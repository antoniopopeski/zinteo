<?php
$pomLokacija = $this->uri->segment(2);
?>
<ol class="matches">
	<li <?php echo ($pomLokacija=="")?'class="selected"':'';?>><a
		href="<?php 
	echo base_url()."admin_natprevari"; ?>">ALL MATCHES</a></li>
	<li <?php echo ($pomLokacija=="nezatvoreni")?'class="selected"':'';?>><a
		href="<?php 
	echo base_url()."admin_natprevari/nezatvoreni"; ?>">ALL BUT CLOSED</a></li>
	<li <?php echo ($pomLokacija=="naked")?'class="selected"':'';?>><a
		href="<?php echo base_url()."admin_natprevari/naked"; ?>">NAKED</a>
	</li>
	<li <?php echo ($pomLokacija=="missed")?'class="selected"':'';?>><a
		href="<?php echo base_url()."admin_natprevari/missed"; ?>">MISSED</a>
	</li>
	<li <?php echo ($pomLokacija=="open")?'class="selected"':'';?>><a
		href="<?php echo base_url()."admin_natprevari/open"; ?>">OPEN</a>
	</li>
	<li <?php echo ($pomLokacija=="live")?'class="selected"':'';?>><a
		href="<?php echo base_url()."admin_natprevari/live"; ?>">LIVE</a>
	</li>
	<li <?php echo ($pomLokacija=="prikraj")?'class="selected"':'';?>><a
		href="<?php echo base_url()."admin_natprevari/prikraj"; ?>">FINISH IN 30 MIN</a>
	</li>
	<li <?php echo ($pomLokacija=="zavrseni")?'class="selected"':'';?>><a
		href="<?php echo base_url()."admin_natprevari/zavrseni"; ?>">FINISHED</a>
	</li>
	<li <?php echo ($pomLokacija=="zatvoreni")?'class="selected"':'';?>><a
		href="<?php echo base_url()."admin_natprevari/zatvoreni"; ?>">CLOSED</a>
	</li>
</ol>
