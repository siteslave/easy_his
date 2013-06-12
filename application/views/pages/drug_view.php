<form action="#">
    <input type="hidden" id="drug_isupdate" value="<?=$update?>">
    <input type="hidden" id="service_drug_id" value="<?=isset($drug) ? $drug->id : ''?>">
    <div class="row">
        <div class="col col-lg-8">
            <label for="txt_drug_name">ชื่อยา/เวชภัณฑ์</label>
            <input type="hidden" id="txt_drug_id" value="<?=isset($drug) ? $drug->drug_id : ''?>">
            <input id="txt_drug_name" type="text" placeholder="พิมพ์รายการยา เพื่อค้นหา..."
                   title="พิมพ์รายการยา เพื่อค้นหา..." rel="tooltip" autocomplete="off"
                value="<?=isset($drug) ? $drug->drug_name : ''?>" <?=$update ? 'disabled="disabled"' : ''?>>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-8">
            <label for="txt_drug_name">วิธีการใช้ยา</label>
            <input type="hidden" id="txt_drug_usage_id" value="<?=isset($drug) ? $drug->usage_id : ''?>">
            <input id="txt_drug_usage_name" type="text" placeholder="พิมพ์สูตร วิธีการใช้ยา เพื่อค้นหา..."
                title="พิมพ์สูตร วิธีการใช้ยา เพื่อค้นหา..." rel="tooltip" autocomplete="off"
                value="<?=isset($drug) ? $drug->usage_name : ''?>">
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-3">
            <label for="txt_drug_name">ราคา</label>
            <div class="input-group" style="width: 150px">
                <input id="txt_drug_price" type="text" data-type="number" value="<?=isset($drug) ? $drug->price : 0?>">
                <span class="input-group-addon">บาท</span>
            </div>
        </div>
        <div class="col col-lg-2">
            <label for="txt_drug_name">จำนวน</label>
            <input id="txt_drug_qty" type="text" data-type="number" value="<?=isset($drug) ? $drug->qty : 0?>">
        </div>
    </div>

</form>
<br>

<a href="#" class="btn btn-success" id="btn_drug_do_save"><i class="icon-save"></i> บันทึกข้อมูล</a>