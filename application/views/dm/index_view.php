<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">ทะเบียนผู้ป่วยเบาหวาน (DM)</li>
</ul>
<form action="#" class="well form-inline">
    <label for="sl_village_id">หมู่บ้าน</label>
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

<!-- Module Register Form -->
<div class="modal hide fade" id="mdlNewRegister">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>ลงทะเบียนผู้ป่วยเบาหวาน (DM)</h3>
    </div>
    <div class="modal-body">
        <div class="alert alert-info" id="alert_regis_dm">
            <strong>คำแนะนำ ! </strong><span>กรุณากรอกข้อมูลให้ครบ</span>
        </div>
        <form action="#" class="form-inline">
            <div  data-name="blog_search">
                <div class="span5">
                    <div class="control-group">
                        <div class="controls">
                            <input type="hidden" data-name="txt_search_person_filter" value="0">
                            <label class="control-label" for="tboSearch">คำค้นหา</label>
                            <input type="text" id="tboSearch" placeholder="เลขบัตรประชาชน หรือ HN" />
                            <div class="btn-group">
                                <button type="button" class="btn btn-info" id="btnSearch"><i class="icon-search icon-white"></i>ค้นหา</button>
                                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter" data-value="0"><i class="icon-qrcode"></i> ค้นจาก เลขบัตรประชาชน</a></li>
                                    <li><a href="javascript:void(0);" data-name="btn_set_search_person_filter" data-value="1"><i class="icon-th-list"></i> ค้นจาก HN</a></li>
                                </ul>
                            </div>
                            <input type="hidden" id="tboCheckRegis" value="" />
                        </div>
                    </div>
                </div>
                <br><hr>
            </div>
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
                            <select id="slSex" class="input-small" disabled>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
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
                                <option value="NIDDM">NIDDM</option>
                                <option value="IDDM">IDDM</option>
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
                            <input type="checkbox" id="ch_pre_register" placeholder="Pre register" class="input-small" />
                            <label class="control-label" for="ch_pre_register">Pre register</label>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <div class="controls">
                            <input type="checkbox" id="ch_pregnancy" placeholder="Pregnancy" class="input-small" />
                            <label class="control-label" for="ch_pregnancy">Pregnancy</label>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <div class="controls">
                            <input type="checkbox" id="ch_hypertension" placeholder="with Hypertension/DM" class="input-small" />
                            <label class="control-label" for="ch_hypertension">with Hypertension/DM</label>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <div class="controls">
                            <input type="checkbox" id="ch_insulin" placeholder="with Insulin" class="input-small" />
                            <label class="control-label" for="ch_insulin">with Insulin</label>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <div class="controls">
                            <input type="checkbox" id="ch_newcase" placeholder="เป็นผู้ป่วยรายใหม่" class="input-small" />
                            <label class="control-label" for="ch_newcase">เป็นผู้ป่วยรายใหม่</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn_dm_do_register"><i class="icon-plus-sign icon-white"></i><span id="lblRegis" title="add">ลงทะเบียน</span></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off icon-white"></i>ปิดหน้าต่าง</button>
    </div>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.dm.index.js');
</script>


