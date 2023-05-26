<?php
class Masuk_model extends CI_Model{
    public function getmasuk(){
        $this->db->select("master.kode,master.id as idm,master.nama,riwayat.noform,riwayat.tglform,riwayat.masuk,riwayat.suplai,riwayat.cat,riwayat.tgltrima,riwayat.no")
        ->from("riwayat,master")
        ->where("master.id=riwayat.kode and masuk>0")
        ->order_by("riwayat.no","DESC");
        return $this->db->get()->result();
    }
}