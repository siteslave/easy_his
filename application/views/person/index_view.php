    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
        <li class="active">ประชากรในเขต</li>
    </ul>
    <div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>ข้อแนะนำ!</strong> เนื่องจากรายชื่อประชากรมีจำนวนมาก การโหลดครั้งแรกอาจจะนาน กรุณาเลือกหมู่บ้านหรือบ้านที่ต้องการแสดงรายชื่อประชากร หรือค้นหา
    </div>
    <form action="#" class="well well-small form-inline">
        <label for="sl_villages">หมู่บ้าน</label>
        <select class="input-xlarge" id="sl_villages">
            <option value="">---</option>
            <?php
            foreach ($villages as $r){
                echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
            }
            ?>
        </select>
        <button type="button" class="btn" id="btn_village_survey" rel="tooltip" title="สำรวจข้อมูลหมู่บ้าน"><i class="icon-check"></i></button>
        |
        <label for="sl_houses">หลังคาเรือน</label>
        <select class="input-medium" id="sl_houses">
        </select>
        <div class="btn-group">
            <button type="button" class="btn btn-success" id="btn_get_list" rel="tooltip" title="แสดงรายชื่อประชากร"><i class="icon-refresh"></i></button>
            <button type="button" class="btn" id="btn_add_house" rel="tooltip" title="เพิ่มหลังคาเรือน"><i class="icon-home"></i></button>
            <button type="button" class="btn" id="btn_add_person" rel="tooltip" title="เพิ่มคนในบ้าน"><i class="icon-user"></i></button>
            <button type="button" class="btn" id="btn_house_survey" rel="tooltip" title="สำรวจข้อมูลหลังคาเรือน"><i class="icon-check"></i></button>
        </div>

        <div class="btn-group pull-right">
            <button type="button" id="btn_search_person" class="btn btn-success" title="ค้นหาประชากร" rel="tooltip"><i class="icon-search"></i></button>
            <button type="button" id="btn_print" class="btn" title="พิมพ์รายชื่อ (Print)" rel="tooltip"><i class="icon-print"></i></button>
        </div>

    </form>
    <table class="table table-striped table-hover" id="tbl_person">
        <thead>
        <tr>
            <th>HN</th>
            <th>เลขบัตรประชาชน</th>
            <th>คำนำ</th>
            <th>ชื่อ - สกุล</th>
            <th>วันเกิด</th>
            <th>อายุ</th>
            <th>เพศ</th>
            <th>สถานะในครอบครัว</th>
            <th>สถานะ</th>
            <th>Typearea</th>
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
            <td>...</td>
            <td>...</td>
        </tr>
        </tbody>
    </table>

    <div class="pagination pagination-centered" id="main_paging">
        <ul></ul>
    </div>

    <!-- modal new house -->
    <div class="modal hide fade" id="mdlNewHouse">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="icon-file-alt"></i> เพิ่มบ้านใหม่</h4>
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
            <button type="button" class="btn btn-success" id="btn_do_save_house"><i class="icon-save"></i> บันทึกบ้าน</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
        </div>
    </div>
    <!-- end modal new house -->

    <div class="modal hide fade" id="mdl_search_person">
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
                    <input class="input-xlarge" id="txt_search_query" type="text">
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
                <button class="btn btn-info" type="button"><i class="icon-search"></i></button>
            </div>
        </div>
        <div class="span6">
            <div class="input-append">
                <label>เจ้าบ้าน</label>
                <input type="hidden" id="txt_headid">
                <input class="input-xlarge uneditable-input" id="txt_headid_cid" type="text">
                <button class="btn btn-info" type="button"><i class="icon-search"></i></button>
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
        <button type="button" class="btn btn-success" id="btn_save_house_seruvey"><i class="icon-save"></i> บันทึก</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
    </div>
    </div>
    <!-- end modal survey -->

<!--  village survey  -->
    <div class="modal hide fade" id="mdl_village_survey">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><i class="icon-desktop"></i> สำรวจข้อมูลหมู่บ้าน</h3>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <strong>คำแนะนำ!</strong> <span>กรุณากรอกข้อมูลให้ครบ</span>
            </div>
            <form action="#">

            <input type="hidden" id="txt_village_id" />

                <div class="row-fluid">
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_ntraditional">แพทย์แผนไทย</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_ntraditional">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nmonk">พระ</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nmonk">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nreligionleader">ผู้นำศาสนา</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nreligionleader">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nbroadcast">หอกระจายข่าว</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nbroadcast">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nradio">สถานีวิทยุชุมชน</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nradio">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_npchc">ศูนย์ ศสม.</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_npchc">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nclinic">คลินิก</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nclinic">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_ndrugstore">ร้านขายยา</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_ndrugstore">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nchildcenter">ศูนย์พัฒนาเด็ก</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nchildcenter">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_npschool">โรงเรียนประถมฯ</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_npschool">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nsschool">โรงเรียนมัธยมฯ</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nsschool">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_ntemple">วัด</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_ntemple">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nreligiousplace">ศาสนสถาน</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nreligiousplace">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nmarket">ตลาดสด</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nmarket">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nshop">ร้านขายของชำ</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nshop">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nfoodshop">ร้านอาหาร</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nfoodshop">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nstall">หาบเร่ แผงลอย</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nstall">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nraintank">ถังเก็บน้ำฝน</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nraintank">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_chickenfarm">ฟาร์มสัตว์ปีก</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_chickenfarm">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_npigfarm">ฟาร์มสุกร</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_npigfarm">
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="sl_wastewater">บ่อกำจัดน้ำเสีย</label>
                            <div class="controls">
                                <select id="sl_wastewater">
                                    <option value="1">มีบ่อกำจัดน้ำเสีย</option>
                                    <option value="2">ไม่มีบ่อกำจัดน้ำเสีย</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="sl_grabage">สถานที่กำจัดขยะ</label>
                            <div class="controls">
                                <select id="sl_grabage">
                                    <option value="1">ไม่มีสถานที่กำจัดขยะ</option>
                                    <option value="2">มีสถานที่ฝังกลบ</option>
                                    <option value="2">มีสถานที่เผาขยะ</option>
                                    <option value="2">มีสถานที่ย่อยทำลายขยะ</option>
                                    <option value="2">ขนส่งไปทิ้งที่อื่น</option>
                                    <option value="2">กำจัดขยะด้วยวิธี</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nfactory">โรงงานอุตสาหกรรม</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nfactory">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_latitude">พิกัด (ลติจูด)</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_latitude">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_longitude">พิกัด (ลองจิจูด)</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_longitude">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_outdate">วันที่แยกชุมชน</label>
                            <div class="controls">
                                <div class="input-append date" data-name="datepicker">
                                    <input class="input-small" id="txt_outdate" type="text" value="<?php echo date('d/m/Y'); ?>" disabled>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_numactually">แหล่งอบายมุข</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_numactually">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_risktype">ประเภทเสี่ยงภัยพิบัติ</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_risktype">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_numstateless">ชุมชนต่างด้าว</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_numstateless">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nexerciseclub">ชมรมออกกำลังกาย</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nexerciseclub">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nolderlyclub">ชมรมผู้สูงอายุ</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nolderlyclub">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_ndisableclub">ชมรมผู้พิการ</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_ndisableclub">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_nnumberoneclub">To Be Number 1</label>
                            <div class="controls">
                                <input type="text" class="input-mini" data-type="number" id="txt_nnumberoneclub">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn_save_village_survey"><i class="icon-save"></i> บันทึกข้อมูลสำรวจ</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/apps/js/apps.person.index.js"></script>
