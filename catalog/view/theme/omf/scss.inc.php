<?php

class scssc {
	static public $VERSION = "v0.0.3";

	static protected $operatorNames = array(
		'+' => "add",
		'-' => "sub",
		'*' => "mul",
		'/' => "div",
		'%' => "mod",

		'==' => "eq",
		'!=' => "neq",
		'<' => "lt",
		'>' => "gt",

		'<=' => "lte",
		'>=' => "gte",
	);

	static protected $namespaces = array(
		"mixin" => "@",
		"function" => "^",
	);

	static protected $unitTable = array(
		"in" => array(
			"in" => 1,
			"pt" => 72,
			"pc" => 6,
			"cm" => 2.54,
			"mm" => 25.4,
		)
	);

	static public $true = array("keyword", "true");
	static public $false = array("keyword", "false");

	static public $defaultValue = array("keyword", "");
	static public $selfSelector = array("self");

	protected $importPaths = array("");
	protected $importCache = array();

	protected $userFunctions = array();

	protected $formatter = "scss_formatter_nested";

	function compile($code, $name=null) {
		$this->indentLevel = -1;
		$this->commentsSeen = array();
		$this->extends = array();
		$this->extendsMap = array();

		$locale = setlocale(LC_NUMERIC, 0);
		setlocale(LC_NUMERIC, "C");

		$this->parsedFiles = array();
		$this->parser = new scss_parser($name);
		$tree = $this->parser->parse($code);

		$this->formatter = new $this->formatter();

		$this->env = null;
		$this->scope = null;

		$this->compileRoot($tree);
		$this->flattenSelectors($this->scope);

		$out = $this->formatter->block($this->scope);

		setlocale(LC_NUMERIC, $locale);
		return $out;
	}

	protected function pushExtends($target, $origin) {
		$i = count($this->extends);
		$this->extends[] = array($target, $origin);

		foreach ($target as $part) {
			if (isset($this->extendsMap[$part])) {
				$this->extendsMap[$part][] = $i;
			} else {
				$this->extendsMap[$part] = array($i);
			}
		}
	}

	protected function makeOutputBlock($type, $selectors = null) {
		$out = new stdclass;
		$out->type = $type;
		$out->lines = array();
		$out->children = array();
		$out->parent = $this->scope;
		$out->selectors = $selectors;
		$out->depth = $this->env->depth;

		return $out;
	}

	protected function matchExtendsSingle($single, &$out_origin, &$out_rem) {
		$counts = array();
		foreach ($single as $part) {
			if (!is_string($part)) return false; // hmm

			if (isset($this->extendsMap[$part])) {
				foreach ($this->extendsMap[$part] as $idx) {
					$counts[$idx] =
						isset($counts[$idx]) ? $counts[$idx] + 1 : 1;
				}
			}
		}

		foreach ($counts as $idx => $count) {
			list($target, $origin) = $this->extends[$idx];
			// check count
			if ($count != count($target)) continue;
			// check if target is subset of single
			if (array_diff(array_intersect($single, $target), $target)) continue;

			$out_origin = $origin;
			$out_rem = array_diff($single, $target);

			return true;
		}

		return false;
	}

	protected function combineSelectorSingle($base, $other) {
		$tag = null;
		$out = array();

		foreach (array($base, $other) as $single) {
			foreach ($single as $part) {
				if (preg_match('/^[^.#:]/', $part)) {
					$tag = $part;
				} else {
					$out[] = $part;
				}
			}
		}

		if ($tag) {
			array_unshift($out, $tag);
		}

		return $out;
	}

	protected function matchExtends($selector, &$out, $from = 0, $initial=true) {
		foreach ($selector as $i => $part) {
			if ($i < $from) continue;

			if ($this->matchExtendsSingle($part, $origin, $rem)) {
				$before = array_slice($selector, 0, $i);
				$after = array_slice($selector, $i + 1);

				foreach ($origin as $new) {
					$new[count($new) - 1] =
						$this->combineSelectorSingle(end($new), $rem);

					$k = 0;
					// remove shared parts
					if ($initial) {
						foreach ($before as $k => $val) {
							if (!isset($new[$k]) || $val != $new[$k]) {
								break;
							}
						}
					}

					$result = array_merge(
						$before,
						$k > 0 ? array_slice($new, $k) : $new,
						$after);


					if ($result == $selector) continue;
					$out[] = $result;

					// recursively check for more matches
					$this->matchExtends($result, $out, $i, false);

					// selector sequence merging
					if (!empty($before) && count($new) > 1) {
						$result2 = array_merge(
							array_slice($new, 0, -1),
							$k > 0 ? array_slice($before, $k) : $before,
							array_slice($new, -1),
							$after);

						$out[] = $result2;
					}
				}
			}
		}
	}

	protected function flattenSelectors($block) {
		if ($block->selectors) {
			$selectors = array();
			foreach ($block->selectors as $s) {
				$selectors[] = $s;
				if (!is_array($s)) continue;
				// check extends
				if (!empty($this->extendsMap)) {
					$this->matchExtends($s, $selectors);
				}
			}

			$selectors = array_map(array($this, "compileSelector"), $selectors);
			$block->selectors = $selectors;
		}

		foreach ($block->children as $child) {
			$this->flattenSelectors($child);
		}
	}

	protected function compileRoot($rootBlock) {
		$this->pushEnv($rootBlock);
		$this->scope = $this->makeOutputBlock("root");
		$this->compileChildren($rootBlock->children, $this->scope);
		$this->popEnv();
	}

	protected function compileMedia($media) {
		$this->pushEnv($media);
		$parentScope = $this->mediaParent($this->scope);

		$this->scope = $this->makeOutputBlock("media", array(
			$this->compileMediaQuery($this->multiplyMedia($this->env)))
		);

		$parentScope->children[] = $this->scope;

		$this->compileChildren($media->children, $this->scope);

		$this->scope = $this->scope->parent;
		$this->popEnv();
	}

	protected function mediaParent($scope) {
		while (!empty($scope->parent)) {
			if (!empty($scope->type) && $scope->type != "media") {
				break;
			}
			$scope = $scope->parent;
		}

		return $scope;
	}

	// TODO refactor compileNestedBlock and compileMedia into same thing
	protected function compileNestedBlock($block, $selectors) {
		$this->pushEnv($block);

		$this->scope = $this->makeOutputBlock($block->type, $selectors);
		$this->scope->parent->children[] = $this->scope;
		$this->compileChildren($block->children, $this->scope);

		$this->scope = $this->scope->parent;
		$this->popEnv();
	}

	protected function compileBlock($block) {
		$env = $this->pushEnv($block);

		$env->selectors =
			array_map(array($this, "evalSelector"), $block->selectors);

		$out = $this->makeOutputBlock(null, $this->multiplySelectors($env));
		$this->scope->children[] = $out;
		$this->compileChildren($block->children, $out);

		$this->popEnv();
	}

	// joins together .classes and #ids
	protected function flattenSelectorSingle($single) {
		$joined = array();
		foreach ($single as $part) {
			if (empty($joined) ||
				!is_string($part) ||
				preg_match('/[.:#]/', $part))
			{
				$joined[] = $part;
				continue;
			}

			if (is_array(end($joined))) {
				$joined[] = $part;
			} else {
				$joined[count($joined) - 1] .= $part;
			}
		}

		return $joined;
	}

	// replaces all the interpolates
	protected function evalSelector($selector) {
		return array_map(array($this, "evalSelectorPart"), $selector);
	}

	protected function evalSelectorPart($piece) {
		foreach ($piece as &$p) {
			if (!is_array($p)) continue;

			switch ($p[0]) {
			case "interpolate":
				$p = $this->compileValue($p);
				break;
			}
		}

		return $this->flattenSelectorSingle($piece);
	}

	// compiles to string
	// self(&) should have been replaced by now
	protected function compileSelector($selector) {
		if (!is_array($selector)) return $selector; // media and the like

		return $this->formatter->implodeSelectors(array_map(
			array($this, "compileSelectorPart"), $selector));
	}

	protected function compileSelectorPart($piece) {
		foreach ($piece as &$p) {
			if (!is_array($p)) continue;

			switch ($p[0]) {
			case "self":
				$p = "&";
				break;
			default:
				$p = $this->compileValue($p);
				break;
			}
		}

		return implode($piece);
	}

	protected function compileChildren($stms, $out) {
		foreach ($stms as $stm) {
			$ret = $this->compileChild($stm, $out);
			if (!is_null($ret)) return $ret;
		}
	}

	protected function compileMediaQuery($queryList) {
		$out = "@media";
		$first = true;
		foreach ($queryList as $query){
			$parts = array();
			foreach ($query as $q) {
				switch ($q[0]) {
					case "mediaType":
						$parts[] = implode(" ", array_slice($q, 1));
						break;
					case "mediaExp":
						if (isset($q[2])) {
							$parts[] = "($q[1]" . $this->formatter->assignSeparator . $this->compileValue($q[2]) . ")";
						} else {
							$parts[] = "($q[1])";
						}
						break;
				}
			}
			if (!empty($parts)) {
				if ($first) {
					$first = false;
					$out .= " ";
				} else {
					$out .= $this->formatter->tagSeparator;
				}
				$out .= implode(" and ", $parts);
			}
		}
		return $out;
	}

	// returns true if the value was something that could be imported
	protected function compileImport($rawPath, $out) {
		if ($rawPath[0] == "string") {
			$path = $this->compileStringContent($rawPath);
			if ($path = $this->findImport($path)) {
				$this->importFile($path, $out);
				return true;
			}
			return false;
		} if ($rawPath[0] == "list") {
			// handle a list of strings
			if (count($rawPath[2]) == 0) return false;
			foreach ($rawPath[2] as $path) {
				if ($path[0] != "string") return false;
			}

			foreach ($rawPath[2] as $path) {
				$this->compileImport($path, $out);
			}

			return true;
		}

		return false;
	}

	// return a value to halt execution
	protected function compileChild($child, $out) {
		switch ($child[0]) {
		case "import":
			list(,$rawPath) = $child;
			$rawPath = $this->reduce($rawPath);
			if (!$this->compileImport($rawPath, $out)) {
				$out->lines[] = "@import " . $this->compileValue($rawPath) . ";";
			}
			break;
		case "directive":
			list(, $directive) = $child;
			$s = "@" . $directive->name;
			if (!empty($directive->value)) {
				$s .= " " . $this->compileValue($directive->value);
			}
			$this->compileNestedBlock($directive, array($s));
			break;
		case "media":
			$this->compileMedia($child[1]);
			break;
		case "block":
			$this->compileBlock($child[1]);
			break;
		case "charset":
			$out->lines[] = "@charset ".$this->compileValue($child[1]).";";
			break;
		case "assign":
			list(,$name, $value) = $child;
			if ($name[0] == "var") {
				$isDefault = !empty($child[3]);
				if (!$isDefault || $this->get($name[1], true) === true) {
					$this->set($name[1], $this->reduce($value));
				}
				break;
			}

			$out->lines[] = $this->formatter->property(
				$this->compileValue($child[1]),
				$this->compileValue($child[2]));
			break;
		case "comment":
			if(!$this->formatter->stripComments){
				$out->lines[] = $child[1];
			}
			break;
		case "mixin":
		case "function":
			list(,$block) = $child;
			$this->set(self::$namespaces[$block->type] . $block->name, $block);
			break;
		case "extend":
			list(, $selectors) = $child;
			foreach ($selectors as $sel) {
				// only use the first one
				$sel = current($this->evalSelector($sel));
				$this->pushExtends($sel, $out->selectors);
			}
			break;
		case "if":
			list(, $if) = $child;
			if ($this->reduce($if->cond, true) != self::$false) {
				return $this->compileChildren($if->children, $out);
			} else {
				foreach ($if->cases as $case) {
					if ($case->type == "else" ||
						$case->type == "elseif" && ($this->reduce($case->cond) != self::$false))
					{
						return $this->compileChildren($case->children, $out);
					}
				}
			}
			break;
		case "return":
			return $this->reduce($child[1], true);
		case "each":
			list(,$each) = $child;
			$list = $this->reduce($this->coerceList($each->list));
			foreach ($list[2] as $item) {
				$this->pushEnv();
				$this->set($each->var, $item);
				// TODO: allow return from here
				$this->compileChildren($each->children, $out);
				$this->popEnv();
			}
			break;
		case "while":
			list(,$while) = $child;
			while ($this->reduce($while->cond, true) != self::$false) {
				$ret = $this->compileChildren($while->children, $out);
				if ($ret) return $ret;
			}
			break;
		case "for":
			list(,$for) = $child;
			$start = $this->reduce($for->start, true);
			$start = $start[1];
			$end = $this->reduce($for->end, true);
			$end = $end[1];
			$d = $start < $end ? 1 : -1;

			while (true) {
				if ((!$for->until && $start - $d == $end) ||
					($for->until && $start == $end))
				{
					break;
				}

				$this->set($for->var, array("number", $start, ""));
				$start += $d;

				$ret = $this->compileChildren($for->children, $out);
				if ($ret) return $ret;
			}

			break;
		case "nestedprop":
			list(,$prop) = $child;
			$prefixed = array();
			$prefix = $this->compileValue($prop->prefix) . "-";
			foreach ($prop->children as $child) {
				if ($child[0] == "assign") {
					array_unshift($child[1][2], $prefix);
				}
				if ($child[0] == "nestedprop") {
					array_unshift($child[1]->prefix[2], $prefix);
				}
				$prefixed[] = $child;
			}
			$this->compileChildren($prefixed, $out);
			break;
		case "include": // including a mixin
			list(,$name, $argValues) = $child;
			$mixin = $this->get(self::$namespaces["mixin"] . $name, false);
			if (!$mixin) break; // throw error?

			// push scope, apply args
			$this->pushEnv();
			if (!is_null($mixin->args)) {
				$this->applyArguments($mixin->args, $argValues);
			}

			foreach ($mixin->children as $child) {
				$this->compileChild($child, $out);
			}

			$this->popEnv();

			break;
		case "debug":
			list(,$value, $pos) = $child;
			$line = $this->parser->getLineNo($pos);
			$value = $this->compileValue($this->reduce($value, true));
			fwrite(STDERR, "Line $line DEBUG: $value\n");
			break;
		default:
			throw new exception("unknown child type: $child[0]");
		}
	}

