<?php
class Klienti extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->db->query("UPDATE klienti SET saldo = (SELECT COALESCE(SUM(iznos)*1.18,0) FROM fakture 
				WHERE klient_id=klienti.id AND platena=0)");
		$data = array("content" => "klienti", "title" => "КЛИЕНТИ",
				"uredil"=>$this->uredil, "bar" => "Клиенти");
		$data["lista"] = $this->klienti_model->getObjects();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function dodadi()
	{
		if(isset($_POST["klient"]) && !empty($_POST["klient"]))
		{
			$data = $_POST["klient"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = $this->execute($this->klienti_model, $data, "insert");
			$this->session->set_userdata($sessionData);
		}
		redirect("/klienti");
	}
	
	function promeni()
	{
		if(isset($_POST["klient"]) && !empty($_POST["klient"]) &&
				isset($_POST["id"]) && !empty($_POST["id"]))
		{
			$data = $_POST["klient"];
			$id = $_POST["id"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = $this->execute($this->klienti_model, $data, "update", $id);
			$this->session->set_userdata($sessionData);
		}
		redirect("/klienti");
	}
	
	function brisi()
	{
		$id = $this->uri->segment(3);
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = $this->execute($this->klienti_model, "" , "delete", $id);
		$this->session->set_userdata($sessionData);
		redirect("/klienti");
	}
}