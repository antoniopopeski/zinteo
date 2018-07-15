<h2>Add score</h2>
<?php if(isset($poraka) && $poraka):
if(is_array($poraka)):
?>
<div id="info">
<?php
foreach ($poraka as $p):
?>
	<label <?php echo (strpos($p, 'success')===false)?'style="background-color: #F00; display: block;"':
		'style="background-color: #0F0; display: block;"';?>><?php echo $p; ?></label>
<?php
endforeach;
?>
</div>
<?php
else: ?>
<div id="info"<?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>>
	<label><?php echo $poraka; ?></label>
</div>
<?php
endif;
endif;
?>
<form method="post" action="<?php echo base_url()."admin_rezultat";?>">
	<?php 
	$br = 0;
	foreach($lista as $s):
	?>
	<div class="pole">
		<div class="labeler" style="width: 35%; font-weight: normal;">
			<?php echo (!$s->koef)?'<span style="color: #F00;">*</span>':''; echo $s->id.": ".$s->domasni." vs ".$s->gosti;?><button class="detali" value="<?php echo $s->id;
			?>">*</button>
		</div>
		<div class="elements"><span
				style="font-weight: bold;">
			Full time</span> <input
				style="width: 50px; font-weight: bold;"
				name="domasni4[<?php echo $br;?>]"
				value="<?php echo $s->domasni4;?>"> :<input
				style="width: 50px; font-weight: bold; margin-right: 50px;"
				name="gosti4[<?php echo $br;?>]" value="<?php echo $s->gosti4;?>"> <input
				type="hidden" name="natprevar[<?php echo $br;?>]"
				value="<?php echo $s->id;?>">
			Half time <input style="width: 50px;"
				name="domasni2[<?php echo $br;?>]"
				value="<?php echo $s->domasni2;?>"> :<input style="width: 50px;"
				name="gosti2[<?php echo $br;?>]" value="<?php echo $s->gosti2;?>">
		</div>
	</div>
	<hr style="border: 0.5px solid #CCC; margin: 7px 0;">
	<?php 
	$br++;
endforeach;?>
	<div class="pole">
		<div class="elements">
			<input type="submit" value="SET SCORES">
		</div>
	</div>
</form>
<br>
<h3>Finish in 30 minutes (<?php echo count($prikraj);?> total)</h3>
<br>
<table id="adminTabela" class="dataTable" style="width: 100%;">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>HOME TEAM</th>
			<th>AWAY TEAM</th>
			<th>FINAL</th>
			<th>HALF</th>
			<th>DATE</th>
			<th>TIME START</th>
			<th>TIME END</th>
			<th>ENDING</th>
			<th>CHAMPIONSHIP</th>
			<th>STATUS</th>
			<th>VIS</th>
			<th>BETS</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($prikraj as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else 
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);

		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";
		elseif(!$s->koef && $denes > $pocetok)
			$status = "Missed";
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
			$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
			$status = "Finished";
		elseif($minuti <= 30)
			$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
			$status = "Live";
		elseif($s->koef)
			$status = "Open";
	?>
		<tr style="color: <?php 
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
			break;
			case "Missed":
				echo "#987e00";
			break;
			case "Finish in 30min":
				echo "#ff8000";
			break;
			case "Finished":
				echo "#FF0000";
			break;
			case "Closed":
				echo "#999999";
			break;
			case "Live":
				echo "#00FF00";
			break;
			default:
				echo "#000";
			break;
		}
		?>">
			<td></td>
			<td id="indeks"><?php echo $s->id;?></td>
			<td><?php echo $s->domasni;?></td>
			<td><?php echo $s->gosti;?></td>
			<td><?php echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
				$s->domasni4.":".$s->gosti4:'';?></td>
			<td><?php echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
				$s->domasni2.":".$s->gosti2:'';?></td>
			<td><?php echo $pocetok->format("d M Y");?></td>
			<td><?php echo $pocetok->format("H:i");?></td>
			<td><?php echo $kraj->format("H:i");?></td>
			<td><?php echo ($minuti>0)?$minuti:0;?></td>
			<td><?php echo $s->sampionat;?></td>
			<td><?php echo $status;?></td>
			<td><?php echo ($vidliv < $denes && $s->koef)?'YES':'NO';?></td>
			<td><?php echo $s->oblozi;?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>

