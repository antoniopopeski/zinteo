YOU HAVE WON BET!

<div class="ime">
	<?php echo strtoupper($user->fname)."'S BALANCE";?>
</div>
<div class="balans">B<?php echo $user->saldo;?></div>
<div class="maxTipovi"><?php 
$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
$maxTipovi = $user->bids;
if($user->tmpDatum == $sega->format("Y-m-d"))
	$maxTipovi += $user->tmpBids;
echo $maxTipovi;?></div>
<hr>
<?php
if(count($oblozi)):
$brStr4 = ceil(count($oblozi)/3);
?>
<div class="slajder">
	<div class="natpis">MY BETS
		<div class="levo">
			<img src="<?php echo base_url();?>images/left.png">
		</div>
		<div class="mesto">1/<?php echo $brStr4;?></div>
		<div class="desno">
			<img src="<?php echo base_url();?>images/right.png">
		</div>
	</div>
	<div class="prozor">
		<div class="film" style="width: <?php echo 100.0*$brStr4; ?>%;">
			<div class="slajd" style="width: <?php echo 100.0/$brStr4; ?>%;">
				<?php
				$brm = 0;
				foreach($oblozi as $t):
					if($brm%3 == 0 && $brm > 0):
				?>
			</div>
			<div class="slajd" style="width: <?php echo 100.0/$brStr4; ?>%;">
				<?php endif;?>
					<div class="item <?php switch ($t->uspesen) {
						case '':
							echo "live";
						break;
						
						case '1':
							echo "win";
						break;
						
						default:
							echo "lose";
						break;
					}?>">
					<?php 
					/*
						[id] => 1 
						[datum] => 2013-04-29 22:46:51 
						[tip] => 1 
						[ulog] => 10 
						[koeficient] => 1.6 
						[uspesen] => 
						[domasni] => Golden State Warriors 
						[gosti] => Atlanta Hawks 
						[saldo] => 100 
						[domasni4] => 
						[gosti4] => 
						[pocetok] => 2013-04-30 16:00:00 
						[sampionat] => NBA
					*/
					echo '<span class="betTim">'.$t->domasni.'</span>';
					echo '<span class="betRez">'.$t->domasni4.'</span>';
					echo '<span class="betTim">'.$t->gosti.'</span>';
					echo '<span class="betRez">'.$t->gosti4.'</span>';
					echo '<span class="betTip">';
					switch ($t->tip) {
						case 1:
							echo $t->domasni;
							break;
					
						case 2:
							echo $t->gosti;
							break;
					
						default:
							echo "draw";
							break;
					}
					echo '-'.number_format($t->koeficient, 2, ',', '.').'</span>';
					echo '<span class="saldo">s';
					if($t->uspesen)
						echo $t->saldo + $t->ulog * $t->koeficient;
					else 
						echo $t->saldo;
					echo '</span>';
					?>
				</div>
				<?php 
				$brm++;
				endforeach;
				?>
			</div>
		</div>
	</div>
</div>
<?php
endif;
if(count($tiperi)):
$brStr4 = ceil(count($tiperi)/2);
?>
<div class="slajder">
	<div class="natpis">RECOMENDED MATCHES
		<div class="levo">
			<img src="<?php echo base_url();?>images/left.png">
		</div>
		<div class="mesto">1/<?php echo $brStr4;?></div>
		<div class="desno">
			<img src="<?php echo base_url();?>images/right.png">
		</div>
	</div>
	<div class="prozor">
		<div class="film" style="width: <?php echo 100.0*$brStr4; ?>%;">
			<div class="slajd" style="width: <?php echo 100.0/$brStr4; ?>%;">
				<?php
				$brm = 0;
				foreach($tiperi as $t):
					if($brm%2 == 0 && $brm > 0):
				?>
			</div>
			<div class="slajd" style="width: <?php echo 100.0/$brStr4; ?>%;">
				<?php endif;?>
				<div class="matchDiv">
					<input type="hidden" id="match_id" value="<?php echo $t->id; ?>">
					<span class="pocetok"><?php 
					//[igrano] => 0 [tipuvacIme] => Tester [tipuvacPrezime] => Testerovski [tipuvacSaldo] => 90 
					$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
					$datum = new DateTime($t->pocetok, new DateTimeZone("Europe/Skopje"));
					if($denes->format("Y-m-d") == $datum->format("Y-m-d"))
						echo "Today, ".$datum->format("H:i");
					else 
						echo $datum->format("d M Y, H:i");
					?></span>
					<span class="tipperInfo">from top tipper, #<?php echo $t->rang.' '.$t->tipuvacIme.' '.
					', B'.$t->tipuvacSaldo;?></span>
					<div class="match">
						<div class="home">
							<input type="hidden" id="koeficient" value="<?php echo $t->home; ?>">
							<span class="tim"><?php echo $t->domasni; ?></span>
							<span class="koeficient">win (<?php 
								echo number_format($t->home, 2, ',','.'); ?>)</span>
						</div>
						<div class="draw">
							draw
							<input type="hidden" id="koeficient" value="<?php echo $t->draw; ?>">
							<span class="koeficient">win (<?php 
								echo number_format($t->draw, 2, ',','.'); ?>)</span>
						</div>
						<div class="away">
							<span class="tim"><?php echo $t->gosti; ?></span>
							<input type="hidden" id="koeficient" value="<?php echo $t->away; ?>">
							<span class="koeficient">win (<?php 
								echo number_format($t->away, 2, ',','.'); ?>)</span>
						</div>
					</div>
				</div>
				<?php 
				$brm++;
				endforeach;
				?>
			</div>
		</div>
	</div>
