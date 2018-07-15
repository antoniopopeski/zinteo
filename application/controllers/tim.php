<?php
class tim extends CI_Controller//MY_Public
{
	protected $user = true;
	function index()
	{
		//$data = array("content"=> "a_drzavi", "admin" => true, "js" => "tablesorter");
		$data = array("content"=>"p_home", "user"=>$this->user);
		$this->load->view("public_template", $data);
	}
}