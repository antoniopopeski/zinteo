<?php
class matches extends MY_Public
{
	private $serverZone = 'Europe/Skopje';
	private $listanje_natprevari = "SELECT DISTINCT(n.id), n.domasni AS domasniID, td.ime AS domasni,
			n.gosti AS gostiID, tg.ime AS gosti, n.domasni1, n.domasni2, n.domasni3, n.domasni4,
			n.gosti1, n.gosti2, n.gosti3, n.gosti4, n.pocetok, n.kraj, k.ime AS kolo, s.ime AS sezona,
			l.ime AS sampionat, c.prv AS home, c.x AS draw, c.vtor AS away, x.ime AS sport, d.ime AS drzava,
			(CASE WHEN (c.prvprv > 1 AND c.prvx > 1 AND c.prvvtor > 1 AND c.xprv > 1 AND c.xx > 1
			AND c.xvtor > 1 AND c.vtorprv > 1 AND c.vtorx > 1 AND c.vtorvtor > 1) OR
			(c.golovi0do1 > 1 AND c.golovi2do3 > 1 AND c.golovi4do6 > 1 AND c.golovi7plus > 1)
			THEN 1 ELSE 0 END) AS more";
	private $broenje_natprevari = "SELECT COUNT(DISTINCT(n.id)) AS broj";
	private $join_natprevari = " FROM natprevari AS n
			INNER JOIN timovi AS td ON td.id=n.domasni
			INNER JOIN timovi AS tg ON tg.id=n.gosti
			INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona AS s ON s.id=k.sezona_id
			INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			INNER JOIN sportovi AS x ON l.sport_id=x.id
			LEFT JOIN drzavi AS d ON l.drzava_id=d.id
			INNER JOIN coeficienti AS c ON c.natprevar_id=n.id";
	function index()
	{
		$data = array ("content" => "p_matches","user" => $this->user,'title' => "Matches");
		$rezultat = array ();
		
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$sql = "SELECT COUNT(DISTINCT(id)) AS broj FROM oblozi
					WHERE tipuvac_id=" . $this->user->id . " AND uspesen IS NULL";
		
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["nezatvoreni"] = (int) $red->broj;
		
		$sql = "SELECT COUNT(DISTINCT(id)) AS broj FROM oblozi
					WHERE tipuvac_id=" . $this->user->id;
		
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["mybets"] = (int) $red->broj;
		
		$sql = $this->broenje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . " AND natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi 
				WHERE tipuvac_id=" . $this->user->id . " AND natprevar_id=n.id) AS igrano,
				(SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS brojOblozi, 
				tt.fname, tt.lname, tt.username, o.tip, tt.rang, tt.dobivka AS saldo" .
			 $this->join_natprevari .
			 "
				INNER JOIN oblozi AS o ON o.natprevar_id=n.id
			 	INNER JOIN (SELECT id, @red := @red + 1 AS rang, fname, lname, username,
				(SELECT 100 + SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
					if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o 
					WHERE tipuvac_id=t.id) AS dobivka
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, saldo DESC LIMIT " .
			 $this->limits->top . ") AS tt ON tt.id=o.tipuvac_id
				WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" .
			 $sega->format("Y-m-d H:i:s") . "' AND tt.id<>" . $this->user->id . "
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
				ORDER BY n.pocetok ASC";
		
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["recomended"] = (int) $red->broj;
		
		$sql = $this->broenje_natprevari . $this->join_natprevari . "
				WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
				AND (td.top>0 OR tg.top>0) ORDER BY n.pocetok ASC";
		
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["topteam"] = (int) $red->broj;
		
		$sql = $this->broenje_natprevari . $this->join_natprevari .
			 "
				WHERE (n.domasni IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" . $this->user->id . ")
				OR n.gosti IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" .
			 $this->user->id . "))
				AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
				ORDER BY n.pocetok ASC";
		// (x.id IN (SELECT sport_id FROM fav_sport WHERE tipuvac_id=".$this->user->id.") OR
		//l.id IN (SELECT sampionat_id FROM fav_sampionat WHERE tipuvac_id=" . $this->user->id . ") OR
				
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["favorite"] = (int) $red->broj;
		
		$sql = $this->broenje_natprevari . $this->join_natprevari . "
				INNER JOIN oblozi AS o ON o.natprevar_id=n.id
				WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "' AND
				n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
				AND o.tipuvac_id IN (SELECT sledi_tipuvac FROM sledenje
				WHERE tipuvac_id=" . $this->user->id . ")";
		
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["following"] = (int) $red->broj;
		
		$sql = $this->broenje_natprevari . $this->join_natprevari . "
				WHERE n.pocetok LIKE '" . $sega->format("Y-m-d") . "%'
				AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
				ORDER BY n.pocetok ASC";
		
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["denesni"] = (int) $red->broj;
		
		$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj FROM natprevari AS n
			INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
			INNER JOIN kolo AS k ON n.kolo_id=k.id
			INNER JOIN sezona AS s ON s.id=k.sezona_id
			INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			INNER JOIN sportovi AS x ON x.id=l.sport_id
			WHERE n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
			AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
			AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
			AND	n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
				ORDER BY n.pocetok ASC";
		
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["recent"] = (int) $red->broj;
		
		$sql = $this->broenje_natprevari . ", (SELECT COUNT(DISTINCT(id)) FROM oblozi
				WHERE natprevar_id=n.id) AS brojOblozi" . $this->join_natprevari . "
				WHERE n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
				AND	n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=".
			 $this->user->id . ")
				AND n.id IN (SELECT DISTINCT(natprevar_id) FROM oblozi)
			 	ORDER BY brojOblozi DESC, n.pocetok ASC";
		
		$rezz = $this->db->query($sql);
		$red = $rezz->row();
		$rezultat["popularni"] = (int) $red->broj;
		
		$data['broevi'] = (object) $rezultat;
		$data['info'] = $this->info;
		$this->load->view("public_template", $data);
	}
	function all($id = 0)
	{
		$data = array ("content" => "p_natprevari","user" => $this->user,
					'activeLeagues' => $this->activeLeagues,'activeSports' => $this->activeSports,
					'title' => "All matches");
		
		$data['sport_id'] = $id;
		$uslov = "";
		if($id > 0)
		{
			$uslov = " AND x.id=" . $id;
		}
		
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$sql = $this->listanje_natprevari . $this->join_natprevari . "
			WHERE n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND 
			n.pocetok < '" .
			 $posle->format("Y-m-d H:i:s") . "'" . $uslov . " AND 
			n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
			ORDER BY n.pocetok ASC, n.id ASC"; // td.top DESC, tg.top DESC,
		
		$rezz = $this->db->query($sql);
		if($rezz->num_rows() > 0)
			$data["lista"] = $rezz->result();
		else
			$data["lista"] = array ();
		
		$data['info'] = $this->info;
		$data['popup'] = $this->session->userdata("popup");
		$this->session->unset_userdata("popup");
		$this->load->view("public_template", $data);
	}
	function today()
	{
		$data = array ("content" => "p_natprevari","user" => $this->user,
					'activeLeagues' => $this->activeLeagues,'activeSports' => $this->activeSports,
					'title' => "Today's matches");
		
		$data['sport_id'] = 0;
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime($sega->format("Y-m-d"), new DateTimeZone($this->serverZone));
		$posle->modify("+1 day");
		$posle->modify("-1 second");
		
		$sql = $this->listanje_natprevari . $this->join_natprevari . "
			WHERE n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "' AND
			n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
			ORDER BY td.top DESC, tg.top DESC, n.pocetok ASC, n.id ASC";
		
		$rezz = $this->db->query($sql);
		if($rezz->num_rows() > 0)
			$data["lista"] = $rezz->result();
		else
			$data["lista"] = array ();
		
		$data['info'] = $this->info;
		$this->load->view("public_template", $data);
	}
	function popular()
	{
		$data = array ("content" => "p_natprevari","user" => $this->user,
					'activeLeagues' => $this->activeLeagues,'activeSports' => $this->activeSports,
					'title' => "Most popular matches");
		
		$data['sport_id'] = 0;
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id)
			AS brojOblozi" . $this->join_natprevari . "
			WHERE n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "' AND
			n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
			AND n.id IN (SELECT DISTINCT(natprevar_id) FROM oblozi)
			ORDER BY brojOblozi DESC, n.pocetok ASC, n.id ASC";
		
