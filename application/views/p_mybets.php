<div id="filter" class="leftcss">
	<select class="filter" id="prv">
		<option value="0">All bets</option>
		<option value="1">Open</option>
		<option value="2">Winning</option>
		<option value="3">Missed</option>
		<option value="4">Today's</option>
		<option value="5">This month</option>
		<option value="6">This year</option>
	</select>
	<select class="filter" id="vtor">
		<option value="0">Most recent</option>
		<option value="1">Small coef.</option>
		<option value="2">Large coef.</option>
		<option value="3">Gain max</option>
		<option value="4">Gain min</option>
	</select>
</div>
<div id="container" class="leftcss" style="margin: 0px;">
	<table id="mybetstable">
		<thead>
			<tr>
				<th id="col1">Match</th>
				<th id="col2">Result</th>
				<th id="col3">Tip</th>
				<th id="col4">Coef</th>
				<th id="col5">Bet</th>
				<th id="col6">Gain</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$aktivenDatum = new DateTime('now', new DateTimeZone('Europe/Skopje'));
		$aktivenDatum->setTimezone(new DateTimeZone($user->timezone));
		$aktivenDatum->modify('+1 month');
		$prv = 0;
		$format = "d.m.Y";
		foreach ($lista as $o):
			$datum = new DateTime($o->pocetok, new DateTimeZone('Europe/Skopje'));
			$datum->setTimezone(new DateTimeZone('America/Whitehorse'));
			if($aktivenDatum->format($format) != $datum->format($format)):
				$aktivenDatum = $datum;
				if($prv > 0):
			?>
			<tr>
				<td colspan="6">&nbsp;</td>
			</tr>
			<?php endif;?>
			<tr>
				<td id="coldate" colspan="6"><?php echo $aktivenDatum->format("l, d M")?></td>
			</tr>
			<?php
			$prv++;
			endif;
			?>
			<tr<?php if(is_numeric($o->uspesen))
					echo ($o->uspesen)?' class="won"':' class="missed"';?>>
				<?php if($o->domasniKratko && $o->gostiKratko):?>
				<td id="col1">
					<?php echo $o->domasniKratko.' - '.$o->gostiKratko; ?>
					<input id="natprevar_id" value="<?php echo $o->natprevar_id;?>" type="hidden">
				</td>
				<?php else:?>
				<td id="col1">
					<?php echo substr($o->domasni, 0, 3).'. - '.substr($o->gosti, 0, 3)."."; ?>
					<input id="natprevar_id" value="<?php echo $o->natprevar_id;?>" type="hidden">
				</td>
				<?php endif;?>
				<td id="col2"><?php echo (is_numeric($o->domasni4) && is_numeric($o->gosti4))?$o->domasni4.':'.$o->gosti4:''; ?></td>
				<td id="col3"><?php 
				switch ($o->tip)
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
						echo 'G0-2';
						break;
					case "o":
						echo 'G3+';
						break;
					case '0':
						echo 'X';
						break;
					default:
						echo $o->tip; 
						break;
				}
				?></td>
				<td id="col4"><?php echo $o->koeficient; ?></td>
				<td id="col5">- <?php echo $o->ulog; ?></td>
				<td id="col6"><?php echo ($o->status=="Closed")?$o->dobivka:''; ?></td>
			</tr>
			<?php
		endforeach;
		?>
		</tbody>
	</table>
</div>
<div id="dialog" style="display: none;"></div>
<script type="text/javascript">
$("#dialog").dialog({
    resizable: false,
    modal: true,
    buttons: {
		'OK': function() {
		    $(this).dialog('close');
		}
    },
    autoOpen: false
});
$('td#col1').click(function(){
	$.ajax({
		url: "<?php echo base_url()."pajax/detaliNatprevar"?>",
		type: "POST",
		data: {id: $(this).find('#natprevar_id').val()},
		success: function(data)
		{
			$("#dialog").html(data);
		    $("#dialog").dialog('open');
		}
	});
});
$('.filter').val('0');
window.scrollTo(0, 1);
$('.filter').change(function(){
	$.ajax({
		url: "<?php 
		echo ($this->uri->segment(1)!="leaderboard")?base_url('pajax/mybets'):base_url('pajax/bets');
		?>",
		type: "POST",
		data: {filter1: $('#prv').val(), filter2: $('#vtor').val(), id: <?php echo (int)$this->uri->segment(3);?>},
		success: function(data)
		{
			$('#container').html(data);
		}
	});
});
</script>