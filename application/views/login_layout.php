<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EasyHIS : Please login...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/login.css" rel="stylesheet">
    <style type="text/css">

    </style>

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