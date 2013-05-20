<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียนเด็กแรกเกิด</li>
</ul>
<form action="#" class="well form-inline">
    <label for="sl_village">หมู่บ้าน</label>
    <select class="input-xlarge" id="sl_village">
        <option value="">ทั้งหมด</option>
        <?php
        foreach ($villages as $r){
            echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
        }
        ?>
    </select>
    <div class="btn-group">
        <button type="button" class="btn btn-success" id="btn_do_get_list" rel="tooltip" title="แสดงรายการ"><i class="icon-refresh"></i></button>
        <button type="button" class="btn" id="btn_do_print" rel="tooltip" title="พิมพ์รายชื่อตามหมู่บ้านที่เลือก"><i class="icon-print"></i></button>
    </div>
    |
    <label for="">HN:</label>
    <div class="input-append">
        <input class="input-medium" id="txt_query_babies" type="text" data-type="number" autocomplete="off" placeholder="ระบุ HN เพื่อค้นหา">
        <button class="btn btn-info" type="button" id="btn_do_search_babies" ref="tooltip" title="ค้นหา">
            <i class="icon-search"></i>
        </button>
    </div>


     <div class="btn-group pull-right">
        <button type="button" id="btn_refresh" class="btn" rel="tooltip" title="Refresh"><i class="icon-refresh"></i></button>
        <button type="button" id="btn_register" class="btn btn-success" rel="tooltip" title="ลงทะเบียนรายใหม่"><i class="icon-plus-sign"></i></button>
    </div>
</form>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
    <tr>
        <th>HN</th>
        <th>CID</th>
        <th>ชื่อ - สกุล</th>
        <th>วันเกิด</th>
        <th>อายุ (ป.ด.ว)</th>
        <th>วันที่ลงทะเบียน</th>
        <th>ครรภ์ที่</th>
        <th>HN มารดา</th>
        <th>ชื่อมารดา</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="10">...</td>
    </tr>
    </tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<div class="modal hide fade" id="mdl_register">
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
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_labor_1" data-toggle="tab"><i class="icon-user"></i> ข้อมูลมารดา</a></li>
                <li><a href="#tab_labor_2" data-toggle="tab"><i class="icon-edit"></i> การคัดกรองเด็ก</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_labor_1">
                    <form action="#" class="form-inline">
                        <div class="row-fluid">
                            <div class="span2">
                                <div class="control-group">
                                    <label for="txt_labor_gravida" class="control-label">HN</label>
                                    <input type="text" class="input-small uneditable-input" id="txt_labor_mother_hn" disabled="disabled" placeholder="...">
                                </div>
                            </div>
                            <div class="span5">
                                <div class="control-group">
                                    <label for="txt_labor_gravida" class="control-label">ชื่อ - สกุล</label>
                                    <input type="text" class="input-xlarge" id="txt_labor_mother_name" placeholder="พิมพ์ชื่อ/HN เพื่อค้นหา...">
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="sl_labor_gravida">ระบุครรภ์ที่</label>
                                    <select id="sl_labor_gravida" class="input-small"></select>
                                </div>
                            </div>
                            <div class="span2">
                                <a href="#" class="btn btn-success" id="btn_labor_do_mother_save"><i class="icon-save"></i> บันทึกมารดา</a>
                            </div>
                        </div>
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
                                        <input class="input-small uneditable-input" id="txt_labor_bdate" type="text" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="span1">
                                <div class="control-group">
                                    <label class="control-label" for="sl_labor_btime">เวลา</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini uneditable-input" data-type="time" id="txt_labor_btime" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span10">
                                <div class="control-group">
                                    <label class="control-label" for="txt_labor_bresult_icdcode">ผลวินิจฉัยการคลอด</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini uneditable-input" id="txt_labor_bresult_icdcode" placeholder="..." disabled="disabled">
                                        <input type="text" class="input-xxlarge uneditable-input" disabled="disabled" id="txt_labor_bresult_icdname" placeholder="...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <label class="control-label" for="sl_labor_bplace">สถานที่คลอด</label>
                                <div class="controls">
                                    <select class="input-medium" id="sl_labor_bplace" disabled="disabled">
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
                                        <input type="text" class="input-mini uneditable-input" disabled="disabled" id="txt_labor_hospcode" placeholder="...">
                                        <input type="text" class="input-xlarge uneditable-input" disabled="disabled" id="txt_labor_hospname" placeholder="...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <label class="control-label" for="sl_labor_btype">วิธีการคลอด</label>
                                <div class="controls">
                                    <select class="input-medium" id="sl_labor_btype" disabled="disabled">
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
                                    <select class="input-xlarge" id="sl_labor_bdoctor" disabled="disabled">
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
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab_labor_2">
                    <form action="#">
                        <div class="row-fluid">
                            <div class="span2">
                                <label class="control-label" for="txt_labor_bweight">น้ำหนักแรกคลอด</label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input class="input-mini" id="txt_labor_bweight" type="text" data-type="number">
                                        <span class="add-on">กรัม</span>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <label class="control-label" for="sl_labor_birthno">ลำดับที่การคลอด</label>
                                <div class="controls">
                                    <select class="input-xlarge" id="sl_labor_birthno">
                                        <option value="">--</option>
                                        <option value="1">คลอดเดี่ยว</option>
                                        <option value="2">เป็นเด็กแฝดลำดับที่ 1</option>
                                        <option value="3">เป็นเด็กแฝดลำดับที่ 2</option>
                                        <option value="4">เป็นเด็กแฝดลำดับที่ 3</option>
                                        <option value="5">เป็นเด็กแฝดลำดับที่ 3</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <label class="control-label" for="sl_labor_asphyxia">ขาดออกซิเจน</label>
                                <div class="controls">
                                    <select class="input-medium" id="sl_labor_asphyxia">
                                        <option value="">--</option>
                                        <option value="1">ขาด</option>
                                        <option value="2">ไม่ขาด</option>
                                        <option value="9">ไม่ทราบ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span3">
                                <label class="control-label" for="sl_labor_vitk">ไดัรับ Vit. K</label>
                                <div class="controls">
                                    <select class="input-medium" id="sl_labor_vitk">
                                        <option value="">--</option>
                                        <option value="1">ได้รับ</option>
                                        <option value="2">ไม่ได้รับ</option>
                                        <option value="9">ไม่ทราบ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span3">
                                <label class="control-label" for="sl_labor_tsh">ตรวจ TSH</label>
                                <div class="controls">
                                    <select class="input-medium" id="sl_labor_tsh">
                                        <option value="">--</option>
                                        <option value="1">ไดัรับการตรวจ</option>
                                        <option value="2">ไม่ได้รับการตรวจ</option>
                                        <option value="9">ไม่ทราบ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label" for="txt_labor_tshresult">ผล TSH</label>
                                <div class="controls">
                                    <input class="input-mini" id="txt_labor_tshresult" type="text" data-type="number">
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href="#" class="btn btn-success" id="btn_labor_save_babies">
                        <i class="icon-save"></i> บันทึกข้อมูล</a>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>

