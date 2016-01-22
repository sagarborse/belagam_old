<div class="<?php echo $additional_class; ?> search_block">
    <form method="GET" action="index.php" class="input-group search-box">
	<?php if(!empty($categories)) { ?>
	<?php

		$useragent=$_SERVER['HTTP_USER_AGENT'];
		$css = '';

		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))

		$css = 'style="width: 101px;"';

	?>
	<div class="filter_type category_filter input-group-addon group-addon-select no-padding icon-select">
		<select <?php echo $css ?> name="category_id" class="no-border">
			<option value="0"><?php echo $objlang->get("text_category_all"); ?></option>
			<?php foreach ($categories as $category_1) { ?>
	        <?php if ($category_1['category_id'] == $category_id) { ?>
	        <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
	        <?php } else { ?>
	        <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
	        <?php } ?>
	        <?php foreach ($category_1['children'] as $category_2) { ?>
	        <?php if ($category_2['category_id'] == $category_id) { ?>
	        <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
	        <?php } else { ?>
	        <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
	        <?php } ?>
	        <?php foreach ($category_2['children'] as $category_3) { ?>
	        <?php if ($category_3['category_id'] == $category_id) { ?>
	        <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
	        <?php } else { ?>
	        <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
	        <?php } ?>
	        <?php } ?>
	        <?php } ?>
	        <?php } ?>
		</select>
	</div>
	<?php } ?>
	<div id="search<?php echo $module ?>" class="search-input-wrapper clearfix clearfixs input-group">
	    <input type="text" value="" size="20" autocomplete="off" placeholder="<?php echo $objlang->get("text_search");?>" name="search" class="form-control input-lg input-search">

        <span class="input-group-addon input-group-search">
                    <span class="fa fa-search"></span>
                    <button type='submit'  value='Search..'class="button-search "> Search..</button>

        </span>
	</div>
	<input type="hidden" name="sub_category" value="1" id="sub_category"/>
	<input type="hidden" name="route" value="product/search"/>
	<input type="hidden" name="sub_category" value="true" id="sub_category"/>
	<input type="hidden" name="description" value="true" id="description"/>
	</form>
	<div class="clear clr"></div>
</div>
<script type="text/javascript">

/* Autocomplete */
(function($) {
	function Autocomplete1(element, options) {
		this.element = element;
		this.options = options;
		this.timer = null;
		this.items = new Array();

		$(element).attr('autocomplete', 'off');
		$(element).on('focus', $.proxy(this.focus, this));
		$(element).on('blur', $.proxy(this.blur, this));
		$(element).on('keydown', $.proxy(this.keydown, this));

		$(element).after('<ul class="dropdown-menu autosearch"></ul>');
		$(element).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));
	}

	Autocomplete1.prototype = {
		focus: function() {
			this.request();
		},
		blur: function() {
			setTimeout(function(object) {
				object.hide();
			}, 200, this);
		},
		click: function(event) {
			event.preventDefault();
			value = $(event.target).parent().attr("href");
			if (value) {
				window.location = value.replace(/&amp;/gi,'&');
			}
		},
		keydown: function(event) {
			switch(event.keyCode) {
				case 27: // escape
					this.hide();
					break;
				default:
					this.request();
					break;
			}
		},
		show: function() {
			var pos = $(this.element).position();

			$(this.element).siblings('ul.dropdown-menu').css({
				top: pos.top + $(this.element).outerHeight(),
				left: pos.left
			});

			$(this.element).siblings('ul.dropdown-menu').show();
		},
		hide: function() {
			$(this.element).siblings('ul.dropdown-menu').hide();
		},
		request: function() {
			clearTimeout(this.timer);

			this.timer = setTimeout(function(object) {
				object.options.source($(object.element).val(), $.proxy(object.response, object));
			}, 200, this);
		},
		response: function(json) {
			console.log(json);
			html = '';

			if (json.length) {
				for (i = 0; i < json.length; i++) {
					this.items[json[i]['value']] = json[i];
				}

				for (i = 0; i < json.length; i++) {
					if (!json[i]['category']) {
						html += '<li class="media" data-value="' + json[i]['value'] + '">';
						if(json[i]['simage']) {
							html += '	<a class="media-left" href="' + json[i]['link'] + '"><img  src="' + json[i]['image'] + '"></a>';	
						}
						html += '<div class="media-body">';
						html += '	<a  href="' + json[i]['link'] + '"><span>' + json[i]['label'] + '</span></a>';
						if(json[i]['sprice']){
							html += '	<div>';
							if (!json[i]['special']) {
								html += json[i]['price'];
							} else {
								html += '<span class="price-old">' + json[i]['price'] + '</span><span class="price-new">' + json[i]['special'] + '</span>';
							}
							if (json[i]['tax']) {
								html += '<br />';
								html += '<span class="price-tax"><?php echo $objlang->get("text_tax");?> : ' + json[i]['tax'] + '</span>';
							}
							html += '	</div> </div>';
						}
						html += '</li>';
					}
				}
				//html += '<li><a href="index.php?route=product/search&search='+g.term+'&category_id='+category_id+'&sub_category=true&description=true" onclick="window.location=this.href">'+text_view_all+'</a></li>';

				// Get all the ones with a categories
				var category = new Array();
				for (i = 0; i < json.length; i++) {
					if (json[i]['category']) {
						if (!category[json[i]['category']]) {
							category[json[i]['category']] = new Array();
							category[json[i]['category']]['name'] = json[i]['category'];
							category[json[i]['category']]['item'] = new Array();
						}
						category[json[i]['category']]['item'].push(json[i]);
					}
				}
				for (i in category) {
					html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';
					for (j = 0; j < category[i]['item'].length; j++) {
						html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
					}
				}
			}
			if (html) {
				this.show();
			} else {
				this.hide();
			}
			$(this.element).siblings('ul.dropdown-menu').html(html);
		}
	};

	$.fn.autocomplete1 = function(option) {
		return this.each(function() {
			var data = $(this).data('autocomplete');
			if (!data) {
				data = new Autocomplete1(this, option);
				$(this).data('autocomplete', data);
			}
		});
	}
})(window.jQuery);
$(document).ready(function() {
	var selector = '#search<?php echo $module ?>';
	var total = 0;
	var show_image = <?php echo ($show_image==1)?'true':'false';?>;
	var show_price = <?php echo ($show_price==1)?'true':'false';?>;
	var search_sub_category = true;
	var search_description = true;
	var width = 102;
	var height = 102;

	$(selector).find('input[name=\'search\']').autocomplete1({
		delay: 500,
		source: function(request, response) {
			var category_id = $(".category_filter select[name=\"category_id\"]").first().val();
			if(typeof(category_id) == 'undefined')
				category_id = 0;
			var limit = <?php echo $limit;?>;
			var search_sub_category = search_sub_category?'&sub_category=true':'';
			var search_description = search_description?'&description=true':'';
			$.ajax({
				url: 'index.php?route=module/pavautosearch/autocomplete&filter_category_id='+category_id+'&width='+width+'&height='+height+'&limit='+limit+search_sub_category+search_description+'&filter_name='+encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						if($('.pavautosearch_result')){
							$('.pavautosearch_result').first().html("");
						}
						total = 0;
						if(item.total){
							total = item.total;
						}
						return {
							price:   item.price,
							speical: item.special,
							tax:     item.tax,
							label:   item.name,
							image:   item.image,
							link:    item.link,
							value:   item.product_id,
							sprice:  show_price,
							simage:  show_image,
						}
					}));
				}
			});
		},
	}); // End Autocomplete 

});// End document.ready

</script>