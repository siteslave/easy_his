<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียนผู้ป่วยความดัน (HT)</li>
</ul>
<form action="#" class="well form-inline">
    <label for="sl_village_id">หมู่บ้าน</label>
    <select class="input-xlarge" id="sl_village">
        <option value="00000000">---</option>
        <?php
        foreach ($villages as $r){
            echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
        }
        ?>
    </select>
    บ้านเลขที่
    <select id="sl_house" class="input-medium"></select>
    <button type="button" class="btn btn-info" id="btn_do_get_list"><i class="icon-search icon-white"></i> แสดงรายการ</button>
    <div class="btn-group pull-right">
        <button type="button" id="btn_search" class="btn"><i class="icon-search"></i> ค้นหา</button>
        <button type="button" id="btn_register" class="btn btn-success"><i class="icon-plus-sign icon-white"></i> ลงทะเบียน</button>
    </div>
</form>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
    <tr>
        <th>HN</th>
        <th>CID</th>
        <th>วันที่ลงทะเบียน</th>
        <th>ชื่อ - สกุล</th>
        <th>วันเกิด</th>
        <th>อายุ (ปี)</th>
        <th>เพศ</th>

        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="8">กรุณากำหนดเงื่อนไขการแสดงข้อมูล</td>
    </tr>
    </tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<div class="modal hide fade" id="mdl_register">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ลงทะเบียนใหม่</h3>
    </div>
    <div class="modal-body" style="height: 250px;">
        <form class="form-inline well">
            <input type="hidden" data-name="txt_search_person_filter" value="0">
            <label>คำค้นหา</label>
            <input type="text" class="input-xlarge" id="txt_query_person">
            <div class="btn-group">
                <button type="button" class="btn btn-info" id="btn_do_search_person"><i class="icon-search icon-white"></i> ค้นหา</button>
                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter" data-value="0"><i class="icon-qrcode"></i> ค้นจาก เลขบัตรประชาชน</a></li>
                    <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter" data-value="1"><i class="icon-th-list"></i> ค้นจาก HN</a></li>
                    <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter" data-value="2"><i class="icon-list"></i> ค้นจาก ชื่อ - สกุล</a></li>
                </ul>
            </div>
        </form>
        <table class="table table-striped" id="tbl_search_person_result">
            <thead>
            <tr>
                <th>HN</th>
                <th>CID</th>
                <th>ชื่อ - สกุล</th>
                <th>วันเกิด</th>
                <th>อายุ</th>
                <th>เพศ</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="7">กรุณาระบุเงื่อนไขการค้นหา</td>
            </tr>
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.ht.index.js');
</script>


