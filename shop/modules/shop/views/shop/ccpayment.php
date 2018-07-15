<main>
<div class="title">
	<h2><?php echo lang("Please input your credit card details")?></h2>
</div>
<?php if($errors){?>
	<h3 class="warning"><?php 
	$field=explode('.', $errors['field']);
	$field=end($field);
	$field=str_replace('_', ' ', $field);
	$field=ucfirst($field); 
	echo $field.": ".$errors['issue'];?></h3>
<?php }?>
<form class="form-horizontal" method="post">

  <div class="form-group fg">
	<label class="col-sm-3 control-label" for="">Card type</label>
 <?php 
 $cc=array("visa", "mastercard", "amex", "discover", "maestro");
foreach ($cc as $c) {?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox" style="<?php if($c=='visa') echo "margin-top: -20px;";?> ">
			<label class="col-xs-12 col-sm-9 col-md-9 col-lg-9"> 
			<input type="radio" name="cc_type" value="<?php echo $c;?>" /><?php echo ucfirst($c);?>
    </label>
		</div>
<?php }?>
	</div> 

<div class="form-group"> <label class="col-xs-12 col-sm-9 col-md-9 col-lg-9"></label></div>
<div class="form-group">
			<label class="col-sm-3 control-label" for="">First Name</label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-5">
				<input type="text" placeholder="ex. Joe" id="cc_firstname" name="cc_firstname" class="form-control" required="required" value="<?php if(isset($_SESSION['cc_firstname'])) { echo $_SESSION['cc_firstname'];}?>">
			</div>
</div>

<div class="form-group">
			<label class="col-sm-3 control-label" for="LastName">Last Name</label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-5">
				<input type="text" placeholder="ex. Shopper" name="cc_lastname" id="cc_lastname" class="form-control" required="required" value="<?php if(isset($_SESSION['cc_lastname'])) { echo $_SESSION['cc_lastname'];}?>">
			</div>
</div>

<div class="form-group">
			<label class="col-sm-3 control-label" for="LastName">Credit Card number</label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-5">
				<input type="text" placeholder="ex. 1234567890123456" name="cc_number" id="cc_number" class="form-control" required="required" maxlength="19">
			</div>
</div>

<div class="form-group">
			<label class="col-sm-3 control-label" for="LastName">Expiration</label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-2">
				<select name="cc_exp_month" id="cc_exp_month" class="form-control" required="required" maxlength="2">
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>
			</div>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-2">
				<select name="cc_exp_year" id="cc_exp_year" class="form-control" required="required" maxlength="4">
					<option value="2015">2015</option>
					<option value="2016">2016</option>
					<option value="2017">2017</option>
					<option value="2018">2018</option>
					<option value="2019">2019</option>
					<option value="2020">2020</option>
					<option value="2021">2021</option>
					<option value="2022">2022</option>
					<option value="2023">2023</option>
					<option value="2024">2024</option>
					<option value="2025">2025</option>
				</select>
			</div>
</div>

<div class="form-group">
			<label class="col-sm-3 control-label" for="LastName">CVV</label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-2">
				<input type="text" placeholder="ex. 158" name="cc_cvv" id="cc_cvv" class="form-control" required="required" maxlength="3">
			</div>
</div>

 <div class="form-group">
		<label for="" class="col-sm-3 control-label"></label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<button class="btn-orange" onclick="return check();" type="submit"><?php echo lang("Pay now")?></button>
		</div>
	</div>



</form>
</main>
<script type="text/javascript">
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
		if (!$("input[name='cc_type']:checked").val()) {
		   alert('You must select credit card type!');
			return false;
		} else {
			if($("#cc_firstname").val()=='' || $("#cc_lastname").val()=='' || $("#cc_number").val()=='' || $("#cc_exp_month").val()=='' || $("#cc_exp_year").val()=='' || $("#cc_cvv").val()==''){
		  		alert('All the fields are required!');
				return false;
			} else {
				return true;
			}
		} 
		return true;
	}

	$('#cc_number').keyup(function()
	{
	    $(this).val(function(i, v)
	    {
	        var v = v.replace(/[^\d]/g, '').match(/.{1,4}/g);
	        return v ? v.join('-') : '';
	    });
	});
</script>