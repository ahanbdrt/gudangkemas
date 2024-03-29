<?php
class Home extends CI_Controller{
    public function index(){
        $this->load->view('home');
    }
    public function gethome(){
        $data = $this->Home_model->gethome();
        $i=0;
        foreach($data as $d) {
            $test[] = array(
                "id"=>$i=$i+1,
                "kode"=>$d->kode,
                "nama"=>$d->nama,
                "satuan"=>$d->satuan,
                "saldo"=>$d->saldo,
                "namagrup"=>$d->namagrup,
                "namasubgr"=>$d->namasubgr,
                "tglmas"=>$d->tglmas,
            );
        }
        echo json_encode($test);
    }
    public function getriwayat(){
        $data = $this->Home_model->getriwayat();
        $i=0;
        foreach($data as $d) {
            if($d->keluar==0){
                $qty=$d->masuk;
                $ket="IN";
            }else{
                $qty=$d->keluar;
                $ket="OUT";
            }
            $test[] = array(
                "no"=>$i=$i+1,
                "kode"=>$d->kode,
                "nama"=>$d->nama,
                "namagrup"=>$d->namagrup,
                "namasubgr"=>$d->namasubgr,
                "noform"=>$d->noform,
                "tglform"=>$d->tglform,
                "qty"=>$qty,
                "ket"=>$ket,
            );
        }
        echo json_encode($test);
    }
}