<?php
class M_Stasiun extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function getAllStasiun()
    {
      $query = $this->db->query("SELECT `id_stasiun`, `nama_stasiun` FROM `stasiun`");
           
      if($query->num_rows() >= 1){
        return $query->result_array();
      }else{
        return 0;
      }         
    }

    public function getStasiunbyID($id_stasiun)
    {
      $query = $this->db->query("SELECT `id_stasiun`, `nama_stasiun` FROM `stasiun` WHERE `id_stasiun` = '$id_stasiun'");
           
      if($query->num_rows() == 1){
        return $query->result_array();
      }else{
        return 0;
      }   
    }

}
?>