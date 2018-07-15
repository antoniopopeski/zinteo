<?php
class admin_tipper extends MY_Controller
{
	private $sql = "SELECT t.id, t.username, (SELECT COUNT(DISTINCT(natprevar_id)) FROM oblozi WHERE tipuvac_id=t.id) AS oblozi,
			(SELECT 100 + SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog, if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o 
				WHERE tipuvac_id=t.id) AS dobivka, (SELECT COUNT(DISTINCT(natprevar_id)) FROM oblozi WHERE uspesen=1 AND tipuvac_id=t.id) AS uspesni,
			@red := @red + 1 AS rang, t.kreiran, t.logiran, (SELECT COUNT(DISTINCT(sledi_tipuvac)) FROM sledenje WHERE tipuvac_id=t.id)
			AS sledi, (SELECT COUNT(DISTINCT(tipuvac_id)) FROM sledenje WHERE sledi_tipuvac=t.id) AS sleden,
			(SELECT COUNT(id) FROM tiketi WHERE tipuvac_id=t.id) AS tiketi, t.tiperi_pokaneti,
			COALESCE((SELECT bids FROM tiketi WHERE NOW() BETWEEN od AND do AND tipuvac_id=t.id), 0) AS bonusBids,
			(SELECT if(aktiviran IS NULL OR aktiviran='0000-00-00 00:00:00', 0, 1)  FROM tiketi 
				WHERE NOW() BETWEEN od AND do AND tipuvac_id=t.id) AS aktivBids FROM tipuvaci AS t, (SELECT @red := 0) r
			ORDER BY dobivka DESC";
	
	function index()
	{
		$data = array("content"=> "a_tipperi", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$lista = $this->db->query($this->sql)->result();
		usort($lista, array($this,'sort'));
		$data['lista'] = $lista;
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function sort($a, $b)
	{
		//return ($a->rang < $b->rang ? 1 : -1); //opagjacki
		return ($a->rang > $b->rang ? 1 : -1); //rastecki
	}
	
	function tiket()
	{
		$this->load->model("tiket");
		if(isset($_POST["tiket"]) && !empty($_POST["tiket"]))
		{
			$data = $_POST["tiket"];
			$datum = date_create_from_format("d-m-Y", $_POST["tiket"]["od"], new DateTimeZone("Europe/Skopje"));
			$data["od"] = $datum->format("Y-m-d");
			$datum = date_create_from_format("d-m-Y", $_POST["tiket"]["do"], new DateTimeZone("Europe/Skopje"));
			$data["do"] = $datum->format("Y-m-d");
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$uspesnost = $this->tiket->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
				}
			}
			else
			{
				$id = $_POST['id'];
				$uspesnost = $this->tiket->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			$this->session->set_userdata($sessionData);
		}
		redirect("admin_tipper");
	}
	
	function edit()
	{
		$this->load->model("korisnik");
		if(isset($_POST["korisnik"]) && !empty($_POST["korisnik"]))
		{
			$data = $_POST["korisnik"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$uspesnost = $this->korisnik->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
					$id = $this->korisnik->lastID();
				}
			}
			else
			{
				$id = $_POST['id'];
				$uspesnost = $this->korisnik->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			$this->session->set_userdata($sessionData);
		}
		redirect("admin_tipper");
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = "Error";
		$this->load->model("korisnik");
		if(is_numeric($id))
		{
			$uspesnost = $this->korisnik->delete($id);
			if($uspesnost)
			{
				$sessionData["poraka"] = "Data successfully deleted";
			}
		}
		$this->session->set_userdata($sessionData);
		redirect("admin_tipper");
	}
}