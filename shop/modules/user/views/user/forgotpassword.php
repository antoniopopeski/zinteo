
<main>
<div class="title">
	<h2><?php echo lang("Forgot password")?></h2>
</div>

<?php if ($error) {?>
<h3><?php echo $error?></h3>
<?php }?>

<?php if ($password_change == 0) {?>
<form class="form-horizontal" method="post">
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php
		echo lang ( "My e-mail address is" )?>:</label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<input type="email" class="form-control" name="email" id="email"
				placeholder="">
		</div>
	</div>


	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox submit">
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" style="padding:0;">
			<button id="button-login" class="btn-orange left" type="submit"><?php echo lang("Request new password")?></button>
		</div>
	</div>



</form>


<?php } else {?>
<p><?php echo lang("We have sent you link to change your password.")?></p>
<p><?php echo lang("Please check your email ..")?></p>
<?php }?>


</main>

<script>
	$(function(){
		$(".header").find("ul").hide();
	})
	</script>



