<?php
class Master_model extends CI_Model{
    public function getmaster(){
        return $this->db->order_by('kode',"ASC")->get("master")->result();
    }
}