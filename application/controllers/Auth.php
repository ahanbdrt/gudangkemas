<?php
class Auth extends CI_Controller
{
    public function index(){
        $this->load->view("login");
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required', [
            'required' => 'username harus di isi!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required', [
            'required' => 'password harus di isi!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('login');

        } else {
            $auth = $this->Auth_model->cek_login();
            if ($auth == false) {
                $this->session->set_flashdata('pesan', '<div class="text-danger text-center">Username atau Password Anda Salah!</div>');
                redirect('auth/login');
            } else {
                $this->session->set_userdata('fullname', $auth->fullname);
                $this->session->set_userdata('user_id', $auth->user_id);
                $this->session->set_userdata('username', $auth->username);
                $this->session->set_userdata('role', $auth->role);
                switch ($auth->role) {
                    case 'admin':
                        redirect('home');
                        break;
                    case 'manager':
                        redirect('home');
                        break;
                    case 'gudang':
                        redirect('home');
                        break;
                    case 'ppic':
                        redirect('home');
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
  Anda Berhasil Logout
</div>');
        redirect('auth/login');
    }
}