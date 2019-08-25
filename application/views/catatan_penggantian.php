<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<style type="text/css">
  #btn-delete:hover,
  #btn-delete > .mini-box > .fa-trash:hover{
    color: green !important;
  }
  
  .ui-datepicker-calendar {
    display: none;
  }
</style>
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Catatan Penggantian
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Home');?>"><i class="fa fa-home"></i> Beranda</a></li>
        <li class="active">Catatan Penggantian</li>
    </ol>
</section>
<div id="notif"><?php echo $this->session->flashdata('pesan'); ?></div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
              <div class="box-header">
                  <div class="row" >
                      <div class="col-md-10 col-sm-8">
                        <form class="form-inline" action="<?php echo site_url('CatatanPenggantian/getCatatanRentangWaktu'); ?>" method="post">
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="date-picker" placeholder="Tahun" name="tahun_pilih" required />
                            </div><!-- /.input group -->
                          </div>
                          <button type="tampilCatatan" class="btn btn-default">Tampilkan</button>
                        </form>
                      </div>
                      <div class="col-md-2 col-sm-4">
                          <form action="<?php echo site_url('CatatanPenggantian/getPDFCatatan'); ?>" method="post" target="_blank">
                        <?php
                          if (!$tahun_pilih) {
                        ?>
                          <input hidden name="tahun_pilih" value=""></input>
                        <?php  } else { ?>
                          <input hidden name="tahun_pilih" value="<?php echo $tahun_pilih ?>"></input>
                        <?php } ?>
                          <button class="btn btn-block btn-primary" name="PDFCatatan"><i class="fa fa-fw fa fa-file-pdf-o" style="font-size: 20px"></i>      Buat PDF</button>
                        </form>

                      </div> 
                      
                  </div>
                  
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                <?php
                  if (!$status) {
                    echo "<h1 style='margin:auto;'>".$catatan."</h1>";
                  } else {
                ?>
                  <table class="table table-bordered" id="myTable">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Stasiun</th>
                      <th>Nama Kalibrator</th>
                      <th>Tanggal Penggantian</th>
                      <th>Sparepart Lama</th>
                      <th>Sparepart Baru</th>
                      <th>Alasan Diganti</th>
                      <th>Foto / Video</th>
                      <th style="width: 80px">Kelola</th>
                    </tr>
                    <tr>
                    <?php
                    $i=0;
                      foreach ($catatan as $row) 
                        { 
                          $i++;
                    ?>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row['nama_stasiun']; ?></td><td><?php echo $row['nama']; ?></td>
                      <td><?php echo $row['tanggal_penggantian']; ?></td>
                      <td><?php echo $row['sparepart_sebelum']; ?></td>
                      <td><?php echo $row['pengganti_sparepart']; ?></td>
                      <td><?php echo $row['alasan_diganti']; ?></td>
                      <td><img src="<?php echo $row['foto']; ?>" style="width: 80px; height: 80px; "/></td>
            
                      <td style="padding: 5px">
                        <div class="row">
                          <div class="col-xs-12" style=" text-align: center; color:red;font-size:12px;">
                          <a href="javascript:void(0);" data-kode="<?php echo $row['id_catatan']; ?>" style="color:red;" id="btn-delete">
                            <div class="mini-box">
                              <i class="fa fa-fw fa fa-trash" style="color:red; font-size: 20px"></i>
                            </div> Hapus
                          </a>
                          </div>
                        </div>
                      </td>         
              
                    </tr>
                    <?php
                        }
                    ?>
                  
                  </table>

                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <div class="col">
                    <?php echo $pagination; ?>
                  </div>
                </div>
                <?php
                  }
                ?>
              </div><!-- /.box -->

              <!-- MODAL  -->
             <form id="add-row-form" action="<?php echo base_url('CatatanPenggantian/hapusCatatan');?>" method="post">
               <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content">
                         <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                             <h4 class="modal-title" id="myModalLabel">Hapus Catatan</h4>
                         </div>
                         <div class="modal-body">
                                 <input type="hidden" name="id_catatan" class="form-control" required>
                                                       <strong>Anda yakin mau menghapus catatan ini?</strong>
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
  $(function() {
      $('#date-picker').datepicker( {
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy',
        yearRange: "2005:+0",
        onClose: function(dateText, inst) { 
          $(this).datepicker('setDate', new Date(inst.selectedYear,  1));
        }
      });

      $(".date-picker").focus(function () {
          $(".ui-datepicker-month").hide();
      });

      $('#myTable').on('click','#btn-delete',function(){
        var kode=$(this).data('kode');
        $('#ModalHapus').modal('show');
        $('[name="id_catatan"]').val(kode);
      });
  });
  
  </script>
<?php
$this->load->view('template/foot');
?>