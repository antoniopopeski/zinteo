<?php
class reseter extends CI_Controller
{
	public function index()
	{
		$format = "Y-m-d";
		//$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$this->load->model("korisnik");
		$korisnici = $this->korisnik->getObjects();
		$this->load->model('settings');
		$limit = $this->settings->getObjects();
		foreach($korisnici as $k)
		{
			$segaLokalno = new DateTime("now", new DateTimeZone($k->timezone));
			if($segaLokalno->format("H:i") == "00:00")
			{
				//resetirani vrednosti treba da bidev bids = 1 + pokaneti + tiket
				//proverka za aktivni tiketi
				$sql = "SELECT SUM(bids) AS broj FROM tiketi WHERE aktiviran<>'0000-00-00 00:00:00'
						AND DATE('".$segaLokalno->format($format)."') BETWEEN od 
						AND do AND tipuvac_id=".$k->id;
				$broj = (int)$limit->startBids + (int)$k->tiperi_pokaneti;
				$rezz = $this->db->query($sql);
				if($rezz->num_rows() > 0)
					$broj += (int)$rezz->row()->broj;
				
				// uncomment this later!!!
				//$this->db->query("UPDATE tipuvaci SET bidsLimit = ".$limit->bidsLimit
						.",bids=".$broj.", tmpBids=0 WHERE id=".$k->id);
			}
		}
	}
	function notify()
	{
		$this->load->model('korisnik');
		$igraci = $this->korisnik->getObjects("WHERE device<>''");
		//otkako ke se zeme lista na igraci koi imav device vrednost treba da se prebroiv 
		//oblozi za koi nema prateno notifikacija
		foreach ($igraci as $i)
		{
			$sql = "SELECT COUNT(id) AS broj FROM oblozi WHERE notifikacija=0 AND tipuvac_id=".$i->id;
			$broj = (int)$this->db->query($sql)->row()->broj;
			if($broj && $i->device)
			{
				echo "pogodeni ".$broj." za tiper ".$i->username."<br>";
				try
				{
					/*lokalno*
					$this->load->helper('notify');
					echo sendNotification($i->device, $broj);
					/*remote*/
					$argumenti = "device=".$i->device."&broj=".$broj;
					$url = 'http://test.tztdevelop.com/notify.php?'.$argumenti;
					$rezultat = file_get_contents($url);
					if($rezultat == 'Message successfully delivered')
					{
						$sql = "UPDATE oblozi SET notifikacija=1 WHERE tipuvac_id=".$i->id;
						$this->db->query($sql);
					}
					//**/
				}
				catch (Exception $error)
				{
					echo $error->getMessage();
				}
			}
		}
	}
	function test()
	{
		$this->load->helper('notify');
		echo sendNotification(FALSE, 1);
	}
}
