<!--
 * Created by Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 11/3/2556 10:52 น.
-->
<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียน Refer</li>
</ul>
<form action="#" class="well form-inline">
    <label class="control-label" for="tboSearch">ค้นหา</label>
    <div class="input-append">
        <input type="text" id="tboSearch" placeholder="ค้นหา" class="input-medium">
        <div class="btn-group">
            <button class="btn btn-info" id="btnSearch"><i class="icon-search icon-white"></i>ค้นหา</button>
            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter1" data-value="0"><i class="icon-qrcode"></i> ค้นจาก เลขบัตรประชาชน</a></li>
                <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter1" data-value="1"><i class="icon-th-list"></i> ค้นจาก HN</a></li>
                <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter1" data-value="2"><i class="icon-list"></i> ค้นจาก ชื่อ - สกุล</a></li>
            </ul>
        </div>
    </div>

    <label class="control-label">ค้นหาจากวันที่</label>
    <div class="input-append date" data-name="datepicker">
        <input type="text" id="dtpStart" class="input-small" value="<? echo date('d/m/Y'); ?>">
        <span class="add-on"><i class="icon-calendar"></i></span>
    </div>
    <label class="control-label">ถึงวันที่</label>
    <div class="input-append date" data-name="datepicker">
        <input type="text" id="dtpStop" class="input-small" value="<? echo date('d/m/Y'); ?>">
        <span class="add-on"><i class="icon-calendar"></i></span>
    </div>
    <button class="btn btn-success" id="btnSearchByDate"><i class="icon-search icon-white"></i>ค้นหาจากวันที่</button>

    <div class="btn-group pull-right">
        <button type="button" id="btnShowRegisterForm" class="btn btn-success"><i class="icon-plus-sign icon-white"></i> ส่งตัวผู้ป่วย</button>
    </div>
</form>

<!-- Begin Tab menu -->
<ul class="nav nav-tabs" id="mainTab">
    <li class="active"><a href="#tab1" data-toggle="tab">Refer IN</a></li>
    <li><a href="#tab2" data-toggle="tab">Refer OUT</a></li>
    <li><a href="#tab3" data-toggle="tab">Consult Center</a></li>
</ul>
<!-- End Tab menu -->
<!-- Begin Tab Content -->
<div class="tab-content">
    <div class="tab-pane active" id="tab1"></div>
    <div class="tab-pane" id="tab2"></div>
    <div class="tab-pane" id="tab3"></div>
</div>
<!-- End Tab Content -->

<div class="modal hide fade" id="mdlRegister">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ส่งตัวผู้ป่วย</h3>
    </div>
    <div class="modal-body" style="height: 250px;">
        <form class="form-inline well">
            <input type="hidden" data-name="txt_search_person_filter2" value="0">
            <label>คำค้นหา</label>
            <input type="text" class="input-xlarge" id="txt_query_person" placeholder="ระบุคำค้นหา">
            <div class="btn-group">
                <button type="button" class="btn btn-info" id="btn_do_search_person"><i class="icon-search icon-white"></i> ค้นหา</button>
                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter2" data-value="0"><i class="icon-qrcode"></i> ค้นจาก เลขบัตรประชาชน</a></li>
                    <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter2" data-value="1"><i class="icon-th-list"></i> ค้นจาก HN</a></li>
                    <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter2" data-value="2"><i class="icon-list"></i> ค้นจาก ชื่อ - สกุล</a></li>
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
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i>ปิดหน้าต่าง</button>
    </div>
</div>

<div class="modal hide fade" id="mdlServiceList">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ข้อมูลบริการ</h3>
    </div>
    <div class="modal-body" style="height: 250px;">
        <table class="table table-striped" id="tblServiceList">
            <thead>
            <tr>
                <th>VN</th>
                <th>วันที่รับบริการ</th>
                <th>มาด้วยอาการ</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="btnCancelServiceList"><i class="icon-off icon-white"></i>ยกเลิก</button>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.refer.index.js');
</script>