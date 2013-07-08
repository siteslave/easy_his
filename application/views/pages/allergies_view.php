<form action="#">
    <input type="hidden" id="txt_isupdate" value="<?=isset($drug_id) ? '1' : ''?>">
    <input type="hidden" id="txt_allergy_hn" value="<?=isset($hn) ? $hn : ''?>">
    <div class="row">
        <div class="col-lg-2">
            <label for="txt_allergies_date_record">วันที่รายงาน</label>
            <input id="txt_allergies_date_record" type="text" data-type="date"
                rel="tooltip" title="ระบุวันที่เป็น พ.ศ เช่น 28/02/2556" value="<?=isset($record_date) ? $record_date : ''?>">

        </div>
        <div class="col-lg-10">
            <label for="txt_allergies_name">ยาที่แพ้</label>
            <input type="hidden" id="txt_allergies_code" value="<?=isset($drug_id) ? $drug_id : ''?>">
            <input type="text" id="txt_allergies_name" placeholder="พิมพ์ชื่อยาเพื่อค้นหา..."
                rel="tooltip" title="พิมพ์ชื่อยาเพื่อค้นหา..." value="<?=isset($drug_name) ? $drug_name : ''?>"
                <?=isset($drug_id) ? 'disabled="disabled"' : ''?>>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <label for="sl_allergies_symptom">อาการแพ้</label>
            <select id="sl_allergies_symptom">
                <option value="">--</option>
                <?php
                foreach($symptoms as $t) {
                    if(isset($symptom_id))
                    {
                        if($symptom_id == $t->id) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                        echo '<option value="'.$t->id.'">'.$t->name.'</option>';
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
            <label for="sl_allergies_diag_type">การวินิจฉัย</label>
            <select id="sl_allergies_diag_type">
                <option value="">--</option>
                <?php
                foreach($diag_types as $t) {
                    if(isset($diag_type_id))
                    {
                        if($diag_type_id == $t->id) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                        echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                    }
                    else
                    {
                        echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-lg-6">
            <label for="sl_allergies_alevel">ความรุนแรง</label>
            <select id="sl_allergies_alevel">
                <option value="">--</option>
                <?php
                foreach($alevels as $t) {
                    if(isset($alevel_id))
                    {
                        if($alevel_id == $t->id) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                        echo '<option value="'.$t->id.'">'.$t->name.'</option>';
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
        <div class="col-lg-2">
            <label for="txt_allergies_hosp_code">รหัส</label>
            <input type="text" id="txt_allergies_hosp_code" value="<?=isset($hospcode) ? $hospcode : ''?>" disabled="disabled" placeholder="-*-">
        </div>
        <div class="col-lg-10">
            <label for="txt_allergies_hosp_name">หน่วยงานที่ให้ข้อมูล (พิมพ์ชื่อหรือรหัสเพื่อค้นหา)</label>
            <input type="text" id="txt_allergies_hosp_name" placeholder="พิมพ์ชื่อ หรือ รหัสสถานบริการ เพื่อค้นหา..."
                   rel="tooltip" title="พิมพ์ชื่อหรือรหัสสถานบริการเพื่อค้นหา" value="<?=isset($hospname) ? $hospname : ''?>">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="sl_allergies_informant">ผู้ให้ประวัติ</label>
            <select id="sl_allergies_informant" class="input-xlarge">
                <option value="">--</option>
                <?php
                foreach($informants as $t) {
                    if(isset($informant_id))
                    {
                        if($informant_id == $t->id) echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                        echo '<option value="'.$t->id.'">'.$t->name.'</option>';
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
</form>
<br>
<button type="button" class="btn btn-success" id="btn_allergies_save"><i class="icon-plus-sign"></i> บันทึกข้อมูล</button>
