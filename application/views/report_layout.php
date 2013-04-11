<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />

    <title>Health Information System Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le styles -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome-ie7.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/docs.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/alertify.core.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/alertify.default.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/freeow/freeow.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/js/html5.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/head.load.min.js"></script>
    <script>
        head.js(
                '<?php echo base_url(); ?>assets/js/bootstrap.min.js',
                '<?php echo base_url(); ?>assets/js/underscore.min.js',
                '<?php echo base_url(); ?>assets/js/taffy.js',
                '<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js',
                '<?php echo base_url(); ?>assets/js/bootstrap-datepicker.th.js',
                '<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js',
                '<?php echo base_url(); ?>assets/js/locales/bootstrap-datetimepicker.th.js',
                '<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.blockUI.js',
                '<?php echo base_url(); ?>assets/js/jquery.cookie.js',
                '<?php echo base_url(); ?>assets/js/jquery.freeow.min.js',
                '<?php echo base_url(); ?>assets/js/bootbox.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.maskedinput.min.js',
                '<?php echo base_url(); ?>assets/js/typeahead.js',
                '<?php echo base_url(); ?>assets/js/spin.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.paging.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.numeric.js',
                '<?php echo base_url(); ?>assets/js/numeral.min.js'
        );

    </script>

    <script src="<?php echo base_url(); ?>assets/apps/js/apps.js"></script>

    <script type="text/javascript">
        var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>
</head>

<body>

<div id="freeow" class="freeow freeow-bottom-right"></div>
<div id="confirmmodalcontainer"></div>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">EHIS <img id="imgLoading" style="display: none;" src="<?php echo base_url(); ?>assets/apps/img/ajax-loader-fb.gif" alt="Loading..."></a>

            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li>
                        <a href="<?php echo site_url(); ?>">
                            <i class="icon-home"></i>
                            หน้าหลัก
                        </a>
                    </li>
                    <?php
                        $rs = get_main_report_menu();
                        foreach($rs as $r) {
                            echo '
                                <li>
                                    <a href="'.site_url('reports/menu/'.$r['_id']).'">
                                        <i class="'.$r['icon'].'"></i>
                                        '.$r['name'].'
                                    </a>
                                </li>
                            ';
                        }
                    ?>
                </ul>
                <div class="btn-group pull-right">
                    <a href="#" class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i>
                        <?php echo $this->session->userdata('fullname'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-header">USER PROFILES</li>
                        <li>
                            <a href="#"><i class="icon-edit"></i> เปลี่ยนรหัสผ่าน (Change password)</a>
                        </li>
                        <li>
                            <a href="#"> <i class="icon-info-sign"></i> แก้ไขข้อมูลส่วนตัว</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo site_url('users/logout'); ?>"><i class="icon-off"></i> ออกจากระบบ (Logout)</a>
                        </li>
                    </ul>
                </div>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container">
    <?php echo $content_for_layout; ?>
</div> <!-- /container -->


</body>
</html>