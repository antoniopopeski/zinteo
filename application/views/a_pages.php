<select id="selector">
	<!-- <option>New page</option> -->
	<?php foreach($lista as $t):?>
	<option value="<?php echo $t->id;?>"><?php echo $t->naslov;?></option>
	<?php endforeach;?>
</select>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<br><br>
<form id="the_form"
	action="<?php echo base_url(); ?>admin_pages" method="post">
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
		url: '<?php echo base_url()."ajax/page";?>'
	});
});
function applyEditor(){
	var editor = CKEDITOR.instances["sodrzina"];
    if (editor) { editor.destroy(true); }
	CKEDITOR.replace('sodrzina',
	    {
	        filebrowserBrowseUrl : '<?php echo base_url();?>js/ckfinder/ckfinder.html',
	        filebrowserImageBrowseUrl : '<?php echo base_url();?>js/ckfinder/ckfinder.html?Type=Images',
	        filebrowserFlashBrowseUrl : '<?php echo base_url();?>js/ckfinder/ckfinder.html?Type=Flash',
	        filebrowserUploadUrl : '<?php echo base_url();?>js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	        filebrowserImageUploadUrl : '<?php echo base_url();?>js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	        filebrowserFlashUploadUrl : '<?php echo base_url();?>js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
		    enterMode : CKEDITOR.ENTER_BR,
	        shiftEnterMode: CKEDITOR.ENTER_P
	    });
}
$.ajax({
	type: 'POST',
	data: {'id': 0},
	success: function(data){
		$('#target').html(data);
		applyEditor();
	},
	url: '<?php echo base_url()."ajax/page";?>'
});
</script>