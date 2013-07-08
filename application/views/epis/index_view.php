<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">ทะเบียน EPI</li>
</ul>
<div class="navbar">
    <form action="#" class="navbar-form">
        <select id="sl_village" style="width: 350px;">
            <option value="">-- เลือกหมู่บ้าน [ทั้งหมด] --</option>
            <?php
            foreach ($villages as $r){
                echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
            }
            ?>
        </select>
        <button type="button" class="btn btn-primary" id="btn_fillter"><i class="icon-search"></i> แสดง</button>
        <button rel="tooltip" title="รีเฟรช" type="button" id="btn_refresh" class="btn btn-default pull-right"><i class="icon-refresh"></i></button>
        <button rel="tooltip" title="ลงทะเบียนรายใหม่" type="button" id="btn_register" class="btn btn-success"><i class="icon-plus-sign"></i> ลงทะเบียน</button>
    </form>
</div>

<table class="table table-striped table-hover" id="tbl_epi_list">
    <thead>
    <tr>
        <th>HN</th>
        <th>เลขบัตรประชาชน</th>
        <th>วันที่ลงทะเบียน</th>
        <th>ชื่อ - สกุล</th>
        <th>วันเกิด</th>
        <th>อายุ (ปี)</th>
        <th>กราฟ</th>

        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="7">กรุณากำหนดเงื่อนไขการแสดงข้อมูล</td>
    </tr>
    </tbody>
</table>

<ul class="pagination pagination-centered" id="main_paging"></ul>

<div class="modal fade" id="mdl_search_person">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class="icon-search"></i>
                    ค้นหาข้อมูลประชากร
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txt_search_person_filter" value="0" />
                <div class="navbar">
                    <form action="#" class="navbar-form">
                        <input id="txt_search_query" type="text" autocomplete="off" placeholder="พิมพ์คำที่ต้องการค้นหา เช่น เลขบัตรประชาชน, HN, ชื่อ-สกุล..."
                               title="พิมพ์คำที่ต้องการค้นหา เช่น เลขบัตรประชาชน, HN, ชื่อ-สกุล..." rel="tooltip" style="width: 400px;">
                        <div class="btn-group">
                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" rel="tooltip" title="ระบุเงื่อนไขในการค้นหา">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" data-name="btn_search_person_fillter" data-value="0">ค้นจาก เลขบัตรประชาชน</a></li>
                                <li><a href="#" data-name="btn_search_person_fillter" data-value="1">ค้นจาก HN</a></li>
                                <li><a href="#" data-name="btn_search_person_fillter" data-value="2">ค้นจาก ชื่อ - สกุล</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-primary" rel="tooltip" title="ค้นหา" id="btn_do_search_person"><i class="icon-search"></i> ค้นหา</button>
                    </form>
                </div>
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
    </div>
</div>


<div class="modal fade" id="mdl_vaccines">
    <div class="modal-dialog" style="width: 960px; left: 35%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-pushpin"></i> บันทึกข้อมูลการให้วัคซีน</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.epi.index.js');
</script>


