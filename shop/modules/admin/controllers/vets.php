<?php
class Vets extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		loader::lib ( "../shop/Vets_users" );
		loader::lib ( "../user/User" );
	}

	public function index(){
		$data = array ();
		$data ['main'] = "vets/index";
		$data ['page_title'] = lang ( "Vets" );
		
		$conf['sortby']='id';
		$conf ['orderby'] = 'desc';
		
		$data ['vets'] = Vets_users::find($conf);
		
		return view ( "../theme/admin", $data, false );
	}
		
}