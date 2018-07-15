<h2>Rounds</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<select class="filter" id="sampionat">
	<option value="0" selected="selected">ALL CHAMPIONSHIPS</option>
	<?php foreach($sampionati as $d): ?>
	<option <?php echo ($selSampionat==$d->id)?'selected="selected"':'';?> value="l<?php echo $d->id;?>"><?php 
		echo $d->ime;?></option>
	<?php endforeach;?>
</select>
<button id="reset">Reset</button>
<br>
<table id="adminTabela" class="dataTable">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>ROUND</th>
			<th>CHAMPIONSHIP</th>
			<th>SEASON</th>
			<th>DELETE</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($lista as $s):?>
		<tr>
			<td></td>
			<td id="indeks"><?php echo $s->id;?></td>
			<td><?php echo $s->ime;?></td>
			<td><?php echo $s->liga;?></td>
			<td><?php echo $s->sezona;?></td>
			<td><a class="delete" href="<?php echo base_url().'admin_kolo/delete/'.$s->id;?>">Delete</a></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<button id="new">New round</button><br>
<form id='target' method="post" enctype="multipart/form-data" action="<?php echo base_url("admin_kolo/edit");?>">
</form>
<div id="potvrdi-dialog"><h3>Are you sure that you want to delete this round?</h3></div>
<script type="text/javascript">
$('.filter').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/filtri');?>",
		type: "POST",
		data: {sampionat: $('#sampionat').val()},
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
		data: { sampionat: 0},
		success: function(data)
		{
			window.location.reload(true);
		}
	});
});
$("#new").click(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/nov_kolo');?>",
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
		url: "<?php echo base_url('ajax/smeni_kolo');?>",
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