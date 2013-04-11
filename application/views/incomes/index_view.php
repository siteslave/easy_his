    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
        <li><a href="<?php echo site_url('settings'); ?>">กำหนดค่า</a> <span class="divider">/</span></li>
        <li class="active">ข้อมูลค่าใช้จ่าย</li>
    </ul>
    <form action="#" class="well well-small form-inline">
        <div class="input-append">
            <input class="input-xlarge" id="txt_query" type="text" placeholder="พิมพ์คำที่ต้องการค้นหา...">
            <button class="btn btn-info" id="btn_search" type="button">
                <i class="icon-search"></i> ค้นหา
            </button>
        </div>
|
        <select id="sl_groups">
            <option value="">เลือกหมวดหมู่</option>
            <?php
            foreach($groups as $r)
            {
                echo '<option value="'.get_first_object($r['_id']).'">' . $r['name'] . '</option>';
            }
            ?>
        </select>
        <button type="button" id="btn_filter" class="btn btn-info">
            <i class="icon-search"></i> แสดง
        </button>

        <div class="btn-group pull-right">
            <button type="button" class="btn btn-success" id="btn_new"><i class="icon-plus-sign"></i> เพิ่มรายการ</button>
            <button type="button" class="btn" id="btn_refresh"><i class="icon-refresh"></i> แสดงทั้งหมด</button>
        </div>
    </form>
    <table class="table table-striped table-hover" id="tbl_list">
        <thead>
        <tr>
            <th>รายการ</th>
            <th>หมวดหมู่</th>
            <th>ราคา</th>
            <th>สถานะ</th>
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
            <h3>เพิ่มรายการ</h3>
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
                                <input type="text" id="txt_reg_name" class="input-xxlarge">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="control-group">
                        <label class="control-label" for="sl_reg_groups">หมวดหมู่</label>
                        <div class="controls">
                            <select id="sl_reg_groups" class="input-xxlarge">
                                <option value="">เลือกหมวดหมู่</option>
                                <?php
                                foreach($groups as $r)
                                {
                                    echo '<option value="'.get_first_object($r['_id']).'">' . $r['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label" for="txt_reg_price">ราคา</label>
                            <div class="controls">
                                <input type="text" id="txt_reg_price" class="input-small" data-type="number">
                            </div>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="chk_active">ใช้งาน</label>
                            <div class="controls">
                                <input type="checkbox" id="chk_active" checked="checked"/>
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