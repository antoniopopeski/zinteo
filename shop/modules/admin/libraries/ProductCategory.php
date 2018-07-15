<?php
class ProductCategory extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $name;
	protected $order;
	protected $active;
	protected $image;
	protected $description;
	protected $created;
	protected $modified;
}