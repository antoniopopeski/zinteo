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
    <div id="page-loader" class="fade in"><span class="spinner"></span>
    </div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <?php
        if($this->config->item('load_header')){
            $this->load->view($this->config->item('theme_path').'includes/header.php');
        }
        ?>
        <?php $this->load->view($this->config->item('theme_path').'includes/sidebar.php');?>
        <?php //$this->load->view($this->config->item('theme_path').'pages/dashboard.php');?>


        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->

    <?php $this->load->view($this->config->item('theme_path').'includes/footer_scripts.php');?>

    <script>
        $(document).on('ready', function () {
            App.init();
            $('.endmenu:contains("Products")').trigger('click');
            window.location=$('.endmenu:contains("Products")').attr('href');
            try {
                DashboardV2.init();
            } catch (e) {}
        });
    </script>
</body>

</html>
