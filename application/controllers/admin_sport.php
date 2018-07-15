<?php
class admin_sport extends MY_Controller
{
	function index()
	{
		$data = array("content"=> "a_sport", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$sql = "SELECT *,  (SELECT COUNT(n.id) FROM natprevari AS n INNER JOIN kolo AS k ON n.kolo_id=k.id
				INNER JOIN sezona AS s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				WHERE l.sport_id=sportovi.id AND n.id IN (SELECT natprevar_id FROM coeficienti) 
				AND n.pocetok > '".$sega->format("Y-m-d H:i:s")."')	AS broj FROM sportovi ORDER BY id DESC";
		$data['lista'] = $this->db->query($sql)->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function edit()
	{
		$this->load->library('uploader');
		$this->load->model("sport");
		$this->load->model("image_model");
		if(isset($_POST["sport"]) && !empty($_POST["sport"]))
		{
			$data = $_POST["sport"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$uspesnost = $this->sport->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
					$id = $this->sport->lastID();
				}
			}
			else
			{
				$id = $_POST['id'];
				$uspesnost = $this->sport->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			if(isset($_FILES['picture']) && $_FILES['picture']['name']!="")
			try 
			{
				$filename = "./images/sports/item_".$id;
				if(file_exists($filename.".png"))
					unlink($filename.".png");
				elseif(file_exists($filename.".jpeg"))
					unlink($filename.".jpeg");
				
				$relPath = "./images/sports/";
				$galleryPath = realpath($relPath)."/";
				$this->uploader->setPath($galleryPath);
				$this->uploader->setFileType("png");
				//$this->uploader->setPath("./images/sports/");
				$this->uploader->setNewName("osnova_".$id);
				$rezz = $this->uploader->doUpload("picture");
				$filename = end(explode('/',$rezz));
				if(file_exists("./images/sports/".$filename))
					$this->image_model->resizeImg("images/sports/", $filename, 240, 240);
			}
			catch (Exception $e)
			{
				$sessionData["poraka"] = $e->getMessage();
			}
			$this->session->set_userdata($sessionData);
		}
		redirect("admin_sport");
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = "Error";
		$this->load->model("sport");
		if(is_numeric($id))
		{
			$filename = "./images/sports/item_".$id;
			if(file_exists($filename.".png"))
				unlink($filename.".png");
			elseif(file_exists($filename.".jpeg"))
				unlink($filename.".jpeg");
			$uspesnost = $this->sport->delete($id);
			if($uspesnost)
			{
				$sessionData["poraka"] = "Data successfully deleted";
			}
		}
		$this->session->set_userdata($sessionData);
		redirect("admin_sport");
	}
}