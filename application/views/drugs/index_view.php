<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>"><i class="icon-home"></i> หน้าหลัก</a></li>
    <li><a href="javascript:void();"><i class="icon-cogs"></i> กำหนดค่า</a></li>
    <li class="active"><i class="icon-shopping-cart"></i> ทะเบียนเวชภัณฑ์</li>
</ul>
<div class="navbar">
    <form action="#" class="navbar-form form-inline">
        <label for="txt_query">ค้นหา</label>
        <input style="width: 350px;" id="txt_query" type="text" placeholder="พิมพ์ชื่อยา..."
               rel="tootlip" title="พิมพ์ชื่อยา เพื่อค้นหา" autocomplete="off" />
        <button class="btn btn-primary" id="btn_search">
            <i class="icon-search"></i> ค้นหา
        </button>

        <button rel="tooltip" title="รีเฟรชใหม่" class="btn btn-success pull-right" id="btn_refresh">
            <i class="icon-refresh"></i>
        </button>
    </form>
</div>

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

<ul class="pagination pagination-centered" id="main_paging"></ul>

<div class="modal fade" id="mdl_register">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-briefcase"></i> แก้ไขรายการยา</h4>
            </div>
            <div class="modal-body">
                <form action="#" class="">
                    <input type="hidden" id="txt_id" value="" />
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label" for="txt_reg_did">รหัสมาตรฐาน</label>
                            <input type="text" disabled="disabled" id="txt_reg_did" data-type="number" />
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label" for="txt_reg_name">ชื่อยา</label>
                            <input type="text" disabled="disabled" id="txt_reg_name" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="control-label" for="txt_reg_unit_cost">ราคาซื้อ (บาท)</label>
                            <input type="text" disabled="disabled" data-type="number" id="txt_reg_unit_cost" />
                        </div>
                        <div class="col-lg-2">
                            <label class="control-label" for="txt_reg_unit_price">ราคาขาย (บาท)</label>
                            <input type="text" data-type="number" id="txt_reg_unit_price" />
                        </div>
                        <div class="col-lg-2">
                            <label class="control-label" for="txt_reg_qty">คงเหลือ</label>
                            <input type="text" data-type="number" id="txt_reg_qty" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_save"><i class="icon-save"></i> บันทึกข้อมูล</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.drugs.index.js');
</script>


