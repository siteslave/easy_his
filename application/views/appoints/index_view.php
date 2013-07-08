<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li><a href="<?php echo site_url('services');?>">การให้บริการ</a></li>
    <li class="active">ทะเบียนนัด</li>
</ul>
<div class="navbar">
    <form action="#" class="navbar-form form-inline">
        <input type="hidden" id="txt_status" value="0">
        <label for="txt_date">วันที่</label>
        <input style="width: 150px;" id="txt_date" type="text" data-type="date" placeholder="dd/mm/yyyy">
        <label for="txt_date">แผนก</label>
        <select style="width: 250px;" id="sl_clinic">
            <option value="">--- ทั้งหมด ---</option>
            <?php
            foreach ($clinics as $t){
                echo '<option value="'.$t->id.'">' . $t->name . '</option>';
            }
            ?>
        </select>
        <div class="btn-group" data-toggle="buttons-radio">
            <button type="button" data-name="btn_do_filter" data-id="0" class="btn btn-success"><i class="icon-refresh"></i> ทั้งหมด</button>
            <button type="button" data-name="btn_do_filter" data-id="1" class="btn btn-default"><i class="icon-check"></i> มาตามนัด</button>
            <button type="button" data-name="btn_do_filter" data-id="2" class="btn btn-success"><i class="icon-minus-sign"></i> ไม่มาตามนัด</button>
        </div>

        <div class="btn-group pull-right">
<!--
            <button class="btn btn-success" id="btn_show_visit">
                <i class="icon-plus-sign"></i> ลงทะเบียน
            </button>-->
            <button class="btn btn-primary" id="btn_show_print">
                <i class="icon-print"></i> พิมพ์
            </button>
        </div>
    </form>
</div>

<table class="table table-striped table-hover" id="tbl_appoint_list">
    <thead>
        <tr>
            <th>สถานะ</th>
            <th>วันที่นัด</th>
            <th>เวลา</th>
            <th>HN</th>
            <th>ชื่อ - สกุล</th>
            <th>ประเภทการนัด</th>
            <th>คลินิค/แผนก</th>
            <th>ผู้นัด (Provider)</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="9">กรุณาเลือกเงื่อนไขการค้นหา</td>
    </tr>
    </tbody>
</table>

<ul class="pagination pagination-centered" id="main_paging"></ul>

<div class="modal fade" id="mdl_appoint">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-check"></i> ข้อมูลการนัด</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_select_visit">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">เลือกรายการรับบริการ</h4>
            </div>
            <div class="modal-body" style="height: 250px;">
                <div class="navbar">
                    <form class="form-inline navbar-form">
                        <input type="hidden" id="txt_search_visit_by" value="0">
                        <label>HN</label>
                        <input type="text" style="width: 250px;" id="txt_query_visit" placeholder="พิมพ์ชื่อ-สกุล, HN หรือ เลขบัตรประชาชน"
                               title="พิมพ์ชื่อ-สกุล, HN หรือ เลขบัตรประชาชน" rel="tooltip" autocomplete="off">
                        <div class="btn-group">
                            <button class="btn btn-primary" id="btn_do_search_visit"><i class="icon-search"></i> ค้นหา</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" data-name="btn_set_search_visit_filter" data-value="0"><i class="icon-qrcode"></i> ค้นจาก เลขบัตรประชาชน</a></li>
                                <li><a href="javascript:void(0);" data-name="btn_set_search_visit_filter" data-value="1"><i class="icon-th-list"></i> ค้นจาก HN</a></li>
                                <li><a href="javascript:void(0);" data-name="btn_set_search_visit_filter" data-value="2"><i class="icon-list"></i> ค้นจาก ชื่อ - สกุล</a></li>
                            </ul>
                        </div>
                    </form>
                </div>
                <table class="table table-striped" id="tbl_search_visit_result">
                    <thead>
                    <tr>
                        <th>VN</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>แผนก</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="5">...</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>

<div class="modal hide fade" id="mdl_update">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>แก้ไขข้อมูลการนัด</h3>
    </div>
    <div class="modal-body">
        <form class="form-inline">
            <form action="#">
                <input type="hidden" id="txt_update_id" value="">
                <legend>ข้อมูลการนัด</legend>
                <div class="row-fluid">
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label" for="txt_update_date">วันที่นัด</label>
                            <input class="input-small" id="txt_update_date" type="text" disabled>
                        </div>
                    </div>
                    <div class="span1">
                        <div class="control-group">
                            <label class="control-label" for="txt_update_time">เวลา</label>
                            <div class="controls">
                                <input type="text" data-type="time" id="txt_update_time" class="input-mini">
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="sl_update_clinic">แผนกที่นัด</label>
                            <div class="controls">
                                <select class="input-xlarge" id="sl_update_clinic">
                                    <?php
                                    foreach ($clinics as $t){
                                        echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="sl_update_aptype">ประเภทกิจกรรมนัด</label>
                            <div class="controls">
                                <select name="" id="sl_update_aptype" disabled="disabled" style="background-color: white;">
                                    <?php
                                    foreach ($aptypes as $t){
                                        echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row-fluid">
                    <div class="span10">
                        <div class="control-group">
                            <label class="control-label" for="">การวินิจฉัย</label>
                        </div>
                        <input type="text" id="txt_update_diag_code" class="input-mini"placeholder="พิมพ์รหัส...">
                        <input type="text" id="txt_update_diag_name" class="input-xxlarge uneditable-input"  disabled="disabled" placeholder="...">
                    </div>
                </div>
            </form>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success" id="btn_do_update"><i class="icon-save"></i> ปรับปรุงข้อมูล</a>
        <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off"></i> ปิดหน้าต่าง</a>
    </div>
</div>


<div class="modal fade" id="mdl_new_service">
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file-alt"></i> ลงทะเบียนส่งตรวจ</h4>
            </div>
            <div class="modal-body"></div>
           <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
            </div>-->
        </div>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.appointments.index.js');
</script>


