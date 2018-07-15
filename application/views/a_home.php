<h2>DASHBOARD</h2>
<form method="post" enctype="multipart/form-data" action="<?php 
	echo base_url("admin_home/picture");?>">
	<div class="pole">
		<?php echo ($settings->slika)?'Change the picture':'Set the picture';?>
		<input type="file" name="picture">
	</div>
	<div class="pole">
		<input type="submit" value="SUBMIT">
	</div>
</form>
<form method="post" enctype="multipart/form-data" action="<?php 
	echo base_url("admin_home/picture2");?>">
	<div class="pole">
		<?php 
		$filename = '/images/background.png';
		echo (file_exists($filename))?'Change the web background picture':'Set the web background picture';?>
		<input type="file" name="picture">
	</div>
	<div class="pole">
		<input type="submit" value="SUBMIT">
	</div>
</form>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>