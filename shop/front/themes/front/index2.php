<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

<head>
    <meta charset="UTF-8">
    <title>Vet Friend 24 -
        <?php echo $this->translation->lang('slogan',true);?></title>
    <script src="<?php echo base_url();?>themes/front/assets/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url();?>themes/front/assets/js/jquery.smooth-scroll.js"></script>

    <link rel="stylesheet" href="<?php echo base_url();?>themes/front/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>themes/front/assets/css/media_q.css">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <script src="<?php echo base_url();?>themes/front/assets/js/main.js"></script>
</head>

<body>
    <section class="menu_fixed">
        <a href="<?php echo site_url();?>" class="scroll_page">
            <img src="<?php echo base_url();?>themes/front/assets/images/logo_small_menu.png" width="9%;" style="padding: 0.5%; position:absolute; left:0;">
        </a>
        <section class="menu_content_fixed ">
            <nav id="primary_nav_wrap">
                    <?php 
                    foreach($menus as $m_item){
                        
                        ?>
                    <ul class="menu_element ">
                        <?php
                            $parent  = $m_item['id'];
                        ?>
                        <li>
                        <a class="external_link" href="<?php echo $m_item['url'];?>" target="<?php echo $m_item['target'];?>">
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
            <?php // foreach($menus as $m_item){?>
<!--            <section class="menu_element">
                <a href="<?php //echo $m_item['url'];?>" target="<?php //echo $m_item['target'];?>">
                    <?php //echo $this->translation->lang($m_item['name'],true);?></a>
            </section>-->
            <?php // }?>
        </section>
    </section>
    <div class="open_responsive_fixed"><span class="responsive_span">&#9776; <?php echo $this->translation->lang('menu',true);?></span>

        <div class="responsive_menu_fixed ">
            <ul>
                <?php foreach($menus as $m_item){?>
                <li>
                    <a class="external_link" href="<?php echo $m_item['url'];?>" target="<?php echo $m_item['target'];?>">
                        <?php echo $this->translation->lang($m_item['name'],true);?></a>
                </li>
                <hr>
                <?php }?>
            </ul>
        </div>
    </div>
    <section class="wrapper ">

        <div class="contact_form">
            <h2>ASK AN EXPERT</h2>
            <div class="first_row">
                <div class="first_column">
                    <div class="name"><span>Name</span>
                        <input type="text">
                    </div>
                </div>
                <div class="second_column">
                    <div class="email"><span>Email</span>
                        <input type="email" required>
                    </div>
                </div>
            </div>
            <div class="second_row">
                <label for="question">Question</label>
                <textarea id="question" rows="7" cols="50" required></textarea>
            </div>
            <div class="submit_button send_q">
                <span>SEND</span>
            </div>
        </div>

        <section class="logo l_logo"></section>
        <section class="header ">

            <section class="header_img ">
                <span><?php echo $this->translation->lang('slogan',true);?></span>
                <img src="<?php echo base_url();?>themes/front/assets/images/header_img.jpg " width="100% ">

            </section>
            <section class="clear "></section>
            <section class="menu ">
                <section class="menu_content ">
                    <nav id="primary_nav_wrap">
                    <?php 
                    foreach($menus as $m_item){
                        
                        ?>
                    <ul class="menu_element">
                        <?php
                            $parent  = $m_item['id'];
                        ?>
                        <li>
                        <a class="external_link" href="<?php echo $m_item['url'];?>" target="<?php echo $m_item['target'];?>">
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
                </section>
            </section>
            <div class="open_responsive "><span class="responsive_span">&#9776; <?php echo $this->translation->lang('menu',true);?></span>
            </div>
            <div class="responsive_menu ">
                <ul>
                    <?php foreach($menus as $m_item){?>
                    <li>
                        <a href="<?php echo $m_item['url'];?>" target="<?php echo $m_item['target'];?>">
                            <?php echo $this->translation->lang($m_item['name'],true);?></a>
                    </li>
                    <hr>
                    <?php }?>
                </ul>
            </div>
        </section>
        <section class="clear "></section>
        <section class="main_content ">
            <section class="content_green ">
                <section class="title ">
                    <h1><?php echo $this->translation->lang('what_is_vetfriend',true);?></h1>
                </section>
                <section class="content_desc ">
                    <p>
                        <?php echo $this->translation->lang('what_is_vetfriend_text',true);?></p>
                </section>
                <section class="paw ">
                    <img src="<?php echo base_url();?>themes/front/assets/images/logo_s_white.png ">
                </section>
            </section>
            <div id="nutrition"></div>
            <section class="content_white ">
                <section class="title ">
                    <h1><?php echo $this->translation->lang('NUTRITION',true);?></h1>
                </section>
                <section class="content_desc ">
                    <img src="<?php echo base_url();?>themes/front/assets/images/nutrition_dogs.png " width="80% ">
                    <p>
                        <?php echo $this->translation->lang('NUTRITION_TEXT',true);?></p>
                </section>
                <section class="paw ">
                    <img src="<?php echo base_url();?>themes/front/assets/images/logo_s.png ">
                </section>
            </section>
            <section class="above_title ">
                <section class="title_image ">
                    <img src="<?php echo base_url();?>themes/front/assets/images/OSTEOARTHITIS_dog.png " width="100% ">
                </section>
            </section>
            <div id="ost"></div>
            <section class="content_orange ">
                <section class="title ">
                    <h1><?php echo $this->translation->lang('OSTEOARTHITIS',true);?></h1>

                </section>
                <section class="content_desc ">
                    <?php echo strip_tags($this->translation->lang('OSTEOARTHITIS_TEXT',false),'
                    <p>
                        <ul>
                            <li>');?>

                </section>
                <section class="empty " style="width:60%; float:left;position:relative; "></section>
            </section>
            <section id="j_problem" class="clear"></section>
            <section class="joint_problem ">

                <section class="joint_desc_dog ">
                    <section class="col_1 ">

                        <section class="col_2 ">
                            <section class="title sss ">
                                <h1><?php echo $this->translation->lang('JOINT_PROBLEMS',true);?></h1>
                            </section>
                            <section class="col_3 ">
                                <p>
                                    <?php echo $this->translation->lang('DOGS',true);?></p>
                            </section>
                            <p>
                                <?php echo $this->translation->lang('joint_problems_dogs_text',true);?></p>
                            <div class="joint_problem_bg_dog ">
                                <img src="<?php echo base_url();?>themes/front/assets/images/joint_problem-dog.png " height="100% ">
                            </div>
                        </section>
                    </section>
                </section>
                <section class="clear "></section>
                <section class="joint_desc_cat content_green clear ">
                    <section class="col_1 ">
                        <p>
                            <?php echo $this->translation->lang('joint_problems_cats_text',true);?></p>
                    </section>
                    <section class="colon_1 ">
                        <img src="<?php echo base_url();?>themes/front/assets/images/joint_problem_cat.png " height="100% " class="cat ">
                        <section class="cat_s ">
                            <p>
                                <?php echo $this->translation->lang('CATS',true);?></p>
                        </section>
                    </section>

                </section>
            </section>
            <section id="joint_preparations" class="clear "></section>
            <section class="products_container ">
                <section class="title_p ">
                    <h1><?php echo $this->translation->lang('JOINT_PREPARATIONS',true);?></h1>
                </section>
                <section class="desc_p ">
                    <p>
                        <?php echo $this->translation->lang('JOINT_PREPARATIONS_TEXT',true);?></p>
                    <p style="margin-top: 5%; margin-bottom: 0;">
                        <?php echo $this->translation->lang('PRODUCTS_TEXT_BEFORE',true);?></p>
                </section>
                <section class="clear "></section>
                <section class="products_holder ">
                    <section class="main_p_holder product ">
                        <section class="green_p pp ">
                            <section class="product_title ">
                                <h1><?php echo $this->translation->lang('canosan',true);?></h1>
                            </section>
                            <section class="product_desc ">
                                <?php echo strip_tags($this->translation->lang('canosan_desc',false),'
                                <p>
                                    <ul>
                                        <li><b>');?>
                            </section>
                            <section class="product_pic ">
                                <img src="<?php echo base_url();?>themes/front/images/products/<?php echo $products[0]['image'];?>" width="100% ">
                            </section>

                        </section>
                        <section class="clear "></section>
                        <section class="buy_btn green_p ">
                            <p><?php echo $this->translation->lang('BUY',true);?></p>
                        </section>
                    </section>
                    <section class="main_p_holder product ">
                        <section class="brown_p pp ">
                            <section class="product_title ">
                                <h1><?php echo $this->translation->lang('cosequin_DS',true);?> </h1>
                            </section>
                            <section class="product_desc ">
                                <?php echo strip_tags($this->translation->lang('cosequin_DS_desc',false),'<p><ul><li><b>');?>

                            </section>
                            <section class="product_pic ">
                                <img src="<?php echo base_url();?>themes/front/images/products/<?php echo $products[1]['image'];?>" width="100% ">
                            </section>

                        </section>
                        <section class="clear "></section>
                        <section class="buy_btn brown_p ">
                            <p><?php echo $this->translation->lang('BUY',true);?></p>
                        </section>
                    </section>
                    <section class="main_p_holder product pppp ">
                        <section class="orange_p pp ">
                            <section class="product_title ">
                                <h1><?php echo $this->translation->lang('synoquin_EFA',true);?> </h1>
                            </section>
                            <section class="product_desc ">
                                <?php echo strip_tags($this->translation->lang('synoquin_EFA_desc',false),'<p><ul><li><b>');?>
                            </section>
                            <section class="product_pic ">
                                <img src="<?php echo base_url();?>themes/front/images/products/<?php echo $products[2]['image'];?>" width="100% ">
                            </section>

                        </section>
                        <section class="clear "></section>
                        <section class="buy_btn orange_p ">
                            <p><?php echo $this->translation->lang('BUY',true);?></p>
                        </section>
                        <div id="h_insurance"></div>
                    </section>
                </section>
                
            </section>
            
            <section class="healt_insurance ">
                <section class="title_p ">
                    <h1><?php echo $this->translation->lang('HEALTH_INSURANCE',true);?></h1>
                </section>
                <P class="sub_header "><?php echo $this->translation->lang('HEALTH_INSURANCE_PARAGRAPH_1',true);?></P>
                <hr>
                <p class="healt_insurance_orange"><?php echo $this->translation->lang('HEALTH_INSURANCE_PARAGRAPH_2',true);?></p>
                <section class="offers_holder " style="left:0; ">
                    <section class="offer " style="width:40% ">
                        <section class="percent "><?php echo $this->translation->lang('HEALTH_INSURANCE_PERCENT_1',true);?></section>
                        <section class="offer_desc "><?php echo $this->translation->lang('HEALTH_INSURANCE_PERCENT_1_TEXT',true);?></section>
                    </section>
                    <section class="dog_offer ">
                        <img src="<?php echo base_url();?>themes/front/assets/images/dog_offer.png ">
                    </section>
                    <section class="offer " style="right:0; ">
                        <section class="percent "><?php echo $this->translation->lang('HEALTH_INSURANCE_PERCENT_2',true);?></section>
                        <section class="offer_desc das "><?php echo $this->translation->lang('HEALTH_INSURANCE_PERCENT_2_TEXT',true);?></section>
                    </section>
                    <section class="clear "></section>

                </section>
                <hr>
                <section class="responsive_holder">
                    <section class="offer_p " style="width:50% ">
                        <section class="percent "><?php echo $this->translation->lang('HEALTH_INSURANCE_PERCENT_1',true);?></section>
                        <section class="offer_desc "><?php echo $this->translation->lang('HEALTH_INSURANCE_PERCENT_1_TEXT',true);?></section>
                    </section>

                    <section class="offer_p" style="width:50% ">
                        <section class="percent "><?php echo $this->translation->lang('HEALTH_INSURANCE_PERCENT_2',true);?></section>
                        <section class="offer_desc das "><?php echo $this->translation->lang('HEALTH_INSURANCE_PERCENT_2_TEXT',true);?></section>
                    </section>
                </section>
            </section>
            <section id="ask_expert" class="ask_an_expert ">
                 
                <section class="ask_expert_img ">
                    <img src="<?php echo base_url();?>themes/front/assets/images/expert_bg.jpg " width="100% ">
                </section>
                <section class="text_expert ">
                    <section class="big_title ">
                        <h1><?php echo $this->translation->lang('ASK_AN_EXPERT',true);?></h1>

                    </section>
                    <p><?php echo $this->translation->lang('ASK_AN_EXPERT_TEXT',true);?></p>
                    <section class="ask_expert_btn "><?php echo $this->translation->lang('ASK_AN_EXPERT',true);?></section>
                </section>
            </section>
            <section class="clear "></section>
            <section id="shop" class="shop ">
                <section class="shop_text ">
                    <h1><?php echo $this->translation->lang('SHOP',true);?></h1>
                </section>
                <section class="sales_force " style="display:none;">
                    <img src="<?php echo base_url();?>themes/front/assets/images/salse_force.jpg " width="100%; " </section>
                </section>
            </section>
            <section class="clear "></section>
            <section class="footer brown_p ">
                <section class="logo_f ">
                    <img src="<?php echo base_url();?>themes/front/assets/images/bottom.png " style="opacity:0; ">
                </section>
                <section class="copyright ">
                    <p><?php echo $this->translation->lang('copyright',true);?></p>
                </section>
            </section>
             
        </section>

</body>

</html>