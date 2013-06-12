<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('services');?>">การให้บริการ</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียนนัด</li>
</ul>
<form action="#" class="form-actions form-inline">
    <input type="hidden" id="txt_status" value="0">
    <label for="txt_date">วันที่</label>
    <div class="input-append date" data-name="datepicker">
        <input class="input-small" id="txt_date" type="text" disabled>
        <span class="add-on"><i class="icon-th"></i></span>
    </div>
    <label for="txt_date">แผนก</label>
    <select class="input-xlarge" id="sl_clinic">
        <option value="">--- ทั้งหมด ---</option>
    <?php
        foreach ($clinics as $t){
            echo '<option value="'.$t->id.'">' . $t->name . '</option>';
        }
    ?>
    </select>
    <div class="btn-group" data-toggle="buttons-radio">
        <button type="button" data-name="btn_do_filter" data-id="0" class="btn"><i class="icon-th-list"></i> ทั้งหมด</button>
        <button type="button" data-name="btn_do_filter" data-id="1" class="btn"><i class="icon-check"></i> มาตามนัด</button>
        <button type="button" data-name="btn_do_filter" data-id="2" class="btn"><i class="icon-minus-sign"></i> ไม่มาตามนัด</button>
    </div>
    <button class="btn btn-success pull-right" id="btn_show_visit">
        <i class="icon-plus-sign"></i> ลงทะเบียน
    </button>
</form>

<table class="table table-striped table-hover" id="tbl_appoint_list">
    <thead>
        <tr>
            <th>สถานะ</th>
            <th>วันที่นัด</th>
            <th>เวลา</th>
            <th>HN</th>
            <th>ชื่อ - สกุล</th>
            <th>ประเภทการนัด</th>
            <th>คลินิค/แผนก</th>
            <th>ผู้นัด (Provider)</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="9">กรุณาเลือกเงื่อนไขการค้นหา</td>
    </tr>
    </tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<div class="modal hide fade" id="mdl_select_visit">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>เลือกรายการรับบริการ</h3>
    </div>
    <div class="modal-body" style="height: 250px;">
        <form class="form-inline well">
            <input type="hidden" id="txt_search_visit_by" value="0">
            <label>HN</label>
            <input type="text" class="input-xlarge" id="txt_query_visit">
            <div class="btn-group">
                <button class="btn btn-info" id="btn_do_search_visit"><i class="icon-search"></i> ค้นหา</button>
                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0);" data-name="btn_set_search_visit_filter" data-value="0"><i class="icon-qrcode"></i> ค้นจาก เลขบัตรประชาชน</a></li>
                    <li><a href="javascript:void(0);" data-name="btn_set_search_visit_filter" data-value="1"><i class="icon-th-list"></i> ค้นจาก HN</a></li>
                    <li><a href="javascript:void(0);" data-name="btn_set_search_visit_filter" data-value="2"><i class="icon-list"></i> ค้นจาก ชื่อ - สกุล</a></li>
                </ul>
            </div>
        </form>
        <table class="table table-striped" id="tbl_search_visit_result">
            <thead>
                <tr>
                    <th>VN</th>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>แผนก</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
        <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>

