<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_nutri1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
        <li><a href="#tab_nutri2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_nutri1">
            <br>
            <form class="form-horizontal">
                <input type="hidden" id="txt_nutri_id" value="<?=isset($id) ? $id : ''?>"/>
                <input type="hidden" id="txt_nutri_hn" value="<?=isset($hn) ? $hn : ''?>"/>
                <input type="hidden" id="txt_nutri_vn" value="<?=isset($vn) ? $vn : ''?>"/>
                <div class="row">
                    <div class="col-lg-2">
                        <label for="txt_fp_date">วันที่รับบริการ</label>
                        <input type="text" id="txt_fp_date" placeholder="dd/mm/yyyy" title="ระบุวันที่รับบริการวัคซีน" rel="tooltip" data-type="date"
                               value="<?=isset($date_serv) ? $date_serv : ''?>" <?=isset($date_serv) ? 'disabled="disabled"' : ''?> />
                    </div>
                    <div class="col-lg-2">
                        <label for="txt_nutri_hospcode">รหัส</label>
                        <input type="text" id="txt_nutri_hospcode" value="<?=isset($hospcode) ? $hospcode : ''?>" disabled="disabled" placeholder="-*-" />
                    </div>
                    <div class="col-lg-8">
                        <label for="txt_nutri_hospname">สถานพยาบาล</label>
                        <input type="text" id="txt_nutri_hospname" value="<?=isset($hospname) ? $hospname : ''?>" <?=isset($hospname) ? 'disabled="disabled"' : ''?>
                               placeholder="พิมพ์ชื่อหรือรหัสสถาพยาบาล..." title="พิมพ์ชื่อหรือรหัสสถานพยาบาลเพื่อค้นหา" rel="tooltip"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <label for="txt_nutri_weight">น้ำหนัก (Kg.)</label>
                        <input id="txt_nutri_weight" type="text" data-type="number" value="<?=isset($weight) ? $weight : '' ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="txt_nutri_height">ส่วนสูง (cm.)</label>
                        <input id="txt_nutri_height" type="text" data-type="number" value="<?=isset($height) ? $height : '' ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="txt_nutri_headcircum">เส้นรอบศีรษะ (cm.)</label>
                        <input id="txt_nutri_headcircum" type="text" data-type="number" value="<?=isset($headcircum) ? $headcircum : '' ?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="sl_nutri_childdevelop">ระดับพัฒนาการ</label>
                        <select id="sl_nutri_childdevelop">
                            <option value="">-*-</option>
                            <option value="1" <?=isset($childdevelop) ? $childdevelop == '1' ? 'selected="selected"' : '' : ''?>>ปกติ</option>
                            <option value="2" <?=isset($childdevelop) ? $childdevelop == '2' ? 'selected="selected"' : '' : ''?>>สงสัยช้ากว่าปกติ</option>
                            <option value="3" <?=isset($childdevelop) ? $childdevelop == '3' ? 'selected="selected"' : '' : ''?>>ช้ากว่าปกติ</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="sl_nutri_food">อาหารที่รับประทาน</label>
                        <select id="sl_nutri_food">
                            <option value="">-*-</option>
                            <option value="1" <?=isset($food) ? $food == '1' ? 'selected="selected"' : '' : ''?>>นมแม่อย่างเดียว</option>
                            <option value="2" <?=isset($food) ? $food == '2' ? 'selected="selected"' : '' : ''?>>นมแม่และน้ำ</option>
                            <option value="3" <?=isset($food) ? $food == '3' ? 'selected="selected"' : '' : ''?>>นมแม่และนมผสม</option>
                            <option value="4" <?=isset($food) ? $food == '4' ? 'selected="selected"' : '' : ''?>>นมผสมอย่างเดียว</option>
                        </select>
                    </div>

                    <div class="col-lg-4">
                        <label for="sl_nutri_bottle">การใช้ขวดนม</label>
                        <select id="sl_nutri_bottle">
                            <option value="">-*-</option>
                            <option value="1" <?=isset($bottle) ? $bottle == '1' ? 'selected="selected"' : '' : ''?>>ใช้ขวดนม</option>
                            <option value="2" <?=isset($bottle) ? $bottle == '2' ? 'selected="selected"' : '' : ''?>>ไม่ใช้ขวดนม</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="sl_nutri_providers">ผู้ให้บริการ</label>
                        <select id="sl_nutri_providers">
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
            </form>
            <br>
            <button class="btn btn-success" type="button" id="btn_nutri_save">
                <i class="icon-save"></i> บันทึกโภชนาการ
            </button>
        </div>
        <div class="tab-pane" id="tab_nutri2">
            <table class="table table-striped" id="tbl_nutri_history">
                <thead>
                <tr>
                    <th>วันที่</th>
                    <th>หน่วยบริการ</th>
                    <th>น้ำหนัก (kg)</th>
                    <th>ส่วนสูง (cm)</th>
                    <th>อาหาร</th>
                    <th>ระดับพัฒนาการ</th>
                    <th>ผู้ให้บริการ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="7">...</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>