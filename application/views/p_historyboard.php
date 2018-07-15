<?php
$this->load->helper("periodi");
$thisYear = ( int ) date ( 'Y' );
$thisMonth = ( int ) date ( 'm' );
$maxWeeks = getWeeksInYear ( $thisYear );
$denes = new DateTime('now', new DateTimeZone("America/Whitehorse"));
?>
<div id="filter" style="height: auto;">
	<span style="margin-left: 2%;">Year: </span> <select class="filter"
		id="year">
		<option selected="selected" value="<?php echo $thisYear; ?>"><?php echo $thisYear; ?></option>
		<option value="<?php echo $thisYear - 1; ?>"><?php echo $thisYear - 1; ?></option>
	</select><br> <span style="margin-left: 2%;">Month: </span> <select
		class="filter" id="month">
		<option value="0" selected="selected">All</option>
		<option value="12">December</option>
		<option value="11">November</option>
		<option value="10">October</option>
		<option value="9">September</option>
		<option value="8">August</option>
		<option value="7">July</option>
		<option value="6">June</option>
		<option value="5">May</option>
		<option value="4">April</option>
		<option value="3">March</option>
		<option value="2">February</option>
		<option value="1">January</option>
	</select><br> <span style="margin-left: 2%;">Week: </span> <select
		class="filter" id="week">
		<option value="0" selected="selected">All</option>
		<?php
		for($i = $maxWeeks; $i > 0; $i --) :
			$datumi = getWeek($i, $thisYear, "America/Whitehorse", "America/Whitehorse");
			$monday = $datumi [0];
			$sunday = $datumi [1];
			if($denes > $monday):
			?>
		<option value="<?php echo $i;?>"><?php
			echo "Week" . $i . " " . $thisYear . " (" . $monday->format ( "d" ) . " " . $monday->format ( "M" ) . " - " . $sunday->format ( "d" ) . " " . $sunday->format ( "M" ) . ")";
			?></option><?php
			endif;
		endfor;
		?>
	</select><br> <span style="margin-left: 2%;">Points or Percentage: </span>
	<select class="filter" id="procenti">
		<option value="0" selected="selected">Points</option>
		<option value="1">Percentage</option>
	</select>
</div>
<div id="container" class="leftcss">
	<div id="table"></div>
</div>
<script type="text/javascript">
function myButtons()
{
	$('.follow').click(function(){
		var caller = $(this);
		$.ajax({
			url: "<?php echo base_url()."pajax/follow"?>",
			type: "POST",
			data: {sledi: $(this).siblings('#tiper_id').val()},
			success: function(data)
			{
				if(data == 1)
				{
					caller.siblings('.unfollow').css('display','block');
					caller.css('display','none');
				}
			}
		});
	});
	$('.unfollow').click(function(){
		var caller = $(this);
		$.ajax({
			url: "<?php echo base_url()."pajax/unfollow"?>",
			type: "POST",
			data: {sledi: $(this).siblings('#tiper_id').val()},
			success: function(data)
			{
				if(data == 1)
				{
					caller.siblings('.follow').css('display','block');
					caller.css('display','none');
				}
			}
		});
	});
}
var options = [];
$('#month option').each(function(){
    options.push($(this));
});
function srediMeseci()
{
	var godina = parseInt($('#year').val());
	$('#month').html('');
	if(godina==<?php echo $thisYear;?>)
	{
		for(var i = 0; i < options.length; i++)
		{
			if(options[i].val()<=<?php echo $thisMonth?>)
				$('#month').append('<option value="'+options[i].val()+'">'+options[i].text()+'</option>');
		}
	}
	else
	{
		for(var i = 0; i < options.length; i++)
		{
			$('#month').append('<option value="'+options[i].val()+'">'+options[i].text()+'</option>');
		}
	}
}
srediMeseci();
$('#year').change(function(){
	srediMeseci();
	$('#month').val(0);
	$('#procenti').val(0);
	$.ajax({
		url: "<?php echo base_url()."pajax/weeksOfYear"?>",
		type: "POST",
		data: {year: $('#year').val()},
		success: function(html)
		{
			$('#week').html(html);
			$.ajax({
				url: "<?php echo base_url()."pajax/leaderboard"?>",
				type: "POST",
				data: {year: $('#year').val(), month: 0, week: $('#week').val(), procenti: 0},
				success: function(html)
				{
					$('#table').html(html);
					myButtons();
				}
			});
		}
	});
});
$('#month').change(function(){
	$('#week').val(0);
	$.ajax({
		url: "<?php echo base_url()."pajax/leaderboard"?>",
		type: "POST",
		data: {year: $('#year').val(), month: $('#month').val(), week: 0, procenti: $('#procenti').val()},
		success: function(html)
		{
			$('#table').html(html);
			myButtons();
		}
	});
});
$('#week').change(function(){
	$('#month').val(0);
	$.ajax({
		url: "<?php echo base_url()."pajax/leaderboard"?>",
		type: "POST",
		data: {year: $('#year').val(), month: 0, week: $('#week').val(), procenti: $('#procenti').val()},
		success: function(html)
		{
			$('#table').html(html);
			myButtons();
		}
	});
});
$('#procenti').change(function(){
	$.ajax({
		url: "<?php echo base_url()."pajax/leaderboard"?>",
		type: "POST",
		data: {year: $('#year').val(), month: $('#month').val(), week: $('#week').val(), procenti: $('#procenti').val()},
		success: function(html)
		{
			$('#table').html(html);
			myButtons();
		}
	});
});
$.ajax({
	url: "<?php echo base_url()."pajax/leaderboard"?>",
	type: "POST",
	data: {year: $('#year').val(), month: $('#month').val(), week: $('#week').val(), procenti: $('#procenti').val()},
	success: function(html)
	{
		$('#table').html(html);
		myButtons();
	}
});
</script>