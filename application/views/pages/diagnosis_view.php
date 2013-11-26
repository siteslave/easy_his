<form class="form-horizontal" action="#">
    <div class="row">
        <div class="col col-lg-10">
            <label for="txt_diag_query">คำค้นหา</label>
            <input type="text" id="txt_diag_query" placeholder="พิมพ์รหัส หรือ ชื่อโรค"
                title="พิมพ์ชื่อ หรือรหัสการวินิจฉัยเพื่อค้นหา" rel="tooltip" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-4">
            <label for="sl_diag_type">ประเภทการวินิจฉัย</label>
            <select id="sl_diag_type" style="width: 300px;" class="form-control">
                <option value="">--</option>
                <?php foreach($diag_types as $t) echo '<option value="'.$t->code.'">['.$t->code.'] '.$t->name.'</option>'; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-4">
            <label for="sl_diag_clinic">คลินิก</label>
            <select id="sl_diag_clinic" style="width: 300px;" class="form-control">
                <option value="">--</option>
                <?php
                foreach($clinics as $t) {
                    echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
</form>
<br>
<a href="#" class="btn btn-success" id="btn_diag_do_save"><i class="fa fa-save"></i> เพิ่มรายการ</a>