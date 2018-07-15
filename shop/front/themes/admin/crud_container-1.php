<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<?php $this->load->view($this->config->item('theme_path').'includes/head.php');?>   
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<?php
                if($this->config->item('load_header')){
                    $this->load->view($this->config->item('theme_path').'includes/header.php');
                }
                ?>
                <?php $this->load->view($this->config->item('theme_path').'includes/sidebar.php');?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin page-header -->
			<h1 class="page-header"><?php echo $crud_titles['page_title'];?><br /><small><?php echo $crud_titles['page_description'];?></small></h1>
			<!-- end page-header -->
                        
                        <div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
			        </div>
			        <h4 class="panel-title"><?php echo $crud_titles['container_title'];?></h4>
			    </div>
			    <div class="panel-body">
			<iframe ALLOWTRANSPARENCY="true" src="<?php echo site_url('crud/'.$crud_controller);?>" width="100%" id="crud_table" frameborder="0"></iframe>
			        
			    </div>
			</div>
                        
                        
		</div>
		<!-- end #content -->
		
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url().$this->config->item('base_theme_path');?>assets/plugins/jquery-1.8.2/jquery-1.8.2.min.js"></script>
	<script src="<?php echo base_url().$this->config->item('base_theme_path');?>assets/plugins/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo base_url().$this->config->item('base_theme_path');?>assets/plugins/bootstrap-3.2.0/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo base_url().$this->config->item('base_theme_path');?>assets/crossbrowserjs/html5shiv.js"></script>
		<script src="<?php echo base_url().$this->config->item('base_theme_path');?>assets/crossbrowserjs/respond.min.js"></script>
		<script src="<?php echo base_url().$this->config->item('base_theme_path');?>assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo base_url().$this->config->item('base_theme_path');?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url().$this->config->item('base_theme_path');?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?php echo base_url().$this->config->item('base_theme_path');?>assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
        
</body>
</html>
