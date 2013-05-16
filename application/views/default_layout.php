<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />

    <title>Health Information System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le styles -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome-ie7.min.css" rel="stylesheet">
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
                '<?php echo base_url(); ?>assets/js/jquery.blockUI.js',
                '<?php echo base_url(); ?>assets/js/jquery.cookie.js',
                '<?php echo base_url(); ?>assets/js/jquery.freeow.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.maskedinput.min.js',
                '<?php echo base_url(); ?>assets/js/typeahead.js',
                '<?php echo base_url(); ?>assets/js/spin.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.paging.min.js',
                '<?php echo base_url(); ?>assets/js/jquery.numeric.js',
                '<?php echo base_url(); ?>assets/js/numeral.min.js',
                '<?php echo base_url(); ?>assets/js/bootbox.min.js',
                '<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js',
                '<?php echo base_url(); ?>assets/js/highchart/highcharts.js',
                '<?php echo base_url(); ?>assets/js/highchart/highcharts-more.js',
                '<?php echo base_url(); ?>assets/js/holder.js',
                '<?php echo base_url(); ?>assets/apps/js/apps.js'
        );

    </script>

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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-th-list"></i>
                            การให้บริการ
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('services'); ?>">
                                    <i class="icon-th-list"></i> ผู้มารับบริการ (Service list)
                                </a>
                            </li>
                             <li>
                                <a href="<?php echo site_url('appoints'); ?>">
                                    <i class="icon-calendar"></i> ทะเบียนนัด (Appointment)
                                </a>
                            </li>
                             <li>
                                 <a href="<?php echo site_url('ncdscreen'); ?>">
                                     <i class="icon-book"></i> คัดกรองเบาหวาน/ความดัน 15 ปีขึ้นไป
                                 </a>
                            </li>
                            <li class="divider"></li>
                             <li>
                                 <a href="<?php echo site_url('surveil'); ?>">
                                     <i class="icon-book"></i> บันทึกข้อมูลระบาดวิทยา (R506)
                                 </a>
                            </li>

                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-th-list"></i>
                            ทะเบียนต่างๆ
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('epis'); ?>">
                                    <i class="icon-book"></i> ทะเบียนส่งเสริมป้องกันโรค (EPI)
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('pregnancies'); ?>">
                                    <i class="icon-book"></i> ทะเบียนฝากครรภ์/คลอด/การดูแลหลังคลอด
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('babies'); ?>">
                                    <i class="icon-medkit"></i> ทะเบียนเด็กแรกเกิด/ดูแลหลังคลอด
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo site_url('diabetes'); ?>">
                                    <i class="icon-tags"></i> ทะเบียนผู้ป่วยเบาหวาน (DM)
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('hypertension'); ?>">
                                    <i class="icon-tags"></i> ทะเบียนผู้ป่วยความดัน (HT)
                                </a>
                            </li>

                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo site_url('death'); ?>">
                                    <i class="icon-group"></i> ทะเบียนผู้เสียชีวิต (Death)
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('disabilities'); ?>">
                                    <i class="icon-tags"></i> ทะเบียนผู้พิการ (Disability)
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('women'); ?>">
                                    <i class="icon-tags"></i> ทะเบียนหญิงวัยเจริญพันธุ์ (Women)
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-briefcase"></i>
                            ข้อมูลพื้นฐาน
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('person'); ?>">
                                    <i class="icon-folder-close"></i>
                                    ข้อมูลประชากรในเขตรับผิดชอบ
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-briefcase"></i>
                            กำหนดค่า
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('settings/providers'); ?>">
                                    <i class="icon-user"></i>
                                    ข้อมูลผู้ให้บริการ (Providers)
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('drugs'); ?>">
                                    <i class="icon-shopping-cart"></i>
                                    ข้อมูลเวชภัณฑ์ (Drugs)
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('incomes'); ?>">
                                    <i class="icon-shopping-cart"></i>
                                    ข้อมูลค่าใช้จ่าย (Incomes)
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo site_url('settings/clinics'); ?>">
                                    <i class="icon-th-list"></i>
                                    ข้อมูลแผนกให้บริการ (Clinics)
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin'); ?>">
                                    <i class="icon-group"></i>
                                    ข้อมูลผู้ใช้งาน (Users)
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo site_url('reports'); ?>">
                            <i class="icon-print"></i>
                            รายงาน
                        </a>
                    </li>
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
                            <a href="#"><i class="icon-key"></i> เปลี่ยนรหัสผ่าน (Change password)</a>
                        </li>
                        <li>
                            <a href="#"> <i class="icon-info-sign"></i> แก้ไขข้อมูลส่วนตัว (Edit profiles)</a>
                        </li>
                        <li>
                            <a href="#" id="btn_idx_set_provider_clinic"> <i class="icon-user"></i> กำหนดแพทย์/คลินิก (Provider/Clinic)</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo site_url('users/logout'); ?>"><i class="icon-signout"></i> ออกจากระบบ (Logout)</a>
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


<div class="modal hide fade" id="modal_provider_clinic">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>เลือกแพทย์และแผนก</h4>
    </div>
    <div class="modal-body">
        <form action="#">
            <input type="hidden" id="txt_id">
            <input type="hidden" id="is_update" value="0">
            <div class="row-fluid">
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="sl_clinics">แผนก</label>
                        <div class="controls">
                            <select id="sl_clinics" class="input-xlarge"></select>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="txt_export_code">แพทย์</label>
                        <div class="controls">
                            <select id="sl_providers" class="input-xlarge"></select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn_do_save"><i class="icon-save"></i> บันทึกข้อมูล</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
    </div>
</div>

</body>

</html>