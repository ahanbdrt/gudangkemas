<?php
class Reportperkode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') != 'ppic' && $this->session->userdata('role') != 'manager') {
            $this->session->set_flashdata('pesan', '<div class="text-center fade show" style="color:red" role="alert">
  Anda Belum Login!
</div><br>');
            redirect('auth/login');
        }
    }

    public function index(){
        $data["master"]=$this->db->get("master")->result();
        $this->load->view("report/reportperkode",$data);
    }

    public function hasil(){
        $id = $this->input->post("kode");
        $start = $this->input->post("start");
        $end = $this->input->post("end");

        $hasil = $this->db->query("SELECT *,master.kode as kdm FROM riwayat,master WHERE master.id = riwayat.kode AND riwayat.tglform >= '$start' AND riwayat.tglform <= '$end' AND riwayat.kode='$id'");
        $no = 0;
        foreach($hasil->result() as $h){
            $data[]=array(
                "no"=>$no=$no+1,
                "start"=>$start,
                "end"=>$end,
                "kode"=>$h->kdm,
                "nama"=>$h->nama,
                "tglform"=>$h->tglform,
                "noform"=>$h->noform,
                "masuk"=>$h->masuk,
                "keluar"=>$h->keluar,
                "saldo"=>$h->saldo,
                "satuan"=>$h->satuan,
                "saldo_akhir"=>$h->masuk-$h->keluar,
            );
        }

        echo json_encode($data);
    }
}