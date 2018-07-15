<div id="filter"><!-- 
	<span style="margin-left: 2%;">Sport: </span><select class="filter" id="sport_id">
		<option value="0">All sports</option>
	<?php foreach($activeSports as $s):?>
		<option value="<?php echo $s->id; ?>"><?php echo $s->ime; ?></option>
	<?php endforeach;?>
	</select>-->
	<span style="margin-left: 2%;">Period:</span><select class="filter" id="period">
		<option value="0">All time</option>
		<option value="1">Today</option>
		<option value="2">Yesterday</option>
		<option value="3" selected="selected">This Week</option>
		<option value="4">Last Week</option>
		<option value="5">This Month</option>
		<option value="6">Last Month</option>
		<option value="7">This Year</option>
		<option value="8">Last Year</option>
	</select>
	<select class="filter" id="procenti">
		<option value="0">Points</option>
		<option value="1" selected="selected">Percentage</option>
	</select>
</div>
<div id="container" class="leftcss">
	<div id="table">
		<table id="leaderboard">
			<tbody>
				<?php foreach ($lista as $t):
					if(is_numeric($t->dobivka)):?>
				<tr>
					<td id="col1"<?php echo ($t->oblozi<10)?' style="color: #333;"':'';?>>#<?php echo $t->rang;?></td>
					<td id="col2"><a href="<?php echo base_url('leaderboard/balance/'.$t->id);?>"><?php 
						echo $t->fname.' '.$t->lname; ?></a></td><!-- 
					<td id="col3"><?php echo $t->dobivka; ?></td> -->
					<td id="col3"><?php echo round($t->dobivka,2)*100; ?> %</td>
					<td id="col4">
					<?php if($user->id != $t->id):?>
						<img class="unfollow"<?php 
							echo ($t->sleden)?' style="display: block; cursor: pointer;"':' style="display: none; cursor: pointer;"';
						?> src="images/followBtnSelected.png">
						<img class="follow"<?php 
							echo ($t->sleden)?' style="display: none; cursor: pointer;"':' style="display: block; cursor: pointer;"';
						?> src="images/followBtn.png">
						<input type="hidden" id="tiper_id" value="<?php echo $t->id; ?>">
					<?php endif; ?>
					</td>
				</tr>
				<?php endif; 
				endforeach;?>
			</tbody>
		</table>
	</div>
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
$('.filter').change(function(){
	$.ajax({
		url: "<?php echo base_url()."pajax/leaderboard"?>",
		type: "POST",
		data: {sport_id: $('#sport_id').val(), period: $('#period').val(), procenti: $('#procenti').val()},
		success: function(html)
		{
			$('#table').html(html);
			myButtons();
		}
	});
});
$('#period').val(3);
$('#procenti').val(1)
$.ajax({
	url: "<?php echo base_url()."pajax/leaderboard"?>",
	type: "POST",
	data: {sport_id: $('#sport_id').val(), period: $('#period').val(), procenti: $('#procenti').val()},
	success: function(html)
	{
		$('#table').html(html);
		myButtons();
	}
});
myButtons();
</script>