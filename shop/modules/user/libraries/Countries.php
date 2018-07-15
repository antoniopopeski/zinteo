<?php
class Countries extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $continent;
	protected $country;
	protected $available;
}