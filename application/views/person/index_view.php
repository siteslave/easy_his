    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
        <li class="active">ประชากรในเขต</li>
    </ul>

    <div class="row-fluid">
        <div class="span6">
            <div class="row-fluid">
                <div class="span12">
                    <div class="page-header">
                        <p class="lead">หมู่บ้านในเขตรับผิดชอบ</p>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12" style="max-height: 640px; display: block; overflow: auto">
                    <table class="table table-striped table-hover" id="tblVillageList">
                        <thead>
                        <tr>
                            <th>รหัสหมู่บ้าน</th>
                            <th>หมู่ที่</th>
                            <th>ชื่อหมู่บ้าน</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>...</td>
                            <td>...</td>
                            <td>...</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="span6">
            <div class="row-fluid">
                <div class="span12">
                    <div class="page-header">
                        <p class="lead">หลังคาเรือนในหมู่บ้าน <span id="vMooName"> เลือกหมู่บ้าน </span></p>
                        <input type="hidden" id="village_id">
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12" style="max-height: 640px; display: block; overflow: auto">
                    <table class="table table-striped table-hover" id="tbl_houses_list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัสบ้าน</th>
                            <th>บ้านเลขที่</th>
                            <th>จำนวน (คน)</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="5">เลือกหมู่บ้านที่ต้อง (ซ้ายมือ)</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <br />
            <button type="button" style="display: none;" class="btn btn-success pull-right" id="btnShowModalNewHouse">
                <i class="icon-plus-sign icon-white"></i> เพิ่มบ้าน
            </button>
        </div>
    </div>
    <div id="showPersonList"></div>

    <!-- modal new house -->
    <div class="modal hide fade" id="mdlNewHouse">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>เพิ่มบ้านใหม่</h3>
        </div>
        <div class="modal-body">
            <div class="alert alert-info" id="alert_save_house">
                <strong>คำแนะนำ!</strong> <span>กรุณากรอกข้อมูลให้ครบ</span>
            </div>
            <form action="#">
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtAddress">บ้านเลขที่</label>
                            <div class="controls">
                                <input type="text" id="txtAddress" placeholder="บ้านเลขที่">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtHouseCode">รหัสบ้าน (กรมการปกครอง)</label>
                            <div class="controls">
                                <input type="text" id="txtHouseCode" placeholder="รหัสบ้าน">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="slHouseType">ประเภทที่อยู่</label>
                            <div class="controls">
                                <select id="slHouseType">
                                    <option value="1">บ้านเดียว บ้านแฝด</option>
                                    <option value="2">ทาวน์เฮาส์ ทาวน์โฮม</option>
                                    <option value="3">คอนโดมิเนียม</option>
                                    <option value="4">อพาร์ทเมนท์ หอพัก</option>
                                    <option value="5">บ้านพักคนงาน</option>
                                    <option value="6">อื่นๆ</option>
                                    <option value="7">ไม่ทราบ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtRoomNo">เลขห้อง</label>
                            <div class="controls">
                                <input type="text" id="txtRoomNo" placeholder="เลขห้อง">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtSoiSub">ซอยแยก</label>
                            <div class="controls">
                                <input type="text" id="txtSoiSub" placeholder="ซอยแยก">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtSoiMain">ซอยหลัก</label>
                            <div class="controls">
                                <input type="text" id="txtSoiMain" placeholder="ซอยหลัก">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">

                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtCondo">ชื่ออาคารชุด</label>
                            <div class="controls">
                                <input type="text" id="txtCondo" placeholder="ชื่ออาคารชุด">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtVillageName">ชื่อหมู่บ้านจัดสรร</label>
                            <div class="controls">
                                <input type="text" id="txtVillageName" placeholder="ชื่อหมู่บ้านจัดสรร">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txtRoad">ถนน</label>
                            <div class="controls">
                                <input type="text" id="txtRoad" placeholder="ถนน">
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn_do_save_house"><i class="icon-plus-sign icon-white"></i> บันทึกบ้าน</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</button>
        </div>
    </div>
    <!-- end modal new house -->
    <!-- show person list -->
    <div class="modal hide fade" id="mdl_show_person_list">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>ข้อมูลคนในบ้าน</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span12">
                    <input type="hidden" id="txtHouseId">
                    <p class="lead">ประชากรในบ้านเลขที่ :  <span class="badge badge-success" id="txt_show_house_address"></span></p>
                    <table class="table table-striped table-hover" id="tbl_person_in_house">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>HN</th>
                            <th>เลขบัตรประชาชน</th>
                            <th>คำนำ</th>
                            <th>ชื่อ - สกุล</th>
                            <th>วันเกิด</th>
                            <th>อายุ</th>
                            <th>เพศ</th>
                            <th>สถานะในครอบครัว</th>
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
                            <td>...</td>
                            <td>...</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="btn-group">
                        <button class="btn btn-info"><i class="icon-search icon-white"></i> ค้นหา</button>
                        <button class="btn btn-success" id="btnNewPerson"><i class="icon-plus-sign icon-white"></i> เพิ่มคนในบ้าน</button>
                        <button class="btn btn-inverse"><i class="icon-print icon-white"></i> พิมพ์รายชื่อ</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</button>
        </div>
    </div>
    <!-- /show person list -->

    <!-- modal house survey -->
    <div class="modal hide fade" id="mdlHouseSurvey">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>สำรวจข้อมูลบ้าน</h3>
    </div>
    <div class="modal-body">
    <form action="#">
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group">
                <label class="control-label" for="sl_locatype">ที่ตั้ง</label>
                <div class="controls">
                    <select id="sl_locatype">
                        <option value="1">ในเขตเทศบาล</option>
                        <option value="2">นอกเขตเทศบาล</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class="control-group">
                <label class="control-label" for="txt_house_latitude">ละติจูด</label>
                <div class="controls">
                    <input type="text" id="txt_house_latitude" placeholder="ละติจูด">
                </div>
            </div>
        </div>
        <div class="span4">
            <div class="control-group">
                <label class="control-label" for="txt_house_longitude">ลองจิจูด</label>
                <div class="controls">
                    <input type="text" id="txt_house_longitude" placeholder="ลองจิจูด">
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <div class="input-append">
                <label>อสม. ประจำบ้าน</label>
                <input type="hidden" id="txt_vhvid">
                <input class="input-xlarge uneditable-input" id="txt_vhvid_cid" type="text">
                <button class="btn btn-info" type="button"><i class="icon-search icon-white"></i></button>
            </div>
        </div>
        <div class="span6">
            <div class="input-append">
                <label>เจ้าบ้าน</label>
                <input type="hidden" id="txt_headid">
                <input class="input-xlarge uneditable-input" id="txt_headid_cid" type="text">
                <button class="btn btn-info" type="button"><i class="icon-search icon-white"></i></button>
            </div>
        </div>
    </div>
    <legend>ข้อมูลสำรวจ</legend>
    <div class="row-fluid">
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_toilet">การมีส้วม</label>
                <div class="controls">
                    <select id="sl_toilet" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="0">ไม่มี</option>
                        <option value="1">มี</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_water">น้ำดื่มเพียงพอ</label>
                <div class="controls">
                    <select id="sl_water" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="0">ไม่เพียงพอ</option>
                        <option value="1">เพียงพอ</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_watertype">ประเภทแหล่งน้ำ</label>
                <div class="controls">
                    <select id="sl_watertype" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="1">น้ำฝน</option>
                        <option value="2">น้ำประปา</option>
                        <option value="3">น้ำบาดาล</option>
                        <option value="4">บ่อน้ำตื้น</option>
                        <option value="5">สระน้ำ แม่น้ำ</option>
                        <option value="6">น้ำบรรจุเสร็จ</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_garbage">วิธีกำจัดขยะ</label>
                <div class="controls">
                    <select id="sl_garbage" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="1">ฝัง</option>
                        <option value="2">เผา</option>
                        <option value="3">หมักทำปุ๋ย</option>
                        <option value="4">ส่งไปกำจัดที่อื่น</option>

                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_housing">การจัดบ้านถูกหลัก</label>
                <div class="controls">
                    <select id="sl_housing" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="0">ไม่ถูก</option>
                        <option value="1">ถูก</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_durability">ความคงทน</label>
                <div class="controls">
                    <select id="sl_durability" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="1">คงทน 1-4 ปี</option>
                        <option value="2">คงทน 5 ปีขึ้นไป</option>
                        <option value="3">ไม่คงทน</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_cleanliness">ความสะอาด</label>
                <div class="controls">
                    <select id="sl_cleanliness" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="1">ไม่สะอาด</option>
                        <option value="2">สะอาด</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_ventilation">การระบายอากาศ</label>
                <div class="controls">
                    <select id="sl_ventilation" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="0">ไม่ระบาย</option>
                        <option value="1">ระบาย</option>

                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_light">แสงสว่าง</label>
                <div class="controls">
                    <select id="sl_light" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="0">ไม่เพียงพอ</option>
                        <option value="1">เพียงพอ</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_watertm">การกำจัดน้ำเสีย</label>
                <div class="controls">
                    <select id="sl_watertm" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="1">ไม่กำจัด</option>
                        <option value="2">กำจัด</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_mfood">สารปรุงแต่ง</label>
                <div class="controls">
                    <select id="sl_mfood" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="1">ไม่ใช้</option>
                        <option value="2">ใช้</option>>

                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_bcontrol">การควบคุมแมลง</label>
                <div class="controls">
                    <select id="sl_bcontrol" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="0">ไม่ควบคุม</option>
                        <option value="1">ควบคุม</option>

                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_acontrol">การควบคุมสัตว์</label>
                <div class="controls">
                    <select id="sl_acontrol" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="0">ไม่ควบคุม</option>
                        <option value="1">ควบคุม</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_chemical">การจัดเก็บสารเคมี</label>
                <div class="controls">
                    <select id="sl_chemical" class="input-medium">
                        <option value="9">ไม่ทราบ</option>
                        <option value="1">ไม่มี</option>
                        <option value="2">มี</option>

                    </select>
                </div>
            </div>
        </div>
    </div>
    </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn_save_house_seruvey"><i class="icon-plus-sign icon-white"></i> บันทึก</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</button>
    </div>
    </div>
    <!-- end modal survey -->

    <!-- modal person -->
    <div class="modal hide fade" id="mdlPersonDetail">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ข้อมูลบุคคล</h3>
    </div>
    <div class="modal-body">
    <form action="#">
    <div class="row-fluid">
        <div class="span4">
            <label>เลขบัตรประชาชน</label>
            <div class="input-append">
                <input class="input-medium" id="txtCID" type="text" placeholder="xxxxxxxxxxxxx">
                <button class="btn" type="button"><i class="icon-refresh"></i></button>
                <button class="btn btn-info" type="button"><i class="icon-search icon-white"></i></button>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="txtPassport">เลขที่ Passport</label>
                <div class="controls">
                    <input type="text" id="txtPassport" placeholder="เลขที่ Passport" class="input-medium">
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <div class="control-group">
                <label class="control-label" for="txtAddress">คำนำหน้า</label>
                <div class="controls">
                    <select  id="slTitle" class="input-small">
                        <option value="x">นาย</option>
                        <option value="x">นาง</option>
                        <option value="x">นางสาว</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="txtHouseId">ชื่อ</label>
                <div class="controls">
                    <input type="text" id="txtFirstName" placeholder="ชื่อ" class="input-medium">
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="txtLastName">สกุล</label>
                <div class="controls">
                    <input type="text" id="txtLastName" placeholder="สกุล" class="input-medium">
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                <label class="control-label" for="txtBirthDate">วันเกิด</label>
                <div class="controls">
                    <input type="text" id="txtBirthDate" placeholder="วันเกิด" class="input-small">
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                <label class="control-label" for="slSex">เพศ</label>
                <div class="controls">
                    <select  id="slSex" class="input-small">
                        <option value="x">ชาย</option>
                        <option value="x">หญิง</option>
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
                        <option value="1">โสด</option>
                        <option value="2">คู่</option>
                        <option value="3">ม่าย</option>
                        <option value="4">หย่า</option>
                        <option value="5">แยกกันอยู่</option>
                        <option value="6">สมณะ</option>
                        <option value="9">ไม่ทราบ</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="span5">
            <div class="control-group">
                <label class="control-label" for="slOccupation">อาชีพ</label>
                <div class="controls">
                    <select  id="slOccupation" class="input-xlarge">
                        <option value="1">โสด</option>
                        <option value="2">คู่</option>
                        <option value="3">ม่าย</option>
                        <option value="4">หย่า</option>
                        <option value="5">แยกกันอยู่</option>
                        <option value="6">สมณะ</option>
                        <option value="9">ไม่ทราบ</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <label class="control-label" for="txtEducation">การศึกษา</label>
            <div class="controls">
                <select  id="txtEducation" class="input-medium">
                    <option value="1">โสด</option>
                    <option value="2">คู่</option>
                    <option value="3">ม่าย</option>
                    <option value="4">หย่า</option>
                    <option value="5">แยกกันอยู่</option>
                    <option value="6">สมณะ</option>
                    <option value="9">ไม่ทราบ</option>
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
                        <option value="1">โสด</option>
                        <option value="2">คู่</option>
                        <option value="3">ม่าย</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="slRace">เชื้อชาติ</label>
                <div class="controls">
                    <select  id="slRace" class="input-medium">
                        <option value="1">โสด</option>
                        <option value="2">คู่</option>
                        <option value="3">ม่าย</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="slReligion">ศาสนา</label>
                <div class="controls">
                    <select  id="slReligion" class="input-medium">
                        <option value="1">โสด</option>
                        <option value="2">คู่</option>
                        <option value="3">ม่าย</option>
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
                        <option value="1">กำนันผู้ใหญ่บ้าน</option>
                        <option value="2">อสม.</option>
                        <option value="3">แพทย์ประจำตำบล</option>
                        <option value="4">สมาชิก อบต.</option>
                        <option value="5">อื่นๆ</option>
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
                <label class="control-label" for="txtMoveinDate">วันที่ย้ายเข้า</label>
                <div class="controls">
                    <input type="text" id="txtMoveinDate" placeholder="วันที่ย้ายเข้า" class="input-small">
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                <label class="control-label" for="txtDischargeDate">วันที่ย้ายออก</label>
                <div class="controls">
                    <input type="text" id="txtDischargeDate" placeholder="วันที่ย้ายออก" class="input-small">
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
    </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</button>
        <button type="button" class="btn btn-success"><i class="icon-plus-sign icon-white"></i> บันทึก</button>
    </div>
    </div>
    <!-- end person -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/apps/js/apps.person.index.js"></script>
