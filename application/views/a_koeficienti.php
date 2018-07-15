<h2>Set coeficients</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
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
			<th>START</th>
			<th>END</th>
			<th>STARTING</th>
			<th>CHAMPIONSHIP</th>
			<th>STATUS</th>
			<th>VIS</th>
			<th>POP</th>
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
	$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
	
	if(!$s->koef && $denes < $pocetok)
			$status = "Naked";
	elseif(!$s->koef && $denes > $pocetok)
			$status = "Missed";
	elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) && 
		is_numeric($s->domasni2) && is_numeric($s->gosti2))
		$status = "Closed";
	elseif($denes > $kraj && !(is_numeric($s->domasni4) || is_numeric($s->gosti4)
		|| is_numeric($s->domasni2) || is_numeric($s->gosti2)))
		$status = "Finished";
	elseif($minuti <= 30)
		$status = "Finish in 30min";
	elseif($denes > $pocetok && $denes < $kraj)
		$status = "Live";
	elseif($s->koef)
			$status = "Open";
	$dif = $denes->diff($pocetok);
	if($dif->invert===0)
		$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
	else
		$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);
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
			<td></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table><br><br>
<form id='target' method="post" action="<?php echo base_url("admin_koeficienti/editKoeficient");?>">
</form>
<script type="text/javascript">
$("#adminTabela tbody tr").click(function(){
	$("tr.selected").removeClass("selected");
	$(this).addClass("selected");
	$.ajax({
		url: "<?php echo base_url('ajax/smeni_koeficient');?>",
		type: "POST",
		data: {id: $(this).children('#indeks').html()},
		error: function()
		{
			$('#target').html("error");
		},
		success: function(data)
		{
			$('#target').html(data);
			$("input[type='text']").live('focus', function () {
				$(this).val('');
			});
			$("input[type='text']").live ('keyup', function (e) {
				var tekst = $(this).val();
				var duzina = tekst.length - 1;
				var posleden = tekst.substring(duzina, duzina + 1);
				var brojka = parseInt(posleden);
				if(isNaN(brojka) && posleden != '.')
				{
					if(posleden == ',')
						tekst = tekst.substring(0,duzina) + '.';
					else
						tekst = tekst.substring(0,duzina);
				}
				if(tekst.length > 0 && posleden != '.' && posleden != ',')
					$(this).val(parseFloat(tekst));
				else 
					$(this).val(tekst);
	        });
			$('#prv').focus();
			$( "input[type='text']" ).spinner({ step: 0.01, min: 1, max: 100, numberFormat: "n" });
		}
	});
});
</script>