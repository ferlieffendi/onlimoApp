<?php
class M_Admin extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function login($username, $password){

        $query = $this->db->query("SELECT `id_user`, `nama`, `username`, `foto_profil`, `level`, S.`nama_stasiun` FROM user U JOIN stasiun S ON U.`id_stasiun` = S.`id_stasiun`WHERE (`username`='$username' AND `password`='$password') AND (`level`= 1)");
           
           if($query->num_rows() == 1){
               return $query->result();
           }else{
             return 0;
          }          
    }

    public function updateProfil($id_user, $data){
        $this->db->where('id_user', $id_user);

       if($this->db->update('user', $data)){
          return true;
        }else{
          return false;
        }
    }

    public function posting($data) {
      if($this->db->insert('laporan_operator', $data)){
         return true;
      }else{
         return false;
      }
    }

    public function getProfileData($id_user)
    {
      $query = $this->db->query("SELECT `id_user`, `nama`, `username`, `password`, `email`, `no_telepon`, `foto_profil`, `level`, U.`id_stasiun`, S.`nama_stasiun`, `level` FROM `user` U JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` WHERE `id_user` = '$id_user'");
           
      if($query->num_rows() == 1){
        return $query->result_array();
      }else{
        return 0;
      }          
    }

    public function getAllPosting($id)
    {
      $query = $this->db->query("SELECT `id_laporan`, P.`id_user`, U.`nama`, U.`foto_profil`, `jenis_laporan`, `kondisi`, `keterangan`,`foto`, `waktu_pelaporan`, S.`nama_stasiun` FROM `laporan_operator` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` WHERE P.`id_user` = '$id' ORDER BY `waktu_pelaporan` DESC");
           if($query->num_rows() >= 1){
              return $query->result_array();
           }else{
              return 0;
          }
    }

}
?>