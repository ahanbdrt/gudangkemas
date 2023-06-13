<?php
class Reportall extends CI_Controller
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
        $this->load->view("report/reportall");
    }

    public function hasil(){
        $start = $this->input->post("start");
        $end = $this->input->post("end");
        $sa = $this->db->query("SELECT sum(masuk)-sum(keluar) as saldo_awal FROM master LEFT JOIN riwayat on riwayat.kode=master.id and tglform<'$start' GROUP BY master.id order by master.id");
        foreach($sa->result() as $sa){
            $saldo_awal[]=$sa->saldo_awal;
        }
        $hasil = $this->db->query("SELECT master.id,master.kode,master.nama,grup.namasubgr,satuan,sum(masuk) as masuk,sum(keluar) as keluar,sum(masuk)-sum(keluar) as saldo_akhir FROM master LEFT JOIN riwayat on riwayat.kode=master.id and tglform>='$start' and tglform<='$end' INNER JOIN grup on grup.kdsubgr=master.kdsubgrup GROUP BY master.id,namasubgr,satuan order by master.id");
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
                "kode"=>$h->kode,
                "nama"=>$h->nama,
                "namasubgr"=>$h->namasubgr,
                "satuan"=>$h->satuan,
                "saldo_awal"=>number_format($saldo_awal[$no-1],2),
                "masuk"=>number_format($h->masuk,2),
                "keluar"=>number_format($h->keluar,2),
                "saldo_akhir"=>number_format($h->saldo_akhir+$saldo_awal[$no-1],2),
            );
        }
        echo json_encode($data);
    }
}