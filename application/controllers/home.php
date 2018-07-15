<?php
class home extends MY_Public
{
	function index()
	{
		$data = array ("content" => "p_startup","user" => $this->user,"info" => $this->info);
		$sql = "SELECT COUNT(id) AS broj FROM oblozi WHERE tipuvac_id=" . $this->user->id;
		$data["oblozi"] = (int) $this->db->query($sql)->row()->broj;
		$this->load->view("public_template", $data);
	}
	function balance()
	{
		$updateSql = "UPDATE tipuvaci dest, (SELECT x.id, o.tipuvac_id, COUNT(o.id) as broj
			FROM sportovi as x INNER JOIN timovi as t ON x.id=t.sport_id
		INNER JOIN natprevari as n ON n.domasni=t.id OR n.gosti=t.id
		RIGHT JOIN oblozi as o ON o.natprevar_id=n.id
		WHERE o.uspesen=1 GROUP BY o.tipuvac_id, x.id ORDER BY broj DESC) src
		SET dest.sport_id = src.id WHERE dest.id=src.tipuvac_id";
		$this->db->query($updateSql);
		$updateSql = "UPDATE tipuvaci dest, (SELECT tipuvac_id, (100 +
		SUM(if(uspesen=1, round(ulog*koeficient, 1) - ulog,	0 - ulog))) AS dobivka
		FROM oblozi GROUP BY tipuvac_id) src
		SET dest.saldo = src.dobivka WHERE dest.id=src.tipuvac_id";
		$this->db->query($updateSql);
		$data = array ("content" => "p_balance","user" => $this->user,"info" => $this->info,
					'title' => "My balance");
		$sega = new DateTime("now", new DateTimeZone($this->user->timezone));
		$sql = "SELECT x.dobivka as saldo, x.rang, 
				(SELECT COALESCE(COUNT(id),0) FROM oblozi WHERE tipuvac_id=t.id 
					AND uspesen IN (0,1)) AS played,(SELECT COALESCE(COUNT(id),0) FROM oblozi 
					WHERE tipuvac_id=t.id AND uspesen IS NULL) AS waiting,
				(SELECT SUM(ulog) FROM oblozi WHERE  tipuvac_id=t.id AND uspesen IS NULL) AS rezervirani,
				(SELECT COALESCE(COUNT(id),0) FROM oblozi WHERE tipuvac_id=t.id AND uspesen=1) AS won,
				(SELECT COALESCE(COUNT(id),0) FROM sledenje WHERE tipuvac_id=t.id) AS follow,
				(SELECT COALESCE(COUNT(id),0) FROM sledenje WHERE sledi_tipuvac=t.id) AS followers,
				(SELECT COALESCE(COUNT(id),0) FROM sledenje WHERE sledi_tipuvac=t.id
						AND od_datum > DATE_SUB(NOW(), INTERVAL 1 WEEK)) AS followersWeek,
				t.tiperi_pokaneti AS invited,
				t.fb_id, t.fname, t.lname, t.sport_id AS sport, (SELECT (SELECT startBids FROM settings LIMIT 1)
				 + " . $this->user->tiperi_pokaneti . " +
				COALESCE(SUM(bids), 0) FROM tiketi WHERE aktiviran <> '0000-00-00 00:00:00'
				AND '" . $sega->format("Y-m-d") . "' BETWEEN od AND do
				AND tipuvac_id=" . $this->user->id . ") AS dailyBids
				FROM tipuvaci AS t INNER JOIN (SELECT id, @red := @red + 1 AS rang,
				(SELECT 100 + SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
					if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o 
				WHERE tipuvac_id=t.id) AS dobivka,
				(SELECT COUNT(id) FROM sledenje WHERE tipuvac_id=".$this->user->id."
					AND sledi_tipuvac=t.id) AS sleden
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, saldo DESC)
				AS x ON x.id=t.id WHERE t.id=" .$this->user->id;
		$data["acc"] = $this->db->query($sql)->row();/*
		$list = $this->db->query("select fb_id as id from tipuvaci
				union select pokanet as id from pokani")->result();
		if($list)
		{
			$lista = "";
			foreach($list as $p)
			{
				$lista = $lista . $p->id . ",";
			}
			$lista = trim($lista, ',');
			$data["vekjePokaneti"] = $lista;
		}*/
		// potrebno e da se otcitav podesuvanja
		$this->config->load('Facebook', TRUE);
		$fb_app = $this->config->item('appId');
		$data['fbinfo'] = $fb_app;
		$this->load->view("public_template", $data);
	}
	function dailybids()
	{
		$data = array ("content" => "p_dailybids","user" => $this->user,"info" => $this->info,
					'title' => "Daily bids");
		$format = "Y-m-d";
		$segaLokalno = new DateTime("now", new DateTimeZone($this->user->timezone));
		$sql = "SELECT * FROM tiketi WHERE aktiviran<>'0000-00-00 00:00:00'
						AND DATE('" . $segaLokalno->format($format) . "') BETWEEN od
						AND do AND tipuvac_id=" . $this->user->id;
		$rezz = $this->db->query($sql);
		if($rezz->num_rows() > 0)
			$data['tiket'] = $rezz->row();
		else 
			$data['tiket'] = (object)array("bids" => 0);
		$this->load->model('settings');
		$limit = $this->settings->getObjects();
		$data['startBids'] = (int) $limit->startBids;
		$this->load->view("public_template", $data);
	}
	function country()
	{
		$drzava_id = $this->input->post('country');
		$timezone = $this->input->post('timezone');
		if($drzava_id && $drzava_id != $this->user->drzava_id)
		{
			$this->user->drzava_id = $drzava_id;
			$this->korisnik->update($this->user, $this->user->id);
		}
		if($timezone && $timezone != $this->user->timezone)
		{
			$this->user->timezone = $timezone;
			$this->korisnik->update($this->user, $this->user->id);
		}
		$data = array ("content" => "p_country","user" => $this->user,"info" => $this->info,
				'title' => "Choose your country");
		$data['drzavi'] = $this->db->query("SELECT * FROM drzavi ORDER BY ime")->result();
		$this->load->view("public_template", $data);
	}
	function invite()
	{
		$data = array ("content" => "p_invite","user" => $this->user,"info" => $this->info,
					'title' => "Invite friends");
		$page = $this->pages->oneObject(5);
		$data['page'] = $page;/*
		$list = $this->db->query(
								"select fb_id as id from tipuvaci
				union select pokanet as id from pokani")->result();
		if($list)
		{
			$lista = "";
			foreach($list as $p)
			{
				$lista = $lista . $p->id . ",";
			}
			$lista = trim($lista, ',');
			$data["vekjePokaneti"] = $lista;
		}*/
		$this->load->model('settings');
		$limit = $this->settings->getObjects();
		$data['startBids'] = (int) $limit->startBids;
		// potrebno e da se otcitav podesuvanja
		$this->config->load('Facebook', TRUE);
		$fb_app = $this->config->item('appId');
		$data['fbinfo'] = $fb_app;
		$this->load->view("public_template", $data);
	}
}