<?php
class korisnik extends MY_Model
{
	protected static $tabela = "tipuvaci";
	protected static $indeks = "id";
	
	function __construct()
	{
		parent::__construct();
	}
	
	function profil($username)
	{
		$sql = "SELECT * FROM ".self::$tabela." WHERE username='".$username."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
		{
			$korisnik = $query->row_array();
			return $korisnik;
		}
		return false;
	}
	
	function profil2($username)
	{
		$sql = "SELECT * FROM ".self::$tabela." WHERE fb_id='".$username."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
		{
			$korisnik = $query->row();
			return $korisnik;
		}
		return false;
	}
	/*
	 fb_user default array
	(
			[id] => 1224457348
			[name] => Toni Trajkovski
			[first_name] => Toni
			[last_name] => Trajkovski
			[link] => http://www.facebook.com/toni.trajkovski
			[username] => toni.trajkovski
			[hometown] => Array
			(
					[id] => 113408742002807
					[name] => Kumanovo
			)
			[location] => Array
			(
					[id] => 107337242635813
					[name] => Kumanovo
			)
			[bio] => Hmmm
			[quotes] => Jebiga
			[gender] => male
			[timezone] => 1
			[locale] => en_US
			[verified] => 1
			[updated_time] => 2013-03-06T22:52:58+0000
	)
	*/
}