<h2>Correct scores</h2>
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
include 'koregiraj_nav.php';?>
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
	<?php foreach($lista as $s):
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
<br>
<form method="post" action="<?php echo base_url("admin_koregiraj/editRezultat");?>">
</form>
<script type="text/javascript">
$("#adminTabela tbody tr").click(function(){
	$("tr.selected").removeClass("selected");
	$(this).addClass("selected");
	$.ajax({
		url: "<?php echo base_url('ajax/smeni_rezultat');?>",
		type: "POST",
		data: {id: $(this).children('#indeks').html()},
		error: function()
		{
			$('form').html("error");
		},
		success: function(data)
		{
			$('form').html(data);
		}
	});
});
</script>