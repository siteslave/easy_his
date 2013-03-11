<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('person');?>">ประชากรในเขต</a> <span class="divider">/</span></li>
    <li class="active">เพิ่มคนในบ้าน</li>
</ul>

<blockquote>
    เพิ่มคนในบ้าน ที่อยู่ในเขตรับผิดชอบ
</blockquote>

<input type="hidden" value="<?php echo $house_id; ?>" id="house_code">

<div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tabPersonInfo" data-toggle="tab"><i class="icon-th-list"></i> ข้อมูลทั่วไป</a></li>
        <li><a href="#tabRight" data-toggle="tab"><i class="icon-folder-open"></i> สิทธิการรักษา</a></li>
        <li><a href="#tabOutsideAddress" data-toggle="tab"><i class="icon-edit"></i> ที่อยู่นอกเขต</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tabPersonInfo">
            <div class="span10">
                <div class="row-fluid">
                    <div class="span4">
                        <label>เลขบัตรประชาชน</label>
                        <div class="input-append">
                            <input class="input-medium" id="txt_cid" type="text" placeholder="xxxxxxxxxxxxx">
                            <button class="btn" type="button"><i class="icon-refresh"></i></button>
                            <button class="btn btn-info" type="button" id="btn_search_dbpop"><i class="icon-search"></i></button>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_passport">เลขที่ Passport</label>
                            <div class="controls">
                                <input type="text" id="txt_passport" placeholder="เลขที่ Passport" class="input-medium">
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
                                    <?php foreach($titles as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_first_name">ชื่อ</label>
                            <div class="controls">
                                <input type="text" id="txt_first_name" placeholder="ชื่อ" class="input-medium">
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_last_name">สกุล</label>
                            <div class="controls">
                                <input type="text" id="txt_last_name" placeholder="สกุล" class="input-medium">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_birth_date">วันเกิด</label>
                            <div class="controls">
                                <div class="input-append date" data-name="datepicker">
                                    <input class="input-small" id="txt_birth_date" size="16" type="text" disabled>
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
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
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
                                    <?php foreach($marry_statuses as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
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
                                    <?php foreach($occupations as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <label class="control-label" for="slEducation">การศึกษา</label>
                        <div class="controls">
                            <select  id="slEducation" class="input-xlarge">
                                <option value="">--</option>
                                <?php foreach($educations as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
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
                                    <?php foreach($nationalities as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
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
                                    <?php foreach($races as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
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
                                    <?php foreach($religions as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="slFstatus">สถานะในครอบครัว</label>
                            <div class="controls">
                                <select  id="slFstatus" class="input-medium">
                                    <option value="2">ผู้อาศัย</option>
                                    <option value="1">เจ้าบ้าน</option>
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
                                    <?php foreach($vstatus as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txtFatherCid">CID บิดา</label>
                            <div class="controls">
                                <input type="text" id="txtFatherCid" placeholder="xxxxxxxxxxxxx" class="input-medium">
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txtMotherCid">CID มารดา</label>
                            <div class="controls">
                                <input type="text" id="txtMotherCid" placeholder="xxxxxxxxxxxxx" class="input-medium">
                            </div>
                        </div>
                    </div>

                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txtCoupleCid">CID คู่สมรส</label>
                            <div class="controls">
                                <input type="text" id="txtCoupleCid" placeholder="xxxxxxxxxxxxx" class="input-medium">
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
                                    <input class="input-small" id="txtMoveInDate" size="16" type="text" disabled>
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
                                    <input class="input-small" id="txtDischargeDate" size="16" type="text" disabled>
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
                                    <option value="9">ไม่จำหน่าย</option>
                                    <option value="1">ตาย</option>
                                    <option value="2">ย้าย</option>
                                    <option value="3">สาบสูญ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="slABOGroup">หมู่เลือด</label>
                            <div class="controls">
                                <select  id="slABOGroup" class="input-small">
                                    <option value="">--</option>
                                    <option value="1">A</option>
                                    <option value="2">B</option>
                                    <option value="3">AB</option>
                                    <option value="4">O</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="slRHGroup">หมู่เลือด RH</label>
                            <div class="controls">
                                <select  id="slRHGroup" class="input-small">
                                    <option value="1">Positive</option>
                                    <option value="2">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="slTypeArea">คนต่างด้าว</label>
                            <div class="controls">
                                <select  id="slLabor" class="input-xlarge">
                                    <option value="">--</option>
                                    <?php foreach($labor_types as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
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
                                    <?php foreach($typearea as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
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
                            <?php foreach($inscls as $t) echo '<option value="'.$t->code.'">['.$t->code.'] '.$t->name.'</option>'; ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="txt_inscl_code">รหัสสิทธิ</label>
                    <div class="controls">
                        <input type="text" id="txt_inscl_code" placeholder="รหัสสิทธิการรักษา">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="txtInsStartDate">วันออกบัตร</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txtInsStartDate" size="16" type="text" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="txtInsExpireDate">วันหมดอายุ</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txtInsExpireDate" size="16" type="text" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="txt_ins_hospmain_name">สถานบริการหลัก</label>
                    <div class="controls">
                        <div class="input-append">
                            <input class="input-xlarge" id="txt_ins_hospmain_name" disabled type="text">
                            <input type="hidden" id="txt_ins_hospmain_code">
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
                            <input class="input-xlarge" id="txt_ins_hospsub_name" disabled type="text">
                            <input type="hidden" id="txt_ins_hospsub_code" />
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
                                    <option value="1">ที่อยู่ตามทะเบียนบ้าน</option>
                                    <option value="2">ที่อยู่ที่ติดต่อได้</option>
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
                                    <?php foreach($house_type as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideHouseId">รหัสบ้าน</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideHouseId" placeholder="ตามกรมการปกครอง">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideRoomNumber">เลขห้อง</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideRoomNumber">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideCondo">ชื่ออาคารชุด</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideCondo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideAddressNumber">บ้านเลขที่</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideAddressNumber">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideSoiSub">ซอยแยก</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideSoiSub">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideSoiMain">ซอยหลัก</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideSoiMain">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideRoad">ถนน</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideRoad">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideVillageName">บ้านจัดสรร</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideVillageName">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="slOutsideVillage">หมู่ที่</label>
                            <div class="controls">
                                <select id="slOutsideVillage">
                                    <?php for($i=0; $i>=30; $i++){ echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
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
                                    <?php foreach($provinces as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                        <label class="control-label" for="slOutsideAmpur">อำเภอ</label>
                        <div class="controls">
                            <select id="slOutsideAmpur">
                                <option value=""></option>
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
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsidePostcode">รหัสไปรษณีย์</label>
                            <div class="controls">
                                <input type="text" id="txtOutsidePostcode">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideTelephone">โทรศัพท์</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideTelephone">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtOutsideMobile">โทรศัพท์มือถือ</label>
                            <div class="controls">
                                <input type="text" id="txtOutsideMobile">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

<form action="#" class="form-actions">
    <button type="button" id="btn_save_person" class="btn btn-success btn-large">
        <i class="icon-plus-sign"></i>
        เพิ่มคนในบ้าน
    </button>
    <button type="button" id="btn_clear_person" class="btn btn-large">
        <i class="icon-refresh"></i>
        เคลียร์ข้อมูล
    </button>
</form>
</div>


<div class="modal hide fade" id="modal_search_dbpop">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ค้นหาข้อมูลจาก DBPOP</h3>
    </div>
    <div class="modal-body">
        <form action="#" class="form-inline form-actions">
            <input type="hidden" id="txt_dbpop_search_by">
            <div class="control-group">
                <div class="controls">
                    <label for="text_query_search_dbpop">เลขบัตรประชาชน</label>
                    <div class="input-append">
                        <input class="input-xlarge" placeholder="xxxxxxxxxxxxx" id="text_query_search_dbpop" type="text">
                        <div class="btn-group">
                            <button class="btn btn-info" tabindex="-1" type="button" id="button_do_search_dbpop"><i class="icon-search"></i> ค้นหา</button>
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" id="btn_dbpop_search_by_cid"><i class="icon-barcode"></i> ค้นจากเลขบัตรประชาชน</a></li>
                                <li><a href="javascript:void(0);" id="btn_dbpop_search_by_name"><i class="icon-list"></i> ค้นจากชื่อ-สกุล</a></li>
                            </ul>
                        </div>

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
<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.person.register.js');
</script>
