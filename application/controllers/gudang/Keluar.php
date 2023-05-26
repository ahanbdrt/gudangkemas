<?php
class Keluar extends CI_Controller{
    public function index(){
        $this->load->view("gudang/keluar/keluar");
    }
    public function getkeluar(){
        $data = $this->Keluar_model->getkeluar();
        $i=0;
        foreach($data as $d) {
            $test[] = array(
                "no"=>$i=$i+1,
                "kode"=>$d->kode,
                "nama"=>$d->nama,
                "namagrup"=>$d->namagrup,
                "namasubgr"=>$d->namasubgr,
                "noform"=>$d->noform,
                "tglform"=>$d->tglform,
                "keluar"=>$d->keluar,
                "tgltrima"=>$d->tgltrima,
                "cat"=>$d->cat,
                "aksi"=>'<a href="'.site_url("gudang/masuk/edit").'"class="btn btn-sm btn-warning"><i class="fas fa-edit fa-sm"></i> Edit</a><a href="'.site_url("gudang/masuk/hapus").'"class="mt-1 btn btn-sm btn-danger"><i class="fas fa-trash fa-sm"></i> Hapus</a>'
            );
        }
        echo json_encode($test);
    }
}