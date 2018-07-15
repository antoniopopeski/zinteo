<?php

class Form {
	
	protected  $label;
	protected  $required;
	protected  $_inputtext;
	
	public function setLabel( $label ) {
		$this->label = $label;
		return $this;
	}
	
	public function getLabel() {
		return $this->label;
	}
	
	public function required($required = "required") {
		 $this->required = $required;
		 return $this;
	}
	
	public function __construct() {
		
	}
	
	public  function text() {
		
				
		$this->_inputtext = '<div class="form-group">
                                    <label class="col-md-3 control-label ui-sortable">'. $this->getLabel() .'</label>
                                    <div class="col-md-9 ui-sortable">
                                        <input type="text" placeholder="Default input"  required="'.$this->required.'" class="form-control">
                                    </div>
                            </div>';

		//return get_called_class();
		return $this;
		//echo $this->_inputtext;
	}
	
	
 	public function __toString()
    {
		echo $this->_inputtext;
    }
}