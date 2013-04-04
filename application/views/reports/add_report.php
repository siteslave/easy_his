<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('reports'); ?>">รายงาน</a> <span class="divider">/</span></li>
    <li class="active">เพิ่มรายงาน</li>
</ul>

<input type="hidden" id="tboGroup" value="<?php echo $id; ?>">

<div class="alert alert-danger">
    <div class="form-inline">
        <?php
            $m1 = '<b><a href="'.site_url("reports/add_report/1").'">การให้บริการ</a></b> / ';
            $m2 = '<b><a href="'.site_url("reports/add_report/2").'">งานส่งเสริม</a></b> / ';
            $m3 = '<b><a href="'.site_url("reports/add_report/3").'">ข้อมูลพื้นฐาน</a></b> ';

            if($id == 1) {
                $m1 = '<b>การให้บริการ</b> / ';
            } elseif($id == 2) {
                $m2 = '<b>งานส่งเสริม</b> / ';
            } else {
                $m3 = '<b>ข้อมูลพื้นฐาน</b>';
            }

            echo $m1.$m2.$m3;
        ?>
        <button class="btn btn-mini btn-info pull-right" id="btnAddReport" data-id="<? echo $id; ?>"><i class="icon-plus-sign icon-white"></i> เพิ่มรายงาน</button>
    </div>
</div>

<table class="table table-striped table-hover" id="tblList">
    <thead>
    <tr>
        <th>ชื่อรายงาน</th>
        <th>URL</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<div class="modal hide fade" id="mdlReport">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>จัดการรายงาน</h3>
    </div>
    <div class="modal-body">
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="tboName">ชื่อรายงาน</label>
                    <div class="controls">
                        <input type="text" class="input-large" id="tboName">
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="cboGroup">หมวดรายงาน</label>
                    <div class="controls">
                        <select class="input-large" id="cboGroup">
                            <option value="1">การให้บริการ</option>
                            <option value="2">งานส่งเสริม</option>
                            <option value="3">ข้อมูลพื้นฐาน</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="tboUrl">URL</label>
                    <div class="controls">
                        <input type="text" class="input-large" id="tboUrl">
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