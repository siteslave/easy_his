<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">ทะเบียนฝากครรภ์</li>
</ul>

<div class="navbar">
    <form action="#" class="navbar-form">
        <select style="width: 250px;" id="sl_village">
            <option value="">-- เลือกหมู่บ้าน [ทั้งหมด] --</option>
            <?php
            foreach ($villages as $r){
                echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
            }
            ?>
        </select>
        <div class="btn-group">
            <button type="button" class="btn btn-primary" id="btn_do_get_list" rel="tooltip" title="แสดงรายชื่อ">
                <i class="icon-search"></i> แสดง</button>
            <button type="button" class="btn btn-default" id="btn_print" rel="tooltip" title="พิมพ์รายชื่อ">
                <i class="icon-print"></i> พิมพ์</button>
        </div>
        |
        HN:
        <input style="width: 180px;" id="txt_query_preg" type="text" data-type="number" autocomplete="off" placeholder="ระบุ HN เพื่อค้นหา">
        <button class="btn btn-primary" type="button" id="btn_do_search_preg" rel="tooltip" title="ค้นหา">
            <i class="icon-search"></i>
        </button>

        <button type="button" id="btn_refresh" rel="tooltip" title="รีเฟรช (Refresh)" class="btn btn-default pull-right"><i class="icon-refresh"></i></button>
        <button type="button" id="btn_register" rel="tooltip" title="ลงทะเบียนรายใหม่" class="btn btn-success">
            <i class="icon-plus-sign"></i> ลงทะเบียน</button>
    </form>
</div>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
    <tr>
        <th>ANC No.</th>
        <th>HN</th>
        <th>เลขบัตรประชาชน</th>
        <th>ชื่อ - สกุล</th>
        <th>วันเกิด</th>
        <th>อายุ (ป.ด.ว)</th>
        <th>วันที่ลงทะเบียน</th>
        <th>ครรภ์ที่</th>
        <th>สถานะ</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="8">กรุณากำหนดเงื่อนไขการแสดงข้อมูล</td>
    </tr>
    </tbody>
</table>

<ul class="pagination" id="main_paging"></ul>

