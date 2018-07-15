<form action="<?php echo base_url(); ?>login/logiranje" method="post">
	<label for="username">Username: </label><br />
	<input type="text" name="username" value="<?php echo $username;?>" id="username" /><br />
	<label for="password">Password: </label><br />
	<input type="password" name="password" value="" id="password" /><br />
	<input type="submit" value="Login in" />
</form>
<?php
echo $login_errors;
?>
<script type="text/javascript">
$(function(){
});
</script>