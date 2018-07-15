<?php
class Cities extends AppCore {
	public function __construct() {
	 	 parent::__construct ();
	}
	protected $id;
	protected $countryid;
	protected $city;

	public static function getByCountryId($cid = 0) {
		$query = DBApp::conn ()->select ()->where ( "countryid", $cid )->orderby('city');
		
		$result = $query->get ( strtolower ( get_called_class () ) )->as_class ( get_called_class () );
		
		return ($result) ? $result : new self ();
	}
}