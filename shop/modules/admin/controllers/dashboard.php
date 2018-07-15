<?php
class Dashboard extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
	}
	public function index() {
		$data = array ();
		
		$data ['main'] = "admin/index";
		$data ['page_title'] = lang ( "Administrator Home" );
		
		return view ( "../theme/admin", $data, false );
	}
}