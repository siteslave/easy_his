<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">การให้บริการ</li>
</ul>
<div class="navbar">
    <form action="#" class="navbar-form">
    <input type="text" style="width: 200px;" id="txt_query_visit" 
    rel="tooltip" title="พิมพ์ชื่อ หรือ HN หรือ เลขบัตรประชาชน เพื่อค้นหา" autocomplete="off" placeholder="HN, ชื่อ สกุล...">
    <button type="button" id="btn_do_search_visit" class="btn btn-primary" rel="tooltip" title="ค้นหารายการ"><i class="icon-search"></i></button>
   | 
    <input style="width: 100px;" id="txt_service_date" type="text" value="<?=get_current_date()?>"
    placeholder="dd/mm/yyyy" data-type="date" rel="tooltip" title="ระวันที่ เช่น 12/02/2556">
    <!--
    <select id="sl_query_filter_by_diag" class="input-medium">
        <option value="1">ทั้งหมด</option>
        <option value="1">ยังไม่ลงรหัสวินิจฉัย</option>
        <option value="1">ลงวินิจฉัยแล้ว</option>
    </select>
    -->
    <select style="width: 200px;" id="sl_service_doctor_room">
        <option value="">--- ห้องตรวจ ---</option>
        <?php foreach($doctor_rooms as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
    </select>

    <button class="btn btn-primary" id="btn_do_filter" type="button" title="แสดง" rel="tooltip">
        <i class="icon-search"></i>
    </button>

    <div class="btn-group pull-right">
        <button type="button" class="btn btn-success" id="btn_new_visit" title="ลงทะเบียน" rel="tooltip">
            <i class="icon-plus-sign"></i>
        </button>
        <button type="button" class="btn btn-default" id="btn_refresh_visit" title="รีเฟรช" rel="tooltip">
            <i class="icon-refresh"></i>
        </button>
    </div>
</form>
</div>
<table class="table table-striped table-hover" id="tbl_service_list">
    <thead>
    <tr>
        <th>HN</th>
        <th>ชื่อ - สกุล</th>
        <th>อายุ (ปี)</th>
        <th>สิทธิการรักษา</th>
        <th>อาการสำคัญ</th>
        <th>คลินิค</th>
        <th>การวินิจฉัย</th>
        <th>ผู้ให้บริการ</th>
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
        <td>...</td>
        <td>...</td>
    </tr>
    </tbody>
</table>
    <ul class="pagination" id="main_paging"></ul>
<!-- modal new -->
<div class="modal fade" id="mdl_new_service">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file-alt"></i> ลงทะเบียนส่งตรวจ</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_search_person">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-search"></i> ค้นหาผู้ป่วย</h4>
            </div>
            <div class="modal-body">
                <form action="#" class="form-inline form-actions">
                    <input type="hidden" id="txt_reg_person_search_by">
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <div class="controls">
                                    <div class="input-append">
                                        <input type="text" class="input-xlarge" id="txt_reg_search_person">
                                        <div class="btn-group">
                                            <button class="btn btn-info" id="btn_do_search_person" type="button"><i class="icon-search"></i> ค้นหา</button>
                                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="javascript:void(0);" id="btn_reg_search_person_by_name"><i class="icon-user"></i> ค้นจากชื่อ - สกุล</a></li>
                                                <li><a href="javascript:void(0);" id="btn_reg_search_person_by_cid"><i class="icon-barcode"></i> ค้นจากเลขบัตรประชาชน (CID)</a></li>
                                                <li><a href="javascript:void(0);" id="btn_reg_search_person_by_hn"><i class="icon-bookmark"></i> ค้นจาก HN</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="div_search_person_result">
                    <table class="table table-striped" id="table_search_person_result_list">
                        <thead>
                        <tr>
                            <th>HN</th>
                            <th>เลขบัตรประชาชน</th>
                            <th>ชื่อ - สกุล</th>
                            <th>วันเกิด</th>
                            <th>อายุ (ปี)</th>
                            <th>ที่อยู่</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<!-- end person -->
<!-- <script type="text/javascript" src="{{ base_url }}assets/apps/js/apps.services.js"></script> -->
<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.services.js');
</script>
