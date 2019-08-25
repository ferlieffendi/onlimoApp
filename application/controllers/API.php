<?php

require(APPPATH.'/libraries/REST_Controller.php');
 
class Api extends REST_Controller{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Model');
    }

    function login_post(){
        $username = $this->post('username');
        $password = $this->post('password');

        if (!$username || !$password) {
            $data = array( "status" => "false","message" => "Isi Username dan Password");

            $this->response($data, 200);
        } else {
            $result = $this->Model->login($username,$password);
            
            if ($result === 0) {
                $data = array( "status" => "false","message" => "Username dan Password tidak cocok");
                $this->response($data, 200);
            } else {
            	foreach ($result as $key => $value) {
	         		$id_user = $value['id_user'];
	         		$level = $value['level'];
	         	}
	         	if ($level == 0) {
	         		$return = $this->Model->getLastLaporan($id_user);
	         		if ($return != 0) {
	         			foreach ($return as $key => $value) {
	            	    	$return = $value['waktu_pelaporan'];
	            		}
	            		$data = array( "status" => "true","message" => "Login berhasil", "data" => $result, "lastLaporan" => $return);
	               		$this->response($data, 200);
	         		}else{
	         			$data = array( "status" => "true","message" => "Login berhasil", "data" => $result, "lastLaporan" => "0");
	               		$this->response($data, 200);
	         		}
	            	             
	                
	         	}else{
	         		$data = array( "status" => "true","message" => "Login berhasil", "data" => $result, "lastLaporan" => "0");
	                $this->response($data, 200);
	         	}
            	
            }            
        }        
    }

    function updateProfil_post(){         
         $id_user     = $this->post('id_user');
         $nama     = $this->post('nama');
         $username    = $this->post('username');
         $password  = $this->post('password');
         $password_baru = $this->post('password_baru');
         $email  = $this->post('email');
         $no_telp      = $this->post('no_telepon');
         
         if(!$id_user || !$nama || !$username || !$email || !$no_telp ){

                $data = array( "status" => "false","message" => "Isi data diri secara lengkap");

            	$this->response($data, 200);
         }else{
         	if (!$_FILES) {
         		if (!$password_baru && !$password) {
         			$result = $this->Model->updateProfil($id_user, array("nama"=>$nama, "username"=>$username, "email"=>$email, "no_telepon"=>$no_telp));
         			if($result === 0){
			                $data = array( "status" => "false","message" => "Update profil gagal. Coba lagi");
		                    $this->response($data, 200);
			            }else{
			            	$data = array( "status" => "true","message" => "Update profil berhasil", "data" => $result);
			                $this->response($data, 200);
			            }
         		}else{
         			$passLama = $this->Model->getPass($id_user);
         			foreach ($passLama as $key => $value) {
         				$passLama = $value['password'];
         			}
         			if ($password == $passLama) {
         				$result = $this->Model->updateProfil($id_user, array("nama"=>$nama, "username"=>$username, "email"=>$email, "password"=>$password_baru,"no_telepon"=>$no_telp));
         				if($result === 0){
			                $data = array( "status" => "false","message" => "Update profil gagal. Coba lagi");
		                    $this->response($data, 200);
			            }else{
			            	$data = array( "status" => "true","message" => "Update profil berhasil", "data" => $result);
			                $this->response($data, 200);
			            }
         			}else{
         				$data = array( "status" => "false","message" => "Password Lama anda salah. Coba Lagi");
                    	$this->response($data, 200);
         			}
         		} 
         	}else{
         		// $image = base64_decode($_FILES);
	            $name_file = $id_user."_" .time();
	            $config['upload_path']          = './uploads/fotoProfil';
	            $config['allowed_types']        = 'jpg|png';
	            $config['max_size']             = 5024;
	            $config['file_name'] = $name_file;
	            // $config['max_width']            = 1024;
	            // $config['max_height']           = 768;

	            $this->load->library('uploadandroid', $config);
		    	$this->uploadandroid->initialize($config);

	            if ( ! $this->uploadandroid->do_upload('foto_profil', true)) {
	                $data = array( "status" => "false","message" => $this->upload->display_errors());
	                $this->response($data, 200);
	         	} else {
	         		$file_upload = $this->uploadandroid->data();
	         		$id_userFIX     = str_replace("\r\n","",$id_user);
			         $namaFIX     = str_replace("\r\n","",$nama);
			         $usernameFIX    = str_replace("\r\n","",$username);			         
			         $emailFIX  = str_replace("\r\n","",$email);
			         $no_telpFIX      = str_replace("\r\n","",$no_telp);
	         		if (!$password_baru && !$password) {
	         			$result = $this->Model->updateProfil($id_userFIX, array("nama"=>$namaFIX, "username"=>$usernameFIX, "email"=>$emailFIX, "no_telepon"=>$no_telpFIX, "foto_profil"=>$file_upload['file_name']));
	         			if($result === 0){
				                $data = array( "status" => "false","message" => "Update profil gagal. Coba lagi");
			                    $this->response($data, 200);
				            }else{
				            	$data = array( "status" => "true","message" => "Update profil berhasil", "data" => $result);
				                $this->response($data, 200);
				            }
	         		}else{
	         			$passwordFIX  = str_replace("\r\n","",$password);
			         	$password_baruFIX = str_replace("\r\n","",$password_baru);
	         			$passLama = $this->Model->getPass($id_user);
	         			foreach ($passLama as $key => $value) {
	         				$passLama = $value['password'];
	         			}
	         			if ($passwordFIX == $passLama) {
	         				$result = $this->Model->updateProfil($id_user, array("nama"=>$namaFIX, "username"=>$usernameFIX, "email"=>$emailFIX, "password"=>$password_baruFIX,"no_telepon"=>$no_telpFIX, "foto_profil"=>$file_upload['file_name']));
	         				if($result === 0){
				                $data = array( "status" => "false","message" => "Update profil gagal. Coba lagi");
			                    $this->response($data, 200);
				            }else{
				            	$data = array( "status" => "true","message" => "Update profil berhasil", "data" => $result);
				                $this->response($data, 200);
				            }
	         			}else{
	         				$data = array( "status" => "false","message" => "Password Lama anda salah. Coba Lagi");
	                    	$this->response($data, 200);
	         			}
	         		} 
	        	}
         	} 
         }     	
    }

    public function getLastLaporan_post($id_user)
    {
    	$id_user = $this->post('id_user');

    	if(!$id_user){
            $data = array( "status" => "false","message" => "Username tidak ada");
            $this->response($data, 200);
            exit;
        }else{
            $result = $this->Model->getLastLaporan( $id_user );

            if($result){
                $data = array( "status" => "true","message" => "Laporan Terakhir berhasil diambil", "data" => $result);
                $this->response($data, 200); 

                exit;
            } else {
                 $data = array( "status" => "false","message" => "Tidak ada Laporan");
                $this->response($data, 200);

                exit;
            }
        } 

    }

    function getAllNotification_post(){
    	$id_user = $this->post('id_user');

    	if(!$id_user){
            $data = array( "status" => "false","message" => "Username tidak ada");
            $this->response($data, 200);
            exit;
        }else{
            $result = $this->Model->getAllNotification( $id_user );

            if($result){
                $data = array( "status" => "true","message" => "Data notifikasi berhasil diambil", "data" => $result);
                $this->response($data, 200); 

                exit;
            } else {
                 $data = array( "status" => "false","message" => "Tidak ada notifikasi");
                $this->response($data, 200);

                exit;
            }
        }     
    }


