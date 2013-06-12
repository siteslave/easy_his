<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียนคัดกรองเบาหวาน/ความดัน 15 ปีขึ้นไป</li>
</ul>
<form action="#" class="well form-inline">
    <label class="control-label" for="sl_village">หมู่บ้าน</label>
    <select class="input-xlarge" id="sl_village">
        <option value="">---</option>
        <?php
        foreach ($villages as $r){
            echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
        }
        ?>
    </select>
    บ้านเลขที่
    <select id="sl_house" class="input-medium"></select>
    <button type="button" class="btn btn-info" id="btn_do_get_list"><i class="icon-search icon-white"></i> แสดงรายการ</button>
    <div class="btn-group pull-right">
        <button type="button" id="btn_search" class="btn"><i class="icon-search"></i> ค้นหา</button>
    </div>
</form>

<table class="table table-striped table-hover" id="tbl_ncd_list">
    <thead>
    <tr>
        <th>HN</th>
        <th>CID</th>
        <th>ชื่อ - สกุล</th>
        <th>วันเกิด</th>
        <th>อายุ (ปี)</th>
        <th>เพศ</th>
        <th>คัดกรองเมื่อ</th>
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

<div class="modal hide fade" id="mdlViewScreen">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ข้อมูลสรุปผลการคัดกรองผู้ป่วย</h3>
    </div>
    <div class="modal-body">
        <p>
            <div class="row-fluid">
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="tboFName">ชื่อ</label>
                        <div class="controls">
                            <input type="text" id="tboFname" placeholder="ชื่อ" class="input-medium" disabled>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="tboLname">นามสกุล</label>
                        <div class="controls">
                            <input type="text" id="tboLname" placeholder="นามสกุล" class="input-medium" disabled>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="tboSex">เพศ</label>
                        <div class="controls">
                            <input type="text" id="tboSex" placeholder="เพศ" class="input-small" disabled>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="tboAge">อายุ</label>
                        <div class="controls">
                            <input type="text" id="tboAge" placeholder="อายุ" class="input-small" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <table class="table" id="tblScreen">
                    <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>เวลา</th>
                            <th>น้ำหนัก</th>
                            <th>ส่วนสูง</th>
                            <th>รอบเอว</th>
                            <th>BMI</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </p>
    </div>
    <div class="modal-footer">
        <a class="btn btn-success" data-name="btnShowScreenDialog">เพิ่มคัดกรอง</a>
        <a class="btn btn-danger" data-dismiss="modal" aria-hidden="true">ยกเลิก</a>
    </div>
</div>

