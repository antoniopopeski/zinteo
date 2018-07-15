<?php
class sports extends MY_Public
{
	function index()
	{
		$data = array ("content" => "p_sports","user" => $this->user,"info" => $this->info,
					'title' => "Sports");
		$data["sportovi"] = $this->activeSports;
		$this->load->view("public_template", $data);
	}
}