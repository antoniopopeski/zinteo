<?php
class Users extends User_Controller {
	public function __construct() {
		parent::__construct ();
		loader::lib ( "User" );
		loader::lib("ob/Email");
		
		//loader::lang ( 'app/en', 'language' );
		set_language();
		
	}
	public function index() {

	
		
	
	}
	public function usertest() {
		$data = array ();
		
		return view ( "theme/public", $data, false );
	}
	
	public function resetpassword($hash = 0) {
		
		$data = array();
		$data['main'] = 'user/resetpassword';
		$data['error'] = "";
		if (i_post()) {
			
			$password = i_post('password');
			$password_comfirm = i_post('password_comfirm');
			$user = User::find(array('id'=>i_post('uid')));
			
			if ($password == $password_comfirm) {
				$user->setPassword(md5(i_post('password')));
				$user->update();
				$data['user'] = $user;
				$data['password_change'] = 1;
				return view ( "../theme/public", $data, false );
			} else {
				
				$data['user'] = $user;
				$data['error'] = "Password doesnt match";
				$data['password_change'] = 0;
				return view ( "../theme/public", $data, false );
			}
		}
		
		if ($hash) {
			$data['password_change'] = 0;
			
			$data['main'] = 'user/resetpassword';
			$data['password_change'] = 0;
			$data['user'] = User::getByPasswordHash($hash);
			
			
		return view ( "../theme/public", $data, false );		
		} else {
			redirect(base_url());
		}
	}
	
	public function forgotpassword() 
	{
		$data = array ();
		$data['main'] = 'user/forgotpassword';
		$data['password_change'] = 0;
		$data['error'] = "";
		if (i_post()) {
			
			$email = i_post('email');
			$user = user::getByEmail($email);
			
			if ($user instanceof  User) {
			$forgot_password_hash = md5(time());
			
			$user->setForgotPassword($forgot_password_hash);
			$user->update();
			
			$html = "";
			$html .="<html><body>";
			$html .= "Please click <a href='http://vetfriend24.kriipton.com/shop/user/users/resetpassword/".$forgot_password_hash."' target='_blank' >here</a> to reset your password"; 
			$html .="</body></html>";
			
			$to      = $user->getEmail();
			$subject = 'VetFriend24 - Password Change';
			$message = $html;
			$headers = 'From: no-replay@vetfriend24.kriiptin.com' . "\r\n" .
					'Reply-To: no-replay@vetfriend24.kriiptin.com' . "\r\n" .
					'MIME-Version: 1.0 ' . "\r\n" .
					'Content-Type: text/html; charset=ISO-8859-1 '. "\r\n".
					'X-Mailer: PHP/' . phpversion();
			
			// mail($to, $subject, $message, $headers);
			// echo "<pre>";
			// print_r(mail($to, $subject, $message, $headers));
			// echo "</pre>";
			$this->email->set_mailtype("html");
			$this->email->from('no-replay@vetfriend24.kriiptin.com', 'VetFriend24 - Password Change');
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);

			if($this->email->send()) 
			{
			   //conditional true
				$data['password_change'] = 1;
			}
			// send email
			
			
			} else {
				$data['error'] = lang("This email does not exist in the system!");
			}
		}
		
		return view ( "../theme/public", $data, false );
	}
	
	public function login() {
	
		$data = array ();
		$data ['errors'] = array ();
		$data ['main'] = 'user/login';
		$data ['active_menu'] ['login'] = 1;
		if (i_post ()) {
			
			$userexist = i_post ( "userexist" );
			if ($userexist == 1) {
				// login
				$user = User::login ( array (
						'email' => i_post ( 'email' ),
						'password' => i_post ( 'password' ) 
				) );
				
				if ($user) {
					
					$_SESSION ['user'] = current ( $user );
					$user = User::find(array('id'=>$user[0]->id));
					$user->setLastlogin(date("Y-m-d H:i:s"));
					$user->update();
					redirect ( "/user/dashboard" );
				} 

				else {
					$data ['errors'] = lang ( "Wrong username or password." );
					return view ( "../theme/public", $data, false );
				}
			} 

			else {
				
				$_SESSION ['email_new_user'] = i_post ( 'email' );
				
				redirect ( '/user/register' );
				// register and login
			}
		}
		
		return view ( "../theme/public", $data, false );
	}
	public function register() {
		if (! isset ( $_SESSION ['email_new_user'] )) {
			redirect ( '/user/login' );
		}
		
		$data = array ();
		$data ['main'] = 'user/register';
		$data ['errors'] = false;
		$data ['what'] = false;
		$data ['active_menu'] ['login'] = 1;
		
		if (i_post ()) {
			$password = i_post ( 'password' );
			$comfirm_password = i_post ( 'comfirm_password' );
			
			$email = i_post ( 'email' );
			$comfirm_email = i_post ( 'email_confirm' );

			if ($password == $comfirm_password) {
				
				if ($email === $comfirm_email) {
					$_SESSION ['email_new_user']=i_post('email');
					$user = new User ();
					
					$user->setEmail ( $_SESSION ['email_new_user'] );
					$user->setPassword ( md5 ( $password ) );
					$user->setCreated ( date("Y-m-d H:i:s"));
					$user->setLastlogin( date("Y-m-d H:i:s"));

					$id = $user->insert ();
					
					$_user = User::login ( array (
							'email' => $_SESSION ['email_new_user'],
							'password' => i_post ( 'password' ) 
					) );
					
					if ($_user) {
						
						$_SESSION ['user'] = current ( $_user );
						redirect ( "/user/dashboard" );
					}
				}
				$data['what']='email';
				$data ['errors'] = lang ( "Email does not match!" );
					
				return view ( "../theme/public", $data, false );
			}
			$data['what']='password';
			$data ['errors'] = lang ( "Passwords does not match!" );
		}
		
		return view ( "../theme/public", $data, false );
	}
	public function logout() {
		User::logout ();
		
		redirect ( "/user/login" );
	}

}