//OPERATOR STASIUN
//PELAPORAN OPERATOR

    function getAllPelaporan_get(){
        $result = $this->Model->getAllPelaporan();

        if($result){
            $data = array( "status" => "true","message" => "Data Peloran berhasil diambil", "data" => $result);
            $this->response($data, 200);
        }else{
            $data = array( "status" => "false","message" => "Tidak ada pelaporan");
            $this->response($data, 200);

        }
    }

    function getAllPelaporanUser_post(){
        $id_user = $this->post('id_user');

        if(!$id_user){
            $data = array( "status" => "false","message" => "Username tidak ada");
            $this->response($data, 200);
            exit;
        }else{
            $result = $this->Model->getAllPelaporanUser( $id_user );

            if($result){
                $data = array( "status" => "true","message" => "Data Peloran berhasil diambil", "data" => $result);
                $this->response($data, 200); 

                exit;
            } else {
                 $data = array( "status" => "false","message" => "Tidak ada data pelaporan");
                $this->response($data, 200);

                exit;
            }
        }        
    }

    function getThePelaporan_post(){
        $id_laporan = $this->post('id_laporan');

        if(!$id_laporan){
            $data = array( "status" => "false","message" => "Tidak Ada Pelaporan yang Dipilih");
            $this->response($data, 200);
            exit;
        }else{
            $result = $this->Model->getThePelaporan( $id_laporan );

            if($result){
                $data = array( "status" => "true","message" => "Data Peloran berhasil diambil", "data" => $result);
                $this->response($data, 200); 

                exit;
            } else {
                 $data = array( "status" => "false","message" => "Tidak ada pelaporan");
                $this->response($data, 200);

                exit;
            }
        }        
    }

    function uploadLaporan_post() {
         $jenis_laporan     = $this->post('jenis_laporan');
         $kondisi     = $this->post('kondisi');
         $keterangan    = $this->post('keterangan');
         $id_user  = $this->post('id_user');
         // $foto = $this->post('foto');
        
         if(!$jenis_laporan || !$kondisi || !$keterangan || !$_FILES || !$id_user){
                $data = array( "status" => "false","message" => "Masukkan keterangan laporan secara lengkap");
                $this->response($data, 200);

         }else{
//          	$base64 = strtr($foto, '-_', '+/');
// 	        $image = base64_decode($base64);
         	// echo $image;
//          	$f = finfo_open();

// $mime_type = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);

// $name_file = $id_user."_" .time().$mime_type;
// $path         = './uploads/PelaporanOperator'.$name_file;

// file_put_contents($path . $name_file, $image);
			// $name_file = $id_user."_" .time();

   //       	$temp_file_path = tempnam('./uploads/temp', 'androidtempimage'); // might not work on some systems, specify your temp path if system temp dir is not writeable
			//  file_put_contents($temp_file_path, $image);
			//  $image_info = getimagesize($temp_file_path); 
			//  $_FILES['userfile'] = array(
			//      'name' => uniqid().'.'.preg_replace('!\w+/!', '', $image_info['mime']),
			//      'tmp_name' => $temp_file_path,
			//      'size'  => filesize($temp_file_path),
			//      'error' => UPLOAD_ERR_OK,
			//      'type'  => $image_info['mime'],
			//  );

		    $name_file = $id_user."_" .time();	
		    $config['upload_path']          = './uploads/PelaporanOperator';
		    $config['allowed_types']        = 'gif|jpg|png|mp4|jpeg';
		    $config['max_size']             = 9024;
		    $config['file_name'] = $name_file;
		    // $config['max_width']            = 1024;
		    // $config['max_height']           = 768;

		    $this->load->library('uploadandroid', $config);
		    $this->uploadandroid->initialize($config);

		    if ( ! $this->uploadandroid->do_upload('foto', true)) {
		                $data = array( "status" => "false","message" => $this->uploadandroid->display_errors('',''));
		                $this->response($data, 200);
		    }else{
		    	$jenis_laporanFIX = str_replace("\r\n","",$jenis_laporan);
		        $kondisiFIX = str_replace("\r\n","",$kondisi);
		        $keteranganFIX = str_replace("\r\n","",$keterangan);
		        $id_userFIX = str_replace("\r\n","",$id_user);
		        
		        $file_upload = $this->uploadandroid->data();
		        $result = $this->Model->uploadLaporan(array("jenis_laporan"=>$jenis_laporanFIX, "kondisi"=>$kondisiFIX, "keterangan"=>$keteranganFIX, "foto"=>$file_upload['file_name'], "id_user"=>$id_userFIX));

		        if(!$result){
		            $data = array( "status" => "false","message" => "Pengiriman laporan gagal. Coba lagi");
		            $this->response($data, 200);

		        }else{
		            $data = array( "status" => "true","message" => "Pengiriman laporan berhasil");
		            $this->response($data, 200);                
		        }
		    }                        
        }
    }

     function addPeringatan_post() {
     	//TAMBAH JUDUL + JENIS
         $isi_notifikasi     = $this->post('isi_notifikasi');
         $id_user    = $this->post('id_user');
        
         if(!$isi_notifikasi || !$id_user){
                $data = array( "status" => "false","message" => "Data notifikasi kurang lengkap");
                $this->response($data, 200);
         }else{

            $result = $this->Model->addPeringatan(array("isi_notifikasi"=>$isi_notifikasi, "id_user"=>$id_user));

            if(!$result){
                $data = array( "status" => "false","message" => "Menambah peringatan gagal. Coba lagi");
                    $this->response($data, 200);
            }else{
                $data = array( "status" => "true","message" => "Menambah peringatan berhasil", "data" => $result);
                $this->response($data, 200); 
            }
        }
    }

    function deletePelaporan_post() {
        $id_laporan  = $this->post('id_laporan');
        $id_user = $this->post('id_user');
        if(!$id_laporan){
        	$data = array( "status" => "false","message" => "Tidak ada laporan yang dipilih");
                $this->response($data, 200);
        }
         
        if($this->Model->deletePelaporan($id_laporan)) {
        	$return = $this->Model->getLastLaporan($id_user);
            $data = array( "status" => "true","message" => "Laporan berhasil dihapus", "data"=> $return);
                $this->response($data, 200);
        }else {
            $data = array( "status" => "false","message" => "Laporan tidak berhasil dihapus. Coba lagi.");
                $this->response($data, 200);
        }
    }




