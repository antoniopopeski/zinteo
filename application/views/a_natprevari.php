<h2>All matches</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;
if($this->uri->segment(2) == ""): ?>
<select class="filter" id="drzava">
	<option value="0" selected="selected">ALL COUNTRIES</option>
	<?php foreach($drzavi as $d): ?>
	<option <?php echo ($selDrzava==$d->id)?'selected="selected"':'';?> value="d<?php echo $d->id;?>"><?php 
		echo $d->ime;?></option>
	<?php endforeach;?>
</select>
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
</select>
Start Date <input class="filter date" id="startDate" value="<?php 
if($startDate)
{
	$date = new DateTime($startDate, new DateTimeZone("Europe/Skopje"));
	echo $date->format("d M Y");
}?>" style="width: 90px;">
End Date <input class="filter date" id="endDate" value="<?php 
if($endDate)
{
	$date = new DateTime($endDate, new DateTimeZone("Europe/Skopje"));
	echo $date->format("d M Y");
}?>" style="width: 90px;">
<button id="reset">Reset</button>
<!-- 
Starts after <select class="filter" id="days">
	<option value="0" selected="selected">ANY</option>
	<option <?php echo ($selTim==1)?'selected="selected"':'';?> value="1">24 Hours</option>
	<option <?php echo ($selTim==2)?'selected="selected"':'';?> value="1">48 Hours</option>
	<option <?php echo ($selTim==7)?'selected="selected"':'';?> value="1">7 Days</option>
</select> -->
<br>
<?php elseif($this->uri->segment(2) == "open"): ?>
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
</select>
<select class="filter" id="sampionat">
	<option value="0" selected="selected">ALL CHAMPIONSHIPS</option>
	<?php foreach($sampionati as $d): ?>
	<option <?php echo ($selSampionat==$d->id)?'selected="selected"':'';?> value="l<?php echo $d->id;?>"><?php 
		echo $d->ime;?></option>
	<?php endforeach;?>
</select>
<button id="reset">Reset</button>
<br>
<?php 
endif;
include 'natprevari_nav.php';?>
<br><br>
<table id="adminTabela" class="dataTable" style="width: 100%;">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>SPORT</th>
			<th>HOME TEAM</th>
			<th>AWAY TEAM</th>
			<th>FINAL</th>
			<th>HALF</th>
			<th>DATE</th>
			<th>TIME START</th>
			<th>TIME END</th>
			<th>ENDING</th>
			<th>CHAMPIONSHIP</th>
			<th>ROUND</th>
			<th>STATUS</th>
			<th>VIS</th>
			<th>BETS</th>
			<th></th>
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
			$status = "Naked";/*
		elseif(!$s->koef && $denes > $pocetok)
			$status = "Missed";*/
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
				echo "#458B00";
			break;
			default:
				echo "#000";
			break;
		}
		?>">
			<td></td>
			<td id="indeks"><?php echo $s->id;?></td>
			<td><?php
			$filename = "images/sports/item_".$s->sport_id;
			if(file_exists("./".$filename.".png"))
			{
				?><img width="25" height="auto" src="<?php echo base_url().$filename.".png"; ?>"><?php
			}
			elseif(file_exists("./".$filename.".jpg"))
			{
				?><img width="25" height="auto" src="<?php echo base_url().$filename.".jpg"; ?>"><?php
			}
			?></td>
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
			<td><?php echo $s->kolo;?></td>
			<td><?php echo (!$s->koef && $status!="Naked")?'<span style="color: #987e00;">*</span>'.$status:$status;?></td>
			<td><?php echo ($vidliv < $denes && $s->koef)?'YES':'NO';?></td>
			<td><?php echo $s->oblozi;?></td>
			<td><a class="delete" href="<?php echo base_url().'admin_natprevari/delete/',$s->id;?>">DEL</a></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<form id='target' method="post" action="<?php echo base_url("admin_natprevari/edit");?>">
