<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li><a href="<?php echo site_url('services'); ?>">การให้บริการ</a></li>
    <li class="active"><?php echo $patient_name; ?> เพศ: <?php echo $sex == '1' ? 'ชาย' : 'หญิง'; ?> [HN: <?php echo $hn; ?>, CID: <?php echo $cid; ?>]</li>
</ul>
<div class="alert alert-success">
    <a href="#" class="btn btn-danger" rel="tooltip" title="บันทึกข้อมูลอุบัติเหตุ"><i class="icon-truck"></i> ข้อมูลอุบัติเหตุ</a>
    <a href="#" class="btn btn-warning" id="btn_labs"><i class="icon-tasks"></i> สั่ง/ลงผล LAB</a>

    <div class="btn-group">
        <button class="btn btn-success" type="button"><i class="icon-th-large"></i> งานส่งเสริม</button>
        <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="javascript:void(0);" data-name="btn_fp"><i class="icon-tags"></i> วางแผนครอบครัว (Family Planing)</a></li>
            <li><a href="javascript:void(0);" data-name="btn_nutri"><i class="icon-text-height"></i> บันทึกโภชนาการ (Nutrition)</a></li>
            <li><a href="javascript:void(0);" data-name="btn_epi"><i class="icon-user"></i> บันทึกข้อมูลการรับวัคซีน (EPI)</a></li>
            <li><a href="javascript:void(0);" data-name="btn_anc"><i class="icon-eye-open"></i> บันทึกข้อมูลการฝากครรภ์ (ANC)</a></li>
            <li><a href="javascript:void(0);" data-name="btn_postnatal"><i class="icon-headphones"></i> เยี่ยมหลังคลอดมารดา</a></li>
            <li><a href="javascript:void(0);" data-name="btn_baby_care"><i class="icon-headphones"></i> เยี่ยมหลังคลอดเด็ก</a></li>
            <li class="dropdown-submenu">
                <a tabindex="-1" href="#"><i class="icon-th-list"></i> บริการอื่นๆ...</a>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0);" data-name="btn_specialpp"><i class="icon-eye-close"></i> ให้บริการส่งเสริมป้องกัน (Special PP)</a></li>
                    <li><a href="javascript:void(0);" data-name="btn_community_service"><i class="icon-eye-close"></i> ให้บริการในชุมชน (Community Service)</a></li>
                    <li><a href="javascript:void(0);" data-name="btn_icf"><i class="icon-briefcase"></i> ประเมินภาวะสุขภาพผู้พิการ (ICF)</a></li>
                    <li><a href="javascript:void(0);" data-name="btn_rehabilitation"><i class="icon-refresh"></i> การฟื้นฟูสมรรถภาพ (ผู้พิการหรือผู้สูงอายุ)</a></li>
                    <li><a href="javascript:void(0);" data-name="btn_dental"><i class="icon-th"></i> ตรวจสภาวะทันตสุขภาพของฟัน (หญิงตั้งครรภ์/นักเรียน/ผู้มารับบริการ)</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="btn-group">
        <button class="btn btn-primary" type="button"><i class="icon-check"></i> งานคัดกรอง</button>
        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="javascript:void(0);" data-name="btn_chronic_fu"><i class="icon-tags"></i> คัดกรองความเสี่ยง (เบาหวาน, ความดัน)</a></li>
            <li><a href="javascript:void(0);" data-name="btn_chronic_fu"><i class="icon-leaf"></i> คัดกรองโรคซึมเศร้า</a></li>
            <li><a href="javascript:void(0);" data-name="btn_chronic_fu"><i class="icon-fire"></i> คัดกรองมะเร็งปากมดลูก</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button class="btn btn-default" type="button"><i class="icon-briefcase"></i> กิจกรรมอื่นๆ</button>
        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="javascript:void(0);" data-name="btn_chronic_fu"><i class="icon-tags"></i> ติดตามดูแลผู้ป่วยโรคเรื้อรัง</a></li>
        </ul>
    </div>

    <div class="pull-right">
        <button type="button" class="btn btn-success">
            <i class="icon-time"></i> ประวัติ (EMR)
        </button>
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
        <li><a href="#tab_dental" data-toggle="tab"><i class="icon-eye-close"></i> ทันตกรรม</a></li>
        <li><a href="#tab_drug" data-toggle="tab"><i class="icon-filter"></i> จ่ายยา</a></li>
        <li><a href="#tab_income" data-toggle="tab"><i class="icon-shopping-cart"></i> ค่าใช้จ่าย</a></li>
        <li><a href="#tab_appoint" data-toggle="tab"><i class="icon-calendar"></i> ลงทะเบียนนัด</a></li>
        <li><a href="#tab_refer" data-toggle="tab"><i class="icon-share"></i> ส่งต่อ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_screening">
            <blockquote>บันทึกข้อมูลการให้บริการผู้ป่วย <p class="text-warning">กรุณาบันทึกข้อมูลให้ถูกต้องและสมบูรณ์เพื่อป้องกันข้อมูลผิดพลาดเวลาส่งออก</p></blockquote>
            <div class="row">
                <div class="col-lg-2">
                    <select id="sl_typeout" style="width: 150px;" title="ประเภทที่ตั้งของที่อยู่ผู้รับบริการ" rel="tooltip">
                        <option value="1">[1] ในเขต</option>
                        <option value="2">[2] นอกเขต</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <select id="sl_typeout" style="width: 160px;" title="ประเภทเวลาการมารับบริการ" rel="tooltip">
                        <option value="1">[1] ในเวลาราชการ</option>
                        <option value="2">[2] นอกเวลาราชการ</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <select id="sl_typeout" style="width: 250px;" title="ระบุสถานะปัจจุบันของผู้มารับบริการ" rel="tooltip">
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
                <div class="col-lg-4">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default"><i class="icon-edit"></i> แก้ไขส่งตรวจ</button>
                        <button type="button" class="btn btn-danger"><i class="icon-trash"></i> ลบส่งตรวจ</button>
                    </div>
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
                        <button class="btn btn-success pull-right" id="btn_screening_add_drgu_allergy">
                            <i class="icon-plus"></i>
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
            <button type="button" class="btn btn-success" id="btn_save_screening"><i class="icon-save"></i> บันทึกคัดกรอง</button>
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

            <button class="btn btn-success" rel="tooltip" title="เพิ่มรายการ" id="btn_proced_new"><i class="icon-plus-sign"></i></button>

        </div>
        <div class="tab-pane" id="tab_dental">
            xxx
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

                </div>
                <div class="tab-pane active" id="tab_refer_out">
                    <table class="table table-striped" id="tbl_refer_out_list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>เลขที่ส่งต่อ</th>
                            <th>วันที่ส่ง</th>
                            <th>สถานที่ส่ง</th>
                            <th>การวินิจฉัย</th>
                            <th>แพทย์ผู้ส่งต่อ</th>
                            <th>สถานะ</th>
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
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success" id="btn_new_refer_out"
                            title="บันทึกส่งต่อ" rel="tooltip"><i class="icon-plus-sign"></i></button>
                    <button type="button" class="btn btn-default" id="btn_appoint_refresh"
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
<div class="modal hide fade" id="modal_screening_allergy">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>ข้อมูลการแพ้ยา</h4>
    </div>
    <div class="modal-body">
        <form action="#">
            <input type="hidden" id="txt_screening_allergy_isupdate">
            <div class="row-fluid">
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_allergy_date_record">วันที่รายงาน</label>
                        <div class="controls">
                            <div class="input-append date" data-name="datepicker">
                                <input class="input-small" id="txt_screening_allergy_date_record" type="text" disabled>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_drug_allergy_name">ยาที่แพ้</label>
                        <div class="controls">
                            <input type="hidden" id="txt_screening_drug_allergy_code">
                            <input type="text" class="input-xxlarge" id="txt_screening_drug_allergy_name" placeholder="พิมพ์ชื่อยา">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="sl_screening_allergy_diag_type">การวินิจฉัย</label>
                        <div class="controls">
                            <select id="sl_screening_allergy_diag_type" class="input-xlarge">
                                <option value="">--</option>
                                <?php foreach($drug_allergy_diag_types as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="sl_screening_allergy_alevel">ความรุนแรง</label>
                        <div class="controls">
                            <select id="sl_screening_allergy_alevel" class="input-xlarge">
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
                        <label class="control-label" for="sl_screening_allergy_symptom">อาการแพ้</label>
                        <div class="controls">
                            <select id="sl_screening_allergy_symptom" class="input-xlarge">
                                <option value="">--</option>
                                <?php foreach($drug_allergy_symptoms as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="sl_screening_allergy_informant">ผู้ให้ประวัติ</label>
                        <div class="controls">
                            <select id="sl_screening_allergy_informant" class="input-xlarge">
                                <option value="">--</option>
                                <?php foreach($drug_allergy_informants as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_drug_allergy_name">หน่วยงานที่ให้ข้อมูล</label>
                        <div class="controls">
                            <input type="hidden" id="txt_screening_drug_allergy_hosp_code">
                            <input type="text" class="input-xxlarge" id="txt_screening_drug_allergy_hosp_name" placeholder="ชื่อ หรือ รหัสสถานบริการ">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn_screening_save_allergy"><i class="icon-plus-sign"></i> เพิ่มรายการ</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
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

<!-- FP -->
<div class="modal hide fade" id="mdl_fp">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>เพิ่มข้อมูลการวางแผนครอบครัว</h4>
    </div>
    <div class="modal-body">
    
    

    <div class="tabbable">
	    <ul class="nav nav-tabs">
		    <li class="active"><a href="#fp_tab1" data-toggle="tab"><i class="icon-file"></i> บันทึกข้อมูล</a></li>
		    <li><a href="#fp_tab2" data-toggle="tab"><i class="icon-time"></i> ประวัติการรับบริการ</a></li>
	    </ul>
	    <div class="tab-content">
		    <div class="tab-pane active" id="fp_tab1">
		    	<blockquote>
		    	ข้อมูลการรับบริการในครั้งนี้
		    	</blockquote>
		        <form class="form-horizontal">
		            <div class="control-group">
		                <label class="control-label" for="txt_drug_name">วิธีการคุมกำเนิด</label>
		                <div class="controls">
		                    <select id="sl_fp_type" class="input-xlarge">
		                    <option value="">-----</option>
		                    <?php 
		                    foreach($fp_types as $r) echo '<option value="'.$r->code.'">'.$r->name.'</option>';
		                    ?>
		                    </select>
		                    <a href="#" class="btn btn-success" id="btn_do_save_fp"><i class="icon-plus"></i> เพิ่มรายการ</a>
		                </div>
		            </div>
		        </form>
		        <table class="table table-hover" id="tbl_fp_list" style="width: 640px;">
		        <thead>
		        <tr>
		        	<th>ประเภทการคุมกำเนิด</th>
		        	<th>ผู้ให้บริการ</th>
		        </tr>
		        </thead>
		        <tbody></tbody>
		        </table>
        
		    </div>
		    <div class="tab-pane" id="fp_tab2">
		    	<blockquote>
		    	ประวัติการรับบริการจากหน่วยงานอื่นๆ
		    	</blockquote>
		    	
		    	<table class="table table-hover" id="tbl_fp_list_all">
		        <thead>
		        <tr>
		        	<th>วันที่</th>
		        	<th>เวลา</th>
		        	<th>คลินิก</th>
		        	<th>สถานบริการ</th>
		        	<th>ประเภทการคุมกำเนิด</th>
		        	<th>ผู้ให้บริการ</th>
		        </tr>
		        </thead>
		        <tbody></tbody>
		        </table>
		        
		    </div>
	    </div>
    </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>
<!--  end FP -->
<!-- EPI -->
<div class="modal hide fade" id="mdl_epi">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>เลือกข้อมูลวัคซีน</h4>
    </div>
    <div class="modal-body">

        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_epi1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
                <li><a href="#tab_epi2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_epi1">
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="sl_epi_vaccines">วัคซีน</label>
                            <div class="controls">
                                <select id="sl_epi_vaccines" class="input-xlarge"></select>
                                <a href="#" class="btn btn-success" id="btn_do_add_epi">
                                    <i class="icon-plus-sign"></i> เพิ่มรายการ
                                </a>
                            </div>
                        </div>
                    </form>
                    <legend>ประวัติครั้งนี้</legend>
                    <table class="table table-striped" id="tbl_epi_visit_history">
                        <thead>
                        <tr>
                            <th>ชื่อวัคซีน</th>
                            <th>ผู้ให้บริการ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="3">ไม่พบรายการ</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane" id="tab_epi2">
                    <table class="table table-striped" id="tbl_epi_history">
                        <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>หน่วยบริการ</th>
                            <th>วัคซีน</th>
                            <th>ผู้ให้บริการ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="4">ไม่พบรายการ</td>
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
<!-- end EPI -->

<!-- Nutrition -->
<div class="modal hide fade" id="mdl_nutri">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>ข้อมูลระดับโภชนาการ</h4>
    </div>
    <div class="modal-body">

        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_nutri1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
                <li><a href="#tab_nutri2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_nutri1">
                    <form class="form-horizontal">
                        <div class="row-fluid">
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="txt_nutri_headcircum">เส้นรอบศีรษะ</label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input class="input-small" id="txt_nutri_headcircum" type="text" data-type="number">
                                            <span class="add-on">ซม.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_childdevelop">ระดับพัฒนาการ</label>
                                    <div class="controls">
                                        <select id="sl_childdevelop">
                                            <option value="1">ปกติ</option>
                                            <option value="2">สงสัยช้ากว่าปกติ</option>
                                            <option value="3">ช้ากว่าปกติ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_food">อาหารที่รับประทาน</label>
                                    <div class="controls">
                                        <select id="sl_food">
                                            <option value="1">นมแม่อย่างเดียว</option>
                                            <option value="2">นมแม่และน้ำ</option>
                                            <option value="3">นมแม่และนมผสม</option>
                                            <option value="4">นมผสมอย่างเดียว</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_bottle">การใช้ขวดนม</label>
                                    <div class="controls">
                                        <select id="sl_bottle">
                                            <option value="1">ใช้ขวดนม</option>
                                            <option value="2">ไม่ใช้ขวดนม</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <button class="btn btn-success" type="button" id="btn_nutri_save">
                            <i class="icon-plus-sign"></i> บันทึกโภชนาการ
                        </button>
                    </form>
                </div>
                <div class="tab-pane" id="tab_nutri2">
                    <table class="table table-striped" id="tbl_nutri_history">
                        <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>หน่วยบริการ</th>
                            <th>วัคซีน</th>
                            <th>ผู้ให้บริการ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="4">อยู่ในระหว่างปรับปรุงระบบ</td>
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
<!-- end Nutrition -->

<!-- ANC -->
<div class="modal hide fade" id="mdl_anc">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>ข้อมูลการฝากครรภ์</h4>
    </div>
    <div class="modal-body">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_anc1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
                <li><a href="#tab_anc2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_anc1">
                    <form class="form-horizontal">
                        <legend>การให้บริการวันนี้</legend>
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label" for="sl_anc_gravida">ครรภ์ที่</label>
                                    <div class="controls">
                                        <select id="sl_anc_gravida" class="input-small">
                                            <option value="">ระบุ..</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_anc_no">ANC ช่วงที่</label>
                                    <div class="controls">
                                        <select id="sl_anc_no">
                                            <option value="1">ช่วงที่ 1 (อายุครรภ์ <= 12 สัปดาห์)</option>
                                            <option value="2">ช่วงที่ 2 (อายุครรภ์ 18 สัปดาห์)</option>
                                            <option value="3">ช่วงที่ 3 (อายุครรภ์ 26 สัปดาห์)</option>
                                            <option value="4">ช่วงที่ 4 (อายุครรภ์ 32 สัปดาห์)</option>
                                            <option value="5">ช่วงที่ 5 (อายุครรภ์ 38 สัปดาห์)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label" for="txt_anc_ga">อายุครรภ์ (สัปดาห์)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_anc_ga">
                                    </div>
                                </div>
                            </div>

                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_anc_result">ผลตรวจ</label>
                                    <div class="controls">
                                        <select id="sl_anc_result">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <button class="btn btn-success" type="button" id="btn_anc_save">
                            <i class="icon-plus-sign"></i> บันทึกข้อมูล
                        </button>
                    </form>
                </div>
                <div class="tab-pane" id="tab_anc2">
                    <legend>ประวัติการรับบริการ</legend>
                    <form action="#" class="form-inline">
                        <label for="sl_anc_gravida2">ครรภ์ที่</label>
                        <select id="sl_anc_gravida2" class="input-small">
                            <option value="">ระบุ..</option>
                        </select>
                    </form>
                    <table class="table table-striped" id="tbl_anc_history">
                        <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>หน่วยบริการ</th>
                            <th>ครรภ์ที่</th>
                            <th>ANC ช่วงที่</th>
                            <th>อายุครรภ์ (สัปดาห์)</th>
                            <th>ผลตรวจ</th>
                            <th>ผู้ให้บริการ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="6">อยู่ในระหว่างปรับปรุงระบบ</td>
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
<!-- /ANC -->
<!-- Mother care -->
<div class="modal hide fade" id="mdl_postnatal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>ข้อมูลการดูแลมารดาหลังคลอด (Postnatal)</h4>
    </div>
    <div class="modal-body">

        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_postnatal1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
                <li><a href="#tab_postnatal2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_postnatal1">
                    <form class="form-horizontal">
                        <legend>การให้บริการวันนี้</legend>
                        <div class="row-fluid">
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_postnatal_gravida">ครรภ์ที่</label>
                                    <div class="controls">
                                        <select id="sl_postnatal_gravida" class="input-small">
                                            <option value="">ระบุ..</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_postnatal_ppresult">ผลการตรวจ</label>
                                    <div class="controls">
                                        <select id="sl_postnatal_ppresult">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_postnatal_sugar">ระดับน้ำตาล</label>
                                    <div class="controls">
                                        <select id="sl_postnatal_sugar">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_postnatal_albumin">Albumin</label>
                                    <div class="controls">
                                        <select id="sl_postnatal_albumin">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row-fluid">
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_postnatal_amniotic_fluid">น้ำคาวปลา</label>
                                    <div class="controls">
                                        <select id="sl_postnatal_amniotic_fluid">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_postnatal_uterus">ระดับมดลูก</label>
                                    <div class="controls">
                                        <select id="sl_postnatal_uterus">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_postnatal_perineal">ฝีเย็บ</label>
                                    <div class="controls">
                                        <select id="sl_postnatal_perineal">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_postnatal_tits">หัวนม</label>
                                    <div class="controls">
                                        <select id="sl_postnatal_tits">
                                            <option value="1">ปกติ</option>
                                            <option value="2">ผิดปกติ</option>
                                            <option value="9">ไม่ทราบ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-success" type="button" id="btn_postnatal_save">
                            <i class="icon-save"></i> บันทึกข้อมูล
                        </button>
                    </form>
                </div>
                <div class="tab-pane" id="tab_postnatal2">
                    <legend>ประวัติการรับบริการ</legend>
                    <table class="table table-striped" id="tbl_postnatal_history">
                        <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>หน่วยบริการ</th>
                            <th>ครรภ์ที่</th>
                            <th>ผลตรวจ</th>
                            <th>ผู้ให้บริการ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="5">...</td>
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
<!-- /Mother care -->

<!-- เยี่ยมหลังคลอด เด็ก -->
<div class="modal hide fade" id="mdl_babies_care">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>ข้อมูลการตรวจหลังคลอด เด็ก</h4>
    </div>
    <div class="modal-body">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_babies_care1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
                <li><a href="#tab_babies_care2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_babies_care1">
                    <form class="form-horizontal">
                        <legend>การให้บริการวันนี้</legend>
                        <div class="control-group">
                            <label class="control-label" for="sl_babies_care_result">ผลตรวจ</label>
                            <div class="controls">
                                <select id="sl_babies_care_result">
                                    <option value="">--</option>
                                    <option value="1">ปกติ</option>
                                    <option value="2">ผิดปกติ</option>
                                    <option value="9">ไม่ทราบ</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="sl_babies_care_food">อาหาร</label>
                            <div class="controls">
                                <select id="sl_babies_care_food">
                                    <option value="">--</option>
                                    <option value="1">นมแม่อย่างเดียว</option>
                                    <option value="2">นมแม่นและน้ำ</option>
                                    <option value="3">นมแม่และนมผสม</option>
                                    <option value="4">นมผสมอย่างเดียว</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="btn_babies_care_save">&nbsp;</label>
                            <div class="controls">
                                <button class="btn btn-success" type="button" id="btn_babies_care_save">
                                    <i class="icon-save"></i> บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab_babies_care2">
                    <legend>ประวัติการรับบริการ</legend>
                    <table class="table table-striped" id="tbl_babies_care_history">
                        <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>หน่วยบริการ</th>
                            <th>ผลตรวจ</th>
                            <th>อาหาร</th>
                            <th>ผู้ให้บริการ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="4">อยู่ในระหว่างปรับปรุงระบบ</td>
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
<!-- /เยี่ยมหลังคลอด เด็ก -->

<!-- SPECIAL PP -->
<div class="modal hide fade" id="mdl_special_pp">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>การให้บริการส่งเสริมสุขภาพป้องกันโรคเฉพาะ (Special PP)</h4>
    </div>
    <div class="modal-body">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_special_pp1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
                <li><a href="#tab_special_pp2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_special_pp1">
                    <form class="form-horizontal">
                        <legend>การให้บริการวันนี้</legend>
                        <div class="control-group">
                            <label class="control-label" for="sl_spp_servplace">สถานบริการ</label>
                            <div class="controls">
                                <select id="sl_spp_servplace">
                                    <option value="">--</option>
                                    <option value="1">ในสถานบริการ</option>
                                    <option value="2">นอกสถานบริการ</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="sl_spp_ppspecial">ประเภทบริการ</label>
                            <div class="controls">
                                <select id="sl_spp_ppspecial">
                                    <option value="">--</option>
                                    <?php
                                    $specials = get_pp_special_list();
                                    foreach($specials as $r)
                                    {
                                        echo '<option value="'.$r->id.'">' . $r->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="btn_special_pp_save">&nbsp;</label>
                            <div class="controls">
                                <button class="btn btn-success" type="button" id="btn_special_pp_save">
                                    <i class="icon-save"></i> บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab_special_pp2">
                    <legend>ประวัติการรับบริการ</legend>
                    <table class="table table-striped" id="tbl_special_pp_history">
                        <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>หน่วยบริการ</th>
                            <th>กิจกรรม</th>
                            <th>สถานที่</th>
                            <th>ผู้ให้บริการ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="5">อยู่ในระหว่างปรับปรุงระบบ</td>
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
<!-- /SPECIAL PP -->
<!-- Community Service -->
<div class="modal hide fade" id="mdl_comms">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>การให้บริการในชุมชน (Community Service)</h4>
    </div>
    <div class="modal-body">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_comms1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
                <li><a href="#tab_comms2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_comms1">
                    <form class="form-horizontal">
                        <legend>การให้บริการวันนี้</legend>
                        <div class="control-group">
                            <label class="control-label" for="sl_comms">ประเภทบริการ</label>
                            <div class="controls">
                                <select id="sl_comms" class="input-xxlarge">
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
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="btn_comms_save">&nbsp;</label>
                            <div class="controls">
                                <button class="btn btn-success" type="button" id="btn_comms_save">
                                    <i class="icon-save"></i> บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>
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
<!-- /Community service -->
<!-- ICF -->
<div class="modal hide fade" id="mdl_icf">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>ประเมินภาวะสุขภาพผู้พิการ (ICF)</h4>
    </div>
    <div class="modal-body">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_icf1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
                <li><a href="#tab_icf2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_icf1">
                    <form class="form-horizontal">
                        <legend>การให้บริการวันนี้</legend>
                        <div class="control-group">
                            <label class="control-label" for="txt_icf_disabid">เลขทะเบียนผู้พิการ</label>
                            <div class="controls">
                                <input type="text" id="txt_icf_disabid" class="input-medium">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="sl_icf_disb_type">ประเภทความพิการ</label>
                            <div class="controls">
                                <select id="sl_icf_disb_type" class="input-xxlarge">
                                    <option value="">--</option>
                                    <?php foreach($disabilities_types as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="sl_icf">ภาวะสุขภาพ</label>
                            <div class="controls">
                                <select id="sl_icf" class="input-xxlarge"></select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="sl_icf_qualifier">ระดับภาวะสุขภาพ</label>
                            <div class="controls">
                                <select id="sl_icf_qualifier" class="input-xlarge">
                                    <option value="">--</option>
                                    <?php foreach($icf_qualifiers as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="btn_icf_save">&nbsp;</label>
                            <div class="controls">
                                <button class="btn btn-success" type="button" id="btn_icf_save">
                                    <i class="icon-save"></i> บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped" id="tbl_icf_list">
                        <thead>
                        <tr>
                            <th>ภาวะสุขภาพ</th>
                            <th>ระดับ</th>
                            <th>ผู้ให้บริการ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="3">...</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab_icf2">
                    <legend>ประวัติการรับบริการ</legend>
                    <table class="table table-striped" id="tbl_icf_history">
                        <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>หน่วยบริการ</th>
                            <th>ภาวะสุขภาพ</th>
                            <th>ระดับ</th>
                            <th>ผู้ให้บริการ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="5">...</td>
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
<!-- /ICF -->
<!-- dental -->
<div class="modal hide fade" id="mdl_dental">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>ประเมินสุขภาพฟัน</h4>
    </div>
    <div class="modal-body">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_dental1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
                <li><a href="#tab_dental2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_dental1">
                    <form class="form-horizontal">
                        <legend>การให้บริการวันนี้</legend>
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label" for="sl_dental_denttype">ประเภทผู้รับบริการ</label>
                                    <div class="controls">
                                        <select id="sl_dental_denttype" class="input-xlarge">
                                            <option value="">--</option>
                                            <option value="1">กลุ่มหญิงตั้งครรภ์</option>
                                            <option value="2">กลุ่มเด็กก่อนวัยเรียน</option>
                                            <option value="3">กลุ่มเด็กวัยเรียน</option>
                                            <option value="4">กลุ่มผู้สูงอายุ</option>
                                            <option value="5">กลุ่มอื่นๆ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_pteeth">ฟันแท้ที่มีอยู่ (ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_pteeth">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_pcaries">ฟันแท้ผุที่ไม่ได้อุด (ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_pcaries">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_pfilling">ฟันแท้ที่ได้อุด (ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_pfilling">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_pextract">ฟันแท้ถอน/หลุด (ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_pextract">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_dteeth">ฟันน้ำนมที่มีอยู่ (ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_dteeth">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_dfilling">ฟันน้ำนมที่ได้อุด (ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_dfilling">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_dcaries">ฟันน้ำนมผุไม่ได้อุด(ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_dcaries">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_dextract">ฟันน้ำนมที่ถอน/หลุด(ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_dextract">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_need_sealant">ต้องเคลือบ(ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_need_sealant">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_dental_need_fluoride">เคลือบฟลูออไรด์</label>
                                    <div class="controls">
                                        <select id="sl_dental_need_fluoride">
                                            <option value="">--</option>
                                            <option value="1">ต้องทา/เคลือบฟลูออไรด์</option>
                                            <option value="2">ไม่ต้องทา/เคลือบฟลูออไรด์</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_dental_need_scaling">ขุดหินน้ำลาย</label>
                                    <div class="controls">
                                        <select id="sl_dental_need_scaling">
                                            <option value="">--</option>
                                            <option value="1">ต้องขูดหินน้ำลาย</option>
                                            <option value="2">ไม่ต้องขูดหินน้ำลาย</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_need_pfilling">ฟันแท้ที่ต้องอุด(ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_need_pfilling">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_need_dfilling">ฟันน้ำนมที่ต้องอุด(ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_need_dfilling">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_need_pextract">ฟันแท้ที่ต้องถอน(ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_need_pextract">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_need_dextract">ฟันน้ำนมที่ต้องถอน(ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_need_dextract">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_nprosthesis">ต้องใส่ฟันเทียม(ซี่)</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_nprosthesis">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_permanent_perma">คู่สบฟันแท้กับฟันแท้</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_permanent_perma">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_permanent_prost">คู่สบฟันแท้กับฟันเทียม</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_permanent_prost">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_prosthesis_prost">คู่สบฟันเทียมกับฟันเทียม</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_prosthesis_prost">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_dental_gum">สภาวะปริทันต์</label>
                                    <div class="controls">
                                        <select class="input-xlarge" id="sl_dental_gum">
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
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="sl_dental_schooltype">สถานศึกษา</label>
                                    <div class="controls">
                                        <select class="input-xlarge" id="sl_dental_schooltype">
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
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label" for="txt_dental_school_class">ระดับการศึกษา</label>
                                    <div class="controls">
                                        <input type="text" class="input-mini" data-type="number" id="txt_dental_school_class">
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
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>
<!-- /dental -->

<!-- Lab order -->
<div class="modal hide fade" id="mdl_lab_order">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>สั่ง LAB</h4>
    </div>
    <div class="modal-body">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_lab1" data-toggle="tab"><i class="icon-plus"></i> สั่ง LAB</a></li>
                <li><a href="#tab_lab2" data-toggle="tab"><i class="icon-refresh"></i> บันทึกผล</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_lab1">
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="sl_lab_group">ชุด LAB</label>
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
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.labs.js'
    );
</script>