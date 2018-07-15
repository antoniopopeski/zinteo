<?php
class leaderboard extends MY_Public
{
	private $timezone = "America/Whitehorse";
	function index()
	{/*
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
		$this->db->query($updateSql);*/
		$data = array ("content" => "p_leaderboard","user" => $this->user,"info" => $this->info,
					'title' => "Leaderboard");/*
		$sql = "SELECT id, @red := @red + 1 AS rang, fname, lname,
				(SELECT COUNT(o.id) FROM oblozi o
				INNER JOIN natprevari n ON n.id=o.natprevar_id
				INNER JOIN kolo AS k ON k.id=n.kolo_id
				INNER JOIN sezona AS s ON s.id=k.sezona_id
				INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				WHERE tipuvac_id=t.id AND o.uspesen IS NOT NULL) AS oblozi,
				(SELECT COUNT(o.id) FROM oblozi o 
				INNER JOIN natprevari n ON n.id=o.natprevar_id
				INNER JOIN kolo AS k ON k.id=n.kolo_id
				INNER JOIN sezona AS s ON s.id=k.sezona_id
				INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				WHERE tipuvac_id=t.id AND o.uspesen=1) AS pogodeni,
				(SELECT 100 + SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
					if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o 
				WHERE tipuvac_id=t.id) AS dobivka,
				(SELECT COUNT(id) FROM sledenje WHERE tipuvac_id=".$this->user->id."
					AND sledi_tipuvac=t.id) AS sleden
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, saldo DESC";*/
		//dodadeni za da bide prikazano za this week
		/*$this->load->helper("periodi");
		$uslov = "";
		$sega = new DateTime('now', new DateTimeZone($this->timezone));
		$datumi = getWeek($sega->format("W"), $sega->format("Y"), "Europe/Skopje", $this->timezone);
		$p = $datumi[0];
		$k = $datumi[1];
		$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
		$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
		$sql = "SELECT id, @red := @red + 1 AS rang, fname, lname,
			(SELECT COUNT(o.id) FROM oblozi o
			INNER JOIN natprevari n ON n.id=o.natprevar_id
			INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona AS s ON s.id=k.sezona_id
			INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			WHERE tipuvac_id=t.id$uslov AND o.uspesen IS NOT NULL) AS oblozi,
			(SELECT COUNT(o.id) FROM oblozi o
			INNER JOIN natprevari n ON n.id=o.natprevar_id
			INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona AS s ON s.id=k.sezona_id
			INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			WHERE tipuvac_id=t.id AND o.uspesen=1$uslov) AS pogodeni,
			(SELECT SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1), 0))/SUM(o.ulog) FROM oblozi o
			INNER JOIN natprevari n ON n.id=o.natprevar_id
			INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona AS s ON s.id=k.sezona_id
			INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			WHERE tipuvac_id=t.id$uslov) AS dobivka,
			(SELECT COUNT(id) FROM sledenje WHERE tipuvac_id=".$this->user->id."
			AND sledi_tipuvac=t.id) AS sleden
			FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC";
		$data["lista"] = $this->db->query($sql)->result();*/
		$data["lista"] = array();
		$data["activeSports"] = $this->activeSports;
		$this->load->view("public_template", $data);
	}
	function balance($id = 0)
	{
		if(!$id)
			redirect('leaderboard');
		$user = $this->korisnik->oneObject($id);
		$data = array ("content" => "p_balance2","user" => $user,"info" => $this->info,
					'title' => "Balance");
		$sega = new DateTime("now", new DateTimeZone($this->timezone));
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
				 + " . $user->tiperi_pokaneti . " +
				COALESCE(SUM(bids), 0) FROM tiketi WHERE aktiviran <> '0000-00-00 00:00:00'
				AND '" . $sega->format("Y-m-d") . "' BETWEEN od AND do
				AND tipuvac_id=" . $user->id . ") AS dailyBids
				FROM tipuvaci AS t INNER JOIN (SELECT id, @red := @red + 1 AS rang,
				(SELECT 100 + SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
					if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o 
				WHERE tipuvac_id=t.id) AS dobivka,
				(SELECT COUNT(id) FROM sledenje WHERE tipuvac_id=".$user->id."
					AND sledi_tipuvac=t.id) AS sleden
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, saldo DESC)
				AS x ON x.id=t.id WHERE t.id=" . $user->id;
		$data["acc"] = $this->db->query($sql)->row();
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
		}
		$sql = "SELECT COUNT(id) AS sleden FROM sledenje WHERE tipuvac_id=".$this->user->id."
					AND sledi_tipuvac=".$user->id;
		$rezz = $this->db->query($sql);
		$red = $rezz->row(); 
		$data["eSleden"] = (int)$red->sleden;
		$this->load->view("public_template", $data);
	}
	function bets($id = 0)
	{
		if(!$id)
			redirect('leaderboard');
		$user = $this->korisnik->oneObject($id);
		$data = array ("content" => "p_mybets","user" => $user, 'title' => $user->fname."'s bets");
		$sega = new DateTime("now", new DateTimeZone('Europe/Skopje'));
		$posle = new DateTime("now", new DateTimeZone('Europe/Skopje'));
		$posle->modify($this->limits->recent . " day");
		$sql = "SELECT o.id, o.tip, o.ulog, o.koeficient, o.uspesen, d.ime AS domasni,
				d.kratenka AS domasniKratko, g.ime AS gosti, g.kratenka AS gostiKratko, o.saldo,
				n.domasni4, n.gosti4, n.domasni2, n.gosti2, n.pocetok, n.kraj,
				o.izvesten, CASE WHEN n.gosti4 IS NOT NULL AND n.gosti2 IS NOT NULL
				AND n.domasni4 IS NOT NULL AND n.domasni2 IS NOT NULL THEN 'Closed' WHEN n.kraj < '" .
						$sega->format("Y-m-d H:i:s") . "' THEN 'Finished' WHEN n.pocetok < '" .
						$sega->format("Y-m-d H:i:s") . "' AND n.kraj > '" . $sega->format("Y-m-d H:i:s") . "'
			 	THEN 'Live' ELSE 'Open' END  AS status,
				n.id AS natprevar_id, if (o.uspesen=1, round(o.ulog*o.koeficient, 1), 0) AS dobivka
				FROM oblozi AS o
				INNER JOIN natprevari AS n ON n.id=o.natprevar_id
				INNER JOIN timovi AS d ON d.id=n.domasni
				INNER JOIN timovi AS g ON g.id=n.gosti
				WHERE o.tipuvac_id=" . $user->id . " ORDER BY n.kraj DESC";
		$data["lista"] = $this->db->query($sql)->result();
		$tiper_id = $user->id;
			
		$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj
					FROM natprevari AS n INNER JOIN timovi AS td ON td.id=n.domasni
					INNER JOIN timovi AS tg ON tg.id=n.gosti
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					WHERE n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
					n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
					n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "' AND
					n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .$tiper_id. ")";
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["mybets"] = (int)$red->broj;
		
		$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj
					FROM natprevari AS n INNER JOIN timovi AS td ON td.id=n.domasni
					INNER JOIN timovi AS tg ON tg.id=n.gosti
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					INNER JOIN oblozi AS o ON o.natprevar_id=n.id
					INNER JOIN (SELECT @red := @red + 1 AS rang, t.fname, t.id, t.saldo FROM tipuvaci t,
					(SELECT @red := 0) r ORDER BY t.saldo DESC LIMIT " . $this->limits->top . ") AS t
					WHERE n.pocetok > '".$sega->format("Y-m-d H:i:s")."' AND
					n.pocetok < '".$posle->format("Y-m-d H:i:s")."'
					AND n.vidliv < '".$sega->format("Y-m-d H:i:s")."' AND t.id<>".$tiper_id."
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=".$tiper_id.")
					ORDER BY n.pocetok ASC";
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["recomended"] = (int)$red->broj;
		
		$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj FROM natprevari AS n
					INNER JOIN timovi AS td ON td.id=n.domasni
					INNER JOIN timovi AS tg ON tg.id=n.gosti
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					INNER JOIN kolo AS k ON n.kolo_id=k.id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					INNER JOIN sportovi AS x ON x.id=l.sport_id
					WHERE (n.domasni IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=".$tiper_id.") OR
					n.gosti IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=".$tiper_id."))
					AND n.pocetok < '".$posle->format("Y-m-d H:i:s")."'
					AND n.pocetok > '".$sega->format("Y-m-d H:i:s")."'
					AND n.vidliv < '".$sega->format("Y-m-d H:i:s")."'
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=".$tiper_id.")
					ORDER BY n.pocetok ASC";
		// x.id IN (SELECT sport_id FROM fav_sport WHERE tipuvac_id=".$tiper_id.") OR
			
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["favorite"] = (int)$red->broj;
			
		$sql = "SELECT 100 + SUM(if(uspesen=1, round(ulog*koeficient, 1) - ulog,
				if(uspesen=0,0 - ulog, 0))) AS broj FROM oblozi	WHERE tipuvac_id=".$tiper_id;
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["serenje"] = $red->broj;
		
		$data["info"] = (object)$rezultat;
		$this->load->view("public_template", $data);
	}
}