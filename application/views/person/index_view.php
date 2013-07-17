    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
        <li class="active">ประชากรในเขต</li>
    </ul>
    <div class="navbar">
        <form action="#" class="navbar-form form-inline">
            <label for="sl_villages">หมู่บ้าน</label>
            <select style="width: 250px;" id="sl_villages">
                <option value="">-- เลือกหมู่บ้าน --</option>
                <?php
                foreach ($villages as $r){
                    echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
                }
                ?>
            </select>
            <button type="button" class="btn btn-primary" id="btn_village_survey" rel="tooltip" title="สำรวจข้อมูลหมู่บ้าน"><i class="icon-check"></i></button>
            |
            <label for="sl_houses">หลังคาเรือน</label>
            <select style="width: 150px;" id="sl_houses">
            </select>
            <div class="btn-group">
                <button type="button" class="btn btn-success" id="btn_get_list" rel="tooltip" title="แสดงรายชื่อประชากร"><i class="icon-refresh"></i></button>
                <button type="button" class="btn btn-default" id="btn_add_house" rel="tooltip" title="เพิ่มหลังคาเรือน"><i class="icon-home"></i></button>
                <button type="button" class="btn btn-default" id="btn_add_person" rel="tooltip" title="เพิ่มคนในบ้าน"><i class="icon-user"></i></button>
                <button type="button" class="btn btn-primary" id="btn_house_survey" rel="tooltip" title="สำรวจข้อมูลหลังคาเรือน"><i class="icon-check"></i></button>
            </div>

            <div class="btn-group pull-right">
                <button type="button" id="btn_search_person" class="btn btn-success" title="ค้นหาประชากร" rel="tooltip"><i class="icon-search"></i></button>
                <button type="button" id="btn_print" class="btn btn-default" title="พิมพ์รายชื่อ (Print)" rel="tooltip"><i class="icon-print"></i></button>
            </div>

        </form>
    </div>

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
            <th>สถานะ</th>
            <th>Typearea</th>
            <th>ที่อยู่</th>
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

    <ul class="pagination pagination-centered" id="main_paging"></ul>

    <!-- modal new house -->
    <div class="modal fade" id="mdlNewHouse">
        <div class="modal-dialog" style="width: 960px; left: 35%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="icon-file-alt"></i> เพิ่มบ้านใหม่</h4>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="control-label" for="txtAddress">บ้านเลขที่</label>
                                <input type="text" id="txtAddress" placeholder="บ้านเลขที่">
                            </div>
                            <div class="col-lg-4">
                                <label class="control-label" for="txtHouseCode">รหัสบ้าน (กรมการปกครอง)</label>
                                <input type="text" id="txtHouseCode" placeholder="รหัสบ้าน">
                            </div>
                            <div class="col-lg-4">
                                <label class="control-label" for="slHouseType">ประเภทที่อยู่</label>
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
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="control-label" for="txtRoomNo">เลขห้อง</label>
                                <input type="text" id="txtRoomNo" placeholder="เลขห้อง">
                            </div>
                            <div class="col-lg-4">
                                <label class="control-label" for="txtSoiSub">ซอยแยก</label>
                                <input type="text" id="txtSoiSub" placeholder="ซอยแยก">
                            </div>
                            <div class="col-lg-4">
                                <label class="control-label" for="txtSoiMain">ซอยหลัก</label>
                                <input type="text" id="txtSoiMain" placeholder="ซอยหลัก">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-4">
                                <label class="control-label" for="txtCondo">ชื่ออาคารชุด</label>
                                <input type="text" id="txtCondo" placeholder="ชื่ออาคารชุด">
                            </div>
                            <div class="col-lg-4">
                                <label class="control-label" for="txtVillageName">ชื่อหมู่บ้านจัดสรร</label>
                                <input type="text" id="txtVillageName" placeholder="ชื่อหมู่บ้านจัดสรร">
                            </div>
                            <div class="col-lg-4">
                                <label class="control-label" for="txtRoad">ถนน</label>
                                <input type="text" id="txtRoad" placeholder="ถนน">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_do_save_house"><i class="icon-save"></i> บันทึกบ้าน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal new house -->

    <div class="modal fade" id="mdl_search_person">
        <div class="modal-dialog" style="width: 960px; left: 35%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
                        <i class="icon-search"></i>
                        ค้นหาข้อมูลประชากร
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="navbar">
                        <form action="#" class="form-inline navbar-form">
                            <input type="hidden" id="txt_search_person_filter" value="0" />
                            <input style="width: 300px;" id="txt_search_query" type="text" placeholder="พิมพ์ HN ชื่อ-สกุล หรือเลขบัตรประชาชน"
                                   title="พิมพ์ชื่อ-สกุล HN หรือเลขบัตรประชาชน" rel="tooltip" autocomplete="off">
                            <button class="btn btn-primary" type="button" id="btn_do_search_person">
                                <i class="icon-search"></i>
                            </button>
                            <div class="btn-group">
                                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="ระบุเงื่อนไขในการค้นหา" rel="tooltip" data-direction="right">
                                    <i class="icon-cog"></i>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" data-name="btn_search_person_fillter" data-value="0">ค้นจาก เลขบัตรประชาชน</a></li>
                                    <li><a href="#" data-name="btn_search_person_fillter" data-value="1">ค้นจาก HN</a></li>
                                    <li><a href="#" data-name="btn_search_person_fillter" data-value="2">ค้นจาก ชื่อ - สกุล</a></li>
                                </ul>
                            </div>
                        </form>
                    </div>

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
        </div>
    </div>

    <!-- modal house survey -->
    <div class="modal fade" id="mdlHouseSurvey">
        <div class="modal-dialog" style="width: 960px; left: 35%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">สำรวจข้อมูลบ้าน</h4>
                </div>
                <div class="modal-body">
                    <form action="#">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_locatype">ที่ตั้ง</label>
                            <select id="sl_locatype">
                                <option value="1">ในเขตเทศบาล</option>
                                <option value="2">นอกเขตเทศบาล</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="control-label" for="txt_house_latitude">ละติจูด</label>
                            <input type="text" id="txt_house_latitude" placeholder="ละติจูด">
                        </div>
                        <div class="col-lg-2">
                            <label class="control-label" for="txt_house_longitude">ลองจิจูด</label>
                            <input type="text" id="txt_house_longitude" placeholder="ลองจิจูด">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <label for="txt_vhvid_cid">HN</label>
                            <input type="text" disabled="disabled" id="txt_vhvid" placeholder="-*-">
                        </div>
                        <div class="col-lg-4">
                            <label for="txt_vhvid_cid">อสม. ประจำบ้าน</label>
                            <input id="txt_vhvid_cid" type="text" placeholder="พิมพ์ชื่อ-สกุล, HN หรือเลขบัตรประชาชน" title="พิมพ์ชื่อ-สกุล, HN หรือเลขบัตรประชาชน" rel="tooltip">
                        </div>
                        <div class="col-lg-2">
                            <label for="txt_headid">HN</label>
                            <input type="text" disabled="disabled" id="txt_headid" placeholder="-*-">
                        </div>
                        <div class="col-lg-4">
                            <label for="txt_headid_cid">เจ้าบ้าน</label>
                            <input id="txt_headid_cid" type="text" placeholder="พิมพ์ชื่อ-สกุล, HN หรือเลขบัตรประชาชน" title="พิมพ์ชื่อ-สกุล, HN หรือเลขบัตรประชาชน" rel="tooltip">
                        </div>
                    </div>
                    <legend>ข้อมูลสำรวจ</legend>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_toilet">การมีส้วม</label>
                            <select id="sl_toilet">
                                <option value="9">ไม่ทราบ</option>
                                <option value="0">ไม่มี</option>
                                <option value="1">มี</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_water">น้ำดื่มเพียงพอ</label>
                            <select id="sl_water">
                                <option value="9">ไม่ทราบ</option>
                                <option value="0">ไม่เพียงพอ</option>
                                <option value="1">เพียงพอ</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_watertype">ประเภทแหล่งน้ำ</label>
                            <select id="sl_watertype">
                                <option value="9">ไม่ทราบ</option>
                                <option value="1">น้ำฝน</option>
                                <option value="2">น้ำประปา</option>
                                <option value="3">น้ำบาดาล</option>
                                <option value="4">บ่อน้ำตื้น</option>
                                <option value="5">สระน้ำ แม่น้ำ</option>
                                <option value="6">น้ำบรรจุเสร็จ</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_garbage">วิธีกำจัดขยะ</label>
                            <select id="sl_garbage">
                                <option value="9">ไม่ทราบ</option>
                                <option value="1">ฝัง</option>
                                <option value="2">เผา</option>
                                <option value="3">หมักทำปุ๋ย</option>
                                <option value="4">ส่งไปกำจัดที่อื่น</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_housing">การจัดบ้านถูกหลัก</label>
                            <select id="sl_housing">
                                <option value="9">ไม่ทราบ</option>
                                <option value="0">ไม่ถูก</option>
                                <option value="1">ถูก</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_durability">ความคงทน</label>
                            <select id="sl_durability">
                                <option value="9">ไม่ทราบ</option>
                                <option value="1">คงทน 1-4 ปี</option>
                                <option value="2">คงทน 5 ปีขึ้นไป</option>
                                <option value="3">ไม่คงทน</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_cleanliness">ความสะอาด</label>
                            <select id="sl_cleanliness" class="input-medium">
                                <option value="9">ไม่ทราบ</option>
                                <option value="1">ไม่สะอาด</option>
                                <option value="2">สะอาด</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_ventilation">การระบายอากาศ</label>
                            <select id="sl_ventilation">
                                <option value="9">ไม่ทราบ</option>
                                <option value="0">ไม่ระบาย</option>
                                <option value="1">ระบาย</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_light">แสงสว่าง</label>
                            <select id="sl_light">
                                <option value="9">ไม่ทราบ</option>
                                <option value="0">ไม่เพียงพอ</option>
                                <option value="1">เพียงพอ</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_watertm">การกำจัดน้ำเสีย</label>
                            <select id="sl_watertm" class="input-medium">
                                <option value="9">ไม่ทราบ</option>
                                <option value="1">ไม่กำจัด</option>
                                <option value="2">กำจัด</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_mfood">สารปรุงแต่ง</label>
                            <select id="sl_mfood">
                                <option value="9">ไม่ทราบ</option>
                                <option value="1">ไม่ใช้</option>
                                <option value="2">ใช้</option>>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_bcontrol">การควบคุมแมลง</label>
                            <select id="sl_bcontrol">
                                <option value="9">ไม่ทราบ</option>
                                <option value="0">ไม่ควบคุม</option>
                                <option value="1">ควบคุม</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_acontrol">การควบคุมสัตว์</label>
                            <select id="sl_acontrol">
                                <option value="9">ไม่ทราบ</option>
                                <option value="0">ไม่ควบคุม</option>
                                <option value="1">ควบคุม</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_chemical">การจัดเก็บสารเคมี</label>
                            <select id="sl_chemical">
                                <option value="9">ไม่ทราบ</option>
                                <option value="1">ไม่มี</option>
                                <option value="2">มี</option>
                            </select>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_save_house_seruvey"><i class="icon-save"></i> บันทึก</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal survey -->

