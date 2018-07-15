<select id="selector">
<!-- <option>New page</option> -->
	<?php foreach($lista as $t):?>
	<option value="<?php echo $t->id;?>"><?php echo $t->greska;?></option>
	<?php endforeach;?>
</select>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<br><br>
<form id="the_form"
	action="<?php echo base_url(); ?>admin_poraki" method="post">
<div id="target">
</div>
</form>
<script type="text/javascript">
$('#selector').change(function(){
	$.ajax({
		type: 'POST',
		data: {'id':$(this).val()},
		success: function(data){
			$('#target').html(data);
			applyEditor();
		},
		url: '<?php echo base_url()."ajax/poraki";?>'
	});
});
$.ajax({
	type: 'POST',
	data: {'id':$('#selector').val()},
	success: function(data){
		$('#target').html(data);
		applyEditor();
	},
	url: '<?php echo base_url()."ajax/poraki";?>'
});
</script>