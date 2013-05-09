<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียน EPI</li>
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
    <button type="button" class="btn btn-info" id="btn_do_get_list"><i class="icon-search"></i> แสดงรายการ</button>
    <div class="btn-group pull-right">
        <button rel="tooltip" title="รีเฟรช" type="button" id="btn_search" class="btn"><i class="icon-refresh"></i></button>
        <button rel="tooltip" title="ลงทะเบียนรายใหม่" type="button" id="btn_register" class="btn btn-success"><i class="icon-plus-sign"></i></button>
    </div>
</form>

<table class="table table-striped table-hover" id="tbl_epi_list">
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

<div class="modal hide fade" id="mdl_search_person">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>
            <i class="icon-search"></i>
            ค้นหาข้อมูลประชากร
        </h4>
    </div>
    <div class="modal-body">
        <form action="#" class="form-inline well well-small">
            <input type="hidden" id="txt_search_person_filter" value="0" />
            <div class="input-append">
                <input class="input-xlarge" id="txt_search_query" type="text" autocomplete="off">
                <button class="btn" type="button" id="btn_do_search_person">
                    <i class="icon-search"></i>
                </button>
                <div class="btn-group">
                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-cog"></i>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-name="btn_search_person_fillter" data-value="0">ค้นจาก เลขบัตรประชาชน</a></li>
                        <li><a href="#" data-name="btn_search_person_fillter" data-value="1">ค้นจาก HN</a></li>
                        <li><a href="#" data-name="btn_search_person_fillter" data-value="2">ค้นจาก ชื่อ - สกุล</a></li>
                    </ul>
                </div>
            </div>
        </form>
        <table class="table table-striped" id="tbl_search_person_result">
            <thead>
            <tr>
                <th>HN</th>
                <th>เลขบัตรประชาชน</th>
                <th>ชื่อ - สกุล</th>
                <th>วันเกิด</th>
                <th>อายุ</th>
                <th>เพศ</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.epi.index.js');
</script>


