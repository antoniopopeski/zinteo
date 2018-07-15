<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('administrator');
        $this->load->library('grocery_CRUD');   
        $this->crud_titles=$this->config->item('crud_titles');
    }
    public function index(){
        $output=array();
        $output['administrator']=$this->administrator->get();
	$this->load->view($this->config->item('theme_path').'default.php',$output);
    }
    
    public function crud(){
        $output=array();
        $output['administrator']=$this->administrator->get();
        $output['crud_controller']=$this->uri->segment('3');
	$output['crud_titles']=$this->crud_titles[$this->uri->segment('3')];
        $this->load->view($this->config->item('theme_path').'crud_container.php',$output);
    }
    
    public function login(){
        $output=array();
        if(@$_POST['username']){
            $admin=$this->administrator->login(@$_POST['username'],@$_POST['password']);
            if($admin){
                redirect(site_url('admin'));
            }
        }
        $this->load->view($this->config->item('theme_path').'login.php',$output);
    }
    public function logout(){
        $this->administrator->logout();
        redirect(site_url('admin'));
    }
    
    
}
