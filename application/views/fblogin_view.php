<div id="login_header" class="leftcss">
	<img src="<?php echo base_url('images/logo_finteo.png');?>" alt="logo" id="showLeftPush"> <img
		src="<?php echo base_url('images/football_player.png');?>" alt="logo" id="showLeftPush"
		style="margin-top: 15px;">
	<h1
		style="color: #ffdc0a; font-size: 1.1em; font-weight: bold; text-align: center; margin-left: 30px; margin-right: 30px; margin-top: -5px; line-height: 90%;">EARN
		REAL MONEY FROM BETTING</h1>
	<h2
		style="color: #fff; font-size: 0.9em; font-weight: bold; text-align: center; margin-left: 30px; margin-right: 30px; margin-top: -5px; line-height: 90%;">BY
		PLACING MONEY FREE BETS</h2>
	<h3
		style="color: #fff; font-size: 0.6em; text-align: center; font-weight: normal; margin-left: 30px; margin-right: 30px; margin-top: 10px; line-height: 90%;">START
		YOUR ZINTEO JOURNEY NOW</h3>
	<a href="<?php echo $login_url ?>"><img
		src="<?php echo base_url('images/login_fb.png');?>" alt="logo"
		id="showLeftPush" style="width: 245px; margin-top: 0px;"></a>
</div>
<script>
$(function(){
	setTimeout(function() { window.scrollTo(0, 1); }, 100);
});
$(window).load(function(){
	var viewportWidth = $(window).width();
	if(viewportWidth > 400)
	{
		$('body').css('overflow','auto');
	}
	else
	{
		$('body').css('width','100%');
		$('#podvizno').css('width','100%');
		$('#footer').css('width','100%');
		$('#balans_footer').css('width','100%');
	}
});
</script>