	protected function expToString($exp) {
		list(, $op, $left, $right, $inParens, $whiteLeft, $whiteRight) = $exp;
		$content = array($left);
		if ($whiteLeft) $content[] = " ";
		$content[] = $op;
		if ($whiteRight) $content[] = " ";
		$content[] = $right;
		return array("string", "", $content);
	}

	// should $value cause its operand to eval
	protected function shouldEval($value) {
		switch ($value[0]) {
		case "exp":
			if ($value[1] == "/") {
				return $this->shouldEval($value[2], $value[3]);
			}
		case "var":
		case "fncall":
			return true;
		}
		return false;
	}

	protected function reduce($value, $inExp = false) {
		list($type) = $value;
		switch ($type) {
			case "exp":
				list(, $op, $left, $right, $inParens) = $value;
				$opName = isset(self::$operatorNames[$op]) ? self::$operatorNames[$op] : $op;

				$inExp = $inExp || $this->shouldEval($left) || $this->shouldEval($right);

				$left = $this->reduce($left, true);
				$right = $this->reduce($right, true);

				// only do division in special cases
				if ($opName == "div" && !$inParens && !$inExp) {
					if ($left[0] != "color" && $right[0] != "color") {
						return $this->expToString($value);
					}
				}

				$left = $this->coerceForExpression($left);
				$right = $this->coerceForExpression($right);

				$ltype = $left[0];
				$rtype = $right[0];

				// this tries:
				// 1. op_[op name]_[left type]_[right type]
				// 2. op_[left type]_[right type] (passing the op as first arg
				// 3. op_[op name]
				$fn = "op_${opName}_${ltype}_${rtype}";
				if (is_callable(array($this, $fn)) ||
					(($fn = "op_${ltype}_${rtype}") &&
						is_callable(array($this, $fn)) &&
						$passOp = true) ||
					(($fn = "op_${opName}") &&
						is_callable(array($this, $fn)) &&
						$genOp = true))
				{
					$unitChange = false;
					if (!isset($genOp) &&
						$left[0] == "number" && $right[0] == "number")
					{
						$unitChange = true;
						if ($opName == "div" && $left[2] == $right[2]) {
							$targetUnit = "";
						} else {
							$targetUnit = $left[2];
							$left = $this->normalizeNumber($left);
							$right = $this->normalizeNumber($right);
						}
					}

					$shouldEval = $inParens || $inExp;
					if (isset($passOp)) {
						$out = $this->$fn($op, $left, $right, $shouldEval);
					} else {
						$out = $this->$fn($left, $right, $shouldEval);
					}

					if (!is_null($out)) {
						if ($unitChange && $out[0] == "number") {
							$out = $this->coerceUnit($out, $targetUnit);
						}
						return $out;
					}
				}

				return $this->expToString($value);
			case "unary":
				list(, $op, $exp, $inParens) = $value;
				$inExp = $inExp || $this->shouldEval($exp);

				$exp = $this->reduce($exp);
				if ($exp[0] == "number") {
					switch ($op) {
					case "+":
						return $exp;
					case "-":
						$exp[1] *= -1;
						return $exp;
					}
				}

				if ($op == "not") {
					if ($inExp || $inParens) {
						if ($exp == self::$false) {
							return self::$true;
						} else {
							return self::$false;
						}
					} else {
						$op = $op . " ";
					}
				}

				return array("string", "", array($op, $exp));
			case "var":
				list(, $name) = $value;
				return $this->reduce($this->get($name));
			case "list":
				foreach ($value[2] as &$item) {
					$item = $this->reduce($item);
				}
				return $value;
			case "string":
				foreach ($value[2] as &$item) {
					if (is_array($item)) {
						$item = $this->reduce($item);
					}
				}
				return $value;
			case "interpolate":
				$value[1] = $this->reduce($value[1]);
				return $value;
			case "fncall":
				list(,$name, $argValues) = $value;

				// user defined function?
				$func = $this->get(self::$namespaces["function"] . $name, false);
				if ($func) {
					$this->pushEnv();

					// set the args
					if (isset($func->args)) {
						$this->applyArguments($func->args, $argValues);
					}

					// throw away lines and children
					$tmp = (object)array(
						"lines" => array(),
						"children" => array()
					);
					$ret = $this->compileChildren($func->children, $tmp);
					$this->popEnv();

					return is_null($ret) ? self::$defaultValue : $ret;
				}

				// built in function
				if ($this->callBuiltin($name, $argValues, $returnValue)) {
					return $returnValue;
				}

				// need to flatten the arguments into a list
				$listArgs = array();
				foreach ((array)$argValues as $arg) {
					if (empty($arg[0])) {
						$listArgs[] = $this->reduce($arg[1]);
					}
				}
				return array("function", $name, array("list", ",", $listArgs));
			default:
				return $value;
		}
	}

	// just does physical lengths for now
	protected function normalizeNumber($number) {
		list(, $value, $unit) = $number;
		if (isset(self::$unitTable["in"][$unit])) {
			$conv = self::$unitTable["in"][$unit];
			return array("number", $value / $conv, "in");
		}
		return $number;
	}

	// $number should be normalized
	protected function coerceUnit($number, $unit) {
		list(, $value, $baseUnit) = $number;
		if (isset(self::$unitTable[$baseUnit][$unit])) {
			$value = $value * self::$unitTable[$baseUnit][$unit];
		}

		return array("number", $value, $unit);
	}

	protected function op_add_number_number($left, $right) {
		return array("number", $left[1] + $right[1], $left[2]);
	}

	protected function op_mul_number_number($left, $right) {
		return array("number", $left[1] * $right[1], $left[2]);
	}

	protected function op_sub_number_number($left, $right) {
		return array("number", $left[1] - $right[1], $left[2]);
	}

	protected function op_div_number_number($left, $right) {
		return array("number", $left[1] / $right[1], $left[2]);
	}

	protected function op_mod_number_number($left, $right) {
		return array("number", $left[1] % $right[1], $left[2]);
	}

	// adding strings
	protected function op_add($left, $right) {
		if ($strLeft = $this->coerceString($left)) {
			if ($right[0] == "string") {
				$right[1] = "";
			}
			$strLeft[2][] = $right;
			return $strLeft;
		}

		if ($strRight = $this->coerceString($right)) {
			if ($left[0] == "string") {
				$left[1] = "";
			}
			array_unshift($strRight[2], $left);
			return $strRight;
		}
	}

	protected function op_and($left, $right, $shouldEval) {
		if (!$shouldEval) return;
		if ($left != self::$false) return $right;
		return $left;
	}

	protected function op_or($left, $right, $shouldEval) {
		if (!$shouldEval) return;
		if ($left != self::$false) return $left;
		return $right;
	}

	protected function op_color_color($op, $left, $right) {
		$out = array('color');
		foreach (range(1, 3) as $i) {
			$lval = isset($left[$i]) ? $left[$i] : 0;
			$rval = isset($right[$i]) ? $right[$i] : 0;
			switch ($op) {
			case '+':
				$out[] = $lval + $rval;
				break;
			case '-':
				$out[] = $lval - $rval;
				break;
			case '*':
				$out[] = $lval * $rval;
				break;
			case '%':
				$out[] = $lval % $rval;
				break;
			case '/':
				if ($rval == 0) {
					throw new exception("color: Can't divide by zero");
				}
				$out[] = $lval / $rval;
				break;
			default:
				throw new exception("color: unknow op $op");
			}
		}

		if (isset($left[4])) $out[4] = $left[4];
		elseif (isset($right[4])) $out[4] = $right[4];

		return $this->fixColor($out);
	}

	protected function op_color_number($op, $left, $right) {
		$value = $right[1];
		return $this->op_color_color($op, $left,
			array("color", $value, $value, $value));
	}

	protected function op_number_color($op, $left, $right) {
		$value = $left[1];
		return $this->op_color_color($op,
			array("color", $value, $value, $value), $right);
	}

	protected function op_eq($left, $right) {
		if (($lStr = $this->coerceString($left)) && ($rStr = $this->coerceString($right))) {
			$lStr[1] = "";
			$rStr[1] = "";
			return $this->toBool($this->compileValue($lStr) == $this->compileValue($rStr));
		}

		return $this->toBool($left == $right);
	}

	protected function op_neq($left, $right) {
		return $this->toBool($left != $right);
	}

	protected function op_gte_number_number($left, $right) {
		return $this->toBool($left[1] >= $right[1]);
	}

	protected function op_gt_number_number($left, $right) {
		return $this->toBool($left[1] > $right[1]);
	}

	protected function op_lte_number_number($left, $right) {
		return $this->toBool($left[1] <= $right[1]);
	}

	protected function op_lt_number_number($left, $right) {
		return $this->toBool($left[1] < $right[1]);
	}

	protected function toBool($thing) {
		return $thing ? self::$true : self::$false;
	}

	protected function compileValue($value) {
		$value = $this->reduce($value);

		list($type) = $value;
		switch ($type) {
		case "keyword":
			return $value[1];
		case "color":
			// [1] - red component (either number for a %)
			// [2] - green component
			// [3] - blue component
			// [4] - optional alpha component
			list(, $r, $g, $b) = $value;

			$r = round($r);
			$g = round($g);
			$b = round($b);
			$a = (count($value) == 5) ? max(0,min($value[4],1)) : 1;

			return $this->formatter->color($r, $g, $b, $a);
		case "number":
			return $this->formatter->number($value[1],$value[2]);
		case "string":
			return $value[1] . $this->compileStringContent($value) . $value[1];
		case "function":
			$args = !empty($value[2]) ? $this->compileValue($value[2]) : "";
			return "$value[1]($args)";
		case "list":
			$value = $this->extractInterpolation($value);
			if ($value[0] != "list") return $this->compileValue($value);

			list(, $delim, $items) = $value;
			foreach ($items as &$item) {
				$item = $this->compileValue($item);
			}
			return $this->formatter->implodeList($delim, $items);
		case "interpolated": # node created by extractInterpolation
			list(, $interpolate, $left, $right) = $value;
			list(,, $whiteLeft, $whiteRight) = $interpolate;

			$left = count($left[2]) > 0 ?
				$this->compileValue($left).$whiteLeft : "";

			$right = count($right[2]) > 0 ?
				$whiteRight.$this->compileValue($right) : "";

			return $left.$this->compileValue($interpolate).$right;

		case "interpolate": # raw parse node
			list(, $exp) = $value;

			// strip quotes if it's a string
			$reduced = $this->reduce($exp);
			if ($reduced[0] == "string") {
				$reduced = array("keyword",
					$this->compileStringContent($reduced));
			}

			return $this->compileValue($reduced);
		default:
			throw new exception("unknown value type: $type");
		}
	}

