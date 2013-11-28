<div class="navbar navbar-default">
    <form action="#" class="navbar-form">
        <input type="hidden" id="txt_service_hn" value="<?=isset($hn) ? $hn : ''?>" />
        <input type="hidden" id="txt_service_vn" value="<?=isset($vn) ? $vn : ''?>" />
        <input type="hidden" id="txt_reg_service_patient_fullname" value="<?=isset($fullname) ? $fullname : ''?>" />
        <input type="hidden" id="txt_service_appoint_id" value="<?=!empty($appoint_id) ? $appoint_id : ''?>" />

        <input type="hidden" id="txt_reg_service_insc_hosp_main_code1" value="<?=isset($ins_hosp_main_code) ? $ins_hosp_main_code : ''?>" />
        <input type="hidden" id="txt_reg_service_insc_hosp_main_name1" value="<?=isset($ins_hosp_main_name) ? $ins_hosp_main_name : ''?>" />
        <input type="hidden" id="txt_reg_service_insc_hosp_sub_code1" value="<?=isset($ins_hosp_sub_code) ? $ins_hosp_sub_code : ''?>" />
        <input type="hidden" id="txt_reg_service_insc_hosp_sub_name1" value="<?=isset($ins_hosp_sub_name) ? $ins_hosp_sub_name : ''?>" />

        <input type="hidden" style="width: 300px;" id="txt_service_profile_hn" class="form-control">
        <input type="text" style="width: 530px;" disabled="disabled" placeholder="-*-" id="txt_service_profile"
               class="form-control" value="<?=isset($patient_detail) ? $patient_detail : ''?>" />
    </form>
