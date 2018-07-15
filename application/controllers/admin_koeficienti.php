<?php
class admin_koeficienti extends MY_Controller
{
	private $sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, s.ime AS sampionat, n.pocetok, n.kraj, n.vnesen,
			n.vidliv, c.id AS koef
			FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona AS z ON z.id=k.sezona_id INNER JOIN sampionati AS s ON s.id=z.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id";
	
	function index()
	{
		$data = array("content"=> "a_koeficienti", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$uslov = " WHERE n.pocetok > '".$sega->format("Y-m-d H:i:s")."' AND c.id IS NULL ORDER BY n.id DESC";
		$data['sportovi'] = $this->db->order_by('ime', 'asc')->get("sportovi")->result();
		$data['drzavi'] = $this->db->order_by('ime', 'asc')->get("drzavi")->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$data["selSport"] = $this->session->userdata("fSport");
		$data["selDrzava"] = $this->session->userdata("fDrzava");
		$data["selSampionat"] = $this->session->userdata("fSampionat");
		$data['lista'] = $this->db->query($this->sql.$uslov)->result();
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
			$data['user_id'] = $this->uredil->id;
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
		redirect("admin_koeficienti");
	}
}