
<main>
<div class="title">
	<h2><?php echo lang("Choose Payment Option")?></h2>
</div>
<form class="form-horizontal" method="post">

 <?php //foreach ($types as $type) {?>
  <div class="form-group fg">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
			<label class="col-xs-12 col-sm-9 col-md-9 col-lg-9"> 

			<input type="radio" name="type" value="1" /><?php echo lang("PayPal");?>
    </label>
		</div>
	</div>

	  <div class="form-group fg">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
				<label class="col-xs-12 col-sm-9 col-md-9 col-lg-9"> 

          <input type="radio" name="type" value="2" /><?php echo lang("Bank Transfer");?>
	    </label>
			</div>
		</div>
                
	  <div class="form-group fg">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
				<label class="col-xs-12 col-sm-9 col-md-9 col-lg-9"> 

          <input type="radio" name="type" value="3" /><?php echo lang("Credit Card");?>
	    </label>
			</div>
		</div>
                  <?php // }?>

 <div class="form-group">
		<label for="" class="col-sm-3 control-label"></label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<button class="btn-orange" type="submit"><?php echo lang("Continue")?></button>
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
</script>