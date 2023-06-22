<?php 
class Test extends CI_Controller{
    public function index(){
        $bulan_awal = $this->db->select("tglform")->FROM("riwayat")->where("kode",2)->order_by("tglform","ASC")->limit(1)->get()->result();
        foreach($bulan_awal as $ba) {
           $tglform =  $ba->tglform;
        }
        $awal = date_create($tglform);
        $akhir = date_create(); // waktu sekarang
        $diff = date_diff($akhir, $awal);
        $bln=$diff->y*12+$diff->m;
        echo $bln;
}
}