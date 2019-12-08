<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProfileModel');
    }

    public function index(){
        redirect('profile/settings');
    }

    public function settings()
    {
        
    }

    public function history()
    {
        $data = array(
            'title'           => 'History '.$this->session->user_type.' Gotong Sampah',
            'session_data'    => $this->session->user,
            'type'            => $this->session->user_type,
        );
        $this->load->view('template/header_dashboard', $data);
        $this->load->view('profile/history', $data);
        $this->load->view('template/footer');
    }

    public function getDataHistory($id = null)
    {
        $this->check_session();
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $type = $this->session->user_type;
            $id     = $this->session->user[0]['id_' . $type];
            $data   = $this->ProfileModel->getDataHistory($id, $type);
            echo json_encode($data);
        } else {
            redirect('dashboard/');
        }
    }

    public function check_session()
    {
        if ($this->session->user !== null) {
            //good to go
        } else {
            redirect('auth/login');
        }
    }
}
