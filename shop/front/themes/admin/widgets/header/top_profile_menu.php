<li class="dropdown navbar-user">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
        <img src="<?php echo base_url() . $this->config->item('base_theme_path'); ?>assets/img/1417898810_Caucasian_boss.png" alt="" />
        <span class="hidden-xs"><?php// echo $administrator['name'];?>Vetfirend24 Administrator</span>  <b class="caret"></b>
    </a>
    <ul class="dropdown-menu animated fadeInLeft">
        <li class="arrow"></li>
        <?php foreach ($this->config->item('profile_menu') as $menu_item) { ?>
            <?php if (@$menu_item['separated']) { ?>
                <li class="divider"></li>
                <?php } ?>
                <?php if (@$menu_item['text']) { ?>
                <li><a href="<?php echo @$menu_item['link']; ?>"><?php echo @$menu_item['text']; ?></a></li>
            <?php } ?>
        <?php } ?>
    </ul>
</li>