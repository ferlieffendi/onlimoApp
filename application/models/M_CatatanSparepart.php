<?php
class M_CatatanSparepart extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function getAllCatatantoPaginate($limit, $start){
      $this->db->select('`id_catatan`, P.`id_user`, U.`nama`, U.`foto_profil`, `tanggal_penggantian`, `sparepart_sebelum`, `pengganti_sparepart`, `alasan_diganti`, `foto`, S.`nama_stasiun`');
      $this->db->from('`catatan_penggantian` P');
      $this->db->join('user u', 'u.id_user = P.id_user');
      $this->db->join('stasiun s', 's.id_stasiun = P.stasiun');
      $this->db->order_by('P.`tanggal_penggantian`', 'DESC');
      $this->db->limit($limit, $start);
      $query = $this->db->get();
      if($query->num_rows() >= 1){
              return $query->result_array();
           }else{
              return 0;
          }
    }

    public function getAllCatatan(){
        $query = $this->db->query("SELECT `id_catatan`, P.`id_user`, U.`nama`, U.`foto_profil`, `tanggal_penggantian`, `sparepart_sebelum`, `pengganti_sparepart`, `alasan_diganti`, `foto`, S.`nama_stasiun` FROM `catatan_penggantian` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = P.`stasiun` ORDER BY `P`.`tanggal_penggantian` DESC");
           if($query->num_rows() >= 1){
              return $query->result_array();
           }else{
              return 0;
          }
    }

    public function getCatatanRentangWaktu($tahun_pilih)
    {
    	$query = $this->db->query("SELECT `id_catatan`, P.`id_user`, U.`nama`, U.`foto_profil`, `tanggal_penggantian`, `sparepart_sebelum`, `pengganti_sparepart`, `alasan_diganti`, `foto`, S.`nama_stasiun` FROM `catatan_penggantian` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON P.`stasiun` = S.`id_stasiun` WHERE YEAR(`tanggal_penggantian`) = '$tahun_pilih' ORDER BY `tanggal_penggantian` DESC"); 
           
          if($query->num_rows() >= 1){
               return $query->result_array();
           }else{
             return 0;
          }
    }

    public function getRowCatatanRentangWaktu($tahun_pilih)
    {
      $query = $this->db->query("SELECT `id_catatan`, P.`id_user`, U.`nama`, U.`foto_profil`, `tanggal_penggantian`, `sparepart_sebelum`, `pengganti_sparepart`, `alasan_diganti`, `foto`, S.`nama_stasiun` FROM `catatan_penggantian` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON P.`stasiun` = S.`id_stasiun` WHERE YEAR(`tanggal_penggantian`) = '$tahun_pilih' ORDER BY `tanggal_penggantian` DESC"); 
      return $query->num_rows();
    }

    public function getCatatanRentangWaktuPaginate($tahun_pilih, $limit, $start)
    {
      $query = $this->db->query("SELECT `id_catatan`, P.`id_user`, U.`nama`, U.`foto_profil`, `tanggal_penggantian`, `sparepart_sebelum`, `pengganti_sparepart`, `alasan_diganti`, `foto`, S.`nama_stasiun` FROM `catatan_penggantian` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON P.`stasiun` = S.`id_stasiun` WHERE YEAR(`tanggal_penggantian`) = '$tahun_pilih' ORDER BY `tanggal_penggantian` DESC LIMIT $start,$limit"); 
           
          if($query->num_rows() >= 1){
               return $query->result_array();
           }else{
             return 0;
          }
    }

    public function deleteCatatan($id_catatan)
    {
      $this->db->where('id_catatan', $id_catatan);

      if($this->db->delete('catatan_penggantian')){
        return true;
      }else{
        return false;
      }
    }

}
?>