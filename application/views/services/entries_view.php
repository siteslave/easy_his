<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li><a href="<?php echo site_url('services'); ?>">การให้บริการ</a></li>
    <li class="active"><?php echo $patient_name; ?> เพศ: <?php echo $sex == '1' ? 'ชาย' : 'หญิง'; ?> [HN: <?php echo $hn; ?>, CID: <?php echo $cid; ?>]</li>
</ul>
<div class="alert alert-success">
    <a href="#" class="btn btn-danger" rel="tooltip" title="บันทึกข้อมูลอุบัติเหตุ" id="btn_accident"><i class="icon-truck"></i> ข้อมูลอุบัติเหตุ</a>
    <a href="#" class="btn btn-warning" id="btn_labs"><i class="icon-tasks"></i> สั่ง/ลงผล LAB</a>

    <div class="btn-group">
        <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" type="button">
            <i class="icon-th-large"></i> งานส่งเสริม <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li><a href="javascript:void(0);" data-name="btn_fp"><i class="icon-tags"></i> วางแผนครอบครัว (Family Planing)</a></li>
            <li><a href="javascript:void(0);" data-name="btn_nutri"><i class="icon-text-height"></i> บันทึกโภชนาการ (Nutrition)</a></li>
<!--            <li><a href="javascript:void(0);" data-name="btn_epi"><i class="icon-user"></i> บันทึกข้อมูลการรับวัคซีน (EPI)</a></li>-->
            <li><a href="javascript:void(0);" data-name="btn_anc"><i class="icon-eye-open"></i> บันทึกข้อมูลการฝากครรภ์ (ANC)</a></li>
            <li><a href="javascript:void(0);" data-name="btn_postnatal"><i class="icon-headphones"></i> เยี่ยมหลังคลอดมารดา</a></li>
            <li><a href="javascript:void(0);" data-name="btn_baby_care"><i class="icon-headphones"></i> เยี่ยมหลังคลอดเด็ก</a></li>
            <li><a href="javascript:void(0);" data-name="btn_specialpp"><i class="icon-eye-close"></i> ให้บริการส่งเสริมป้องกัน (Special PP)</a></li>
            <li><a href="javascript:void(0);" data-name="btn_community_service"><i class="icon-eye-close"></i> ให้บริการในชุมชน (Community Service)</a></li>
            <!--                    <li><a href="javascript:void(0);" data-name="btn_icf"><i class="icon-briefcase"></i> ประเมินภาวะสุขภาพผู้พิการ (ICF)</a></li>-->
            <li class="disabled"><a href="javascript:void(0);" data-name="btn_rehabilitation"><i class="icon-refresh"></i> การฟื้นฟูสมรรถภาพ (ผู้พิการหรือผู้สูงอายุ)</a></li>
            <li><a href="javascript:void(0);" data-name="btn_dental"><i class="icon-th"></i> ตรวจสภาวะทันตสุขภาพของฟัน</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" type="button"><i class="icon-check"></i> งานคัดกรอง
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li class="disabled"><a href="javascript:void(0);" data-name="btn_chronic_fu"><i class="icon-tags"></i> คัดกรองความเสี่ยง (เบาหวาน, ความดัน)</a></li>
            <li><a href="javascript:void(0);" data-name="btn_depress"><i class="icon-leaf"></i> คัดกรองโรคซึมเศร้า</a></li>
            <li><a href="javascript:void(0);" data-name="btn_papsemear"><i class="icon-fire"></i> คัดกรองมะเร็งปากมดลูก</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button"><i class="icon-briefcase"></i> กิจกรรมอื่นๆ
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="javascript:void(0);" data-name="btn_chronic_fu"><i class="icon-eye-close"></i> คัดกรองภาวะแทรกซ้อน</a></li>
        </ul>
    </div>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-success" id="btn_save_screening"
            rel="tooltip" title="บันทึกข้อมูลคัดกรอง"><i class="icon-save"></i></button>
        <button type="button" class="btn btn-default" id="btn_edit_service"
            rel="tooltip" title="แก้ไขข้อมูลส่งตรวจ"><i class="icon-edit"></i></button>
        <button type="button" class="btn btn-danger" id="btn_remove_service"
            rel="tooltip" title="ลบรายการส่งตรวจ"><i class="icon-trash"></i></button>
        <button type="button" class="btn btn-primary"
            rel="tooltip" title="ประวัติการรับบริการ"><i class="icon-time"></i></button>
    </div>
</div>

