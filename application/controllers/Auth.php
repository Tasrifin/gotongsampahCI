<?php

class Auth extends CI_Controller {

	public function __construct()
	{	
		parent::__construct();
		$this->load->model('AuthModel');
	}

	public function index()
	{
		$this->check_session();
		redirect('auth/login');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}

	public function login()
	{
		$this->check_session();
		$data = array(
			'title'				=> 'Login ke Gotong Sampah',
		);
		$this->load->view('template/header_auth',$data);
		$this->load->view('auth/login');
	}

	public function tryLogin()
	{
		if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$this->check_session();
			$output = array('error' => false);
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if (isset($username) && isset($password)) {
				$type = $this->input->post('type_login');
				$password = md5($password);
				$data = $this->AuthModel->tryLogin($username, $password, $type);
				if (!$data) {
					$output['error'] = true;
					$output['message'] = 'Login Invalid. User not found';
				} else {
					$this->session->set_userdata('user', $data);
					$this->session->set_userdata('user_type', $type);
					$output['message'] = 'Logging in. Please wait...';
				}

				echo json_encode($output);
			} else {
				$output['error'] = true;
				$output['message'] = 'Go back!';
				echo json_encode($output);
			}
		}else {
			redirect('auth/login');
		}
		
	}


	public function signup()
	{
		$this->check_session();
		$data = array(
			'session_username' 	=> $this->session->username,
			'title'				=> 'Signup ke Gotong Sampah',
		);
		$this->load->view('template/header_auth',$data);
		$this->load->view('auth/signup');
	}


	public function trySignup($type="user")
	{
		if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$this->check_session();
			$type = $this->input->post('type_signup');
			$data = array(
				'title'				=> 'Signup ke Gotong Sampah',
			);
			$this->form_validation->set_rules(
				'username',
				'username',
				'required|is_unique[' . $type . '.username]',
				array(
					'required'      => 'You have not provided %s.',
					'is_unique'     => 'This %s already exists.'
				)
			);
			$this->form_validation->set_rules('password', 'password', 'required');
			$this->form_validation->set_rules('repassword', 'repassword', 'required|matches[password]');
			$this->form_validation->set_rules(
				'email',
				'email',
				'required|valid_email|is_unique[' . $type . '.email]',
				array(
					'required'      => 'You have not provided %s.',
					'is_unique'     => 'This %s already exists.'
				)
			);
			if ($this->form_validation->run() == FALSE) {
				$rsp = validation_errors();
				$rsp = str_replace('<p>', '', $rsp);
				$rsp = str_replace('</p>', '', $rsp);
				$data = array(
					'title'				=> 'Signup ke Gotong Sampah',
					'error'	=> true,
					'msg'	=> $rsp,
				);
			} else {
				$username = $this->input->post('username');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				if(isset($username) && isset($email) && isset($password)){
					$password = md5($password);
					$signup = $this->AuthModel->trySignup($username, $password, $email, $type);
					if($signup){
						$data = array(
							'title'				=> 'Signup ke Gotong Sampah',
							'error'	=> false,
							'msg'	=> 'Berhasil mendaftarkan akun!',
						);
					}else{
						$data = array(
							'title'				=> 'Signup ke Gotong Sampah',
							'error'	=> true,
							'msg'	=> 'Gagal mendaftarkan akun!',
						);
					}
				}else{
					redirect('auth/signup');		
				}
				
			}
			echo json_encode($data);
		}else {
			redirect('auth/signup');
		}
		
	}

	public function sessionCheck()
	{
		echo "<pre>";
		print_r($this->session->user);
		echo "</pre>";
		$data = $this->session->user;
		echo $data['0']['username'];
	}

	public function check_session()
    {
        if($this->session->user !== null){
			redirect('dashboard/index');
        }
        else{
            
        }
    }
}
