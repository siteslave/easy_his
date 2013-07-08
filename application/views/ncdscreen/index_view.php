<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">คัดกรองเบาหวานความดัน</li>
</ul>

<div class="navbar">
    <form action="#" class="navbar-form form-inline">
        <label for="sl_year">ปีงบประมาณ</label>
        <select id="sl_year" style="width: 100px;">
            <option value="2556">2556</option>
            <option value="2557">2557</option>
            <option value="2558">2558</option>
        </select>
        <label for="sl_village">หมู่บ้าน</label>
        <select style="width: 250px;" id="sl_village">
            <option value="">---</option>
            <?php
            foreach ($villages as $r){
                echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
            }
            ?>
        </select>
        <button type="button" class="btn btn-primary" id="btn_do_get_list"><i class="icon-search"></i></button> |
        <input type="text" style="width: 250px;" id="txt_query" placeholder="พิมพ์ HN หรือ เลขบัตรประชาชน" title="พิมพ์ HN หรือ เลขบัตรประชาชน" rel="tooltip" autocomplete="off" />
        <button type="button" id="btn_do_search" class="btn btn-primary"><i class="icon-search"></i></button>

        <div class="btn-group pull-right">
            <button type="button" id="btn_result" class="btn btn-default" title="ผลการปฏิบัติงาน" rel="tooltip"><i class="icon-bar-chart"></i></button>
            <button type="button" id="btn_refresh" class="btn btn-success" title="รีเฟรช (Refresh)" rel="tooltip"><i class="icon-refresh"></i></button>
            <button type="button" id="btn_print" class="btn btn-primary" title="พิมพ์รายชื่อ (Print)" rel="tooltip"><i class="icon-print"></i></button>
        </div>

    </form>
</div>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
    <tr>
        <th>HN</th>
        <th>CID</th>
        <th>ชื่อ - สกุล</th>
        <th>วันเกิด</th>
        <th>อายุ (ปี)</th>
        <th>วันที่</th>
        <th>สถานที่</th>
        <th>น้ำหนัก (kg)</th>
        <th>ส่วนสูง (cm)</th>
        <th>FBS (mg%)</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="11">...</td>
    </tr>
    </tbody>
</table>

<ul class="pagination pagination-centered" id="main_paging"></ul>