<h3>Finish today (<?php echo count($denesni);?> total)</h3>
<br>
<table id="adminTabela" class="dataTable" style="width: 100%;">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>HOME TEAM</th>
			<th>AWAY TEAM</th>
			<th>FINAL</th>
			<th>HALF</th>
			<th>DATE</th>
			<th>TIME START</th>
			<th>TIME END</th>
			<th>ENDING</th>
			<th>CHAMPIONSHIP</th>
			<th>STATUS</th>
			<th>VIS</th>
			<th>BETS</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($denesni as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else 
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);

		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";
		elseif(!$s->koef && $denes > $pocetok)
			$status = "Missed";
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
			$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
			$status = "Finished";
		elseif($minuti <= 30)
			$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
			$status = "Live";
		elseif($s->koef)
			$status = "Open";
	?>
		<tr style="color: <?php 
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
			break;
			case "Missed":
				echo "#987e00";
			break;
			case "Finish in 30min":
				echo "#ff8000";
			break;
			case "Finished":
				echo "#FF0000";
			break;
			case "Closed":
				echo "#999999";
			break;
			case "Live":
				echo "#00FF00";
			break;
			default:
				echo "#000";
			break;
		}
		?>">
			<td></td>
			<td id="indeks"><?php echo $s->id;?></td>
			<td><?php echo $s->domasni;?></td>
			<td><?php echo $s->gosti;?></td>
			<td><?php echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
				$s->domasni4.":".$s->gosti4:'';?></td>
			<td><?php echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
				$s->domasni2.":".$s->gosti2:'';?></td>
			<td><?php echo $pocetok->format("d M Y");?></td>
			<td><?php echo $pocetok->format("H:i");?></td>
			<td><?php echo $kraj->format("H:i");?></td>
			<td><?php echo ($minuti>0)?$minuti:0;?></td>
			<td><?php echo $s->sampionat;?></td>
			<td><?php echo $status;?></td>
			<td><?php echo ($vidliv < $denes && $s->koef)?'YES':'NO';?></td>
			<td><?php echo $s->oblozi;?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>

<h3>Finish in next 72 hours (<?php echo count($naredni);?> total)</h3>
<br>
<table id="adminTabela" class="dataTable" style="width: 100%;">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>HOME TEAM</th>
			<th>AWAY TEAM</th>
			<th>FINAL</th>
			<th>HALF</th>
			<th>DATE</th>
			<th>TIME START</th>
			<th>TIME END</th>
			<th>ENDING</th>
			<th>CHAMPIONSHIP</th>
			<th>STATUS</th>
			<th>VIS</th>
			<th>BETS</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($naredni as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else 
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);

		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";
		elseif(!$s->koef && $denes > $pocetok)
			$status = "Missed";
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
			$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
			$status = "Finished";
		elseif($minuti <= 30)
			$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
			$status = "Live";
		elseif($s->koef)
			$status = "Open";
	?>
		<tr style="color: <?php 
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
			break;
			case "Missed":
				echo "#987e00";
			break;
			case "Finish in 30min":
				echo "#ff8000";
			break;
			case "Finished":
				echo "#FF0000";
			break;
			case "Closed":
				echo "#999999";
			break;
			case "Live":
				echo "#00FF00";
			break;
			default:
				echo "#000";
			break;
		}
		?>">
			<td></td>
			<td id="indeks"><?php echo $s->id;?></td>
			<td><?php echo $s->domasni;?></td>
			<td><?php echo $s->gosti;?></td>
			<td><?php echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
				$s->domasni4.":".$s->gosti4:'';?></td>
			<td><?php echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
				$s->domasni2.":".$s->gosti2:'';?></td>
			<td><?php echo $pocetok->format("d M Y");?></td>
			<td><?php echo $pocetok->format("H:i");?></td>
			<td><?php echo $kraj->format("H:i");?></td>
			<td><?php echo ($minuti>0)?$minuti:0;?></td>
			<td><?php echo $s->sampionat;?></td>
			<td><?php echo $status;?></td>
			<td><?php echo ($vidliv < $denes && $s->koef)?'YES':'NO';?></td>
			<td><?php echo $s->oblozi;?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<div id="dialog"></div>
<script type="text/javascript">
$('.detali').click(function(){
	$.ajax({
		url: "<?php echo base_url()."ajax/detaliNatprevar"?>",
		type: "POST",
		data: {id: $(this).val()},
		success: function(data)
		{
			$("#dialog").html(data);
		    $("#dialog").dialog({
		        resizable: false,
		        modal: true,
		        buttons: {
		    		'OK': function() {
		    		    $(this).dialog('destroy');
		    		}
		        },
		        autoOpen: false
		    });
		    $("#dialog").dialog('open');
		}
	});
	return false;
});
</script>