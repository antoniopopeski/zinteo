<?php
class admin_tiket extends MY_Controller
{
	function index()
	{
		$data = array("content"=> "a_tiketi", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$sql = "SELECT b.id, b.code, t.username, b.od, b.do, b.bids, b.aktiviran FROM tiketi AS b INNER JOIN tipuvaci AS t
				ON t.id=b.tipuvac_id";
		$data["startDate"] = $this->session->userdata("fStartDate");
		$data["selTiper"] = $this->session->userdata("fTiper");
		$this->load->model('korisnik');
		$data["tiperi"] = $this->korisnik->getObjects();
		$uslov = "";
		if($data["startDate"] || $data["selTiper"])
		{
			$uslov = " WHERE ";
			if($data["startDate"])
				$uslov .= "DATE('".$data["startDate"]."') BETWEEN b.od AND b.do AND";
			if($data["selTiper"])
				$uslov .= " t.id=".$data["selTiper"];
			$uslov = trim($uslov, "AND");
		}
		$data['lista'] = $this->db->query($sql.$uslov)->result();
		$this->load->view("template", $data);
	}
}