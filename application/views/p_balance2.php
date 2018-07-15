<div id="balans" class="leftcss">
	<div id="filter">
		<span id="balans_crno"><?php echo $user->fname." ".$user->lname;?></span>
	</div>
	<img
		src="<?php echo "http://graph.facebook.com/".$user->fb_id."/picture?type=large";?>"
		id="balans_image">
	<table>
		<tbody>
			<tr>
				<td id="balans_one"><span class="balans_span">RANK</span><br> <span
					style="color: #feda06; font-size: 25px; font-weight: bold;">#<?php echo $acc->rang;?></span>
				</td>
				<td colspan="2" style="text-align: right; padding-right: 10px; vertical-align: top;"
					height="100px;" width="66%;"><span class="balans_span">BALANCE</span><br>
					<span class="balans_span2"><?php echo round($acc->saldo, 1);?></span>
					<img id="balans_coins"
					src="<?php echo base_url('images/bottomBalanceSelected.png');?>"> <br>
				<span style="font-size: 12px; font-weight: normal;">- <?php echo round($acc->rezervirani, 1);?> reserved</span>
				</td>
			</tr>
			<tr>
				<td id="balans_one"><span class="balans_span">% OF WINNING MATCHES</span><br>
					<span class="balans_span3"><?php 
					echo ($acc->played)?round(($acc->won / $acc->played)*100, 0):0;?>%</span></td>
				<td id="balans_two"><span class="balans_span">MATCHES PLAYED</span><br>
					<span class="balans_span3"><?php echo $acc->played;?></span> <span
					style="font-size: 12px; font-weight: normal; display: block;">+ <?php echo $acc->waiting;?> waiting</span>
				</td>
				<td id="balans_three"><span class="balans_span">MATCHES GAINED</span><br>
					<span class="balans_span3"><?php echo $acc->won;?></span></td>
			</tr>
			<tr>
				<td id="balans_one"><span class="balans_span">FOLLOWING</span><br> <span
					class="balans_span3"><?php echo $acc->follow;?></span></td>
				<td id="balans_two"><span class="balans_span">FOLLOWERS</span><br> <span
					class="balans_span3"><?php echo $acc->followers;?></span></td>
				<td id="balans_three"><span class="balans_span">FAV SPORT</span><br><?php 
				echo ($acc->sport)?'<img id="fav_sport" src="'.base_url().'images/sports/item_'.$acc->sport.'.png">':'';
				?></td>
			</tr>
		</tbody>
	</table>
	<?php if($eSleden):?>
	<div id="balans_footer">
		<span style="text-transform: uppercase;">VIEW <?php echo $user->fname;?>'S BETTING HISTORY AND OPEN MATCHES</span><img
			id="button" style="cursor: pointer;"
			src="<?php echo base_url('images/played.png');?>">
	</div>
	<?php endif;?>
</div>
<?php if($eSleden):?>
<script type="text/javascript">
$('.balans_span3').css('cursor','pointer');
$('#button').click(function(){
	window.location.replace("<?php echo base_url("leaderboard/bets/".$user->id);?>");
});
$('.balans_span3').click(function(){
	window.location.replace("<?php echo base_url("leaderboard/bets/".$user->id);?>");
});
</script>
<?php endif;?>