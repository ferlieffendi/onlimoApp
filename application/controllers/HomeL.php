<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('M_Home');
        $this->load->library('session');
        $this->load->library('googlemaps');
    }

	public function index()
	{
		$result = $this->M_Home->getAllLokasi();

        $config=array();
            $config['region']='ID';
            $config['language']='ID';
            $config['center']="-1.603805, 118.231670";
            $config['zoom']=5;
            $config['map_height']="450px";
            $this->googlemaps->initialize($config);

            foreach ($result as $key) {
                if ($key['latitude'] != 0 && $key['longitude'] != 0) {
                    $marker=array();
                    $marker['position']=$key['latitude'].", ".$key['longitude'];
                    $kalibrasi = $this->M_Home->cekKalibrasi($key['id_stasiun'], $key['waktu_pelaporan']);
                    $cekWarning = $this->M_Home->cekWarning($key['id_user']);
                    
                    $icon = NULL;
                    $link = NULL;
                    if ($key['jenis_laporan'] == "bencana" && $key['kondisi'] == "sedang terjadi") {
                        $icon = 'caution.png';
                        $link = '<a href="'.site_url('Home/getPelaporan/'.$key['id_laporan']).'">Lihat Pelaporan</a>';
                    }elseif ($key['jenis_laporan'] == "bencana" && $key['kondisi'] == "sudah selesai") {
                        if ($kalibrasi == 0) {
                            $icon = 'tools.png';
                            $link='<a href="'.site_url('Home/getPelaporan/'.$key['id_laporan']).'">Lihat Pelaporan</a>';
                        } elseif ($kalibrasi != 0 || $cekWarning > -14) {
                            $icon = 'loc.svg';
                            $link="";
                        }
                    } elseif ($key['jenis_laporan'] == "barang hilang") {
                        if ($kalibrasi == 0) {
                            $icon = 'tools.png';
                            $link='<a href="'.site_url('Home/getPelaporan/'.$key['id_laporan']).'">Lihat Pelaporan</a>';
                        }
                        else{
                            $icon = 'loc.svg';
                        }
                    } elseif ($key['jenis_laporan'] == "pembersihan"){
                        if ($cekWarning < -14) {
                            $icon = 'administration.png';
                            $link='<a>BELUM MELAKUKAN LAPORAN LEBIH DARI 2 MINGGU</a>';
                        } else {
                            $icon = 'loc.svg';
                            $link="";
                        }
                    } else {
                        $icon = 'loc.svg';
                    }
                    $marker['infowindow_content'] = '<div id="content"><div id="siteNotice"></div><h3 id="firstHeading" class="firstHeading">'. $key['nama_stasiun'] .'</h3><div id="bodyContent"><p><b>'. $key['alamat_stasiun'] .'</b></p><p>Nama Operator Stasiun  :  '. $key['nama'] .'<br>Nomor Telepon : '. $key['no_telepon'] .'<br>'. $link .'</p></div></div>';
                    $marker['icon'] = site_url('assets/icon_maps/'.$icon.'');
                    
                    $this->googlemaps->add_marker($marker);
                }
            }
            
            $data['map']=$this->googlemaps->create_map();
            $this->load->view('home',$data);
	}

    public function getPelaporan($id_laporan)
    {
        $data['post'] = $this->M_Home->getPelaporan( $id_laporan );
        $result = $this->M_Home->getAllLokasi();

        $config=array();
            $config['region']='ID';
            $config['language']='ID';
            $config['center']="-1.603805, 118.231670";
            $config['zoom']=5;
            $config['map_height']="450px";
            $this->googlemaps->initialize($config);

            foreach ($result as $key) {
                if ($key['latitude'] != 0 && $key['longitude'] != 0) {
                    $marker=array();
                    $marker['position']=$key['latitude'].", ".$key['longitude'];
                    $kalibrasi = $this->M_Home->cekKalibrasi($key['id_stasiun'], $key['waktu_pelaporan']);
                    $cekWarning = $this->M_Home->cekWarning($key['id_user']);
                    
                    $icon = NULL;
                    $link = NULL;
                    if ($key['jenis_laporan'] == "bencana" && $key['kondisi'] == "sedang terjadi") {
                        $icon = 'caution.png';
                        $link = '<a href="'.site_url('Home/getPelaporan/'.$key['id_laporan']).'">Lihat Pelaporan</a>';
                    }
                    elseif ($key['jenis_laporan'] == "bencana" && $key['kondisi'] == "sudah selesai") {
                        if ($kalibrasi == 0) {
                            $icon = 'tools.png';
                            $link='<a href="'.site_url('Home/getPelaporan/'.$key['id_laporan']).'">Lihat Pelaporan</a>';
                        }else{
                            $icon = 'loc.svg';
                            $link="";
                        }
                    }
                    elseif ($key['jenis_laporan'] == "barang hilang") {
                        if ($kalibrasi == 0) {
                            $icon = 'tools.png';
                            $link='<a href="'.site_url('Home/getPelaporan/'.$key['id_laporan']).'">Lihat Pelaporan</a>';
                        }
                        else{
                            $icon = 'loc.svg';
                        }
                    }
                    elseif ($key['jenis_laporan'] == "pembersihan"){
                        if ($cekWarning < -14) {
                            $icon = 'administration.png';
                            $link='<a>BELUM MELAKUKAN LAPORAN LEBIH DARI 2 MINGGU</a>';
                        }
                        else{
                            $icon = 'loc.svg';
                            $link="";
                        }
                    }
                    else{
                        $icon = 'loc.svg';
                    }
                    $marker['infowindow_content'] = '<div id="content"><div id="siteNotice"></div><h3 id="firstHeading" class="firstHeading">'. $key['nama_stasiun'] .'</h3><div id="bodyContent"><p><b>'. $key['alamat_stasiun'] .'</b></p><p>Nama Operator Stasiun  :  '. $key['nama'] .'<br>Nomor Telepon : '. $key['no_telepon'] .'<br>'. $link .'</p></div></div>';
                    $marker['icon'] = site_url('assets/icon_maps/'.$icon.'');
                    
                    $this->googlemaps->add_marker($marker);
                }
            }
            
            $data['tampil'] = true;
            $data['map']=$this->googlemaps->create_map();
            $this->load->view('home',$data);
    }
}
