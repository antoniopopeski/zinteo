<?php
class logout extends CI_Controller
{
	function index()
	{
		$this->auth->logout();
		session_destroy();
		redirect("");
	}
}