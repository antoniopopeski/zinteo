
<main>
<div class="title">
	<h2><?php echo lang("Place Order")?></h2>
</div>
<form class="form-horizontal" method="post">


	<div class="form-group">
		<div class="content-order">
			<div class="title-price">
				<div class="subtitle"><?php echo $product->getName()?></div>
				<?php if ($_SESSION['currency'] == 'eur') {?>
				<div class="price">&euro; <?php echo $product->getEURPrice()?></div>
				<?php } elseif ($_SESSION['currency'] == 'gbp') {?>
				<div class="price">&pound; <?php echo $product->getGBPPrice()?></div>
				<?php } elseif($_SESSION['currency'] == 'pln') {?>
				<div class="price">PLN <?php echo $product->getPLNPrice()?></div>
				<?php }?>
				
				<?php if ($_SESSION['currency'] == 'eur') {?>
				
							<input type="hidden" name="price" id="price"
					value="<?php echo $product->getEURPrice()?>" /> <input
					type="hidden" name="total_price" id="total_price"
					value="<?php echo $product->getEURPrice()?>" />
					
					<input type="hidden" id="currency" name="currency" value="&euro;" />								
				<?php } elseif ($_SESSION['currency'] == 'gbp') {?>
				
								<input type="hidden" name="price" id="price"
					value="<?php echo $product->getGBPPrice()?>" /> <input
					type="hidden" name="total_price" id="total_price"
					value="<?php echo $product->getGBPPrice()?>" />
					
					<input type="hidden" id="currency" name="currency" value="&pound;" />		
				
				<?php } elseif($_SESSION['currency'] == 'pln') {?>
				
								<input type="hidden" name="price" id="price"
					value="<?php echo $product->getPLNrice()?>" /> <input
					type="hidden" name="total_price" id="total_price"
					value="<?php echo $product->getPLNrice()?>" />
				
				<input type="hidden" id="currency" name="currency" value="PLN" />		
				<?php }?>
				
	
			</div>
			<div class="image">
				<img src="<?php echo base_url()?><?php echo $product->getImage()?>"
					height="95%" width="95%" /> 
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					<a target="_blank" href="<?php echo base_url()?>shop/shop/product/<?php echo $product->getId()?>"><?php echo lang("Read description about the product")?></a>
					</div>
			</div>
			<div class="right-content">
				<span><?php echo lang("Quantity")?></span>
				<input type="number" name="quantity" id="quantity" style="width: 50px; display: inline-block; border-radius: 0px;" value="1">
				<div style="display: block; border-bottom: 1px solid #54390e;">
					<span class="span"><?php echo lang("Total Price")?></span> 
					
					
					<?php if ($_SESSION['currency'] == 'eur') {?>
				
					<span class="span" style="color: #ee9200;" id="total_price_val">&euro; <?php echo $product->getEurPrice()?></span>
								
				<?php } elseif ($_SESSION['currency'] == 'gbp') {?>
				
					<span class="span" style="color: #ee9200;" id="total_price_val">&pound; <?php echo $product->getGBPPrice()?></span>
				
				<?php } elseif($_SESSION['currency'] == 'pln') {?>
				
					<span class="span" style="color: #ee9200;" id="total_price_val">PLN <?php echo $product->getPLNPrice()?></span>
				
				<?php }?>
				
					
					
				</div>
				<div class="address-d">
			
					<div class="delivery-address">
						<h5><?php echo lang("Delivery Address")?></h5>
						<p><?php echo $deliveryaddress->getFirstName()?> <?php echo $deliveryaddress->getLastName()?></p>

						<p><?php echo $deliveryaddress->getStreet()?> <?php echo $deliveryaddress->getstreetno()?> </p>

						<p><?php echo Cities::find(array('id'=>$deliveryaddress->getCity()))->getCity();?>, <?php echo $deliveryaddress->getZip()?>, <?php echo Countries::find(array('id'=>$deliveryaddress->getCountry()))->getCountry();?></p>
					</div>
				
					
					<div class="invoice-address">
						<h5><?php echo lang("Invoice Address")?></h5>
						<p><?php echo $invoiceaddress->getFirstName()?> <?php echo $invoiceaddress->getLastName()?></p>

						<p><?php echo $invoiceaddress->getStreet()?> <?php echo $invoiceaddress->getstreetno()?>, </p>

						<p><?php echo Cities::find(array('id'=>$invoiceaddress->getCity()))->getCity();?>, <?php echo $invoiceaddress->getZip()?>, <?php echo Countries::find(array('id'=>$invoiceaddress->getCountry()))->getCountry();?></p>
					</div>
					
					</div>
					<div class="address-d">
					 <h5><?php echo lang("Delivery Type")?></h5>
					 <label><?php echo lang("One time only")?></label>
					 <input type="checkbox" name="deliveryinterval[]" value="One time only"><br>


					 <label><?php echo lang("Or every")?></label>
					    <select name="deliveryinterval[]" style="width:auto; display:inline-block;  border-radius: 0px;" class="form-control">
					  		
					  	<?php for($i=1;$i<13;$i++){?>
					  		<option value="<?php echo $i?>"><?php echo $i?></option>
					  	<?php }?>
					   </select>
					   <select name="deliveryinterval[]" style="width:auto; display:inline-block;  border-radius: 0px;" class="form-control">
					   	<option value="month"><?php echo lang("month")?></option>
					   	<option value="weeks"><?php echo lang("weeks")?></option>
					   </select>
					    </div>

					<div style="margin-top:20px!important;" class="form-group fg">
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
					    <label class="col-xs-12 col-sm-12vcol-md-12 col-lg-12">
					      <input name="agree_1" id="agree_1" type="checkbox"><?php echo lang("Agree to the 'AGB'")?>”
					    </label>
					 </div>
					</div>
				<div class="form-group fg">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
						<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <input
						 name="agree_2" id="agree_2"	type="checkbox"><?php echo lang("Agree to 'Widerrufsbelehrung'")?>
						</label>
					</div>
				</div>
				<div class="form-group fg">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
						<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <input
						name="agree_3"	id="agree_3" type="checkbox"><?php echo lang("Sign up for Newsletter")?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label"></label>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<button onclick="return check(); " class="btn-orange" type="submit"><?php echo lang("Place Order")?></button>
					</div>
				</div>

			</div>

		</div>
	</div>

</form>
</main>

<script>

$(".myaccount").click(function(e){
	e.preventDefault();
	$c = confirm("<?php echo lang("Are you sure to cancel payment process?")?>");

	if ($c == true )
	{
			window.location.href = "/shop/shop/myorders";
	}
	else 
	{
			return false;
	}
})

function check() {
	if ($('#agree_1').is(":checked") && $('#agree_2').is(":checked")) {
		return true
	} else {
		alert("<?php echo lang("You must agree with terms and conditions")?>");
		return false;
	}
}
$("#quantity").change(function(){
	var quantity = $(this).val();

	var price = $("#price").val();

	var currency = $("#currency").val();
	
	var total_price = parseFloat(quantity) * parseFloat(price);
	
	$("#total_price").val(parseFloat(total_price).toFixed(2));

	$("#total_price_val").html(currency + " " +parseFloat(total_price).toFixed(2));
})
</script>
