<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet"
	href="<?php echo base_url()?>assets/shop/css/main.css" type="text/css" />
<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow"
	rel="stylesheet" type="text/css">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script type="text/javascript"
	src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js"></script>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script
	src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"
	type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>	
	
<script type="text/javascript"
	src="<?php echo base_url()?>assets/shop/js/site-functions.js"></script>

<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	
	<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
	<style>
	body {
		background: #fff !important;
		/*font-size: 20pt!important;*/
		/*font-weight: 700;*/
	}
	p,.col-xs-12{
		font-size: 20px!important;
	}
	.col-lg-8,.col-lg-12{
		/*text-align: right;*/
	}
	</style>
</head>
<?php 


?>

<body>
	<div class="wrapper">


<?php 
$invoiceaddress = InvoiceAddress::find(array('id'=>$order->getInvoiceAddressId()));
$product = Product::find(array('id' => $order->getProductId()));

?>
<main>
<div style="display:block; position:relative;">
  		<p><img src="<?php echo base_url();?>assets/img/logo.jpg" style="width:250px;"></p>
  		<?php if(!$order->getPaid()){?>
  					<p><img src="<?php echo base_url();?>public/notpaid.png" style="position: absolute;
  			  right: 270px;
  			  top: 90px;
  			  width: 330px;"></p>
  		<?php }?>
</div>


	<div style="display:block; position:relative; margin-bottom: 70px;">
		<div class="company-name">
	  		<h1><?php echo $invoiceaddress->getFirstName()?> <?php echo $invoiceaddress->getLastName()?></h1>
	  		<p><?php echo lang("Address")?>: <?php echo $invoiceaddress->getStreet()?> <?php echo $invoiceaddress->getStreetNo()?>, <?php echo $invoiceaddress->getZip()?></p>
	  		<p><?php echo Cities::find(array('id'=>$invoiceaddress->getCity()))->getCity();?>, <?php echo Countries::find(array('id'=>$invoiceaddress->getCountry()))->getCountry();?></p>
		</div>
		<div class="invoice-right">
	  		<h1><?php echo lang("Invoice Num.")?>: <?php echo $order->getId()?>/2015</h1>
	  		<p><?php echo lang("Date")?>: <?php echo date("d F Y, H:i",strtotime($order->getDate()));?></p>	
		</div>
	</div>
      <div class="quantity-product-list">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><?php echo lang("Quantity")?></div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5"><?php echo lang("Product")?></div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<div style="text-align: right;padding: 0px;" class="col-xs-12 col-sm-8 col-md-8 col-lg-8"><?php echo lang("Unit Price")?></div>
				<div style="text-align: right;padding: 0px;" class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><?php echo lang("Subtotal")?></div>
			</div>
	</div>
      </div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 items">
 		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 item product-list">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><?php echo $order->getQuantity()?> </div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5"><?php echo $product->getName()?></div>
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
			<div style="text-align:right;" class="col-xs-12 col-sm-8 col-md-8 col-lg-8"><?php if ($order->getCurrency() == 'eur'){
		echo '&euro;' . $product->getEurPrice();
		$subtotal = $order->getQuantity() * $product->getEurPrice();
		$currency = '&euro;';
	} elseif ($order->getCurrency() == 'gbp') {
		echo '&pound;' . $product->getGBPPrice();
		$subtotal = $order->getQuantity() * $product->getGBPPrice();
		$currency = '&pound;';
	}elseif ($order->getCurrency() == 'pln') {
		echo 'PLN ' . $product->getPLnPrice();
		$subtotal = $order->getQuantity() * $product->getPLnPrice();
		$currency = 'PLN';
	}


	$vat_countryId=DeliveryAddress::find(array('id'=>$order->getDeliveryaddressid()));
	
	$vat=Vat::getByCountryId($vat_countryId->getCountry());
	$vat_value=0;
	$order_date_=strtotime($order->getDate());

	if($vat){
		foreach ($vat as $key => $value) {
			$mince=strtotime($value->getFrom_date());
			$maxce=strtotime($value->getTo_date());

			if($mince<=$order_date_ && $maxce>=$order_date_){
				$vat_value=$value->getValue();
			}
		}
	}	

	$discount=$order->getDiscount();


	if(isset($discount)){
		$sub_disc=$subtotal*$discount/100;
		$subTotalSve=$subtotal-$sub_disc;
	} else{
		$subTotalSve=$subtotal;
	}

	$vat_percent=$vat_value;
	// procenti sto se prikazuvaat u faktura
	$vat_view=$vat_value;
	$vat_percent=($vat_percent/100)+1;

	$total_without_tax=$subTotalSve/$vat_percent;

	$vat=$subTotalSve-$total_without_tax;

	
	// $vat=($order->getQuantity()*$price)*$vat_percent/100;

	?></div>
			<div style="text-align:right;" class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><?php echo $currency?> <?php echo number_format($subtotal,2,',','.')?></div>
        </div>
		</div>
        </div>