	protected function compileStringContent($string) {
		$parts = array();
		foreach ($string[2] as $part) {
			if (is_array($part)) {
				$parts[] = $this->compileValue($part);
			} else {
				$parts[] = $part;
			}
		}

		return implode($parts);
	}

	// doesn't need to be recursive, compileValue will handle that
	protected function extractInterpolation($list) {
		$items = $list[2];
		foreach ($items as $i => $item) {
			if ($item[0] == "interpolate") {
				$before = array("list", $list[1], array_slice($items, 0, $i));
				$after = array("list", $list[1], array_slice($items, $i + 1));
				return array("interpolated", $item, $before, $after);
			}
		}
		return $list;
	}

	// find the final set of selectors
	protected function multiplySelectors($env, $childSelectors = null) {
		if (is_null($env)) {
			return $childSelectors;
		}

		// skip env, has no selectors
		if (empty($env->selectors)) {
			return $this->multiplySelectors($env->parent, $childSelectors);
		}

		if (is_null($childSelectors)) {
			$selectors = $env->selectors;
		} else {
			$selectors = array();
			foreach ($env->selectors as $parent) {
				foreach ($childSelectors as $child) {
					$selectors[] = $this->joinSelectors($parent, $child);
				}
			}
		}

		return $this->multiplySelectors($env->parent, $selectors);
	}

	// looks for & to replace, or append parent before child
	protected function joinSelectors($parent, $child) {
		$setSelf = false;
		$out = array();
		foreach ($child as $part) {
			$newPart = array();
			foreach ($part as $p) {
				if ($p == self::$selfSelector) {
					$setSelf = true;
					foreach ($parent as $i => $parentPart) {
						if ($i > 0) {
							$out[] = $newPart;
							$newPart = array();
						}

						foreach ($parentPart as $pp) {
							$newPart[] = $pp;
						}
					}
				} else {
					$newPart[] = $p;
				}
			}

			$out[] = $newPart;
		}

		return $setSelf ? $out : array_merge($parent, $child);
	}

	protected function multiplyMedia($env, $childQueries = null) {
		if (is_null($env) ||
			!empty($env->block->type) && $env->block->type != "media")
		{
			return $childQueries;
		}

		// plain old block, skip
		if (empty($env->block->type)) {
			return $this->multiplyMedia($env->parent, $childQueries);
		}

		$parentQueries = $env->block->queryList;
		if ($childQueries == null) {
			$childQueries = $parentQueries;
		} else {
			$originalQueries = $childQueries;
			$childQueries = array();
				
			foreach ($parentQueries as $parentQuery){
				foreach ($originalQueries as $childQuery) {
					$childQueries []= array_merge($parentQuery, $childQuery);
				}
			}
		}

		return $this->multiplyMedia($env->parent, $childQueries);
	}

	// convert something to list
	protected function coerceList($item, $delim = ",") {
		if (!is_null($item) && $item[0] == "list") {
			return $item;
		}

		return array("list", $delim, is_null($item) ? array(): array($item));
	}

	protected function applyArguments($argDef, $argValues) {
		$argValues = (array)$argValues;

		$keywordArgs = array();
		$remaining = array();

		// assign the keyword args
		foreach ($argValues as $arg) {
			if (!empty($arg[0])) {
				$keywordArgs[$arg[0][1]] = $arg[1];
			} else {
				$remaining[] = $arg[1];
			}
		}

		foreach ($argDef as $i => $arg) {
			list($name, $default) = $arg;

			if (isset($remaining[$i])) {
				$val = $remaining[$i];
			} elseif (isset($keywordArgs[$name])) {
				$val = $keywordArgs[$name];
			} elseif (!empty($default)) {
				$val = $default;
			} else {
				$val = self::$defaultValue;
			}

			$this->set($name, $this->reduce($val, true));
		}
	}

	protected function pushEnv($block=null) {
		$env = new stdclass;
		$env->parent = $this->env;
		$env->store = array();
		$env->block = $block;
		$env->depth = isset($this->env->depth) ? $this->env->depth + 1 : 0;

		$this->env = $env;
		return $env;
	}

	protected function normalizeName($name) {
		return str_replace("-", "_", $name);
	}

	protected function set($name, $value) {
		$name = $this->normalizeName($name);
		$this->setExisting($name, $value);
	}

	protected function setExisting($name, $value, $env = null) {
		if (is_null($env)) $env = $this->env;
		if (isset($env->store[$name])) {
			$env->store[$name] = $value;
		} elseif (!is_null($env->parent)) {
			$this->setExisting($name, $value, $env->parent);
		} else {
			$this->env->store[$name] = $value;
		}
	}

	protected function get($name, $defaultValue = null, $env = null) {
		$name = $this->normalizeName($name);

		if (is_null($env)) $env = $this->env;
		if (is_null($defaultValue)) $defaultValue = self::$defaultValue;

		if (isset($env->store[$name])) {
			return $env->store[$name];
		} elseif (!is_null($env->parent)) {
			return $this->get($name, $defaultValue, $env->parent);
		}

		return $defaultValue; // found nothing
	}

	protected function popEnv() {
		$env = $this->env;
		$this->env = $this->env->parent;
		return $env;
	}

	public function getParsedFiles() {
		return $this->parsedFiles;
	}

	public function addImportPath($path) {
		$this->importPaths[] = $path;
	}

	public function setImportPaths($path) {
		$this->importPaths = (array)$path;
	}

	public function setFormatter($formatterName) {
		$this->formatter = $formatterName;
	}

	public function registerFunction($name, $func) {
		$this->userFunctions[$this->normalizeName($name)] = $func;
	}

	public function unregisterFunction($name) {
		unset($this->userFunctions[$this->normalizeName($name)]);
	}

	protected function importFile($path, $out) {
		// see if tree is cached
		$realPath = realpath($path);
		if (isset($this->importCache[$realPath])) {
			$tree = $this->importCache[$realPath];
		} else {
			$code = file_get_contents($path);
			$parser = new scss_parser($path);
			$tree = $parser->parse($code);
			$this->parsedFiles[] = $path;

			$this->importCache[$realPath] = $tree;
		}

		$pi = pathinfo($path);
		array_unshift($this->importPaths, $pi['dirname']);
		$this->compileChildren($tree->children, $out);
		array_shift($this->importPaths);
	}

	// results the file path for an import url if it exists
	protected function findImport($url) {
		$urls = array();
		
		// for "normal" scss imports (ignore vanilla css and external requests)
		if (!preg_match('/\.css|^http:\/\/$/', $url)) {
			// try both normal and the _partial filename
			$urls = array($url, preg_replace('/[^\/]+$/', '_\0', $url));
		}

		foreach ($this->importPaths as $dir) {
			if (is_string($dir)) {
				// check urls for normal import paths
				foreach ($urls as $full) {
					$full = $dir .
						(!empty($dir) && substr($dir, -1) != '/' ? '/' : '') .
						$full;
	
					if ($this->fileExists($file = $full.'.scss') ||
						$this->fileExists($file = $full))
					{
						return $file;
					}
				}
			} else {
				// check custom callback for import path
				$file = call_user_func($dir,$url,$this);
				if ($file !== null) {
					return $file;
				}
			}
		}

		return null;
	}

	protected function fileExists($name) {
		return is_file($name);
	}

	protected function callBuiltin($name, $args, &$returnValue) {
		// try a lib function
		$name = $this->normalizeName($name);
		$libName = "lib_".$name;
		$f = array($this, $libName);
		$prototype = isset(self::$$libName) ? self::$$libName : null;

		if (is_callable($f)) {
			$sorted = $this->sortArgs($prototype, $args);
			foreach ($sorted as &$val) {
				$val = $this->reduce($val, true);
			}
			$returnValue = call_user_func($f, $sorted, $this);
		} else if (isset($this->userFunctions[$name])) {
			// see if we can find a user function
			$fn = $this->userFunctions[$name];

			foreach ($args as &$val) {
				$val = $this->reduce($val[1], true);
			}

			$returnValue = call_user_func($fn, $args, $this);
		}

		if (isset($returnValue)) {
			// coerce a php value into a scss one
			if (is_numeric($returnValue)) {
				$returnValue = array('number', $returnValue, "");
			} elseif (is_bool($returnValue)) {
				$returnValue = $returnValue ? self::$true : self::$false;
			} elseif (!is_array($returnValue)) {
				$returnValue = array('keyword', $returnValue);
			}

			return true;
		}

		return false;
	}

	// sorts any keyword arguments
	// TODO: merge with apply arguments
	protected function sortArgs($prototype, $args) {
		$keyArgs = array();
		$posArgs = array();

		foreach ($args as $arg) {
			list($key, $value) = $arg;
			$key = $key[1];
			if (empty($key)) {
				$posArgs[] = $value;
			} else {
				$keyArgs[$key] = $value;
			}
		}

		if (is_null($prototype)) return $posArgs;

		$finalArgs = array();
		foreach ($prototype as $i => $names) {
			if (isset($posArgs[$i])) {
				$finalArgs[] = $posArgs[$i];
				continue;
			}

			$set = false;
			foreach ((array)$names as $name) {
				if (isset($keyArgs[$name])) {
					$finalArgs[] = $keyArgs[$name];
					$set = true;
					break;
				}
			}

			if (!$set) {
				$finalArgs[] = null;
			}
		}

		return $finalArgs;
	}

	protected function coerceForExpression($value) {
		if ($color = $this->coerceColor($value)) {
			return $color;
		}

		return $value;
	}

	protected function coerceColor($value) {
		switch ($value[0]) {
		case "color": return $value;
		case "keyword":
			$name = strtolower($value[1]);
			if (isset(self::$cssColors[$name])) {
				$color = explode(',', self::$cssColors[$name]);
				// array('color', $r, $g, $b);
				array_unshift($color, 'color');
				return $color;
			}
			return null;
		}

		return null;
	}

	protected function coerceString($value) {
		switch ($value[0]) {
		case "string":
			return $value;
		case "keyword":
			return array("string", "", array($value[1]));
		}
		return null;
	}

	protected function assertColor($value) {
		if ($color = $this->coerceColor($value)) return $color;
		throw new exception("expecting color");
	}

	protected function assertNumber($value) {
		if ($value[0] != "number")
			throw new exception("expecting number");
		return $value[1];
	}

	protected function coercePercent($value) {
		if ($value[0] == "number") {
			if ($value[2] == "%") {
				return $value[1] / 100;
			}
			return $value[1];
		}
		return 0;
	}

	// make sure a color's components don't go out of bounds
	protected function fixColor($c) {
		foreach (range(1, 3) as $i) {
			if ($c[$i] < 0) $c[$i] = 0;
			if ($c[$i] > 255) $c[$i] = 255;
		}

		return $c;
	}

	function toHSL($r, $g, $b) {
		$r = $r / 255;
		$g = $g / 255;
		$b = $b / 255;

		$min = min($r, $g, $b);
		$max = max($r, $g, $b);

		$L = ($min + $max) / 2;
		if ($min == $max) {
			$S = $H = 0;
		} else {
			if ($L < 0.5)
				$S = ($max - $min)/($max + $min);
			else
				$S = ($max - $min)/(2.0 - $max - $min);

			if ($r == $max) $H = ($g - $b)/($max - $min);
			elseif ($g == $max) $H = 2.0 + ($b - $r)/($max - $min);
			elseif ($b == $max) $H = 4.0 + ($r - $g)/($max - $min);

		}

		return array('hsl',
			($H < 0 ? $H + 6 : $H)*60,
			$S*100,
			$L*100,
		);
	}

