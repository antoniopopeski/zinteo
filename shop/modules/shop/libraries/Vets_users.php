<?php
class Vets_users extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $vet_name;
	protected $vet_country;
	protected $vet_city;
	protected $vet_user_id;
	protected $vet_datum_submited;
}