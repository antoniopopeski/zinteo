<?php
class admin_kolo extends MY_Controller
{
	function index()
	{
		$sql = "SELECT k.id, k.ime, s.ime AS sezona, l.ime AS liga
				FROM kolo AS k INNER JOIN sezona AS s ON k.sezona_id=s.id 
				INNER JOIN sampionati AS l ON s.sampionat_id=l.id";
		$order = " ORDER BY s.id DESC";
		$data = array("content"=> "a_kolo", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		//$data["selSport"] = $this->session->userdata("fSport");
		//$data["selDrzava"] = $this->session->userdata("fDrzava");
		$data["selSampionat"] = $this->session->userdata("fSampionat");
		//$data["selTim"] = $this->session->userdata("fTim");
		$uslov = "";
		if($data["selSampionat"])
			$uslov .= " WHERE l.id =".$data['selSampionat'];
		$data['lista'] = $this->db->query($sql.$uslov.$order)->result();
		$sql = "SELECT s.id, CONCAT_WS(' ', s.ime,'[',d.ime,']') AS ime
				FROM sampionati AS s LEFT JOIN drzavi AS d ON d.id=s.drzava_id
				ORDER BY s.ime ASC";
		$data['sampionati'] = $this->db->query($sql)->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function edit()
	{
		$this->load->library('uploader');
		$this->load->model("kolo");
		$this->load->model("image_model");
		if(isset($_POST["kolo"]) && !empty($_POST["kolo"]))
		{
			$data = $_POST["kolo"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$uspesnost = $this->kolo->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
					$id = $this->kolo->lastID();
				}
			}
			else
			{
				$id = $_POST['id'];
				$uspesnost = $this->kolo->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			$this->session->set_userdata($sessionData);
		}
		redirect("admin_kolo");
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = "Error";
		$this->load->model("kolo");
		if(is_numeric($id))
		{
			$uspesnost = $this->kolo->delete($id);
			if($uspesnost)
			{
				$sessionData["poraka"] = "Data successfully deleted";
			}
		}
		$this->session->set_userdata($sessionData);
		redirect("admin_kolo");
	}
}