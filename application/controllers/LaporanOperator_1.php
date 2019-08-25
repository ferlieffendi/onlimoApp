<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanOperator extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('M_LaporanOperator');
        $this->load->library('session');
        $this->load->library('pdf');
        $this->load->library('pagination');
    }

	public function index()
	{
		$config['base_url'] = site_url('LaporanOperator/index'); //site url
        $config['total_rows'] = $this->db->count_all('laporan_operator'); //total row
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
 		
 		$result = $this->M_LaporanOperator->getAllPelaporantoPaginate($config["per_page"], $data['page']);
 		if($result === 0){
            $result = "Tidak Ada Laporan Operator";
        	$data['status'] = false;
        }else{
        	$data['status'] = true;
        	$data['pagination'] = $this->pagination->create_links();
        } 
        $data['waktu_awal']=false;
        $data['waktu_akhir']=false;
        $data['pelaporan']=$result;
        $this->load->view('laporan_operator', $data);		
	}

	public function getPelaporanRentangWaktu()
	{
		$waktu_awal = $this->input->post('waktu_awal');

        $waktu_akhir = $this->input->post('waktu_akhir');

        $data['waktu_akhir']="";
        $data['waktu_awal']="";
        if(!empty($waktu_awal) && !empty($waktu_akhir)) {
            $data['waktu_akhir'] = $waktu_akhir;
            $data['waktu_awal'] = $waktu_awal;
            $this->session->set_userdata('cari_waktu_awal', $data['waktu_awal']);
            $this->session->set_userdata('cari_waktu_akhir', $data['waktu_akhir']);
        } else {
            $data['waktu_akhir'] = $this->session->userdata('cari_waktu_akhir');
            $data['waktu_awal'] = $this->session->userdata('cari_waktu_awal');
        }

        $waktu_awalSQL =date('Ym', strtotime($this->session->userdata('cari_waktu_awal')));
        $waktu_akhirSQL =date('Ym', strtotime($this->session->userdata('cari_waktu_akhir')));

        $config['base_url'] = site_url('LaporanOperator/getPelaporanRentangWaktu'); //site url 
        $config['total_rows'] = $this->M_LaporanOperator->getRowPelaporanRentangWaktu($waktu_awalSQL, $waktu_akhirSQL); //total row
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

        $result = $this->M_LaporanOperator->getPelaporanRentangWaktuPaginate($waktu_awalSQL, $waktu_akhirSQL, $config["per_page"], $data['page']);

        if ($result === 0) {
        	$result = "Tidak Ada Laporan Operator Pada ". $waktu_awal." sampai ". $waktu_akhir;
        	$data['status'] = false;
        }else{
        	$data['status'] = true;
            $data['pagination'] = $this->pagination->create_links();
        }
        $data['pelaporan']=$result;
        $this->load->view('laporan_operator', $data);
	}

	public function getPDFPelaporan()
	{
		$waktu_awal = $this->input->post('waktu_awal');
		$waktu_akhir = $this->input->post('waktu_akhir');

		if (!$waktu_awal && !$waktu_akhir) {
			$result = $this->M_LaporanOperator->getAllPelaporan();
			$data['judul'] = "Laporan Operator Stasiun";
			if ($result === 0) {
	        	$result = "Tidak Ada Laporan Operator";
	        	$data['status'] = false;
	        }else{
	        	$data['status'] = true;
	        }
		}else{
			$waktu_awalSQL =date('Ym', strtotime($waktu_awal));
	        $waktu_akhirSQL =date('Ym', strtotime($waktu_akhir));

	        $result = $this->M_LaporanOperator->getPelaporanRentangWaktu($waktu_awalSQL, $waktu_akhirSQL);
	        $data['judul'] = "Laporan Operator Stasiun ".$waktu_awal." - ".$waktu_akhir;
	        if ($result === 0) {
	        	$result = "Tidak Ada Laporan Operator Pada ". $waktu_awal." sampai ". $waktu_akhir;
	        	$data['status'] = false;
	        }else{
	        	$data['status'] = true;
	        }
		}

        $data['laporan'] = $result;
		$this->load->view('pdf_laporan', $data);
	}

	public function hapusPelaporan()
	{
        $id_laporan = $this->input->post('id_laporan');
		if($this->M_LaporanOperator->deletePelaporan($id_laporan)) {
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Laporan berhasil dihapus</div>");
            redirect('LaporanOperator');
        }else {
            $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" style=\"pointer:cursor;position:absolute; z-index: 9999; top: 0px;margin: 5px auto; width:60%;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> Laporan tidak berhasil dihapus. Coba lagi.</div>");
            redirect('LaporanOperator');
        }

        $this->load->view('laporan_operator', $data);
	}
}
