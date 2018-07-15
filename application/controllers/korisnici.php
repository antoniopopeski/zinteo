<?php
class Korisnici extends MY_Controller
{	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		redirect("/korisnici/pregled/");
	}
	
	function pregled()
	{
		$poraka = $this->session->userdata("poraka");
		$greska = $this->session->userdata("greska");
		$data = array("title" => "Преглед на корисници", "uredil"=>$this->uredil,
			"content" => "list_users", "bar" => "Корисници",
			"poraka" => $poraka, "greska" => $greska);
		$this->db->select('id,username,password,date_created,date_modified,uloga');
		$this->db->from('admin');
		$query = $this->db->get();
		$data['lista'] = $query->result_array();
		$this->load->view("template", $data);
		$this->session->unset_userdata("poraka");
		$this->session->unset_userdata("greska");
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
				$sessionData["poraka"] = "Корисникот е успешно внесен!";
				$sessionData["greska"] = "";
			}
			else
			{
				$sessionData["poraka"] = "";
				$sessionData["greska"] = "Корисникот не е внесен!";
			}
			$this->session->set_userdata($sessionData);
			$this->index();
		}
		$data = array("title" => "Додавање на корисник", "content" => "add_user",
			"uredil"=>$this->uredil, "bar" => "Додавање на корисник");
		$this->load->view("template", $data);
	}
	
	function promeni($id=0)
	{
		$this->load->helper('date');
		$data = array("title" => "Уредување на корисник", "content" => "edit_user",
			"uredil"=>$this->uredil, "bar" => "Уредување на корисник");
		
		if($id == 0)
		{
			$id = $this->uri->segment(3);
		}
		if(!$id)
		{
			$this->index();
		}
		if(!empty($_POST["user"]) && isset($_POST["id"]))
		{
			$status = $this->admin_model->update($_POST["user"], $_POST["id"]);
			$sessionData = $this->session->all_userdata();
			if($status)
			{
				$sessionData["poraka"] = "Корисникот е успешно променет!";
				$sessionData["greska"] = "";
			}
			else
			{
				$sessionData["poraka"] = "";
				$sessionData["greska"] = "Корисникот не е променет!";
			}
			$this->session->set_userdata($sessionData);
			$this->index();
		}
		$data['user'] = $this->admin_model->zemiRed($id);
		$this->load->view("template", $data);
	}
	
	function izbrisi($id=0)
	{
		$id = $this->admin_model->delete($this->uri->segment(3));
		$sessionData = $this->session->all_userdata();
		if($id)
		{
			$sessionData["poraka"] = "Корисникот е избришан!";
			$sessionData["greska"] = "";
		}
		else
		{
			$sessionData["poraka"] = "";
			$sessionData["greska"] = "Корисникот не е избришан!";
		}
		$this->session->set_userdata($sessionData);
		$this->index();
	}
}