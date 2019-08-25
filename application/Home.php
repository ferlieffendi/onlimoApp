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

    public function mapData()
    {
        $result = $this->M_Home->getAllLokasi();
        foreach ($result as $key => $value) {
            $kalibrasi = $this->M_Home->cekKalibrasi($value['id_stasiun'], $value['waktu_pelaporan']);
            $cekWarning = $this->M_Home->cekWarning($value['id_user']);
            $icon = NULL;
            $link = NULL;
            if ($value['jenis_laporan'] == "bencana" && $value['kondisi'] == "sedang terjadi") {
                $icon = site_url('assets/icon_maps/caution.png');
                $link = '<a href="'.site_url('Home/getPelaporan/'.$value['id_laporan']).'">Lihat Pelaporan</a>';
            } else if ($value['jenis_laporan'] == "bencana" && $value['kondisi'] == "sudah selesai") {
                if ($kalibrasi == 0) {
                    $icon = site_url('assets/icon_maps/tools.png');
                    $link='<a href="'.site_url('Home/getPelaporan/'.$value['id_laporan']).'">Lihat Pelaporan</a>';
                } else if ($kalibrasi != 0 || $cekWarning > -14) {
                    $icon = site_url('assets/icon_maps/loc.svg');
                    $link="";
                }
            } else if ($value['jenis_laporan'] == "barang hilang") {
                if ($kalibrasi == 0) {
                    $icon = site_url('assets/icon_maps/tools.png');
                    $link='<a href="'.site_url('Home/getPelaporan/'.$value['id_laporan']).'">Lihat Pelaporan</a>';
                }
                else{
                    $icon = site_url('assets/icon_maps/loc.svg');
                }
            } else if ($value['jenis_laporan'] == "pembersihan"){
                if ($cekWarning < -14) {
                    $icon = site_url('assets/icon_maps/administration.png');
                    $link='<a>BELUM MELAKUKAN LAPORAN LEBIH DARI 2 MINGGU</a>';
                } else {
                    $icon = site_url('assets/icon_maps/loc.svg');
                    $link="";
                }
            } else {
                    $icon = site_url('assets/icon_maps/loc.svg');
                    $link="";
            }
            $data[] = array(
                'id_stasiun' => $value['id_stasiun'], 
                'nama_stasiun' => $value['nama_stasiun'],
                'alamat_stasiun' => $value['alamat_stasiun'],
                'latitude' => $value['latitude'],
                'longitude' => $value['longitude'],
                'id_user' => $value['id_user'],
                'nama' => $value['nama'],
                'no_telepon' => $value['no_telepon'],
                'id_laporan' => $value['id_laporan'],
                'waktu_pelaporan' => $value['waktu_pelaporan'],
                'jenis_laporan' => $value['jenis_laporan'],
                'kondisi' => $value['kondisi'],
                'keterangan' => $value['keterangan'],
                'foto' => $value['foto'],
                'icon' => $icon,
                'link' => $link
            );
        }
        echo json_encode($data);
        // print_r($data);
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
