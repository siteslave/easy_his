<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">ทะเบียนผู้เสียชีวิต</li>
</ul>
<div class="navbar navbar-default">
    <form action="#" class="navbar-form form-inline">
        <label for="txt_query">ค้นหา</label>
        <input style="width: 300px;" id="txt_query" type="hidden" />
        <button class="btn btn-primary" id="btn_search">
            <i class="fa fa-search"></i> ค้นหา
        </button>

        <div class="btn-group pull-right">
            <button class="btn btn-success" id="btn_register">
                <i class="fa fa-plus-circle"></i> ลงทะเบียน
            </button>
            <button class="btn btn-default" id="btn_refresh">
                <i class="fa fa-refresh"></i> รีเฟรช
            </button>
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
            <th>วันที่เสียชีวิต</th>
            <th>สาเหตุการเสียชีวิต</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="8">ไม่พบรายการ</td>
    </tr>
    </tbody>
</table>

<ul class="pagination pagination-centered" id="main_paging"></ul>

<!-- register service -->
<div class="modal fade" id="mdl_register">
    <div class="modal-dialog" style="width: 960px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-briefcase"></i> ลงทะเบียนผู้เสียชีวิต</h4>
            </div>
            <div class="modal-body">
                <div class="navbar navbar-default">
                    <form action="#" class="navbar-form">
                        <div class="row">
                            <div class=col-lg-4>
                                <label for="">HN</label>
                                <input type="hidden" id="txt_reg_hn" style="width: 250px;"/>
                            </div>
                            <div class="col-lg-4">
                                <label for="txt_reg_cid">เลขบัตรประชาชน</label>
                                <input type="text" class="form-control" id="txt_reg_cid" disabled="disabled" />
                            </div>
                            <div class="col-lg-2">
                                <label for="">วันเกิด</label>
                                <input type="text" class="form-control" id="txt_reg_birthdate" disabled="disabled" />
                            </div>
                            <div class="col-lg-2">
                                <label for="">อายุ (ปี)</label>
                                <input type="text" class="form-control" id="txt_reg_age" disabled="disabled" />

                            </div>
                        </div>
                    </form>
                </div>

            
                <form action="#">
            
                    <input type="hidden" id="txt_isupdate" value="0" />
            
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="control-label" for="txt_reg_death_date">วันที่</label>
                            <input id="txt_reg_death_date" class="form-control" value="<?= date('d/m/Y') ?>" type="text" data-type="date">
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_pdeath">สถานที่</label>
                            <select id="sl_pdeath" class="form-control">
                                <option value="">--</option>
                                <option value="1">ในสถานพยาบาล</option>
                                <option value="2">นอกสถานพยาบาล</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label" for="txt_reg_hosp_death">สถานบริการที่เสียชีวิต</label>
                            <input type="hidden" id="txt_reg_hosp_death" style="width: 400px;" />
                        </div>
                        <div class="col-lg-6">
                           <label class="control-label" for="sl_reg_pregdeath">การตั้งครรภ์</label>
                            <select id="sl_reg_pregdeath" class="form-control">
                                <option value="">--</option>
                                <option value="1">เสียชีวิตระหว่างตั้งครรภ์</option>
                                <option value="2">เสียชีวิตระหว่าง/หลังคลอด ภายใน 42 วัน</option>
                                <option value="3">ไม่ตั้งครรภ์</option>
                                <option value="4">ผู้ชาย</option>
                                <option value="9">ไม่ทราบ</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label" for="txt_icd_cdeath">สาเหตุการตาย</label>
                            <input type="hidden" id="txt_icd_cdeath" style="width: 400px;">
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label" for="txt_icd_odisease">โรคที่เป็นเหตุหนุน</label>
                            <input type="hidden" id="txt_icd_odisease" style="width: 400px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label" for="txt_icd_deathA">สาเหตุการตาย (A)</label>
                            <input type="hidden" id="txt_icd_deathA" style="width: 400px;">
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label" for="txt_icd_deathB">สาเหตุการตาย (B)</label>
                            <input type="hidden" id="txt_icd_deathB" style="width: 400px;" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label" for="txt_icd_deathC">สาเหตุการตาย (C)</label>
                            <input type="text" id="txt_icd_deathC" style="width: 400px;">
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label" for="txt_icd_deathD">สาเหตุการตาย (D)</label>
                            <input type="text" id="txt_icd_deathD" style="width: 400px;">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_save_death"><i class="icon-save"></i> บันทึกข้อมูล</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>
<!-- end register service -->

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.death.js');
</script>


