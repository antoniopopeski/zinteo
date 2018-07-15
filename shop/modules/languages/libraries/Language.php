<?php
class Language extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $language;
	protected $code;
	protected $flag;
}