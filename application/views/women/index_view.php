<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียนหญิงวัยเจริญพันธุ์</li>
</ul>
<form action="#" class="well form-inline">
    <label for="sl_village">หมู่บ้าน</label>
    <select class="input-xlarge" id="sl_village">
        <option value="00000000">---</option>
        <?php
        foreach ($villages as $r){
            echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
        }
        ?>
    </select>
    <!--
    บ้านเลขที่
    <select id="sl_house" class="input-medium"></select>
    -->
    <button type="button" class="btn btn-info" id="btn_do_get_list"><i class="icon-search"></i> แสดงรายการ</button>
    <div class="btn-group pull-right">
        <button type="button" id="btn_search" class="btn"><i class="icon-search"></i> ค้นหา</button>
        <button type="button" id="btn_register" class="btn btn-success"><i class="icon-plus-sign"></i> ลงทะเบียน</button>
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
        <th>วันที่ลงทะเบียน</th>
        <th>ประเภทคความพิการ</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="8">...</td>
    </tr>
    </tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<div class="modal hide fade" id="mdl_search_person">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ค้นหา</h3>
    </div>
    <div class="modal-body" style="height: 250px;">
        <form class="form-inline well">
            <input type="hidden" data-name="txt_search_person_filter" value="0">
            <label>คำค้นหา</label>
            <input type="text" class="input-xlarge" id="txt_query_person">
            <div class="btn-group">
                <button type="button" class="btn btn-info" id="btn_do_search_person"><i class="icon-search"></i> ค้นหา</button>
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
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>

<div class="modal hide fade" id="mdl_register">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ข้อมูลการลงทะเบียน</h3>
    </div>
    <div class="modal-body">
        <form class="form-inline well">
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
            <button type="button" id="btn_search_person" class="btn btn-info"><i class="icon-search"></i></button>
        </form>

        <legend>ข้อมูลความพิการ</legend>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txt_did">เลขทะเบียนผู้พิการ</label>
                    <div class="controls">
                        <input type="text" class="input-medium" id="txt_did">
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="sl_disb_types">ประเภทความพิการ</label>
                    <div class="controls">
                        <select id="sl_disb_types" class="input-xlarge">
                            <option value="">--</option>
                            <?php foreach($disabilities_types as $t) echo '<option value="'.$t->id.'">'.$t->name.'</option>'; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_disp_cause">สาเหตุความพิการ</label>
                    <div class="controls">
                        <select id="sl_disp_cause" class="input-xlarge">
                            <option value="">--</option>
                            <option value="1">ความพิการแต่กำเนิด</option>
                            <option value="2">ความพิการจากการบาดเจ็บ</option>
                            <option value="3">ความพิการจากโรค</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span10">
                <div class="control-group">
                    <label class="control-label" for="txt_icdcode">โรคหรือการบาดเจ็บที่เป็นสาเหตุ</label>
                    <div class="controls">
                        <input type="text" class="input-mini" id="txt_icdcode" placeholder="...">
                        <input type="text" class="input-xxlarge uneditable-input" id="txt_icdname" placeholder="พิมพ์ชื่อหรือรหัสในช่อง รหัส" disabled="disabled">
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <label class="control-label" for="txt_detect_date">วันที่ตรวจพบ</label>
                <div class="controls">
                    <div class="input-append date" data-name="datepicker">
                        <input class="input-small" id="txt_detect_date" type="text" disabled>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="span3">
                <label class="control-label" for="txt_disab_date">วันที่เริ่มมีความพิการ</label>
                <div class="controls">
                    <div class="input-append date" data-name="datepicker">
                        <input class="input-small" id="txt_disab_date" type="text" disabled>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" id="btn_save_disb" class="btn btn-success"><i class="icon-save"></i> บันทึกข้อมูล</a>
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.women.js');
</script>

