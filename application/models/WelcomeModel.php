<?php

class WelcomeModel extends CI_Model{

    public function tryLogin($username, $password, $type){
        $where = "username like binary '".$username."' AND password like binary '".$password."'";
        $this->db->where($where);
        $data = $this->db->get($type);
        return $data->result_array();


    }

}