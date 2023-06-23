<?php
/**
 * @property  session $session
 * @property  input $input
 * @property  db $db
 * 
 */
class Reportpergrup extends CI_Controller{
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
        $data['grup'] = $this->db->get("grup")->result();
        $this->load->view("report/reportpergrup",$data);
    }
    public function hasil(){
        $kdgrup = $this->input->post("kdgrup");
        $start = $this->input->post("start");
        $end = $this->input->post("end");
        // $sa = $this->db->query("SELECT sum(masuk)-sum(keluar) as saldo_awal FROM riwayat,master,grup WHERE master.id = riwayat.kode and master.kdsubgrup=grup.kdsubgr and master.kdgrup='$kdgrup' AND riwayat.tglform < '$start' group by master.id order by riwayat.tglform,master.kode");
        // foreach($sa->result() as $sa){
        //     $saldo_awal[]=$sa->saldo_awal;
        // }

        $hasil = $this->db->query("SELECT riwayat.tglform,noform,master.kode,master.nama,grup.namagrup,grup.namasubgr,masuk,keluar,saldo,master.satuan FROM riwayat,master,grup WHERE master.id = riwayat.kode and master.kdsubgrup=grup.kdsubgr and master.kdgrup='$kdgrup' AND riwayat.tglform >= '$start' AND riwayat.tglform <= '$end' order by riwayat.tglform,master.kode");
        $no = 0;
        foreach($hasil->result() as $h){
            $data[]=array(
                "no"=>$no=$no+1,
                "start"=>$start,
                "end"=>$end,
                "kode"=>$h->kode,
                "nama"=>$h->nama,
                "tglform"=>$h->tglform,
                "noform"=>$h->noform,
                "namasubgr"=>$h->namasubgr,
                "namagrup"=>$h->namagrup,
                "masuk"=>$h->masuk.' '.$h->satuan,
                "keluar"=>$h->keluar.' '.$h->satuan,
                "saldo"=>$h->saldo.' '.$h->satuan,
                // "saldo_awal"=>$saldo_awal[$no-1]
            );
        }

        echo json_encode($data);
    }
}