<?php
class Order extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $userid;
	protected $productid;
	protected $deliveryaddressid;
	protected $invoiceaddressid;
	protected $quantity;
	protected $status;
	protected $date;
	protected $paymentid;
	protected $token;
	protected $paymenttypeid;
	protected $vetid;
	protected $vetname;
	protected $vetcity;
	protected $currency;
	protected $deliverytype;
	protected $discount;
	protected $paid;
	
	public static function getOrderByUserId($uid) {
		$sql = "select * from `order` where userid = '" . $uid . "' ORDER BY id DESC";
		
		$result = DBApp::conn ()->query ( $sql );
		// print_r($result);die;
		return $result->result ();
	}
}