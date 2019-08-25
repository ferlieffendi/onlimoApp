<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
    {
        parent::__construct();

        $this->load->model('M_Admin');
        $this->load->model('M_Stasiun');
        $this->load->library('session');
        $this->load->library('aws3');
    }

	public function index()
	{
		$result = $this->M_Admin->getAllPosting($this->session->userdata('id_user'));

        if($result === 0){
            $result = "Tidak Ada Posting";
            $data['status'] = false;
        }else{
            $data['status'] = true;
        }

        $data['posting']=$result;
        $this->load->view('profil', $data);
	}

	public function viewPosting()
	{
		$this->load->view('posting');
	}

	public function viewEditProfil($id)
	{
        $result ['profil'] = $this->M_Admin->getProfileData($id);
        $result ['stasiun']= $this->M_Stasiun->getAllStasiun();

        if($result['stasiun'] === 0){
            $result['stasiun'] = "Tidak Ada Data Stasiun";
            $result['status_stasiun'] = false;
        }else{
            $result['status_stasiun'] = true;
        }

        $this->load->view('edit_profil', $result);
	}

	public function editProfil($id_user)
	{
        $nama     = $this->input->post('inputNama');
        $username    = $this->input->post('inputUsername');
        $password  = $this->input->post('inputPass');
        $email  = $this->input->post('inputEmail');
        $no_telp      = $this->input->post('inputTelp');
        $foto_lama = $this->input->post('foto_lama');

        $name_file = "ADMIN_" .time();
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
                redirect('Admin/viewEditProfil/'.$id_user);
            } else {
                $file_upload = $this->upload->data();
                $file_upload['file_name'] = $this->aws3->sendFile('onlimo123',$_FILES['inputFoto']);
                $result = $this->M_Admin->updateProfil($id_user, array("nama"=>$nama, "username"=>$username, "password"=>$password, "email"=>$email, "no_telepon"=>$no_telp, "foto_profil"=>$file_upload['file_name']));
            }       
        }else{
            $result = $this->M_Admin->updateProfil($id_user, array("nama"=>$nama, "username"=>$username, "password"=>$password, "email"=>$email, "no_telepon"=>$no_telp, "foto_profil"=>$foto_lama));
        }
        if(!$result){
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Edit Akun Gagal. Coba Lagi</div>");
            redirect('Admin/viewEditProfil/'.$id_user);
        }else{
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Akun berhasil di edit</div>");
            redirect('Admin/updateSess/'.$id_user);
        }
	}

	public function posting()
	{
		$jenis_posting  = $this->input->post('JenisPosting');
        $kondisi     = $this->input->post('inputKondisi');
        $keterangan    = $this->input->post('inputKeterangan');
        $id_user  = $this->input->post('inputID');
                 
        // $image = base64_decode($_FILES);
        // $name_file = "ADMIN_" .time();
        $config['upload_path']          = './uploads/PelaporanOperator';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 5024;
        // $config['file_name'] = $name_file;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('inputFoto')) {
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Upload Foto Gagal !!</div>");
                redirect('Admin/viewPosting');
        }else{
            $file_upload = $this->upload->data();
            $file_upload['file_name'] = $this->aws3->sendFile('onlimo123',$_FILES['inputFoto']);
            if (!$kondisi) {
                $kondisi = "-";
            }
            $result = $this->M_Admin->posting(array("jenis_laporan"=>$jenis_posting, "kondisi"=>$kondisi, "keterangan"=>$keterangan, "foto"=>$file_upload['file_name'], "id_user"=>$id_user));

            if(!$result){
                    $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Posting Gagal. Coba Lagi</div>");
                redirect('Admin/viewPosting');
            }else{
                    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Berhasil mengirim posting</div>");
                redirect('Admin');
            }
        }                      
    }

    public function updateSess($id_user)
    {
        $result = $this->M_Admin->getProfileData($id_user);
        if ($result === 0) {
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:relative; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Login Gagal!!!</div>");
            redirect('Admin/viewEditProfil/'.$id_user);
        } else {  
            foreach ($result as $data) {
                $sess_data['username'] = $data['username'];
                $sess_data['nama'] = $data['nama'];
                $sess_data['nama_stasiun'] = $data['nama_stasiun'];
                $sess_data['foto_profil'] = $data['foto_profil'];
                $sess_data['status'] = "login";
            }
            $this->session->set_userdata($sess_data);
            redirect('admin');          
        }
    }
}
