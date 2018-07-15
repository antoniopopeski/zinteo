<?php
class championships extends MY_Public
{
	function index()
	{
		$this->load->model('drzava');
		$data = array ("content" => "p_sampionat","user" => $this->user,"info" => $this->info,
					'title' => "Championships");
		/*
		 * $sql = "SELECT s.id, s.ime, (SELECT COUNT(id) FROM fav_sampionat WHERE tipuvac_id=" .
		 * $this->user->id . " AND sampionat_id=s.id) AS fav FROM sampionati AS s WHERE s.aktiven=1
		 * ORDER BY s.ime ASC";
		 */
		$data['ligi'] = $this->activeLeagues; // $this->db->query($sql)->result();
		$data["sportovi"] = $this->activeSports;
		$data["drzavi"] = $this->drzava->getObjects("ORDER BY ime ASC");
		$this->load->view("public_template", $data);
	}
}