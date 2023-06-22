<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') != 'gudang' && $this->session->userdata('role') != 'ppic' && $this->session->userdata('role') != 'ppic' && $this->session->userdata('role') != 'manager') {
            $this->session->set_flashdata('pesan', '<div class="fade show text-center" style="color:red" role="alert">
  Anda Belum Login!
</div><br>');
            redirect('auth/login');
        }
    }

    public function index()
    {
        $this->load->view("setting");
    }

    public function update(){
        $id = $this->input->post("id");
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        if($password==null) {
            $data=array(
                "username"=>$username,
            );
        }else{
            $data=array(
                "username"=>$username,
                "password"=>$password,
            );
        }

        $this->db->trans_start();
        $this->db->where("user_id",$id)->update("tb_user",$data);
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE){
            $this->session->set_flashdata("gagal","Gagal di update!");
        }else{
            $this->session->set_flashdata("berhasil", "Berhasil di update!");
        }
        redirect("setting");
    }
}

/* End of file Setting.php and path \application\controllers\Setting.php */
