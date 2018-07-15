<h1><?php echo $title;?></h1>
<form id="the_form" action="<?php echo base_url(); ?>admin_users/dodadi" method="post">
	<div class="pole">
		<div class="labeler" style="width: 25%;">Username <span style="color: red;">*</span></div>
		<div class="elements">
			<input type="text" name="user[username]" value="">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="width: 25%;">Password <span style="color: red;">*</span></div>
		<div class="elements">
			<input type="password" name="user[password]" value="">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="width: 25%;">First name <span style="color: red;">*</span></div>
		<div class="elements">
			<input type="text" name="user[fname]" value="">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="width: 25%;">Last name</div>
		<div class="elements">
			<input type="text" name="user[lname]" value="">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="width: 25%;">e-mail</div>
		<div class="elements">
			<input type="text" name="user[email]" value="">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="width: 25%;">Type of user <span style="color: red;">*</span></div>
		<div class="elements">
			<input id="radio1" type="radio" name="user[uloga]" value="1" checked="checked">
			<label for="radio1">User</label>
			<input id="radio2" type="radio" name="user[uloga]" value="2">
			<label for="radio2">Administrator</label>
			<input id="radio3" type="radio" name="user[uloga]" value="3">
			<label for="radio3">Super administrator</label>
		</div>
	</div>
	<div class="pole">
		<div class="elements"><input type="submit" class="submit" value="ADD USER" /></div>
	</div>
</form>
<script type="text/javascript">
$('#the_form').validate({
    rules: {
    	"user[username]": {
            required: true,
            minlength: 4 },
        "user[password]": {
            required: true,
            minlength: 6 },
        "user[fname]": {
        	required: true,
        	minlength: 3 }
    },
    messages: {
    	"user[username]": {
            required: "Enter username",
            minlength: jQuery.format("Minimum {0} characters")
        },
        "user[password]": {
            required: "Enter password",
            minlength: jQuery.format("Minimum {0} characters")
        },
        "user[fname]": {
            required: "Enter first name for the user",
            minlength: jQuery.format("Minimum {0} characters")
        }
    }
});
</script>