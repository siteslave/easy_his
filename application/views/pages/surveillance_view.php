<form class="form-inline well well-small">
    <input type="hidden" id="txt_surveil_hn" value="<?=isset($hn) ? $hn : ''?>" />
    <input type="hidden" id="txt_surveil_vn" value="<?=isset($vn) ? $vn : ''?>" />

    <div class="row">
        <div class="col-lg-2">
            <label>HN</label>
            <input type="text" disabled="disabled" value="<?=isset($hn) ? $hn : ''?>">
        </div>
        <div class="col-lg-3">
            <label>ชื่อ - สกุล</label>
            <input type="text" disabled="disabled" value="<?=isset($name) ? $name : ''?>">
        </div>
        <div class="col-lg-2">
            <label>CID</label>
            <input type="text" disabled="disabled" value="<?=isset($cid) ? $cid : ''?>">
        </div>
        <div class="col-lg-2">
            <label>วันเกิด</label>
            <input type="text" disabled="disabled" value="<?=isset($birthdate) ? $birthdate : ''?>">
        </div>
        <div class="col-lg-2">
            <label>อายุ (ปี)</label>
            <input type="text" disabled="disabled" value="<?=isset($age) ? $age : ''?>">
        </div>
    </div>


</form>

<legend>ข้อมูลการเจ็บป่วย</legend>
<div class="row">
    <div class="col-lg-2">
        <label class="control-label" for="txt_surveil_illdate">วันที่เริ่มป่วย</label>
        <input id="txt_surveil_illdate" type="text" value="<?=isset($illdate) ? $illdate : ''?>" <?=isset($illdate) ? 'disalbed="disabled"' : ''?> data-type="date"
            placeholder="dd/mm/yyyy" rel="tooltip" title="ระบุวันที่เริ่มป่วย">
    </div>
    <div class="col-lg-2">
        <label class="control-label" for="txt_surveil_diag_code">รหัส</label>
        <input type="text" id="txt_surveil_diag_code" disabled="disabled" placeholder="-*-" value="<?=isset($diag_code) ? $diag_code : ''?>" />
    </div>
    <div class="col-lg-8">
        <label class="control-label" for="txt_surveil_diag_name">การวินิจฉัย</label>
        <input type="text" id="txt_surveil_diag_name" disabled="disabled" value="<?=isset($diag_name) ? $diag_name : ''?>" />
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <label class="control-label" for="sl_surveil_syndrome">กลุ่มอาการ</label>
        <select id="sl_surveil_syndrome">
            <option value="">--</option>
            <?php
            foreach($syndromes as $r)
            {
                if(isset($syndrome))
                {
                    if($syndrome == $r->code)
                    {
                        echo '<option value="'.$r->code.'" selected="selected">['.$r->code.'] ' . $r->name . '</option>';
                    }
                    else
                    {
                        echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                    }
                }
                else
                {
                    echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                }

            }
            ?>
        </select>
    </div>
    <div class="col-lg-4">
        <label class="control-label" for="sl_surveil_506">รหัส 506</label>
        <select id="sl_surveil_506">
            <option value="">--</option>
            <?php
            foreach($groups as $r)
            {
                if(isset($code506))
                {
                    if($code506 == $r->code)
                    {
                        echo '<option value="'.$r->code.'" selected="selected">['.$r->code.'] ' . $r->name . '</option>';
                    }
                    else
                    {
                        echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                    }
                }
                else
                {
                    echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                }

            }
            ?>
        </select>
    </div>

    <div class="col-lg-4">
        <label class="control-label" for="sl_surveil_organism">ชนิดของเชื้อ</label>
        <select id="sl_surveil_organism">
            <option value="">--</option>
            <?php
            foreach($ogranisms as $r)
            {
                if(isset($organism))
                {
                    if($organism == $r->code)
                    {
                        echo '<option value="'.$r->code.'" selected="selected">['.$r->code.'] ' . $r->name . '</option>';
                    }
                    else
                    {
                        echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                    }
                }
                else
                {
                    echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                }

            }
            ?>
        </select>
    </div>

