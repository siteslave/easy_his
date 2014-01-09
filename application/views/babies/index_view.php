<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">ทะเบียนเด็กแรกเกิด</li>
</ul>

<div class="navbar navbar-default">
    <form action="#" class="navbar-form">
        <label for="sl_village">หมู่บ้าน</label>
        <select style="width: 250px;" id="sl_village" class="form-control">
            <option value="">-- เลือกหมู่บ้าน [ทั้งหมด] --</option>
            <?php
            foreach ($villages as $r){
                echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
            }
            ?>
        </select>
        <div class="btn-group">
            <button type="button" class="btn btn-primary" id="btn_do_get_list"
                    rel="tooltip" title="แสดงรายการ"><i class="fa fa-refresh"></i></button>
            <button type="button" class="btn btn-default" id="btn_do_print"
                    rel="tooltip" title="พิมพ์รายชื่อตามหมู่บ้านที่เลือก"><i class="fa fa-print"></i></button>
        </div>
        |
        <label for="">HN:</label>
        <input style="width: 300px;" id="txt_query_babies" type="hidden">
        <button class="btn btn-primary" type="button" id="btn_do_search_babies" rel="tooltip" title="ค้นหา">
            <i class="fa fa-search"></i>
        </button>
        <button type="button" id="btn_register" class="btn btn-success" rel="tooltip"
                title="ลงทะเบียนรายใหม่"><i class="fa fa-plus-circle"></i> ลงทะเบียน</button>

        <button type="button" id="btn_refresh" class="btn btn-default pull-right" rel="tooltip"
                title="Refresh"><i class="fa fa-refresh"></i></button>
    </form>
</div>



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

<ul class="pagination" id="main_paging"></ul>

