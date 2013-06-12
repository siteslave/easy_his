    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
        <li><a href="<?php echo site_url('settings'); ?>">ตั้งค่า</a> <span class="divider">/</span></li>
        <li class="active">ข้อมูลผู้ให้บริการ (Providers)</li>
    </ul>
    <div class="alert alert-info">
        <strong>คำแนะนำ!</strong> เพิ่มข้อมูลผู้ให้บริการ เช่น แพทย์และทันตแพทย์, บุคลากรสาธารณสุขที่ทำหน้าที่ตรวจรักษา, อสม. อื่นๆ
    </div>

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
            <i class="icon-plus-sign"></i> เพิ่มรายการ
        </button>
    </div>

    <!-- modal new house -->
    <div class="modal hide fade" id="modal_new_provider">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>เพิ่มข้อมูลผู้ให้บริการ (Provider)</h3>
        </div>
        <div class="modal-body">
            <div class="alert alert-info" id="alert_save_house">
                <strong>คำแนะนำ!</strong> <span>กรุณากรอกข้อมูลให้ครบ</span>
            </div>
            <form action="#">
                <input type="hidden" id="txt_search_for">
                <input type="hidden" id="is_update">
                <input type="hidden" id="txt_old_cid">
                <input type="hidden" id="txt_provider_id">
                <div class="row-fluid">
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_regster_no">ทะเบียนวิชาชีพ</label>
                            <div class="controls">
                                <input type="text" id="txt_regster_no" class="input-medium">
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_council">รหัสสภาวิชาชีพ</label>
                            <div class="controls">
                                <input type="text" id="txt_council" class="input-medium">
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_cid">เลขบัตรประชาชน</label>
                            <div class="controls">
                                <input type="text" id="txt_cid" class="input-medium">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="sl_sex">เพศ</label>
                            <div class="controls">
                                <select  id="sl_sex" class="input-small">
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="sl_title">คำนำ</label>
                            <div class="controls">
                                <select  id="sl_title" class="input-small">
                                    <option value="">--</option>
                                    <?php 
                                    foreach($titles as $t){
                                    	echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_first_name">ชื่อ</label>
                            <div class="controls">
                                <input type="text" id="txt_first_name" class="input-medium">
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_last_name">สกุล</label>
                            <div class="controls">
                                <input type="text" id="txt_last_name" class="input-medium">
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_birth_date">วันเกิด</label>
                            <div class="controls">
                                <div class="input-append date" data-name="datepicker">
                                    <input class="input-small" id="txt_birth_date" type="text" disabled>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="sl_provider_type">ประเภทบุคลากร</label>
                            <div class="controls">
                                <select  id="sl_provider_type" class="input-xlarge">
                                    <option value="">--</option>
                                    <?php 
                                    foreach($provider_types as $t){
                                    	echo '<option value="'.$t->code.'">' . $t->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_start_date">เริ่มปฏิบัติงาน</label>
                            <div class="controls">
                                <div class="input-append date" data-name="datepicker">
                                    <input class="input-small" id="txt_start_date" type="text" disabled>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_out_date">ออกจากงาน</label>
                            <div class="controls">
                                <div class="input-append date" data-name="datepicker">
                                    <input class="input-small" id="txt_out_date" type="text" disabled>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="txt_move_from_hospital_name">สถานบริการที่ย้ายมา</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input class="input-medium" id="txt_move_from_hospital_name" disabled type="text">
                                    <input type="hidden" id="txt_move_from_hospital_code">
                                    <button class="btn" type="button" id="btn_search_hospital_from">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="txt_move_to_hospital_name">สถานบริการที่ย้ายไป</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input class="input-medium" id="txt_move_to_hospital_name" disabled type="text">
                                    <input type="hidden" id="txt_move_to_hospital_code" />
                                    <button class="btn" type="button" id="btn_search_hospital_to">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn_do_save_provider"><i class="icon-save"></i> บันทึกข้อมูล</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
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