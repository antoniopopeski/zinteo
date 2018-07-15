<?php
class profile extends MY_Public
{
	function index()
	{
		$data = array("content"=>"p_home", "user"=>$this->user, "info"=>$this->info);
		$this->load->view("public_template", $data);
	}
}