<!-- NCD Registration form -->
<div class="modal hide fade" id="mdlScreen">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>บันทึกคัดกรองความเสี่ยงเบาหวานและความดัน</h3>
    </div>
    <div class="modal-body">
        <p>

        <input type="hidden" id="hideScreenId" /> <!-- HIDE My Screen ID with edit record -->

        <div class="row-fluid">
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="dtpHeadDate">วันที่</label>
                    <div class="input-append date" data-name="datepicker">
                        <input value="<?php echo date('d/m/Y'); ?>" type="text" id="dtpHeadDate" style="width: 80px;" disabled />
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="dtpHeadTime">เวลา</label>
                    <div class="input-append bootstrap-timepicker">
                        <input type="text" value="<?php echo date('H:i'); ?>" class="input-mini timepicker" id="dtpHeadTime" data-name="timepicker" data-type="time" />
                        <span class="add-on"><i class="icon-time"></i></span>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="tboHeadWeight">น้ำหนัก</label>
                    <div class="input-append">
                        <input type="text" id="tboHeadWeight" class="input-mini" data-type="number" placeholder="น้ำหนัก">
                        <span class="add-on">กก.</span>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="tboHeadHeight">ส่วนสูง</label>
                    <div class="input-append">
                        <input type="text" id="tboHeadHeight" class="input-mini" data-type="number" placeholder="ส่วนสูง">
                        <span class="add-on">ซม.</span>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="tboHeadWaistline">รอบเอว</label>
                    <div class="input-append">
                        <input type="text" id="tboHeadWaistline" class="input-mini" data-type="number" placeholder="รอบเอว">
                        <span class="add-on">ซม.</span>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="tboHeadBMI">BMI</label>
                    <div class="controls">
                        <input type="text" id="tboHeadBMI" class="input-mini" placeholder="BMI" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="checkbox">
                        <input type="checkbox" id="chkHeadServiceLocal" checked>&nbsp;คัดกรองที่หน่วยให้บริการ
                    </label>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="cboDoctor">ผู้คัดกรอง</label>
                    <div class="form-inline">
                        <select id="cboDoctor">
                            <option value="">.........</option>
                            <?php
                                foreach($providers as $p) {
                                    echo '
                                        <option value="'.$p->id.'">'.$p->name.'</option>
                                    ';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span5">
                <div class="control-group">
                    <label class="control-label" for="tboPcuCode">คัดกรองที่</label>
                    <div class="controls">
                        <input type="text" class="input-mini" id="tboPcuCode" placeholder="...">
                        <input type="text" id="tboPcuName" placeholder="..." disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <ul class="nav nav-tabs" id="mainTab">
                <li class="active"><a href="#tabInterview">การสัมภาษณ์</a></li>
                <li><a href="#tabSugar">ระดับน้ำตาลในเลือด</a></li>
                <li><a href="#tabPressure">การวัดความดัน</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tabInterview">
                    <!-- SUB TAB -->
                    <div class="tabbable tabs-left">
                        <ul class="nav nav-tabs" id="subTab">
                            <li class="active"><a href="#tab1">ข้อมูลครอบครัว</a></li>
                            <li><a href="#tab2">ประวัติการเจ็บป่วย</a></li>
                            <li><a href="#tab3">การสูบบุหรี่</a></li>
                            <li><a href="#tab4">การดื่มแอลกอฮอล์</a></li>
                            <li><a href="#tab5">การออกกำลังกาย</a></li>
                            <li><a href="#tab6">การรับประทานอาหาร</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <!-- ข้อมูลครอบครัว -->
                                <div class="alert alert-success">
                                    <h4>บิดาหรือมารดาของท่านที่มีประวัติเจ็บป่วยด้วย</h4>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab11DM"> เบาหวาน (DM)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab11HT"> ความดันโลหิตสูง (HT)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab11Gout"> โรคเกาท์ (Gout)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab11CRF"> ไตวายเรื้อรัง (CRF)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab11MI"> กล้ามเนื้อหัวใจตาย (MI)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab11Stroke"> เส้นเลือดสมอง (Stroke)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab11Copd"> ถุงลมโป่งพอง (COPD)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab11Unknown"> ไม่ทราบ
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <h4>พี่น้อง (สายตรง) ของท่านที่มีประวัติเจ็บป่วยด้วย</h4>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab12DM"> เบาหวาน (DM)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab12HT"> ความดันโลหิตสูง (HT)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab12Gout"> โรคเกาท์ (Gout)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab12CRF"> ไตวายเรื้อรัง (CRF)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab12MI"> กล้ามเนื้อหัวใจตาย (MI)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab12Stroke"> เส้นเลือดสมอง (Stroke)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab12Copd"> ถุงลมโป่งพอง (COPD)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="chkTab12Unknown"> ไม่ทราบ
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="tab2">
                            <!-- ประวัติการเจ็บป่วย -->
                                <div class="alert alert-success">
                                    <h4>ท่านมีประวัติการเจ็บป่วย หรือต้องพบแพทย์หรืออาการ</h4>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label">โรคเบาหวาน</label>
                                                <div class="controls">
                                                    <select id="cboTab21DM" class="input-medium">
                                                        <option value="ไม่เคยตรวจ">ไม่เคยตรวจ</option>
                                                        <option value="มี">มี</option>
                                                        <option value="ไม่มี">ไม่มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label">ความดันโลหิตสูง</label>
                                                <div class="controls">
                                                    <select id="cboTab21HT" class="input-medium">
                                                        <option value="ไม่เคยตรวจ">ไม่เคยตรวจ</option>
                                                        <option value="มี">มี</option>
                                                        <option value="ไม่มี">ไม่มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label">โรคตับ</label>
                                                <div class="controls">
                                                    <select id="cboTab21Liver" class="input-medium">
                                                        <option value="ไม่เคยตรวจ">ไม่เคยตรวจ</option>
                                                        <option value="มี">มี</option>
                                                        <option value="ไม่มี">ไม่มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21Paralysis">โรคอัมพาต</label>
                                                <div class="controls">
                                                    <select id="cboTab21Paralysis" class="input-medium">
                                                        <option value="ไม่เคยตรวจ">ไม่เคยตรวจ</option>
                                                        <option value="มี">มี</option>
                                                        <option value="ไม่มี">ไม่มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21Heart">โรคหัวใจ</label>
                                                <div class="controls">
                                                    <select id="cboTab21Heart" class="input-medium">
                                                        <option value="ไม่เคยตรวจ">ไม่เคยตรวจ</option>
                                                        <option value="มี">มี</option>
                                                        <option value="ไม่มี">ไม่มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21Lipid">ไขมันในเลือดผิดปกติ</label>
                                                <div class="controls">
                                                    <select id="cboTab21Lipid" class="input-medium">
                                                        <option value="ไม่เคยตรวจ">ไม่เคยตรวจ</option>
                                                        <option value="มี">มี</option>
                                                        <option value="ไม่มี">ไม่มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21FootUlcers">แผลที่เท้า/ตัดขา (จากเบาหวาน)</label>
                                                <div class="controls">
                                                    <select id="cboTab21FootUlcers" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21Confined">คลอดบุตรน้ำหนักเกิน 4 กก.หรือเป็นเบาหวานขณะตั้งครรภ์</label>
                                                <div class="controls">
                                                    <select id="cboTab21Confined" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21DrinkWaterFrequently">ดื่มน้ำบ่อยและมาก</label>
                                                <div class="controls">
                                                    <select id="cboTab21DrinkWaterFrequently" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21NightUrination">ปัสสาวะกลางคืน 3 ครั้งขึ้นไป</label>
                                                <div class="controls">
                                                    <select id="cboTab21NightUrination" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21Batten">กินจุแต่ผอมลง</label>
                                                <div class="controls">
                                                    <select id="cboTab21Batten" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21WeightDown">น้ำหนักลด/อ่อนเพลีย</label>
                                                <div class="controls">
                                                    <select id="cboTab21WeightDown" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21UlceratedLips">เป็นแผลริมฝีปากบ่อยและหายยาก</label>
                                                <div class="controls">
                                                    <select id="cboTab21UlceratedLips" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21ItchySkin">คันตามผิวหนังและอวัยวะสืบพันธุ์</label>
                                                <div class="controls">
                                                    <select id="cboTab21ItchySkin" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21BlearyEyed">ตาพร่ามัว ต้องเปลี่ยนแว่นบ่อย</label>
                                                <div class="controls">
                                                    <select id="cboTab21BlearyEyed" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21TeaByHand">ชาตามปลายมือปลายเท้าโดยไม่ทราบสาเหตุ</label>
                                                <div class="controls">
                                                    <select id="cboTab21TeaByHand" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span5">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21HowToBehave">วิธีการปฏิบัติตนหากมีประวัติด้านบน</label>
                                                <div class="controls">
                                                    <select id="cboTab21HowToBehave" class="input-xlarge">
                                                        <option value="ไม่มีประวัติ">ไม่มีประวัติ</option>
                                                        <option value="รับการรักษาอยู่/ปฏิบัติตามที่แพทย์แนะนำ">รับการรักษาอยู่/ปฏิบัติตามที่แพทย์แนะนำ</option>
                                                        <option value="รับการรักษาต่อแต่ไม่สม่ำเสมอ">รับการรักษาต่อแต่ไม่สม่ำเสมอ</option>
                                                        <option value="เคยรักษา ขณะนี้ไม่รักษา/หายาทานเอง">เคยรักษา ขณะนี้ไม่รักษา/หายาทานเอง</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21CreasedNeck">มีรอยพับรอบคอหรือใต้รักแร้ดำ</label>
                                                <div class="controls">
                                                    <select id="cboTab21CreasedNeck" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span8">
                                            <div class="control-group">
                                                <label class="control-label" for="cboTab21HistoryFPG">มีประวัติน้ำตาลในเลือดสูง (FPG 100-125)(OGTT 140-199)</label>
                                                <div class="controls">
                                                    <select id="cboTab21HistoryFPG" class="input-medium">
                                                        <option value="ไม่มี">ไม่มี</option>
                                                        <option value="มี">มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="tab3">
                                <!-- การสูบบุหรี่ -->
                                <div class="alert">
                                    <h4>ท่านสูบบุหรี่หรือไม่</h4>
                                    <div class="row-fluid">
                                        <label class="radio">
                                            <input type="radio" name="Smoke" id="rdoNoSmoke" checked> ไม่สูบ
                                        </label>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <label class="radio">
                                                <input type="radio" name="Smoke" id="rdoEverSmoked"> เคยสูบแต่เลิกแล้ว
                                            </label>
                                        </div>
                                        <div class="span5">
                                            <label class="control-label">ชนิดบุหรี่ที่เคยสูบ</label>
                                            <div class="controls">
                                                <input type="text" placeholder="ชนิดบุหรี่ที่เคยสูบ" id="tboOfSmoked" class="input-large">
                                            </div>
                                        </div>
                                        <div class="span3">
                                            <label class="control-label">ระยะเวลา</label>
                                            <div class="controls">
                                                <input type="text" class="input-mini" id="tboTimeSmoke" placeholder="ระยะเวลา" data-type="number"> ปี
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span2">
                                            <label class="radio">
                                                <input type="radio" name="Smoke" id="rdoSmoking"> สูบ
                                            </label>
                                        </div>
                                        <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">จำนวน</label>
                                                <div class="controls">
                                                    <input type="text" class="input-mini" id="tboSmokingNumberPerDay" placeholder="จำนวน" data-type="number"> มวน/วัน
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">จำนวน</label>
                                                <div class="controls">
                                                    <input type="text" class="input-mini" id="tboSmokingNumberPerYear" placeholder="จำนวน" data-type="number"> Pack/ปี
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">ชนิดบุหรี่ที่สูบ</label>
                                                <div class="controls">
                                                    <input type="text" id="tboOfSmoking" class="input-medium" placeholder="ชนิดบุหรี่ที่สูบ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span2">
                                        </div>
                                        <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">สุบมาแล้ว</label>
                                                <div class="controls">
                                                    <input type="text" class="input-mini" id="tboSmokingYear" placeholder="สุบมา/ปี" data-type="number"> ปี
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="tab4">
                                <!-- การดื่มแอลกอฮอล์ -->
                                <div class="alert alert-error">
                                    <h4>ท่านดื่มแอลกอฮอล์หรือไม่</h4>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <label class="radio">
                                                <input type="radio" name="Alcohol" id="rdoNoAlcohol" checked> ไม่ดื่ม
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <label class="radio">
                                                <input type="radio" name="Alcohol" id="rdoBeenDrinkingAlcohol"> เคยดื่มแต่เลิกแล้ว
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span2">
                                            <label class="radio">
                                                <input type="radio" name="Alcohol" id="rdoAlcohol"> ดื่ม
                                            </label>
                                        </div>
                                        <div class="span4">
                                            <label class="control-label">จำนวน</label>
                                            <div class="controls">
                                                <input type="text" class="input-mini" data-type="number" id="tboAlcoholPerWeek" placeholder="จำนวน"> ครั้ง/สัปดาห์
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" id="tab5">
                                <!-- การออกกำลังกาย -->
                                <div class="alert alert-info">
                                    <h4>ท่านออกกำลังกายแบบใด</h4>
                                    <div class="row-fluid">
                                        <label class="radio">
                                            <input type="radio" id="rdoExercise1" name="Exercise" checked> ออกกำลังกายทุกวัน ครั้งละ 30 นาที
                                        </label>
                                    </div>
                                    <div class="row-fluid">
                                        <label class="radio">
                                            <input type="radio" id="rdoExercise2" name="Exercise"> ออกกำลังกายสัปดาห์ละมากกว่า 3 ครั้ง ครั้งละ 30 นาทีสม่ำเสมอ
                                        </label>
                                    </div>
                                    <div class="row-fluid">
                                        <label class="radio">
                                            <input type="radio" id="rdoExercise3" name="Exercise"> ออกกำลังกายสัปดาห์ละ 3 ครั้ง ครั้งละ 30 นาทีสม่ำเสมอ
                                        </label>
                                    </div>
                                    <div class="row-fluid">
                                        <label class="radio">
                                            <input type="radio" id="rdoExercise4" name="Exercise"> ออกกำลังกายน้อยกว่าสัปดาห์ละ 3 ครั้ง
                                        </label>
                                    </div>
                                    <div class="row-fluid">
                                        <label class="radio">
                                            <input type="radio" id="rdoNoExercise" name="Exercise"> ไม่ออกกำลังกายเลย
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="tab6">
                                <!-- การรับประทานอาหาร -->
                                <div class="alert alert-success">
                                    <h4>ท่านรับประทานอาหารรสใด</h4>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <label class="radio">
                                                <input type="radio" name="Food" id="rdoNoFood" checked> ไม่ชอบทุกข้อ
                                            </label>
                                        </div>

                                        <div class="span2">
                                            <label class="radio">
                                                <input type="radio" name="Food" id="rdoFoodSweet"> หวาน
                                            </label>
                                        </div>

                                        <div class="span2">
                                            <label class="radio">
                                                <input type="radio" name="Food" id="rdoFoodSalt"> เค็ม
                                            </label>
                                        </div>

                                        <div class="span2">
                                            <label class="radio">
                                                <input type="radio" name="Food" id="rdoFoodIt"> มัน
                                            </label>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- SUB TAB -->
                </div>
                <div class="tab-pane" id="tabSugar">

                    <!-- ระดับน้ำตาลในเลือด -->
                    <div class="alert alert-success">
                        <h4>Fasting Capillary Blood Glucose (FCG)</h4><input type="hidden" id="hideFcg">
                        <table class="table" id="tblFcg">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>วันที่</th>
                                    <th>เวลา</th>
                                    <th>ผล</th>
                                    <th>อดน้ำ/อาหาร 8 ชั่วโมง</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <button id="btnShowAddFcg" class="btn btn-info"><i class="icon-check icon-white"></i></button>
                        <div class="fade top in" style="display: none;" id="popFcg">
                            <div class="row-fluid">
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="dtpFcgDate">วันที่</label>
                                        <div class="input-append date" data-name="datepicker">
                                            <input value="<?php echo date('d/m/Y'); ?>" type="text" id="dtpFcgDate" style="width: 80px;" disabled />
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                        <label class="control-label" for="dtpFcgTime">เวลา</label>
                                        <div class="input-append bootstrap-timepicker">
                                            <input type="text" value="<?php echo date('H:i'); ?>" class="input-mini timepicker" id="dtpFcgTime" data-name="timepicker" data-type="time" />
                                            <span class="add-on"><i class="icon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                        <label class="control-label" for="tboFcgResult">ผล</label>
                                        <div class="controls">
                                            <input class="input-mini" type="text" id="tboFcgResult" placeholder="ผล" data-type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="chkFcg">อดน้ำ/อาหาร 8 ชั่วโมง</label>
                                        <input type="checkbox" id="chkFcg">
                                    </div>

                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                        <label class="control-label">&nbsp;</label>
                                        <div class="input-append">
                                            <button id="btnAddFcg" class="btn btn-success" title="บันทึก"><i class="icon-plus-sign icon-white"></i></button>
                                            <button id="btnCancelFcg" class="btn btn-danger" title="ยกเลิก"><i class="icon-minus-sign icon-white"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h4>Fasting Plasma Glucose (FPG)</h4><input type="hidden" id="hideFpg">
                        <table class="table" id="tblFpg">
                            <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>วันที่</th>
                                <th>เวลา</th>
                                <th>ผล</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <button id="btnShowAddFpg" class="btn btn-info"><i class="icon-check icon-white"></i></button>
                        <div class="fade top in" style="display: none;" id="popFpg">
                            <div class="row-fluid">
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="dtpFpgDate">วันที่</label>
                                        <div class="input-append date" data-name="datepicker">
                                            <input value="<?php echo date('d/m/Y'); ?>" type="text" id="dtpFpgDate" style="width: 80px;" disabled />
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                        <label class="control-label" for="dtpFpgTime">เวลา</label>
                                        <div class="input-append bootstrap-timepicker">
                                            <input type="text" value="<?php echo date('H:i'); ?>" class="input-mini timepicker" id="dtpFpgTime" data-name="timepicker" data-type="time" />
                                            <span class="add-on"><i class="icon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                        <label class="control-label" for="tboFpgResult">ผล</label>
                                        <div class="controls">
                                            <input class="input-mini" type="text" id="tboFpgResult" placeholder="ผล" data-type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                        <label class="control-label">&nbsp;</label>
                                        <div class="input-append">
                                            <button id="btnAddFpg" class="btn btn-success" title="บันทึก"><i class="icon-plus-sign icon-white"></i></button>
                                            <button id="btnCancelFpg" class="btn btn-danger" title="ยกเลิก"><i class="icon-minus-sign icon-white"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert">
                        <h4>Post pandial blood sugar</h4>
                        <div class="control-group">
                            <div class="controls">
                                PPG <input type="text" class="input-small" id="tboPPG1" data-type="number"> mg% ตรวจหลังรับประทานอาหาร <input type="text" id="tboPPG2" class="input-mini" data-type="number"> ชั่วโมง
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="tabPressure">
                    <!-- การวัดความดัน -->
                    <div class="alert alert-success">
                        <h4>การวัดความดัน</h4><input type="hidden" id="hideHt">
                        <table class="table" id="tblHt">
                            <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>bps</th>
                                <th>bpd</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>100</td>
                                <td>100</td>
                                <td><a id="btnRemoveHT" class="btn btn-danger"><i class="icon-trash"></i></td>
                            </tr>
                            </tbody>
                        </table>

                        <button id="btnShowAddHt" class="btn btn-info"><i class="icon-check icon-white"></i></button>
                        <div class="fade top in" style="display: none;" id="popHt">
                            <div class="row-fluid">
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="tboHtResult1">BPS</label>
                                        <div class="controls">
                                            <input class="input-mini" type="text" id="tboHtResult1" placeholder="BPS" data-type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="tboHtResult1">BPD</label>
                                        <div class="controls">
                                            <input class="input-mini" type="text" id="tboHtResult2" placeholder="BPD" data-type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                        <label class="control-label">&nbsp;</label>
                                        <div class="input-append">
                                            <button id="btnAddHt" class="btn btn-success" title="บันทึก"><i class="icon-plus-sign icon-white"></i></button>
                                            <button id="btnCancelHt" class="btn btn-danger" title="ยกเลิก"><i class="icon-minus-sign icon-white"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h4>ผลตรวจร่างกายทั่วไป</h4>
                        <textarea id="tboScreen" class="input-xxlarge"></textarea>
                    </div>

                </div>
            </div>
        </div>

        </p>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="tboPersonId">
        <a class="btn btn-danger" id="btnCancelSaveScreen">ยกเลิก</a>
        <a class="btn btn-success" id="btnSaveScreen">บันทึกคัดกรอง</a>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.ncd.index.js');
</script>