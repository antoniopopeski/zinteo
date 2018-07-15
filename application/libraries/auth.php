<?php

if(! defined('BASEPATH'))
	exit('No direct script access allowed');

if(session_status() == PHP_SESSION_NONE)
{
	session_start();
}

//require 'application/libraries/fb4/autoload.php';/*
require_once 'application/libraries/fb4/src/Facebook/GraphObject.php';
require_once 'application/libraries/fb4/src/Facebook/GraphUser.php';
require_once 'application/libraries/fb4/src/Facebook/GraphSessionInfo.php';
require_once 'application/libraries/fb4/src/Facebook/FacebookSession.php';
require_once 'application/libraries/fb4/src/Facebook/HttpClients/FacebookCurl.php';
require_once 'application/libraries/fb4/src/Facebook/HttpClients/FacebookHttpable.php';
require_once 'application/libraries/fb4/src/Facebook/HttpClients/FacebookCurlHttpClient.php';
require_once 'application/libraries/fb4/src/Facebook/Entities/AccessToken.php';
require_once 'application/libraries/fb4/src/Facebook/FacebookResponse.php';
require_once 'application/libraries/fb4/src/Facebook/FacebookRequest.php';
require_once 'application/libraries/fb4/src/Facebook/FacebookRedirectLoginHelper.php';
require_once 'application/libraries/fb4/src/Facebook/FacebookSDKException.php';
require_once 'application/libraries/fb4/src/Facebook/FacebookRequestException.php';
require_once 'application/libraries/fb4/src/Facebook/FacebookPermissionException.php';
require_once 'application/libraries/fb4/src/Facebook/FacebookAuthorizationException.php';//*/

use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\Entities\AccessToken;
use Facebook\GraphSessionInfo;
use Facebook\FacebookSession;
use Facebook\FacebookCurl;
use Facebook\FacebookHttpable;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookResponse;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookPermissionException;
use Facebook\FacebookAuthorizationException;
class Auth
{
	protected $CI;
	protected $urlRedirect;
	protected $settings;
	protected $session;
	function __construct()
	{
		$this->CI = & get_instance();
		if(strpos(base_url(), "tztdevelop") !== false)
			$settings = array ("appId" => '520132328072343',
							"secret" => 'c6a6611cad5158f8058a48f29f7c36b7',
							"base_url" => 'test.tztdevelop.com');
		else
			$settings = array ("appId" => '648648968491961',
							"secret" => '09159ac7de389f34686a01d11f558d77',
							"base_url" => 'zinteo.com');
		$this->settings = $settings;
		// print_r($settings);
		FacebookSession::setDefaultApplication($settings['appId'], $settings['secret']);
		$params = 'http://'.$settings["base_url"].'/fblogin';
		log_message("error", "redirect_url=>".$params);
		$this->urlRedirect = new FacebookRedirectLoginHelper($params);
		if($this->CI->session->userdata('fb_token'))
		{
			$this->session = new FacebookSession($this->CI->session->userdata('fb_token'));
			
			try
			{
				if(! $this->session->validate())
				{
					$this->session = false;
					$this->CI->session->unset_userdata('fb_token');
				}
			}
			catch(Exception $ex)
			{
				log_message('error', $ex->getMessage()." mark1");
				$this->session = false;
				$this->CI->session->unset_userdata('fb_token');
			}
		} elseif(!$this->session) {
			try
			{
				$helper = new FacebookRedirectLoginHelper($params);
				$this->session = $helper->getSessionFromRedirect();
			}
			catch(FacebookRequestException $ex)
			{
				log_message('error', $ex->getMessage()." mark2");
			}
			catch(Exception $ex)
			{
				log_message('error', $ex->getMessage()." mark3");	
			}
		}
		
		if($this->session)
		{
			$this->CI->session->set_userdata('fb_token', $this->session->getToken());
			$this->session = new FacebookSession($this->session->getToken());
		}
		
		// echo "__construct complete<br>";
	}
	function is_logged_in()
	{
		// echo "is_logged_id<br>";
		$user = $this->CI->session->userdata('fb_user');
		if($user)
			return $user;
		return FALSE;
	}
	function get_profile()
	{
		// echo "get_profile<br>";
		if($this->session)
		{
			try
			{
				$request = new FacebookRequest( $this->session, 'GET', '/me' );
				$response = $request->execute();
				$user = $response->getGraphObject()->asArray();
				
				return $user;
			}
			catch(FacebookRequestException $ex)
			{
				log_message('error', $ex->getMessage()." mark4");
				return false;
			}
		}
		// echo "get_profile_failed<br>";
		return false;
	}
	function get_email()
	{
		// echo "get_email<br>";
		if($this->session)
		{
			try
			{
				$request = new FacebookRequest( $this->session, 'GET', '/me?fields=email' );
				$response = $request->execute();
				$user = $response->getGraphObject()->asArray();
			
				return $user;
			}
			catch(FacebookRequestException $ex)
			{
				log_message('error', $ex->getMessage()." mark5");
				return false;
			}
		}
		//echo "get_email_failed<br>";
		return false;
	}
	function delete_request($request_id)
	{
		// echo "delete_request<br>";
		if($this->session)
		{
			$request = new FacebookRequest($this->session, 'DELETE', '/' . $request_id);
			$response = $request->execute();
			$data = $response->getGraphObject();
			return $data;
		}
		// echo "delete_request_failed<br>";
		return false;
	}
	function smee_post()
	{
		if($this->session)
		{
			$request = new FacebookRequest($this->session, 'GET', '/me/permissions');
			$user_permissions = $request->execute()->getGraphObject(GraphUser::className())->asArray();
			$found_permission = false;
			foreach($user_permissions as $key => $val){
				if($val->permission == 'publish_actions'){
					$found_permission = true;
				}
			}
		}
		return $found_permission;
	}
	function post($post_data)
	{
		// echo "post<br>";
		if($this->session)
		{
			$found_permission = $this->smee_post();
			if($found_permission)
			{
				$request = new FacebookRequest($this->session, 'POST', '/me/feed', $post_data);
				$response = $request->execute();
				$data = $response->getGraphObject();
				return $data;
			} else {
				return "Permissions not granted!";
			}
		}
		// echo "post_failed<br>";
		return false;
	}
	function get_apprequests()
	{
		// echo "get_apprequests<br>";
		if($this->session)
		{
			$request = new FacebookRequest($this->session, 'GET', '/me/apprequests');
			$response = $request->execute();
			$data = $response->getGraphObject();
			return $data;
		}
		// echo "get_apprequests_failed<br>";
		return false;
	}
	function get_login_url($scope)
	{
		// echo "get_login_url<br>";
		try
		{
			return $this->urlRedirect->getLoginUrl($scope);
		}
		catch(FacebookOtherException $err)
		{
			log_message('error', $err->getMessage()." mark6");
			return $err->getMessage();
		}
		catch(Exception $err)
		{
			log_message('error', $err->getMessage()." mark7");
			return $err->getMessage();
		}
	}
	function logout()
	{
		$this->CI->session->unset_userdata('fb_token');
		session_destroy();
		redirect(base_url(), 'location');
	}
}