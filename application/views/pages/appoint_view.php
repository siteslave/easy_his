<input type="hidden" id="txt_ap_hn" value="<?=$hn?>">
<input type="hidden" id="txt_ap_vn" value="<?=$vn?>">
<input type="hidden" id="txt_ap_isupdate" value="<?=isset($id)? '1' : '0'?>">
<input type="hidden" id="txt_ap_id" value="<?=isset($id)? $id : ''?>">
<form action="#">
    <div class="row">
        <div class="col-lg-2">
            <label for="txt_date">วันที่นัด</label>
            <input id="txt_ap_date" type="text" data-type="date" rel="tooltip"
                   value="<?=isset($apdate) ? $apdate : ''?>" <?=isset($id)? 'disabled="disabled"' : ''?> title="ระบุวันที่ในรูปแบบ พ.ศ" placeholder="dd/mm/yyyy">
        </div>
        <div class="col-lg-2">
            <label for="txt_time">เวลา</label>
            <input type="text" data-type="time" id="txt_ap_time"
                   value="<?=isset($aptime) ? $aptime : ''?>" rel="tooltip" title="ระบุเวลาที่นัด" placeholder="hh:mm">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label for="sl_ap_clinic">แผนกที่นัด</label>
            <select id="sl_ap_clinic">
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
            <select name="" id="sl_ap_type" <?=isset($id)? 'disabled="disabled"' : ''?>>
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
            <select name="" id="sl_ap_provider">
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
        <div class="col-lg-2">
            <label for="txt_ap_diag_code">รหัส</label>
            <input type="text" id="txt_ap_diag_code" value="<?=isset($diag_code) ? $diag_code : ''?>" placeholder="-*-" disabled="disabled" rel="tooltip" title="พิมพ์คำค้นหาในช่องค้นหา">
        </div>
        <div class="col-lg-10">
            <label for="txt_ap_diag_code">คำค้นหา</label>
            <input type="text" id="txt_ap_diag_name" placeholder="พิมพ์คำค้นหา"
                   value="<?=isset($diag_name) ? $diag_name : ''?>" rel="tooltip" title="พิมพ์รหัส หรือรายการที่ต้องการค้น">
        </div>
    </div>
</form>
<br>
<button type="button" class="btn btn-success" id="btn_ap_do_register">
    <i class="icon-save"></i> บันทึกข้อมูลนัด
</button>