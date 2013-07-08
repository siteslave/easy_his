    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
        <li><a href="<?php echo site_url('settings'); ?>">กำหนดค่า</a></li>
        <li class="active">ข้อมูลแผนก</li>
    </ul>
    <div class="row-fluid">
        <table class="table table-striped table-hover" id="tbl_list">
            <thead>
            <tr>
                <th>ลำดับ</th>
                <th>รหัสส่งออก</th>
                <th>รายการ</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
            </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-success" id="btn_new">
            <i class="icon-plus-sign"></i> เพิ่มรายการ
        </button>
    </div>

    <!-- modal new house -->
    <div class="modal fade" id="modal_new">
        <div class="modal-dialog" style="width: 960px; left: 35%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3>เพิ่มข้อมูลแผนก</h3>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <input type="hidden" id="txt_id">
                        <input type="hidden" id="is_update" value="0">
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="control-label" for="txt_export_code">รหัสส่งออก</label>
                                <input type="text" id="txt_export_code">
                            </div>
                            <div class="col-lg-3">
                                <label class="control-label" for="txt_name">ชื่อแผนก</label>
                                <input type="text" id="txt_name">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_do_save"><i class="icon-save"></i> บันทึกข้อมูล</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        head.js('<?php echo base_url(); ?>assets/apps/js/apps.settings.clinics.js');
    </script>