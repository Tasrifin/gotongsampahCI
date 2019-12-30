<?php

class AuthModel extends CI_Model{

    public function tryLogin($username, $password, $type){
        $where = "username like binary '".$username."' AND password like binary '".$password."'";
        $this->db->where($where);
        $data = $this->db->get($type);
        return $data->result_array();
    }

    public function trySignup($username,$password,$email,$type, $activationCode)
    {
        $data = array(
            'username'  => $username,
            'password'  => $password,
            'email'     => $email,
            'activationCode'     => $activationCode,
        );
        $response = $this->db->insert($type,$data);
        return $response;
    }

    public function activate($type, $activationCode)
    {
        $this->db->set('activationCode', null);
        $this->db->where('activationCode', $activationCode);
        $this->db->update($type);
        return $this->db->affected_rows();
    }

}