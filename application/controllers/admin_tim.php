<?php
class admin_tim extends MY_Controller
{
	private $sql = "SELECT DISTINCT(t.id), t.ime, t.grad, t.kratenka, d.ime AS drzava, s.ime as sport, 
			t.tip, (SELECT GROUP_CONCAT(CONCAT(sezona.ime, ' - ', sampionati.ime) SEPARATOR ', ') 
			FROM sezona INNER JOIN sampionati ON sezona.sampionat_id=sampionati.id
			INNER JOIN sezona_tim ON sezona_tim.sezona_id=sezona.id 
			WHERE sezona_tim.tim_id=t.id AND sezona.aktiven=1) AS sampionat, t.top
			FROM timovi AS t LEFT JOIN drzavi AS d ON d.id=t.drzava_id
			INNER JOIN sportovi AS s ON s.id=t.sport_id
			LEFT JOIN sezona_tim AS st ON st.tim_id=t.id LEFT JOIN sezona AS z ON z.id=st.sezona_id
			LEFT JOIN sampionati AS l ON z.sampionat_id=l.id";
	
	function index()
	{
		$search = $this->uri->segment(3);
		if(isset($_POST["search"]) && !empty($_POST["search"]))
		{
			redirect("admin_tim/index/".$_POST["search"]);
		}
		$order = " ORDER BY t.id DESC";
		$data = array("content"=> "a_timovi", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data["selSport"] = $this->session->userdata("fSport");
		$data["selDrzava"] = $this->session->userdata("fDrzava");
		$data["selSampionat"] = $this->session->userdata("fSampionat");
		$data["selTipTim"] = $this->session->userdata("fTipTim");
		$data["selTopTim"] = $this->session->userdata("fTopTim");
		$data['sportovi'] = $this->db->order_by('ime', 'asc')->get("sportovi")->result();
		$data['drzavi'] = $this->db->order_by('ime', 'asc')->get("drzavi")->result();
		$sql = "SELECT s.id, CONCAT_WS(' ', s.ime,'[',d.ime,']') AS ime
				FROM sampionati AS s LEFT JOIN drzavi AS d ON d.id=s.drzava_id
				ORDER BY s.ime ASC";
		$data['sampionati'] = $this->db->query($sql)->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$uslov = "";
		if($data["selDrzava"] || $data["selSport"] || $data["selSampionat"] || $data["selTipTim"]
				|| $data["selTopTim"])
			$uslov .= " WHERE ";
		if($data["selDrzava"] && $data["selSport"] && $data["selSampionat"] && $data["selTipTim"]
				&& $data["selTopTim"])
			$uslov .= "t.drzava_id =".$data['selDrzava']." AND t.sport_id=".$data['selSport']
				." AND l.id=".$data['selSampionat']." AND t.tip=".$data['selTipTim'].
				" AND t.top=".(($data['selTopTim']==1)?1:0);
		else
		{
			if($data["selDrzava"])
				$uslov .= "t.drzava_id =".$data['selDrzava']." AND ";
			if($data["selSport"])
				$uslov .= "t.sport_id =".$data['selSport']." AND ";
			if($data["selSampionat"])
				$uslov .= "l.id=".$data['selSampionat']." AND ";
			if($data["selTipTim"])
				$uslov .= "t.tip=".$data['selTipTim']." AND ";
			if($data["selTopTim"])
				$uslov .= "t.top=".(($data['selTopTim']==1)?1:0)." AND ";
			$uslov = substr($uslov, 0, strlen($uslov)-5);
		}
		if($search)
		{
			if($uslov)
				$uslov .= " AND t.ime LIKE '%".$search."%'";
			else 
				$uslov = " WHERE t.ime LIKE '%".$search."%'";
		}
		$data['lista'] = $this->db->query($this->sql.$uslov.$order)->result();
		$data['search'] = $search;
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function edit()
	{
		$this->load->library('uploader');
		$this->load->model("tim");
		$this->load->model("image_model");
		if(isset($_POST["tim"]) && !empty($_POST["tim"]))
		{
			$data = $_POST["tim"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$uspesnost = $this->tim->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
					$id = $this->tim->lastID();
				}
			}
			else
			{
				$id = $_POST['id'];
				$uspesnost = $this->tim->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			if(isset($_FILES['picture']) && $_FILES['picture']['name']!="")
			try
			{
				$filename = "./images/teams/item_".$id;
				if(file_exists($filename.".png"))
					unlink($filename.".png");
				elseif(file_exists($filename.".jpeg"))
					unlink($filename.".jpeg");
				
				$relPath = "./images/teams/";
				$galleryPath = realpath($relPath)."/";
				$this->uploader->setPath($galleryPath);
				$this->uploader->setFileType("png");
				//$this->uploader->setPath("./images/teams/");
				$this->uploader->setNewName("osnova_".$id);
				$rezz = $this->uploader->doUpload("picture");
				$filename = end(explode('/',$rezz));
				if(file_exists("./images/teams/".$filename))
					$this->image_model->resizeImg("images/teams/", $filename, 240, 240);
			}
			catch (Exception $e)
			{
				$sessionData["poraka"] = $e->getMessage();
			}
			$this->session->set_userdata($sessionData);
		}
		redirect("admin_tim");
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = "Error";
		$this->load->model("tim");
		if(is_numeric($id))
		{
			$uspesnost = $this->tim->delete($id);
			if($uspesnost)
			{
				$sessionData["poraka"] = "Data successfully deleted";
			}
		}
		$this->session->set_userdata($sessionData);
		redirect("admin_tim");
	}
}