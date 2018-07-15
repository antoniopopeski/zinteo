<?php
class info extends MY_Public
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
		$page = $this->pages->oneObject(1);
		$data = array ("content" => "p_info2","page" => $page,
				"user"=>$this->user, "info"=>$this->info, 'title' => $page->naslov);
		$this->load->view("public_template", $data);
	}
	
	function about()
	{
		$page = $this->pages->oneObject(2);
		$data = array ("content" => "p_info2","page" => $page,
				"user"=>$this->user, "info"=>$this->info, 'title' => $page->naslov);
		$this->load->view("public_template", $data);
	}
	
	function rules()
	{
		$page = $this->pages->oneObject(3);
		$data = array ("content" => "p_info2","page" => $page,
				"user"=>$this->user, "info"=>$this->info, 'title' => $page->naslov);
		$this->load->view("public_template", $data);
	}
	
	function awards()
	{
		$page = $this->pages->oneObject(4);
		$data = array ("content" => "p_info2","page" => $page,
				"user"=>$this->user, "info"=>$this->info, 'title' => $page->naslov);
		$this->load->view("public_template", $data);
	}
	
	function invite()
	{
		$page = $this->pages->oneObject(5);
		$data = array ("content" => "p_info2","page" => $page,
				"user"=>$this->user, "info"=>$this->info, 'title' => $page->naslov);
		$this->load->view("public_template", $data);
	}
	
	function checkout()
	{
		$page = $this->pages->oneObject(6);
		$data = array ("content" => "p_info2","page" => $page,
				"user"=>$this->user, "info"=>$this->info, 'title' => $page->naslov);
		$this->load->view("public_template", $data);
	}

	function facebook()
	{
		$page = $this->pages->oneObject(11);
		$data = array ("content" => "p_info2","page" => $page,
				"user"=>$this->user, "info"=>$this->info, 'title' => $page->naslov);
		$this->load->view("public_template", $data);
	}

	function blog()
	{
		$page = $this->pages->oneObject(12);
		$data = array ("content" => "p_info2","page" => $page,
				"user"=>$this->user, "info"=>$this->info, 'title' => $page->naslov);
		$this->load->view("public_template", $data);
	}
}