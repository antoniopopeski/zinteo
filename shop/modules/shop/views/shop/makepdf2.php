<?php 
// define some HTML content with style
$linkce=$this->uri->segment(2);
$invoiceaddress = InvoiceAddress::find(array('id'=>$order->getInvoiceAddressId()));
$product = Product::find(array('id' => $order->getProductId()));

$html = '
<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet"
	href="'.base_url().'assets/shop/css/main.css" type="text/css" />
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
	src="'.base_url().'assets/shop/js/site-functions.js"></script>

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
<body>
	<div class="wrapper">

<main>
<div style="display:block; position:relative;">
	<div class="company-name">
  		<p><img src="'.base_url().'assets/img/logo.jpg" style="width:250px;height:100px;margin-left:-40px;"></p>
	</div>
</div>
<div style="display:block; position:relative; margin-bottom: 70px;">
	<div class="company-name">
';
$html.='<h1>'.$invoiceaddress->getFirstName().' '.$invoiceaddress->getLastName().'<h1>';
$html.='<p>'.lang("Address").': '.$invoiceaddress->getStreet().' '.$invoiceaddress->getStreetNo().', '.$invoiceaddress->getZip().'</p>';
$html.="<p>".Cities::find(array('id'=>$invoiceaddress->getCity()))->getCity().", ".Countries::find(array('id'=>$invoiceaddress->getCountry()))->getCountry()."</p>
</div>
";
$html.='<div class="invoice-right">
<h1>'.lang("Invoice").': '.$order->getId().'/2015</h1>
<p>'.lang("Date").': '.date("d F Y, H:i",strtotime($order->getDate())).'</p>
</div>
</div>
';

$html.='
      <div class="quantity-product-list">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">'.lang("Quantity").'</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">'.lang("Product").'</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<div style="text-align: right;padding: 0px;" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">'.lang("Unit Price").'</div>
				<div style="text-align: right;padding: 0px;" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">'.lang("Subtotal").'</div>
			</div>
		</div>
      </div>
';
$html.='
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 items">
 		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 item product-list">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">'.$order->getQuantity().'</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">'.$product->getName().'</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
			<div style="text-align:right;" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
';

if ($order->getCurrency() == 'eur'){
		$html.='&euro;' . $product->getEurPrice();
		$subtotal = $order->getQuantity() * $product->getEurPrice();
		$currency = '&euro;';
	} elseif ($order->getCurrency() == 'gbp') {
		$html.='&pound;' . $product->getGBPPrice();
		$subtotal = $order->getQuantity() * $product->getGBPPrice();
		$currency = '&pound;';
	}elseif ($order->getCurrency() == 'pln') {
		$html.='PLN ' . $product->getPLnPrice();
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

$html.='
</div>
<div style="text-align:right;" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$currency.' '.number_format($subtotal,2,',','.').'</div>
</div>
</div>
</div>

<div class="notes-content">
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 border">
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 total">
';

if(isset($discount)){
	$html.='
	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="color:red;">'.lang("Discount").' '.$discount.'%</div>
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="color:red;">- '.$currency.' '.number_format(($subtotal*$discount/100),2,',','.').'</div>
	';
}

$html.='
	    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">'.lang("Total without tax").'</div>
	    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$currency.' '.number_format($total_without_tax,2,',','.').'</div>

	    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">VAT '.$vat_view.'%</div>
	    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">'.$currency.' '.number_format($vat,2,',','.').'</div>

	</div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 total">
';
if(isset($discount)){
$html.='
<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 total-sum">'.lang("Total"). ' '.$currency.' '.number_format($subtotal-($subtotal*$discount/100), 2,',','.').'</div>';
} else {
$html.='
	<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 total-sum">'.lang("Total").' '.$currency.' '.number_format($subtotal, 2,',','.').'</div>
';	
}
$html.='</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<div class="company-name">
';
$deliverytype = $order->getDeliveryType();
$dt = explode("-", $deliverytype);
if(count($dt)==3){
	$html.='
	  		<h1>'.lang("Notes").':</h1>
	  		<p>'.lang("Delivery Type").': '.$dt[0] . ' ' . $dt[1].' ' . $dt[2].'</p>
	  		<p>'.lang("Delivery time").': 3 days</p>	
		</div>
	</div>

	';	
} else {
	$html.='
	  		<h1>'.lang("Notes").':</h1>
	  		<p>'.lang("Delivery Type").': '.$dt[0] . ' ' . $dt[1].' </p>
	  		<p>'.lang("Delivery time").': 3 days</p>	
		</div>
	</div>

	';
}

$html.='	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 payed-title">
		<h2>Paid in advance</h2>
	</div>
</div>';


$html.='
	<div class="payment-details">
			<div class="company-name">
		  		<h1>'.lang("PAYMENT DETAILS").'</h1>
		  		<p>'.lang("BARCLAYS").'</p>
		  		<p>'.lang("Bank/Sort Code").': 20-54-78</p>                                                                                   
				<p>'.lang("Account Number").': 8650511</p>
				<p>'.lang("IBAN").': GB23BARC20077186050511</p>
				<p>'.lang("BIC").': BARCGB22</p>
				<p>'.lang("VAT Number").': GB155557293</p>
				<p style="font-weight:700;">'.lang("Payment Refference Number").': 0235687</p>
			</div>
			<div class="invoice-right">
		  		<h2>'.lang("OTHER INFORMATION").'</h2>
		  		<p>'.lang("Comany Registration Number").': 7954389</p>
				<p>'.lang("Registered in").': '.lang("England and Wales").'</p>	
			</div>
		</div>
	</main>
	    <footer>
				<p>Copyright &copy 2015. Vetfriend 24</p>
			</footer>
		</div>
	</body>
	</html>
';

// output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
// $pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
// $pdf->Output('example_061.pdf', 'I');

$url = 'http://freehtmltopdf.com';
$data = array(  'convert' => '', 
		'html' => $html,
		'baseurl' => 'http://vetfriend24.kriipton.com/shop/shop/pdfMake/50');

// use key 'http' even if you send the request to https://...
$options = array(
	'http' => array(
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'method'  => 'POST',
		'content' => http_build_query($data),
	),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// set the pdf data as download content:
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="webpage.pdf"');
// echo($result);
?>