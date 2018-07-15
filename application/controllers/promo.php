<?php
class promo extends MY_Public
{
	function index()
	{
		$code = $this->input->post('code');
		$data = array ("content" => "p_promo","user" => $this->user,"info" => $this->info);
		if($code)
		{
			$timezone = new DateTimeZone($this->user->timezone);
			$this->load->model('tiket');
			$tiket = $this->tiket->oneObject("code='" . $code . "' AND tipuvac_id=".$this->user->id);
			if(is_object($tiket)) // najden e tiket
			{
				if($tiket->aktiviran)
					$data['error'] = "The code you entered [$code] is already used";
				else 
				{
					$denes = new DateTime('now', $timezone);
					$zavrsuva = new DateTime($tiket->do, $timezone);
					if($denes < $zavrsuva)
					{
						$tiket->aktiviran = $denes->format("Y-m-d");
						$this->tiket->update($tiket, $tiket->id);
						$data['bonus'] = $tiket->bids;
						$data['poraka'] = $zavrsuva->format("d.m.Y");
					}
					else
					{
						$data['error'] = "The code you entered [$code] is expired";
					}
				}
			}
			else
			{
				$data['error'] = "The code you entered [$code] is not valid";
			}
		}
		$this->load->view("public_template", $data);
	}
}