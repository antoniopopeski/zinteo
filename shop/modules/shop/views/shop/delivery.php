<?php $num_delivery_address = count($deliveryaddress)?>
<main>


<div class="title">
            <h2><?php echo lang("Delivery/Invoice Address")?></h2>
            <h5><?php echo lang("Delivery Address")?></h5>
            <?php if ($num_delivery_address >= 1) {?>
	    <h4><?php echo lang("Please choose one of the previously entered delivery addresses")?></h4>
	    <?php }?>
        </div>

<form class="form-horizontal" method="post">        
<?php $count_addr = 1;?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 boxs">
<?php foreach ($deliveryaddress as $da) {?>
   <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
       <div class="address">
           <p><?php echo $da->firstname . " " . $da->lastname?></p>
			<p><?php echo $da->street . " " . $da->streetno?></p>
			<p><?php echo Cities::find(array('id'=>$da->city))->getCity()?>, <?php echo $da->zip?>, <?php echo Countries::find(array('id'=>$da->country))->getCountry()?></p>
			<input type="radio" value="<?php echo $da->id?>"
				<?php echo ($count_addr == 1) ? "checked='checked'" : ""?>
				name="selected_delivery_address">
       </div>
    </div>
     <?php $count_addr++;?>
<?php }?>  
</div>
<?php if ($num_delivery_address >= 1) {?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 boxs">
<a id="add-delivery-address" href="#" style="text-decoration:underline;"><?php echo lang("Or, enter new delivery address")?></a>

</div>
<?php }?>
<div id="please-enter-new-delivery-address" style="display:none" class="form-group">
    <label class="col-sm-3 control-label" for=""></label>
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
      <h4><?php echo lang("Please enter new delivery address")?></h4>
    </div>
  </div>






	<div id="new-delivery-address"
		<?php echo ($num_delivery_address > 0) ? 'style="display:none"' : ''?>>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label"><?php echo lang("First Name")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" name="firstname" 
					id="firstname" placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="LastName" class="col-sm-3 control-label"><?php echo lang("Last Name")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" id="lastname" 
					name="lastname" placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="street" class="col-sm-3 control-label"><?php echo lang("Street")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" id="street" name="street" 	placeholder="">			
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label"><?php echo lang("Street No.")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" id="streetno" 
					name="streetno" placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="zipcode" class="col-sm-3 control-label"><?php echo lang("Zip-Code")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="number" class="form-control" name="zip" id="zip" placeholder="" >
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label"><?php echo lang("Country")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<select class="form-control" name="country" id="country">
						<?php foreach ($countries as $c) {?>
						<option value="<?php echo $c->getId();?>" <?php if($c->getCountry()=='Germany') echo "selected";?>><?php echo $c->getCountry()?></option>
						<?php }?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="city" class="col-sm-3 control-label"><?php echo lang("City")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<select class="form-control" name="city" id="city">
						<option value="0">-</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="telefon" class="col-sm-3 control-label"><?php echo lang("Telefon")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="number" class="form-control" name="phone" id="phone"	placeholder="">
			</div>
		</div>


	</div>


 <h5 style="  color: #543912;
    display: inline-block;
    font-size: 17px !important;
    font-weight: 700;
    padding-top: 30px;
    width: 100%;"><?php echo lang("Invoice Address")?></h5>
 <div class="form-group" style="margin:0px;">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
         <input	name="invoiceaddress" value="1" type="radio" checked="checked"><?php echo lang("Invoice Address is same as delivery address")?>
    </label>
  </div>

 <div class="form-group" style="margin:0px!important; padding:0px;">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
     <input	name="invoiceaddress" value="2" type="radio"><?php echo lang("Or, enter new invoice address")?>
    </label>
