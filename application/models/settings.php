<?php
class settings extends CI_Model
{
	function getArray()
	{
		$sql = 'SELECT * FROM settings';
		$query = $this->db->query($sql)->result_array();
		return array_shift($query);
	}
	
	function getObjects()
	{
		$sql = 'SELECT * FROM settings';
		$query = $this->db->query($sql)->row();
		return $query;
	}
	
	function update($data)
	{
		$sql = 'UPDATE settings SET ';
		foreach($data as $key=>$value)
		{
			$sql .= $key."='".$value."',";
		}
		$sql = trim($sql, ',');
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