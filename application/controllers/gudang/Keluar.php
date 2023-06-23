<?php
/**
 * @property  session $session
 * @property  input $input
 * @property  db $db
 * @property  Keluar_model $Keluar_model
 * 
 */
class Keluar extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') != 'gudang') {
            $this->session->set_flashdata('pesan', '<div class="text-center fade show" style="color:red" role="alert">
  Anda Belum Login!
</div><br>');
            redirect('auth/login');
        }
    }

    public function index(){
        $data['master'] = $this->db->order_by('kode','ASC')->get('master')->result();
        $this->load->view("gudang/keluar/keluar",$data);
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
                "aksi"=>'<button onclick="edit(`'.$d->tglform.'`,`'.$d->noform.'`,`'.$d->idm.'`,`'.$d->keluar.'`,`'.$d->tgltrima.'`,`'.$d->cat.'`,`'.$d->no.'`)" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editkeluar"><i class="fas fa-edit fa-md"></i> Edit</button><button onclick="hapuskeluar(`'.$d->no.'`,`'.$d->idm.'`,`'.$d->keluar.'`)" class="mt-1 btn btn-sm btn-danger" data-toggle="modal" data-target="#hapuskeluar"><i class="fas fa-trash fa-sm"></i> Hapus</button>'
            );
        }
        echo json_encode($test);
    }
    public function tambahkeluar(){
        $data['master'] = $this->db->order_by('kode','ASC')->get('master')->result();
        $this->load->view("gudang/keluar/tambahkeluar",$data);
    }

    public function store(){
        $index = $this->input->post('index');
        for($i=0;$i<=$index;$i++) {
            $saldo = $this->db->where("kode",$this->input->post('kode')[$i])->get("saldo")->result();
            foreach($saldo as $s) {
                $saldo_arr[$i]=$s->saldo;
                $total[$i] = $saldo_arr[$i] - $this->input->post('qty')[$i];
            }
            $data_riwayat=array(
                "tglform"=>$this->input->post('tglform'),
                "noform"=>$this->input->post('noform'),
                "kode"=>$this->input->post('kode')[$i],
                "masuk"=>0,
                "suplai"=>"",
                "cat"=>$this->input->post('cat')[$i],
                "keluar"=>$this->input->post('qty')[$i],
                "saldo"=>$saldo_arr[$i],
                "tanggal"=>date("Y-m-d H:i:s"),
                "ket"=>"Output",
                "adm"=>6,
                "tgltrima"=>$this->input->post("tgltrima")[$i],
            );
            $data_keluar=array(
                "tglform"=>$this->input->post('tglform'),
                "noform"=>$this->input->post('noform'),
                "kode"=>$this->input->post('kode')[$i],
                "jumlah"=>$this->input->post('qty')[$i],
                "saldo"=>$saldo_arr[$i],
                "tanggal"=>date("Y-m-d H:i:s"),
                "adm"=>6,
            );
            $data_saldo = array("saldo"=>$total[$i]);
            if($total[$i]>=0) {
                $this->db->trans_start();
                $this->db->insert('riwayat', $data_riwayat);
                $this->db->where("kode", $this->input->post('kode')[$i])->update('saldo', $data_saldo);
                $this->db->insert('keluar', $data_keluar);
                $this->db->trans_complete();
                if($this->db->trans_status()===false) {
                    $response[] = array(
                        "text"=>"Gagal ditambahkan!",
                        "icon"=>"error",
                        "bg"=>"bg-danger"
                    );
                } else {
                    $response[] = array(
                        "text"=>"Berhasil ditambahkan!",
                        "icon"=>"success",
                        "bg"=>"bg-success"
                    );
                }
            }else{
                $response[] = array(
                    "text"=>"Saldo Minus!",
                    "icon"=>"error",
                    "bg"=>"bg-danger"
                );
            }         
        }
        echo json_encode($response);
    }
    public function edit(){
        $data_riwayat = array(
            "tglform"=>$this->input->post("tglform"),
            "noform"=>$this->input->post("noform"),
            "keluar"=>$this->input->post("qty"),
            "suplai"=>$this->input->post("tgltrima"),
            "cat"=>$this->input->post("cat"),
            "ket"=>"revisiOUT"
        );
        $saldo = $this->db->where('kode',$this->input->post("kodelama"))->get("saldo")->result();
        foreach($saldo as $s){
            $total = $s->saldo + $this->input->post("qtylama") - $this->input->post("qty");
        }
        $data_saldo = array("saldo"=>$total);
        if($total>=0) {
            $this->db->trans_start();
            $this->db->where("no", $this->input->post("no"))->update("riwayat", $data_riwayat);
            $this->db->where("kode", $this->input->post("kodelama"))->update("saldo", $data_saldo);
            $this->db->trans_complete();

            if($this->db->trans_status()=== false) {
                $this->session->set_flashdata("gagal", "Gagal di edit!");
            } else {
                $this->session->set_flashdata("berhasil", "Berhasil di edit!");
            }
        }else{
            $this->session->set_flashdata("gagal", "Saldo Minus!");
        }
        redirect("gudang/keluar");
    }

    public function hapus(){
        $saldo = $this->db->where("kode",$this->input->post("kode"))->get("saldo")->result();
        foreach($saldo as $s){
            $total = $s->saldo-$this->input->post("qty");
        }
        $this->db->trans_start();
        $this->db->where("no",$this->input->post("hapusno"))->delete("riwayat");
        $this->db->where("kode",$this->input->post("kode"))->update("saldo",$total);
        $this->db->trans_complete();

        if($this->db->trans_status()===false) {
            $this->session->set_flashdata("gagal", "Gagal di hapus!");
        } else {
            $this->session->set_flashdata("berhasil", "Berhasil di hapus!");
        }

        redirect("gudang/keluar");
    }
}