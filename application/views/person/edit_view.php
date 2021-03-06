    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
        <li><a href="<?php echo site_url('person');?>">ประชากรในเขต</a></li>
        <li class="active">แก้ไขข้อมูล</li>
    </ul>

    <input type="hidden" value="<?php echo $data->hn; ?>" id="hn">

    <div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tabPersonInfo" data-toggle="tab" id="btn_tab_person_info">
                <i class="fa fa-th-list"></i> ข้อมูลทั่วไป
            </a>
        </li>
        <li>
            <a href="#tabRight" data-toggle="tab" id="btn_tab_person_right">
                <i class="fa fa-folder-open-o"></i> สิทธิการรักษา
            </a>
        </li>
        <li>
            <a href="#tabOutsideAddress" data-toggle="tab" id="btn_tab_person_address">
                <i class="fa fa-edit"></i> ที่อยู่นอกเขต
            </a>
        </li>
        <li>
            <a href="#tab_drug_allergy" data-toggle="tab" id="btn_tab_drug_allergy">
                <i class="fa fa-warning"></i> ข้อมูลการแพ้ยา
            </a>
        </li>
        <li>
            <a href="#tab_chronic" data-toggle="tab" id="btn_tab_chronic">
                <i class="fa fa-tags"></i> ข้อมูลโรคเรื้อรัง
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tabPersonInfo">
        <br>
            <div class="navbar navbar-default">
                <form action="#" class="form-inline navbar-form">
                    <label>เลขบัตรประชาชน</label>
                    <input type="hidden" id="txt_old_cid" value="<?php echo $data->cid; ?>">
                    <input id="txt_cid" class="form-control" style="width: 250px;" type="text"
                           value="<?php echo $data->cid; ?>" placeholder="xxxxxxxxxxxxx">
                    <button class="btn btn-default" type="button" disabled>
                        <i class="fa fa-refresh"></i>
                    </button>
                    <button class="btn btn-primary" type="button" id="btn_search_dbpop-x" disabled>
                        <i class="fa fa-search"></i>
                    </button>
                    |
                    <label class="control-label" for="txt_passport">เลขที่ Passport</label>
                    <input type="text" class="form-control" id="txt_passport"
                           style="width: 250px;" value="<?php echo $data->passport; ?>" placeholder="เลขที่ Passport">
                </form>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <label class="control-label" for="slTitle">คำนำหน้า</label>
                    <select  id="slTitle" class="form-control">
                        <option value="">--</option>
                        <?php
                        foreach($titles as $t){
                            if($t->id == $data->title) echo '<option value="'.$t->id.'" selected>'.$t->name.'</option>';
                            else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="txt_first_name">ชื่อ</label>
                    <input type="text" class="form-control" id="txt_first_name" value="<?= $data->first_name; ?>" placeholder="ชื่อ">
                </div>
                <div class="col-lg-3">
                    <div class="control-group">
                        <label for="txt_last_name">สกุล</label>
                        <div class="controls">
                            <input type="text" class="form-control" id="txt_last_name" value="<?= $data->last_name; ?>" placeholder="สกุล">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="txt_birth_date">วันเกิด</label>
                    <input class="form-control" id="txt_birth_date" value="<?= $data->birthdate; ?>" type="text" data-type="date">
                </div>
                <div class="col-lg-2">
                    <label class="control-label" for="sl_sex">เพศ</label>
                    <select  id="sl_sex" class="form-control">
                        <option value="1" <?=$data->sex == '1' ? 'selected="selected"' : ''?>>ชาย</option>
                        <option value="2" <?=$data->sex == '2' ? 'selected="selected"' : ''?>>หญิง</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <label class="control-label" for="slMStatus">สถานะสมรส</label>
                    <select  id="slMStatus" class="form-control">
                        <option value="">-*-</option>
                        <?php
                        foreach($marry_status as $t){
                            if($t->id == $data->mstatus) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                            else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-5">
                    <label class="control-label" for="slOccupation">อาชีพ</label>
                    <select  id="slOccupation" class="form-control">
                        <option value="">-*-</option>
                        <?php
                        foreach($occupations as $t){
                            if($t->id == $data->occupation) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                            else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                        }
                        ?>

                    </select>
                </div>
                <div class="col-lg-3">
                    <label class="control-label" for="slEducation">การศึกษา</label>
                    <select  id="slEducation" class="form-control">
                        <option value="">-*-</option>
                        <?php
                        foreach($educations as $t){
                            if($t->id == $data->education) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                            else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <label class="control-label" for="slNation">สัญชาติ</label>
                    <select  id="slNation" class="form-control">
                        <option value="">-*-</option>
                        <?php
                        foreach($nationalities as $t){
                            if($t->id == $data->nation) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                            else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label class="control-label" for="slRace">เชื้อชาติ</label>
                    <select  id="slRace" class="form-control">
                        <option value="">-*-</option>
                        <?php
                        foreach($races as $t){
                            if($t->id == $data->race) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                            else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label class="control-label" for="slReligion">ศาสนา</label>
                    <select  id="slReligion" class="form-control">
                        <option value="">-*-</option>
                        <?php
                        foreach($religions as $t){
                            if($t->id == $data->religion) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                            else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label class="control-label" for="slFstatus">สถานะในครอบครัว</label>
                    <select  id="slFstatus" class="form-control">
                        <option value="1" <?=$data->fstatus == '1' ? 'selected="selected"' : ''?>>เจ้าบ้าน</option>
                        <option value="2" <?=$data->fstatus == '2' ? 'selected="selected"' : ''?>>ผู้อาศัย</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <label class="control-label" for="slVstatus">สถานะในชุมชน</label>
                    <select  id="slVstatus" class="form-control">
                        <option value="">-*-</option>
                        <?php
                        foreach($vstatus as $t){
                            if($t->id == $data->vstatus) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                            else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="txtFatherCid">CID บิดา</label>
                    <input type="text" class="form-control" id="txtFatherCid" value="<?= $data->father_cid; ?>" placeholder="xxxxxxxxxxxxx">
                </div>
                <div class="col-lg-3">
                    <label for="txtMotherCid">CID มารดา</label>
                    <input type="text" class="form-control" id="txtMotherCid" value="<?= $data->mother_cid; ?>" placeholder="xxxxxxxxxxxxx">
                </div>
    
                <div class="col-lg-3">
                    <label for="txtCoupleCid">CID คู่สมรส</label>
                    <input type="text" class="form-control" id="txtCoupleCid" value="<?= $data->couple_cid;?>" placeholder="xxxxxxxxxxxxx">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <div class="control-group">
                        <label for="txtMoveInDate">วันย้ายเข้า</label>
                        <input value="<?= $data->movein_date; ?>" class="form-control" id="txtMoveInDate" type="text" data-type="date">
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="txtDischargeDate">วันที่จำหน่าย</label>
                    <input value="<?= $data->discharge_date; ?>" class="form-control" id="txtDischargeDate" type="text" data-type="date">
                </div>
    
                <div class="col-lg-3">
                    <label for="slDischarge">สถานะการจำหน่าย</label>
                    <select  id="slDischarge" class="form-control">
                        <option value="9" <?=$data->discharge_status == '9' ? 'selected="selected"' : ''?>>ไม่จำหน่าย</option>
                        <option value="1" <?=$data->discharge_status == '1' ? 'selected="selected"' : ''?>>ตาย</option>
                        <option value="2" <?=$data->discharge_status == '2' ? 'selected="selected"' : ''?>>ย้าย</option>
                        <option value="3" <?=$data->discharge_status == '3' ? 'selected="selected"' : ''?>>สาบสูญ</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label for="slABOGroup">หมู่เลือด</label>
                    <select  id="slABOGroup" class="form-control">
                        <option value="">-*-</option>
                        <option value="1" <?=$data->abogroup == '1' ? 'selected="selected"' : ''?>>A</option>
                        <option value="2" <?=$data->abogroup == '2' ? 'selected="selected"' : ''?>>B</option>
                        <option value="3" <?=$data->abogroup == '3' ? 'selected="selected"' : ''?>>AB</option>
                        <option value="4" <?=$data->abogroup == '4' ? 'selected="selected"' : ''?>>O</option>
                    </select>
                </div>
    
                <div class="col-lg-2">
                    <label for="slRHGroup">หมู่เลือด RH</label>
                    <select  id="slRHGroup" class="form-control">
                        <option value="">-*-</option>
                        <option value="1" <?=$data->rhgroup == '1' ? 'selected="selected"' : ''?>>Positive</option>
                        <option value="2" <?=$data->rhgroup == '2' ? 'selected="selected"' : ''?>>Negative</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <label for="slLabor">คนต่างด้าว</label>
                    <select  id="slLabor" class="form-control">
                        <option value="">-*-</option>
                        <?php
                        foreach($labor_types as $t){
                            if($t->id == $data->labor_type) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                            else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-5">
                    <label for="slTypeArea">ประเภทบุคคล</label>
                    <select  id="slTypeArea" class="form-control">
                        <option value="">-*-</option>
                        <?php
                        foreach($typearea as $t){
                            if($t->code == $data->typearea) echo '<option value="'.$t->code.'" selected="selected">['.$t->code.'] '.$t->name.'</option>';
                            else echo '<option value="'.$t->code.'">['.$t->code.'] '.$t->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tabRight">
            <br />
            <div class="navbar navbar-default">
                <form action="#" class="navbar-form form-inline">
                    <label for="sl_inscl_type">ประเภทสิทธิการรักษา</label>
                    <select name="slInstype" id="sl_inscl_type" class="form-control" style="width: 450px;">
                        <option value="">-*-</option>
                        <?php
                        foreach($inscls as $t) {
                            if($t->code == $data->ins_id) echo '<option value="'.$t->code.'" selected="selected">'.$t->name.'</option>';
                            else echo '<option value="'.$t->code.'">'.$t->name.'</option>';
                        }
                        ?>
                    </select>
                    |
                    <label for="txt_inscl_code">รหัสสิทธิ</label>
                    <input type="text" id="txt_inscl_code" style="width: 200px;" class="form-control" value="<?= $data->ins_code; ?>" placeholder="รหัสสิทธิการรักษา">
                </form>
            </div>
            <form class="form-horizontal" action="#">
                <div class="row">
                    <div class="col-lg-2">
                        <label for="txtInsStartDate">วันออกบัตร</label>
                        <input id="txtInsStartDate" class="form-control" value="<?= $data->ins_start_date; ?>" type="text" data-type="date">
                    </div>
                    <div class="col-lg-2">
                        <label for="txtInsExpireDate">วันหมดอายุ</label>
                        <input class="form-control" id="txtInsExpireDate" data-type="date" type="text" value="<?= $data->ins_expire_date; ?>">
                    </div>
                </div>

                <div class="row">
<!--                    <div class="col-lg-2">-->
<!--                        <label for="txt_ins_hospmain_code">รหัส</label>-->
                        <input type="hidden" id="txt_ins_hospmain_code1" value="<?= $data->ins_hmain_code; ?>">
                        <input type="hidden" id="txt_ins_hospmain_name1" value="<?= $data->ins_hmain_name; ?>">
<!--                    </div>-->
                    <div class="col-lg-4">
                        <label for="txt_ins_hospmain_name">ชื่อสถานพยาบาลหลัก</label>
                        <input id="txt_ins_hospmain_name" class="form-control" value="<?= $data->ins_hmain_name; ?>" type="hidden">
                    </div>
                </div>

                <div class="row">
<!--                    <div class="col-lg-2">-->
<!--                        <label for="txt_ins_hospsub_code">รหัส</label>-->
                        <input type="hidden" id="txt_ins_hospsub_code1" value="<?= $data->ins_hsub_code; ?>">
                        <input type="hidden" id="txt_ins_hospsub_name1" value="<?= $data->ins_hsub_name; ?>">
<!--                    </div>-->
                    <div class="col-lg-4">
                        <label for="txt_ins_hospsub_name">ชื่อสถานพยาบาลหลัก</label>
                        <input id="txt_ins_hospsub_name" class="form-control" value="<?= $data->ins_hsub_name; ?>" type="text" placeholder="พิมพ์ชื่อ หรือ รหัส สถานพยาบาล"
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
                        <select id="slOutsiedAddressType" class="form-control">
                            <option value="1" <?=$data->address_address_type == '1' ? 'selected="selected"' : ''?>>ที่อยู่ตามทะเบียนบ้าน</option>
                            <option value="2" <?=$data->address_address_type == '2' ? 'selected="selected"' : ''?>>ที่อยู่ที่ติดต่อได้</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="slOutsiedHouseType">ลักษณะที่อยู่</label>
                            <div class="controls">
                                <select id="slOutsiedHouseType" class="form-control">
                                    <option value="">-*-</option>
                                    <?php
                                    foreach($house_type as $t){
                                        if($t->id == $data->address_house_type) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                        else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsideHouseId">รหัสบ้าน</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="txtOutsideHouseId" value="<?php echo $data->address_house_id; ?>" placeholder="ตามกรมการปกครอง">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsideRoomNumber">เลขห้อง</label>
                            <div class="controls">
                                <input type="text" class="form-control" value="<?= $data->address_room_no; ?>" id="txtOutsideRoomNumber">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsideCondo">ชื่ออาคารชุด</label>
                            <div class="controls">
                                <input type="text" class="form-control" value="<?= $data->address_condo; ?>" id="txtOutsideCondo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsideAddressNumber">บ้านเลขที่</label>
                            <div class="controls">
                                <input type="text" class="form-control" value="<?= $data->address_houseno; ?>" id="txtOutsideAddressNumber">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsideSoiSub">ซอยแยก</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="txtOutsideSoiSub" value="<?= $data->address_soi_sub; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsideSoiMain">ซอยหลัก</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="txtOutsideSoiMain" value="<?= $data->address_soi_main; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsideRoad">ถนน</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="txtOutsideRoad" value="<?= $data->address_road; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsideVillageName">บ้านจัดสรร</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="txtOutsideVillageName" value="<?= $data->address_village_name; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="slOutsideVillage">หมู่ที่</label>
                            <div class="controls">
                                <select id="slOutsideVillage" class="form-control">
                                    <?php
                                        for($i=0; $i<=50; $i++){
                                            if($data->village == $i) echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
                                            else echo '<option value="'.$i.'">'.$i.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="slOutsideProvince">จังหวัด</label>
                            <div class="controls">
                                <select id="slOutsideProvince" class="form-control">
                                    <option value="">-*-</option>
                                    <?php
                                    foreach($provinces as $t){
                                        if($t->code == $data->address_changwat) echo '<option value="'.$t->code.'" selected="selected">'.$t->name.'</option>';
                                        else echo '<option value="'.$t->code.'">'.$t->name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="slOutsideAmpur">อำเภอ</label>
                            <div class="controls">
                                <select id="slOutsideAmpur" class="form-control">
                                    <option value="">--</option>
                                    <?php
                                    foreach($ampurs as $t){
                                        if($t->code == $data->address_ampur) echo '<option value="'.$t->code.'" selected="selected">'.$t->name.'</option>';
                                        else echo '<option value="'.$t->code.'">'.$t->name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="slOutsideTambon">ตำบล</label>
                            <div class="controls">
                                <select id="slOutsideTambon" class="form-control">
                                    <option value="">-*-</option>.<?php
                                    foreach($tambons as $t){
                                        if($t->code == $data->address_tambon) echo '<option value="'.$t->code.'" selected="selected">'.$t->name.'</option>';
                                        else echo '<option value="'.$t->code.'">'.$t->name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsidePostcode">รหัสไปรษณีย์</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="txtOutsidePostcode" value="<?= $data->address_postcode; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsideTelephone">โทรศัพท์</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="txtOutsideTelephone" value="<?= $data->address_telephone; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="control-group">
                            <label for="txtOutsideMobile">โทรศัพท์มือถือ</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="txtOutsideMobile" value="<?= $data->address_mobile; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="tab_drug_allergy">
            <table class="table table-striped table-hover" id="tbl_drug_allergy_list">
                <thead>
                <tr>
                    <th>วันที่</th>
                    <th>ชื่อยา</th>
                    <th>อาการ</th>
                    <th>ความรุนแรง</th>
                    <th>หน่ายงานที่ให้ข้อมูล</th>
                    <th>ผู้บันทึก</th>
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
            <div class="btn-group">
                <a href="javascript:void(0);" class="btn btn-success" id="btn_new_drug_allergy">
                    <i class="fa fa-plus-circle"></i> เพิ่ม
                </a>
                <a href="javascript:void(0);" class="btn btn-default" id="btn_allergy_refresh">
                    <i class="fa fa-refresh"></i> รีเฟรช
                </a>
            </div>

        </div>

        <div class="tab-pane" id="tab_chronic">
            <table class="table table-striped" id="tbl_chronic_list">
                <thead>
                    <tr>
                        <th>รหัส</th>
                        <th>โรคเรื้อรัง</th>
                        <th>วันที่ตรวจพบ</th>
                        <th>สถานะ</th>
                        <th>วันจำหน่าย</th>
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
                    </tr>
                </tbody>
            </table>

            <div class="btn-group">
                <a href="javascript:void(0);" class="btn btn-success" id="btn_new_chronic">
                    <i class="fa fa-plus-circle"></i> เพิ่มรายการ
                </a>
                <a href="javascript:void(0);" class="btn btn-default" id="btn_refresh_chronic">
                    <i class="fa fa-refresh"></i> รีเฟรช
                </a>
            </div>

        </div>
    </div>
 <br>
 <br>
    <form action="#" id="frm_update_person">
        <div class="alert alert-success">
            <button type="button" id="btn_save_person" class="btn btn-success">
                <i class="icon-save"></i>
                ปรับปรุงข้อมูล
            </button>
            <button type="button" id="btn_back_to_home" class="btn btn-default">
                <i class="icon-home"></i>
                กลับหน้าหลัก
            </button>
        </div>
    </form>
    </div>

<!---->
<!--    <div class="modal hide fade" id="modal_search_dbpop">-->
<!--        <div class="modal-header">-->
<!--            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--            <h3>ค้นหาข้อมูลจาก DBPOP</h3>-->
<!--        </div>-->
<!--        <div class="modal-body">-->
<!--            <form action="#" class="form-inline form-actions">-->
<!--                <div class="control-group">-->
<!--                    <div class="controls">-->
<!--                        <label for="text_query_search_dbpop">เลขบัตรประชาชน</label>-->
<!--                        <div class="input-append">-->
<!--                            <input class="input-xlarge" placeholder="xxxxxxxxxxxxx" id="text_query_search_dbpop" type="text">-->
<!--                            <button class="btn btn-info" type="button" id="button_do_search_dbpop"><i class="icon-search"></i> ค้นหา</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </form>-->
<!--            <table class="table table-striped" id="table_search_dbpop_result_list">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th>เลขบัตรประชาชน</th>-->
<!--                    <th>ชื่อ - สกุล</th>-->
<!--                    <th>วันเกิด</th>-->
<!--                    <th>อายุ</th>-->
<!--                    <th>สิทธิการรักษา</th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody></tbody>-->
<!--            </table>-->
<!--        </div>-->
<!--        <div class="modal-footer">-->
<!--            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>-->
<!--        </div>-->
<!--    </div>-->

<!--    <div class="modal hide fade" id="modal_search_hospital">-->
<!--        <div class="modal-header">-->
<!--            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--            <h3>ค้นหาสถานบริการ</h3>-->
<!--        </div>-->
<!--        <div class="modal-body">-->
<!--            <form action="#" class="form-inline form-actions">-->
<!--                <input type="hidden" id="txt_search_by" />-->
<!--                <div class="control-group">-->
<!--                    <div class="controls">-->
<!--                        <label for="text_query_search_dbpop">ชื่อ/รหัส สถานบริการ</label>-->
<!--                        <div class="input-append">-->
<!--                            <input class="input-xlarge" placeholder="..." id="text_query_search_hospital" type="text">-->
<!--                            <button class="btn btn-info" type="button" id="btn_do_search_hospital"><i class="icon-search"></i> ค้นหา</button>-->
<!--                        </div>-->
<!---->
<!--                        <label class="checkbox inline">-->
<!--                            <input type="checkbox" id="chk_search_by_name" checked="checked"> ค้นจากชื่อ-->
<!--                        </label>-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--            </form>-->
<!--            <table class="table table-striped" id="table_search_hospital_result_list">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th>รหัส</th>-->
<!--                    <th>ชื่อสถานบริการ</th>-->
<!--                    <th>จังหวัด</th>-->
<!--                    <th></th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody></tbody>-->
<!--            </table>-->
<!--        </div>-->
<!--        <div class="modal-footer">-->
<!--            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>-->
<!--        </div>-->
<!--    </div>-->


<div class="modal fade" id="modal_search_drug_allergy">
    <div class="modal-dialog" style="width: 960px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">ข้อมูลการแพ้ยา</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
<!--                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>-->
            </div>
        </div>
    </div>
</div>
<!-- search chronic -->
<div class="modal fade" id="modal_search_chronic">
    <div class="modal-dialog" style="width: 960px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">ข้อมูลโรคเรื้อรัง</h4>
            </div>
            <div class="modal-body">
                <form action="#">
                    <input type="hidden" id="txt_chronic_isupdate">
                    <div class="row">
                        <div class="col-lg-2">
                            <label for="txt_date_record">วันที่พบครั้งแรก</label>
                            <input id="txt_chronic_date_diag" class="form-control" type="text" data-type="date" placeholder="dd/mm/yyyy" title="ระบุวันที่ พ.ศ">
                        </div>
                        <div class="col-lg-10">
                            <label for="txt_chronic_name">ชื่อโรค</label>
                            <input type="hidden" class="form-control" id="txt_chronic_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="txt_chronic_hosp_dx_name">สถานบริการวินิจฉัยครั้งแรก</label>
                            <input id="txt_chronic_hosp_dx_name" class="form-control" type="hidden">
                        </div>
                        <div class="col-lg-6">
                            <label for="txt_chronic_hosp_rx_name">สถานบริการประจำ</label>
                            <input id="txt_chronic_hosp_rx_name" class="form-control" type="hidden">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <label for="txt_chronic_date_disch">วันที่จำหน่าย</label>
                            <input id="txt_chronic_date_disch" class="form-control" type="text" data-type="date" placeholder="dd/mm/yyyy">
                        </div>
                        <div class="col-lg-6">
                            <label for="txt_chronic_hosp_rx_name">สถานะผู้ป่วย/จำหน่าย</label>
                            <select id="sl_chronic_dischage_type" class="form-control">
                                <option value="">-*-</option>
                                <?php foreach($chronic_discharge_types as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_save_chronic">
                    <i class="fa fa-save"></i> บันทึกรายการ
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-power-off"></i> ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>
</div>
<!-- /search chronic -->
<!-- <script type="text/javascript" src="{{ base_url }}assets/apps/js/apps.person.update.js"></script> -->
<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.person.update.js');
</script>