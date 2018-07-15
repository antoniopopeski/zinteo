
<main>
<div class="title">
	<h2><?php echo lang("Registration")?></h2>
	    <h4><?php echo lang("New to Vetfriend24.com? Register Below.")?></h4><br>
	    <?php if(isset($errors)){ if($what=='email') {?><h3 class="warning"> <?php echo $errors;?> </h3><?php } } ?>
</div>

<form class="form-horizontal" method="post">

	<div class="form-group">
		<label for="email" class="col-sm-3 control-label"><?php echo lang("My e-mail address is")?>:</label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<input type="email" name="email"
				value="<?php echo isset($_SESSION['email_new_user']) ? $_SESSION['email_new_user'] : ''?>"
				class="form-control" id="email" placeholder="">
		</div>
	</div>
	<div class="form-group">
		<label for="Email" class="col-sm-3 control-label"><?php echo lang("Type e-mail address again")?>:</label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<input type="text" name="email_confirm" class="form-control" value="<?php echo isset($_POST['email_confirm']) ? $_POST['email_confirm'] : ""?>"
				id="email_confirm" placeholder="">
		</div>
	</div>
	<div style="margin-top: 30px;">
		<h4><?php echo lang("Protect your information with a password")?></h4>
		<span style="font-size: 12px; color: #9a8e80;"><?php echo lang("This will be your only Vetfriend password")?>.</span>
	    <?php if(isset($errors)){ if($what=='password') {?><h3 class="warning"> <?php echo $errors;?> </h3><?php } } ?>
		<div class="form-group">
			<label for="password" class="col-sm-3 control-label"><?php echo lang("Enter password")?>:</label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="password" name="password" class="form-control"
					id="password" placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="Email" class="col-sm-3 control-label"><?php echo lang("Enter password again")?>:</label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<input type="password" class="form-control" name="comfirm_password"
					id="comfirm_password"
			
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox submit">
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
			<button class="btn-orange left" type="submit"><?php echo lang("Create account")?></button>
		</div>
	</div>
</form>
</main>







