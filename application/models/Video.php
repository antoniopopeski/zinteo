<?php
class Video extends CI_Controller
{
	private $uredil = "";
	private $topNum = 12;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		if($this->admin_model->login_check())
		{
			$this->uredil = $this->admin_model->getActiveUser();
		}
		$this->load->model("settings_model");
		$this->load->model("sekcii_model");
		$this->load->model("kategorii_model");
		$this->load->model("podkategorii_model");
		$this->load->model("tipobjavi_model");
		$this->load->model("reklami_model");
		if(base_url()=="http://guru.dev/")
			$this->output->enable_profiler(TRUE);
		else
			$this->output->enable_profiler(FALSE);
	}
	//nov index za think.mk
	function index()
	{
		$data = array();
		//za svite prikazani objave, da ne gi cita duplo
		$indexString = "";
		$data["content"] = "shablon4";
		$seo_url = $this->uri->segment(3);
		$najtopUslov = "AND o.top=2";
		if($seo_url)
		{
			$sql = "SELECT * FROM categories WHERE seo_url='".$seo_url."'";
			$sekcija = $this->db->query($sql)->row_array();
			if($sekcija["category_id"]>0)
				$uslov = " AND o.category_id = ".(int)$sekcija["category_id"]." ";
			$item["kategorija"] = $sekcija['category_name'];
			$item["section_id"] = $sekcija['section_id'];
			$item["category_id"] = $sekcija['category_id'];
		}
		else {
			$uslov = " AND o.prikaz=0 ";
			$item["kategorija"] = "СИТЕ";
			$item["section_id"] = 0;
			$item["category_id"] = 0;
		}
		if($indexString)
			$sql ="SELECT o.*, k.category_name as kategorija, k.seo_url as katURL
				FROM objavi as o inner join categories as k on k.category_id = o.category_id
				INNER JOIN tipObjavi as t ON t.id=o.tip WHERE o.status=1 $najtopUslov
				AND o.id NOT IN (".trim($indexString,',').") $uslov
				ORDER BY o.date_modified DESC LIMIT 1";
		else
			$sql ="SELECT o.*, k.category_name as kategorija, k.seo_url as katURL
				FROM objavi as o inner join categories as k on k.category_id = o.category_id
				INNER JOIN tipObjavi as t ON t.id=o.tip WHERE o.status=1 $najtopUslov $uslov
				ORDER BY o.date_modified DESC LIMIT 1";
		$rezultat = $this->db->query($sql);
		if($rezultat->num_rows()>0)
		{
			$data["prvaNajtop"] = $rezultat->row_array();
			$indexString = $data["prvaNajtop"]['id'];
		}
		else
		{
			$data['prvaNajtop'] = array();
		}
		$rezultat->free_result();
		if($indexString)
			$sql ="SELECT o.*, k.category_name as kategorija, k.seo_url as katURL
				FROM objavi as o inner join categories as k on k.category_id = o.category_id
				INNER JOIN tipObjavi as t ON t.id=o.tip WHERE
				o.status=1 $uslov AND o.id NOT IN (".trim($indexString,',').")
				ORDER BY o.date_modified DESC LIMIT 11";
		else
			$sql ="SELECT o.*, k.category_name as kategorija, k.seo_url as katURL
				FROM objavi as o inner join categories as k on k.category_id = o.category_id
				INNER JOIN tipObjavi as t ON t.id=o.tip WHERE 
				o.status=1 $uslov ORDER BY o.date_modified DESC LIMIT 11";
		$rezultat = $this->db->query($sql);
		if($rezultat->num_rows()>0)
			$data["normalni"] = $rezultat->result_array();
		else
			$data["normalni"] = array();
		foreach ($data["normalni"] as $a)
			$indexString .= ",".$a["id"];
		$rezultat->free_result();
		//11 najpopularni nedelava
		$odVreme = new DateTime('now', new DateTimeZone('Europe/Skopje'));
		$odVreme->modify('-7 day');
		$doVreme = new DateTime('now', new DateTimeZone('Europe/Skopje'));
		$sql ="SELECT o.*, k.category_name as kategorija, k.seo_url as katURL,
			(SELECT COALESCE(COUNT(id),0) FROM pregledi WHERE objava_id=o.id AND (vreme BETWEEN '".
			$odVreme->format('Y-m-d H:i:s')."' AND '".$doVreme->format('Y-m-d H:i:s').
			"')) AS posetena FROM objavi as o inner join categories as k on k.category_id = o.category_id
			WHERE o.status=1 $uslov
			ORDER BY posetena DESC, o.date_modified DESC LIMIT 11";
		$rezultat = $this->db->query($sql);
		if($rezultat->num_rows()>0)
			$data["popularni"] = $rezultat->result_array();
		else
			$data["popularni"] = array();
		$rezultat->free_result();

		//kolko ima broj na objave za prikazuvanje od kategoriju za da se odredi
		$sql = "SELECT COUNT(o.id) AS broj FROM objavi as o inner join categories as k on k.category_id = o.category_id
			WHERE o.status=1 AND o.id NOT IN (".trim($indexString,',').") AND o.category_id=".$item['category_id'];
		$brojLevo = floor((int)$this->db->query($sql)->row()->broj / 10);
		$sql = "SELECT COUNT(o.id) AS broj FROM objavi as o inner join categories as k on k.category_id = o.category_id
			WHERE o.status=1 AND o.section_id=".$item['section_id']." AND o.top>0";
		$brojDesno = floor((int)$this->db->query($sql)->row()->broj / 6);
		$brojLevo--;
		$brojDesno--;
		if($brojLevo < $brojDesno)
			$data["maxStrani"] = (int)$brojLevo;
		else
			$data["maxStrani"] = (int)$brojDesno;
		$data['prikazaniIDs'] = $indexString;
		$data["item"] = $item;
		$data['sts'] = $this->settings_model->zemi();
		$data["sekcii"] = $this->sekcii_model->zemiSite();
		$sql = "pocetok <= '".date_create()->format("Y-m-d")."' AND "."kraj >= '".date_create()->format("Y-m-d").
				"' ORDER BY pozicija ASC, redosled ASC, RAND()";
		$data["reklami"] = $this->reklami_model->zemiSite($sql);
		/*if(isset($item['category_id']) && $item['category_id'])//ima kategorija
		{
			$uslov = "WHERE (site_sekcii=1 OR site_kategorii=1 OR kategorii LIKE '%k".$item['category_id']."%')";
		} 
		else*/
		if(isset($item['section_id']) && $item['section_id'])//ima sekcija 
		{
			//$uslov = "WHERE (site_sekcii=1 OR sekcii LIKE '%s".$item['section_id']."%')";
			$uslov = "WHERE sekcii='".$item['section_id']."'";
		}
		else //naslovna
		{
			$uslov = "";
		}
		$sql = "SELECT * FROM kvoti ".$uslov." ORDER BY id DESC LIMIT 2";
		$data["kvota"] = $this->db->query($sql)->result_array();
		$this->load->view("template", $data);
	}
}
