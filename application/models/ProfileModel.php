<?php

class ProfileModel extends CI_Model
{
    public function getDataHistory($id,$type)
    {
        $this->db->select('*');
        $this->db->from('gambar_donasi');
        $this->db->join('donasi', 'donasi.id_donasi = gambar_donasi.id_donasi', 'inner');
        if($type == 'user'){
            $this->db->where('donasi.fkid_user', $id);
        }else{
            $this->db->where('donasi.fkid_mitra', $id);
        }        
        $this->db->order_by("donasi.id_donasi", "DESC");
        $data = $this->db->get();
        return $data->result();
    }

    public function getSettingsInfo($id_user,$type)
    {
        $this->db->select('username,email,alamat,tanggallahir,handphone,jeniskelamin,nama');
        $this->db->from($type);
        $this->db->where('id_'.$type, $id_user);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getUsrInf($id_user,$type){
        $this->db->select('password,email');
        $this->db->from($type);
        $this->db->where('id_'.$type, $id_user);
        $data = $this->db->get()->result();
        return $data;

    }

    public function updateUsrInfo($id_user,$nama, $email, $alamat, $tglLahir, $hp, $jk, $password, $type){
        $data = array(
            'email' => $email,
            'nama' => $nama,
            'handphone' => $hp,
            'password' => $password,
            'tanggallahir' => $tglLahir,
            'jeniskelamin' => $jk,
            'alamat' => $alamat,
        );
        $this->db->where('id_'.$type , $id_user);
        $this->db->update($type,$data);
        return $this->db->affected_rows();
    }


}
