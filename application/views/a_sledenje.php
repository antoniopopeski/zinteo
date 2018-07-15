<h2>Tippers FLW, FLWRS</h2>
Created: <select class="filter" id="kreiran">
	<option <?php echo ($selKreiran=="")?'selected="selected"':'';?> value="0">ALL</option>
	<option <?php echo ($selKreiran=="year")?'selected="selected"':'';?> value="year">This year</option>
	<option <?php echo ($selKreiran=="month")?'selected="selected"':'';?> value="month">This month</option>
	<option <?php echo ($selKreiran=="week")?'selected="selected"':'';?> value="week">This week</option>
	<option <?php echo ($selKreiran=="day")?'selected="selected"':'';?> value="day">Today</option>
</select>
Last login: <select class="filter" id="logiran">
	<option <?php echo ($selLogiran=="")?'selected="selected"':'';?> value="0">ALL</option>
	<option <?php echo ($selLogiran=="year")?'selected="selected"':'';?> value="year">This year</option>
	<option <?php echo ($selLogiran=="month")?'selected="selected"':'';?> value="month">This month</option>
	<option <?php echo ($selLogiran=="week")?'selected="selected"':'';?> value="week">This week</option>
	<option <?php echo ($selLogiran=="day")?'selected="selected"':'';?> value="day">Today</option>
</select><br>
<table id="adminTabela" class="dataTable">
	<thead>
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>username</th>
			<th>following</th>
			<th>followers</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($lista as $o):?>
		<tr>
			<td></td>
			<td id="indeks"><?php echo $o->id;?></td>
			<td id="user"><?php echo $o->username;?></td>
			<td><?php echo $o->flw;?></td>
			<td><?php echo $o->flwrs;?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<div id="target"></div>
<script type="text/javascript">
$("#adminTabela tbody tr").click(function(){
	$("tr.selected").removeClass("selected");
	$(this).addClass("selected");
	var user = $(this).children("#user").html();
	$.ajax({
		url: "<?php echo base_url('ajax/tabelaSledenje');?>",
		type: "POST",
		data: {'id': $(this).children('#indeks').html(), 'username': user},
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
			    "aaSorting": [[ 1, "asc" ]],
			    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ALL"]],
			    "oLanguage": { "sEmptyTable": "No data" }
			});
		}
	});
});
$('.filter').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/filtri');?>",
		type: "POST",
		data: {tiperKreiran: $('#kreiran').val(), tiperLogiran: $('#logiran').val()},
		success: function(data)
		{
			window.location.reload(true);
		}
	});
});
$("#tipuvac").change(function(){
	$('#target').html("");
	var id = parseInt($(this).val());
	if(id>0)
	{
		var user = $('#tipuvac option:selected').text();
		$.ajax({
			url: "<?php echo base_url('ajax/tabelaSledenje');?>",
			type: "POST",
			data: {'id': id, 'username': user},
			error: function()
			{
				$('#target').html("error");
			},
			success: function(data)
			{
				$('#target').html(data);
				$("#adminTabela").dataTable({
				    "bPaginate": true,
				    "sPaginationType": "full_numbers",
				    "bLengthChange": true,
				    "iDisplayLength" : 25,
				    "bFilter": false,
				    "bSort": true,
				    "bDestroy" : true,
				    "bInfo": false,
				    "bAutoWidth": false,
				    "aaSorting": [[ 1, "desc" ]],
					"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
						var index = iDisplayIndex +1;
						$('td:eq(0)',nRow).html(index);
						return nRow;
					},
					"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }],
				    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ALL"]],
				    "oLanguage": { "sEmptyTable": "No data" }
				});
			}
		});
	}
});
</script>