<?php
class Keluar extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') != 'gudang' && $this->session->userdata('role') != 'ppic' && $this->session->userdata('role') != 'manager') {
            $this->session->set_flashdata('pesan', '<div class="text-center fade show" style="color:red" role="alert">
  Anda Belum Login!
</div><br>');
            redirect('auth/login');
        }
    }

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
                "aksi"=>'<a href="'.site_url("gudang/masuk/edit").'"class="btn btn-sm btn-warning"><i class="fas fa-edit fa-md"></i> Edit</a><a href="'.site_url("gudang/masuk/hapus").'"class="mt-1 btn btn-sm btn-danger"><i class="fas fa-trash fa-sm"></i> Hapus</a>'
            );
        }
        echo json_encode($test);
    }
    public function tambahkeluar(){
        $data['master'] = $this->db->order_by('kode','ASC')->get('master')->result();
        $this->load->view("gudang/keluar/tambahkeluar",$data);
    }
}