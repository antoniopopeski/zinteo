<?php
class teams extends MY_Public
{
	function index()
	{
		$data = array ("content" => "p_tim","user" => $this->user,"info" => $this->info,
					'title' => "Teams");
		$this->load->model('drzava');
		$data["sport_id"] = 0;
		$sql = "SELECT DISTINCT(t.id), TRIM(CONCAT_WS(' ', t.ime, t.grad)) AS ime, t.kratenka, t.top,
				(SELECT COUNT(DISTINCT(id)) FROM fav_tim WHERE tim_id=t.id AND tipuvac_id=" . $this->user->id . ") AS fav FROM timovi AS t
				INNER JOIN sezona_tim AS st ON st.tim_id=t.id INNER JOIN sezona AS s ON st.sezona_id=s.id
				ORDER BY top DESC, ime ASC";
		$data["lista"] = $this->db->query($sql)->result();
		$data["sportovi"] = $this->activeSports;
		$data["drzavi"] = $this->drzava->getObjects("ORDER BY ime ASC");
		$this->load->view("public_template", $data);
	}
}