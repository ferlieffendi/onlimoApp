<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('M_Admin');
        $this->load->library('session');
    }

	public function index()
	{                  
		$this->load->view('login');
	}
        
	public function login()
	{
		$username = $this->input->post('username');
        $password = $this->input->post('password');
                
        $result = $this->M_Admin->login($username,$password);
            
        if ($result === 0) {
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:relative; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Login Gagal!!!</div>");
            redirect('auth');
        } else {     
            $sess_data['id_user'] = NULL;
            $sess_data['username'] = NULL;
            $sess_data['level'] = NULL;
            $sess_data['nama'] = NULL;
            $sess_data['nama_stasiun'] = NULL;
            $sess_data['foto_profil'] = NULL;
            $sess_data['status'] = NULL;
            foreach ($result as $data) {
                $sess_data['id_user'] = $data->id_user;
                $sess_data['username'] = $data->username;
                $sess_data['level'] = $data->level;
                $sess_data['nama'] = $data->nama;
                $sess_data['nama_stasiun'] = $data->nama_stasiun;
                $sess_data['foto_profil'] = $data->foto_profil;
                $sess_data['status'] = "login";
            }
            $this->session->set_userdata($sess_data);
            redirect('home');          
        }    
	}
        
    public function logout()
	{
        $this->session->sess_destroy();
        redirect('auth');
        exit();
	}
}
