<input type="hidden" id="txt_ssp_hn" value="<?=isset($hn) ? $hn : ''?>" />
<input type="hidden" id="txt_ssp_vn" value="<?=isset($vn) ? $vn : ''?>" />
<input type="hidden" id="txt_ssp_id" value="<?=isset($id) ? $id : ''?>" />

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_special_pp1" data-toggle="tab"><i class="fa fa-plus-circle"></i> เพิ่มข้อมูล</a></li>
        <li><a href="#tab_special_pp2" data-toggle="tab"><i class="fa fa-refresh"></i> ประวัติการรับบริการ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_special_pp1">
            <br>
            <form class="form-horizontal">
                <legend>การให้บริการวันนี้</legend>
                <div class="row">
                    <div class="col-lg-2">
                        <label class="control-label" for="txt_spp_date">วันที่รับบริการ</label>
                        <input type="text" class="form-control" id="txt_spp_date" placeholder="dd/mm/yyyy" title="ระบุวันที่รับบริการวัคซีน" rel="tooltip" data-type="date"
                               value="<?=isset($date_serv) ? $date_serv : ''?>" <?=isset($date_serv) ? 'disabled="disabled"' : ''?> />
                    </div>
                    <div class="col-lg-2">
                        <label class="control-label"  for="txt_spp_hospcode">รหัส</label>
                        <input type="text" class="form-control" id="txt_spp_hospcode" value="<?=isset($hospcode) ? $hospcode : ''?>" disabled="disabled" placeholder="-*-" />
                    </div>
                    <div class="col-lg-8">
                        <label class="control-label"  for="txt_spp_hospname">สถานพยาบาล</label>
                        <input type="text" class="form-control" id="txt_spp_hospname" value="<?=isset($hospname) ? $hospname : ''?>" <?=isset($hospname) ? 'disabled="disabled"' : ''?>
                               placeholder="พิมพ์ชื่อหรือรหัสสถาพยาบาล..." title="พิมพ์ชื่อหรือรหัสสถานพยาบาลเพื่อค้นหา" rel="tooltip"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label class="control-label" for="sl_spp_servplace">สถานที่ให้บริการ</label>
                        <select id="sl_spp_servplace" class="form-control">
                            <option value="">-*-</option>
                            <option value="1" <?=isset($servplace) ? $servplace == '1' ? 'selected="selected"' : '' : ''?>>ในสถานบริการ</option>
                            <option value="2" <?=isset($servplace) ? $servplace == '2' ? 'selected="selected"' : '' : ''?>>นอกสถานบริการ</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label class="control-label" for="sl_spp_ppspecial">ประเภทบริการ</label>
                        <select id="sl_spp_ppspecial" class="form-control">
                            <option value="">-*-</option>
                            <?php
                            $specials = get_pp_special_list();
                            foreach($specials as $r)
                            {
                                if(isset($ppspecial))
                                {
                                    if($ppspecial == $r->id)
                                    {
                                        echo '<option value="'.$r->id.'" selected="selected">' . $r->name . '</option>';
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
                    <div class="col-lg-4">
                        <label class="control-label" for="sl_spp_providers">ผู้ให้บริการ</label>
                        <select id="sl_spp_providers" class="form-control">
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
            <button class="btn btn-success" type="button" id="btn_special_pp_save">
                <i class="fa fa-save"></i> บันทึกข้อมูล
            </button>

            <?php
            if(isset($visit)) {
            ?>
                <br>
                <br>
            <legend>การให้บริการในวันนี้</legend>
            <table class="table table-striped" id="tbl_visit_ssp">
                <thead>
                <tr>
                    <th>#</th>
                    <th>หน่วยบริการ</th>
                    <th>กิจกรรม</th>
                    <th>สถานที่</th>
                    <th>ผู้ให้บริการ</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            <?php } ?>

        </div>
        <div class="tab-pane" id="tab_special_pp2">
            <br>
            <legend>ประวัติการรับบริการ</legend>
            <table class="table table-striped" id="tbl_special_pp_history">
                <thead>
                <tr>
                    <th>วันที่</th>
                    <th>หน่วยบริการ</th>
                    <th>กิจกรรม</th>
                    <th>สถานที่</th>
                    <th>ผู้ให้บริการ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="5">อยู่ในระหว่างปรับปรุงระบบ</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>