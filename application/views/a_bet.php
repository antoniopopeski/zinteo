<h2>Bets</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;
//print_r($lista[0]); exit();
?>
<table id="adminTabela" class="dataTable dataTable2">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>tipper username</th>
			<th>tipper rang</th>
			<th>date</th>
			<th>home team</th>
			<th>away team</th>
			<th>bet amount</th>
			<th>bet coeficient</th>
			<th>home win</th>
			<th>draw</th>
			<th>away win</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($lista as $o):?>
		<tr>
			<td></td>
			<td><?php echo $o->id;?></td>
			<td><?php echo $o->username;?></td>
			<td><?php echo $o->rang;?></td>
			<td><?php $datum = date_create_from_format("Y-m-d H:i:s", $o->datum);
			echo $datum->format("d M Y, H:i:s");?></td>
			<td><?php echo $o->domasni;?></td>
			<td><?php echo $o->gosti;?></td>
			<td><?php echo $o->ulog;?></td>
			<td><?php echo $o->koeficient;?></td>
			<td><?php 
			if($o->uspesen)
				$boja = "green";
			else $boja = "red";
			if($o->tip == 1)
				echo '<div style="background-color: '.$boja.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == 0)
				echo '<div style="background-color: '.$boja.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == 2)
				echo '<div style="background-color: '.$boja.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<form id='target' method="post" enctype="multipart/form-data" action="<?php echo base_url("admin_bets");?>">
</form>
<div id="potvrdi-dialog"><h3>Are you sure that you want to delete this sport?</h3></div>
<script type="text/javascript">
$("#new").click(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/nov_sport');?>",
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