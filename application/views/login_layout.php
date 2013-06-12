<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HIS : Please login...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
          }

          .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
          }
          .form-signin .form-signin-heading,
          .form-signin .checkbox {
            margin-bottom: 10px;
          }
          .form-signin .checkbox {
            font-weight: normal;
          }
          .form-signin input[type="text"],
          .form-signin input[type="password"] {
            position: relative;
            font-size: 16px;
            height: auto;
            padding: 10px;
            -webkit-box-sizing: border-box;
               -moz-box-sizing: border-box;
                    box-sizing: border-box;
          }
          .form-signin input[type="text"]:focus,
          .form-signin input[type="password"]:focus {
            z-index: 2;
          }
          .form-signin input[type="text"] {
            margin-bottom: -1px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
          }
          .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
          }

    </style>
    <link href="<?php echo base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/freeow/freeow.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/head.load.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        var base_url = '<?=base_url()?>';
        var site_url = '<?=site_url()?>';
        
    </script>

    <script>
        head.js(
                '<?php echo base_url(); ?>assets/js/bootstrap.min.js',
                '<?php echo base_url(); ?>assets/js/underscore.min.js',
                '<?php echo base_url(); ?>assets/js/taffy.js',
                '<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js',
                '<?php echo base_url(); ?>assets/js/bootstrap-datepicker.th.js',
                '<?php echo base_url(); ?>assets/js/jquery.blockUI.js',
                '<?php echo base_url(); ?>assets/js/jquery.freeow.min.js',
                '<?php echo base_url(); ?>assets/js/bootbox.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.maskedinput.min.js',
                '<?php echo base_url(); ?>assets/js/typeahead.js',
                '<?php echo base_url(); ?>assets/js/jquery.paging.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.numeric.js',
                '<?php echo base_url(); ?>assets/js/numeral.min.js',
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