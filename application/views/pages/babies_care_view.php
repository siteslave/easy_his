<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_babies_care1" data-toggle="tab"><i class="fa fa-plus-circle"></i> เพิ่มข้อมูล</a></li>
        <li><a href="#tab_babies_care2" data-toggle="tab"><i class="fa fa-refresh"></i> ประวัติการรับบริการ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_babies_care1">
            <br>
            <form class="form-horizontal">
                <legend>การให้บริการวันนี้</legend>

                <input type="hidden" id="txt_babies_care_id" value="<?=isset($id) ? $id : ''?>"/>
                <input type="hidden" id="txt_babies_care_hn" value="<?=isset($hn) ? $hn : ''?>"/>
                <input type="hidden" id="txt_babies_care_vn" value="<?=isset($vn) ? $vn : ''?>"/>

                <input type="hidden" id="txt_babies_care_hospcode1" value="<?=isset($hospcode) ? $hospcode : ''?>" />
                <input type="hidden" id="txt_babies_care_hospname1" value="<?=isset($hospname) ? $hospname : ''?>" />

                <input type="hidden" id="txt_babies_care_owner_code" value="<?=isset($owner_code) ? $owner_code : ''?>"/>
                <input type="hidden" id="txt_babies_care_owner_name" value="<?=isset($owner_name) ? $owner_name : ''?>"/>
                <div class="row">
                    <div class="col-lg-2">
                        <label for="txt_babies_care_date">วันที่รับบริการ</label>
                        <input type="text" class="form-control" id="txt_babies_care_date" placeholder="dd/mm/yyyy" title="ระบุวันที่รับบริการวัคซีน" rel="tooltip" data-type="date"
                               value="<?=isset($date_serv) ? $date_serv : ''?>" <?=isset($date_serv) ? 'disabled="disabled"' : ''?> />
                    </div>
                    <div class="col-lg-6">
                        <label for="txt_babies_care_hospname">สถานพยาบาล</label>
                        <input type="hidden" class="form-control" id="txt_babies_care_hospname" style="width: 380px;" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="control-label" for="sl_babies_care_result">ผลตรวจ</label>
                        <select id="sl_babies_care_result" class="form-control">
                            <option value="">-*-</option>
                            <option value="1" <?=isset($result) ? $result == '1' ? 'selected="selected"' : '' : '' ?>>ปกติ</option>
                            <option value="2" <?=isset($result) ? $result == '2' ? 'selected="selected"' : '' : '' ?>>ผิดปกติ</option>
                            <option value="9" <?=isset($result) ? $result == '9' ? 'selected="selected"' : '' : '' ?>>ไม่ทราบ</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label class="control-label" for="sl_babies_care_food">อาหาร</label>
                        <select id="sl_babies_care_food" class="form-control">
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
                        <select id="sl_babies_care_providers" class="form-control">
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
                <i class="fa fa-save"></i> บันทึกข้อมูล
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
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="6">อยู่ในระหว่างปรับปรุงระบบ</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>