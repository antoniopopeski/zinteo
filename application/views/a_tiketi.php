<h2>Bonus bids</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<select class="filter" id="tiper">
	<option value="0" selected="selected">ALL TIPPERS</option>
	<?php foreach($tiperi as $t): ?>
	<option <?php echo ($selTiper==$t->id)?'selected="selected"':'';?> value="t<?php echo $t->id;?>"><?php 
		echo $t->username;?></option>
	<?php endforeach;?>
</select>
Valid on <input class="filter date" id="startDate" value="<?php 
if($startDate)
{
	$date = new DateTime($startDate, new DateTimeZone("Europe/Skopje"));
	echo $date->format("d M Y");
}?>" style="width: 90px;"><button id="reset">Reset</button><br><br>
<table id="adminTabela" class="dataTable" style="width: 100%;">
	<thead>
		<tr>
			<th>#</th>
			<th>Ticket ID</th>
			<th>Ticket code</th>
			<th>Tiper</th>
			<th>Valid from</th>
			<th>Valid until</th>
			<th>Daily bids</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($lista as $o):
	?>
		<tr>
			<td></td>
			<td><?php echo $o->id;?></td>
			<td><?php echo $o->code;?></td>
			<td><?php echo $o->username;?></td>
			<td><?php $datum = date_create_from_format("Y-m-d H:i:s", $o->od);
			echo $datum->format("d M Y, H:i:s");?></td>
			<td><?php $datum = date_create_from_format("Y-m-d H:i:s", $o->do);
			echo $datum->format("d M Y, H:i:s");?></td>
			<td><?php echo $o->bids;?></td>
			<td><?php if($o->aktiviran == '0000-00-00 00:00:00')
				echo 'not activated';
			else 
				echo 'activated';
			?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<form id='target' method="post" action="<?php echo base_url("admin_tipper/tiket");?>">
</form>
<div id="potvrdi-dialog"><h3>Are you sure that you want to delete this user?</h3></div>
<script type="text/javascript">
$('.delete').click(function(e){
    e.preventDefault();
    $("#potvrdi-dialog").dialog('option', 'href',$(this).attr('href')).dialog('open');
    return false;
});
$('.date').datepicker({dateFormat: "dd-mm-yy"});
$('#reset').click(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/filtri');?>",
		type: "POST",
		data: {tiper: 0, tiketDate: 0},
		success: function(data)
		{
			window.location.reload(true);
		}
	});
});
$('.filter').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/filtri');?>",
		type: "POST",
		data: {tiper: $('#tiper').val(), tiketDate: $('#startDate').val()},
		success: function(data)
		{
			window.location.reload(true);
		}
	});
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