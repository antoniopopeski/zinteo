<?php
class Cities extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $country;
	protected $city;
	protected $shipping_price;
	protected $available;
	public static function getByCountry($c) {
		DBApp::conn ()->where ( 'country', $c );
		DBApp::conn ()->from ( strtolower ( get_called_class () ) );
		$result = DBApp::conn ()->get ()->result ();
		
		return $result;
	}
}