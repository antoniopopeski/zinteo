<h2>Teams in championship</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<select class="filter" id="drzava">
	<option value="0" selected="selected">ALL COUNTRIES</option>
	<?php foreach($drzavi as $d): ?>
	<option <?php echo ($selDrzava==$d->id)?'selected="selected"':'';?> value="d<?php echo $d->id;?>"><?php 
		echo $d->ime;?></option>
	<?php endforeach;?>
</select>
<select class="filter" id="sport">
	<option value="0" selected="selected">ALL SPORTS</option>
	<?php foreach($sportovi as $d): ?>
	<option <?php echo ($selSport==$d->id)?'selected="selected"':'';?> value="s<?php echo $d->id;?>"><?php 
		echo $d->ime;?></option>
	<?php endforeach;?>
</select><!--
<select class="filter" id="sampionat">
	<option value="0" selected="selected">ALL CHAMPIONSHIPS</option>
	<?php foreach($sampionati as $d): ?>
	<option <?php echo ($selSampionat==$d->id)?'selected="selected"':'';?> value="l<?php echo $d->id;?>"><?php 
		echo $d->ime;?></option>
	<?php endforeach;?>
</select>
<select class="filter" id="tim">
	<option value="0" selected="selected">ALL TEAMS</option>
	<?php foreach($timovi as $d): ?>
	<option <?php echo ($selTim==$d->id)?'selected="selected"':'';?> value="t<?php echo $d->id;?>"><?php 
		echo $d->ime;?></option>
	<?php endforeach;?>
</select> -->
<button id="reset">Reset</button>
<br>
<br>
<?php include "sampionati_nav.php";?>
<br><br>
<table id="adminTabela" class="dataTable">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>CHAMPIONSHIP</th>
			<th>COUNTRY</th>
			<th>SPORT</th>
			<th>TOP</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($lista as $s):?>
		<tr>
			<td></td>
			<td id="indeks"><?php echo $s->id;?></td>
			<td><?php echo $s->sampionat." [".$s->broj."]";?></td>
			<td><?php echo $s->drzava;?></td>
			<td><?php echo $s->sport;?></td>
			<td><?php echo ($s->top)?'YES':'';?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<div id='target'>
</div><br>
<div id='ipon'>
</div>
<script type="text/javascript">
$('.filter').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/filtri');?>",
		type: "POST",
		data: {drzava: $('#drzava').val(), sport: $('#sport').val()},
		success: function(data)
		{
			window.location.reload(true);
		}
	});
});
$('#reset').click(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/filtri');?>",
		type: "POST",
		data: {drzava: 0, sport: 0},
		success: function(data)
		{
			window.location.reload(true);
		}
	});
});
$("#adminTabela tbody tr").click(function(){
	$("tr.selected").removeClass("selected");
	$(this).addClass("selected");
	$('#ipon').html("");
	$.ajax({
		url: "<?php echo base_url('ajax/sezoni_sampionat');?>",
		type: "POST",
		data: {id: $(this).children('#indeks').html()},
		error: function()
		{
			$('#target').html("error");
		},
		success: function(data)
		{
			$('#target').html(data);
		}
	});
});
</script>