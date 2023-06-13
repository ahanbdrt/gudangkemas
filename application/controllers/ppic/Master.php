<?php
class Master extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') != 'ppic') {
            $this->session->set_flashdata('pesan', '<div class="text-center fade show" style="color:red" role="alert">
  Anda Belum Login!
</div><br>');
            redirect('auth/login');
        }
    }
    public function index(){
        $data["master"] = $this->Home_model->gethome();
        $data["subgrup"] = $this->db->select("kdgrup,namagrup,kdsubgr,namasubgr")->from("grup")->get()->result();
        $data["grup"] = $this->db->query("SELECT DISTINCT kdgrup,namagrup FROM grup group by namagrup,kdgrup")->result();
        $this->load->view("ppic/master/master",$data);
    }
    public function getmaster(){
        $data = $this->Home_model->gethome();
        $i=0;
        foreach($data as $d) {
            $test[] = array(
                "id"=>$i=$i+1,
                "kode"=>$d->kode,
                "nama"=>$d->nama,
                "satuan"=>$d->satuan,
                "namagrup"=>$d->namagrup,
                "namasubgr"=>$d->namasubgr,
                "tglmas"=>$d->tglmas,
                "aksi"=>'<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editmaster" onclick="editmaster(`'.$d->kode.'`,`'.$d->satuan.'`,`'.$d->nama.'`,`'.$d->kdgrup.'`,`'.$d->kdsubgr.'`,`'.$d->id.'`,`'.$d->namagrup.'`,`'.$d->namasubgr.'`)"><i class="fas fa-md fa-edit"></i> Edit</button><button onclick="hapus(`'.$d->id.'`)" class="btn btn-sm btn-danger mt-1"><i class="fas fa-md fa-trash"></i> Hapus</button>',
            );
        }
        echo json_encode($test);
    }
    public function tambah(){
        $kode = $this->input->post("kode");
        $nama = $this->input->post("nama");
        $satuan = $this->input->post("satuan");
        $subgr = $this->input->post("subgr");
        $grup = $this->input->post("grup");
        $master = $this->db->order_by('id','DESC')->limit(1)->get("master")->result();
        foreach($master as $m){
            $id = $m->id;
        }

        $data_master=array(
            "id"=>$id+1,
            "kode"=>$kode,
            "nama"=>$nama,
            "satuan"=>$satuan,
            "nama"=>$nama,
            "kdgrup"=>$grup,
            "kdsubgrup"=>$subgr,
            "grup"=>"",
            "tglmas"=>date("Y-m-d H:i:s")
        );
        $data_saldo=array(
            "kode"=>$id+1,
            "saldo"=>0,
            "tglform"=>"0000-00-00",
            "tanggal"=>date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
        $this->Master_model->tambah($data_master,'master');
        $this->Master_model->tambah($data_saldo,'saldo');
        $this->db->trans_complete();

        if($this->db->trans_status()===FALSE){
            $this->session->set_flashdata("gagal","Master gagal ditambahkan!");
        }else{
            $this->session->set_flashdata("berhasil","Master berhasil ditambahkan!");
        }
        redirect("ppic/master");
    }

    public function getsubgr(){
        $grup = $this->input->post("grup");
        $data = $this->db->where("kdgrup",$grup)->get("grup")->result();
        echo json_encode($data);
    }
    
    public function update(){
        $nama = $this->input->post("nama");
        $satuan = $this->input->post("satuan");
        $grup = $this->input->post("grup");
        $subgr = $this->input->post("subgr");
        $id = $this->input->post("id");

        $data= array(
            "nama"=>$nama,
            "satuan"=>$satuan,
            "kdgrup"=>$grup,
            "kdsubgrup"=>$subgr,
        );

        $this->db->trans_start();
        $this->db->where("id",$id)->update("master",$data);
        $this->db->trans_complete();

        if($this->db->trans_status()==FALSE){
            $this->session->set_flashdata("gagal","Master gagal di edit!");
        }else{
            $this->session->set_flashdata("berhasil","Master berhasil di edit!");
        }

        redirect("ppic/master");
    }

    public function hapus(){
        $this->db->trans_start();
        $this->db->where("id",$this->input->post("id"))->delete("master");
        $this->db->where("kode",$this->input->post("id"))->delete("saldo");
        $this->db->trans_complete();

        if($this->db->trans_status()===FALSE){
            $this->session->set_flashdata("gagal","Master gagal di hapus!");
        }else{
            $this->session->set_flashdata("berhasil","Master berhasil di hapus!");
        }
        redirect("ppic/master");
    }
}