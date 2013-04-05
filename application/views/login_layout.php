<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HIS : Please login...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            max-width: 400px;
            padding: 19px 29px 29px;
            margin: 0 auto 20px;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            box-shadow: 0 1px 2px rgba(0,0,0,.05);
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }
        .form-signin input[type="text"],
        .form-signin input[type="password"] {
            font-size: 16px;
            height: auto;
            margin-bottom: 15px;
            padding: 7px 9px;
        }

    </style>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/alertify.default.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/freeow/freeow.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/head.load.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/html5.js"></script>

    <script type="text/javascript">
        var RecaptchaOptions = {
            theme : 'clean'
        };

        var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>

    <script>
        head.js(
                '<?php echo base_url(); ?>assets/js/bootstrap.min.js',
                '<?php echo base_url(); ?>assets/js/underscore.min.js',
                '<?php echo base_url(); ?>assets/js/taffy.js',
                '<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js',
                '<?php echo base_url(); ?>assets/js/bootstrap-datepicker.th.js',
                '<?php echo base_url(); ?>assets/js/jquery.blockUI.js',
                '<?php echo base_url(); ?>assets/js/jquery.cookie.js',
                '<?php echo base_url(); ?>assets/js/jquery.freeow.min.js',
                '<?php echo base_url(); ?>assets/js/bootbox.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.maskedinput.min.js',
                '<?php echo base_url(); ?>assets/js/typeahead.js',
                '<?php echo base_url(); ?>assets/js/spin.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.paging.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.numeric.js',
                '<?php echo base_url(); ?>assets/js/numeral.min.js',
                '<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js',
                '<?php echo base_url(); ?>assets/apps/js/apps.js',
                '<?php echo base_url(); ?>assets/apps/js/apps.users.js'
        );

    </script>

</head>

<body>

<div id="freeow" class="freeow freeow-top-right"></div>

<div class="container">
   <?php echo $content_for_layout; ?>
</div>
</body>
</html>