<?php
class Vats extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		loader::lib ( "Vat" );
		loader::lib ( "Countries" );
	}
	
	public function index() {
		
		$data = array ();
		$data ['main'] = "vats/index";
		$data ['page_title'] = lang ( "Vats" );
		
		$data ['vats'] = Vat::find ();
		
		return view ( "../theme/admin", $data, false );
	}
	
	public function insert() {
		$data = array ();
		$data ['main'] = "vats/insert";
		$data ['page_title'] = lang ( "Vats - Insert vat" );

		$data['countries']=Countries::find();
		$data['vats'] = Vat::find ();
		
		$form = lib ( 'ob/validator' );
		

		if (i_post ()) {
				
			$form->set_rules ( 'country', lang ( "Country" ), 'required|xss_clean|' );
			$form->set_rules ( 'value', lang ( "Value" ), 'required|xss_clean' );
			$form->set_rules ( 'from', lang ( "From" ), 'required|xss_clean' );
			$form->set_rules ( 'to', lang ( "To" ), 'required|xss_clean' );
			

			if(!$this->min_date(i_post('to'),i_post('from'))){
				$data['error_max_date']=lang("Date to can not be lower than Date From");
				return view ( "../theme/admin", $data, false );
			}
			
			$min_date=Vat::getByCountryId(i_post('country'));
			if($min_date){
				$min_date=end($min_date);
				$min_date = $min_date->getTo_Date();
				$min_date= date("Y-m-d",strtotime($min_date . '+1 day'));
			
				if(!$this->min_date(i_post('from'),$min_date)){
					$data['error_min_date']=lang("Date from can not be before the previous Date To. Min date:(".$min_date.")");
					return view ( "../theme/admin", $data, false );
				}
				
			}

			// check for validation
			if ($form->run () === FALSE) {
				// validation fail!
				// reload same page with validation errors displayed
				return view ( "../theme/admin", $data, false );
			}
				
	
			$vat = new Vat();
				
			$vat->setCountryid ( i_post ( 'country' ) )->setValue ( i_post ( 'value' ) )->setFrom_Date ( i_post ( 'from' ) )->setTo_Date( i_post('to')." 23:59:59");
				
	
			$pid = $vat->insert ();
				
	
				
			log_me ( 'debug', '[ admin ]: New vat  was added ' );
				
			// sess_set_flash ( 'success', lang ( 'Question was succesfuly edited' ) );
				
			// redirect to index page with messages displayed
			redirect ( "/admin/vats/index" );
		}
		
		return view ( "../theme/admin", $data, false );
	}
	
	public function edit($id) {
		$data = array ();
		$data ['main'] = "vats/edit";
		$data ['page_title'] = lang ( "Vats - Edit vat" );
		
		$data ['vat'] = Vat::find ( array (
				'id' => $id
		) );

		$min_date = $data['vat']->getTo_Date();
		$min_date= date("Y-m-d",strtotime($min_date . '+1 day'));
		
		
		$form = lib ( 'ob/validator' );
		
		if (i_post ()) {
				
			$form->set_rules ( 'country', lang ( "Country" ), 'required|xss_clean' );
			$form->set_rules ( 'value', lang ( "Value" ), 'required|xss_clean' );
			$form->set_rules ( 'from', lang ( "From" ), 'required|xss_clean' );
			$form->set_rules ( 'to', lang ( "To" ), 'required|xss_clean' );
			
			if(!$this->min_date(i_post('from'),$min_date)){
				$data['error_min_date']=lang("Date from can not be before the previous Date To");
				return view ( "../theme/admin", $data, false );
			}

			if(!$this->min_date(i_post('to'),i_post('from'))){
				$data['error_max_date']=lang("Date to can not be lower than Date From");
				return view ( "../theme/admin", $data, false );
			}
			// check for validation
			if ($form->run () === FALSE) {
				// validation fail!
				// reload same page with validation errors displayed
				return view ( "../theme/admin", $data, false );
			}
				
			$vat = Vat::find(array('id'=>i_post("vatid")));
			$vat->setCountryid ( i_post ( 'country' ) )->setValue ( i_post ( 'value' ) )->setFrom_Date ( i_post ( "from" ) )->setTo_Date( i_post('to'));
			$pid = $vat->update ();
				
			log_me ( 'debug', '[ admin ]: Vat was edited: ' );
				
			// sess_set_flash ( 'success', lang ( 'Question was succesfuly edited' ) );
				
			// redirect to index page with messages displayed
			redirect ( "/admin/vats/index" );
		}
		
		return view ( "../theme/admin", $data, false );
		
	}
		
	public function delete($id) {
		Vat::remove ( $id );
		redirect('admin/vats/index');
	}
// callback function for mindate validation
	public function min_date($InputDate,$MinDate){
		if($InputDate<$MinDate){
			return false;
		} else {
			return true;
		}
	}
}