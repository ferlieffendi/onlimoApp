<?php
class M_AkunPengguna extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function getAllAkun()
    {
    	$query = $this->db->query("SELECT `id_user`,`nama`,`username`, `email`, `no_telepon`, `foto_profil`, S.`nama_stasiun`, `level` FROM `user` U JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` WHERE `level` != 1 ORDER BY `id_user`");

    	if($query->num_rows() >= 1){
            return $query->result_array();
        }else{
            return 0;
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

    public function updateProfil($id_user, $data){
        $this->db->where('id_user', $id_user);

       if($this->db->update('user', $data)){
          return true;
        }else{
          return false;
        }
    }

    public function buatAkun($data)
    {
    	if($this->db->insert('user', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function deleteAkun($id_user)
    {
    	$this->db->where('id_user', $id_user);

       	if($this->db->delete('user')){
          return true;
        }else{
          return false;
        }
    }

}
?>