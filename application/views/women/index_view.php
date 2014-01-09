<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">ทะเบียนหญิงวัยเจริญพันธุ์</li>
</ul>
<div class="navbar navbar-default">
    <form action="#" class="navbar-form form-inline">
        <label for="sl_year">ปีงบประมาณ</label>
        <select id="sl_year" style="width: 100px;" class="form-control">
<!--            <option value="2013">2556</option>-->
            <option value="2014">2557</option>
            <option value="2015">2558</option>
        </select>
        <label for="sl_village">หมู่บ้าน</label>
        <select style="width: 300px;" id="sl_village" class="form-control">
            <option value="">---</option>
            <?php
            foreach ($villages as $r){
                echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
            }
            ?>
        </select>
        <button type="button" class="btn btn-primary" id="btn_do_get_list">
            <i class="fa fa-search"></i> ค้นหา
        </button> |
        ค้นหา
        <input type="text" style="width: 250px;" id="txt_query" />
        <button type="button" id="btn_do_search" class="btn btn-primary">
            <i class="fa fa-search"></i>
        </button>
        <div class="btn-group pull-right">
            <button type="button" id="btn_chart" rel="tooltip" title="ดูผลงานการปฏิบัติงาน"
                    class="btn btn-default"><i class="fa fa-bar-chart-o"></i></button>
            <button type="button" id="btn_refresh" rel="tooltip" title="รีเฟรชข้อมูลใหม่"
                    class="btn btn-success"><i class="fa fa-refresh"></i></button>
        </div>

    </form>
</div>


<table class="table table-striped table-hover" id="tbl_list">
    <thead>
    <tr>
        <th>HN</th>
        <th>เลขบัตรประชาชน</th>
        <th>ชื่อ - สกุล</th>
        <th>วันเกิด</th>
        <th>อายุ (ปี)</th>
        <th>สถานะภาพ</th>
        <th>จำนวนบุตร</th>
        <th>วิธีคุมกำเนิด</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="9">...</td>
    </tr>
    </tbody>
</table>

<ul class="pagination pagination-centered" id="main_paging"></ul>

<div class="modal fade" id="mdl_screen">
    <div class="modal-dialog" style="width: 960px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">บันทึกข้อมูลการสำรวจหญิงวัยเจริญพันธุ์</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline well well-small">
                    <div class="row">
                        <div class="col-lg-2">
                            <label>HN</label>
                            <input type="text" class="form-control" disabled="disabled" id="txt_hn">
                        </div>
                        <div class="col-lg-3">
                            <label>ชื่อ - สกุล</label>
                            <input type="text" class="form-control" disabled="disabled" id="txt_fullname">
                        </div>
                        <div class="col-lg-3">
                            <label>เลขบัตรประชาชน</label>
                            <input type="text" class="form-control" disabled="disabled" id="txt_cid">
                        </div>
                        <div class="col-lg-2">
                            <label>วันเกิด</label>
                            <input type="text" class="form-control" disabled="disabled" id="txt_birthdate">
                        </div>
                        <div class="col-lg-2">
                            <label>อายุ (ปี)</label>
                            <input type="text" class="form-control" disabled="disabled" id="txt_age">
                        </div>
                    </div>
                </form>

                <legend>ข้อมูลการสำรวจ</legend>
                <div class="row">
                    <div class="col-lg-3">
                        <label class="control-label" for="sl_fptype">วิธีการคุมกำเนิด</label>
                        <select id="sl_fptype" class="form-control">
                            <option value="">--</option>
                            <?php foreach($fptypes as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label class="control-label" for="sl_nofpcause">สาเหตุที่ไม่คุมกำเนิด</label>
                        <select id="sl_nofpcause" class="form-control">
                            <option value="">--</option>
                            <option value="1">ต้องการมีบุตร</option>
                            <option value="2">หมันธรรมชาติ</option>
                            <option value="3">อื่นๆ</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label class="control-label" for="txt_icdcode">บุตรทั้งหมดที่เคยมี</label>
                        <input type="text" class="form-control" data-type="number" id="txt_totalson" placeholder="0">
                    </div>
                    <div class="col-lg-2">
                        <label class="control-label" for="txt_icdcode">จำนวนบุตรมีชีวิต</label>
                        <input type="text" class="form-control" data-type="number" id="txt_numberson" placeholder="0">
                    </div>
                    <div class="col-lg-2">
                        <label class="control-label" for="txt_icdcode">จำนวนบุตรเสียชีวิต</label>
                        <input type="text" class="form-control" data-type="number" id="txt_stillbirth" placeholder="0">
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label" for="txt_icdcode">จำนวนการแท้งบุตร</label>
                        <input type="text" class="form-control" data-type="number" id="txt_abortion" placeholder="0">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" id="btn_save" class="btn btn-success"><i class="fa fa-save"></i> บันทึกข้อมูล</a>
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-power-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.women.js');
</script>


