<?php echo $header; ?>

<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<?php if ($success) { ?>
	<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons">
				<a id="button-save" class="button"><?php echo $button_save; ?></a>
				<a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href="http://braiv.zendesk.com?src=omfa" target="_blank"><?php echo $text_help; ?></a>
			</div>
		</div>
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<input type="hidden" id="store_id" name="store_id" value="<?php echo $store_id; ?>" />
				<div id="tab-omframework">

					<div id="tabs_omframework" class="htabs">
			<a href="#tab-omframework-general"><?php echo $tab_omframework_general; ?></a>
			<a href="#tab-omframework-customization"><?php echo $tab_omframework_customization; ?></a>
			<a href="#tab-omframework-adv-customization"><?php echo $tab_omframework_adv_customization; ?></a>
			<a href="#tab-omframework-patcher"><?php echo $tab_omframework_patcher; ?></a>
			<?php // --- BASIC ?>
			<a href="#tab-omframework-modules"><?php echo $tab_omframework_modules; ?></a>
			<?php // --- /BASIC ?>

					</div>

					<div id="tab-omframework-general">
					<?php // --- BASIC ?>
						<table>
							<tr class="general">
								<td>
					<?php // --- /BASIC ?>
								<table class="form">
									<tr>
								<td valign=top><?php echo $entry_mobile_theme; ?></td>
								<td>
			<?php if (defined('VERSION') && (version_compare(VERSION, '1.5.5', '<') == true)) { ?>
									<select name="config_mobile_theme"
									<?php // --- BASIC -------------------------- ?>
									disabled="disabled"
									<?php // --- /BASIC -------------------------- ?>
									>
										<?php foreach ($mobile_themes as $template) { ?>

										<option value="<?php echo $template; ?>"><?php echo $template; ?></option>

										<?php } ?>
									</select>
			<?php } else { ?>
				<select name="config_mobile_theme" onchange="$('#mobile_template').load('index.php?route=setting/setting/template&token=<?php echo $token; ?>&template=' + encodeURIComponent(this.value));"
					<?php // --- BASIC -------------------------- ?>
					disabled="disabled"
					<?php // --- /BASIC -------------------------- ?>
					>
									<?php foreach ($mobile_themes as $template) { ?>
									<?php if ($template == $config_mobile_theme) { ?>
									<option value="<?php echo $template; ?>" selected="selected"><?php echo $template; ?></option>
									<?php } else { ?>
									<option value="<?php echo $template; ?>"><?php echo $template; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
			<?php } ?>
				</td>
							</tr>
							<tr>
								<td></td>
								<td id="mobile_template"></td>
							</tr>

							<tr>
								<td valign=top><?php echo $entry_mobile_disable_site_for; ?></td>
								 <td>
										<input type="checkbox" name="config_mobile_tablets" value="1" <?php if ($config_mobile_tablets){echo 'checked';}; ?> size="3" />
									</td>
							</tr>

			<tr>
				<td valign=top><?php echo $entry_mobile_disable_omf; ?></td>
				<td>
					<input type="checkbox" name="config_mobile_disable_omf" value="1" <?php if (isset($config_mobile_disable_omf)){echo 'checked';}; ?> size="3" />
				</td>
			</tr>

			<tr>
				<td valign=top><?php echo $entry_wishlist_activation; ?>:</td>
				<td>
					<input type="checkbox" name="config_wishlist_disabled" value="1" <?php if ($config_wishlist_disabled){echo 'checked';}; ?> size="3" />
				</td>
			</tr>
			<tr>
				<td valign=top><?php echo $entry_mobile_disable_addtocart_outofstock; ?>:</td>
				<td>
					<input type="checkbox" name="config_disable_addtocart_outofstock" value="1" <?php if ($config_disable_addtocart_outofstock){echo 'checked';}; ?> size="3"
					<?php // --- BASIC -------------------------- ?>
					disabled="disabled"
					<?php // --- /BASIC -------------------------- ?>
					/>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_mobile_frontpage_cat_list; ?></td>
				<td><?php echo $entry_mobile_count; ?> &nbsp;&nbsp;<input type="text" name="config_mobile_front_page_cat_list" value="<?php echo $config_mobile_front_page_cat_list; ?>" size="3" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="config_mobile_display_top_cats" value="1" <?php if ($config_mobile_display_top_cats){echo 'checked';}; ?>> <?php echo $entry_mobile_display_top_cats; ?></td>
			</tr>

						</table>
					<?php // --- BASIC ?>
					</td>
					<td class="banner" valign="top">
						<a href="http://omframework.com/upgrade-lite?src=omfab" target="_blank"><img src="view/image/omfa/banner.png" alt="" /></a>
					</td>
				</tr>
			</table>
			<?php // --- /BASIC ?>

					</div>

		<div id="tab-omframework-customization" style="position: relative; overflow-x: hidden;">
			<?php // --- BASIC -------------------------- ?>
			<div class="overlay">
				<div>
					<p><?php echo $text_upgrade; ?></p>
					<a href="http://omframework.com/upgrade-lite?src=omfatc" target="_blank"><?php echo $text_compare_versions; ?></a>
        		</div>
      		</div>
      		<img src="view/image/omfa/customization.png" />
      		<?php // --- /BASIC ----------------------- ?>
					</div>

		<div id="tab-omframework-adv-customization" style="position: relative; overflow-x: hidden;">
			<?php // --- BASIC -------------------------- ?>
			<div class="overlay">
				<div>
					<p><?php echo $text_upgrade; ?></p>
					<a href="http://omframework.com/upgrade-lite?src=omfatac" target="_blank"><?php echo $text_compare_versions; ?></a>
        		</div>
      		</div>
      		<img src="view/image/omfa/advanced_customization.png" />
      		<?php // --- /BASIC ----------------------- ?>
		</div>

			<div id="tab-omframework-patcher" style="position: relative; overflow-x: hidden;">
			<?php // --- BASIC -------------------------- ?>
			<div class="overlay">
				<div>
					<p><?php echo $text_upgrade; ?></p>
					<a href="http://omframework.com/upgrade-lite?src=omfatp" target="_blank"><?php echo $text_compare_versions; ?></a>
        		</div>
      		</div>
      		<img src="view/image/omfa/compatibility.png" />
      		<?php // --- /BASIC ----------------------- ?>
					</div>

				
					<div id="tab-omframework-modules" style="position: relative; overflow-x: hidden;">
						<?php // --- BASIC -------------------------- ?>
			<div class="overlay">
				<div>
					<p><?php echo $text_upgrade; ?></p>
					<a href="http://omframework.com/upgrade-lite?src=omfatm" target="_blank"><?php echo $text_compare_versions; ?></a>
        		</div>
      		</div>
      		<img src="view/image/omfa/modules.png" />
      		<?php // --- /BASIC ----------------------- ?>
					</div>
					
				</div>
			</form>
		</div>
	</div>

<link type="text/css" rel="stylesheet" href="view/javascript/colorpicker/jquery.miniColors.css" />
<script type="text/javascript" src="view/javascript/colorpicker/jquery.miniColors.js" ></script>

<script type="text/javascript"><!--
$(document).ready( function() {
	// Enabling miniColors
	$('.color-picker').miniColors({
		letterCase: 'uppercase'
	});

	loadStoreSettings(<?php echo $store_id; ?>, '');
});

function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('\
		<div id="dialog" style="padding: 3px 0px 0px 0px;">\
			<iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto">\
			</iframe>\
		</div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
		if ($('#' + field).attr('value')) {
			$.ajax({
				url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
				<?php if (defined('VERSION') && (version_compare(VERSION, '1.5.2', '<') == true)) { ?>
				data: {
					image: $('#' + field).val()
				},
				type: 'POST',
				<?php } ?>
				dataType: 'text',
				beforeSend: function () {
					$('#' + thumb).attr('src','view/image/loading.gif');
				},
				success: function(data) {
					//console.log(data);
					$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
				}
			})
				}
		},
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};

function populate(json) {
	$('input[type=\'checkbox\']').not('[name="patches[]"]').removeAttr('checked');
	//$('input[type=\'checkbox\']').removeAttr('checked');

	$.each(json, function(key, value) {
		if (key == 'mobile_logo')
	{
		$('#thumb-mobile-logo').attr('src',json['mobile_logo']);
		}
	else if (key != 'new_store' )
	{
		var $formElement = $('[name="'+key+'"]');
		if ($formElement.get(0).tagName == 'INPUT')
		{
			switch($formElement.attr("type")) {
				case "text" :

				case "hidden":
				  $formElement.attr("value", value);
			  break;

			  case "checkbox":
				  if(value > 0) $formElement.attr("checked","checked");
			  break;
		  }
		}
		else if ($formElement.get(0).tagName == 'SELECT')
		{
			var found = false;

			for (var i in $formElement.get(0).options)
			{
				if ($formElement.get(0).options[i].value == value)
				{
					$formElement.get(0).selectedIndex = i;
					found = true;
					break;
				}
			}

			if ( ! found && key == 'config_mobile_theme') // if new theme is created, add it to the options and load it
			{
				$formElement.append('<option selected="selected" value="'+value+'">'+value+'</option>');
				$formElement.trigger("change");
			}
		} else if ($formElement.get(0).tagName == 'TEXTAREA') {
			$formElement.val(value);
		}
		}

	});

	$('#mobile_template').load('index.php?route=setting/setting/template&token=<?php echo $token; ?>&template=' + encodeURIComponent($('select[name=\'config_mobile_theme\']').attr('value')));

	$('.color-picker').each(function() {
		$(this).trigger('keyup.miniColors');
	});

}

function jsonify(formSet, mobile_logo) {
	var a = formSet.serializeArray()
	var json = {};

	for (var i in a) {
	if (a[i].name == 'patches[]') continue; // skip patches
		json[a[i].name] = a[i].value;
	}

	json['mobile_logo'] = mobile_logo;

	json['config_mobile_custom_styles'] = json['config_mobile_custom_styles'].replace(/[\r\n\t]/g,'');

	return json;
}

function loadStoreSettings(store_id, store_name)
{
//console.log("loadStoreSettings store_id: "+ store_id +"\n store_name: "+ store_name);
	$.ajax({
		type:"GET",
		url: 'index.php?route=module/omfa/load&token=<?php echo $token; ?>&store_id=' + encodeURIComponent(store_id),
		dataType: 'json',
		beforeSend: function() {},
		success: function(json) {
			$('#dialog').dialog('close');
			$('#store_name').remove();
			$('#store_id').val(store_id);
			if (store_name != '')
			{
				$('h1').append('<span id="store_name">&ensp;&ndash;&ensp;' + store_name + '</span>');
			}
			
			populate(json);

		}
	});
}


$('#button-save').click(function() {

	$.ajax({
		type:"POST",
		url: 'index.php?route=module/omfa/save&token=<?php echo $token; ?>&store_id='+ encodeURIComponent($("#store_id").val()),
		dataType: 'json',
		data: $('input[type=\'text\'], input[type=\'hidden\'], input[type=\'checkbox\']:checked, select, textarea, .image img.attr(\'src\')'),
		beforeSend: function() {
			$('.box').before('<div class="attention"><img src="view/image/loading.gif" alt="" /></div>');
		},
		success: function(json) {
		if(json.success) {
			$('.attention').remove();
			$('.box').before('<div class="success" style="display: none;">' + json['success'] + '</div>');
			$('.success').fadeIn('slow');
			$('.error').remove();
		}
		else if(json.error)
		{
			$('.attention, .error').remove();
			$('.box').before('<div class="warning error" style="display: none;">' + json['error'] + '</div>');
			$('.error').fadeIn('slow');
		}
		},
		complete: function() {
			setTimeout(function () {
				$('.success').fadeOut('slow').remove();
			}, 8000);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#tabs_omframework a').tabs();

$('[name=\'config_mobile_theme\']').change(function() {

	$('#mobile_template').load('index.php?route=setting/setting/template&token=<?php echo $token; ?>&template=' + encodeURIComponent(this.value));

	$.ajax({
		type:"GET",
		url: 'index.php?route=module/omfa/loadTheme&token=<?php echo $token; ?>&theme=' + encodeURIComponent(this.value),
		dataType: 'json',
		success: function(json) {
			$('input[type=\'checkbox\']').removeAttr('checked');
			$.each(json, function(key, value) {
				var $formElement = $('[name="'+key+'"]');
				if ($formElement.get(0).tagName == 'INPUT')
				{
					switch($formElement.attr("type")) {
						case "text" :
						$formElement.attr("value", value);
						break;
						case "checkbox":
						$formElement.attr("checked","checked");
						break;
					}
				} else if ($formElement.get(0).tagName == 'TEXTAREA') {
					$formElement.val(value);
				}
			});

			$('.color-picker').each(function() {
				$(this).trigger('keyup.miniColors');
			});
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//-->

<?php if (defined('VERSION') && (version_compare(VERSION, '1.5.2', '<') == true)) { ?>
$("a.button").wrapInner("<span>"); // fix for v. 1.5.1 buttons
<?php } ?>
</script>


<?php //} ?>

<?php // --- BASIC ?>
<style>
	.banner {
		padding: 0 20px;
		width: 270px;
	}

	.banner h2 {
		border-bottom: none !important;
	}

	#mobile_template img {
		max-width: 100%;
	}

	.general > td:first-child {
		width: 100%;
	}

	.overlay {
		position: absolute;
		top: 0;
		bottom: 0;
		width: 100%;
		opacity: 0.85;
		background: #FFFFFF;
	}

	.overlay div {
		position: fixed;
		bottom: 50%;
		left: 0;
		right: 0;
		width: 100%;
		margin-left: auto;
		margin-right: auto;
		text-align: center;
		font-size: 24px;
		-webkit-user-select: none;
	}

	.overlay a {
		background: black;
		color: white;
		text-decoration: none;
		padding-top: 0.4em;
		padding-bottom: 0.4em;
		padding-left: 0.8em;
		padding-right: 0.8em;
		border-radius: 0.125em
	}

</style>
<?php // --- /BASIC ?>
<?php echo $footer; ?>