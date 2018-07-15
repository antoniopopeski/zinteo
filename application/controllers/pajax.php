<?php
class Pajax extends MY_Public
{
	private $USAzone = "America/Whitehorse";
	private $serverZone = "Europe/Skopje";
	private $listanje_natprevari = "SELECT DISTINCT(n.id), td.id AS domasniID, td.ime AS domasni,
			tg.id AS gostiID, tg.ime AS gosti, n.domasni1, n.domasni2, n.domasni3, n.domasni4,
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
	function getRandomMatch()
	{
		$id = (int) $this->input->post('tiper');
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify("+".$this->limits->recent." day");
		if($id)
		{
			$sql = $this->broenje_natprevari . $this->join_natprevari . " WHERE n.pocetok > '" .
				 $sega->format("Y-m-d H:i:s") . "'
				AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
				AND (td.top>0 AND tg.top>0)";
			$rezultat = $this->db->query($sql);
			$broj = 0;
			if($rezultat->num_rows() > 0)
				$broj = (int) $rezultat->row()->broj;
			if($broj)
			{
				$sql = $this->listanje_natprevari . $this->join_natprevari . "
					WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
					AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
					AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
					AND (td.top>0 AND tg.top>0)";
				$lista = $this->db->query($sql . " ORDER BY n.pocetok ASC LIMIT " . $broj);
				if($lista->num_rows() > 0)
				{
					$indeks = 0;
					if($broj > 1 && $lista->num_rows() > 1)
						$indeks = mt_rand(0, $broj - 1);
					$arr = $lista->result();
					$mlista = $arr [$indeks];
				}
			}
			else
			{
				$sql = $this->broenje_natprevari . $this->join_natprevari . "
					WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
					AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
					AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
					AND (td.top>0 OR tg.top>0)";
				$rezultat = $this->db->query($sql);
				$broj = 0;
				if($rezultat->num_rows() > 0)
					$broj = (int) $rezultat->row()->broj;
				if($broj)
				{
					$sql = $this->listanje_natprevari . $this->join_natprevari . "
						WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
						AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
						AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
						AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
						AND (td.top>0 OR tg.top>0)";
					$lista = $this->db->query($sql . " ORDER BY n.pocetok ASC");
					if($lista->num_rows() > 0)
					{
						$indeks = 0;
						if($broj > 1 && $lista->num_rows() > 1)
							$indeks = mt_rand(0, $broj - 1);
						$arr = $lista->result();
						$mlista = $arr [$indeks];
					}
				}
				else
				{
					$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj,
						(SELECT COUNT(DISTINCT(id)) FROM oblozi WHERE natprevar_id=n.id) AS brojOblozi
						" . $this->join_natprevari . "
						WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
						AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
						AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
						AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
						AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'";
					$rezultat = $this->db->query($sql);
					$broj = 0;
					if($rezultat->num_rows() > 0)
						$broj = (int) $rezultat->row()->broj;
					if($broj)
					{
						$sql = $this->listanje_natprevari . ",
							(SELECT COUNT(DISTINCT(id)) FROM oblozi WHERE natprevar_id=n.id) AS brojOblozi" .
							 $this->join_natprevari . " WHERE n.pocetok > '" .
							 $sega->format("Y-m-d H:i:s") . "'
							AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
							AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
							AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
							AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'";
						$lista = $this->db->query($sql . " ORDER BY brojOblozi DESC, n.pocetok ASC");
						if($lista->num_rows() > 0)
						{
							$indeks = 0;
							if($broj > 1 && $lista->num_rows() > 1)
								$indeks = mt_rand(0, $broj - 1);
							$arr = $lista->result();
							$mlista = $arr [$indeks];
						}
					}
				}
			}
			if(isset($mlista))
				$this->renderMatch($mlista);
		}
	}
	function detaliNatprevar()
	{
	$broj = (int)$_POST['id'];
	$sql = "SELECT d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,s.ime AS sezona,
			domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv, c.id AS koef,
			(SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, y.ime AS drzava
			FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona AS s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN drzavi AS y ON l.drzava_id= y.id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id WHERE n.id=".$broj;
	$timezone = $this->user->timezone; //"Europe/Skopje";
	$format = "F d, Y";
	$format2 = "H:i";
	$data = $this->db->query($sql)->row();
	?>
<div style="text-align: center; font-size: 15px;">
	<div>
		<b><?php echo $data->domasni." : ".$data->gosti;?></b>
	</div>
	<div><?php $datum = new DateTime($data->pocetok, new DateTimeZone($this->serverZone));
	$datum->setTimezone(new DateTimeZone($timezone)); 
	echo $datum->format($format);?> @ <?php echo $datum->format($format2);?></div>
	<div>League: <?php echo $data->sampionat; echo ($data->drzava)?" (".$data->drzava.")":"";?></div>
</div>
<?php
	}
	function all()
	{
		$id = $this->user->id;
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$uslov = "";
		if($sport_id)
			$uslov .= " AND l.sport_id=" . $sport_id;
		if($liga_id)
			$uslov .= " AND l.id=" . $liga_id;
		
		$sql = $this->listanje_natprevari . $this->join_natprevari . "
			WHERE n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND 
			n.pocetok < '" .
			 $posle->format("Y-m-d H:i:s") . "'" . $uslov . " AND 
			n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
			ORDER BY n.pocetok ASC";// td.top DESC, tg.top DESC,
		
		$lista = $this->db->query($sql)->result();
		$this->renderMatches($lista);
	}
	function following()
	{
		$id = $this->user->id;
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$uslov = "";
		if($sport_id)
			$uslov .= " AND l.sport_id=" . $sport_id;
		if($liga_id)
			$uslov .= " AND l.id=" . $liga_id;
		
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
				n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" . $uslov . "
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
				AND o.tipuvac_id IN (SELECT sledi_tipuvac FROM sledenje WHERE tipuvac_id=" . $id . ")
				ORDER BY n.pocetok ASC, brojOblozi DESC, n.id ASC";
		$lista = $this->db->query($sql)->result();
		$this->renderMatches($lista, "following");
	}
	function today()
	{
		$id = $this->user->id;
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify("+1 day");
		$posle->modify("-1 second");
		
		$uslov = "";
		if($sport_id)
			$uslov .= " AND l.sport_id=" . $sport_id;
		if($liga_id)
			$uslov .= " AND l.id=" . $liga_id;
		
		$sql = $this->listanje_natprevari . $this->join_natprevari . " WHERE n.pocetok > '" .
			 $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok < '" .
			 $posle->format("Y-m-d H:i:s") . "' AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") .
			 "'" . $uslov . " AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $id . ")
			AND o.tipuvac_id IN (SELECT sledi_tipuvac FROM sledenje WHERE tipuvac_id=" . $id . ")
			ORDER BY n.pocetok ASC, brojOblozi DESC";
		