</form>
<div id="potvrdi-dialog"><h3>Are you sure that you want to delete this match?</h3></div>
<script type="text/javascript">
$('.date').datepicker({dateFormat: "dd M yy"});
<?php if($this->uri->segment(2) == ""): ?>
$('#reset').click(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/filtri');?>",
		type: "POST",
		data: {sampionat: 0, tim: 0, startDate: 0, endDate: 0},
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
		data: {sampionat: $('#sampionat').val(), tim: $('#tim').val(),
			startDate: $('#startDate').val(), endDate: $('#endDate').val()},
		success: function(data)
		{
			window.location.reload(true);
		}
	});
});
<?php elseif($this->uri->segment(2) == "open"): ?>
$('.filter').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/filtri');?>",
		type: "POST",
		data: {drzava: $('#drzava').val(), sport: $('#sport').val(), sampionat: $('#sampionat').val()},
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
		data: {drzava: 0, sport: 0, sampionat: 0},
		success: function(data)
		{
			window.location.reload(true);
		}
	});
});
<?php endif; ?>
/*
$("#new").click(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/nov_natprevar');?>",
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
});*/
function efekti()
{
	$("#adminTabela tbody tr").click(function(){
		$("tr.selected").removeClass("selected");
		$(this).addClass("selected");
		$.ajax({
			url: "<?php echo base_url('ajax/smeni_natprevar');?>",
			type: "POST",
			data: {id: $(this).children('td:eq(1)').html()},
			error: function()
			{
				$('#target').html("error");
			},
			success: function(data)
			{
				$('#target').html(data);
				$(".addon").dataTable({
				    "bPaginate": true,
				    "sPaginationType": "full_numbers",
				    "bLengthChange": true,
				    "iDisplayLength" : 25,
				    "bFilter": false,
				    "bSort": true,
				    "bDestroy" : true,
				    "bInfo": false,
				    "bAutoWidth": false,
					"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
						var table = $.fn.dataTable.fnTables(true);
						var oSettings = $(table).dataTable().fnSettings();
						//var strana = Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength) + 1;
						if ( table.length > 0 ) {
							strana = $(table).dataTable().fnGetPosition(nRow);
						}
						var index = oSettings._iDisplayStart + iDisplayIndex + 1;//strana + 1;
						$('td:eq(0)',nRow).html(index);
					},
					"aoColumns": [{ "bSortable": false, "aTargets": [ 0 ] },
									{ "bSortable": true, "aTargets": [ 1 ] },
									{ "bSortable": true, "aTargets": [ 2 ] },
									{ "bSortable": true, "aTargets": [ 3 ] },
									{ "bSortable": true, "aTargets": [ 4 ] },
									{ "bSortable": false, "aTargets": [ 5 ] },
									{ "bSortable": false, "aTargets": [ 6 ] },
									{ "bSortable": false, "aTargets": [ 7 ] },
									{ "bSortable": false, "aTargets": [ 8 ] },
									{ "bSortable": false, "aTargets": [ 9 ] },
									{ "bSortable": false, "aTargets": [ 10 ] },
									{ "bSortable": false, "aTargets": [ 11 ] },
									{ "bSortable": false, "aTargets": [ 12 ] },
									{ "bSortable": false, "aTargets": [ 13 ] },
									{ "bSortable": false, "aTargets": [ 14 ] },
									{ "bSortable": false, "aTargets": [ 15 ] },
									{ "bSortable": false, "aTargets": [ 16 ] },
									{ "bSortable": false, "aTargets": [ 17 ] },
									{ "bSortable": false, "aTargets": [ 18 ] },
									{ "bSortable": false, "aTargets": [ 19 ] },
									{ "bSortable": false, "aTargets": [ 20 ] },
									{ "bSortable": false, "aTargets": [ 21 ] },
									{ "bSortable": false, "aTargets": [ 22 ] }],
				    "aaSorting": [[ 1, "asc" ]],
				    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ALL"]],
				    "oLanguage": { "sEmptyTable": "No data" }
				});
			}
		});
	});
	$('.delete').click(function(e){
	    e.preventDefault();
	    $("#potvrdi-dialog").dialog('option', 'href', $(this).attr('href')).dialog('open');
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
}
</script>