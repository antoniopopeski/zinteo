<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">

<head>
    <meta charset="UTF-8">
    <title><?php echo $page['title'];?></title>

    <script src="<?php echo base_url();?>themes/front/assets/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url();?>themes/front/assets/js/jquery.smooth-scroll.js"></script>

    <link rel="stylesheet" href="<?php echo base_url();?>themes/front/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>themes/front/assets/css/media_q.css">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <script src="<?php echo base_url();?>themes/front/assets/js/main.js"></script>
    <style>
        section,
        p {
            font-size: 19px;
        }
    </style>

</head>

<body>
    <section class="menu_fixed">
        <a href="<?php echo base_url();?>">
            <img src="<?php echo base_url();?>themes/front/assets/images/logo_small_menu.png" width="9%;" style="padding: 0.5%; position:absolute; left:0;">
        </a>
        <section class="menu_content_fixed ">
            <?php //foreach($menus as $m_item){?>
<!--            <section class="menu_element "><a href="<?php echo base_url();?><?php echo $m_item['url'];?>" target="<?php echo $m_item['target'];?>"><?php echo $this->translation->lang($m_item['name'],true);?></a>
            </section>-->
             <nav id="primary_nav_wrap">
                <?php 
                foreach($menus as $m_item){    
                    ?>
                    <ul class="menu_element drop_down">
                        <?php
                            $parent  = $m_item['id'];
                        ?>
                        <li>
                        <a href="<?php echo $m_item['url'];?>" target="<?php echo $m_item['target'];?>">
                            <?php echo $this->translation->lang($m_item['name'],true);?></a>
                        <?php 
                        ?>
                            <ul>
                            <?php
                            foreach($submenus as $s_items){
                                if($s_items['parent'] == $parent){
                                ?>
                                    <li>
                                        <a href="<?php echo $s_items['url'];?>" target="<?php echo $s_items['target'];?>">
                                        <?php echo $this->translation->lang($s_items['name'],true);?></a>
                                    </li>
                                <?php
                                }
                            }
                            ?>
                            </ul>
                        </li>
                    </ul>
                    <?php 
                    }
                    ?>
                </nav>
        <?php //}?>
        </section>
    </section>
    <div class="open_responsive_fixed"><span class="responsive_span">&#9776; Menu</span>

        <div class="responsive_menu_fixed ">
            <ul>
               <?php foreach($menus as $m_item){?>
                <li><a href="<?php echo base_url();?><?php echo $m_item['url'];?>" target="<?php echo $m_item['target'];?>"><?php echo $this->translation->lang($m_item['name'],true);?></a>
                </li>
                <hr>
                <?php }?>
            </ul>
        </div>
    </div>
    <div class="wrapper">
        <div class="circle_holder">
            <div class="full-circle"></div>
        </div>
        <div class="circle_holder_right">

            <img src="<?php echo base_url();?>themes/front/assets/images/page_header_dog.png">

        </div>
        <div class="logo_page l_logo">
            <q><?php echo $this->translation->lang('slogan',true);?></q>
        </div>
        <div class="clear"></div>
        <div class="header">
            <div class="break_line">
                <hr>
            </div>
            <div class="page_menu">

                <div class="menu_content">
                    <nav id="primary_nav_wrap">
                <?php 
                foreach($menus as $m_item){    
                    ?>
                    <ul class="menu_element drop_down">
                        <?php
                            $parent  = $m_item['id'];
                        ?>
                        <li>
                        <a href="<?php echo $m_item['url'];?>" target="<?php echo $m_item['target'];?>">
                            <?php echo $this->translation->lang($m_item['name'],true);?></a>
                        <?php 
                        ?>
                            <ul>
                            <?php
                            foreach($submenus as $s_items){
                                if($s_items['parent'] == $parent){
                                ?>
                                    <li>
                                        <a href="<?php echo $s_items['url'];?>" target="<?php echo $s_items['target'];?>">
                                        <?php echo $this->translation->lang($s_items['name'],true);?></a>
                                    </li>
                                <?php
                                }
                            }
                            ?>
                            </ul>
                        </li>
                    </ul>
                    <?php 
                    }
                    ?>
                </nav>
                    <?php //foreach($menus as $m_item){?>
               
<!--                 <div class="menu_element"><a href="<?php echo base_url();?><?php echo $m_item['url'];?>"  target="<?php echo $m_item['target'];?>"><?php echo $this->translation->lang($m_item['name'],true);?></a>
                    </div>-->
                    <?php //}?>
                   
                    
                </div>
               
            </div>
            <div class="open_responsive "><span>&#9776; Menu</span>
            </div>
            <div class="responsive_menu">
                <ul>
                   <?php foreach($menus as $m_item){?>
                <li><a href="<?php echo base_url();?><?php echo $m_item['url'];?>" target="<?php echo $m_item['target'];?>"><?php echo $this->translation->lang($m_item['name'],true);?></a>
                </li>
                <hr>
                <?php }?>
                </ul>
            </div>
        </div>

        <div class="clear"></div>
        <div class="main_content">
            <div id="nutrition" class="page_nutrition">
                <div class="title">
                    <h1><?php echo $page['title'];?></h1>
                </div>
                <section>
                    <p><strong><?php echo $page['short_description'];?></strong></p>
                </section>
            </div>
            <?php if(@$page['image']){?>
            <div class="clear"></div>
            <section><img width="90%" style="margin-left:5%;margin-right:5%;" src="<?php echo base_url();?>themes/front/images/<?php echo $page['image'];?>" /></section>
            <?php }?>
            <div class="clear"></div>
            <section style="width:90%; margin-left: 5%;"><?php echo $page['body'];?></section>
            <div class="footer brown_p">
                <div class="logo_f">
                    <img src="<?php echo base_url();?>themes/front/assets/images/logo_bottom.png" style="opacity:0;">
                </div>
                <div class="copyright">
                    <p><?php echo $this->translation->lang('copyright',true);?></p>
                </div>
            </div>
        </div>
</body>

</html>