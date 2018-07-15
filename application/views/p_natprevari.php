<div id="filter">
	<select class="filter" id="sport_id">
		<option value="0">All sports</option>
	<?php foreach($activeSports as $s):?>
		<option value="<?php echo $s->id;?>" <?php echo ($s->id==$sport_id)?'selected="selected"':'';?>><?php
			echo $s->ime; ?></option>
	<?php endforeach;?>
	</select><!-- 
	<select class="filter" id="liga_id">
		<option value="0">All championships</option>
	<?php foreach($activeLeagues as $s):?>
		<option value="<?php echo $s->id; ?>"><?php echo $s->ime; ?></option>
	<?php endforeach;?>
	</select>
	
	<select class="filter">
		<option></option>
	</select> -->
</div>
<div id="container" class="leftcss">	
	<div id="table"><?php foreach ($lista as $t): ?>
		<div class="matchDiv">
			<input type="hidden" id="match_id" value="<?php echo $t->id; ?>">
			<div id="pocetok"><p><?php 
			$serverZona = 'Europe/Skopje';
			$polok = $this->uri->segment(2);
			$denes = new DateTime("now", new DateTimeZone($serverZona));
			$utre = new DateTime("now", new DateTimeZone($serverZona));
			$utre->modify('+1 day');
			$datum = new DateTime($t->pocetok, new DateTimeZone($serverZona));
			$datum->setTimezone(new DateTimeZone($user->timezone));
			if($denes->format("Y-m-d")==$datum->format("Y-m-d"))
				echo "Today, ".$datum->format("H:i");
			elseif($utre->format("Y-m-d")==$datum->format("Y-m-d"))
				echo "Tomorrow, ".$datum->format("H:i");
			else 
				echo $datum->format("d M, H:i");// ' Y'
			?></p></div>
			<div class="match">
				<div class="home<?php echo (isset($t->tip) && $t->tip=="1")?' tipperSelected':'';
				?>">
					<?php if(file_exists('./images/teams/item_'.$t->domasniID.'.png')):?>
					<img src="<?php echo base_url();?>images/teams/item_<?php echo $t->domasniID; ?>.png" id="hometeam">
					<?php endif;?>
					<input type="hidden" id="koeficient" value="<?php echo $t->home; ?>">
					<span class="tim"><?php echo $t->domasni; ?></span>
					<span class="koeficient"><?php 
						echo number_format($t->home, 2, ',','.'); ?></span>
				</div><?php if($t->draw == 1): ?>
				<div class="drawHolder"></div><?php else:?>
				<div class="draw<?php echo (isset($t->tip) && $t->tip=="0")?' tipperSelected':'';
				?>">
					<span class="koeficient"><?php 
						echo number_format($t->draw, 2, ',','.'); ?></span><br>draw
					<input type="hidden" id="koeficient" value="<?php echo $t->draw; ?>">
				</div><?php endif;?>
				<div class="away<?php echo (isset($t->tip) && $t->tip=="2")?' tipperSelected':'';
				?>">
					<?php if(file_exists('./images/teams/item_'.$t->gostiID.'.png')):?>
					<img src="<?php echo base_url();?>images/teams/item_<?php echo $t->gostiID; ?>.png" id="awayteam">
					<?php endif;?>
					<input type="hidden" id="koeficient" value="<?php echo $t->away; ?>">
					<span class="tim"><?php echo $t->gosti; ?></span>
					<span class="koeficient"><?php 
						echo number_format($t->away, 2, ',','.'); ?></span>
				</div>
			</div>
			<?php if(isset($t->fname) || $t->more): ?>
			<div class="tipperInfo">
				<?php 
				if(isset($t->tip) && $t->tip != "0" && $t->tip != "1" && $t->tip != "2")
				{
					echo $t->fname."'s tip for this match: ";
					switch ($t->tip)
					{
						case "hf1":
							echo "1-1";
							break;
						case "hf2";
							echo "1-X";
							break;
						case "hf3":
							echo "1-2";
							break;
						case "hf4":
							echo "X-1";
							break;
						case "hf5":
							echo "X-X";
							break;
						case "hf6":
							echo "X-2";
							break;
						case "hf7":
							echo "2-1";
							break;
						case "hf8":
							echo "2-X";
							break;
						case "hf9":
							echo "2-2";
							break;
						case "g1":
							echo 'Goals 0 or 1';
							break;
						case "g2":
							echo 'Goals 2 or 3';
							break;
						case "g3":
							echo 'Goals 4 to 6';
							break;
						case 'Goals 7+':
							$pravTip = "g4";
							break;
						case "u":
							echo '0-2 Goals';
							break;
						case "o":
							echo '3+ Goals';
							break;
					}
					echo " (Odd: ".number_format($t->koeficient, 2, ',','.').")<br>";
				}
				if($polok=="following")
					$tttt = "following";
				else 
					$tttt = "top";
				echo (isset($t->fname))?'from '.$tttt.' tipper, #'.$t->rang.' '.$t->fname.' '.$t->lname.
						', B'.$t->saldo.'<br>':'';
				if($t->more):?>
				<button class="moreBtn">More</button>
				<?php endif;?>
			</div>
			<?php endif; ?>
		</div><?php endforeach;?>
	</div>
	<form id="target" action="<?php echo base_url()."matches/bets/"; ?>" method="post" style="display: none;">
		<input name="natprevariArray" id="natprevariArray" type="text">
		<input name="tipoviArray" id="tipoviArray" type="text">
		<input name="ulog" id="ulog" type="text" value="<?php echo round($user->saldo/10);?>">
		<input name="koeficientiArray" id="koeficientiArray" type="text">
	</form>
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
<div id="dialog" title="Select tip"></div>
<script type="text/javascript">
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
$('#sport_id').val('0');
$('#sport_id').change(function(){
	$.ajax({
		url: "<?php echo base_url('pajax/sampionati');?>",
		type: "POST",
		data: {id: $(this).val()},
		success: function(data)
		{
			$('#liga_id').html(data);
		}
	});
	$.ajax({
		url: "<?php echo base_url('pajax/'.$this->uri->segment(2));?>",
		type: "POST",
		data: {sport_id: $('#sport_id').val(), liga_id: $('#liga_id').val()},
		success: function(data)
		{
			$('#table').html(data);
			setupNatprevari();
		}
	});
});
$('#liga_id').change(function(){
	$.ajax({
		url: "<?php echo base_url('pajax/'.$this->uri->segment(2));?>",
		type: "POST",
		data: {sport_id: $('#sport_id').val(), liga_id: $('#liga_id').val()},
		success: function(data)
		{
			$('#table').html(data);
			setupNatprevari();
		}
	});
});
<?php if(isset($popup) && $popup):?>
alert('<?php echo $popup;?>');
<?php endif;?>
</script>