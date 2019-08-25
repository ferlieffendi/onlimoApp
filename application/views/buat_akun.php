<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<section class="content-header">
    <h1>
        Buat Akun Baru
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Home');?>"><i class="fa fa-home"></i> Beranda</a></li>
        <li><a href="<?php echo site_url('AkunPengguna');?>">Pengguna</a></li>
        <li class="active">Buat Akun Baru</li>
    </ol>
</section>

<section class="content">
	<div class="box box-primary">
        <div class="box-body">
        	<form class="form-horizontal" method="post" action="<?php echo site_url('AkunPengguna/buatAkun') ?>" enctype="multipart/form-data">
    			<div class="form-group" >
                    <label for="inputNama" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputNama" placeholder="Nama" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUsername" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputUsername" placeholder="Username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPass" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="inputPass" placeholder="Password (Max. 8 Karakter)" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="inputEmail" placeholder="Email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputTelp" class="col-sm-2 control-label">Nomor Telepon</label>

                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="inputTelp" placeholder="Nomor Telepon" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputLevel" class="col-sm-2 control-label">Jenis Pengguna</label>

                    <div class="col-sm-10">
                      <select class="form-control" name="inputLevel" >
                        <option value="" hidden>Jenis Pengguna</option>
                        <option value="1">Admin Data Center</option>
                        <option value="2">Kalibrator</option>
                        <option value="0">Operator Stasiun</option>
                      </select>  
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputStasiun" class="col-sm-2 control-label">Stasiun</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="inputStasiun">
                        <option value="" hidden>Stasiun</option>
                        <?php
                          if (!$status) {
                            echo "<option disabled>".$stasiun."</option>";
                          } else {
                            foreach ($stasiun as $row) { 
                                echo "<option value='".$row['id_stasiun']."'>".$row['nama_stasiun']."</option>";
                            }
                          }
                        ?>
                      </select>  
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputFoto" class="col-sm-2 control-label">Foto Profil</label>

                    <div class="col-sm-10">
                      <input type="file" name="inputFoto" style="margin: auto 0; " required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Buat Akun</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php 
$this->load->view('template/js');
?>
<!--tambahkan custom js disini-->
<?php
$this->load->view('template/foot');
?>