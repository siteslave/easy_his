<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_epi1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มการให้วัคซีน</a></li>
        <li class=""><a href="#tab_epi2" data-toggle="tab"><i class="icon-time"></i> ประวัติการรับวัคซีน</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_epi1">
            <br>
            <form class="form-horizontal">
                <input type="hidden" id="txt_vaccs_id" value="<?=isset($id) ? $id : ''?>" />
                <input type="hidden" id="txt_vaccs_hn" value="<?=isset($hn) ? $hn : ''?>" />
                <input type="hidden" id="txt_vaccs_vn" value="<?=isset($vn) ? $vn : ''?>" />
                <div class="row">
                    <div class="col-lg-2">
                        <label for="">วันที่รับบริการ</label>
                        <input type="text" id="txt_vaccs_date" data-type="date" placeholder="dd/mm/yyyy" title="ระบุวันที่รับบริการวัคซีน" rel="tooltip"
                            value="<?=isset($date_serv) ? $date_serv : ''?>" <?=isset($date_serv) ? 'disabled="disabled"' : ''?> />
                    </div>
                    <div class="col-lg-2">
                        <label for="">รหัส</label>
                        <input type="text" id="txt_vaccs_hosp_code" value="<?=isset($hospcode) ? $hospcode : ''?>" disabled="disabled" placeholder="-*-" />
                    </div>
                    <div class="col-lg-8">
                        <label for="">สถานพยาบาล</label>
                        <input type="text" id="txt_vaccs_hosp_name" value="<?=isset($hospname) ? $hospname : ''?>" <?=isset($hospname) ? 'disabled="disabled"' : ''?>
                               placeholder="พิมพ์ชื่อหรือรหัสสถาพยาบาล..." title="พิมพ์ชื่อหรือรหัสสถานพยาบาลเพื่อค้นหา" rel="tooltip"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="sl_vaccs_vaccine_id">วัคซีน</label>
                        <select id="sl_vaccs_vaccine_id" <?=isset($id) ? 'disabled="disabled"' : ''?>>
                            <option value="">-*-</option>
                            <?php
                            foreach($vaccines as $r)
                            {
                                if(isset($id))
                                {
                                    if($vaccine_id == $r->id)
                                    {
                                        echo '<option value="'.$r->id.'" selected="selected">' . $r->th_name . '['.$r->eng_name.']</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="'.$r->id.'">' . $r->th_name . '['.$r->eng_name.']</option>';
                                    }
                                }
                                else
                                {
                                    echo '<option value="'.$r->id.'">' . $r->th_name . '['.$r->eng_name.']</option>';
                                }

                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label for="">Lot.</label>
                        <input type="text" id="txt_vaccs_lot" placeholder="Lot number." value="<?=isset($lot) ? $lot : ''?>" />
                    </div>
                    <div class="col-lg-2">
                        <label for="">หมดอายุ</label>
                        <input type="text" id="txt_vaccs_expire_date" title="ระบุวันที่หมดอายุ" value="<?=isset($expire) ? $expire : ''?>"
                               data-type="date" placeholder="dd/mm/yyyy" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="">ผู้ให้บริการ</label>
                        <select id="sl_vaccs_providers">
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
                </div>
                <br>
                <a href="#" class="btn btn-success" id="btn_vaccs_save">
                    <i class="icon-save"></i> บันทึกรายการวัคซีน
                </a>
            </form>

        </div>
        <div class="tab-pane" id="tab_epi2">
            <table class="table table-striped" id="tbl_vaccs_history">
                <thead>
                <tr>
                    <th>วันที่</th>
                    <th>วัคซีน</th>
                    <th>lot</th>
                    <th>หมดอายุ</th>
                    <th>สถานพยาบาล</th>
                    <th>ผู้ให้บริการ</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>