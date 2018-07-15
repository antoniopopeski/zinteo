<?php
class Veterinars extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $name;
	protected $lastname;
	protected $address;
	protected $city;
	protected $country;
	
	public static function findByName($name) {
		$sql = "select * from  veterinars where name like '%$" . $name . "%' limit 20 order by id desc ";
		
		$result = DBApp::conn ()->query ( $sql );
		
		return $reslt->result ();
	}
}