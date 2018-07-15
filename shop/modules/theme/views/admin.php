<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8" />
<title><?php  echo $page_title ?> | Vetfriend Shop Administration</title>
<meta
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
	name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />

<!-- ================== BEGIN BASE CSS STYLE ================== -->
<link
	href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
	rel="stylesheet">
<link
	href="<?php echo base_url()?>/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css"
	rel="stylesheet" />
<link
	href="<?php echo base_url()?>/assets/plugins/bootstrap/css/bootstrap.min.css"
	rel="stylesheet" />
<link
	href="<?php echo base_url()?>/assets/plugins/font-awesome/css/font-awesome.min.css"
	rel="stylesheet" />
<link href="<?php echo base_url()?>/assets/css/animate.min.css"
	rel="stylesheet" />
<link href="<?php echo base_url()?>/assets/css/style.min.css"
	rel="stylesheet" />
<link href="<?php echo base_url()?>/assets/css/style-responsive.min.css"
	rel="stylesheet" />
<link
	href="<?php echo base_url()?><?php echo base_url()?>/assets/css/theme/default.css"
	rel="stylesheet" id="theme" />
<!-- ================== END BASE CSS STYLE ================== -->

<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
<link
	href="<?php echo base_url()?>/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css"
	rel="stylesheet" />
<link
	href="<?php echo base_url()?>/assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css"
	rel="stylesheet" />
<link
	href="<?php echo base_url()?>/assets/plugins/gritter/css/jquery.gritter.css"
	rel="stylesheet" />
<link href="<?php echo base_url()?>/assets/plugins/morris/morris.css"
	rel="stylesheet" />
<link
	href="<?php echo base_url()?>/assets/plugins/DataTables/css/data-table.css"
	rel="stylesheet" />
<!-- ================== END PAGE LEVEL CSS STYLE ================== -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo base_url()?>/assets/plugins/pace/pace.min.js"></script>
<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>
<!-- ================== END BASE JS ================== -->
<style>
body {
	font-size: 150%;
	color: black!important;
}

.navbar {
	min-height: 70px !important
}
</style>
</head>
<body>


	<!-- begin #page-container -->
	<div id="page-container"
		class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<?php print view("../theme/admin/includes/header", $data)?>
		<!-- end #header -->

		<!-- begin #sidebar -->
		<?php print view("../theme/admin/includes/sidebar", $data)?>
		<!-- end #sidebar -->

		<!-- begin #content -->
		<div id="content" class="content">
		<?php //print view("../theme/admin/includes/breadcrumbs", $data)?>
		<?php print view($main, $data)?>
		</div>
		<!-- end #content -->

		<!-- begin theme-panel -->
		<!-- 
        <div class="theme-panel">
            <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
            <div class="theme-panel-content">
                <h5 class="m-t-0">Color Theme</h5>
                <ul class="theme-list clearfix">
                    <li class="active"><a href="javascript:;" class="bg-green" data-theme="default" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Default">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-red" data-theme="red" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Red">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-blue" data-theme="blue" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Blue">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-purple" data-theme="purple" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Purple">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-orange" data-theme="orange" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Orange">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-black" data-theme="black" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Black">&nbsp;</a></li>
                </ul>
                <div class="divider"></div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">Header Styling</div>
                    <div class="col-md-7">
                        <select name="header-styling" class="form-control input-sm">
                            <option value="1">default</option>
                            <option value="2">inverse</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label">Header</div>
                    <div class="col-md-7">
                        <select name="header-fixed" class="form-control input-sm">
                            <option value="1">fixed</option>
                            <option value="2">default</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">Sidebar Styling</div>
                    <div class="col-md-7">
                        <select name="sidebar-styling" class="form-control input-sm">
                            <option value="1">default</option>
                            <option value="2">grid</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label">Sidebar</div>
                    <div class="col-md-7">
                        <select name="sidebar-fixed" class="form-control input-sm">
                            <option value="1">fixed</option>
                            <option value="2">default</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">Sidebar Gradient</div>
                    <div class="col-md-7">
                        <select name="content-gradient" class="form-control input-sm">
                            <option value="1">disabled</option>
                            <option value="2">enabled</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">Content Styling</div>
                    <div class="col-md-7">
                        <select name="content-styling" class="form-control input-sm">
                            <option value="1">default</option>
                            <option value="2">black</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-12">
                        <a href="#" class="btn btn-inverse btn-block btn-sm" data-click="reset-local-storage"><i class="fa fa-refresh m-r-3"></i> Reset Local Storage</a>
                    </div>
                </div>
            </div>
        </div>
         -->
		<!-- end theme-panel -->

		<!-- begin scroll to top btn -->
		<a href="javascript:;"
			class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
			data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script
		src="<?php echo base_url()?>/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script
		src="<?php echo base_url()?>/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script
		src="<?php echo base_url()?>/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script
		src="<?php echo base_url()?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo base_url()?>/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="<?php echo base_url()?>/assets/crossbrowserjs/respond.min.js"></script>
		<script src="<?php echo base_url()?>/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script
		src="<?php echo base_url()?>/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script
		src="<?php echo base_url()?>/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->

	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script
		src="<?php echo base_url()?>/assets/plugins/morris/raphael.min.js"></script>
	<script src="<?php echo base_url()?>/assets/plugins/morris/morris.js"></script>
	<script
		src="<?php echo base_url()?>/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script
		src="<?php echo base_url()?>/assets/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js"></script>
	<script
		src="<?php echo base_url()?>/assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js"></script>
	<script
		src="<?php echo base_url()?>/assets/plugins/gritter/js/jquery.gritter.js"></script>
	<script src="<?php echo base_url()?>/assets/js/dashboard-v2.min.js"></script>
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url()?>/assets/js/apps.min.js"></script>
	<script src="<?php echo base_url()?>/assets/js/main.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
			DashboardV2.init();
		});
	</script>
	<style type="text/css">
		input.form-control, select.form-control{
			font-size: 14px!important;
		}
		td{
			color: #000!important;
		}
	</style>
</body>
</html>