<!--  village survey  -->
    <div class="modal fade" id="mdl_village_survey">
        <div class="modal-dialog" style="width: 960px; left: 35%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="icon-desktop"></i> สำรวจข้อมูลหมู่บ้าน</h4>
                </div>
                <div class="modal-body">
                    <form action="#">
        
                        <input type="hidden" id="txt_village_id" />
            
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_ntraditional">แพทย์แผนไทย</label>
                                <input type="text" data-type="number" id="txt_ntraditional">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nmonk">พระ</label>
                                <input type="text" data-type="number" id="txt_nmonk">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nreligionleader">ผู้นำศาสนา</label>
                                <input type="text" data-type="number" id="txt_nreligionleader">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nbroadcast">หอกระจายข่าว</label>
                                <input type="text" data-type="number" id="txt_nbroadcast">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nradio">สถานีวิทยุชุมชน</label>
                                <input type="text" data-type="number" id="txt_nradio">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_npchc">ศูนย์ ศสม.</label>
                                <input type="text" data-type="number" id="txt_npchc">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nclinic">คลินิก</label>
                                <input type="text" data-type="number" id="txt_nclinic">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_ndrugstore">ร้านขายยา</label>
                                <input type="text" data-type="number" id="txt_ndrugstore">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nchildcenter">ศูนย์พัฒนาเด็ก</label>
                                <input type="text" data-type="number" id="txt_nchildcenter">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_npschool">โรงเรียนประถมฯ</label>
                                <input type="text" data-type="number" id="txt_npschool">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nsschool">โรงเรียนมัธยมฯ</label>
                                <input type="text" data-type="number" id="txt_nsschool">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_ntemple">วัด</label>
                                <input type="text" data-type="number" id="txt_ntemple">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nreligiousplace">ศาสนสถาน</label>
                                <input type="text" data-type="number" id="txt_nreligiousplace">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nmarket">ตลาดสด</label>
                                <input type="text" data-type="number" id="txt_nmarket">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nshop">ร้านขายของชำ</label>
                                <input type="text" data-type="number" id="txt_nshop">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nfoodshop">ร้านอาหาร</label>
                                <input type="text" data-type="number" id="txt_nfoodshop">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nstall">หาบเร่ แผงลอย</label>
                                <input type="text" data-type="number" id="txt_nstall">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nraintank">ถังเก็บน้ำฝน</label>
                                <input type="text" data-type="number" id="txt_nraintank">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_chickenfarm">ฟาร์มสัตว์ปีก</label>
                                <input type="text" data-type="number" id="txt_chickenfarm">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_npigfarm">ฟาร์มสุกร</label>
                                <input type="text" data-type="number" id="txt_npigfarm">
                            </div>
                            <div class="col-lg-3">
                                <label class="control-label" for="sl_wastewater">บ่อกำจัดน้ำเสีย</label>
                                <select id="sl_wastewater">
                                    <option value="1">มีบ่อกำจัดน้ำเสีย</option>
                                    <option value="2">ไม่มีบ่อกำจัดน้ำเสีย</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="control-label" for="sl_grabage">สถานที่กำจัดขยะ</label>
                                <select id="sl_grabage">
                                    <option value="1">ไม่มีสถานที่กำจัดขยะ</option>
                                    <option value="2">มีสถานที่ฝังกลบ</option>
                                    <option value="2">มีสถานที่เผาขยะ</option>
                                    <option value="2">มีสถานที่ย่อยทำลายขยะ</option>
                                    <option value="2">ขนส่งไปทิ้งที่อื่น</option>
                                    <option value="2">กำจัดขยะด้วยวิธี</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nfactory">โรงงานอุตสาหกรรม</label>
                                <input type="text" data-type="number" id="txt_nfactory">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_latitude">พิกัด (ลติจูด)</label>
                                <input type="text" data-type="number" id="txt_latitude">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_longitude">พิกัด (ลองจิจูด)</label>
                                <input type="text" data-type="number" id="txt_longitude">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_outdate">วันที่แยกชุมชน</label>
                                <input id="txt_outdate" type="text" data-type="date">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_numactually">แหล่งอบายมุข</label>
                                <input type="text" data-type="number" id="txt_numactually">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_risktype">ประเภทเสี่ยงภัยพิบัติ</label>
                                <input type="text" data-type="number" id="txt_risktype">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_numstateless">ชุมชนต่างด้าว</label>
                                <input type="text" data-type="number" id="txt_numstateless">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nexerciseclub">ชมรมออกกำลังกาย</label>
                                <input type="text" data-type="number" id="txt_nexerciseclub">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nolderlyclub">ชมรมผู้สูงอายุ</label>
                                <input type="text" data-type="number" id="txt_nolderlyclub">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_ndisableclub">ชมรมผู้พิการ</label>
                                <input type="text" data-type="number" id="txt_ndisableclub">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_nnumberoneclub">To Be Number 1</label>
                                <input type="text" data-type="number" id="txt_nnumberoneclub">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_save_village_survey"><i class="icon-save"></i> บันทึกข้อมูลสำรวจ</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="mdl_move_person">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="icon-share"></i> ย้ายบ้าน</h4>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-horizontal">
                        <legend>ย้ายไปที่</legend>
                        <input type="hidden" id="txt_move_person_hn"/>
                        <label for="sl_move_person_villages">หมู่บ้าน</label>
                        <select style="width: 350px;" id="sl_move_person_villages">
                            <option value="">-- เลือกหมู่บ้าน --</option>
                            <?php
                            foreach ($villages as $r){
                                echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
                            }
                            ?>
                        </select>
                        <label for="sl_move_person_house">บ้านเลขที่</label>
                        <select id="sl_move_person_house" style="width: 350px;"></select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_save_move_person"><i class="icon-save"></i> ย้ายบ้าน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/apps/js/apps.person.index.js"></script>
