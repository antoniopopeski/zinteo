<?php
class api extends CI_Controller
{
	private $limit;
	private $timezone = "America/Whitehorse";
	private $listanje_natprevari = "SELECT n.id, n.domasni AS domasniID, td.ime AS domasni, 
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
	function api()
	{
		parent::__construct();
		$this->load->model('korisnik');
		$this->load->model('greski');
		$this->load->model('settings');
		$this->limit = $this->settings->getObjects();
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
	}
	function index()
	{
		?>
<html>
<head>
<style type="text/css">
table,tr,td,th {
	border: 1px solid #999;
	border-collapse: collapse;
}

td {
	padding: 1px 3px;
}

th {
	background-color: #EEEEEE;
}

tr:nth-child(even) {
	background-color: #F0FDFD;
}
</style>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>funkcija</th>
				<th>post parametri</th>
				<th>odgovor</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>profil</td>
				<td>fb_id, username, fname, lname, timezone</td>
				<td>profil od bazata</td>
			</tr>
			<tr>
				<td>limits</td>
				<td></td>
				<td>vrakja lista na ogranicuvanja</td>
			</tr>
			<tr>
				<td>drzavi</td>
				<td></td>
				<td>lista na drzavi</td>
			</tr>
			<tr>
				<td>aktivirajKod</td>
				<td>id: tiper id, code: kod za aktivacija na bonus bids</td>
				<td>poraka za uspeh</td>
			</tr>
			<tr>
				<td>sefte</td>
				<td></td>
				<td>vrakja natprevar za pravenje na sefte</td>
			</tr>
			<tr>
				<td>sampionati</td>
				<td>sport_id: id na sport, liga_id: id na sampionat, drzava_id: id
					na drzava</td>
				<td>lista na sampionati</td>
			</tr>
			<tr>
				<td>timovi</td>
				<td>id: id na profil, sport_id: id na sport, liga_id: id na
					sampionat, drzava_id: id na drzava</td>
				<td>lista na aktivni timovi</td>
			</tr>
			<tr>
				<td>matchinfo</td>
				<td>id: na oblog</td>
				<td>site informacii za natprevarot</td>
			</tr>
			<tr>
				<td>postavifavtim</td>
				<td>id: na profil, tim_id: id na tim</td>
				<td>poraka za uspeh</td>
			</tr>
			<tr>
				<td>otstranifavtim</td>
				<td>id: na profil, tim_id: id na tim</td>
				<td>poraka za uspeh</td>
			</tr>
			<tr>
				<td>postavifavsport</td>
				<td>id: na profil, sport_id: id na sport</td>
				<td>poraka za uspeh</td>
			</tr>
			<tr>
				<td>otstranifavsport</td>
				<td>id: na profil, sport_id: id na sport</td>
				<td>poraka za uspeh</td>
			</tr>
			<tr>
				<td>sledninatprevari</td>
				<td>sport_id: id na sport, liga_id: id na sampionat, tim_id: id na
					tim, od: poceten datum, do: kraen datum, id: na profil</td>
				<td>lista na natprevari sto treba da pocnat vo narednite 72 casa</td>
			</tr>
			<tr>
				<td>postavioblog</td>
				<td>id: na profil, natprevar_id: id na natprevar, tip: 1/0/2,
					koeficient: izbran koeficient, ulog: vlozena suma</td>
				<td>lista na aktivni timovi</td>
			</tr>
			<tr>
				<td>status</td>
				<td>id na profil, sport_id: id na sport, liga_id: id na sampionat,
					tim_id: id na tim</td>
				<td>lista na broevi</td>
			</tr>
			<tr>
				<td>matchescount</td>
				<td>id na profil, sport_id: id na sport, liga_id: id na sampionat,
					tim_id: id na tim</td>
				<td>lista na broevi</td>
			</tr>
			<tr>
				<td>mybets</td>
				<td>id: na profil, filter1: uslov (1: nezavrsena ili bez status, 2:
					uspesni, 3: neuspesni, 4: denesni, 5: mesecni, 6: godisni),
					filter2: sort (1: koeficient ASC, 2: koeficient DESC, 3: saldo ASC,
					4: saldo DESC, 5: datum DESC)</td>
				<td>lista na oblozi</td>
			</tr>
			<tr>
				<td>mesledat</td>
				<td>id: na profil</td>
				<td>lista na tiperi koi go sledat tiperot</td>
			</tr>
			<tr>
				<td>gisledam</td>
				<td>id: na profil</td>
				<td>lista na tiperi koi gi sledi tiperot</td>
			</tr>
			<tr>
				<td>bidsinfo</td>
				<td>id: na profil</td>
				<td>informacii za bids koi gi ima tiperot</td>
			</tr>
			<tr>
				<td>promenetioblozi</td>
				<td>id: na profil</td>
				<td>lista na oblozi koi se promeneti</td>
			</tr>
			<tr>
				<td>balans</td>
				<td>id: na profil</td>
				<td>informacii za screen mybalance</td>
			</tr>
			<tr>
				<td>reg_pokani</td>
				<td>id: na profil, fb_id_array: array od fb_id, request_id: id na
					baranjeto (ovie vrednosti se del od odgovorot na facebook api)</td>
				<td>poraka za primanje na podatocite</td>
			</tr>
			<tr>
				<td>reg_objava</td>
				<td>id: na profil koj ima uspesno napraveno objava na fb</td>
				<td>poraka za uspeh</td>
			</tr>
			<tr>
				<td>recomended</td>
				<td>id: na profil, sport_id: id na sport, liga_id: id na sampionat,
					tim_id: id na tim</td>
				<td>lista na preporacani natprevari</td>
			</tr>
			<tr>
				<td>favorites</td>
				<td>id: na profil, sport_id: id na sport, liga_id: id na sampionat,
					tim_id: id na tim</td>
				<td>lista na favorit natprevari</td>
			</tr>
			<tr>
				<td>following</td>
				<td>id: na profil, sport_id: id na sport, liga_id: id na sampionat,
					tim_id: id na tim</td>
				<td>lista na natprevari igrani od tiperi koi se sledat</td>
			</tr>
			<tr>
				<td>followingcount</td>
				<td>id: na profil, sport_id: id na sport, liga_id: id na sampionat,
					tim_id: id na tim</td>
				<td>broj na natprevari igrani od tiperi koi se sledat</td>
			</tr>
			<tr>
				<td>najpopularni</td>
				<td>id: na profil, sport_id: id na sport, liga_id: id na sampionat,
					tim_id: id na tim</td>
				<td>lista na najpopularni natprevari</td>
			</tr>
			<tr>
				<td>toptimovicount</td>
				<td>id: na profil, sport_id: id na sport, liga_id: id na sampionat,
					tim_id: id na tim</td>
				<td>broj na natprevari kade nekoj tim e top</td>
			</tr>
			<tr>
				<td>toptimovi</td>
				<td>id: na profil, sport_id: id na sport, liga_id: id na sampionat,
					tim_id: id na tim</td>
				<td>lista na natprevari kade nekoj tim e top</td>
			</tr>
			<tr>
				<td>follow</td>
				<td>id: na profil, sledi: id na tiper za sledenje</td>
				<td>poraka za uspeh</td>
			</tr>
			<tr>
				<td>unfollow</td>
				<td>id: na profil, sledi: id na tiper za sledenje</td>
				<td>poraka za uspeh</td>
			</tr>
			<tr>
				<td>rangiranje</td>
				<td>id: na profil, sport_id: id na sport, pocetok i kraj: datum
					format 2013-01-25, skip: kolku strani da skokne (0,1,2)</td>
				<td>rang lista spored osvoeni poeni</td>
			</tr>
		</tbody>
	</table>
</body>
</html>
<?php
	}
	function drzavi()
	{
		$sql = "SELECT id, ime FROM drzavi ORDER BY redosled DESC, id DESC";
		$this->query($sql);
	}
	function sefte()
	{
		$id = (int) $this->input->post('id');
		$greska = $this->greski->oneObject(1)->poraka;
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify("+7 day");
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
				$this->random($sql . " ORDER BY n.pocetok ASC", $broj);
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
					$this->random($sql . " ORDER BY n.pocetok ASC", $broj);
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
						$this->random($sql . " ORDER BY brojOblozi DESC, n.pocetok ASC", $broj);
					}
				}
			}
		}
		else
			$this->respond($greska, 400);
	}
	function rangiranje()
	{
		$uslov = "";
		$tiper_id = $this->input->post('id');
		$this->load->model('korisnik');
		$tiper = $this->korisnik->oneObject($tiper_id);
		$skip = (int) $this->input->post('skip');
		$skip = 20 * $skip;
		$sport_id = (int) $this->input->post('sport_id');
		$post_pocetok = $this->input->post('pocetok');
		$post_kraj = $this->input->post('kraj');
		$pocetok = new DateTime($post_pocetok, new DateTimeZone($this->timezone)); // $tiper->timezone));
		$kraj = new DateTime($post_kraj, new DateTimeZone($this->timezone)); // $tiper->timezone));
		$denes = new DateTime('now', new DateTimeZone($tiper->timezone));
		$greska = $this->greski->oneObject(1)->poraka;
		/*
		 * print_r($pocetok); echo "<br>"; print_r($kraj);
		 */
		
		$format = "Y-m-d";
		
		if($sport_id)
			$uslov .= " AND l.sport_id = " . $sport_id;
		if($post_pocetok && $post_kraj)
			$uslov .= " AND (n.kraj BETWEEN '" . $pocetok->format($format) . " 00:00:00'
					AND '" . $kraj->format($format) . " 23:59:59')";
		elseif($post_pocetok)
			$uslov .= " AND (n.kraj BETWEEN '" . $pocetok->format($format) . " 00:00:00'
					AND '" . $denes->format($format) . " 23:59:59')";
		elseif($post_kraj)
			$uslov .= " AND (n.kraj BETWEEN '2010-01-01 00:00:00'
					AND '" . $kraj->format($format) . " 23:59:59')";
		else
			$uslov .= " AND (n.kraj BETWEEN '2010-01-01 00:00:00'
					AND '" . $denes->format("Y") . "-12-31 23:59:59')";
		if($tiper_id)
		{
			if($post_kraj || $post_pocetok)
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
					FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, saldo DESC
					LIMIT $skip, 20";
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
					FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, saldo DESC
					LIMIT $skip, 20";
				// echo $sql;
			$this->query($sql);
		}
		else
			$this->respond($greska, 400);
	}
	function follow()
	{
		// tipuvac_id, sledi_tipuvac, od_datum
		$greska = $this->greski->oneObject(1)->poraka;
		$tiper_id = $this->input->post('id');
		$sledi = $this->input->post('sledi');
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		if($tiper_id)
		{
			$proverka = $this->db->query(
										"SELECT * FROM sledenje WHERE tipuvac_id=" . $tiper_id .
										 " AND sledi_tipuvac=" . $sledi);
			if($proverka->num_rows() == 0)
			{
				$proverka = $this->db->query("SELECT * FROM sledenje WHERE tipuvac_id=" . $tiper_id);
				// proverka dali sledi pomalko od dozvoleni broj na igraci
				if($proverka->num_rows() < $this->limit->sledi)
				{
					$sql = "INSERT INTO sledenje (tipuvac_id,sledi_tipuvac, od_datum)
										VALUES (" . $tiper_id . "," . $sledi . ",'" .
					 $sega->format("Y-m-d H:i:s") . "')";
					$this->insert($sql);
				}
				else
					$this->respond("dostignat limit", 400);
			}
			else
				$this->respond("postoi zapis");
		}
		else
			$this->respond($greska, 400);
	}
	function unfollow()
	{
		$id = $this->input->post('id');
		$sledi = $this->input->post('sledi');
		$sql = "DELETE FROM sledenje WHERE tipuvac_id=" . $id . " AND sledi_tipuvac=" . $sledi;
		$this->updel($sql);
	}
	function sportovi()
	{
		$id = $this->input->post('id');
		if($id)
			$sql = "SELECT DISTINCT(id), ime, top, (SELECT COUNT(DISTINCT(id)) FROM fav_sport WHERE sport_id=s.id AND 
					tipuvac_id=" . $id . ") AS favorite FROM sportovi AS s WHERE aktiven=1 
					ORDER BY redosled ASC, ime ASC";
		else
			$sql = "SELECT id, ime, top, 0 AS favorite FROM sportovi AS s WHERE aktiven=1 
					ORDER BY redosled ASC, ime ASC;";
		$this->query($sql);
	}
	function sampionati()
	{
		$sport_id = (int) $this->input->post('sport_id');
		$drzava_id = (int) $this->input->post('drzava_id');
		$id = $this->input->post('id');
		
		$uslov = "";
		if($sport_id)
			$uslov .= " AND l.sport_id=" . $sport_id;
		if($drzava_id)
			$uslov .= " AND l.drzava_id=" . $drzava_id;
		if($id)
			$sql = "SELECT DISTINCT(l.id), l.ime, l.top, s.ime AS sport, d.ime AS drzava,
				(SELECT COUNT(DISTINCT(id)) FROM fav_sampionat WHERE sampionat_id=l.id AND 
					tipuvac_id=" . $id . ") AS favorite
				FROM sampionati AS l 
				INNER JOIN sportovi AS s ON l.sport_id=s.id
				LEFT JOIN drzavi AS d ON l.drzava_id=d.id
				WHERE l.aktiven=1" . $uslov .
				 " ORDER BY l.top DESC, l.ime ASC";
		else
			$sql = "SELECT DISTINCT(l.id), l.ime, l.top, s.ime AS sport, d.ime AS drzava,
				0 AS favorite FROM sampionati AS l
				INNER JOIN sportovi AS s ON l.sport_id=s.id
				LEFT JOIN drzavi AS d ON l.drzava_id=d.id
				WHERE l.aktiven=1" . $uslov .
				 " ORDER BY l.top DESC, l.ime ASC";
			// $this->respond($sql);
		$this->query($sql);
	}
	function timovi()
	{
		$tiper_id = (int) $this->input->post('id');
		$tip = (int) $this->input->post('tip');
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		$drzava_id = (int) $this->input->post('drzava_id');
		$uslov = "";
		
		if($sport_id || $liga_id || $drzava_id || $tip)
		{
			$uslov = " WHERE ";
			if($tip)
				$uslov .= "t.tip=" . $tip . " AND ";
			if($sport_id)
				$uslov .= "t.sport_id=" . $sport_id . " AND ";
			if($liga_id)
				$uslov .= "s.id=" . $liga_id . " AND ";
			if($drzava_id)
				$uslov .= "t.drzava_id=" . $drzava_id . " AND ";
			
			$uslov = trim($uslov, " AND ");
		}
		if($tiper_id)
			$sql = "SELECT DISTINCT(t.id), TRIM(CONCAT_WS(' ', t.ime, t.grad)) AS ime, t.kratenka, t.top,
				(SELECT COUNT(DISTINCT(id)) FROM fav_tim WHERE tim_id=t.id AND tipuvac_id=" .
				 $tiper_id . ") AS favorite FROM timovi AS t
				INNER JOIN sezona_tim AS st ON st.tim_id=t.id INNER JOIN sezona AS s ON st.sezona_id=s.id
				" . $uslov . " ORDER BY top DESC, ime ASC";
		else
			$sql = "SELECT DISTINCT(t.id), TRIM(CONCAT_WS(' ', t.ime, t.grad)) AS ime, t.kratenka, t.top,
				0 AS favorite FROM timovi AS t
				INNER JOIN sezona_tim AS st ON st.tim_id=t.id INNER JOIN sezona AS s ON st.sezona_id=s.id
				" . $uslov . " ORDER BY top DESC, ime ASC";
		$this->query($sql);
	}
	function postavifavtim()
	{
		$tiper_id = $this->input->post('id');
		$greskaTiper = $this->greski->oneObject(1)->poraka;
		$greskaZapis = $this->greski->oneObject(7)->poraka;
		$greskaLimit = $this->greski->oneObject(8)->poraka;
		if($tiper_id)
		{
			$tim_id = $this->input->post('tim_id');
			
			$proverka = $this->db->query(
										"SELECT * FROM fav_tim WHERE tipuvac_id=" . $tiper_id .
										 " AND tim_id=" . $tim_id);
			if($proverka->num_rows() == 0)
			{
				$proverka = $this->db->query("SELECT * FROM fav_tim WHERE tipuvac_id=" . $tiper_id);
				if($proverka->num_rows() < $this->limit->favtim)
				{
					$sql = "INSERT INTO fav_tim (tim_id,tipuvac_id) VALUES (" . $tim_id . "," .
					 $tiper_id . ")";
					$this->insert($sql);
				}
				else
					$this->respond($greskaLimit, 400);
			}
			else
				$this->respond($greskaZapis, 400);
		}
		else
			$this->respond($greskaTiper, 400);
	}
	function postavifavsport()
	{
		$tiper_id = $this->input->post('id');
		$greskaTiper = $this->greski->oneObject(1)->poraka;
		$greskaZapis = $this->greski->oneObject(7)->poraka;
		$greskaLimit = $this->greski->oneObject(8)->poraka;
		if($tiper_id)
		{
			$sport_id = $this->input->post('sport_id');
			$proverka = $this->db->query(
										"SELECT * FROM fav_sport WHERE tipuvac_id=" . $tiper_id .
										 " AND sport_id=" . $sport_id);
			if($proverka->num_rows() == 0)
			{
				
				$proverka = $this->db->query(
											"SELECT * FROM fav_sport WHERE tipuvac_id=" . $tiper_id);
				if($proverka->num_rows() < $this->limit->favsport)
				{
					$sql = "INSERT INTO fav_sport (sport_id,tipuvac_id) VALUES (" . $sport_id . "," .
					 $tiper_id . ")";
					$this->insert($sql);
				}
				else
					$this->respond($greskaLimit, 400);
			}
			else
				$this->respond($greskaZapis, 400);
		}
		else
			$this->respond($greskaTiper, 400);
	}
	function postavifavsampionat()
	{
		$tiper_id = $this->input->post('id');
		$greskaTiper = $this->greski->oneObject(1)->poraka;
		$greskaZapis = $this->greski->oneObject(7)->poraka;
		$greskaLimit = $this->greski->oneObject(8)->poraka;
		
		if($tiper_id)
		{
			$sampionat_id = $this->input->post('liga_id');
			$proverka = $this->db->query(
										"SELECT * FROM fav_sampionat WHERE tipuvac_id=" . $tiper_id .
										 " AND sampionat_id=" . $sampionat_id);
			if($proverka->num_rows() == 0)
			{
				$proverka = $this->db->query(
											"SELECT * FROM fav_sampionat WHERE tipuvac_id=" .
											 $tiper_id);
				if($proverka->num_rows() < $this->limit->favsampionat)
				{
					$sql = "INSERT INTO fav_sampionat (sampionat_id,tipuvac_id)
										VALUES (" . $sampionat_id . "," . $tiper_id . ")";
					$this->insert($sql);
				}
				else
					$this->respond($greskaLimit, 400);
			}
			else
				$this->respond($greskaZapis, 400);
		}
		else
			$this->respond($greskaTiper, 400);
	}
	function otstranifavtim()
	{
		$id = $this->input->post('id');
		$tim_id = $this->input->post('tim_id');
		$sql = "DELETE FROM fav_tim WHERE tipuvac_id=" . $id . " AND tim_id=" . $tim_id;
		$this->updel($sql);
	}
	function otstranifavsport()
	{
		$id = $this->input->post('id');
		$sport_id = $this->input->post('sport_id');
		$sql = "DELETE FROM fav_sport WHERE tipuvac_id=" . $id . " AND sport_id=" . $sport_id;
		$this->updel($sql);
	}
	function otstranifavsampionat()
	{
		$tiper_id = (int) $this->input->post('id');
		$sampionat_id = (int) $this->input->post('liga_id');
		$sql = "DELETE FROM fav_sampionat WHERE tipuvac_id=" . $tiper_id . " AND sampionat_id=" .
			 $sampionat_id;
		$this->updel($sql);
	}
	function otstranifavdrzava()
	{
		$id = $this->input->post('id');
		$sql = "DELETE FROM fav_drzava WHERE id=" . $id;
		$this->updel($sql);
	}
	function sledninatprevari()
	{
		$id = $this->input->post('id');
		$sport = $this->input->post('sport_id');
		$liga = $this->input->post('liga_id');
		$tim_id = (int) $this->input->post('tim_id');
		$min = $this->input->post('od');
		$max = $this->input->post('do');
		$greska = $this->greski->oneObject(1)->poraka;
		
		if($id)
		{
			$timezone = "Europe/Skopje";
			$sega = new DateTime("now", new DateTimeZone($timezone));
			$posle = new DateTime("now", new DateTimeZone($timezone));
			$posle->modify($this->limit->recent . " day");
			$uslov = "";
			if($min && $max)
				$uslov = " AND n.pocetok > '" . $min . "' AND n.pocetok < '" . $max . "'";
			else
				$uslov = "AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'";
			
			if($sport)
				$uslov .= " AND l.sport_id=" . $sport;
			if($liga)
				$uslov .= " AND l.id=" . $liga;
			if($tim_id)
				$uslov .= " AND (n.domasni=" . $tim_id . " OR n.gosti=" . $tim_id . ")";
			$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" .
				 $id . " AND 
				natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" . $id . " AND 
				natprevar_id=n.id) AS igrano" . $this->join_natprevari .
				 " WHERE n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' 
				AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
				ORDER BY n.pocetok ASC, td.top DESC, tg.top DESC";
			$this->query($sql);
		}
		else
			$this->respond($greska, 400);
	}
	function postavioblog()
	{
		$greska = $this->greski->oneObject(1)->poraka;
		$greskaZapis = $this->greski->oneObject(7)->poraka;
		$greskaBids = $this->greski->oneObject(9)->poraka;
		$greskaSaldo = $this->greski->oneObject(10)->poraka;
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$tiper_id = $this->input->post('id');
		if(!$tiper_id)
		{
			$this->respond($greska, 400);
			return;
		}
		
		$natprevar_id = $this->input->post('natprevar_id');
		$tip = $this->input->post('tip');
		$ulog = $this->input->post('ulog');
		$koeficient = $this->input->post('koeficient');
		if(! $ulog)
			$ulog = 10;
		if(! $koeficient)
			$koeficient = 1;
		
		$tiper = $this->korisnik->oneObject($tiper_id);
		if($tiper->bids == 0 && $tiper->tmpBids == 0)
			$this->respond($greskaBids, 400);
		if($tiper->saldo < $ulog)
			$this->respond($greskaSaldo, 400);
		
		switch($tip)
		{
			case 'half 1 full 1':
				$pravTip = "hf1";
				break;
			case 'half 1 full 0':
				$pravTip = "hf2";
				break;
			case 'half 1 full 2':
				$pravTip = "hf3";
				break;
			case 'half 0 full 1':
				$pravTip = "hf4";
				break;
			case 'half 0 full 0':
				$pravTip = "hf5";
				break;
			case 'half 0 full 2':
				$pravTip = "hf6";
				break;
			case 'half 2 full 1':
				$pravTip = "hf7";
				break;
			case 'half 2 full 0':
				$pravTip = "hf8";
				break;
			case 'half 2 full 2':
				$pravTip = "hf9";
				break;
			case 'goals 0 or 1':
				$pravTip = "g1";
				break;
			case 'goals 2 or 3':
				$pravTip = "g2";
				break;
			case 'goals 4 to 6':
				$pravTip = "g3";
				break;
			case 'goals 7+':
				$pravTip = "g4";
				break;
			case 'under':
				$pravTip = "u";
				break;
			case 'over':
				$pravTip = "o";
				break;
			default:
				$pravTip = $tip;
				break;
		}
		
		$natprevar_id = $this->input->post('natprevar_id');
		$proverka = $this->db->query(
									"SELECT * FROM oblozi WHERE tipuvac_id=" . $tiper_id .
									 " AND natprevar_id=" . $natprevar_id);
		if($proverka->num_rows() == 0)
		{
			$sql = "INSERT INTO oblozi (natprevar_id, tipuvac_id, datum, tip, ulog, koeficient, saldo, izvesten)
					VALUES (" . $natprevar_id . "," . $tiper->id . ",'" .
			 $sega->format("Y-m-d H:i:s") . "','" . $pravTip . "'," . $ulog . "," . $koeficient .
			 ",'" . $tiper->saldo . "', 1)";
			$this->insert($sql, $tiper, $ulog);
		}
		else
			$this->respond($greskaZapis, 400);
	}
	function aktivirajKod()
	{
		$greskaAktivacija = $this->greski->oneObject(4)->poraka;
		$greskaIskoristen = $this->greski->oneObject(5)->poraka;
		$greskaTiper = $this->greski->oneObject(1)->poraka;
		
		$tiper_id = $this->input->post('id');
		$code = $this->input->post('code');
		if($tiper_id && $code)
		{
			$sql = "SELECT COUNT(id) AS broj FROM tiketi WHERE tipuvac_id=" . $tiper_id .
			 " AND code='" . $code . "' AND aktiviran > '0000-00-00 00:00:00'";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			if($red->broj == 0)
			{
				$this->load->model('tiket');
				$tiket = $this->tiket->oneObject(
												"tipuvac_id=" . $tiper_id . " AND code='" . $code .
												 "'");
				$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
				$tiket->aktiviran = $sega->format("Y-m-d H:i:s");
				if($this->tiket->update($tiket, $tiket->id))
				{
					$this->respond("aktivacijata e uspesna");
					$tiper = $this->korisnik->oneObject($tiper_id);
					$tiper->bids += $tiket->bids;
					$this->korisnik->update($tiper, $tiper_id);
				}
				else
					$this->respond($greskaAktivacija, 400);
			}
			else
				$this->respond($greskaIskoristen, 400);
		}
		else
			$this->respond($greskaTiper, 400);
	}
	function mybetscount()
	{
		$tiper_id = (int) $this->input->post('id');
		$uslovBr = (int) $this->input->post('filter1');
		$sortBr = (int) $this->input->post('filter2');
		$uslov = "";
		$greska = $this->greski->oneObject(1)->poraka;
		
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
			
			case 4:
				$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
				$uslov = " AND o.datum LIKE '" . $sega->format("Y-m-d") . "%'";
				break;
			
			case 5:
				$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
				$uslov = " AND o.datum LIKE '" . $sega->format("Y-m") . "%'";
				break;
			
			case 6:
				$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
				$uslov = " AND o.datum LIKE '" . $sega->format("Y") . "%'";
				break;
			
			default:
				$uslov = "";
				break;
		}
		switch($sortBr)
		{
			case 1:
				$sort = " ORDER BY o.koeficient ASC";
				break;
			
			case 2:
				$sort = " ORDER BY o.koeficient DESC";
				break;
			
			case 3:
				$sort = " ORDER BY o.saldo DESC";
				break;
			
			case 4:
				$sort = " ORDER BY o.saldo ASC";
				break;
			
			default:
				$sort = " ORDER BY o.datum DESC";
				break;
		}
		if($tiper_id)
		{
			$sql = "SELECT COUNT(DISTINCT(o.id)) AS broj FROM oblozi AS o
					INNER JOIN natprevari AS n ON n.id=o.natprevar_id
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					INNER JOIN timovi AS d ON d.id=n.domasni
					INNER JOIN timovi AS g ON g.id=n.gosti INNER JOIN kolo AS k ON n.kolo_id=k.id
					INNER JOIN sezona AS s ON s.id=k.sezona_id 
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE o.tipuvac_id=" . $tiper_id . $uslov . $sort;
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$this->respondBroj((int) $red->broj);
		}
		else
			$this->respond($greska, 400);
	}
	function mybets()
	{
		$id = (int) $this->input->post('id');
		$uslovBr = (int) $this->input->post('filter1');
		$sortBr = (int) $this->input->post('filter2');
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$uslov = "";
		$greska = $this->greski->oneObject(1)->poraka;
		
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
			
			case 4:
				$uslov = " AND o.datum LIKE '" . $sega->format("Y-m-d") . "%'";
				break;
			
			case 5:
				$uslov = " AND o.datum LIKE '" . $sega->format("Y-m") . "%'";
				break;
			
			case 6:
				$uslov = " AND o.datum LIKE '" . $sega->format("Y") . "%'";
				break;
			
			default:
				$uslov = "";
				break;
		}
		switch($sortBr)
		{
			case 1:
				$sort = " ORDER BY o.koeficient ASC";
				break;
			
			case 2:
				$sort = " ORDER BY o.koeficient DESC";
				break;
			
			case 3:
				$sort = " ORDER BY dobivka DESC";
				break;
			
			case 4:
				$sort = " ORDER BY dobivka ASC";
				break;
			
			default:
				$sort = " ORDER BY o.ID DESC";
				break;
		}
		if($id)
		{
			$sql = "SELECT o.id, o.datum, o.tip, o.ulog, o.koeficient, o.uspesen, d.ime AS domasni,
				d.kratenka AS domaK, g.ime AS gosti, g.kratenka AS gostiK, o.saldo, n.domasni4,
				n.gosti4, n.domasni2, n.gosti2, n.pocetok, n.kraj, l.ime AS sampionat, o.izvesten,
				CASE WHEN n.gosti4 IS NOT NULL AND n.gosti2 IS NOT NULL AND n.domasni4 IS NOT NULL
				AND n.domasni2 IS NOT NULL THEN 'Closed' WHEN n.kraj < '" .
				 $sega->format("Y-m-d H:i:s") . "' THEN 'Finished' WHEN n.pocetok < '" .
				 $sega->format("Y-m-d H:i:s") . "' 
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
			$this->query($sql);
			// $lista = $this->db->query($sql);
			// $this->repackRespond($lista->result_array());
		}
		else
			$this->respond($greska, 400);
	}
	function youwon()
	{
		$id = (int) $this->input->post('id');
		$sega = new DateTime('now', new DateTimeZone('Europe/Skopje'));
		$greska = $this->greski->oneObject(1)->poraka;
		if($id)
		{
			$sql = "SELECT o.id, o.datum, o.tip, o.ulog, o.koeficient, o.uspesen, d.ime AS domasni,
				d.kratenka AS domaK, g.ime AS gosti, g.kratenka AS gostiK, o.saldo, n.domasni4,
				n.gosti4, n.domasni2, n.gosti2, n.pocetok, n.kraj, l.ime AS sampionat, o.izvesten,
				CASE WHEN n.gosti4 IS NOT NULL AND n.gosti2 IS NOT NULL AND n.domasni4 IS NOT NULL
				AND n.domasni2 IS NOT NULL THEN 'Closed' WHEN n.kraj < '" .
				 $sega->format("Y-m-d H:i:s") . "' THEN 'Finished' WHEN n.pocetok < '" .
				 $sega->format("Y-m-d H:i:s") . "' 
				AND n.kraj > '" .
				 $sega->format("Y-m-d H:i:s") . "' THEN 'Live' ELSE 'Open' END  AS status,
				n.id AS natprevar_id, if (o.uspesen=1, round(o.ulog*o.koeficient, 1), 0) AS dobivka
				FROM oblozi AS o INNER JOIN natprevari AS n ON n.id=o.natprevar_id
				INNER JOIN coeficienti AS c ON c.natprevar_id=n.id INNER JOIN timovi AS d ON d.id=n.domasni
				INNER JOIN timovi AS g ON g.id=n.gosti INNER JOIN kolo AS k ON n.kolo_id=k.id
				INNER JOIN sezona AS s ON s.id=k.sezona_id
				INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				WHERE o.tipuvac_id=" . $id . " AND o.izvesten=0";
			$this->query($sql);
		}
		else 
			$this->respond($greska, 400);
	}
	function bidsinfo()
	{
		$greska = $this->greski->oneObject(1)->poraka;
		$id = (int) $this->input->post('id');
		if($id)
		{
			$tiper = $this->korisnik->oneObject($id);
			$format = "Y-m-d";
			$sega = new DateTime("now", new DateTimeZone($tiper->timezone));
			$sql = "SELECT startBids,(SELECT tiperi_pokaneti FROM tipuvaci WHERE id=" . $id . ")
				AS invited, COALESCE((SELECT bids FROM tiketi WHERE od <= '" .
				 $sega->format($format) . "' 
					AND do >= '" . $sega->format($format) . "' AND aktiviran > '0000-00-00'
					AND tipuvac_id=" . $id . "),0) AS promocode,
				(SELECT do FROM tiketi WHERE od <= '" . $sega->format($format) . "' 
					AND do >= '" . $sega->format($format) . "' AND aktiviran > '0000-00-00'
					AND tipuvac_id=" . $id . ") AS promoDate,
				(SELECT tmpBids FROM tipuvaci WHERE id=" . $id . ") AS temp,
				(SELECT bids + tmpBids FROM tipuvaci WHERE id=" . $id . ") AS remaining
				FROM settings";
			$this->query($sql);
		}
		else 
			$this->respond($greska, 400);
	}
	function promenetioblozi()
	{
		$id = (int) $this->input->post('id');
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$greska = $this->greski->oneObject(1)->poraka;
		
		if($id)
		{
			$sql = "SELECT o.id, o.datum, o.tip, o.ulog, o.koeficient, o.uspesen, d.ime AS domasni,
					g.ime AS gosti, o.saldo, n.domasni4, n.gosti4, n.domasni2, n.gosti2, n.pocetok, n.kraj, l.ime AS sampionat,
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
					WHERE o.izvesten=0 AND o.tipuvac_id=" . $id;
			$this->query($sql);
			$this->db->query("UPDATE oblozi SET izvesten=1 WHERE izvesten=0 AND tipuvac_id=" . $id);
		}
		else
			$this->respond($greska, 400);
	}
	function status()
	{
		$rezultat = array ();
		$tiper_id = (int) $this->input->post('id');
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify($this->limit->recent . " day");
		$greska = $this->greski->oneObject(1)->poraka;
		if($tiper_id)
		{
			$this->load->model('korisnik');
			$igrac = $this->korisnik->oneObject($tiper_id);
			
			$rezultat["bids"] = (int) $igrac->bids + (int) $igrac->tmpBids;
			
			$rezervirani = (int) $this->db->query(
												"SELECT SUM(ulog) AS broj FROM oblozi WHERE tipuvac_id=$tiper_id AND uspesen IS NULL")->row()->broj;
			
			$rezultat["balance"] = $igrac->saldo + $rezervirani;
			
			$rezultat["saldo"] = $igrac->saldo;
			
			$rezultat["invitefb"] = $igrac->bidsLimit;
			
			$sql = "SELECT COUNT(DISTINCT(o.id)) AS broj FROM oblozi AS o INNER JOIN natprevari AS n ON n.id=o.natprevar_id
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id INNER JOIN timovi AS d ON d.id=n.domasni
					INNER JOIN timovi AS g ON g.id=n.gosti INNER JOIN kolo AS k ON n.kolo_id=k.id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE o.tipuvac_id=" . $tiper_id . " AND izvesten=0";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["mybets"] = (int) $red->broj;
			// $this->db->query();
			
			$uslov = "";
			if($sport_id)
				$uslov .= " AND l.sport_id=" . $sport_id;
			if($liga_id)
				$uslov .= " AND l.id=" . $liga_id;
			
			$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj
					FROM natprevari AS n INNER JOIN timovi AS td ON td.id=n.domasni
					INNER JOIN timovi AS tg ON tg.id=n.gosti
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					INNER JOIN oblozi AS o ON o.natprevar_id=n.id
					INNER JOIN (SELECT @red := @red + 1 AS rang, t.fname, t.id, t.saldo FROM tipuvaci t,
					(SELECT @red := 0) r ORDER BY t.saldo DESC LIMIT " .
				 $this->limit->top . ") AS t
					WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
					n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
					AND n.vidliv < '" .
				 $sega->format("Y-m-d H:i:s") . "' AND t.id<>" . $tiper_id . $uslov . "
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $tiper_id . ")
					ORDER BY n.pocetok ASC";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["recomended"] = (int) $red->broj;
			
			$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj FROM natprevari AS n 
					INNER JOIN timovi AS td ON td.id=n.domasni
					INNER JOIN timovi AS tg ON tg.id=n.gosti
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					INNER JOIN kolo AS k ON n.kolo_id=k.id
					INNER JOIN sezona AS s ON s.id=k.sezona_id 
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					INNER JOIN sportovi AS x ON x.id=l.sport_id
					WHERE (n.domasni IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" . $tiper_id . ")
					OR n.gosti IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" . $tiper_id . "))
					AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
					AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
					AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
					ORDER BY n.pocetok ASC";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["favorite"] = (int) $red->broj;
			
			$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj
					FROM natprevari AS n INNER JOIN timovi AS td ON td.id=n.domasni
					INNER JOIN timovi AS tg ON tg.id=n.gosti
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
					n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
					AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $tiper_id . ")
					ORDER BY n.pocetok ASC";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["allmatches"] = (int) $red->broj;
			
			$this->respond($rezultat);
		}
		else
			$this->respond($greska, 400);
	}
	function matchescount()
	{
		$rezultat = array ();
		$tiper_id = (int) $this->input->post('id');
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify($this->limit->recent . " day");
		$greska = $this->greski->oneObject(1)->poraka;
		
		if($tiper_id)
		{
			$sql = "SELECT COUNT(DISTINCT(id)) AS broj FROM oblozi 
				WHERE tipuvac_id=" . $tiper_id . " AND uspesen IS NULL";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["nezatvoreni"] = (int) $red->broj;
			
			$sql = "SELECT COUNT(DISTINCT(id)) AS broj FROM oblozi
					WHERE tipuvac_id=" . $tiper_id;
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["mybets"] = (int) $red->broj;
			
			$uslov = "";
			if($sport_id)
				$uslov .= " AND l.sport_id=" . $sport_id;
			if($liga_id)
				$uslov .= " AND l.id=" . $liga_id;
			$sql = $this->broenje_natprevari . $this->join_natprevari .
				 "
				INNER JOIN oblozi AS o ON o.natprevar_id=n.id
				INNER JOIN (SELECT @red := @red + 1 AS rang, t.saldo, t.id
				FROM tipuvaci t, (SELECT @red := 0) r ORDER BY t.saldo DESC LIMIT " .
				 $this->limit->top . ") AS t
				WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" .
				 $sega->format("Y-m-d H:i:s") . "' AND t.id<>" . $tiper_id . $uslov . "
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $tiper_id . ")
				ORDER BY n.pocetok ASC";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["recomended"] = (int) $red->broj;
			
			$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj
					FROM natprevari AS n INNER JOIN timovi AS td ON td.id=n.domasni
					INNER JOIN timovi AS tg ON tg.id=n.gosti
					INNER JOIN kolo AS k ON k.id=n.kolo_id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
					n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
					AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'
					AND (td.top>0 OR tg.top>0)
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $tiper_id . ")
				ORDER BY n.pocetok ASC";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["topteam"] = (int) $red->broj;
			
			$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj FROM natprevari AS n
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					INNER JOIN kolo AS k ON n.kolo_id=k.id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					INNER JOIN sportovi AS x ON x.id=l.sport_id
					WHERE (n.domasni IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" . $tiper_id . ")
					OR n.gosti IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" . $tiper_id . "))
					AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
					AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
					AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" . $uslov . "
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $tiper_id . ")
					ORDER BY n.pocetok ASC";
			// (x.id IN (SELECT sport_id FROM fav_sport WHERE tipuvac_id=".$tiper_id.") OR
			// l.id IN (SELECT sampionat_id FROM fav_sampionat WHERE tipuvac_id=" . $tiper_id . ")
			// OR
			
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["favorite"] = (int) $red->broj;
			
			$sql = $this->broenje_natprevari . $this->join_natprevari . "
				INNER JOIN oblozi AS o ON o.natprevar_id=n.id
				WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "' AND
				n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
				AND o.tipuvac_id IN (SELECT sledi_tipuvac FROM sledenje WHERE tipuvac_id=" .
				 $tiper_id . ")
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $tiper_id .
				 ")";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["following"] = (int) $red->broj;
			
			$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj FROM natprevari AS n
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					INNER JOIN kolo AS k ON n.kolo_id=k.id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					INNER JOIN sportovi AS x ON x.id=l.sport_id
					WHERE n.pocetok LIKE '" . $sega->format("Y-m-d") . "%'
					AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
					AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" . $uslov . "
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $tiper_id . ")
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
					AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $tiper_id . ")
					ORDER BY n.pocetok ASC";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["recent"] = (int) $red->broj;
			
			$sql = "SELECT COUNT(DISTINCT(n.id)) AS broj, (SELECT COUNT(DISTINCT(id)) FROM oblozi 
					WHERE natprevar_id=n.id) AS brojOblozi FROM natprevari AS n
					INNER JOIN timovi AS td ON td.id=n.domasni
					INNER JOIN timovi AS tg ON tg.id=n.gosti
					INNER JOIN coeficienti AS c ON c.natprevar_id=n.id
					INNER JOIN kolo AS k ON n.kolo_id=k.id
					INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					INNER JOIN sportovi AS x ON x.id=l.sport_id
					WHERE n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
					AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
					AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" . $uslov . "
					AND n.id IN (SELECT DISTINCT(natprevar_id) FROM oblozi)
					AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $tiper_id . ")
					ORDER BY brojOblozi DESC, n.pocetok ASC";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$rezultat["popularni"] = (int) $red->broj;
			
			$this->respond($rezultat);
		}
		else
			$this->respond($greska, 400);
	}
	function profil()
	{
		$this->load->model('korisnik');
		$greska = $this->greski->oneObject(12)->poraka;
		$username = $this->input->post('username');
		$fb_id = $this->input->post('fb_id');
		$fname = $this->input->post('fname');
		$lname = $this->input->post('lname');
		$username = strtolower($fname . ' ' . $lname);
		$device = $this->input->post('device');
		$drzava = $this->input->post('drzava_id');
		$email = $this->input->post('email');
		$time = $this->input->post('timezone');
		if(! $username || ! $fb_id)
		{
			$this->respond($greska, 400);
			return;
		}
		if(! $time)
			$timezone = "Europe/Skopje";
		else 
			$timezone = $time;
		$profil = $this->korisnik->profil2($fb_id);
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		if(! $profil)
		{
			//if($fb_id && $username && $fname && $lname)
			$data = array ("fb_id" => $fb_id,"username" => $username,"fname" => $fname,
						"lname" => $lname,"device" => $device,"email" => $email,
						"timezone" => $timezone,"kreiran" => $sega->format("Y-m-d H:i:s"),
						"logiran" => $sega->format("Y-m-d H:i:s"),"drzava_id" => $drzava);
			$this->korisnik->insert($data);//*
			try
			{
				// Get the request details using Graph API
				$requests = $this->facebook->api("/" . $fb_id . "?fields=apprequests");
				if(isset($requests["apprequests"]))
				{
					$request_content = $requests["apprequests"]["data"];
					foreach($request_content as $b)
					{
						$this->config->load('Facebook', TRUE);
						if($b["application"]["id"] == $this->config->item('appId'))
						{
							try
							{
								$this->auth->delete_request($b["id"]);
							}
							catch(FacebookApiException $e)
							{
							}
							$from_id = $b["from"]["id"];
							if($from_id)
							{
								$sql = "UPDATE tipuvaci SET tiperi_pokaneti = tiperi_pokaneti + 1
								WHERE fb_id='" . $from_id . "'";
								$this->db->query($sql);
							}
						}
					}
				}
			}
			catch(Exception $error)
			{
			}//*/
		}
		else
		{
			$profil->logiran = $sega->format("Y-m-d H:i:s");
			if($fname && $profil->fname != $fname)
				$profil->fname = $fname;
			if($lname && $profil->lname != $lname)
				$profil->lname = $lname;
			if($email && $profil->email != $email)
				$profil->email = $email;
			if($device && $profil->device != $device)
				$profil->device = $device;
			if($drzava)
				$profil->drzava_id = $drzava;
			if($time && $time != $profil->timezone)
				$profil->timezone = $timezone;
			$this->korisnik->update($profil, $profil->id);
		}
		$sql = "SELECT t.*,(SELECT 100 + COALESCE(SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
					if(o.uspesen=0,0 - o.ulog, 0))),0) FROM oblozi o 
				WHERE tipuvac_id=t.id) AS dobivka
			FROM tipuvaci t WHERE username='" . $username . "'";
		$this->query($sql);
	}
	function balans()
	{
		$greska = $this->greski->oneObject(1)->poraka;
		// najde gi naj
		$updateSql = "UPDATE tipuvaci dest, (SELECT x.id, o.tipuvac_id, COUNT(o.id) as broj 
				FROM sportovi as x INNER JOIN timovi as t ON x.id=t.sport_id
			INNER JOIN natprevari as n ON n.domasni=t.id OR n.gosti=t.id
			RIGHT JOIN oblozi as o ON o.natprevar_id=n.id
			WHERE o.uspesen=1 GROUP BY o.tipuvac_id, x.id ORDER BY broj DESC) src 
			SET dest.sport_id = src.id WHERE dest.id=src.tipuvac_id";
		$this->db->query($updateSql);
		$id = $this->input->post('id');
		$format = "Y-m-d";
		// $id = 1;
		$this->load->model('korisnik');
		$user = $this->korisnik->oneObject($id);
		if($id)
		{
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
				(SELECT COUNT(id) FROM sledenje WHERE tipuvac_id=" . $user->id . "
					AND sledi_tipuvac=t.id) AS sleden
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC, saldo DESC)
				AS x ON x.id=t.id WHERE t.id=" . $user->id;
			
			$this->query($sql);
		}
		else
			$this->respond($greska, 400);
	}
	function reg_objava()
	{
		$id = $this->input->post('id');
		$greska = $this->greski->oneObject(1)->poraka;
		if($id)
		{
			$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			
			$this->db->query(
							"UPDATE tipuvaci SET bidsLimit = bidsLimit - 1,
					tmpBids = tmpBids + 1, tmpDatum='" .
							 $sega->format("Y-m-d") . "' WHERE id=" . $id);
			if($this->db->affected_rows() == 1)
				$this->respond("Izvrseno");
			else
				$this->respond("Greska", 400);
		}
		else
			$this->respond($greska, 400);
	}
	function inviteFB()
	{
		$this->load->model('korisnik');
		$tiper = $this->korisnik->oneObject($this->input->post('id'));
		$data = array ("invitefb" => $tiper->bidsLimit);
		$this->respond($data);
	}
	function postiraj()
	{
		$this->load->model('korisnik');
		$tiper = $this->korisnik->oneObject($this->input->post('id'));
		$message = $this->input->post("message");
		$greska = $this->greski->oneObject(1)->poraka;
		
		if($tiper && $message)
		{
			$access_token = $this->auth->get_access_token();
			$this->load->model("korisnik");
			$opis = "Zinteo - a place where tippers from all around the" .
					 " world can compete to each other on real sport matches." .
					 " All bets are money-free. Now. Tomorrow. Forever";
			try
			{
				$attachment = array ('access_token' => $access_token,
						'message' => $message,
						'link' => base_url(),
						'name' => "Zinteo - Social Betting Fantazy Game",
						'description' => $opis,
						'picture' => base_url('images/fb_pic.png'));
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 
							'https://graph.facebook.com/' . $tiper->fb_id . '/feed');
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // to suppress the curl output
				$postwall = json_decode(curl_exec($ch));
				curl_close($ch);
				if($postwall)
				{
					$sega = new DateTime("now", new DateTimeZone($user->timezone));
					/*
					 * if($this->user->tmpDatum == "0000-00-00") { $this->user->tmpDatum =
					 * $sega->format("Y-m-d"); $this->user->tmpBids += 2; } else
					 */
					{
						$user->tmpDatum = $sega->format("Y-m-d");
						$user->tmpBids += 1;
						$user->bidsLimit -= 1;
					}
					$this->korisnik->update($user, $user->id);
				}
				$this->recomended("executed");
			}
			catch(FacebookApiException $err)
			{
				$this->recomended($err->getMessage(), 400);
			}
		}
		else
		{
			$this->respond($greska, 400);
		}
	}
	function reg_pokani()
	{
		$tipuvac_id = $this->input->post('id');
		$pokaneti = explode('-', $this->input->post('fb_id_array'));
		$request_id = $this->input->post('request_id');
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$this->load->model("pokani");
		foreach($pokaneti as $pokanet)
		{
			$proverka = $this->db->query(
										"SELECT * FROM pokani WHERE pokanet=" . $pokanet .
										 " AND tipuvac_id=" . $tipuvac_id);
			if($proverka->num_rows() == 0)
			{
				$sql = "INSERT INTO pokani (pokanet, request_id, tipuvac_id, datum) VALUES ('" .
				 $pokanet . "','" . $request_id . "'," . $tipuvac_id . ",'" .
				 $sega->format("Y-m-d H:i:s") . "')";
				$this->db->query($sql);
			}
		}
		$this->respond("Data received");
	}
	function limits()
	{
		$sql = "SELECT sledi AS maxSledenje, pokani AS brojPokani, favsport AS maxFavSport,
				favsampionat AS maxFavSampionat, favtim AS maxFavTim, objava AS bonusFacebookObjava
				FROM settings";
		$this->query($sql);
	}
	function recomended()
	{
		$id = $this->input->post('id');
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		$tim_id = (int) $this->input->post('tim_id');
		$greska = $this->greski->oneObject(1)->poraka;
		
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify($this->limit->recent . " day");
		
		if($id)
		{
			$uslov = "";
			if($sport_id)
				$uslov .= " AND l.sport_id=" . $sport_id;
			if($liga_id)
				$uslov .= " AND l.id=" . $liga_id;
			if($tim_id)
				$uslov .= " AND (n.domasni=" . $tim_id . " OR n.gosti=" . $tim_id . ")";
			
			$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" .
				 $id . " AND 
				natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" . $id .
				 " AND 
				natprevar_id=n.id) AS igrano, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) 
				AS brojOblozi, t.fname, t.lname, t.username, o.tip, t.rang, t.dobivka AS saldo" .
				 $this->join_natprevari .
				 "
				INNER JOIN oblozi AS o ON o.natprevar_id=n.id
				INNER JOIN (SELECT id, @red := @red + 1 AS rang, fname, lname, username,
				(SELECT 100 + SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
						if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o
				WHERE tipuvac_id=t.id" . $uslov . ") AS dobivka
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC) AS t
				WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" .
				 $sega->format("Y-m-d H:i:s") . "' AND t.id<>" . $id . $uslov . "
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
				ORDER BY n.pocetok ASC, n.id ASC";
			
			$this->query($sql);
		}
		else
			$this->respond($greska, 400);
	}
	function following()
	{
		$id = $this->input->post('id');
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		$tim_id = (int) $this->input->post('tim_id');
		
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify($this->limit->recent . " day");
		$greska = $this->greski->oneObject(1)->poraka;
		
		if($id)
		{
			$uslov = "";
			if($sport_id)
				$uslov .= " AND l.sport_id=" . $sport_id;
			if($liga_id)
				$uslov .= " AND l.id=" . $liga_id;
			if($tim_id)
				$uslov .= " AND (n.domasni=" . $tim_id . " OR n.gosti=" . $tim_id . ")";
			
			$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" .
				 $id . " AND
				natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" . $id .
				 " AND
				natprevar_id=n.id) AS igrano, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id)
				AS brojOblozi, t.fname, t.lname, t.username, o.tip, t.rang" .
				 $this->join_natprevari . " INNER JOIN oblozi AS o ON o.natprevar_id=n.id
				INNER JOIN (SELECT id, @red := @red + 1 AS rang, fname, lname, username,
				(SELECT 100 + SUM(if(o.uspesen=1, round(o.ulog*o.koeficient, 1) - o.ulog,
						if(o.uspesen=0,0 - o.ulog, 0))) FROM oblozi o
				WHERE tipuvac_id=t.id) AS dobivka
				FROM tipuvaci AS t, (SELECT @red:=0) r ORDER BY dobivka DESC) AS t ON t.id=o.tipuvac_id
				WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "' AND
				n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
				AND o.tipuvac_id IN (SELECT sledi_tipuvac FROM sledenje WHERE tipuvac_id=" . $id . ")
				ORDER BY n.pocetok ASC, n.id ASC";
			$this->query($sql);
		}
		else
			$this->respond($greska, 400);
	}
	function followingcount()
	{
		$id = $this->input->post('id');
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		$tim_id = (int) $this->input->post('tim_id');
		
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify($this->limit->recent . " day");
		$greska = $this->greski->oneObject(1)->poraka;
		
		if($id)
		{
			$uslov = "";
			if($sport_id)
				$uslov .= " AND l.sport_id=" . $sport_id;
			if($liga_id)
				$uslov .= " AND l.id=" . $liga_id;
			if($tim_id)
				$uslov .= " AND (n.domasni=" . $tim_id . " OR n.gosti=" . $tim_id . ")";
			
			$sql = $this->broenje_natprevari . $this->join_natprevari . " INNER JOIN oblozi AS o ON o.natprevar_id=n.id
				WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "' AND
				n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
				AND n.id NOT IN (SELECT natprevar_id FROM oblozi WHERE tipuvac_id=" . $id . ")
				AND o.tipuvac_id IN (SELECT sledi_tipuvac FROM sledenje WHERE tipuvac_id=" . $id . ")";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$this->respondBroj((int) $red->broj);
		}
		else
			$this->respond($greska, 400);
	}
	function favorites()
	{
		$tiper_id = $this->input->post('id');
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		$tim_id = (int) $this->input->post('tim_id');
		
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify($this->limit->recent . " day");
		$greska = $this->greski->oneObject(1)->poraka;
		if($tiper_id)
		{
			$uslov = "";
			if($sport_id)
				$uslov .= " AND l.sport_id=" . $sport_id;
			if($liga_id)
				$uslov .= " AND l.id=" . $liga_id;
			if($tim_id)
				$uslov .= " AND (n.domasni=" . $tim_id . " OR n.gosti=" . $tim_id . ")";
			
			$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" .
				 $tiper_id . " AND 
				natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" .
				 $tiper_id . " AND 
				natprevar_id=n.id) AS igrano" . $this->join_natprevari .
				 " WHERE (n.domasni IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" . $tiper_id . ")
				OR n.gosti IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=" . $tiper_id . "))
				AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "' " .
				 $uslov . "
				ORDER BY n.pocetok ASC";
			// (x.id IN (SELECT sport_id FROM fav_sport WHERE tipuvac_id=".$tiper_id.") OR
			// (l.id IN (SELECT sampionat_id FROM fav_sampionat WHERE tipuvac_id=" . $tiper_id . ")
			// OR
			$this->query($sql);
		}
		else
			$this->respond($greska, 400);
	}
	function matchinfo()
	{
		$bet_id = $this->input->post('id');
		$greska = $this->greski->oneObject(2)->poraka;
		
		if($bet_id)
		{
			// sport, championship, country, datum, start time
			$sql = $this->listanje_natprevari . $this->join_natprevari .
				 " INNER JOIN oblozi AS o ON n.id=o.natprevar_id WHERE o.id=" . $bet_id;
			$this->query($sql);
		}
		else
			$this->respond($greska, 400);
	}
	function more()
	{
		$nat_id = $this->input->post('id');
		$greska = $this->greski->oneObject(1)->poraka;
		
		if($nat_id)
		{
			$sql = "SELECT prvprv AS 'half 1 full 1', prvx AS 'half 1 full 0', 
				prvvtor AS 'half 1 full 2', xprv AS 'half 0 full 1', xx AS 'half 0 full 0',
				xvtor AS 'half 0 full 2', vtorprv AS 'half 2 full 1', vtorx AS 'half 2 full 0',
				vtorvtor AS 'half 2 full 2', golovi0do1 AS 'goals 0 or 1', golovi2do3 AS 'goals 2 or 3',
				golovi4do6 AS 'goals 4 to 6', golovi7plus AS 'goals 7+'	FROM coeficienti WHERE natprevar_id=" .
				 $nat_id;
			$this->query($sql);
		}
		else
			$this->respond($greska, 400);
	}
	function toptimovi()
	{
		$id = $this->input->post('id');
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		$tim_id = (int) $this->input->post('tim_id');
		
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify($this->limit->recent . " day");
		$greska = $this->greski->oneObject(1)->poraka;
		
		if($id)
		{
			
			$uslov = "";
			if($sport_id)
				$uslov .= " AND l.sport_id=" . $sport_id;
			if($liga_id)
				$uslov .= " AND l.id=" . $liga_id;
			if($tim_id)
				$uslov .= " AND (n.domasni=" . $tim_id . " OR n.gosti=" . $tim_id . ")";
			
			$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" .
				 $id . " AND 
				natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" . $id . " AND 
				natprevar_id=n.id) AS igrano" . $this->join_natprevari .
				 " WHERE n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "' AND
				n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "' 
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
				AND (td.top>0 OR tg.top>0) ORDER BY n.pocetok ASC, td.top DESC, tg.top DESC";
			$this->query($sql);
		}
		else
			$this->respond($greska, 400);
	}
	function toptimovicount()
	{
		$id = $this->input->post('id');
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		$tim_id = (int) $this->input->post('tim_id');
		
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify($this->limit->recent . " day");
		$greska = $this->greski->oneObject(1)->poraka;
		
		if($id)
		{
			$uslov = "";
			if($sport_id)
				$uslov .= " AND l.sport_id=" . $sport_id;
			if($liga_id)
				$uslov .= " AND l.id=" . $liga_id;
			if($tim_id)
				$uslov .= " AND (n.domasni=" . $tim_id . " OR n.gosti=" . $tim_id . ")";
			
			$sql = $this->broenje_natprevari . $this->join_natprevari .
				 " WHERE l.sport_id IN (SELECT sport_id FROM fav_sport WHERE tipuvac_id=" . $id . ")
				AND n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
				AND (td.top>0 OR tg.top>0) ORDER BY n.pocetok ASC";
			$rezz = $this->db->query($sql);
			$red = $rezz->row();
			$this->respondBroj((int) $red->broj);
		}
		else
			$this->respond($greska, 400);
	}
	function najpopularni()
	{
		$id = $this->input->post('id');
		$sport_id = (int) $this->input->post('sport_id');
		$liga_id = (int) $this->input->post('liga_id');
		$tim_id = (int) $this->input->post('tim_id');
		
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$posle->modify($this->limit->recent . " day");
		$greska = $this->greski->oneObject(1)->poraka;
		
		if($id)
		{
			$uslov = "";
			if($sport_id)
				$uslov .= " AND l.sport_id=" . $sport_id;
			if($liga_id)
				$uslov .= " AND l.id=" . $liga_id;
			if($tim_id)
				$uslov .= " AND (n.domasni=" . $tim_id . " OR n.gosti=" . $tim_id . ")";
			
			$sql = $this->listanje_natprevari . ", (SELECT COUNT(id) FROM oblozi WHERE tipuvac_id=" .
				 $id . " AND 
				natprevar_id=n.id) AS igran, (SELECT tip FROM oblozi WHERE tipuvac_id=" . $id .
				 " AND 
				natprevar_id=n.id) AS igrano, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS brojOblozi" .
				 $this->join_natprevari . " WHERE n.pocetok < '" . $posle->format("Y-m-d H:i:s") . "'
				AND n.pocetok > '" . $sega->format("Y-m-d H:i:s") . "'
				AND n.vidliv < '" . $sega->format("Y-m-d H:i:s") . "'" .
				 $uslov . "
				AND n.id IN (SELECT DISTINCT(natprevar_id) FROM oblozi)
				ORDER BY brojOblozi DESC, n.pocetok ASC";
			$this->query($sql);
		}
		else
			$this->respond($greska, 400);
	}
	private function random($sql = "", $broj = 5)
	{
		$error = "";
		try
		{
			$sql = str_replace("COUNT(DISTINCT(n.id)) AS broj", 
							"DISTINCT(n.id), n.domasni AS domasniID, td.ime AS domasni, 
					n.gosti AS gostiID, tg.ime AS gosti, n.domasni1, n.domasni2, n.domasni3, 
					n.domasni4, n.gosti1, n.gosti2, n.gosti3, n.gosti4,	n.pocetok, n.kraj, 
					k.ime AS kolo, s.ime AS sezona, l.ime AS sampionat, c.prv AS home,
					c.x AS draw, c.vtor AS away ", $sql);
			$lista = $this->db->query($sql . " LIMIT " . $broj);
			if($lista->num_rows() > 0)
			{
				$indeks = 0;
				if($broj > 1 && $lista->num_rows() > 1)
					$indeks = mt_rand(0, $broj - 1);
				$arr = $lista->result_array();
				$this->respond($arr[$indeks]);
			}
			else
				$this->respond("Nema podatoci", 400);
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
			$this->respond($error, 400);
		}
	}
	private function query($sql = "")
	{
		$error = "";
		try
		{
			$lista = $this->db->query($sql);
			if($lista->num_rows() > 0)
				$this->respond($lista->result_array());
			else
				$this->respond("Nema podatoci", 400);
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
			$this->respond($error, 400);
		}
	}
	private function insert($sql = "", $tiper = NULL, $ulog = 0)
	{
		try
		{
			$this->db->query($sql);
			if($this->db->insert_id() > 0)
			{
				if($tiper)
				{
					$tiper->saldo -= $ulog;
					if($tiper->tmpBids)
						$tiper->tmpBids --;
					else
						$tiper->bids --;
					$this->korisnik->update($tiper, $tiper->id);
				}
				$this->respond("Executed");
			}
			else
				$this->respond("Error", 400);
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
			$this->respond($error, 400);
		}
	}
	private function updel($sql = "")
	{
		try
		{
			$this->db->query($sql);
			if($this->db->affected_rows() == 0)
				$this->respond("No records found", 400);
			else
				$this->respond("Records deleted");
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
			$this->respond($error, 400);
		}
	}
	private function respond($data, $status = 200, $content_type = "application/json")
	{
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
		header($status_header);
		header('Content-type: ' . $content_type);
		$response = array ("data" => $data);
		echo json_encode($response); // , JSON_FORCE_OBJECT);
	}
	private function repackRespond($data, $status = 200, $content_type = "application/json", $timezone = "Europe/Skopje")
	{
		$format = "Y-m-d H:i:s";
		foreach($data as $s)
		{
			$pocetok = new DateTime($s["pocetok"], new DateTimeZone($timezone));
			$kraj = new DateTime($s["kraj"], new DateTimeZone($timezone));
			$denes = new DateTime("now", new DateTimeZone($timezone));
			if(is_numeric($s["domasni4"]) && is_numeric($s["gosti4"]) && is_numeric($s["domasni2"]) &&
			 is_numeric($s["gosti2"]))
				$status = "closed";
			elseif($denes > $kraj && ! (is_numeric($s["domasni4"]) && is_numeric($s["gosti4"]) &&
				 is_numeric($s["domasni2"]) && is_numeric($s["gosti2"])))
				$status = "finished";
			elseif($denes > $pocetok && $denes < $kraj)
				$status = "live";
			else
				$status = "open";
			$s["status"] = $status;
			$lista[] = $s;
		}
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
		header($status_header);
		header('Content-type: ' . $content_type);
		$response = array ("data" => $lista);
		echo json_encode($response);
	}
	private function respondBroj($data, $status = 200, $content_type = "application/json")
	{
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
		header($status_header);
		header('Content-type: ' . $content_type);
		echo json_encode($data); // , JSON_FORCE_OBJECT);
	}
	function gisledam()
	{
		$id = (int) $this->input->post('id');
		$sql = "SELECT t.id, t.fb_id, t.fname, t.lname, t.rang, t.saldo AS balance
					FROM sledenje s INNER JOIN 
					(SELECT id, fb_id, @red := @red + 1 AS rang, fname, lname, saldo
					FROM tipuvaci AS k, (SELECT @red:=0) AS l ORDER BY saldo DESC) AS t
					ON t.id=s.sledi_tipuvac WHERE s.tipuvac_id=" . $id .
			 " ORDER BY t.saldo DESC";
		$this->query($sql);
	}
	function mesledat()
	{
		$id = (int) $this->input->post('id');
		$sql = "SELECT t.id, t.fb_id, t.fname, t.lname, t.rang, t.saldo AS balance
					FROM sledenje s INNER JOIN 
					(SELECT id, fb_id, @red := @red + 1 AS rang, fname, lname, saldo
					FROM tipuvaci AS k, (SELECT @red:=0) AS l ORDER BY saldo DESC) AS t
					ON t.id=s.tipuvac_id WHERE s.sledi_tipuvac=" . $id .
			 " ORDER BY t.saldo DESC";
		
		$this->query($sql);
	}
	function getStatusCodeMessage($status)
	{
		$codes = Array (100 => 'Continue',101 => 'Switching Protocols',200 => 'OK',201 => 'Created',
						202 => 'Accepted',203 => 'Non-Authoritative Information',204 => 'No Content',
						205 => 'Reset Content',206 => 'Partial Content',300 => 'Multiple Choices',
						301 => 'Moved Permanently',302 => 'Found',303 => 'See Other',
						304 => 'Not Modified',305 => 'Use Proxy',306 => '(Unused)',
						307 => 'Temporary Redirect',400 => 'Bad Request',401 => 'Unauthorized',
						402 => 'Payment Required',403 => 'Forbidden',404 => 'Not Found',
						405 => 'Method Not Allowed',406 => 'Not Acceptable',
						407 => 'Proxy Authentication Required',408 => 'Request Timeout',
						409 => 'Conflict',410 => 'Gone',411 => 'Length Required',
						412 => 'Precondition Failed',413 => 'Request Entity Too Large',
						414 => 'Request-URI Too Long',415 => 'Unsupported Media Type',
						416 => 'Requested Range Not Satisfiable',417 => 'Expectation Failed',
						500 => 'Internal Server Error',501 => 'Not Implemented',502 => 'Bad Gateway',
						503 => 'Service Unavailable',504 => 'Gateway Timeout',
						505 => 'HTTP Version Not Supported');
		return (isset($codes[$status]))?$codes[$status]:'';
	}
}