</div>
<?php
endif;
if(count($favoriti)):
$brStr4 = ceil(count($favoriti)/2);
?>
<div class="slajder">
	<div class="natpis">FROM MY FAVORITES
		<div class="levo">
			<img src="<?php echo base_url();?>images/left.png">
		</div>
		<div class="mesto">1/<?php echo $brStr4;?></div>
		<div class="desno">
			<img src="<?php echo base_url();?>images/right.png">
		</div>
	</div>
	<div class="prozor">
		<div class="film" style="width: <?php echo 100.0*$brStr4; ?>%;">
			<div class="slajd" style="width: <?php echo 100.0/$brStr4; ?>%;">
				<?php
				$brm = 0;
				foreach($favoriti as $t):
					if($brm%2 == 0 && $brm > 0):
				?>
			</div>
			<div class="slajd" style="width: <?php echo 100.0/$brStr4; ?>%;">
				<?php endif;?>
				<div class="matchDiv">
					<input type="hidden" id="match_id" value="<?php echo $t->id; ?>">
					<span class="pocetok"><?php 
					$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
					$datum = new DateTime($t->pocetok, new DateTimeZone("Europe/Skopje"));
					if($denes->format("Y-m-d")==$datum->format("Y-m-d"))
						echo "Today, ".$datum->format("H:i");
					else 
						echo $datum->format("d M Y, H:i");
					?></span>
					<div class="match">
						<div class="home">
							<input type="hidden" id="koeficient" value="<?php echo $t->home; ?>">
							<span class="tim"><?php echo $t->domasni; ?></span>
							<span class="koeficient">win (<?php 
								echo number_format($t->home, 2, ',','.'); ?>)</span>
						</div>
						<div class="draw">
							draw
							<input type="hidden" id="koeficient" value="<?php echo $t->draw; ?>">
							<span class="koeficient">win (<?php 
								echo number_format($t->draw, 2, ',','.'); ?>)</span>
						</div>
						<div class="away">
							<span class="tim"><?php echo $t->gosti; ?></span>
							<input type="hidden" id="koeficient" value="<?php echo $t->away; ?>">
							<span class="koeficient">win (<?php 
								echo number_format($t->away, 2, ',','.'); ?>)</span>
						</div>
					</div>
				</div>
				<?php 
				/*
				Object ( [id] [domasni] [gosti] [pocetok] [kraj] 
					[kolo] [sezona] [sampionat] [home] [draw] [away] ) 
				*/
				$brm++;
				endforeach;
				?>
			</div>
		</div>
	</div>
