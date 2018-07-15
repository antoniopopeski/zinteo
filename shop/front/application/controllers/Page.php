<?php

class Page extends CI_Controller{
	function __construct(){
        parent::__construct();
        $this->load->model('translation');
    }
	public function index(){
		$output=array();
		$output['menus']=$this->db->query("SELECT * FROM menus WHERE parent IS NULL AND active = 1 ORDER BY `order` ASC")->result_array();				
		$output['submenus']=$this->db->query("SELECT * FROM menus WHERE active = 1 ORDER BY `order` ASC")->result_array();
		$output['products']=$this->db->query("SELECT * FROM products ORDER BY `id` ASC")->result_array();
		$output['socialnetworks'] = $this->db->query("SELECT * FROM socialnetworks order by id desc")->result_array();
		$output['footerlinks'] = $this->db->query("select * from footerlinks order by `order` asc")->result_array();
		$this->load->view('../../themes/front/index.php',$output);	
	}
	public function page(){
		$output=array();
		//$output['menus']=$this->db->query("SELECT * FROM menus ORDER BY `order` ASC")->result_array();
		$output['menus']=$this->db->query("SELECT * FROM menus WHERE parent IS NULL AND active = 1 ORDER BY `order` ASC")->result_array();				
		$output['submenus']=$this->db->query("SELECT * FROM menus WHERE active = 1 ORDER BY `order` ASC")->result_array();
		$output['products']=$this->db->query("SELECT * FROM products ORDER BY `id` ASC")->result_array();
		$output['socialnetworks'] = $this->db->query("SELECT * FROM socialnetworks order by id desc")->result_array();
		$output['sidebar'] = $this->db->query("SELECT * FROM sidebar order by id asc")->result_array();
		$output['page']=$this->db->query("SELECT * FROM static_pages WHERE id=".$this->uri->segment(3))->result_array();
		$output['footerlinks'] = $this->db->query("select * from footerlinks order by `order` asc")->result_array();
                $output['page']=$output['page'][0];
                //print_r($output['page']);
                $this->load->view('../../themes/front/page.php',$output);	
	}
	
	
	public function shop() {
		$output=array();
		//$output['menus']=$this->db->query("SELECT * FROM menus ORDER BY `order` ASC")->result_array();
		$output['menus']=$this->db->query("SELECT * FROM menus WHERE parent IS NULL AND active = 1 ORDER BY `order` ASC")->result_array();
		$output['submenus']=$this->db->query("SELECT * FROM menus WHERE active = 1 ORDER BY `order` ASC")->result_array();
		$output['products']=$this->db->query("SELECT * FROM products ORDER BY `id` ASC")->result_array();
		$output['socialnetworks'] = $this->db->query("SELECT * FROM socialnetworks order by id desc")->result_array();
		$output['sidebar'] = $this->db->query("SELECT * FROM sidebar order by id asc")->result_array();
		//$output['page']=$this->db->query("SELECT * FROM static_pages WHERE id=".$this->uri->segment(3))->result_array();
		//$output['page']=$output['page'][0];
		//print_r($output['page']);
		$this->load->view('../../themes/front/shop.php',$output);
		
	}
	
	public function contact() {
		
		require $_SERVER["DOCUMENT_ROOT"] . '/application/libraries/PHPMailer/PHPMailerAutoload.php';
		
		$message = "Name: " .$_POST['name'] . "<br/>" . "Email: " .$_POST['email'] . "<br/>" . $_POST['quesiton'];

		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "malotopp@gmail.com";
		$mail->Password = "adenozintrifosfat";
		$mail->SetFrom("malotopp@gmail.com");
		$mail->Subject = "Vetfriend24 contact form";
		$mail->Body = $message;
		$mail->AddAddress("popeskiantonio@gmail.com");
	
		
		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
		}
		
		
		
	}
}
