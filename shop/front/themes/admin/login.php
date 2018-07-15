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
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login bg-black animated fadeInDown">
            <div align="center"><h1 style="color:white;">Administration login</h1></div>
            <div class="login-content">
                <?php if(@$_POST['username']){?>
                <p style="color: orange;">Invalid Username or password</p>
                <?php }?>
                <form action="<?php echo site_url('admin/login');?>" method="POST" class="margin-bottom-0">
                    <div class="form-group m-b-20">
                        <input type="text" name="username" value="<?php echo @$_POST['username'];?>" class="form-control input-lg" placeholder="Username"  style="font-size:15px !important"/>
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" name="password" class="form-control input-lg" placeholder="Password" style="font-size:15px !important" />
                    </div>
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end login -->
        
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
