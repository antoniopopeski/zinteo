<?php
class admin_poraki extends MY_Controller
{
	function index()
	{
		$this->load->model('greski');
		$poraka = "";
		$greska = $this->input->post('greska');
		$greskaID = $this->input->post('id');
		if($greska && $greskaID)
		{
			if($this->greski->update($greska, $greskaID))
				$poraka = "Data successfully updated";
			else 
				$poraka = "Error";
		}
		$data = array("content"=> "a_poraki", "uredil"=>$this->uredil,
			"settings" => $this->limits, "poraka" => $poraka);
		$data["lista"] = $this->greski->getObjects();
		$this->load->view("template", $data);
	}
	
}