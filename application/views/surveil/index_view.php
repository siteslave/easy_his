<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">บันทึกข้อมูลระบาดวิทยา (506)</li>
</ul>
<form action="#" class="well well-small form-inline">

    <label for="txt_query_date">วันที่</label>
    <div class="input-append date" data-name="datepicker">
        <input class="input-small" id="txt_query_date" type="text" value="<?php echo date('d/m/Y'); ?>" disabled>
        <span class="add-on"><i class="icon-th"></i></span>
    </div>
    <button type="buttton" id="btn_get_list" class="btn btn-info"
            rel="tooltip" title="เลือกวันที่รับบริการ เพื่อค้นหาผู้ป่วยที่มีการวินิจฉัยตรงกับงานระบาดวิทยา">
        <i class="icon-search"></i>
    </button>
</form>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
    <tr>
        <th>วันที่</th>
        <th>HN</th>
        <th>CID</th>
        <th>ชื่อ - สกุล</th>
        <th>รหัสวินิฉัย</th>
        <th>รหัส 506</th>
        <th>สภาพผู้ป่วย</th>
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

<div class="modal hide fade" id="mdl_entry">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>บันทึกข้อมูลระบาดวิทยา</h4>
    </div>
    <div class="modal-body">
        <form class="form-inline well well-small">
            <input type="hidden" id="txt_vn" value="" />

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

        <legend>ข้อมูลการเจ็บป่วย</legend>
        <div class="row-fluid">
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_illdate">วันที่เริ่มป่วย</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txt_illdate" type="text" value="<?php echo date('d/m/Y'); ?>" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span10">
                <div class="control-group">
                    <label class="control-label" for="sl_nofpcause">การวินิจฉัย</label>
                    <div class="controls">
                        <input type="text" id="txt_diag_code" class="input-mini uneditable-input" disabled="disabled" />
                        <input type="text" id="txt_diag_name" disabled="disabled" class="input-xxlarge uneditable-input"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_syndrome">กลุ่มอาการ</label>
                    <div class="controls">
                        <select id="sl_syndrome">
                            <option value="">--</option>
                            <?php
                            foreach($syndromes as $r)
                            {
                                echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_506">รหัส 506</label>
                    <div class="controls">
                        <select id="sl_506">
                            <option value="">--</option>
                            <?php
                            foreach($groups as $r)
                            {
                                echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_organism">ชนิดของเชื้อ</label>
                    <div class="controls">
                        <select id="sl_organism">
                            <option value="">--</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="sl_complication">สาเหตุการป่วย</label>
                    <div class="controls">
                        <select id="sl_complication" class="input-xlarge">
                            <option value="">--</option>
                            <?php
                            foreach($complications as $r)
                            {
                                echo '<option value="'.$r->code.'">['.$r->code.'] ' . $r->name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_ptstatus">สภาพผู้ป่วย</label>
                    <div class="controls">
                        <select id="sl_ptstatus">
                            <option value="">--</option>
                            <option value="1">[1] หาย</option>
                            <option value="2">[2] ตาย</option>
                            <option value="3">[3] ยังรักษาอยู่</option>
                            <option value="9">[9] ไม่ทราบ</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_date_death">วันที่เสียชีวิต</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txt_date_death" type="text" value="" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <legend>ที่อยู่ขณะป่วย</legend>
        <div class="row-fluid">
            <div class="span1">
                <div class="control-group">
                    <label class="control-label" for="txt_address">เลขที่</label>
                    <div class="controls">
                        <input type="text" class="input-mini" id="txt_address" placeholder="..">
                    </div>
                </div>
            </div>
            <div class="span1">
                <div class="control-group">
                    <label class="control-label" for="txt_moo">หมู่</label>
                    <div class="controls">
                        <input type="text" rel="tooltip" title="ระบุตัวเลข 2 หลัก เช่น 00, 01, 02" class="input-mini" data-type="number" id="txt_moo" placeholder="00">
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_province">จังหวัด</label>
                    <div class="controls">
                        <select id="sl_province">
                            <option value="99">ไม่ทราบ</option>
                            <?php foreach($provinces as $t) echo '<option value="'.$t->code.'">'.$t->name.'</option>'; ?>
                        </select>

                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_ampur">อำเภอ</label>
                    <div class="controls">
                        <select id="sl_ampur" rel="tooltip" title="กรุณาเลือกจังหวัดก่อน"></select>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="sl_tambon">ตำบล</label>
                    <div class="controls">
                        <select id="sl_tambon" rel="tooltip" title="กรุณาเลือกอำเภอก่อน"></select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txt_school_class">ชั้นเรียน</label>
                    <div class="controls">
                        <input type="text" id="txt_school_class" class="input-medium"/>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_school_name">โรงเรียน</label>
                    <div class="controls">
                        <input type="text" id="txt_school_name" class="input-xlarge"/>
                    </div>
                </div>
            </div>
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_latitude">Latitude</label>
                    <div class="controls">
                        <input type="text" id="txt_latitude" class="input-small"/>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="txt_longitude">Longitude</label>
                    <div class="controls">
                        <div class="input-append">
                            <input class="input-small" id="txt_longitude" type="text">
                            <button class="btn" type="button"><i class="icon-map-marker"></i></button>
                        </div>
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
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.surveil.js');
</script>


