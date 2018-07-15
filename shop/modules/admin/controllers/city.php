<?php
class City extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		loader::lib ( "Countries" );
		loader::lib ( "Cities" );
	}

	public function index(){
		$data = array ();
		$data ['main'] = "cities/index";
		$data ['page_title'] = lang ( "Cities" );
		
		$data ['cities'] = Cities::find();
		
		return view ( "../theme/admin", $data, false );
	}

	public function insert(){
		$data = array ();
		$data ['main'] = "cities/insert";
		$data ['page_title'] = lang ( "City - Insert city" );

		$data['countries']=Countries::find();
		// $data['cities'] = Cities::find ();
		
		$form = lib ( 'ob/validator' );
		
		if (i_post ()) {
				
			$form->set_rules ( 'country', lang ( "Country" ), 'required|xss_clean|' );
			$form->set_rules ( 'city', lang ( "City" ), 'required|xss_clean' );
		
				
			// check for validation
			if ($form->run () === FALSE) {
				// validation fail!
				// reload same page with validation errors displayed
				return view ( "../theme/admin", $data, false );
			}
				
		
			$city = new Cities();
			$city->setCountryid(i_post('country'));
			$city->setCity(i_post('city'));	

			$pid=$city->insert();
				
		
				
			log_me ( 'debug', '[ admin ]: New city  was added ' );
				
			// sess_set_flash ( 'success', lang ( 'Question was succesfuly edited' ) );
				
			// redirect to index page with messages displayed
			redirect ( "/admin/city/index" );
		}
		
		return view ( "../theme/admin", $data, false );
	}

	public function edit($id) {
		$data = array ();
		$data ['main'] = "cities/edit";
		$data ['page_title'] = lang ( "Cities - Edit city" );
		
		$data['countries']=Countries::find();
		$data ['city'] = Cities::find ( array (
				'id' => $id
		) );


		$form = lib ( 'ob/validator' );
		
		if (i_post ()) {
				
			$form->set_rules ( 'country', lang ( "Country" ), 'required|xss_clean' );
			$form->set_rules ( 'city', lang ( "City" ), 'required|xss_clean' );
			
			// check for validation
			if ($form->run () === FALSE) {
				// validation fail!
				// reload same page with validation errors displayed
				return view ( "../theme/admin", $data, false );
			}
			
			$city = Cities::find(array('id'=>$id));
			$city->setCountryid(i_post('country'));
			$city->setCity(i_post('city'));	

			$pid=$city->update();
				
			log_me ( 'debug', '[ admin ]: City was edited: ' );
				
			// sess_set_flash ( 'success', lang ( 'Question was succesfuly edited' ) );
				
			// redirect to index page with messages displayed
			redirect ( "/admin/city/index" );
		}
		
		return view ( "../theme/admin", $data, false );
		
	}
		
	public function delete($id) {
		Cities::remove ( $id );
	}
}