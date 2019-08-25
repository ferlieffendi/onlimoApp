<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<style type="text/css">
	.profile-user-img{
		margin: 10px auto;
	    width: 150px;
	    padding: 3px;
	    border: 3px solid #d2d6de;
	}
	.post .user-block {
	    margin-bottom: 15px;
	}
	.user-block img {
	    width: 40px;
	    height: 40px;
	    float: left;
	}
	.img-bordered-sm {
	    border: 2px solid #d2d6de;
	    padding: 2px;
	}
	.img-circle {
	    border-radius: 50%;
	}
	img {
	    vertical-align: middle;
	}
</style>
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<section class="content-header">
    <h1>
        Edit Profil
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Home') ?>"><i class="fa fa-home"></i> Beranda</a></li>
        <li><a href="<?php echo site_url('admin');?>">Profil</li>
        <li class="active">Edit Profil</li>
    </ol>
</section>
<div id="notif"><?php echo $this->session->flashdata('pesan'); ?></div>
<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url('Admin/editProfil/'.$this->session->userdata('id_user')); ?>">
            <?php
                foreach ($profil as $key) {                
            ?>
                <input type="text" name="foto_lama" value="<?php echo $key['foto_profil'];?>" hidden>
                <img class="profile-user-img img-responsive img-circle" src="../../uploads/fotoProfil/<?php echo $key['foto_profil'];?>" alt="User profile picture">
                <div class="form-group" >
                    <label for="inputNama" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputNama" value="<?php echo $key['nama'];?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUsername" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputUsername" value="<?php echo $key['username'];?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPass" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="inputPass" value="<?php echo $key['password'];?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="inputEmail" value="<?php echo $key['email'];?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputTelp" class="col-sm-2 control-label">Nomor Telepon</label>

                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="inputTelp" value="<?php echo $key['no_telepon'];?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputFoto" class="col-sm-2 control-label">Ubah Foto Profil</label>

                    <div class="col-sm-10">
                      <input type="file" name="inputFoto" style="margin: auto 0;" value="<?php echo $key['foto_profil'];?>" >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Simpan</button>
                    </div>
                </div>
                <?php
                    }
                ?>
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