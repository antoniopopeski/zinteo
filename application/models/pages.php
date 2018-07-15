<?php
class pages extends MY_Model
{
	static $tabela = "pages";
	static $indeks = "id";
	
	function __construct()
	{
		parent::__construct();
	}
	
	function insert($data)
	{
		$sql = 'INSERT INTO '.self::$tabela.' (';
		$dbValues = '(';
		if(!array_key_exists("date_modified", $data))
		{
			$sql .= 'date_modified,';
			$dbValues .= "'".date("Y-m-d H:i:s")."',";
		}
		if(!array_key_exists("seo_url", $data) || trim($data['seo_url'])=="")
		{
			$this->load->helper('my');
			$sql .= 'seo_url,';
			$dbValues .= "'".create_seo_link(trim($data['naslov']))."',";
		}
		foreach($data as $key=>$value)
		{
			$sql .= $key.',';
			if($key == "date_modified" && trim($value) == "")
				$dbValues .= "'".date("Y-m-d H:i:s")."',";
			else $dbValues .= "'".addslashes(trim($value))."',";//html_escape
		}
		$sql = trim($sql, ',').') VALUES '.trim($dbValues, ',').')';
		$this->db->query($sql);
		if($this->db->affected_rows() == 1)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	function update($data, $id)
	{
		$sql = 'UPDATE '.self::$tabela.' SET ';
		if(!array_key_exists("date_modified", $data))
		{
			$sql .= "date_modified='".date("Y-m-d H:i:s")."',";
		}
		if(!array_key_exists("seo_url", $data) || trim($data['seo_url'])=="")
		{
			$this->load->helper('my');
			$sql .= "seo_url='".create_seo_link(trim($data['naslov']))."',";
		}
		if(!array_key_exists("tekst", $data) || trim($data['tekst'])=="")
		{
			$sql .= "tekst=NULL,";
		}
		foreach($data as $key=>$value)
		{
			if($key == "date_modified" && $value == "0000-00-00 00:00:00")
				$sql .= $key."='".date("Y-m-d H:i:s")."',";
			elseif($key == "date_modified" && trim($value) == "")
			$sql .= $key."='".date("Y-m-d H:i:s")."',";
			else $sql .= $key."='".addslashes(trim($value))."',";//html_escape
		}
		$sql = trim($sql, ',').' WHERE '.self::$indeks.'='.$id;
		$this->db->query($sql);
		$promeneti = $this->db->affected_rows();
		if($promeneti == 1)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	function delete($id)
	{
		$sql = 'DELETE FROM '.self::$tabela.' WHERE '.self::$indeks.'='.$id;
		$this->db->query($sql);
		if($this->db->affected_rows() == 1)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
}