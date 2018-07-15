<?php
class admin_sledenje extends MY_Controller
{
	function index()
	{
		$data = array("content"=> "a_sledenje", "uredil"=>$this->uredil, "js" => "tablesorter",
			"settings" => $this->limits);
		$sql = "SELECT t.id, t.username, (SELECT COUNT(id) FROM sledenje WHERE tipuvac_id=t.id) as flw,
				(SELECT COUNT(id) FROM sledenje WHERE sledi_tipuvac=t.id) as flwrs FROM tipuvaci as t ";
		$data["selKreiran"] = $this->session->userdata("tiperKreiran");
		$data["selLogiran"] = $this->session->userdata("tiperLogiran");
		$kreiran = $data["selKreiran"];
		$logiran = $data["selLogiran"];
		$uslov = "";
		if($data["selKreiran"] || $data["selLogiran"])
		{
			$uslov .= " WHERE";
			$min = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			//$max = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			switch ($kreiran)
			{
				case "day":
					$uslov .= " t.kreiran LIKE '".$min->format("Y-m-d")."%' AND ";
				break;
				
				case "week":
					$uslov .= " t.kreiran LIKE '".$min->format("Y-m")."%'
							AND WEEKOFYEAR(t.kreiran)=WEEKOFYEAR(NOW())) AND ";
				break;

				case "month":
					$uslov .= " t.kreiran LIKE '".$min->format("Y-m")."%' AND ";
				break;

				case "year":
					$uslov .= " t.kreiran LIKE '".$min->format("Y")."%' AND ";
				break;
			}
			switch ($logiran)
			{
				case "day":
					$uslov .= " t.logiran LIKE '".$min->format("Y-m-d")."%' AND ";
				break;
		
				case "week":
					$uslov .= " t.logiran LIKE '".$min->format("Y-m")."%'
							AND WEEKOFYEAR(t.logiran)=WEEKOFYEAR(NOW()) AND ";
				break;
		
				case "month":
					$uslov .= " t.logiran LIKE '".$min->format("Y-m")."%' AND ";
					break;
		
				case "year":
					$uslov .= " t.logiran LIKE '".$min->format("Y")."%' AND ";
				break;
			}
			$uslov = trim($uslov, " AND ");
		}
		
		$data['lista'] = $this->db->query($sql.$uslov)->result();
		$data["poraka"] = $this->session->userdata("poraka");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}
}