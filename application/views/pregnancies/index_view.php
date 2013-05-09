<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียนฝากครรภ์</li>
</ul>
<form action="#" class="well form-inline">
    <label for="sl_village">หมู่บ้าน</label>
    <select class="input-xlarge" id="sl_village">
        <option value="00000000">---</option>
        <?php
        foreach ($villages as $r){
            echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
        }
        ?>
    </select>
    <button type="button" class="btn btn-info" id="btn_do_get_list"><i class="icon-search"></i></button>
    <div class="btn-group pull-right">
        <button type="button" id="btn_refresh" rel="tooltip" title="รีเฟรช (Refresh)" class="btn"><i class="icon-refresh"></i></button>
        <button type="button" id="btn_register" rel="tooltip" title="ลงทะเบียนรายใหม่" class="btn btn-success"><i class="icon-plus-sign"></i></button>
    </div>
</form>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
    <tr>
        <th>ANC No.</th>
        <th>HN</th>
        <th>CID</th>
        <th>ชื่อ - สกุล</th>
        <th>วันเกิด</th>
        <th>อายุ (ปี)</th>
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

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<div class="modal hide fade" id="mdl_search_person">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>
            <i class="icon-search"></i>
            ค้นหาข้อมูลประชากร
        </h4>
    </div>
    <div class="modal-body">
        <form action="#" class="form-inline well well-small">
            <input type="hidden" id="txt_search_person_filter" value="0" />
            <div class="input-append">
                <input class="input-xlarge" id="txt_search_query" type="text" autocomplete="off">
                <button class="btn" type="button" id="btn_do_search_person">
                    <i class="icon-search"></i>
                </button>
                <div class="btn-group">
                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-cog"></i>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-name="btn_search_person_fillter" data-value="0">ค้นจาก เลขบัตรประชาชน</a></li>
                        <li><a href="#" data-name="btn_search_person_fillter" data-value="1">ค้นจาก HN</a></li>
                        <li><a href="#" data-name="btn_search_person_fillter" data-value="2">ค้นจาก ชื่อ - สกุล</a></li>
                    </ul>
                </div>
            </div>
        </form>
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

<div class="modal hide fade" id="mdl_labor">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ข้อมูลการคลอด</h3>
    </div>
    <div class="modal-body">
        <blockquote>
            บันทึกข้อมูลการคลอด
        </blockquote>
        <form class="form-inline well">
            <label>HN</label>
            <input type="text" class="input-small uneditable-input" disabled="disabled" id="txt_labor_hn">
            <label>CID</label>
            <input type="text" class="input-medium uneditable-input" disabled="disabled" id="txt_labor_cid">
            <label>ชื่อ - สกุล</label>
            <input type="text" class="input-medium uneditable-input" disabled="disabled" id="txt_labor_fullname">
            <label>วันเกิด</label>
            <input type="text" class="input-small uneditable-input" disabled="disabled" id="txt_labor_birthdate">
            <label>อายุ (ปี)</label>
            <input type="text" class="input-mini uneditable-input" disabled="disabled" id="txt_labor_age">
        </form>

        <form action="#">
            <legend>ข้อมูลการคลอด</legend>
            <div class="row-fluid">
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_labor_gravida">ครรภ์ที่</label>
                        <div class="controls">
                            <input type="text" class="input-small uneditable-input" id="txt_labor_gravida" disabled="disabled">
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_labor_bdate">วันที่คลอด</label>
                        <div class="controls">
                            <div class="input-append date" data-name="datepicker">
                                <input class="input-small" id="txt_labor_bdate" type="text" disabled>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span1">
                    <div class="control-group">
                        <label class="control-label" for="sl_labor_btime">เวลา</label>
                        <div class="controls">
                            <input type="text" class="input-mini" data-type="time" id="txt_labor_btime">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span9">
                    <div class="control-group">
                        <label class="control-label" for="txt_labor_bresult_icdcode">ผลวินิจฉัยการคลอด</label>
                        <div class="controls">
                            <input type="text" class="input-mini" id="txt_labor_bresult_icdcode" placeholder="...">
                            <input type="text" class="input-xxlarge uneditable-input" disabled="disabled" id="txt_labor_bresult_icdname" placeholder="...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3">
                    <label class="control-label" for="sl_labor_bplace">สถานที่คลอด</label>
                    <div class="controls">
                        <select class="input-medium" id="sl_labor_bplace">
                            <option value="">--</option>
                            <option value="1">โรงพยาบาล</option>
                            <option value="2">สถานีอนามัย</option>
                            <option value="3">บ้าน</option>
                            <option value="4">ระหว่างทาง</option>
                            <option value="5">อื่นๆ</option>
                        </select>
                    </div>
                </div>
                <div class="span8">
                    <div class="control-group">
                        <label class="control-label" for="txt_labor_hospcode">สถานพยาบาลที่คลอด</label>
                        <div class="controls">
                            <input type="text" class="input-mini" id="txt_labor_hospcode" placeholder="...">
                            <input type="text" class="input-xlarge uneditable-input" disabled="disabled" id="txt_labor_hospname" placeholder="...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3">
                    <label class="control-label" for="sl_labor_btype">วิธีการคลอด</label>
                    <div class="controls">
                        <select class="input-medium" id="sl_labor_btype">
                            <option value="">--</option>
                            <option value="1">Normal</option>
                            <option value="2">Cesarean</option>
                            <option value="3">Vacuum</option>
                            <option value="4">Forceps</option>
                            <option value="5">ท่ากัน</option>
                            <option value="6">Abortion</option>
                        </select>
                    </div>
                </div>
                <div class="span4">
                    <label class="control-label" for="sl_labor_bdoctor">ประเภทผู้ทำคลอด</label>
                    <div class="controls">
                        <select class="input-xlarge" id="sl_labor_bdoctor">
                            <option value="">--</option>
                            <option value="1">แพทย์</option>
                            <option value="2">พยาบาล</option>
                            <option value="3">จนท.สาธารณสุข (ที่ไม่ใช่แพทย์ พยาบาล)</option>
                            <option value="4">ผดุงครรภ์โบราณ</option>
                            <option value="5">คลอดเอง</option>
                            <option value="6">อื่นๆ</option>
                        </select>
                    </div>
                </div>
                <div class="span1">
                    <label class="control-label" for="txt_labor_lborn">เกิดมีชีพ</label>
                    <div class="controls">
                        <input type="text" class="input-mini" data-type="number" id="txt_labor_lborn">
                    </div>
                </div>
                <div class="span1">
                    <label class="control-label" for="txt_labor_sborn">เกิดไร้ชีพ</label>
                    <div class="controls">
                        <input type="text" class="input-mini" data-type="number" id="txt_labor_sborn">
                    </div>
                </div>
            </div>
        </form>

    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success" id="btn_labor_do_save"><i class="icon-save"></i> บันทึกข้อมูล</a>
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>

