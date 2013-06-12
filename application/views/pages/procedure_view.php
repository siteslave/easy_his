<form class="form-horizontal">

    <input type="hidden" id="txt_proced_vn" value="<?=$vn?>">
    <input type="hidden" id="txt_proced_isupdate" value="<?=$update?>">
    <div class="row">
        <div class="col col-lg-2">
            <label class="control-label" for="txt_proced_query">รหัส</label>
            <input type="text" disabled="disabled" style="background-color: white;"
                id="txt_proced_query_code" rel="tooltip" title="พิมพ์ชื่อหัตถการในช่องค้นหา" placeholder="-*-"
                value="<?=isset($proced) ? $proced->code: ''?>">
        </div>
        <div class="col col-lg-10">
            <label class="control-label" for="txt_proced_query">คำค้นหา</label>
            <input type="text" id="txt_proced_query" placeholder="พิมพ์รหัส หรือ ชื่อหัตถการ"
                rel="tooltip" title="พิมพ์รหัส หรือชื่อหัตถการ เพื่อค้นหารายการ"
                value="<?=isset($proced) ? $proced->proced_name : ''?>" <?=$update ? 'disabled="disabled"' : ''?>>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-2">
            <label for="txt_proced_price">ราคา</label>
            <div class="input-group" style="width: 150px;">
                <input data-type="number" id="txt_proced_price"
                    rel="tooltip" title="ระบุเวลาราคาในการทำหัตถการ" type="text" placeholder="0.00"
                    value="<?=isset($proced) ? $proced->price : ''?>">
                <span class="input-group-addon">บาท</span>
            </div>
        </div>
        <div class="col col-lg-2">
            <label for="txt_proced_start_time">เวลาเริ่ม</label>
            <input type="text" id="txt_proced_start_time"
                   rel="tooltip" title="ระบุเวลาเริ่มทำหัตถการ" data-type="time" placeholder="12:00"
                value="<?=isset($proced) ? $proced->start_time : ''?>">
        </div>
        <div class="col col-lg-2">
            <label for="txt_proced_end_time">เวลาสิ้นสุด</label>
            <input type="text" id="txt_proced_end_time"
                   rel="tooltip" title="ระบุเวลาสิ้นสุดการทำหัตถการ"  data-type="time" placeholder="12:00"
                value="<?=isset($proced) ? $proced->end_time : ''?>">
        </div>
    </div>

    <div class="row">
        <div class="col col-lg-4">
            <label for="sl_proced_clinic">คลินิกที่ทำหัตถการ</label>
            <select id="sl_proced_clinic">
                <option value="">--</option>
                <?php
                foreach($clinics as $t) {
                    if(isset($proced))
                    {
                        if($proced->clinic_id == $t->id)
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
        <div class="col col-lg-4">
            <label for="sl_proced_provider">ผู้ทำหัตถการ</label>
            <select id="sl_proced_provider">
                <option value="">--</option>
                <?php
                foreach($providers as $prov) {
                    if(isset($proced))
                    {
                        if($proced->provider_id == $prov->id)
                        {
                            echo '<option value="'.$prov->id.'" selected="selected">'.$prov->name.'</option>';
                        }
                        else
                        {
                            echo '<option value="'.$prov->id.'">'.$prov->name.'</option>';
                        }
                    }
                    else
                    {
                        echo '<option value="'.$prov->id.'">'.$prov->name.'</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <br>
    <?php
    if(!empty($vn))
    {
        echo '<a href="#" class="btn btn-success" id="btn_proced_do_save"><i class="icon-save"></i> บันทึกข้อมูล</a>';
    }
    else
    {
        echo '<a href="#" class="btn btn-success" disabled="disabled" rel="tooltip" title="ไม่พบเลขที่รับบริการ (VN)"><i class="icon-save"></i> บันทึกข้อมูล</a>';
    }

    if(!$update)
    {
        echo ' <a href="javascript:void(0);" id="btn_proced_refresh" class="btn btn-default"><i class="icon-refresh"></i> ล้างข้อมูล</a>';
    }
    ?>
</form>
