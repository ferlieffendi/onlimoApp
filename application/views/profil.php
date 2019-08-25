<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<style type="text/css">
	.profile-user-img{
		margin: 0 auto;
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

	.user-block .username {
	    font-size: 16px;
	    font-weight: 600;
	}
	.user-block .username, .user-block .description, .user-block .comment {
	    display: block;
	    margin-left: 50px;
	}
	.post {
	    border-bottom: 1px solid #d2d6de;
	    margin-bottom: 15px;
	    padding-bottom: 15px;
	    color: #666;
	}
	.post:last-of-type {
	    border-bottom: 0;
	    margin-bottom: 0;
	    padding-bottom: 0;
	}
</style>
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<section class="content-header">
    <h1>
        Profil 
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Home');?>"><i class="fa fa-home"></i> Beranda</a></li>
        <li class="active">Profil</li>
    </ol>
</section>
<div id="notif"><?php echo $this->session->flashdata('pesan'); ?></div>
<section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo site_url('/uploads/fotoProfil'); echo "/".$this->session->userdata('foto_profil'); ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $this->session->userdata('nama');?></h3>

              <p class="text-muted text-center"><?php echo $this->session->userdata('nama_stasiun');?></p>

              <a href="<?php echo site_url('admin/viewEditProfil/'.$this->session->userdata('id_user')); ?>" class="btn btn-default btn-block"><b><i class="fa fa-cog" style="margin-right: 5px"></i>Ubah Data Profil </b></a>
            </div>
            <!-- /.box-body -->
          </div>
         <!-- /.box -->
        </div>
        <div class="col-md-9">
        	<div class="box box-primary">
	            <div class="box-body box-profile">
	            <?php
	            	if (!$status) {
	            		echo "<h3>".$posting."</h3>";
	            	}else{
	            		foreach ($posting as $key) {
	            		
	            ?>
	            	<div class="post">
	            		<div class="user-block">
		                    <img class="img-circle img-bordered-sm" src="<?php echo site_url('/uploads/fotoProfil'); echo "/".$key['foto_profil']; ?>" alt="User Image">
		                        <span class="username">
		                          <a href="#">Adam Jones</a>
		                        </span>
		                    <span class="description"><?php echo $key['waktu_pelaporan']; ?></span>
		                </div>
	            		<div class="row">
		                    <div class="col-sm-12">
		                      <img class="img-responsive" src="<?php echo $key['foto']; ?>" alt="Photo" style="max-height: 300px; margin: 0 auto">
		                    </div>
	                  </div>
	                  <div class="row margin-bottom">
	                  	<div class="col-sm-12">
	                  		<p>
	                  			<?php echo "<b style='text-transform: uppercase;'>".$key['jenis_laporan']."</b> : ".$key['kondisi']."<br>".$key['keterangan']; ?>
	                  		</p>
	                  	</div>
	                  </div>
	            	</div>
	            	<?php
	            		}
	            	}
	            	?>
	            	</div>
	            </div>
            </div>
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