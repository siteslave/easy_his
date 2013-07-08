<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('services');?>">การให้บริการ</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('appoints');?>">ทะเบียนนัด</a> <span class="divider">/</span></li>
    <li class="active">ลงทะเบียนนัด [vn=<?php echo $vn; ?>, hn=<?php echo $hn;?>]</li>
</ul>



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

