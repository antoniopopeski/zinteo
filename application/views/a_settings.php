<h2>Settings</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<form method='post' action='<?php echo base_url(); ?>admin_settings/promeni'>
<div class='pole'>
	<div class='labeler'>Maximum number of tipper to follow</div>
	<div class='elements'>
		<input type='text' name='settings[sledi]' value='<?php echo $settings->sledi;?>'>
	</div>
</div>
<div class='pole'>
	<div class='labeler'>Number of tipper needed to join after invitation to get bonus bids</div>
	<div class='elements'>
		<input type='text' name='settings[pokani]' value='<?php echo $settings->pokani;?>'>
	</div>
</div>
<div class='pole'>
	<div class='labeler'>Maximum number of favorite sports per tipper</div>
	<div class='elements'>
		<input type='text' name='settings[favsport]' value='<?php echo $settings->favsport;?>'>
	</div>
</div><!-- 
<div class='pole'>
	<div class='labeler'>Maximum number of favorite championships per tipper</div>
	<div class='elements'>
		<input type='text' name='settings[favsampionat]' value='<?php echo $settings->favsampionat;?>'>
	</div>
</div> -->
<div class='pole'>
	<div class='labeler'>Maximum number of favorite teams per tipper</div>
	<div class='elements'>
		<input type='text' name='settings[favtim]' value='<?php echo $settings->favtim;?>'>
	</div>
</div>
<div class='pole'>
	<div class='labeler'>Maximum number of tippers taken for recomended matches</div>
	<div class='elements'>
		<input type='text' name='settings[top]' value='<?php echo $settings->top;?>'>
	</div>
</div>
<div class='pole'>
	<div class='labeler'>Normal bonus temporary bids per post on Facebook</div>
	<div class='elements'>
		<input type='text' name='settings[objava]' value='<?php echo $settings->objava;?>'>
	</div>
</div>
<div class='pole'>
	<div class='labeler'>Number of days for matches to fetch</div>
	<div class='elements'>
		<input type='text' name='settings[recent]' value='<?php echo $settings->recent;?>'>
	</div>
</div>
<div class='pole'>
	<div class='labeler'></div>
	<div class='elements'>
		<input type='submit' value='Submit'>
	</div>
</div>
</form>
<script type='text/javascript'>
$('form').validate({
	rules: {
		'settings[sledi]': {required: true},
		'settings[pokani]': {required: true},
		'settings[favsport]': {required: true},
		'settings[favsampionat]': {required: true},
		'settings[favtim]': {required: true},
		'settings[objava]': {required: true}
	},
	messages: {
		'settings[sledi]': {required: 'This field is required'},
		'settings[pokani]': {required: 'This field is required'},
		'settings[favsport]': {required: 'This field is required'},
		'settings[favsampionat]': {required: 'This field is required'},
		'settings[favtim]': {required: 'This field is required'},
		'settings[objava]': {required: 'This field is required'}
	}
});
</script>