<?php
class DeliveryAddress extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $userid;
	protected $firstname;
	protected $lastname;
	protected $street;
	protected $streetno;
	protected $zip;
	protected $city;
	protected $country;
	protected $phone;
	protected $email;
	public static function getForCurrentUser($uid) {
		$sql = "select * from deliveryaddress where userid = '" . $uid . "' order by id desc limit 1";
		
		$query = DBApp::conn ()->query ( $sql );
		// return print_r($query->result ());

		return ($query->result ());
	}
}