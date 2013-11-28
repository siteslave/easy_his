<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">ทะเบียน EPI</li>
</ul>
<div class="navbar navbar-default">
    <form action="#" class="navbar-form">
        <select id="sl_village" style="width: 350px;" class="form-control">
            <option value="">-- เลือกหมู่บ้าน [ทั้งหมด] --</option>
            <?php
            foreach ($villages as $r){
                echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
            }
            ?>
        </select>
        <div class="btn-group">
            <button type="button" class="btn btn-primary" id="btn_fillter">
                <i class="fa fa-search"></i> แสดง</button>
            <button rel="tooltip" title="รีเฟรช" type="button" id="btn_refresh" class="btn btn-default">
                <i class="fa fa-refresh"></i> รีเฟรช</button>
            <button rel="tooltip" title="ลงทะเบียนรายใหม่" type="button" id="btn_register" class="btn btn-success">
                <i class="fa fa-plus-circle"></i> ลงทะเบียน</button>
        </div>

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
    <div class="modal-dialog" style="width: 680px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-search"></i>
                    ค้นหาข้อมูลประชากร
                </h4>
            </div>
            <div class="modal-body">

                <div class="navbar">
                    <form action="#" class="navbar-form">
                        <input id="txt_search_query" type="hidden" style="width: 400px;">
                        <button type="button" class="btn btn-success" id="btn_do_register_epi">
                            <span class="fa fa-search"></span> ลงทะเบียน
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="mdl_vaccines">
    <div class="modal-dialog" style="width: 960px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-puzzle-piece"></i> บันทึกข้อมูลการให้วัคซีน</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-power-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.epi.index.js');
</script>