		$lista = $this->db->query($sql)->result();
		$this->renderMatches($lista);
	}
	function popular()
	{
		$id = $this->user->id;
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$uslov = "";
		if($sport_id)
			$uslov .= " AND l.sport_id=" . $sport_id;
		if($liga_id)
			$uslov .= " AND l.id=" . $liga_id;
		
		$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id)
			AS brojOblozi" . $this->join_natprevari . "
			WHERE n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok < '" .
			 $posle->format("Y-m-d H:i:s") . "'" . $uslov . " AND
			n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
			AND n.id IN (SELECT DISTINCT(natprevar_id) FROM oblozi)
			ORDER BY brojOblozi DESC, n.pocetok ASC";
		
		$lista = $this->db->query($sql)->result();
		$this->renderMatches($lista);
	}
	function recent()
	{
		$id = $this->user->id;
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$uslov = "";
		if($sport_id)
			$uslov .= " AND l.sport_id=" . $sport_id;
		if($liga_id)
			$uslov .= " AND l.id=" . $liga_id;
		
		$sql = $this->listanje_natprevari . $this->join_natprevari . "
				WHERE n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'" .
			 $uslov . "
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . ")
				ORDER BY n.pocetok ASC";
		
		$lista = $this->db->query($sql)->result();
		$this->renderMatches($lista, "recommended");
	}
	function recommended()
	{
		$id = $this->user->id;
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$uslov = "";
		if($sport_id)
			$uslov .= " AND l.sport_id=" . $sport_id;
		if($liga_id)
			$uslov .= " AND l.id=" . $liga_id;
		
		$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" . $id . " AND
				natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" . $id .
					 " AND
				natprevar_id=n.id) AS igrano, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id)
				AS brojOblozi, tt.fname, tt.lname, tt.username, o.tip, o.koeficient, tt.rang, tt.dobivka AS saldo" .
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
				AND n.vidliv < '" .	 $sega->format("Y-m-d H:i:s") . "'" .$uslov . " AND tt.id<>" . $id . "
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
				ORDER BY n.pocetok ASC, n.id ASC";
		//echo '<div style="display: none;">'.$sql.'</div>';
		$lista = $this->db->query($sql)->result();
		//print_r($lista);
		$this->renderMatches($lista);
	}
	function favorites()
	{
		$id = $this->user->id;
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$uslov = "";
		if($sport_id)
			$uslov .= " AND l.sport_id=" . $sport_id;
		if($liga_id)
			$uslov .= " AND l.id=" . $liga_id;
		
		$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" . $id .
			 " AND natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" . $id .
			 " AND natprevar_id=n.id) AS igrano" . $this->join_natprevari . " WHERE
			(n.domasni IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" . $id . ")
			OR n.gosti IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" . $id . "))
			AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
			AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
			AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" .
			 $uslov . "
			ORDER BY n.pocetok ASC";
		//l.id IN (SELECT sampionat_id FROM fav_sampionat WHERE tipuvac_id=" . $id . ") OR
		
		$lista = $this->db->query($sql)->result();
		$this->renderMatches($lista);
	}
	function top()
	{
		$id = $this->user->id;
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle = new DateTime("now", new DateTimeZone($this->serverZone));
		$posle->modify($this->limits->recent . " day");
		
		$uslov = "";
		if($sport_id)
			$uslov .= " AND l.sport_id=" . $sport_id;
		if($liga_id)
			$uslov .= " AND l.id=" . $liga_id;
		
		$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" .
			 $this->user->id . " AND natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi
			WHERE tipuvac_id=" . $this->user->id .
			 " AND natprevar_id=n.id) AS igrano" . $this->join_natprevari . " WHERE n.pocetok > '" .
			 $sega->format("Y-m-d H:i:s") . "' AND
			n.pocetok < '" .
			 $posle->format("Y-m-d H:i:s") . "' AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
			AND (td.top>0 OR tg.top>0)" . $uslov .
			 " ORDER BY n.pocetok ASC, td.top DESC, tg.top DESC";
		
		$lista = $this->db->query($sql)->result();
		$this->renderMatches($lista);
	}
	function weeksOfYear()
	{
		$this->load->helper("periodi");
		$year = $this->input->post("year");
		$maxWeeks =  getWeeksInYear($year);
		?><option value="0" selected="selected">All</option><?php
		for($i = $maxWeeks; $i > 0; $i --) :
		$datumi = getWeek($i, $year, "America/Whitehorse", "America/Whitehorse");
		$monday = $datumi[0];
		$sunday = $datumi[1];
		?>
		<option value="<?php echo $i;?>"><?php
			echo "Week" . $i . " " . $year . " (" . $monday->format("d") . " " . $monday->format("M") . " - " . $sunday->format("d") . " " . $sunday->format("M") . ")";
		?></option><?php
		endfor;
	}
	function awarded()
	{
		$procenti = 0;
		//minIgrani edno pomalko od trazenu vrednost (4 za 5 igrani)
		$minIgrani = 9;
		if($this->input->post("procenti"))
			$procenti = $this->input->post("procenti");
		$this->load->helper("periodi");
		$year = $this->input->post("year");
		$month = 12;
		$maxWeeks =  getWeeksInYear($year);
		$sega = new DateTime('now', new DateTimeZone($this->USAzone));
		for($i = $maxWeeks; $i > 0; $i --) :
		$datumi = getWeek($i, $year, $this->serverZone, $this->USAzone);
		$p = $datumi[0];
		$k = $datumi[1];
		if($p > $sega )
			continue;
		$datumi = getWeek($i, $year, $this->serverZone, $this->USAzone);
		$pr = $datumi[0];
		$kr = $datumi[1];
		$uslov = " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
		$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
		if(!$procenti)
			$sql = "SELECT * FROM (SELECT id, @red := @red + 1 AS rang, fname, lname,
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
				(SELECT SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
				if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o
				INNER JOIN natprevari n ON n.id=o.natprevar_id
				INNER JOIN kolo AS k ON k.id=n.kolo_id
				INNER JOIN sezona AS s ON s.id=k.sezona_id
				INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				WHERE tipuvac_id=t.id$uslov) AS dobivka
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, oblozi DESC
				) AS rezultat WHERE oblozi>$minIgrani AND dobivka > 0 LIMIT 1";
		else
			$sql = "SELECT * FROM (SELECT id, @red := @red + 1 AS rang, fname, lname,
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
				(SELECT SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1), 0))/SUM(if(o.uspesen IS NOT NULL, o.ulog, 0)) FROM oblozi o
				INNER JOIN natprevari n ON n.id=o.natprevar_id
				INNER JOIN kolo AS k ON k.id=n.kolo_id
				INNER JOIN sezona AS s ON s.id=k.sezona_id
				INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				WHERE tipuvac_id=t.id$uslov) AS dobivka
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, oblozi DESC
				) AS rezultat WHERE oblozi>$minIgrani AND dobivka > 1 LIMIT 1";
		//echo $sql."<br><br>";
		$data = $this->db->query($sql)->row();
		if(is_object($data) && $data->pogodeni)
		{
			echo "<br>Week" . $i . " (" . $pr->format("d") . " " . $pr->format("M") . " - " . $kr->format("d") . " " . 
				$kr->format("M") . ")<br>";
			echo '<a href="'.site_url('leaderboard/bets/'.$data->id).'"><span style="font-size: 17px; font-weight: bold; color: #fff;">'.$data->fname.' '.$data->lname.' ';
			if($procenti)
				echo 100*round($data->dobivka, 2)."%";
			else 
				echo $data->dobivka." pts";
			echo '</span></a><br>';
		}
		if((int)$p->format('m') < $month)
		{
			$month = (int)$p->format('m');
			$datumi = getMonth($month, $year, $this->serverZone, $this->USAzone);
			$p = $datumi[0];
			$k = $datumi[1];
			$uslov = " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
			$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
			if(!$procenti)
				$sql = "SELECT * FROM (SELECT id, @red := @red + 1 AS rang, fname, lname,
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
					(SELECT SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
					if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o
					INNER JOIN natprevari n ON n.id=o.natprevar_id
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE tipuvac_id=t.id$uslov) AS dobivka
					FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, oblozi DESC
					) AS rezultat WHERE oblozi>$minIgrani AND dobivka > 0 LIMIT 1";
			else
				$sql = "SELECT * FROM (SELECT id, @red := @red + 1 AS rang, fname, lname,
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
					(SELECT SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1), 0))/SUM(if(o.uspesen IS NOT NULL, o.ulog, 0)) FROM oblozi o
					INNER JOIN natprevari n ON n.id=o.natprevar_id
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE tipuvac_id=t.id$uslov) AS dobivka
					FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, oblozi DESC
					) AS rezultat WHERE oblozi>$minIgrani AND dobivka > 1 LIMIT 1";
					//echo $sql."<br><br>";
			$data = $this->db->query($sql)->row();
			if(is_object($data) && $data->pogodeni)
			{
				echo "<br><hr/>";
				switch($month)
				{
					case 1: echo "<br>January $year<br>";
					break;
					case 2: echo "<br>February $year<br>";
					break;
					case 3: echo "<br>March $year<br>";
					break;
					case 4: echo "<br>April $year<br>";
					break;
					case 5: echo "<br>May $year<br>";
					break;
					case 6: echo "<br>June $year<br>";
					break;
					case 7: echo "<br>July $year<br>";
					break;
					case 8: echo "<br>August $year<br>";
					break;
					case 9: echo "<br>September $year<br>";
					break;
					case 10: echo "<br>October $year<br>";
					break;
					case 11: echo "<br>November $year<br>";
					break;
					case 12: echo "<br>December $year<br>";
					break;
				}
				echo '<a href="'.site_url('leaderboard/bets/'.$data->id).'"><span style="font-size: 17px; font-weight: bold; color: #fff;">'.$data->fname.' '.$data->lname.' ';
				if($procenti)
					echo 100*round($data->dobivka, 2)."%";
				else
					echo $data->dobivka." pts";
				echo '</span></a><br>';
			} 
		}
		endfor;
	}
	function mostAwarded()
	{
		if($this->input->post("year"))
		{
			$maxGodina = $this->input->post("year");
			$minGodina = $maxGodina;
		} else {
			$sega = new DateTime('now', new DateTimeZone($this->USAzone));
			$maxGodina = (int) $sega->format("Y");
			$minGodina = 2013;
		}
		//echo "min: $minGodina, max: $maxGodina<br>";
		$this->render_most_awarded($minGodina, $maxGodina);
	}
	private function render_most_awarded($minGodina, $maxGodina)
	{
		//treba da vrati lista na najnagraduvani mesecno, nedelno
		$this->load->helper("periodi");
		$listaPobednici = array();
		$minIgrani = 9;
		for($i=$minGodina;$i<=$maxGodina; $i++)
		{
			//mesecno pobednici
			for($month=1;$month<=12;$month++)
			{
				$datumi = getMonth($month, $i, $this->USAzone, $this->USAzone);
				$p = $datumi[0];
				$k = $datumi[1];
				$uslov = " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
				$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
				$sql = "SELECT * FROM (SELECT id, fb_id, fname, lname,
					(SELECT COUNT(o.id) FROM oblozi o
					INNER JOIN natprevari n ON n.id=o.natprevar_id
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE tipuvac_id=t.id$uslov AND o.uspesen IS NOT NULL) AS oblozi,
					(SELECT SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1), 0))/SUM(if(o.uspesen IS NOT NULL, o.ulog, 0)) FROM oblozi o
					INNER JOIN natprevari n ON n.id=o.natprevar_id
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE tipuvac_id=t.id$uslov) AS dobivka
					FROM tipuvaci AS t ORDER BY dobivka DESC, oblozi DESC
					) AS rezultat WHERE oblozi>$minIgrani AND dobivka > 0 LIMIT 1";
				$data = $this->db->query($sql)->row_array();
				if(!empty($data))
				{
					$data["mesecno"] = 1;
					$data["nedelno"] = 0;
					if(in_array($data["fb_id"], $listaPobednici))
					{
						$vrednost = array_search($data["fb_id"], $listaPobednici);
						$predhodanPodatok = $listaPobednici[$vrednost];
						$predhodanPodatok["mesecno"]++;
					}
					else 
						$listaPobednici[] = $data;
				}
			}
			//nedelni pobednici
			$maxWeeks =  getWeeksInYear($i);
			for($week=1;$week<=$maxWeeks;$week++)
			{
				$datumi = getWeek($week, $i, $this->USAzone, $this->USAzone);
				$p = $datumi[0];
				$k = $datumi[1];
				$uslov = " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
				$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
				$sql = "SELECT * FROM (SELECT id, fb_id, fname, lname,
					(SELECT COUNT(o.id) FROM oblozi o
					INNER JOIN natprevari n ON n.id=o.natprevar_id
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE tipuvac_id=t.id$uslov AND o.uspesen IS NOT NULL) AS oblozi,
					(SELECT SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1), 0))/SUM(if(o.uspesen IS NOT NULL, o.ulog, 0)) FROM oblozi o
					INNER JOIN natprevari n ON n.id=o.natprevar_id
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE tipuvac_id=t.id$uslov) AS dobivka
					FROM tipuvaci AS t ORDER BY dobivka DESC, oblozi DESC
					) AS rezultat WHERE oblozi>$minIgrani AND dobivka > 0 LIMIT 1";
				$data = $this->db->query($sql)->row_array();
				if(!empty($data))
				{
					$data["mesecno"] = 0;
					$data["nedelno"] = 1;
					if(in_array($data["fb_id"], $listaPobednici))
					{
						$vrednost = array_search($data["fb_id"], $listaPobednici);
						$predhodanPodatok = $listaPobednici[$vrednost];
						$predhodanPodatok["nedelno"]++;
					}
					else
						$listaPobednici[] = $data;
				}
			}
		}
		usort($listaPobednici, "self::sort_tipuvaci");
		echo "<br>";
		foreach ($listaPobednici as $pobednik)
		{
			echo "<span style=\"padding-left:2%; font-size: 15px; color: #fff; display: block; text-align: left;\">".
				$pobednik['fname']." ".$pobednik['lname']." - ".$pobednik['mesecno']." monthly, ".
				$pobednik['nedelno']." weekly winner</span>";
		}
	}
	static function sort_tipuvaci($prv,$vtor)
	{
		if($prv["mesecno"]==$vtor["mesecno"])
		{
			if($prv["nedelno"]==$vtor["nedelno"])
				return 0;
			else 
				return ($prv["nedelno"]<$vtor["nedelno"]) ? +1 : -1;
		}
		else
			return ($prv["mesecno"]<$vtor["mesecno"]) ? +1 : -1;
	}
	function leaderboard()
	{
		$uslov = "";
		$procenti = 0;
		if($this->input->post("procenti"))
			$procenti = $this->input->post("procenti");
		$tiper_id = $this->user->id;
		if($this->input->post('sport_id'))
			$uslov .= " AND l.sport_id = " . $this->input->post('sport_id');
		$period = $this->input->post('period');
		if($period)
		{
			//potrebno e da se konstriura vreme od do ali od string '2013-08-31 00:00:00' i '2013-08-31 23:59:59
			$timeAmerika = new DateTimeZone($this->USAzone);
			$timeServer = new DateTimeZone($this->serverZone);
			$sega = new DateTime('now', $timeAmerika);//vreme u ameriku
			$vremeOd = $sega->format('Y-m-d').' 00:00:00';
			$vremeDo = $sega->format('Y-m-d').' 23:59:59';
			$pocetno = new DateTime($vremeOd, $timeAmerika);
			$pocetno->setTimezone($timeServer);
			$krajno = new DateTime($vremeDo, $timeAmerika);
			$krajno->setTimezone($timeServer);
			switch($period)
			{
				case 1:
					$uslov .= " AND n.kraj >= '" . $pocetno->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $krajno->format('Y-m-d H:i:s') . "'";
					break;
				case 2: // yesterday
					$pocetno->modify('-1 day');
					$krajno->modify('-1 day');
					$uslov .= " AND n.kraj >= '" . $pocetno->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $krajno->format('Y-m-d H:i:s') . "'";
					break;
				case 3: // this week ama treba da se preraboti kako pogore zaradi vremenski zone
					//$uslov .= " AND WEEKOFYEAR(n.kraj)=".$sega->format("W");
					$this->load->helper("periodi");
					$datumi = getWeek($sega->format("W"), $sega->format("Y"), $this->serverZone, $this->USAzone);
					$p = $datumi[0];
					$k = $datumi[1];
					$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
					break;
				case 4: // last week
					//$uslov .= " AND WEEKOFYEAR(n.kraj)=".$sega->modify('-7 day')->format("W");
					$sega->modify('-7 day');
					$this->load->helper("periodi");
					$datumi = getWeek($sega->format("W"), $sega->format("Y"), $this->serverZone, $this->USAzone);
					$p = $datumi[0];
					$k = $datumi[1];
					$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
					break;
				case 5: // this month
					//$uslov .= " AND n.kraj LIKE '".$sega->format("Y-m")."%'";
					$this->load->helper("periodi");
					$datumi = getMonth($sega->format("m"), $sega->format("Y"), $this->serverZone, $this->USAzone);
					$p = $datumi[0];
					$k = $datumi[1];
					$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
					break;
				case 6: // last month
					//$uslov .= " AND n.kraj LIKE '".$sega->modify('-1 month')->format("Y-m")."%'";
					$sega->modify('-1 month');
					$this->load->helper("periodi");
					$datumi = getMonth($sega->format("m"), $sega->format("Y"), $this->serverZone, $this->USAzone);
					$p = $datumi[0];
					$k = $datumi[1];
					$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
					break;
				case 7: // this year
					//$uslov .= " AND n.kraj LIKE '".$sega->format("Y")."%'";
					$this->load->helper("periodi");
					$datumi = getYear($sega->format("Y"), $this->serverZone, $this->USAzone);
					$p = $datumi[0];
					$k = $datumi[1];
					$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
					break;
				case 8: // last year
					//$uslov .= " AND n.kraj LIKE '".$sega->modify('-1 year')->format("Y")."%'";
					$sega->modify('-1 year');
					$this->load->helper("periodi");
					$datumi = getYear($sega->format("Y"), $this->serverZone, $this->USAzone);
					$p = $datumi[0];
					$k = $datumi[1];
					$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
					break;
			}
		}
		elseif($this->input->post("year"))
			{
				if($this->input->post("month"))
				{
					$this->load->helper("periodi");
					$datumi = getMonth($this->input->post("month"), $this->input->post("year"), $this->serverZone, $this->USAzone);
					$p = $datumi[0];
					$k = $datumi[1];
					$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
				}
				elseif($this->input->post("week"))
				{
					$this->load->helper("periodi");
					$datumi = getWeek($this->input->post("week"), $this->input->post("year"), $this->serverZone, $this->USAzone);
					$p = $datumi[0];
					$k = $datumi[1];
					$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
				}
				else 
				{
					$this->load->helper("periodi");
					$datumi = getYear($this->input->post("year"), $this->serverZone, $this->USAzone);
					$p = $datumi[0];
					$k = $datumi[1];
					$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
					$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
				}
			}
		if($tiper_id)
		{
			if(!$procenti) //prikazuev se poeni
			{
				if($period || $this->input->post("month") || $this->input->post("week"))
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
						(SELECT SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
						if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o 
						INNER JOIN natprevari n ON n.id=o.natprevar_id
						INNER JOIN kolo AS k ON k.id=n.kolo_id
						INNER JOIN sezona AS s ON s.id=k.sezona_id
						INNER JOIN sampionati AS l ON l.id=s.sampionat_id
						WHERE tipuvac_id=t.id$uslov) AS dobivka,
						(SELECT COUNT(id) FROM sledenje WHERE tipuvac_id=$tiper_id 
							AND sledi_tipuvac=t.id) AS sleden
						FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, oblozi DESC";
				else 
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
						(SELECT 100 + SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
						if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o 
						INNER JOIN natprevari n ON n.id=o.natprevar_id
						INNER JOIN kolo AS k ON k.id=n.kolo_id
						INNER JOIN sezona AS s ON s.id=k.sezona_id
						INNER JOIN sampionati AS l ON l.id=s.sampionat_id
						WHERE tipuvac_id=t.id$uslov) AS dobivka,
						(SELECT COUNT(id) FROM sledenje WHERE tipuvac_id=$tiper_id 
							AND sledi_tipuvac=t.id) AS sleden
						FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, oblozi DESC";
			}
			else //prikazuev se procenti
			{
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
					(SELECT SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1), 0))/SUM(if(o.uspesen IS NOT NULL, o.ulog, 0)) FROM oblozi o
					INNER JOIN natprevari n ON n.id=o.natprevar_id
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE tipuvac_id=t.id$uslov) AS dobivka,
					(SELECT COUNT(id) FROM sledenje WHERE tipuvac_id=$tiper_id
						AND sledi_tipuvac=t.id) AS sleden
					FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, oblozi DESC";
			}
			$lista = $this->db->query($sql)->result();
			echo '<div style="display:none">';
			echo count($lista)." => ".$sql;
			echo '</div>';
			if(!$procenti)
				$this->renderLeaderboard($lista);
			else 
				$this->renderLeaderboardProcent($lista);
		}
	}
	function follow()
	{
		// tipuvac_id, sledi_tipuvac, od_datum
		$tiper_id = $this->user->id;
		$sledi = $this->input->post('sledi');
		$sega = new DateTime("now", new DateTimeZone($this->serverZone));
		if($sledi)
		{
			$this->load->model('settings');
			$limit = $this->settings->getObjects();
			$proverka = $this->db->query(
										"SELECT * FROM sledenje WHERE tipuvac_id=" . $tiper_id .
										 " AND sledi_tipuvac=" . $sledi);
			if($proverka->num_rows() == 0)
			{
				$proverka = $this->db->query("SELECT * FROM sledenje WHERE tipuvac_id=" . $tiper_id);
				// proverka dali sledi pomalko od dozvoleni broj na igraci
				if($proverka->num_rows() < $limit->sledi)
				{
					$sql = "INSERT INTO sledenje (tipuvac_id,sledi_tipuvac, od_datum)
										VALUES (" . $tiper_id . "," . $sledi . ",'" .
					 $sega->format("Y-m-d H:i:s") . "')";
					$this->db->query($sql);
					if($this->db->affected_rows() > 0)
						echo 1;
				}
			}
		}
	}
	function unfollow()
	{
		$tiper_id = $this->user->id;
		$sledi = $this->input->post('sledi');
		if($sledi)
		{
			$sql = "DELETE FROM sledenje WHERE tipuvac_id=" . $tiper_id . " AND sledi_tipuvac=" .
				 $sledi;
			$this->db->query($sql);
			if($this->db->affected_rows() > 0)
				echo 1;
			return;
		}
	}
	function sampionati()
	{
		$sql = "SELECT id, ime FROM sampionati WHERE sport_id=" . $this->input->post("id") .
			 " ORDER BY ime ASC";
		$sampionati = $this->db->query($sql)->result();
		?>
<option value="0" selected="selected">All championships</option>
<?php
		foreach($sampionati as $t)
		:
			?>
<option value="<?php echo $t->id;?>"><?php echo $t->ime;?></option>
<?php
		endforeach
		;
	}
	function favorite()
	{
		$tiper_id = $this->user->id;
		$sport_id = $this->input->post('sport_id');
		$liga_id = $this->input->post('liga_id');
		$tim_id = $this->input->post('tim_id');
		
		$sql = "";
		
		if($sport_id)
			$sql = "INSERT INTO fav_sport (tipuvac_id, sport_id) VALUES (" . $tiper_id . ", " .
				 $sport_id . ")";
		elseif($liga_id)
			$sql = "INSERT INTO fav_sampionat (tipuvac_id, sampionat_id) VALUES (" . $tiper_id . ", " .
				 $liga_id . ")";
		elseif($tim_id)
			$sql = "INSERT INTO fav_tim (tipuvac_id, tim_id) VALUES (" . $tiper_id . ", " . $tim_id .
				 ")";
		if(! $sql)
			return;
		$this->db->query($sql);
		if($this->db->affected_rows() > 0)
			echo 1;
	}
	function unfavorite()
	{
		$tiper_id = $this->user->id;
		$sport_id = $this->input->post('sport_id');
		$liga_id = $this->input->post('liga_id');
		$tim_id = $this->input->post('tim_id');
		
		$sql = "";
		
		if($sport_id)
			$sql = "DELETE FROM fav_sport WHERE tipuvac_id=" . $tiper_id . " AND sport_id=" .
				 $sport_id;
		elseif($liga_id)
			$sql = "DELETE FROM fav_sampionat WHERE tipuvac_id=" . $tiper_id . " AND sampionat_id=" .
				 $liga_id;
		elseif($tim_id)
			$sql = "DELETE FROM fav_tim WHERE tipuvac_id=" . $tiper_id . " AND tim_id=" . $tim_id;
		if(! $sql)
			return;
		$this->db->query($sql);
		if($this->db->affected_rows() > 0)
			echo 1;
	}
	function mybets()
	{
		$id = $this->user->id;
		$uslovBr = (int) $this->input->post('filter1');
		$sortBr = (int) $this->input->post('filter2');
		//$sega = new DateTime("now", new DateTimeZone($this->user->timezone));
		$timeAmerika = new DateTimeZone($this->USAzone);
		$timeServer = new DateTimeZone($this->serverZone);
		$sega = new DateTime('now', $timeAmerika);//vreme u ameriku
		$vremeOd = $sega->format('Y-m-d').' 00:00:00';
		$vremeDo = $sega->format('Y-m-d').' 23:59:59';
		$pocetno = new DateTime($vremeOd, $timeAmerika);
		$pocetno->setTimezone($timeServer);
		$krajno = new DateTime($vremeDo, $timeAmerika);
		$krajno->setTimezone($timeServer);
		$uslov = "";
		switch($uslovBr)
		{
			case 1:
				$uslov = " AND o.uspesen IS NULL";
				break;
			
			case 2:
				$uslov = " AND o.uspesen=1";
				break;
			
			case 3:
				$uslov = " AND o.uspesen=0";
				break;
			
			case 4://today
				//$uslov = " AND o.datum LIKE '" . $sega->format("Y-m-d") . "%'";
				$uslov .= " AND n.kraj >= '" . $pocetno->format('Y-m-d H:i:s') . "'";
				$uslov .= " AND n.kraj < '" . $krajno->format('Y-m-d H:i:s') . "'";
				break;
			
			case 5://month
				//$uslov = " AND o.datum LIKE '" . $sega->format("Y-m") . "%'";
				$this->load->helper("periodi");
				$datumi = getMonth($sega->format("m"), $sega->format("Y"), $this->serverZone, $this->USAzone);
				$p = $datumi[0];
				$k = $datumi[1];
				$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
				$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
				break;
			
			case 6://year
				//$uslov = " AND o.datum LIKE '" . $sega->format("Y") . "%'";
				$this->load->helper("periodi");
				$datumi = getYear($sega->format("Y"), $this->serverZone, $this->USAzone);
				$p = $datumi[0];
				$k = $datumi[1];
				$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
				$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
				break;
			
			default:
				$uslov = "";
				break;
		}
		switch($sortBr)
		{
			case 1:
				$sort = " ORDER BY o.koeficient ASC, n.id DESC";
				break;
			
			case 2:
				$sort = " ORDER BY o.koeficient DESC, n.id DESC";
				break;
			
			case 3:
				$sort = " ORDER BY dobivka DESC, n.id DESC";
				break;
			
			case 4:
				$sort = " ORDER BY dobivka ASC, n.id DESC";
				break;
			
			default:
				$sort = " ORDER BY n.kraj DESC, n.id DESC";
				break;
		}
		$sega->setTimezone(new DateTimeZone($this->serverZone));
		$sql = "SELECT o.id, o.datum, o.tip, o.ulog, o.koeficient, o.uspesen, d.ime AS domasni,
				d.kratenka AS domasniKratko, g.ime AS gosti, g.kratenka AS gostiKratko, o.saldo,
				n.domasni4, n.gosti4, n.domasni2, n.gosti2, n.pocetok, n.kraj, l.ime AS sampionat,
				o.izvesten, CASE WHEN n.gosti4 IS NOT NULL AND n.gosti2 IS NOT NULL AND n.domasni4 IS NOT NULL AND n.domasni2 IS NOT NULL
				THEN 'Closed' WHEN n.kraj < '" . $sega->format("Y-m-d H:i:s") .
			 "' THEN 'Finished' WHEN n.pocetok < '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.kraj > '" .
			 $sega->format("Y-m-d H:i:s") . "' THEN 'Live' ELSE 'Open' END  AS status,
				n.id AS natprevar_id, if (o.uspesen=1, round(o.ulog*o.koeficient, 1), 0) AS dobivka
				FROM oblozi AS o
				INNER JOIN natprevari AS n ON n.id=o.natprevar_id
				INNER JOIN timovi AS d ON d.id=n.domasni
				INNER JOIN timovi AS g ON g.id=n.gosti
				INNER JOIN kolo AS k ON n.kolo_id=k.id
				INNER JOIN sezona AS s ON s.id=k.sezona_id
				INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				WHERE o.tipuvac_id=" . $id . $uslov . $sort;
		$lista = $this->db->query($sql)->result();
		?>
<table id="mybetstable">
	<thead>
		<tr>
			<th id="col1">Match</th>
			<th id="col2">Result</th>
			<th id="col3">Tip</th>
			<th id="col4">Coef</th>
			<th id="col5">Bet</th>
			<th id="col6">Gain</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$aktivenDatum = new DateTime('now', $timeAmerika);
		$aktivenDatum->modify('+1 month');
		$prv = 0;
		//$format = "l, d.m.Y";
		foreach ($lista as $o):
			$datum = new DateTime($o->pocetok, $timeServer);
			$datum->setTimezone($timeAmerika);
			if($aktivenDatum->format($format) != $datum->format($format)):
				$aktivenDatum = $datum;
				if($prv > 0):
			?>
			<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
			<?php endif;?>
			<tr>
			<td id="coldate" colspan="6"><?php echo $aktivenDatum->format("l, d M")?></td>
		</tr>
			<?php
			$prv++;
			endif;
			?>
			<tr
			<?php if(is_numeric($o->uspesen))
					echo ($o->uspesen)?' class="won"':' class="missed"';?>>
				<?php if($o->domasniKratko && $o->gostiKratko):?>
				<td id="col1">
					<?php echo $o->domasniKratko.' - '.$o->gostiKratko; ?>
					<input id="natprevar_id" value="<?php echo $o->natprevar_id;?>" type="hidden">
				</td>
				<?php else:?>
				<td id="col1">
					<?php echo substr($o->domasni, 0, 3).'. - '.substr($o->gosti, 0, 3)."."; ?>
					<input id="natprevar_id" value="<?php echo $o->natprevar_id;?>" type="hidden">
				</td>
				<?php endif;?>
				<td id="col2"><?php echo ($o->domasni4 && $o->gosti4)?$o->domasni4.':'.$o->gosti4:''; ?></td>
			<td id="col3"><?php 
				switch ($o->tip)
				{
					case "hf1":
						echo "1-1";
						break;
					case "hf2";
						echo "1-X";
						break;
					case "hf3":
						echo "1-2";
						break;
					case "hf4":
						echo "X-1";
						break;
					case "hf5":
						echo "X-X";
						break;
					case "hf6":
						echo "X-2";
						break;
					case "hf7":
						echo "2-1";
						break;
					case "hf8":
						echo "2-X";
						break;
					case "hf9":
						echo "2-2";
						break;
					case "g1":
						echo 'Goals 0 or 1';
						break;
					case "g2":
						echo 'Goals 2 or 3';
						break;
					case "g3":
						echo 'Goals 4 to 6';
						break;
					case "g4":
						echo 'Goals 7+';
						break;
					case "u":
						echo 'G0-2';
						break;
					case "o":
						echo 'G3+';
						break;
					case "0":
						echo "X";
						break;
					default:
						echo $o->tip; 
						break;
				}
				?></td>
			<td id="col4"><?php echo $o->koeficient; ?></td>
			<td id="col5">-<?php echo $o->ulog; ?></td>
			<td id="col6"><?php echo ($o->status=="Closed")?$o->dobivka:''; ?></td>
		</tr>
			<?php
		endforeach;
		?>
		</tbody>
</table>
<script type="text/javascript">
$('td#col1').click(function(){
	$.ajax({
		url: "<?php echo base_url()."pajax/detaliNatprevar"?>",
		type: "POST",
		data: {id: $(this).find('#natprevar_id').val()},
		success: function(data)
		{
			$("#dialog").html(data);
		    $("#dialog").dialog('open');
		}
	});
});
</script>
<?php
	}
	function bets()
	{
		$id = $this->input->post('id');
		$uslovBr = (int) $this->input->post('filter1');
		$sortBr = (int) $this->input->post('filter2');
		//$sega = new DateTime("now", new DateTimeZone($this->user->timezone));
		$timeAmerika = new DateTimeZone($this->USAzone);
		$timeServer = new DateTimeZone($this->serverZone);
		$sega = new DateTime('now', $timeAmerika);//vreme u ameriku
		$vremeOd = $sega->format('Y-m-d').' 00:00:00';
		$vremeDo = $sega->format('Y-m-d').' 23:59:59';
		$pocetno = new DateTime($vremeOd, $timeAmerika);
		$pocetno->setTimezone($timeServer);
		$krajno = new DateTime($vremeDo, $timeAmerika);
		$krajno->setTimezone($timeServer);
		$uslov = "";
		switch($uslovBr)
		{
			case 1:
				$uslov = " AND o.uspesen IS NULL";
				break;
			
			case 2:
				$uslov = " AND o.uspesen=1";
				break;
			
			case 3:
				$uslov = " AND o.uspesen=0";
				break;
			
			case 4://today
				//$uslov = " AND o.datum LIKE '" . $sega->format("Y-m-d") . "%'";
				$uslov .= " AND n.kraj >= '" . $pocetno->format('Y-m-d H:i:s') . "'";
				$uslov .= " AND n.kraj < '" . $krajno->format('Y-m-d H:i:s') . "'";
				break;
			
			case 5://month
				//$uslov = " AND o.datum LIKE '" . $sega->format("Y-m") . "%'";
				$this->load->helper("periodi");
				$datumi = getMonth($sega->format("m"), $sega->format("Y"), $this->serverZone, $this->USAzone);
				$p = $datumi[0];
				$k = $datumi[1];
				$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
				$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
				break;
			
			case 6://year
				//$uslov = " AND o.datum LIKE '" . $sega->format("Y") . "%'";
				$this->load->helper("periodi");
				$datumi = getYear($sega->format("Y"), $this->serverZone, $this->USAzone);
				$p = $datumi[0];
				$k = $datumi[1];
				$uslov .= " AND n.kraj >= '" . $p->format('Y-m-d H:i:s') . "'";
				$uslov .= " AND n.kraj < '" . $k->format('Y-m-d H:i:s') . "'";
				break;
			
			default:
				$uslov = "";
				break;
		}
		switch($sortBr)
		{
			case 1:
				$sort = " ORDER BY o.koeficient ASC, n.id DESC";
				break;
			
			case 2:
				$sort = " ORDER BY o.koeficient DESC, n.id DESC";
				break;
			
			case 3:
				$sort = " ORDER BY dobivka DESC, n.id DESC";
				break;
			
			case 4:
				$sort = " ORDER BY dobivka ASC, n.id DESC";
				break;
			
			default:
				$sort = " ORDER BY n.kraj DESC, n.id DESC";
				break;
		}
		$sega->setTimezone(new DateTimeZone($this->serverZone));
		$sql = "SELECT o.id, o.datum, o.tip, o.ulog, o.koeficient, o.uspesen, d.ime AS domasni,
				d.kratenka AS domasniKratko, g.ime AS gosti, g.kratenka AS gostiKratko, o.saldo,
				n.domasni4, n.gosti4, n.domasni2, n.gosti2, n.pocetok, n.kraj, l.ime AS sampionat,
				o.izvesten, CASE WHEN n.gosti4 IS NOT NULL AND n.gosti2 IS NOT NULL AND n.domasni4 IS NOT NULL AND n.domasni2 IS NOT NULL
				THEN 'Closed' WHEN n.kraj < '" . $sega->format("Y-m-d H:i:s") .
			 "' THEN 'Finished' WHEN n.pocetok < '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.kraj > '" .
			 $sega->format("Y-m-d H:i:s") . "' THEN 'Live' ELSE 'Open' END  AS status,
				n.id AS natprevar_id, if (o.uspesen=1, round(o.ulog*o.koeficient, 1), 0) AS dobivka
				FROM oblozi AS o
				INNER JOIN natprevari AS n ON n.id=o.natprevar_id
				INNER JOIN timovi AS d ON d.id=n.domasni
				INNER JOIN timovi AS g ON g.id=n.gosti
				INNER JOIN kolo AS k ON n.kolo_id=k.id
				INNER JOIN sezona AS s ON s.id=k.sezona_id
				INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				WHERE o.tipuvac_id=" . $id . $uslov . $sort;
		$lista = $this->db->query($sql)->result();
		?>
<table id="mybetstable">
	<thead>
		<tr>
			<th id="col1">Match</th>
			<th id="col2">Result</th>
			<th id="col3">Tip</th>
			<th id="col4">Coef</th>
			<th id="col5">Bet</th>
			<th id="col6">Gain</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$aktivenDatum = new DateTime('now', $timeAmerika);
		$aktivenDatum->modify('+1 month');
		$prv = 0;
		$format = "d.m.Y";
		foreach ($lista as $o):
			$datum = new DateTime($o->pocetok, $timeServer);
			$datum->setTimezone($timeAmerika);
			if($aktivenDatum->format($format) != $datum->format($format)):
				$aktivenDatum = $datum;
				if($prv > 0):
			?>
			<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
			<?php endif;?>
			<tr>
			<td id="coldate" colspan="6"><?php echo $aktivenDatum->format("d M")?></td>
		</tr>
			<?php
			$prv++;
			endif;
			?>
			<tr
			<?php if(is_numeric($o->uspesen))
					echo ($o->uspesen)?' class="won"':' class="missed"';?>>
				<?php if($o->domasniKratko && $o->gostiKratko):?>
				<td id="col1">
					<?php echo $o->domasniKratko.' - '.$o->gostiKratko; ?>
					<input id="natprevar_id" value="<?php echo $o->natprevar_id;?>" type="hidden">
				</td>
				<?php else:?>
				<td id="col1">
					<?php echo substr($o->domasni, 0, 3).'. - '.substr($o->gosti, 0, 3)."."; ?>
					<input id="natprevar_id" value="<?php echo $o->natprevar_id;?>" type="hidden">
				</td>
				<?php endif;?>
				<td id="col2"><?php echo ($o->domasni4 && $o->gosti4)?$o->domasni4.':'.$o->gosti4:''; ?></td>
			<td id="col3"><?php 
				switch ($o->tip)
				{
					case "hf1":
						echo "1-1";
						break;
					case "hf2";
						echo "1-X";
						break;
					case "hf3":
						echo "1-2";
						break;
					case "hf4":
						echo "X-1";
						break;
					case "hf5":
						echo "X-X";
						break;
					case "hf6":
						echo "X-2";
						break;
					case "hf7":
						echo "2-1";
						break;
					case "hf8":
						echo "2-X";
						break;
					case "hf9":
						echo "2-2";
						break;
					case "g1":
						echo 'Goals 0 or 1';
						break;
					case "g2":
						echo 'Goals 2 or 3';
						break;
					case "g3":
						echo 'Goals 4 to 6';
						break;
					case "g4":
						echo 'Goals 7+';
						break;
					case "u":
						echo 'G0-2';
						break;
					case "o":
						echo 'G3+';
						break;
					case "0":
						echo "X";
						break;
					default:
						echo $o->tip; 
						break;
				}
				?></td>
			<td id="col4"><?php echo $o->koeficient; ?></td>
			<td id="col5">-<?php echo $o->ulog; ?></td>
			<td id="col6"><?php echo ($o->status=="Closed")?$o->dobivka:''; ?></td>
		</tr>
			<?php
		endforeach;
		?>
		</tbody>
</table>
<script type="text/javascript">
$('td#col1').click(function(){
	$.ajax({
		url: "<?php echo base_url()."pajax/detaliNatprevar"?>",
		type: "POST",
		data: {id: $(this).find('#natprevar_id').val()},
		success: function(data)
		{
			$("#dialog").html(data);
		    $("#dialog").dialog('open');
		}
	});
});
</script>
<?php
	}
	function championships()
	{
		$id = $this->user->id;
		$sport = (int) $this->input->post('sport_id');
		$drzava = (int) $this->input->post('drzava_id');
		$uslov = "";
		if($sport || $drzava)
		{
			$uslov = " WHERE ";
			if($sport)
				$uslov .= " sport_id=" . $sport . " AND";
			if($drzava)
				$uslov .= " drzava_id=" . $drzava . " AND";
			$uslov = substr($uslov, 0, strlen($uslov) - 4);
		}
		$sql = "SELECT id, ime, (SELECT COUNT(id) FROM fav_sampionat WHERE tipuvac_id=" . $id . "
					AND sampionat_id = s.id) AS fav	FROM sampionati AS s" . $uslov;
		$lista = $this->db->query($sql)->result();
		?>
<table id="tablelist" style="margin: 0px;">
	<tbody><?php
		foreach($lista as $o)
		:
			?>
				<tr>
			<td id="col1"><?php
			if(file_exists('images/leagues/item_' . $o->id . '.png'))
			:
				?><img
				src="<?php echo base_url().'images/leagues/item_'.$o->id.'.png';?>">
					<?php endif;?></td>
			<td id="col2"><?php echo $o->ime; ?></td>
		</tr><?php endforeach;?>
			</tbody>
</table><?php
	}
	function teams()
	{
		$id = $this->user->id;
		$sport = (int) $this->input->post('sport_id');
		$drzava = (int) $this->input->post('drzava_id');
		$uslov = "";
		if($sport || $drzava)
		{
			$uslov = " WHERE ";
			if($sport)
				$uslov .= " sport_id=" . $sport . " AND";
			if($drzava)
				$uslov .= " drzava_id=" . $drzava . " AND";
			$uslov = substr($uslov, 0, strlen($uslov) - 4);
		}
		$sql = "SELECT id, ime, (SELECT COUNT(id) FROM fav_tim WHERE tipuvac_id=" . $id . "
					AND tim_id = s.id) AS fav	FROM timovi AS s" . $uslov;
		$lista = $this->db->query($sql)->result();
		?>