	function toRGB_helper($comp, $temp1, $temp2) {
		if ($comp < 0) $comp += 1.0;
		elseif ($comp > 1) $comp -= 1.0;

		if (6 * $comp < 1) return $temp1 + ($temp2 - $temp1) * 6 * $comp;
		if (2 * $comp < 1) return $temp2;
		if (3 * $comp < 2) return $temp1 + ($temp2 - $temp1)*((2/3) - $comp) * 6;

		return $temp1;
	}

	// H from 0 to 360, S and L from 0 to 100
	function toRGB($H, $S, $L) {
		$H = $H % 360;
		if ($H < 0) $H += 360;

		$S = min(100, max(0, $S));
		$L = min(100, max(0, $L));

		$H = $H / 360;
		$S = $S / 100;
		$L = $L / 100;

		if ($S == 0) {
			$r = $g = $b = $L;
		} else {
			$temp2 = $L < 0.5 ?
				$L*(1.0 + $S) :
				$L + $S - $L * $S;

			$temp1 = 2.0 * $L - $temp2;

			$r = $this->toRGB_helper($H + 1/3, $temp1, $temp2);
			$g = $this->toRGB_helper($H, $temp1, $temp2);
			$b = $this->toRGB_helper($H - 1/3, $temp1, $temp2);
		}

		$out = array('color', $r*255, $g*255, $b*255);
		return $out;
	}

	// Built in functions

	protected static $lib_if = array("condition", "if-true", "if-false");
	protected function lib_if($args) {
		list($cond,$t, $f) = $args;
		if ($cond == self::$false) return $f;
		return $t;
	}

	protected static $lib_rgb = array("red", "green", "blue");
	protected function lib_rgb($args) {
		list($r,$g,$b) = $args;
		return array("color", $r[1], $g[1], $b[1]);
	}

	protected static $lib_rgba = array(
		array("red", "color"),
		"green", "blue", "alpha");
	protected function lib_rgba($args) {
		if ($color = $this->coerceColor($args[0])) {
			$num = is_null($args[1]) ? $args[3] : $args[1];
			$alpha = $this->assertNumber($num);
			$color[4] = $alpha;
			return $color;
		}

		list($r,$g,$b, $a) = $args;
		return array("color", $r[1], $g[1], $b[1], $a[1]);
	}

	// helper function for adjust_color, change_color, and scale_color
	protected function alter_color($args, $fn) {
		$color = $this->assertColor($args[0]);

		foreach (array(1,2,3,7) as $i) {
			if (!is_null($args[$i])) {
				$val = $this->assertNumber($args[$i]);
				$ii = $i == 7 ? 4 : $i; // alpha
				$color[$ii] =
					$this->$fn(isset($color[$ii]) ? $color[$ii] : 0, $val, $i);
			}
		}

		if (!is_null($args[4]) || !is_null($args[5]) || !is_null($args[6])) {
			$hsl = $this->toHSL($color[1], $color[2], $color[3]);
			foreach (array(4,5,6) as $i) {
				if (!is_null($args[$i])) {
					$val = $this->assertNumber($args[$i]);
					$hsl[$i - 3] = $this->$fn($hsl[$i - 3], $val, $i);
				}
			}

			$rgb = $this->toRGB($hsl[1], $hsl[2], $hsl[3]);
			if (isset($color[4])) $rgb[4] = $color[4];
			$color = $rgb;
		}

		return $color;
	}

	protected static $lib_adjust_color = array(
		"color", "red", "green", "blue",
		"hue", "saturation", "lightness", "alpha"
	);
	protected function adjust_color_helper($base, $alter, $i) {
		return $base += $alter;
	}
	protected function lib_adjust_color($args) {
		return $this->alter_color($args, "adjust_color_helper");
	}

	protected static $lib_change_color = array(
		"color", "red", "green", "blue",
		"hue", "saturation", "lightness", "alpha"
	);
	protected function change_color_helper($base, $alter, $i) {
		return $alter;
	}
	protected function lib_change_color($args) {
		return $this->alter_color($args, "change_color_helper");
	}

	protected static $lib_scale_color = array(
		"color", "red", "green", "blue",
		"hue", "saturation", "lightness", "alpha"
	);
	protected function scale_color_helper($base, $scale, $i) {
		// 1,2,3 - rgb
		// 4, 5, 6 - hsl
		// 7 - a
		switch ($i) {
		case 1:
		case 2:
		case 3:
			$max = 255; break;
		case 4:
			$max = 360; break;
		case 7:
			$max = 1; break;
		default:
			$max = 100;
		}

		$scale = $scale / 100;
		if ($scale < 0) {
			return $base * $scale + $base;
		} else {
			return ($max - $base) * $scale + $base;
		}
	}
	protected function lib_scale_color($args) {
		return $this->alter_color($args, "scale_color_helper");
	}

	protected static $lib_red = array("color");
	protected function lib_red($args) {
		list($color) = $args;
		return $color[1];
	}

	protected static $lib_green = array("color");
	protected function lib_green($args) {
		list($color) = $args;
		return $color[2];
	}

	protected static $lib_blue = array("color");
	protected function lib_blue($args) {
		list($color) = $args;
		return $color[3];
	}

	protected static $lib_alpha = array("color");
	protected function lib_alpha($args) {
		if ($color = $this->coerceColor($args[0])) {
			return isset($color[4]) ? $color[4] : 1;
		}

		// this might be the IE function, so return value unchanged
		return array("function", "alpha", array("list", ",", $args));
	}

	protected static $lib_opacity = array("color");
	protected function lib_opacity($args) {
		return $this->lib_alpha($args);
	}

	// mix two colors
	protected static $lib_mix = array("color-1", "color-2", "weight");
	protected function lib_mix($args) {
		list($first, $second, $weight) = $args;
		$first = $this->assertColor($first);
		$second = $this->assertColor($second);

		if (is_null($weight)) {
			$weight = 0.5;
		} else {
			$weight = $this->coercePercent($weight);
		}

		$first_a = isset($first[4]) ? $first[4] : 1;
		$second_a = isset($second[4]) ? $second[4] : 1;

		$w = $weight * 2 - 1;
		$a = $first_a - $second_a;

		$w1 = (($w * $a == -1 ? $w : ($w + $a)/(1 + $w * $a)) + 1) / 2.0;
		$w2 = 1.0 - $w1;

		$new = array('color',
			$w1 * $first[1] + $w2 * $second[1],
			$w1 * $first[2] + $w2 * $second[2],
			$w1 * $first[3] + $w2 * $second[3],
		);

		if ($first_a != 1.0 || $second_a != 1.0) {
			$new[] = $first_a * $weight + $second_a * ($weight - 1);
		}

		return $this->fixColor($new);
	}

	protected static $lib_hsl = array("hue", "saturation", "lightness");
	protected function lib_hsl($args) {
		list($h, $s, $l) = $args;
		return $this->toRGB($h[1], $s[1], $l[1]);
	}

	protected static $lib_hsla = array("hue", "saturation",
		"lightness", "alpha");
	protected function lib_hsla($args) {
		list($h, $s, $l, $a) = $args;
		$color = $this->toRGB($h[1], $s[1], $l[1]);
		$color[4] = $a[1];
		return $color;
	}

	protected static $lib_hue = array("color");
	protected function lib_hue($args) {
		$color = $this->assertColor($args[0]);
		$hsl = $this->toHSL($color[1], $color[2], $color[3]);
		return array("number", $hsl[1], "deg");
	}

	protected static $lib_saturation = array("color");
	protected function lib_saturation($args) {
		$color = $this->assertColor($args[0]);
		$hsl = $this->toHSL($color[1], $color[2], $color[3]);
		return array("number", $hsl[2], "%");
	}

	protected static $lib_lightness = array("color");
	protected function lib_lightness($args) {
		$color = $this->assertColor($args[0]);
		$hsl = $this->toHSL($color[1], $color[2], $color[3]);
		return array("number", $hsl[3], "%");
	}


	protected function adjustHsl($color, $idx, $amount) {
		$hsl = $this->toHSL($color[1], $color[2], $color[3]);
		$hsl[$idx] += $amount;
		$out = $this->toRGB($hsl[1], $hsl[2], $hsl[3]);
		if (isset($color[4])) $out[4] = $color[4];
		return $out;
	}

	protected static $lib_adjust_hue = array("color", "degrees");
	protected function lib_adjust_hue($args) {
		$color = $this->assertColor($args[0]);
		$degrees = $this->assertNumber($args[1]);
		return $this->adjustHsl($color, 1, $degrees);
	}

	protected static $lib_lighten = array("color", "amount");
	protected function lib_lighten($args) {
		$color = $this->assertColor($args[0]);
		$amount = 100*$this->coercePercent($args[1]);
		return $this->adjustHsl($color, 3, $amount);
	}

	protected static $lib_darken = array("color", "amount");
	protected function lib_darken($args) {
		$color = $this->assertColor($args[0]);
		$amount = 100*$this->coercePercent($args[1]);
		return $this->adjustHsl($color, 3, -$amount);
	}

	protected static $lib_saturate = array("color", "amount");
	protected function lib_saturate($args) {
		$color = $this->assertColor($args[0]);
		$amount = 100*$this->coercePercent($args[1]);
		return $this->adjustHsl($color, 2, $amount);
	}

	protected static $lib_desaturate = array("color", "amount");
	protected function lib_desaturate($args) {
		$color = $this->assertColor($args[0]);
		$amount = 100*$this->coercePercent($args[1]);
		return $this->adjustHsl($color, 2, -$amount);
	}

	protected static $lib_grayscale = array("color");
	protected function lib_grayscale($args) {
		return $this->adjustHsl($this->assertColor($args[0]), 2, -100);
	}

	protected static $lib_complement = array("color");
	protected function lib_complement($args) {
		return $this->adjustHsl($this->assertColor($args[0]), 1, 180);
	}

	protected static $lib_invert = array("color");
	protected function lib_invert($args) {
		$color = $this->assertColor($args[0]);
		$color[1] = 255 - $color[1];
		$color[2] = 255 - $color[2];
		$color[3] = 255 - $color[3];
		return $color;
	}


	// increases opacity by amount
	protected static $lib_opacify = array("color", "amount");
	protected function lib_opacify($args) {
		$color = $this->assertColor($args[0]);
		$amount = $this->coercePercent($args[1]);

		$color[4] = (isset($color[4]) ? $color[4] : 1) + $amount;
		$color[4] = min(1, max(0, $color[4]));
		return $color;
	}

	protected static $lib_fade_in = array("color", "amount");
	protected function lib_fade_in($args) {
		return $this->lib_opacify($args);
	}

	// decreases opacity by amount
	protected static $lib_transparentize = array("color", "amount");
	protected function lib_transparentize($args) {
		$color = $this->assertColor($args[0]);
		$amount = $this->coercePercent($args[1]);

		$color[4] = (isset($color[4]) ? $color[4] : 1) - $amount;
		$color[4] = min(1, max(0, $color[4]));
		return $color;
	}

	protected static $lib_fade_out = array("color", "amount");
	protected function lib_fade_out($args) {
		return $this->lib_transparentize($args);
	}

	protected static $lib_unquote = array("string");
	protected function lib_unquote($args) {
		$str = $args[0];
		if ($str[0] == "string") $str[1] = "";
		return $str;
	}

	protected static $lib_quote = array("string");
	protected function lib_quote($args) {
		$value = $args[0];
		if ($value[0] == "string" && !empty($value[1]))
			return $value;
		return array("string", '"', array($value));
	}

	protected static $lib_percentage = array("value");
	protected function lib_percentage($args) {
		return array("number",
			$this->coercePercent($args[0]) * 100,
			"%");
	}

	protected static $lib_round = array("value");
	protected function lib_round($args) {
		$num = $args[0];
		$num[1] = round($num[1]);
		return $num;
	}

	protected static $lib_floor = array("value");
	protected function lib_floor($args) {
		$num = $args[0];
		$num[1] = floor($num[1]);
		return $num;
	}

