<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistem Pelaporan ONLIMO | Login</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo base_url('assets/font-awesome-4.3.0/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url('assets/AdminLTE-2.0.5/dist/css/AdminLTE.min.css') ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.css') ?>" rel="stylesheet" type="text/css" />

        <style type="text/css">
        .login-logo img{
            width: 40%;
            margin: 0 auto;
        }
        .login-box{
            width: 400px;
        }        
        </style>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-page">
    <div id="notif"><?php echo $this->session->flashdata('pesan'); ?></div>
        <div class="login-box">
            <div class="login-logo">
                <img src="<?php echo site_url('/uploads/logo onlimo.png')?>"><br>
                <b>Sistem Pelaporan</b>ONLIMO
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Masuk untuk memulai</p>
                <form action="<?php echo site_url('auth/login') ?>" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Username" name="username" required />
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password" required />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">    
                                                    
                        </div><!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat login">Masuk</button>
                        </div><!-- /.col -->
                    </div>
                </form>

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
        

        <!-- jQuery 2.1.3 -->
        <script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jQuery/jQuery-2.1.3.min.js') ?>"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.js') ?>" type="text/javascript"></script>
        <script>   
            $(document).ready(function(){
                $('#notif').slideDown('slow').delay(6000).slideUp('slow');
            })
        </script>
    </body>
</html>