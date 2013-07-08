<?php
    $title = '';
    for($i = 0; $i < count($mainmenu); $i++) {
        if($mainmenu[$i]->id == $id) {
            $title = $mainmenu[$i]->name;
        }
    }
?>

<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">รายงาน</li>
</ul>

<input type="hidden" id="tboId" value="<?php echo $id; ?>">

<div class="alert alert-info">
    <h4>
        <?php echo $title; ?>
    </h4>
</div>

<table class="table table-striped table-hover" id="tblList">
    <thead>
    <tr>
        <th>ชื่อรายงานย่อย</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<div class="modal hide fade" id="mdlDate2">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Modal header</h3>
    </div>
    <div class="modal-body">
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="tboStart">จากวันที่</label>
                    <div class="input-append date" data-name="datepicker">
                        <input value="<?php echo date('d/m/Y'); ?>" type="text" id="tboStart" style="width: 80px;" disabled />
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="tboStop">ถึงวันที่</label>
                    <div class="input-append date" data-name="datepicker">
                        <input value="<?php echo date('d/m/Y'); ?>" type="text" id="tboStop" style="width: 80px;" disabled />
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a class="btn btn-danger" data-dismiss="modal">ยกเลิก</a>
        <a class="btn btn-primary" id="btnDate2View">แสดงรายงาน</a><input type="hidden" id="tboUrl">
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/report.menu.report.js');
</script>
