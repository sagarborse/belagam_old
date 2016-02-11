<?php echo $header; ?>
<div id="main" role="main">
	<?php echo $content_top; ?>
	<ul id="breadcrumbs">
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
	<?php } ?>
	</ul>
	<h1><?php echo $heading_title; ?></h1>
	<div class="product-info">
		<?php // --- BASIC --------------------------------------------------- ?>
		<?php if ($thumb || $images) { ?>
		<section id="images">
			<?php if ($thumb) { ?>
			<a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img id="thumb" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
			<?php } ?>
			<?php if ($images) { ?>
			<div class="image-additional">
				<?php foreach ($images as $image) { ?>
				<a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" rel="additional images"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
				<?php } ?>
			</div>
			<?php } ?>
		</section>
		<?php } ?>
		<?php // --- /BASIC --------------------------------------------------- ?>


		<table class="description">
			<?php if ($manufacturer) { ?>
			<tr><th><?php echo $text_manufacturer; ?></th><td><a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></td></tr>
			<?php } ?>
			<tr><th><?php echo $text_model; ?></th><td><?php echo $model; ?></td></tr>
			<?php if ($reward) { ?>
			<tr><th><?php echo $text_reward; ?></th><td><?php echo $reward; ?></td></tr>
			<?php } ?>
			<tr><th><?php echo $text_stock; ?></th><td><?php echo $stock; ?></td></tr>
		</table>
		<?php if ($price) { ?>
		<div class="price">
			<?php echo $text_price; ?>
			<?php if (!$special) { ?>
			<?php echo $price; ?>
			<?php } else { ?>
			<del class="price-old"><?php echo $price; ?></del> <strong class="price-new"><?php echo $special; ?></strong>
			<?php } ?>
			<?php if ($tax) { ?>
			<span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
			<?php } ?>
			<?php if ($points) { ?>
			<p class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></p>
			<?php }
			?>
			<?php if ($discounts) { ?>
			<table class="discount">
				<?php foreach ($discounts as $discount) { ?>
				<tr>
					<th><?php echo sprintf($text_discount, $discount['quantity'], '');?></th>
					<td><?php echo $discount['price'];?></td>
				</tr>
				<?php } ?>
			</table>
			<?php }
			?>
		</div>
		<?php } ?>


