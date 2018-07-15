<?php
$pomLokacija = $this->uri->segment(2);
?>
<ol class="matches">
	<li <?php echo ($pomLokacija=="")?'class="selected"':'';?>><a
		href="<?php 
	echo base_url()."admin_sampionati"; ?>">CHAMPIONSHIP</a></li>
	<li <?php echo ($pomLokacija=="select")?'class="selected"':'';?>><a
		href="<?php echo base_url()."admin_sampionati/select"; ?>">TEAMS IN CHAMPIONSHIP</a>
</ol>
