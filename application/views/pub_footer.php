<?php 
if($this->uri->segment(1) != "fblogin" && $this->uri->segment(1) != "login" && 
	$this->uri->segment(1) != "home" && isset($user) && $user):
$lokacija = $this->uri->segment(1);
$all = "";
$rec = "";
$fav = "";
$mybets = "";
if($lokacija == "bets")
	$mybets = "Selected";

switch($this->uri->segment(2))
{
	case "all":
		$all = "Selected";
	break;
	case "recommended":
		$rec = "Selected";
	break;
	case "favorites":
		$fav = "Selected";
	break;
}
?><div class="leftcss" id="footer">
	<div class="row">
	    <div class="col" id="footer_all">
	    	<img class="footer_images" src="<?php echo base_url('images/bottomMybets'.$all.'.png');?>">
	    	<span><?php echo $info->mybets; ?></span>
	    </div>
	    <div class="col" id="footer_rec">
	    	<img class="footer_images" src="<?php echo base_url('images/bottomRecommended'.$rec.'.png');?>">
	    	<span><?php echo $info->recomended; ?></span>
	    </div>
	    <div class="col" id="footer_fav">
	    	<img class="footer_images" src="<?php echo base_url('images/bottomFavorite'.$fav.'.png');?>">
	    	<span><?php echo $info->favorite; ?></span>
	    </div>
	    <div style="border: none;" class="col" id="footer_mybets">
	    	<img class="footer_images" src="<?php echo base_url('images/bottomBalance'.$mybets.'.png');?>">
	    	<span><?php echo $info->serenje;//$user->saldo; ?></span>
	    </div>
	</div>
</div>
<?php endif;?>