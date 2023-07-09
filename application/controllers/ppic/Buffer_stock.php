<?php

/**
 * @property  session $session
 * @property  input $input
 * @property  db $db
 * 
 */

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
        $data['master']=$this->db->query("SELECT master.id,master.nama,master.kode, count(keluar) as jum FROM `riwayat`,master where master.id=riwayat.kode and masuk=0 GROUP BY riwayat.kode ORDER BY master.kode")->result();
        $this->load->view("ppic/buffer_stock/form",$data);
    }

    public function tampil_buffer(){
        $id = $this->input->post("kode");
        $format = $this->input->post("format");
        if($format=="bulan"){
            $lead = $this->input->post("lead");
        }else{
            $lead = $this->input->post("lead")/30;
        }

        if($id != "all") {
            $tb_saldo = $this->db->where("kode", $id)->get("saldo")->result();
            foreach($tb_saldo as $s) {
                $saldo=$s->saldo;
            }
            $tb_master = $this->db->where("id", $id)->get("master")->result();
            foreach($tb_master as $m) {
                $kode=$m->kode;
                $satuan=$m->satuan;
                $nama=$m->nama;
            }

            $riwayat = $this->db->query("SELECT keluar FROM `riwayat` where kode='$id' and masuk=0");
            foreach($riwayat->result() as $r) {
                $riw_per_bulan[] = $r->keluar;
            }

            $bulan_awal = $this->db->select("tglform")->FROM("riwayat")->where("kode", $id)->where("masuk", 0)->order_by("tglform", "ASC")->limit(1)->get()->result();
            foreach($bulan_awal as $ba) {
                $tglform =  $ba->tglform;
            }
            $bulan_akhir = $this->db->select("tglform")->FROM("riwayat")->where("kode", $id)->where("masuk", 0)->order_by("tglform", "DESC")->limit(1)->get()->result();
            foreach($bulan_akhir as $bk) {
                $tglakhir =  $bk->tglform;
            }
            $awal = date_create(date("Y-m", strtotime($tglform)));
            $akhir = date_create(date("Y-m", strtotime($tglakhir))); //
            $diff = date_diff($akhir, $awal);
            $jumlah_bulan=$diff->y*12+($diff->m+1)*30;

            $nilai_max=max($riw_per_bulan);
            $nilai_rata = array_sum($riw_per_bulan)/$riwayat->num_rows();

            $buffer = ($nilai_max-$nilai_rata)*$lead;

            $data=array(
                "kode"=>$kode,
                "lead"=>$this->input->post("lead").' '.$format,
                "saldo"=>$saldo,
                "buffer"=>abs(round($buffer)),
                "satuan"=>$satuan,
                "nama"=>$nama,
            );
            echo json_encode($data);
        }else{
            $test = $this->db->query("SELECT master.kode, keluar FROM `riwayat` LEFT JOIN master on master.id=riwayat.kode where masuk=0 order by master.kode")->result();
        foreach($test as $t){
            $data[]=$t->keluar;
        }
        $max = $this->db->query("SELECT master.id,master.nama,master.kode, keluar,master.satuan FROM `riwayat` LEFT JOIN master on master.id=riwayat.kode where masuk=0 order by master.kode,keluar")->result();
        foreach($max as $m){
            $datamax[]=array(
                "kode"=>$m->kode,
                "keluar"=>$m->keluar,
                "satuan"=>$m->satuan,
                "nama"=>$m->nama,
                "id"=>$m->id,
            );
        }
        $sumriwayat = array_reduce($datamax, function($carry, $item){ 
            if(!isset($carry[$item['kode']])){
                $carry[$item['kode']] = ['kode'=>$item['kode'],'keluar'=>$item['keluar']]; 
            } else {
                $carry[$item['kode']]['keluar'] += $item["keluar"]; 
            }
            return $carry;
        });
        $maxriwayat = array_reduce($datamax, function($carry, $item){ 
            if(!isset($carry[$item['kode']])){
                $carry[$item['kode']] = ['kode'=>$item['kode'],'satuan'=>$item['satuan'],'nama'=>$item['nama'],'id'=>$item['id'],'keluar'=>$item['keluar']];
            } else {
                $carry[$item['kode']]['keluar'] = $item["keluar"]; 
            }
            return $carry;
        });
        $count = $this->db->query("SELECT riwayat.kode, count(keluar) as jumlah FROM `riwayat`,master where master.id=riwayat.kode and masuk=0 GROUP BY kode ORDER BY master.kode")->result();
        foreach($count as $c){
            $jumlah[] = $c->jumlah;
        }
        foreach($sumriwayat as $sumriwayat){
            $sumr[] = $sumriwayat['keluar'];
        }
        foreach($maxriwayat as $maxriwayat){
            $maxr[] = $maxriwayat['keluar'];
            $kode[] = $maxriwayat['kode'];
            $satuan[] = $maxriwayat['satuan'];
            $nama[] = $maxriwayat['nama'];
            $idm[] = $maxriwayat['id'];
        }
            for($i=0;$i<count($count);$i++){
                if($jumlah[$i]>50) {
                    $buffer[]=array(
                        "lead"=>$this->input->post("lead").' '.$format,
                        "kode"=>$kode[$i],
                        "id"=>$idm[$i],
                        "nama"=>$nama[$i],
                        "buffer"=>round(($maxr[$i]-($sumr[$i]/$jumlah[$i]))*$lead).' '.$satuan[$i]
                    );
                }
            }
            echo json_encode($buffer);
        }
    }
}