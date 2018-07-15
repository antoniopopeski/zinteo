<div id="container" class="leftcss" 
	style="padding: 24px; text-align: justify; font-size: 16px; line-height: 20px;">
<strong>ENTER A PROMOTIONAL CODE</strong><br><br>
<form method="post" action="<?php base_url('promo');?>">
	<input type="text" name="code" width="200">
	<input type="submit" value="SEND">
</form><br><br>
<?php if(isset($poraka)):?>
<span>You will receive <strong><?php echo $bonus;?></strong> bonus bids from the code from the next day to <?php echo $poraka; ?></span>
<?php endif;?>
<?php if(isset($error)):?>
<span style="color: red;"><?php echo $error;?></span>
<?php endif;?>
</div>