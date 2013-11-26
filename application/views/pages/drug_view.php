<form action="#">
    <input type="hidden" id="drug_isupdate" value="<?=$update?>">
    <input type="hidden" id="service_drug_visit_id" value="<?=isset($drug) ? $drug->id : ''?>">

    <input type="hidden" id="service_drug_id" value="<?=isset($drug) ? $drug->drug_id : ''?>">
    <input type="hidden" id="service_drug_name" value="<?=isset($drug) ? $drug->drug_name : ''?>">
    <input type="hidden" id="service_drug_usage_id" value="<?=isset($drug) ? $drug->usage_id : ''?>">
    <input type="hidden" id="service_drug_usage_name" value="<?=isset($drug) ? $drug->usage_name : ''?>">
    <div class="row">
        <div class="col col-lg-7">
            <label for="txt_drug_name">ชื่อยา/เวชภัณฑ์</label>
            <input id="txt_drug_name" type="hidden" style="width: 480px;">
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-7">
            <label for="txt_drug_usage_name">วิธีการใช้ยา</label>
            <input id="txt_drug_usage_name" type="text" style="width: 480px;" >
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-3">
            <label for="txt_drug_name">ราคา</label>
            <div class="input-group" style="width: 150px">
                <input id="txt_drug_price" class="form-control" type="text" data-type="number" value="<?=isset($drug) ? $drug->price : 0?>">
                <span class="input-group-addon">บาท</span>
            </div>
        </div>
        <div class="col col-lg-2">
            <label for="txt_drug_name">จำนวน</label>
            <input id="txt_drug_qty" class="form-control" type="text" data-type="number" value="<?=isset($drug) ? $drug->qty : 0?>">
        </div>
    </div>

</form>
<br>

<a href="#" class="btn btn-success" id="btn_drug_do_save"><i class="fa fa-save"></i> บันทึกข้อมูล</a>