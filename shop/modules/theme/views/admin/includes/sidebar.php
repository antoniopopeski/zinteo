<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%" style="background: #54390E;">
		<!-- begin sidebar user -->
		<ul class="nav">
			<li class="nav-profile">
				<div class="image">
					<a href="javascript:;"><img src="/assets/img/user-13.jpg" alt="" /></a>
				</div>
				<div class="info">
					<?php echo Admins::getCurrent()->getName()?>
				</div>
			</li>
		</ul>
		<!-- end sidebar user -->
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="nav-header">Navigation</li>

			<li class="has-sub expand"><a href="javascript:;" style="background: #54390E;"> <b
					class="caret pull-right"></b> <i class="fa fa-laptop"></i> <span><?php  echo lang("Products")?></span>
			</a>
				<ul class="sub-menu" style="display: block;background: #54390E;" >
				<li class="" style="background: #54390E;"><a href="<?php echo base_url()?>admin/orders"><?php echo lang("Orders")?></a></li>
					<li><a href="<?php echo base_url()?>admin/productscategory/"><?php echo lang("Brands")?></a></li>
					<li class=""><a href="<?php echo base_url()?>admin/products/"><?php echo lang("Products")?></a></li>
					<li class=""><a href="<?php echo base_url()?>admin/warehouse"><?php echo lang("Warehous & Logs")?></a></li>
					<li class=""><a href="<?php echo base_url()?>admin/vats"><?php echo lang("Vat")?></a></li>
					<li class=""><a href="<?php echo base_url()?>admin/users/"><?php echo lang("Users")?></a></li>
					<li class=""><a href="<?php echo base_url()?>admin/users/insert"><?php echo lang("Add new user")?></a></li>
					<li class=""><a href="<?php echo base_url()?>admin/vets"><?php echo lang("Veterinarian suggestions")?></a></li>
					<li class=""><a href="<?php echo base_url()?>admin/city"><?php echo lang("Cities")?></a></li>
					<li class=""><a href="<?php echo base_url()?>admin/translate/lang/de"><?php echo lang("Translation - German")?></a></li>
					<li class=""><a href="<?php echo base_url()?>admin/translate/lang/pl"><?php echo lang("Translation - Polish")?></a></li>
				</ul></li>

				<li class="has-sub expand">
					<a href="/admin/crud/products" style="background: #54390E;">
						<i class="fa fa-laptop"></i> 
						<span>To the Root Admin -></span></a>
				</li>



			<!-- begin sidebar minify button -->
			<li><a href="#" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-arrow"></i></a></li>
			<!-- end sidebar minify button -->
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>