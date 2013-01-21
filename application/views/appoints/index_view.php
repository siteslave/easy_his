<ul class="breadcrumb">
	<li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
	<li><a href="<?php echo site_url('services');?>">การให้บริการ</a> <span class="divider">/</span></li>
	<li class="active">ทะเบียนนัด</li>
</ul>
<form action="#" class="form-actions form-inline">
	<input type="hidden" id="txt_status" value="0">
	<label for="txt_date">วันที่</label>
	<div class="input-append date" data-name="datepicker">
 		<input class="input-small" id="txt_date" type="text" disabled>
 		<span class="add-on"><i class="icon-th"></i></span>
 	</div>
 	<label for="txt_date">แผนก</label>
	<select class="input-xlarge" id="sl_clinic">
		<option value="">--- ทั้งหมด ---</option>
	<?php 
		foreach ($clinics as $t){
			echo '<option value="'.$t->id.'">' . $t->name . '</option>';
		}
	?>
	</select>
	<div class="btn-group" data-toggle="buttons-radio">
	    <button type="button" data-name="btn_do_filter" data-id="0" class="btn"><i class="icon-th-list"></i> ทั้งหมด</button>
	    <button type="button" data-name="btn_do_filter" data-id="1" class="btn"><i class="icon-check"></i> มาตามนัด</button>
	    <button type="button" data-name="btn_do_filter" data-id="2" class="btn"><i class="icon-minus-sign"></i> ไม่มาตามนัด</button>
    </div>
</form>

<table class="table table-striped table-hover" id="tbl_appoint_list">
	<thead>
		<tr>
			<th>วันที่นัด</th>
			<th>เวลา</th>
			<th>HN</th>
			<th>ชื่อ - สกุล</th>
			<th>ประเภทการนัด</th>
			<th>คลินิค/แผนก</th>
			<th>ผู้นัด (Provider)</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.appointments.index.js');
</script>


