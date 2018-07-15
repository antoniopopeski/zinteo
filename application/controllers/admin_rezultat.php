<?php
class admin_rezultat extends MY_Controller
{
	private $sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv, c.id AS koef,
			(SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi
			FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id";
	
	function index()
	{
		$this->load->model("natprevar");
		$this->load->model("oblog");
		if(isset($_POST["natprevar"]) && isset($_POST["domasni2"]) && isset($_POST["domasni4"])
				&& isset($_POST["gosti2"]) && isset($_POST["gosti4"]))
		{
			$sessionData = $this->session->all_userdata();
			$id = $_POST["natprevar"];
			$domasni2 = $_POST['domasni2'];
			$gosti2 = $_POST['gosti2'];
			$domasni4 = $_POST['domasni4'];
			$gosti4 = $_POST['gosti4'];
			if(count($gosti2) == count($gosti4) && count($domasni2) == count($domasni4) 
					&& count($id)==count($gosti2))
			{
				$max = count($gosti2);
				for($i=0; $i<$max;$i++)
				{
					if(is_numeric($domasni2[$i]) && $domasni2[$i] > -1 && 
						is_numeric($gosti2[$i]) && $gosti2[$i] > -1 &&
						is_numeric($domasni4[$i]) && $domasni4[$i] > -1 &&
						is_numeric($gosti4[$i]) && $gosti4[$i] > -1)
					{
						$data['gosti2'] = (int)$gosti2[$i];
						$data['domasni2'] = (int)$domasni2[$i];
						$data['gosti4'] = (int)$gosti4[$i];
						$data['domasni4'] = (int)$domasni4[$i];
						//kraen rezultat
						if((int)$domasni4[$i] > (int)$gosti4[$i])
							$kraenTip = "1";
						elseif ((int)$domasni4[$i] == (int)$gosti4[$i])
							$kraenTip = "0";
						else 
							$kraenTip = "2";
						//half / full
						if((int)$domasni2[$i] > (int)$gosti2[$i] && (int)$domasni4[$i] > (int)$gosti4[$i])
							$hf = "hf1";
						elseif ((int)$domasni2[$i] > (int)$gosti2[$i] && (int)$domasni4[$i] == (int)$gosti4[$i])
							$hf = "hf2";
						elseif ((int)$domasni2[$i] > (int)$gosti2[$i] && (int)$domasni4[$i] < (int)$gosti4[$i])
							$hf = "hf3";
						elseif ((int)$domasni2[$i] == (int)$gosti2[$i] && (int)$domasni4[$i] > (int)$gosti4[$i])
							$hf = "hf4";
						elseif ((int)$domasni2[$i] == (int)$gosti2[$i] && (int)$domasni4[$i] == (int)$gosti4[$i])
							$hf = "hf5";
						elseif ((int)$domasni2[$i] == (int)$gosti2[$i] && (int)$domasni4[$i] < (int)$gosti4[$i])
							$hf = "hf6";
						elseif ((int)$domasni2[$i] < (int)$gosti2[$i] && (int)$domasni4[$i] > (int)$gosti4[$i])
							$hf = "hf7";
						elseif ((int)$domasni2[$i] < (int)$gosti2[$i] && (int)$domasni4[$i] == (int)$gosti4[$i])
							$hf = "hf8";
						elseif ((int)$domasni2[$i] < (int)$gosti2[$i] && (int)$domasni4[$i] < (int)$gosti4[$i])
							$hf = "hf9";
						//golovi
						$pogodoci = (int)$domasni4[$i] + (int)$gosti4[$i];
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
						$uspesnost = $this->natprevar->update($data, $id[$i]);
						if(!$uspesnost)
							$sessionData["poraka"][$i] = "Error setting the score<br>";
						else
						{
							$sessionData["poraka"][$i] = "The score successfully was set<br>";
							$igrani = "SELECT * FROM oblozi WHERE uspesen IS NULL AND natprevar_id=".$id[$i];
							$igraniOblozi = $this->db->query($igrani)->result();
							foreach($igraniOblozi AS $oblog)
							{
								//$dobivka = round($oblog->ulog * $oblog->koeficient, 1);
								//dokolko e tip ist ss bilo koj drugo tacan rezultat oblog e uspesan
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
						$sessionData["poraka"][$i] = "Incomplete data, all fields are required";
					unset($data);
				}
			}
			$updateSql = "UPDATE tipuvaci dest, (SELECT o.tipuvac_id, 100 + 
					ROUND(SUM(o.ulog*o.koeficient), 1) - (SELECT ROUND(SUM(ulog), 1) 
					FROM oblozi WHERE tipuvac_id=o.tipuvac_id GROUP BY o.tipuvac_id) as dobivka 
					FROM oblozi as o WHERE o.uspesen=1 GROUP BY o.tipuvac_id) src 
					SET dest.saldo = src.dobivka WHERE dest.id=src.tipuvac_id";
			$this->db->query($updateSql);
			$this->session->set_userdata($sessionData);
			redirect("admin_rezultat");
		}
		$order = " ORDER BY kraj ASC LIMIT 40";
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$uslov = " WHERE (domasni4 IS NULL OR gosti4 IS NULL OR domasni4 IS NULL OR gosti4 IS NULL)
				AND kraj < '".$sega->format("Y-m-d H:i:s")."'";
		$data = array("content"=> "a_rezultat", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$data['lista'] = $this->db->query($this->sql.$uslov.$order)->result();
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify("+30 minute");
		$uslov = " WHERE (domasni4 IS NULL OR gosti4 IS NULL OR domasni4 IS NULL OR gosti4 IS NULL)
				AND kraj > '".$sega->format("Y-m-d H:i:s")."'
				AND kraj < '".$posle->format("Y-m-d H:i:s")."'";
		$data['prikraj'] = $this->db->query($this->sql.$uslov)->result();
		$uslov = " WHERE (domasni4 IS NULL OR gosti4 IS NULL OR domasni4 IS NULL OR gosti4 IS NULL) 
				AND kraj < '".$sega->format("Y-m-d")." 23:59:59' AND kraj > '".
				$posle->format("Y-m-d H:i:s")."'";
		$data['denesni'] = $this->db->query($this->sql.$uslov)->result();
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify("+3 day");
		$uslov = " WHERE (domasni4 IS NULL OR gosti4 IS NULL OR domasni4 IS NULL OR gosti4 IS NULL)
				AND kraj > '".$sega->format("Y-m-d")." 23:59:59' AND kraj < '".$posle->format("Y-m-d H:i:s")."'";
		$data['naredni'] = $this->db->query($this->sql.$uslov)->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
}
