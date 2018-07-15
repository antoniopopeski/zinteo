<?php

class Page extends CI_Controller{
	function __construct(){
        parent::__construct();
        $this->load->model('translation');
    }
	public function index(){
		$output=array();
		$output['menus']=$this->db->query("SELECT * FROM menus ORDER BY `order` ASC")->result_array();
		$output['products']=$this->db->query("SELECT * FROM products ORDER BY `id` ASC")->result_array();
		$this->load->view('../../themes/front/index.php',$output);	
	}
	public function page(){
		$output=array();
		$output['menus']=$this->db->query("SELECT * FROM menus ORDER BY `order` ASC")->result_array();
		$output['products']=$this->db->query("SELECT * FROM products ORDER BY `id` ASC")->result_array();
		$output['page']=$this->db->query("SELECT * FROM static_pages WHERE id=".$this->uri->segment(3))->result_array();
                $output['page']=$output['page'][0];
                //print_r($output['page']);
                $this->load->view('../../themes/front/page.php',$output);	
	}
}