<div class="modal hide fade" id="mdl_update">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>แก้ไขข้อมูลการนัด</h3>
    </div>
    <div class="modal-body">
        <form class="form-inline">
            <form action="#">
                <input type="hidden" id="txt_update_id" value="">
                <legend>ข้อมูลการนัด</legend>
                <div class="row-fluid">
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_update_date">วันที่นัด</label>
                            <input class="input-small" id="txt_update_date" type="text" disabled>
                        </div>
                    </div>
                    <div class="span1">
                        <div class="control-group">
                            <label class="control-label" for="txt_update_time">เวลา</label>
                            <div class="controls">
                                <input type="text" data-type="time" id="txt_update_time" class="input-mini">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="sl_update_clinic">แผนกที่นัด</label>
                            <div class="controls">
                                <select class="input-xlarge" id="sl_update_clinic">
                                    <?php
                                    foreach ($clinics as $t){
                                        echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="sl_update_aptype">ประเภทกิจกรรมนัด</label>
                            <div class="controls">
                                <select name="" id="sl_update_aptype" disabled="disabled" style="background-color: white;">
                                    <?php
                                    foreach ($aptypes as $t){
                                        echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row-fluid">
                    <div class="span10">
                        <div class="control-group">
                            <label class="control-label" for="">การวินิจฉัย</label>
                        </div>
                        <input type="text" id="txt_update_diag_code" class="input-mini"placeholder="พิมพ์รหัส...">
                        <input type="text" id="txt_update_diag_name" class="input-xxlarge uneditable-input"  disabled="disabled" placeholder="...">
                    </div>
                </div>
            </form>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success" id="btn_do_update"><i class="icon-save"></i> ปรับปรุงข้อมูล</a>
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>

<!-- register service -->
<div class="modal hide fade" id="mdl_register_service">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>ลงทะเบียนส่งตรวจ</h3>
</div>
<div class="modal-body">
<form action="#" class="form-inline well">
    <input type="hidden" id="txt_serv_appoint_id">
    <div class="row-fluid">
        <div class="span2">
            <label class="control-label" for="txt_serv_hn">HN</label>
            <input class="input-small uneditable-input" id="txt_serv_hn" disabled="disabled" type="text">
        </div>
        <div class="span5">
            <label class="control-label" for="txt_serv_fullname">ชื่อ - สกุล</label>
            <input type="text" disabled="disabled" id="txt_serv_fullname" class="input-xlarge">
        </div>
    </div>
</form>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#tab_service_detail" data-toggle="tab"><i class="icon-th-list"></i> ข้อมูลการรับบริการ</a></li>
    <li><a href="#tab_service_right" data-toggle="tab"><i class="icon-barcode"></i> สิทธิการรักษา</a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="tab_service_detail">
    <form action="#">
        <div class="row-fluid">
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_serv_date">วันที่</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txt_serv_date" type="text" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_serv_time">เวลา</label>
                    <div class="controls">
                        <input type="text" data-type="time" id="txt_serv_time" class="input-mini">
                    </div>
                </div>
            </div>

            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_serv_patient_status">สภาพผู้ป่วย</label>
                    <div class="controls">
                        <select name="" id="sl_serv_patient_status">
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
                    <label class="control-label" for="sl_serv_clinic">แผนกที่รับบริการ</label>
                    <div class="controls">
                        <select class="input-xlarge" id="sl_serv_clinic">
                            <option value="">--</option>
                            <?php foreach($clinics as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="sl_serv_doctor_room">ห้องตรวจ</label>
                    <div class="controls">
                        <select class="input-xlarge" id="sl_serv_doctor_room">
                            <option value="">--</option>
                            <?php foreach($doctor_rooms as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_serv_pttype">ประเภทผู้ป่วย</label>
                    <div class="controls">
                        <select name="" id="sl_serv_pttype">
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
                    <label class="control-label" for="sl_serv_location">ที่ตั้ง</label>
                    <div class="controls">
                        <select name="" id="sl_serv_location">
                            <option value="1">ในเขตรับผิดชอบ</option>
                            <option value="2">นอกเขตรับผิดชอบ</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_serv_typein">ประเภทการมา</label>
                    <div class="controls">
                        <select name="" id="sl_serv_typein">
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
                    <label class="control-label" for="sl_serv_service_place">สถานที่รับบริการ</label>
                    <div class="controls">
                        <select name="" id="sl_serv_service_place">
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
                    <label class="control-label" for="txt_serv_cc">อาการแรกรับ (CC)</label>
                    <div class="controls">
                        <textarea rows="2" class="input-xxlarge" id="txt_serv_cc"></textarea>
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
                    <label class="control-label" for="sl_serv_insc">สิทธิการรักษา</label>
                    <div class="controls">
                        <select name="" id="sl_serv_insc" class="input-xlarge">
                            <option value="">--</option>
                            <?php foreach($inscls as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_serv_insc_code">เลขที่บัตร</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge" id="txt_serv_insc_code">
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_serv_insc_start_date">วันออกบัตร</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txt_serv_insc_start_date" type="text" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_serv_insc_expire_date">วันหมดอายุ</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txt_serv_insc_expire_date" type="text" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_serv_insc_hosp_main_name">สถานบริการหลัก</label>
                    <div class="controls">
                        <input type="hidden" id="txt_serv_insc_hosp_main_code">
                        <input type="text" class="input-xlarge" id="txt_serv_insc_hosp_main_name">
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_serv_insc_hosp_sub_name">สถานบริการรอง</label>
                    <div class="controls">
                        <input type="hidden" id="txt_serv_insc_hosp_sub_code">
                        <input type="text" class="input-xlarge" id="txt_serv_insc_hosp_sub_name">
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" id="btn_do_save_service_register"><i class="icon-save"></i> บันทึกข้อมูล</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
</div>
</div>
<!-- end register service -->

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.appointments.index.js');
</script>


