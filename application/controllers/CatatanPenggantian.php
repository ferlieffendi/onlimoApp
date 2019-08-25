<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatatanPenggantian extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('M_CatatanSparepart');
        $this->load->library('session');
        $this->load->library('pdf');
        $this->load->library('pagination');
    }

	public function index()
	{
		$config['base_url'] = site_url('CatatanPenggantian/index'); //site url
        $config['total_rows'] = $this->db->count_all('catatan_penggantian'); //total row
        $config['per_page'] = 10;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
 		
 		$result = $this->M_CatatanSparepart->getAllCatatantoPaginate($config["per_page"], $data['page']);
 		if($result === 0){
            $result = "Tidak Ada Catatan Penggantian";
        	$data['status'] = false;
        }else{
        	$data['status'] = true;
        	$data['pagination'] = $this->pagination->create_links();
        } 
        $data['tahun_pilih']=false;
        $data['catatan']=$result;
        
        $this->load->view('catatan_penggantian', $data);
	}

	public function getCatatanRentangWaktu()
	{
		$tahun_pilih = $this->input->post('tahun_pilih');

		$data['tahun_pilih']="";
        if(!empty($tahun_pilih)) {
            $data['tahun_pilih'] = $tahun_pilih;
            $this->session->set_userdata('cari_tahun_pilih', $data['tahun_pilih']);
        } else {
            $data['tahun_pilih'] = $this->session->userdata('cari_tahun_pilih');
        }

		$config['base_url'] = site_url('CatatanPenggantian/getCatatanRentangWaktu'); //site url
        $config['total_rows'] = $this->M_CatatanSparepart->getRowCatatanRentangWaktu($tahun_pilih); //total row
        $config['per_page'] = 10;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
 		
 		$result = $this->M_CatatanSparepart->getCatatanRentangWaktuPaginate($tahun_pilih, $config["per_page"], $data['page']);
 		if($result === 0){
            $result = "Tidak Ada Catatan Penggantian Pada Tahun ".$tahun_pilih;
        	$data['status'] = false;
        }else{
        	$data['status'] = true;
        	$data['pagination'] = $this->pagination->create_links();
        }
        $data['catatan']=$result;

        $this->load->view('catatan_penggantian', $data);
	}

	public function getPDFCatatan()
	{
		$tahun_pilih = $this->input->post('tahun_pilih');

		if (!$tahun_pilih) {
			$result = $this->M_CatatanSparepart->getAllCatatan();
			$data['judul'] = "Catatan Penggantian Sparepart";
			if ($result === 0) {
	        	$result = "Tidak Ada Catatan Penggantian";
	        	$data['status'] = false;
	        }else{
	        	$data['status'] = true;
	        }
		}else{
	        $result = $this->M_CatatanSparepart->getCatatanRentangWaktu($tahun_pilih);
	        $data['judul'] = "Catatan Penggantian Sparepart Tahun ".$tahun_pilih;
	        if ($result === 0) {
	        	$result = "Tidak Ada Catatan Penggantian Pada Tahun ". $tahun_pilih;
	        	$data['status'] = false;
	        }else{
	        	$data['status'] = true;
	        }
		}
        $data['catatan'] = $result;
		$this->load->view('pdf_catatan', $data);
	}

	public function hapusCatatan()
	{
		$id_catatan = $this->input->post('id_catatan');

		if($this->M_CatatanSparepart->deleteCatatan($id_catatan)) {
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Catatan Penggantian berhasil dihapus</div>");
            redirect('CatatanPenggantian');
        }else {
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Catatan Penggantian  tidak berhasil dihapus. Coba lagi.</div>");
            redirect('CatatanPenggantian');
        }
	}
}
