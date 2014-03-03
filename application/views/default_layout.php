<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Health information system.">
    <meta name="author" content="Mr.Satit Rianpit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Health Information System</title>

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/freeow/freeow.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/select2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/select2-bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/datepicker3.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/ladda.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/head.load.min.js"></script>
    <script type="text/javascript">
        var base_url = '<?=base_url()?>';
        var site_url = '<?=site_url()?>';
        var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>

    <style>

        body {
            padding-top: 48px;
        }
        .popover {
            max-width: 690px;
        }

    </style>
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond/respond.min.js"></script>
    <!--[endif]-->

<!--    <script src="--><?php //echo base_url(); ?><!--assets/js/jquery.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--assets/js/head.load.min.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--assets/js/angular/angular.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--assets/js/angular/angular-animate.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--assets/js/angular/angular-resource.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--assets/js/angular/angular-route.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--assets/js/angular/angular-sanitize.js"></script>-->

    <script>
        head.js(
            '<?php echo base_url(); ?>assets/js/bootstrap.min.js',
            '<?php echo base_url(); ?>assets/js/underscore.min.js',
            '<?php echo base_url(); ?>assets/js/taffy.js',
            '<?php echo base_url(); ?>assets/js/jquery.blockUI.js',
            '<?php echo base_url(); ?>assets/js/jquery.freeow.min.js',
            '<?php echo base_url(); ?>assets/js/jquery.maskedinput.min.js',
            '<?php echo base_url(); ?>assets/js/jquery.cookie.js',
            '<?php echo base_url(); ?>assets/js/jquery.paging.min.js',
            '<?php echo base_url(); ?>assets/js/jquery.numeric.js',
            '<?php echo base_url(); ?>assets/js/numeral.min.js',
            '<?php echo base_url(); ?>assets/js/highchart/highcharts.js',
            '<?php echo base_url(); ?>assets/js/highchart/highcharts-more.js',
            '<?php echo base_url(); ?>assets/js/holder.js',
            '<?php echo base_url(); ?>assets/js/select2.min.js',
            '<?php echo base_url(); ?>assets/js/select2_locale_th.js',
            '<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js',
            '<?php echo base_url(); ?>assets/js/bootstrap-datepicker.th.js',
            '<?php echo base_url(); ?>assets/js/spin.min.js',
            '<?php echo base_url(); ?>assets/js/ladda.min.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.js'
        );

    </script>
</head>

<body>

<div id="freeow" class="freeow freeow-bottom-right"></div>

    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-ext1-collapse">
          <span class="fa fa-bars"></span>
        </button>
        <a class="navbar-brand" href="<?=site_url()?>"><span class="fa fa-windows"></span> eHIS</a>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=site_url()?>"><span class="fa fa-home"></span> หน้าหลัก</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-list fa-fw"></i> การให้บริการ
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo site_url('services'); ?>">
                    <i class="fa fa-th-list fa-fw"></i> ผู้มารับบริการ
                  </a>
                </li>
                <li>
                  <a href="<?php echo site_url('appoints'); ?>">
                    <i class="fa fa-calendar fa-fw"></i> ทะเบียนนัด
                  </a>
                </li>
                <li>
                  <a href="<?php echo site_url('ncdscreen'); ?>">
                    <i class="fa fa-book fa-fw"></i> คัดกรองเบาหวาน/ความดัน 15 ปีขึ้นไป
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="<?php echo site_url('surveil'); ?>">
                    <i class="fa fa-book"></i> บันทึกข้อมูลระบาดวิทยา (R506)
                  </a>
                </li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-th-list fa-fw"></i> ทะเบียนต่างๆ
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                  <li>
                      <a href="<?php echo site_url('epis'); ?>">
                          <i class="fa fa-book fa-fw"></i> ทะเบียนส่งเสริมป้องกันโรค
                      </a>
                  </li>
                  <li>
                      <a href="<?php echo site_url('pregnancies'); ?>">
                          <i class="fa fa-book fa-fw"></i> ทะเบียนฝากครรภ์/คลอด/การดูแลหลังคลอด
                      </a>
                  </li>
                  <li>
                      <a href="<?php echo site_url('babies'); ?>">
                          <i class="fa fa-medkit fa-fw"></i> ทะเบียนเด็กแรกเกิด/ดูแลหลังคลอด
                      </a>
                  </li>
                  <li class="divider"></li>
                  <li>
                      <a href="<?php echo site_url('diabetes'); ?>">
                          <i class="fa fa-tags fa-fw"></i> ทะเบียนผู้ป่วยเบาหวาน
                      </a>
                  </li>
                  <li>
                      <a href="<?php echo site_url('hypertension'); ?>">
                          <i class="fa fa-tags fa-fw"></i> ทะเบียนผู้ป่วยความดัน
                      </a>
                  </li>

                  <li class="divider"></li>
                  <li>
                      <a href="<?php echo site_url('death'); ?>">
                          <i class="fa fa-group fa-fw"></i> ทะเบียนผู้เสียชีวิต
                      </a>
                  </li>
                  <li>
                      <a href="<?php echo site_url('disabilities'); ?>">
                          <i class="fa fa-tags fa-fw"></i> ทะเบียนผู้พิการ
                      </a>
                  </li>
                  <li>
                      <a href="<?php echo site_url('women'); ?>">
                          <i class="fa fa-tags fa-fw"></i> ทะเบียนหญิงวัยเจริญพันธุ์
                      </a>
                  </li>
              </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-briefcase fa-fw"></i>
                    ข้อมูลพื้นฐาน
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?php echo site_url('person'); ?>">
                            <i class="fa fa-home fa-fw"></i>
                            ประชากร/หมู่บ้าน/หลังคาเรือน
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-briefcase fa-fw"></i>
                    กำหนดค่า
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?php echo site_url('settings/providers'); ?>">
                            <i class="fa fa-user fa-fw"></i>
                            ข้อมูลผู้ให้บริการ
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('drugs'); ?>">
                            <i class="fa fa-shopping-cart fa-fw"></i>
                            ข้อมูลเวชภัณฑ์
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('incomes'); ?>">
                            <i class="fa fa-shopping-cart fa-fw"></i>
                            ข้อมูลค่าใช้จ่าย
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo site_url('settings/clinics'); ?>">
                            <i class="fa fa-th-list fa-fw"></i>
                            ข้อมูลแผนกให้บริการ
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin'); ?>">
                            <i class="fa fa-group fa-fw"></i>
                            ข้อมูลผู้ใช้งาน
                        </a>
                    </li>
                </ul>
            </li>
            <li class="disabled">
                <a href="javascript:void(0)">
                    <i class="fa fa-print fa-fw"></i>
                    รายงาน
                </a>
            </li>

          </ul>

          <ul class="nav navbar-nav pull-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i>
                        <?php echo $this->session->userdata('fullname'); ?>
                                                   <b class="caret"></b>
                                                                           </a>
                    <ul class="dropdown-menu">
                    <li class="dropdown-header">USER PROFILES</li>
                    <li class="disabled">
                        <a href="#"><i class="fa fa-key fa-fw"></i> เปลี่ยนรหัสผ่าน (Change password)</a>
                    </li>
                    <li class="disabled">
                        <a href="#"> <i class="fa fa-info-sign fa-fw"></i> แก้ไขข้อมูลส่วนตัว (Edit profiles)</a>
                    </li>
                    <li class="disabled">
                        <a href="#" id="btn_idx_set_provider_clinic-x"> <i class="fa fa-user fa-fw"></i> กำหนดแพทย์/คลินิก (Provider/Clinic)</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo site_url('users/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ (Logout)</a>
                    </li>
                </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
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