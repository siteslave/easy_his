<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#fp_tab1" data-toggle="tab"><i class="icon-file"></i> บันทึกข้อมูล</a></li>
        <li><a href="#fp_tab2" data-toggle="tab"><i class="icon-time"></i> ประวัติการรับบริการ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="fp_tab1">
            <blockquote>
                ข้อมูลการรับบริการในครั้งนี้
            </blockquote>
            <form class="form-horizontal">
                <input type="hidden" id="txt_fp_hn" value="<?=isset($hn) ? $hn : ''?>"/>
                <input type="hidden" id="txt_fp_vn" value="<?=isset($vn) ? $vn : ''?>"/>
                <div class="row">
                    <div class="col-lg-2">
                        <label for="txt_fp_date">วันที่รับบริการ</label>
                        <input type="text" data-type="date" id="txt_fp_date" placeholder="dd/mm/yyyy" title="ระบุวันที่รับบริการวัคซีน" rel="tooltip"
                               value="<?=isset($date_serv) ? $date_serv : ''?>" <?=isset($date_serv) ? 'disabled="disabled"' : ''?> />
                    </div>
                    <div class="col-lg-2">
                        <label for="txt_fp_hosp_code">รหัส</label>
                        <input type="text" id="txt_fp_hosp_code" value="<?=isset($hospcode) ? $hospcode : ''?>" disabled="disabled" placeholder="-*-" />
                    </div>
                    <div class="col-lg-8">
                        <label for="txt_fp_hosp_name">สถานพยาบาล</label>
                        <input type="text" id="txt_fp_hosp_name" value="<?=isset($hospname) ? $hospname : ''?>" <?=isset($hospname) ? 'disabled="disabled"' : ''?>
                               placeholder="พิมพ์ชื่อหรือรหัสสถาพยาบาล..." title="พิมพ์ชื่อหรือรหัสสถานพยาบาลเพื่อค้นหา" rel="tooltip"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="sl_fp_type">วิธีการคุมกำเนิด</label>
                        <select id="sl_fp_type">
                            <option value="">-----</option>
                            <?php
                            foreach($fp_types as $r) echo '<option value="'.$r->code.'">'.$r->name.'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="sl_fp_providers">ผู้ให้บริการ</label>
                        <select id="sl_fp_providers">
                            <option value="">-*-</option>
                            <?php
                            foreach($providers as $r)
                            {
                                if(isset($provider_id))
                                {
                                    if($provider_id == $r->id)
                                    {
                                        echo '<option value="'.$r->id.'" selected="selected">' . $r->name .'</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="'.$r->id.'">' . $r->name . '</option>';
                                    }
                                }
                                else
                                {
                                    echo '<option value="'.$r->id.'">' . $r->name . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label for=""><span style="color: white;">ดำเนินการ</span></label>
                        <a href="#" class="btn btn-success" id="btn_save_fp"><i class="icon-save"></i> บันทึกรายการ</a>
                    </div>
                </div>
            </form>
            <?php if(isset($vn)) { ?>
                <br>
                <legend>การให้บริการในวันนี้ (กรณีบันทึกการให้บริการ)</legend>
                <table class="table table-striped" id="tbl_fp_list">
                    <thead>
                    <tr>
                        <th>ประเภทการคุมกำเนิด</th>
                        <th>ผู้ให้บริการ</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            <?php } ?>

        </div>
        <div class="tab-pane" id="fp_tab2">
            <blockquote>
                ประวัติการรับบริการจากหน่วยงานอื่นๆ
            </blockquote>

            <table class="table table-hover" id="tbl_fp_list_all">
                <thead>
                <tr>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>คลินิก</th>
                    <th>สถานบริการ</th>
                    <th>ประเภทการคุมกำเนิด</th>
                    <th>ผู้ให้บริการ</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    </div>
</div>