<!-- anc info -->
<div class="modal hide fade" id="mdl_ppcare">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>ข้อมูลการดูแลหลังคลอด</h4>
    </div>
    <div class="modal-body">
    <form class="form-inline well well-small">
        <label>HN</label>
        <input type="text" class="input-small uneditable-input" disabled="disabled" id="txt_ppcare_hn">
        <label>CID</label>
        <input type="text" class="input-medium uneditable-input" disabled="disabled" id="txt_ppcare_cid">
        <label>ชื่อ - สกุล</label>
        <input type="text" class="input-medium uneditable-input" disabled="disabled" id="txt_ppcare_fullname">
        <label>วันเกิด</label>
        <input type="text" class="input-small uneditable-input" disabled="disabled" id="txt_ppcare_birthdate">
        <label>อายุ (ปี)</label>
        <input type="text" class="input-mini uneditable-input" disabled="disabled" id="txt_ppcare_age">
    </form>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_ppcare1" data-toggle="tab"><i class="icon-plus-sign"></i> บันทึกข้อมูลดูแลหลังคลอด (บันทึกความครอบคลุม)</a></li>
            <li><a href="#tab_ppcare2" data-toggle="tab"><i class="icon-time"></i> ประวัติการรับบริการ</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_ppcare1">
                <form action="#">
                    <div class="row-fluid">

                        <div class="span1">
                            <div class="control-group">
                                <label class="control-label" for="txt_ppcare_gravida">ครรภ์ที่</label>
                                <div class="controls">
                                    <input type="text" id="txt_ppcare_gravida" class="input-mini uneditable-input" disabled="disabled"/>
                                </div>
                            </div>
                        </div>
                        <div class="span2">
                            <div class="control-group">
                                <label class="control-label" for="txt_ppcare_bcare">วันที่รับบริการ</label>
                                <div class="controls">
                                    <div class="input-append date" data-name="datepicker">
                                        <input class="input-small" id="txt_ppcare_bcare" type="text" disabled>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span1">
                            <div class="control-group">
                                <label class="control-label" for="txt_ppcare_hospcode">รหัส</label>
                                <div class="controls">
                                    <input type="text" id="txt_ppcare_hospcode" class="input-mini uneditable-input" disabled="disabled" />
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label" for="txt_ppcare_hospname">สถานที่ตรวจ</label>
                                <div class="controls">
                                    <input type="text" id="txt_ppcare_hospname" class="input-xxlarge"
                                        placeholder="พิมพ์ชื่อ หรือ รหัสสถานบริการ" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            <div class="control-group">
                                <label class="control-label" for="sl_ppcare_bcareresult">ผลการตรวจ</label>
                                <div class="controls">
                                    <select id="sl_ppcare_bcareresult" class="input-medium">
                                        <option value="1">ปกติ</option>
                                        <option value="2">ผิดปกติ</option>
                                        <option value="9">ไม่ทราบ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label" for="sl_ppcare_food">อาหารที่รับประทาน</label>
                                <div class="controls">
                                    <select id="sl_ppcare_food" class="input-xlarge">
                                        <option value="1">นมแม่อย่างเดียว</option>
                                        <option value="2">นมแม่และน้ำ</option>
                                        <option value="3">นมแม่และนมผสม</option>
                                        <option value="4">นมผสมอย่างเดียว</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label" for="sl_ppcare_providers">ผู้ให้บริการ</label>
                                <div class="controls">
                                    <select id="sl_ppcare_providers" class="input-xlarge">
                                        <option value="">--</option>
                                        <?php foreach($providers as $r) echo '<option value="'.$r->id.'">' . $r->name .'</option>';?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn btn-success" id="btn_ppcare_save"><i class="icon-save"></i> บันทึกข้อมูล</a>
                </form>
            </div>

            <div class="tab-pane" id="tab_ppcare2">
                <table class="table table-striped" id="tbl_ppcare_history">
                    <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>หน่วยบริการ</th>
                        <th>ผลตรวจ</th>
                        <th>อาหาร</th>
                        <th>ผู้ให้บริการ</th>
                        <th>#</th>
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
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.babies.index.js');
</script>


