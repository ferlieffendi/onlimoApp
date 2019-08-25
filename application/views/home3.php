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
        Sistem Pelaporan ONLIMO
    </h1>
</section>
<div id="notif"><?php echo $this->session->flashdata('pesan'); ?></div>
<section class="content">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<!-- <?php echo $map['html']; ?> -->
			<div id="map" style="height: 500px; width: 100%;"></div>
		</div>
		<div class="col-md-12 col-sm-12">
			<div class="box" style="padding: 5px">
			<h4>Keterangan : </h4>
				<div class="row">
					<div class="col-md-3 col-sm-3">
						<img src="<?php echo site_url('assets/icon_maps/loc.svg')?>"> Lokasi Stasiun
					</div>
					<div class="col-md-3 col-sm-3">
						<img src="<?php echo site_url('assets/icon_maps/administration.png')?>"> Tidak Melakukan Pelaporan
					</div>
					<div class="col-md-3 col-sm-3">
						<img src="<?php echo site_url('assets/icon_maps/tools.png')?>"> Perlu Dilakukan Kalibrasi
					</div>
					<div class="col-md-3 col-sm-3">
						<img src="<?php echo site_url('assets/icon_maps/caution.png')?>"> Sedang Terjadi Bencana
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12" style="margin-top: 10px">
			<div class="box box-primary" id="posting" style="display: none">
		        <div class="box-body box-profile">
			        <div class="post">
			        	<div class="user-block">
			        	<?php
			        		if (!is_null($post)) {
			        			foreach ($post as $key) { 			
			        	?>
				            <img class="img-circle img-bordered-sm" src="<?php echo site_url('/uploads/fotoProfil'); echo "/".$key['foto_profil']; ?>" alt="User Image">
				            <span class="username">
				                <a href="#"><?php echo $key['nama']?>(<?php echo $key['nama_stasiun']?>)</a>
				                <a class="pull-right btn-box-tool" id="close"><i class="fa fa-times"></i></a>
				            </span>
				            <span class="description"><?php echo $key['waktu_pelaporan'] ?></span>
				        </div>
			            <div class="row">
				            <div class="col-sm-12">
				                <img class="img-responsive" src="<?php echo site_url('/uploads/PelaporanOperator'); echo "/".$key['foto']; ?>" alt="Photo" style="max-height: 300px; margin: 0 auto">
				            </div>
			            </div>
			            <div class="row margin-bottom">
		                  	<div class="col-sm-12">
		                  		<p>
		                  			<?php echo "<b style='text-transform: uppercase;'>".$key['jenis_laporan']."</b> : ".$key['kondisi']."<br>".$key['keterangan']; ?>
		                  		</p>
		                  	</div>
		                  </div>
			            <?php } } ?>
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
<!-- <?php echo $map['js']; ?> -->
<!-- JS hide show -->
<script type="text/javascript">
	$(window).load(function(){

		var tampil = "<?php //echo $tampil;?>";

		if (tampil == 1) {
			document.getElementById( 'posting' ).style.display = 'block';
		}
			 
		$('#close').click(function(){
	      	$("#posting").hide();  
		});
	});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCO1jzRqAHPyjgAnTo4A1BxDuhbVys5D8c"></script>
<script type="text/javascript">
	var myMarker = [];
	var map;
	var marker;

	$(document).ready(function(){
		
		map = new google.maps.Map(document.getElementById("map"), {
			zoom: 5,
			center: new google.maps.LatLng(-1.603805, 118.231670),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		var infoWindow = new google.maps.InfoWindow;      
        var bounds = new google.maps.LatLngBounds();

        addMarkers();

        function bindInfoWindow(marker, map, infoWindow, html) {
          google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
          });
        }

		function addMarkers() {
			deleteMarker();
			$.get('<?php echo base_url('Home/mapData'); ?>',{}, function (res, resp) {
				// deletemarker();
				for (var i = 0; i < res.length; i++) {

					marker = new google.maps.Marker({
						position: new google.maps.LatLng(res[i].latitude,res[i].longitude),
						title: res[i].nama_stasiun,
						icon: res[i].icon,
						map: map
					});
					myMarker.push(marker);
					var info = '<div id="content"><div id="siteNotice"></div><h3 id="firstHeading" class="firstHeading">'+ res[i].nama_stasiun +'</h3><div id="bodyContent"><p><b>'+ res[i].alamat_stasiun +'</b></p><p>Nama Operator Stasiun  :  '+ res[i].nama +'<br>Nomor Telepon : '+ res[i].no_telepon +'<br>'+ res[i].link +'</p></div></div>';
					bindInfoWindow(marker, map, infoWindow, info);
				}
				window.setTimeout(addMarkers,300000);
			}, "json");
		}

		

		function inputmarker() {
			for (i in myMarker) {
				for (j in myMarker[i]){
					var marker = new google.maps.Marker({
						position: new google.maps.LatLng(myMarker[i][j].latitude,myMarker[i][j].longitude),
						title: myMarker[i][j].nama_stasiun,
						icon: myMarker[i][j].icon,
						map: map
					});
					var info = '<div id="content"><div id="siteNotice"></div><h3 id="firstHeading" class="firstHeading">'+ myMarker[i][j].nama_stasiun +'</h3><div id="bodyContent"><p><b>'+ myMarker[i][j].alamat_stasiun +'</b></p><p>Nama Operator Stasiun  :  '+ myMarker[i][j].nama +'<br>Nomor Telepon : '+ myMarker[i][j].no_telepon +'<br>'+ myMarker[i][j].link +'</p></div></div>';
					bindInfoWindow(marker, map, infoWindow, info);
				}
			}
		}
	});

	function deleteMarker() {

		if(myMarker){
			for (i in myMarker) {
				myMarker[i].setMap(null);
			}
			myMarker = [];	
		}
	}
</script>

<?php
$this->load->view('template/foot');
?>