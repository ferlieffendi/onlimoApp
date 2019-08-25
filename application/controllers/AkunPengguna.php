<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AkunPengguna extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('M_AkunPengguna');
        $this->load->model('M_Stasiun');
        $this->load->library('session');
        $this->load->library('aws3');
    }

	public function index()
	{
		$result = $this->M_AkunPengguna->getAllAkun();

        if($result === 0){
            $result = "Tidak Ada Data Akun Pengguna";
            $data['status'] = false;
        }else{
            $data['status'] = true;
        }

        $data['user']=$result;

		$this->load->view('akun_pengguna', $data);
	}

	public function viewBuatAkun()
	{
		$result = $this->M_Stasiun->getAllStasiun();

        if($result === 0){
            $result = "Tidak Ada Data Stasiun";
            $data['status'] = false;
        }else{
            $data['status'] = true;
        }

        $data['stasiun']=$result;

        $this->load->view('buat_akun', $data);
	}

	public function viewEditAkun($id)
	{
		// $id_user = $this->input->get('id_user');

		$result ['akun'] = $this->M_AkunPengguna->getProfileData($id);
        $result ['stasiun']= $this->M_Stasiun->getAllStasiun();

        if($result['stasiun'] === 0){
            $result['stasiun'] = "Tidak Ada Data Stasiun";
            $result['status_stasiun'] = false;
        }else{
            $result['status_stasiun'] = true;
        }

		$this->load->view('edit_akun', $result);
	}

	public function editAkun()
	{
        $id_user     = $this->input->post('inputID');
        $nama     = $this->input->post('inputNama');
        $username    = $this->input->post('inputUsername');
        $password  = $this->input->post('inputPass');
        $email  = $this->input->post('inputEmail');
        $no_telp      = $this->input->post('inputTelp');
        $id_stasiun = $this->input->post('inputStasiun');
        $level = $this->input->post('inputLevel');
        $foto_lama = $this->input->post('foto_lama');

        $name_file = $id_user."_" .time();
        $config['upload_path']          = './uploads/fotoProfil';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 5024;
        $config['file_name'] = $name_file;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!empty($_FILES['inputFoto']['name'])) {
            if ( ! $this->upload->do_upload('inputFoto')) {
                 $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Upload Foto Gagal !!</div>");
                redirect('AkunPengguna/viewEditAkun/'.$id_user);
            } else {
                $file_upload = $this->upload->data();
                $file_upload['file_name'] = $this->aws3->sendFile('onlimo123',$_FILES['inputFoto']); // "TETEP userfile? bukan inputFoto?"
                $result = $this->M_AkunPengguna->updateProfil($id_user, array("nama"=>$nama, "username"=>$username, "password"=>$password, "email"=>$email, "no_telepon"=>$no_telp, "foto_profil"=>$file_upload['file_name'], "id_stasiun"=>$id_stasiun, "level"=>$level));

                if(!$result){
                    $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Edit Akun Gagal. Coba Lagi</div>");
                redirect('AkunPengguna/viewEditAkun/'.$id_user);
                }else{
                     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Akun berhasil di edit</div>");
                    redirect('AkunPengguna');
                }
            }       
        }else{
            $result = $this->M_AkunPengguna->updateProfil($id_user, array("nama"=>$nama, "username"=>$username, "password"=>$password, "email"=>$email, "no_telepon"=>$no_telp, "foto_profil"=>$foto_lama, "id_stasiun"=>$id_stasiun, "level"=>$level));
            if(!$result){
                $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Edit Akun Gagal. Coba Lagi</div>");
            redirect('AkunPengguna/viewEditAkun');
            }else{
                    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Akun berhasil di edit</div>");
            redirect('AkunPengguna');
            }
        }
        
	}

	public function buatAkun()
	{
		$nama     = $this->input->post('inputNama');
        $username    = $this->input->post('inputUsername');
        $password  = $this->input->post('inputPass');
        $email  = $this->input->post('inputEmail');
        $no_telp      = $this->input->post('inputTelp');
        $id_stasiun = $this->input->post('inputStasiun');
        $level = $this->input->post('inputLevel');

        $name_file = $username."_" .time();
        $config['upload_path']          = './uploads/fotoProfil';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 5024;
        $config['file_name'] = $name_file;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('inputFoto')) {
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Upload Foto Gagal !!</div>");
            redirect('AkunPengguna/viewBuatAkun');
        } else {
            $file_upload = $this->upload->data();
         	$result = $this->M_AkunPengguna->buatAkun(array("nama"=>$nama, "username"=>$username, "password"=>$password, "email"=>$email, "no_telepon"=>$no_telp, "foto_profil"=>$file_upload['file_name'], "id_stasiun"=>$id_stasiun, "level"=>$level));

	        if(!$result){
	            $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Akun Gagal Dibuat !!</div>");
                redirect('AkunPengguna/viewBuatAkun');
	        }else{
	            $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Akun Berhasil Dibuat </div>");
                redirect('AkunPengguna');
	        }
        }     	
	}

	public function hapusAkun()
	{
		$id_user = $this->input->post('id_user');

		if($this->M_AkunPengguna->deleteAkun($id_user)) {
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Akun berhasil dihapus</div>");
            redirect('AkunPengguna');
        }else {
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Akun tidak berhasil dihapus. Coba lagi.</div>");
            redirect('AkunPengguna');
        }
	}

    public function getStasiunbyID($id)
    {
        $result = $this->M_Stasiun->getStasiunbyID($id);

        if($result === 0){
            return 0;
        }else{
            return $result->nama_stasiun;
        }
    }
}
