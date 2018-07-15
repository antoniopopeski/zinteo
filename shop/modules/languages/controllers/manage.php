<?php
class Manage extends Languages_Controller {
	public function __construct() {
		parent::__construct ();
		loader::helper ( "app/bootstrap_form" );
		loader::lib ( "Language", false );
	}
	public function index() {
		$data = array ();
		$data ['main'] = 'manage/index';
		
		$data ['languages'] = Language::find ();
		
		return view ( "manage/index", $data, false );
	}
	public function insert() {
		$data = array ();
		
		$data ['main'] = "manage/insert";
		
		if (i_post ( "submit" )) {
			
			$form = lib ( 'ob/validator' );
			$form->set_rules ( 'language', lang ( "Language" ), 'required|xss_clean|min_length[3]|max_length[12]' );
			$form->set_rules ( 'code', lang ( "Code" ), 'required|xss_clean|min_length[2]|max_length[4]' );
			// set rule for upload
			
			if ($form->run () === FALSE) {
				return view ( "manage/insert", $data, false );
			} else {
				
				$language = new Language ();
				
				$language->setLanguage ( i_post ( "language" ) );
				$language->setCode ( i_post ( "code" ) );
				
				if ($language->insert ()) {
					// success
					sess_flash ( "success", lang ( "New language was succesfully added" ) );
				} else {
					// error
					sess_flash ( "error", lang ( "Error while inserting new language" ) );
				}
				
				redirect ( "/languages/manage/index" );
			}
		}
		
		return view ( "manage/insert", $data, false ); // if needed edit template
	}
}