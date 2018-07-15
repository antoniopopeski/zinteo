<?php
class Login extends CI_Controller
{	
	function index()
	{
		$errors = $this->session->userdata("poraka");
		$data = array("title" => "Login", "username" => "", "login_errors" => $errors, 
				"content" => "login_view");
		$this->session->unset_userdata("poraka");
		$this->load->view("template", $data);
	}

	function logiranje()
	{

		$sessionData = $this->session->all_userdata();
		$broj = array_shift($this->db->query("SELECT COUNT(ID) as broj FROM admin")->result_array());
		$this->load->model('admin_model');
		if($broj['broj']>0)
		{
			if($this->admin_model->login($this->input->post('username'),
				$this->input->post('password')))
			{
				redirect("admin_home");
			}
			else
			{
				$sessionData["poraka"] = "Wrong username and/or password";
			}

		}
		else
		{
			$data = array("username" => $this->input->post('username'),"password" => $this->input->post('password'),
					"fname" => "Administrator", "uloga" => 2);
			$this->admin_model->insert($data);
			if($this->admin_model->login($this->input->post('username'),
					$this->input->post('password')))
			{
				redirect("admin_home");
			}
		}
		$this->session->set_userdata($sessionData);
		redirect("login");
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
