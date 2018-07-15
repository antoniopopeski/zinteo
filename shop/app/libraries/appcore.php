<?php
/*
 * class AppCore this class is main class which is extended by all other classes it purpuse is to handle creating new objects
 */
class AppCore {

	private $_class_name;

	public function getTableName() {
		return $this->_class_name;
	}
	function __construct() {
		$this->_class_name = strtolower ( get_class ( $this ) );
	}
	
	// this is Chuck Norris method!
	public function __call($methodName, $params = null) {
		
		// get the method prefix. It shoyld be get or set
		$methodPrefix = substr ( $methodName, 0, 3 );
		
		// get the method name. Method name is after the get or set prefix
		$key = strtolower ( substr ( $methodName, 3 ) );
		
		if ($methodPrefix == 'set' && count ( $params ) == 1) {
			
			$value = $params [0];
			$this->$key = $value;
			return $this;
		} elseif ($methodPrefix == 'get') {
			return (isset ( $key )) ? $this->$key : false;
		} else {
			exit ( 'Error occured! The method : ' . $methodName . '() is not defined!' );
		}
	}
	public function insert() {
		
		$id = DBApp::conn()->insert( $this->getTableName (), $this->to_array () );
		
		$this->setId ( DBApp::conn()->insert_id() );
		
		return DBApp::conn()->insert_id();
		
	}
	public function update() {
			
		DBApp::conn()->where ( 'id', $this->id );
		
		$ret = DBApp::conn()->update ( $this->getTableName (), $this->to_array () );
		
		//echo DBApp::conn()->last_query(); die;
	
		return $ret;
		
		
	}
	public function delete() {

		DBApp::conn()->where ( 'id', $this->id );
		
		DBApp::conn()->delete ( $this->getTableName () );
		
		//return DBApp::conn()->affected_rows ();
		return ;
	}
	
	static function find($config = array(), &$found_rows = 0) {

	
		/*
		 * $config = array(
		 * 		'id' => 0,
		 * 		'from' => 12,
		 * 		'limit' => 10,
		 * 		'sortby' => 'id',
		 * 		'orderby' => 'asc'
		 * )
		 */
		
		// get only one row
		
		if (isset($config['id'])) {
	
		
		$query  = DBApp::conn()
				->select()
				->where ( 'id', $config['id'] )
				->limit ( 1 );
	
	 	$result = $query->get(strtolower(get_called_class()))->as_class(get_called_class()); 
	 	
	
		return ( $result ) ? $result[0] : false;
			
		} else {
			
			//hs_debug( $config );
			
			// make sure we have default values
			if (!isset($config['from'])) $config['from'] = 0;
			if (!isset($config['limit'])) $config['limit'] = 1000;
			if (!isset($config['sortby'])) $config['sortby'] = 'id';
			if (!isset($config['orderby'])) $config['orderby'] = 'asc';
			
			//hs_debug( $config );
		
			$query = DBApp::conn()
					->select("SQL_CALC_FOUND_ROWS *", false )
					->limit($config['limit'], $config['from'])
					->order_by($config['sortby'], $config['orderby']);
	
			$_called_class = "`" . get_called_class() . "`";
			$_called_class = strtolower($_called_class);
			
			$result = $query->get( $_called_class )->as_class(get_called_class());
			
			//echo DBApp::conn()->last_query();
			
			$found_rows = DBApp::conn()->query ( "SELECT FOUND_ROWS() as found_rows" )->row ()->found_rows;
			
			return $result;
		
		}
		
		//return $query->result ( get_called_class () );
	
	}
	
	
	static function remove($id = 0, $col = 'id') {
	
		DBApp::conn()->where ( $col, $id );
		
		DBApp::conn()->delete ( strtolower(get_called_class()) );
		
		//return DBApp::conn()->affected_rows ();
		return ;
	}
	
	static function findByColumn($column) {}
	
	// This function gets called class and make an array with class' properties.
	// we need this function for the insert method for easier management.
	public function to_array() {
		
		$arr = array ();
		
		foreach ( get_class_vars ( get_class ( $this ) ) as $k => $v ) {
			
			$skip_fields = array('_class_name'); // add more if needed
			
			if ( in_array($k, $skip_fields) )
				continue; // dont take class name attributite to insert!
			$arr [$k] = $this->$k;
		}
		
		return $arr;
	}
	
}