<div class="modal fade" id="mdl_search_person">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class="icon-search"></i>
                    ค้นหาข้อมูลประชากร
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txt_search_person_filter" value="0" />
                <div class="navbar">
                    <form action="#" class="navbar-form">
                        <input id="txt_search_query" type="text" autocomplete="off" placeholder="พิมพ์คำที่ต้องการค้นหา เช่น เลขบัตรประชาชน, HN, ชื่อ-สกุล..."
                               title="พิมพ์คำที่ต้องการค้นหา เช่น เลขบัตรประชาชน, HN, ชื่อ-สกุล..." rel="tooltip" style="width: 400px;">
                        <div class="btn-group">
                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" rel="tooltip" title="ระบุเงื่อนไขในการค้นหา">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" data-name="btn_search_person_fillter" data-value="0">ค้นจาก เลขบัตรประชาชน</a></li>
                                <li><a href="#" data-name="btn_search_person_fillter" data-value="1">ค้นจาก HN</a></li>
                                <li><a href="#" data-name="btn_search_person_fillter" data-value="2">ค้นจาก ชื่อ - สกุล</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-primary" rel="tooltip" title="ค้นหา" id="btn_do_search_person"><i class="icon-search"></i> ค้นหา</button>
                    </form>
                </div>
                <table class="table table-striped" id="tbl_search_person_result">
                    <thead>
                    <tr>
                        <th>HN</th>
                        <th>เลขบัตรประชาชน</th>
                        <th>ชื่อ - สกุล</th>
                        <th>วันเกิด</th>
                        <th>อายุ</th>
                        <th>เพศ</th>
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
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_labor">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-group"></i> ข้อมูลการคลอด</h4>
            </div>
            <div class="modal-body">

                <form class="form-inline well well-small">
                    <div class="row">
                        <div class="col-lg-2">
                            <label>HN</label>
                            <input type="text" disabled="disabled" id="txt_labor_hn">
                        </div>
                        <div class="col-lg-3">
                            <label>เลขบัตรประชาชน</label>
                            <input type="text" disabled="disabled" id="txt_labor_cid">
                        </div>
                        <div class="col-lg-3">
                            <label>ชื่อ - สกุล</label>
                            <input type="text" disabled="disabled" id="txt_labor_fullname">
                        </div>
                        <div class="col-lg-2">
                            <label>วันเกิด</label>
                            <input type="text" disabled="disabled" id="txt_labor_birthdate">
                        </div>
                        <div class="col-lg-2">
                            <label>อายุ (ปี)</label>
                            <input type="text" disabled="disabled" id="txt_labor_age">
                        </div>
                    </div>
                </form>

                <form action="#">
                    <legend>รายละเอียดการคลอด</legend>
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="control-label" for="txt_labor_gravida">ครรภ์ที่</label>
                            <input type="text" class="input-small uneditable-input" id="txt_labor_gravida" disabled="disabled">
                        </div>
                        <div class="col-lg-2">
                            <div class="control-group">
                                <label for="txt_labor_bdate">วันที่คลอด</label>
                                <input data-type="date" id="txt_labor_bdate" type="text" placeholder="dd/mm/yyyy"
                                    rel="tooltip" title="ระบุวันที่คลอด เช่น 28/02/2556">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label for="sl_labor_btime">เวลา</label>
                            <input type="text" data-type="time" id="txt_labor_btime" rel="tooltip" title="เวลาที่คลอด" placeholder="hh:mm">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <label for="txt_labor_bresult_icdcode">รหัส</label>
                            <input type="text" id="txt_labor_bresult_icdcode" disabled="disabled" placeholder="-*-" rel="tooltip" title="พิมพ์รหัสการวินิจฉัย">
                        </div>
                        <div class="col-lg-10">
                            <label for="txt_labor_bresult_icdname">รหัสวินิจฉัย</label>
                            <input type="text" id="txt_labor_bresult_icdname" placeholder="-*-" title="พิมพ์รหัสหรือรายละเอียดการวินิจฉัย เพื่อค้นหา" rel="tooltip">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="sl_labor_bplace">สถานที่คลอด</label>
                            <select id="sl_labor_bplace">
                                <option value="">--</option>
                                <option value="1">โรงพยาบาล</option>
                                <option value="2">สถานีอนามัย</option>
                                <option value="3">บ้าน</option>
                                <option value="4">ระหว่างทาง</option>
                                <option value="5">อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="txt_labor_hospcode">รหัส</label>
                            <input type="text" id="txt_labor_hospcode" disabled="disabled" placeholder="-*-" rel="tooltip" title="พิมพ์รหัสหรือชื่อสถานพยาบาลเพื่อค้นหา">
                        </div>
                        <div class="col-lg-7">
                            <label for="txt_labor_hospname">สถานพยาบาลที่คลอด</label>
                            <input type="text" id="txt_labor_hospname" placeholder="-*-" rel="tooltip" title="พิมพ์รหัสหรือชื่อสถานพยาบาลเพื่อค้นหา">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="sl_labor_btype">วิธีการคลอด</label>
                            <select id="sl_labor_btype">
                                <option value="">--</option>
                                <option value="1">Normal</option>
                                <option value="2">Cesarean</option>
                                <option value="3">Vacuum</option>
                                <option value="4">Forceps</option>
                                <option value="5">ท่ากัน</option>
                                <option value="6">Abortion</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="sl_labor_bdoctor">ประเภทผู้ทำคลอด</label>
                            <select id="sl_labor_bdoctor">
                                <option value="">--</option>
                                <option value="1">แพทย์</option>
                                <option value="2">พยาบาล</option>
                                <option value="3">จนท.สาธารณสุข (ที่ไม่ใช่แพทย์ พยาบาล)</option>
                                <option value="4">ผดุงครรภ์โบราณ</option>
                                <option value="5">คลอดเอง</option>
                                <option value="6">อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="txt_labor_lborn">เกิดมีชีพ</label>
                            <input type="text" data-type="number" id="txt_labor_lborn">
                        </div>
                        <div class="col-lg-2">
                            <label for="txt_labor_sborn">เกิดไร้ชีพ</label>
                            <input type="text" data-type="number" id="txt_labor_sborn">
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-success" id="btn_labor_do_save"><i class="icon-save"></i> บันทึกข้อมูล</a>
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<!-- anc info -->
<div class="modal fade" id="mdl_anc_info">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-briefcase"></i> ข้อมูลการฝากครรภ์</h4>
            </div>
            <div class="modal-body">
            <form class="form-inline  well well-small">
                <div class="row">
                    <div class="col-lg-2">
                        <label>HN</label>
                        <input type="text" disabled="disabled" id="txt_anc_info_hn">
                    </div>
                    <div class="col-lg-3">
                        <label>CID</label>
                        <input type="text" disabled="disabled" id="txt_anc_info_cid">
                    </div>
                    <div class="col-lg-3">
                        <label>ชื่อ - สกุล</label>
                        <input type="text" disabled="disabled" id="txt_anc_info_fullname">
                    </div>
                    <div class="col-lg-2">
                        <label>วันเกิด</label>
                        <input type="text" disabled="disabled" id="txt_anc_info_birthdate">
                    </div>
                    <div class="col-lg-2">
                        <label>อายุ (ปี)</label>
                        <input type="text" disabled="disabled" id="txt_anc_info_age">
                    </div>
                </div>

            </form>

            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_anc_info1" data-toggle="tab"><i class="icon-info-sign"></i> ข้อมูลการฝากครรภ์</a></li>
                    <li><a href="#tab_anc_info2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab_anc_info1">
                        <form action="#">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label for="txt_anc_info_gravida">ครรภ์ที่</label>
                                    <input type="text" id="txt_anc_info_gravida" disabled="disabled">
                                </div>
                                <div class="col-lg-2">
                                    <label for="txt_anc_info_lmp">LMP</label>
                                    <input id="txt_anc_info_lmp" type="text" data-type="date">
                                </div>
                                <div class="col-lg-2">
                                    <label for="txt_anc_info_edc">EDC</label>
                                    <input id="txt_anc_info_edc" type="text" data-type="date">
                                </div>
                                <div class="col-lg-3">
                                    <label for="sl_anc_info_preg_status">สถานะปัจจุบัน</label>
                                    <select id="sl_anc_info_preg_status">
                                        <option value="0">ยังไม่คลอด</option>
                                        <option value="1">คลอดแล้ว</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <label class="control-label" for="sl_anc_info_vdrl">VDRL</label>
                                    <select id="sl_anc_info_vdrl">
                                        <option value="1">ปกติ</option>
                                        <option value="2">ผิดปกติ</option>
                                        <option value="3">ไม่ตรวจ</option>
                                        <option value="4">รอผลตรวจ</option>
                                        <option value="5">ไม่ทราบ</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="control-label" for="sl_anc_info_hb">HB</label>
                                    <select id="sl_anc_info_hb" class="input-medium">
                                        <option value="1">ปกติ</option>
                                        <option value="2">ผิดปกติ</option>
                                        <option value="3">ไม่ตรวจ</option>
                                        <option value="4">รอผลตรวจ</option>
                                        <option value="5">ไม่ทราบ</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="control-label" for="sl_anc_info_hiv">HIV</label>
                                    <select id="sl_anc_info_hiv">
                                        <option value="1">ปกติ</option>
                                        <option value="2">ผิดปกติ</option>
                                        <option value="3">ไม่ตรวจ</option>
                                        <option value="4">รอผลตรวจ</option>
                                        <option value="5">ไม่ทราบ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="txt_anc_info_hct_date">วันที่ตรวจ HCT</label>
                                    <input class="input-small" id="txt_anc_info_hct_date" type="text" data-type="date">
                                </div>
                                <div class="col-lg-3">
                                    <label for="sl_anc_info_hct">ผลตรวจ HCT</label>
                                    <select id="sl_anc_info_hct">
                                        <option value="1">ปกติ</option>
                                        <option value="2">ผิดปกติ</option>
                                        <option value="3">ไม่ตรวจ</option>
                                        <option value="4">รอผลตรวจ</option>
                                        <option value="5">ไม่ทราบ</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="control-label" for="sl_anc_info_thalassemia">ธาลัสซีเมีย</label>
                                    <select id="sl_anc_info_thalassemia">
                                        <option value="1">ปกติ</option>
                                        <option value="2">ผิดปกติ</option>
                                        <option value="3">ไม่ตรวจ</option>
                                        <option value="4">รอผลตรวจ</option>
                                        <option value="5">ไม่ทราบ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <label class="control-label" for="chk_anc_info_do_export">บังคับส่ง</label>
                                    <input type="checkbox" id="chk_anc_info_do_export">
                                </div>
                                <div class="col-lg-2">
                                    <label for="txt_anc_info_export_date">ส่งออกวันที่</label>
                                    <input id="txt_anc_info_export_date" type="text" data-type="date" rel="tooltip" title="ระบุวันที่เพื่อส่งออก">
                                </div>
                            </div>

                            <a href="#" class="btn btn-success" id="btn_anc_info_save"><i class="icon-save"></i> บันทึกข้อมูล</a>
                        </form>
                    </div>

                    <div class="tab-pane" id="tab_anc_info2">
                        <table class="table table-striped" id="tbl_anc_history">
                            <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>หน่วยบริการ</th>
                                <!--<th>ครรภ์ที่</th>-->
                                <th>ANC ช่วงที่</th>
                                <th>อายุครรภ์ (สัปดาห์)</th>
                                <th>ผลตรวจ</th>
                                <th>ผู้ให้บริการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="6">...</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- /anc info -->

<div class="modal fade" id="mdl_anc">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-briefcase"></i> ข้อมูลการฝากครรภ์</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_postnatal">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-briefcase"></i> ข้อมูลการฝากครรภ์</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.pregnancies.index.js');
</script>