	protected static $lib_ceil = array("value");
	protected function lib_ceil($args) {
		$num = $args[0];
		$num[1] = ceil($num[1]);
		return $num;
	}

	protected static $lib_length = array("list");
	protected function lib_length($args) {
		$list = $this->coerceList($args[0]);
		return count($list[2]);
	}

	protected static $lib_nth = array("list", "n");
	protected function lib_nth($args) {
		$list = $this->coerceList($args[0]);
		$n = $this->assertNumber($args[1]) - 1;
		return isset($list[2][$n]) ? $list[2][$n] : self::$defaultValue;
	}


	protected function listSeparatorForJoin($list1, $sep) {
		if (is_null($sep)) return $list1[1];
		switch ($this->compileValue($sep)) {
		case "comma":
			return ",";
		case "space":
			return "";
		default:
			return $list1[1];
		}
	}

	protected static $lib_join = array("list1", "list2", "separator");
	protected function lib_join($args) {
		list($list1, $list2, $sep) = $args;
		$list1 = $this->coerceList($list1, " ");
		$list2 = $this->coerceList($list2, " ");
		$sep = $this->listSeparatorForJoin($list1, $sep);
		return array("list", $sep, array_merge($list1[2], $list2[2]));
	}

	protected static $lib_append = array("list", "val", "separator");
	protected function lib_append($args) {
		list($list1, $value, $sep) = $args;
		$list1 = $this->coerceList($list1, " ");
		$sep = $this->listSeparatorForJoin($list1, $sep);
		return array("list", $sep, array_merge($list1[2], array($value)));
	}


	protected static $lib_type_of = array("value");
	protected function lib_type_of($args) {
		$value = $args[0];
		switch ($value[0]) {
		case "keyword":
			if ($value == self::$true || $value == self::$false) {
				return "bool";
			}

			if ($this->coerceColor($value)) {
				return "color";
			}

			return "string";
		default:
			return $value[0];
		}
	}

	protected static $lib_unit = array("number");
	protected function lib_unit($args) {
		$num = $args[0];
		if ($num[0] == "number") {
			return array("string", '"', array($num[2]));
		}
		return "";
	}

	protected static $lib_unitless = array("number");
	protected function lib_unitless($args) {
		$value = $args[0];
		return $value[0] == "number" && empty($value[2]);
	}


	protected static $lib_comparable = array("number-1", "number-2");
	protected function lib_comparable($args) {
		return true; // TODO: THIS
	}

	public static $cssColors = array(
		'transparent' => '0,0,0,0',
		'aliceblue' => '240,248,255',
		'antiquewhite' => '250,235,215',
		'aqua' => '0,255,255',
		'aquamarine' => '127,255,212',
		'azure' => '240,255,255',
		'beige' => '245,245,220',
		'bisque' => '255,228,196',
		'black' => '0,0,0',
		'blanchedalmond' => '255,235,205',
		'blue' => '0,0,255',
		'blueviolet' => '138,43,226',
		'brown' => '165,42,42',
		'burlywood' => '222,184,135',
		'cadetblue' => '95,158,160',
		'chartreuse' => '127,255,0',
		'chocolate' => '210,105,30',
		'coral' => '255,127,80',
		'cornflowerblue' => '100,149,237',
		'cornsilk' => '255,248,220',
		'crimson' => '220,20,60',
		'cyan' => '0,255,255',
		'darkblue' => '0,0,139',
		'darkcyan' => '0,139,139',
		'darkgoldenrod' => '184,134,11',
		'darkgray' => '169,169,169',
		'darkgreen' => '0,100,0',
		'darkgrey' => '169,169,169',
		'darkkhaki' => '189,183,107',
		'darkmagenta' => '139,0,139',
		'darkolivegreen' => '85,107,47',
		'darkorange' => '255,140,0',
		'darkorchid' => '153,50,204',
		'darkred' => '139,0,0',
		'darksalmon' => '233,150,122',
		'darkseagreen' => '143,188,143',
		'darkslateblue' => '72,61,139',
		'darkslategray' => '47,79,79',
		'darkslategrey' => '47,79,79',
		'darkturquoise' => '0,206,209',
		'darkviolet' => '148,0,211',
		'deeppink' => '255,20,147',
		'deepskyblue' => '0,191,255',
		'dimgray' => '105,105,105',
		'dimgrey' => '105,105,105',
		'dodgerblue' => '30,144,255',
		'firebrick' => '178,34,34',
		'floralwhite' => '255,250,240',
		'forestgreen' => '34,139,34',
		'fuchsia' => '255,0,255',
		'gainsboro' => '220,220,220',
		'ghostwhite' => '248,248,255',
		'gold' => '255,215,0',
		'goldenrod' => '218,165,32',
		'gray' => '128,128,128',
		'green' => '0,128,0',
		'greenyellow' => '173,255,47',
		'grey' => '128,128,128',
		'honeydew' => '240,255,240',
		'hotpink' => '255,105,180',
		'indianred' => '205,92,92',
		'indigo' => '75,0,130',
		'ivory' => '255,255,240',
		'khaki' => '240,230,140',
		'lavender' => '230,230,250',
		'lavenderblush' => '255,240,245',
		'lawngreen' => '124,252,0',
		'lemonchiffon' => '255,250,205',
		'lightblue' => '173,216,230',
		'lightcoral' => '240,128,128',
		'lightcyan' => '224,255,255',
		'lightgoldenrodyellow' => '250,250,210',
		'lightgray' => '211,211,211',
		'lightgreen' => '144,238,144',
		'lightgrey' => '211,211,211',
		'lightpink' => '255,182,193',
		'lightsalmon' => '255,160,122',
		'lightseagreen' => '32,178,170',
		'lightskyblue' => '135,206,250',
		'lightslategray' => '119,136,153',
		'lightslategrey' => '119,136,153',
		'lightsteelblue' => '176,196,222',
		'lightyellow' => '255,255,224',
		'lime' => '0,255,0',
		'limegreen' => '50,205,50',
		'linen' => '250,240,230',
		'magenta' => '255,0,255',
		'maroon' => '128,0,0',
		'mediumaquamarine' => '102,205,170',
		'mediumblue' => '0,0,205',
		'mediumorchid' => '186,85,211',
		'mediumpurple' => '147,112,219',
		'mediumseagreen' => '60,179,113',
		'mediumslateblue' => '123,104,238',
		'mediumspringgreen' => '0,250,154',
		'mediumturquoise' => '72,209,204',
		'mediumvioletred' => '199,21,133',
		'midnightblue' => '25,25,112',
		'mintcream' => '245,255,250',
		'mistyrose' => '255,228,225',
		'moccasin' => '255,228,181',
		'navajowhite' => '255,222,173',
		'navy' => '0,0,128',
		'oldlace' => '253,245,230',
		'olive' => '128,128,0',
		'olivedrab' => '107,142,35',
		'orange' => '255,165,0',
		'orangered' => '255,69,0',
		'orchid' => '218,112,214',
		'palegoldenrod' => '238,232,170',
		'palegreen' => '152,251,152',
		'paleturquoise' => '175,238,238',
		'palevioletred' => '219,112,147',
		'papayawhip' => '255,239,213',
		'peachpuff' => '255,218,185',
		'peru' => '205,133,63',
		'pink' => '255,192,203',
		'plum' => '221,160,221',
		'powderblue' => '176,224,230',
		'purple' => '128,0,128',
		'red' => '255,0,0',
		'rosybrown' => '188,143,143',
		'royalblue' => '65,105,225',
		'saddlebrown' => '139,69,19',
		'salmon' => '250,128,114',
		'sandybrown' => '244,164,96',
		'seagreen' => '46,139,87',
		'seashell' => '255,245,238',
		'sienna' => '160,82,45',
		'silver' => '192,192,192',
		'skyblue' => '135,206,235',
		'slateblue' => '106,90,205',
		'slategray' => '112,128,144',
		'slategrey' => '112,128,144',
		'snow' => '255,250,250',
		'springgreen' => '0,255,127',
		'steelblue' => '70,130,180',
		'tan' => '210,180,140',
		'teal' => '0,128,128',
		'thistle' => '216,191,216',
		'tomato' => '255,99,71',
		'turquoise' => '64,224,208',
		'violet' => '238,130,238',
		'wheat' => '245,222,179',
		'white' => '255,255,255',
		'whitesmoke' => '245,245,245',
		'yellow' => '255,255,0',
		'yellowgreen' => '154,205,50'
	);
}

class scss_parser {
	static protected $precedence = array(
		"or" => 0,
		"and" => 1,

		'==' => 2,
		'!=' => 2,
		'<=' => 2,
		'>=' => 2,
		'=' => 2,
		'<' => 3,
		'>' => 2,

		'+' => 3,
		'-' => 3,
		'*' => 4,
		'/' => 4,
		'%' => 4,
	);

	static protected $operators = array("+", "-", "*", "/", "%",
		"==", "!=", "<=", ">=", "<", ">", "and", "or");

	static protected $operatorStr;
	static protected $whitePattern;
	static protected $commentMulti;

	static protected $commentSingle = "//";
	static protected $commentMultiLeft = "/*";
	static protected $commentMultiRight = "*/";

	function __construct($sourceName = null) {
		$this->sourceName = $sourceName;

		if (empty(self::$operatorStr)) {
			self::$operatorStr = $this->makeOperatorStr(self::$operators);

			$commentSingle = $this->preg_quote(self::$commentSingle);
			$commentMultiLeft = $this->preg_quote(self::$commentMultiLeft);
			$commentMultiRight = $this->preg_quote(self::$commentMultiRight);
			self::$commentMulti = $commentMultiLeft.'.*?'.$commentMultiRight;
			self::$whitePattern = '/'.$commentSingle.'[^\n]*\s*|('.self::$commentMulti.')\s*|\s+/Ais';
		}
	}

	static protected function makeOperatorStr($operators) {
		return '('.implode('|', array_map(array('scss_parser','preg_quote'),
			$operators)).')';
	}

	function parse($buffer) {
		$this->count = 0;
		$this->env = null;
		$this->inParens = false;
		$this->pushBlock(null); // root block
		$this->eatWhiteDefault = true;
		$this->insertComments = true;

		$this->buffer = $buffer;

		$this->whitespace();
		while (false !== $this->parseChunk());

		if ($this->count != strlen($this->buffer))
			$this->throwParseError();

		if (!empty($this->env->parent)) {
			$this->throwParseError("unclosed block");
		}

		$this->env->isRoot = true;
		return $this->env;
	}

