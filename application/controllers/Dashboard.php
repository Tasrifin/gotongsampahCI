<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DashboardModel');
    }

    public function index()
    {
        $this->check_session();
        $data = array(
            'title'           => 'Dashboard Gotong Sampah',
            'session_data'    => $this->session->user,
            'type'            => $this->session->user_type,
        );
        $this->load->view('template/header_dashboard', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer');
    }

    public function mitra(){
        $type = $this->input->post('getType');
        $uname = $this->input->post('uname');
        $rsp = $this->DashboardModel->mitra($type,$uname);
        if(!empty($rsp)){
            $dt = array(
                'status' => true,
                'response' => $rsp,
            );
            echo json_encode($dt);
        }else{
            $dt = array(
                'status' => false,
            );
            echo json_encode($dt);
        }
        
    }

    public function konfirmasi()
    {       
        $this->form_validation->set_rules(
            'username_mitra',
            "'Username Mitra'",
            'required'
        );

        if ($this->form_validation->run() == FALSE) {
            $output = array('error' => true);
            $rsp = validation_errors();
            $rsp = str_replace('<p>', '', $rsp);
            $rsp = str_replace('</p>', '', $rsp);
            $output = array(
                'error' => true,
                'msg' => $rsp,
            );
            echo json_encode($output);
        } else {
            $id_donasi = $this->input->post('id_donasi');
            $id_creator = $this->input->post('creator');
            $username_mitra = $this->input->post('username_mitra');
            $id_user = $this->session->user[0]['id_user'];

            if($id_user != $id_creator)
            {
                $output = array(
                    'error' => false,
                    'msg' => 'Tidak dapat merubah data milik user lain!',
                );
                echo json_encode($output);
            }else{
                $dataMitra = $this->DashboardModel->getMitraInfo($username_mitra);
                if (isset($dataMitra)) {
                    $id_mitra = $dataMitra[0]['id_mitra'];
                    $dataDonasi = $this->DashboardModel->konfirmasi_donasi($id_donasi,$id_creator,$id_mitra);
                    if($dataDonasi){
                        $output = array(
                            'error' => false,
                            'msg' => 'Konfirmasi pengambilan donasi berhasil!',
                            'stat' => $dataDonasi,
                        );
                        echo json_encode($output);

                    }else{
                        $output = array(
                            'error' => false,
                            'msg' => 'Konfirmasi pengambilan donasi gagal!',
                        );
                        echo json_encode($output);

                    }
                } else {
                    $output = array(
                        'error' => false,
                        'msg' => 'Username mitra tidak terdaftar!',
                    );
                    echo json_encode($output);
                }
            }    
        }
    }

    public function getData($id = null)
    {
        $this->check_session();
        if ($this->input->POST('id') !== null) {
            $id     = $this->input->POST('id');
        }
        $data   = $this->DashboardModel->getData($id);
        echo json_encode($data);
    }

    public function getData_UserInfo()
    {
        $this->check_session();
        $id = $this->input->POST('id');
        $type = $this->input->POST('type');
        $data    = $this->DashboardModel->getData_UserInfo($id, $type);
        echo json_encode($data);
    }

    public function check_session()
    {
        if ($this->session->user !== null) {
            //good to go
        } else {
            redirect('auth/login');
        }
    }

    public function generateRandomString($length = 30)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function edit()
    {
        $output = array(
            'error' => false,
            'msg' => '',
        );
        $this->load->helper('file');
        $this->form_validation->set_rules(
            'judul_donasi',
            "'judul donasi'",
            'required|max_length[250]'
        );
        $this->form_validation->set_rules(
            'jenis_donasi',
            "'jenis donasi'",
            'required'
        );
        $this->form_validation->set_rules(
            'jumlah_donasi',
            "'jumlah donasi'",
            'required|max_length[11]|greater_than[0.99]'
        );
        $this->form_validation->set_rules(
            'deskripsi_donasi',
            "'deskripsi donasi'",
            'required|max_length[500]'
        );
        if ($this->input->post('update_foto') == "Y") {
            $this->form_validation->set_rules(
                'input_foto',
                "'Foto donasi'",
                'callback_file_check'
            );
        } else {
            //do nothing
        }

        if ($this->form_validation->run() == FALSE) {
            $output = array('error' => true);
            $rsp = validation_errors();
            $rsp = str_replace('<p>', '', $rsp);
            $rsp = str_replace('</p>', '', $rsp);
            $output = array(
                'error' => true,
                'msg' => $rsp,
            );
            echo json_encode($output);
        } else {

            if ($this->input->post('id_user') != $this->session->user[0]['id_user']) {
                $output = array(
                    'error' => true,
                    'msg' => "Tidak dapat merubah data milik orang lain",
                );
                echo json_encode($output);
            } else {

                $fkid_user = $this->session->user[0]['id_user'];
                $id_donasi = $this->input->post('id_donasi');
                $judul = $this->input->post('judul_donasi');
                $jenis = $this->input->post('jenis_donasi');
                $jumlah = $this->input->post('jumlah_donasi');
                $desc = $this->input->post('deskripsi_donasi');
                $desc = $desc.' ';
                $keypicker = time() . $this->generateRandomString();
                $keypicker = $keypicker . '' . $_FILES['input_foto']['name'];
                $keypicker = preg_replace('/\s+/', '', $keypicker);

                $resp = $this->DashboardModel->updateDonasi($id_donasi, $fkid_user, $judul, $jenis, $jumlah, $desc, $keypicker);
                if ($resp) {
                    if ($this->input->post('update_foto') == "Y") {
                        $_FILES['input_foto']['name'] = $keypicker;
                        $config['image_library'] = 'gd2';
                        $config['upload_path'] = './cdn/img';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|pjpeg|x-png';
                        $config['max_size'] = 2048;
                        $this->load->library('upload');
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('input_foto')) {

                            $gbr = $this->upload->data();
                            //Compress Image
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = './cdn/img/' . $gbr['file_name'];
                            $config['create_thumb'] = FALSE;
                            $config['maintain_ratio'] = FALSE;
                            $config['quality'] = '50%';
                            $config['width'] = 800;
                            $config['height'] = 500;
                            $config['new_image'] = './cdn/img/' . $gbr['file_name'];
                            $this->load->library('image_lib', $config);
                            if(!$this->image_lib->resize()){
                                $output = array(
                                    'error' => true,
                                    'msg' => "Berhasil memperbaharui donasi tapi gagal memperbaharui gambar",
                                );
                                echo json_encode($output);
                            }else{
                                $output = array(
                                    'error' => false,
                                    'msg' => "Berhasil memperbaharui donasi beserta gambar",
                                    'id' => $id_donasi,
                                );
                                echo json_encode($output);
                            }

                        }else {
                            $output = array(
                                'error' => true,
                                'msg' => $this->upload->display_errors(),
                            );
                            echo json_encode($output);
                        }
                    } else {
                        $output = array(
                            'error' => false,
                            'msg' => "Berhasil memperbaharui donasi",
                            'id' => $id_donasi,
                        );
                        echo json_encode($output);
                    }
                } else {
                    $output = array(
                        'error' => true,
                        'msg' => "Gagal memperbaharui donasi",
                    );
                    echo json_encode($output);
                }
            }
        }
    }

    public function getDel(){
        $id_donasi = $this->input->get('id_donasi');
        $id_creator = $this->input->get('id_creator');
        $myID = $this->session->user[0]['id_user'];
        if($id_creator != $myID){
            $output = 0;
            
        }
        else{
            $rsp = $this->DashboardModel->getDel($id_donasi,$myID);
            if (empty($rsp)) {
                $output = 0;
            } else {
                $rsp_ = $rsp['0'];
                if (empty($rsp_['fkid_mitra']) && $rsp_['fkid_user'] == $myID) {
                    $output = 1;
                } else if (!empty($rsp_['fkid_mitra']) && $rsp_['fkid_user'] == $myID) {
                    $output = 2;
                } else if ($rsp_['fkid_user'] != $myID) {
                    $output = 0;
                }
            }
            
        }
        echo json_encode($output);
    }

    public function deleteData()
    {
        $id_donasi = $this->input->get('id_donasi');
        $id_creator = $this->input->get('id_creator');
        $myID = $this->session->user[0]['id_user'];
        if($id_creator != $myID){
            $output = 0;
            
        }
        else{
            $rsp = $this->DashboardModel->getDel($id_donasi,$myID);
            if (empty($rsp)) {
                $output = array(
                    'stat' => 0,
                );  
            } else {
                $rsp_ = $rsp['0'];
                if (empty($rsp_['fkid_mitra']) && $rsp_['fkid_user'] == $myID) {
                    //delete picture first
                    
                    $output = array(
                        'stat' => 1,
                    );  
                } else if (!empty($rsp_['fkid_mitra']) && $rsp_['fkid_user'] == $myID) {
                    $output = array(
                        'stat' => 2,
                    );  
                } else if ($rsp_['fkid_user'] != $myID) {
                    $output = array(
                        'stat' => 0,
                    );  
                }
            }            
        }
        echo json_encode($output);

    }





    public function file_check($str)
    {
        $allowed_mime_type_arr = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
        $mime = get_mime_by_extension($_FILES['input_foto']['name']);
        if (isset($_FILES['input_foto']['name']) && $_FILES['input_foto']['name'] != "") {
            if (in_array($mime, $allowed_mime_type_arr)) {
                return true;
            } else {
                $this->form_validation->set_message('file_check', 'Please select only pdf/gif/jpg/png file.');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }
}
