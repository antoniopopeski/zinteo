<?php
class Languages extends Languages_Controller {
	public function __construct() {
		parent::__construct ();
	
	}
	public function index() {
	}
	public function set_language() {
		$data = array ();
		
		if (i_request ( 'lang' )) {
			sess_set ( "lang", $_POST ['lang'] );
			redirect ( $_SERVER ['HTTP_REFERER'] );
		}
		
		echo json_encode ( array (
				'view' => view ( 'languages/set_language', $data ) 
		) );
	}
}