
<main>
<div class="title">
	<h2><?php echo lang("Login/Register")?></h2>
</div>

<form class="form-horizontal" method="post">
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php
		echo lang ( "My e-mail address is" )?>:</label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<input type="email" class="form-control" name="email" id="email"
				placeholder="">
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
		<label class="col-xs-12 col-sm-9 col-md-9 col-lg-9"> <input
			type="radio" name="userexist" id="new-user" checked="checked"> <?php echo lang("I'm a new customer you will create password later")?>
		</label>
	</div>
	
	<div style="padding-top:0px;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
    <label class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
     <input type="radio" name="userexist" / value="1" id="existing-user"><?php echo lang("I'm returning custommer and my password is")?>:</input>
    </label>
 	</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
    <label class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
       <input type="password" 	name="password" class="form-control" disabled="disabled" 	id="password" placeholder="Password">
    </label>
 </div>
	<?php if ($errors) {?>
		<div style="padding-top:0px;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox">
    <label class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
     <h3 class="warning"><?php echo $errors?></h3>
    </label>
 	</div>
	<?php }?>
	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 checkbox submit">
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
			<button id="button-login" class="btn-orange left" type="submit" style="margin: 10px auto 13px;"><?php echo lang("Register")?></button>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
		<a href="<?php echo base_url()?>user/users/forgotpassword"><?php echo lang("Forgot your password? Click here")?> </a>
	</div>


</form>
</main>