<?php if (defined('VERSION') && (version_compare(VERSION, '1.5.2', '<') == true)) { ?>
		<form action="index.php?route=checkout/cart/update" method="post">
<?php } else { ?>
		<form action="index.php?route=checkout/cart/add" method="post">
<?php } ?>
			<?php if ($options) { ?>
			<section id="options">
				<h2><?php echo $text_option; ?></h2>
				<?php foreach ($options as $option) { ?>
				<?php if ($option['type'] == 'select') { ?>
				<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
					<?php if ($option['required']) { ?>
					<span class="required">*</span>
					<?php } ?>
					<b><?php echo $option['name']; ?>:</b>
					<select name="option[<?php echo $option['product_option_id']; ?>]">
						<option value=""><?php echo $text_select; ?></option>
						<?php foreach ($option['option_value'] as $option_value) { ?>
						<option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
						<?php if ($option_value['price']) { ?>
						(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
						<?php } ?>
						</option>
						<?php } ?>
					</select>
				</div>
				<?php }
				?>
				<?php if ($option['type'] == 'radio') { ?>
				<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
					<?php if ($option['required']) { ?>
					<span class="required">*</span>
					<?php } ?>
					<b><?php echo $option['name']; ?>:</b>
					<?php foreach ($option['option_value'] as $option_value) { ?>
					<label for="option-value-<?php echo $option_value['product_option_value_id']; ?>">
					<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
					<?php echo $option_value['name']; ?>
					<?php if ($option_value['price']) { ?>
					(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
					<?php } ?>
					</label>
					<?php } ?>
				</div>
				<?php }
				?>
				<?php if ($option['type'] == 'checkbox') { ?>
				<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
					<?php if ($option['required']) { ?>
					<span class="required">*</span>
					<?php } ?>
					<b><?php echo $option['name']; ?>:</b>
					<?php foreach ($option['option_value'] as $option_value) { ?>
					<label for="option-value-<?php echo $option_value['product_option_value_id']; ?>">
					<input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
					<?php echo $option_value['name']; ?>
					<?php if ($option_value['price']) { ?>
					(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
					<?php } ?>
					</label>
					<?php } ?>
				</div>
				<?php }
				?>
				<?php if ($option['type'] == 'image') { ?>
				<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
					<?php if ($option['required']) { ?>
					<span class="required">*</span>
					<?php } ?>
					<b><?php echo $option['name']; ?>:</b>
					<table class="option-image">
						<?php foreach ($option['option_value'] as $option_value) { ?>
						<tr>
							<td style="width: 1px;">
								<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
							</td>
							<td>
								<label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label>
							</td>
							<td>
								<label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
								<?php if ($option_value['price']) { ?>
								(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
								<?php } ?>
								</label>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php }
				?>
				<?php if ($option['type'] == 'text') { ?>
				<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
					<?php if ($option['required']) { ?>
					<span class="required">*</span>
					<?php } ?>
					<b><?php echo $option['name']; ?>:</b>
					<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
				</div>
				<?php }
				?>
				<?php if ($option['type'] == 'textarea') { ?>
				<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
					<?php if ($option['required']) { ?>
					<span class="required">*</span>
					<?php } ?>
					<b><?php echo $option['name']; ?>:</b>
					<textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
				</div>
				<?php }
				?>
				<?php if ($option['type'] == 'file') { ?>
		        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
		          <?php if ($option['required']) { ?>
		          <span class="required">*</span>
		          <?php } ?>
		          <b><?php echo $option['name']; ?>:</b>
		          <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
		          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
		        </div>
        		<?php } ?>
				<?php if ($option['type'] == 'date') { ?>
				<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
					<?php if ($option['required']) { ?>
					<span class="required">*</span>
					<?php } ?>
					<b><?php echo $option['name']; ?>:</b>
					<input type="date" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
				</div>
				<?php }
				?>
				<?php if ($option['type'] == 'datetime') { ?>
				<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
					<?php if ($option['required']) { ?>
					<span class="required">*</span>
					<?php } ?>
					<b><?php echo $option['name']; ?>:</b>
					<input type="datetime" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
					</div>
				<?php }
				?>
				<?php if ($option['type'] == 'time') { ?>
				<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
					<?php if ($option['required']) { ?>
					<span class="required">*</span>
					<?php } ?>
					<b><?php echo $option['name']; ?>:</b>
					<input type="time" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
				</div>
				<?php } ?>
				<?php if(isset($errors[$option['product_option_id']])) echo '<span class="s-error">'. $errors[$option['product_option_id']] .'</span>';?>
				<?php } ?>
			</section>
			<?php }
			?>
			<div class="cart">
				<?php echo $text_qty; ?>
				<input type="number" name="quantity" size="2" value="<?php echo $minimum; ?>"  min="<?php echo $minimum; ?>" />
				<input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
			</div>
			<?php if ($minimum > 1) { ?>
			<div class="minimum"><?php echo $text_minimum; ?></div>
			<?php } ?>
		</form>


	<?php if ( is_null($this->config->get('config_wishlist_disabled')) or (bool)$this->config->get('config_wishlist_disabled') == false) { ?>
		<form action="index.php?route=account/wishlist/update" method="post">
			<input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
			<input id="wishlist-button" type="submit" value="<?php echo $button_wishlist; ?>" />
		</form>
	<?php } ?>

		<?php /* if ($review_status) { ?>
		<div class="review">
			<img src="catalog/view/theme/default/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $reviews; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $text_write; ?></a>
		</div>
		<?php } */?>
	</div>

	<?php $current_page = $breadcrumbs[count($breadcrumbs) - 1]; ?>
	<section id="description" class="panel">
		<h2><?php echo $tab_description; ?></h2>
		<div class="panel-content">
			<?php echo $description; ?>
			<a href="<?php echo $current_page['href']; ?>#description"><?php echo $text_close; ?></a>
		</div>
	</section>
	<?php if ($attribute_groups) { ?>
	<section id="attribute" class="panel">
		<h2><?php echo $tab_attribute; ?></h2>
		<div class="panel-content">
			<table class="attribute">
				<?php foreach ($attribute_groups as $attribute_group) { ?>
				<thead>
					<tr>
					<td colspan="2"><?php echo $attribute_group['name']; ?></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
					<tr>
						<td><?php echo $attribute['name']; ?></td>
						<td><?php echo $attribute['text']; ?></td>
					</tr>
					<?php } ?>
				</tbody>
				<?php } ?>
			</table>
			<a href="<?php echo $current_page['href']; ?>#attribute"><?php echo $text_close; ?></a>
	</div>
	</section>
	<?php }
	?>
	<?php if ($review_status) { ?>
  	<section id="reviews" class="panel">
  		<h2><?php echo $tab_review; ?></h2>
    	<div class="panel-content">
    		<div id="review"></div>
    		<h3 id="review-title"><?php echo $text_write; ?></h3>
    		<form>
    			<ul>
    				<li>
    					<label>* <?php echo $entry_name; ?></label>
			    		<input type="text" name="name" value="" />
			    	</li>
			    	<li>
			    		<label>* <?php echo $entry_review; ?></label>
			    		<textarea name="text" cols="40" rows="8"></textarea>
			    		<span><?php echo $text_note; ?></span>
			    	</li>
			    	<li>
				    	<label>* <?php echo $entry_rating; ?></label>
				    	<?php echo $entry_bad; ?>
					    <input type="radio" name="rating" value="1" />
					    <input type="radio" name="rating" value="2" />
					    <input type="radio" name="rating" value="3" />
					    <input type="radio" name="rating" value="4" />
					    <input type="radio" name="rating" value="5" />
					    <?php echo $entry_good; ?>
				    </li>
				    <li>
			    		<label>* <?php echo $entry_captcha; ?></label>
			    		<input type="text" name="captcha" value="" />
					    <span class="captchaImage"><img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br /></span>
					</li>
				    <input type="submit" id="button-review" value="<?php echo $button_continue; ?>" />
			  	</ul>
			</form>
			<a href="<?php echo $current_page['href']; ?>#reviews"><?php echo $text_close; ?></a>
    	</div>
  </section>
  <?php } ?>
	<?php if ($products) { ?>
	<section id="related" class="panel">
		<h2><?php echo $tab_related; ?> (<?php echo count($products); ?>)</h2>
		<div class="panel-content">
			<ul class="product-list">
				<?php foreach ($products as $product) { ?>
				<li>
					<?php if ($product['thumb']) { ?>
					<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a>
					<?php } ?>
					<a href="<?php echo $product['href']; ?>" class="name"><?php echo $product['name']; ?></a>
					<?php if ($product['price']) { ?>
					<div class="price">
						<?php if (!$product['special']) { ?>
						<?php echo $product['price']; ?>
						<?php } else { ?>
						<del class="price-old"><?php echo $product['price']; ?></del> <strong class="price-new"><?php echo $product['special']; ?></strong>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($product['rating']) { ?>
					<img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" class="rating">
					<?php } ?>

				</li>
				<?php } ?>
			</ul>
			<a href="<?php echo $current_page['href']; ?>#related"><?php echo $text_close; ?></a>
		</div>
	</section>
	<?php } ?>
	<?php if ($tags) { ?>
	<div class="tags">
		<b><?php echo $text_tags; ?></b>
		<?php foreach ($tags as $tag) { ?>
		<a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a>,
		<?php } ?>
	</div>
	<?php } ?>
	<?php echo $content_bottom; ?>
</div>


<!-- This shouldn't be here. We are doing the same in the footer. -->
<script src="catalog/view/theme/omf/js/jq.mobi.min.js" type="text/javascript" ></script>
<script>window.$ = window.jq;</script>


<script type="text/javascript">
/*$('#review .pagination a').live('click', function() {
	$('#review').slideUp('slow');

	$('#review').load(this.href);

	$('#review').slideDown('slow');

	return false;
});			*/

$.get("index.php?route=product/product/review&product_id=<?php echo $product_id; ?>",function(data){
         $('#review').html(data);
      });

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#review-title').after('<div class="warning">' + data.error + '</div>');
			}

			if (data.success) {
				$('#review-title').after('<div class="success">' + data.success + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});

<?php if ( is_null($this->config->get('config_wishlist_disabled')) or (bool)$this->config->get('config_wishlist_disabled') == false) { ?>
$("#wishlist-button").on("click", function(e){

	e.preventDefault();
	var product_id = $("input[name='product_id']").val();

	$.ajax({
		<?php if (defined('VERSION') && (version_compare(VERSION, '1.5.2', '<') == true)) { ?>
			url: 'index.php?route=account/wishlist/update',
		<?php } else { ?>
			url: 'index.php?route=account/wishlist/add',
		<?php } ?>
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();

			if (json['success']) {
				var message_type = ( json.success.indexOf('Success') != -1 ? 'success' : 'warning' );
				$("#wishlist-button").after('<div class="'+message_type+'">' + json.success + '</div>')
				//$("."+ message_type).fadeOut(1000)
				$('#wishlist_total').html(json['total']);
			}
		}
	});
})
<?php } ?>
</script>

<?php if ($options) { ?>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
  action: 'index.php?route=product/product/upload',
  name: 'file',
  autoSubmit: true,
  responseType: 'json',
  onSubmit: function(file, extension) {
    $('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
    document.querySelector('#button-option-<?php echo $option['product_option_id']; ?>').setAttribute('disabled', true);
  },
  onComplete: function(file, json) {
    $('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
    
    $('.error').remove();
    
    if (json['success']) {
      alert(json['success']);
      
      document.querySelector('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').setAttribute('value', json['file']);
    }
    
    if (json['error']) {
      $('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
    }
    
    $('.loading').remove(); 
  }
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>

<?php echo $footer; ?>