<h2>Team</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<select class="filter" id="drzava">
	<option value="0" selected="selected">ALL COUNTRIES</option>
	<?php foreach($drzavi as $d): ?>
	<option <?php echo ($selDrzava==$d->id)?'selected="selected"':'';?> value="d<?php 
		echo $d->id;?>"><?php echo $d->ime;?></option>
	<?php endforeach;?>
</select>
<select class="filter" id="sport">
	<option value="0" selected="selected">ALL SPORTS</option>
	<?php foreach($sportovi as $d): ?>
	<option <?php echo ($selSport==$d->id)?'selected="selected"':'';?> value="s<?php 
		echo $d->id;?>"><?php echo $d->ime;?></option>
	<?php endforeach;?>
</select>
<select class="filter" id="sampionat">
	<option value="0" selected="selected">ALL CHAMPIONSHIPS</option>
	<?php foreach($sampionati as $d): ?>
	<option <?php echo ($selSampionat==$d->id)?'selected="selected"':'';?> value="l<?php echo 
		$d->id;?>"><?php echo $d->ime;?></option>
	<?php endforeach;?>
</select>
<select class="filter" id="tipTim">
	<option value="0" selected="selected">ALL TEAM TYPES</option>
	<option <?php echo ($selTipTim==1)?'selected="selected"':'';?> value="1">Team</option>
	<option <?php echo ($selTipTim==2)?'selected="selected"':'';?> value="2">National team</option>
	<option <?php echo ($selTipTim==3)?'selected="selected"':'';?> value="3">Sportsman</option>
</select>
<select class="filter" id="topTim">
	<option value="0" selected="selected">TOP AND NORMAL</option>
	<option <?php echo ($selTopTim==1)?'selected="selected"':'';?> value="1">TOP</option>
	<option <?php echo ($selTopTim==2)?'selected="selected"':'';?> value="2">NORMAL</option>
</select>
<button id="reset">Reset</button>
<br><br>
<form action="<?php echo base_url('admin_tim/index')?>" method="post">
<input name="search" value="<?php echo $search;?>" type="text" style="width: 400px;">
<button id="btnSearch">Find</button>
</form>
<br><br>
<table id="adminTabela" class="dataTable">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>TEAM NAME 1</th>
			<th>TEAM NAME 2</th>
			<th>SHORT NAME</th>
			<th>TYPE</th>
			<th>SPORT</th>
			<th>COUNTRY</th>
			<th>CHAMPIONSHIPS</th>
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
			<td><?php echo $s->ime;?></td>
			<td><?php echo $s->grad;?></td>
			<td><?php echo $s->kratenka;?></td>
			<td><?php 
			switch ($s->tip) {
				case 2:
					echo "National";
				break;
				case 3:
					echo "Sportsman";
				break;
				
				default:
					echo "Team";
				break;
			}?></td>
			<td><?php echo $s->sport;?></td>
			<td><?php echo $s->drzava;?></td>
			<td><?php echo $s->sampionat;?></td>
			<td><?php
			$filename = "images/teams/item_".$s->id;
			if(file_exists("./".$filename.".png"))
			{
				?><img width="75" src="<?php echo base_url().$filename.".png"; ?>"><?php
			}
			elseif(file_exists("./".$filename.".jpeg"))
			{
				?><img width="75" src="<?php echo base_url().$filename.".jpeg"; ?>"><?php
			}
			?></td>
			<td><?php echo ($s->top)?'TOP':'';?></td>
			<td><a class="delete" href="<?php echo base_url().'admin_tim/delete/'.
				$s->id;?>">Delete</a></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<button id="new">New team</button><br>
<form id='target' method="post" enctype="multipart/form-data" action="<?php echo 
	base_url("admin_tim/edit");?>">
</form>
<div id="potvrdi-dialog"><h3>Are you sure that you want to delete this team?</h3></div>
<script type="text/javascript">
$('.filter').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/filtri');?>",
		type: "POST",
		data: {drzava: $('#drzava').val(), sport: $('#sport').val(), topTim: $('#topTim').val(),
			sampionat: $('#sampionat').val(), tipTim: $('#tipTim').val()},
		success: function(data)
		{
			window.location.replace("<?php echo base_url();?>admin_tim")
		}
	});
});
$('#reset').click(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/filtri');?>",
		type: "POST",
		data: {drzava: 0, sport: 0, topTim: 0, sampionat: 0, tipTim: 0},
		success: function(data)
		{
			window.location.reload(true);
		}
	});
});
$("#new").click(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/nov_tim');?>",
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
$("#btnSearch").click(function(){
	$('form').submit();
});
$("#adminTabela tbody tr").click(function(){
	$("tr.selected").removeClass("selected");
	$(this).addClass("selected");
	$.ajax({
		url: "<?php echo base_url('ajax/smeni_tim');?>",
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