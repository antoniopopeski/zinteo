<?php
class admin_multicoef extends MY_Controller
{
	private $sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti
			FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id 
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id";
	
	function index()
	{
		$this->load->model("koeficient");
		if(isset($_POST['koeficient']))
		{
			$sessionData = $this->session->all_userdata();
			$sessionData["poraka"] = "";
			$data['user_id'] = $this->uredil->id;
			
			$nat_id = $_POST['koeficient']['natprevar_id'];
			$listaP = $_POST['koeficient']['prv'];
			$listaX = $_POST['koeficient']['x'];
			$listaV = $_POST['koeficient']['vtor'];
			$listaG1 = $_POST['koeficient']['golovi0do1'];
			$listaG2 = $_POST['koeficient']['golovi2do3'];
			$listaG3 = $_POST['koeficient']['golovi4do6'];
			$listaG4 = $_POST['koeficient']['golovi7plus'];
			$listaPP = $_POST['koeficient']['prvprv'];
			$listaPX = $_POST['koeficient']['prvx'];
			$listaPV = $_POST['koeficient']['prvvtor'];
			$listaXP = $_POST['koeficient']['xprv'];
			$listaXX = $_POST['koeficient']['xx'];
			$listaXV = $_POST['koeficient']['xvtor'];
			$listaVP = $_POST['koeficient']['vtorprv'];
			$listaVX = $_POST['koeficient']['vtorx'];
			$listaVV = $_POST['koeficient']['vtorvtor'];
			$listaU = $_POST['koeficient']['un'];
			$listaO = $_POST['koeficient']['ov'];
			
			
			$max = count($listaP);
			
			for($i=0; $i<$max; $i++)
			{
				$data = array('prv' => $listaP[$i], 'x' => $listaX[$i],
					'vtor' => $listaV[$i], 'golovi0do1' => $listaG1[$i],
					'golovi2do3' => $listaG2[$i], 'golovi4do6' => $listaG3[$i],
					'golovi7plus' => $listaG4[$i], 'prvprv' => $listaPP[$i],
					'prvx' => $listaPX[$i], 'prvvtor' => $listaPV[$i],
					'xprv' => $listaXP[$i], 'xx' => $listaXX[$i], 'xvtor' => $listaXV[$i],
					'vtorprv' => $listaVP[$i], 'vtorx' => $listaVX[$i],
					'vtorvtor' => $listaVV[$i], 'un' => $listaU[$i], 'ov' => $listaO[$i],
					'user_id' => $this->uredil->id, 'natprevar_id' => $nat_id[$i]);
				
				if($data['prv']>1&&$data['vtor']>1/*&&$data['prvprv']>1&&
					$data['prvx']>1&&$data['prvvtor']>1&&$data['xprv']>1&&
					$data['xx']>1&&$data['xvtor']>1&&$data['vtorprv']>1&&
					$data['vtorx']>1&&$data['vtorvtor']>1*/)
				{
					$uspesnost = $this->koeficient->insert($data);
					if($uspesnost)
						$sessionData["poraka"] .= "Data [".$i."] successfully inserted<br>";
					else
						$sessionData["poraka"] .= "Error, data [".$i."] can't be inserted<br>";
				}
				else
					$sessionData["poraka"] .= "Error, data [".$i."] missing final result coeficients<br>";
			}
			$this->session->set_userdata($sessionData);
			redirect("admin_multicoef");
		}
		$data = array("content"=> "a_multicoef", "uredil" => $this->uredil,
			"settings" => $this->limits);//, "js" => "tablesorter"
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$uslov = " WHERE n.pocetok > '".$sega->format("Y-m-d H:i:s")."' AND c.id IS NULL
				ORDER BY n.id DESC LIMIT 10";
		$data['lista'] = $this->db->query($this->sql.$uslov)->result();
		$this->load->view("template", $data);
	}
}