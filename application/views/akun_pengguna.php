<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<style type="text/css">
  #btn-delete:hover,
  #btn-delete > .mini-box > .fa-trash:hover{
    color: green !important;
  }

  #edit:hover,
  #edit > .mini-box > .fa-pencil:hover{
    color: green !important;
  }
  
</style>
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Akun Pengguna
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Home');?>"><i class="fa fa-home"></i> Beranda</a></li>
        <li class="active">Pengguna</li>
    </ol>
</section>
    
<section class="content">
    <div class="row">
        <div class="col-md-10 col-sm-8"></div>
        <div class="col-md-2 col-sm-4" style="margin-bottom: 10px">
                <a href="<?php echo site_url('AkunPengguna/viewBuatAkun') ?>"><button class="btn btn-block btn-primary"><i class="fa fa-fw fa-plus"></i>   Buat Akun</button></a>
        </div> 
        
    </div>

<!-- TABEL KALIBRATOR -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
            <?php
              if (!$status) {
                echo "<h1>".$user."</h1>";
              } else {
            ?>
                <div class="box-header">
                  <h3 class="box-title">Kalibrator</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-bordered" id="myTable1">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nama</th>
                      <th>Username</th>
                      <th>E-Mail</th>
                      <th>No Telp</th>
                      <th>Perusahaan</th>
                      <th>Foto Profil</th>
                      <th style="width: 80px">Kelola</th>
                    </tr>
                    <tr>
                    <?php
                    $i=0;
                      foreach ($user as $row) 
                        { 
                          if ($row['level'] != 2) {
                            continue;
                          }else{
                            $i++;
                    ?>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row['nama']; ?></td>
                      <td><?php echo $row['username']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td><?php echo $row['no_telepon']; ?></td>
                      <td><?php echo $row['nama_stasiun']; ?></td>
                      <td><img src="<?php echo $row['foto_profil']; ?>" style="width: 50px; height: 50px; "/></td>
            
                      <td style="padding: 5px">
                        <div class="row">
                          <div class="col-xs-6 hapus" style=" text-align: center; color:red;font-size:12px; padding: 2px 2px 2px 15px" >
                            <a href="javascript:void(0);" data-kode="<?php echo $row['id_user']; ?>" data-nama="<?php echo $row['nama']; ?>" style="color:red;" id="btn-delete">
                              <div class="mini-box">
                                <i class="fa fa-fw fa fa-trash" style="color:red; font-size: 20px"></i>
                              </div> Hapus
                            </a>
                          </div>
                          <div class="col-xs-6" style=" text-align: center; color:blue;font-size: 12px; padding: 2px 10px 2px 2px">
                            <a href="<?php echo base_url('AkunPengguna/viewEditAkun'); echo "/".$row['id_user']; ?>" style="color:blue;" id="edit">
                              <div class="mini-box">
                                <i class="fa fa-fw fa fa-pencil" style="color:blue; font-size: 20px"></i>
                              </div> Edit
                            </a>
                          </div>
                        </div>
                      </td>         
              
                    </tr>
                    <?php
                        }
                      }
                    ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->             
        </div>
    </div>
<div id="notif"><?php echo $this->session->flashdata('pesan'); ?></div>
<!-- TABEL OPERATOR STASIUN -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Operator Stasiun</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                  <table class="table table-bordered" id="myTable2">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nama</th>
                      <th>Username</th>
                      <th>E-Mail</th>
                      <th>No Telp</th>
                      <th>Stasiun</th>
                      <th>Foto Profil</th>
                      <th style="width: 80px">Kelola</th>
                    </tr>
                    <tr>
                    <?php
                      $i=0;

                      foreach ($user as $row) 
                        { 
                          if ($row['level'] != 0) {
                            continue;
                          }else{
                            $i++;
                    ?>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row['nama']; ?></td>
                      <td><?php echo $row['username']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td><?php echo $row['no_telepon']; ?></td>
                      <td><?php echo $row['nama_stasiun']; ?></td>
                      <td><img src="<?php echo $row['foto_profil']; ?>" style="width: 50px; height: 50px; "/></td>
            
                      <td style="padding: 5px">
                        <div class="row">
                          <div class="col-xs-6 hapus" style=" text-align: center; color:red;font-size:12px; padding: 2px 2px 2px 15px" >
                            <a href="javascript:void(0);" data-kode="<?php echo $row['id_user']; ?>" data-nama="<?php echo $row['nama']; ?>" style="color:red;" id="btn-delete">
                              <div class="mini-box">
                                <i class="fa fa-fw fa fa-trash" style="color:red; font-size: 20px"></i>
                              </div> Hapus
                            </a>
                          </div>
                          <div class="col-xs-6" style=" text-align: center; color:blue;font-size: 12px; padding: 2px 10px 2px 2px">
                            <a href="<?php echo base_url('AkunPengguna/viewEditAkun'); echo "/".$row['id_user']; ?>" style="color:blue;" id="edit">
                              <div class="mini-box">
                                <i class="fa fa-fw fa fa-pencil" style="color:blue; font-size: 20px"></i>
                              </div> Edit
                            </a>
                          </div>
                        </div>
                      </td>         
              
                    </tr>
                    <?php
                        }
                      }
                    }
                    ?>
                    
                  </table>
                </div><!-- /.box-body -->
                <!-- <div class="box-footer clearfix">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul>
                </div> -->
              </div><!-- /.box --> 

              <!-- MODAL  -->
               <form id="add-row-form" action="<?php echo base_url('AkunPengguna/hapusAkun');?>" method="post">
                 <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               <h4 class="modal-title" id="myModalLabel">Hapus Laporan</h4>
                           </div>
                           <div class="modal-body">
                                   <input type="hidden" name="id_user" class="form-control" required>
                                                         <strong>Anda yakin mau menghapus akun <b name="nama_user"></b>   ?</strong>
                           </div>
                           <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="add-row" class="btn btn-success">Hapus</button>
                           </div>
                            </div>
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
<script type="text/javascript">
  $(function () {
    $('#myTable2').on('click','#btn-delete',function(){
        var kode=$(this).data('kode');
        var nama=$(this).data('nama');
        $('#ModalHapus').modal('show');
        $('[name="id_user"]').val(kode);
        $('[name="nama_user"]').html(nama);
      });

    $('#myTable1').on('click','#btn-delete',function(){
        var kode=$(this).data('kode');
        var nama=$(this).data('nama');
        $('#ModalHapus').modal('show');
        $('[name="id_user"]').val(kode);
        $('[name="nama_user"]').html(nama);
      });
  });
</script>
<?php
$this->load->view('template/foot');
?>