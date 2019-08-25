<?php
  class Model extends CI_Model {
       
      public function __construct(){
          
        $this->load->database();
        
      }

      public function login($username, $password){

        $query = $this->db->query("SELECT `id_user`, `nama`, `username`, `password`, `email`, `no_telepon`, `foto_profil`, `level`, S.`nama_stasiun` FROM user U JOIN stasiun S ON U.`id_stasiun` = S.`id_stasiun`WHERE (`username`='$username' AND `password`='$password') AND (`level`= 0 OR `level`= 2)");
           
           if($query->num_rows() == 1){
               return $query->result_array();
           }else{
             return 0;
          }          
      }

      public function updateProfil($id_user, $data){
        $this->db->where('id_user', $id_user);

       if($this->db->update('user', $data)){
          $query = $this->db->query("SELECT * FROM `user` WHERE `id_user` = '$id_user'");
          return $query->result_array();;
        }else{
          return 0;
        }
      }

      public function getPass($id_user) {
        $query = $this->db->query("SELECT `password` FROM `user` WHERE `id_user` = '$id_user'");
        if($query->num_rows() == 1){
               return $query->result_array();
          }else{
             return 0;
          }
      }

      public function getLastLaporan($id_user) {
        $query = $this->db->query("SELECT `waktu_pelaporan` FROM `laporan_operator` WHERE `id_user` = '$id_user' ORDER BY `waktu_pelaporan` DESC LIMIT 1");
        if($query->num_rows() == 1){
               return $query->result_array();
          }else{
             return 0;
          }
      }

      public function getAllNotification($id_user) {
        $query = $this->db->query("SELECT * FROM `notifikasi_peringatan` WHERE `id_user` = '$id_user'");

        if($query->num_rows() == 1){
               return $query->result_array();
          }else{
             return 0;
          }
      }

//OPERATOR STASIUN
//PELAPORAN OPERATOR
      public function getAllPelaporan(){

        $query = $this->db->query("SELECT `id_laporan`, U.`id_user`, U.`nama`, U.`foto_profil`, `jenis_laporan`, `kondisi`, `keterangan`,`foto`, `waktu_pelaporan`, S.`nama_stasiun` FROM `laporan_operator` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` ORDER BY `waktu_pelaporan` DESC");
           if($query->num_rows() >= 1){
              return $query->result_array();
           }else{
              return 0;
          }
      }

      public function getAllPelaporanUser($id_user){
        $query = $this->db->query("SELECT `id_laporan`, U.`id_user`, U.`nama`, U.`foto_profil`, `jenis_laporan`, `kondisi`, `keterangan`,`foto`, `waktu_pelaporan`, S.`nama_stasiun` FROM `laporan_operator` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` WHERE U.`id_user` = '$id_user' ORDER BY `waktu_pelaporan` DESC");
           
           if($query->num_rows() >= 1){
               return $query->result_array();
           }else{
             return 0;
          }
      }

      public function getThePelaporan($id_laporan){

        $query = $this->db->query("SELECT `id_laporan`, P.`id_user`,U.`nama`, U.`foto_profil`, `waktu_pelaporan`, `jenis_laporan`, `kondisi`, `keterangan`, `foto`, S.`nama_stasiun` FROM `laporan_operator` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` WHERE `id_laporan` = '$id_laporan'");
           
          if($query->num_rows() == 1){
               return $query->result_array();
           }else{
             return 0;
          }
      }
     
      public function uploadLaporan($data) {
          if($this->db->insert('laporan_operator', $data)){
             return true;
          }else{
             return false;
          }
      }

      public function addPeringatan($data) {
          if($this->db->insert('notifikasi_peringatan', $data)){
             return true;
          }else{
             return false;
          }
      }  

      public function deletePelaporan($id_laporan) {
        $this->db->where('id_laporan', $id_laporan);
       if($this->db->delete('laporan_operator')){
          return true;
        }else{
          return false;
        }
      }

      public function cekPelaporan($id_user)
      {
        $query = $this->db->query("SELECT `waktu_pelaporan`, (DATEDIFF (CURRENT_TIMESTAMP, `waktu_pelaporan`)) AS tenggat_waktu FROM `laporan_operator` WHERE `id_user`= '$id_user' AND jenis_laporan = 'pembersihan' ORDER BY `laporan_operator`.`waktu_pelaporan` DESC LIMIT 1");

        if($query->num_rows() == 1){
               return $query->result_array();
           }else{
             return 0;
          }
      }

//KALIBRATOR
//CATATAN PENGGANTIAN
       public function getAllCatatan(){

        $query = $this->db->query("SELECT `id_catatan`, P.`id_user`, U.`nama`, U.`foto_profil`, `tanggal_penggantian`, `sparepart_sebelum`, `pengganti_sparepart`, `alasan_diganti`, `foto`, S.`nama_stasiun` FROM `catatan_penggantian` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = P.`stasiun` ORDER BY `P`.`tanggal_penggantian` DESC");
           
           if($query->num_rows() >= 1){
               return $query->result_array();
           }else{
             return 0;
          }
      }

      public function getAllCatatanUser($id_user){

        $query = $this->db->query("SELECT `id_catatan`, P.`id_user`, U.`nama`, U.`foto_profil`, `tanggal_penggantian`, `sparepart_sebelum`, `pengganti_sparepart`, `alasan_diganti`, `foto`, S.`nama_stasiun` FROM `catatan_penggantian` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = P.`stasiun` WHERE U.`id_user` = '$id_user' ORDER BY `tanggal_penggantian` DESC");
           
           if($query->num_rows() >= 1){
               return $query->result_array();
           }else{
             return 0;
          }
      }

      public function getTheCatatan($id_catatan){

        $query = $this->db->query("SELECT `id_catatan`, P.`id_user`, U.`nama`, U.`foto_profil`, `tanggal_penggantian`, `sparepart_sebelum`, `pengganti_sparepart`, `alasan_diganti`, `foto`, S.`nama_stasiun` FROM `catatan_penggantian` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` WHERE `id_catatan` = '$id_catatan'");
           
           if($query->num_rows() == 1){
               return $query->result_array();
           }else{
             return 0;
          }
      }

      public function uploadCatatan($data) {
          if($this->db->insert('catatan_penggantian', $data)){
             return true;
          }else{
             return false;
          }
      }

      public function deleteCatatan($id_catatan) {
        $this->db->where('id_catatan', $id_catatan);
       if($this->db->delete('catatan_penggantian')){
          return true;
        }else{
          return false;
        }
      }

      public function getAllStasiun(){
        $query = $this->db->query("SELECT `id_stasiun`, `nama_stasiun` FROM `stasiun` WHERE `id_stasiun`LIKE 'KLHK%'");
             
        if($query->num_rows() >= 1){
          return $query->result_array();
        }else{
          return 0;
        }         
      }
}