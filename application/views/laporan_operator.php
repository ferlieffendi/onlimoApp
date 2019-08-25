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
        Laporan Operator
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Beranda</a></li>
        <li class="active">Laporan Operator</li>
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
                        <form class="form-inline" method="post" action="<?php echo site_url('LaporanOperator/getPelaporanRentangWaktu'); ?>" >
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="date-picker" placeholder="Bulan-Tahun" name="waktu_awal" required/>
                            </div><!-- /.input group -->
                          
                            <label style="margin-left : 5px;">s/d</label>
                          </div>
                          <div class="form-group" style="margin:0px 5px; ">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="date-picker2" placeholder="Bulan-Tahun" name="waktu_akhir"  required/>
                            </div><!-- /.input group -->
                          </div>
                          <button type="tampilLaporan" class="btn btn-default">Tampilkan</button>
                        </form>
                      </div>
                      <div class="col-md-2 col-sm-4">
                        <form action="<?php echo site_url('LaporanOperator/getPDFPelaporan'); ?>" method="post" target="_blank">
                        <?php
                          if (!$waktu_awal && !$waktu_akhir) {
                        ?>
                        <input hidden name="waktu_awal" value=""></input>
                          <input hidden name="waktu_akhir" value=""></input>
                        <?php  } else { ?>
                          <input hidden name="waktu_awal" value="<?php echo $waktu_awal ?>"></input>
                          <input hidden name="waktu_akhir" value="<?php echo $waktu_akhir ?>"></input>
                        <?php } ?>
                          <button class="btn btn-block btn-primary" name="PDFLaporan"><i class="fa fa-fw fa fa-file-pdf-o" style="font-size: 20px"></i>      Buat PDF</button>
                        </form>
                      </div> 
                      
                  </div>
                  
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                <?php
                  if (!$status) {
                    echo "<h1 style='margin:auto;'>".$pelaporan."</h1>";
                  } else {
                ?>
                  <table class="table table-bordered " id="myTable">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nama Operator</th>
                      <th>Stasiun</th>
                      <th>Waktu Pelaporan</th>
                      <th>Isi Pelaporan</th>
                      <th>Bukti Pelaporan</th>
                      <th style="width: 80px">Kelola</th>
                    </tr>
                    <tr>
                    <?php
                    $i=0;
                      foreach ($pelaporan as $row) 
                        { 
                          $i++;
                    ?>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row['nama']; ?></td>
                      <td><?php echo $row['nama_stasiun']; ?></td>
                      <td><?php echo $row['waktu_pelaporan']; ?></td>
                      <td><?php echo "<b style='text-transform: uppercase;'>".$row['jenis_laporan']."</b> : ".$row['kondisi']."<br>".$row['keterangan']; ?></td>

                      <td>
                        <?php if (pathinfo($row['foto'], PATHINFO_EXTENSION) == "mp4") {
                          echo "<a><button class=\"btn btn-default open_modal\" data-toggle=\"modal\" data-target=\"#myModal\" data-video=\"".$row['foto']."\"><span class=\"fa fa-play\"></span> Play</button></a>";
                        }
                        else{
                          echo "<img src=\"".$row['foto']."\" style=\"width:80px; height:80px;\">";
                        } ?>
                      </td>
            
                      <td style="padding: 5px">
                        <div class="row">
                          <div class="col-xs-12" style=" text-align: center; color:red;font-size:12px;">
                          <a href="javascript:void(0);" data-kode="<?php echo $row['id_laporan']; ?>" style="color:red;" id="btn-delete">
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
         <form id="add-row-form" action="<?php echo base_url('LaporanOperator/hapusPelaporan');?>" method="post">
           <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                         <h4 class="modal-title" id="myModalLabel">Hapus Laporan</h4>
                     </div>
                     <div class="modal-body">
                             <input type="hidden" name="id_laporan" class="form-control" required>
                                                   <strong>Anda yakin mau menghapus laporan ini?</strong>
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
        <!-- Modal Show Video -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Title</h4>
              </div>
              <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <iframe width="100%" height="350" src="" frameborder="0" allowfullscreen></iframe>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<script type="text/javascript">
  $(function() {
      $('#date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        yearRange: "2005:+0",
        onClose: function(dateText, inst) { 
          $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
      });

      $('#date-picker2').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        yearRange: "2005:+0",
        onClose: function(dateText, inst) { 
          $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
      });

      $('#myTable').on('click','#btn-delete',function(){
        var kode=$(this).data('kode');
        $('#ModalHapus').modal('show');
        $('[name="id_laporan"]').val(kode);
      }); 

      $(document).on("click", ".open_modal", function(){
        var videoSRC = $(this).data('video');
        var theModal = $(this).data('target');
        var videoSRCauto = videoSRC + "?modestbranding=1&rel=0&controls=0&showinfo=0&html5=1&autoplay=1";
        $(theModal + ' iframe').attr('src', videoSRCauto);
        $(theModal + ' button.close').click(function () {
          $(theModal + ' iframe').attr('src', '');
        });
        // $('#videoMain')[0].play();
        // console.log(video);
      });
      $("myModal").on('hidden.bs.modal', function () {
        $('#videoMain')[0].pause();
      });
      
  });
</script>
<?php
$this->load->view('template/foot');
?>