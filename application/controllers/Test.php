<?php

/**
 * @property  session $session
 * @property  input $input
 * @property  db $db
 * 
 */

class Test extends CI_Controller{
//     public function __construct()
//     {
//         parent::__construct();
//         if ($this->session->userdata('role') != 'ppic' && $this->session->userdata('role') != 'manager') {
//             $this->session->set_flashdata('pesan', '<div class="text-center fade show" style="color:red" role="alert">
//   Anda Belum Login!
// </div><br>');
//             redirect('auth/login');
//         }
//     }

    public function index(){
        $data['master']=$this->db->query("SELECT master.id,master.nama,master.kode, count(keluar) as jum FROM `riwayat`,master where master.id=riwayat.kode and masuk=0 GROUP BY riwayat.kode ORDER BY master.kode")->result();
        $this->load->view("ppic/buffer_stock/form",$data);
    }

    public function testing(){
        $master = $this->db->query("SELECT riwayat.kode as kode,master.kode as mkode, master.nama as nama, 1 as jum, sum(keluar) as keluar FROM `riwayat`,master where YEAR(tglform)>2020 and master.id=riwayat.kode and masuk=0 GROUP BY riwayat.kode,YEAR(tglform), MONTH(tglform) ORDER BY riwayat.kode")->result();
            foreach($master as $m){
                $kemasan[] = array(
                    "kode"=>$m->kode,
                    "mkode"=>$m->mkode,
                    "nama"=>$m->nama,
                    "jum"=>$m->jum,
                    "keluar"=>$m->keluar,
                );
            }
            $groupby = array_reduce($kemasan, function($carry, $item){ 
                if(!isset($carry[$item['kode']])){
                    $carry[$item['kode']] = ['kode'=>$item['kode'],"mkode"=>$item["mkode"],'nama'=>$item['nama'],'jum'=>$item['jum'],'keluar'=>$item['keluar']]; 
                } else {
                    $carry[$item['kode']]['jum'] += $item["jum"]; 
                    $carry[$item['kode']]['keluar'] += $item["keluar"]; 
                }
                return $carry;
            });
            foreach($groupby as $gb){
                if($gb['jum']>=24){
                    //varabel dt
                    $sum_dt[]=round($gb['keluar']);
                    for($c=1;$c<=$gb["jum"];$c++){
                    $periode[]=$c;
                    $per[]=array(
                        "kode"=>$gb["kode"],
                        "mkode"=>$gb["mkode"],
                        "nama"=>$gb["nama"],
                        "periode"=>$c,
                        "periode2"=>$c*$c,
                        "jum"=>$gb["jum"],
                    );
                    $pergroupby = array_reduce($per, function($carry, $item){ 
                        if(!isset($carry[$item['kode']])){
                            $carry[$item['kode']] = ['kode'=>$item['kode'],"mkode"=>$item["mkode"],'nama'=>$item['nama'],'periode'=>$item['periode'],'periode2'=>$item['periode2'],"jum"=>$item["jum"]]; 
                        } else {
                            $carry[$item['kode']]['periode'] += $item["periode"]; 
                            $carry[$item['kode']]['periode2'] += $item["periode2"]; 
                        }
                        return $carry;
                    });
                    }
                }
            }
            //variabel t dan variabel t2
            foreach($pergroupby as $pgb){
                $sum_t[]=$pgb["periode"];
                $sum_t2[] = $pgb["periode2"];
                $count[] = $pgb["jum"];
                $getkode = $pgb["kode"];
                $mkode[] = $pgb["mkode"];
                $nama[] = $pgb["nama"];
                $testdb=$this->db->query("SELECT riwayat.kode as kode,sum(keluar) as keluar FROM `riwayat`,master where riwayat.kode='$getkode' and YEAR(tglform)>2020 and master.id=riwayat.kode and masuk=0 GROUP BY riwayat.kode,YEAR(tglform), MONTH(tglform) ORDER BY riwayat.kode")->result();
                foreach($testdb as $tb){
                    $dt[]=array(
                        "kode"=>$getkode,
                        "dt"=>$tb->keluar,
                    );
                }
            }
            //variabel dt.t
            for($i=0;$i<count($dt);$i++){
                $dtxt[]=array(
                    "kode"=>$dt[$i]["kode"],
                    "dtxt"=>$dt[$i]["dt"]*$periode[$i],
                );
            }
            $group_dtxt = array_reduce($dtxt, function($carry, $item){ 
                if(!isset($carry[$item['kode']])){
                    $carry[$item['kode']] = ['kode'=>$item['kode'],"dtxt"=>$item["dtxt"]]; 
                } else {
                    $carry[$item['kode']]['dtxt'] += round($item["dtxt"]); 
                }
                return $carry;
            });

            foreach($group_dtxt as $gdtxt){
                $sum_dtxt[]=round($gdtxt["dtxt"]);
                $rkode[]=$gdtxt['kode'];   
            }
            for($z=0;$z<count($rkode);$z++){
            $tgl = $this->db->query("SELECT kode,YEAR(tglform) as tahun, MONTH(tglform) as bulan FROM `riwayat` where kode='$rkode[$z]' and masuk=0 and YEAR(tglform)>'2020' GROUP BY kode, YEAR(tglform),MONTH(tglform) ORDER BY kode, YEAR(tglform) ASC, MONTH(tglform) ASC")->result();
                foreach($tgl as $t){
                    $tglan[] = array(
                        "kode"=>$t->kode,
                        "tahun"=>$t->tahun,
                        "bulan"=>$t->bulan,
                    );
                }
                $group_tgl = array_reduce($tglan, function($carry, $item){ 
                    if(!isset($carry[$item['kode']])){
                        $carry[$item['kode']] = ['kode'=>$item['kode'],"tahun"=>$item["tahun"],'bulan'=>$item['bulan']]; 
                    } else {
                        $carry[$item['kode']]['tahun'] = $item["tahun"]; 
                        $carry[$item['kode']]['bulan'] = $item["bulan"]; 
                    }
                    return $carry;
                });
            }
            foreach($group_tgl as $gt){
                $tglget[] = date($gt["tahun"]."-".$gt["bulan"]."-01");
            }
            // regresi linear
            for($d=0;$d<count($sum_dt);$d++){

                $awal[] = date_create(date("Y-m", strtotime("2023-08-01")));
                $akhir[] = date_create(date("Y-m", strtotime($tglget[$d])));
                $diff[] = date_diff($akhir[$d], $awal[$d]);
                $jumlah_bulan[]=$diff[$d]->y*12+($diff[$d]->m);
                
                $nilai_a1[] = ($sum_dt[$d]*$sum_t2[$d])-($sum_dtxt[$d]*$sum_t[$d]);
                $nilai_a2[] = $count[$d]*$sum_t2[$d]-($sum_t[$d]*$sum_t[$d]);
                $nilai_a[] = $nilai_a1[$d]/$nilai_a2[$d];
    
                $nilai_b1[] = ($count[$d]*$sum_dtxt[$d])-$sum_t[$d];
                $nilai_b2[] = $nilai_a2[$d];
                $nilai_b []= $nilai_b1[$d]/$nilai_b2[$d];
                $regresi_linear[] = array(
                    "no"=>$d+1,
                    "kode"=>$mkode[$d],
                    "rkode"=>$rkode[$d],
                    "nama"=>$nama[$d],
                    "regresi"=>round($nilai_a[$d]+$nilai_b[$d]*8)
                );
            }
        echo json_encode($jumlah_bulan)."<br>";
        echo json_encode($tglget);
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
        // $bulan_awal = $this->db->query("SELECT master.kode,tglform FROM riwayat,master where master.id=riwayat.kode and masuk=0 ORDER BY master.kode,tglform DESC")->result();
        // foreach($bulan_awal as $ba) {
        //    $tglform[] =  array(
        //     "kode"=>$ba->kode,
        //     "tglform"=>$ba->tglform
        // );
        // }
        // $bulan_akhir = $this->db->query("SELECT master.kode,tglform FROM riwayat,master where master.id=riwayat.kode and masuk=0 ORDER BY master.kode,tglform ASC")->result();
        // foreach($bulan_akhir as $bk) {
        //     $tglakhir[] =  array(
        //         "kode"=>$bk->kode,
        //         "tglform"=>$bk->tglform
        //     );
        //  }
        // $start = array_reduce($tglform, function($carry, $item){ 
        //     if(!isset($carry[$item['kode']])){
        //         $carry[$item['kode']] = ['kode'=>$item['kode'],'tglform'=>$item['tglform']]; 
        //     } else {
        //         $carry[$item['kode']]['tglform'] = $item["tglform"]; 
        //     }
        //     return $carry;
        // });
        //  $end = array_reduce($tglakhir, function($carry, $item){ 
        //     if(!isset($carry[$item['kode']])){
        //         $carry[$item['kode']] = ['kode'=>$item['kode'],'tglform'=>$item['tglform']]; 
        //     } else {
        //         $carry[$item['kode']]['tglform'] = $item["tglform"]; 
        //     }
        //     return $carry;
        // });
        // foreach($start as $start) {
        //     $starttotime[] = strtotime($start['tglform']);
        // }
        // foreach($end as $end){
        //     $endtotime[] = strtotime($end['tglform']);
        // }
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
                // $awal[] = date_create(date("Y-m",$starttotime[$i]));
                // $akhir[] = date_create(date("Y-m",$endtotime[$i]));
                // $diff[] = date_diff($akhir[$i], $awal[$i]);
                // $jumlah_bulan[] = $diff[$i]->y*12+($diff[$i]->m+1);
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