<input type="hidden" id="vn" value="<?php echo $vn; ?>">
<input type="hidden" id="hn" value="<?php echo $hn; ?>">
<input type="hidden" id="person_sex" value="<?php echo $sex; ?>">

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_screening" data-toggle="tab"><i class="icon-th-list"></i> ข้อมูลคัดกรอง</a></li>
        <li><a href="#tab_diagnosis" data-toggle="tab"><i class="icon-check"></i> วินิจฉัยโรค</a></li>
        <li><a href="#tab_procedure" data-toggle="tab"><i class="icon-eye-close"></i> หัตถการ</a></li>
        <li><a href="#tab_dental_charge_item" data-toggle="tab"><i class="icon-check-sign"></i> ทันตกรรม</a></li>
        <li><a href="#tab_vaccine" data-toggle="tab"><i class="icon-pushpin"></i> วัคซีน</a></li>
        <li><a href="#tab_drug" data-toggle="tab"><i class="icon-filter"></i> จ่ายยา</a></li>
        <li><a href="#tab_income" data-toggle="tab"><i class="icon-shopping-cart"></i> ค่าใช้จ่าย</a></li>
        <li><a href="#tab_appoint" data-toggle="tab"><i class="icon-calendar"></i> ลงทะเบียนนัด</a></li>
        <li><a href="#tab_refer" data-toggle="tab"><i class="icon-share"></i> ส่งต่อ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_screening">
            <blockquote>บันทึกข้อมูลการให้บริการผู้ป่วย <p class="text-warning">กรุณาบันทึกข้อมูลให้ถูกต้องและสมบูรณ์เพื่อป้องกันข้อมูลผิดพลาดเวลาส่งออก</p></blockquote>
            <div class="row">
                <div class="col-lg-3">
                    <select id="sl_intime" title="เวลารับบริการ" rel="tooltip" disabled>
                        <option value="1">[1] ในเวลาราชการ</option>
                        <option value="2">[2] นอกเวลาราชการ</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <select id="sl_location" title="ประเภทที่ตั้งของที่อยู่ผู้รับบริการ" rel="tooltip" disabled>
                        <option value="1">[1] ในเขต</option>
                        <option value="2">[2] นอกเขต</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <select id="sl_typein" title="ประเภทเวลาการมารับบริการ" rel="tooltip" disabled>
                        <option value="1">[1] มารับบริการเอง</option>
                        <option value="2">[2] มารับบริการตามนัดหมาย</option>
                        <option value="3">[3] ได้รับการส่งต่อจากสถานพยาบาลอื่น</option>
                        <option value="4">[4] ได้รับการส่งตัวจากบริการ EMS</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <select id="sl_typeout" title="ระบุสถานะปัจจุบันของผู้มารับบริการ" rel="tooltip">
                        <option value="1">[1] จำหน่ายกลับบ้าน</option>
                        <option value="2">[2] รับไว้รักษาต่อในแผนกผู้ป่วยใน</option>
                        <option value="3">[3] ส่งต่อไปสถานพยาบาลอื่น</option>
                        <option value="4">[4] เสียชีวิต</option>
                        <option value="5">[5] เสียชีวิตก่อนมาถึงสถานพยาบาล</option>
                        <option value="6">[6] เสียชีวิตระหว่างส่งต่อไปยังสถานบริการอื่น</option>
                        <option value="7">[7] ปฏิเสธการรักษา</option>
                        <option value="8">[8] หนีกลับ</option>
                    </select>
                </div>
            </div>
            <br>
            <legend><i class="icon-eye-close"></i> คัดกรองผู้ป่วย</legend>
            <div class="row">
                <div class="col-lg-2">
                    <label for="txt_screening_weight">น้ำหนัก</label>
                    <div class="input-group" style="width: 100px;">
                        <input data-type="number" id="txt_screening_weight" type="text">
                        <span class="input-group-addon">กก.</span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="txt_screening_height">ส่วนสูง</label>
                    <div class="input-group" style="width: 100px;">
                        <input data-type="number" id="txt_screening_height" type="text">
                        <span class="input-group-addon">ซม.</span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="txt_screening_body_tmp">อุณหภูมิ</label>
                    <div class="input-group" style="width: 100px;">
                        <input data-type="number" id="txt_screening_body_tmp" type="text">
                        <span class="input-group-addon">C.</span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="txt_screening_waist">รอบเอว</label>
                    <div class="input-group" style="width: 100px;">
                        <input data-type="number" id="txt_screening_waist" type="text">
                        <span class="input-group-addon">ซม.</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <label for="txt_screening_pluse">ชีพจร</label>
                    <div class="input-group" style="width: 100px;">
                        <input data-type="number" id="txt_screening_pluse" type="text">
                        <span class="input-group-addon">m.</span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="txt_screening_breathe">หายใจ</label>
                    <div class="input-group" style="width: 100px;">
                        <input data-type="number" id="txt_screening_breathe" type="text">
                        <span class="input-group-addon">m.</span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="txt_screening_sbp">ความดัน SBP</label>
                    <div class="input-group" style="width: 100px;">
                        <input data-type="number" id="txt_screening_sbp" type="text">
                        <span class="input-group-addon">มป.</span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="txt_screening_dbp">ความดัน DBP</label>
                    <div class="input-group" style="width: 100px;">
                        <input data-type="number" id="txt_screening_dbp" type="text">
                        <span class="input-group-addon">มป.</span>
                    </div>
                </div>
            </div>
            <br>
            <!-- tab cc -->
            <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_screening_cc" data-toggle="tab"><i class="icon-th-list"></i> อาการแรกรับ (CC)</a>
                </li>
                <li>
                    <a href="#tab_screening_pe" data-toggle="tab"><i class="icon-eye-close"></i> PE</a>
                </li>
                <li>
                    <a href="#tab_screening_ill_history" data-toggle="tab"><i class="icon-time"></i> เจ็บป่วยในอดีต</a>
                </li>
                <li>
                    <a href="#tab_screening_allergy" data-toggle="tab"><i class="icon-warning-sign"></i> แพ้ยา</a>
                </li>
                <li>
                    <a href="#tab_screening_screen" data-toggle="tab"><i class="icon-list"></i> คัดกรอง</a>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon-briefcase"></i> อื่นๆ
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#tab_screening_lmp" data-toggle="tab"><i class="icon-calendar"></i> ประจำเดือน (LMP)</a>
                        </li>
                        <li>
                            <a href="#tab_screening_consult" data-toggle="tab"><i class="icon-bullhorn"></i> การให้คำแนะนำ</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="tab-content">
            <div class="tab-pane active" id="tab_screening_cc">
                <blockquote>บันทึกข้อมูลอาการสำคัญ (Chief complaint)</blockquote>
                <textarea rows="3" id="txt_screening_cc" placeholder="บันทึกข้อมูลอาการสำคัญ (Chief complaint)"
                          rel="tooltip" title="บันทึกข้อมูลอาการสำคัญ (Chief complaint)"></textarea>
            </div>
            <div class="tab-pane" id="tab_screening_pe">
                <blockquote>บันทึกข้อมูล Physical examination</blockquote>
                <textarea rows="3" id="txt_screening_pe" placeholder="บันทึกข้อมูล Physical examination"
                          title="บันทึกข้อมูล Physical examination" rel="tooltip"></textarea>
            </div>
            <div class="tab-pane" id="tab_screening_ill_history">
                <blockquote>ประวัติการเจ็บป่วยในอดีต</blockquote>
                <div class="control-group">
                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="rd_ill_history" id="rd_ill_history1" checked="checked" value="0"> ปฏิเสธโรคประจำตัวและการผ่าตัด
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="rd_ill_history" id="rd_ill_history2" value="1"> มีโรคประจำตัว
                        </label>
                        <input type="text" id="txt_ill_history_ill_detail" rel="tooltip" title="ระบุโรคประจำตัว" placeholder="ระบุโรคประจำตัว">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox">
                            <input type="checkbox" id="chk_operate"> ผ่าตัด
                        </label>
                        <input type="text" rel="tooltip" placeholder="ระบุอาการที่ผ่าตัด" title="ระบุอาการที่ผ่าตัด" id="txt_ill_history_operate_detail">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label for="txt_operate_year">ปีที่ผ่าตัด</label>
                        <input type="text" rel="tooltip" title="ระบุปี พ.ศ" placeholder="yyyy" data-type="year" style="width: 100px;" data-type="year" id="txt_operate_year">
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_screening_allergy">
                <blockquote>บันทึกข้อมูลการแพ้ยา (Drug allergy)</blockquote>
                <div class="row-fluid">
                    <div class="span12">
                        <table class="table table-striped table-hover" id="tbl_screening_allergy_list">
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
                        <button class="btn btn-success" id="btn_screening_add_drgu_allergy" title="เพิ่มรายการ" rel="tooltip">
                            <i class="icon-plus-sign"></i>
                        </button>
                        <button class="btn btn-default" id="btn_screening_refresh_drug_allergy" title="รีเฟรชรายการ" rel="tooltip">
                            <i class="icon-refresh"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_screening_screen">
                <br>
                <div class="row">
                    <div class="col col-lg-4">
                        <form action="#">
                            <legend><i class="icon-glass"></i> สูบบุหรี่/ดื่มเหล้า</legend>
                            <label for="sl_screening_smoking">สูบบุหรี่</label>
                            <select id="sl_screening_smoking" style="width: 200px;">
                                <?php foreach($smokings as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                            <label for="sl_screening_drinking">ดื่มสุรา</label>
                            <select id="sl_screening_drinking" style="width: 200px;">
                                <?php foreach($drinkings as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                        </form>
                    </div>
                    <div class="col col-lg-4">
                        <form action="#">
                            <legend><i class="icon-rss"></i> ประเมินสุขภาพจิต</legend>
                            <label class="checkbox" for="chk_screening_screen_mind_strain">
                                <input type="checkbox" id="chk_screening_screen_mind_strain"> เครียด/วิตกกังวล
                            </label>
                            <label class="checkbox" for="chk_screening_screen_mind_work">
                                <input type="checkbox" id="chk_screening_screen_mind_work"> ปัญหาการเงิน/การทำงาน/เพื่อนร่วมงาน
                            </label>
                            <label class="checkbox" for="chk_screening_screen_mind_family">
                                <input type="checkbox" id="chk_screening_screen_mind_family"> ปัญหาครอบครัว
                            </label>
                            <label class="checkbox" for="chk_screening_screen_mind_other">
                                <input type="checkbox" id="chk_screening_screen_mind_other"> อื่นๆ
                            </label>
                            <textarea rows="3" id="txt_screening_screen_mind_other_detail"></textarea>
                        </form>
                    </div>
                    <div class="col col-lg-4">
                        <form action="#">
                            <legend><i class="icon-warning-sign"></i> ภาวะเสี่ยง</legend>
                            <label class="checkbox" for="chk_screening_screen_risk_ht">
                                <input type="checkbox" id="chk_screening_screen_risk_ht"> เสี่ยงต่อการเป็นความดันโลหิตสูง
                            </label>
                            <label class="checkbox" for="chk_screening_screen_risk_dm">
                                <input type="checkbox" id="chk_screening_screen_risk_dm"> เสี่ยงต่อการเป็นเบาหวาน
                            </label>
                            <label class="checkbox" for="chk_screening_screen_risk_stoke">
                                <input type="checkbox" id="chk_screening_screen_risk_stoke"> เสี่ยงต่อการเป็นโรคหัวใจ
                            </label>
                            <label class="checkbox" for="chk_screening_screen_risk_other">
                                <input type="checkbox" id="chk_screening_screen_risk_other"> อื่นๆ
                            </label>
                            <textarea id="txt_screening_screen_risk_other_detail" rows="3"></textarea>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_screening_lmp">
                <blockquote>บันทึกข้อมูลการมีประจำเดือน (LMP)</blockquote>
                <form action="#">
                    <div class="row">
                        <div class="col col-lg-3">
                            <label class="control" for="sl_screening_lamp">การมาของประจำเดือน (LMP)</label>
                            <select id="sl_screening_lamp" style="width: 250px;">
                                <option value="">-- ไม่ระบุ --</option>
                                <option value="0">ประจำเดือนไม่มา</option>
                                <option value="1">ประจำเดือนมาปกติ (มีประจำเดือน)</option>
                            </select>
                        </div>
                        <div class="col col-lg-2">
                            <label for="txt_screening_lmp_start">วันที่ประจำเดือนมา</label>
                            <input id="txt_screening_lmp_start" style="width: 100px;" type="text" data-type="date"
                                   title="ระบุวันที่ รูปแบบ พ.ศ เช่น 28/02/2556" rel="tooltip" placeholder="วว/ดด/ปปปป">
                        </div>
                        <div class="col col-lg-2">
                            <label for="txt_screening_lmp_finished">วันที่ประจำเดือนไม่มา</label>
                            <input id="txt_screening_lmp_finished" style="width: 100px;" type="text" data-type="date"
                                   title="ระบุวันที่ รูปแบบ พ.ศ เช่น 28/02/2556" rel="tooltip" placeholder="วว/ดด/ปปปป">
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="tab_screening_consult">
                <blockquote>บันทึกข้อมูลการให้คำแนะนำ</blockquote>
                <form action="#">
                    <legend>ข้อมูลการให้คำแนะนำ</legend>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox" for="chk_screening_consult_drug">
                                <input type="checkbox" id="chk_screening_consult_drug"> แนะนำในการใช้ยา
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox" for="chk_screening_consult_activity">
                                <input type="checkbox" id="chk_screening_consult_activity"> แนะนำการปฏิบัติตัวให้เหมาะสมกับโรค
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox" for="chk_screening_consult_food">
                                <input type="checkbox" id="chk_screening_consult_food"> แนะนำการรับประทานอาหาร
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox" for="chk_screening_consult_appoint">
                                <input type="checkbox" id="chk_screening_consult_appoint"> แนะนำการมาตรวจตามนัดหมาย
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox" for="chk_screening_consult_exercise">
                                <input type="checkbox" id="chk_screening_consult_exercise"> แนะนำการออกกำลังกาย
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox" for="chk_screening_consult_complication">
                                <input type="checkbox" id="chk_screening_consult_complication"> แนะนำการป้องกันภาวะแทรกซ้อน
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox" for="chk_screening_consult_other_detail">
                                <input type="checkbox" id="chk_screening_consult_other"> อื่นๆ
                            </label>
                            <textarea class="input-xlarge" id="chk_screening_consult_other_detail" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            </div>
            <!-- end tab cc -->
<br>
        </div>
        <div class="tab-pane" id="tab_diagnosis">
            <blockquote>บันทึกข้อมูลการวินิจฉัยโรค โดยบันทึกได้ทั้ง ICD10 WHO และ ICD10-TM</blockquote>
            <table class="table table-striped" id="tbl_diag_list">
                <thead>
                <tr>
                    <th>#</th>
                    <th>รหัส</th>
                    <th>รายการ</th>
                    <th>ประเภทการวินิจฉัย</th>
                    <th>เจ้าหน้าที่</th>
                    <th>แผนก</th>
                    <th></th>
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
            <button class="btn btn-default" rel="tooltip" title="รีเฟรชรายการ" id="btn_diag_refresh"><i class="icon-refresh"></i></button>
            <button class="btn btn-success" rel="tooltip" title="เพิ่มรายการ" id="btn_diag_new"><i class="icon-plus-sign"></i></button>
        </div>
        <div class="tab-pane" id="tab_procedure">
            <blockquote>บันทึกข้อมูลการให้หัตถการ โดยสามารถบันทึกได้ทั้ง ICD9-CM และ ICD10-TM</blockquote>
            <table class="table table-striped" id="tbl_proced_list">
                <thead>
                <tr>
                    <th>#</th>
                    <th>แผนก</th>
                    <th>รหัส</th>
                    <th>รายการ</th>
                    <th>ราคา</th>
                    <th>เวลาเริ่ม</th>
                    <th>เวลาสิ้นสุด</th>
                    <th>ผู้ทำหัถการ</th>
                    <th></th>
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

            <button class="btn btn-default" rel="tooltip" title="รีเฟรชรายการ" id="btn_proced_refresh"><i class="icon-refresh"></i></button>
            <button class="btn btn-success" rel="tooltip" title="เพิ่มรายการ" id="btn_proced_new"><i class="icon-plus-sign"></i></button>

        </div>
        <div class="tab-pane" id="tab_dental_charge_item">
            <blockquote>บันทึกข้อมูลกิจกรรม/ค่าใช้จ่ายที่ใช้ในงานทันตกรรม</blockquote>
            <table class="table table-striped" id="tbl_charge_item_list">
                <thead>
                <tr>
                    <th>#</th>
                    <th>รายการ</th>
                    <th>ซี่ฟัน</th>
                    <th>ด้าน</th>
                    <th>ราคา</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="6">...</td>
                </tr>
                </tbody>
            </table>

            <button type="button" class="btn btn-success" id="btn_new_charge_dental"
                rel="tooltip" title="เพิ่มรายการ">
                <i class="icon-plus"></i>
            </button>
        </div>
        <div class="tab-pane" id="tab_vaccine">
            <blockquote>บันทึกข้อมูลการให้วัคซีนสำหรับกลุ่มเป้าหมายและบุคคลทั่วไป</blockquote>
            <table class="table table-striped" id="tbl_vaccine_list">
                <thead>
                <tr>
                    <th>#</th>
                    <th>รายการวัคซีน</th>
                    <th>Lot number</th>
                    <th>Expire date</th>
                    <th>แพทย์/เจ้าหน้าที่</th>
                    <th></th>
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
            <button type="button" class="btn btn-success" id="btn_new_vaccine" title="เพิ่มรายการ" rel="tooltip">
                <i class="icon-plus-sign"></i>
            </button>
            <button type="button" class="btn btn-primary" id="btn_vaccine_history" title="ดูประวัติการรับวัคซีน" rel="tooltip">
                <i class="icon-time"></i>
            </button>
            <button type="button" class="btn btn-default" id="btn_vaccine_refresh" title="รีเฟรชรายการใหม่" rel="tooltip">
                <i class="icon-refresh"></i>
            </button>
        </div>
        <div class="tab-pane" id="tab_drug">
            <blockquote>ระบุรายการยาที่จ่ายให้กับผู้รับบริการ</blockquote>
            <table class="table table-striped" id="tbl_drug_list">
                <thead>
                <tr>
                    <th>#</th>
                    <th>รายการ</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>วิธีใช้</th>
                    <th></th>
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
                <button type="button" class="btn btn-success" id="btn_drug_new" rel="tooltip" title="เพิ่มรายการ"><i class="icon-plus-sign"></i></button>
                <button type="button" class="btn btn-default" rel="tooltip" title="กำหนดสูตรยา"><i class="icon-th-list"></i></button>
                <button type="button" class="btn btn-default"rel="tooltip" title="Remed."><i class="icon-exchange"></i></button>
            </div>
            <button type="button" class="btn btn-success" rel="tooltip" title="รีเฟรชรายการใหม่" id="btn_drug_refresh"><i class="icon-refresh"></i></button>
            <button type="button" class="btn btn-danger" rel="tooltip" title="ลบใบสั่งยา" id="btn_drug_remove_bill"><i class="icon-trash"></i></button>
        </div>
        <!-- Charge item -->
        <div class="tab-pane" id="tab_income">
            <blockquote>รายการค่าใช้จ่ายนอกเนือจากยา และ หัตถการ</blockquote>
            <table class="table table-striped" id="tbl_charge_list">
                <thead>
                <tr>
                    <th>#</th>
                    <th>รหัส</th>
                    <th>รายการ</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>รวม (บาท)</th>
                    <th></th>
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
            <button type="button" class="btn btn-success" title="เพิ่มรายการใหม่" rel="tooltip" id="btn_charge_new"><i class="icon-plus-sign"></i></button>
            <button type="button" class="btn btn-default" title="รีเฟรชรายการใหม่" rel="tooltip" id="btn_charge_refresh"><i class="icon-refresh"></i></button>
        </div>
        <!-- end charge item -->
        <div class="tab-pane" id="tab_appoint">
            <blockquote>ลงบันทึกการนัดผู้ป่วย</blockquote>
            <table class="table table-striped" id="tbl_appoint_list">
                <thead>
                <tr>
                    <th>#</th>
                    <th>วันที่</th>
                    <th>เหตุผลการนัด</th>
                    <th>การวินิจฉัย (รหัส Z)</th>
                    <th>แผนกที่นัด</th>
                    <th>แพทย์ผู้นัด (Provider)</th>
                    <th></th>
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
            <button type="button" class="btn btn-success" id="btn_appoint_new"
                title="เพิ่มรายการนัด" rel="tooltip"><i class="icon-plus-sign"></i></button>
            <button type="button" class="btn btn-default" id="btn_appoint_refresh"
                title="รีเฟรชรายการใหม่" rel="tooltip"><i class="icon-refresh"></i></button>
        </div>
        <div class="tab-pane" id="tab_refer">
            <blockquote>บันทึกข้อมูลการรับส่งต่อ</blockquote>
            <ul class="nav nav-tabs">

                <li class="active"><a href="#tab_refer_out" data-toggle="tab"><i class="icon-share-sign"></i> ส่งต่อ (Refer Out)</a></li>
                <li><a href="#tab_refer_in" data-toggle="tab"><i class="icon-share"></i> รับส่งต่อ (Refer In)</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="tab_refer_in">
                    Under construction.
                </div>
                <div class="tab-pane active" id="tab_refer_out">
                    <table class="table table-striped" id="tbl_refer_out_list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>วันที่ส่ง</th>
                            <th>เลขที่ส่งต่อ</th>
                            <th>สถานที่ส่ง</th>
                            <th>แผนกที่ส่ง</th>
                            <th>แพทย์</th>
                            <th></th>
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
                    <button type="button" class="btn btn-success" id="btn_new_refer_out"
                            title="บันทึกส่งต่อ" rel="tooltip"><i class="icon-plus-sign"></i></button>
                    <button type="button" class="btn btn-default" id="btn_rfo_refresh"
                            title="รีเฟรชรายการใหม่" rel="tooltip"><i class="icon-refresh"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_new_refer_out">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-share"></i> บันทึกส่งต่อผู้ป่วย [<span id="spn_refer_out_vn"></span>]</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_new_appointment">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-calendar"></i> ลงทะเบียนนัดผู้ป่วย [<span id="spn_appoint_vn"></span>]</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- new drug allergy -->
<div class="modal fade" id="modal_screening_allergy">
    <div class="modal-dialog" style="width: 960px; left: 35%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-exclamation-sign"></i> ข้อมูลการแพ้ยา [<span id="spn_allergy_vn"></span>]</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>
<!-- end drug allergy -->

<!-- new diagnosis -->
<div class="modal fade" id="mdl_diag_new">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-check-sign"></i> เพิ่มรายการวินิจฉัยโรค</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- end new diagnosis -->
<div class="modal fade" id="mdl_proced_new">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-briefcase"></i> เพิ่มข้อมูลการทำหัตถการ [<span id="spn_procedure_vn"></span>]</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<!-- new drug -->
<div class="modal fade" id="mdl_drug_new">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-plus-sign"></i> เพิ่ม/แก้ไขรายการยา [<span id="spn_drug_vn"></span>]</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- end new drug -->
<!-- new charge item -->
<div class="modal fade" id="mdl_charge_new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-shopping-cart"></i> เพิ่มรายการค่าใช้จ่าย [<span id="spn_charge_vn"></span>]</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- end new charge item -->
<!-- new dental charge item -->
<div class="modal fade" id="mdl_dental_charge_new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-shopping-cart"></i> เพิ่มรายการค่าใช้จ่าย</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txt_charge_dental_id"/>
                <label>ค่าใช้จ่าย/กิจกรรม</label>
                <select id="sl_charge_dental_items">
                    <option value="">-*-</option>
                    <?php
                    foreach($dental_charge_items as $r)
                    {
                        echo '<option value="'.$r->id.'" data-price="'.$r->price.'">' . $r->name . '</option>';
                    }
                    ?>
                </select>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="">ราคา</label>
                        <div class="input-group" style="width: 150px;">
                            <input data-type="number" id="txt_charge_dental_price" type="text" placeholder="0.0">
                            <span class="input-group-addon">บาท</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7">
                        <label for="">ซี่ (มีหลายซี่ใช้เครื่องหมาย , คั่น)</label>
                        <input type="text" placeholder="#15, #12" id="txt_charge_dental_teeth" />
                    </div>
                    <div class="col-lg-5">
                        <label for="">ด้าน</label>
                        <input type="text" data-type="number" placeholder="0" id="txt_charge_dental_side" />
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-success" id="btn_save_charge_dental"><i class="icon-save"></i> บันทึก</a>
                <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- end new dental charge item -->

<!-- FP -->
<div class="modal fade" id="mdl_fp">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-check"></i> เพิ่มข้อมูลการวางแผนครอบครัว</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!--  end FP -->
<!-- EPI -->
<div class="modal fade" id="mdl_vaccines">
    <div class="modal-dialog" style="width: 960px; left: 35%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-pushpin"></i> บันทึกข้อมูลการให้วัคซีน</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- end EPI -->

<!-- Nutrition -->
<div class="modal fade" id="mdl_nutri">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">ข้อมูลระดับโภชนาการ</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- end Nutrition -->

<!-- ANC -->
<div class="modal fade" id="mdl_anc">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-briefcase"></i> ข้อมูลการฝากครรภ์</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- /ANC -->
<!-- Mother care -->
<div class="modal fade" id="mdl_postnatal">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-user-md"></i> ข้อมูลการดูแลมารดาหลังคลอด (Postnatal)</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- /Mother care -->

<!-- เยี่ยมหลังคลอด เด็ก -->
<div class="modal fade" id="mdl_babies_care">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">ข้อมูลการตรวจเด็กหลังคลอด</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- /เยี่ยมหลังคลอด เด็ก -->

<!-- SPECIAL PP -->
<div class="modal fade" id="mdl_special_pp">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">การให้บริการส่งเสริมสุขภาพป้องกันโรคเฉพาะ (Special PP)</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- /SPECIAL PP -->
<!-- Community Service -->
<div class="modal fade" id="mdl_comms">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">การให้บริการในชุมชน (Community Service)</h4>
            </div>
            <div class="modal-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_comms1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
                        <li><a href="#tab_comms2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_comms1">
                            <br>
                            <form class="form-horizontal">
                                <legend>การให้บริการวันนี้</legend>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label class="control-label" for="sl_comms">ประเภทบริการ</label>
                                        <select id="sl_comms">
                                            <option value="">--</option>
                                            <?php
                                            $comms = get_community_service_list();
                                            foreach($comms as $r)
                                            {
                                                echo '<option value="'.$r->id.'">' . $r->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="sl_comms_providers" class="control-label" >ผู้ให้บริการ</label>
                                        <select id="sl_comms_providers">
                                            <option value="">-*-</option>
                                            <?php
                                            foreach($providers as $p)
                                            {
                                                echo '<option value="'.$p->id.'">' . $p->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <button class="btn btn-success" type="button" id="btn_comms_save">
                                <i class="icon-save"></i> บันทึกข้อมูล
                            </button>
                            <br>
                            <br>
                            การให้บริการในวันนี้
                            <table class="table table-striped" id="tbl_comms_visit_list">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รายการ</th>
                                    <th>ผู้ให้บริการ</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="4">ไม่พบรายการ..</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab_comms2">
                            <legend>ประวัติการรับบริการ</legend>
                            <table class="table table-striped" id="tbl_comms_history">
                                <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>หน่วยบริการ</th>
                                    <th>กิจกรรม</th>
                                    <th>ผู้ให้บริการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="4">...</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- /Community service -->

<!-- dental -->
<div class="modal fade" id="mdl_dental">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">ประเมินสุขภาพฟัน</h4>
            </div>
            <div class="modal-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_dental1" data-toggle="tab"><i class="icon-plus"></i> การให้บริการวันนี้</a></li>
                        <li><a href="#tab_dental2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_dental1">
                            <br>
                            <form class="form-horizontal">
                                <div class="alert alert-success">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="control-label" for="sl_dental_denttype">ประเภทผู้รับบริการ</label>
                                            <select id="sl_dental_denttype">
                                                <option value="">--</option>
                                                <option value="1">กลุ่มหญิงตั้งครรภ์</option>
                                                <option value="2">กลุ่มเด็กก่อนวัยเรียน</option>
                                                <option value="3">กลุ่มเด็กวัยเรียน</option>
                                                <option value="4">กลุ่มผู้สูงอายุ</option>
                                                <option value="5">กลุ่มอื่นๆ</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-5">
                                            <label for="sl_dental_providers" class="control-label" >ผู้ให้บริการ</label>
                                            <select id="sl_dental_providers">
                                                <option value="">-*-</option>
                                                <?php
                                                foreach($providers as $p)
                                                {
                                                    echo '<option value="'.$p->id.'">' . $p->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabbable">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab_dental_survey1" data-toggle="tab"><i class="icon-file"></i> การสำรวจสภาพฟัน</a></li>
                                        <li><a href="#tab_dental_survey2" data-toggle="tab"><i class="icon-time"></i> การให้คำแนะนำ</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_dental_survey1">
                                            <legend>ฟันแท้</legend>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <label class="control-label" for="txt_dental_pteeth">มีอยู่ (ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_pteeth">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="control-label" for="txt_dental_pcaries">ผุที่ไม่ได้อุด (ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_pcaries">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="control-label" for="txt_dental_pfilling">ได้อุด (ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_pfilling">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="control-label" for="txt_dental_pextract">ถอน/หลุด (ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_pextract">
                                                </div>
                                            </div>
                                            <legend>ฟันน้ำนม</legend>

                                            <div class="row">

                                                <div class="col-lg-2">
                                                    <label class="control-label" for="txt_dental_dteeth">มีอยู่ (ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_dteeth">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="control-label" for="txt_dental_dfilling">ได้อุด (ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_dfilling">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="control-label" for="txt_dental_dcaries">ผุไม่ได้อุด(ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_dcaries">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="control-label" for="txt_dental_dextract">ที่ถอน/หลุด(ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_dextract">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label class="control-label" for="sl_dental_gum">สภาวะปริทันต์</label>
                                                    <select id="sl_dental_gum">
                                                        <option value="">--</option>
                                                        <option value="0">ปกติ</option>
                                                        <option value="1">มีเลือดออกภายหลังจากการตรวจ</option>
                                                        <option value="2">มีหินน้ำลายแต่ยังเห็นแถบดำบนเครื่องมือ</option>
                                                        <option value="3">มีร่องลึกปริทันต์ 4-5 ม.ม. (ขอบเงือกอยู่ภายในแถบดำ)</option>
                                                        <option value="4">มีร่องลึกปริทันต์ 6 ม.ม. หรือ มากกว่า (มองไม่เห็นแถบดำบนเครื่องมือ)</option>
                                                        <option value="5">มีหินน้ำลายและมีเลือดออกภายหลังการตรวจ</option>
                                                        <option value="9">ตรวจไม่ได้/ไม่ตรวจ</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab_dental_survey2">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="txt_dental_need_sealant">ต้องเคลือบ(ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_need_sealant">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="sl_dental_need_fluoride">เคลือบฟลูออไรด์</label>
                                                    <select id="sl_dental_need_fluoride">
                                                        <option value="">--</option>
                                                        <option value="1">ต้องทา/เคลือบฟลูออไรด์</option>
                                                        <option value="2">ไม่ต้องทา/เคลือบฟลูออไรด์</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="sl_dental_need_scaling">ขุดหินน้ำลาย</label>
                                                    <select id="sl_dental_need_scaling">
                                                        <option value="">--</option>
                                                        <option value="1">ต้องขูดหินน้ำลาย</option>
                                                        <option value="2">ไม่ต้องขูดหินน้ำลาย</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="txt_dental_need_pfilling">ฟันแท้ที่ต้องอุด(ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_need_pfilling">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="txt_dental_need_dfilling">ฟันน้ำนมที่ต้องอุด(ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_need_dfilling">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="txt_dental_need_pextract">ฟันแท้ที่ต้องถอน(ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_need_pextract">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="txt_dental_need_dextract">ฟันน้ำนมที่ต้องถอน(ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_need_dextract">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="txt_dental_nprosthesis">ต้องใส่ฟันเทียม(ซี่)</label>
                                                    <input type="text" data-type="number" id="txt_dental_nprosthesis">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="txt_dental_permanent_perma">คู่สบฟันแท้กับฟันแท้</label>
                                                    <input type="text" data-type="number" id="txt_dental_permanent_perma">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="txt_dental_permanent_prost">คู่สบฟันแท้กับฟันเทียม</label>
                                                    <input type="text" data-type="number" id="txt_dental_permanent_prost">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="txt_dental_prosthesis_prost">คู่สบฟันเทียมกับฟันเทียม</label>
                                                    <input type="text" data-type="number" id="txt_dental_prosthesis_prost">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <label class="control-label" for="sl_dental_schooltype">สถานศึกษา</label>
                                                    <select id="sl_dental_schooltype">
                                                        <option value="">--</option>
                                                        <option value="1">ศพด.</option>
                                                        <option value="2">ประถมศึกษารัฐบาล</option>
                                                        <option value="3">ประถมศึกษาเทศบาล</option>
                                                        <option value="4">ประถมศึกษาท้องถิ่น</option>
                                                        <option value="5">ประถมศึกษาเอกชน</option>
                                                        <option value="6">มัธยมศึกษารัฐบาล</option>
                                                        <option value="7">มัธยมศึกษาเทศบาล</option>
                                                        <option value="8">มัธยมศึกษาท้องถิ่น</option>
                                                        <option value="9">มัธยมศึกษาเอกชน</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="control-label" for="txt_dental_school_class">ระดับการศึกษา</label>
                                                    <input type="text" data-type="number" id="txt_dental_school_class">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="btn_icf_save">&nbsp;</label>
                                    <div class="controls">
                                        <button class="btn btn-success" type="button" id="btn_dental_save">
                                            <i class="icon-save"></i> บันทึกข้อมูล
                                        </button>
                                        <button class="btn btn-danger" type="button" id="btn_dental_remove">
                                            <i class="icon-trash"></i> ลบข้อมูลการให้บริการ
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab_dental2">
                            <legend>ประวัติการรับบริการ</legend>
                            <table class="table table-striped" id="tbl_dental_history">
                                <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>หน่วยบริการ</th>
                                    <th>ประเภทผู้รับบริการ</th>
                                    <th>สถานที่</th>
                                    <th>สภาวะปริทันต์</th>
                                    <th>ผู้ให้บริการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="6">...</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /dental -->

<!-- Lab order -->
<div class="modal fade" id="mdl_lab_order">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">สั่ง LAB</h4>
            </div>
            <div class="modal-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_lab1" data-toggle="tab"><i class="icon-file-alt"></i> สั่ง LAB</a></li>
                        <li><a href="#tab_lab2" data-toggle="tab"><i class="icon-check-sign"></i> บันทึกผล</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_lab1">
                            <blockquote>เลือกชุดแล็บเพื่อสั่ง</blockquote>
                            <div class="navbar">
                                <form class="form-inline navbar-form">
                                    <label class="control-label" for="sl_lab_group">ชุด LAB</label>
                                    <select id="sl_lab_group" style="width: 350px;">
                                        <option value="">--</option>
                                        <?php foreach($lab_groups as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                    </select>
                                    <button class="btn btn-primary" id="btn_lab_do_order"><i class="icon-plus-sign"></i> เพิ่ม</button>
                                </form>
                            </div>
                            <table class="table table-striped" id="tbl_lab_group_list">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รายการ</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="3">...</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab_lab2">
                            <br>
                            <blockquote>บันทึกผลการตรวจแล็ป</blockquote>
                            <div class="navbar">
                                <form class="form-inline navbar-form">
                                    <label class="control-label" for="sl_lab_group_result">ชุด LAB</label>
                                    <select id="sl_lab_group_result" style="width: 350px;"></select>
                                </form>
                            </div>
                            <table class="table table-striped" id="tbl_lab_result">
                                <thead>
                                <tr>
                                    <th>รายการ</th>
                                    <th>ผล</th>
                                    <th>หน่วย</th>
                                    <th>ค่าปกติ</th>
                                    <th>#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="4">...</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<div class="modal hide fade" id="mdl_surveil">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>บันทึกข้อมูลระบาดวิทยา</h4>
    </div>
    <div class="modal-body">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_lab1" data-toggle="tab"><i class="icon-plus"></i> บันทึกข้อมูล</a></li>
                <li><a href="#tab_lab2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการป่วย</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_lab1">
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="sl_lab_group">รหัสกลุ่มอาการ</label>
                            <div class="controls">
                                <select id="sl_lab_group" class="input-xlarge">
                                    <option value="">--</option>
                                    <?php foreach($lab_groups as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                </select>
                                <button class="btn btn-info" id="btn_lab_do_order"><i class="icon-plus-sign"></i> เพิ่ม</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped" id="tbl_lab_group_list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>รายการ</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="3">...</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab_lab2">
                    <legend>บันทึกผล LAB</legend>
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="sl_lab_group_result">ชุด LAB</label>
                            <div class="controls">
                                <select id="sl_lab_group_result" class="input-xlarge">

                                </select>

                            </div>
                        </div>
                    </form>
                    <table class="table table-striped" id="tbl_lab_result">
                        <thead>
                        <tr>
                            <th>รายการ</th>
                            <th>ผล</th>
                            <th>หน่วย</th>
                            <th>ค่าปกติ</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="4">...</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>

<div class="modal fade" id="mdl_new_service">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file-alt"></i> ลงทะเบียนส่งตรวจ</h4>
            </div>
            <div class="modal-body"></div>
<!--            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
            </div>-->
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_accident">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file-alt"></i> บันทึกข้อมูลการเกิดอุบัติเหตุ</h4>
            </div>
            <div class="modal-body">
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab"><i class="icon-info-sign"></i> ข้อมูลการเกิดอุบัติเหตุ</a></li>
                        <li><a href="#tab2" data-toggle="tab"><i class="icon-zoom-in"></i> การคัดกรองและการให้บริการ</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <form action="#" class="form-inline">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="control-label" for="txt_aedate">วันที่เกิด</label>
                                        <input id="txt_aedate" type="text" data-type="date">
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="control-label" for="txt_aetime">เวลา</label>
                                        <input type="text" data-type="time" id="txt_aetime">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="control-label" for="sl_aeurgency">ระดับความเร่งด่วน</label>
                                        <select id="sl_aeurgency" >
                                            <option value="">---</option>
                                            <option value="1">Life threatening</option>
                                            <option value="2">Emergency</option>
                                            <option value="3">Urgent</option>
                                            <option value="4">Acute</option>
                                            <option value="5">Non acute</option>
                                            <option value="6">ไม่แน่ใจ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="control-label" for="sl_aetype">ประเภทผู้ป่วยอุบัติเหตุ (19 สาเหตุ)</label>
                                        <select id="sl_aetype">
                                            <option value="">---</option>
                                            <?php
                                            foreach($aetypes as $r){
                                                echo '<option value="'.$r->id.'">' . $r->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="control-label" for="sl_aeplace">สถานที่เกิดอุบัติเหตุ</label>
                                        <select id="sl_aeplace">
                                            <option value="">---</option>
                                            <?php
                                            foreach($aeplaces as $r){
                                                echo '<option value="'.$r->id.'">' . $r->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="control-label" for="sl_aetypein">ประเภทการมารับบริการ</label>
                                        <select id="sl_aetypein">
                                            <option value="">---</option>
                                            <?php
                                            foreach($aetypeins as $r){
                                                echo '<option value="'.$r->id.'">' . $r->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="control-label" for="sl_aetraffic">ประเภทผู้บาดเจ็บ (อุบัติเหตุจราจร)</label>
                                        <select id="sl_aetraffic">
                                            <option value="">---</option>
                                            <?php
                                            foreach($aetraffics as $r){
                                                echo '<option value="'.$r->id.'">' . $r->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="control-label" for="sl_aevehicle">ประเภทยานพาหนะ</label>
                                        <select id="sl_aevehicle">
                                            <option value="">---</option>
                                            <?php
                                            foreach($aevehicles as $r){
                                                echo '<option value="'.$r->id.'">' . $r->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <form action="#">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label class="control-label" for="sl_aealcohol">ดื่มแอลกอฮอลล์</label>
                                        <select id="sl_aealcohol">
                                            <option value="">---</option>
                                            <option value="1">ดื่ม</option>
                                            <option value="2">ไม่ดื่ม</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="control-label" for="sl_aenacrotic_drug">ใช้สารเสพติด</label>
                                        <select id="sl_aenacrotic_drug">
                                            <option value="">---</option>
                                            <option value="1">ใช้</option>
                                            <option value="2">ไม่ใช้</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="control-label" for="sl_aebelt">คาดเข็มขัดนิรภัย</label>
                                        <select id="sl_aebelt">
                                            <option value="">---</option>
                                            <option value="1">คาด</option>
                                            <option value="2">ไม่คาด</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="control-label" for="sl_aehelmet">สวมหมวดนิรภัย</label>
                                        <select id="sl_aehelmet">
                                            <option value="">---</option>
                                            <option value="1">สวม</option>
                                            <option value="2">ไม่สวม</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label class="control-label" for="sl_aeairway">การดูแลการหายใจ</label>
                                        <select id="sl_aeairway">
                                            <option value="">---</option>
                                            <option value="1">มีการดูแลการหายใจก่อนมาถึง</option>
                                            <option value="2">ไม่มีการดูแลการหายใจก่อนมาถึง</option>
                                            <option value="3">ไม่จำเป็น</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="control-label" for="sl_aestopbleed">การห้ามเลือด</label>
                                        <select id="sl_aestopbleed">
                                            <option value="">---</option>
                                            <option value="1">มีการห้ามเลือดก่อนมาถึง</option>
                                            <option value="2">ไม่มีการห้ามเลือดก่อนมาถึง</option>
                                            <option value="3">ไม่จำเป็น</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="control-label" for="sl_aesplint">การใส่ splint/slab</label>
                                        <select id="sl_aesplint">
                                            <option value="">---</option>
                                            <option value="1">มีการใส่ splint/slab ก่อนมาถึง</option>
                                            <option value="2">ไม่มีการใส่ splint/slab ก่อนมาถึง</option>
                                            <option value="3">ไม่จำเป็น</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label class="control-label" for="sl_aefluid">มีการให้น้ำเกลือ</label>
                                        <select id="sl_aefluid">
                                            <option value="">---</option>
                                            <option value="1">มีการให้ IV fluid ก่อนมาถึง</option>
                                            <option value="2">ไม่มีการให้ IV fluid ก่อนมาถึง</option>
                                            <option value="3">ไม่จำเป็น</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="control-label" for="txt_aecoma_eye">ระดับความรู้สึกทางสายตา</label>
                                        <input type="text" data-type="number" id="txt_aecoma_eye">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="control-label" for="txt_aecoma_speak">ระดับความรู้สึกทางการพูด</label>
                                        <input type="text" data-type="number" id="txt_aecoma_speak">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="control-label" for="txt_aecoma_movement">ระดับความรู้สึกการเคลื่อนไหว</label>
                                        <input type="text" data-type="number" id="txt_aecoma_movement">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- end modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_save_accident">
                    <i class="icon-save"></i> บันทึกข้อมูล
                </button>
                <button type="button" class="btn btn-danger" id="btn_remove_accident">
                    <i class="icon-trash"></i> ลบข้อมูลอุบัติเหตุ
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_depress">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-check-sign"></i> บันทึกข้อมูลคัดกรองซึมเศร้า</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_depress_2q" data-toggle="tab"><i class="icon-check-sign"></i> แบบประเมิน 2Q</a></li>
                    <li><a href="#tab_depress_9q" data-toggle="tab"><i class="icon-check-sign"></i> แบบประเมิน 9Q</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_depress_2q">
                        <br>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>รายละเอียด</th>
                                <th>การประเมิน</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>ใน สองสัปดาห์ที่ผ่านมา รวมวันนี้
                                    ท่านรู้สึก หดหู่ เศร้า หรือท้อแท้สิ้นหวัง หรือไม่
                                </td>
                                <td>
                                    <select id="sl_depress_2q1">
                                        <option value="">-*-</option>
                                        <option value="1">มี</option>
                                        <option value="2">ไม่มี</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    ในสองสัปดาห์ที่ผ่านมา รวมวันนี้
                                    ท่านรู้สึก  เบื่อ ทำอะไรก็ไม่เพลิดเพลิน หรือไม่
                                </td>
                                <td>
                                    <select id="sl_depress_2q2">
                                        <option value="">-*-</option>
                                        <option value="1">มี</option>
                                        <option value="2">ไม่มี</option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tab_depress_9q">
                        <br>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>รายละเอียด</th>
                                <th>การประเมิน</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>เบื่อ ไม่สนใจอยากทำอะไร
                                </td>
                                <td>
                                    <select id="sl_depress_9q1">
                                        <option value="">-*-</option>
                                        <option value="1">ไม่เลย</option>
                                        <option value="2">เป็นบางวัน (1-7 วัน)</option>
                                        <option value="3">เป็นบ่อย (มากกว่า 7 วัน)</option>
                                        <option value="4">เป็นทุกวัน</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>ไม่สบายใจ ซึมเศร้า ท้อแท้</td>
                                <td>
                                    <select id="sl_depress_9q2">
                                        <option value="">-*-</option>
                                        <option value="1">ไม่เลย</option>
                                        <option value="2">เป็นบางวัน (1-7 วัน)</option>
                                        <option value="3">เป็นบ่อย (มากกว่า 7 วัน)</option>
                                        <option value="4">เป็นทุกวัน</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>หลับยาก หรือหลับๆ ตื่นๆ หรือหลับมากไป</td>
                                <td>
                                    <select id="sl_depress_9q3">
                                        <option value="">-*-</option>
                                        <option value="1">ไม่เลย</option>
                                        <option value="2">เป็นบางวัน (1-7 วัน)</option>
                                        <option value="3">เป็นบ่อย (มากกว่า 7 วัน)</option>
                                        <option value="4">เป็นทุกวัน</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>เหนื่อยง่าย หรือ ไม่ค่อยมีแรง</td>
                                <td>
                                    <select id="sl_depress_9q4">
                                        <option value="">-*-</option>
                                        <option value="1">ไม่เลย</option>
                                        <option value="2">เป็นบางวัน (1-7 วัน)</option>
                                        <option value="3">เป็นบ่อย (มากกว่า 7 วัน)</option>
                                        <option value="4">เป็นทุกวัน</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>เบื่ออาหาร หรือ กินมากเกินไป</td>
                                <td>
                                    <select id="sl_depress_9q5">
                                        <option value="">-*-</option>
                                        <option value="1">ไม่เลย</option>
                                        <option value="2">เป็นบางวัน (1-7 วัน)</option>
                                        <option value="3">เป็นบ่อย (มากกว่า 7 วัน)</option>
                                        <option value="4">เป็นทุกวัน</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>รู้สึกไม่ดีกับตัวเอง คิดว่า ตัวเองล้มเหลว หรือ ทำให้ตนเองหรือครอบครัว ผิดหวัง</td>
                                <td>
                                    <select id="sl_depress_9q6">
                                        <option value="">-*-</option>
                                        <option value="1">ไม่เลย</option>
                                        <option value="2">เป็นบางวัน (1-7 วัน)</option>
                                        <option value="3">เป็นบ่อย (มากกว่า 7 วัน)</option>
                                        <option value="4">เป็นทุกวัน</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>สมาธิไม่ดีเวลาทำอะไร เช่น ดูโทรทัศน์ ฟังวิทยุ หรือทำงานที่ต้องใช้ความตั้งใจ</td>
                                <td>
                                    <select id="sl_depress_9q7">
                                        <option value="">-*-</option>
                                        <option value="1">ไม่เลย</option>
                                        <option value="2">เป็นบางวัน (1-7 วัน)</option>
                                        <option value="3">เป็นบ่อย (มากกว่า 7 วัน)</option>
                                        <option value="4">เป็นทุกวัน</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>พูดช้า ทำอะไรช้าลงจนคนอื่นสังเกตเห็นได้หรือกระสับกระส่ายไม่สามารถอยู่นิ่งได้เหมือนที่เคยเป็น</td>
                                <td>
                                    <select id="sl_depress_9q8">
                                        <option value="">-*-</option>
                                        <option value="1">ไม่เลย</option>
                                        <option value="2">เป็นบางวัน (1-7 วัน)</option>
                                        <option value="3">เป็นบ่อย (มากกว่า 7 วัน)</option>
                                        <option value="4">เป็นทุกวัน</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>คิดทำร้าย หรือคิดว่าถ้าตายไปก็คงจะดี</td>
                                <td>
                                    <select id="sl_depress_9q9">
                                        <option value="">-*-</option>
                                        <option value="1">ไม่เลย</option>
                                        <option value="2">เป็นบางวัน (1-7 วัน)</option>
                                        <option value="3">เป็นบ่อย (มากกว่า 7 วัน)</option>
                                        <option value="4">เป็นทุกวัน</option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_save_depress"><i class="icon-save"></i> บันทึก</button>
                <button type="button" class="btn btn-danger" id="btn_remove_depress"><i class="icon-trash"></i> ลบข้อมูล</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_ncd_follow">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">บันทึกการตรวจภาวะแทรกซ้อนผู้ป่วยโรคเรื้อรัง</h4>
            </div>
            <div class="modal-body">
            <input type="hidden" id="txt_cfu_id" value="" />
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_chronicfu_eye" data-toggle="tab"><i class="icon-check-sign"></i> ตรวจภาวะแทรกซ้อนทางตา</a></li>
                    <li><a href="#tab_chronicfu_foot" data-toggle="tab"><i class="icon-check-sign"></i> ตรวจภาวะแทรกซ้อนเท้า</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_chronicfu_eye">
                        <div class="row">
                            <div class="col-lg-6">
                                <legend>ผลการตรวจตาด้านซ้าย</legend>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="sl_cfu_eye_result_left">ตรวจจอประสาทตา</label>
                                        <select id="sl_cfu_eye_result_left">
                                            <option value="0">-*-</option>
                                            <option value="1">NO DR</option>
                                            <option value="2">Mild NPDR</option>
                                            <option value="3">Moderate NPDR</option>
                                            <option value="4">Severe NPDR</option>
                                            <option value="5">PDR</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="txt_cfu_eye_va_left">VisualAucity</label>
                                        <input type="text" id="txt_cfu_eye_va_left" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="txt_cfu_eye_iop_left">IntraOcular Pressure</label>
                                        <input type="text" id="txt_cfu_eye_iop_left" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="txt_cfu_eye_oth_dz_left">โรคอื่นๆ</label>
                                        <input type="text" id="txt_cfu_eye_oth_dz_left" />
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <legend>ผลการตรวจตาด้านขวา</legend>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="sl_cfu_eye_result_right">ตรวจจอประสาทตา</label>
                                        <select id="sl_cfu_eye_result_right">
                                            <option value="0">-*-</option>
                                            <option value="1">NO DR</option>
                                            <option value="2">Mild NPDR</option>
                                            <option value="3">Moderate NPDR</option>
                                            <option value="4">Severe NPDR</option>
                                            <option value="5">PDR</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="txt_cfu_eye_va_right">VisualAucity</label>
                                        <input type="text" id="txt_cfu_eye_va_right" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="txt_cfu_eye_iop_right">IntraOcular Pressure</label>
                                        <input type="text" id="txt_cfu_eye_iop_right" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="txt_cfu_eye_oth_dz_right">โรคอื่นๆ</label>
                                        <input type="text" id="txt_cfu_eye_oth_dz_right" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <legend>ผลการตรวจอื่นๆ</legend>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_cfu_eye_macular">Macular Edema</label>
                                <select id="sl_cfu_eye_macular">
                                    <option value="0">-*-</option>
                                    <option value="1">No ไม่มี ไม่เป็น</option>
                                    <option value="2">เป็นข้างขวา</option>
                                    <option value="3">เป็นข้างซ้าย</option>
                                    <option value="4">เป็นทั้งซ้ายและขวา</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_eye_laser">รักษาด้วย Laser</label>
                                <select id="sl_cfu_eye_laser">
                                    <option value="0">-*-</option>
                                    <option value="1">ไม่ได้ยิง</option>
                                    <option value="2">ยิงข้างขวา</option>
                                    <option value="3">ยิงข้างซ้าย</option>
                                    <option value="4">ยิงทั้งซ้ายและขวา</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_eye_cataract">พบต้อกระจก (Cataract)</label>
                                <select id="sl_cfu_eye_cataract">
                                    <option value="0">-*-</option>
                                    <option value="1">ไม่เป็นต้อกระจก (ปกติ)</option>
                                    <option value="2">เป็นต้อกระจกข้างขวา</option>
                                    <option value="3">เป็นต้อกระจกข้างซ้าย</option>
                                    <option value="4">เป็นทั้งซ้ายและขวา</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_cfu_eye_surgery">การผ่าตัด (Surgery)</label>
                                <select id="sl_cfu_eye_surgery">
                                    <option value="0">-*-</option>
                                    <option value="1">ไม่ได้ผ่า</option>
                                    <option value="2">ผ่าข้างขวา</option>
                                    <option value="3">ผ่าข้างซ้าย</option>
                                    <option value="4">ผ่าทั้งซ้ายและขวา</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_eye_blindness">ผู้ป่วยตาบอดหรือไม่</label>
                                <select id="sl_cfu_eye_blindness">
                                    <option value="0">-*-</option>
                                    <option value="1">ปกติดี ไม่บอด</option>
                                    <option value="2">บอดข้างขวา</option>
                                    <option value="3">บอดข้างซ้าย</option>
                                    <option value="4">บอดทั้งซ้ายและขวา</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="txt_cfu_eye_treatment">การรักษาที่ให้ (Treatment)</label>
                                <textarea id="txt_cfu_eye_treatment" rows="2"></textarea>
                            </div>
                            <div class="col-lg-6">
                                <label for="">รายละเอียดเพิ่มเติม</label>
                                <textarea id="txt_cfu_eye_remark" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_chronicfu_foot">
                        <br>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_result_left">ผลตรวจเท้าซ้าย</label>
                                <select id="sl_cfu_foot_result_left">
                                    <option value="0">-*-</option>
                                    <option value="1">Low Risk</option>
                                    <option value="2">Moderate Risk</option>
                                    <option value="3">High Risk</option>
                                    <option value="4">Very High Risk</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_result_right">ผลตรวจเท้าขวา</label>
                                <select id="sl_cfu_foot_result_right">
                                    <option value="0">-*-</option>
                                    <option value="1">Low Risk</option>
                                    <option value="2">Moderate Risk</option>
                                    <option value="3">High Risk</option>
                                    <option value="4">Very High Risk</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_ulcer">แผลที่เท้า (Ulcer)</label>
                                <select id="sl_cfu_foot_ulcer">
                                    <option value="0">-*-</option>
                                    <option value="4">ปกติ</option>
                                    <option value="1">แผลที่เท้าขวา</option>
                                    <option value="2">แผลที่เท้าซ้าย</option>
                                    <option value="3">แผลที่เท้าซ้ายและเท้าขวา</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_his_ulcer">ประวัติการเป็นแผล</label>
                                <select id="sl_cfu_foot_his_ulcer">
                                    <option value="0">-*-</option>
                                    <option value="1">ใช่</option>
                                    <option value="2">ไม่เคย</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_his_amp">ประวัติ ตัดนิ้ว, ขา, เท้า</label>
                                <select id="sl_cfu_foot_his_amp">
                                    <option value="0">-*-</option>
                                    <option value="1">มี</option>
                                    <option value="2">ไม่มี</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_his_sens">ประวัติเสียความรู้สึก</label>
                                <select id="sl_cfu_foot_his_sens">
                                    <option value="0">-*-</option>
                                    <option value="1">มี</option>
                                    <option value="2">ไม่มี</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_nail">ผลตรวจเล็บเท้า</label>
                                <select id="sl_cfu_foot_nail">
                                    <option value="0">-*-</option>
                                    <option value="1">ไม่มีปัญหา</option>
                                    <option value="2">มีปัญหา</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_wart">พบหูด ตาปลา</label>
                                <select id="sl_cfu_foot_wart">
                                    <option value="0">-*-</option>
                                    <option value="1">ไม่พบ</option>
                                    <option value="2">พบ</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_footshape">พบเท้าผิดรูป</label>
                                <select id="sl_cfu_foot_footshape">
                                    <option value="0">-*-</option>
                                    <option value="1">ไม่พบ</option>
                                    <option value="2">พบ</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_hair">พบเส้นขน หลุดร่วง</label>
                                <select id="sl_cfu_foot_hair">
                                    <option value="0">-*-</option>
                                    <option value="1">ไม่พบ</option>
                                    <option value="2">พบ</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_temp">สัมผัสถึงไออุ่นบริเวณเท้า</label>
                                <select id="sl_cfu_foot_temp">
                                    <option value="0">-*-</option>
                                    <option value="1">เย็น ไม่อุ่น</option>
                                    <option value="2">พบไออุ่น</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_tenia">พบเท้าติดเชื้อรา</label>
                                <select id="sl_cfu_foot_tenia">
                                    <option value="0">-*-</option>
                                    <option value="1">ไม่พบ</option>
                                    <option value="2">พบ</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_sensory">ประสาทความรู้สึกเท้า</label>
                                <select id="sl_cfu_foot_sensory">
                                    <option value="0">-*-</option>
                                    <option value="1">ปกติ</option>
                                    <option value="2">สูญเสียประสาท เท้าขวาอย่างเดียว แต่เท้าซ้ายปกติ</option>
                                    <option value="3">สูญเสียประสาทเท้าซ้าย แต่เท้าขวาปกติ</option>
                                    <option value="4">สูญเสียประสาทเท้าทั้งสองข้าง ทั้งซ้ายและขวา</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_dieskin">พบเนื้อตาย</label>
                                <select id="sl_cfu_foot_dieskin">
                                    <option value="0">-*-</option>
                                    <option value="1">ไม่พบ</option>
                                    <option value="2">พบ</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_skincolor">สีของผิวเท้า</label>
                                <select id="sl_cfu_foot_skincolor">
                                    <option value="0">-*-</option>
                                    <option value="1">ปกติ</option>
                                    <option value="2">แดง</option>
                                    <option value="3">ซีด</option>
                                    <option value="4">คล้ำ</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_posttib_left">Posterior tibial ด้านซ้าย</label>
                                <select id="sl_cfu_foot_posttib_left">
                                    <option value="0">-*-</option>
                                    <option value="1">Absence</option>
                                    <option value="2">Faint</option>
                                    <option value="3">Full</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_posttib_right">Posterior tibial ด้านขวา</label>
                                <select id="sl_cfu_foot_posttib_right">
                                    <option value="0">-*-</option>
                                    <option value="1">Absence</option>
                                    <option value="2">Faint</option>
                                    <option value="3">Full</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_dorsped_left">Dorsalis Pedis ด้านซ้าย</label>
                                <select id="sl_cfu_foot_dorsped_left">
                                    <option value="0">-*-</option>
                                    <option value="1">Absence</option>
                                    <option value="2">Faint</option>
                                    <option value="3">Full</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="sl_cfu_foot_dorsped_right">Dorsalis Pedis ด้านขวา</label>
                                <select id="sl_cfu_foot_dorsped_right">
                                    <option value="0">-*-</option>
                                    <option value="1">Absence</option>
                                    <option value="2">Faint</option>
                                    <option value="3">Full</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="txt_cfu_foot_shoe">รองเท้าที่ใช้ประจำ</label>
                                <textarea id="txt_cfu_foot_shoe" rows="2"></textarea>
                            </div>
                            <div class="col-lg-6">
                                <label for="txt_cfu_foot_remark">รายละเอียดเพิ่มเติม</label>
                                <textarea id="txt_cfu_foot_remark" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-success" id="btn_cfu_save"><i class="icon-save"></i> บันทึกข้อมูล</a>
                <a href="javascript:void(0);" class="btn btn-danger" id="btn_cfu_remove"><i class="icon-trash"></i> ลบข้อมูล</a>
                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-default"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    head.js(
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.allergy.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.appointment.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.refer.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.diagnosis.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.procedures.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.drugs.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.charges.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.fp.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.epi.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.nutritions.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.anc.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.postnatal.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.babies_care.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.special_pp.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.comms.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.icf.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.dental.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.labs.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.accidents.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.depress.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.charge_dental.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.chronicfu.js'
    );
</script>