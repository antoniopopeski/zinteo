<?php
class mob_info extends CI_Controller //MY_Public
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('pages');
	}
	
	function index()
	{
		$this->about();
	}
	
	function contact()
	{
		$data = array("content" => "p_info", "page" => $this->pages->oneObject(1));
		$this->load->view("public_template", $data);
	}
	
	function about()
	{
		$data = array("content" => "p_info", "page" => $this->pages->oneObject(2));
		$this->load->view("public_template", $data);
	}
	
	function rules()
	{
		$data = array("content" => "p_info", "page" => $this->pages->oneObject(3));
		$this->load->view("public_template", $data);
	}
	
	function awards()
	{
		$data = array("content" => "p_info", "page" => $this->pages->oneObject(4));
		$this->load->view("public_template", $data);
	}
	
	function invite()
	{
		$data = array("content" => "p_info", "page" => $this->pages->oneObject(5));
		$this->load->view("public_template", $data);
	}
	
	function checkout()
	{
		$data = array("content" => "p_info", "page" => $this->pages->oneObject(6));
		$this->load->view("public_template", $data);
	}

	function rate()
	{
		$data = array("content" => "p_info", "page" => $this->pages->oneObject(7));
		$this->load->view("public_template", $data);
	}

	function promo()
	{
		$data = array("content" => "p_info", "page" => $this->pages->oneObject(8));
		$this->load->view("public_template", $data);
	}
}