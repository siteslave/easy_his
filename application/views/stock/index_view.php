<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>"><i class="icon-home"></i> หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('settings'); ?>"><i class="icon-cogs"></i> กำหนดค่า</a> <span class="divider">/</span></li>
    <li class="active"><i class="icon-shopping-cart"></i> ทะเบียนเวชภัณฑ์</li>
</ul>
<form action="#" class="form-actions form-inline">
    <label for="txt_query">ค้นหา</label>
    <input class="input-xlarge" id="txt_query" type="text" placeholder="พิมพ์ชื่อยา..." autocomplete="off" />
    <button class="btn btn-info" id="btn_search">
        <i class="icon-search"></i>
    </button>

    <button class="btn btn-success pull-right" id="btn_register">
        <i class="icon-plus-sign"></i> เพิ่มรายการยา
    </button>
</form>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
        <tr>
            <th>รหัส</th>
            <th>รหัสมาตฐาน</th>
            <th>ชื่อยา</th>
            <th>ความแรง</th>
            <th>หน่วย</th>
            <th>ราคา</th>
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
    <form action="#">

        <input type="hidden" id="txt_isupdate" value="0" />

        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="sl_pdeath">สถานที่</label>
                    <div class="controls">
                        <select id="sl_pdeath" class="input-xlarge">
                            <option value="">--</option>
                            <option value="1">ในสถานพยาบาล</option>
                            <option value="2">นอกสถานพยาบาล</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" id="btn_save_death"><i class="icon-save"></i> บันทึกข้อมูล</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
</div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/app.stock.index.js');
</script>