<div class="notes-content">
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 border">
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 total">
	    <?php 
	    if(isset($discount)){?>
	    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="color:red;"><?php echo lang("Discount") ?> <?php echo $discount;?>%</div>
	    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="color:red; text-align: right;">- <?php echo $currency?> <?php echo number_format(($subtotal*$discount/100),2,',','.')?></div>
	    <?php }?>
	    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"><?php echo lang("Total without tax")?></div>
	    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="text-align: right;"><?php echo $currency?> <?php echo number_format($total_without_tax,2,',','.')?></div>

	    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">VAT <?php echo $vat_view;?>%</div>
	    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="text-align: right;padding-right: 0;"><?php echo $currency?> <?php echo number_format($vat,2,',','.')?></div>

	</div>
    </div>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-12 total">
	    <?php if(isset($discount)){?>
	    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-10" style="padding-right: 0px"><?php echo lang("Total");?></div>
	    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2" style="text-align:right;padding-right:15px;"><?php echo $currency . " " . number_format($subtotal-($subtotal*$discount/100), 2,',','.')?> </div>

	    <?php } else {?>
	    	    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-10" style="padding-right: 0px"><?php echo lang("Total");?></div>
	    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2" style="text-align:right;padding-right:15px;"><?php echo $currency . " " . number_format($subtotal, 2,',','.');?> </div>
	    <?php }?>
	</div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="company-name">
		<?php $deliverytype = $order->getDeliveryType();
		$dt = explode("-", $deliverytype);
		?>
	  		<h1><?php echo lang("Notes")?>:</h1>
	  		<?php if(count($dt)==3) {?>
	  		<p><?php echo lang("Delivery Type")?>: <?php echo $dt[1] . " " . $dt[2]?> </p>
	  		<?php } else {?>
	  		<p><?php echo lang("Delivery Type")?>: <?php echo $dt[0]?> </p>
	  		<?php } ?>
	  		<p><?php echo lang("Delivery time")?>: 3 days</p>	
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 payed-title">
		<h2>Paid in advance</h2>
	</div>
</div>
<div class="payment-details">
		<div class="company-name">
	  		<h1><?php echo lang("PAYMENT DETAILS")?></h1>
	  		<p><?php echo lang("BARCLAYS")?></p>
	  		<p><?php echo lang("Bank/Sort Code")?>: 20-54-78</p>                                                                                   
			<p><?php echo lang("Account Number")?>: 8650511</p>
			<p><?php echo lang("IBAN")?>: GB23BARC20077186050511</p>
			<p><?php echo lang("BIC")?>: BARCGB22</p>
			<p><?php echo lang("VAT Number")?>: GB155557293</p>
			<p style="font-weight:700;"><?php echo lang("Payment Refference Number")?>: 0235687</p>
		</div>
		<div class="invoice-right">
	  		<h2><?php echo lang("OTHER INFORMATION")?></h2>
	  		<p><?php echo lang("Comany Registration Number")?>: 7954389</p>
			<p><?php echo lang("Registered in")?>: <?php echo lang("England and Wales")?></p>	
		</div>
	</div>
</main>
 
    
    <footer>
			<p>Copyright &copy 2015. Vetfriend 24</p>
		</footer>
	</div>
</body>
</html>