<?php
class Master_model extends CI_Model{
    public function getmaster(){
        return $this->db->order_by('kode',"ASC")->get("master")->result();
    }
    public function tambah($data,$table){
        $this->db->insert($table,$data);
    }
}