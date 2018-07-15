<div id="header">
	<img id="showLeftPush" class="" alt="logo" src="<?php echo base_url();?>images/finteo_logo.png">
	<span><?php echo (isset($title))?$title:''; ?></span>
	<?php if(isset($user)):?>
	<div class="maxTipovi"><?php echo (int)$user->bids + (int)$user->tmpBids; ?></div>
	<?php endif;?>
</div>