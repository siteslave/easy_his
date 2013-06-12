<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('reports'); ?>">รายงาน</a> <span class="divider">/</span></li>
    <li class="active">เพิ่มหมวดรายงาน</li>
</ul>

<table class="table table-striped table-hover" id="tblList">
    <thead>
    <tr>
        <th>ชื่อหมวดรายงาน</th>
        <th>
            <button class="btn btn-success btn-mini" id="btnAddMainReport"><i class="icon-plus-sign icon-white"></i> เพิ่มหมวดรายงาน</button>
        </th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<div class="modal hide fade" id="mdlMainReport">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>จัดการรายงาน</h3>
    </div>
    <div class="modal-body">
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="tboName">ชื่อหมวดรายงาน</label>
                    <div class="controls">
                        <input type="text" class="input-large" id="tboName">
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="tboName">ไอค่อน</label>
                    <div class="controls">
                        <input type="text" class="input-large" id="tboIcon">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a class="btn btn-danger" data-dismiss="modal" aria-hidden="true">ยกเลิก</a>
        <a class="btn btn-primary" id="btnSave">บันทึก</a><input type="hidden" id="tboId">
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/report.addreport.js');
</script>