//KALIBRATOR
//CATATAN PENGGANTIAN
    function uploadCatatan_post() {
    	 $id_stasiun	= $this->post('id_stasiun');
         $sparepart_sebelum     = $this->post('sparepart_sebelum');
         $pengganti_sparepart    = $this->post('pengganti_sparepart');
         $alasan_diganti    = $this->post('alasan_diganti');
         $id_user  = $this->post('id_user');
        
         if(!$id_stasiun ||!$sparepart_sebelum || !$pengganti_sparepart || !$alasan_diganti || !$_FILES || !$id_user){
                 $data = array( "status" => "false","message" => "Isi catatan penggantian secara lengkap"); 
                $this->response($data, 200);
         }else{
            // $image = base64_decode($_FILES);
            $name_file = $id_user."_" .time();
            $config['upload_path']          = './uploads/CatatanPenggantian';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|mp4|3gp';
            $config['max_size']             = 9024;
            $config['file_name'] = $name_file;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('uploadandroid', $config);
		    $this->uploadandroid->initialize($config);

		    if ( ! $this->uploadandroid->do_upload('foto', true)) {
		                $data = array( "status" => "false","message" => $this->uploadandroid->display_errors('',''));
		                $this->response($data, 200);
		    }else{
		    	$id_stasiunFIX = str_replace("\r\n","",$id_stasiun);
		        $sparepart_sebelumFIX = str_replace("\r\n","",$sparepart_sebelum);
		        $pengganti_sparepartFIX = str_replace("\r\n","",$pengganti_sparepart);
		        $alasan_digantiFIX = str_replace("\r\n","",$alasan_diganti);
		        $id_userFIX = str_replace("\r\n","",$id_user);
		        
		        $file_upload = $this->uploadandroid->data();
                $result = $this->Model->uploadCatatan(array("stasiun"=>$id_stasiunFIX, "sparepart_sebelum"=>$sparepart_sebelumFIX, "pengganti_sparepart"=>$pengganti_sparepartFIX, "alasan_diganti"=>$alasan_digantiFIX, "foto"=>$file_upload['file_name'], "id_user"=>$id_userFIX));

                if(!$result){
                    $data = array( "status" => "false","message" => "Pencatatan penggantian gagal. Coba lagi");
                    $this->response($data, 200);

                }else{
                    $data = array( "status" => "true","message" => "Pencatatan penggantian berhasil", "data" => $result);
                    $this->response($data, 200);                
                }
            }                      
        }
    }

    function getAllCatatan_get(){
        $result = $this->Model->getAllCatatan();

        if($result){
            $data = array( "status" => "true","message" => "Data catatan penggantian sparepart berhasil diambil", "data" => $result);
            $this->response($data, 200);
        }else{
            $data = array( "status" => "false","message" => "Tidak ada catatan penggantian sparepart");
            $this->response($data, 200);

        }
    }

    function getAllCatatanUser_post(){
        $id_user = $this->post('id_user');

        if(!$id_user){
            $data = array( "status" => "false","message" => "Username tidak ada");
            $this->response($data, 200);
            exit;
        }else{
            $result = $this->Model->getAllCatatanUser( $id_user );

            if($result){
                $data = array( "status" => "true","message" => "Data catatan penggantian sparepart berhasil diambil", "data" => $result);
                $this->response($data, 200); 

                exit;
            } else {
                 $data = array( "status" => "false","message" => "Tidak ada data catatan penggantian sparepart");
                $this->response($data, 404);

                exit;
            }
        }        
    }

    function getTheCatatan_post(){
        $id_catatan = $this->post('id_catatan');

        if(!$id_catatan){
            $data = array( "status" => "false","message" => "Tidak Ada Catatan Penggantian Sparepart yang Dipilih");
            $this->response($data, 200);
            exit;
        }else{
            $result = $this->Model->getTheCatatan( $id_catatan );

            if($result){
                $data = array( "status" => "true","message" => "Data Catatan Penggantian Sparepart berhasil diambil", "data" => $result);
                $this->response($data, 200); 

                exit;
            } else {
                 $data = array( "status" => "false","message" => "Tidak ada Catatan Penggantian Sparepart");
                $this->response($data, 200);

                exit;
            }
        }        
    }

    function deleteCatatan_post() {
        $id_catatan  = $this->post('id_catatan');
        if(!$id_catatan){
        	$data = array( "status" => "false","message" => "Tidak ada catatan yang dipilih");
                $this->response($data, 200);
        }
         
        if($this->Model->deleteCatatan($id_catatan)) {
            $data = array( "status" => "true","message" => "Catatan penggantian sparepart berhasil dihapus");
                $this->response($data, 200);
        }else {
            $data = array( "status" => "false","message" => "Catatan penggantian sparepart tidak berhasil dihapus. Coba lagi.");
                $this->response($data, 200);
        }
    }

    public function getNamaStasiun_get() {
    	 $result = $this->Model->getAllStasiun();

        if($result){
            $data = array( "status" => "true","message" => "Data Stasiun berhasil diambil", "data" => $result);
            $this->response($data, 200);
        }else{
            $data = array( "status" => "false","message" => "Tidak ada stasiun");
            $this->response($data, 200);

        }
    }
}