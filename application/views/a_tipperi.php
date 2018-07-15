<h2>Tippers</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<table id="adminTabela" class="dataTable" style="width: 100%;">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>TIPPER USERNAME</th>
			<th>#R</th>
			<th>#R-C</th>
			<th>SALDO</th>
			<th>%</th>
			<th>FLW</th>
			<th>FWR</th>
			<th>INV</th>
			<th>M</th>
			<th>M+</th>
			<th>BT</th>
			<th>BB</th>
			<th>DATE LOGIN</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($lista as $s):
	$kraj = new DateTime($s->logiran, new DateTimeZone("Europe/Skopje"));
	$procent = 0;
	if($s->oblozi)
		$procent = round(($s->uspesni / $s->oblozi * 100), 0);
	?>
		<tr>
			<td></td>
			<td id="indeks"><?php echo $s->id;?></td>
			<td><?php echo $s->username;?></td>
			<td><?php echo $s->rang; ?></td>
			<td>0</td>
			<td><?php echo $s->dobivka;?></td>
			<td><?php echo $procent;?></td>
			<td><?php echo $s->sledi;?></td>
			<td><?php echo $s->sleden;?></td>
			<td><?php echo $s->tiperi_pokaneti;?></td>
			<td><?php echo $s->oblozi;?></td>
			<td><?php echo $s->uspesni;?></td>
			<td><?php echo $s->tiketi;?></td>
			<td <?php if(!$s->aktivBids):?>style="color: #666;"<?php endif;?>><?php echo $s->bonusBids;?></td>
			<td><?php echo $kraj->format("d-m-Y H:i:s");?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<form id='target' method="post" action="<?php echo base_url("admin_tipper/tiket");?>">
</form>
<div id="potvrdi-dialog"><h3>Are you sure that you want to delete this user?</h3></div>
<script type="text/javascript">
$("#adminTabela tbody tr").click(function(){
	$("tr.selected").removeClass("selected");
	$(this).addClass("selected");
	$.ajax({
		url: "<?php echo base_url('ajax/tiket');?>",
		type: "POST",
		data: {id: $(this).children('#indeks').html()},
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
				"fnRowCallback": function( nRow ) {
					var strana = 0;
					var table = $.fn.dataTable.fnTables(true);
					if ( table.length > 0 ) {
						strana = $(table).dataTable().fnGetPosition(nRow);
					}
					var index = strana + 1;
					$('td:eq(0)',nRow).html(index);
					return nRow;
				},
				"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }],
			    "aaSorting": [[ 1, "desc" ]],
			    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ALL"]],
			    "oLanguage": { "sEmptyTable": "No data" }
			});
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