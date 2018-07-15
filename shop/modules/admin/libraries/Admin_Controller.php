<?php
class Admin_Controller extends Controller {
	public function __construct() {
		parent::__construct ();
		
		is_admin_logged ();
	}
}