<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียนฝากครรภ์</li>
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

<div class="modal hide fade" id="mdl_labor">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ข้อมูลการคลอด</h3>
    </div>
    <div class="modal-body">
        <blockquote>
            บันทึกข้อมูลการคลอด
        </blockquote>
        <form class="form-inline well">
            <label>HN</label>
            <input type="text" class="input-small uneditable-input" disabled="disabled">
            <label>CID</label>
            <input type="text" class="input-medium uneditable-input" disabled="disabled">
            <label>ชื่อ - สกุล</label>
            <input type="text" class="input-medium uneditable-input" disabled="disabled">
            <label>วันเกิด</label>
            <input type="text" class="input-small uneditable-input" disabled="disabled">
            <label>อายุ (ปี)</label>
            <input type="text" class="input-mini uneditable-input" disabled="disabled">
        </form>

        <form action="#">
            <legend>ข้อมูลการคลอด</legend>
            <div class="row-fluid">
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="sl_anc_no">ครรภ์ที่</label>
                        <div class="controls">
                            <select id="sl_anc_no" class="input-small">
                                <option value="">ระบุ..</option>
                                <?php
                                for($i = 1; $i<=10; $i++)
                                {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }

                                ?>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_reg_service_date">LMP</label>
                        <div class="controls">
                            <div class="input-append date" data-name="datepicker">
                                <input class="input-small" id="txt_reg_service_date" type="text" disabled>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_reg_service_date">EDC (กำหนดคลอด)</label>
                        <div class="controls">
                            <div class="input-append date" data-name="datepicker">
                                <input class="input-small" id="txt_reg_service_date" type="text" disabled>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="sl_anc_no">สถานะปัจจุบัน</label>
                        <div class="controls">
                            <select id="sl_anc_no" class="input-medium">
                                <option value="">ยังไม่คลอด</option>
                                <option value="">คลอดแล้ว</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="txt_reg_service_date">วันที่คลอด</label>
                        <div class="controls">
                            <div class="input-append date" data-name="datepicker">
                                <input class="input-small" id="txt_reg_service_date" type="text" disabled>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span10">
                    <div class="control-group">
                        <label class="control-label" for="txt_reg_service_date">ผลวินิจฉัยการคลอด</label>
                        <div class="controls">
                            <input type="text" class="input-mini" id="" placeholder="...">
                            <input type="text" class="input-xxlarge uneditable-input" disabled="disabled" id="" placeholder="...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3">
                    <label class="control-label" for="txt_reg_service_date">สถานที่คลอด</label>
                    <div class="controls">
                        <select class="input-medium">
                            <option value="">--</option>
                            <option value="1">โรงพยาบาล</option>
                            <option value="2">สถานีอนามัย</option>
                            <option value="3">บ้าน</option>
                            <option value="4">ระหว่างทาง</option>
                            <option value="5">อื่นๆ</option>
                        </select>
                    </div>
                </div>
                <div class="span8">
                    <div class="control-group">
                        <label class="control-label" for="txt_reg_service_date">สถานพยาบาลที่คลอด</label>
                        <div class="controls">
                            <input type="text" class="input-mini" id="" placeholder="...">
                            <input type="text" class="input-xlarge uneditable-input" disabled="disabled" id="" placeholder="...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3">
                    <label class="control-label" for="txt_reg_service_date">วิธีการคลอด</label>
                    <div class="controls">
                        <select class="input-medium">
                            <option value="">--</option>
                            <option value="1">Normal</option>
                            <option value="2">Cesarean</option>
                            <option value="3">Vacuum</option>
                            <option value="4">Forceps</option>
                            <option value="5">ท่ากัน</option>
                            <option value="6">Abortion</option>
                        </select>
                    </div>
                </div>
                <div class="span4">
                    <label class="control-label" for="txt_reg_service_date">ประเภทผู้ทำคลอด</label>
                    <div class="controls">
                        <select class="input-xlarge">
                            <option value="">--</option>
                            <option value="1">แพทย์</option>
                            <option value="2">พยาบาล</option>
                            <option value="3">จนท.สาธารณสุข (ที่ไม่ใช่แพทย์ พยาบาล)</option>
                            <option value="4">ผดุงครรภ์โบราณ</option>
                            <option value="5">คลอดเอง</option>
                            <option value="6">อื่นๆ</option>
                        </select>
                    </div>
                </div>
                <div class="span1">
                    <label class="control-label" for="txt_reg_service_date">เกิดมีชีพ</label>
                    <div class="controls">
                        <input type="text" class="input-mini" data-type="number">
                    </div>
                </div>
                <div class="span1">
                    <label class="control-label" for="txt_reg_service_date">เกิดไร้ชีพ</label>
                    <div class="controls">
                        <input type="text" class="input-mini" data-type="number">
                    </div>
                </div>
            </div>
        </form>

    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success"><i class="icon-plus-sign icon-white"></i> บันทึกข้อมูล</a>
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.pregnancies.index.js');
</script>


