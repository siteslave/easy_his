    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
        <li class="active">กำหนดค่า<span class="divider">/</span></li>
        <li class="active">ข้อมูลค่าใช้จ่าย</li>
    </ul>
    <form action="#" class="well well-small form-inline">
        <div class="input-append">
            <input class="input-xlarge" id="txt_query" type="text" placeholder="พิมพ์คำที่ต้องการค้นหา...">
            <button class="btn btn-info" rel="tooltip" title="ค้นหา" id="btn_search" type="button">
                <i class="icon-search"></i>
            </button>
        </div>
|
        <select id="sl_incomes" class="input-xxlarge">
            <option value="">เลือกหมวดหมู่</option>
            <?php
            foreach($incomes as $r)
            {
                echo '<option value="'.get_first_object($r['_id']).'">' . $r['name'] . '</option>';
            }
            ?>
        </select>
        <button type="button" rel="tooltip" title="แสดงรายการ" id="btn_filter" class="btn btn-info">
            <i class="icon-search"></i>
        </button>

        <div class="btn-group pull-right">
            <button type="button" rel="tooltip" title="เพิ่มรายการ" class="btn btn-success" id="" disabled="disabled"><i class="icon-plus-sign"></i></button>
            <button type="button" rel="tooltip" title="รีเฟรชรายการใหม่" class="btn" id="btn_refresh"><i class="icon-refresh"></i></button>
        </div>
    </form>
    <table class="table table-striped table-hover" id="tbl_list">
        <thead>
        <tr>
            <th>รหัส</th>
            <th>รายการ</th>
            <th>หมวดหมู่</th>
            <th>ราคาทุน</th>
            <th>ราคาขาย</th>
            <th>หน่วย</th>
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
        </tr>
        </tbody>
    </table>

    <div class="pagination pagination-centered" id="main_paging">
        <ul></ul>
    </div>

    <!-- modal new house -->
    <div class="modal hide fade" id="modal_new_item">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="icon-edit"></i> แก้ไขรายการ</h4>
        </div>
        <div class="modal-body">
            <form action="#">
                <input type="hidden" id="txt_id">
                <input type="hidden" id="is_update" value="0">
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="txt_reg_name">รายการ</label>
                            <div class="controls">
                                <input type="text" id="txt_reg_name" class="input-xxlarge uneditable-input" disabled="disabled">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_reg_cost">ราคาทุน</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input id="txt_reg_cost" class="input-mini" type="text" data-type="number">
                                    <span class="add-on">บาท</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_reg_price">ราคาขาย</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input id="txt_reg_price" class="input-mini" type="text" data-type="number">
                                    <span class="add-on">บาท</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn_save"><i class="icon-save"></i> บันทึกข้อมูล</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
        </div>
    </div>
    <script type="text/javascript">
        head.js('<?php echo base_url(); ?>assets/apps/js/apps.settings.incomes.js');
    </script>