<?php
class admin_model extends MY_Model
{
	static $tabela = "admin";
	static $indeks = "id";
	private $encKey = 'b5uJ3agCLafEvc8e03bNSAV85RCJqG';
	//za login proverki
	private $max_attempts = '5';
	private $period = '3600';
	
	function zemiSite($uslov="")
	{
		$sql = 'SELECT * FROM '.self::$tabela;
		if($uslov!="")
		{
			$sql .= ' WHERE '.$uslov;
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert($data)
	{
		$sql = 'INSERT INTO '.self::$tabela.' (';
		$dbValues = '(';
		if(!array_key_exists("date_created", $data))
		{
			$sql .= 'date_created,';
			$dbValues .= "'".date("Y-m-d H:i:s")."',";
		}
		if(!array_key_exists("date_modified", $data))
		{
			$sql .= 'date_modified,';
			$dbValues .= "'".date("Y-m-d H:i:s")."',";
		}
		if($data['password']!='')
		{
			$data['salt'] = random_string('alnum', 32);
			$data['password'] = sha1($data['password'].$this->encKey.$data['salt']);
		}
		else
		{
			unset($data['password']);
		}
		foreach($data as $key=>$value)
		{
			if($value != null || $value != "")
			{
				$sql .= $key.',';
				$dbValues .= "'".$value."',";
			}
		}
		$sql = trim($sql, ',').') VALUES '.trim($dbValues, ',').')';
		//echo $sql;
		$this->db->query($sql);
		if($this->db->affected_rows() == 1)
		{
			return $this->db->insert_id();
		}
		else {
			return FALSE;
		}
	}
	
	function update($data, $id)
	{
		$this->load->library('encrypt');
		$this->load->helper('string');
		$data['username'] = $this->db->escape_str($data['username']);
		if($data['password']!='')
		{
			$data['salt'] = random_string('alnum', 32);
			$data['password'] = sha1($data['password'].$this->encKey.$data['salt']);
		}
		else
		{
			unset($data['password']);
		}
		$sql = 'UPDATE '.self::$tabela.' SET ';
		if(!array_key_exists("date_modified", $data))
		{
			$sql .= "date_modified='".date("Y-m-d H:i:s")."',";
		}
		foreach($data as $key=>$value)
		{
			if($key == "date_created" && $value == "")
				$sql .= $key."='".date("Y-m-d H:i:s")."',";
			elseif($key == "date_modified" && $value == "")
				$sql .= $key."='".date("Y-m-d H:i:s")."',";
			else $sql .= $key."='".$value."',";
		}
		$sql = trim($sql, ',').' WHERE '.self::$indeks.'='.$id;
		//echo $sql;
		$this->db->query($sql);
		if($this->db->affected_rows() == 1)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	function uloga()
	{
		$id = $this->session->userdata('admin');
		$q = $this->db->query("SELECT uloga FROM admin WHERE id = ".$id." LIMIT 1");
		if($q->num_rows() == 1)
		{
			$row = $q->row();
			return $row->uloga;
		}
		return -1;
	}
	
	function login($username, $password)
	{
		$this->load->library('encrypt');
		$this->load->helper('string');
		$result = FALSE;
		$query = $this->db->query("SELECT id, salt, password FROM ".self::$tabela.
			" WHERE username = '".$username."' LIMIT 1");
		if($query->num_rows() == 1)
		{
			$row = $query->row();
			$new_pass = sha1($password.$this->encKey.$row->salt);
			//die($new_pass);
			if($new_pass == $row->password)
			{
				$result = TRUE;
				
				$rand_str = random_string('alnum', 8);
				$hash_str = $this->encrypt->encode($rand_str);
				
				$sess_data = array(
					'admin' => $row->id,
					'logged_in' => $result,
					'scheck' => $rand_str);
				
				$this->session->set_userdata($sess_data);
				
				$this->db->query("UPDATE ".self::$tabela." SET dbcheck = '".$hash_str.
					"', last_login = NOW() WHERE id = ".$row->id);
			}
		}
		return $result;
	}
	
	function getActiveUser()
	{
		$id = $this->session->userdata('admin');
		return $this->oneObject($id);
	}
	
	function login_check()
	{
		$this->load->library('encrypt');
		//Initialize boolean variable to keep the result from this method outcome.
		$result = FALSE;
		
		if($this->session->userdata('admin') && $this->session->userdata('logged_in') &&
			$this->session->userdata('scheck'))
		{
			$id = $this->session->userdata('admin');
			$scheck = $this->session->userdata('scheck');
			
			$q = $this->db->query("SELECT dbcheck FROM ".self::$tabela." WHERE id = ".$id.
				" LIMIT 1");
			if($q->num_rows() == 1)
			{
				$row = $q->row();
				if($scheck == $this->encrypt->decode($row->dbcheck))
				{
					$result = TRUE;
				}
			}
		}
		return $result;
	}
}
