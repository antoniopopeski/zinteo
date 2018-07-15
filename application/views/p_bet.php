<div id="youjustbet" class="leftcss">
	<h1>YOU JUST BET!</h1>
	<?php echo $message; 
	if(isset($fbmessage)):
	if(!isset($login_url)):
	?>
	<div style="background-color: #fff; padding: 20px 0px;">
		<form action="<?php echo base_url()."matches/postiraj"; ?>" method="post">
			<input type="hidden" name="message" value="<?php echo $fbmessage; ?>">
			<input type="submit" id="publish" value="">
		</form>
		<h3 style="color: #000;">AND EARN</h3>
		<h2 style="color: #000; margin-top: 0px; margin-bottom: 20px;">ONE MORE MATCH FOR BET TODAY</h2>
		<a href="<?php echo base_url("matches/all"); ?>">I don’t want to publish on Facebook. Give me back to list of all matches</a>
	</div>
	<?php 
	else:?>
		<a href="<?php echo $login_url;?>">We need permissions to publish on your timeline!</a>	
	<?php 
	endif;
	else: ?>
	<div id="balans_footer" style="margin-bottom: 45px;">
		<img id="button" style="cursor: pointer;"
			src="<?php echo base_url('images/invitefriends.png');?>">
	</div>
	<?php endif;?>
</div>
<script>
FB.init({
	appId  : '<?php echo (isset($fbinfo) && $fbinfo)?$fbinfo:"648648968491961";?>',
	status : true,
	cookie : true,
	frictionlessRequests: true, 
	oauth: true,
	//xfbml  : false
});
function snimiPokani(response) {
	$.ajax({
		url: "<?php echo base_url('ajax/pokaneti');?>",
		type: "POST",
		data: {"data": response},
		error: function()
		{
			$('#rezultat').html("error");
		},
		success: function(data)
		{
			$('#rezultat').html(data);
		}
	});
}
function pokani()
{
	FB.ui({
	method: 'apprequests',
	filters: ['app_non_users'],<?php
	if(isset($vekjePokaneti))
	{
		echo "exclude_ids : [".$vekjePokaneti."],";
	} ?>
	/*display: 'popup',*/
	data: <?php echo $user->fb_id; ?>,
	message: "I'm playing betting game, will you join me and win some awesome prizes..",
	// redirect_uri: "<?php echo base_url('fblogin');?>"
	}, snimiPokani);
	var viewportWidth = $(window).width();
	if(viewportWidth < 651)
		$('iframe').width('100%');
}
$('#button').click(function(){
	pokani();
});
</script>