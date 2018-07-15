<?php
class admin_koregiraj extends MY_Controller
{
	private $sqlKoeficienti = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, s.ime AS sampionat, n.pocetok, n.kraj, n.vnesen,
			n.vidliv, c.id AS koef
			FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona AS z ON z.id=k.sezona_id INNER JOIN sampionati AS s ON s.id=z.sampionat_id
			INNER JOIN coeficienti AS c ON c.natprevar_id=n.id";
	
	private $sqlRezultat = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv, c.id AS koef,
			(SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi
			FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			INNER JOIN coeficienti AS c ON c.natprevar_id=n.id";
	
	function index()
	{
		$data = array("content"=> "a_koeficienti2", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		//$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		//$uslov = " WHERE n.pocetok > '".$sega->format("Y-m-d H:i")."' ORDER BY n.id DESC";
		$uslov = " ORDER BY n.id DESC";
		$data['lista'] = $this->db->query($this->sqlKoeficienti.$uslov)->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function rezultat()
	{
		$data = array("content"=> "a_rezultat2", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		//$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		//$uslov = " WHERE domasni2 IS NOT NULL AND domasni4 IS NOT NULL AND gosti2 IS NOT NULL
		//		AND gosti4 IS NOT NULL ORDER BY n.id DESC";
		$uslov = " ORDER BY n.id DESC";
		$data['lista'] = $this->db->query($this->sqlRezultat.$uslov)->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
	
	function editKoeficient()
	{
		$this->load->model("koeficient");
		if(isset($_POST["koeficient"]) && !empty($_POST["koeficient"]))
		{
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
		redirect("admin_koregiraj");
	}
	
	function editRezultat()
	{
		$this->load->model("natprevar");
		$this->load->model("oblog");
		if(isset($_POST["natprevar"]) && !empty($_POST["natprevar"]))
		{
			$post = $_POST["natprevar"];
			$sessionData = $this->session->all_userdata();
			$data['gosti2'] = (int)$post["gosti2"];
			$data['domasni2'] = (int)$post["domasni2"];
			$data['gosti4'] = (int)$post["gosti4"];
			$data['domasni4'] = (int)$post["domasni4"];

			//kraen rezultat
			if((int)$post["domasni4"] > (int)$post["gosti4"])
				$kraenTip = "1";
			elseif ((int)$post["domasni4"] == (int)$post["gosti4"])
				$kraenTip = "0";
			else
				$kraenTip = "2";
			//half / full
			if((int)$post["domasni2"] > (int)$post["gosti2"] && (int)$post["domasni4"] > (int)$post["gosti4"])
				$hf = "hf1";
			elseif ((int)$post["domasni2"] > (int)$post["gosti2"] && (int)$post["domasni4"] == (int)$post["gosti4"])
				$hf = "hf2";
			elseif ((int)$post["domasni2"] > (int)$post["gosti2"] && (int)$post["domasni4"] < (int)$post["gosti4"])
				$hf = "hf3";
			elseif ((int)$post["domasni2"] == (int)$post["gosti2"] && (int)$post["domasni4"] > (int)$post["gosti4"])
				$hf = "hf4";
			elseif ((int)$post["domasni2"] == (int)$post["gosti2"] && (int)$post["domasni4"] == (int)$post["gosti4"])
				$hf = "hf5";
			elseif ((int)$post["domasni2"] == (int)$post["gosti2"] && (int)$post["domasni4"] < (int)$post["gosti4"])
				$hf = "hf6";
			elseif ((int)$post["domasni2"] < (int)$post["gosti2"] && (int)$post["domasni4"] > (int)$post["gosti4"])
				$hf = "hf7";
			elseif ((int)$post["domasni2"] < (int)$post["gosti2"] && (int)$post["domasni4"] == (int)$post["gosti4"])
				$hf = "hf8";
			elseif ((int)$post["domasni2"] < (int)$post["gosti2"] && (int)$post["domasni4"] < (int)$post["gosti4"])
				$hf = "hf9";
			//golovi
			$pogodoci = (int)$post["domasni4"] + (int)$post["gosti4"];
			if($pogodoci < 2)//0-1
				$goals = "g1";
			elseif ($pogodoci < 4)// 2-3
				$goals = "g2";
			elseif ($pogodoci < 7)//4-6
				$goals = "g3";
			else
				$goals = "g4";
			//over / under
			if($pogodoci < 3)//under
				$unov = "u";
			else
				$unov = "o";
			
			$uspesnost = $this->natprevar->update($data, $_POST["id"]);
			if(!$uspesnost)
				$sessionData["poraka"] = "Error setting the score<br>";
			else
			{
				$sessionData["poraka"] = "The score successfully was set<br>";
				$igrani = "SELECT * FROM oblozi WHERE natprevar_id=".$_POST["id"];
				$igraniOblozi = $this->db->query($igrani)->result();
				foreach($igraniOblozi AS $oblog)
				{
					if($oblog->tip == $kraenTip || $oblog->tip == $hf || 
							$oblog->tip == $goals || $oblog->tip == $unov)
					{
						$oblog->uspesen = 1;
						$oblog->izvesten = 0;
						$oblog->notifikacija = 0;
					}
					else
					{
						$oblog->uspesen = 0;
						$oblog->izvesten = 0;
						$oblog->notifikacija = 1;
					}
					$this->oblog->update($oblog, $oblog->id);
				}
			}
		}
		else
			$sessionData["poraka"] = "Incomplete data, all fields are required";
		$updateSql = "UPDATE tipuvaci dest, (SELECT o.tipuvac_id, 100 + 
				ROUND(SUM(o.ulog*o.koeficient), 1) - (SELECT ROUND(SUM(ulog), 1) 
				FROM oblozi WHERE tipuvac_id=o.tipuvac_id GROUP BY o.tipuvac_id) as dobivka 
				FROM oblozi as o WHERE o.uspesen=1 GROUP BY o.tipuvac_id) src 
				SET dest.saldo = src.dobivka WHERE dest.id=src.tipuvac_id";
		$this->db->query($updateSql);
		$this->session->set_userdata($sessionData);
		redirect("admin_koregiraj/rezultat");
	}
}