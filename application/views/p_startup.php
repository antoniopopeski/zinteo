<div id="homepage"
	style="position: absolute; width: 100%; height =100%; cursor: auto; color: white;"
	class="leftcss">
	<img
		src="<?php echo "http://graph.facebook.com/".$user->fb_id."/picture?type=large";?>"
		style="display: block; margin-left: auto; margin-right: auto; margin-top: 50px; height: 70px; width: 70px;">
	<span
		style="text-align: center; display: block; margin-top: 10px; font-size: 17px; text-transform: uppercase; font-weight: bold;">Welcome <?php echo $user->fname.' '.$user->lname; ?></span>
	<span
		style="text-align: center; display: block; color: fff; text-transform: uppercase">your<?php echo ($oblozi == 0)?' starting':''?> balance is <?php echo $info->serenje//$user->saldo ?> points.</span>
	<span
		style="font-size: 25px; text-align: center; display: block; color: #fad705; margin-top: 20px; text-transform: uppercase">you
		have</span> <span
		style="font-size: 30px; text-align: center; display: block; color: #fad705; font-weight: bold; text-transform: uppercase"><?php echo (int)$user->bids + (int)$user->tmpBids; ?> bet<?php echo ((int)$user->bids + (int)$user->tmpBids > 1)?'s':''; ?> for today</span>
	<div id="table" style="margin-top: 15px; z-index: 5;"></div>
	<!-- <button class="ui-link" style="display: block; margin-left: auto; margin-right: auto; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; background: #313131; color: #FFF; border: none; text-align: center; width: 190px; height: 24px; margin-top:10px; padding-top: 3px;">Want to bet other match?</button> -->
	<a href="<?php echo base_url('matches/all'); ?>" class="ui-link"
		style="display: block; margin-left: auto; margin-right: auto; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; background: #313131; color: #FFF; border: none; text-align: center; width: 190px; height: 24px; margin-top: 10px; padding-top: 3px;">Want
		to bet other match?</a> <span
		style="font-size: 20px; text-align: center; display: block; margin-top: 10px; color: fff; text-transform: uppercase; font-weight: bold;">all
		bets are money free</span> <span
		style="font-size: 15px; text-align: center; display: block; color: fff; text-transform: uppercase">now.
		tomorrow. forever.</span>
</div>
<div id="placebet" class="leftcss" style="display:none;">
	<div style="color: #fff; display: block; font-size: 16px;">Your bet: <select id="range">
		<?php for ($i=1;$i<=round($user->saldo/10); $i++):?><option<?php 
		echo($i==round($user->saldo/10))?' selected="selected"':''?> value="<?php echo $i; ?>"><?php 
		echo $i;?></option><?php endfor;?>
	</select><!-- <div id="range" 
	style="width: 70px; display: inline-block;margin: 0px 20px;"></div><div id="vlozeno" style="display: inline-block;"><?php
	echo round($user->saldo/10);?></div> --></div>
	<span>You have <?php echo $user->bids + (int)$user->tmpBids;?> remaining bets for today</span>
	<img id="submit" src="<?php echo base_url();?>images/placebet.png" height="50" width="288" style="margin-top: 10px;">
</div>
<form id="target" action="<?php echo base_url()."matches/bets/"; ?>"
	method="post" style="display: none;">
	<input name="natprevariArray" id="natprevariArray" type="text">
		<input name="tipoviArray" id="tipoviArray" type="text">
		<input name="ulog" id="ulog" type="text" value="<?php echo round($user->saldo/10);?>">
		<input name="koeficientiArray" id="koeficientiArray" type="text">
</form>
<div id="dialog" title="Select tip"></div>
<script type="text/javascript">
$.ajax({
	url: "<?php echo base_url('pajax/getRandomMatch');?>",
	type: "POST",
	data: {tiper: <?php echo $user->id; ?>},
	success: function(data)
	{
		$('#table').html(data);
		setupNatprevari();
	}
});
$('.ui-link').click(function(){
	$.ajax({
		url: "<?php echo base_url('pajax/getRandomMatch');?>",
		type: "POST",
		data: {tiper: <?php echo $user->id; ?>},
		success: function(data)
		{
			$('#table').html(data);
		}
	});
});
$("#range").change(function(){
	var broj = parseInt($(this).val());
	$("#ulog").val(broj);
});

/*slider({
	value: <?php echo round($user->saldo/10);?>,
	min: 1,
	max: <?php echo round($user->saldo/10);?>,
	slide: function( event, ui ) {
		$( "#ulog" ).val( ui.value );
		$( "#vlozeno" ).html( ui.value );
	}
});*/
</script>