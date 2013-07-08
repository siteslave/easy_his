<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li><a href="<?php echo site_url('person');?>">ประชากรในเขต</a></li>
    <li class="active">เพิ่มคนในบ้าน</li>
</ul>

<input type="hidden" value="<?php echo $house_id; ?>" id="house_code">

<div class="tabbable">
<ul class="nav nav-tabs">
    <li class="active"><a href="#tabPersonInfo" data-toggle="tab" id="btn_tab_person_info"><i class="icon-th-list"></i> ข้อมูลทั่วไป</a></li>
    <li><a href="#tabRight" data-toggle="tab" id="btn_tab_person_right"><i class="icon-folder-open"></i> สิทธิการรักษา</a></li>
    <li><a href="#tabOutsideAddress" data-toggle="tab" id="btn_tab_person_address"><i class="icon-edit"></i> ที่อยู่นอกเขต</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tabPersonInfo">
        <br>
        <div class="navbar">
            <form action="#" class="form-inline navbar-form">
                <label>เลขบัตรประชาชน</label>
                <input id="txt_cid" style="width: 250px;" type="text" value="" placeholder="xxxxxxxxxxxxx">
                <button class="btn btn-default" type="button"><i class="icon-refresh"></i></button>
                <button class="btn btn-primary" type="button" id="btn_search_dbpop"><i class="icon-search"></i></button>
                |
                <label class="control-label" for="txt_passport">เลขที่ Passport</label>
                <input type="text" id="txt_passport" style="width: 250px;" value="" placeholder="เลขที่ Passport" class="input-medium">
            </form>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <label class="control-label" for="slTitle">คำนำหน้า</label>
                <select  id="slTitle">
                    <option value="">--</option>
                    <?php foreach($titles as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>';?>
                </select>
            </div>
            <div class="col-lg-3">
                <label class="control-label" for="txt_first_name">ชื่อ</label>
                <input type="text" id="txt_first_name" value="" placeholder="ชื่อ">
            </div>
            <div class="col-lg-3">
                <div class="control-group">
                    <label class="control-label" for="txt_last_name">สกุล</label>
                    <div class="controls">
                        <input type="text" id="txt_last_name" value="" placeholder="สกุล">
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <label class="control-label" for="txt_birth_date">วันเกิด</label>
                <input id="txt_birth_date" value="" type="text" data-type="date">
            </div>
            <div class="col-lg-2">
                <label class="control-label" for="sl_sex">เพศ</label>
                <select  id="sl_sex">
                    <option value="1">ชาย</option>
                    <option value="2" selected>หญิง</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label class="control-label" for="slMStatus">สถานะสมรส</label>
                <select  id="slMStatus">
                    <option value="">--</option>
                    <?php foreach($marry_status as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-5">
                <label class="control-label" for="slOccupation">อาชีพ</label>
                <select  id="slOccupation">
                    <option value="">--</option>
                    <?php foreach($occupations as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>

                </select>
            </div>
            <div class="col-lg-4">
                <label class="control-label" for="slEducation">การศึกษา</label>
                <select  id="slEducation">
                    <option value="">--</option>
                    <?php foreach($educations as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label class="control-label" for="slNation">สัญชาติ</label>
                <select  id="slNation">
                    <option value="">--</option>
                    <?php foreach($nationalities as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-3">
                <label class="control-label" for="slRace">เชื้อชาติ</label>
                <select  id="slRace">
                    <option value="">--</option>
                    <?php foreach($races as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-3">
                <label class="control-label" for="slReligion">ศาสนา</label>
                <select  id="slReligion">
                    <option value="">--</option>
                    <?php foreach($religions as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-3">
                <label class="control-label" for="slFstatus">สถานะในครอบครัว</label>
                <select  id="slFstatus">
                    <option value="1" selected>เจ้าบ้าน</option>
                    <option value="2">ผู้อาศัย</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label class="control-label" for="slVstatus">สถานะในชุมชน</label>
                <select  id="slVstatus">
                    <option value="">--</option>
                    <?php foreach($vstatus as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-3">
                <label class="control-label" for="txtFatherCid">CID บิดา</label>
                <input type="text" id="txtFatherCid" value="" placeholder="xxxxxxxxxxxxx">
            </div>
            <div class="col-lg-3">
                <label class="control-label" for="txtMotherCid">CID มารดา</label>
                <input type="text" id="txtMotherCid" value="" placeholder="xxxxxxxxxxxxx">
            </div>

            <div class="col-lg-3">
                <label class="control-label" for="txtCoupleCid">CID คู่สมรส</label>
                <input type="text" id="txtCoupleCid" value="" placeholder="xxxxxxxxxxxxx">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="control-group">
                    <label class="control-label" for="txtMoveInDate">วันย้ายเข้า</label>
                    <input value="" id="txtMoveInDate" type="text" data-type="date">
                </div>
            </div>
            <div class="col-lg-2">
                <label class="control-label" for="txtDischargeDate">วันที่จำหน่าย</label>
                <input value="" id="txtDischargeDate" type="text" data-type="date">
            </div>

            <div class="col-lg-3">
                <label class="control-label" for="slDischarge">สถานะการจำหน่าย</label>
                <select  id="slDischarge">
                    <option value="9">ไม่จำหน่าย</option>
                    <option value="1">ตาย</option>
                    <option value="2">ย้าย</option>
                    <option value="3">สาบสูญ</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label class="control-label" for="slABOGroup">หมู่เลือด</label>
                <select  id="slABOGroup">
                    <option value="">--</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">AB</option>
                    <option value="4">O</option>
                </select>
            </div>

            <div class="col-lg-2">
                <label class="control-label" for="slRHGroup">หมู่เลือด RH</label>
                <select  id="slRHGroup">
                    <option value="">--</option>
                    <option value="1">Positive</option>
                    <option value="2">Negative</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <label class="control-label" for="slLabor">คนต่างด้าว</label>
                <select  id="slLabor">
                    <option value="">--</option>
                    <?php foreach($labor_types as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-8">
                <label class="control-label" for="slTypeArea">ประเภทบุคคล</label>
                <select  id="slTypeArea">
                    <option value="">--</option>
                    <?php foreach($typearea as $t) echo '<option value="'.$t->code.'">['.$t->code.'] '.$t->name.'</option>'; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tabRight">
        <form class="form-horizontal" action="#">
            <div class="row">
                <div class="col-lg-6">
                    <label class="control-label" for="sl_inscl_type">ประเภทสิทธิการรักษา</label>
                    <select name="slInstype" id="sl_inscl_type">
                        <option value="">--</option>
                        <?php foreach($inscls as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label class="control-label" for="txt_inscl_code">รหัสสิทธิ</label>
                    <input type="text" id="txt_inscl_code" value="" placeholder="รหัสสิทธิการรักษา">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <label class="control-label" for="txtInsStartDate">วันออกบัตร</label>
                    <input id="txtInsStartDate" value="" type="text" data-type="date">
                </div>
                <div class="col-lg-2">
                    <label class="control-label" for="txtInsExpireDate">วันหมดอายุ</label>
                    <input id="txtInsExpireDate" data-type="date" type="text" value="">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2">
                    <label for="txt_ins_hospmain_code">รหัส</label>
                    <input type="text" id="txt_ins_hospmain_code" value="" disabled="disabled">
                </div>
                <div class="col-lg-4">
                    <label for="txt_ins_hospmain_name">ชื่อสถานพยาบาลหลัก</label>
                    <input id="txt_ins_hospmain_name" value="" type="text" placeholder="พิมพ์ชื่อ หรือ รหัส สถานพยาบาล"
                           title="พิมพ์ชื่อ หรือ รหัส สถานพยาบาล เพื่อค้นหา" rel="tooltip">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2">
                    <label for="txt_ins_hospsub_code">รหัส</label>
                    <input type="text" id="txt_ins_hospsub_code" value="" disabled="disabled">
                </div>
                <div class="col-lg-4">
                    <label for="txt_ins_hospsub_name">ชื่อสถานพยาบาลหลัก</label>
                    <input id="txt_ins_hospsub_name" value="" type="text" placeholder="พิมพ์ชื่อ หรือ รหัส สถานพยาบาล"
                           title="พิมพ์ชื่อ หรือ รหัส สถานพยาบาล เพื่อค้นหา" rel="tooltip">
                </div>
            </div>
        </form>
    </div>
    <div class="tab-pane" id="tabOutsideAddress">
        <form action="#" class="form-horizontal">
            <div class="row">
                <div class="col-lg-4">
                    <label class="control-label" for="slOutsiedAddressType">ประเภท</label>
                    <select id="slOutsiedAddressType">
                        <option value="1">ที่อยู่ตามทะเบียนบ้าน</option>
                        <option value="2">ที่อยู่ที่ติดต่อได้</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="control-group">
                        <label class="control-label" for="slOutsiedHouseType">ลักษณะที่อยู่</label>
                        <div class="controls">
                            <select id="slOutsiedHouseType">
                                <option value="">--</option>
                                <?php foreach($house_type as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsideHouseId">รหัสบ้าน</label>
                        <div class="controls">
                            <input type="text" id="txtOutsideHouseId" value="" placeholder="ตามกรมการปกครอง">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsideRoomNumber">เลขห้อง</label>
                        <div class="controls">
                            <input type="text" value="" id="txtOutsideRoomNumber">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsideCondo">ชื่ออาคารชุด</label>
                        <div class="controls">
                            <input type="text" value="" id="txtOutsideCondo">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsideAddressNumber">บ้านเลขที่</label>
                        <div class="controls">
                            <input type="text" value="" id="txtOutsideAddressNumber">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsideVillageName">บ้านจัดสรร</label>
                        <div class="controls">
                            <input type="text" id="txtOutsideVillageName" value="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsideSoiSub">ซอยแยก</label>
                        <div class="controls">
                            <input type="text" id="txtOutsideSoiSub" value="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsideSoiMain">ซอยหลัก</label>
                        <div class="controls">
                            <input type="text" id="txtOutsideSoiMain" value="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsideRoad">ถนน</label>
                        <div class="controls">
                            <input type="text" id="txtOutsideRoad" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-2">
                    <div class="control-group">
                        <label class="control-label" for="slOutsideVillage">หมู่ที่</label>
                        <div class="controls">
                            <select id="slOutsideVillage">
                                <?php for($i=0; $i<=50; $i++) echo '<option value="'.$i.'">'.$i.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label class="control-label" for="slOutsideProvince">จังหวัด</label>
                        <div class="controls">
                            <select id="slOutsideProvince">
                                <option value="">--</option>
                                <?php foreach($provinces as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label class="control-label" for="slOutsideAmpur">อำเภอ</label>
                        <div class="controls">
                            <select id="slOutsideAmpur">
                                <option value="">--</option>
                                <?php foreach($ampurs as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label class="control-label" for="slOutsideTambon">ตำบล</label>
                        <div class="controls">
                            <select id="slOutsideTambon">
                                <option value="">--</option>
                                <?php foreach($tambons as $t)  echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsidePostcode">รหัสไปรษณีย์</label>
                        <div class="controls">
                            <input type="text" id="txtOutsidePostcode" value="" data-type="number">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsideTelephone">โทรศัพท์บ้าน</label>
                        <div class="controls">
                            <input type="text" id="txtOutsideTelephone" value="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label class="control-label" for="txtOutsideMobile">โทรศัพท์มือถือ</label>
                        <div class="controls">
                            <input type="text" id="txtOutsideMobile" value="">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<br>
<br>
<form action="#">
    <div class="alert alert-success">
        <button type="button" id="btn_save_person" class="btn btn-success">
            <i class="icon-save"></i>
            บันทึกข้อมูล
        </button>
        <button type="button" id="btn_back_to_home" class="btn btn-default">
            <i class="icon-home"></i>
            กลับหน้าหลัก
        </button>
    </div>
</form>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.person.register.js');
</script>