<input type="hidden" id="txt_postnatal_vn" value="<?=isset($vn) ? $vn : ''?>" />
<input type="hidden" id="txt_postnatal_hn" value="<?=isset($hn) ? $hn : ''?>" />
<input type="hidden" id="txt_postnatal_id" value="<?=isset($id) ? $id : ''?>" />

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_postnatal1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
        <li><a href="#tab_postnatal2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_postnatal1">
            <form class="form-horizontal">
                <br>
                <legend>การให้บริการวันนี้</legend>
                <div class="row">
                    <div class="col-lg-2">
                        <label for="txt_anc_date">วันที่รับบริการ</label>
                        <input type="text" data-type="date" id="txt_postnatal_date" placeholder="dd/mm/yyyy" title="ระบุวันที่รับบริการวัคซีน" rel="tooltip"
                               value="<?=isset($date_serv) ? $date_serv : ''?>" <?=isset($date_serv) ? 'disabled="disabled"' : ''?> />
                    </div>
                    <div class="col-lg-2">
                        <label for="txt_postnatal_hospcode">รหัส</label>
                        <input type="text" id="txt_postnatal_hospcode" value="<?=isset($hospcode) ? $hospcode : ''?>" disabled="disabled" placeholder="-*-" />
                    </div>
                    <div class="col-lg-6">
                        <label for="txt_postnatal_hospname">สถานพยาบาล</label>
                        <input type="text" id="txt_postnatal_hospname" value="<?=isset($hospname) ? $hospname : ''?>" <?=isset($hospname) ? 'disabled="disabled"' : ''?>
                               placeholder="พิมพ์ชื่อหรือรหัสสถาพยาบาล..." title="พิมพ์ชื่อหรือรหัสสถานพยาบาลเพื่อค้นหา" rel="tooltip"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="sl_postnatal_gravida">ครรภ์ที่</label>
                        <select id="sl_postnatal_gravida" <?=!empty($gravida) ? 'disabled="disabled"' : ''?>>
                            <option value="">ระบุ..</option>
                            <?php
                            foreach($gravidas as $r)
                            {
                                if(isset($gravida))
                                {
                                    if($r['gravida'] == $gravida)
                                    {
                                        echo '<option value="'.$r['gravida'].'" selected="selected">'. $r['gravida'] . '</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="'.$r['gravida'].'">'. $r['gravida'] . '</option>';
                                    }
                                }
                                else
                                {
                                    echo '<option value="'.$r['gravida'].'">'. $r['gravida'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_postnatal_ppresult">ผลการตรวจ</label>
                        <select id="sl_postnatal_ppresult">
                            <option value="1" <?=isset($ppresult) ? $ppresult == '1' ? 'selected="selected"' : '' : ''?>>ปกติ</option>
                            <option value="2" <?=isset($ppresult) ? $ppresult == '2' ? 'selected="selected"' : '' : ''?>>ผิดปกติ</option>
                            <option value="9" <?=isset($ppresult) ? $ppresult == '9' ? 'selected="selected"' : '' : ''?>>ไม่ทราบ</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_postnatal_sugar">ระดับน้ำตาล</label>
                        <select id="sl_postnatal_sugar">
                            <option value="1" <?=isset($sugar) ? $sugar == '1' ? 'selected="selected"' : '' : ''?>>ปกติ</option>
                            <option value="2" <?=isset($sugar) ? $sugar == '2' ? 'selected="selected"' : '' : ''?>>ผิดปกติ</option>
                            <option value="9" <?=isset($sugar) ? $sugar == '9' ? 'selected="selected"' : '' : ''?>>ไม่ทราบ</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_postnatal_albumin">Albumin</label>
                        <select id="sl_postnatal_albumin">
                            <option value="1" <?=isset($albumin) ? $albumin == '1' ? 'selected="selected"' : '' : ''?>>ปกติ</option>
                            <option value="2" <?=isset($albumin) ? $albumin == '2' ? 'selected="selected"' : '' : ''?>>ผิดปกติ</option>
                            <option value="9" <?=isset($albumin) ? $albumin == '9' ? 'selected="selected"' : '' : ''?>>ไม่ทราบ</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="sl_postnatal_amniotic_fluid">น้ำคาวปลา</label>
                        <select id="sl_postnatal_amniotic_fluid">
                            <option value="1" <?=isset($fluid) ? $fluid == '1' ? 'selected="selected"' : '' : ''?>>ปกติ</option>
                            <option value="2" <?=isset($fluid) ? $fluid == '2' ? 'selected="selected"' : '' : ''?>>ผิดปกติ</option>
                            <option value="9" <?=isset($fluid) ? $fluid == '9' ? 'selected="selected"' : '' : ''?>>ไม่ทราบ</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_postnatal_uterus">ระดับมดลูก</label>
                        <select id="sl_postnatal_uterus">
                            <option value="1" <?=isset($uterus) ? $uterus == '1' ? 'selected="selected"' : '' : ''?>>ปกติ</option>
                            <option value="2" <?=isset($uterus) ? $uterus == '2' ? 'selected="selected"' : '' : ''?>>ผิดปกติ</option>
                            <option value="9" <?=isset($uterus) ? $uterus == '9' ? 'selected="selected"' : '' : ''?>>ไม่ทราบ</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_postnatal_perineal">ฝีเย็บ</label>
                        <select id="sl_postnatal_perineal">
                            <option value="1" <?=isset($perineal) ? $perineal == '1' ? 'selected="selected"' : '' : ''?>>ปกติ</option>
                            <option value="2" <?=isset($perineal) ? $perineal == '2' ? 'selected="selected"' : '' : ''?>>ผิดปกติ</option>
                            <option value="9" <?=isset($perineal) ? $perineal == '9' ? 'selected="selected"' : '' : ''?>>ไม่ทราบ</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_postnatal_tits">หัวนม</label>
                        <select id="sl_postnatal_tits">
                            <option value="1" <?=isset($tits) ? $tits == '1' ? 'selected="selected"' : '' : ''?>>ปกติ</option>
                            <option value="2" <?=isset($tits) ? $tits == '2' ? 'selected="selected"' : '' : ''?>>ผิดปกติ</option>
                            <option value="9" <?=isset($tits) ? $tits == '9' ? 'selected="selected"' : '' : ''?>>ไม่ทราบ</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="sl_postnatal_providers">ผู้ให้บริการ</label>
                        <select id="sl_postnatal_providers">
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

                <button class="btn btn-success" type="button" id="btn_postnatal_save">
                    <i class="icon-save"></i> บันทึกข้อมูล
                </button>
            </form>
        </div>
        <div class="tab-pane" id="tab_postnatal2">
            <br>
            <legend>ประวัติการรับบริการ</legend>
            <table class="table table-striped" id="tbl_postnatal_history">
                <thead>
                <tr>
                    <th>วันที่</th>
                    <th>หน่วยบริการ</th>
                    <th>ครรภ์ที่</th>
                    <th>ผลตรวจ</th>
                    <th>ผู้ให้บริการ</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="6">...</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>