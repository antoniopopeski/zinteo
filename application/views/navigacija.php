<?php
if($this->uri->segment(1) != "fblogin" && $this->uri->segment(1) != "login" &&
 $this->uri->segment(1) != "")
:
	$lokacija = $this->uri->segment(1);
	?>
<ul class="mainNav">
	<?php
	
$path = realpath('./images/') . '/';
	if(file_exists($path . $settings->slika))
	:
		?><li><img
		src="<?php
		echo base_url() . 'images/' . $settings->slika;
		?>"
		width="100%" height="auto"></li>
	<?php
	endif;
	if(isset($uredil) && $uredil->uloga)
	:
		?>
	<?php if($uredil->uloga > 1): ?>
	<li <?php echo ($lokacija=="admin_home")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_home">Dashboard</a></li>
	<li <?php echo ($lokacija=="admin_sport")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_sport">Sports</a></li>
	<li <?php echo ($lokacija=="admin_drzavi")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_drzavi">Countries</a></li>
	<li <?php echo ($lokacija=="admin_sampionati")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_sampionati">Championships</a></li>
	<li <?php echo ($lokacija=="admin_sezona")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_sezona">Seasons</a></li>
	<li <?php echo ($lokacija=="admin_kolo")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_kolo">Rounds</a></li>
	<li <?php echo ($lokacija=="admin_tim")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_tim">Teams</a></li>
	<li <?php echo ($lokacija=="admin_tipper")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_tipper">Tippers</a></li>
	<li <?php echo ($lokacija=="admin_sledenje")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_sledenje">Tippers FLW, FLWRS</a></li>
	<li <?php echo ($lokacija=="admin_tiket")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_tiket">Bonus bids</a></li>
	<li <?php echo ($lokacija=="admin_reports")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_reports">Reports</a></li>
	<li <?php echo ($lokacija=="admin_koregiraj")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_koregiraj">Corrections</a></li>
	<?php endif;?>
	<li <?php echo ($lokacija=="admin_natprevari")?'class="selected"':"";?>><a
		href="<?php
		echo base_url();
		?>admin_natprevari">Matches</a></li>
	<li <?php echo ($lokacija=="admin_multiple")?'class="selected"':"";?>><a
		href="<?php
		echo base_url();
		?>admin_multiple">Add multiple matches</a></li>
	<li <?php echo ($lokacija=="admin_single")?'class="selected"':"";?>><a
		href="<?php
		echo base_url();
		?>admin_single">Add single match with coeficients</a></li>
	<li
		<?php echo ($lokacija=="admin_koeficienti")?'class="selected"':"";?>><a
		href="<?php
		echo base_url();
		?>admin_koeficienti">Set coeficients</a></li>
	<li <?php echo ($lokacija=="admin_multicoef")?'class="selected"':"";?>><a
		href="<?php
		echo base_url();
		?>admin_multicoef">Add multiple coeficients</a></li>
	<li <?php echo ($lokacija=="admin_rezultat")?'class="selected"':"";?>><a
		href="<?php
		echo base_url();
		?>admin_rezultat">Add scores</a></li>
	<?php if($uredil->uloga == 3):?>
	<li <?php echo ($lokacija=="admin_poraki")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_poraki">Sentences</a></li>
	<li <?php echo ($lokacija=="admin_users")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_users">Users</a></li>
	<li <?php echo ($lokacija=="admin_settings")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_settings">Settings</a></li>
	<li <?php echo ($lokacija=="admin_pages")?'class="selected"':"";?>><a
		href="<?php
			echo base_url();
			?>admin_pages">Info pages</a></li>
	<?php endif;?>
	<li><a href="<?php echo base_url();?>logout">Logout</a></li>
	
	<?php endif;

	endif;
?>
</ul>