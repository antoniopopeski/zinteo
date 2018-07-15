<?php
class wall extends CI_Controller
{
	function index()
	{
		//$data = array("content"=> "a_drzavi", "admin" => true, "js" => "tablesorter");
		$data = array("content"=> "a_dashboard", "admin"=>true);
		$this->load->view("template", $data);
	}
}