	protected function parseChunk() {
		$s = $this->seek();

		// the directives
		if (isset($this->buffer[$this->count]) && $this->buffer[$this->count] == "@") {
			if ($this->literal("@media") && $this->mediaQueryList($mediaQueryList) && $this->literal("{")) {
				$media = $this->pushSpecialBlock("media");
				$media->queryList = $mediaQueryList[2];
				return true;
			} else {
				$this->seek($s);
			}

			if ($this->literal("@mixin") &&
				$this->keyword($mixinName) &&
				($this->argumentDef($args) || true) &&
				$this->literal("{"))
			{
				$mixin = $this->pushSpecialBlock("mixin");
				$mixin->name = $mixinName;
				$mixin->args = $args;
				return true;
			} else {
				$this->seek($s);
			}

			if ($this->literal("@include") &&
				$this->keyword($mixinName) &&
				($this->literal("(") &&
					($this->argValues($argValues) || true) &&
					$this->literal(")") || true) &&
				$this->end())
			{
				$this->append(array("include",
					$mixinName,
					isset($argValues) ? $argValues : null));
				return true;
			} else {
				$this->seek($s);
			}

			if ($this->literal("@import") &&
				$this->valueList($importPath) &&
				$this->end())
			{
				$this->append(array("import", $importPath));
				return true;
			} else {
				$this->seek($s);
			}

			if ($this->literal("@extend") &&
				$this->selectors($selector) &&
				$this->end())
			{
				$this->append(array("extend", $selector));
				return true;
			} else {
				$this->seek($s);
			}

			if ($this->literal("@function") &&
				$this->keyword($fn_name) &&
				$this->argumentDef($args) &&
				$this->literal("{"))
			{
				$func = $this->pushSpecialBlock("function");
				$func->name = $fn_name;
				$func->args = $args;
				return true;
			} else {
				$this->seek($s);
			}

			if ($this->literal("@return") && $this->valueList($retVal) && $this->end()) {
				$this->append(array("return", $retVal));
				return true;
			} else {
				$this->seek($s);
			}

			if ($this->literal("@each") &&
				$this->variable($varName) &&
				$this->literal("in") &&
				$this->valueList($list) &&
				$this->literal("{"))
			{
				$each = $this->pushSpecialBlock("each");
				$each->var = $varName[1];
				$each->list = $list;
				return true;
			} else {
				$this->seek($s);
			}

			if ($this->literal("@while") &&
				$this->expression($cond) &&
				$this->literal("{"))
			{
				$while = $this->pushSpecialBlock("while");
				$while->cond = $cond;
				return true;
			} else {
				$this->seek($s);
			}

			if ($this->literal("@for") &&
				$this->variable($varName) &&
				$this->literal("from") &&
				$this->expression($start) &&
				($this->literal("through") ||
					($forUntil = true && $this->literal("to"))) &&
				$this->expression($end) &&
				$this->literal("{"))
			{
				$for = $this->pushSpecialBlock("for");
				$for->var = $varName[1];
				$for->start = $start;
				$for->end = $end;
				$for->until = isset($forUntil);
				return true;
			} else {
				$this->seek($s);
			}

			if ($this->literal("@if") && $this->valueList($cond) && $this->literal("{")) {
				$if = $this->pushSpecialBlock("if");
				$if->cond = $cond;
				$if->cases = array();
				return true;
			} else {
				$this->seek($s);
			}

			if (($this->literal("@debug") || $this->literal("@warn")) &&
				$this->valueList($value) &&
				$this->end()) {
				$this->append(array("debug", $value, $s));
				return true;
			} else {
				$this->seek($s);
			}

			$last = $this->last();
			if (!is_null($last) && $last[0] == "if") {
				list(, $if) = $last;
				if ($this->literal("@else")) {
					if ($this->literal("{")) {
						$else = $this->pushSpecialBlock("else");
					} elseif ($this->literal("if") && $this->valueList($cond) && $this->literal("{")) {
						$else = $this->pushSpecialBlock("elseif");
						$else->cond = $cond;
					}

					if (isset($else)) {
						$else->dontAppend = true;
						$if->cases[] = $else;
						return true;
					}
				}

				$this->seek($s);
			}

			if ($this->literal("@charset") &&
				$this->valueList($charset) && $this->end())
			{
				$this->append(array("charset", $charset));
				return true;
			} else {
				$this->seek($s);
			}

			// doesn't match built in directive, do generic one
			if ($this->literal("@", false) && $this->keyword($dirName) &&
				($this->openString("{", $dirValue) || true) &&
				$this->literal("{"))
			{
				$directive = $this->pushSpecialBlock("directive");
				$directive->name = $dirName;
				if (isset($dirValue)) $directive->value = $dirValue;
				return true;
			}

			$this->seek($s);
			return false;
		}

		// property shortcut
		// captures most properties before having to parse a selector
		if ($this->keyword($name, false) &&
			$this->literal(": ") &&
			$this->valueList($value) &&
			$this->end())
		{
			$name = array("string", "", array($name));
			$this->append(array("assign", $name, $value));
			return true;
		} else {
			$this->seek($s);
		}

		// variable assigns
		if ($this->variable($name) &&
			$this->literal(":") &&
			$this->valueList($value) && $this->end())
		{
			$defaultVar = false;
			// check for !default
			if ($value[0] == "list") {
				$def = end($value[2]);
				if ($def[0] == "keyword" && $def[1] == "!default") {
					array_pop($value[2]);
					$value = $this->flattenList($value);
					$defaultVar = true;
				}
			}
			$this->append(array("assign", $name, $value, $defaultVar));
			return true;
		} else {
			$this->seek($s);
		}

		// misc
		if ($this->literal("-->")) {
			return true;
		}

		// opening css block
		$oldComments = $this->insertComments;
		$this->insertComments = false;
		if ($this->selectors($selectors) && $this->literal("{")) {
			$this->pushBlock($selectors);
			$this->insertComments = $oldComments;
			return true;
		} else {
			$this->seek($s);
		}
		$this->insertComments = $oldComments;

		// property assign, or nested assign
		if ($this->propertyName($name) && $this->literal(":")) {
			$foundSomething = false;
			if ($this->valueList($value)) {
				$this->append(array("assign", $name, $value));
				$foundSomething = true;
			}

			if ($this->literal("{")) {
				$propBlock = $this->pushSpecialBlock("nestedprop");
				$propBlock->prefix = $name;
				$foundSomething = true;
			} elseif ($foundSomething) {
				$foundSomething = $this->end();
			}

			if ($foundSomething) {
				return true;
			}

			$this->seek($s);
		} else {
			$this->seek($s);
		}

		// closing a block
		if ($this->literal("}")) {
			$block = $this->popBlock();
			if (empty($block->dontAppend)) {
				$type = isset($block->type) ? $block->type : "block";
				$this->append(array($type, $block));
			}
			return true;
		}

		// extra stuff
		if ($this->literal(";") ||
			$this->literal("<!--"))
		{
			return true;
		}

		return false;
	}

	protected function literal($what, $eatWhitespace = null) {
		if (is_null($eatWhitespace)) $eatWhitespace = $this->eatWhiteDefault;

		// this is here mainly prevent notice from { } string accessor
		if ($this->count >= strlen($this->buffer)) return false;

		// shortcut on single letter
		if (!$eatWhitespace && strlen($what) == 1) {
			if ($this->buffer{$this->count} == $what) {
				$this->count++;
				return true;
			}
			else return false;
		}

		return $this->match($this->preg_quote($what), $m, $eatWhitespace);
	}

	// tree builders

	protected function pushBlock($selectors) {
		$b = new stdclass;
		$b->parent = $this->env; // not sure if we need this yet

		$b->selectors = $selectors;
		$b->children = array();

		$this->env = $b;
		return $b;
	}

	protected function pushSpecialBlock($type) {
		$block = $this->pushBlock(null);
		$block->type = $type;
		return $block;
	}

	protected function popBlock() {
		if (empty($this->env->parent)) {
			$this->throwParseError("unexpected }");
		}

		$old = $this->env;
		$this->env = $this->env->parent;
		unset($old->parent);
		return $old;
	}

	protected function append($statement) {
		$this->env->children[] = $statement;
	}

	// last child that was appended
	protected function last() {
		$i = count($this->env->children) - 1;
		if (isset($this->env->children[$i]))
			return $this->env->children[$i];
	}

	// high level parsers (they return parts of ast)

	protected function mediaQueryList(&$out) {
		return $this->genericList($out, "mediaQuery", ",", false);
	}

	protected function mediaQuery(&$out) {
		$s = $this->seek();

		$expressions = null;
		$parts = array();

		if (($this->literal("only") && ($only = true) || $this->literal("not") && ($not = true) || true) && $this->keyword($mediaType)) {
			$prop = array("mediaType");
			if (isset($only)) $prop[] = "only";
			if (isset($not)) $prop[] = "not";
			$prop[] = $mediaType;
			$parts[] = $prop;
		} else {
			$this->seek($s);
		}


		if (!empty($mediaType) && !$this->literal("and")) {
			// ~
		} else {
			$this->genericList($expressions, "mediaExpression", "and", false);
			if (is_array($expressions)) $parts = array_merge($parts, $expressions[2]);
		}

		$out = $parts;
		return true;
	}

	protected function mediaExpression(&$out) {
		$s = $this->seek();
		$value = null;
		if ($this->literal("(") &&
			$this->keyword($feature) &&
			($this->literal(":") && $this->expression($value) || true) &&
			$this->literal(")"))
		{
			$out = array("mediaExp", $feature);
			if ($value) $out[] = $value;
			return true;
		}

		$this->seek($s);
		return false;
	}

	protected function argValues(&$out) {
		if ($this->genericList($list, "argValue", ",", false)) {
			$out = $list[2];
			return true;
		}
		return false;
	}

	protected function argValue(&$out) {
		$s = $this->seek();

		$keyword = null;
		if (!$this->variable($keyword) || !$this->literal(":")) {
			$this->seek($s);
			$keyword = null;
		}

		if ($this->genericList($value, "expression")) {
			$out = array($keyword, $value);
			return true;
		}

		return false;
	}


	protected function valueList(&$out) {
		return $this->genericList($out, "commaList");
	}

	protected function commaList(&$out) {
		return $this->genericList($out, "expression", ",");
	}

	protected function genericList(&$out, $parseItem, $delim="", $flatten=true) {
		$s = $this->seek();
		$items = array();
		while ($this->$parseItem($value)) {
			$items[] = $value;
			if ($delim) {
				if (!$this->literal($delim)) break;
			}
		}

		if (count($items) == 0) {
			$this->seek($s);
			return false;
		}

		if ($flatten && count($items) == 1) {
			$out = $items[0];
		} else {
			$out = array("list", $delim, $items);
		}

		return true;
	}

	protected function expression(&$out) {
		if ($this->value($lhs)) {
			$out = $this->expHelper($lhs, 0);
			return true;
		}
		return false;
	}

	protected function expHelper($lhs, $minP) {
		$opstr = self::$operatorStr;

		$ss = $this->seek();
		$whiteBefore = isset($this->buffer[$this->count - 1]) &&
			ctype_space($this->buffer[$this->count - 1]);
		while ($this->match($opstr, $m) && self::$precedence[$m[1]] >= $minP) {
			$whiteAfter = isset($this->buffer[$this->count - 1]) &&
				ctype_space($this->buffer[$this->count - 1]);

			$op = $m[1];

			// don't turn negative numbers into expressions
			if ($op == "-" && $whiteBefore) {
				if (!$whiteAfter) break;
			}

			if (!$this->value($rhs)) break;

			// peek and see if rhs belongs to next operator
			if ($this->peek($opstr, $next) && self::$precedence[$next[1]] > self::$precedence[$op]) {
				$rhs = $this->expHelper($rhs, self::$precedence[$next[1]]);
			}

			$lhs = array("exp", $op, $lhs, $rhs, $this->inParens, $whiteBefore, $whiteAfter);
			$ss = $this->seek();
			$whiteBefore = isset($this->buffer[$this->count - 1]) &&
				ctype_space($this->buffer[$this->count - 1]);
		}

		$this->seek($ss);
		return $lhs;
	}

	protected function value(&$out) {
		$s = $this->seek();

		if ($this->literal("not", false) && $this->whitespace() && $this->value($inner)) {
			$out = array("unary", "not", $inner, $this->inParens);
			return true;
		} else {
			$this->seek($s);
		}

		if ($this->literal("+") && $this->value($inner)) {
			$out = array("unary", "+", $inner, $this->inParens);
			return true;
		} else {
			$this->seek($s);
		}

		// negation
		if ($this->literal("-", false) &&
			($this->variable($inner) ||
			$this->unit($inner) ||
			$this->parenValue($inner)))
		{
			$out = array("unary", "-", $inner, $this->inParens);
			return true;
		} else {
			$this->seek($s);
		}

		if ($this->parenValue($out)) return true;
		if ($this->interpolation($out)) return true;
		if ($this->variable($out)) return true;
		if ($this->color($out)) return true;
		if ($this->unit($out)) return true;
		if ($this->string($out)) return true;
		if ($this->func($out)) return true;
		if ($this->progid($out)) return true;

		if ($this->keyword($keyword)) {
			$out = array("keyword", $keyword);
			return true;
		}

		return false;
	}

	// value wrappen in parentheses
	protected function parenValue(&$out) {
		$s = $this->seek();

		$inParens = $this->inParens;
		if ($this->literal("(") &&
			($this->inParens = true) && $this->expression($exp) &&
			$this->literal(")"))
		{
			$out = $exp;
			$this->inParens = $inParens;
			return true;
		} else {
			$this->inParens = $inParens;
			$this->seek($s);
		}

		return false;
	}

