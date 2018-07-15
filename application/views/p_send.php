<div id="container" class="leftcss" 
	style="padding: 24px; text-align: justify; font-size: 16px; line-height: 20px;">
	<div class="sodrzina">
		<?php if(!isset($error) || $error != "The message was sent to your friend"): ?>
		<form method="post">
			<label style="display: block;" for="email">Friend's email</label>
			<input style="display: block; width: 100%;" id="email" name="email" value="" type="email"><br>
			<label style="display: block;" for="subject">Subject</label>
			<input style="display: block; width: 100%;" id="subject" name="subject" value="<?php
				echo $default_subject;?>"><br>
			<label style="display: block;" for="message">Message</label>
			<textarea style="display: block; width: 100%;" rows="5" name="message" id="message"><?php 
				echo $default_message;?></textarea><br>
			<input type="submit" value="Send">
		</form>
		<span><?php echo (isset($error))?$error:'';?></span>
		<?php else: 
		echo $error; ?>
		<br><a class="zolto" href="<?php echo base_url("matches/all")?>">Continue...</a>
		<?php endif;?>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace('message', {
	toolbar : 'Basic'
});
</script>