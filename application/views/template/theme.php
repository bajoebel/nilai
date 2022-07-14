<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= COMPANY_NAME ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta name="robots" content="none" />
    <link rel="shortcut icon" href="<?php echo base_url() . 'favicon.png' ?>">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/Ionicons/css/ionicons.min.css" />
    <!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css"> -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/select2/dist/css/select2.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/AdminLTE.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/skins/_all-skins.min.css" />
    <link async rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/sweetalert/sweetalert.css">
    <script src="<?php echo base_url() ?>assets/plugins/sweetalert/sweetalert.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/jquery/css/jquery-ui.min.css">
    
    <link href="<?php echo base_url() ?>assets/bower_components/fonts.googleapis/fonts.css" type="text/css" rel="stylesheet">
    <script type="text/javascript">
        var url = "<?= base_url(); ?>";
    </script>
</head>

<body class="hold-transition skin-red-light sidebar-mini">
    <div class="wrapper">
        <?php echo $header; ?>

        <aside class="main-sidebar">
            <?php echo $nav_sidebar; ?>
        </aside>

        <div class="content-wrapper">
            
            <?php echo $content ?>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs"><?= VERSION_APP ?></div>
            <?= FOOTER ?>
        </footer>

        <div class="control-sidebar-bg"></div>
    </div>
    <!-- <script src="<?php echo base_url() ?>assets/bower_components/jquery/dist/jquery.js"></script> -->
    <script src="<?php echo base_url() ?>assets/jquery/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/jquery/js/jquery-ui.min.js"></script>
    <script async src="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <script async src="<?php echo base_url() ?>assets/bower_components/select2/dist/js/select2.full.js"></script>
    <script async src="<?php echo base_url() ?>assets/bower_components/inputmask/dist/jquery.inputmask.bundle.js"></script>
    <script async src="<?php echo base_url() ?>assets/bower_components/moment/min/moment.min.js"></script>
    <!-- <script async src="<?php echo base_url() ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->
    <!-- <script async src="<?php echo base_url() ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script> -->
    <script async src="<?php echo base_url() ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
    <script async src="<?php echo base_url() ?>assets/dist/js/adminlte.js"></script>
    <script type="text/javascript">
        var base_url = "<?= base_url()  ?>";
    </script>
    <script src="<?php echo base_url() ?>assets/js/function.js"></script>
    
    <script type="text/javascript">
        
        <?php
        if (!empty($func)) echo $func;
        if (!empty($ajaxdata)) echo $ajaxdata;
        ?>
    </script>
    <?php if (!empty($lib)) {
        if(is_array($lib)){
            foreach ($lib as $l ) {
                echo '<script src="' . base_url() . $l . '"></script>'; 
            }
        }else{
            echo '<script src="' . base_url() . $lib . '"></script>'; 
        }
        
    }
    ?>

    <div id="error" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="overflow-y: hidden;">
                <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Response Error Dari Server BPJS...</h4>
                </div>
                <div class="modal-body text-center">
                    <h1><i class="fa fa-warning text-red"></i></h1>
                    <h2  id="xhr"></h2>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

</body>

</html>