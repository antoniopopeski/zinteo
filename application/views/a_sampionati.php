<h2>Championship</h2>
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
			<th>LOGO</th>
			<th>TOP</th>
			<th>DELETE</th>
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
			<td><?php
			$filename = "images/leagues/item_".$s->id;
			if(file_exists("./".$filename.".png"))
			{
				?><img width="100" src="<?php echo base_url().$filename.".png"; ?>"><?php
			}
			elseif(file_exists("./".$filename.".jpeg"))
			{
				?><img width="100" src="<?php echo base_url().$filename.".jpeg"; ?>"><?php
			}
			?></td>
			<td><?php echo ($s->top)?'YES':'';?></td>
			<td><a class="delete" href="<?php echo base_url().'admin_sampionati/delete/'.$s->id;?>">Delete</a></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<button id="new">New championship</button><br>
<form id='target' method="post" enctype="multipart/form-data" action="<?php echo base_url("admin_sampionati/edit");?>">
</form>
<div id="potvrdi-dialog"><h3>Are you sure that you want to delete this championship?</h3></div>
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
$("#new").click(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/nov_sampionat');?>",
		type: "POST",
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
$("#adminTabela tbody tr").click(function(){
	$("tr.selected").removeClass("selected");
	$(this).addClass("selected");
	$.ajax({
		url: "<?php echo base_url('ajax/smeni_sampionat');?>",
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
$('.delete').click(function(e){
    e.preventDefault();
    $("#potvrdi-dialog").dialog('option', 'href',$(this).attr('href')).dialog('open');
    return false;
});
$("#potvrdi-dialog").dialog({
    resizable: false,
    modal: true,
    buttons: {
		'Cancel': function() {
		    $(this).dialog('close');
		},
		'Delete': function() {
		    window.location.href = $(this).dialog('option', 'href');
		}
    },
    autoOpen: false
});
</script>