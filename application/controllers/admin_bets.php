<?php
class admin_bets extends MY_Controller
{
	function index()
	{
		$data = array("content"=> "a_bet", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$sql = "SELECT o.id, o.datum, rt.username, rt.rang, o.tip, o.ulog, o.koeficient, o.uspesen, d.ime AS domasni,
					g.ime AS gosti, n.domasni4, n.gosti4, n.domasni2, n.gosti2, n.pocetok, n.kraj, l.ime AS sampionat,
					CASE WHEN n.gosti4 IS NOT NULL AND n.gosti2 IS NOT NULL AND n.domasni4 IS NOT NULL AND n.domasni2 IS NOT NULL
					THEN 'Closed' WHEN n.kraj < '".$sega->format("Y-m-d H:i:s")."' THEN 'Finished' WHEN n.pocetok < '".$sega->format("Y-m-d H:i:s")."' 
					AND n.kraj > '".$sega->format("Y-m-d H:i:s")."' THEN 'Live' ELSE 'Open' END  AS status,
					n.id AS natprevar_id, if (o.uspesen=1, round(o.ulog*o.koeficient, 1), 0) AS dobivka
					FROM oblozi AS o INNER JOIN natprevari AS n ON n.id=o.natprevar_id
					INNER JOIN timovi AS d ON d.id=n.domasni INNER JOIN timovi AS g ON g.id=n.gosti
					INNER JOIN kolo AS k ON n.kolo_id=k.id INNER JOIN sezona AS s ON s.id=k.sezona_id 
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id INNER JOIN (SELECT t.id, t.username,
					t.saldo, @red := @red + 1 AS rang FROM tipuvaci AS t, (SELECT @red := 0) AS r ORDER BY t.saldo DESC) rt ON rt.id=o.tipuvac_id
					ORDER BY o.id ASC";
		$data['lista'] = $this->db->query($sql)->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
}
