<?php
class admin_natprevari extends MY_Controller
{
	private $sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv,
			c.id AS koef, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, k.ime AS kolo,
			l.sport_id FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id";
	
	function index()
	{
		$data = array("content"=> "a_natprevari", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$data["sampionati"] = $this->db->order_by('ime', 'asc')->get("sampionati")->result();
		$data["drzavi"] = $this->db->order_by('ime', 'asc')->get("drzavi")->result();
		$data["startDate"] = $this->session->userdata("fStartDate");
		$data["endDate"] = $this->session->userdata("fEndDate");
		$data["selSampionat"] = $this->session->userdata("fSampionat");
		$data["selTim"] = $this->session->userdata("fTim");
		$data["selDays"] = $this->session->userdata("fDays");
		$data["selDrzava"] = $this->session->userdata("fDrzava");
		$uslov = "";
		if($data["selSampionat"] || $data["selTim"] || $data["startDate"] || $data["endDate"])
		{
			$uslov = " WHERE ";
			if($data["selSampionat"])
				$uslov .= " l.id=".$data["selSampionat"]." AND";
			if($data["selTim"])
				$uslov .= " (n.domasni=".$data["selTim"]." OR n.gosti=".$data["selTim"].") AND";
			if($data["startDate"])
				$uslov .= " n.pocetok >= '".$data["startDate"]."' AND";
			if($data["endDate"])
				$uslov .= " n.pocetok <='".$data["endDate"]."' AND";
			$uslov = substr($uslov, 0, strlen($uslov)-4);
		}
		$data['lista'] = array();//$this->db->query($this->sql.$uslov." ORDER BY n.id DESC LIMIT 500")->result();
		if($data["selSampionat"])
		{
			$sql = "SELECT DISTINCT(t.id), t.ime FROM timovi AS t INNER JOIN sezona_tim AS st 
					ON st.tim_id=t.id INNER JOIN sezona AS s ON s.id=st.sezona_id WHERE s.sampionat_id=".
					$data["selSampionat"]." ORDER BY t.ime ASC";
			$data['timovi'] = $this->db->query($sql)->result();
		}
		else 
			$data['timovi'] = $this->db->order_by('ime', 'asc')->get('timovi')->result();
		$this->load->view("template", $data);
	}
	
	function edit()
	{
		$this->load->model("natprevar");
		if(isset($_POST["natprevar"]) && !empty($_POST["natprevar"]))
		{
			$data = $_POST["natprevar"];
			$format = "Y-m-d H:i:s";
			$post = $_POST["natprevar"];
			$date = new DateTime($_POST['datum']." ".$_POST['pocetok'], new DateTimeZone("Europe/Skopje"));
			$data['pocetok'] = $date->format($format);
			$date2 = new DateTime($_POST['datum']." ".$_POST['kraj'], new DateTimeZone("Europe/Skopje"));
			if($date2<$date)
				$date2->modify("+1 day");
			$data['kraj'] = $date2->format($format);
			$date = new DateTime($post['vidliv'], new DateTimeZone("Europe/Skopje"));
			$data['vidliv'] = $date->format($format);
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$uspesnost = $this->natprevar->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
					$id = $this->natprevar->lastID();
				}
			}
			else
			{
				$id = $_POST['id'];
				$uspesnost = $this->natprevar->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			$this->session->set_userdata($sessionData);
		}
		redirect("admin_natprevari");
	}

