<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_babies_care1" data-toggle="tab"><i class="icon-plus"></i> เพิ่มข้อมูล</a></li>
        <li><a href="#tab_babies_care2" data-toggle="tab"><i class="icon-refresh"></i> ประวัติการรับบริการ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_babies_care1">
            <br>
            <form class="form-horizontal">
                <legend>การให้บริการวันนี้</legend>

                <input type="hidden" id="txt_babies_care_id" value="<?=isset($id) ? $id : ''?>"/>
                <input type="hidden" id="txt_babies_care_hn" value="<?=isset($hn) ? $hn : ''?>"/>
                <input type="hidden" id="txt_babies_care_vn" value="<?=isset($vn) ? $vn : ''?>"/>
                <div class="row">
                    <div class="col-lg-2">
                        <label for="txt_babies_care_date">วันที่รับบริการ</label>
                        <input type="text" id="txt_babies_care_date" placeholder="dd/mm/yyyy" title="ระบุวันที่รับบริการวัคซีน" rel="tooltip" data-type="date"
                               value="<?=isset($date_serv) ? $date_serv : ''?>" <?=isset($date_serv) ? 'disabled="disabled"' : ''?> />
                    </div>
                    <div class="col-lg-2">
                        <label for="txt_babies_care_hospcode">รหัส</label>
                        <input type="text" id="txt_babies_care_hospcode" value="<?=isset($hospcode) ? $hospcode : ''?>" disabled="disabled" placeholder="-*-" />
                    </div>
                    <div class="col-lg-8">
                        <label for="txt_babies_care_hospname">สถานพยาบาล</label>
                        <input type="text" id="txt_babies_care_hospname" value="<?=isset($hospname) ? $hospname : ''?>" <?=isset($hospname) ? 'disabled="disabled"' : ''?>
                               placeholder="พิมพ์ชื่อหรือรหัสสถาพยาบาล..." title="พิมพ์ชื่อหรือรหัสสถานพยาบาลเพื่อค้นหา" rel="tooltip"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="control-label" for="sl_babies_care_result">ผลตรวจ</label>
                        <select id="sl_babies_care_result">
                            <option value="">-*-</option>
                            <option value="1" <?=isset($result) ? $result == '1' ? 'selected="selected"' : '' : '' ?>>ปกติ</option>
                            <option value="2" <?=isset($result) ? $result == '2' ? 'selected="selected"' : '' : '' ?>>ผิดปกติ</option>
                            <option value="9" <?=isset($result) ? $result == '9' ? 'selected="selected"' : '' : '' ?>>ไม่ทราบ</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label class="control-label" for="sl_babies_care_food">อาหาร</label>
                        <select id="sl_babies_care_food">
                            <option value="">-*-</option>
                            <option value="1" <?=isset($food) ? $food == '1' ? 'selected="selected"' : '' : '' ?>>นมแม่อย่างเดียว</option>
                            <option value="2" <?=isset($food) ? $food == '2' ? 'selected="selected"' : '' : '' ?>>นมแม่นและน้ำ</option>
                            <option value="3" <?=isset($food) ? $food == '3' ? 'selected="selected"' : '' : '' ?>>นมแม่และนมผสม</option>
                            <option value="4" <?=isset($food) ? $food == '4' ? 'selected="selected"' : '' : '' ?>>นมผสมอย่างเดียว</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <label for="sl_babies_care_providers">ผู้ให้บริการ</label>
                        <select id="sl_babies_care_providers">
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
            <button class="btn btn-success" type="button" id="btn_babies_care_save">
                <i class="icon-save"></i> บันทึกข้อมูล
            </button>

        </div>
        <div class="tab-pane" id="tab_babies_care2">
            <br>
            <legend>ประวัติการรับบริการ</legend>
            <table class="table table-striped" id="tbl_babies_care_history">
                <thead>
                <tr>
                    <th>วันที่</th>
                    <th>หน่วยบริการ</th>
                    <th>ผลตรวจ</th>
                    <th>อาหาร</th>
                    <th>ผู้ให้บริการ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="4">อยู่ในระหว่างปรับปรุงระบบ</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>