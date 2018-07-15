<div id="container" class="leftcss" style="overflow: hidden;">
	<div class="listsports">
		<?php 
		$br = 1;
		foreach($sportovi as $s): ?>
		<div class="pole">
			<input type="hidden" id="link" value="<?php echo base_url('/matches/all/'.$s->id); ?>">
			<input type="hidden" id="sport_id" value="<?php echo $s->id; ?>">
			<div id="<?php switch ($br)
			{
				case 1:
					echo 'one';
				break;
				case 2:
					echo 'two';
				break;
				case 3:
					echo 'three';
				break;
			}?>">
				<br>
				<img src="<?php echo base_url().'images/sports/item_'.$s->id.'.png'; ?>"
					height="50px" width="50px" <?php echo ($s->id==5)?'style="margin-top: -15px;"':'';?>><br>
				<span style="font-size: 15px; font-weight: bold;"><?php echo $s->ime; ?></span>
				<div class="star<?php echo ($s->fav)?' favstar':''; ?>" ></div>
			</div>
		</div>
		<?php 
		$br++;
		if($br > 3)
		{
			$br = 1;
			echo '</div><div class="listsports">';
		}
		endforeach; ?>
	</div>
	<hr class="clearing">
</div>
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
		data: {sport_id: zvezda.closest('.pole').find('#sport_id').val()},
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
$('.pole img').click(function(){
	window.location.replace($(this).closest('.pole').find('#link').val());
});
</script>