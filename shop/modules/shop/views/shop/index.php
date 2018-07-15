 <main>
        <div class="title">
                <h2><?php echo lang("Product List")?></h2>
                <h4 style="color:#54390e!important;"><?php echo lang("Short description of the Vetfriend product list")?></h4>
        </div>
               <form method="post" action="" id="search-form">
        <input type="hidden" name="first_filter" id="first_filter" value="<?php echo $first_filter?>" />
        <input type="hidden" name="last_filter" id="last_filter" value="<?php echo $last_filter?>"/>
            <input type="hidden" name="brand" id="brand" value="<?php if(isset($brand)) echo $brand;?>" />
          </form>

        <div class="sorted-list">
            <a  href="#"><p style="font-weight:700; color:#333; !important;"><?php echo lang("Brand")?>:</p></a>
            <select name="brands" id="brands">
                <option value="all"><?php echo lang("All");?></option>
                <?php foreach ($brands as $b) {?>
                    <option value="<?php echo $b->getId();?>" <?php if($brand==$b->getId()) echo "selected";?>><?php echo $b->getName();?></option>
                <?php }?>
            </select>
            <a  href="#"><p style="font-weight:700; color:#333; !important;"><?php echo lang("Filter")?>:</p></a>

            <a class="filter show_all" href="#"><p <?php echo ($first_filter == 'show_all') ? "style='color:#333 !important;'" : "" ?> ><?php echo lang("Show All")?></p></a>
        <!--     <a class="filter only_dogs"  href="#"><p <?php echo ($first_filter == 'only_dogs') ? "style='color:#333 !important;'" : "" ?> ><?php echo lang("Only for Dogs")?></p></a>
            <a class="filter only_cats"  href="#"><p <?php echo ($first_filter == 'only_cats') ? "style='color:#333 !important;'" : "" ?> ><?php echo lang("Only for Cats")?></p></a> -->
            <div class="right">
                <a  href="#"><p style="font-weight:700; color:#333; !important;"><?php echo lang("Sort by")?>: </p></a>
                <a class="filter date"  href="#"><p <?php echo ($last_filter == 'date') ? "style='color:#333 !important;'" : "" ?> ><?php echo lang("Date")?></p></a>
                <a class="filter name"  href="#"><p <?php echo ($last_filter == 'name') ? "style='color:#333 !important;'" : "" ?> ><?php echo lang("Name")?></p></a>
                <a class="filter price_asc"  href="#"  ><p <?php echo ($last_filter == 'price_asc') ? "style='color:#333 !important;'" : "" ?>><?php echo lang("Price Acc")?></p></a>
                <a class="filter price_desc"  href="#"  ><p <?php echo ($last_filter == 'price_desc') ? "style='color:#333 !important;'" : "" ?>><?php echo lang("Price Desc")?></p></a>
            </div>
          
        </div>

        <?php $c=0;;?>
       <?php foreach ($products as $product) {?>   
		
		<?php 
		if ($c >3) $c = 0;
		$c++;
	
		$box = "";
		if ($c == 1) {
			$box="left";
		} elseif ($c==2) {
		$box = "";
		} elseif ($c == 3) { $box = 'right'; }
	
		?>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="height: 400px;">
                <div class="box <?php echo $box ?>" onclick="window.location='<?php echo base_url()?>/shop/shop/product/<?php echo $product->variantid?>'">
                <?php if ($product->type == 1) {?>
                	<div class="image-box"><img src="<?php echo base_url()?>/assets/shop/assets/img/dog.png"/></div>
                <?php }?>
                <?php if ($product->type == 2) {?>
                	<div class="image-box"><img src="<?php echo base_url()?>/assets/shop/assets/img/cat.png"/></div>
                <?php }?>
                <?php if ($product->type == 3 ){?>
                                <div class="image-box"><img src="<?php echo base_url()?>/assets/shop/assets/img/cat.png"/></div>
                <div  style="left:70px;" class="image-box"><img src="<?php echo base_url()?>/assets/shop/assets/img/dog.png"/></div>
                <?php }?>

                <ul>
                    <li><a href="<?php echo base_url()?>/shop/shop/product/<?php echo $product->variantid?>"><img src="<?php echo base_url() . $product->image?>"/></a></li>
                    <li style="height: 55px;"><?php echo $product->variantname?></li>
                    <?php 
                    if (isset($_SESSION['currency']) AND $_SESSION['currency'] == 'eur') {
                    	echo '<li>&euro;'. $product->varianteurprice .'</li>';
                    } 
                    
                    elseif (isset($_SESSION['currency']) AND $_SESSION['currency'] == 'gbp') {
                    	echo '<li>&pound;'. $product->variantgbpprice .'</li>';
                    	 
                    }
                    
                    elseif (isset($_SESSION['currency']) AND $_SESSION['currency'] == 'pln') {
                    	echo '<li>PLN'. $product->variantplnprice .'</li>';
                    }
                
                    ?>
                    
                    <li><a class="btn-orange buy-btn"
				href="<?php echo base_url()?>/shop/shop/checkout/<?php echo $product->variantid?>"><?php echo lang("Buy")?></a></li>
                </ul>
                </div>
            </div>
       
       <?php }?>
      
</main>

<?php 
if (!is_logged()) { ?>
		<script>
	$(function(){
		$(".header").find("ul").hide();
	})
	</script>
<?php }
?>
<script type="text/javascript">
    $(".header ul").remove();
</script>

