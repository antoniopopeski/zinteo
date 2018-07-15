<?php
class Login extends Controller {
	public function __construct() {
		parent::__construct ();
		set_language();
	}
	public function index() {
		
		$data = array ();
		if (i_post ()) {
			
			$username = i_post ( "username" );
			$password = i_post ( "password" );
			
			$admin = Admins::login ( array (
					"username" => $username,
					'password' => $password 
			) );
			
			if ($admin) {
				Admins::setCurrent ( $admin->id );
				redirect ( '/admin/dashboard' );
			}
		}
		return view ( 'login/index', $data, false );
	}
	public function logout() {
		Admins::logout ();
	}
}