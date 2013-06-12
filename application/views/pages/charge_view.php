<form class="form-horizontal">
    <input type="hidden" id="charge_isupdate" value="<?=isset($id) ? '1' : '0'?>">
    <input type="hidden" id="charge_id" value="<?=isset($id) ? $id : ''?>">
    <input type="hidden" id="charge_vn" value="<?=isset($vn) ? $vn : ''?>">
    <input type="hidden" id="charge_hn" value="<?=isset($hn) ? $hn : ''?>">
    <div class="row">
        <div class="col-lg-3">
            <label for="txt_charge_code">รหัส</label>
            <input type="text" disabled="disabled" id="txt_charge_code" placeholder="-*-"
                value="<?=isset($items->charge_code) ? $items->charge_code : ''?>">
        </div>
        <div class="col-lg-9">
            <label for="txt_charge_name">รายการ/คำค้น</label>
            <input id="txt_charge_name" type="text" placeholder="พิมพ์ชื่อรายการเพื่อค้นหา"
                title="พิมพ์ชื่อรายการเพื่อค้นหา" rel="tooltip" placeholder="พิมพ์ชื่อเพื่อค้นหา" autocomplete="off"
                value="<?=isset($items->charge_name) ? $items->charge_name : ''?>" <?=isset($id) ? 'disabled="disabled"' : ''?>>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label for="txt_charge_price">ราคา</label>
            <div class="input-group">
                <input id="txt_charge_price" type="text" data-type="number" value="<?=isset($items->price) ? $items->price : '0'?>">
                <span class="input-group-addon">บาท</span>
            </div>
        </div>
        <div class="col-lg-2">
            <label for="txt_charge_qty">จำนวน</label>
            <input id="txt_charge_qty" type="text" data-type="number" value="<?=isset($items->qty) ? $items->qty : '1'?>">
        </div>

    </div>
</form>
<br>
<a href="#" class="btn btn-success" id="btn_charge_do_save"><i class="icon-save"></i> บันทึก</a>