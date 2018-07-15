<?php
$this->load->helper("periodi");
$thisYear = ( int ) date ( 'Y' );
$maxWeeks = getWeeksInYear ( $thisYear );
?>
<div id="filter" style="height: auto;">
	<span style="margin-left: 2%;">Year: </span> <select class="filter"
		id="year">
		<option selected="selected" value="<?php echo $thisYear; ?>"><?php echo $thisYear; ?></option>
		<option value="<?php echo $thisYear - 1; ?>"><?php echo $thisYear - 1; ?></option>
	</select>
	<select class="filter" id="procenti">
		<option value="0" selected="selected">Points</option>
		<option value="1">Percentage</option>
	</select>
</div>
<div id="container" class="leftcss">
	<span style="margin-left: 2%;margin-top:10px;text-align: left;display: block;"><?php echo $uslov; ?></span>
	<div id="table" style="text-align: left;padding-left: 2%;"></div>
</div>
<script type="text/javascript">
$('.filter').change(function(){
	$.ajax({
		url: "<?php echo base_url()."pajax/awarded"?>",
		type: "POST",
		data: {year: $('#year').val(), procenti: $('#procenti').val()},
		success: function(html)
		{
			$('#table').html(html);
		}
	});
});
$.ajax({
	url: "<?php echo base_url()."pajax/awarded"?>",
	type: "POST",
	data: {year: $('#year').val(), procenti: $('#procenti').val()},
	success: function(html)
	{
		$('#table').html(html);
	}
});
</script>