<table id="tablelist" style="margin: 0px;">
	<tbody><?php
		foreach ($lista as $o): ?>
			<tr>
			<td id="col1"><?php 
				if(file_exists('images/teams/item_'.$o->id.'.png')):
				?><img
				src="<?php echo base_url().'images/teams/item_'.$o->id.'.png';?>">
				<?php endif;?></td>
			<td id="col2"><?php echo $o->ime; ?></td>
			<td id="col3">
				<div style="position: relative;"
					class="star<?php echo ($o->fav)?' favstar':''; ?>"></div> <input
				type="hidden" id="team_id" value="<?php echo $o->id; ?>">
			</td>
		</tr><?php endforeach;?>
		</tbody>
</table><?php
	}
	function more()
	{
		$nat_id = $this->input->post('id');
		if($nat_id)
		{
			$sql = "SELECT prvprv, prvx, prvvtor, xprv, xx, xvtor, vtorprv, vtorx, vtorvtor,
				golovi0do1, golovi2do3, golovi4do6, golovi7plus, un, ov FROM coeficienti 
				WHERE natprevar_id=" . $nat_id;
			$data = array_shift($this->db->query($sql)->result());
			if(! is_object($data))
				return;
			?>
<table id="moreOption" style="margin: 0;">
	<tbody>
		<?php
			
			if($data->prvprv > 1 && $data->prvx > 1 && $data->prvvtor > 1 && $data->xprv > 1 &&
			 $data->xx > 1 && $data->xvtor > 1 && $data->vtorprv > 1 && $data->vtorx > 1 &&
			 $data->vtorvtor > 1)
			:
				?>
		<tr>
			<td>1-1 (Odd: <?php echo $data->prvprv;?>)<input type="hidden"
				id="tip" value="hf1"><input id="koef" type="hidden"
				value="<?php echo $data->prvprv;?>"></td>
		</tr>
		<tr>
			<td>1-X (Odd: <?php echo $data->prvx;?>)<input type="hidden"
				id="tip" value="hf2"><input id="koef" type="hidden"
				value="<?php echo $data->prvx;?>"></td>
		</tr>
		<tr>
			<td>1-2 (Odd: <?php echo $data->prvvtor;?>)<input
				type="hidden" id="tip" value="hf3"><input id="koef" type="hidden"
				value="<?php echo $data->prvvtor;?>"></td>
		</tr>
		<tr>
			<td>X-1 (Odd: <?php echo $data->xprv;?>)<input type="hidden"
				id="tip" value="hf4"><input id="koef" type="hidden"
				value="<?php echo $data->xprv;?>"></td>
		</tr>
		<tr>
			<td>X-X (Odd: <?php echo $data->xx;?>)<input type="hidden"
				id="tip" value="hf5"><input id="koef" type="hidden"
				value="<?php echo $data->xx;?>"></td>
		</tr>
		<tr>
			<td>X-2 (Odd: <?php echo $data->xvtor;?>)<input type="hidden"
				id="tip" value="hf6"><input id="koef" type="hidden"
				value="<?php echo $data->xvtor;?>"></td>
		</tr>
		<tr>
			<td>2-1 (Odd: <?php echo $data->vtorprv;?>)<input
				type="hidden" id="tip" value="hf7"><input id="koef" type="hidden"
				value="<?php echo $data->vtorprv;?>"></td>
		</tr>
		<tr>
			<td>2-X (Odd: <?php echo $data->vtorx;?>)<input type="hidden"
				id="tip" value="hf8"><input id="koef" type="hidden"
				value="<?php echo $data->vtorx;?>"></td>
		</tr>
		<tr>
			<td>2-2 (Odd: <?php echo $data->vtorvtor;?>)<input
				type="hidden" id="tip" value="hf9"><input id="koef" type="hidden"
				value="<?php echo $data->vtorvtor;?>"></td>
		</tr>
		<tr><td></td></tr>
		<?php endif;?>
		<?php
			
			if($data->golovi0do1 > 1 && $data->golovi2do3 > 1 && $data->golovi4do6 > 1 &&
			 $data->golovi7plus > 1)
			:
				?>
		<tr>
			<td>Goals 0 to 1 (Odd: <?php echo $data->golovi0do1;?>)<input
				type="hidden" id="tip" value="g1"><input id="koef" type="hidden"
				value="<?php echo $data->golovi0do1;?>"></td>
		</tr>
		<tr>
			<td>Goals 2 to 3 (Odd: <?php echo $data->golovi2do3;?>)<input
				type="hidden" id="tip" value="g2"><input id="koef" type="hidden"
				value="<?php echo $data->golovi2do3;?>"></td>
		</tr>
		<tr>
			<td>Goals 4 to 6 (Odd: <?php echo $data->golovi4do6;?>)<input
				type="hidden" id="tip" value="g3"><input id="koef" type="hidden"
				value="<?php echo $data->golovi4do6;?>"></td>
		</tr>
		<tr>
			<td>Goals 7+ (Odd: <?php echo $data->golovi7plus;?>)<input
				type="hidden" id="tip" value="g4"><input id="koef" type="hidden"
				value="<?php echo $data->golovi7plus;?>"></td>
		</tr>
		<tr><td></td></tr>
		<?php endif;?>
		<?php if($data->ov>1 && $data->un>1):?>
		<tr>
			<td>0-2 Goals (Odd: <?php echo $data->un;?>)<input
				type="hidden" id="tip" value="u"><input id="koef" type="hidden"
				value="<?php echo $data->un;?>"></td>
		</tr>
		<tr>
			<td>3+ Goals (Odd: <?php echo $data->ov;?>)<input
				type="hidden" id="tip" value="o"><input id="koef" type="hidden"
				value="<?php echo $data->ov;?>"></td>
		</tr>
		<?php endif;?>
	</tbody>
</table>
<?php
		}
	}
	private function renderLeaderboard($lista)
	{
		?>
<table id="leaderboard">
	<tbody>
		<?php 
		$rang = 0;
		foreach ($lista as $t):
			if(is_numeric($t->oblozi) && $t->oblozi > 0):
			$rang++;
		?>
		<tr>
			<td id="col1"<?php echo ($t->oblozi<5)?' style="color: #333;"':'';?>>#<?php echo $rang;?></td>
			<td id="col2"><a style="color: #FFF;" href="<?php echo base_url('leaderboard/balance/'.$t->id);?>"><?php 
				echo $t->fname.' '.$t->lname; ?></a></td>
			<td id="col3"><?php echo $t->dobivka; ?></td>
			<td id="col4">
			<?php if($this->user->id != $t->id):?>
				<img class="unfollow"<?php 
					echo ($t->sleden)?' style="display: block; cursor: pointer;"':' style="display: none; cursor: pointer;"';
				?> src="/images/followBtnSelected.png">
				<img class="follow"<?php 
					echo ($t->sleden)?' style="display: none; cursor: pointer;"':' style="display: block; cursor: pointer;"';
				?> src="/images/followBtn.png">
				<input type="hidden" id="tiper_id" value="<?php echo $t->id; ?>">
			<?php endif; ?>
			</td>
		</tr>
		<?php endif; 
		endforeach;?>
	</tbody>
</table>
<?php
	}
	private function renderLeaderboardProcent($lista)
	{
		?>
<table id="leaderboard">
	<tbody>
		<?php 
		$rang = 0;
		foreach ($lista as $t):
			if(is_numeric($t->oblozi) && $t->oblozi > 0):
		$rang++;?>
		<tr>
			<td id="col1"<?php echo ($t->oblozi<5)?' style="color: #333;"':'';?>>#<?php echo $rang;?></td>
			<td id="col2"><a style="color: #FFF;" href="<?php echo base_url('leaderboard/balance/'.$t->id);?>"><?php 
				echo $t->fname.' '.$t->lname; ?></a></td>
			<td id="col3"><?php echo round($t->dobivka,2)*100; ?> %</td>
			<td id="col4">
			<?php if($this->user->id != $t->id):?>
				<img class="unfollow"<?php 
					echo ($t->sleden)?' style="display: block; cursor: pointer;"':' style="display: none; cursor: pointer;"';
				?> src="/images/followBtnSelected.png">
				<img class="follow"<?php 
					echo ($t->sleden)?' style="display: none; cursor: pointer;"':' style="display: block; cursor: pointer;"';
				?> src="/images/followBtn.png">
				<input type="hidden" id="tiper_id" value="<?php echo $t->id; ?>">
			<?php endif; ?>
			</td>
		</tr>
		<?php endif; 
		endforeach;?>
	</tbody>
</table>
<?php
	}
	private function renderMatch($t)
	{
		?>
<div class="matchDiv">
	<input type="hidden" id="match_id" value="<?php echo $t->id; ?>">
	<div id="pocetok">
		<p><?php 
			$denes = new DateTime("now", new DateTimeZone($this->user->timezone));
			$utre = new DateTime("now", new DateTimeZone($this->user->timezone));
			$utre->modify('+1 day');
			$datum = new DateTime($t->pocetok, new DateTimeZone($this->serverZone));
			$datum->setTimezone(new DateTimeZone($this->user->timezone));
			if($denes->format("Y-m-d")==$datum->format("Y-m-d"))
				echo "Today, ".$datum->format("H:i");
			elseif($utre->format("Y-m-d")==$datum->format("Y-m-d"))
				echo "Tomorrow, ".$datum->format("H:i");
			else 
				echo $datum->format("d M, H:i");// ' Y'
			?></p>
	</div>
	<div class="match">
		<div
			class="home<?php echo (isset($t->tip) && $t->tip=="1")?' tipperSelected':'';
				?>">
					<?php if(file_exists('./images/teams/item_'.$t->domasniID.'.png')):?>
					<img
				src="<?php echo base_url();?>images/teams/item_<?php echo $t->domasniID; ?>.png"
				id="hometeam">
					<?php endif;?>
					<input type="hidden" id="koeficient"
				value="<?php echo $t->home; ?>"> <span class="tim"><?php echo $t->domasni; ?></span>
			<span class="koeficient"><?php 
						echo number_format($t->home, 2, ',','.'); ?></span>
		</div><?php if($t->draw == 1): ?>
				<div class="drawHolder"></div><?php else:?>
				<div
			class="draw<?php echo (isset($t->tip) && $t->tip=="0")?' tipperSelected':'';
				?>">
			<span class="koeficient"><?php 
						echo number_format($t->draw, 2, ',','.'); ?></span><br>draw <input
				type="hidden" id="koeficient" value="<?php echo $t->draw; ?>">
		</div><?php endif;?>
				<div
			class="away<?php echo (isset($t->tip) && $t->tip=="2")?' tipperSelected':'';
				?>">
					<?php if(file_exists('./images/teams/item_'.$t->gostiID.'.png')):?>
					<img
				src="<?php echo base_url();?>images/teams/item_<?php echo $t->gostiID; ?>.png"
				id="awayteam">
					<?php endif;?>
					<input type="hidden" id="koeficient"
				value="<?php echo $t->away; ?>"> <span class="tim"><?php echo $t->gosti; ?></span>
			<span class="koeficient"><?php 
						echo number_format($t->away, 2, ',','.'); ?></span>
		</div>
	</div>
			<?php if(isset($t->fname) || $t->more): ?>
			<div class="tipperInfo">
				<?php 
				if(isset($t->tip) && $t->tip != "0" && $t->tip != "1" && $t->tip != "2")
				{
					echo $t->fname."'s tip for this match: ";
					switch ($t->tip)
					{
						case "hf1":
							echo "1-1";
							break;
						case "hf2";
						echo "1-X";
						break;
						case "hf3":
							echo "1-2";
							break;
						case "hf4":
							echo "X-1";
							break;
						case "hf5":
							echo "X-X";
							break;
						case "hf6":
							echo "X-2";
							break;
						case "hf7":
							echo "2-1";
							break;
						case "hf8":
							echo "2-X";
							break;
						case "hf9":
							echo "2-2";
							break;
						case "g1":
							echo 'Goals 0 or 1';
							break;
						case "g2":
							echo 'Goals 2 or 3';
							break;
						case "g3":
							echo 'Goals 4 to 6';
							break;
						case "g4":
							echo 'Goals 7+';
							break;
						case "u":
							echo '0-2 Goals';
							break;
						case "o":
							echo '3+ Goals';
							break;
					}
					echo " (Odd: ".number_format($t->koeficient, 2, ',','.').")<br>";
				}
				echo (isset($t->fname))?'from top tipper, #'.$t->rang.' '.$t->fname.' '.$t->lname.
						', B'.$t->saldo.'<br>':'';
				if($t->more):?>
				<button class="moreBtn">More</button>
				<?php endif;?>
			</div>
			<?php endif; ?>
		</div><?php
	}
	private function renderMatches($lista, $polok = '')
	{
		foreach($lista as $t)
		{
			?>
<div class="matchDiv">
	<input type="hidden" id="match_id" value="<?php echo $t->id; ?>">
	<div id="pocetok">
		<p><?php 
			$denes = new DateTime("now", new DateTimeZone($this->user->timezone));
			$utre = new DateTime("now", new DateTimeZone($this->user->timezone));
			$utre->modify('+1 day');
			$datum = new DateTime($t->pocetok, new DateTimeZone($this->serverZone));
			$datum->setTimezone(new DateTimeZone($this->user->timezone));
			if($denes->format("Y-m-d")==$datum->format("Y-m-d"))
				echo "Today, ".$datum->format("H:i");
			elseif($utre->format("Y-m-d")==$datum->format("Y-m-d"))
				echo "Tomorrow, ".$datum->format("H:i");
			else 
				echo $datum->format("d M, H:i");// ' Y'
			?></p>
	</div>
	<div class="match">
		<div
			class="home<?php echo (isset($t->tip) && $t->tip=="1")?' tipperSelected':'';
				?>">
					<?php if(file_exists('./images/teams/item_'.$t->domasniID.'.png')):?>
					<img
				src="<?php echo base_url();?>images/teams/item_<?php echo $t->domasniID; ?>.png"
				id="hometeam">
					<?php endif;?>
					<input type="hidden" id="koeficient"
				value="<?php echo $t->home; ?>"> <span class="tim"><?php echo $t->domasni; ?></span>
			<span class="koeficient"><?php 
						echo number_format($t->home, 2, ',','.'); ?></span>
		</div><?php if($t->draw == 1): ?>
				<div class="drawHolder"></div><?php else:?>
				<div
			class="draw<?php echo (isset($t->tip) && $t->tip=="0")?' tipperSelected':'';
				?>">
			<span class="koeficient"><?php 
						echo number_format($t->draw, 2, ',','.'); ?></span><br>draw <input
				type="hidden" id="koeficient" value="<?php echo $t->draw; ?>">
		</div><?php endif;?>
				<div
			class="away<?php echo (isset($t->tip) && $t->tip=="2")?' tipperSelected':'';
				?>">
					<?php if(file_exists('./images/teams/item_'.$t->gostiID.'.png')):?>
					<img
				src="<?php echo base_url();?>images/teams/item_<?php echo $t->gostiID; ?>.png"
				id="awayteam">
					<?php endif;?>
					<input type="hidden" id="koeficient"
				value="<?php echo $t->away; ?>"> <span class="tim"><?php echo $t->gosti; ?></span>
			<span class="koeficient"><?php 
						echo number_format($t->away, 2, ',','.'); ?></span>
		</div>
	</div>
			<?php if(isset($t->fname) || $t->more): ?>
			<div class="tipperInfo">
				<?php 
				if(isset($t->tip) && $t->tip != "0" && $t->tip != "1" && $t->tip != "2")
				{
					echo $t->fname."'s tip for this match: ";
					switch ($t->tip)
					{
						case "hf1":
							echo "1-1";
							break;
						case "hf2";
						echo "1-X";
						break;
						case "hf3":
							echo "1-2";
							break;
						case "hf4":
							echo "X-1";
							break;
						case "hf5":
							echo "X-X";
							break;
						case "hf6":
							echo "X-2";
							break;
						case "hf7":
							echo "2-1";
							break;
						case "hf8":
							echo "2-X";
							break;
						case "hf9":
							echo "2-2";
							break;
						case "g1":
							echo 'Goals 0 or 1';
							break;
						case "g2":
							echo 'Goals 2 or 3';
							break;
						case "g3":
							echo 'Goals 4 to 6';
							break;
						case "g4":
							echo 'Goals 7+';
							break;
						case "u":
							echo '0-2 Goals';
							break;
						case "o":
							echo '3+ Goals';
							break;
					}
					echo " (Odd: ".number_format($t->koeficient, 2, ',','.').")<br>";
				}
				if($polok=="following")
					$tttt = "following";
				else
					$tttt = "top";
				echo (isset($t->fname))?'from '.$tttt.' tipper, #'.$t->rang.' '.$t->fname.' '.$t->lname.', B'.$t->saldo.'<br>':'';
				if($t->more):?>
				<button class="moreBtn">More</button>
				<?php endif;?>
			</div>
			<?php endif; ?>
		</div><?php
		}
	}
}