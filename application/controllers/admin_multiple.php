<?php
class admin_multiple extends MY_Controller
{	
	function index()
	{
		$this->load->model("natprevar");
		$sessionData = $this->session->all_userdata();
		$sessionData["poraka"] = "";
		if(isset($_POST["datum"]) && isset($_POST["pocetok"]) && isset($_POST["kraj"])
				&& isset($_POST["kolo_id"]) && isset($_POST["vidliv"])
				&& isset($_POST["domasni"]) && isset($_POST["gosti"]))
		{
			$domasni = $_POST['domasni'];
			$gosti = $_POST['gosti'];
			$data['user_id'] = $this->uredil->id;
			if(count($domasni) > count($gosti))
				$max = count($gosti);
			else $max = count($domasni);
			for($i=0; $i<$max; $i++)
			{
				$format = "Y-m-d H:i:s";
				$date = new DateTime($_POST['datum']." ".$_POST['pocetok'], new DateTimeZone("Europe/Skopje"));
				$data['pocetok'] = $date->format($format);
				$date2 = new DateTime($_POST['datum']." ".$_POST['kraj'], new DateTimeZone("Europe/Skopje"));
				if($date2<$date)
					$date2->modify("+1 day");
				$data['kraj'] = $date2->format($format);
				$data['kolo_id'] = $_POST["kolo_id"];
				$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
				$data['vnesen'] = $denes->format($format); 
				$date = new DateTime($_POST['vidliv'], new DateTimeZone("Europe/Skopje"));
				$data['vidliv'] = $date->format($format); 
				$data['domasni'] = (int)$domasni[$i];
				$data['gosti'] = (int)$gosti[$i];
				$data['user_id'] = $this->uredil->id;
				if($data['domasni'] == $data['gosti'] || $data['domasni']==0 || $data['gosti']==0)
					continue;
				$uspesnost = $this->natprevar->insert($data);
				if($uspesnost)
				{
					$sessionData["poraka"] .= "Data [".$i."] successfully inserted<br>";
				} else {
					$sessionData["poraka"] .= "Error [".$i."]<br>";
				}
			}
			$this->session->set_userdata($sessionData);
			redirect("admin_multiple");
		}
		$data = array("content"=> "a_multi", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");/*
		$sql = "SELECT k.id, CONCAT_WS(' - ', k.ime, s.ime, l.ime, d.ime) AS ime 
				FROM kolo AS k INNER JOIN sezona AS s ON s.id=k.sezona_id 
				INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				LEFT JOIN drzavi AS d ON l.drzava_id=d.id
				WHERE s.aktiven=1";
		$data['lista'] = $this->db->query($sql)->result();*/
		$sql = "SELECT s.id, CONCAT_WS(' ', s.ime,'[',d.ime,']') AS ime
				FROM sampionati AS s LEFT JOIN drzavi AS d ON d.id=s.drzava_id
				ORDER BY s.ime ASC";
		$data['lista'] = $this->db->query($sql)->result();
		$data['timovi'] = $this->db->order_by('ime', 'asc')->get("timovi")->result();
		$this->load->view("template", $data);
	}
}