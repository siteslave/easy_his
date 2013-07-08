    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
        <li><a href="<?php echo site_url('settings'); ?>">ตั้งค่า</a></li>
        <li class="active">ข้อมูลผู้ให้บริการ (Providers)</li>
    </ul>
    <div class="row-fluid">
        <table class="table table-striped table-hover" id="tbl_provider_list">
            <thead>
            <tr>
                <th>ลำดับ</th>
                <th>รหัส</th>
                <th>เลขบัตรประชาชน</th>
                <th>ชื่อ - สกุล</th>
                <th>ทะเบียนวิชาชีพ</th>
                <th>ประเภทบุคลากร</th>
                <th>วันเริ่ม</th>
                <th>วันสิ้นสุด</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
            </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-success" id="btn_new_provider">
            <i class="icon-plus-sign"></i> เพิ่ม
        </button>
    </div>

    <!-- modal new house -->
    <div class="modal fade" id="modal_new_provider">
        <div class="modal-dialog" style="width: 960px; left: 35%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="icon-user-md"></i> เพิ่มข้อมูลผู้ให้บริการ (Provider)</h4>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <input type="hidden" id="txt_search_for">
                        <input type="hidden" id="is_update">
                        <input type="hidden" id="txt_old_cid">
                        <input type="hidden" id="txt_provider_id">
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="control-label" for="txt_regster_no">ทะเบียนวิชาชีพ</label>
                                <input type="text" id="txt_regster_no">
                            </div>
                            <div class="col-lg-3">
                                <label class="control-label" for="txt_council">รหัสสภาวิชาชีพ</label>
                                <input type="text" id="txt_council">
                            </div>
                            <div class="col-lg-3">
                                <label class="control-label" for="txt_cid">เลขบัตรประชาชน</label>
                                <input type="text" id="txt_cid">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="sl_sex">เพศ</label>
                                <select  id="sl_sex">
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="control-label" for="sl_title">คำนำ</label>
                                <select  id="sl_title">
                                    <option value="">--</option>
                                    <?php
                                    foreach($titles as $t){
                                        echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="control-label" for="txt_first_name">ชื่อ</label>
                                <input type="text" id="txt_first_name">
                            </div>
                            <div class="col-lg-3">
                                <label class="control-label" for="txt_last_name">สกุล</label>
                                <input type="text" id="txt_last_name">
                            </div>
                            <div class="col-lg-3">
                                <label class="control-label" for="txt_birth_date">วันเกิด</label>
                                <input id="txt_birth_date" type="text" data-type="date" placeholder="dd/mm/yyyy" title="วันเดือนปี เกิด" rel="tooltip">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <label class="control-label" for="sl_provider_type">ประเภทบุคลากร</label>
                                <select  id="sl_provider_type">
                                    <option value="">--</option>
                                    <?php
                                    foreach($provider_types as $t){
                                        echo '<option value="'.$t->code.'">' . $t->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_start_date">เริ่มปฏิบัติงาน</label>
                                <input id="txt_start_date" type="text" data-type="date" title="ระบุวันที่ dd/mm/yyyy" rel="tooltip">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_out_date">ออกจากงาน</label>
                                <input id="txt_out_date" type="text" data-type="date" title="ระบุวันที่ dd/mm/yyyy" rel="tooltip">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_move_from_hospital_code">รหัส</label>
                                <input type="text" id="txt_move_from_hospital_code" placeholder="-*-" disabled>
                            </div>
                            <div class="col-lg-4">
                                <label for="txt_move_from_hospital_name">สถานบริการที่ย้ายมา</label>
                                <input id="txt_move_from_hospital_name" type="text" placeholder="พิมพ์ชื่อหรือรหัสสถานพยาบาล">
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_move_to_hospital_code">รหัส</label>
                                <input type="text" id="txt_move_to_hospital_code" placeholder="-*-" disabled>
                            </div>
                            <div class="col-lg-4">
                                <label for="txt_move_to_hospital_name">สถานบริการที่ย้ายไป</label>
                                <input id="txt_move_to_hospital_name" type="text" placeholder="พิมพ์ชื่อหรือรหัสสถานพยาบาล">
                            </div>
                        </div>



                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_do_save_provider"><i class="icon-save"></i> บันทึกข้อมูล</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" id="modal_search_hospital">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>ค้นหาสถานบริการ</h3>
        </div>
        <div class="modal-body">
            <form action="#" class="form-inline form-actions">
                <input type="hidden" id="txt_search_by" />
                <div class="control-group">
                    <div class="controls">
                        <label for="text_query_search_hospital">ชื่อ/รหัส สถานบริการ</label>
                        <div class="input-append">
                            <input class="input-xlarge" placeholder="..." id="text_query_search_hospital" type="text">
                            <button class="btn btn-info" type="button" id="btn_do_search_hospital"><i class="icon-search"></i> ค้นหา</button>
                        </div>

                        <label class="checkbox inline">
                            <input type="checkbox" id="chk_search_by_name" checked="checked"> ค้นจากชื่อ
                        </label>

                    </div>
                </div>
            </form>
            <table class="table table-striped" id="table_search_hospital_result_list">
                <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อสถานบริการ</th>
                    <th>จังหวัด</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
        </div>
    </div>
    <!-- end person -->
    <!-- <script type="text/javascript" src="{{ base_url }}assets/apps/js/apps.settings.provider.js"></script> -->
    <script type="text/javascript">
        head.js('<?php echo base_url(); ?>assets/apps/js/apps.settings.provider.js');
    </script>