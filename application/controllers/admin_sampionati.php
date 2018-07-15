<?php
class admin_sampionati extends MY_Controller
{
	function index()
	{
		$data = array("content"=> "a_sampionati", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$sql = 'SELECT l.id, l.ime AS sampionat, d.ime AS drzava, t.ime AS sport, l.top,
				(SELECT COUNT(z.id) FROM timovi AS z INNER JOIN sezona_tim st ON st.tim_id=z.id
				INNER JOIN sezona AS s ON s.id=st.sezona_id WHERE s.aktiven=1 AND s.sampionat_id=l.id) AS broj
				FROM sampionati AS l LEFT JOIN drzavi AS d ON d.id=l.drzava_id
				LEFT JOIN sportovi AS t ON t.id=l.sport_id';
		$order = " ORDER BY l.id DESC";
		$data['sportovi'] = $this->db->order_by('ime', 'asc')->get("sportovi")->result();
		$data['drzavi'] = $this->db->order_by('ime', 'asc')->get("drzavi")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$data["selSport"] = $this->session->userdata("fSport");
		$data["selDrzava"] = $this->session->userdata("fDrzava");
		//$data["selSampionat"] = $this->session->userdata("fSampionat");
		//$data["selTim"] = $this->session->userdata("fTim");
		$uslov = "";
		if($data["selDrzava"] || $data["selSport"])
			$uslov .= " WHERE ";
		if($data["selDrzava"] && $data["selSport"])
			$uslov .= "l.drzava_id =".$data['selDrzava']." AND l.sport_id=".$data['selSport'];
		elseif($data["selDrzava"])
			$uslov .= "l.drzava_id =".$data['selDrzava'];
		elseif($data["selSport"])
			$uslov .= "l.sport_id=".$data['selSport'];
		$data['lista'] = $this->db->query($sql.$uslov.$order)->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function select()
	{
		if(isset($_POST["id"]) && $_POST["id"])
		{
			$izbrani = array();
			if(isset($_POST["timovi"]) && is_array($_POST["timovi"]))
				$izbrani = $_POST["timovi"];//id na izbrani timovi
			$this->load->model("sezona_tim");
			$data["sezona_id"] = $_POST['id'];
			$sql = "DELETE FROM sezona_tim WHERE sezona_id=".$data["sezona_id"];
			$this->db->query($sql);
			foreach($izbrani as $i)
			{
				try 
				{
					$data["tim_id"] = $i;
					$this->sezona_tim->insert($data);
				}
				catch (Exception $e) {}
			}
			redirect("admin_sampionati/select");
		}
		$data = array("content"=> "a_sampionatis", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$sql = 'SELECT l.id, l.ime AS sampionat, d.ime AS drzava, t.ime AS sport, l.top,
				(SELECT COUNT(z.id) FROM timovi AS z INNER JOIN sezona_tim st ON st.tim_id=z.id
				INNER JOIN sezona AS s ON s.id=st.sezona_id WHERE s.aktiven=1 AND s.sampionat_id=l.id) AS broj
				FROM sampionati AS l LEFT JOIN drzavi AS d ON d.id=l.drzava_id
				LEFT JOIN sportovi AS t ON t.id=l.sport_id';
		$order = " ORDER BY l.id DESC";
		$data['sportovi'] = $this->db->order_by('ime', 'asc')->get("sportovi")->result();
		$data['drzavi'] = $this->db->order_by('ime', 'asc')->get("drzavi")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$data["selSport"] = $this->session->userdata("fSport");
		$data["selDrzava"] = $this->session->userdata("fDrzava");
		//$data["selSampionat"] = $this->session->userdata("fSampionat");
		//$data["selTim"] = $this->session->userdata("fTim");
		$uslov = "";
		if($data["selDrzava"] || $data["selSport"])
			$uslov .= " WHERE ";
		if($data["selDrzava"] && $data["selSport"])
			$uslov .= "l.drzava_id =".$data['selDrzava']." AND l.sport_id=".$data['selSport'];
		elseif($data["selDrzava"])
			$uslov .= "l.drzava_id =".$data['selDrzava'];
		elseif($data["selSport"])
			$uslov .= "l.sport_id=".$data['selSport'];
		$data['lista'] = $this->db->query($sql.$uslov.$order)->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function edit()
	{
		$this->load->library('uploader');
		$this->load->model("sampionat");
		$this->load->model("image_model");
		if(isset($_POST["sampionat"]) && !empty($_POST["sampionat"]))
		{
			$data = $_POST["sampionat"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$uspesnost = $this->sampionat->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
					$id = $this->sampionat->lastID();
				}
			}
			else
			{
				$id = $_POST['id'];
				$uspesnost = $this->sampionat->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			if(isset($_FILES['picture']) && $_FILES['picture']['name']!="")
			try
			{
				$filename = "./images/leagues/item_".$id;
				if(file_exists($filename.".png"))
					unlink($filename.".png");
				elseif(file_exists($filename.".jpeg"))
					unlink($filename.".jpeg");
				
				$relPath = "./images/leagues/";
				$galleryPath = realpath($relPath)."/";
				$this->uploader->setPath($galleryPath);
				$this->uploader->setFileType("png");
				$this->uploader->setNewName("osnova_".$id);
				$rezz = $this->uploader->doUpload("picture");
				$filename = end(explode('/',$rezz));
				if(file_exists("./images/leagues/".$filename))
					$this->image_model->resizeImg("images/leagues/", $filename, 240, 240);
			}
			catch (Exception $e)
			{
				$sessionData["poraka"] = $e->getMessage();
			}
			$this->session->set_userdata($sessionData);
		}
		redirect("admin_sampionati");
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = "Error";
		$this->load->model("sampionat");
		if(is_numeric($id))
		{
			$uspesnost = $this->sampionat->delete($id);
			if($uspesnost)
			{
				$sessionData["poraka"] = "Data successfully deleted";
			}
		}
		$this->session->set_userdata($sessionData);
		redirect("admin_sampionati");
	}
}