<div class="modal fade" id="mdl_screen">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4>บันทึกข้อมูลการการคัดกรองเบาหวานความดัน</h4>
        </div>
        <div class="modal-body">
            <form class="form-inline well well-small">
                <div class="row">
                    <div class="col-lg-2">
                        <label>HN</label>
                        <input type="text" disabled="disabled" id="txt_hn">
                    </div>
                    <div class="col-lg-3">
                        <label>ชื่อ - สกุล</label>
                        <input type="text" disabled="disabled" id="txt_fullname">
                    </div>
                    <div class="col-lg-3">
                        <label>CID</label>
                        <input type="text" disabled="disabled" id="txt_cid">
                    </div>
                    <div class="col-lg-2">
                        <label>วันเกิด</label>
                        <input type="text" disabled="disabled" id="txt_birthdate">
                    </div>
                    <div class="col-lg-2">
                        <label>อายุ (ปี)</label>
                        <input type="text" disabled="disabled" id="txt_age">
                    </div>
                </div>

            </form>
            <div class="row">
                <div class="col-lg-3">
                    <label for="sl_place">สถานที่คัดกรอง</label>
                    <select name="" id="sl_place">
                        <option value="1">ในสถานบริการ</option>
                        <option value="2" selected="selected">นอกสถานบริการ</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-2">
                    <label class="control-label" for="txt_screen_date">วันที่</label>
                    <input type="text" id="txt_screen_date" data-type="date" />
                </div>
                <div class="col-lg-2">
                    <label class="control-label" for="txt_screen_time">เวลา</label>
                    <input type="text" value="<?php echo date('H:i'); ?>" id="txt_screen_time" data-type="time" />
                </div>
                <div class="col-lg-2">
                    <label class="control-label" for="txt_weight">น้ำหนัก</label>
                    <div class="input-group">
                        <input type="text" data-type="number" id="txt_weight">
                        <span class="input-group-addon">กก.</span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label class="control-label" for="txt_height">ส่วนสูง</label>
                    <div class="input-group">
                        <input type="text" data-type="number" id="txt_height">
                        <span class="input-group-addon">ซม.</span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label class="control-label" for="txt_waistline">รอบเอว</label>
                    <div class="input-group">
                        <input type="text" data-type="number" id="txt_waistline">
                        <span class="input-group-addon">ซม.</span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label class="control-label" for="txt_bmi">BMI</label>
                    <input type="text" id="txt_bmi" placeholder="BMI" disabled>
                </div>
            </div>
            <br>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_01" data-toggle="tab"> ข้อมูลครอบครัว</a></li>
                <li><a href="#tab_02" data-toggle="tab"> ประวัติการเจ็บป่วย</a></li>
                <li><a href="#tab_03" data-toggle="tab"> การคัดกรองอื่นๆ</a></li>
                <li><a href="#tab_04" data-toggle="tab"> การตรวจร่างกาย</a></li>
                <li><a href="#tab_05" data-toggle="tab"> สรุปผลคัดกรอง</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_01">
                    <br>
                    <legend>ข้อมูลการเจ็บป่วยของบุคคลในครอบครัว</legend>
                    <strong>บิดาหรือมารดา</strong> ของท่านมีประวัติการเจ็บป่วยด้วย
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_fm_dm"> เบาหวาน (DM)
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_fm_ht"> ความดันโลหิตสูง (HT)
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_fm_gout"> โรคเกาท์ (Gout)
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_fm_crf"> ไตวายเรื้อรัง (CRF)
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_fm_mi"> กล้ามเนื้อหัวใจตาย (MI)
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_fm_copd"> ถุงลมโป่งพอง (COPD)
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_fm_stroke"> เส้นเลือดสมอง (Stroke)
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_fm_not_know"> ไม่ทราบ
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_fm_no"> ไม่มี
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_fm_other"> อื่นๆ
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <input type="text" class="input-xxlarge" id="txt_fm_other_detail"/>
                        </div>
                    </div>
                    <strong>พี่น้อง (สายตรง)</strong> ของท่านมีประวัติการเจ็บป่วยด้วย
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_sb_dm"> เบาหวาน (DM)
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_sb_ht"> ความดันโลหิตสูง (HT)
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_sb_gout"> โรคเกาท์ (Gout)
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_sb_crf"> ไตวายเรื้อรัง (CRF)
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_sb_mi"> กล้ามเนื้อหัวใจตาย (MI)
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_sb_copd"> ถุงลมโป่งพอง (COPD)
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_sb_stroke"> เส้นเลือดสมอง (Stroke)
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_sb_not_know"> ไม่ทราบ
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_sb_no" checked="checked"> ไม่มี
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_sb_other"> อื่นๆ
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <input type="text" class="input-xxlarge" id="txt_sb_other_detail"/>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_02">
                    <br>
                    <legend>ท่านมีประวัติการเจ็บป่วย หรือต้องพบแพทย์ด้วยโรคหรืออาการนี้หรือไม่</legend>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>โรคหรืออาการ</th>
                            <th>ประวัติ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>โรคเบาหวาน (DM)</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_dm_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_dm_history" data-value="0">ไม่มี</button>
                                    <button type="button" class="btn btn-default" data-name="btn_dm_history" data-value="-1">ไม่เคยตรวจ</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> โรคความดันโลหิตสูง (HT)</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_ht_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_ht_history" data-value="0">ไม่มี</button>
                                    <button type="button" class="btn btn-default" data-name="btn_ht_history" data-value="-1">ไม่เคยตรวจ</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> โรคตับ</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_lv_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_lv_history" data-value="0">ไม่มี</button>
                                    <button type="button" class="btn btn-default" data-name="btn_lv_history" data-value="-1">ไม่เคยตรวจ</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> โรคอัมพาต</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_ds_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_ds_history" data-value="0">ไม่มี</button>
                                    <button type="button" class="btn btn-default" data-name="btn_ds_history" data-value="-1">ไม่เคยตรวจ</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> โรคหัวใจ</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_hb_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_hb_history" data-value="0">ไม่มี</button>
                                    <button type="button" class="btn btn-default" data-name="btn_hb_history" data-value="-1">ไม่เคยตรวจ</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> ไขมันในเลือดผิดปกติ</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_lb_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_lb_history" data-value="0">ไม่มี</button>
                                    <button type="button" class="btn btn-default" data-name="btn_lb_history" data-value="-1">ไม่เคยตรวจ</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> แผลที่เท้า/ตัดขา (จากเบาหวาน)</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_lg_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_lg_history" data-value="0">ไม่มี</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> คลอดบุตรน้ำหนักเกิน 4 กิโลกรัม</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_bb_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_bb_history" data-value="0">ไม่มี</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> ดื่มน้ำบ่อยมาก</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_wt_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_wt_history" data-value="0">ไม่มี</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> ปัสสาวะกลางคืน 3 ครั้งขึ้นไป</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_ur_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_ur_history" data-value="0">ไม่มี</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> กินจุแต่ผอม</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_et_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_et_history" data-value="0">ไม่มี</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> น้ำหนักลด/อ่อนเพลีย</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_we_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_we_history" data-value="0">ไม่มี</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> เป็นแผลริมฝีปากบ่อยและหายยาก</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_mo_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_mo_history" data-value="0">ไม่มี</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> คันตามผิวหนังและอวัยวะสืบพันธุ์</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_sk_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_sk_history" data-value="0">ไม่มี</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> ตาพร่ามัว ต้องเปลี่ยนแว่นบ่อย</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_ey_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_ey_history" data-value="0">ไม่มี</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> ชาปลายมือปลายเท้าโดยไม่ทราบสาเหตุ</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_fg_history" data-value="1">มี</button>
                                    <button type="button" class="btn btn-default active" data-name="btn_fg_history" data-value="0">ไม่มี</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> <strong>กรณีมีประวัติ</strong></td>
                            <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" class="btn btn-default" data-name="btn_status_history" data-value="1">รักษาอยู่</button>
                                    <button type="button" class="btn btn-default" data-name="btn_status_history" data-value="0">รักษาไม่สม่ำเสมอ</button>
                                    <button type="button" class="btn btn-default" data-name="btn_status_history" data-value="-1">เคยรักษา ไม่รักษา/หายาทานเอง</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab_03">
                    <br>
                    <legend>ท่านสูบบุหรี่หรือไม่</legend>
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="radio">
                                <input type="radio" name="rd_smoke" value="1">
                                สูบ
                            </label>
                        </div>
                        <div class="col-lg-3">
                            จำนวน (มวน/วัน) <input type="text" class="input-mini" id="txt_smoke_qty" />
                        </div>
                        <div class="col-lg-4">
                            ชนิด <input type="text" class="input-medium" id="txt_smoke_type"/>
                        </div>
                        <div class="col-lg-3">
                            ระยะเวลา (ปี) <input type="text" class="input-mini" data-type="year" id="txt_smoke_year" />
                        </div>
                    </div>
                    <label class="radio">
                        <input type="radio" name="rd_smoke"  value="0" checked="checked">
                        ไม่สูบ
                    </label>
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="radio">
                                <input type="radio" name="rd_smoke" value="-1">
                                เคยสูบ
                            </label>
                        </div>
                        <div class="col-lg-4">
                            ชนิด <input type="text" class="input-medium" id="txt_smoked_type"/>
                        </div>
                        <div class="col-lg-3">
                            ระยะเวลา <input type="text" class="input-mini" data-type="year" id="txt_smoked_year" /> ปี
                        </div>
                    </div>

                    <legend>ท่านดื่มเครื่องดื่มที่มีแอลกอฮอล์หรือไม่</legend>
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="radio">
                                <input type="radio" name="rd_drink" value="1">
                                ดื่ม
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <input type="text" data-type="number" class="input-mini" id="txt_drink_qty"/> ครั้ง/สัปดาห์
                        </div>
                    </div>
                    <label class="radio">
                        <input type="radio" name="rd_drink" value="0" checked="checked">
                        ไม่ดื่ม
                    </label>
                    <label class="radio">
                        <input type="radio" name="rd_drink" value="-1">
                        เคยดื่มแต่เลิกแล้ว
                    </label>

                    <legend>ท่านออกกำลังกาย/เล่นกีฬา</legend>

                    <label class="radio">
                        <input type="radio" name="rd_sport" value="1" checked="checked">
                        ออกกำลังกาย <strong>ทุกวัน</strong> ครั้งละ 30 นาที
                    </label>
                    <label class="radio">
                        <input type="radio" name="rd_sport" value="2">
                        ออกกำลังกาย <strong>สัปดาห์ละมากกว่า 3 </strong> ครั้งๆ ละ 30 นาที สม่ำเสมอ
                    </label>
                    <label class="radio">
                        <input type="radio" name="rd_sport" value="3">
                        ออกกำลังกาย <strong>สัปดาห์ละ 3 </strong> ครั้งๆ ละ 30 นาที สม่ำเสมอ
                    </label>
                    <label class="radio">
                        <input type="radio" name="rd_sport" value="4">
                        ออกกำลังกาย <strong>น้อยกว่าสัปดาห์ละ 3 ครั้ง </strong>
                    </label>
                    <label class="radio">
                        <input type="radio" name="rd_sport" value="0">
                        ไม่ออกกำลังกายเลย
                    </label>

                    <legend>ท่านชอบอาหารรสใด</legend>
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="food_taste_sweet" checked="checked"> หวาน
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="food_taste_salt"> เค็ม
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="food_taste_creamy"> มัน
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="food_taste_no"> ไม่ชอบทุกข้อ
                            </label>
                        </div>
                    </div>

                    <legend>แบบคัดกรองวัณโรค (เฉพาะผู้ป่วยโรคเรื้อรัง ผู้ป่วยเบาหวานและผู้สัมผัสร่วมบ้าน)</legend>
                    <strong>ท่านมีอาการไอเรื้อรังติดต่อกันมากกว่า 2 สัปดาห์หรือมีอาการไอมีเสมหะปนเลือด</strong>
                    <div class="row">
                        <div class="col-lg-1">
                            <label class="radio">
                                <input type="radio" name="rd_screen_tb" value="1" checked>
                                มี
                            </label>
                        </div>
                        <div class="col-lg-1">
                            <label class="radio">
                                <input type="radio" name="rd_screen_tb" value="0" checked>
                                ไม่มี
                            </label>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_04">
                    <br>
                    <legend>ข้อมูลการตรวจร่างกาย</legend>
                    <div class="row">
                        <div class="col-lg-3">
                            <label>BP ครั้งที่ 1</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" data-type="number" id="txt_sbp1" placeholder="SBP" rel="tooltip" title="SBP ครั้งที่ 1">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" data-type="number" id="txt_dbp1" placeholder="DBP" rel="tooltip" title="DBP ครั้งที่ 1">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label>BP ครั้งที่ 2</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" data-type="number" id="txt_sbp2" placeholder="SBP" rel="tooltip" title="SBP ครั้งที่ 2">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" data-type="number" id="txt_dbp2" placeholder="DBP" rel="tooltip" title="DBP ครั้งที่ 2">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label>BP เฉลี่ย</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" data-type="number" id="txt_sbp3" placeholder="SBP" rel="tooltip" title="SBP เฉลี่ย">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" data-type="number" id="txt_dbp3" placeholder="DBP" rel="tooltip" title="DBP เฉลี่ย">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="control-label" for="txt_fbs">FBS</label>
                            <div class="input-group">
                                <input type="text" data-type="number" id="txt_fbs">
                                <span class="input-group-addon">mg%</span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="txt_blood_sugar">Post pandrail blood sugar</label>
                            <div class="input-group">
                                <input type="text" data-type="number" id="txt_blood_sugar">
                                <span class="input-group-addon">mg%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_05">
                    <br>
                    <legend>สรุปผลการตรวจคัดกรองยืนยันความเสี่ยงโรค Metabolic</legend>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="radio">
                                <input type="radio" name="rd_risk_meta" checked="checked" value="0"> ไม่พบความเสี่ยง
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="radio">
                                <input type="radio" name="rd_risk_meta" value="1"> มีความเสี่ยงเบื้องต้นต่อโรค
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_risk_meta_dm"> DM
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_risk_meta_ht"> HT
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_risk_meta_stroke"> Stroke
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_risk_meta_obesity"> Obesity
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="radio">
                                <input type="radio" name="rd_risk_meta" value="2"> ป่วยด้วยโรคเรื้อรัง
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_risk_ncd_dm"> DM
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_risk_ncd_ht"> HT
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_risk_ncd_stroke"> Stroke
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <label class="checkbox">
                                <input type="checkbox" id="chk_risk_ncd_obesity"> Obesity
                            </label>
                        </div>
                    </div>
                    <legend>สรุปผลความเสี่ยงต่อโรคหัวใจขาดเลือดและอัมพฤกษ์และอัมพาต</legend>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="radio">
                                <input type="radio" name="rd_risk_disb" value="0"> ไม่พบความเสี่ยง
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="radio">
                                <input type="radio" name="rd_risk_disb" value="1"> กลุ่มเสี่ยงสูง
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="radio">
                                <input type="radio" name="rd_risk_disb" value="2">กลุ่มเสี่ยงสูงปานกลาง
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="radio">
                                <input type="radio" name="rd_risk_disb" value="3"> กลุ่มเสี่ยงสูงมาก
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" id="btn_save" class="btn btn-success"><i class="icon-save"></i> บันทึกข้อมูล</a>
            <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
        </div>
        </div>
    </div>
</div>

<div class="modal hide fade" id="mdl_result">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ผลการปฏิบัติงาน</h3>
    </div>
    <div class="modal-body">
        <form class="well well-small form-inline">
            <label for="">เลือกปีงบประมาณ</label>
            <select name="" id="sl_result_year" class="input-small">
                <option value="2556">2556</option>
                <option value="2557">2557</option>
                <option value="2558">2558</option>
            </select>
            <button type="button" class="btn btn-info" id="btn_get_result">
                <i class="icon-refresh"></i> แสดงผลงาน
            </button>
        </form>
        <div class="row">
            <div class="col-lg-6">
                <table class="table table-bordered" id="tbl_result">
                    <thead>
                    <tr>
                        <th>เป้าหมาย</th>
                        <th>ผลงาน</th>
                        <th>คิดเป็น %</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><span id="txt_total"></span></td>
                        <td><span id="txt_result"></span></td>
                        <td><span id="txt_percent"></span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6" id="div_result_chart" style="height: 250px;"> </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.ncdscreen.js');
</script>


