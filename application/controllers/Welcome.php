<?php

class Welcome extends CI_Controller {

	public function __construct()
	{	
		parent::__construct();
		$this->load->model('WelcomeModel');
	}

	public function index()
	{
		$data = array(
			'session_username' => $this->session->username,
		);
		$this->load->view('template/header',$data);
		$this->load->view('welcome/index');
		$this->load->view('template/footer');
	}

	public function sessionCheck()
	{
		echo $this->session->sess_expiration;;
		echo ($this->session->user);
	}
}