<div class="modal fade" id="mdl_register">
    <div class="modal-dialog" style="width: 680px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-search"></i>
                    ค้นหาข้อมูลประชากร
                </h4>
            </div>
            <div class="modal-body">

                <div class="navbar">
                    <form action="#" class="navbar-form">
                        <input id="txt_search_query" type="hidden" style="width: 400px;">
                        <button type="button" class="btn btn-success" id="btn_do_register_babies">
                            <span class="fa fa-search"></span> ลงทะเบียน
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_labor">
    <div class="modal-dialog" style="width: 960px;">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">ข้อมูลการคลอด</h4>
        </div>
        <div class="modal-body">
            <form class="form-inline well well-small">
            <div class="row">
                <div class="col-lg-2">
                    <label>HN</label>
                    <input type="text" class="form-control" disabled="disabled" id="txt_labor_hn">
                </div>
                <div class="col-lg-3">
                    <label>CID</label>
                    <input type="text" class="form-control" disabled="disabled" id="txt_labor_cid">
                </div>
                <div class="col-lg-3">
                    <label>ชื่อ - สกุล</label>
                    <input type="text" class="form-control" disabled="disabled" id="txt_labor_fullname">
                </div>
                <div class="col-lg-2">
                    <label>วันเกิด</label>
                    <input type="text" class="form-control" disabled="disabled" id="txt_labor_birthdate">
                </div>
                <div class="col-lg-2">
                    <label>อายุ (ปี)</label>
                    <input type="text" class="form-control" disabled="disabled" id="txt_labor_age">
                </div>
            </div>
        </form>
            <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_labor_1" data-toggle="tab"><i class="fa fa-user"></i> ข้อมูลมารดา</a></li>
                <li><a href="#tab_labor_2" data-toggle="tab"><i class="fa fa-edit"></i> การคัดกรองเด็ก</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_labor_1">
                    <br>
                    <form action="#" class="form-inline">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="txt_labor_mother_name">ชื่อ - สกุล</label>
                                <input type="hidden" id="txt_labor_mother_name" style="width: 400px;">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="sl_labor_gravida">ระบุครรภ์ที่</label>
                                <select id="sl_labor_gravida" class="form-control"></select>
                            </div>
                            <div class="col-lg-2">
                                <label for="btn_labor_do_mother_save"><span style="color: white;">ดำเนินการ</span></label>
                                <a href="#" class="btn btn-success" id="btn_labor_do_mother_save"><i class="fa fa-save"></i> บันทึกมารดา</a>
                            </div>
                        </div>
                        <br>
                        <legend>ข้อมูลการคลอด</legend>
                        <div class="row">
                            <div class="col-lg-1">
                                <label for="txt_labor_gravida">ครรภ์ที่</label>
                                <input type="text" class="form-control" id="txt_labor_gravida" disabled="disabled">
                            </div>
                            <div class="col-lg-2">
                                <label for="txt_labor_bdate">วันที่คลอด</label>
                                <input id="txt_labor_bdate" class="form-control" type="text" data-type="date" disabled="disabled">
                            </div>
                            <div class="col-lg-2">
                                <label for="sl_labor_btime">เวลา</label>
                                <input type="text" class="form-control" data-type="time" id="txt_labor_btime" disabled="disabled">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label for="txt_labor_bresult_icdcode">รหัส</label>
                                <input type="text" class="form-control" id="txt_labor_bresult_icdcode" placeholder="..." disabled="disabled">
                            </div>
                            <div class="col-lg-10">
                                <label for="txt_labor_bresult_icdname">ผลวินิจฉัยการคลอด</label>
                                <input type="text" class="form-control" disabled="disabled" id="txt_labor_bresult_icdname" placeholder="...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_labor_bplace">สถานที่คลอด</label>
                                <select class="form-control" id="sl_labor_bplace" disabled="disabled">
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
                                <input type="text" class="form-control" disabled="disabled" id="txt_labor_hospcode" placeholder="...">
                            </div>
                            <div class="col-lg-7">
                                <label for="txt_labor_hospcode">สถานพยาบาลที่คลอด</label>
                                <input type="text" class="form-control" disabled="disabled" id="txt_labor_hospname" placeholder="...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_labor_btype">วิธีการคลอด</label>
                                <select id="sl_labor_btype" disabled="disabled" class="form-control">
                                    <option value="">--</option>
                                    <option value="1">Normal</option>
                                    <option value="2">Cesarean</option>
                                    <option value="3">Vacuum</option>
                                    <option value="4">Forceps</option>
                                    <option value="5">ท่ากัน</option>
                                    <option value="6">Abortion</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="sl_labor_bdoctor">ประเภทผู้ทำคลอด</label>
                                <select id="sl_labor_bdoctor" disabled="disabled" class="form-control">
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
                    </form>
                </div>
                <div class="tab-pane" id="tab_labor_2">
                    <br>
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="control-label" for="txt_labor_bweight">น้ำหนักแรกคลอด</label>
                                <div class="input-group" style="width: 150px;">
                                    <input class="form-control" id="txt_labor_bweight" type="text" data-type="number">
                                    <span class="input-group-addon">กรัม</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="control-label" for="sl_labor_birthno">ลำดับที่การคลอด</label>
                                <select id="sl_labor_birthno" class="form-control">
                                    <option value="">--</option>
                                    <option value="1">คลอดเดี่ยว</option>
                                    <option value="2">เป็นเด็กแฝดลำดับที่ 1</option>
                                    <option value="3">เป็นเด็กแฝดลำดับที่ 2</option>
                                    <option value="4">เป็นเด็กแฝดลำดับที่ 3</option>
                                    <option value="5">เป็นเด็กแฝดลำดับที่ 3</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_labor_asphyxia">ขาดออกซิเจน</label>
                                <select id="sl_labor_asphyxia" class="form-control">
                                    <option value="">--</option>
                                    <option value="1">ขาด</option>
                                    <option value="2">ไม่ขาด</option>
                                    <option value="9">ไม่ทราบ</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_labor_vitk">ไดัรับ Vit. K</label>
                                <select class="form-control" id="sl_labor_vitk">
                                    <option value="">--</option>
                                    <option value="1">ได้รับ</option>
                                    <option value="2">ไม่ได้รับ</option>
                                    <option value="9">ไม่ทราบ</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_labor_tsh">ตรวจ TSH</label>
                                <select id="sl_labor_tsh" class="form-control">
                                    <option value="">--</option>
                                    <option value="1">ไดัรับการตรวจ</option>
                                    <option value="2">ไม่ได้รับการตรวจ</option>
                                    <option value="9">ไม่ทราบ</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="txt_labor_tshresult">ผล TSH</label>
                                <input id="txt_labor_tshresult" class="form-control" type="text" data-type="number">
                            </div>
                        </div>
                    </form>
                    <br>
                    <a href="#" class="btn btn-success" id="btn_labor_save_babies">
                        <i class="fa fa-save"></i> บันทึกข้อมูล</a>
                </div>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-power-off"></i> ปิดหน้าต่าง</a>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_babies_care">
    <div class="modal-dialog" style="width: 960px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-check-circle"></i> ข้อมูลการตรวจเด็กหลังคลอด</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-power-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_nutri">
    <div class="modal-dialog" style="width: 960px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">ข้อมูลระดับโภชนาการ</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-power-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.babies.index.js');
</script>


