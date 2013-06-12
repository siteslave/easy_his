<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียนผู้ป่วยความดันโลหิตสูง (HT)</li>
</ul>
<form action="#" class="well well-small form-inline">
    <label for="sl_village">หมู่บ้าน</label>
    <select class="input-xlarge" id="sl_village">
        <option value="">---</option>
        <?php
        foreach ($villages as $r){
            echo '<option value="'.get_first_object($r['_id']).'">' . $r['village_code'] . ' ' . $r['village_name'] . '</option>';
        }
        ?>
    </select>
    <button type="button" class="btn btn-info" id="btn_filter_by_village"><i class="icon-search"></i></button> |
    <input type="text" class="input-xlarge" id="txt_query" placeholder="พิมพ์ HN หรือ เลขบัตรประชาชน"
        title="พิมพ์ HN หรือ เลขบัตรประชาชน" rel="tooltip" autocomplete="off" />
    <button type="button" id="btn_search" class="btn btn-info"><i class="icon-search"></i></button>
    <div class="btn-group pull-right">
        <button type="button" id="btn_refresh" class="btn" title="แสดงข้อมูลทั้งหมด (Refresh)" rel="tooltip"><i class="icon-refresh"></i></button>
        <button type="button" id="btn_register" class="btn btn-success" title="ลงทะเบียนผู้ป่วยรายใหม่ (Register)" rel="tooltip"><i class="icon-plus-sign"></i></button>
        <button type="button" id="btn_print" class="btn" title="พิมพ์รายชื่อผู้ป่วยทั้งหมด (Print)" rel="tooltip"><i class="icon-print"></i></button>
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
        <th>เพศ</th>
        <th>วันที่ลงทะเบียน</th>
        <th>ประเภท</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="9">กรุณากำหนดเงื่อนไขการแสดงข้อมูล</td>
    </tr>
    </tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<!-- Module Register Form -->
<div class="modal hide fade" id="mdlNewRegister">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ลงทะเบียนผู้ป่วยความดันโลหิตสูง (HT)</h3>
    </div>
    <div class="modal-body">
        <form action="#" class="well well-small form-inline">
            <div class="control-group">
                <div class="controls">
                    <label class="control-label" for="tboSearch">ค้นหา</label>
                    <input type="text" id="txt_search_person" class="input-xlarge" placeholder="เลขบัตรประชาชน หรือ HN"
                           rel="tooltip" title="เลขบัตรประชาชน หรือ HN " data-placement="right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-info" id="btn_search_person"><i class="icon-search icon-white"></i></button>
                    </div>
                    <input type="hidden" id="txt_isupdate" value="0" />
                </div>
            </div>
        </form>
        <form action="#" class="form-inline">
            <div class="row-fluid">
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="tboHN">HN</label>
                        <div class="controls">
                            <input type="text" id="tboHN" placeholder="HN" class="input-small" disabled />
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="tboCid">เลขบัตรประชาชน</label>
                        <div class="controls">
                            <input type="text" id="tboCid" placeholder="เลขบัตรประชาชน" class="input-medium" disabled />
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="tboFname">ชื่อ</label>
                        <div class="controls">
                            <input type="text" id="tboFname" placeholder="ชื่อผู้ป่วย" class="input-medium" disabled />
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="tboLname">นามสกุล</label>
                        <div class="controls">
                            <input type="text" id="tboLname" placeholder="นามสกุล" class="input-medium" disabled />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="tboAge">อายุ</label>
                        <div class="controls">
                            <input type="text" id="tboAge" placeholder="อายุ" class="input-small" disabled />
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="slSex">เพศ</label>
                        <div class="controls">
                            <select id="slSex" class="input-small" disabled style="background-color: white">
                                <option value="1">ชาย</option>
                                <option value="2">หญิง</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="tboRegCenterNumber">เลขทะเบียนกลาง</label>
                        <div class="controls">
                            <input type="text" id="tboRegCenterNumber" placeholder="เลขทะเบียนกลาง" class="input-medium" disabled />
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="tboRegHosNumber">เลขทะเบียน รพ.</label>
                        <div class="controls">
                            <input type="text" id="tboRegHosNumber" placeholder="เลขทะเบียน รพ." class="input-medium" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="tboYear">ปีที่เริ่มเป็น</label>
                        <div class="controls">
                            <input type="text" id="tboYear" placeholder="พ.ศ. เช่น 2556" class="input-small" data-type="year" />
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="dtpRegisDate">วันที่ขึ้นทะเบียน</label>
                        <div class="input-append date" data-name="datepicker">
                            <input value="<?=date('d/m/Y')?>" type="text" id="dtpRegisDate" class="input-small" disabled />
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="cboDiseaseType">ประเภทโรค</label>
                        <div class="controls">
                            <select class="input-medium" id="cboDiseaseType">
                                <option value="">----------</option>
                                <?php
                                foreach($diabetes_types as $dt)
                                    echo '<option value="'.$dt->id.'">' . $dt->name . '</option>';
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label" for="cboDoctor">แพทย์ผู้ดูแล</label>
                        <div class="controls">
                            <select id="cboDoctor">
                                <option value="">----------------</option>
                                <?php
                                    foreach($providers as $prov) {
                                        echo '<option value="'.$prov->id.'">'.$prov->name.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" id="ch_pre_register" checked="checked" /> Pre register
                            </label>

                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" id="ch_pregnancy"/> Pregnancy
                            </label>

                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" id="ch_hypertension"/> with Hypertension/DM
                            </label>

                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" id="ch_insulin"/> with Insulin
                            </label>

                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" id="ch_newcase" /> เป็นผู้ป่วยรายใหม่
                            </label>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn_do_register"><i class="icon-save"></i> บันทึกข้อมูล</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.hypertensions.index.js');
</script>


