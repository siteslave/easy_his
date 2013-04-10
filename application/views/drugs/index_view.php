<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>"><i class="icon-home"></i> หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('settings'); ?>"><i class="icon-cogs"></i> กำหนดค่า</a> <span class="divider">/</span></li>
    <li class="active"><i class="icon-shopping-cart"></i> ทะเบียนเวชภัณฑ์</li>
</ul>
<form action="#" class="form-actions form-inline">
    <label for="txt_query">ค้นหา</label>
    <div class="input-append">
        <input class="input-xlarge" id="txt_query" type="text" placeholder="พิมพ์ชื่อยา..." autocomplete="off" />
        <button class="btn btn-info" id="btn_search">
            <i class="icon-search"></i> ค้นหา
        </button>
    </div>

    <button class="btn btn-success pull-right" id="btn_register">
        <i class="icon-plus-sign"></i> เพิ่มรายการยา
    </button>
</form>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
        <tr>
            <th>รหัสมาตฐาน</th>
            <th>ชื่อยา</th>
            <th>ความแรง</th>
            <th>หน่วย</th>
            <th>ราคาซื้อ</th>
            <th>ราคาขาย</th>
            <th>คงเหลือ</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="8">ไม่พบรายการ</td>
    </tr>
    </tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<div class="modal hide fade" id="mdl_register">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="icon-briefcase"></i> เพิ่ม/แก้ไขรายการยา</h3>
</div>
<div class="modal-body">
    <form action="#" class="">

        <input type="hidden" id="txt_isupdate" value="0" />
        <input type="hidden" id="txt_id" value="" />

        <div class="row-fluid">
            <div class="span4">
                <div class="control-group error">
                    <label class="control-label" for="txt_reg_did">รหัสมาตรฐาน</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge" id="txt_reg_did" data-type="number" />
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_reg_name">ชื่อยา</label>
                    <div class="controls">
                        <input type="text" class="input-xxlarge" id="txt_reg_name" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span1">
                <div class="control-group">
                    <label class="control-label" for="txt_reg_strength_value">ความแรง</label>
                    <div class="controls">
                        <input type="text" class="input-mini" id="txt_reg_strength_value" data-type="number" />
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_reg_strength_unit">หน่วยความแรง</label>
                    <div class="controls">
                        <select id="sl_reg_strength_unit" class="input-small">
                            <option value="">---</option>
                            <?php
                            foreach($strengths as $r)
                            {
                                echo '<option value="'.$r->id.'">'. $r->name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="sl_reg_unit">หน่วย</label>
                    <div class="controls">
                        <select id="sl_reg_unit" class="input-medium">
                            <option value="">---</option>
                            <?php
                            foreach($units as $r)
                            {
                                echo '<option value="'.$r->id.'">'. $r->name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group success">
                    <label class="control-label" for="txt_reg_unit_cost">ราคาซื้อ (บาท)</label>
                    <div class="controls">
                        <input type="text" class="input-small" data-type="number" id="txt_reg_unit_cost" />
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group success">
                    <label class="control-label" for="txt_reg_unit_price">ราคาขาย (บาท)</label>
                    <div class="controls">
                        <input type="text" class="input-small" data-type="number" id="txt_reg_unit_price" />
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group success">
                    <label class="control-label" for="txt_reg_qty">คงเหลือ</label>
                    <div class="controls">
                        <input type="text" class="input-small" data-type="number" id="txt_reg_qty" />
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="row-fluid">

            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txt_reg_usage_name">วิธีการใช้ยา</label>
                    <div class="controls">
                        <input type="hidden" id="txt_reg_usage_id" />
                        <input type="text" class="input-xxlarge" data-type="number" id="txt_reg_usage_name" />
                    </div>
                </div>
            </div>
        </div>-->
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" id="btn_save"><i class="icon-save"></i> บันทึกข้อมูล</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
</div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.drugs.index.js');
</script>


