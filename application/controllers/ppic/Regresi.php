<?php
/**
 * @property  session $session
 * @property  input $input
 * @property  db $db
 * 
 */

 class Regresi extends CI_Controller{
    public function index(){
        $master = $this->db->query("SELECT riwayat.kode as kode,master.kode as mkode, master.nama as nama, 1 as jum FROM `riwayat`,master where YEAR(tglform)>2020 and master.id=riwayat.kode and masuk=0 GROUP BY riwayat.kode,YEAR(tglform), MONTH(tglform) ORDER BY riwayat.kode")->result();
        foreach($master as $m){
            $kemasan[] = array(
                "kode"=>$m->kode,
                "mkode"=>$m->mkode,
                "nama"=>$m->nama,
                "jum"=>$m->jum,
            );
        }
        $groupby = array_reduce($kemasan, function($carry, $item){ 
            if(!isset($carry[$item['kode']])){
                $carry[$item['kode']] = ['kode'=>$item['kode'],"mkode"=>$item["mkode"],'nama'=>$item['nama'],'jum'=>$item['jum']]; 
            } else {
                $carry[$item['kode']]['jum'] += $item["jum"]; 
            }
            return $carry;
        });
        $data['master']=$groupby;
        $this->load->view("ppic/regresi",$data);
    }
    public function hasil(){
        $kode = $this->input->post("kode");
        $tahuninput = $this->input->post("tahun");
        $bulaninput = $this->input->post("bulan");
        $tglpred = date($tahuninput."-".$bulaninput."-01");
        $tgl = $this->db->query("SELECT YEAR(tglform) as tahun, MONTH(tglform) as bulan FROM `riwayat` where kode='$kode' and masuk=0 and YEAR(tglform)>'2020' GROUP BY YEAR(tglform),MONTH(tglform) ORDER BY YEAR(tglform) DESC, MONTH(tglform) DESC limit 1")->result();
        foreach($tgl as $tgl){
            $tahundb = $tgl->tahun;
            $bulandb = $tgl->bulan;
        }

        if($kode != "all"){
            $keluar = $this->db->query("SELECT sum(keluar) as keluar FROM `riwayat` where kode='$kode' and masuk=0 and YEAR(tglform)>'2020' GROUP BY YEAR(tglform),MONTH(tglform) ORDER BY YEAR(tglform)")->result();
            //variabel dt
            foreach($keluar as $k){
                $dt[]=$k->keluar;
            }
            //variabel t
            for($i=1;$i<=count($dt);$i++){
                $t[] = $i;
            }
            // variabel dt.t
            for($j=0;$j<count($dt);$j++){
                $dtxt[] = $t[$j]*$dt[$j];
            }
            //variabel t^2
            for($l=0;$l<count($dt);$l++){
                $t2[] = $t[$l]*$t[$l];
            }
            $sum_dt = array_sum($dt);
            $sum_t = array_sum($t);
            $sum_dtxt = array_Sum($dtxt);
            $sum_t2 = array_Sum($t2);
            $nilai_a1 = ($sum_dt*$sum_t2)-($sum_dtxt*$sum_t);
            $nilai_a2 = count($t)*$sum_t2-($sum_t*$sum_t);
            $nilai_a = $nilai_a1/$nilai_a2;

            $nilai_b1 = (count($t)*$sum_dtxt)-$sum_t;
            $nilai_b2 = $nilai_a2;
            $nilai_b = $nilai_b1/$nilai_b2;

            $tglget = date($tahundb."-".$bulandb);
            $awal = date_create(date("Y-m", strtotime($tglpred)));
            $akhir = date_create(date("Y-m", strtotime($tglget)));
            $diff = date_diff($akhir, $awal);
            $jumlah_bulan=$diff->y*12+($diff->m);

            $regresi_linear = $nilai_a+$nilai_b*$jumlah_bulan;

            $master = $this->db->where("id",$kode)->get("master")->result();
            foreach($master as $m){
                $hasil[] = array(
                    "kode"=>$m->kode,
                    "nama"=>$m->nama,
                    "hasil"=>number_format(round($regresi_linear)).' '.$m->satuan,
                );
            }
            echo json_encode($hasil);
        }else{
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
                $testdb=$this->db->query("SELECT riwayat.kode as kode,sum(keluar) as keluar,master.satuan FROM `riwayat`,master where riwayat.kode='$getkode' and YEAR(tglform)>2020 and master.id=riwayat.kode and masuk=0 GROUP BY riwayat.kode,YEAR(tglform), MONTH(tglform) ORDER BY riwayat.kode")->result();
                foreach($testdb as $tb){
                    $dt[]=array(
                        "kode"=>$getkode,
                        "satuan"=>$tb->satuan,
                        "dt"=>$tb->keluar,
                    );
                }
            }
            //variabel dt.t
            for($i=0;$i<count($dt);$i++){
                $dtxt[]=array(
                    "kode"=>$dt[$i]["kode"],
                    "satuan"=>$dt[$i]["satuan"],
                    "dtxt"=>$dt[$i]["dt"]*$periode[$i],
                );
            }
            $group_dtxt = array_reduce($dtxt, function($carry, $item){ 
                if(!isset($carry[$item['kode']])){
                    $carry[$item['kode']] = ['kode'=>$item['kode'],"satuan"=>$item["satuan"],"dtxt"=>$item["dtxt"]]; 
                } else {
                    $carry[$item['kode']]['dtxt'] += round($item["dtxt"]); 
                }
                return $carry;
            });

            foreach($group_dtxt as $gdtxt){
                $sum_dtxt[]=round($gdtxt["dtxt"]);
                $rkode[]=$gdtxt["kode"];
                $satuan[]=$gdtxt["satuan"];
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
    
                    $awal[] = date_create(date("Y-m", strtotime($tglpred)));
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
                    "nama"=>$nama[$d],
                    "regresi"=>number_format(round($nilai_a[$d]+$nilai_b[$d]*$jumlah_bulan[$d])),
                    "satuan"=>$satuan[$d]
                );
            }
            echo json_encode($regresi_linear);
        }
    }
 }