<h2>Sport</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<table id="adminTabela" class="dataTable">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>SPORT</th>
			<th>LOGO</th>
			<th>OPEN MATCHES</th>
			<th>DELETE</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($lista as $s):?>
		<tr>
			<td></td>
			<td id="indeks"><?php echo $s->id;?></td>
			<td><?php echo $s->ime;?></td>
			<td><?php
			$filename = "images/sports/item_".$s->id;
			if(file_exists("./".$filename.".png"))
			{
				?><img width="100" src="<?php echo base_url().$filename.".png"; ?>"><?php
			}
			elseif(file_exists("./".$filename.".jpeg"))
			{
				?><img width="100" src="<?php echo base_url().$filename.".jpeg"; ?>"><?php
			}
			?></td>
			<td><?php echo $s->broj;?></td>
			<td><a class="delete" href="<?php echo base_url().'admin_sport/delete/'.$s->id;?>">Delete</a></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<button id="new">New sport</button><br>
<form id='target' method="post" enctype="multipart/form-data" action="<?php echo base_url("admin_sport/edit");?>">
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
$("#adminTabela tbody tr").click(function(){
	$("tr.selected").removeClass("selected");
	$(this).addClass("selected");
	$.ajax({
		url: "<?php echo base_url('ajax/smeni_sport');?>",
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