<?php
if($this->uri->segment(1) != "fblogin" && $this->uri->segment(1) != "login" && isset($user) && $user)
:
	$lokacija = $this->uri->segment(1);
	?>
<ul id="menu">
	<li>Home
		<ul>
			<li><a href="<?php echo base_url();?>home">Home page</a></li>
			<li><a href="<?php echo base_url();?>matches">Matches</a></li>
			<li><a href="<?php echo base_url();?>leaderboard">Leaderboard</a></li>
			<li><a href="<?php echo base_url();?>historyboard">Leaderboard History</a></li>
			<li><a href="<?php echo base_url();?>historyboard/awarded">Awarded Bettors</a></li>
			<!-- <li><a href="<?php echo base_url();?>historyboard/successfull">Most Successful Bettors</a></li> -->
		</ul>
	</li>
	<li>My zinteo
		<ul>
			<li><a href="<?php echo base_url();?>balance">My balance</a></li>
			<li><a href="<?php echo base_url();?>bets">My bets</a></li>
			<li><a href="<?php echo base_url();?>favorites">My favorites</a></li>
			<li><a href="<?php echo base_url();?>invite">Invite friends</a></li>
			<li><a href="<?php echo base_url();?>home/dailybids">Daily bids</a></li>
			<li><a href="<?php echo base_url();?>home/country">Choose Your Country</a></li>
		</ul>
	</li>
	<li>Matches
		<ul>
			<li><a href="<?php echo base_url();?>matches/all">All matches</a></li>
			<li><a href="<?php echo base_url();?>matches/today">Today's matches</a></li>
			<li><a href="<?php echo base_url();?>matches/popular">Most popular</a></li>
			<li><a href="<?php echo base_url();?>matches/recommended">Recommended matches</a></li>
			<li><a href="<?php echo base_url();?>matches/favorites">Matches from my favorites</a></li>
			<li><a href="<?php echo base_url();?>matches/following">Matches from my followings</a></li>
			<li><a href="<?php echo base_url();?>matches/top">Matches from top teams</a></li>
		</ul>
	</li>
	<li>General
		<ul>
			<li><a href="<?php echo base_url();?>sports">Sports</a></li>
			<li><a href="<?php echo base_url();?>championships">Championships</a></li>
			<li><a href="<?php echo base_url();?>teams">Teams</a></li>
		</ul>
	</li>
	<li>Info pages
		<ul>
			<li><a href="<?php echo base_url();?>contact">Contact</a></li>
			<li><a href="<?php echo base_url();?>about">About</a></li>
			<li><a href="<?php echo base_url();?>rules">Rules</a></li>
			<li><a href="<?php echo base_url();?>awards">Awards</a></li>
			<li><a href="<?php echo base_url();?>friends">Why invite friends</a></li>
			<li><a href="<?php echo base_url();?>blog">Blog</a></li>
			<li><a href="<?php echo base_url();?>facebook">Zinteo on Facebook</a></li><!--
			<li><a href="<?php echo base_url();?>rate">Rate</a></li>
			<li><a href="<?php echo base_url();?>checkout">Checkout</a></li>-->
		</ul>
	</li>
	<li>Other
		<ul>
			<li><a href="<?php echo base_url();?>promo">Enter promo code</a></li>
			<li><a href="<?php echo base_url();?>send">Send to friend</a></li>
			<li><a href="<?php echo base_url();?>logout">Log out</a></li>
		</ul>
	</li>
</ul>
<script src="<?php echo  base_url();?>js/jquery.slicknav.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#menu').slicknav({prependTo:'#podvizno'});
});
</script>
<?php endif;?>
<?php if(false):?>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
	<h3>Home</h3>
	<a href="<?php echo base_url();?>home"><img src="<?php echo base_url();?>images/footb.png"><span>Home page</span></a>
	<a href="<?php echo base_url();?>matches"><img src="<?php echo base_url();?>images/footb.png"><span>Matches</span></a>
	<a href="<?php echo base_url();?>leaderboard"><img src="<?php echo base_url();?>images/footb.png"><span>Leaderboard</span></a>
	<h3>My finteo</h3>
	<a href="<?php echo base_url();?>home/balance"><img src="<?php echo base_url();?>images/footb.png"><span>My balance</span></a>
	<a href="<?php echo base_url();?>bets"><img src="<?php echo base_url();?>images/footb.png"><span>My bets</span></a>
	<a href="<?php echo base_url();?>favorites"><img src="<?php echo base_url();?>images/footb.png"><span>My favorites</span></a>
	<h3>Matches</h3>
	<a href="<?php echo base_url();?>matches/all"><img src="<?php echo base_url();?>images/footb.png"><span>All matches</span></a>
	<a href="<?php echo base_url();?>matches/today"><img src="<?php echo base_url();?>images/footb.png"><span>Today's matches</span></a>
	<a href="<?php echo base_url();?>matches/popular"><img src="<?php echo base_url();?>images/footb.png"><span>Most popular</span></a>
	<a href="<?php echo base_url();?>matches/recommended"><img src="<?php echo base_url();?>images/footb.png"><span>Recommended</span></a>
	<a href="<?php echo base_url();?>matches/favorites"><img src="<?php echo base_url();?>images/footb.png"><span>From my favorites</span></a>
	<a href="<?php echo base_url();?>matches/following"><img src="<?php echo base_url();?>images/footb.png"><span>From my following</span></a>
	<a href="<?php echo base_url();?>matches/top"><img src="<?php echo base_url();?>images/footb.png"><span>From top teams</span></a>
	<h3>General</h3>
	<a href="<?php echo base_url();?>sports"><img src="<?php echo base_url();?>images/footb.png"><span>Sports</span></a>
	<a href="<?php echo base_url();?>championships"><img src="<?php echo base_url();?>images/footb.png"><span>Championships</span></a>
	<a href="<?php echo base_url();?>teams"><img src="<?php echo base_url();?>images/footb.png"><span>Teams</span></a>
	<h3>Info pages</h3>
	<a href="<?php echo base_url();?>contact"><img src="<?php echo base_url();?>images/footb.png"><span>Contact</span></a>
	<a href="<?php echo base_url();?>about"><img src="<?php echo base_url();?>images/footb.png"><span>About</span></a>
	<a href="<?php echo base_url();?>rules"><img src="<?php echo base_url();?>images/footb.png"><span>Rules</span></a>
	<a href="<?php echo base_url();?>awards"><img src="<?php echo base_url();?>images/footb.png"><span>Awards</span></a>
	<a href="<?php echo base_url();?>rate"><img src="<?php echo base_url();?>images/footb.png"><span>Rate</span></a>
	<a href="<?php echo base_url();?>friends"><img src="<?php echo base_url();?>images/footb.png"><span>Invite friends</span></a>
	<a href="<?php echo base_url();?>checkout"><img src="<?php echo base_url();?>images/footb.png"><span>Checkout</span></a>
	<h3>Other</h3>
	<a href="<?php echo base_url();?>matches"><img src="<?php echo base_url();?>images/footb.png"><span>Enter promo code</span></a>
	<a href="<?php echo base_url();?>matches"><img src="<?php echo base_url();?>images/footb.png"><span>Send this app to friend</span></a>
	<a href="<?php echo base_url();?>logout"><img src="<?php echo base_url();?>images/footb.png"><span>Log out</span></a>
</nav>
<?php endif;?>