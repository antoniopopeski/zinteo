<?php
class MY_Public extends CI_Controller
{
	protected $user;
	protected $limits;
	protected $info;
	protected $activeSports;
	protected $activeLeagues;
	
	function __construct()
	{
		parent::__construct();
		$settings = array("appId" => $this->config->item('appId'), 
				"secret" => $this->config->item('secret'));
		$this->load->library('facebook', $settings);
		$fb_user = $this->auth->is_logged_in();
		if(!$fb_user)
			redirect('fblogin');
		try 
		{
			$this->load->model('korisnik');
			$this->user = $this->korisnik->profil2($fb_user["username"]);
			if(!is_object($this->user))
				redirect('fblogin');
			
			//potrebno e da se otcitav podesuvanja
			$this->load->model('settings');
			$this->limits = $this->settings->getObjects();
			$this->load->model('pages');
			$sega = new DateTime("now", new DateTimeZone($this->user->timezone));
			$posle = new DateTime("now", new DateTimeZone($this->user->timezone));
			$posle->modify($this->limits->recent . " day");
			$rezultat["bids"] = (int)$this->user->bids + (int)$this->user->tmpBids;
			$tiper_id = $this->user->id;
			
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
				
			$this->info = (object)$rezultat;
			$sql = "SELECT id, ime, (SELECT COUNT(id) FROM fav_sport WHERE tipuvac_id=".$tiper_id.
					" AND sport_id=s.id) AS fav FROM sportovi AS s WHERE aktiven=1 ORDER BY ime ASC";
			$this->activeSports = $this->db->query($sql)->result();
			$sql = "SELECT id, ime, (SELECT COUNT(id) FROM fav_sampionat WHERE tipuvac_id=".$tiper_id.
					" AND sampionat_id=s.id) AS fav FROM sampionati AS s WHERE aktiven=1 ORDER BY ime ASC";
			$this->activeLeagues = $this->db->query($sql)->result();
			$sql = "SELECT id, TRIM(CONCAT_WS(' ', ime, grad)), 
					(SELECT COUNT(id) FROM fav_tim WHERE tipuvac_id=".$tiper_id.
					" AND tim_id=t.id) AS fav FROM timovi AS t ORDER BY ime ASC";
		}
		catch(Exception $error)
		{
			redirect("/fblogin");
		}
	}
}
class MY_Controller extends CI_Controller
{
	protected $uredil;
	protected $limits;
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		if(!$this->admin_model->login_check())
		{
			redirect("/login");
		}
		$this->uredil = $this->admin_model->getActiveUser();
		$this->load->model('pages');
		//potrebno e da se otcitav podesuvanja
		$this->load->model('settings');
		$this->limits = $this->settings->getObjects();
		if(strpos(base_url(), ".dev")!== false)
			$this->output->enable_profiler(true);
		else
			$this->output->enable_profiler(false);
	}
}