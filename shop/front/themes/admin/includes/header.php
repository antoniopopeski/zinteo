<!-- begin #header -->
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <!-- begin container-fluid -->
    <div class="container-fluid">
        <!-- begin mobile sidebar expand / collapse button -->
        <div class="navbar-header">
            <a href="<?php echo base_url(); ?>" class="navbar-brand"><?php if ($this->config->item('show_logo')) { ?><span class="navbar-logo"></span> <?php } ?><?php echo $this->config->item('app_name'); ?></a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- end mobile sidebar expand / collapse button -->

        <!-- begin header navigation right -->
        <ul class="nav navbar-nav navbar-right">
            <?php
            if ($this->config->item('load_widget_search')) {
                $this->load->view($this->config->item('theme_path').'widgets/header/search.php');
            }
            ?>
            <?php if ($this->config->item('load_widget_notifications')) { 
                $this->load->view($this->config->item('theme_path').'widgets/header/notifications.php');
            } 
            ?>

            <?php if ($this->config->item('load_widget_profile_menu')) { 
                $this->load->view($this->config->item('theme_path').'widgets/header/top_profile_menu.php');
            } 
            ?>
            
        </ul>
        <!-- end header navigation right -->
    </div>
    <!-- end container-fluid -->
</div>
<style>
.nav { font-size:15px !important }            
</style>
<!-- end #header -->
