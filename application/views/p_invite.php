<div id="balans" class="leftcss">
	<div id="container" class="leftcss"
		style="padding: 24px; text-align: justify; font-size: 16px; line-height: 20px;">
		<div class="sodrzina"><?php echo html_entity_decode($page->tekst);?></div>
	</div>
	<div id="balans_footer">
		<span>NOW, YOU CAN BET <?php echo $startBids + (int)$user->tiperi_pokaneti;?> MATCHES PER DAY</span><img
			id="button" style="cursor: pointer;"
			src="<?php echo base_url('images/invitefriends.png');?>">
	</div>
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
	// filters: ['app_non_users'],<?php
	if(isset($vekjePokaneti))
	{
		echo "exclude_ids : [" . $vekjePokaneti . "],";
	}
	?>
	// display: 'popup',
	//display: 'touch',
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