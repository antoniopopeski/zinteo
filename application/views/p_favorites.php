<table id="tablelist" style="margin: 0px;">
	<tbody>
		<tr>
			<td id="coldate" colspan="3">
				<div>Sports</div>
				<a href="<?php echo base_url(); ?>sports"><button class="addMore">+</button></a>
			</td>
		</tr><?php foreach ($sportovi as $s): ?>
		<tr>
			<td id="col1">
				<img src="<?php echo base_url(); ?>images/sports/item_<?php echo $s->id; ?>.png">
			</td>
			<td id="col2"><?php echo $s->ime;?></td>
			<td id="col3">
				<input type="hidden" id="sport_id" value="<?php echo $s->id; ?>">
				<input type="hidden" id="team_id" value="0">
				<div style="position: relative;" class="star favstar"></div>
			</td>
		</tr><?php endforeach; ?>
		<tr>
			<td id="coldate" colspan="3">
				<div>Teams</div>
				<a href="<?php echo base_url(); ?>teams"><button class="addMore">+</button></a>
			</td>
		</tr><?php foreach ($timovi as $s): ?>
		<tr>
			<td id="col1">
				<?php if(file_exists('images/teams/item_'.$s->id.'.png')):?>
				<img src="<?php echo base_url(); ?>images/teams/item_<?php echo $s->id; ?>.png">
				<?php endif;?>
			</td>
			<td id="col2"><?php echo $s->ime;?></td>
			<td id="col3">
				<input type="hidden" id="sport_id" value="0">
				<input type="hidden" id="tim_id" value="<?php echo $s->id; ?>">
				<div style="position: relative;" class="star favstar"></div>
			</td>
		</tr><?php endforeach; ?>
	</tbody>
</table>
<script type="text/javascript">
var zvezda = null;
$('.star').click(function(){
	var favUrl = "<?php echo base_url()."pajax/favorite"?>";
	var unfavUrl = "<?php echo base_url()."pajax/unfavorite"?>";
	var ajaxUrl = "";
	zvezda = $(this);
	if(zvezda.hasClass('favstar'))
	{
		ajaxUrl = unfavUrl;
	}
	else
	{
		ajaxUrl = favUrl;
	}
	$.ajax({
		url: ajaxUrl,
		type: "POST",
		data: {sport_id: zvezda.siblings('#sport_id').val(),
			tim_id: zvezda.siblings('#tim_id').val()},
		success: function(data)
		{
			location.reload();
		}
	});
});
</script>
