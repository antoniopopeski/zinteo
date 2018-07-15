<?php
class Products extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		
		loader::lib ( "ProductCategory" );
		loader::lib ( "Stock" );
	}
	public function index() {
		$data = array ();
		$data ['main'] = "products/index";
		$data ['page_title'] = lang ( "Products" );
		
		$data ['products'] = Product::find ();
		
		return view ( "../theme/admin", $data, false );
	}
	public function insert() {
		$data = array ();
		$data ['main'] = "products/insert";
		$data ['page_title'] = lang ( "Products - Insert product" );
		
		$data ['categories'] = ProductCategory::find ();
		// $data['currency'] = Currency::find();
		
		$form = lib ( 'ob/validator' );
		
		if (i_post ()) {
			
			$form->set_rules ( 'name', lang ( "Name" ), 'required|xss_clean|min_len[2]|max_len[500]' );
			$form->set_rules ( 'active', lang ( "Active" ), 'required|xss_clean' );
			$form->set_rules ( 'productcategoryid', lang ( "Category" ), 'required|xss_clean' );
			$form->set_rules ( 'eurprice', lang ( "Price EUR" ), 'required|xss_clean' );
			$form->set_rules ( 'plnprice', lang ( "Price PLN" ), 'required|xss_clean' );
			$form->set_rules ( 'gbpprice', lang ( "Price GBP" ), 'required|xss_clean' );
			
			// check for validation
			if ($form->run () === FALSE) {
				// validation fail!
				// reload same page with validation errors displayed
				return view ( "../theme/admin", $data, false );
			}
			
			$image_path = "";
			if (strpos ( $_SERVER ["HTTP_HOST"], "kriipton" ) !== false) {
				require $_SERVER ['DOCUMENT_ROOT'] . "/shop/app/libraries/upload.php";
			} else {
				require $_SERVER ['DOCUMENT_ROOT'] . "/app/libraries/upload.php";
			}
			$image = new Upload ( $_FILES ['image'] );
			if ($image->uploaded) {
				$image->Process ( $_SERVER ["DOCUMENT_ROOT"] . "/public/" );
				$image_path = "/public/" . $image->file_src_name;
			}
			
			$product = new Product ();
			
			$product->setName ( i_post ( 'name' ) )->setProductCategoryId ( i_post ( 'productcategoryid' ) )->setDescription ( i_post ( "description" ) )->setImage ( $image_path )->setPlnPrice ( i_post ( 'plnprice' ) )->setEurPrice ( i_post ( 'eurprice' ) )->setGbpPrice ( i_post ( 'gbpprice' ) )->setCreated ( date ( "Y-m-d H:i:s" ) )->setActive ( i_post ( 'active' ) );
			
			$type = i_post ( 'type' );
			$_type = "";
			if ($type) {
				if (count ( $type ) == 2) { // both selected
					$_type = 3;
				} else {
					$_type = current ( $type );
				}
				
				$product->setType ( $_type );
			}
			$pid = $product->insert ();
			
			// save product in stock too
			$stock = new Stock ();
			
			$stock->setProductId ( $pid )->setProductCategoryId ( i_post ( 'productcategoryid' ) )->setCount ( 0 );
			
			$stock->insert ();
			
			log_me ( 'debug', '[ admin ]: New Product was added : ' . i_post ( 'name' ) );
			
			// sess_set_flash ( 'success', lang ( 'Question was succesfuly edited' ) );
			
			// redirect to index page with messages displayed
			redirect ( "/admin/products/index" );
		}
		
		return view ( "../theme/admin", $data, false );
	}
	public function edit($id) {
		$data = array ();
		$data ['main'] = "products/edit";
		$data ['page_title'] = lang ( "Products - Edit product" );
		
		$data ['product'] = Product::find ( array (
				'id' => $id 
		) );
		$data ['categories'] = ProductCategory::find ();
		// $data['currency'] = Currency::find();
		
		$form = lib ( 'ob/validator' );
		
		if (i_post ()) {
			
			$form->set_rules ( 'name', lang ( "Name" ), 'required|xss_clean|min_len[2]|max_len[500]' );
			$form->set_rules ( 'active', lang ( "Active" ), 'required|xss_clean' );
			$form->set_rules ( 'productcategoryid', lang ( "Category" ), 'required|xss_clean' );
			$form->set_rules ( 'eurprice', lang ( "Price EUR" ), 'required|xss_clean' );
			$form->set_rules ( 'plnprice', lang ( "Price PLN" ), 'required|xss_clean' );
			$form->set_rules ( 'gbpprice', lang ( "Price GBP" ), 'required|xss_clean' );
			
			// check for validation
			if ($form->run () === FALSE) {
				// validation fail!
				// reload same page with validation errors displayed
				return view ( "../theme/admin", $data, false );
			}
			
			$image_path = "";
			if (strpos ( $_SERVER ["HTTP_HOST"], "kriipton" ) !== false) {
				require $_SERVER ['DOCUMENT_ROOT'] . "/shop/app/libraries/upload.php";
			} else {
				require $_SERVER ['DOCUMENT_ROOT'] . "/app/libraries/upload.php";
			}
			$image = new Upload ( $_FILES ['image'] );
			if ($image->uploaded) {
				$image->Process ( $_SERVER ["DOCUMENT_ROOT"] . "/public/" );
				$image_path = "/public/" . $image->file_src_name;
			}
			
			// print_r($image); die;
			$product = Product::find ( array (
					'id' => i_post ( 'pid' ) 
			) );
			
			if ($image_path != "")
				$product->setImage ( $image_path );
			
			$product->setName ( i_post ( 'name' ) )->setProductCategoryId ( i_post ( 'productcategoryid' ) )->setDescription ( i_post ( "description" ) )->setPlnPrice ( i_post ( 'plnprice' ) )->setEurPrice ( i_post ( 'eurprice' ) )->setGbpPrice ( i_post ( 'gbpprice' ) )->setModified ( date ( 'Y-m-d H:i:s' ) )->setActive ( i_post ( 'active' ) );
			
			$type = i_post ( 'type' );
			$_type = "";
			if ($type) {
				if (count ( $type ) == 2) { // both selected
					$_type = 3;
				} else {
					$_type = current ( $type );
				}
				
				$product->setType ( $_type );
			}
			
			$pid = $product->update ();
			
			log_me ( 'debug', '[ admin ]: Product was edited: ' . i_post ( 'name' ) );
			
			// sess_set_flash ( 'success', lang ( 'Question was succesfuly edited' ) );
			
			// redirect to index page with messages displayed
			redirect ( "/admin/products/index" );
		}
		
		return view ( "../theme/admin", $data, false );
	}
	public function delete($id) {
		Product::remove ( $id );
		
		$stock = Stock::getByProductId ( $id );
		foreach ( $stock as $s ) {
			$s->delete ();
		}
		
		$stockhistory = StockHistory::getByProductId ( $id );
		foreach ( $stockhistory as $sh ) {
			$sh->delete ();
		}
		
		redirect ( "/admin/products/index" );
	}
}
