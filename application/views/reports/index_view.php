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
        
    </div>
    <div class="modal-footer">
        <a class="btn btn-danger" data-dismiss="modal">ยกเลิก</a>
        <a class="btn btn-primary">แสดงรายงาน</a>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/report.menu.report.js');
</script>
