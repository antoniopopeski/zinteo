<?php
class DBApp  extends  Singleton {
	
	public function __construct() {
			log_me("debug", get_called_class() . " loaded!");
	}
	
	static public function conn() {
		loader::database();
		$db = this();
		return $db->db;
	}
}