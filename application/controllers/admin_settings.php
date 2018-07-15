<?php
class admin_settings extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$poraka = $this->session->userdata("poraka");
		$data = array("content" => "a_settings", "uredil"=>$this->uredil,
			"poraka" => $poraka, "js" => "tablesorter", "settings" => $this->limits);
		$data['settings'] = $this->limits;
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function promeni()
	{
		$this->load->model('settings');
		if(!empty($_POST["settings"]))
		{
			$status = $this->settings->update($_POST["settings"]);
			$sessionData = $this->session->all_userdata();
			if($status)
				$sessionData["poraka"] = "Data successfully updated";
			else
				$sessionData["poraka"] = "Error";
			$this->session->set_userdata($sessionData);
			redirect("/admin_settings");
		}
	}
}