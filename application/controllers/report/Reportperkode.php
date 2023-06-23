<?php
/**
 * @property  session $session
 * @property  input $input
 * @property  db $db
 * 
 */
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
        $sa = $this->db->query("SELECT sum(masuk)-sum(keluar) as saldo_awal FROM master LEFT JOIN riwayat on riwayat.kode=master.id and tglform<'$start' where master.id='$id' order by master.id");
        foreach($sa->result() as $sa){
            $saldo_awal=$sa->saldo_awal;
        }

        $hasil = $this->db->query("SELECT *,master.kode as kdm FROM riwayat,master WHERE master.id = riwayat.kode AND riwayat.tglform >= '$start' AND riwayat.tglform <= '$end' AND riwayat.kode='$id' order by riwayat.tglform");
        $no = 0;
        foreach($hasil->result() as $h){
            if($h->masuk==null){
                $h->masuk=0;
            }
            if($h->keluar==null){
                $h->keluar=0;
            }
            $data[]=array(
                "no"=>$no=$no+1,
                "start"=>$start,
                "end"=>$end,
                "kode"=>$h->kdm,
                "nama"=>$h->nama,
                "tglform"=>$h->tglform,
                "noform"=>$h->noform,
                "saldo_awal"=>$saldo_awal,
                "masuk"=>$h->masuk,
                "keluar"=>$h->keluar,
                "saldo"=>$h->saldo,
                "satuan"=>$h->satuan,
            );
        }

        echo json_encode($data);
    }
}