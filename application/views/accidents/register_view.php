<ul class="breadcrumb">
	<li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
	<li><a href="<?php echo site_url('services');?>">การให้บริการ</a> <span class="divider">/</span></li>
	<li class="active">ข้อมูลอุบัติเหตุ [vn=<?php echo $vn; ?>, hn=<?php echo $hn;?>]</li>
</ul>

<input type="hidden" id="txt_hn" value="<?php echo $hn; ?>">
<input type="hidden" id="txt_vn" value="<?php echo $vn; ?>">
<input type="hidden" id="isupdate" value="<?php echo $updated; ?>">

<?php 
	if($updated)
	{
		echo '
          <div class="alert alert-block alert-error fade in" id="div_warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4 class="alert-heading">พบข้อมูลเดิมที่เคยบันทึกไว้แล้ว!</h4>
            <p>เนื่องจากมีการตรวจสอบพบว่ามีการบันทึกข้อมูลเดิมของผู้ป่วยที่มารับบริการในครั้งนี้อยู่แล้ว คุณต้องการเรียกข้อมูลเดิมขึ้นมาแก้ไขหรือไม่</p>
            <p>
              <a class="btn btn-danger" href="#" id="btn_get_data"><i class="icon-refresh"></i> เรียกข้อมูลเดิมขึ้นมาแก้ไข</a>
            </p>
          </div>
			';
	}

?>
<legend>ข้อมูลผู้ป่วย</legend>
<form action="#" class="well form-inline">
	<label class="control-label" for="txt_fullname">ชื่อ - สกุล</label>
	<input type="text" disabled="disabled" class="uneditable-input" id="txt_fullname" 
		value="<?php echo $first_name . ' ' . $last_name; ?>">
	<label class="control-label" for="txt_birth">วันเกิด</label>
	<input type="text" disabled="disabled" class="input-small uneditable-input" id="txt_birth" value="<?php echo from_mongo_to_thai_date($birthdate); ?>">
	
	<label class="control-label" for="txt_birth">ที่อยู่</label>
	<input type="text" disabled="disabled" class="input-xxlarge uneditable-input" id="txt_birth" value="<?php echo isset($address) ? $address : '-'; ?>">
</form>

<legend>ข้อมูลการเกิดอุบัติเหตุ</legend>


   

<form class="form-actions">
	<a href="javascript:void(0);" class="btn btn-success" id="btn_save">
		<i class="icon-save"></i> บันทึกข้อมูล
	</a>
	
	<a href="<?php echo site_url('services/entries'); ?>/<?php echo $vn; ?>" class="btn">
		<i class="icon-home"></i> กลับหน้าหลัก
	</a>

	<div class="pull-right">
		<a href="javascript:void(0);" class="btn btn-danger disabled">
			<i class="icon-trash"></i> ลบข้อมูล
		</a>
		<a href="javascript:void(0);" class="btn btn-info disabled">
			<i class="icon-time"></i> ประวัติการเกิดอุบัติเหตุ
		</a>
	</div>
</form>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.accidents.js');
</script>

