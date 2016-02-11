<?php $themeName = basename( dirname(dirname(dirname(__FILE__))) ); ?>

<?php if (!isset($redirect)) { ?>
<div class="checkout-product">
	<table class="table">
		<thead class="hidden-phone">
			<tr>
				<td class="name"><?php echo $column_name; ?></td>
				<td class="model"><?php echo $column_model; ?></td>
				<td class="quantity"><?php echo $column_quantity; ?></td>
				<td class="price"><?php echo $column_price; ?></td>
				<td class="total"><?php echo $column_total; ?></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($products as $product) { ?>
			
			<?php if($product['recurring']): ?>
			<tr>
			    <td colspan="6" style="border:none;"><image src="catalog/view/theme/<?php echo $themeName;?>/image/reorder.png" alt="" title="" style="float:left;" /><span style="float:left;line-height:18px; margin-left:10px;"> 
			        <strong><?php echo $text_recurring_item ?></strong>
			        <?php echo $product['profile_description'] ?>
			    </td>
			</tr>
			<?php endif; ?>

			<tr>
				<td class="name">
					<span class="phone hidden-desktop hidden-tablet"><?php echo $column_name; ?></span>
					<div class="avg-right">
						<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
						<?php foreach ($product['option'] as $option) { ?>
						<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
						<?php } ?>
						
						<?php if($product['recurring']): ?>
						<br />
						&nbsp;<small><?php echo $text_payment_profile ?>: <?php echo $product['profile_name'] ?></small>
						<?php endif; ?>

					</div>
				</td>
				<td class="model">
					<span class="phone hidden-desktop hidden-tablet"><?php echo $column_model; ?></span>
					<span class="avg-right"><?php echo $product['model']; ?></span>
				</td>
				<td class="quantity">
					<span class="phone hidden-desktop hidden-tablet"><?php echo $column_quantity; ?></span>
					<span class="avg-right"><?php echo $product['quantity']; ?></span>
				</td>
				<td class="price">
					<span class="phone hidden-desktop hidden-tablet"><?php echo $column_price; ?></span>
					<span class="avg-right"><?php echo $product['price']; ?></span>
				</td>
				<td class="total">
					<span class="phone hidden-desktop hidden-tablet"><?php echo $column_total; ?></span>
					<span class="avg-right"><?php echo $product['total']; ?></span>
				</td>
			</tr>
			<?php } ?>
			<?php foreach ($vouchers as $voucher) { ?>
			<tr>
				<td class="name"><?php echo $voucher['description']; ?></td>
				<td class="model"></td>
				<td class="quantity">1</td>
				<td class="price"><?php echo $voucher['amount']; ?></td>
				<td class="total"><?php echo $voucher['amount']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<?php foreach ($totals as $total) { ?>
				<tr>
					<td colspan="4" class="price">
						<b><?php echo $total['title']; ?>:</b>
					</td>
					<td class="total">
						<?php echo $total['text']; ?>
					</td>
				</tr>
			<?php } ?>
		</tfoot>
	</table>
</div>

<div class="payment clearfix"><?php echo $payment; ?></div>

<?php } else { ?>

<script type="text/javascript">
	<!--
	location = '<?php echo $redirect; ?>';
	//-->
</script> 
	
<?php } ?>