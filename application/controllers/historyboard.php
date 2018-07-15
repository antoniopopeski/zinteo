<?php
class historyboard extends MY_Public
{
	private $timezone = "America/Whitehorse";
	function index()
	{
		$data = array ("content" => "p_historyboard","user" => $this->user,"info" => $this->info,
					'title' => "Leaderboard History");
		$data["lista"] = array();
		$data["activeSports"] = $this->activeSports;
		$this->load->view("public_template", $data);
	}
	function awarded()
	{
		$data = array ("content" => "p_awarded","user" => $this->user,"info" => $this->info,
				'title' => "Awarded Bettors");
		$data["uslov"] = $this->db->query("SELECT * FROM greski WHERE greska='uslov za nagrada'")->row()->poraka;
		$data["activeSports"] = $this->activeSports;
		$this->load->view("public_template", $data);
	}
	function successfull()
	{
		$data = array ("content" => "p_success","user" => $this->user,"info" => $this->info,
					'title' => "Most Successful Bettors");
		$this->load->view("public_template", $data);
	}
}