<?php
class Admins extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $name;
	protected $username;
	protected $password;
	public static function login($data = array()) {
		if (isset ( $data ['username'] ) and isset ( $data ['password'] )) {
			
			DBApp::conn ()->where ( 'username', $data ['username'] )->where ( 'password', $data ['password'] );
			DBApp::conn ()->from ( strtolower ( get_called_class () ) );
			$result = DBApp::conn ()->get ()->result ();
			
			if ($result) {
				return current ( $result );
			} else {
				return false;
			}
		} else {
			return new self ();
		}
	}
	public static function getCurrent() {
		$user = $_SESSION ['admin'];
		return self::find ( array (
				"id" => $user ['id'] 
		) );
	}
	public static function logout() {
		sess_destroy ();
		redirect ( "/admin/login" );
	}
	public static function setCurrent($id) {
		if ($id and is_numeric ( $id )) {
			
			$user = self::find ( array (
					"id" => $id 
			) );
			
			$sessdata = array (
					"id" => $id,
					"username" => $user->getUsername (),
					"name" => $user->getName () 
			);
			
			$_SESSION ['admin'] = $sessdata;
		}
	}
}