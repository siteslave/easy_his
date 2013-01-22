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
    <button class="btn btn-success pull-right" id="btn_show_visit">
    	<i class="icon-plus-sign icon-white"></i> ลงทะเบียน
    </button>
</form>

<table class="table table-striped table-hover" id="tbl_appoint_list">
	<thead>
		<tr>
			<th>สถานะ</th>
			<th>วันที่นัด</th>
			<th>เวลา</th>
			<th>HN</th>
			<th>ชื่อ - สกุล</th>
			<th>ประเภทการนัด</th>
			<th>คลินิค/แผนก</th>
			<th>ผู้นัด (Provider)</th>
			<th>#</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>

<div class="modal hide fade" id="mdl_select_visit">
    <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h3>เลือกรายการรับบริการ</h3>
	</div>
	<div class="modal-body" style="height: 250px;">
	    <form class="form-inline well">
	    	<input type="hidden" id="txt_search_visit_by" value="0">
	    	<label>HN</label>
	    	<input type="text" class="input-xlarge" id="txt_query_visit">
	    	<div class="btn-group">
			    <button class="btn btn-info" id="btn_do_search_visit"><i class="icon-search icon-white"></i> ค้นหา</button>
			    <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
			    <span class="caret"></span>
			    </button>
			    <ul class="dropdown-menu">
			    	<li><a href="javascript:void(0);" data-name="btn_set_search_visit_filter" data-value="0"><i class="icon-qrcode"></i> ค้นจาก เลขบัตรประชาชน</a></li>
			    	<li><a href="javascript:void(0);" data-name="btn_set_search_visit_filter" data-value="1"><i class="icon-th-list"></i> ค้นจาก HN</a></li>
			    	<li><a href="javascript:void(0);" data-name="btn_set_search_visit_filter" data-value="2"><i class="icon-list"></i> ค้นจาก ชื่อ - สกุล</a></li>
			    </ul>
		    </div>
	    </form>
	    <table class="table table-striped" id="tbl_search_visit_result">
	    	<thead>
	    		<tr>
	    			<th>VN</th>
	    			<th>วันที่</th>
	    			<th>เวลา</th>
	    			<th>แผนก</th>
	    			<th></th>
	    		</tr>
	    	</thead>
	    	<tbody></tbody>
	    </table>
	</div>
	    <div class="modal-footer">
	    <a href="#" data-dismiss="modal" class="btn btn-danger"><i class="icon-off icon-white"></i> ปิดหน้าต่าง</a>
    </div>
</div>


<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.appointments.index.js');
</script>


