<input type="hidden" id="txt_rfo_vn" value="<?=$vn?>"/>
<input type="hidden" id="txt_rfo_hn" value="<?=$hn?>"/>
<input type="hidden" id="txt_rfo_id" value="<?=$id?>"/>
<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_rfo_detail" data-toggle="tab"><i class="icon-edit"></i> ข้อมูลการส่งต่อ</a></li>
        <li><a href="#tab_rfo_followup" data-toggle="tab"><i class="icon-check"></i> ติดตามผลการรักษา</a></li>
        <li><a href="#tab_rfo_history" data-toggle="tab"><i class="icon-time"></i> ประวัติการส่งต่อ</a></li>
    </ul>
    <div class="tab-content">
        <br>
        <div class="tab-pane active" id="tab_rfo_detail">
            <div class="row">
                <div class="col-lg-2">
                    <label for="#">เลขที่</label>
                    <input type="text" id="txt_rfo_no" disabled="disabled" placeholder="-*-" />
                </div>
                <div class="col-lg-2">
                    <label for="#">วันที่ส่ง</label>
                    <input type="text" id="txt_rfo_date" data-type="date" rel="tooltip" title="ระบุวันที่ส่ง เช่น 28/02/2556" placeholder="dd/mm/yyyy" />
                </div>
                <div class="col-lg-2">
                    <label for="#">เวลา</label>
                    <input type="text" id="txt_rfo_time" data-type="time" rel="tooltip" title="ระบุเวลา ชช:นน" placeholder="hh:mm" />
                </div>
                <div class="col-lg-2">
                    <label for="#">รหัส</label>
                    <input type="text" id="txt_rfo_hosp_code" disabled="disabled" rel="tooltip" title="พิมพ์ชื่อหรือรหัสสถานบริการในช่องค้นหา" placeholder="-*-" />
                </div>
                <div class="col-lg-4">
                    <label for="#">ค้นหาสถานบริการ</label>
                    <input type="text" id="txt_rfo_hosp_name" rel="tooltip" title="พิมพ์ชื่อหรือรหัสสถานบริการในช่องค้นหา" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <label for="">สาเหตุการส่งต่อ</label>
                    <select id="sl_rfo_cause">
                        <option value="">-*-</option>
                        <option value="1">เพื่อการวินิจฉัยและรักษา</option>
                        <option value="2">เพื่อการวินิจฉัย</option>
                        <option value="3">เพื่อการรักษาต่อเนื่อง</option>
                        <option value="4">เพื่อการดูแลต่อใกล้บ้าน</option>
                        <option value="5">ตามความต้องการผู้ป่วย</option>
                        <option value="6">เพื่อส่งผู้ป่วยกลับไปยังสถานพยาบาลที่ส่งผู้ป่วยมา</option>
                        <option value="7">เป็นการตอบกลับการส่งต่อ</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="">เหตุผลการส่งตัว</label>
                    <select id="sl_rfo_reason">
                        <option value="">-*-</option>
                        <option value="1">วินิจฉัย ชัณสูตร/ส่งต่อ</option>
                        <option value="2">ขีดความสามารถไม่เพียงพอ ด้านบุคลากร</option>
                        <option value="2">ขีดความสามารถไม่เพียงพอ ด้านเครื่องมือ/สถานที่</option>
                        <option value="2">ขีดความสามารถไม่เพียงพอ ด้านบุคลากร เครื่องมือ และ สถานที่</option>
                        <option value="2">ขีดความสามารถไม่เพียงพอ ด้านวิชาการ</option>
                        <option value="2">ขีดความสามารถเพียงพอ แต่จำเป็น (เช่น ผ่าตัด)</option>
                        <option value="2">ขีดความสามารถเพียงพอ แต่ผู้ป่วย/ญาติ ต้องการ</option>
                        <option value="2">ขีดความสามารถเพียงพอ แต่ต้องการใช้สิทธิ</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="sl_rfo_clinic">แผนกที่ส่งต่อ</label>
                    <select id="sl_rfo_clinic">
                        <option value="">-*-</option>
                        <?php
                        foreach ($clinics as $t){
                            if(isset($clinic_id))
                            {
                                if($clinic_id == $t->id)
                                {
                                    echo '<option value="'.$t->id.'" selected>' . $t->name . '</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                }
                            }
                            else
                            {
                                echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="">สิ่งที่ต้องการให้ดำเนินการ</label>
                    <textarea rows="3" id="txt_rfo_request"></textarea>
                </div>
                <div class="col-lg-6">
                    <label for="">รายละเอียดเพิ่มเติม</label>
                    <textarea rows="3" id="txt_rfo_comment"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <label for="">ผลการส่งต่อ</label>
                    <select id="sl_rfo_result">
                        <option value="">-*-</option>
                        <option value="1">ตอบรับการส่งต่อ</option>
                        <option value="2">ปฏิเสธการส่งต่อ</option>
                        <option value="3">เสียชีวิตระหว่างการส่งต่อ</option>
                        <option value="4">ไม่พบผู้ป่วย</option>
                        <option value="5">อื่นๆ</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="">แพทย์ผู้ส่งต่อ</label>
                    <select name="" id="sl_rfo_provider">
                        <option value="">-*-</option>
                        <?php
                        foreach ($providers as $t){
                            if(isset($provider_id))
                            {
                                if($provider_id == $t->id)
                                {
                                    echo '<option value="'.$t->id.'" selected>' . $t->name . '</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                }
                            }
                            else
                            {
                                echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <button type="button" class="btn btn-success" id="btn_rfo_save"><i class="icon-save"></i> บันทึกข้อมูลส่งต่อ</button>
        </div>
        <div class="tab-pane" id="tab_rfo_followup">
            <div class="row">
                <div class="col-lg-2">
                    <label for="">วันที่ตอบกลับ</label>
                    <input type="text" data-type="date" rel="tooltip" title="รูปแบบวันที่ พ.ศ เช่น 28/02/2556" placeholder="dd/mm/yyyy" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-11">
                    <label for="">ผลการรักษา</label>
                    <textarea rows="5" id="txt_rfo_answer_detail"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <label for="">รหัสวินิจฉัย</label>
                    <input type="text" disabled="disabled" placeholder="-*-" id="txt_rfo_answer_diag_code" />
                </div>
                <div class="col-lg-9">
                    <label for="">การวินิจฉัย (พิมพ์รหัส หรือ ข้อความ เพื่อค้นหา)</label>
                    <input type="text" id="txt_rfo_answer_diag_name" placeholder="พิมพ์รหัส หรือข้อความเพื่อค้นหา..."/>
                </div>
            </div>
            <br>
            <button type="button" class="btn btn-success"><i class="icon-save"></i> บันทึกการติดตาม</button>
        </div>
        <div class="tab-pane" id="tab_rfo_history">
            <p>Howdy, I'm in Section 2.</p>
        </div>
    </div>
</div>
