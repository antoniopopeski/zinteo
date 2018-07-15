<h1><?php echo $title;?></h1>
<form id="the_form" action="<?php echo base_url()."admin_users/promeni/".$user->id;?>" method="post">
	<div class="pole">
		<div class="labeler" style="width: 25%;">Username <span style="color: red;">*</span></div>
		<div class="elements">
			<input type="text" name="user[username]" value="<?php echo $user->username;?>">
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
			<input type="text" name="user[fname]" value="<?php echo $user->fname;?>">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="width: 25%;">Last name</div>
		<div class="elements">
			<input type="text" name="user[lname]" value="<?php echo $user->lname;?>">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="width: 25%;">e-mail</div>
		<div class="elements">
			<input type="text" name="user[email]" class="email" value="<?php echo $user->email;?>">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="width: 25%;">Type of user <span style="color: red;">*</span></div>
		<div class="elements">
			<input id="radio1" type="radio" name="user[uloga]" value="1"
			<?php echo ($user->uloga==1)?'checked="checked"':'';?>>
			<label for="radio1">User</label>
			<input id="radio2" type="radio" name="user[uloga]" value="2"
			<?php echo ($user->uloga==2)?'checked="checked"':'';?>>
			<label for="radio2">Administrator</label>
			<input id="radio3" type="radio" name="user[uloga]" value="3"
			<?php echo ($user->uloga==3)?'checked="checked"':'';?>>
			<label for="radio3">Super administrator</label>
		</div>
	</div>
	<div class="pole">
		<div class="elements"><input type="submit" class="submit" value="UPDATE USER" /></div>
	</div>
	<input type="hidden" name="id" value="<?php echo $user->id;?>">
</form>
<script type="text/javascript">
$('#the_form').validate({
    rules: {
    	"user[username]": {
            required: true,
            minlength: 4 },
        "user[password]": {
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
            minlength: jQuery.format("Minimum {0} characters")
        },
        "user[fname]": {
            required: "Enter first name for the user",
            minlength: jQuery.format("Minimum {0} characters")
        }
    }
});
</script>