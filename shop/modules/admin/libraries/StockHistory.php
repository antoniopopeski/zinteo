<?php
class StockHistory extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $productid;
	protected $productcategoryid;
	protected $oldcount;
	protected $newcount;
	protected $date;
	protected $userid;
	public static function getByProductId($pid = 0) {
		$query = DBApp::conn ()->select ()->where ( "productid", $pid );
		
		$result = $query->get ( strtolower ( get_called_class () ) )->as_class ( get_called_class () );
		
		return ($result) ? $result : new self ();
	}
}