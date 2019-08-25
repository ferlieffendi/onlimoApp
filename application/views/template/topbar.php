<body class="skin-blue-light">
    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <a href="<?php echo site_url('home') ?>" class="logo"><img src="<?php echo site_url('/uploads/logo onlimo.png')?>">  Pelaporan<b>ONLIMO</b></a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="messages-menu">
                            <a href="<?php echo site_url('admin/viewPosting') ?>" >
                                <span><i class="fa fa-upload"></i>     Posting</span>
                            </a>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo site_url('/uploads/fotoProfil'); echo "/".$this->session->userdata('foto_profil'); ?>" class="user-image" alt="User Image"/>
                                <span class="hidden-xs"><?php echo $this->session->userdata('nama');?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?php echo site_url('/uploads/fotoProfil'); echo "/".$this->session->userdata('foto_profil'); ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $this->session->userdata('nama');?>
                                        <small><?php echo $this->session->userdata('nama_stasiun');?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!-- <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li> -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo site_url('admin');?>" class="btn btn-default btn-flat"><i class="fa fa-user"></i>  Profil</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo site_url('auth/logout') ?>" class="btn btn-default btn-flat">
                                            <i class="fa fa-power-off"></i>  Keluar</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- =============================================== -->