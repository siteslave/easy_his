    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
        <li class="active">กำหนดค่า</li>
        <li class="active">ข้อมูลค่าใช้จ่าย</li>
    </ul>
    <div class="navbar navbar-default">
        <form action="#" class="navbar-form form-inline">
            <input id="txt_query" class="form-control" type="text" placeholder="พิมพ์คำที่ต้องการค้นหา..." style="width: 350px;">
            <button class="btn btn-primary" rel="tooltip" title="ค้นหา" id="btn_search" type="button">
                <i class="fa fa-search"></i>
            </button>
            |
            <select id="sl_incomes" style="width: 350px;" class="form-contorl">
                <option value="">เลือกหมวดหมู่ [ทั้งหมด]</option>
                <?php
                foreach($incomes as $r)
                {
                    echo '<option value="'.get_first_object($r['_id']).'">' . $r['name'] . '</option>';
                }
                ?>
            </select>
            <button type="button" rel="tooltip" title="แสดงรายการ" id="btn_filter" class="btn btn-primary">
                <i class="fa fa-search"></i>
            </button>

            <div class="btn-group pull-right">
                <button type="button" rel="tooltip" title="เพิ่มรายการ" class="btn btn-success" id="" disabled="disabled">
                    <i class="fa fa-plus-circle"></i>
                </button>
                <button type="button" rel="tooltip" title="รีเฟรชรายการใหม่" class="btn btn-default" id="btn_refresh">
                    <i class="fa fa-refresh"></i>
                </button>
            </div>
        </form>
    </div>
    <table class="table table-striped table-hover" id="tbl_list">
        <thead>
        <tr>
            <th>รายการ</th>
            <th>หมวดหมู่</th>
            <th>ราคาทุน</th>
            <th>ราคาขาย</th>
            <th>หน่วย</th>
            <th>คงเหลือ</th>
            <th></th>
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
        </tr>
        </tbody>
    </table>

    <ul class="pagination pagination-centered" id="main_paging"></ul>

    <!-- modal new house -->
    <div class="modal fade" id="modal_new_item">
        <div class="modal-dialog" style="width: 960px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i> แก้ไขรายการ</h4>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <input type="hidden" id="txt_id">
                        <input type="hidden" id="is_update" value="0">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="txt_reg_name">รายการ</label>
                                <input type="text" id="txt_reg_name" class="form-control" disabled="disabled">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label for="txt_reg_cost">ราคาทุน</label>
                                <input id="txt_reg_cost" class="form-control" type="text" data-type="number" disabled>
                            </div>
                            <div class="col-lg-2">
                                <label for="txt_reg_price">ราคาขาย</label>
                                <input id="txt_reg_price" class="form-control" type="text" data-type="number">
                            </div>
                            <div class="col-lg-2">
                                <label for="txt_reg_qty">คงเหลือ</label>
                                <input id="txt_reg_qty" class="form-control" type="text" data-type="number">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_save">
                        <i class="fa fa-save"></i> บันทึกข้อมูล
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-power-off"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        head.js('<?php echo base_url(); ?>assets/apps/js/apps.settings.incomes.js');
    </script>