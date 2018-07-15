<div id="container" class="leftcss">	
	<div id="table">
		<div class="listmatches">
			<a href="<?php echo base_url();?>bets">
				<div class="listmatch">
					<span class="namebutton">My matches</span>
					<span class="numbermatch"><?php echo $broevi->mybets.' ( + '.$broevi->nezatvoreni;?> open )</span>
				</div>
			</a>
			<a href="<?php echo base_url();?>matches/today">
				<div class="listmatch">
					<span class="namebutton">Today's matches</span>
					<span class="numbermatch"><?php echo $broevi->denesni;?></span>
				</div>
			</a>
			<a href="<?php echo base_url();?>matches/recent">
				<div class="listmatch">
					<span class="namebutton">Most recent</span>
					<span class="numbermatch"><?php echo $broevi->recent;?></span>
				</div>
			</a>
			<a href="<?php echo base_url();?>matches/recommended">
				<div class="listmatch">
					<span class="namebutton">Recommended</span>
					<span class="numbermatch"><?php echo $broevi->recomended;?></span>
				</div>
			</a>
			<a href="<?php echo base_url();?>matches/favorites">
				<div class="listmatch">
					<span class="namebutton">From my favorites</span>
					<span class="numbermatch"><?php echo $broevi->favorite;?></span>
				</div>
			</a>
			<a href="<?php echo base_url();?>matches/following">
				<div class="listmatch">
					<span class="namebutton">From my following</span>
					<span class="numbermatch"><?php echo $broevi->following;?></span>
				</div>
			</a>
			<a href="<?php echo base_url();?>matches/top">
				<div class="listmatch">
					<span class="namebutton">From top teams</span>
					<span class="numbermatch"><?php echo $broevi->topteam;?></span>
				</div>
			</a>
			<a href="<?php echo base_url();?>matches/popular">
				<div class="listmatch">
					<span class="namebutton">Most popular</span>
					<span class="numbermatch"><?php echo $broevi->popularni;?></span>
				</div>
			</a>
		</div>
	</div>
</div>