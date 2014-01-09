<ul class="nav nav-tabs">
    <li class="active">
        <a href="#procedure_new" data-toggle="tab">
            <i class="fa fa-plus-square"></i> บันทึกรายการ
        </a></li>
    <?php if(!isset($proced)) { ?>
    <li>
        <a href="#procedure_extra" data-toggle="tab">
            <i class="fa fa-medkit"></i> รายการใช้บ่อย
        </a>
    </li>
    <?php } ?>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="procedure_new">
        <br/>
        <form class="form-horizontal">

            <input type="hidden" id="txt_proced_vn" value="<?=$vn?>">
            <input type="hidden" id="txt_proced_isupdate" value="<?=$update?>">
            <input type="hidden" id="txt_proced_code" value="<?=isset($proced) ? $proced->code : ''?>">
            <input type="hidden" id="txt_proced_name" value="<?=isset($proced) ? $proced->name : ''?>">
            <div class="row">
                <div class="col col-lg-12">
                    <label class="control-label" for="txt_proced_query">รายการหัตถการ</label>
                    <input type="hidden" id="txt_proced_query" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col col-lg-3">
                    <label for="txt_proced_price">ราคา</label>
                    <div class="input-group" style="width: 150px;">
                        <input data-type="number" id="txt_proced_price" class="form-control"
                               rel="tooltip" title="ระบุเวลาราคาในการทำหัตถการ" type="text" placeholder="0.00"
                               value="<?=isset($proced) ? $proced->price : ''?>">
                        <span class="input-group-addon">บาท</span>
                    </div>
                </div>
                <div class="col col-lg-2">
                    <label for="txt_proced_start_time">เวลาเริ่ม</label>
                    <input type="text" id="txt_proced_start_time" class="form-control"
                           rel="tooltip" title="ระบุเวลาเริ่มทำหัตถการ" data-type="time" placeholder="12:00"
                           value="<?=isset($proced) ? $proced->start_time : ''?>">
                </div>
                <div class="col col-lg-2">
                    <label for="txt_proced_end_time">เวลาสิ้นสุด</label>
                    <input type="text" id="txt_proced_end_time" class="form-control"
                           rel="tooltip" title="ระบุเวลาสิ้นสุดการทำหัตถการ"  data-type="time" placeholder="12:00"
                           value="<?=isset($proced) ? $proced->end_time : ''?>">
                </div>
            </div>

            <div class="row">
                <div class="col col-lg-5">
                    <label for="sl_proced_clinic">คลินิกที่ทำหัตถการ</label>
                    <select id="sl_proced_clinic" class="form-control">
                        <option value="">--</option>
                        <?php
                        foreach($clinics as $t) {
                            if(isset($proced))
                            {
                                if($proced->clinic_id == $t->id)
                                {
                                    echo '<option value="'.$t->id.'" selected="selected">'.$t->name.'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                                }
                            }
                            else
                            {
                                echo '<option value="'.$t->id.'">'.$t->name.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col col-lg-5">
                    <label for="sl_proced_provider">ผู้ทำหัตถการ</label>
                    <select id="sl_proced_provider" class="form-control">
                        <option value="">--</option>
                        <?php
                        foreach($providers as $prov) {
                            if(isset($proced))
                            {
                                if($proced->provider_id == $prov->id)
                                {
                                    echo '<option value="'.$prov->id.'" selected="selected">'.$prov->name.'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$prov->id.'">'.$prov->name.'</option>';
                                }
                            }
                            else
                            {
                                echo '<option value="'.$prov->id.'">'.$prov->name.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <?php
            if(!empty($vn))
            {
                echo '<a href="#" class="btn btn-success" id="btn_proced_do_save"><i class="fa fa-save"></i> บันทึกข้อมูล</a>';
            }
            else
            {
                echo '<a href="#" class="btn btn-success" disabled="disabled" rel="tooltip" title="ไม่พบเลขที่รับบริการ (VN)"><i class="fa fa-save"></i> บันทึกข้อมูล</a>';
            }

            if(!$update)
            {
                echo ' <a href="javascript:void(0);" id="btn_proced_refresh" class="btn btn-default"><i class="fa fa-refresh"></i> ล้างข้อมูล</a>';
            }
            ?>
        </form>
    </div>
    <?php if(!isset($proced)) { ?>
    <div class="tab-pane" id="procedure_extra">
        <br/>
        <div class="navbar navbar-default">
            <form action="#" class="navbar-form form-inline">
                <label for="">ค้นหา</label>
                <input type="hidden" id="txt_procedure_extra_query" class="form-control" style="width: 550px;"/>
                <button type="button" class="btn btn-primary" id="btn_procedure_extra_do_search">
                    <i class="fa fa-plus"></i>
                </button>
            </form>
        </div>
        <table class="table table-striped" id="tbl_procedure_extra">
            <thead>
            <tr>
                <th>รหัส</th>
                <th>รายการ</th>
                <th>ราคา</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody></tbody>

        </table>

        <ul class="pagination" id="procedure_extra_paging"></ul>
    </div>
    <?php } ?>
</div>