</div>
</div>





	<div id="new-invoice-address" style="display: none">
	<div class="form-group">
	    <label for="" class="col-sm-3 control-label"></label>
	    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
	      <h4><?php echo lang("Please enter invoice address")?></h4>
	    </div>
	  </div>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label"><?php echo lang("First Name")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" name="firstname_i" 
					id="firstname_i" placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="LastName" class="col-sm-3 control-label"><?php echo lang("Last Name")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" id="lastname_i" 
					name="lastname_i" placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="street" class="col-sm-3 control-label"><?php echo lang("Street")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" id="street_i" 
					name="street_i" placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label"><?php echo lang("Street No.")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" id="streetno_i" 
					name="streetno_i" placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="zipcode" class="col-sm-3 control-label"><?php echo lang("Zip-Code")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"> 
				<input type="number" class="form-control" name="zip_i" id="zip_i" 
					placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label"><?php echo lang("Country")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<select class="form-control" name="country_i" id="country_i">
						<?php foreach ($countries as $c) {?>
						<option value="<?php echo $c->getId();?>" <?php if($c->getCountry()=='Germany') echo "selected";?>><?php echo $c->getCountry()?></option>
						<?php }?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="city" class="col-sm-3 control-label"><?php echo lang("City")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" name="city_i" id="city_i" placeholder="" >
			</div>
		</div>
		<div class="form-group">
			<label for="telefon" class="col-sm-3 control-label"><?php echo lang("Telefon")?></label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="number" class="form-control" name="phone_i" id="phone_i" 
					placeholder="">
			</div>
		</div>


	</div>

	<div class="form-group">
		<label for="" class="col-sm-3 control-label"></label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<button class="btn-orange" type="submit"><?php echo lang("Continue")?></button>
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

$("input[name='invoiceaddress']").click(function(){
	var clicked_val = $(this).val();

	if (clicked_val == 1) {
		$("#new-invoice-address").hide();
		$("#firstname_i").attr("required", false);
		$("#lastname_i").attr("required", false);
		$("#street_i").attr("required", false);
		$("#streetno_i").attr("required", false);
		$("#zip_i").attr("required", false);
		$("#city_i").attr("required", false);
		$("#country_i").attr("required", false);
		$("#phone_i").attr("required", false);
	} 
	if (clicked_val == 2) {
		$("#new-invoice-address").show();

		$("#firstname_i").attr("required", true);
		$("#lastname_i").attr("required", true);
		$("#street_i").attr("required", true);
		$("#streetno_i").attr("required", true);
		$("#zip_i").attr("required", true);
		$("#city_i").attr("required", true);
		$("#country_i").attr("required", true);
		$("#phone_i").attr("required", true);
	}
});

$("#add-delivery-address").click(function(e){
	e.preventDefault();
	var visible = $("#new-delivery-address").toggle();

	if ($("#new-delivery-address").is(":visible")) {
		$("input[name='selected_delivery_address']").attr('checked',false);
		$("#please-enter-new-delivery-address").show();

		$("#firstname").attr("required", true);
		$("#lastname").attr("required", true);
		$("#street").attr("required", true);
		$("#streetno").attr("required", true);
		$("#zip").attr("required", true);
		$("#city").attr("required", true);
		$("#country").attr("required", true);
		$("#phone").attr("required", true);
		$("#add-delivery-address").text('<?php echo lang("I will use current delivery address");?>');
	} else {
		$("#please-enter-new-delivery-address").hide();

		$("input[name='selected_delivery_address']:first").attr('checked','checked');

		$("#firstname").attr("required", false);
		$("#lastname").attr("required", false);
		$("#street").attr("required", false);
		$("#streetno").attr("required", false);
		$("#zip").attr("required", false);
		$("#city").attr("required", false);
		$("#country").attr("required", false);
		$("#phone").attr("required", false);
		$("input:radio[name=selected_delivery_address]").attr('checked', 'checked');
		$("input:radio[name=selected_delivery_address]").click();
		$("#add-delivery-address").text('<?php echo lang("Or, enter new delivery address");?>');
	}
	


})

$("#country").on('change', function(){
	var cid = $(this).val();
	$.ajax({
	    url : '/shop/shop/a_getCities',
	    type : 'post',
	    data : 'countryid=' + cid,
	    success : function(res){
	       
	        $('#city').find('option').remove().end();
	        $('#count').val(0);
	        
	        var products = $.parseJSON(res); 
	       
	        var options;
	        // $("#city").append($('<option>', {value:0, text:'-'}));
	        $.each(products, function(k, v){
	            
	            options =  $('<option>').val(v.id).text(v.city);
	            $(options).appendTo($("#city"));
	        });
	   
	    },
	    error : function(err) {
	        console.log(err);
	    }
	});
}).trigger('change');
</script>
