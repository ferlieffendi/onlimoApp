<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" >
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">NAVIGASI UTAMA</li>
            <li class="<?php if ($this->uri->segment(1)=="Home") {echo "active";} ?>"> 
<!-- kalau mau drop down tambah in class="treeview" di sebelah li -->
                 <a href="<?php echo site_url('Home') ?>">
                    <i class="fa fa-home"></i> <span>Beranda</span> <!-- <i class="fa fa-angle-left pull-right"></i> -->
                </a>
                <!-- <ul class="treeview-menu">
                    <li><a href="<?php echo site_url('dashboard1') ?>"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                    <li><a href="<?php echo site_url('dashboard2') ?>"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul> -->
            </li>
            <li class="<?php if ($this->uri->segment(1)=="AkunPengguna") {echo "active";} ?>">
                <a href="<?php echo site_url('AkunPengguna') ?>">
                    <i class="fa fa-users"></i>
                    <span>Pengguna</span>
                    <!-- <span class="label label-primary pull-right">4</span> -->
                </a>
            </li>
            <li class="<?php if ($this->uri->segment(1)=="LaporanOperator") {echo "active";} ?>">
                <a href="<?php echo site_url('LaporanOperator') ?>">
                    <i class="fa fa-file-text-o"></i> <span>Laporan Operator</span> 
                </a>
            </li>            
            <li class="<?php if ($this->uri->segment(1)=="CatatanPenggantian") {echo "active";} ?>">
                <a href="<?php echo site_url('CatatanPenggantian') ?>">
                    <i class="fa fa-list-alt"></i>
                    <span>Catatan Penggantian Sparepart</span>
                </a>
            </li>            
            
            <!-- <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-danger"></i> Important</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Warning</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-info"></i> Information</a></li> -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">