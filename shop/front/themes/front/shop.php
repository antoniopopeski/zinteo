<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">

<head>
    <meta charset="UTF-8">
    <title><?php $this->translation->lang('Shop',true)?> </title>

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
        
        .circle_holder_right hover { cursor:pointer }
    </style>

</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=385960518189268";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script> 
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
                    <h1 ><?php echo $this->translation->lang('Shop',true) ?> </h1>
                  	
                </div>
            
    
            </div>
    
            <div class="clear"></div>
           
            <section id="main_content_text" style="width:70%; margin-left: 5%;">
            <div id="my-store-"></div>
					<div>
					<script type="text/javascript" src="http://app.ecwid.com/script.js?7004961" charset="utf-8"></script><script type="text/javascript"> xProductBrowser("categoriesPerRow=3","views=grid(3,3) list(10) table(20)","categoryView=grid","searchView=list","id=my-store-");</script>
					</div>
            </section>
            <div class="clear"></div>
                        <section class="social">
                  <div style="padding-bottom:20px; top:-6px; float:left; margin-right:5px; margin-left:65px" class="fb-like " data-href="http://vetfriend24.com" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
               		<a href="https://twitter.com/Vetfriend24" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false" data-dnt="true">Follow @Vetfriend24</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                </section>
                <div class="clear"></div>
            <div class="footer brown_p">
                <div class="logo_f">
                    <img src="<?php echo base_url();?>themes/front/assets/images/logo_bottom.png" style="opacity:0;">
                </div>
                			<section class="footer_links">
				<section class="f_link">
					<div class="fl">
						<h2>Impresum</h2>
						<?php echo $this->translation->lang('contact',false);?>
						
					</div>
				</section>

				<section class="f_link ">
					<div class="fl f_link_middle">
						<h2>Legal</h2>

						<p>
							<a href="#">Some link</a>
						</p>
						<p>
							<a href="#">Some link</a>
						</p>
						<p>
							<a href="#">Some link</a>
						</p>
						<p>
							<a href="#">Some link</a>
						</p>
					</div>
				</section>

				<section class="f_link">
					<div class="fl">
						<h2>Social Media</h2>
				
						<?php foreach ($socialnetworks as $sn) {?>
							<a href="<?php print $sn['link']?>"><img class="sm-icon" height="36" width="36" src="/themes/front/images/<?php print $sn['image']?>"></a>
						<?php }?>
						
					</div>
				</section>
			</section>
			 <div class="clear"></div>
                <div class="copyright">
                    <p><?php echo $this->translation->lang('copyright',true);?></p>
                </div>
            </div>
        </div>
</body>

</html>