<form class="form-horizontal">
    <input type="hidden" id="charge_isupdate" value="<?=isset($id) ? '1' : '0'?>">
    <input type="hidden" id="charge_id" value="<?=isset($id) ? $id : ''?>">
    <input type="hidden" id="charge_vn" value="<?=isset($vn) ? $vn : ''?>">
    <input type="hidden" id="charge_hn" value="<?=isset($hn) ? $hn : ''?>">

    <input type="hidden" id="charge_item_id" value="<?=isset($items->charge_id) ? $items->charge_id : ''?>">
    <input type="hidden" id="charge_item_name" value="<?=isset($items->charge_name) ? $items->charge_name : ''?>">
    <div class="row">
        <div class="col-lg-12">
            <label for="txt_charge_name">รายการ/คำค้น</label>
            <input id="txt_charge_name" type="hidden" style="width: 550px;">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label for="txt_charge_price">ราคา</label>
            <div class="input-group">
                <input id="txt_charge_price" class="form-control" type="text" data-type="number" value="<?=isset($items->price) ? $items->price : '0'?>">
                <span class="input-group-addon">บาท</span>
            </div>
        </div>
        <div class="col-lg-2">
            <label for="txt_charge_qty">จำนวน</label>
            <input id="txt_charge_qty" class="form-control" type="text" data-type="number" value="<?=isset($items->qty) ? $items->qty : '1'?>">
        </div>

    </div>
</form>
<br>
<a href="#" class="btn btn-success" id="btn_charge_do_save"><i class="fa fa-save"></i> บันทึก</a>