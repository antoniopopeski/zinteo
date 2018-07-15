<?php
class Test extends MY_Controller
{
	function index()
	{
		$this->load->helper("notify");
		echo "napunet helper notify<br>";
		$this->load->model("korisnik");
		echo "napunet model korisnik<br>ke se upotrebi tipuvac_id = 9 Bobi Zrncev<br>";
		$igrac = $this->korisnik->oneObject(9);
		if($igrac->device)
		{
			$query = "device=".$igrac->device."&broj=10";
			$url = 'http://test.tztdevelop.com/notify.php?'.$query;
			echo $url."<br>";
			$content = file_get_contents($url);
			echo $content;
		}
		else
		{
			echo "nema device token";
		}	
	}
}