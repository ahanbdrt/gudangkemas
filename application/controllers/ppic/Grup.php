<?php 
/**
 * @property  session $session
 * @property  input $input
 * @property  db $db
 * 
 */
class Grup extends CI_Controller{
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
        $data["grup"]=$this->db->query("SELECT kdgrup,namagrup FROM grup GROUP BY kdgrup,namagrup")->result();
        $data["subgr"]=$this->db->get("grup")->result();
        $this->load->view("ppic/grup/grup",$data);
    }

    public function getgrup(){
        $data = $this->db->order_by("kdsubgr","ASC")->get("grup")->result();
        $i=0;
        foreach($data as $d){
            $test[] = array(
                "no"=>$i=$i+1,
                "kdgrup"=>$d->kdgrup,
                "namagrup"=>$d->namagrup,
                "kdsubgr"=>$d->kdsubgr,
                "namasubgr"=>$d->namasubgr,
                "aksi"=>'<button class="btn btn-sm btn-warning" onclick="edit(`'.$d->id.'`,`'.$d->kdgrup.'`,`'.$d->kdsubgr.'`,`'.$d->namasubgr.'`)" data-toggle="modal" data-target="#editmodal"><i class="fas fa-md fa-edit"></i> Edit</button><button class="btn btn-sm btn-danger mt-1" onclick="hapus(`'.$d->id.'`)"><i class="fas fa-md fa-trash"></i> Hapus</button>',
            );
        }
        echo json_encode($test);
    }

    public function tambah(){
        $kdgrup=$this->input->post("kdgrup");
        $kdsubgr=$this->input->post("kdsubgr");
        $namasubgr=$this->input->post("namasubgr");

        $namagr = $this->db->where("kdgrup",$kdgrup)->get("grup")->result();
        foreach($namagr as $ng){
            $namagrup = $ng->namagrup;
        }

        $data=array(
            "kdgrup"=>$kdgrup,
            "namagrup"=>$namagrup,
            "kdsubgr"=>$kdsubgr,
            "namasubgr"=>$namasubgr,
        );

        $this->db->trans_start();
        $this->db->insert("grup",$data);
        $this->db->trans_complete();

        if($this->db->trans_status()===FALSE){
            $this->session->set_flashdata("gagal","Grup gagal ditambahkan!");
        }else{
            $this->session->set_flashdata("berhasil","Grup behasil ditambahkan!");
        }

        redirect("ppic/grup");
    }

    public function edit(){
        $id=$this->input->post("id");
        $kdgrup=$this->input->post("kdgrup");
        $kdsubgr=$this->input->post("kdsubgr");
        $namasubgr=$this->input->post("namasubgr");

        $data=array(
            "kdgrup"=>$kdgrup,
            "kdsubgr"=>$kdsubgr,
            "namasubgr"=>$namasubgr,
        );

        $this->db->trans_start();
        $this->db->where("id",$id)->update("grup",$data);
        $this->db->trans_complete();

        if($this->db->trans_status()===FALSE){
            $this->session->set_flashdata("gagal","Grup gagal ditambahkan!");
        }else{
            $this->session->set_flashdata("berhasil","Grup behasil ditambahkan!");
        }

        redirect("ppic/grup");
    }

    public function hapus(){
        $id = $this->input->post("id");
        $this->db->trans_start();
        $this->db->where("id",$id)->delete("grup");
        $this->db->trans_complete();

        if($this->db->trans_status()===FALSE){
            $this->session->set_flashdata("gagal","Grup gagal di hapus!");
        }else{
            $this->session->set_flashdata("berhasil","Grup behasil di hapus!");
        }

        redirect("ppic/grup");
    }
}