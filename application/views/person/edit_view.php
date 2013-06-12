    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
        <li><a href="<?php echo site_url('person');?>">ประชากรในเขต</a> <span class="divider">/</span></li>
        <li class="active">แก้ไขข้อมูล</li>
    </ul>

    <div class="alert alert-info">

        <strong>แก้ไขข้อมูล!</strong> กรุณาตรวจสอบข้อมูลให้ถูกต้อง และสมบูรณ์ก่อนทำการบันทึกข้อมูล
    </div>

    <input type="hidden" value="<?php echo $data->hn; ?>" id="hn">

    <div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tabPersonInfo" data-toggle="tab" id="btn_tab_person_info"><i class="icon-th-list"></i> ข้อมูลทั่วไป</a></li>
        <li><a href="#tabRight" data-toggle="tab" id="btn_tab_person_right"><i class="icon-folder-open"></i> สิทธิการรักษา</a></li>
        <li><a href="#tabOutsideAddress" data-toggle="tab" id="btn_tab_person_address"><i class="icon-edit"></i> ที่อยู่นอกเขต</a></li>
        <li><a href="#tab_drug_allergy" data-toggle="tab" id="btn_tab_drug_allergy"><i class="icon-warning-sign"></i> ข้อมูลการแพ้ยา</a></li>
        <li><a href="#tab_chronic" data-toggle="tab" id="btn_tab_chronic"><i class="icon-tags"></i> ข้อมูลโรคเรื้อรัง</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tabPersonInfo">
        <div class="span10">
        <div class="row-fluid">
            <div class="span4">
                <label>เลขบัตรประชาชน</label>
                <div class="input-append">
                    <input class="input-medium" id="txt_cid" type="text" value="<?php echo $data->cid; ?>" placeholder="xxxxxxxxxxxxx">
                    <input type="hidden" id="txt_old_cid" value="<?php echo $data->cid; ?>">
                    <button class="btn" type="button"><i class="icon-refresh"></i></button>
                    <button class="btn btn-info" type="button" id="btn_search_dbpop"><i class="icon-search"></i></button>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txt_passport">เลขที่ Passport</label>
                    <div class="controls">
                        <input type="text" id="txt_passport" value="<?php echo $data->passport; ?>" placeholder="เลขที่ Passport" class="input-medium">
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="slTitle">คำนำหน้า</label>
                    <div class="controls">
                        <select  id="slTitle" class="input-small">
                            <option value="">--</option>
                            <?php
                                foreach($titles as $t){
                                    if($t->id == $data->title) echo '<option value="'.$t->id.'" selected>'.$t->name.'</option>';
                                    else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txt_first_name">ชื่อ</label>
                    <div class="controls">
                        <input type="text" id="txt_first_name" value="<?= $data->first_name; ?>" placeholder="ชื่อ" class="input-medium">
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txt_last_name">สกุล</label>
                    <div class="controls">
                        <input type="text" id="txt_last_name" value="<?= $data->last_name; ?>" placeholder="สกุล" class="input-medium">
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_birth_date">วันเกิด</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txt_birth_date" value="<?= $data->birthdate; ?>" size="16" type="text" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="sl_sex">เพศ</label>
                    <div class="controls">
                        <select  id="sl_sex" class="input-small">
                            <?php if($data->sex == '1'){ ?>
                                <option value="1" selected>ชาย</option>
                                <option value="2">หญิง</option>
                            <?php }else{ ?>
                                <option value="1">ชาย</option>
                                <option value="2" selected>หญิง</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="slMStatus">สถานะสมรส</label>
                    <div class="controls">
                        <select  id="slMStatus" class="input-medium">
                            <option value="">--</option>
                            <?php
                                foreach($marry_status as $t){
                                    if($t->id == $data->mstatus) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                    else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span5">
                <div class="control-group">
                    <label class="control-label" for="slOccupation">อาชีพ</label>
                    <div class="controls">
                        <select  id="slOccupation" class="input-xlarge">
                            <option value="">--</option>
                            <?php
                            foreach($occupations as $t){
                                if($t->id == $data->occupation) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <label class="control-label" for="slEducation">การศึกษา</label>
                <div class="controls">
                    <select  id="slEducation" class="input-xlarge">
                        <option value="">--</option>
                        <?php
                        foreach($educations as $t){
                            if($t->id == $data->education) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                            else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="slNation">สัญชาติ</label>
                    <div class="controls">
                        <select  id="slNation" class="input-medium">
                            <option value="">--</option>
                            <?php
                            foreach($nationalities as $t){
                                if($t->id == $data->nation) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="slRace">เชื้อชาติ</label>
                    <div class="controls">
                        <select  id="slRace" class="input-medium">
                            <option value="">--</option>
                            <?php
                            foreach($races as $t){
                                if($t->id == $data->race) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="slReligion">ศาสนา</label>
                    <div class="controls">
                        <select  id="slReligion" class="input-medium">
                            <option value="">--</option>
                            <?php
                            foreach($religions as $t){
                                if($t->id == $data->religion) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="slFstatus">สถานะในครอบครัว</label>
                    <div class="controls">
                        <select  id="slFstatus" class="input-medium">
                            <?php if($data->fstatus == '1'){ ?>
                                <option value="1" selected>เจ้าบ้าน</option>
                                <option value="2">ผู้อาศัย</option>
                            <?php }else{ ?>
                                <option value="1">เจ้าบ้าน</option>
                                <option value="2" selected>ผู้อาศัย</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="slVstatus">สถานะในชุมชน</label>
                    <div class="controls">
                        <select  id="slVstatus" class="input-medium">
                            <option value="">--</option>
                            <?php
                            foreach($vstatus as $t){
                                if($t->id == $data->vstatus) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txtFatherCid">CID บิดา</label>
                    <div class="controls">
                        <input type="text" id="txtFatherCid" value="<?= $data->father_cid; ?>" placeholder="xxxxxxxxxxxxx" class="input-medium">
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txtMotherCid">CID มารดา</label>
                    <div class="controls">
                        <input type="text" id="txtMotherCid" value="<?= $data->mother_cid; ?>" placeholder="xxxxxxxxxxxxx" class="input-medium">
                    </div>
                </div>
            </div>

            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txtCoupleCid">CID คู่สมรส</label>
                    <div class="controls">
                        <input type="text" id="txtCoupleCid" value="<?= $data->couple_cid;?>" placeholder="xxxxxxxxxxxxx" class="input-medium">
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txtMoveInDate">วันย้ายเข้า</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" value="<?= $data->movein_date; ?>" id="txtMoveInDate" size="16" type="text" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txtDischargeDate">วันที่จำหน่าย</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" value="<?= $data->discharge_date; ?>" id="txtDischargeDate" size="16" type="text" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="slDischarge">สถานะการจำหน่าย</label>
                    <div class="controls">
                        <select  id="slDischarge" class="input-medium">
                            <?php if($data->discharge_status == '3'){ ?>
                                <option value="9">ไม่จำหน่าย</option>
                                <option value="1">ตาย</option>
                                <option value="2">ย้าย</option>
                                <option value="3" selected>สาบสูญ</option>
                            <?php }else if($data->discharge_status == '1'){ ?>
                                <option value="9">ไม่จำหน่าย</option>
                                <option value="1" selected>ตาย</option>
                                <option value="2">ย้าย</option>
                                <option value="3">สาบสูญ</option>
                            <?php }else if($data->discharge_status == '2'){ ?>
                                <option value="9">ไม่จำหน่าย</option>
                                <option value="1">ตาย</option>
                                <option value="2" selected>ย้าย</option>
                                <option value="3">สาบสูญ</option>
                            <?php }else{ ?>
                                <option value="9" selected>ไม่จำหน่าย</option>
                                <option value="1">ตาย</option>
                                <option value="2">ย้าย</option>
                                <option value="3">สาบสูญ</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="slABOGroup">หมู่เลือด</label>
                    <div class="controls">
                        <select  id="slABOGroup" class="input-small">
                            <?php if($data->abogroup == '1'){ ?>
                            <option value="">--</option>
                            <option value="1" selected>A</option>
                            <option value="2">B</option>
                            <option value="3">AB</option>
                            <option value="4">O</option>
                            <?php }else if($data->abogroup == '2'){ ?>
                                <option value="">--</option>
                                <option value="1">A</option>
                                <option value="2" selected>B</option>
                                <option value="3">AB</option>
                                <option value="4">O</option>
                            <?php }else if($data->abogroup == '3'){ ?>
                                <option value="">--</option>
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3" selected>AB</option>
                                <option value="4">O</option>
                            <?php }else if($data->abogroup == '4'){ ?>
                                <option value="">--</option>
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">AB</option>
                                <option value="4" selected>O</option>
                            <?php }else{ ?>
                                <option value="" selected>--</option>
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">AB</option>
                                <option value="4">O</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="slRHGroup">หมู่เลือด RH</label>
                    <div class="controls">
                        <select  id="slRHGroup" class="input-small">
                            <?php if($data->rhgroup == '1'){ ?>
                            <option value="">--</option>
                            <option value="1" selected>Positive</option>
                            <option value="2">Negative</option>
                            <?php }else if($data->rhgroup == '2'){ ?>
                            <option value="">--</option>
                            <option value="1">Positive</option>
                            <option value="2" selected>Negative</option>
                            <?php }else{ ?>
                            <option value="" selected>--</option>
                            <option value="1">Positive</option>
                            <option value="2">Negative</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="slLabor">คนต่างด้าว</label>
                    <div class="controls">
                        <select  id="slLabor" class="input-xlarge">
                            <option value="">--</option>
                            <?php
                            foreach($labor_types as $t){
                                if($t->id == $data->labor_type) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                else echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="slTypeArea">ประเภทบุคคล</label>
                    <div class="controls">
                        <select  id="slTypeArea" class="input-xxlarge">
                            <option value="">--</option>
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
        </div>
        </div>

        </div>
        <div class="tab-pane" id="tabRight">
            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="sl_inscl_type">ประเภทสิทธิการรักษา</label>
                    <div class="controls">
                        <select name="slInstype" id="sl_inscl_type" class="input-xlarge">
                            <option value="">--</option>
                            <?php
                            foreach($inscls as $t){
                                if($t->code == $data->ins_id) echo '<option value="'.$t->code.'" selected="selected">'.$t->name.'</option>';
                                else echo '<option value="'.$t->code.'">'.$t->name.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="txt_inscl_code">รหัสสิทธิ</label>
                    <div class="controls">
                        <input type="text" id="txt_inscl_code" value="<?= $data->ins_code; ?>" placeholder="รหัสสิทธิการรักษา">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="txtInsStartDate">วันออกบัตร</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txtInsStartDate" size="16" value="<?= $data->ins_start_date; ?>" type="text" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="txtInsExpireDate">วันหมดอายุ</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txtInsExpireDate" size="16" type="text" value="<?= $data->ins_expire_date; ?>" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="txt_ins_hospmain_name">สถานบริการหลัก</label>
                    <div class="controls">
                        <div class="input-append">
                            <input class="input-xlarge" id="txt_ins_hospmain_name" value="<?= $data->ins_hmain_name; ?>" disabled type="text">
                            <input type="hidden" id="txt_ins_hospmain_code" value="<?= $data->ins_hmain_code; ?>">
                            <button class="btn" type="button" id="btn_search_hospital_main">
                                <i class="icon-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="txt_ins_hospsub_name">สถานบริการรอง</label>
                    <div class="controls">
                        <div class="input-append">
                            <input class="input-xlarge" id="txt_ins_hospsub_name" value="<?= $data->ins_hsub_name; ?>" disabled type="text">
                            <input type="hidden" id="txt_ins_hospsub_code" value="<?= $data->ins_hsub_code; ?>" />
                            <button class="btn" type="button" id="btn_search_hospital_sub">
                                <i class="icon-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="tabOutsideAddress">
            <form action="#" class="form-horizontal">
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="slOutsiedAddressType">ประเภท</label>
                            <div class="controls">
                                <select id="slOutsiedAddressType">
                                    <?php if($data->address_address_type == '1') { ?>
                                        <option value="1" selected="selected">ที่อยู่ตามทะเบียนบ้าน</option>
                                        <option value="2">ที่อยู่ที่ติดต่อได้</option>
                                    <?php }else if($data->address_address_type == '2') { ?>
                                        <option value="1">ที่อยู่ตามทะเบียนบ้าน</option>
                                        <option value="2" selected="selected">ที่อยู่ที่ติดต่อได้</option>
                                    <?php }else{ ?>
                                        <option value="1">ที่อยู่ตามทะเบียนบ้าน</option>
                                        <option value="2" selected="selected">ที่อยู่ที่ติดต่อได้</>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="slOutsiedHouseType">ลักษณะที่อยู่</label>
                            <div class="controls">
                                <select id="slOutsiedHouseType">
                                    <option value="">--</option>
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
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideHouseId">รหัสบ้าน</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideHouseId" value="<?php echo $data->address_house_id; ?>" placeholder="ตามกรมการปกครอง">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideRoomNumber">เลขห้อง</label>
                            <div class="controls">
                                <input type="text" value="<?= $data->address_room_no; ?>" id="txtOutsideRoomNumber">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideCondo">ชื่ออาคารชุด</label>
                            <div class="controls">
                                <input type="text" value="<?= $data->address_condo; ?>" id="txtOutsideCondo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideAddressNumber">บ้านเลขที่</label>
                            <div class="controls">
                                <input type="text" value="<?= $data->address_houseno; ?>" id="txtOutsideAddressNumber">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideSoiSub">ซอยแยก</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideSoiSub" value="<?= $data->address_soi_sub; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideSoiMain">ซอยหลัก</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideSoiMain" value="<?= $data->address_soi_main; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideRoad">ถนน</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideRoad" value="<?= $data->address_road; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideVillageName">บ้านจัดสรร</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideVillageName" value="<?= $data->address_village_name; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="slOutsideVillage">หมู่ที่</label>
                            <div class="controls">
                                <select id="slOutsideVillage">
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
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="slOutsideProvince">จังหวัด</label>
                            <div class="controls">
                                <select id="slOutsideProvince">
                                    <option value="">--</option>
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
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="slOutsideAmpur">อำเภอ</label>
                            <div class="controls">
                                <select id="slOutsideAmpur">
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
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="slOutsideTambon">ตำบล</label>
                            <div class="controls">
                                <select id="slOutsideTambon">
                                    <option value="">--</option>.<?php
                                    foreach($tambons as $t){
                                        if($t->code == $data->address_tambon) echo '<option value="'.$t->code.'" selected="selected">'.$t->name.'</option>';
                                        else echo '<option value="'.$t->code.'">'.$t->name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsidePostcode">รหัสไปรษณีย์</label>
                            <div class="controls">
                                <input type="text" id="txtOutsidePostcode" value="<?= $data->address_postcode; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideTelephone">โทรศัพท์</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideTelephone" value="<?= $data->address_telephone; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideMobile">โทรศัพท์มือถือ</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideMobile" value="<?= $data->address_mobile; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="tab_drug_allergy">
            <div class="alert alert-warning">

                <strong>หมายเหตุ!</strong> เมื่อได้ทำการบันทึกข้อมูลการแพ้ยาแล้วโปรแกรมจะบันทึกข้อมูลลงในฐานให้ทันที
            </div>
            <table class="table table-striped table-hover" id="tbl_drug_allergy_list">
                <thead>
                <tr>
                    <th>วันที่แพ้</th>
                    <th>รหัสยา</th>
                    <th>ชื่อยา</th>
                    <th>ประเภทการวินิจฉัย</th>
                    <th>ระดับความรุนแรง</th>
                    <th>ลักษณะอาการแพ้ยาที่พบ</th>
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
            <a href="javascript:void(0);" class="btn btn-success" id="btn_new_drug_allergy"><i class="icon-plus-sign"></i> เพิ่มรายการ</a>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                    </tr>
                </tbody>
            </table>

            <a href="javascript:void(0);" class="btn btn-success" id="btn_new_chronic"><i class="icon-plus-sign"></i> เพิ่มรายการ</a>
        </div>
    </div>

    <form action="#" id="frm_update_person">
        <div class="alert alert-info">
            <button type="button" id="btn_save_person" class="btn btn-success btn-large">
                <i class="icon-save"></i>
                ปรับปรุงข้อมูล
            </button>
            <button type="button" id="btn_back_to_home" class="btn btn-large">
                <i class="icon-home"></i>
                กลับหน้าหลัก
            </button>
        </div>
    </form>
    </div>


    <div class="modal hide fade" id="modal_search_dbpop">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>ค้นหาข้อมูลจาก DBPOP</h3>
        </div>
        <div class="modal-body">
            <form action="#" class="form-inline form-actions">
                <div class="control-group">
                    <div class="controls">
                        <label for="text_query_search_dbpop">เลขบัตรประชาชน</label>
                        <div class="input-append">
                            <input class="input-xlarge" placeholder="xxxxxxxxxxxxx" id="text_query_search_dbpop" type="text">
                            <button class="btn btn-info" type="button" id="button_do_search_dbpop"><i class="icon-search"></i> ค้นหา</button>
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-striped" id="table_search_dbpop_result_list">
                <thead>
                <tr>
                    <th>เลขบัตรประชาชน</th>
                    <th>ชื่อ - สกุล</th>
                    <th>วันเกิด</th>
                    <th>อายุ</th>
                    <th>สิทธิการรักษา</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
        </div>
    </div>

    <div class="modal hide fade" id="modal_search_hospital">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>ค้นหาสถานบริการ</h3>
        </div>
        <div class="modal-body">
            <form action="#" class="form-inline form-actions">
                <input type="hidden" id="txt_search_by" />
                <div class="control-group">
                    <div class="controls">
                        <label for="text_query_search_dbpop">ชื่อ/รหัส สถานบริการ</label>
                        <div class="input-append">
                            <input class="input-xlarge" placeholder="..." id="text_query_search_hospital" type="text">
                            <button class="btn btn-info" type="button" id="btn_do_search_hospital"><i class="icon-search"></i> ค้นหา</button>
                        </div>

                        <label class="checkbox inline">
                            <input type="checkbox" id="chk_search_by_name" checked="checked"> ค้นจากชื่อ
                        </label>

                    </div>
                </div>
            </form>
            <table class="table table-striped" id="table_search_hospital_result_list">
                <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อสถานบริการ</th>
                    <th>จังหวัด</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
        </div>
    </div>


<div class="modal hide fade" id="modal_search_drug_allergy">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ข้อมูลการแพ้ยา</h3>
    </div>
    <div class="modal-body">
        <form action="#">
            <input type="hidden" id="txt_drug_isupdate">
            <div class="row-fluid">
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="txt_date_record">วันที่รายงาน</label>
                        <div class="controls">
                            <div class="input-append date" data-name="datepicker">
                                <input class="input-small" id="txt_date_record" type="text" disabled>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="txt_drug_name">ยาที่แพ้</label>
                        <div class="controls">
                            <input type="hidden" id="txt_drug_code">
                            <input type="text" class="input-xxlarge" id="txt_drug_name" placeholder="...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="sl_type_diag">การวินิจฉัย</label>
                        <div class="controls">
                            <select id="sl_type_diag" class="input-xlarge">
                                <option value="">--</option>
                                <?php
                                    foreach($drug_allergy_diag_types as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="sl_drug_allergy_alevel">ความรุนแรง</label>
                        <div class="controls">
                            <select id="sl_drug_allergy_alevel" class="input-xlarge">
                                <option value="">--</option>
                                <?php foreach($drug_allergy_alevels as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="sl_drug_allergy_symptom">อาการแพ้</label>
                        <div class="controls">
                            <select id="sl_drug_allergy_symptom" class="input-xlarge">
                                <option value="">--</option>
                                <?php foreach($drug_allergy_symptoms as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="sl_drug_allergy_informant">ผู้ให้ประวัติ</label>
                        <div class="controls">
                            <select id="sl_drug_allergy_informant" class="input-xlarge">
                                <option value="">--</option>
                                <?php foreach($drug_allergy_informants as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="control-group">
                        <label class="control-label" for="sl_drug_allergy_symptom">หน่วยงานที่ให้ข้อมูล</label>
                        <div class="controls">
                            <div class="input-append">
                                <input class="input-xxlarge" id="txt_drug_allergy_hosp_name" type="text">
                                <input type="hidden" id="txt_drug_allergy_hosp_code">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn_save_drug_allergy"><i class="icon-save"></i> บันทึกรายการ</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
    </div>
</div>
    <!-- search chronic -->
    <div class="modal hide fade" id="modal_search_chronic">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>ข้อมูลโรคเรื้อรัง</h3>
        </div>
        <div class="modal-body">
            <form action="#">
                <input type="hidden" id="txt_chronic_isupdate">
                <div class="row-fluid">
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_date_record">วันที่ตรวจพบครั้งแรก</label>
                            <div class="controls">
                                <div class="input-append date" data-name="datepicker">
                                    <input class="input-small" id="txt_chronic_date_diag" type="text" disabled>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_drug_name">รหัส</label>
                            <div class="controls">
                                <input type="text" disabled class="input-mini uneditable-input" id="txt_chronic_code" placeholder="...">
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="txt_chronic_name">ชื่อโรค</label>
                            <div class="controls">
                                <input type="text" class="input-xxlarge" id="txt_chronic_name" placeholder="พิมพ์ชื่อ หรือ รหัส...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="txt_chronic_hosp_dx_name">สถานบริการวินิจฉัยครั้งแรก</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input class="input-xlarge" id="txt_chronic_hosp_dx_name" type="text" placeholder="พิมพ์ชื่อหรือรหัส สถานบริการ">
                                    <input type="hidden" id="txt_chronic_hosp_dx_code">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="txt_chronic_hosp_rx_name">สถานบริการประจำ</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input class="input-xlarge" id="txt_chronic_hosp_rx_name" type="text" placeholder="พิมพ์ชื่อหรือรหัส สถานบริการ">
                                    <input type="hidden" id="txt_chronic_hosp_rx_code">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_chronic_date_disch">วันที่จำหน่าย</label>
                            <div class="controls">
                                <div class="input-append date" data-name="datepicker">
                                    <input class="input-small" id="txt_chronic_date_disch" type="text" disabled>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="txt_chronic_hosp_rx_name">สถานะผู้ป่วย/จำหน่าย</label>
                            <div class="controls">
                                <select id="sl_chronic_dischage_type" class="input-xlarge">
                                    <option value="">--</option>
                                    <?php foreach($chronic_discharge_types as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn_save_chronic"><i class="icon-save"></i> บันทึกรายการ</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
        </div>
    </div>
    <!-- /search chronic -->
    <!-- <script type="text/javascript" src="{{ base_url }}assets/apps/js/apps.person.update.js"></script> -->
    <script type="text/javascript">
        head.js('<?php echo base_url(); ?>assets/apps/js/apps.person.update.js');
    </script>