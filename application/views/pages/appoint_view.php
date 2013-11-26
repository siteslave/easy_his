<input type="hidden" id="txt_ap_hn" value="<?=$hn?>">
<input type="hidden" id="txt_ap_vn" value="<?=$vn?>">
<input type="hidden" id="txt_ap_isupdate" value="<?=isset($id)? '1' : '0'?>">
<input type="hidden" id="txt_ap_id" value="<?=isset($id)? $id : ''?>">
<input type="hidden" id="txt_ap_diag_code" value="<?=isset($diag_code)? $diag_code : ''?>">
<input type="hidden" id="txt_ap_diag_name2" value="<?=isset($diag_name)? $diag_name : ''?>">
<form action="#">
    <div class="row">
        <div class="col-lg-2">
            <label for="txt_date">วันที่นัด</label>
            <input id="txt_ap_date" class="form-control" type="text" data-type="date" rel="tooltip"
                   value="<?=isset($apdate) ? $apdate : ''?>" <?=isset($id)? 'disabled="disabled"' : ''?> title="ระบุวันที่ในรูปแบบ พ.ศ" placeholder="dd/mm/yyyy">
        </div>
        <div class="col-lg-2">
            <label for="txt_time">เวลา</label>
            <input type="text" data-type="time" id="txt_ap_time" class="form-control"
                   value="<?=isset($aptime) ? $aptime : ''?>" rel="tooltip" title="ระบุเวลาที่นัด" placeholder="hh:mm">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label for="sl_ap_clinic">แผนกที่นัด</label>
            <select id="sl_ap_clinic" class="form-control">
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
        <div class="col-lg-4">
            <label for="sl_ap_type">ประเภทกิจกรรมนัด</label>
            <select name="" class="form-control" id="sl_ap_type" <?=isset($id)? 'disabled="disabled"' : ''?>>
                <?php
                foreach ($aptypes as $t){
                    if(isset($type))
                    {
                        if($type == $t->id)
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
        <div class="col-lg-4">
            <label for="sl_ap_provider">แพทย์ผู้นัด</label>
            <select name="" id="sl_ap_provider" class="form-control">
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

    <div class="row">
        <div class="col-lg-6">
            <label for="txt_ap_diag_name">คำค้นหา</label>
            <input type="hidden" id="txt_ap_diag_name" style="width: 550px;">
        </div>
    </div>
</form>
<br>
<button type="button" class="btn btn-success" id="btn_ap_do_register">
    <i class="fa fa-save"></i> บันทึกข้อมูลนัด
</button>