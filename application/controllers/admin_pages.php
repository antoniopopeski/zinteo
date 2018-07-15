<?php
class admin_pages extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$data = array("content" => "a_pages", "uredil"=>$this->uredil,
				"js" => "tablesorter", "settings" => $this->limits);
		
		if(!empty($_POST["page"]))
		{
			if(isset($_POST["id"]))
			{
				$status = $this->pages->update($_POST["page"], $_POST["id"]);
				$sessionData = $this->session->all_userdata();
				if($status)
					$sessionData["poraka"] = "Data successfully updated";
				else
					$sessionData["poraka"] = "Error";
				$this->session->set_userdata($sessionData);
			}
			else
			{
				$id = $this->pages->insert($_POST["page"]);
				$sessionData = $this->session->all_userdata();
				if($id)
					$sessionData["poraka"] = "Data successfully inserted";
				else
					$sessionData["poraka"] = "Error";
				$this->session->set_userdata($sessionData);
			}
		}
		$data['lista'] = $this->db->query("SELECT id, naslov FROM pages")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = "Error";
		if(is_numeric($id) && $id > 7)
		{
			$uspesnost = $this->pages->delete($id);
			if($uspesnost)
			{
				$sessionData["poraka"] = "Data successfully deleted";
			}
		}
		else 
			$sessionData["poraka"] = "Error, deleting the basic 7 pages if forbidden";
		$this->session->set_userdata($sessionData);
		redirect("admin_pages");
	}
}