<!-- anc info -->
<div class="modal hide fade" id="mdl_anc_info">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ข้อมูลการฝากครรภ์</h3>
    </div>
    <div class="modal-body">
        <form class="form-inline well">
            <label>HN</label>
            <input type="text" class="input-small uneditable-input" disabled="disabled" id="txt_anc_info_hn">
            <label>CID</label>
            <input type="text" class="input-medium uneditable-input" disabled="disabled" id="txt_anc_info_cid">
            <label>ชื่อ - สกุล</label>
            <input type="text" class="input-medium uneditable-input" disabled="disabled" id="txt_anc_info_fullname">
            <label>วันเกิด</label>
            <input type="text" class="input-small uneditable-input" disabled="disabled" id="txt_anc_info_birthdate">
            <label>อายุ (ปี)</label>
            <input type="text" class="input-mini uneditable-input" disabled="disabled" id="txt_anc_info_age">
        </form>

        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_anc_info1" data-toggle="tab"><i class="icon-info-sign"></i> ข้อมูลการฝากครรภ์</a></li>
                <li><a href="#tab_anc_info2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_anc_info1">
                    <form action="#">
                        <div class="row-fluid">
                            <div class="span2">
                                <div class="control-group">
                                    <label class="control-label" for="txt_anc_info_gravida">ครรภ์ที่</label>
                                    <div class="controls">
                                        <input type="text" class="input-small uneditable-input" id="txt_anc_info_gravida" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="control-group">
                                    <label class="control-label" for="txt_anc_info_lmp">LMP</label>
                                    <div class="controls">
                                        <div class="input-append date" data-name="datepicker">
                                            <input class="input-small" id="txt_anc_info_lmp" type="text" disabled>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="control-group">
                                    <label class="control-label" for="txt_anc_info_edc">EDC (กำหนดคลอด)</label>
                                    <div class="controls">
                                        <div class="input-append date" data-name="datepicker">
                                            <input class="input-small" id="txt_anc_info_edc" type="text" disabled>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="sl_anc_info_preg_status">สถานะปัจจุบัน</label>
                                    <div class="controls">
                                        <select id="sl_anc_info_preg_status" class="input-medium">
                                            <option value="0">ยังไม่คลอด</option>
                                            <option value="1">คลอดแล้ว</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="sl_anc_info_vdrl">VDRL</label>
                                    <div class="controls">
                                        <select id="sl_anc_info_vdrl" class="input-medium">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="3">ไม่ตรวจ</option>
                                            <option value="4">รอผลตรวจ</option>
                                            <option value="5">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="sl_anc_info_hb">HB</label>
                                    <div class="controls">
                                        <select id="sl_anc_info_hb" class="input-medium">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="3">ไม่ตรวจ</option>
                                            <option value="4">รอผลตรวจ</option>
                                            <option value="5">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="sl_anc_info_hiv">HIV</label>
                                    <div class="controls">
                                        <select id="sl_anc_info_hiv" class="input-medium">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="3">ไม่ตรวจ</option>
                                            <option value="4">รอผลตรวจ</option>
                                            <option value="5">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_anc_info_hct_date">วันที่ตรวจ HCT</label>
                                    <div class="controls">
                                        <div class="input-append date" data-name="datepicker">
                                            <input class="input-small" id="txt_anc_info_hct_date" type="text" disabled>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="sl_anc_info_hct">ผลตรวจ HCT</label>
                                    <div class="controls">
                                        <select id="sl_anc_info_hct" class="input-medium">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="3">ไม่ตรวจ</option>
                                            <option value="4">รอผลตรวจ</option>
                                            <option value="5">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="sl_anc_info_thalassemia">ธาลัสซีเมีย</label>
                                    <div class="controls">
                                        <select id="sl_anc_info_thalassemia" class="input-medium">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="3">ไม่ตรวจ</option>
                                            <option value="4">รอผลตรวจ</option>
                                            <option value="5">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span1">
                                <div class="control-group">
                                    <label class="control-label" for="chk_anc_info_do_export">บังคับส่ง</label>
                                    <div class="controls">
                                        <label class="checkbox">
                                            <input type="checkbox" id="chk_anc_info_do_export">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="control-group">
                                    <label class="control-label" for="txt_anc_info_export_date">ส่งออกวันที่</label>
                                    <div class="controls">
                                        <div class="input-append date" data-name="datepicker">
                                            <input class="input-small" id="txt_anc_info_export_date" type="text" disabled>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
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
<!-- /anc info -->

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.pregnancies.index.js');
</script>


