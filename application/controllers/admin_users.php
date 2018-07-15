<?php
class admin_users extends MY_Controller
{	
	function index()
	{
		$poraka = $this->session->userdata("poraka");
		$data = array("title" => "Users", "uredil"=>$this->uredil,
			"content" => "list_users", "js" => "tablesorter",
			"poraka" => $poraka, "settings" => $this->limits);
		$sql = "SELECT id,username,password,date_created,date_modified,uloga
			FROM admin ORDER BY id DESC";
		$query = $this->db->query($sql);
		$data['lista'] = $query->result();
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function dodadi()
	{
		$this->load->helper('date');
		if(!empty($_POST["user"]))
		{
			$id = $this->admin_model->insert($_POST["user"]);
			$sessionData = $this->session->all_userdata();
			if($id)
			{
				$sessionData["poraka"] = "Data successfully inserted";
			}
			else
			{
				$sessionData["poraka"] = "Error!";
			}
			$this->session->set_userdata($sessionData);
			redirect("admin_users");
		}
		$data = array("title" => "New user", "content" => "add_user",
				"uredil"=>$this->uredil);
		$this->load->view("template", $data);
	}
	
	function promeni($id=0)
	{
		$this->load->helper('date');
		$data = array("title" => "Edit user", "content" => "edit_user",
				"uredil"=>$this->uredil);
		
		if($id == 0)
		{
			$id = $this->uri->segment(3);
		}
		if(!$id)
		{
			redirect("admin_users");
		}
		if(!empty($_POST["user"]) && isset($_POST["id"]))
		{
			$status = $this->admin_model->update($_POST["user"], $_POST["id"]);
			$sessionData = $this->session->all_userdata();
			if($status)
			{
				$sessionData["poraka"] = "Data successfully updated";
			}
			else
			{
				$sessionData["poraka"] = "Error!";
			}
			$this->session->set_userdata($sessionData);
			redirect("admin_users");
		}
		$data['user'] = $this->admin_model->oneObject($id);
		$this->load->view("template", $data);
	}
	
	function izbrisi($id=0)
	{
		$id = $this->admin_model->delete($this->uri->segment(3));
		$sessionData = $this->session->all_userdata();
		if($id)
		{
			$sessionData["poraka"] = "Data successfully deleted";
		}
		else
		{
			$sessionData["poraka"] = "Error!";
		}
		$this->session->set_userdata($sessionData);
		$this->index();
	}
}
