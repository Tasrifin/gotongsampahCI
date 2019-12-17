<?php

class DashboardModel extends CI_Model
{

    public function getData($id = null)
    {
        $this->db->select('*');
        $this->db->from('gambar_donasi');
        $this->db->join('donasi', 'donasi.id_donasi = gambar_donasi.id_donasi', 'inner');
        if ($id !== null) { 
            $this->db->where('gambar_donasi.id_donasi',$id);
        }        
        $this->db->order_by("donasi.id_donasi","DESC");
        $data = $this->db->get();
        return $data->result();
    }

    public function mitra($type,$uname){
        $this->db->select('handphone');
        $this->db->from('mitra');
        $this->db->where($type, $uname);
        $rsp = $this->db->get();
        return $rsp->result();
    }

    public function getData_UserInfo($id,$table_)
    {
        $this->db->select('nama,alamat,handphone,email,tanggallahir,jeniskelamin,activationCode');
        $this->db->from($table_);
        if($table_ == "user"){
            $this->db->where('id_user', $id);
        }else{
            $this->db->where('id_mitra', $id);
        }
        $data = $this->db->get();
        return $data->result();     
    }    

    public function updateDonasi($id_donasi,$fkid_user,$judul,$jenis,$jumlah,$desc,$keypicker)
    {
        if($keypicker == null){
            $data = array(
                'fkid_user' => $fkid_user,
                'Judul_Donasi' => $judul,
                'jenis_donasi' => $jenis,
                'jumlah_donasi' => $jumlah,
                'informasi_donasi' => $desc,
            );
        }else{
            $data = array(
                'fkid_user' => $fkid_user,
                'Judul_Donasi' => $judul,
                'jenis_donasi' => $jenis,
                'jumlah_donasi' => $jumlah,
                'informasi_donasi' => $desc,
                'keypicker' => $keypicker,
            );
        }
        $this->db->where('id_donasi',$id_donasi);
        $this->db->update('donasi',$data);
        return $this->db->affected_rows();
    }

    public function getMitraInfo($username_mitra)
    {
        $this->db->select('id_mitra');
        $this->db->where('username',$username_mitra);
        $this->db->from('mitra');
        $data = $this->db->get();
        return $data->result_array();
    }

    public function konfirmasi_donasi($id_donasi,$id_creator,$id_mitra)
    {
        $this->db->set('fkid_mitra', $id_mitra);
        $this->db->where('id_donasi',$id_donasi);
        $this->db->where('fkid_user',$id_creator);
        $data = $this->db->update('donasi');
        return $this->db->affected_rows();
    }

    public function getDel($id_donasi,$id_creator)
    {
        $this->db->select('*');
        $this->db->where('id_donasi',$id_donasi);
        $this->db->where('fkid_user',$id_creator);
        $this->db->from('donasi');
        $data = $this->db->get();
        return $data->result_array();
    }

    public function deleteData($id_donasi){
        $this->db->where('id_donasi',$id_donasi);
        $data = $this->db->delete('donasi');
        return $this->db->affected_rows();
    }
}
