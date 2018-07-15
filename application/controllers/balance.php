<?php
class balance extends MY_Public
{
	function index()
	{
		$data = array ("content" => "p_balance","user" => $this->user,"info" => $this->info,
					'title' => "My balance");
		$updateSql = "UPDATE tipuvaci dest, (SELECT x.id, o.tipuvac_id, COUNT(o.id) as broj
				FROM sportovi as x INNER JOIN timovi as t ON x.id=t.sport_id
			INNER JOIN natprevari as n ON n.domasni=t.id OR n.gosti=t.id
			RIGHT JOIN oblozi as o ON o.natprevar_id=n.id
			WHERE o.uspesen=1 GROUP BY o.tipuvac_id, x.id ORDER BY broj DESC) src
			SET dest.sport_id = src.id WHERE dest.id=src.tipuvac_id";
		$this->db->query($updateSql);
		$sega = new DateTime("now", new DateTimeZone($this->user->timezone));
		$sql = "SELECT t.saldo, x.rang, (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=t.id) AS played,
				(SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=t.id AND uspesen=1) AS won,
				(SELECT COUNT(id) FROM sledenje WHERE tipuvac_id=t.id) AS follow,
				(SELECT COUNT(id) FROM sledenje WHERE sledi_tipuvac=t.id) AS followers,
				(SELECT COUNT(id) FROM sledenje WHERE sledi_tipuvac=t.id
						AND od_datum > DATE_SUB(NOW(), INTERVAL 1 WEEK)) AS followersWeek,
				t.tiperi_pokaneti AS invited,
				t.fb_id, t.fname, t.lname, t.sport_id AS sport, (SELECT 1 + " .
			 $this->user->tiperi_pokaneti . " + COALESCE(SUM(bids), 0) FROM tiketi WHERE aktiviran <> '0000-00-00 00:00:00'
				AND '" . $sega->format("Y-m-d") . "' BETWEEN od AND do
				AND tipuvac_id=" . $this->user->id . ") AS dailyBids
				FROM tipuvaci AS t INNER JOIN (SELECT vt.id, @red := @red + 1 AS rang,
				vt.saldo AS dobivka FROM tipuvaci AS vt, (SELECT @red:=0) AS r ORDER BY dobivka DESC)
				AS x ON x.id=t.id WHERE t.id=" . $this->user->id;
		$data["acc"] = $this->db->query($sql)->row();
		$data["vekjePokaneti"] = $this->db->query(
												"select fb_id as id from tipuvaci
				union select pokanet as id from pokani")->result();
		$fb_config = $this->config->item('Facebook');
		$data["appId"] = $fb_config['appId'];
		$this->load->view("public_template", $data);
	}
}