<?php
class Product extends AppCore {
	public function __construct() {
		parent::__construct ();
	}
	protected $id;
	protected $name;
	protected $description;
	// protected $propirties;
	protected $image;
	protected $plnprice;
	protected $eurprice;
	protected $gbpprice;
	protected $active;
	protected $instock;
	protected $productcategoryid;
	protected $created;
	protected $modified;
	protected $type; // 1 for dog, 2 for cat, 3 for both
	public static function getByProductCategoryId($pid = 0) {
		$query = DBApp::conn ()->select ()->where ( "productcategoryid", $pid );
		
		$result = $query->get ( strtolower ( get_called_class () ) )->as_class ( get_called_class () );
		
		return ($result) ? $result : new self ();
	}
	public static function getVariantsInStock($filter = array()) {
		
		$first_fillter_sql = "";
		$last_fillter_sql = "";
		
		if (isset($filter['first_serach'])) {
			
			if ($filter['first_serach'] == 'only_dogs') {
				$first_fillter_sql = " and p.type = 1 ";
			}
			if ($filter['first_serach'] == 'only_cats') {
				$first_fillter_sql = ' and p.type = 2';
			}
		}
		
		if (isset($filter['last_search'])) {
			if ($filter['last_search'] == 'date') {
				$last_fillter_sql = ' order by p.modified desc ';
			}
			if ($filter['last_search'] == 'name') {
				$last_fillter_sql = ' order by p.name desc ';
			}
			if ($filter['last_search'] == 'price_asc') {
				$last_fillter_sql = ' order by p.eurprice asc ';
			}
			
			if ($filter['last_search'] == 'price_desc') {
				$last_fillter_sql = ' order by p.eurprice desc ';
			}
		}

		if(isset($filter['brand'])){
			if($filter['brand']=='all'){
				$brand='';
			} else {
				$brand="and pc.id='".$filter['brand']."'";
			}
		} else{
			$brand='';
		}
		
		$sql = "select 
 			p.id as variantid,
			pc.id as productid,
			p.name as variantname,
			pc.name as productname,
			p.description as variantdescription,
			p.type,	
			(case when p.image is not null then p.image else pc.image end ) as image,
			p.plnprice as variantplnprice,
			p.eurprice as varianteurprice,
			p.gbpprice as variantgbpprice
			from product p
			join productcategory pc
			on pc.id = p.productcategoryid
				where p.instock != 0 and p.active = 1 ".$brand." ".$first_fillter_sql."
				" . $last_fillter_sql;
		
		
		
		$query = DBApp::conn ()->query ( $sql );
		$result = $query->result ( 'array' );
		
		return $result;
	}
}