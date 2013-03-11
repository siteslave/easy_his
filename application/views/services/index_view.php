<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">การให้บริการ</li>
</ul>
<blockquote>
   รายชื่อผู้มารับบริการและการให้บริการผู้ป่วย
</blockquote>
<form action="#" class="form-actions form-search">
    <div class="input-append">
        <input type="text" class="input-xlarge search-query" id="txt_query_visit" placeholder="HN, ชื่อ สกุล...">
        <button type="button" id="btn_do_search_visit" class="btn btn-info"><i class="icon-search"></i> ค้นหา</button>
    </div>
    |
    <div class="input-append date" data-name="datepicker">
        <input class="input-small" id="txt_service_date" type="text" value="<?php echo date('d/m/Y'); ?>" disabled>
        <span class="add-on"><i class="icon-th"></i></span>
    </div>
    <!--
    <select id="sl_query_filter_by_diag" class="input-medium">
        <option value="1">ทั้งหมด</option>
        <option value="1">ยังไม่ลงรหัสวินิจฉัย</option>
        <option value="1">ลงวินิจฉัยแล้ว</option>
    </select>
    -->
    <select class="input-medium" id="sl_service_doctor_room">
        <option value="">--- ห้องตรวจ ---</option>
        <?php foreach($doctor_rooms as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
    </select>

    <button class="btn btn-info" id="btn_do_filter">
        <i class="icon-search"></i> แสดง
    </button>
    <button type="button" class="btn btn-success pull-right" id="btn_new_visit">
        <i class="icon-plus-sign"></i> ลงทะเบียน
    </button>
</form>
<table class="table table-striped table-hover" id="tbl_service_list">
    <thead>
    <tr>
        <th>HN</th>
        <th>ชื่อ - สกุล</th>
        <th>อายุ (ปี)</th>
        <th>สิทธิการรักษา</th>
        <th>อาการสำคัญ</th>
        <th>คลินิค</th>
        <th>การวินิจฉัย</th>
        <th>ผู้ให้บริการ</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
    </tr>
    </tbody>
</table>
<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>
<!-- modal new -->
<div class="modal hide fade" id="mdl_register_new_service">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ลงทะเบียนส่งตรวจ</h3>
    </div>
    <div class="modal-body">
        <blockquote>
            บันทึกข้อมูลการส่งตรวจ
        </blockquote>
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#tab_user_profile" data-toggle="tab"><i class="icon-user"></i> ข้อมูลทั่วไป</a></li>
            <li><a href="#tab_service_detail" data-toggle="tab"><i class="icon-th-list"></i> ข้อมูลการรับบริการ</a></li>
            <li><a href="#tab_service_right" data-toggle="tab"><i class="icon-barcode"></i> สิทธิการรักษา</a></li>
            <!-- <li><a href="#tab_service_refer" data-toggle="tab"><i class="icon-globe"></i> ข้อมูลการรับส่งต่อ</a></li> -->
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_user_profile">
                <form action="#">
                    <input type="hidden" id="txt_service_vn">
                    <input type="hidden" id="txt_person_id">
                    <div class="row-fluid">
                        <div class="span2">
                            <div class="control-group">
                                <label class="control-label" for="txt_service_profile_hn">HN</label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input class="input-small uneditable-input" id="txt_service_profile_hn" disabled="disabled" type="text" placeholder="คลิกปุ่มค้นหา...">
                                        <button class="btn btn-info" type="button" id="btn_show_search_person"><i class="icon-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="control-group">
                                <label class="control-label" for="txt_service_profile_cid">เลขบัตรประชาชน</label>
                                <div class="controls">
                                    <input type="text" disabled="disabled" id="txt_service_profile_cid" class="input-medium">
                                </div>
                            </div>
                        </div>
                        <div class="span5">
                            <div class="control-group">
                                <label class="control-label" for="txt_service_profile_fullname">ชื่อ - สกุล</label>
                                <div class="controls">
                                    <input type="text" disabled="disabled" id="txt_service_profile_fullname" class="input-xlarge">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span2">
                            <div class="control-group">
                                <label class="control-label" for="txt_service_profile_birthdate">วันเกิด</label>
                                <div class="controls">
                                    <input type="text" disabled="disabled" id="txt_service_profile_birthdate" class="input-small">
                                </div>
                            </div>
                        </div>
                        <div class="span1">
                            <div class="control-group">
                                <label class="control-label" for="txt_service_profile_age">อายุ (ปี)</label>
                                <div class="controls">
                                    <input type="text" disabled="disabled" id="txt_service_profile_age" class="input-mini">
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label" for="txt_service_profile_address">ที่อยู่</label>
                                <div class="controls">
                                    <input type="text" disabled="disabled" id="txt_service_profile_address" class="input-xxlarge uneditable-input">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="tab_service_detail">
                <form action="#">
                    <div class="row-fluid">
                        <div class="span2">
                            <div class="control-group">
                                <label class="control-label" for="txt_reg_service_date">วันที่</label>
                                <div class="controls">
                                    <div class="input-append date" data-name="datepicker">
                                        <input class="input-small" id="txt_reg_service_date" type="text" disabled>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span2">
                            <div class="control-group">
                                <label class="control-label" for="txt_reg_service_time">เวลา</label>
                                <div class="controls">
                                    <input type="text" data-type="time" id="txt_reg_service_time" class="input-mini">
                                </div>
                            </div>
                        </div>

                        <div class="span3">
                            <div class="control-group">
                                <label class="control-label" for="sl_reg_service_patient_status">สภาพผู้ป่วย</label>
                                <div class="controls">
                                    <select name="" id="sl_reg_service_patient_status">
                                        <option value="0">ปกติ</option>
                                        <option value="1">เมาสุรา/อาละวาด</option>
                                        <option value="2">ไม่รู้สึกตัว</option>
                                        <option value="3">ไม่มีญาติ</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label" for="sl_reg_service_clinic">แผนกที่รับบริการ</label>
                                <div class="controls">
                                    <select class="input-xlarge" id="sl_reg_service_clinic">
                                        <option value="">--</option>
                                         <?php foreach($clinics as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label" for="sl_reg_service_doctor_room">ห้องตรวจ</label>
                                <div class="controls">
                                    <select class="input-xlarge" id="sl_reg_service_doctor_room">
                                        <option value="">--</option>
                                         <?php foreach($doctor_rooms as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="control-group">
                                <label class="control-label" for="sl_reg_service_pttype">ประเภทผู้ป่วย</label>
                                <div class="controls">
                                    <select name="" id="sl_reg_service_pttype">
                                        <option value="0">ผู้ป่วยรายเก่า</option>
                                        <option value="1">ผู้ป่วยรายใหม่</option>
                                        <option value="2">ผู้รับบริการอื่น</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            <div class="control-group">
                                <label class="control-label" for="sl_reg_service_location">ที่ตั้ง</label>
                                <div class="controls">
                                    <select name="" id="sl_reg_service_location">
                                        <option value="1">ในเขตรับผิดชอบ</option>
                                        <option value="2">นอกเขตรับผิดชอบ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="control-group">
                                <label class="control-label" for="sl_reg_service_typein">ประเภทการมา</label>
                                <div class="controls">
                                    <select name="" id="sl_reg_service_typein">
                                        <option value="1">มารับบริการเอง</option>
                                        <option value="2">มารับบริการตามนัดหมาย</option>
                                        <option value="3">ได้รับการส่งต่อจากสถานพยาบาลอื่น</option>
                                        <option value="4">ได้รับการส่งตัวจากบริการ EMS</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="control-group">
                                <label class="control-label" for="sl_reg_service_service_place">สถานที่รับบริการ</label>
                                <div class="controls">
                                    <select name="" id="sl_reg_service_service_place">
                                        <option value="1">ในสถานบริการ</option>
                                        <option value="2">นอกสถานบริการ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span10">
                            <div class="control-group">
                                <label class="control-label" for="txt_reg_service_cc">อาการแรกรับ (CC)</label>
                                <div class="controls">
                                    <textarea rows="2" class="input-xxlarge" id="txt_reg_service_cc"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="tab_service_right">
                <form action="#">
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label" for="sl_reg_service_insc">สิทธิการรักษา</label>
                                <div class="controls">
                                    <select name="" id="sl_reg_service_insc" class="input-xlarge">
                                        <option value="">--</option>
                                         <?php foreach($inscls as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label" for="txt_reg_service_insc_code">เลขที่บัตร</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" id="txt_reg_service_insc_code">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span2">
                            <div class="control-group">
                                <label class="control-label" for="txt_reg_service_insc_start_date">วันออกบัตร</label>
                                <div class="controls">
                                    <div class="input-append date" data-name="datepicker">
                                        <input class="input-small" id="txt_reg_service_insc_start_date" type="text" disabled>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span2">
                            <div class="control-group">
                                <label class="control-label" for="txt_reg_service_insc_expire_date">วันหมดอายุ</label>
                                <div class="controls">
                                    <div class="input-append date" data-name="datepicker">
                                        <input class="input-small" id="txt_reg_service_insc_expire_date" type="text" disabled>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label" for="txt_reg_service_insc_hosp_main_name">สถานบริการหลัก</label>
                                <div class="controls">
                                    <input type="hidden" id="txt_reg_service_insc_hosp_main_code">
                                    <input type="text" class="input-xlarge" id="txt_reg_service_insc_hosp_main_name">
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label" for="txt_reg_service_insc_hosp_sub_name">สถานบริการรอง</label>
                                <div class="controls">
                                    <input type="hidden" id="txt_reg_service_insc_hosp_sub_code">
                                    <input type="text" class="input-xlarge" id="txt_reg_service_insc_hosp_sub_name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-info" disabled="disabled"><i class="icon-time"></i> ประวัติล่าสุด...</button>
                </form>
            </div>
            <!--
            <div class="tab-pane" id="tab_service_refer">

            </div>
            -->
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn_do_save_service_register"><i class="icon-save"></i> บันทึกข้อมูล</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
    </div>
</div>

<div class="modal hide fade" id="modal_search_person">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ค้นหาผู้ป่วย</h3>
    </div>
    <div class="modal-body">
        <form action="#" class="form-inline form-actions">
            <input type="hidden" id="txt_reg_person_search_by">
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <div class="controls">
                            <div class="input-append">
                                <input type="text" class="input-xlarge" id="txt_reg_search_person">
                                <div class="btn-group">
                                    <button class="btn btn-info" id="btn_do_search_person" type="button"><i class="icon-search"></i> ค้นหา</button>
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0);" id="btn_reg_search_person_by_name"><i class="icon-user"></i> ค้นจากชื่อ - สกุล</a></li>
                                        <li><a href="javascript:void(0);" id="btn_reg_search_person_by_cid"><i class="icon-barcode"></i> ค้นจากเลขบัตรประชาชน (CID)</a></li>
                                        <li><a href="javascript:void(0);" id="btn_reg_search_person_by_hn"><i class="icon-bookmark"></i> ค้นจาก HN</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div id="div_search_person_result">
            <table class="table table-striped" id="table_search_person_result_list">
                <thead>
                <tr>
                    <th>HN</th>
                    <th>เลขบัตรประชาชน</th>
                    <th>ชื่อ - สกุล</th>
                    <th>วันเกิด</th>
                    <th>อายุ (ปี)</th>
                    <th>ที่อยู่</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
    </div>
</div>
<!-- end person -->
<!-- <script type="text/javascript" src="{{ base_url }}assets/apps/js/apps.services.js"></script> -->
<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.services.js');
</script>
