<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียนหญิงวัยเจริญพันธุ์</li>
</ul>
<form action="#" class="well well-small form-inline">
    <label for="sl_year">ปีงบประมาณ</label>
    <select id="sl_year" class="input-small">
        <option value="2013">2556</option>
        <option value="2014">2557</option>
    </select>
    <label for="sl_village">หมู่บ้าน</label>
    <select class="input-xlarge" id="sl_village">
        <option value="">---</option>
        <?php
        foreach ($villages as $r){
            echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
        }
        ?>
    </select>
    <button type="button" class="btn btn-info" id="btn_do_get_list"><i class="icon-search"></i></button> |
    ค้นหา <input type="text" class="input-xlarge" id="txt_query" placeholder="พิมพ์ HN หรือ เลขบัตรประชาชน หรือ ชื่อ-สกุล" />
    <button type="button" id="btn_do_search" class="btn btn-info"><i class="icon-search"></i></button>
    <div class="btn-group pull-right">
        <button type="button" id="btn_chart" rel="tooltip" title="ดูผลงานการปฏิบัติงาน" class="btn"><i class="icon-bar-chart"></i></button>
        <button type="button" id="btn_refresh" rel="tooltip" title="รีเฟรชข้อมูลใหม่" class="btn btn-success"><i class="icon-refresh"></i></button>
    </div>

</form>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
    <tr>
        <th>HN</th>
        <th>CID</th>
        <th>ชื่อ - สกุล</th>
        <th>วันเกิด</th>
        <th>อายุ (ปี)</th>
        <th>สถานะภาพ</th>
        <th>จำนวนบุตร</th>
        <th>วิธีคุมกำเนิด</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="9">...</td>
    </tr>
    </tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<div class="modal hide fade" id="mdl_screen">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>บันทึกข้อมูลการสำรวจหญิงวัยเจริญพันธุ์</h3>
    </div>
    <div class="modal-body">
        <form class="form-inline well well-small">
            <label>ชื่อ - สกุล</label>
            <input type="text" class="input-medium" disabled="disabled" id="txt_fullname">
            <label>HN</label>
            <input type="text" class="input-small uneditable-input" disabled="disabled" id="txt_hn">
            <label>CID</label>
            <input type="text" class="input-medium uneditable-input" disabled="disabled" id="txt_cid">
            <label>วันเกิด</label>
            <input type="text" class="input-small uneditable-input" disabled="disabled" id="txt_birthdate">
            <label>อายุ (ปี)</label>
            <input type="text" class="input-mini uneditable-input" disabled="disabled" id="txt_age">
        </form>

        <legend>ข้อมูลการสำรวจ</legend>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="sl_fptype">วิธีการคุมกำเนิด</label>
                    <div class="controls">
                        <select id="sl_fptype" class="input-xlarge">
                            <option value="">--</option>
                            <?php foreach($fptypes as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_nofpcause">สาเหตุที่ไม่คุมกำเนิด</label>
                    <div class="controls">
                        <select id="sl_nofpcause" class="input-xlarge">
                            <option value="">--</option>
                            <option value="1">ต้องการมีบุตร</option>
                            <option value="2">หมันธรรมชาติ</option>
                            <option value="3">อื่นๆ</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txt_icdcode">จำนวนบุตรทั้งหมดที่เคยมี</label>
                    <div class="controls">
                        <input type="text" class="input-mini" data-type="number" id="txt_totalson" placeholder="0">
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_icdcode">จำนวนบุตรมีชีวิต</label>
                    <div class="controls">
                        <input type="text" class="input-mini" data-type="number" id="txt_numberson" placeholder="0">
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_icdcode">จำนวนบุตรเสียชีวิต</label>
                    <div class="controls">
                        <input type="text" class="input-mini" data-type="number" id="txt_stillbirth" placeholder="0">
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txt_icdcode">จำนวนการแท้งบุตร</label>
                    <div class="controls">
                        <input type="text" class="input-mini" data-type="number" id="txt_abortion" placeholder="0">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" id="btn_save" class="btn btn-success"><i class="icon-save"></i> บันทึกข้อมูล</a>
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>


<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.women.js');
</script>


