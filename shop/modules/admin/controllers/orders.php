<?php
class Orders extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		
		loader::lib ( "PaymentType" );
		loader::lib ( "Product" );
		loader::lib ( "Order" );
		loader::lib ( '../user/User' );
		loader::lib ( '../shop/Veterinars' );
		loader::lib ( '../shop/DeliveryAddress' );
	}
	public function index() {
		$data = array ();
		$data ['main'] = "orders/index";
		$data ['page_title'] = lang ( "Orders" );
		
		$data ['orders'] = Order::find ( array (
				'orderby' => 'desc',
				'sortby' => 'id' 
		) );
		
		return view ( "../theme/admin", $data, false );
	}

	public function paidornot(){
		$orderid=i_post('orderid');
		$order=Order::find(array('id'=>$orderid));
		if($order->getPaid()){
			$order->setPaid(0);
		} else {
			$order->setPaid(1);
		}
		$order->update();
		$order=Order::find(array('id'=>$orderid));
		if($order->getPaid()){
			echo "Yes";
		} else {
			echo "No";
		}
	}

	public function status(){
		$orderid=i_post('orderid');
		$order=Order::find(array('id'=>$orderid));
		if($order->getStatus()){
			$order->setStatus(0);
		} else {
			$order->setStatus(1);
		}
		$order->update();
		$order=Order::find(array('id'=>$orderid));
		if($order->getStatus()){
			echo "Yes";
		} else {
			echo "No";
		}
	}

}
