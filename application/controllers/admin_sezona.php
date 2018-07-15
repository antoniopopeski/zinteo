<?php
class admin_sezona extends MY_Controller
{
	function index()
	{
		$data = array("content"=> "a_sezona", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		
		$data["selSport"] = $this->session->userdata("fSport");
		$data["selDrzava"] = $this->session->userdata("fDrzava");
		$data["selSampionat"] = $this->session->userdata("fSampionat");
		//$data["selTim"] = $this->session->userdata("fTim");
		$uslov = "";
		if($data["selDrzava"] || $data["selSport"] || $data["selSampionat"])
			$uslov .= " WHERE ";
		if($data["selDrzava"])
			$uslov .= "l.drzava_id =".$data['selDrzava']." AND ";
		if($data["selSport"])
			$uslov .= "l.sport_id=".$data['selSport']." AND ";
		if($data["selSampionat"])
			$uslov .= "l.id =".$data['selSampionat']." AND ";
		$uslov = substr($uslov, 0, strlen($uslov)-4);
		$sql = "SELECT l.id, CONCAT_WS(' ', l.ime,'[',d.ime,']') AS ime
				FROM sampionati AS l LEFT JOIN drzavi AS d ON d.id=l.drzava_id ".$uslov."
				ORDER BY l.ime ASC";
		$data['sampionati'] = $this->db->query($sql)->result();
		$sql = "SELECT s.id, s.ime, CONCAT_WS(' ', l.ime,'[',d.ime,']') AS liga, s.aktiven
				FROM sezona AS s INNER JOIN sampionati AS l ON s.sampionat_id=l.id
				LEFT JOIN drzavi AS d ON d.id=l.drzava_id";
		$order = " ORDER BY s.id DESC";
		$data['lista'] = $this->db->query($sql.$uslov.$order)->result();
		$data['sportovi'] = $this->db->order_by('ime', 'asc')->get("sportovi")->result();
		$data['drzavi'] = $this->db->order_by('ime', 'asc')->get("drzavi")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function edit()
	{
		$this->load->model("sezona");
		if(isset($_POST["sezona"]) && !empty($_POST["sezona"]))
		{
			$data = $_POST["sezona"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$this->db->query("UPDATE sezona SET aktiven=0 WHERE sampionat_id=".$data["sampionat_id"]);
				$uspesnost = $this->sezona->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
					$id = $this->sezona->lastID();
				}
			}
			else
			{
				$id = $_POST['id'];
				if($data["aktiven"])
					$this->db->query("UPDATE sezona SET aktiven=0 WHERE sampionat_id=".
							$data["sampionat_id"]." AND id<>".$id);
				$uspesnost = $this->sezona->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			$this->session->set_userdata($sessionData);
		}
		redirect("admin_sezona");
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = "Error";
		$this->load->model("sezona");
		if(is_numeric($id))
		{
			$uspesnost = $this->sezona->delete($id);
			if($uspesnost)
			{
				$sessionData["poraka"] = "Data successfully deleted";
			}
		}
		$this->session->set_userdata($sessionData);
		redirect("admin_sezona");
	}
}