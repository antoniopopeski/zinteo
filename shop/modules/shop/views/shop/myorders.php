        <style type="text/css">
        /*a{padding: 0!important;}*/
        </style>

<main>

<div class="title">
	<h2><?php echo lang("My Account / List of my purchases")?></h2>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 item-titles">
	<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1" style="padding:0;width:30px;"><?php echo lang("#")?></div>
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-4"><?php echo lang("Product Name")?></div>
	<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1" style="width:9%!important;"><?php echo lang("Price")?></div>
	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-1" style="padding:0;"><?php echo lang("Quantity")?></div>
	<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1"><?php echo lang("Total")?></div>
	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><?php echo lang("Date Ordered")?></div>
	<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1"><?php echo lang("Delivered")?></div>
	<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1" style="margin-left: 25px;"><?php echo lang("Invoice")?></div>
</div>
<div class="items">
        <?php foreach ($orders as $order) {?>
        <?php 
        	$price = 0;
        	$currency = "";
        	if ($order->currency == 'eur') {
        		$price = Product::find(array('id'=>$order->productid))->getEurPrice();
        		$currency = "&euro;";
        	}
        	if ($order->currency == 'gbp') {
        		$price = Product::find(array('id'=>$order->productid))->getGBPPrice();
        		$currency = "&pound;";
        	}
        	if ($order->currency == 'pln') {
        		$price = Product::find(array('id'=>$order->productid))->getPlnPrice();
        		$currency = "PLN";
        	}

			// $order = Order::find(array('id'=>$order->id));
        	$vat_countryId=DeliveryAddress::find(array('id'=>$order->deliveryaddressid));
 
        	$vat=Vat::getByCountryId($vat_countryId->getCountry());
        	$vat_value=0;
        	$order_date_=strtotime($order->date);

        	if($vat){
	        	foreach ($vat as $key => $value) {
	        		$mince=strtotime($value->getFrom_date());
	        		$maxce=strtotime($value->getTo_date());

	        		if($mince<=$order_date_ && $maxce>=$order_date_){
	        			$vat_value=$value->getValue();
	        		}
	        	}
        	}	
        	// if ($vat instanceof Vat) {
        	// 	$vat_value = $vat[0]->getValue();
        	// }

        	$discount=$order->discount;

        	$vat_percent=$vat_value;
        	// echo $price;
        	$vat=$price*$vat_percent/100;
			// $vat=($vat_percent/100)+1;

        	// echo $vat;

        	if(isset($discount)){
        		$price_total=($order->quantity*$price)*10/100;
        	} else{
        		$price_total=($order->quantity*$price)*$vat_percent/100;
        	}

        	$link=$order->productid;
        	$link=Product::find(array('id'=>$order->productid))->getId();
        ?>
 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 item" style="<?php if(!$order->paid){echo "background:#FFDEDD";};?>">
		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1" style="padding:0;width:30px;"><?php echo $order->id;?></div>
		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1" style="padding:0;">
			<a href="/shop/shop/product/<?php echo $link;?>" style="padding:0px!important;"><img
				src="<?php echo base_url() . Product::find(array('id'=>$order->productid))->getImage()?>"
				height="50" width="50"  /></a>
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-3" style="padding:0;"><a target="_blank" href="<?php echo base_url()?>shop/shop/product/<?php echo $order->productid?>" style="padding:0px;"><?php echo Product::find(array('id'=>$order->productid))->getName()?></a></div>
		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1" style="width:9%!important;"><?php echo  number_format($price,2,',','.')." ".$currency;?></div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-1" style="padding:0;"><?php echo $order->quantity; ?> <?php if($order->quantity==1) { echo lang("piece"); } else { echo lang("pieces");}?></div>
		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1"><?php echo number_format(($order->quantity * ($price-$price_total) ), 2,',','.').$currency;?></div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><?php echo date('d M Y, H:i',strtotime($order->date))?></div>
		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1"><?php echo ($order->status == 1) ? lang("No") : "" ?></div>
		<div class="col-xs-12 col-sm-2 col-md-1 col-lg-1" style="">
		<?php /*?>
		<a href="http://FreeHTMLtoPDF.com/?convert=<?php echo base_url()?>shop/pdf/<?php echo $order->id?>" class="btn btn-orange" target="_blank"><?php echo lang("Download")?></a>
		<?php }*/?>
		<?php if($order->paid==1){?>
		<a href="<?php echo base_url()?>shop/pdf/<?php echo $order->id?>" class="btn btn-orange" target="_blank" style="margin: 5px auto;"><?php echo lang("View")?></a>
		<?php } else{?>
		<a href="<?php echo base_url()?>shop/pdf/<?php echo $order->id?>" class="btn btn-orange" target="_blank" style="margin: 5px auto;"><?php echo lang("Pay now")?></a>

		<?php } ?>
		</div>
	</div>
	<?php }?>

        </div>

<a class="btn btn-orange" href="<?php echo base_url()?>"><?php echo lang("buy another product");?></a> </main>
	<script>
	$(function(){
		$(".header").find("ul").hide();
	})
	</script>