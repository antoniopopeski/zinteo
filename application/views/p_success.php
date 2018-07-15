<?php
$thisYear = ( int ) date ( 'Y' );
?>
<div id="filter" style="height: auto;">
	<span style="margin-left: 2%;">Year: </span> <select class="filter"
		id="year">
		<option selected="selected" value="0">All time</option>
		<option value="<?php echo $thisYear; ?>"><?php echo $thisYear; ?></option>
		<option value="<?php echo $thisYear - 1; ?>"><?php echo $thisYear - 1; ?></option>
	</select>
</div>
<div id="container" class="leftcss">
	<div id="table"></div>
</div>
<script type="text/javascript">
$('#year').val(0);
$('#year').change(function(){
	$.ajax({
		url: "<?php echo base_url()."pajax/mostAwarded"?>",
		type: "POST",
		data: {year: $('#year').val()},
		success: function(html)
		{
			$('#table').html(html);
		}
	});
});
$.ajax({
	url: "<?php echo base_url()."pajax/mostAwarded"?>",
	type: "POST",
	data: {year: $('#year').val()},
	success: function(html)
	{
		$('#table').html(html);
	}
});
</script>