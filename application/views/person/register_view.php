<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li><a href="<?php echo site_url('person');?>">ประชากรในเขต</a></li>
    <li class="active">เพิ่มคนในบ้าน</li>
</ul>

<input type="hidden" value="<?php echo $house_id; ?>" id="house_code">

<div class="tabbable">
<ul class="nav nav-tabs">
    <li class="active"><a href="#tabPersonInfo" data-toggle="tab" id="btn_tab_person_info"><i class="fa fa-th-list"></i> ข้อมูลทั่วไป</a></li>
    <li><a href="#tabRight" data-toggle="tab" id="btn_tab_person_right"><i class="fa fa-folder-open-o"></i> สิทธิการรักษา</a></li>
    <li><a href="#tabOutsideAddress" data-toggle="tab" id="btn_tab_person_address"><i class="fa fa-edit"></i> ที่อยู่นอกเขต</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tabPersonInfo">
        <br>
        <div class="navbar navbar-default">
            <form action="#" class="form-inline navbar-form">
                <label for="txt_cid">เลขบัตรประชาชน</label>
                <input id="txt_cid" class="form-control" style="width: 250px;" type="text" value="" placeholder="xxxxxxxxxxxxx">
                <button class="btn btn-default" type="button" disabled><i class="fa fa-refresh"></i></button>
                <button class="btn btn-primary" type="button" id="btn_search_dbpop-x" disabled><i class="fa fa-search"></i></button>
                |
                <label for="txt_passport">เลขที่ Passport</label>
                <input class="form-control" type="text" id="txt_passport" style="width: 250px;" value="" placeholder="เลขที่ Passport" class="input-medium">
            </form>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <label for="slTitle">คำนำหน้า</label>
                <select  id="slTitle" class="form-control">
                    <option value="">--</option>
                    <?php foreach($titles as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>';?>
                </select>
            </div>
            <div class="col-lg-3">
                <label for="txt_first_name">ชื่อ</label>
                <input class="form-control" type="text" id="txt_first_name" value="" placeholder="ชื่อ">
            </div>
            <div class="col-lg-3">
                <div class="control-group">
                    <label for="txt_last_name">สกุล</label>
                    <div class="controls">
                        <input type="text" class="form-control" id="txt_last_name" value="" placeholder="สกุล">
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <label for="txt_birth_date">วันเกิด</label>
                <input class="form-control" id="txt_birth_date" value="" type="text" data-type="date">
            </div>
            <div class="col-lg-2">
                <label for="sl_sex">เพศ</label>
                <select class="form-control" id="sl_sex">
                    <option value="1">ชาย</option>
                    <option value="2" selected>หญิง</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label for="slMStatus">สถานะสมรส</label>
                <select class="form-control" id="slMStatus">
                    <option value="">--</option>
                    <?php foreach($marry_status as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-5">
                <label for="slOccupation">อาชีพ</label>
                <select class="form-control" id="slOccupation">
                    <option value="">--</option>
                    <?php foreach($occupations as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>

                </select>
            </div>
            <div class="col-lg-4">
                <label for="slEducation">การศึกษา</label>
                <select class="form-control" id="slEducation">
                    <option value="">--</option>
                    <?php foreach($educations as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label for="slNation">สัญชาติ</label>
                <select class="form-control" id="slNation">
                    <option value="">--</option>
                    <?php foreach($nationalities as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-3">
                <label for="slRace">เชื้อชาติ</label>
                <select class="form-control" id="slRace">
                    <option value="">--</option>
                    <?php foreach($races as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-3">
                <label for="slReligion">ศาสนา</label>
                <select class="form-control" id="slReligion">
                    <option value="">--</option>
                    <?php foreach($religions as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-3">
                <label for="slFstatus">สถานะในครอบครัว</label>
                <select class="form-control" id="slFstatus">
                    <option value="1" selected>เจ้าบ้าน</option>
                    <option value="2">ผู้อาศัย</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label for="slVstatus">สถานะในชุมชน</label>
                <select class="form-control" id="slVstatus">
                    <option value="">--</option>
                    <?php foreach($vstatus as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-3">
                <label for="txtFatherCid">CID บิดา</label>
                <input class="form-control" type="text" id="txtFatherCid" value="" placeholder="xxxxxxxxxxxxx">
            </div>
            <div class="col-lg-3">
                <label for="txtMotherCid">CID มารดา</label>
                <input type="text" class="form-control" id="txtMotherCid" value="" placeholder="xxxxxxxxxxxxx">
            </div>

            <div class="col-lg-3">
                <label for="txtCoupleCid">CID คู่สมรส</label>
                <input type="text" class="form-control" id="txtCoupleCid" value="" placeholder="xxxxxxxxxxxxx">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="control-group">
                    <label for="txtMoveInDate">วันย้ายเข้า</label>
                    <input class="form-control" value="" id="txtMoveInDate" type="text" data-type="date">
                </div>
            </div>
            <div class="col-lg-2">
                <label for="txtDischargeDate">วันที่จำหน่าย</label>
                <input class="form-control" value="" id="txtDischargeDate" type="text" data-type="date">
            </div>

            <div class="col-lg-3">
                <label for="slDischarge">สถานะการจำหน่าย</label>
                <select class="form-control" id="slDischarge">
                    <option value="9">ไม่จำหน่าย</option>
                    <option value="1">ตาย</option>
                    <option value="2">ย้าย</option>
                    <option value="3">สาบสูญ</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label for="slABOGroup">หมู่เลือด</label>
                <select class="form-control" id="slABOGroup">
                    <option value="">--</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">AB</option>
                    <option value="4">O</option>
                </select>
            </div>

            <div class="col-lg-2">
                <label for="slRHGroup">หมู่เลือด RH</label>
                <select class="form-control" id="slRHGroup">
                    <option value="">--</option>
                    <option value="1">Positive</option>
                    <option value="2">Negative</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <label for="slLabor">คนต่างด้าว</label>
                <select class="form-control" id="slLabor">
                    <option value="">--</option>
                    <?php foreach($labor_types as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                </select>
            </div>
            <div class="col-lg-5">
                <label for="slTypeArea">ประเภทบุคคล</label>
                <select class="form-control" id="slTypeArea">
                    <option value="">--</option>
                    <?php foreach($typearea as $t) echo '<option value="'.$t->code.'">['.$t->code.'] '.$t->name.'</option>'; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tabRight">
        <br />
        <div class="navbar navbar-default">
            <form action="#" class="navbar-form">
                <label for="sl_inscl_type">ประเภทสิทธิการรักษา</label>
                <select name="slInstype" id="sl_inscl_type" class="form-control" style="width: 480px;">
                    <option value="">--</option>
                    <?php foreach($inscls as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                </select>
                <label for="txt_inscl_code">รหัสสิทธิ</label>
                <input class="form-control" style="width: 200px;" type="text" id="txt_inscl_code" value="" placeholder="รหัสสิทธิการรักษา">
            </form>
        </div>
        <form class="form-horizontal" action="#">
            <div class="row">
                <div class="col-lg-2">
                    <label for="txtInsStartDate">วันออกบัตร</label>
                    <input class="form-control" id="txtInsStartDate" placeholder="dd/mm/yyyy" value="" type="text" data-type="date">
                </div>
                <div class="col-lg-2">
                    <label for="txtInsExpireDate">วันหมดอายุ</label>
                    <input class="form-control" id="txtInsExpireDate" placeholder="dd/mm/yyyy" data-type="date" type="text" value="">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <label for="txt_ins_hospmain_name">ชื่อสถานพยาบาลหลัก</label>
                    <input id="txt_ins_hospmain_name" type="hidden" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <label for="txt_ins_hospsub_name">ชื่อสถานพยาบาลรอง</label>
                    <input id="txt_ins_hospsub_name" type="hidden" class="form-control">
                </div>
            </div>
        </form>
    </div>
    <div class="tab-pane" id="tabOutsideAddress">
        <form action="#" class="form-horizontal">
            <div class="row">
                <div class="col-lg-4">
                    <label for="slOutsiedAddressType">ประเภท</label>
                    <select id="slOutsiedAddressType" class="form-control">
                        <option value="1">ที่อยู่ตามทะเบียนบ้าน</option>
                        <option value="2">ที่อยู่ที่ติดต่อได้</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="control-group">
                        <label for="slOutsiedHouseType">ลักษณะที่อยู่</label>
                        <div class="controls">
                            <select id="slOutsiedHouseType" class="form-control">
                                <option value="">--</option>
                                <?php foreach($house_type as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label for="txtOutsideHouseId">รหัสบ้าน</label>
                        <div class="controls">
                            <input type="text" class="form-control" id="txtOutsideHouseId" value="" placeholder="ตามกรมการปกครอง">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label for="txtOutsideRoomNumber">เลขห้อง</label>
                        <div class="controls">
                            <input type="text" class="form-control" value="" id="txtOutsideRoomNumber">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="control-group">
                        <label for="txtOutsideCondo">ชื่ออาคารชุด</label>
                        <div class="controls">
                            <input type="text" class="form-control" value="" id="txtOutsideCondo">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <div class="control-group">
                        <label for="txtOutsideAddressNumber">บ้านเลขที่</label>
                        <div class="controls">
                            <input type="text" value="" class="form-control" id="txtOutsideAddressNumber">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label for="txtOutsideVillageName">บ้านจัดสรร</label>
                        <div class="controls">
                            <input type="text" class="form-control" id="txtOutsideVillageName" value="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label for="txtOutsideSoiSub">ซอยแยก</label>
                        <div class="controls">
                            <input type="text" class="form-control" id="txtOutsideSoiSub" value="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label for="txtOutsideSoiMain">ซอยหลัก</label>
                        <div class="controls">
                            <input type="text" class="form-control" id="txtOutsideSoiMain" value="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label for="txtOutsideRoad">ถนน</label>
                        <div class="controls">
                            <input type="text" class="form-control" id="txtOutsideRoad" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-2">
                    <div class="control-group">
                        <label for="slOutsideVillage">หมู่ที่</label>
                        <div class="controls">
                            <select id="slOutsideVillage" class="form-control">
                                <?php for($i=0; $i<=50; $i++) echo '<option value="'.$i.'">'.$i.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label for="slOutsideProvince">จังหวัด</label>
                        <div class="controls">
                            <select id="slOutsideProvince" class="form-control">
                                <option value="">--</option>
                                <?php foreach($provinces as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label for="slOutsideAmpur">อำเภอ</label>
                        <div class="controls">
                            <select id="slOutsideAmpur" class="form-control">
                                <option value="">--</option>
                                <?php foreach($ampurs as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label for="slOutsideTambon">ตำบล</label>
                        <div class="controls">
                            <select id="slOutsideTambon" class="form-control">
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
                        <label for="txtOutsidePostcode">รหัสไปรษณีย์</label>
                        <div class="controls">
                            <input type="text" class="form-control" id="txtOutsidePostcode" value="" data-type="number">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label for="txtOutsideTelephone">โทรศัพท์บ้าน</label>
                        <div class="controls">
                            <input type="text" class="form-control" id="txtOutsideTelephone" value="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="control-group">
                        <label for="txtOutsideMobile">โทรศัพท์มือถือ</label>
                        <div class="controls">
                            <input type="text" class="form-control" id="txtOutsideMobile" value="">
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
            <i class="fa fa-save"></i>
            บันทึกข้อมูล
        </button>
        <button type="button" id="btn_back_to_home" class="btn btn-default">
            <i class="fa fa-home"></i>
            กลับหน้าหลัก
        </button>
    </div>
</form>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.person.register.js');
</script>