</div>
<?php
endif;
if(count($sledni)):
$brStr4 = ceil(count($sledni)/2);
?>
<div class="slajder">
	<div class="natpis">SUGGESTIONS
		<div class="levo">
			<img src="<?php echo base_url();?>images/left.png">
		</div>
		<div class="mesto">1/<?php echo $brStr4;?></div>
		<div class="desno">
			<img src="<?php echo base_url();?>images/right.png">
		</div>
	</div>
	<div class="prozor">
		<div class="film" style="width: <?php echo 100.0*$brStr4; ?>%;">
			<div class="slajd" style="width: <?php echo 100.0/$brStr4; ?>%;">
				<?php
				$brm = 0;
				foreach($sledni as $t):
					if($brm%2 == 0 && $brm > 0):
				?>
			</div>
			<div class="slajd" style="width: <?php echo 100.0/$brStr4; ?>%;">
				<?php endif;?>
				<div class="matchDiv">
					<input type="hidden" id="match_id" value="<?php echo $t->id; ?>">
					<span class="pocetok"><?php 
					$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
					$datum = new DateTime($t->pocetok, new DateTimeZone("Europe/Skopje"));
					if($denes->format("Y-m-d")==$datum->format("Y-m-d"))
						echo "Today, ".$datum->format("H:i");
					else 
						echo $datum->format("d M Y, H:i");
					?></span>
					<div class="match">
						<div class="home">
							<input type="hidden" id="koeficient" value="<?php echo $t->home; ?>">
							<span class="tim"><?php echo $t->domasni; ?></span>
							<span class="koeficient">win (<?php 
								echo number_format($t->home, 2, ',','.'); ?>)</span>
						</div>
						<div class="draw">
							draw
							<input type="hidden" id="koeficient" value="<?php echo $t->draw; ?>">
							<span class="koeficient">win (<?php 
								echo number_format($t->draw, 2, ',','.'); ?>)</span>
						</div>
						<div class="away">
							<span class="tim"><?php echo $t->gosti; ?></span>
							<input type="hidden" id="koeficient" value="<?php echo $t->away; ?>">
							<span class="koeficient">win (<?php 
								echo number_format($t->away, 2, ',','.'); ?>)</span>
						</div>
					</div>
				</div>
				<?php 
				/*
				Object ( [id] [domasni] [gosti] [pocetok] [kraj] 
					[kolo] [sezona] [sampionat] [home] [draw] [away] ) 
				*/
				$brm++;
				endforeach;
				?>
			</div>
		</div>
	</div>
