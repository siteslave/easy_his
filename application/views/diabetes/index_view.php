<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">ทะเบียนผู้ป่วยเบาหวาน (DM)</li>
</ul>
<div class="navbar">
    <form action="#" class="navbar-form">
        <label for="sl_village">หมู่บ้าน</label>
        <select id="sl_village" style="width: 255px;">
            <option value="">-- เลือกหมู่บ้าน (ทั้งหมด) --</option>
            <?php
            foreach ($villages as $r){
                echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
            }
            ?>
        </select>
        <button type="button" class="btn btn-primary" id="btn_filter_by_village"><i class="icon-search"></i></button> |
        <input type="text" style="width: 250px;" id="txt_query" placeholder="พิมพ์ HN หรือ เลขบัตรประชาชน"
               title="พิมพ์ HN หรือ เลขบัตรประชาชน" rel="tooltip" autocomplete="off" />
        <button type="button" id="btn_search" class="btn btn-primary"><i class="icon-search"></i></button>
        <div class="btn-group pull-right">
            <button type="button" id="btn_refresh" class="btn btn-default" title="แสดงข้อมูลทั้งหมด (Refresh)" rel="tooltip"><i class="icon-refresh"></i></button>
            <button type="button" id="btn_register" class="btn btn-success" title="ลงทะเบียนผู้ป่วยรายใหม่ (Register)" rel="tooltip"><i class="icon-plus-sign"></i></button>
            <button type="button" id="btn_print" class="btn btn-default" title="พิมพ์รายชื่อผู้ป่วยทั้งหมด (Print)" rel="tooltip"><i class="icon-print"></i></button>
        </div>
    </form>

</div>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
    <tr>
        <th>No.</th>
        <th>HN</th>
        <th>เลขบัตรประชาชน</th>
        <th>ชื่อ - สกุล</th>
        <th>วันเกิด</th>
        <th>อายุ (ปี)</th>
        <th>เพศ</th>
        <th>วันที่ลงทะเบียน</th>
        <th>ประเภท</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="10">กรุณากำหนดเงื่อนไขการแสดงข้อมูล</td>
    </tr>
    </tbody>
</table>

<ul class="pagination pagination-centered" id="main_paging"></ul>

<!-- Module Register Form -->
<div class="modal fade" id="mdlNewRegister">
    <div class="modal-dialog" style="width: 960px; left: 35%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">ลงทะเบียนผู้ป่วยเบาหวาน (DM)</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline well well-small">
                    <label for="txt_search_person">HN</label>
                    <input type="text" id="txt_search_person" style="width: 250px;" placeholder="เลขบัตรประชาชน หรือ HN"
                           rel="tooltip" title="เลขบัตรประชาชน หรือ HN " data-placement="right">
                    <button type="button" class="btn btn-primary" id="btn_search_person"><i class="icon-search icon-white"></i></button>
                    <input type="hidden" id="txt_isupdate" value="0" />
                </form>
                <form action="#" class="form-inline">
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="control-label" for="tboHN">HN</label>
                            <input type="text" id="tboHN" placeholder="HN" disabled />
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="tboCid">เลขบัตรประชาชน</label>
                            <input type="text" id="tboCid" placeholder="เลขบัตรประชาชน" disabled />
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="tboFname">ชื่อ</label>
                            <input type="text" id="tboFname" placeholder="ชื่อผู้ป่วย" disabled />
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="tboLname">นามสกุล</label>
                            <input type="text" id="tboLname" placeholder="นามสกุล" disabled />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="control-label" for="tboAge">อายุ</label>
                            <input type="text" id="tboAge" placeholder="อายุ" disabled />
                        </div>
                        <div class="col-lg-2">
                            <label class="control-label" for="slSex">เพศ</label>
                            <select id="slSex" disabled style="background-color: white">
                                <option value="1">ชาย</option>
                                <option value="2">หญิง</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="tboRegCenterNumber">เลขทะเบียนกลาง</label>
                            <input type="text" id="tboRegCenterNumber" placeholder="เลขทะเบียนกลาง" disabled />
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="tboRegHosNumber">เลขทะเบียน รพ.</label>
                            <input type="text" id="tboRegHosNumber" placeholder="เลขทะเบียน รพ." />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="control-label" for="tboYear">ปีที่เริ่มเป็น</label>
                            <input type="text" id="tboYear" placeholder="พ.ศ. เช่น 2556" data-type="year" />
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="dtpRegisDate">วันที่ขึ้นทะเบียน</label>
                            <input value="" type="text" id="dtpRegisDate" data-type="date" />
                        </div>
                        <div class="col-lg-3">
                            <div class="control-group">
                                <label class="control-label" for="cboDiseaseType">ประเภทโรค</label>
                                <div class="controls">
                                    <select id="cboDiseaseType">
                                        <option value="">----------</option>
                                        <?php
                                        foreach($diabetes_types as $dt)
                                            echo '<option value="'.$dt->id.'">' . $dt->name . '</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label" for="cboDoctor">แพทย์ผู้ดูแล</label>
                            <select id="cboDoctor">
                                <option value="">----------------</option>
                                <?php
                                foreach($providers as $prov) {
                                    echo '<option value="'.$prov->id.'">'.$prov->name.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="sl_member_status">สถานะปัจจุบัน</label>
                            <select id="sl_member_status">
                                <option value="1">ติดตามการรักษา</option>
                                <option value="1">ส่งต่อรับการรักษาที่อื่น</option>
                                <option value="1">เสียชีวิต</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="txt_discharge_date">วันจำหน่าย</label>
                            <input type="text" id="txt_discharge_date" data-type="date" placeholder="dd/mm/yyyy"/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="ch_pre_register" checked="checked" /> Pre register
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="ch_pregnancy"/> Pregnancy
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="ch_hypertension"/> with Hypertension/DM
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="ch_insulin"/> with Insulin
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="ch_newcase" /> เป็นผู้ป่วยรายใหม่
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_dm_do_register"><i class="icon-save"></i><span id="lblRegis" title="add"> บันทึกข้อมูล</span></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.diabetes.index.js');
</script>


