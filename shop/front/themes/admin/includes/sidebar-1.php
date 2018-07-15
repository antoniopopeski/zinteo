<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;">
                                <img src="<?php echo base_url().$this->config->item('base_theme_path');?>assets/img/1417898810_Caucasian_boss.png" alt="" />
                            </a>
                </div>
                <div class="info">
                    <?php //echo $administrator['name'];?>
                    Vetfriend24 Administrator
                    <small>username: <strong><?php echo $administrator['username'];?></strong></small>
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">Navigation</li>
            
            
            
            
            
            
            
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-file-o"></i>
                    <span>Manage content</span>
                </a>
                <ul class="sub-menu">
                    <li><a class="endmenu" href="<?php echo site_url('admin/crud/products');?>">Products</a>
                    </li>
                    <li><a class="endmenu" href="<?php echo site_url('admin/crud/pages');?>">Static pages</a>
                    </li>
                    <li><a class="endmenu"  href="<?php echo site_url('admin/crud/menu');?>">Menu</a>
                    </li>
                </ul>
            </li>
            
            
            
            
            
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-users"></i>
                    <span>Manage vets</span>
                </a>
                <ul class="sub-menu">
                    <li><a class="endmenu" href="<?php echo site_url('admin/crud/vets');?>">Vet list</a>
                    </li>
                    <li><a class="endmenu"  href="<?php echo site_url('admin/crud/importvets');?>">Import vets</a>
                    </li>
                    <li><a class="endmenu" href="<?php echo site_url('admin/crud/coupons');?>">Coupon codes</a>
                    </li>
                </ul>
            </li>
            
            
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-user"></i>
                    <span>Users / Clients</span>
                </a>
                <ul class="sub-menu">
                    <li><a class="endmenu" href="<?php echo site_url('admin/crud/users');?>">Users</a>
                    </li>
                    <li><a class="endmenu"  href="<?php echo site_url('admin/crud/orders');?>">Orders</a>
                    </li>
                    <li><a class="endmenu" href="<?php echo site_url('admin/crud/transactions');?>">Transactions</a>
                    </li>
                </ul>
            </li>
            
            
            
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-map-marker"></i>
                    <span>Manage locations</span>
                </a>
                <ul class="sub-menu">
                    <li><a class="endmenu" href="<?php echo site_url('admin/crud/continents');?>">Continents</a>
                    </li>
                    <li><a class="endmenu"  href="<?php echo site_url('admin/crud/countries');?>">Countries</a>
                    </li>
                    <li><a class="endmenu"  href="<?php echo site_url('admin/crud/cities');?>">Cities</a>
                    </li>
                </ul>
            </li>
            
            
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-language"></i>
                    <span>Manage languages</span>
                </a>
                <ul class="sub-menu">
                    <li><a class="endmenu" href="<?php echo site_url('admin/crud/languages');?>">Languages</a>
                    </li>
                    <li><a class="endmenu"  href="<?php echo site_url('admin/crud/translations');?>">Translations</a>
                    </li>
                </ul>
            </li>
            
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-cogs"></i>
                    <span>Settings</span>
                </a>
                <ul class="sub-menu">
                    <li><a class="endmenu" href="<?php echo site_url('admin/crud/settings');?>">Site settings</a>
                    </li>
                </ul>
            </li>
            
            
            
            
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
            </li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->