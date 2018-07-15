<?php
class admin_home extends MY_Controller
{
	function index()
	{
		$data = array("content"=> "a_home", "uredil"=>$this->uredil,
			"settings" => $this->limits);
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function picture()
	{
		$this->load->library('uploader');
		$this->load->model("settings");
		$sessionData = $this->session->all_userdata();
		if(isset($_FILES['picture']) && $_FILES['picture']['name']!="")
		{
			try
			{
				$filename = "./images/slika";
				if(file_exists($filename.".png"))
					unlink($filename.".png");
				elseif(file_exists($filename.".jpeg"))
					unlink($filename.".jpeg");
				
				$relPath = './images/';
				$galleryPath = realpath($relPath)."/";
				$this->uploader->setPath($galleryPath);
				$this->uploader->setNewName("slika");
				$rezz = $this->uploader->doUpload("picture");
				$filename = end(explode('/',$rezz));
				$this->limits->slika = $filename;
				$this->settings->update($this->limits);
			}
			catch (Exception $e)
			{
				$sessionData["poraka"] = $e->getMessage();
			}
		}
		redirect("admin_home");
	}
	
	function picture2()
	{
		$this->load->library('uploader');
		$this->load->model("settings");
		$sessionData = $this->session->all_userdata();
		if(isset($_FILES['picture']) && $_FILES['picture']['name']!="")
		{
			try
			{
				$filename = "./images/background";
				if(file_exists($filename.".png"))
					unlink($filename.".png");
				elseif(file_exists($filename.".jpeg"))
					unlink($filename.".jpeg");
				
				$relPath = './images/';
				$galleryPath = realpath($relPath)."/";
				$this->uploader->setPath($galleryPath);
				$this->uploader->setNewName("background");
				$rezz = $this->uploader->doUpload("picture");
			}
			catch (Exception $e)
			{
				$sessionData["poraka"] = $e->getMessage();
			}
		}
		redirect("admin_home");
	}
}