	protected function progid(&$out) {
		$s = $this->seek();
		if ($this->literal("progid:", false) &&
			$this->openString("(", $fn) &&
			$this->literal("("))
		{
			$this->openString(")", $args, "(");
			if ($this->literal(")")) {
				$out = array("string", "", array(
					"progid:", $fn, "(", $args, ")"
				));
				return true;
			}
		}

		$this->seek($s);
		return false;
	}

	protected function func(&$func) {
		$s = $this->seek();

		if ($this->keyword($name, false) &&
			$this->literal("("))
		{
			if ($name != "expression") {
				$ss = $this->seek();
				if ($name != "expression") {
					if ($this->argValues($args) && $this->literal(")")) {
						$func = array("fncall", $name, $args);
						return true;
					}
				}
				$this->seek($ss);
			}

			if (($this->openString(")", $str, "(") || true ) &&
				$this->literal(")"))
			{
				$args = array();
				if (!empty($str)) {
					$args[] = array(null, array("string", "", array($str)));
				}

				$func = array("fncall", $name, $args);
				return true;
			}
		}

		$this->seek($s);
		return false;
	}

	protected function argumentDef(&$out) {
		$s = $this->seek();
		$this->literal("(");

		$args = array();
		while ($this->variable($var)) {
			$arg = array($var[1], null);

			$ss = $this->seek();
			if ($this->literal(":") && $this->expression($defaultVal)) {
				$arg[1] = $defaultVal;
			} else {
				$this->seek($ss);
			}

			$args[] = $arg;
			if (!$this->literal(",")) break;
		}

		if (!$this->literal(")")) {
			$this->seek($s);
			return false;
		}

		$out = $args;
		return true;
	}

	protected function color(&$out) {
		$color = array('color');

		if ($this->match('(#([0-9a-f]{6})|#([0-9a-f]{3}))', $m)) {
			if (isset($m[3])) {
				$num = $m[3];
				$width = 16;
			} else {
				$num = $m[2];
				$width = 256;
			}

			$num = hexdec($num);
			foreach (array(3,2,1) as $i) {
				$t = $num % $width;
				$num /= $width;

				$color[$i] = $t * (256/$width) + $t * floor(16/$width);
			}

			$out = $color;
			return true;
		}

		return false;
	}

	protected function unit(&$unit) {
		if ($this->match('([0-9]*(\.)?[0-9]+)([%a-zA-Z]+)?', $m)) {
			$unit = array("number", $m[1], empty($m[3]) ? "" : $m[3]);
			return true;
		}
		return false;
	}

	protected function string(&$out) {
		$s = $this->seek();
		if ($this->literal('"', false)) {
			$delim = '"';
		} elseif ($this->literal("'", false)) {
			$delim = "'";
		} else {
			return false;
		}

		$content = array();

		// look for either ending delim , escape, or string interpolation
		$patt = '([^\n]*?)(#\{|\\\\|' .
			$this->preg_quote($delim).')';

		$oldWhite = $this->eatWhiteDefault;
		$this->eatWhiteDefault = false;

		while ($this->match($patt, $m, false)) {
			$content[] = $m[1];
			if ($m[2] == "#{") {
				$this->count -= strlen($m[2]);
				if ($this->interpolation($inter, false)) {
					$content[] = $inter;
				} else {
					$this->count += strlen($m[2]);
					$content[] = "#{"; // ignore it
				}
			} elseif ($m[2] == '\\') {
				$content[] = $m[2];
				if ($this->literal($delim, false)) {
					$content[] = $delim;
				}
			} else {
				$this->count -= strlen($delim);
				break; // delim
			}
		}

		$this->eatWhiteDefault = $oldWhite;

		if ($this->literal($delim)) {
			$out = array("string", $delim, $content);
			return true;
		}

		$this->seek($s);
		return false;
	}

	protected function mixedKeyword(&$out) {
		$s = $this->seek();

		$parts = array();

		$oldWhite = $this->eatWhiteDefault;
		$this->eatWhiteDefault = false;

		while (true) {
			if ($this->keyword($key)) {
				$parts[] = $key;
				continue;
			}

			if ($this->interpolation($inter)) {
				$parts[] = $inter;
				continue;
			}

			break;
		}

		$this->eatWhiteDefault = $oldWhite;

		if (count($parts) == 0) return false;

		$out = $parts;
		return true;
	}

	// an unbounded string stopped by $end
	protected function openString($end, &$out, $nestingOpen=null) {
		$oldWhite = $this->eatWhiteDefault;
		$this->eatWhiteDefault = false;

		$stop = array("'", '"', "#{", $end);
		$stop = array_map(array($this, "preg_quote"), $stop);
		$stop[] = self::$commentMulti;

		$patt = '(.*?)('.implode("|", $stop).')';

		$nestingLevel = 0;

		$content = array();
		while ($this->match($patt, $m, false)) {
			if (!empty($m[1])) {
				$content[] = $m[1];
				if ($nestingOpen) {
					$nestingLevel += substr_count($m[1], $nestingOpen);
				}
			}

			$tok = $m[2];

			$this->count-= strlen($tok);
			if ($tok == $end) {
				if ($nestingLevel == 0) {
					break;
				} else {
					$nestingLevel--;
				}
			}

			if (($tok == "'" || $tok == '"') && $this->string($str)) {
				$content[] = $str;
				continue;
			}

			if ($tok == "#{" && $this->interpolation($inter)) {
				$content[] = $inter;
				continue;
			}

			$content[] = $tok;
			$this->count+= strlen($tok);
		}

		$this->eatWhiteDefault = $oldWhite;

		if (count($content) == 0) return false;

		// trim the end
		if (is_string(end($content))) {
			$content[count($content) - 1] = rtrim(end($content));
		}

		$out = array("string", "", $content);
		return true;
	}

	// $lookWhite: save information about whitespace before and after
	protected function interpolation(&$out, $lookWhite=true) {
		$oldWhite = $this->eatWhiteDefault;
		$this->eatWhiteDefault = true;

		$s = $this->seek();
		if ($this->literal("#{") && $this->valueList($value) && $this->literal("}", false)) {

			// TODO: don't error if out of bounds

			if ($lookWhite) {
				$left = preg_match('/\s/', $this->buffer[$s - 1]) ? " " : "";
				$right = preg_match('/\s/', $this->buffer[$this->count]) ? " ": "";
			} else {
				$left = $right = false;
			}

			$out = array("interpolate", $value, $left, $right);
			$this->eatWhiteDefault = $oldWhite;
			if ($this->eatWhiteDefault) $this->whitespace();
			return true;
		}

		$this->seek($s);
		$this->eatWhiteDefault = $oldWhite;
		return false;
	}

	// low level parsers

	// returns an array of parts or a string
	protected function propertyName(&$out) {
		$s = $this->seek();
		$parts = array();

		$oldWhite = $this->eatWhiteDefault;
		$this->eatWhiteDefault = false;

		while (true) {
			if ($this->interpolation($inter)) {
				$parts[] = $inter;
			} elseif ($this->keyword($text)) {
				$parts[] = $text;
			} elseif (count($parts) == 0 && $this->match('[:.#]', $m, false)) {
				// css hacks
				$parts[] = $m[0];
			} else {
				break;
			}
		}

		$this->eatWhiteDefault = $oldWhite;
		if (count($parts) == 0) return false;

		// match comment hack
		if (preg_match(self::$whitePattern,
			$this->buffer, $m, null, $this->count))
		{
			if (!empty($m[0])) {
				$parts[] = $m[0];
				$this->count += strlen($m[0]);
			}
		}

		$this->whitespace(); // get any extra whitespace

		$out = array("string", "", $parts);
		return true;
	}

	// comma separated list of selectors
	protected function selectors(&$out) {
		$s = $this->seek();
		$selectors = array();
		while ($this->selector($sel)) {
			$selectors[] = $sel;
			if (!$this->literal(",")) break;
			while ($this->literal(",")); // ignore extra
		}

		if (count($selectors) == 0) {
			$this->seek($s);
			return false;
		}

		$out = $selectors;
		return true;
	}

	// whitepsace separated list of selectorSingle
	protected function selector(&$out) {
		$selector = array();

		while (true) {
			if ($this->match('[>+~]+', $m)) {
				$selector[] = array($m[0]);
			} elseif ($this->selectorSingle($part)) {
				$selector[] = $part;
				$this->whitespace();
			} else {
				break;
			}

		}

		if (count($selector) == 0) {
			return false;
		}

		$out = $selector;
		return true;
	}

	// the parts that make up
	// div[yes=no]#something.hello.world:nth-child(-2n+1)
	protected function selectorSingle(&$out) {
		$oldWhite = $this->eatWhiteDefault;
		$this->eatWhiteDefault = false;

		$parts = array();

		if ($this->literal("*", false)) {
			$parts[] = "*";
		}

		while (true) {
			// see if we can stop early
			if ($this->match("\s*[{,]", $m)) {
				$this->count--;
				break;
			}

			$s = $this->seek();
			// self
			if ($this->literal("&", false)) {
				$parts[] = scssc::$selfSelector;
				continue;
			}

			if ($this->literal(".", false)) {
				$parts[] = ".";
				continue;
			}

			if ($this->literal("|", false)) {
				$parts[] = "|";
				continue;
			}

			// for keyframes
			if ($this->unit($unit)) {
				$parts[] = $unit;
				continue;
			}

			if ($this->keyword($name)) {
				$parts[] = $name;
				continue;
			}

			if ($this->interpolation($inter)) {
				$parts[] = $inter;
				continue;
			}

			if ($this->literal("#", false)) {
				$parts[] = "#";
				continue;
			}

			// a pseudo selector
			if ($this->match("::?", $m) && $this->mixedKeyword($nameParts)) {
				$parts[] = $m[0];
				foreach ($nameParts as $sub) {
					$parts[] = $sub;
				}

				$ss = $this->seek();
				if ($this->literal("(") &&
					($this->openString(")", $str, "(") || true ) &&
					$this->literal(")"))
				{
					$parts[] = "(";
					if (!empty($str)) $parts[] = $str;
					$parts[] = ")";
				} else {
					$this->seek($ss);
				}

				continue;
			} else {
				$this->seek($s);
			}

			// attribute selector
			// TODO: replace with open string?
			if ($this->literal("[", false)) {
				$attrParts = array("[");
				// keyword, string, operator
				while (true) {
					if ($this->literal("]", false)) {
						$this->count--;
						break; // get out early
					}

					if ($this->match('\s+', $m)) {
						$attrParts[] = " ";
						continue;
					}
					if ($this->string($str)) {
						$attrParts[] = $str;
						continue;
					}

					if ($this->keyword($word)) {
						$attrParts[] = $word;
						continue;
					}

					if ($this->interpolation($inter, false)) {
						$attrParts[] = $inter;
						continue;
					}

					// operator, handles attr namespace too
					if ($this->match('[|-~\$\*\^=]+', $m)) {
						$attrParts[] = $m[0];
						continue;
					}

					break;
				}

				if ($this->literal("]", false)) {
					$attrParts[] = "]";
					foreach ($attrParts as $part) {
						$parts[] = $part;
					}
					continue;
				}
				$this->seek($s);
				// should just break here?
			}

			break;
		}

		$this->eatWhiteDefault = $oldWhite;

		if (count($parts) == 0) return false;

		$out = $parts;
		return true;
	}

	protected function variable(&$out) {
		$s = $this->seek();
		if ($this->literal("$", false) && $this->keyword($name)) {
			$out = array("var", $name);
			return true;
		}
		$this->seek($s);
		return false;
	}

	protected function keyword(&$word, $eatWhitespace = null) {
		if ($this->match('([\w_\-\*!"\'\\\\][\w\-_"\'\\\\]*)',
			$m, $eatWhitespace))
		{
			$word = $m[1];
			return true;
		}
		return false;
	}

	// consume an end of statement delimiter
	protected function end() {
		if ($this->literal(';')) {
			return true;
		} elseif ($this->count == strlen($this->buffer) || $this->buffer{$this->count} == '}') {
			// if there is end of file or a closing block next then we don't need a ;
			return true;
		}
		return false;
	}

