<?php
class Vat extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $countryid;
	protected $value;
	protected $from_date;
	protected $to_date;

	public static function getByCountryId($cid=0){
		$query = DBApp::conn ()->select ()->where ( "countryid", $cid );
		// return print_r($query);
		$result = $query->get ( strtolower ( get_called_class () ) )->as_class ( get_called_class () );
		// return $cid." ".print_r($result);
		return ($result) ? $result : false;
	}
	
}