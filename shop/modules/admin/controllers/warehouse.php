<?php
class Warehouse extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		
		loader::lib ( "ProductCategory" );
	}
	public function index() {
		$data = array ();
		$data ['main'] = "warehouse/index";
		$data ['page_title'] = lang ( "Warehous & Logs" );
		
		$data ['stockhistory'] = StockHistory::find ( array (
				'orderby' => 'desc' 
		) );
		
		return view ( "../theme/admin", $data, false );
	}
	public function insert() {
		$data = array ();
		$data ['main'] = "warehouse/insert";
		$data ['page_title'] = lang ( "Warehous & Logs" );
		$data ['categories'] = ProductCategory::find ();
		
		$form = lib ( 'ob/validator' );
		
		if (i_post ()) {
			
			$form->set_rules ( 'productcategoryid', lang ( "Product" ), 'required|xss_clean' );
			$form->set_rules ( 'productid', lang ( "Variant" ), 'required|xss_clean' );
			$form->set_rules ( 'count', lang ( "Value" ), 'required|xss_clean' );
			
			// check for validation
			if ($form->run () === FALSE) {
				// validation fail!
				// reload same page with validation errors displayed
				return view ( "../theme/admin", $data, false );
			}
			
			$stock = Stock::getByProductId ( i_post ( 'productid' ) );
			$stock = current ( $stock );
			
			// exist
			if ($stock->getId ()) {
				$oldcount = $stock->getCount ();
				
				$stock->setCount ( $oldcount+i_post ( 'count' ) );
				$stock->update ();
				
				$stockhistory = new StockHistory ();
				$stockhistory->setProductId ( i_post ( 'productid' ) )->setProductCategoryId ( i_post ( 'productcategoryid' ) )->setOldCount ( $oldcount )->setNewCount ( $oldcount+i_post ( 'count' ) )->setDate ( date ( 'Y-m-d H:i:s' ) )->setUserId ( 1 );
				
				$stockhistory->insert ();
				
				// set instock flag 1
				$instock = i_post ( 'count' ) != 0 ? 1 : 0;
				$product = Product::find ( array (
						'id' => i_post ( 'productid' ) 
				) );
				$product->setInStock ( $instock );
				$product->update ();
			} else {
				
				// not exist insert new
				$stock = new Stock ();
				$stock->setProductId ( i_post ( 'productid' ) )->setProductCategoryId ( i_post ( 'productcategoryid' ) )->setCount ( i_post ( 'count' ) );
				
				$stock->insert ();
				
				$stockhistory = new StockHistory ();
				$stockhistory->setProductId ( i_post ( 'productid' ) )->setProductCategoryId ( i_post ( 'productcategoryid' ) )->setOldCount ( 0 )->setNewCount ( i_post ( 'count' ) )->setDate ( date ( 'Y-m-d H:i:s' ) )->setUserId ( 1 );
				
				$stockhistory->insert ();
			}
			
			log_me ( 'debug', '[ admin ]: New Product was added in stock : ' . i_post ( 'productid' ) );
			
			// sess_set_flash ( 'success', lang ( 'Question was succesfuly edited' ) );
			
			// redirect to index page with messages displayed
			redirect ( "/admin/warehouse/index" );
		}
		
		return view ( "../theme/admin", $data, false );
	}
	public function a_getproducts() {
		if (i_ajax ()) {
			$productcategoryid = i_post ( 'productcategoryid' );
			
			$products = Product::getByProductCategoryId ( $productcategoryid );
			
			$products_arr = array ();
			
			foreach ( $products as $product ) {
				array_push ( $products_arr, array (
						'id' => $product->getId (),
						'name' => $product->getName () 
				) );
			}
			
			echo json_encode ( $products_arr );
		}
	}
	public function a_getproductcount() {
		if (i_ajax ()) {
			$productid = i_post ( "productid" );
			
			$product = Stock::getByProductId ( $productid );
			$product = current ( $product ); // returns first index
			
			$_count = 0;
			
			if (isset ( $product )) {
				$_count = $product->getCount ();
			}
			
			echo json_encode ( array (
					'count' => $_count 
			) );
		}
	}
}