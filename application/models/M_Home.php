<?php
class M_Home extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function getAllLokasi()
    {
    	$query = $this->db->query("SELECT s.id_stasiun, s.nama_stasiun, s.alamat_stasiun, s.latitude, s.longitude, u.id_user, u.nama, u.no_telepon, l.id_laporan, l.waktu_pelaporan, l.jenis_laporan, l.kondisi, l.keterangan, l.foto from stasiun s join user u on s.id_stasiun = u.id_stasiun left join laporan_operator l on u.id_user = l.id_user and l.waktu_pelaporan in (select MAX(waktu_pelaporan) from laporan_operator group by id_user)");
        // select s.id_stasiun, s.nama_stasiun, s.alamat_stasiun, s.latitude, s.longitude, u.id_user, u.nama, u.no_telepon, l.id_laporan, l.waktu_pelaporan, l.jenis_laporan, l.kondisi, l.keterangan from stasiun s join user u on s.id_stasiun = u.id_stasiun join laporan_operator l on u.id_user = l.id_user where l.waktu_pelaporan in (select MAX(waktu_pelaporan) from laporan_operator group by id_user)

    	if($query->num_rows() >= 1){
            return $query->result_array();
        }else{
            return 0;
        }
    }

    public function getLastPost($id_post)
    {
        $query = $this->db->query("SELECT * FROM `laporan_operator` WHERE `id_laporan`= '$id_post'");

        if($query->num_rows() == 1){
            return $query->result_array();
        }else{
            return 0;
        }
    }

    public function cekInfo($id_user)
    {
        $query = $this->db->query("SELECT `id_laporan`, `waktu_pelaporan`, `jenis_laporan`, `kondisi` FROM `laporan_operator` WHERE `id_user`= '$id_user' ORDER BY `waktu_pelaporan` DESC LIMIT 1");

        if($query->num_rows() == 1){
            return $query->result_array();
        }else{
            return 0;
        }
    }

    public function cekWarning($id_user)
    {
        $query = $this->db->query("SELECT DATEDIFF ((SELECT `waktu_pelaporan` FROM `laporan_operator` WHERE `id_user`= '$id_user' ORDER BY `waktu_pelaporan` DESC LIMIT 1), CURRENT_TIMESTAMP) AS cekWarning");
        $hasil = $query->result_array();
        foreach ($hasil as $key) {
            return $key['cekWarning'];
        }
    }

    public function cekKalibrasi($id_stasiun, $waktu_pelaporan)
    {
        $query = $this->db->query("SELECT * FROM `catatan_penggantian` WHERE (`tanggal_penggantian` BETWEEN '$waktu_pelaporan' AND CURRENT_TIMESTAMP ) AND `stasiun`='$id_stasiun' ORDER BY `tanggal_penggantian` DESC");

        return $query->num_rows();
    }

    public function getPelaporan( $id_laporan )
    {
        $query = $this->db->query("SELECT `id_laporan`, P.`id_user`,U.`nama`, U.`foto_profil`, `waktu_pelaporan`, `jenis_laporan`, `kondisi`, `keterangan`, `foto`, S.`nama_stasiun` FROM `laporan_operator` P JOIN `user` U ON U.`id_user` = P.`id_user` JOIN `stasiun` S ON S.`id_stasiun` = U.`id_stasiun` WHERE `id_laporan` = '$id_laporan'");
           
          if($query->num_rows() == 1){
               return $query->result_array();
           }else{
             return 0;
          }
    }

}
?>