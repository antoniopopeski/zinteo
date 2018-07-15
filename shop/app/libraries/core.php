<?php

class Core {
	
	public function __construct() {
		
		
	}
	
	
	public function save() {
	
		// get the name of called class
		$_bean = strtolower(get_class($this));
	
		// get all values from class properties
		$vals = $this->to_array();
	
		// create bean with the same name as called class
		$bean = R::dispense( $_bean );
		
		// set properties
		foreach ( $vals as $k=>$v ) {
			$bean->$k = $v;
				
		}

		// save the bean and return last id
		return $last_id = R::store($bean);
	}
	
	
	public function update() {
		
		//  $book = R::load( 'book', $id ); //reloads our book
		
		// get the name of called class
		$_bean = strtolower(get_class($this));
		
		// get all values from class properties
		$vals = $this->to_array();
		
		// load bean with the same name as called class
		$bean = R::dispense( $_bean, $this->getId() );
	}
	

	public function to_array()
	{
		$arr=array();
		foreach(get_class_vars(get_class($this)) as $k=>$v)
		{	
			$arr[$k]=$this->$k;
		}
		return $arr;
	}
	
}