<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
    <li class="active">ทะเบียนผู้เสียชีวิต</li>
</ul>
<div class="navbar">
    <form action="#" class="navbar-form form-inline">
        <label for="txt_query">ค้นหา</label>
        <input style="width: 300px;" id="txt_query" type="text" placeholder="พิมพ์เลขบัตรประชาชน หรือ HN หรือ ชื่อ - สกุล" autocomplete="off" />
        <button class="btn btn-primary" id="btn_search">
            <i class="icon-search"></i>
        </button>
    
        <button class="btn btn-success pull-right" id="btn_register">
            <i class="icon-plus-sign"></i> ลงทะเบียน
        </button>
    </form>
</div>


<table class="table table-striped table-hover" id="tbl_list">
    <thead>
        <tr>
            <th>HN</th>
            <th>เลขบัตรประชาชน</th>
            <th>ชื่อ - สกุล</th>
            <th>วันเกิด</th>
            <th>อายุ</th>
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
    <div class="modal-dialog" style="width: 960px; left: 35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-briefcase"></i> ลงทะเบียนผู้เสียชีวิต</h4>
            </div>
            <div class="modal-body">
                <form action="#" class="form-inline well well-small">
                    <div class="row">
                        <div class=col-lg-3>
                            <label for="">HN</label>
                            <input type="text" id="txt_reg_hn" placeholder="พิมพ์ HN เพื่อค้นหา"/>
                        </div>
                        <div class="col-lg-4">
                            <label for="">ชื่อ - สกุล</label>
                            <input type="text" id="txt_reg_fullname" disabled="disabled" />
                        </div>
                        <div class="col-lg-2">
                            <label for="">วันเกิด</label>
                            <input type="text" id="txt_reg_birthdate" disabled="disabled" />
                        </div>
                        <div class="col-lg-2">
                            <label for="">อายุ (ปี)</label>
                            <input type="text" id="txt_reg_age" disabled="disabled" />
                            
                        </div>
                    </div>
                </form>
            
                <form action="#">
            
                    <input type="hidden" id="txt_isupdate" value="0" />
            
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="control-label" for="txt_reg_death_date">วันที่</label>
                            <input id="txt_reg_death_date" value="<?= date('d/m/Y') ?>" type="text" data-type="date">
                        </div>
                        <div class="col-lg-3">
                            <label class="control-label" for="sl_pdeath">สถานที่</label>
                            <select id="sl_pdeath">
                                <option value="">--</option>
                                <option value="1">ในสถานพยาบาล</option>
                                <option value="2">นอกสถานพยาบาล</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label" for="txt_reg_hosp_death">สถานบริการที่เสียชีวิต</label>
                            <input type="hidden" id="txt_reg_hosp_death_code" />
                            <input type="text" id="txt_reg_hosp_death_name" placeholder="พิมพ์รหัส หรือ ชื่อ สถานบริการ" />
                        </div>
                        <div class="col-lg-4">
                           <label class="control-label" for="sl_reg_pregdeath">การตั้งครรภ์</label>
                            <select id="sl_reg_pregdeath">
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
                        <div class="col-lg-4">
                            <label class="control-label" for="txt_reg_cdeath_name">สาเหตุการตาย</label>
                            <input type="hidden" id="txt_reg_cdeath_code"/>
                            <input type="text" id="txt_reg_cdeath_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label" for="txt_reg_odisease_name">โรคที่เป็นเหตุหนุน</label>
                            <input type="hidden" id="txt_reg_odisease_code" />
                            <input type="text" id="txt_reg_odisease_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label" for="txt_hosp_deathA_name">สาเหตุการตาย (A)</label>
                            <input type="hidden" id="txt_hosp_deathA_code" />
                            <input type="text" id="txt_hosp_deathA_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label" for="txt_hosp_deathB_name">สาเหตุการตาย (B)</label>
                            <input type="hidden" id="txt_hosp_deathB_code" />
                            <input type="text" id="txt_hosp_deathB_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label" for="txt_hosp_deathC_name">สาเหตุการตาย (C)</label>
                            <input type="hidden" id="txt_hosp_deathC_code" />
                            <input type="text" id="txt_hosp_deathC_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label" for="txt_hosp_deathD_name">สาเหตุการตาย (D)</label>
                            <input type="hidden" id="txt_hosp_deathD_code"/>
                            <input type="text" id="txt_hosp_deathD_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
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