</div>
<div class="message">
Your bets now are <span id="vlozeno">0</span><br>
if you win you will earn <span id="dobivka">0</span>
<button id="submit">PLACE THIS BETS</button>
</div>
<?php endif;?>
<form id="target" action="<?php echo base_url()."matches/bets/"; ?>" method="post" style="display: none;">
<input name="natprevariArray" id="natprevariArray" type="text">
<input name="tipoviArray" id="tipoviArray" type="text">
<input name="uloziArray" id="uloziArray" type="text">
<input name="koeficientiArray" id="koeficientiArray" type="text">
</form>
<script type="text/javascript">
var natprevari = new Array();
var tipovi = new Array();
var ulozi = new Array();
var koeficienti = new Array();
$('#submit').click(function(){
	$('form#target').submit();
	/*
	$.ajax({
		url: "<?php echo base_url()."ajax/tester"?>",
		type: "POST",
		data: {natprevariArray:natprevari, tipoviArray:tipovi,
			uloziArray: ulozi, koeficientiArray:koeficienti},
		success: function(data)
		{
			alert(data);
		}
	});
	*/
});
function presmetaj()
{
	var suma = 0;
	var vkupno = 0;
	for(var i=0; i < natprevari.length; i++)
	{
		vkupno = vkupno + ulozi[i];
		suma = suma + ulozi[i] * koeficienti[i];
	}
	$('#vlozeno').text(vkupno);
	$('#dobivka').text(suma);
	if(suma == 0)
		$(".message").hide();
	else
		$(".message").show();
}
$('.home').click(function(){
	var maxBets = parseInt($('.maxTipovi').text());
	$(this).siblings('.selected').removeClass('selected');
	var matchID = parseInt($(this).closest('.matchDiv').find('#match_id').val());
	var tip = 1;
	var ulog = 10;
	var koeficient = parseFloat($(this).find('#koeficient').val());
	if(natprevari.indexOf(matchID) == -1)
	{
		if(maxBets > 0)
		{
			$(this).addClass('selected');
			natprevari.push(matchID);
			tipovi.push(tip);
			ulozi.push(ulog);
			koeficienti.push(koeficient);
			maxBets--;
		}
	}
	else
	{
		var indeks = natprevari.indexOf(matchID);
		if(tipovi[indeks] == tip)
		{
			$(this).removeClass('selected');
			natprevari.splice(indeks, 1);
			tipovi.splice(indeks, 1);
			ulozi.splice(indeks, 1);
			koeficienti.splice(indeks, 1);
			maxBets++;
		}
		else
		{
			$(this).addClass('selected');
			tipovi[indeks] = tip;
			koeficienti[indeks] = koeficient;
		}
	}
	$('#natprevariArray').val(natprevari);
	$('#tipoviArray').val(tipovi);
	$('#uloziArray').val(ulozi);
	$('#koeficientiArray').val(koeficienti);
	$('.maxTipovi').text(maxBets);
	presmetaj();
});
$('.away').click(function(){
	var maxBets = parseInt($('.maxTipovi').text());
	$(this).siblings('.selected').removeClass('selected');
	var matchID = parseInt($(this).closest('.matchDiv').find('#match_id').val());
	var tip = 2;
	var ulog = 10;
	var koeficient = parseFloat($(this).find('#koeficient').val());
	if(natprevari.indexOf(matchID) == -1)
	{
		if(maxBets > 0)
		{
			$(this).addClass('selected');
			natprevari.push(matchID);
			tipovi.push(tip);
			ulozi.push(ulog);
			koeficienti.push(koeficient);
			maxBets--;
		}
	}
	else
	{
		var indeks = natprevari.indexOf(matchID);
		if(tipovi[indeks] == tip)
		{
			$(this).removeClass('selected');
			natprevari.splice(indeks, 1);
			tipovi.splice(indeks, 1);
			ulozi.splice(indeks, 1);
			koeficienti.splice(indeks, 1);
			maxBets++;
		}
		else
		{
			$(this).addClass('selected');
			tipovi[indeks] = tip;
			koeficienti[indeks] = koeficient;
		}
	}
	$('#natprevariArray').val(natprevari);
	$('#tipoviArray').val(tipovi);
	$('#uloziArray').val(ulozi);
	$('#koeficientiArray').val(koeficienti);
	$('.maxTipovi').text(maxBets);
	presmetaj();
});
$('.draw').click(function(){
	var maxBets = parseInt($('.maxTipovi').text());
	$(this).siblings('.selected').removeClass('selected');
	var matchID = parseInt($(this).closest('.matchDiv').find('#match_id').val());
	var tip = 0;
	var ulog = 10;
	var koeficient = parseFloat($(this).find('#koeficient').val());
	if(natprevari.indexOf(matchID) == -1)
	{
		if(maxBets > 0)
		{
			$(this).addClass('selected');
			natprevari.push(matchID);
			tipovi.push(tip);
			ulozi.push(ulog);
			koeficienti.push(koeficient);
			maxBets--;
		}
	}
	else
	{
		var indeks = natprevari.indexOf(matchID);
		if(tipovi[indeks] == tip)
		{
			$(this).removeClass('selected');
			natprevari.splice(indeks, 1);
			tipovi.splice(indeks, 1);
			ulozi.splice(indeks, 1);
			koeficienti.splice(indeks, 1);
			maxBets++;
		}
		else
		{
			$(this).addClass('selected');
			tipovi[indeks] = tip;
			koeficienti[indeks] = koeficient;
		}
	}
	$('#natprevariArray').val(natprevari);
	$('#tipoviArray').val(tipovi);
	$('#uloziArray').val(ulozi);
	$('#koeficientiArray').val(koeficienti);
	$('.maxTipovi').text(maxBets);
	presmetaj();
});
function levo_desno()
{
	$('.desno').unbind("click");
	$('.levo').unbind("click");
	$('.desno').click(function(){
		var maxPozicija = $(this).closest('.slajder').find('.film').children('.slajd').length;
		var pozicija = parseInt($(this).closest('.slajder').find('.film').css('left'));
		var goleminaSlajd = $(this).closest('.slajder').find('.slajd').width();
		var lokacija = Math.abs(pozicija/goleminaSlajd) + 1;
		if(maxPozicija > lokacija)
		{
			$(this).closest('.slajder').find('.film').animate({left: pozicija-goleminaSlajd}, 10);
			lokacija++;
			var visina = $(this).closest('.slajder').find('.slajd:nth-child('+lokacija+')').height();
			$(this).closest('.slajder').find('.prozor').animate({height: visina}, 10);
			$(this).siblings('.mesto').html(lokacija + "/" + maxPozicija);
		}
	});
	$('.levo').click(function(){
		var maxPozicija = $(this).closest('.slajder').find('.film').children('.slajd').length;
		var pozicija = parseInt($(this).closest('.slajder').find('.film').css('left'));
		var goleminaSlajd = $(this).closest('.slajder').find('.slajd').width();
		var lokacija = Math.abs(pozicija/goleminaSlajd) + 1;
		if(pozicija < 0)
		{
			$(this).closest('.slajder').find('.film').animate({left: pozicija+goleminaSlajd}, 10);
			lokacija--;
			var visina = $(this).closest('.slajder').find('.slajd:nth-child('+lokacija+')').height();
			$(this).closest('.slajder').find('.prozor').animate({height: visina}, 10);
			$(this).siblings('.mesto').html(lokacija + "/" + maxPozicija);
		}
	});
};
levo_desno();
presmetaj();
$(".slajder").each(function(){
	var visina = $(this).find('.film').height();
	$(this).find('.prozor').height(visina);
});
</script>
