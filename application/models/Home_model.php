<?php
class Home_model extends CI_Model{
    public function gethome(){
        $this->db->select("master.kode,master.nama,master.satuan,master.tglmas,grup.namagrup,grup.namasubgr,saldo.saldo")
        ->from("master,grup,saldo")
        ->where("saldo.kode=master.id and master.kdgrup = grup.kdgrup and master.kdsubgrup = grup.kdsubgr")
        ->order_by("kode", "ASC");
        return $this->db->get()->result();
    }
    public function getriwayat(){
        $this->db->select("master.kode,master.nama,grup.namagrup,grup.namasubgr,riwayat.noform,riwayat.tglform,riwayat.keluar,riwayat.masuk")
        ->from("riwayat,master,grup")
        ->where("master.id=riwayat.kode and master.kdgrup=grup.kdgrup and master.kdsubgrup=grup.kdsubgr")
        ->order_by("riwayat.no","DESC");
        return $this->db->get()->result();
    }
}