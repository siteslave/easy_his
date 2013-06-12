<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('reports'); ?>">รายงาน</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('reports/add_report/main'); ?>">เพิ่มหมวดรายงาน</a> <span class="divider">/</span></li>
    <li class="active"><?php for($i = 0; $i < count($mainmenu); $i++) { if($mainmenu[$i]->id == $id) echo $mainmenu[$i]->name; } ?></li>
</ul>

<input type="hidden" id="tboMainId" value="<?php echo $id; ?>">

<table class="table table-striped table-hover" id="tblList">
    <thead>
    <tr>
        <th>ชื่อรายงานย่อย</th>
        <th>URL</th>
        <th>
            <button class="btn btn-success btn-mini" id="btnAddSubReport"><i class="icon-plus-sign icon-white"></i> เพิ่มรายงานย่อย</button>
        </th>
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
                            <?php
                                for($i = 0; $i < count($mainmenu); $i++) {
                                    echo '<option value="'.$mainmenu[$i]->id.'">'.$mainmenu[$i]->name.'</option>';
                                }
                            ?>
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
    head.js('<?php echo base_url(); ?>assets/apps/js/report.add_sub_report.js');
</script>