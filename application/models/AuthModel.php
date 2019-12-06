<?php

class AuthModel extends CI_Model{

    public function tryLogin($username, $password, $type){
        $where = "username like binary '".$username."' AND password like binary '".$password."'";
        $this->db->where($where);
        $data = $this->db->get($type);
        return $data->result_array();
    }

    public function trySignup($username,$password,$email,$type)
    {
        $data = array(
            'username'  => $username,
            'password'  => $password,
            'email'     => $email,
        );
        $response = $this->db->insert($type,$data);
        return $response;
    }

}