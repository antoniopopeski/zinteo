<?php
class Dashboard extends User_Controller {
	public function __construct() {
		parent::__construct ();
		
		if (! is_logged ()) {
			redirect ( "/user/login" );
		}
	}
	public function index() {
		
		// chech profile complete
		
		// check session is there any productid
		if (! isset ( $_SESSION ['vetid'] ) and isset ( $_SESSION ['itemid'] )) {
			redirect ( "/shop/veterinarian" );
		}
		
		redirect ( "/" );
		
		$data ['main'] = 'dashboard/index';
		$data ['page_title'] = lang ( "Dashboard - Vetfriend24" );
		return view ( "../theme/shop", $data, false );
	}
	public function invoiceaddress() {
	}
	public function profile() {
		$data = array ();
		
		$data ['user'] = User::getCurrent ();
		$data ['page_title'] = lang ( "Profile - Vetfriend24" );
		$data ['main'] = 'dashboard/profile';
		$data ['countries'] = Countries::find ();
		
		if (i_post ()) {
			
			$uid = i_post ( 'uid' );
			
			$user = User::find ( array (
					'id' => $uid 
			) );
			
			$user->setFirstName ( i_post ( 'firstname' ) )->setLastName ( i_post ( 'lastname' ) )->setZip ( i_post ( 'zip' ) )->setAddress ( i_post ( 'address' ) )->setCity ( i_post ( "city" ) )->setCountry ( i_post ( 'country' ) );
			
			$user->update ();
			
			redirect ( "/user/profile" );
		}
		return view ( "../theme/shop", $data, false );
	}
	public function getcities() {
		$cid = i_post ( 'countryid' );
		
		$cities = Cities::getByCountry ( $cid );
		
		print_r ( $cities );
		die ();
	}
}