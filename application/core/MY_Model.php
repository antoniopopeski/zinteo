<?php
class MY_Model extends CI_Model
{
	protected static $tabela;
	protected static $indeks;

	function __construct()
	{
		parent::__construct();
	}

	public function getObjects($uslov="")
	{
		$sql = 'SELECT * FROM '.static::$tabela;
		if($uslov != "")
		{
			$sql .= ' '.$uslov;
		}
		else
		{
			$sql .= ' ORDER BY id DESC';
		}
		$query = $this->db->query($sql);
		if($query->num_rows() == 0)
			return false;
		else
			return $query->result();
	}

	public function getArrays($uslov="")
	{
		$sql = 'SELECT * FROM '.static::$tabela;
		if($uslov != "")
		{
			$sql .= ' '.$uslov;
		}
		else
		{
			$sql .= ' ORDER BY id DESC';
		}
		$query = $this->db->query($sql);
		if($query->num_rows() == 0)
			return null;
		else
			return $query->result_array();
	}

	public function oneObject($id = 0)
	{
		$sql = 'SELECT * FROM '.static::$tabela;
		if(is_numeric($id) && $id > 0)
			$sql .= ' WHERE '.static::$indeks.'='.$id;
		elseif(is_string($id) && strlen($id) > 0)
			$sql .= ' WHERE '.$id;
		$query = $this->db->query($sql);
		
		return $query->row();
	}

	public function oneArray($id = 0)
	{
		$sql = 'SELECT * FROM '.static::$tabela;
		if(is_numeric($id) && $id > 0)
			$sql .= ' WHERE '.static::$indeks.'='.$id;
		elseif(is_string($id) && strlen($id) > 0)
			$sql .= ' WHERE '.$id;
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}
	
	public function insert($data)
	{
		$this->db->insert(static::$tabela, $data);
		if($this->db->affected_rows() == 1)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function update($data, $id)
	{
		$this->db->where(static::$indeks, $id);
		$this->db->update(static::$tabela, $data);
		if($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function delete($id)
	{
		$this->db->where(static::$indeks, $id);
		$this->db->delete(static::$tabela);
		if($this->db->affected_rows() == 1)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	public function lastID()
	{
		return $this->db->insert_id();
	}
	
	public function lastQuery()
	{
		return $this->db->last_query();
	}
}