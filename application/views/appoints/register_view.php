<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('services');?>">การให้บริการ</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('appoints');?>">ทะเบียนนัด</a> <span class="divider">/</span></li>
    <li class="active">ลงทะเบียนนัด [vn=<?php echo $vn; ?>, hn=<?php echo $hn;?>]</li>
</ul>

<input type="hidden" id="txt_hn" value="<?php echo $hn; ?>">
<input type="hidden" id="txt_vn" value="<?php echo $vn; ?>">

<legend>ข้อมูลผู้ป่วย</legend>
<form action="#" class="well form-inline">
    <label class="control-label" for="txt_fullname">ชื่อ - สกุล</label>
    <input type="text" disabled="disabled" class="uneditable-input" id="txt_fullname"
        value="<?php echo $person['first_name'] . ' ' . $person['last_name']; ?>">
    <label class="control-label" for="txt_birth">วันเกิด</label>
    <input type="text" disabled="disabled" class="input-small uneditable-input" id="txt_birth" value="<?php echo from_mongo_to_thai_date($person['birthdate']); ?>">

    <label class="control-label" for="txt_birth">ที่อยู่</label>
    <input type="text" disabled="disabled" class="input-xxlarge uneditable-input" id="txt_birth" value="<?php echo $address; ?>">
</form>

<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>คำแนะนำ!</strong> พิมพ์รหัสการวินิจฉัยโรคเพื่อค้นหา และต้องเป็นรหัส z เท่านั้น
</div>

<form action="#">
    <legend>ข้อมูลการนัด</legend>
    <div class="row-fluid">
        <div class="span2">
            <div class="control-group">
                <label class="control-label" for="txt_date">วันที่นัด</label>
                <div class="input-append date" data-name="datepicker">
                    <input class="input-small" id="txt_date" type="text" disabled>
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
            </div>
        </div>
        <div class="span1">
            <div class="control-group">
                <label class="control-label" for="txt_time">เวลา</label>
                <div class="controls">
                    <input type="text" data-type="time" id="txt_time" class="input-mini">
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_clinic">แผนกที่นัด</label>
                <div class="controls">
                    <select class="input-xlarge" id="sl_clinic">
                        <?php
                        foreach ($clinics as $t){
                            echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" for="sl_aptype">ประเภทกิจกรรมนัด</label>
                <div class="controls">
                    <select name="" id="sl_aptype">
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
        <div class="span7">
            <div class="control-group">
                <label class="control-label" for="">การวินิจฉัย</label>
            </div>
            <input type="text" id="txt_diag_code" class="input-mini"placeholder="พิมพ์รหัส...">
            <input type="text" id="txt_diag_name" class="input-xxlarge uneditable-input"  disabled="disabled" placeholder="...">
        </div>
    </div>
</form>

<form class="form-actions">
    <a href="javascript:void(0);" class="btn btn-success" id="btn_save">
        <i class="icon-ok-sign"></i> บันทึกข้อมูลนัด
    </a>

    <a href="<?php echo site_url('appoints'); ?>" class="btn">
        <i class="icon-home"></i> กลับหน้าหลัก
    </a>
    <div class="pull-right">
        <a href="javascript:void(0);" class="btn btn-info">
        <i class="icon-time"></i> ประวัติการนัด
    </a>
    </div>
</form>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.appointments.register.js');
</script>

