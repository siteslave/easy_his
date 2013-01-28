<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('services'); ?>">การให้บริการ</a> <span class="divider">/</span></li>
    <li class="active"><?php echo $patient_name; ?> เพศ: <?php echo $sex == '1' ? 'ชาย' : 'หญิง'; ?> [HN: <?php echo $hn; ?>, CID: <?php echo $cid; ?>]</li>
</ul>
<!--
<div class="page-header">
    <h1>ข้อมูลการให้บริการ <small>บันทึกข้อมูลการให้บริการกับผู้ป่วย</small></h1>
</div>
-->
<div class="alert alert-block alert-info fade in">
    <a class="close" data-dismiss="alert" href="#">&times;</a>
    <h4 class="alert-heading">คำแนะนำเพิ่มเติม</h4>
    <p>การลงข้อมูลของคุณยังไม่ถูกต้องและไม่สมบูรณ์ กรุณาตรวจสอบการบันทึกข้อมูล เช่น การวินิจฉัยโรค การจ่ายยา หรือ การคัดกรองต่างๆ เป็นต้น</p>
    <p>
        <a class="btn btn-primary" href="#"><i class="icon-volume-up icon-white"></i> คำแนะนำ</a>
    </p>
</div>

<form action="#" class="form-actions">
    <a href="<?php echo site_url('accidents/register/' . $vn . '/' . $hn); ?>" class="btn btn-danger"><i class="icon-th-list icon-white"></i> ข้อมูลอุบัติเหตุ</a>
    <a href="<?php echo site_url('appoints/register/' . $vn . '/' . $hn); ?>" class="btn btn-warning"><i class="icon-calendar icon-white"></i> ลงทะเบียนนัด</a>
    <a href="javascript:void(0);" class="btn btn-info"><i class="icon-share-alt icon-white"></i> สั่ง LAB</a>

    <div class="btn-group">
        <button class="btn btn-primary" type="button"><i class="icon-th-large icon-white"></i> งานส่งเสริม</button>
        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
        	<li><a href="javascript:void(0);" data-name="btn_fp"><i class="icon-tags"></i> วางแผนครอบครัว (Family Planing)</a></li>
            <li><a href="javascript:void(0);"><i class="icon-text-height"></i> บันทึกโภชนาการ (Nutrition)</a></li>
            <li><a href="javascript:void(0);"><i class="icon-user"></i> บันทึกข้อมูลการรับวัคซีน (EPI)</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button class="btn btn-success" type="button"><i class="icon-th-large icon-white"></i> งานบริการอื่นๆ</button>
        <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="javascript:void(0);"><i class="icon-search"></i> ทันตกรรม</a></li>
            <li><a href="javascript:void(0);"><i class="icon-leaf"></i> แพทย์แผนไทย</a></li>
            <li><a href="javascript:void(0);"><i class="icon-share"></i> ส่งต่อ (Refer)</a></li>
        </ul>
    </div>
</form>

