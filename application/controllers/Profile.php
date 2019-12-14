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
        $this->check_session();
        $data = array(
            'title'           => 'Setting Akun '.$this->session->user_type.' Gotong Sampah',
            'session_data'    => $this->session->user,
            'type'            => $this->session->user_type,
        );
        $this->load->view('template/header_dashboard', $data);
        $this->load->view('profile/settings', $data);
        $this->load->view('template/footer');
    }

    public function tryUpdateUser()
    {
        $this->check_session();
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $username = $this->input->post('username');
            $myID = $this->session->user[0]['username'];
            $type = $this->session->user_type;
            if($username == $myID)
            {
                $data = array(
                    'title'				=> 'Signup ke Gotong Sampah',
                );
                $this->form_validation->set_rules('name', 'name', 'required');

                $this->form_validation->set_rules('Alamat', 'Alamat', 'required');
                $this->form_validation->set_rules('tanggallahir', 'tanggallahir', 'required');
                $this->form_validation->set_rules('handphone', 'handphone', 'required|min_length[9]');
                $this->form_validation->set_rules('jenisKelamin', 'jenisKelamin', 'required');
                $this->form_validation->set_rules('inputPassword', 'inputPassword', 'required');
                $this->form_validation->set_rules('inputnewPassword', 'inputnewPassword', 'required|min_length[8]');
                
                
                if ($this->form_validation->run() == FALSE) {
                    $rsp = validation_errors();
                    $rsp = str_replace('<p>', '', $rsp);
                    $rsp = str_replace('</p>', '', $rsp);
                    $data = array(
                        'error'	=> true,
                        'msg'	=> $rsp,
                    );
                    echo json_encode($data);
                } else {
                    $username = $this->input->post('username');
                    $nama = $this->input->post('nama');
                    $email = $this->input->post('email');
                    $alamat = $this->input->post('Alamat');
                    $tglLahir = $this->input->post('tanggallahir');
                    $hp = $this->input->post('handphone');
                    $jk = $this->input->post('jenisKelamin');
                    $oldpassword = $this->input->post('inputPassword');
                    $password = $this->input->post('inputnewPassword');

                    //perform check old password!
                    $id_user = $this->session->user[0]['id_' . $type];
                    $data = $this->ProfileModel->getUsrInf($id_user, $type);
                    if($data[0]->password == md5($oldpassword)){
                        $data = array(
                            'error'	=> true,
                            'msg'	=> 'ntap',
                        );
                        echo json_encode($data);
                    }else{
                        $data = array(
                            'error'	=> true,
                            'msg'	=> 'Password lama tidak sesuai, perubahan data ditolak!',
                        );
                        echo json_encode($data);
                    }
                }
            }else{
                $data = array(
                    'title'				=> 'Signup ke Gotong Sampah',
                    'error'	=> true,
                    'msg'	=> 'Tidak dapat mengakses data milik orang lain!',
                );
                echo json_encode($data);
            }
            
        } else {
            redirect('dashboard/');
        }
    }

    public function getSettingsInfo()
    {
        $this->check_session();
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $type = $this->session->user_type;
            $id_user = $this->session->user[0]['id_'.$type];
            $data = $this->ProfileModel->getSettingsInfo($id_user,$type);
            echo json_encode($data);
        } else {
            redirect('dashboard/');
        }
    }


    public function history()
    {
        $this->check_session();
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
