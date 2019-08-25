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
        Posting
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Home') ?>"><i class="fa fa-home"></i> Beranda</a></li>
        <li class="active">Posting</li>
    </ol>
</section>
<div id="notif"><?php echo $this->session->flashdata('pesan'); ?></div>
<section class="content">
	<div class="box box-primary">
        <div class="box-body">
        	<form class="form-horizontal" method="post" action="<?php echo site_url('admin/posting'); ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="inputFoto" class="col-sm-2 control-label">Upload Foto</label>

                    <div class="col-sm-10">
                      <input type="file" name="inputFoto" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputKeterangan" class="col-sm-2 control-label">Keterangan</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" name ="inputKeterangan" placeholder="Keterangan" required></textarea>
                    </div>
                </div>
    			<div class="form-group">
                    <label for="inputJenis" class="col-sm-2 control-label">Jenis Posting</label>
                    <div class="col-sm-10">
                        <label style="font-weight: normal;">
                          <input type="radio" name="JenisPosting" class="minimal" value="pemberitahuan" checked/>  Pemberitahuan
                        </label>
                        <label style="font-weight: normal; margin-left: 10px;">
                          <input type="radio" id="show-kondisi" name="JenisPosting" class="minimal" value="laporan pemeliharaan" />  Laporan Pemeliharaan
                        </label>
                    </div>
                </div>
                <div class="form-group" id="select_pemberitahuan" style="display: none;">
                    <label for="inputKondisi" class="col-sm-2 control-label">Kondisi</label>
                    <div class="col-sm-10"><!-- Pemberitahuan  Pemeliharaan Baik
Pemeliharaan Tidak Baik -->
                      <select class="form-control" name="inputKondisi">
                        <option value="" hidden>Kondisi</option>
                        <option value="pemeliharaan baik">Pemeliharaan Baik</option>
                        <option value="pemeliharaan tidak baik">Pemeliharaan Tidak Baik</option>
                      </select>  
                    </div>
                </div>
                <input type="text" name="inputID" value="<?php echo $this->session->userdata('id_user');?>" hidden>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger" value="posting">Submit</button>
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
        $('input[type="radio"].minimal').iCheck({
            radioClass: 'iradio_minimal-blue'
        });
    });
    $("#show-kondisi").on('ifChecked', function () {
        $("#select_pemberitahuan").show();
        });
    $("#show-kondisi").on('ifUnchecked', function () {
        $("#select_pemberitahuan").hide();
    });

    // $(document).ready(function() {
    //     $('input[type="radio"]').click(function() {
    //        if($(this).attr('id') == 'show-kondisi') {
    //             $('#select_pemberitahuan').show();           
    //        }else {
    //             $('#select_pemberitahuan').hide();   
    //        }
    //     });
    // });
    
</script>
<?php
$this->load->view('template/foot');
?>