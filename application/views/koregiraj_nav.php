<?php
$pomLokacija = $this->uri->segment(2);
?>
<ol class="matches">
	<li <?php echo ($pomLokacija=="")?'class="selected"':'';?>><a
		href="<?php 
	echo base_url()."admin_koregiraj"; ?>">COEFICIENT</a></li>
	<li <?php echo ($pomLokacija=="rezultat")?'class="selected"':'';?>><a
		href="<?php 
	echo base_url()."admin_koregiraj/rezultat"; ?>">RESULT</a></li>
</ol>
