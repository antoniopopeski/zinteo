<?php
class favorites extends MY_Public
{
	function index()
	{
		$data = array("content"=>"p_favorites", "user"=>$this->user, "info"=>$this->info, 
				"title" => "My Favorites");
		
		$sql = "SELECT id, ime FROM sportovi WHERE id IN (SELECT sport_id FROM fav_sport
				WHERE tipuvac_id=".$this->user->id.")";
		$data['sportovi'] = $this->db->query($sql)->result();/*
		$sql = "SELECT id, ime FROM sampionati WHERE id IN (SELECT sampionat_id FROM fav_sampionat
				WHERE tipuvac_id=".$this->user->id.")";
		$data['sampionati'] = $this->db->query($sql)->result();*/
		$sql = "SELECT id, TRIM(CONCAT_WS(' ', ime, grad)) AS ime FROM timovi 
				WHERE id IN (SELECT tim_id FROM fav_tim WHERE tipuvac_id=".$this->user->id.")";
		$data['timovi'] = $this->db->query($sql)->result();
		
		$this->load->view("public_template", $data);
	}
}