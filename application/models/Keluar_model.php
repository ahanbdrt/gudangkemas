<?php
class Keluar_model extends CI_Model{
    public function getkeluar(){
        $this->db->select("master.kode,master.nama,grup.namagrup,grup.namasubgr,riwayat.noform,riwayat.tglform,riwayat.keluar,riwayat.suplai,riwayat.cat,riwayat.tgltrima,riwayat.no,master.id as idm")
        ->from("riwayat,master,grup")
        ->where("master.id=riwayat.kode and master.kdgrup=grup.kdgrup and master.kdsubgrup=grup.kdsubgr and keluar>0")
        ->order_by("riwayat.no","DESC");
        return $this->db->get()->result();
    }
}