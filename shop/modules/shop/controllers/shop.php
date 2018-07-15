<?php
use PayPal\Api\Amount;
use PayPal\Api\CreditCard; 
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument; 
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class Shop extends Shop_Controller {
	public function __construct() {
		parent::__construct ();
		
		loader::lib ( "../admin/Product" );
		loader::lib ( "../admin/ProductCategory" );
		loader::lib ( "../admin/Stock" );
		loader::lib ( "../user/User" );
		loader::lib ( "../admin/Countries" );
		loader::lib ( "../admin/Cities" );
		loader::lib ( "../admin/Vat" );
		loader::lib ( "../shop/Vets" );
		
		set_language();
	}
	
	public function creditcardpayment() 
	{
		
	}
	public function brandRedirectFilter($getRedirectBrand){
		$_SESSION['brandot']=$getRedirectBrand+1;
		redirect('/shop');
	}

	public function index($currency='eur') { 
		$data = array ();

		$data ['main'] = "shop/index";
		$_SESSION['currency'] = $currency;
		$data['first_filter'] = 'show_all';
		$data['last_filter'] = 'date';
		$data['brand']='all';

		if(isset($_SESSION['brandot'])){
			$data['brand']=$_SESSION['brandot'];
			$filter = array('first_serach'=>'show_all', 'last_search' => 'date', 'brand' => $data['brand']);
			unset($_SESSION['brandot']);
		}

		if (i_post()) {
			$first_filter = i_post('first_filter');
			$last_filter = i_post('last_filter');
			$brand = i_post('brand');

			$filter = array('first_serach'=>$first_filter, 'last_search' => $last_filter, 'brand' => $brand);
			$data ['products'] = Product::getVariantsInStock ($filter);
			$data['first_filter'] = i_post('first_filter');
			$data['last_filter'] = i_post('last_filter');
			$data['brand'] = i_post('brand');
			$data['brands']= ProductCategory::find();
		} else {
				$data['brands']= ProductCategory::find();		
				if(isset($filter)){
					$data ['products'] = Product::getVariantsInStock ($filter);
				} else {
					$data ['products'] = Product::getVariantsInStock ($filter=array());
				}
		}
		
		$data['active_menu']['none'] = 1;
		$data['page_status'] = lang("Product List");
		
		return view ( "../theme/public", $data, false );
	}
	
	public function product($id) {
		$data = array();
		
		$data['main'] = 'shop/product';
		$data['product'] = Product::find(array('id' => $id));
		$data['page_status'] = lang("Product Preview");
		$data['page_title'] = lang(" Vetfriend24 - ".$data['product']->getName());
		
		if (!Product::find(array('id' => $id))->getActive() AND !(isset($_SESSION['admin']))) {
			redirect("/");
		}
		return view ( "../theme/public", $data, false );
	}
	public function checkout($id) {
		$_SESSION ['itemid'] = $id;
		
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}
		
			redirect ( "/shop/veterinarian" );
		// if (! isset ( $_SESSION ['vetid'] ) AND !isset($_SESSION['vetname'])) {
		// }
		
		redirect ( "/shop/delivery" );
	}
	public function insertinvoiceaddress() {
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}
		
		if (! isset ( $_SESSION ['vetid'] )) {
			redirect ( "/shop/veterinarian" );
		}
		
		$data ['main'] = 'shop/insertinvoiceaddress';
		$data ['page_title'] = lang ( "Vetfriend24 - Insert new invoice address" );
		if (i_post ()) {
			
			$invoiceaddress = new InvoiceAddress ();
			$invoiceaddress->setId ( 0 )->setUserId ( $_SESSION ['user']->id )->setFirstName ( i_post ( 'firstname' ) )->setLastName ( i_post ( 'lastname' ) )->setStreet ( i_post ( 'street' ) )->setStreetNo ( i_post ( 'streetno' ) )->setZip ( i_post ( 'zip' ) )->setCity ( i_post ( 'city' ) )->setCountry ( i_post ( 'country' ) )->setPhone ( i_post ( 'phone' ) )->setEmail ( i_post ( 'email' ) );
			
			$invoiceaddress->insert ();
			
			redirect ( '/shop/invoice' );
		}
		
		return view ( "../theme/shop", $data, false );
	}

	public function a_getCities() {
		if (i_ajax ()) {
			$countryid = i_post ( 'countryid' );
			
			$cities=Cities::getByCountryId($countryid);
			
			$cities_arr = array ();
			
			foreach ( $cities as $c ) {
				array_push ( $cities_arr, array (
						'id' => $c->getId(),
						'city' => $c->getCity() 
				) );
			}
			
			echo json_encode ($cities_arr);
		}
	}

	public function invoice() {
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}
		
		if (! isset ( $_SESSION ['vetid'] ) and !isset($_SESSION['vetname'])) {
			redirect ( "/shop/veterinarian" );
		}
		
		$data = array ();
		
		$data ['main'] = 'shop/invoice';
		
		$data ['invoiceaddress'] = InvoiceAddress::getForCurrentUser ( User::getCurrent ()->getId () );
		
		if (! $data ['invoiceaddress']) {
			redirect ( "/shop/insertinvoiceaddress" );
		}
		
		$data ['page_title'] = lang ( "Vetfriend24 - Invoice" );
		
		if (i_post ()) {
			
			$invoiceaddress = i_post ( 'invoiceaddress' );
			
			$_SESSION ['invoiceaddressid'] = $invoiceaddress;
			
			redirect ( '/shop/paymenttype' );
		}
		
		return view ( "../theme/shop", $data, false );
	}
	public function insertdeliveryaddress() {
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}
		
		if (! isset ( $_SESSION ['vetid'] ) AND !isset($_SESSION['vetname'])) {
			redirect ( "/shop/veterinarian" );
		}
		
		$data ['main'] = 'shop/insertdeliveryaddress';
		$data ['page_title'] = lang ( "Insert new delivery address - Vetfriend24" );
		if (i_post ()) {
			
			$deliveryaddress = new DeliveryAddress ();
			$deliveryaddress->setId ( 0 )->setUserId ( $_SESSION ['user']->id )->setFirstName ( i_post ( 'firstname' ) )->setLastName ( i_post ( 'lastname' ) )->setStreet ( i_post ( 'street' ) )->setStreetNo ( i_post ( 'streetno' ) )->setZip ( i_post ( 'zip' ) )->setCity ( i_post ( 'city' ) )->setCountry ( i_post ( 'country' ) )->setPhone ( i_post ( 'phone' ) )->setEmail ( i_post ( 'email' ) );
			
			$deliveryaddress->insert ();
			
			redirect ( '/shop/delivery' );
		}
		
		return view ( "../theme/shop", $data, false );
	}
	public function delivery() {
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}
		
		if (! isset ( $_SESSION ['vetid'] ) AND !isset($_SESSION['vetname'])) {
			redirect ( "/shop/veterinarian" );
		}
		
		$data = array ();
		$data['page_status'] = lang("Delivery Address");
		$data ['active_menu'] ['deliveryaddress'] = 1;
		$data ['main'] = 'shop/delivery';
		
		$data ['deliveryaddress'] = DeliveryAddress::getForCurrentUser ( User::getCurrent ()->getId () );
		
		$conf['sortby']='country';
		$data['countries']=Countries::find($conf);
		$data['cities']=Cities::find();
		// if (!$data['deliveryaddress']){
		// redirect("/shop/insertdeliveryaddress");
		// }
		
		$data ['page_title'] = lang ( "Vetfriend24 - Delivery" );
		
		if (i_post ()) {
			
			if (isset ( $_POST ['selected_delivery_address'] )) {
				$selected_delivery_address = i_post ( 'selected_delivery_address' );
				
				$deliveryaddress = DeliveryAddress::find ( array (
						'id' => $selected_delivery_address 
				) );
				
				$_SESSION ['deliveryaddressid'] = $selected_delivery_address;
				
				if (i_post ( 'invoiceaddress' ) == 1) {
					
					$invoiceaddress = new InvoiceAddress ();
					$invoiceaddress->setId ( 0 )->setUserId ( $_SESSION ['user']->id )->setFirstName ( $deliveryaddress->getFirstName () )->setLastName ( $deliveryaddress->getLastName () )->setStreet ( $deliveryaddress->getStreet () )->setStreetNo ( $deliveryaddress->getStreetNo () )->setZip ( $deliveryaddress->getZip () )->setCity ( $deliveryaddress->getCity () )->setCountry ( $deliveryaddress->getCountry () )->setPhone ( $deliveryaddress->getPhone ()  );
					
					$invoiceid = $invoiceaddress->insert ();
					
					$_SESSION ['invoiceaddressid'] = $invoiceid;
				} else {
					$invoiceaddress = new InvoiceAddress ();
					$invoiceaddress->setId ( 0 )->setUserId ( $_SESSION ['user']->id )->setFirstName ( i_post ( 'firstname_i' ) )->setLastName ( i_post ( 'lastname_i' ) )->setStreet ( i_post ( 'street_i' ) )->setStreetNo ( i_post ( 'streetno_i' ) )->setZip ( i_post ( 'zip_i' ) )->setCity ( i_post ( 'city_i' ) )->setCountry ( i_post ( 'country_i' ) )->setPhone ( i_post ( 'phone_i' )  );
					
					$invoiceid = $invoiceaddress->insert ();
					
					$_SESSION ['invoiceaddressid'] = $invoiceid;
				}
				
				redirect ( '/shop/paymenttype' );
			}
			
			$deliveryaddress = new DeliveryAddress ();
			$deliveryaddress->setId ( 0 )->setUserId ( $_SESSION ['user']->id )->setFirstName ( i_post ( 'firstname' ) )->setLastName ( i_post ( 'lastname' ) )->setStreet ( i_post ( 'street' ) )->setStreetNo ( i_post ( 'streetno' ) )->setZip ( i_post ( 'zip' ) )->setCity ( i_post ( 'city' ) )->setCountry ( i_post ( 'country' ) )->setPhone ( i_post ( 'phone' )  );
			
			$deliveryid = $deliveryaddress->insert ();
			
			$_SESSION ['deliveryaddressid'] = $deliveryid;
			
			if (i_post ( 'invoiceaddress' ) == 1) { // same as delivery
				
				$invoiceaddress = new InvoiceAddress ();
				$invoiceaddress->setId ( 0 )->setUserId ( $_SESSION ['user']->id )->setFirstName ( i_post ( 'firstname' ) )->setLastName ( i_post ( 'lastname' ) )->setStreet ( i_post ( 'street' ) )->setStreetNo ( i_post ( 'streetno' ) )->setZip ( i_post ( 'zip' ) )->setCity ( i_post ( 'city' ) )->setCountry ( i_post ( 'country' ) )->setPhone ( i_post ( 'phone' ) );
				
				$invoiceid = $invoiceaddress->insert ();
				
				$_SESSION ['invoiceaddressid'] = $invoiceid;
			} else {
				
				$invoiceaddress = new InvoiceAddress ();
				$invoiceaddress->setId ( 0 )->setUserId ( $_SESSION ['user']->id )->setFirstName ( i_post ( 'firstname_i' ) )->setLastName ( i_post ( 'lastname_i' ) )->setStreet ( i_post ( 'street_i' ) )->setStreetNo ( i_post ( 'streetno_i' ) )->setZip ( i_post ( 'zip_i' ) )->setCity ( i_post ( 'city_i' ) )->setCountry ( i_post ( 'country_i' ) )->setPhone ( i_post ( 'phone_i' )  );
				
				$invoiceid = $invoiceaddress->insert ();
				
				$_SESSION ['invoiceaddressid'] = $invoiceid;
			}
			
			redirect ( '/shop/paymenttype' );
		}
		
		return view ( "../theme/public", $data, false );
	}
	public function myorders() {
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}
		
		$data = array ();
		$data ['main'] = 'shop/myorders';
		
		$data ['orders'] = Order::getOrderByUserId ( User::getCurrent ()->getId () );
		return view ( '../theme/public', $data, false );
	}
	public function success($paymentid=NULL,$orderid=NULL) {
		//print_r($_SERVER['QUERY_STRING']);die;
		$params = explode ( "&", $_SERVER ['QUERY_STRING'] );

		if (count( $params ) > 2) {
			// echo "1";
			$orderid = explode ( "=", $params [0] );
			$paymentid = explode ( "=", $params [1] );
			$token = explode ( "=", $params ['2'] );
			
			$order = Order::find ( array (
					'id' => ($orderid [1]) 
			) );
			$stock = Stock::getByProductId ( $order->getProductId () );
			
			$stock [0]->setCount ( $stock [0]->getCount () - $order->getQuantity () );
			$stock [0]->update ();
			
			$order->setPaymentId ( ($paymentid [1]) );
			$order->setToken ( ($token [1]) );
			$order->setStatus(0);
			$order->setPaid(1);
			
			$order->update ();
			$_SESSION['banktransfer']='0';
			redirect ( "/shop/success" );
		}

		if($paymentid){
			// echo "2";
			$order=Order::find(array('id' => ($orderid)));

			$stock = Stock::getByProductId ( $order->getProductId () );
			
			$stock [0]->setCount ( $stock [0]->getCount () - $order->getQuantity () );
			$stock [0]->update ();

			$order->setPaymentId($paymentid);
			$order->setStatus(0);
			$order->setPaid(1);

			$order->update ();
			$_SESSION['banktransfer']='0';
			redirect ( "/shop/success" );
		}
		
		$data = array ();
		$data ['page_title'] = lang ( "Payment Success - Vetshop24" );
		$data ['main'] = 'shop/success';
		$data['active_menu']['none'] = 1;
		return view ( "../theme/public", $data, false );
	}

	public function successbt($orderid=NULL,$paymentid=NULL){
		if($orderid && $paymentid==NULL){
			$order=Order::find(array('id' => ($orderid)));
			$stock = Stock::getByProductId ( $order->getProductId () );
			
			$stock [0]->setCount ( $stock [0]->getCount () - $order->getQuantity () );
			$stock [0]->update ();

			$order->setPaid(0);
			$order->update();
			$_SESSION['banktransfer']='1';
		}

		$data = array ();
		$data ['page_title'] = lang ( "Payment Success - Vetshop24" );
		$data ['main'] = 'shop/success';
		$data['active_menu']['none'] = 1;
		return view ( "../theme/public", $data, false );
	}

	public function placeorder() {
		
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}
		// echo $_SESSION['paymenttype'];
		if (strpos ( $_SERVER ["HTTP_HOST"], "kriipton" ) !== false) {
			
			include $_SERVER ["DOCUMENT_ROOT"] . "/shop/modules/shop/libraries/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php";
		} else {
			include $_SERVER ["DOCUMENT_ROOT"] . "/modules/shop/libraries/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php";
		}
		
		$data = array ();
		$data['active_menu']['placeorder'] = 1;
		$data['page_status'] = lang("Place Order");
		$data ['product'] = Product::find ( array (
				'id' => $_SESSION ['itemid'] 
		) );
		
		if (isset($_SESSION['vetid'])) {
		
		//$data ['veterinar'] = Veterinars::find ( array (			'id' => $_SESSION ['vetid'] 	) );
		} else {
			//$data['veterinar'] = $_SESSION['vetname'] . " " . $_SESSION['vetcity'];
		}
		$data ['deliveryaddress'] = DeliveryAddress::find ( array (
				'id' => $_SESSION ['deliveryaddressid'] 
		) );
		$data ['invoiceaddress'] = InvoiceAddress::find ( array (
				'id' => $_SESSION ['invoiceaddressid'] 
		) );
		
		$data ['main'] = 'shop/placeorder';
		$data ['page_title'] = lang ( "Vetfriend24 - Finish order" );
		
		if (i_post ()) {
			
			$deliverytype = i_post('deliveryinterval');
			if(count($deliverytype)==3){
				$deliverytype=$deliverytype[0];
			} else{
				$deliverytype=$deliverytype[0]."-".$deliverytype[1];
			}
			$order = new Order ();
			$order
				->setUserId( $_SESSION ['user']->id )
				->setProductId( $_SESSION ['itemid'] )
				->setDeliveryAddressId( $_SESSION ['deliveryaddressid'] )
				
				->setInvoiceAddressId( $_SESSION ['invoiceaddressid'] )
				->setStatus ( 0 )
				->setDate ( date ( "Y-m-d H:i:s" ) )
				->setQuantity ( i_post ( 'quantity' ) )
				->setCurrency($_SESSION['currency'])
				->setDeliveryType($deliverytype)
				->setPaymentTypeId ( $_SESSION['paymenttype'] ); // this should come rom session
			
			
			if (isset($_SESSION['vetname']) AND isset($_SESSION['vetcity'])) {
				$order->setVetId($_SESSION['vetid']);
				$order->setVetName($_SESSION['vetname']);
				$order->setVetCity($_SESSION['vetcity']);
				 
			} elseif (isset($_POST['vetid'])) {
				$order->setVetId($_SESSION['vetid']);
			}
			
			// echo $_SESSION['veterianid'];
			if (isset($_SESSION['veterianid'])){
				// echo "testt";
				
				$veterinar = Veterinars::find(array('id' => $_SESSION ['veterianid']));
				$order->setVetName($veterinar->getName());
				$order->setVetCity($veterinar->getCity());
				$order->setVetId($veterinar->getId());
				$order->setDiscount('10');
			}
			// echo "<pre>";
			// print_r($order);
			// echo "</pre>";
			$_o = $order->insert ();
			
			if ($_SESSION['paymenttype'] == 2) {
				//redirect('/shop/banktransfer/' . $_o);
				redirect('/shop/successbt/0/'.$_o);
			}
			
			$product = Product::find ( array (
					'id' => $_SESSION ['itemid'] 
			) );
			
			if ($_SESSION['currency'] == 'eur') {
				$price = $_POST ['quantity'] * $product->getEURPrice ();
			} elseif ($_SESSION['currency'] == 'gbp') {
				$price = $_POST ['quantity'] * $product->getGBPPrice ();
			} elseif ($_SESSION['currency'] == 'pln') {
				$price = $_POST ['quantity'] * $product->getPLNPrice ();
			}
			
			$currency = 'EUR';
			$_price = 	$product->getEURPrice ();
			if ($_SESSION['currency'] == 'gbp') {
				$currency = 'GBP';
				$_price = $product->getGBPPrice();
			}elseif ($_SESSION['currency'] == 'pln') {
				$currency = 'PLN';
				$_price = $product->getPLNPrice();
			}
			
			if (isset($_SESSION['veterianid'])){
				$_SESSION['price']=$price-($price*10/100);
				$_SESSION['price_single']=$_price-($_price*10/100);
			} else {
				$_SESSION['price']=$price;
				$_SESSION['price_single']=$_price;
			}
			// echo $_SESSION['price'];
			$_SESSION['quantity']=$_POST['quantity'];

			if($_SESSION['paymenttype'] == 3){
				redirect('/shop/ccpayment/'.$_o);
			}
				
			$data['order'] = Order::find(array('id'=>$_o));

			// if($product->getStatus()==1){
			// 	redirect('/');
			// }

			$vat_countryId=DeliveryAddress::find(array('id'=>$data['order']->getDeliveryaddressid()));
			$vat=Vat::getByCountryId($vat_countryId->getCountry());
			$vat_value = 0;

			if ($vat instanceof  Vat) {
				$vat_value = $vat[0]->getValue();
			}

			if(property_exists('Vat', 'value')){
				$vat_value=$vat[0]->getValue();
			}

			// $total_with_vat=$_SESSION['price']+($_SESSION['price']*$vat_value/100);
			// $total_vat=$_SESSION['price']*$vat_value/100;
			// $single_with_vat=$_SESSION['price_single']+($_SESSION['price_single']*$vat_value/100);
			// $single_vat=$_SESSION['price_single']*$vat_value/100;

			// $total_with_vat=$_SESSION['price'];
			// $total_vat=$total_with_vat*$vat_value/100;
			// // 	
			// $single_with_vat=$_SESSION['price_single'];
			// $single_vat=$single_with_vat*$vat_value/100;
			
			$total_with_vat=$_SESSION['price'];
			$total_vat=$total_with_vat-($total_with_vat/(($vat_value/100)+1));

			$single_with_vat=$_SESSION['price_single'];
			$single_vat=$single_with_vat-($single_with_vat/(($vat_value/100)+1));


			// ### Payer
			// A resource representing a Payer that funds a payment
			// For paypal account payments, set payment method
			// to 'paypal'.
			$payer = new Payer ();
			$payer->setPaymentMethod ( "paypal" );
			// ### Itemized information
			// (Optional) Lets you specify item wise
			// information
			$item1 = new Item ();
			$item1->setName ( $product->getName () )->setCurrency ( $currency )->setQuantity ( $_POST ['quantity'] )->setPrice ($single_with_vat-$single_vat);
			
			$itemList = new ItemList ();
			$itemList->setItems ( array (
					$item1 
			) );
			

			$details = new Details ();
			$details->setShipping ( 0 )->setTax ( $total_vat )->setSubtotal ( $total_with_vat -$total_vat);
			// ### Amount
			// Lets you specify a payment amount.
			// You can also specify additional details
			// such as shipping, tax.
			$amount = new Amount ();
			$amount->setCurrency ( $currency )->setTotal ( $total_with_vat )->setDetails($details);
			
			// ### Transaction
			// A transaction defines the contract of a
			// payment - what is the payment for and who
			// is fulfilling it.
			$transaction = new Transaction ();
			$transaction->setAmount ( $amount )->setItemList ( $itemList )->setDescription ( "Vetshop Payment" )->setInvoiceNumber ( uniqid () );
			// ### Redirect urls
			// Set the urls that the buyer must be redirected to after
			// payment approval/ cancellation.
			$baseUrl = getBaseUrl ();
			$redirectUrls = new RedirectUrls ();
			if (strpos ( $_SERVER ["HTTP_HOST"], "kriipton" ) !== false) {
				$redirectUrls->setReturnUrl ( "$baseUrl/index.php/shop/success/?orderid=" . $_o )->setCancelUrl ( "$baseUrl/shop/cancel/?orderid=" . $_o );
			} else {
				$redirectUrls->setReturnUrl ( "$baseUrl/shop/success/?orderid=" . $_o )->setCancelUrl ( "$baseUrl/shop/cancel/?orderid=" . $_o );
			}
			
			// ### Payment
			// A Payment Resource; create one using
			// the above types and intent set to 'sale'
			$payment = new Payment ();
			$payment->setIntent ( "authorize" )->setPayer ( $payer )->setRedirectUrls ( $redirectUrls )->setTransactions ( array (
					$transaction 
			) );
			// For Sample Purposes Only.
			$request = clone $payment;
			// ### Create Payment
			// Create a payment by calling the 'create' method
			// passing it a valid apiContext.
			// (See bootstrap.php for more on `ApiContext`)
			// The return object contains the state and the
			// url to which the buyer must be redirected to
			// for payment approval
			try {
				$payment->create ( $apiContext );
			} catch ( Exception $ex ) {
				// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
				ResultPrinter::printError ( "Created Payment Authorization Using PayPal. Please visit the URL to Authorize.", "Payment", null, $request, $ex );
				exit ( 1 );
			}
			// ### Get redirect url
			// The API response provides the url that you must redirect
			// the buyer to. Retrieve the url from the $payment->getLinks()
			// method
			$approvalUrl = $payment->getApprovalLink ();
			// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
			foreach ( $payment->getLinks () as $link ) {
				if ($link->getRel () == 'approval_url') {
					$approvalUrl = $link->getHref ();
					header ( 'Location:' . $approvalUrl );
					break;
				}
			}
			
			// ResultPrinter::printResult("Created Payment Authorization Using PayPal. Please visit the URL to Authorize.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);
			return $payment;
		}
		return view ( "../theme/public", $data, false );
	}
		

	public function ccpayment($orderid=NULL){
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}

		if(!$orderid){
			redirect("/");
		}
		if($_SESSION['paymenttype']!='3'){
			redirect("/");
		}


		// echo $_SESSION['paymenttype'];
		if (strpos ( $_SERVER ["HTTP_HOST"], "kriipton" ) !== false) {
			
			include $_SERVER ["DOCUMENT_ROOT"] . "/shop/modules/shop/libraries/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php";
		} else {
			include $_SERVER ["DOCUMENT_ROOT"] . "/modules/shop/libraries/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php";
		}

		$data['errors']='';
		$data['page_status'] = lang("Credit Card Payment");

		$data ['active_menu'] ['placeorder'] = 1;
		$data ['main'] = 'shop/ccpayment';
		$data ['page_title'] = lang ( "Vetfriend24 - Credit Card Payment" );

		// echo $_SESSION['itemid'];
		// echo $orderid;
		$data['order'] = Order::find(array('id'=>$orderid));

		$product = Product::find ( array (
				'id' => $_SESSION ['itemid'] 
		) );

		// if($product->getStatus()==1){
		// 	redirect('/');
		// }

		$vat_countryId=DeliveryAddress::find(array('id'=>$data['order']->getDeliveryaddressid()));
	
		$vat=Vat::getByCountryId($vat_countryId->getCountry());
		
		$vat_value = 0;
		if ($vat instanceof  Vat ) {
			$vat_value = $vat->getValue();
		}

		// old
		// $total_with_vat=$_SESSION['price']+($_SESSION['price']*$vat_value/100);
		// $total_vat=$_SESSION['price']*$vat_value/100;
		// $single_with_vat=$_SESSION['price_single']+($_SESSION['price_single']*$vat_value/100);
		// $single_vat=$_SESSION['price_single']*$vat_value/100;
		// 

		// new with included VAT
		$total_with_vat=$_SESSION['price'];
		$total_vat=$total_with_vat*$vat_value/100;
		// 	
		$single_with_vat=$_SESSION['price_single'];
		$single_vat=$single_with_vat*$vat_value/100;
		
		if(i_post()){
			$_SESSION['cc_firstname']=$ccpayment['cc_firstname']=i_post('cc_firstname');
			$_SESSION['cc_lastname']=$ccpayment['cc_lastname']=i_post('cc_lastname');
			$ccpayment['cc_number']=i_post('cc_number');
			$ccpayment['cc_number']=str_replace('-', '', $ccpayment['cc_number']);
			$ccpayment['cc_exp_month']=i_post('cc_exp_month');
			$ccpayment['cc_exp_year']=i_post('cc_exp_year');
			$ccpayment['cc_cvv']=i_post('cc_cvv');
			$ccpayment['cc_type']=i_post('cc_type');

			$card = new CreditCard(); 
			$card->setType($ccpayment['cc_type'])
			->setNumber($ccpayment['cc_number']) 
			->setExpireMonth($ccpayment['cc_exp_month']) 
			->setExpireYear($ccpayment['cc_exp_year']) 
			->setCvv2($ccpayment['cc_cvv']) 
			->setFirstName($ccpayment['cc_firstname']) 
			->setLastName($ccpayment['cc_lastname']);

			$fi = new FundingInstrument(); 
			$fi->setCreditCard($card);

			$payer = new Payer(); 
			$payer
			->setPaymentMethod("credit_card")
			->setFundingInstruments(array($fi));
			// echo "<pre>";
			// print_r($product);
			// echo "</pre>";
			// exit(1);

			$item1 = new Item(); 
			$item1->setName($product->getName()) 
			->setDescription($product->getName()) 
			->setCurrency(strtoupper($_SESSION['currency'])) 
			->setQuantity($_SESSION['quantity']) 
			->setTax($single_vat) 
			->setPrice($_SESSION['price_single']);

			$itemList = new ItemList(); 
			$itemList->setItems(array($item1));
			
			$details = new Details(); 
			$details->setShipping(0)
			->setTax($total_vat)
			->setSubtotal($_SESSION['price']);

			$amount = new Amount();
			$amount->setCurrency(strtoupper($_SESSION['currency']))
			->setTotal($total_with_vat)
			->setDetails($details);
			
			$transaction = new Transaction(); 
			$transaction->setAmount($amount)
			->setItemList($itemList)
			->setDescription("Payment description")
			->setInvoiceNumber(uniqid());

			$payment = new Payment(); 
			$payment->setIntent("sale")
			->setPayer($payer)
			->setTransactions(array($transaction));

			$request = clone $payment;

			try { 
				$payment->create($apiContext); 
			} catch (Exception $ex) {
				// ResultPrinter::printError('Create Payment Using Credit Card. If 500 Exception, try creating a new Credit Card using <a href="https://ppmts.custhelp.com/app/answers/detail/a_id/750">Step 4, on this link</a>, and using it.', 'Payment', null, $request, $ex); 
				// exit(1);
				$pperrors=json_decode($ex->getData(), true);
				// print_r($pperrors['details'][0]);
				$data['errors']=$pperrors['details'][0];
				// exit(1);
				return view ( "../theme/public", $data, false );
				exit(1);
				}

			// ResultPrinter::printResult('Create Payment Using Credit Card', 'Payment', $payment->getId(), $request, $payment); 
			// return $payment;
				$paymentid=$payment->getId();
				$this->success($paymentid,$orderid);
				return $payment;

			// echo "<pre>";
			// json_encode($payment);
			// print_r($payment);
			// echo "</pre>";
		}

		return view ( "../theme/public", $data, false );
	}
	
	public function banktransfer($orderid) {
	
		
			
		
		$data = array();
		$data['active_menu']['paymenttype'] = 1;
		$data ['main'] = 'shop/banktransfer';
		$data ['page_title'] = lang ( "Vetfriend24 - Payment type" );
		
		$data['order'] = Order::find(array('id'=>$orderid));
		
		return view ( "../theme/public", $data, false );
	}
	
	public function pdf($orderid) {
		$data = array();
		$data['active_menu']['paymenttype'] = 1;
		$data ['main'] = 'shop/banktransfer';
		$data ['page_title'] = lang ( "Vetfriend24 - Payment type" );
		
		$data['order'] = Order::find(array('id'=>$orderid));
		
		return view ( "shop/banktransfer", $data, false );
	}

	public function pdfMake($orderid) {
		$data = array();
		$data['active_menu']['paymenttype'] = 1;
		$data ['main'] = 'shop/banktransfer';
		$data ['page_title'] = lang ( "Vetfriend24 - Payment type" );
		
		$data['order'] = Order::find(array('id'=>$orderid));
		
		return view ( "shop/makepdf", $data, false );
	}
	
	public function paymenttype() {
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}
		
		$data = array ();
		$data['active_menu']['paymenttype'] = 1;
		$data['page_status'] = lang("Payment Type");
		$data ['main'] = 'shop/paymenttype';
		$data ['page_title'] = lang ( "Vetfriend24 - Payment type" );
		$data ['types'] = PaymentType::find ();
		
		if (i_post ()) {
			
			$paymenttypeid = i_post ( 'type' );
			
			$user = User::getCurrent ();
			$user->setPaymentTypeId ( $paymenttypeid );
			$user->update ();
		
			$_SESSION['paymenttype'] = i_post('type');
			
			redirect ( "/shop/placeorder" );
			
			
		}
		
		return view ( "../theme/public", $data, false );
	}
	
	
	public function getvetinfo() {
		
		$id = i_post('id');
		
		$veterinar = Veterinars::find(array('id' => $id));
		
		echo $veterinar->getCity();
	}
	
	public function veterinarian($novet=false) {
		$data = array ();
		
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}
		
		if ($novet==1) {
			$_SESSION['vetname'] = 'novet';
			redirect ( "/shop/delivery" );
			
		}
		

		
		$data ['main'] = 'shop/veterinarian';
		$data['page_status'] = lang("Veterian");
		$data ['vets'] = Veterinars::find ();
		// print_r($data['vets']);
		$data ['page_title'] = lang ( "Vetfriend24 - Few Questions" );
		$conf['sortby']='country';
		$data['countries']=Countries::find($conf);
		$conf['sortby']='city';
		$data['cities']=Cities::find($conf);
		if (i_post ()) {
		
			if (i_post('vetname') AND i_post('vetcity')) {
				$_SESSION['country'] = i_post("country");
				$_SESSION['vetname'] = i_post("vetname");
				$_SESSION['vetcity'] =  i_post("vetcity");

				$veterian= new Vets_users();
				$veterian->setVet_name(i_post('vetname'));
				$veterian->setVet_country(i_post('country'));
				$veterian->setVet_city(i_post('vetcity'));
				$veterian->setVet_user_id($_SESSION ['user']->id);
				$veterian->setVet_datum_submited(date('Y-m-d H:i:s'));
				$vet_id=$veterian->insert();
				$_SESSION['vetid']=$vet_id;
				// echo "bla";
			} elseif($_POST['veterianid']) {
				
				$_SESSION ['vetid'] = i_post ( "veterianid" );
				$_SESSION ['veterianid'] = i_post ( "veterianid" );
			}
		
			// name, city ..
			redirect ( "/shop/delivery" );
		}
		
		$data ['active_menu'] ['veterian'] = 1;
		return view ( "../theme/public", $data, false );
	}
	public function getvetbyname() {
		if (i_ajax ()) {
			$vetname = i_post ( "vetname" );
			
			$vets = Veterinars::findByName ( $vetname );
			
			print_r ( $vets );
		}
	}
}