</div>
<div class="row">
    <div class="col-lg-4">
        <label class="control-label" for="sl_surveil_complication">สาเหตุการป่วย</label>
        <select id="sl_surveil_complication">
            <option value="">--</option>
            <?php
            foreach($complications as $r)
            {
                if(isset($complication))
                {
                    if($complication == $r->code)
                    {
                        echo '<option value="'.$r->code.'" selected="selected">['.$r->code.'] ' . $r->name . '</option>';
                    }
                    else
                    {
                        echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                    }
                }
                else
                {
                    echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                }
            }
            ?>
        </select>
    </div>
    <div class="col-lg-3">
        <label class="control-label" for="sl_surveil_ptstatus">สภาพผู้ป่วย</label>
        <select id="sl_surveil_ptstatus">
            <option value="">--</option>
            <option value="1" <?=isset($ptstatus) ? $ptstatus == '1' ? 'selected="selected"' : '' : ''?>>[1] หาย</option>
            <option value="2" <?=isset($ptstatus) ? $ptstatus == '2' ? 'selected="selected"' : '' : ''?>>[2] ตาย</option>
            <option value="3" <?=isset($ptstatus) ? $ptstatus == '3' ? 'selected="selected"' : '' : ''?>>[3] ยังรักษาอยู่</option>
            <option value="9" <?=isset($ptstatus) ? $ptstatus == '9' ? 'selected="selected"' : '' : ''?>>[9] ไม่ทราบ</option>
        </select>
    </div>
    <div class="col-lg-2">
        <label class="control-label" for="txt_surveil_date_death">วันที่เสียชีวิต</label>
        <input id="txt_surveil_date_death" type="text" data-type="date" placeholder="dd/mm/yyyy" rel="tooltip"
            title="ระบุวันที่" value="<?=isset($date_death) ? $date_death : ''?>">
    </div>
</div>
<legend>ที่อยู่ขณะป่วย</legend>
<div class="row">
    <div class="col-lg-2">
        <label class="control-label" for="txt_surveil_address">เลขที่</label>
        <input type="text" class="input-mini" id="txt_surveil_address" placeholder=".." value="<?=isset($illhouse) ? $illhouse : ''?>">
    </div>
    <div class="col-lg-1">
        <label class="control-label" for="txt_surveil_moo">หมู่</label>
        <input type="text" rel="tooltip" title="ระบุตัวเลข 2 หลัก เช่น 00, 01, 02" data-type="number"
               value="<?=isset($illvillage) ? $illvillage : ''?>" id="txt_surveil_moo" placeholder="00">
    </div>
    <div class="col-lg-3">
        <label class="control-label" for="sl_surveil_province">จังหวัด</label>
        <select id="sl_surveil_province">
            <option value="99">ไม่ทราบ</option>
            <?php
            foreach($provinces as $t)
            {
                if(isset($illchangwat))
                {
                    if($illchangwat == $t->code)
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
        <label class="control-label" for="sl_surveil_ampur">อำเภอ</label>
        <select id="sl_surveil_ampur" rel="tooltip" title="กรุณาเลือกจังหวัดก่อน">
            <option value="">-*-</option>
            <?php
            foreach($ampur as $t)
            {
                if(isset($illampur))
                {
                    if($illampur == $t->code)
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
        <label class="control-label" for="sl_surveil_tambon">ตำบล</label>
        <select id="sl_surveil_tambon" rel="tooltip" title="กรุณาเลือกอำเภอก่อน">
            <option value="">-*-</option>
            <?php
            foreach($tambon as $t)
            {
                if(isset($illtambon))
                {
                    if($illtambon == $t->code)
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
</div>
<div class="row">
    <div class="col-lg-3">
        <label class="control-label" for="txt_surveil_school_class">ชั้นเรียน</label>
        <input type="text" id="txt_surveil_school_class" value="<?=isset($school_class) ? $school_class : ''?>" />
    </div>
    <div class="col-lg-3">
        <label class="control-label" for="txt_surveil_school_name">โรงเรียน</label>
        <input type="text" id="txt_surveil_school_name" value="<?=isset($school_name) ? $school_name : ''?>" />
    </div>
    <div class="col-lg-3">
        <label class="control-label" for="txt_surveil_latitude">Latitude</label>
        <input type="text" id="txt_surveil_latitude" value="<?=isset($latitude) ? $latitude : ''?>" />
    </div>
    <div class="col-lg-3">
        <label class="control-label" for="txt_longitude">Longitude</label>
        <input id="txt_surveil_longitude" type="text" value="<?=isset($longitude) ? $longitude : ''?>" >
    </div>
</div>
<br>
<a href="#" id="btn_surveil_save" class="btn btn-success"><i class="icon-save"></i> บันทึกข้อมูล</a>