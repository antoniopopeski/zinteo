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
	protected $paymenttypeid;
	protected $vetid;
	protected $deliverytype;
	protected $discount;
	protected $paid;

	public static function getCountOrdersForCurrentUser($uid=0){
		$sql = "select COUNT(id) as totalorder from `order` where userid = '" . $uid . "'";
		
		$query = DBApp::conn ()->query ( $sql );
		// return print_r($query->result ());
		return ($query->result ());
	}
}