<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">การให้บริการ</li>
</ul>
<div class="navbar">
    <form action="#" class="navbar-form">
    <input type="text" style="width: 200px;" id="txt_query_visit" 
    rel="tooltip" title="พิมพ์ชื่อ หรือ HN หรือ เลขบัตรประชาชน เพื่อค้นหา" autocomplete="off" placeholder="HN, ชื่อ สกุล...">
    <button type="button" id="btn_do_search_visit" class="btn btn-primary" rel="tooltip" title="ค้นหารายการ"><i class="icon-search"></i> ค้นหา</button>
   | 
    <input style="width: 100px;" id="txt_service_date" type="text" 
    placeholder="dd/mm/yyyy" data-type="date" rel="tooltip" title="ระวันที่ เช่น 12/02/2556">
    <!--
    <select id="sl_query_filter_by_diag" class="input-medium">
        <option value="1">ทั้งหมด</option>
        <option value="1">ยังไม่ลงรหัสวินิจฉัย</option>
        <option value="1">ลงวินิจฉัยแล้ว</option>
    </select>
    -->
    <select style="width: 200px;" id="sl_service_doctor_room">
        <option value="">--- ห้องตรวจ ---</option>
        <?php foreach($doctor_rooms as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
    </select>

    <button class="btn btn-primary" id="btn_do_filter">
        <i class="icon-search"></i> แสดง
    </button>
    <button type="button" class="btn btn-success pull-right" id="btn_new_visit">
        <i class="icon-plus-sign"></i> ลงทะเบียน
    </button>
</form>
</div>
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
    <ul class="pagination" id="main_paging"></ul>
<!-- modal new -->
<div class="modal fade" id="mdl_register_new_service">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file-alt"></i> ลงทะเบียนส่งตรวจ</h4>
            </div>
            <div class="modal-body">
                <div class="navbar">
                    <form action="#" class="navbar-form">
                        <input type="hidden" id="txt_hn" value="" />
                        <input type="text" style="width: 180px;" id="txt_service_profile_hn"
                               rel="tooltip" title="พิมพ์ชื่อ, HN หรือ เลขบัตรประชาชน" placeholder="ชื่อ-สกุล, HN หรือ CID" autocomplete="off">
                        <button type="button" id="btn_show_search_person" class="btn btn-primary"
                                rel="tooltip" title="คลิกปุ่มเพื่อค้นหาผู้ป่วย"><i class="icon-search"></i></button>
                        |
                        <input type="text" style="width: 630px;" disabled="disabled" placeholder="-*-" id="txt_service_profile" />
                    </form>
                </div>
                <div class="tab-pane active" id="tab_user_profile">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#tab_service_detail" data-toggle="tab"><i class="icon-th-list"></i> ข้อมูลการรับบริการ</a></li>
<!--                        <li><a href="#tab_service_right" data-toggle="tab"><i class="icon-barcode"></i> สิทธิการรักษา</a></li>-->
                        <!-- <li><a href="#tab_service_refer" data-toggle="tab"><i class="icon-globe"></i> ข้อมูลการรับส่งต่อ</a></li> -->
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_service_detail">
                            <br>
                            <form action="#">
                                <div class="row">
                                    <div class="col col-lg-2">
                                        <label for="txt_reg_service_date">วันที่</label>
                                        <input id="txt_reg_service_date" type="text" data-type="date"
                                               placeholder="dd/mm/yyyy" style="width: 120px;" required>
                                    </div>
                                    <div class="col col-lg-1">
                                        <label for="txt_reg_service_time">เวลา</label>
                                        <input type="text" data-type="time" id="txt_reg_service_time"
                                               placeholder="hh:mm" style="width: 70px;" required>
                                    </div>

                                    <div class="col col-lg-3">
                                        <label for="sl_reg_service_patient_status">สภาพผู้ป่วย</label>
                                        <select name="" id="sl_reg_service_patient_status">
                                            <option value="0">ปกติ</option>
                                            <option value="1">เมาสุรา/อาละวาด</option>
                                            <option value="2">ไม่รู้สึกตัว</option>
                                            <option value="3">ไม่มีญาติ</option>
                                        </select>
                                    </div>

                                    <div class="col col-lg-3">
                                        <label for="sl_reg_service_clinic">แผนกที่รับบริการ</label>
                                        <select class="input-xlarge" id="sl_reg_service_clinic">
                                            <option value="">--</option>
                                            <?php foreach($clinics as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                        </select>
                                    </div>
                                    <div class="col col-lg-3">
                                        <label for="sl_reg_service_doctor_room">ห้องตรวจ</label>
                                        <select class="input-xlarge" id="sl_reg_service_doctor_room">
                                            <option value="">--</option>
                                            <?php foreach($doctor_rooms as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-lg-3">
                                        <label for="sl_reg_service_pttype">ประเภทผู้ป่วย</label>
                                        <select name="" id="sl_reg_service_pttype">
                                            <option value="0">ผู้ป่วยรายเก่า</option>
                                            <option value="1">ผู้ป่วยรายใหม่</option>
                                            <option value="2">ผู้รับบริการอื่น</option>
                                        </select>
                                    </div>
                                    <div class="col col-lg-3">
                                        <label for="sl_reg_service_location">ที่ตั้ง</label>
                                        <select name="" id="sl_reg_service_location">
                                            <option value="1">ในเขตรับผิดชอบ</option>
                                            <option value="2">นอกเขตรับผิดชอบ</option>
                                        </select>
                                    </div>
                                    <div class="col col-lg-3">
                                        <label for="sl_reg_service_typein">ประเภทการมา</label>
                                        <select name="" id="sl_reg_service_typein">
                                            <option value="1">มารับบริการเอง</option>
                                            <option value="2">มารับบริการตามนัดหมาย</option>
                                            <option value="3">ได้รับการส่งต่อจากสถานพยาบาลอื่น</option>
                                            <option value="4">ได้รับการส่งตัวจากบริการ EMS</option>
                                        </select>
                                    </div>
                                    <div class="col col-lg-3">
                                        <label for="sl_reg_service_service_place">สถานที่รับบริการ</label>
                                        <select name="" id="sl_reg_service_service_place">
                                            <option value="1">ในสถานบริการ</option>
                                            <option value="2">นอกสถานบริการ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-lg-11">
                                        <label for="txt_reg_service_cc">อาการแรกรับ (CC)</label>
                                        <textarea rows="1" id="txt_reg_service_cc"></textarea>
                                    </div>
                                </div>
                                <br>
                                <legend><i class="icon-globe"></i> สิทธิการรักษา</legend>
                                <form action="#">
                                    <div class="row">
                                        <div class="col col-lg-5">
                                            <label for="sl_reg_service_insc">สิทธิการรักษา</label>
                                            <select name="" id="sl_reg_service_insc">
                                                <option value="">--</option>
                                                <?php foreach($inscls as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                                            </select>
                                        </div>
                                        <div class="col col-lg-3">
                                            <label for="txt_reg_service_insc_code">เลขที่บัตร</label>
                                            <input type="text" class="input-xlarge" id="txt_reg_service_insc_code">
                                        </div>
                                        <div class="col col-lg-2">
                                            <label for="txt_reg_service_insc_start_date">วันออกบัตร</label>
                                            <input id="txt_reg_service_insc_start_date" type="text" data-type="date"
                                                   placeholder="dd/mm/yyyy" rel="tooltip" title="ระบุวันที่ พ.ศ">
                                        </div>
                                        <div class="col col-lg-2">
                                            <label for="txt_reg_service_insc_expire_date">วันหมดอายุ</label>
                                            <input id="txt_reg_service_insc_expire_date" type="text" data-type="date"
                                                   placeholder="dd/mm/yyyy" rel="tooltip" title="ระบุวันที่ พ.ศ">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-lg-4">
                                            <label for="txt_reg_service_insc_hosp_main_name">สถานบริการหลัก</label>
                                            <input type="hidden" id="txt_reg_service_insc_hosp_main_code">
                                            <input type="text" class="input-xlarge" id="txt_reg_service_insc_hosp_main_name">
                                        </div>
                                        <div class="col col-lg-4">
                                            <label for="txt_reg_service_insc_hosp_sub_name">สถานบริการรอง</label>
                                            <input type="hidden" id="txt_reg_service_insc_hosp_sub_code">
                                            <input type="text" class="input-xlarge" id="txt_reg_service_insc_hosp_sub_name">
                                        </div>
                                    </div>
                                </form>
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
    </div>
</div>

<div class="modal fade" id="modal_search_person">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-search"></i> ค้นหาผู้ป่วย</h4>
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
    </div>
</div>

<!-- end person -->
<!-- <script type="text/javascript" src="{{ base_url }}assets/apps/js/apps.services.js"></script> -->
<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.services.js');
</script>