<input type="hidden" id="vn" value="<?php echo $vn; ?>">
<input type="hidden" id="hn" value="<?php echo $hn; ?>">
<input type="hidden" id="person_id" value="<?php echo $person_id; ?>">
<input type="hidden" id="person_sex" value="<?php echo $sex; ?>">

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_screening" data-toggle="tab"><i class="icon-th-list"></i> ข้อมูลคัดกรอง</a></li>
        <li><a href="#tab_diagnosis" data-toggle="tab"><i class="icon-check"></i> วินิจฉัยโรค</a></li>
        <li><a href="#tab_procedure" data-toggle="tab"><i class="icon-eye-close"></i> หัตถการ</a></li>
        <li><a href="#tab_drug" data-toggle="tab"><i class="icon-filter"></i> จ่ายยา</a></li>
        <li><a href="#tab_income" data-toggle="tab"><i class="icon-shopping-cart"></i> ค่าใช้จ่าย</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_screening">
            <div class="row-fluid">
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_weight">น้ำหนัก</label>
                        <div class="controls">
                            <div class="input-append">
                                <input data-type="number" class="input-mini" id="txt_screening_weight" type="text">
                                <span class="add-on">กก.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_height">ส่วนสูง</label>
                        <div class="controls">
                            <div class="input-append">
                                <input class="input-mini" data-type="number" id="txt_screening_height" type="text">
                                <span class="add-on">ซม.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_body_tmp">อุณหภูมิ</label>
                        <div class="controls">
                            <div class="input-append">
                                <input class="input-mini" data-type="number" id="txt_screening_body_tmp" type="text">
                                <span class="add-on">C.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_waist">รอบเอว</label>
                        <div class="controls">
                            <div class="input-append">
                                <input class="input-mini" data-type="number" id="txt_screening_waist" type="text">
                                <span class="add-on">ซม.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_pluse">ชีพจร</label>
                        <div class="controls">
                            <div class="input-append">
                                <input class="input-mini" data-type="number" id="txt_screening_pluse" type="text">
                                <span class="add-on">/m</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_breathe">หายใจ</label>
                        <div class="controls">
                            <div class="input-append">
                                <input class="input-mini" data-type="number" id="txt_screening_breathe" type="text">
                                <span class="add-on">/m</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_sbp">ความดัน SBP</label>
                        <div class="controls">
                            <div class="input-append">
                                <input class="input-mini" data-type="number" id="txt_screening_sbp" type="text">
                                <span class="add-on">มม.ป</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_screening_dbp">ความดัน DBP</label>
                        <div class="controls">
                            <div class="input-append">
                                <input class="input-mini" data-type="number" id="txt_screening_dbp" type="text">
                                <span class="add-on">มม.ป</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tab cc -->
            <div class="row-fluid">
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
                            <div class="control-group">
                                <div class="controls">
                                    <textarea class="input-xxlarge" rows="2" id="txt_screening_cc"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_screening_pe">
                            <blockquote>บันทึกข้อมูล Physical examination</blockquote>
                            <div class="control-group">
                                <div class="controls">
                                    <textarea class="input-xxlarge" rows="2" id="txt_screening_pe"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_screening_ill_history">
                            <blockquote>บันทึกข้อมูลโรคประจำตัว</blockquote>
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
                                    <input type="text" class="input-xxlarge" id="txt_ill_history_ill_detail">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="chk_operate"> ผ่าตัด
                                    </label>
                                    <input type="text" class="input-xxlarge" id="txt_ill_history_operate_detail">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <label class="control-label" for="txt_operate_year">ปีที่ผ่าตัด</label>
                                    <input type="text" data-type="year" class="input-mini" data-type="year" id="txt_operate_year">
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
                                    <button class="btn pull-right" id="btn_screening_add_drgu_allergy">
                                        <i class="icon-plus"></i> เพิ่มรายการ
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_screening_screen">
                            <blockquote>บันทึกข้อมูลการคัดกรอง</blockquote>
                            <div class="row-fluid">
                                <div class="span4">
                                    <form action="#">
                                        <legend>สูบบุหรี่/ดื่มเหล้า</legend>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label for="sl_screening_smoking">สูบบุหรี่</label>
                                                <select id="sl_screening_smoking">
                                                    <?php foreach($smokings as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label for="sl_screening_drinking">ดื่มสุรา</label>
                                                <select id="sl_screening_drinking">
                                                    <?php foreach($drinkings as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="span4">
                                    <form action="#">
                                        <legend>ประเมินสุขภาพจิต</legend>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label class="checkbox" for="chk_screening_screen_mind_strain">
                                                    <input type="checkbox" id="chk_screening_screen_mind_strain"> เครียด/วิตกกังวล
                                                </label>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label class="checkbox" for="chk_screening_screen_mind_work">
                                                    <input type="checkbox" id="chk_screening_screen_mind_work"> ปัญหาการเงิน/การทำงาน/เพื่อนร่วมงาน
                                                </label>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label class="checkbox" for="chk_screening_screen_mind_family">
                                                    <input type="checkbox" id="chk_screening_screen_mind_family"> ปัญหาครอบครัว
                                                </label>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label class="checkbox" for="chk_screening_screen_mind_other">
                                                    <input type="checkbox" id="chk_screening_screen_mind_other"> อื่นๆ
                                                </label>
                                                <input type="text" class="input-xlarge" id="txt_screening_screen_mind_other_detail">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="span4">
                                    <form action="#">
                                        <legend>ภาวะเสี่ยง</legend>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label class="checkbox" for="chk_screening_screen_risk_ht">
                                                    <input type="checkbox" id="chk_screening_screen_risk_ht"> เสี่ยงต่อการเป็นความดันโลหิตสูง
                                                </label>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label class="checkbox" for="chk_screening_screen_risk_dm">
                                                    <input type="checkbox" id="chk_screening_screen_risk_dm"> เสี่ยงต่อการเป็นเบาหวาน
                                                </label>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label class="checkbox" for="chk_screening_screen_risk_stoke">
                                                    <input type="checkbox" id="chk_screening_screen_risk_stoke"> เสี่ยงต่อการเป็นโรคหัวใจ
                                                </label>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label class="checkbox" for="chk_screening_screen_risk_other">
                                                    <input type="checkbox" id="chk_screening_screen_risk_other"> อื่นๆ
                                                </label>
                                                <textarea class="input-xlarge" id="txt_screening_screen_risk_other_detail" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_screening_lmp">
                            <blockquote>บันทึกข้อมูลการมีประจำเดือน (LMP)</blockquote>
                            <form action="#">
                                <div class="control-group">
                                    <div class="controls">
                                        <label class="control" for="sl_screening_lamp">การมาของประจำเดือน (LMP)</label>
                                        <select id="sl_screening_lamp">
                                            <option value="">-- ไม่ระบุ --</option>
                                            <option value="0">ประจำเดือนไม่มา</option>
                                            <option value="1">ประจำเดือนมาปกติ (มีประจำเดือน)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="txt_screening_lmp_start">วันที่ประจำเดือนมา</label>
                                    <div class="controls">
                                        <div class="input-append date" data-name="datepicker">
                                            <input class="input-small" id="txt_screening_lmp_start" size="16" type="text" disabled>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="txt_screening_lmp_finished">วันที่ประจำเดือนไม่มา</label>
                                    <div class="controls">
                                        <div class="input-append date" data-name="datepicker">
                                            <input class="input-small" id="txt_screening_lmp_finished" size="16" type="text" disabled>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
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
            </div>
            <!-- end tab cc -->

            <button type="button" class="btn btn-success" id="btn_save_screening"><i class="icon-plus-sign icon-white"></i> บันทึกคัดกรอง</button>
        </div>
        <div class="tab-pane" id="tab_diagnosis">
            <table class="table table-hover" id="tbl_diag_list">
                <thead>
                <tr>
                    <th>รหัส</th>
                    <th>รายการ</th>
                    <th>ประเภทการวินิจฉัย</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                </tr>
                </tbody>
            </table>
            <button class="btn btn-success pull-right" id="btn_diag_new"><i class="icon-plus icon-white"></i> เพิ่มรายการ</button>
        </div>
        <div class="tab-pane" id="tab_procedure">
            <table class="table table-hover tabble-striped" id="tbl_proced_list">
                <thead>
                <tr>
                    <th>รหัส</th>
                    <th>รายการ</th>
                    <th>ราคา</th>
                    <th>ผู้ทำหัถการ</th>
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
                </tr>
                </tbody>
            </table>

            <button class="btn btn-success pull-right" id="btn_proced_new"><i class="icon-plus icon-white"></i> เพิ่มรายการ</button>

        </div>
        <div class="tab-pane" id="tab_drug">
            <table class="table table-hover" id="tbl_drug_list">
                <thead>
                <tr>
                    <th>รายการ</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>วิธีใช้</th>
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
                </tr>
                </tbody>
            </table>
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-success" id="btn_drug_new"><i class="icon-plus-sign icon-white"></i> เพิ่ม</button>
                <!--
                <button type="button" class="btn"><i class="icon-th-list"></i> กำหนดสูตร</button>
                <button type="button" class="btn"><i class="icon-refresh"></i> Remed.</button>
                -->
                <button type="button" class="btn btn-danger" id="btn_drug_remove_bill"><i class="icon-trash icon-white"></i> ลบใบสั่งยา</button>
            </div>
        </div>
        <!-- Charge item -->
        <div class="tab-pane" id="tab_income">
            <table class="table table-hover" id="tbl_charge_list">
                <thead>
                <tr>
                    <th>รหัส</th>
                    <th>รายการ</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>รวม (บาท)</th>
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
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-success" id="btn_charge_new"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</button>
            </div>
        </div>
        <!-- end charge item -->
    </div>
</div>
<!-- new drug allergy -->
<div class="modal hide fade" id="modal_screening_allergy">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ข้อมูลการแพ้ยา</h3>
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
        <button type="button" class="btn btn-success" id="btn_screening_save_allergy"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</button>
    </div>
</div>
<!-- end drug allergy -->

<!-- new diagnosis -->
<div class="modal hide fade" id="mdl_diag_new">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>เพิ่มรายการวินิจฉัยโรค</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="txt_diag_query">รหัสการวินิจฉัยโรค</label>
                <div class="controls">
                    <input type="text" class="input-mini uneditable-input" disabled="disabled" id="txt_diag_query_code">
                    <input type="text" id="txt_diag_query" class="input-xxlarge" placeholder="พิมพ์รหัส หรือ ชื่อโรค">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="sl_diag_type">ประเภทการวินิจฉัย</label>
                <div class="controls">
                    <select id="sl_diag_type" class="input-xlarge">
                        <option value="">--</option>
                        <?php foreach($diag_types as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success" id="btn_diag_do_save"><i class="icon-plus icon-white"></i> เพิ่มรายการ</a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>

    </div>
</div>
<!-- end new diagnosis -->
<!-- new procedures -->
<div class="modal hide fade" id="mdl_proced_new">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>เพิ่มข้อมูลการให้หัตถการ</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <input type="hidden" id="txt_proced_isupdate">
            <div class="control-group">
                <label class="control-label" for="txt_diag_query">หัตถการ</label>
                <div class="controls">
                    <input type="text" class="input-small uneditable-input" disabled="disabled" id="txt_proced_query_code">
                    <input type="text" id="txt_proced_query" class="input-xxlarge" placeholder="พิมพ์รหัส หรือ ชื่อหัตถการ">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="txt_diag_query">ราคา</label>
                <div class="controls">
                    <input type="text" id="txt_proced_price" class="input-mini" data-type="number"> บาท
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="txt_diag_query">ผู้ทำหัตถการ</label>
                <div class="controls">
                    <input type="text" class="input-medium uneditable-input" disabled="disabled" id="txt_proced_provider_code">
                    <input type="text" id="txt_proced_provider_name" class="input-xlarge" placeholder="พิมพ์ชื่อเจ้าหน้าที่">
                </div>
            </div>

        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success" id="btn_proced_do_save"><i class="icon-plus icon-white"></i> เพิ่มรายการ</a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>

    </div>
</div>
<!-- end new procedures -->


<!-- new drug -->
<div class="modal hide fade" id="mdl_drug_new">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>เพิ่มรายการยา</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <input type="hidden" id="drug_isupdate" value="0">
            <input type="hidden" id="service_drug_id" value="">
            <div class="control-group">
                <label class="control-label" for="txt_drug_name">ชื่อยา/เวชภัณฑ์</label>
                <div class="controls">
                    <div class="input-append">
                        <input type="hidden" id="txt_drug_id">
                        <input id="txt_drug_name" class="input-xlarge uneditable-input" disabled="disabled" type="text" placeholder="คลิกปุ่มค้นหา">
                        <button class="btn btn-info" type="button" id="btn_drug_show_search">
                            <i class="icon-search icon-white"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="txt_drug_name">วิธีการใช้ยา</label>
                <div class="controls">
                    <div class="input-append">
                        <input type="hidden" id="txt_drug_usage_id">
                        <input id="txt_drug_usage_name" class="input-xlarge uneditable-input" disabled="disabled" type="text" placeholder="คลิกปุ่มค้นหา">
                        <button class="btn btn-info" type="button" id="btn_drug_usage_show_search">
                            <i class="icon-search icon-white"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="txt_drug_name">จำนวน</label>
                <div class="controls">
                    <input id="txt_drug_qty" class="input-mini" type="text" data-type="number" value="1">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="txt_drug_name">ราคา</label>
                <div class="controls">
                    <div class="input-append">
                        <input class="input-mini" id="txt_drug_price" type="text" data-type="number">
                        <span class="add-on">บาท</span>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success" id="btn_drug_do_save"><i class="icon-plus icon-white"></i> เพิ่มรายการ/ปรับปรุง</a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>

    </div>
</div>
<!-- end new drug -->

<!-- new drug -->
<div class="modal hide fade" id="mdl_drug_search">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>เพิ่มรายการยา</h3>
    </div>
    <div class="modal-body">
        <blockquote>ค้นหารายการยาที่ต้องการ โดยพิมพ์ชื่อยา เพื่อค้นหา</blockquote>
        <form class="form-actions form-inline">
            <label for="txt_drug_search_name">ค้นหา</label>
            <div class="input-append">
                <input id="txt_drug_search_name" class="input-xlarge" type="text" placeholder="พิมพ์ชื่อยา...">
                <button class="btn btn-info" type="button" id="bnt_drug_do_search">
                    <i class="icon-search icon-white"></i>
                </button>
            </div>
        </form>
        <table class="table table-hover" id="tbl_drug_search_result">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>ราคา</th>
                    <th>หน่วย</th>
                    <th>ความแรง</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>

    </div>
</div>

    <!-- search drug usage -->
<div class="modal hide fade" id="mdl_drug_usage_search">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>เพิ่มรายการยา</h3>
    </div>
    <div class="modal-body">
        <blockquote>ค้นหาวิธีการใช้ยา โดยพิมพ์ข้อความ หรือ รหัสการใช้ยา เพื่อค้นหา</blockquote>
        <form class="form-actions form-inline">
            <label for="txt_drug_search_name">ค้นหา</label>
            <div class="input-append">
                <input id="txt_drug_usage_search_query" class="input-xlarge" type="text" placeholder="พิมพ์วิธีการใช้/รหัสการใช้ยา...">
                <button class="btn btn-info" type="button" id="bnt_drug_usage_do_search">
                    <i class="icon-search icon-white"></i>
                </button>
            </div>
        </form>
        <table class="table table-hover" id="tbl_drug_usage_search_result">
            <thead>
            <tr>
                <th>alias</th>
                <th>วิธีการใช้</th>
                <th>name1</th>
                <th>name2</th>
                <th>name3</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>

    </div>
</div>

    <!-- end search drug usage -->

<!-- new charge item -->
<div class="modal hide fade" id="mdl_charge_new">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>เพิ่มรายการค่าใช้จ่าย</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <input type="hidden" id="charge_isupdate" value="0">
            <input type="hidden" id="service_charge_id" value="">
            <div class="control-group">
                <label class="control-label" for="txt_charge_name">รายการค่าใช้จ่าย</label>
                <div class="controls">
                    <input type="text" class="input-small uneditable-input" disabled="disabled" id="txt_charge_code">
                    <input id="txt_charge_name" class="input-xxlarge" type="text" placeholder="พิมพ์ชื่อรายการ">

                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="txt_charge_qty">จำนวน</label>
                <div class="controls">
                    <input id="txt_charge_qty" class="input-mini" type="text" data-type="number" value="1">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="txt_charge_price">ราคา</label>
                <div class="controls">
                    <div class="input-append">
                        <input class="input-mini" id="txt_charge_price" type="text" data-type="number">
                        <span class="add-on">บาท</span>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success" id="btn_charge_do_save"><i class="icon-plus icon-white"></i> เพิ่มรายการ/ปรับปรุง</a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>

    </div>
</div>
<!-- end new charge item -->

<!-- modal search charge item -->
<div class="modal hide fade" id="mdl_charge_search_item">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ค้นหารายการ</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <input type="hidden" id="charge_isupdate" value="0">
            <input type="hidden" id="service_charge_id" value="">
            <div class="control-group">
                <label class="control-label" for="txt_drug_name">รายการค่าใช้จ่าย</label>
                <div class="controls">
                    <div class="input-append">
                        <input type="hidden" id="txt_charge_id">
                        <input id="txt_charge_name" class="input-xlarge uneditable-input" disabled="disabled" type="text" placeholder="คลิกปุ่มค้นหา">
                        <button class="btn btn-info" type="button" id="btn_charge_show_search">
                            <i class="icon-search icon-white"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="txt_charge_qty">จำนวน</label>
                <div class="controls">
                    <input id="txt_charge_qty" class="input-mini" type="text" data-type="number" value="1">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="txt_charge_price">ราคา</label>
                <div class="controls">
                    <div class="input-append">
                        <input class="input-mini" id="txt_charge_price" type="text" data-type="number">
                        <span class="add-on">บาท</span>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success" id="btn_charge_do_save"><i class="icon-plus icon-white"></i> เพิ่มรายการ/ปรับปรุง</a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>

    </div>
</div>
<!-- end search charge  -->

<!-- FP -->
<div class="modal hide fade" id="mdl_fp">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>เพิ่มข้อมูลการวางแผนครอบครัว</h3>
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
		                    <a href="#" class="btn btn-success" id="btn_do_save_fp"><i class="icon-plus icon-white"></i> เพิ่มรายการ</a>
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
        <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>
    </div>
</div>
<!--  end FP -->
<!-- <script type="text/javascript" src="{{ base_url }}assets/apps/js/apps.services.js"></script> -->
<script type="text/javascript">
    head.js(
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.allergy.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.diagnosis.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.procedures.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.drugs.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.charges.js',
            '<?php echo base_url(); ?>assets/apps/js/apps.services.entries.fp.js'
    );
</script>