	function nezatvoreni()
	{
		$uslov = " WHERE n.domasni4 IS NULL OR n.gosti4 IS NULL OR n.domasni2 IS NULL OR n.gosti2 IS NULL
				OR n.id NOT IN (SELECT natprevar_id FROM coeficienti)";
		$data = array("content"=> "a_natprevari", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data['lista'] = array();//$this->db->query($this->sql.$uslov." ORDER BY n.id DESC")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}

	function naked()
	{
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$uslov = " WHERE n.pocetok > '".$sega->format("Y-m-d H:i:s")."' 
				AND n.id NOT IN (SELECT natprevar_id FROM coeficienti)";
		$data = array("content"=> "a_natprevari", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data['lista'] = array();//$this->db->query($this->sql.$uslov." ORDER BY n.id DESC")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}

	function missed()
	{
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$uslov = " WHERE n.pocetok < '".$sega->format("Y-m-d H:i:s")."' 
				AND n.id NOT IN (SELECT natprevar_id FROM coeficienti)";
		$data = array("content"=> "a_natprevari", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data['lista'] = array();//$this->db->query($this->sql.$uslov." ORDER BY n.id DESC")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}

	function open()
	{
		if(isset($_POST["koeficient"]) && !empty($_POST["koeficient"]))
		{
			$this->load->model("koeficient");
			$data = $_POST["koeficient"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$uspesnost = $this->koeficient->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
				}
			}
			else
			{
				$id = $_POST['id'];
				$uspesnost = $this->koeficient->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			$this->session->set_userdata($sessionData);
		}
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$data = array("content"=> "a_natprevari", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data["selSport"] = $this->session->userdata("fSport");
		$data["selDrzava"] = $this->session->userdata("fDrzava");
		$data["selSampionat"] = $this->session->userdata("fSampionat");
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
		$data['lista'] = array();/*
		if(strpos($uslov, "WHERE"))
			$data['lista'] = $this->db->query($this->sql.$uslov." AND n.pocetok > '".$sega->format("Y-m-d H:i:s")."'
				AND n.id IN (SELECT natprevar_id FROM coeficienti) ORDER BY n.id DESC")->result();
		else 
			$data['lista'] = $this->db->query($this->sql." WHERE n.pocetok > '".$sega->format("Y-m-d H:i:s")."'
				AND n.id IN (SELECT natprevar_id FROM coeficienti) ORDER BY n.id DESC")->result();*/
		$data['sportovi'] = $this->db->order_by('ime', 'asc')->get("sportovi")->result();
		$data['drzavi'] = $this->db->order_by('ime', 'asc')->get("drzavi")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}

	function prikraj()
	{
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle30min = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle30min->modify("+30 minutes");
		$uslov = " WHERE n.kraj > '".$sega->format("Y-m-d H:i:s")."' 
				AND n.kraj < '".$posle30min->format("Y-m-d H:i:s")."'";
		$data = array("content"=> "a_natprevari", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data['lista'] = array();//$this->db->query($this->sql.$uslov." ORDER BY n.id DESC")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}

	function live()
	{
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$uslov = " WHERE n.pocetok < '".$sega->format("Y-m-d H:i:s")."' 
				AND n.kraj > '".$sega->format("Y-m-d H:i:s")."'";
		$data = array("content"=> "a_natprevari", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data['lista'] = array();//$this->db->query($this->sql.$uslov." ORDER BY n.id DESC")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}

	function zavrseni()
	{
		$this->load->model("natprevar");
		if(isset($_POST["natprevar"]) && !empty($_POST["natprevar"]))
		{
			$data = $_POST["natprevar"];
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "Error";
			if(!isset($_POST['id']))
			{
				$uspesnost = $this->natprevar->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully inserted";
				}
			}
			else
			{
				$id = $_POST['id'];
				$uspesnost = $this->natprevar->update($data, $id);
				if($uspesnost)
				{
					$sessionData["poraka"] = "Data successfully updated";
				}
			}
			$this->session->set_userdata($sessionData);
		}
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$uslov = " WHERE (n.domasni4 IS NULL AND n.gosti4 IS NULL AND 
				n.domasni2 IS NULL AND n.gosti2 IS NULL) AND n.kraj < '".$sega->format("Y-m-d H:i:s")."'";
		$data = array("content"=> "a_natprevari", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data['lista'] = array();//$this->db->query($this->sql.$uslov." ORDER BY n.id DESC")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}

	function zatvoreni()
	{
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$uslov = " WHERE n.domasni4 IS NOT NULL AND n.gosti4 IS NOT NULL AND 
				n.domasni2 IS NOT NULL AND n.gosti2 IS NOT NULL";
		$data = array("content"=> "a_natprevari", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data['lista'] = array();//$this->db->query($this->sql.$uslov." ORDER BY n.id DESC")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = "Error";
		$this->load->model("natprevar");
		if(is_numeric($id))
		{
			$uspesnost = $this->natprevar->delete($id);
			if($uspesnost)
			{
				$sessionData["poraka"] = "Data successfully deleted";
			}
		}
		$this->session->set_userdata($sessionData);

		$updateSql = "DELETE FROM oblozi WHERE natprevar_id NOT IN (SELECT id FROM natprevari)";
		$this->db->query($updateSql);
		
		redirect("admin_natprevari");
	}
}