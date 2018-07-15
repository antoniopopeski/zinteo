<?php
class admin_reports extends MY_Controller
{
	function index()
	{
		//$data = array("content"=> "a_drzavi", "uredil"=>$this->uredil, "js" => "tablesorter");
		$data = array("content"=> "a_reports", "uredil"=>$this->uredil,
			"settings" => $this->limits);
		$data['lista'] = $this->db->order_by('id', 'desc')->get('drzavi')->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function edit()
	{
		$this->load->library('uploader');
		$this->load->model("drzava");
		$this->load->model("image_model");
		if(isset($_POST["drzava"]) && !empty($_POST["drzava"]))
		{
			$data = $_POST["drzava"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$uspesnost = $this->drzava->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
					$id = $this->drzava->lastID();
				}
			}
			else
			{
				$id = $_POST['id'];
				$uspesnost = $this->drzava->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			if(isset($_FILES['picture']) && $_FILES['picture']['name']!="")
			try
			{
				$this->uploader->setPath("./images/countries/");
				$this->uploader->setNewName("osnova_".$id);
				$rezz = $this->uploader->doUpload("picture");
				$filename = end(explode('/',$rezz));
				$this->image_model->resizeImg("images/countries/", $filename, 240, 240);
			}
			catch (Exception $e)
			{
				$sessionData["poraka"] = $e->getMessage();
			}
			$this->session->set_userdata($sessionData);
		}
		redirect("admin_drzavi");
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = "Error";
		$this->load->model("drzava");
		if(is_numeric($id))
		{
			$uspesnost = $this->drzava->delete($id);
			if($uspesnost)
			{
				$sessionData["poraka"] = "Data successfully deleted";
			}
		}
		$this->session->set_userdata($sessionData);
		redirect("admin_drzavi");
	}
}