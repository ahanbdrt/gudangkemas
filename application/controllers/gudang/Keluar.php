<?php
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

    public function store(){
        $index = $this->input->post('index');
        for($i=0;$i<=$index;$i++) {
            $saldo = $this->db->select("saldo")->where("kode",$this->input->post('kode')[$i])->get("saldo")->result();
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
                "cat"=>$this->input->post('cat')[$i],
                "tanggal"=>date("Y-m-d H:i:s"),
                "adm"=>6,
            );
            $data_saldo = array("saldo"=>$total[$i]);
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
        }
        echo json_encode($response);
    }
}