</div>
<div class="tab-pane active" id="tab_user_profile">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a href="#tab_service_detail" data-toggle="tab"><i class="fa fa-th-list"></i> ข้อมูลการรับบริการ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_service_detail">
            <br>
            <form action="#">
                <div class="row">
                    <div class="col-lg-2">
                        <label for="txt_reg_service_date">วันที่</label>
                        <input id="txt_reg_service_date" class="form-control" type="text" data-type="date" <?=isset($vn) ? 'disabled="disabled"': ''?>
                               placeholder="dd/mm/yyyy" style="width: 120px;" required value="<?=isset($date_serv) ? $date_serv : get_current_date()?>">
                    </div>
                    <div class="col-lg-1">
                        <label for="txt_reg_service_time">เวลา</label>
                        <input type="text" data-type="time" id="txt_reg_service_time" class="form-control"
                               placeholder="hh:mm" style="width: 70px;" required  value="<?=isset($time_serv) ? $time_serv : date('H:i:s')?>">
                    </div>

                    <div class="col-lg-3">
                        <label for="sl_reg_service_patient_status">สภาพผู้ป่วย</label>
                        <select id="sl_reg_service_patient_status" class="form-control">
                            <option value="0" <?=isset($patient_type) ? $patient_type == '0' ? 'selected="selected"' : '' : ''?>>ปกติ</option>
                            <option value="1" <?=isset($patient_type) ? $patient_type == '1' ? 'selected="selected"' : '' : ''?>>เมาสุรา/อาละวาด</option>
                            <option value="2" <?=isset($patient_type) ? $patient_type == '2' ? 'selected="selected"' : '' : ''?>>ไม่รู้สึกตัว</option>
                            <option value="3" <?=isset($patient_type) ? $patient_type == '3' ? 'selected="selected"' : '' : ''?>>ไม่มีญาติ</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label for="sl_reg_service_clinic">แผนกที่รับบริการ</label>
                        <select id="sl_reg_service_clinic" class="form-control">
                            <option value="">--</option>
                            <?php
                            foreach($clinics as $t)
                            {
                                if(isset($clinic))
                                {
                                    if($t->id == $clinic)
                                    {
                                        echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                                    }
                                }
                                else
                                {
                                    echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_reg_service_doctor_room">ห้องตรวจ</label>
                        <select id="sl_reg_service_doctor_room" class="form-control">
                            <option value="">--</option>
                            <?php
                            foreach($doctor_rooms as $t)
                            {
                                if(isset($doctor_room))
                                {
                                    if($t->id == $doctor_room)
                                    {
                                        echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                                    }
                                }
                                else
                                {
                                    echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                                }
                            }

                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="sl_reg_service_pttype">ประเภทผู้ป่วย</label>
                        <select  id="sl_reg_service_pttype" class="form-control">
                            <option value="0" <?=isset($patient_type) ? $patient_type == '0' ? 'selected="selected"' : '' : ''?>>ผู้ป่วยรายเก่า</option>
                            <option value="1" <?=isset($patient_type) ? $patient_type == '1' ? 'selected="selected"' : '' : ''?>>ผู้ป่วยรายใหม่</option>
                            <option value="2" <?=isset($patient_type) ? $patient_type == '2' ? 'selected="selected"' : '' : ''?>>ผู้รับบริการอื่น</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_reg_service_location">ที่ตั้ง</label>
                        <select  id="sl_reg_service_location" class="form-control">
                            <option value="1" <?=isset($location) ? $location == '1' ? 'selected="selected"' : '' : ''?>>ในเขตรับผิดชอบ</option>
                            <option value="2" <?=isset($location) ? $location == '2' ? 'selected="selected"' : '' : ''?>>นอกเขตรับผิดชอบ</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_reg_service_typein">ประเภทการมา</label>
                        <select id="sl_reg_service_typein" class="form-control">
                            <option value="1" <?=isset($type_in) ? $type_in == '1' ? 'selected="selected"' : '' : ''?>>มารับบริการเอง</option>
                            <option value="2" <?=isset($type_in) ? $type_in == '2' ? 'selected="selected"' : '' : ''?>>มารับบริการตามนัดหมาย</option>
                            <option value="3" <?=isset($type_in) ? $type_in == '3' ? 'selected="selected"' : '' : ''?>>ได้รับการส่งต่อจากสถานพยาบาลอื่น</option>
                            <option value="4" <?=isset($type_in) ? $type_in == '4' ? 'selected="selected"' : '' : ''?>>ได้รับการส่งตัวจากบริการ EMS</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_reg_service_service_place">สถานที่รับบริการ</label>
                        <select id="sl_reg_service_service_place" class="form-control">
                            <option value="1" <?=isset($service_place) ? $service_place == '1' ? 'selected="selected"' : '' : ''?>>ในสถานบริการ</option>
                            <option value="2" <?=isset($service_place) ? $service_place == '2' ? 'selected="selected"' : '' : ''?>>นอกสถานบริการ</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="">ในเวลา</label>
                        <select id="sl_reg_service_intime" class="form-control">
                            <option value="1" <?=isset($intime) ? $intime == '1' ? 'selected="selected"' : '' : ''?>>ในเวลาราชการ</option>
                            <option value="2" <?=isset($intime) ? $intime == '2' ? 'selected="selected"' : '' : ''?>>นอกเวลาราชการ</option>
                        </select>
                    </div>
                    <div class="col-lg-9">
                        <label for="txt_reg_service_cc">อาการแรกรับ (CC)</label>
                        <textarea rows="1" id="txt_reg_service_cc" class="form-control"><?=isset($cc) ? $cc : ''?></textarea>
                    </div>
                </div>
                <br>
                <legend><i class="icon-globe"></i> สิทธิการรักษา</legend>

                    <div class="row">
                        <div class="col-lg-5">
                            <label for="sl_reg_service_insc">สิทธิการรักษา</label>
                            <select id="sl_reg_service_insc" class="form-control">
                                <option value="">--</option>
                                <?php
                                    foreach($inscls as $t) {
                                        if(isset($ins_id))
                                        {
                                            if($t->code == $ins_id)
                                            {
                                                echo '<option value="'.$t->code.'" selected="selected">'.$t->name.'</option>';
                                            }
                                            else
                                            {
                                                echo '<option value="'.$t->code.'">'.$t->name.'</option>';
                                            }
                                        }
                                        else
                                        {
                                            echo '<option value="'.$t->code.'">'.$t->name.'</option>';
                                        }
                                    }


                                ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="txt_reg_service_insc_code">เลขที่บัตร</label>
                            <input type="text" id="txt_reg_service_insc_code" class="form-control" value="<?=isset($ins_code) ? $ins_code : ''?>">
                        </div>
                        <div class="col-lg-2">
                            <label for="txt_reg_service_insc_start_date">วันออกบัตร</label>
                            <input id="txt_reg_service_insc_start_date" type="text" data-type="date" class="form-control"
                                   placeholder="dd/mm/yyyy" rel="tooltip" title="ระบุวันที่ พ.ศ" value="<?=isset($ins_start_date) ? $ins_start_date : ''?>">
                        </div>
                        <div class="col-lg-2">
                            <label for="txt_reg_service_insc_expire_date">วันหมดอายุ</label>
                            <input id="txt_reg_service_insc_expire_date" type="text" data-type="date" class="form-control"
                                   placeholder="dd/mm/yyyy" rel="tooltip" title="ระบุวันที่ พ.ศ" value="<?=isset($ins_expire_date) ? $ins_expire_date : ''?>">
                        </div>
                    </div>
                    <div class="row">
<!--                        <div class="col-lg-2">-->
<!--                            <label for="txt_reg_service_insc_hosp_main_code">รหัส</label>-->
<!--                            <input type="text" disabled="disabled" id="txt_reg_service_insc_hosp_main_code" placeholder="-*-"-->
<!--                                   class="form-control" value="--><?//=isset($ins_hosp_main_code) ? $ins_hosp_main_code : ''?><!--">-->
<!--                        </div>-->
                        <div class="col-lg-4">
                            <label for="txt_reg_service_insc_hosp_main_name">สถานบริการหลัก</label>
<!--                            <select name="txt_reg_service_insc_hosp_main_name"-->
<!--                                    class="form-control" id="txt_reg_service_insc_hosp_main_name" data-placeholder="เลือกสถานบริการ">-->
<!--                                <option value=""></option>-->
<!--                            </select>-->
                            <input type="hidden" id="txt_reg_service_insc_hosp_main_name" style="width: 300px;" />
                        </div>
<!--                        <div class="col-lg-2">-->
<!--                            <label for="txt_reg_service_insc_hosp_sub_code">รหัส</label>-->
<!--                            <input type="text" disabled="disabled" id="txt_reg_service_insc_hosp_sub_code"-->
<!--                                   placeholder="-*-" class="form-control"-->
<!--                                   value="--><?//=isset($ins_hosp_sub_code) ? $ins_hosp_sub_code : ''?><!--">-->
<!--                        </div>-->
                        <div class="col-lg-4">
                            <label for="txt_reg_service_insc_hosp_sub_name">สถานบริการรอง</label>
                            <input type="hidden" id="txt_reg_service_insc_hosp_sub_name" style="width: 300px;">
                        </div>
                    </div>

            </form>

            <br>
            <button type="button" class="btn btn-success" id="btn_save_service_register"><i class="icon-save"></i> บันทึกข้อมูล</button>
        </div>
    </div>
</div>