	// advance counter to next occurrence of $what
	// $until - don't include $what in advance
	// $allowNewline, if string, will be used as valid char set
	protected function to($what, &$out, $until = false, $allowNewline = false) {
		if (is_string($allowNewline)) {
			$validChars = $allowNewline;
		} else {
			$validChars = $allowNewline ? "." : "[^\n]";
		}
		if (!$this->match('('.$validChars.'*?)'.$this->preg_quote($what), $m, !$until)) return false;
		if ($until) $this->count -= strlen($what); // give back $what
		$out = $m[1];
		return true;
	}

	protected function throwParseError($msg = "parse error", $count = null) {
		$count = is_null($count) ? $this->count : $count;

		$line = $this->getLineNo($count);

		if (!empty($this->sourceName)) {
			$loc = "$this->sourceName on line $line";
		} else {
			$loc = "line: $line";
		}

		if ($this->peek("(.*?)(\n|$)", $m, $count)) {
			throw new exception("$msg: failed at `$m[1]` $loc");
		} else {
			throw new exception("$msg: $loc");
		}
	}

	public function getLineNo($pos) {
		return 1 + substr_count(substr($this->buffer, 0, $pos), "\n");
	}

	// try to match something on head of buffer
	protected function match($regex, &$out, $eatWhitespace = null) {
		if (is_null($eatWhitespace)) $eatWhitespace = $this->eatWhiteDefault;

		$r = '/'.$regex.'/Ais';
		if (preg_match($r, $this->buffer, $out, null, $this->count)) {
			$this->count += strlen($out[0]);
			if ($eatWhitespace) $this->whitespace();
			return true;
		}
		return false;
	}

	// match some whitespace
	protected function whitespace() {
		$gotWhite = false;
		while (preg_match(self::$whitePattern, $this->buffer, $m, null, $this->count)) {
			if ($this->insertComments) {
				if (isset($m[1]) && empty($this->commentsSeen[$this->count])) {
					$this->append(array("comment", $m[1]));
					$this->commentsSeen[$this->count] = true;
				}
			}
			$this->count += strlen($m[0]);
			$gotWhite = true;
		}
		return $gotWhite;
	}

	protected function peek($regex, &$out, $from=null) {
		if (is_null($from)) $from = $this->count;

		$r = '/'.$regex.'/Ais';
		$result = preg_match($r, $this->buffer, $out, null, $from);

		return $result;
	}

	protected function seek($where = null) {
		if ($where === null) return $this->count;
		else $this->count = $where;
		return true;
	}

	static function preg_quote($what) {
		return preg_quote($what, '/');
	}

	protected function show() {
		if ($this->peek("(.*?)(\n|$)", $m, $this->count)) {
			return $m[1];
		}
		return "";
	}

	// turn list of length 1 into value type
	protected function flattenList($value) {
		if ($value[0] == "list" && count($value[2]) == 1) {
			return $this->flattenList($value[2][0]);
		}
		return $value;
	}
}

class scss_formatter {
	public $indentChar = "  ";

	public $break = "\n";
	public $open = " {";
	public $close = "}";
	public $tagSeparator = ", ";
	public $assignSeparator = ": ";
	
	public $removeTrailingSemicolon = false;
	public $replaceColorNames = false;
	public $omitZeroUnit = false;
	public $omitZeroLeading = false;
	public $stripComments = false;
	public $numberPrecision = 3;

	public function __construct() {
		$this->indentLevel = 0;
	}

	public function indentStr($n = 0) {
		return str_repeat($this->indentChar, max($this->indentLevel + $n, 0));
	}

	public function property($name, $value) {
		return $name . $this->assignSeparator . $value . ";";
	}

	public function implodeList($delim, $items) {
	    return implode("$delim ", $items);
	}

	public function implodeSelectors($selectors) {
	    return implode(" ", $selectors);
	}

	public function color($r, $g, $b, $a) {
		if (($a = $this->number($a, null)) != 1) { // rgba
			if ($a == 0 && $this->replaceColorNames) {
				return 'transparent';
			}
		    return 'rgba('.$r.$this->tagSeparator.$g.$this->tagSeparator.$b.$this->tagSeparator.$a.')';
		}
		
		$h = sprintf("#%02x%02x%02x", $r, $g, $b);
		
		// Converting hex color to short notation (e.g. #003399 to #039)
		if ($h[1] === $h[2] && $h[3] === $h[4] && $h[5] === $h[6]) {
		    $h = '#' . $h[1] . $h[3] . $h[5];
		}
		
		if ($this->replaceColorNames) {
		    // Convert hex color to css color name if shorter (e.g. #f00 to red)
		    $name = array_search($r.','.$g.','.$b, scssc::$cssColors, true);
		    if ($name !== false && strlen($name) < strlen($h)) {
		        $h = $name;
		    }
		}
		
		return $h;
	}
	
	public function number($num, $unit) {
		$num = round($num, $this->numberPrecision);
		if ($this->omitZeroUnit && $num == 0) {
		    return 0;
		}
		if ($this->omitZeroLeading) {
		    if ($num > 0 && $num < 1) {
		        $num = substr($num, 1);
		    } else if ($num < 0 && $num > -1) {
		        $num = '-' . substr($num, 2);
		    }
		}
		return $num . $unit;
	}

	public function block($block) {
		if (empty($block->lines) && empty($block->children)) return '';

		$inner = $pre = $this->indentStr();
		
		$ret = '';

		if (!empty($block->selectors)) {
			$ret .= $pre .
				implode($this->tagSeparator, $block->selectors) .
				$this->open . $this->break;
			$this->indentLevel++;
			$inner = $this->indentStr();
		}

		if (!empty($block->lines)) {
			$glue = $this->break.$inner;
			$ret .= $inner . implode($glue, $block->lines);

			if (!empty($block->children)) {
				$ret .= $this->break;
			} else if ($this->removeTrailingSemicolon && substr($ret, -1) === ';') {
			    $ret = substr($ret, 0, -1);
			}
		}

		foreach ($block->children as $child) {
			$ret .= $this->block($child);
		}

		if (!empty($block->selectors)) {
			$this->indentLevel--;
			if (empty($block->children)) $ret .= $this->break;
			$ret .= $pre . $this->close . $this->break;
		}
		return $ret;
	}
}


class scss_formatter_nested extends scss_formatter {
	public $close = " }";

	// adjust the depths of all children, depth first
	public function adjustAllChildren($block) {
		// flatten empty nested blocks
		$children = array();
		foreach ($block->children as $i => $child) {
			if (empty($child->lines) && empty($child->children)) {
				if (isset($block->children[$i + 1])) {
					$block->children[$i + 1]->depth = $child->depth;
				}
				continue;
			}
			$children[] = $child;
		}
		$block->children = $children;

		// make relative to parent
		foreach ($block->children as $child) {
			$this->adjustAllChildren($child);
			$child->depth = $child->depth - $block->depth;
		}
	}

	public function block($block) {
		if ($block->type == "root") {
			$this->adjustAllChildren($block);
		}
		
		$ret = '';

		$inner = $pre = $this->indentStr($block->depth - 1);
		if (!empty($block->selectors)) {
			$ret .= $pre .
				implode($this->tagSeparator, $block->selectors) .
				$this->open . $this->break;
			$this->indentLevel++;
			$inner = $this->indentStr($block->depth - 1);
		}

		if (!empty($block->lines)) {
			$glue = $this->break.$inner;
			$ret .= $inner . implode($glue, $block->lines);

			if (!empty($block->children)) {
				$ret .= $this->break;
			} else if ($this->removeTrailingSemicolon && substr($ret, -1) === ';') {
			    $ret = substr($ret, 0, -1);
			}
		}

		foreach ($block->children as $i => $child) {
			// echo "*** block: ".$block->depth." child: ".$child->depth."\n";
			$ret .= $this->block($child);
			if ($i < count($block->children) - 1) {
				$ret .= $this->break;

				if (isset($block->children[$i + 1])) {
					$next = $block->children[$i + 1];
					if ($next->depth == max($block->depth, 1) && $child->depth >= $next->depth) {
						$ret .= $this->break;
					}
				}
			}
		}

		if (!empty($block->selectors)) {
			$this->indentLevel--;
			$ret .= $this->close;
		}

		if ($block->type == "root") {
			$ret .= $this->break;
		}
		return $ret;
	}
}

class scss_formatter_compressed extends scss_formatter {
	public $open = "{";
	public $tagSeparator = ",";
	public $assignSeparator = ":";
	public $break = "";
	public $removeTrailingSemicolon = true;
	public $replaceColorNames = true;
	public $omitZeroUnit = true;
	public $omitZeroLeading = true;
	public $stripComments = true;

	public function indentStr($n = 0) {
		return "";
	}

	public function implodeList($delim, $list) {
	    // no delimiter => actually a whitespace separated list (as in "margin")
	    if ($delim == "") {
	        $delim = " ";
	    }
	    return implode($delim, $list);
	}

	public function implodeSelectors($selectors){
	    $ret = '';
	    $ws = false;
	    foreach($selectors as $selector){
	        // do not use whitespace around descendant selectors
	        if (in_array($selector,array('+','~','>'),true)) {
	            $ws = false;
	        }else{
	            if ($ws) {
	                $ret .= ' ';
	            } else {
	                $ws = true;
	            }
	        }
	        $ret .= $selector;
	    }
	    return $ret;
	}
}

class scss_server {

	protected function join($left, $right) {
		return rtrim($left, "/") . "/" . ltrim($right, "/");
	}

	protected function inputName() {
		if (isset($_GET["p"])) return $_GET["p"];

		if (isset($_SERVER["PATH_INFO"])) return $_SERVER["PATH_INFO"];
		if (isset($_SERVER["DOCUMENT_URI"])) {
			return substr($_SERVER["DOCUMENT_URI"], strlen($_SERVER["SCRIPT_NAME"]));
		}
	}

	protected function findInput() {
		if ($input = $this->inputName()) {
			$name = $this->join($this->dir, $input);
			if (is_readable($name)) return $name;
		}
		return false;
	}

	protected function cacheName($fname) {
		return $this->join($this->cacheDir, md5($fname) . ".css");
	}

	protected function importsCacheName($out) {
		return $out . ".imports";
	}

	protected function needsCompile($in, $out) {
		if (!is_file($out)) return true;

		$mtime = filemtime($out);
		if (filemtime($in) > $mtime) return true;

		// look for modified imports
		$icache = $this->importsCacheName($out);
		if (is_readable($icache)) {
			$imports = unserialize(file_get_contents($icache));
			foreach ($imports as $import) {
				if (filemtime($import) > $mtime) return true;
			}
		}
		return false;
	}

	protected function compile($in, $out) {
		$start = microtime(true);
		$css = $this->scss->compile(file_get_contents($in), $in);
		$elapsed = round((microtime(true) - $start), 4);

		$v = scssc::$VERSION;
		$t = date("r");
		$css = "/* compiled by scssphp $v on $t (${elapsed}s) */\n\n" . $css;

		file_put_contents($out, $css);
		file_put_contents($this->importsCacheName($out),
			serialize($this->scss->getParsedFiles()));
		return $css;
	}

	public function serve() {
		if ($input = $this->findInput()) {
			$output = $this->cacheName($input);
			header("Content-type: text/css");

			if ($this->needsCompile($input, $output)) {
				try {
					echo $this->compile($input, $output);
				} catch (exception $e) {
					header('HTTP/1.1 500 Internal Server Error');
					echo "Parse error: " . $e->getMessage() . "\n";
				}
			} else {
				header('X-SCSS-Cache: true');
				echo file_get_contents($output);
			}

			return;
		}

		header('HTTP/1.0 404 Not Found');
		header("Content-type: text");
		$v = scssc::$VERSION;
		echo "/* INPUT NOT FOUND scss $v */\n";
	}

	public function __construct($dir, $cacheDir=null, $scss=null) {
		$this->dir = $dir;

		if (is_null($cacheDir)) {
			$cacheDir = $this->join($dir, "scss_cache");
		}

		$this->cacheDir = $cacheDir;
		if (!is_dir($this->cacheDir)) mkdir($this->cacheDir);

		if (is_null($scss)) {
			$scss = new scssc();
			$scss->setImportPaths($this->dir);
		}
		$this->scss = $scss;
	}

	static public function serveFrom($path) {
		$server = new self($path);
		$server->serve();
	}
}