		$rezz = $this->db->query($sql);
		if($rezz->num_rows() > 0)
			$data["lista"] = $rezz->result();
		else
			$data["lista"] = array ();
		
		$data['info'] = $this->info;
		$this->load->view("public_template", $data);
	}
	function recent()
	{
		$data = array ("content" => "p_natprevari","user" => $this->user,
					'activeLeagues' => $this->activeLeagues,'activeSports' => $this->activeSports,
					'title' => "Recent matches");
		
		$data['sport_id'] = 0;
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$sql = $this->listanje_natprevari . $this->join_natprevari . "
				WHERE n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
				ORDER BY n.pocetok ASC, n.id ASC";
		
		$rezz = $this->db->query($sql);
		if($rezz->num_rows() > 0)
			$data["lista"] = $rezz->result();
		else
			$data["lista"] = array ();
		
		$data['info'] = $this->info;
		$this->load->view("public_template", $data);
	}
	function recommended()
	{
		$data = array ("content" => "p_natprevari","user" => $this->user,
					'activeLeagues' => $this->activeLeagues,'activeSports' => $this->activeSports,
					'title' => "Recommended matches");
		
		$data['sport_id'] = 0;
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$id = $this->user->id;
		
		$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" . $id . " AND 
				natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" . $id .
			 " AND 
				natprevar_id=n.id) AS igrano, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) 
				AS brojOblozi, tt.fname, tt.lname, tt.username, o.tip, o.koeficient, tt.rang, tt.dobivka AS saldo" .
			 $this->join_natprevari ."
				INNER JOIN oblozi AS o ON o.natprevar_id=n.id
				INNER JOIN (SELECT id, @red := @red + 1 AS rang, fname, lname, username,
				(SELECT 100 + SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
					if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o 
					WHERE tipuvac_id=t.id) AS dobivka
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, saldo DESC LIMIT " .
			 $this->limits->top . ") AS tt ON tt.id=o.tipuvac_id
				WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" .
			 $sega->format("Y-m-d H:i:s") . "' AND tt.id<>" . $id . "
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
				ORDER BY n.pocetok ASC, n.id ASC";
		$rezz = $this->db->query($sql);
		if($rezz->num_rows() > 0)
			$data["lista"] = $rezz->result();
		else
			$data["lista"] = array ();
		
		$data['info'] = $this->info;
		$this->load->view("public_template", $data);
	}
	function favorites()
	{
		$data = array ("content" => "p_natprevari","user" => $this->user,
					'activeLeagues' => $this->activeLeagues,'activeSports' => $this->activeSports,
					'title' => "Matches from my favorites");
		
		$data['sport_id'] = 0;
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id .
			 " AND natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . " AND natprevar_id=n.id) AS igrano" . $this->join_natprevari . " WHERE 
			(n.domasni IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" . $this->user->id . ")
			OR n.gosti IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" .
			 $this->user->id . "))
			AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
			AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
			AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
			AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $this->user->id . ")
			ORDER BY n.pocetok ASC, n.id ASC";
		// l.id IN (SELECT sampionat_id FROM fav_sampionat WHERE tipuvac_id=" . $this->user->id . ")
		// OR
		$rezz = $this->db->query($sql);
		if($rezz->num_rows() > 0)
			$data["lista"] = $rezz->result();
		else
			$data["lista"] = array ();
		
		$data['info'] = $this->info;
		$this->load->view("public_template", $data);
	}
	function following()
	{
		$data = array ("content" => "p_natprevari","user" => $this->user,
					'activeLeagues' => $this->activeLeagues,'activeSports' => $this->activeSports,
					'title' => "Matches from my following");
		
		$data['sport_id'] = 0;
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		$id = $this->user->id;
		
		$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" . $id . " AND
				natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" . $id .
			 " AND
				natprevar_id=n.id) AS igrano, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id)
				AS brojOblozi, t.fname, t.lname, t.username, o.tip, o.koeficient, t.dobivka as saldo, t.rang" .
			 $this->join_natprevari . " INNER JOIN oblozi AS o ON o.natprevar_id=n.id
				INNER JOIN (SELECT id, @red := @red + 1 AS rang, fname, lname, username,
				(SELECT 100 + SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
					if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o
				INNER JOIN natprevari n ON n.id=o.natprevar_id
				INNER JOIN kolo AS k ON k.id=n.kolo_id
				INNER JOIN sezona AS s ON s.id=k.sezona_id
				INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				WHERE tipuvac_id=t.id) AS dobivka
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC) AS t ON t.id=o.tipuvac_id
				WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "' AND
				n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
				AND o.tipuvac_id IN (SELECT sledi_tipuvac FROM sledenje WHERE tipuvac_id=" . $id . ")
				ORDER BY n.pocetok ASC, brojOblozi DESC, n.id ASC";
		
		$rezz = $this->db->query($sql);
		if($rezz->num_rows() > 0)
			$data["lista"] = $rezz->result();
		else
			$data["lista"] = array ();
		
		$data['info'] = $this->info;
		$this->load->view("public_template", $data);
	}
	function top()
	{
		$data = array ("content" => "p_natprevari","user" => $this->user,
					'activeLeagues' => $this->activeLeagues,'activeSports' => $this->activeSports,
					'title' => "Matches from top teams");
		
		$data['sport_id'] = 0;
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . " AND natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi
			WHERE tipuvac_id=" . $this->user->id .
			 " AND natprevar_id=n.id) AS igrano" . $this->join_natprevari . " WHERE n.pocetok > '" .
			 $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok < '" .
			 $posle->format("Y-m-d H:i:s") . "' AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
			AND (td.top>0 OR tg.top>0) ORDER BY n.pocetok ASC, td.top DESC, tg.top DESC, n.id ASC";
		
		$rezz = $this->db->query($sql);
		if($rezz->num_rows() > 0)
			$data["lista"] = $rezz->result();
		else
			$data["lista"] = array ();
		
		$data['info'] = $this->info;
		$this->load->view("public_template", $data);
	}
	function bets()
	{
		$this->load->model('oblog');
		$this->load->model('korisnik');
		$natprevari = explode(',', $this->input->post("natprevariArray"));
		$koeficienti = explode(',', $this->input->post("koeficientiArray"));
		$tipovi = explode(',', $this->input->post("tipoviArray"));
		$ulozi = $this->input->post("ulog");
		$newdata = array ("content" => "p_bet","user" => $this->user);
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify($this->limits->recent . " day");
		if(! is_array($natprevari) && ! is_numeric($natprevari))
			redirect("matches");
		if(count($natprevari) == count($tipovi) && count($tipovi) == count($koeficienti))
		{
			$data['tipuvac_id'] = $this->user->id;
			$data['datum'] = $sega->format("Y-m-d H:i:s");
			$broj = count($natprevari);
			if(is_array($natprevari))
			{
				for($i = 0; $i < $broj; $i ++)
				{
					$data['natprevar_id'] = $natprevari[$i];
					$data['koeficient'] = $koeficienti[$i];
					$data['tip'] = $tipovi[$i];
					$data['ulog'] = floor($ulozi / $broj);
					$data['saldo'] = $this->user->saldo;
					$sqlProverka = "SELECT COUNT(id) AS broj FROM oblozi WHERE tipuvac_id=" .
								 $this->user->id . " AND natprevar_id=" . $data['natprevar_id'];
					if((int) $this->db->query($sqlProverka)->row()->broj == 0)
					{
						if($this->oblog->insert($data))
						{
							$this->user->saldo -= floor($ulozi / $broj);
							if((int) $this->user->tmpBids == 0)
								$this->user->bids --;
							else
								$this->user->tmpBids --;
						}
					}
				}
				$sql = "SELECT o.tip, o.koeficient, d.ime AS domasni, g.ime AS gosti,
					o.ulog, l.ime AS sampionat
					FROM oblozi AS o INNER JOIN natprevari AS n ON n.id=o.natprevar_id
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id INNER JOIN timovi AS d ON d.id=n.domasni
					INNER JOIN timovi AS g ON g.id=n.gosti INNER JOIN kolo AS k ON n.kolo_id=k.id
					INNER JOIN sezona AS s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE o.tipuvac_id=" . $this->user->id .
					 " AND n.id=" . $natprevari[0];
				$red = $this->db->query($sql)->row();
				$newdata["message"] = "<h2>" . $red->domasni . " vs " . $red->gosti . "</h2>";
				// . $red->sampionat;
				switch($red->tip)
				{
					case "1":
						$newdata["message"] .= "<h3>tip: " . $red->domasni .
											 " wins</h3><h3>coefficient: " .
											 number_format(floatval($red->koeficient), 1) . "</h3>";
						break;
					
					case "1":
						$newdata["message"] .= "<h3>tip: " . $red->gosti .
											 " wins</h3><h3>coefficient " .
											 number_format(floatval($red->koeficient), 1) . "</h3>";
						break;
					
					default:
						$newdata["message"] .= "<h3>tip: draw</h3><h3>coefficient " .
											 number_format(floatval($red->koeficient), 1) . "</h3>";
						break;
				}
				$newdata["message"] .= "<h3>bet: $red->ulog points</h3>";
				if($this->user->bidsLimit > 0)
				{
					$newdata["fbmessage"] = "I just put money-free bet on this match: " .
											 $red->domasni . " - " . $red->gosti . ".
							If I am good tipper, I can earn real money and real prizes. You can check at Zinteo.com";
					/*
					 * switch($red->tip) { case "1": $newdata["fbmessage"] .= $red->domasni . " win,
					 * coefficient " . number_format(floatval($red->koeficient), 1); break; case
					 * "1": $newdata["fbmessage"] .= $red->gosti . " win, coefficient " .
					 * number_format(floatval($red->koeficient), 1); break; default:
					 * $newdata["fbmessage"] .= " draw, coefficient " .
					 * number_format(floatval($red->koeficient), 1); break; }
					 */
				}
			}
			elseif((int) $natprevari > 0)
			{
				$data['natprevar_id'] = (int) $natprevari[0];
				$data['koeficient'] = $koeficienti[0];
				$data['tip'] = $tipovi[0];
				$data['ulog'] = $ulozi;
				$data['saldo'] = $this->user->saldo;
				$sqlProverka = "SELECT COUNT(id) AS broj FROM oblozi WHERE tipuvac_id=" .
							 $this->user->id . " AND natprevar_id=" . $data['natprevar_id'];
				if((int) $this->db->query($sqlProverka)->row()->broj == 0)
				{
					if($this->oblog->insert($data))
					{
						$this->user->saldo -= $ulozi;
						if((int) $this->user->tmpBids == 0)
							$this->user->bids --;
						else
							$this->user->tmpBids --;
					}
				}
				$sql = "SELECT o.tip, o.koeficient, d.ime AS domasni, g.ime AS gosti,
					o.ulog, l.ime AS sampionat
					FROM oblozi AS o INNER JOIN natprevari AS n ON n.id=o.natprevar_id
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id INNER JOIN timovi AS d ON d.id=n.domasni
					INNER JOIN timovi AS g ON g.id=n.gosti INNER JOIN kolo AS k ON n.kolo_id=k.id
					INNER JOIN sezona AS s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE o.tipuvac_id=" . $this->user->id . " AND n.id=" .
					 $natprevari;
				$red = $this->db->query($sql)->row();
				$newdata["message"] = "<h2>" . $red->domasni . " vs " . $red->gosti . "</h2>";
				// . $red->sampionat;
				switch($red->tip)
				{
					case "1":
						$newdata["message"] .= "<h3>tip: " . $red->domasni .
											 " wins</h3><h3>coefficient: " .
											 number_format(floatval($red->koeficient), 1) . "</h3>";
						break;
					
					case "1":
						$newdata["message"] .= "<h3>tip: " . $red->gosti .
											 " wins</h3><h3>coefficient " .
											 number_format(floatval($red->koeficient), 1) . "</h3>";
						break;
					
					default:
						$newdata["message"] .= "<h3>tip: draw</h3><h3>coefficient " .
											 number_format(floatval($red->koeficient), 1) . "</h3>";
						break;
				}
				$newdata["message"] .= "<h3>bet: $red->ulog points</h3>";
				if($this->user->bidsLimit > 0)
				{
					$newdata["fbmessage"] = "I just put money-free bet on this match: " .
											 $red->domasni . " - " . $red->gosti . ".
						If I am good tipper, I can earn real money and real prizes. You can check at Zinteo.com";
					/*
					 * $newdata["fbmessage"] = "I just place this bet: " . $red->domasni . " - " .
					 * $red->gosti . " game from " . $red->sampionat; switch($red->tip) { case "1":
					 * $newdata["fbmessage"] .= $red->domasni . " win, coefficient " .
					 * number_format(floatval($red->koeficient), 1); break; case "1":
					 * $newdata["fbmessage"] .= $red->gosti . " win, coefficient " .
					 * number_format(floatval($red->koeficient), 1); break; default:
					 * $newdata["fbmessage"] .= " draw, coefficient " .
					 * number_format(floatval($red->koeficient), 1); break; }
					 */
				}
			}
			
			$newdata['info'] = $this->info;
			$smee_post = $this->auth->smee_post();
			if(!$smee_post)
			{
				$newdata['login_url'] = $this->auth->get_login_url(array('scope'=>'publish_actions',
						'redirect_uri' => base_url('matches/postiraj')));
			}
			$this->korisnik->update($this->user, $this->user->id);
			$this->load->view("public_template", $newdata);
		}
	}
	function postiraj()
	{
		$message = $this->input->post("message");
		if(! $message)
			redirect("matches/all");
		$this->load->model("korisnik");
		$opis = "Zinteo - a place where tippers from all around the".
			" world can compete to each other on real sport matches.".
			" All bets are money-free. Now. Tomorrow. Forever";
		try
		{
			$attachment = array (
					'message' => $message,
					'link' => base_url(),
					'name' => "Zinteo - Social Betting Fantazy Game",
					'description' => $opis,
					'picture'=> base_url('images/fb_pic.png')
			);
			$postwall = $this->auth->post($attachment);
			print_r($postwall);
			if($postwall)
			{
				$sega = new DateTime("now", new DateTimeZone($this->user->timezone));
				/*
				 * if($this->user->tmpDatum == "0000-00-00") { $this->user->tmpDatum =
				 * $sega->format("Y-m-d"); $this->user->tmpBids += 2; } else
				 */
				{
					$this->user->tmpDatum = $sega->format("Y-m-d");
					$this->user->tmpBids += 1;
					$this->user->bidsLimit -= 1;
				}
				$this->korisnik->update($this->user, $this->user->id);
				$this->session->set_userdata("popup", 
											"By placing your bet od Facebook, you earn one more match to bet on Zinteo (only today)");
			}
			redirect("matches/all");
		}
		catch(FacebookApiException $err)
		{
			// echo $err->getMessage();
		}
		redirect("matches/all");
	}
}