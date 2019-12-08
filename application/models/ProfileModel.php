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
}
