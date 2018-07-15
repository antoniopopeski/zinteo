<?php
/**
 * Description of Administrator
 *
 * @author mihajlo.siljanoski
 */
class Administrator extends CI_Model{
    function login($username='',$password=''){
        @session_start();
        if(!$_SESSION[$this->config->item('app_id')]){
            $_SESSION[$this->config->item('app_id')]=array();
        }
        $admin=$this->db->query("SELECT * FROM admins WHERE username='".mysql_real_escape_string($username)."' AND password='".mysql_real_escape_string($password)."' LIMIT 1")->result_array();
        if(count($admin)){
            $_SESSION[$this->config->item('app_id')]['logged']=$admin[0];
            return $_SESSION[$this->config->item('app_id')]['logged'];
        }
        return false;
    }
    
    function logout(){
        @session_start();
        $_SESSION[$this->config->item('app_id')]=array();
    }
    
    function get(){
        @session_start();
        //print_r($_SESSION[$this->config->item('app_id')]);
       // exit;
        if(!$_SESSION[$this->config->item('app_id')]){
        	$_SESSION[$this->config->item('app_id')]=array();
        }
        
        if(@$_SESSION[$this->config->item('app_id')]['logged']){
            return @$_SESSION[$this->config->item('app_id')]['logged'];
        }
        else{
            redirect('admin/login');
        }
    }
}