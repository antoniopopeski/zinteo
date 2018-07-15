<?php
class FbLogin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	private $scope = 'user_about_me,email,user_birthday,user_photos,read_stream,publish_stream,read_friendlists';
	protected $limits;
	function index()
	{
		if($this->auth->get_profile())
		{
			$user = $this->auth->get_profile();
			$this->load->model('korisnik');
			$profil = $this->korisnik->profil2($user['id']);
			$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			$vreme = $sega->format("Y-m-d H:i:s");
			if(! $profil && $user)
			{
				// $this->limits->startBids
				$data = array ("fb_id" => $user['id'],
							"username" => strtolower($user['first_name'] . ' ' . $user['last_name']),
							'bids' => 3,"kreiran" => $vreme,
							"fname" => $user['first_name'],"lname" => $user['last_name'],
							"logiran" => $vreme);
				$email = $this->auth->get_email();
				if(isset($email['email']))
					$data['email'] = $email['email'];
				$this->korisnik->insert($data);
				try
				{
					$requests = $this->auth->get_apprequests();
					if(isset($requests["apprequests"]))
					{
						$request_content = $requests["apprequests"]["data"];
						foreach($request_content as $b)
						{
							if($b["application"]["id"] == $this->config->item('appId'))
							{
								try
								{
									$this->auth->delete_request($b["id"]);
								}
								catch(FacebookApiException $e)
								{
								}
								$from_id = $b["from"]["id"];
								if($from_id && isset($_GET["request_ids"]))
								{
									$sql = "UPDATE tipuvaci SET tiperi_pokaneti = tiperi_pokaneti + 1
							WHERE fb_id='" . $from_id . "'";
									$this->db->query($sql);
								}
							}
						}
					}
				}
				catch(Exception $error)
				{
				}
			}
			else
			{
				$profil->logiran = $vreme;
				$email = $this->auth->get_email();
				if(isset($email['email']))
					$profil->email = $email['email'];
				$this->korisnik->update($profil, $profil->id);
			}
			$sessionData = $this->session->all_userdata();
			$sessionData["fb_user"] = $user;
			$this->session->set_userdata($sessionData);
			redirect('/home');//
		}
		$loginUrl = $this->auth->get_login_url(array ('email'));
		$data = array ('login_url' => $loginUrl,"content" => "fblogin_view");
		$this->load->view('public_template', $data);
	}
	function logout()
	{
		$base_url = $this->config->item('base_url');
		$this->session->sess_destroy();
		redirect('/');
	}
}
