<?php
class Buffer_stock extends CI_Controller{
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
        $data['master']=$this->db->query("SELECT master.id,master.kode,master.nama,count(riwayat.kode) as jum FROM `riwayat`,master where master.id=riwayat.kode and master.nama not like '%Rusak%' and masuk=0 GROUP BY riwayat.kode ORDER BY master.id")->result();
        $this->load->view("ppic/buffer_stock/form",$data);
    }

    public function tampil_buffer(){
        $id = $this->input->post("kode");
        $lead = $this->input->post("lead");

        $tb_saldo = $this->db->where("kode",$id)->get("saldo")->result();
        foreach($tb_saldo as $s){
            $saldo=$s->saldo;
        }
        $tb_master = $this->db->where("id",$id)->get("master")->result();
        foreach($tb_master as $m){
            $kode=$m->kode;
            $satuan=$m->satuan;
        }

        $riwayat = $this->db->query("SELECT sum(keluar) as keluar FROM `riwayat` where kode='$id' and masuk=0 GROUP BY MONTH(tglform)");
        foreach($riwayat->result() as $r){
            $riw_per_bulan[] = $r->keluar;
        }

        $bulan_awal = $this->db->select("tglform")->FROM("riwayat")->where("kode",$id)->order_by("tglform","ASC")->limit(1)->get()->result();
        foreach($bulan_awal as $ba) {
           $tglform =  $ba->tglform;
        }
        $awal = date_create($tglform);
        $akhir = date_create(); // waktu sekarang
        $diff = date_diff($akhir, $awal);
        $jumlah_bulan=$diff->y;

        $nilai_max=max($riw_per_bulan);
        $nilai_rata = array_sum($riw_per_bulan)/$jumlah_bulan;

        $buffer = ($nilai_max-$nilai_rata)*$lead;

        $data=array(
            "kode"=>$kode,
            "lead"=>$lead,
            "saldo"=>$saldo,
            "buffer"=>number_format($buffer,2),
            "satuan"=>$satuan,
        );
        echo json_encode($data);
    }
}