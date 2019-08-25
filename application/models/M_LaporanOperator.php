<?php
class M_LaporanOperator extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function getAllPelaporan(){
        $query = $this->db->query("SELECT `id_laporan`, U.`id_user`, U.`nama`, `jenis_laporan`, `kondisi`, `keterangan`,`foto`, `waktu_pelaporan`, S.`nama_stasiun` FROM `laporan_operator` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` ORDER BY `waktu_pelaporan` DESC");
           if($query->num_rows() >= 1){
              return $query->result_array();
           }else{
              return 0;
          }
    }

    public function getAllPelaporantoPaginate($limit, $start)
    {
      $this->db->select('l.id_laporan, l.jenis_laporan, l.kondisi, l.keterangan, l.foto, l.waktu_pelaporan, s.nama_stasiun, u.id_user, u.nama');
      $this->db->from('laporan_operator l');
      $this->db->join('user u', 'u.id_user = l.id_user');
      $this->db->join('stasiun s', 's.id_stasiun = u.id_stasiun');
      $this->db->order_by('l.waktu_pelaporan', 'DESC');
      $this->db->limit($limit, $start);
      $query = $this->db->get();
      if($query->num_rows() >= 1){
              return $query->result_array();
           }else{
              return 0;
          }
    }

    public function getPelaporanRentangWaktu($awal, $akhir)
    {
    	$query = $this->db->query("SELECT `id_laporan`, P.`id_user`,U.`nama`, `waktu_pelaporan`, `jenis_laporan`, `kondisi`, `keterangan`, `foto`, S.`nama_stasiun` FROM `laporan_operator` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` WHERE (SELECT EXTRACT(YEAR_MONTH FROM `waktu_pelaporan`)) BETWEEN '$awal' AND '$akhir' ORDER BY `waktu_pelaporan` DESC");
           
          if($query->num_rows() >= 1){
               return $query->result_array();
           }else{
             return 0;
          }
    }

    public function getRowPelaporanRentangWaktu($awal, $akhir)
    {
      $query = $this->db->query("SELECT `id_laporan`, P.`id_user`,U.`nama`, `waktu_pelaporan`, `jenis_laporan`, `kondisi`, `keterangan`, `foto`, S.`nama_stasiun` FROM `laporan_operator` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` WHERE (SELECT EXTRACT(YEAR_MONTH FROM `waktu_pelaporan`)) BETWEEN '$awal' AND '$akhir' ORDER BY `waktu_pelaporan` DESC");
           return $query->num_rows();
    }

    public function getPelaporanRentangWaktuPaginate($awal, $akhir, $limit, $start)
    {
      $query = $this->db->query("SELECT `id_laporan`, P.`id_user`,U.`nama`, `waktu_pelaporan`, `jenis_laporan`, `kondisi`, `keterangan`, `foto`, S.`nama_stasiun` FROM `laporan_operator` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` WHERE (SELECT EXTRACT(YEAR_MONTH FROM `waktu_pelaporan`)) BETWEEN '$awal' AND '$akhir' ORDER BY `waktu_pelaporan` DESC LIMIT $start,$limit ");
      if($query->num_rows() >= 1){
              return $query->result_array();
           }else{
              return 0;
          }
    }

    

    public function deletePelaporan($id_laporan)
    {
      $this->db->where('id_laporan', $id_laporan);

      if($this->db->delete('laporan_operator')){
        return true;
      }else{
        return false;
      }
    }

}
?>