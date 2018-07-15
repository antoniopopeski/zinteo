<div id="filter">
	<select class="filter" id="sport_id">
		<option value="0">All sports</option>
		<?php foreach($sportovi as $s): ?>
		<option<?php echo ($sport_id==$s->id)?' selected="selected"':''; ?> value="<? echo $s->id; ?>"><?php
		echo $s->ime; ?></option>
		<?php endforeach; ?>
	</select>
	<select class="filter" id="drzava_id">
		<option value="0">All countries</option>
		<?php foreach($drzavi as $s): ?>
		<option value="<? echo $s->id; ?>"><?php echo $s->ime; ?></option>
		<?php endforeach; ?>
	</select>
</div>
<div id="container" class="leftcss" style="margin: 0px;">	
	<table id="tablelist" style="margin: 0px;">
		<tbody><?php
		foreach ($ligi as $o): ?>
			<tr>
				<td id="col1"><?php 
				if(file_exists('images/leagues/item_'.$o->id.'.png')):
				?><img src="<?php echo base_url().'images/leagues/item_'.$o->id.'.png';?>">
				<?php endif;?></td>
				<td id="col2"><?php echo $o->ime; ?></td>
				<td id="col3">
					<input type="hidden" id="liga_id" value="<?php echo $o->id; ?>">
					<div style="position: relative;" class="star<?php echo ($o->fav)?' favstar':''; ?>" ></div>
				</td>
			</tr><?php endforeach;?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
$('.filter').change(function(){
	$.ajax({
		url: "<?php echo base_url('pajax/championships');?>",
		type: "POST",
		data: {sport_id: $('#sport_id').val(), drzava_id: $('#drzava_id').val()},
		error: function()
		{
			$('#container').html("");
		},
		success: function(data)
		{
			$('#container').html(data);
		}
	});
});
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
		data: {liga_id: zvezda.siblings('#liga_id').val()},
		success: function(data)
		{
			if(data == 1)
			{
				if(zvezda.hasClass('favstar'))
					zvezda.removeClass('favstar');
				else
					zvezda.addClass('favstar');
			}
		}
	});
});
</script>