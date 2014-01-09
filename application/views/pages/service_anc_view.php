<input type="hidden" id="txt_svc_anc_hn" value="<?=isset($hn) ? $hn : ''?>"/>
<input type="hidden" id="txt_svc_anc_vn" value="<?=isset($vn) ? $vn : ''?>"/>
<input type="hidden" id="txt_svc_anc_id" value="<?=isset($id) ? $id : ''?>"/>
<input type="hidden" id="txt_svc_anc_hospcode1" value="<?=isset($hospcode) ? $hospcode : ''?>" />
<input type="hidden" id="txt_svc_anc_hospname1" value="<?=isset($hospname) ? $hospname : ''?>" />
<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_anc1" data-toggle="tab"><i class="fa fa-plus-circle"></i> เพิ่มข้อมูล</a></li>
        <li><a href="#tab_anc2" data-toggle="tab"><i class="fa fa-refresh"></i> ประวัติการรับบริการ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_anc1">
            <br>
            <form class="form-horizontal" action="#">
                <div class="row">
                    <div class="col-lg-2">
                        <label for="txt_anc_date">วันที่รับบริการ</label>
                        <input type="text" class="form-control" data-type="date" id="txt_anc_date" placeholder="dd/mm/yyyy" title="ระบุวันที่รับบริการวัคซีน" rel="tooltip"
                               value="<?=isset($date_serv) ? $date_serv : ''?>" <?=!empty($date_serv) ? 'disabled="disabled"' : ''?> />
                    </div>
                    <div class="col-lg-6">
                        <label for="txt_anc_hosp_name">สถานพยาบาล</label>
                        <input type="hidden" id="txt_anc_hosp_name" class="form-control" style="width: 350px;" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <label for="sl_anc_gravida">ครรภ์ที่</label>
                        <select id="sl_anc_gravida" class="form-control" <?=!empty($gravida) ? 'disabled="disabled"' : ''?>>
                            <option value="">ระบุ..</option>
                            <?php
                            foreach($gravidas as $r)
                            {
                                if(!empty($gravida))
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
                    <div class="col-lg-4">
                        <label for="sl_anc_no">ANC ช่วงที่</label>
                        <select id="sl_anc_no" class="form-control">
                            <option value="">-*-</option>
                            <option value="1" <?=isset($anc_no) ? $anc_no == '1' ? 'selected="selected"' : '' : ''?>>ช่วงที่ 1 (อายุครรภ์ <= 12 สัปดาห์)</option>
                            <option value="2" <?=isset($anc_no) ? $anc_no == '2' ? 'selected="selected"' : '' : ''?>>ช่วงที่ 2 (อายุครรภ์ 18 สัปดาห์)</option>
                            <option value="3" <?=isset($anc_no) ? $anc_no == '3' ? 'selected="selected"' : '' : ''?>>ช่วงที่ 3 (อายุครรภ์ 26 สัปดาห์)</option>
                            <option value="4" <?=isset($anc_no) ? $anc_no == '4' ? 'selected="selected"' : '' : ''?>>ช่วงที่ 4 (อายุครรภ์ 32 สัปดาห์)</option>
                            <option value="5" <?=isset($anc_no) ? $anc_no == '5' ? 'selected="selected"' : '' : ''?>>ช่วงที่ 5 (อายุครรภ์ 38 สัปดาห์)</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <label class="control-label" for="txt_anc_ga">อายุครรภ์ (สัปดาห์)</label>
                        <input type="text" class="form-control" data-type="number" id="txt_anc_ga" value="<?=isset($ga) ? $ga : ''?>">
                    </div>

                    <div class="col-lg-4">
                        <label class="control-label" for="sl_anc_result">ผลตรวจ</label>
                        <select id="sl_anc_result" class="form-control">
                            <option value="">-*-</option>
                            <option value="1" <?=isset($anc_result) ? $anc_result == '1' ? 'selected="selected"' : '' : ''?>>ปกติ</option>
                            <option value="2" <?=isset($anc_result) ? $anc_result == '2' ? 'selected="selected"' : '' : ''?>>ผิดปกติ</option>
                            <option value="9" <?=isset($anc_result) ? $anc_result == '9' ? 'selected="selected"' : '' : ''?>>ไม่ทราบ</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="sl_anc_providers">ผู้ให้บริการ</label>
                        <select id="sl_anc_providers" class="form-control">
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

                <button class="btn btn-success" type="button" id="btn_anc_save">
                    <i class="fa fa-save"></i> บันทึกข้อมูล
                </button>
            </form>
        </div>
        <div class="tab-pane" id="tab_anc2">
            <br>
            <form action="#" class="form-inline">
                <select id="sl_anc_gravida2" style="width: 150px;" class="form-control">
                    <option value="">ระบุครรภ์ที่..</option>
                    <?php
                    foreach($gravidas as $r)
                    {
                        echo '<option value="'.$r['gravida'].'">'. $r['gravida'] . '</option>';
                    }
                    ?>
                </select>
            </form>
            <br>
            <table class="table table-striped" id="tbl_anc_history">
                <thead>
                <tr>
                    <th>วันที่</th>
                    <th>หน่วยบริการ</th>
                    <th>ครรภ์ที่</th>
                    <th>ANC ช่วงที่</th>
                    <th>อายุครรภ์ (สัปดาห์)</th>
                    <th>ผลตรวจ</th>
                    <th>ผู้ให้บริการ</th>
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
