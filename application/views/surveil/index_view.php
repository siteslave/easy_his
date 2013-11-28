<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">บันทึกข้อมูลระบาดวิทยา (506)</li>
</ul>
<div class="navbar navbar-default">
    <form action="#" class="navbar-form form-inline">

        <label for="txt_query_date">วันทีรับบริการ</label>
        <input style="width: 150px;" id="txt_query_date" type="text" data-type="date" placeholder="dd/mm/yyyy"
               value="<?=get_current_date()?>" title="ระบุวันที่รับบริการ" rel="tooltip" class="form-control">
        <button type="buttton" id="btn_get_list" class="btn btn-primary"
                rel="tooltip" title="เลือกวันที่รับบริการ เพื่อค้นหาผู้ป่วยที่มีการวินิจฉัยตรงกับงานระบาดวิทยา">
            <i class="fa fa-search"></i>
        </button>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-success" title="ส่งออก" rel="tooltip">
                <i class="fa fa-download"></i>
            </button>
            <button type="button" class="btn btn-default" id="btn_surveil_resresh" title="รีเฟรช" rel="tooltip">
                <i class="fa fa-refresh"></i>
            </button>
        </div>
    </form>
</div>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
    <tr>
        <th>วันที่</th>
        <th>HN</th>
<!--        <th>เลขบัตรประชาชน</th>-->
        <th>ชื่อ - สกุล</th>
        <th>รหัสวินิฉัย</th>
        <th>รหัส 506</th>
        <th>สภาพผู้ป่วย</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="7">...</td>
    </tr>
    </tbody>
</table>

<ul class="pagination pagination-centered" id="main_paging"></ul>

<div class="modal fade" id="mdl_surveillance_entry">
    <div class="modal-dialog" style="width: 960px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">บันทึกข้อมูลระบาดวิทยา</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.surveil.js');
</script>


