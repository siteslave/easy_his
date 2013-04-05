<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>"><i class="icon-home"></i> หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('settings'); ?>"><i class="icon-cogs"></i> กำหนดค่า</a> <span class="divider">/</span></li>
    <li class="active"><i class="icon-shopping-cart"></i> ทะเบียนเวชภัณฑ์</li>
</ul>
<form action="#" class="form-actions form-inline">
    <label for="txt_query">ค้นหา</label>
    <input class="input-xlarge" id="txt_query" type="text" placeholder="พิมพ์ชื่อยา..." autocomplete="off" />
    <button class="btn btn-info" id="btn_search">
        <i class="icon-search"></i>
    </button>

    <button class="btn btn-success pull-right" id="btn_register">
        <i class="icon-plus-sign"></i> เพิ่มรายการยา
    </button>
</form>

<table class="table table-striped table-hover" id="tbl_list">
    <thead>
        <tr>
            <th>รหัส</th>
            <th>รหัสมาตฐาน</th>
            <th>ชื่อยา</th>
            <th>ความแรง</th>
            <th>หน่วย</th>
            <th>ราคา</th>
            <th>คงเหลือ</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="8">ไม่พบรายการ</td>
    </tr>
    </tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<!-- register service -->
<div class="modal hide fade" id="mdl_register">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="icon-briefcase"></i> ลงทะเบียนผู้เสียชีวิต</h3>
</div>
<div class="modal-body">
    <blockquote><i class="icon-comments-alt"></i> พิมพ์ชื่อหรือ HN ในช่อง HN เพื่อค้นหา</blockquote>
    <form action="#" class="form-inline well">
        <label for="">HN</label>
        <input type="text" class="input-medium" id="txt_reg_hn" placeholder="พิมพ์ HN เพื่อค้นหา"/>
        <label for="">ชื่อ - สกุล</label>
        <input type="text" class="input-xlarge uneditable-input" id="txt_reg_fullname" disabled="disabled" />
        <label for="">วันเกิด</label>
        <input type="text" class="input-small uneditable-input" id="txt_reg_birthdate" disabled="disabled" />
        <label for="">อายุ (ปี)</label>
        <input type="text" class="input-mini uneditable-input" id="txt_reg_age" disabled="disabled" />
    </form>

    <form action="#">

        <input type="hidden" id="txt_isupdate" value="0" />

        <div class="row-fluid">
            <div class="span2">
                <div class="control-group">
                    <label class="control-label" for="txt_reg_death_date">วันที่</label>
                    <div class="controls">
                        <div class="input-append date" data-name="datepicker">
                            <input class="input-small" id="txt_reg_death_date" value="<?= date('d/m/Y') ?>" type="text" disabled>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="sl_pdeath">สถานที่</label>
                    <div class="controls">
                        <select id="sl_pdeath" class="input-xlarge">
                            <option value="">--</option>
                            <option value="1">ในสถานพยาบาล</option>
                            <option value="2">นอกสถานพยาบาล</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_reg_hosp_death">สถานบริการที่เสียชีวิต</label>
                    <div class="controls">
                        <input type="hidden" id="txt_reg_hosp_death_code" />
                        <input type="text" class="input-xlarge" id="txt_reg_hosp_death_name" placeholder="พิมพ์รหัส หรือ ชื่อ สถานบริการ" />
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="sl_reg_pregdeath">การตั้งครรภ์</label>
                    <div class="controls">
                        <select id="sl_reg_pregdeath" class="input-xlarge">
                            <option value="">--</option>
                            <option value="1">เสียชีวิตระหว่างตั้งครรภ์</option>
                            <option value="2">เสียชีวิตระหว่าง/หลังคลอด ภายใน 42 วัน</option>
                            <option value="3">ไม่ตั้งครรภ์</option>
                            <option value="4">ผู้ชาย</option>
                            <option value="9">ไม่ทราบ</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_reg_cdeath_name">สาเหตุการตาย</label>
                    <div class="controls">
                        <input type="hidden" id="txt_reg_cdeath_code"/>
                        <input type="text" id="txt_reg_cdeath_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_reg_odisease_name">โรคที่เป็นเหตุหนุน</label>
                    <div class="controls">
                        <input type="hidden" id="txt_reg_odisease_code" />
                        <input type="text" id="txt_reg_odisease_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                    </div>
                </div>
            </div>

        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_hosp_deathA_name">สาเหตุการตาย (A)</label>
                    <div class="controls">
                        <input type="hidden" id="txt_hosp_deathA_code" />
                        <input type="text" id="txt_hosp_deathA_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_hosp_deathB_name">สาเหตุการตาย (B)</label>
                    <div class="controls">
                        <input type="hidden" id="txt_hosp_deathB_code" />
                        <input type="text" id="txt_hosp_deathB_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_hosp_deathC_name">สาเหตุการตาย (C)</label>
                    <div class="controls">
                        <input type="hidden" id="txt_hosp_deathC_code" />
                        <input type="text" id="txt_hosp_deathC_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="txt_hosp_deathD_name">สาเหตุการตาย (D)</label>
                    <div class="controls">
                        <input type="hidden" id="txt_hosp_deathD_code"/>
                        <input type="text" id="txt_hosp_deathD_name" class="input-xlarge" placeholder="พิมพ์รหัสการวินิจฉัย...">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" id="btn_save_death"><i class="icon-save"></i> บันทึกข้อมูล</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
</div>
</div>
<!-- end register service -->

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/app.stock.index.js');
</script>


