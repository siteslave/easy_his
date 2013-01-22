<ul class="breadcrumb">
	<li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
	<li><a href="<?php echo site_url('services');?>">การให้บริการ</a> <span class="divider">/</span></li>
	<li class="active">ข้อมูลอุบัติเหตุ [vn=<?php echo $vn; ?>, hn=<?php echo $hn;?>]</li>
</ul>

<input type="hidden" id="txt_hn" value="<?php echo $hn; ?>">
<input type="hidden" id="txt_vn" value="<?php echo $vn; ?>">

<legend>ข้อมูลผู้ป่วย</legend>
<form action="#" class="well form-inline">
	<label class="control-label" for="txt_fullname">ชื่อ - สกุล</label>
	<input type="text" disabled="disabled" class="uneditable-input" id="txt_fullname" 
		value="<?php echo $first_name . ' ' . $last_name; ?>">
	<label class="control-label" for="txt_birth">วันเกิด</label>
	<input type="text" disabled="disabled" class="input-small uneditable-input" id="txt_birth" value="<?php echo from_mongo_to_thai_date($birthdate); ?>">
	
	<label class="control-label" for="txt_birth">ที่อยู่</label>
	<input type="text" disabled="disabled" class="input-xxlarge uneditable-input" id="txt_birth" value="<?php echo $address; ?>">
</form>

<legend>ข้อมูลการเกิดอุบัติเหตุ</legend>

<div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
    	<li class="active"><a href="#tab1" data-toggle="tab"><i class="icon-info-sign"></i> ข้อมูลการเกิดอุบัติเหตุ</a></li>
    	<li><a href="#tab2" data-toggle="tab"><i class="icon-zoom-in"></i> การคัดกรองและการให้บริการ</a></li>
    </ul>
    <div class="tab-content">
	    <div class="tab-pane active" id="tab1">
	    	
	    	<form action="#">
				<div class="row-fluid">
					<div class="span2">
						<div class="control-group error">
							<label class="control-label" for="txt_aedate">วันที่เกิดอุบัติเหตุ</label>
							<div class="input-append date" data-name="datepicker">
								<input class="input-small" id="txt_aedate" type="text" disabled>
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
						</div>
					</div>
					<div class="span1">
						<div class="control-group error">
							<label class="control-label" for="txt_aetime">เวลา</label>
					        <div class="controls">
					        	<input type="text" data-type="time" id="txt_aetime" class="input-mini">
					        </div>
					  	</div>
					</div>		
					<div class="span2">
						<div class="control-group error">
							<label class="control-label" for="sl_aeurgency">ระดับความเร่งด่วน</label>
							<select id="sl_aeurgency" class="input-medium">
								<option value="">---</option>
								<option value="1">Life threatening</option>
								<option value="2">Emergency</option>
								<option value="3">Urgent</option>
								<option value="4">Acute</option>
								<option value="5">Non acute</option>
								<option value="6">ไม่แน่ใจ</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<div class="control-group error">
							<label class="control-label" for="sl_aetype">ประเภทผู้ป่วยอุบัติเหตุ (19 สาเหตุ)</label>
							<select id="sl_aetype" class="input-xlarge">
								<option value="">---</option>
								<?php 
								foreach($aetypes as $r){
									echo '<option value="'.$r->id.'">' . $r->name . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="span3">
						<div class="control-group">
							<label class="control-label" for="sl_aeplace">สถานที่เกิดอุบัติเหตุ</label>
							<select id="sl_aeplace" class="input-xlarge">
								<option value="">---</option>
								<?php 
								foreach($aeplaces as $r){
									echo '<option value="'.$r->id.'">' . $r->name . '</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<div class="control-group">
							<label class="control-label" for="sl_aetypein">ประเภทการมารับบริการ</label>
							<select id="sl_aetypein" class="input-xlarge">
								<option value="">---</option>
								<?php 
								foreach($aetypeins as $r){
									echo '<option value="'.$r->id.'">' . $r->name . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="span3">
						<div class="control-group">
							<label class="control-label" for="sl_aetraffic">ประเภทผู้บาดเจ็บ (อุบัติเหตุจราจร)</label>
							<select id="sl_aetraffic" class="input-xlarge">
								<option value="">---</option>
								<?php 
								foreach($aetraffics as $r){
									echo '<option value="'.$r->id.'">' . $r->name . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="span3">
						<div class="control-group">
							<label class="control-label" for="sl_aevehicle">ประเภทยานพาหนะ</label>
							<select id="sl_aevehicle" class="input-xlarge">
								<option value="">---</option>
								<?php 
								foreach($aevehicles as $r){
									echo '<option value="'.$r->id.'">' . $r->name . '</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
			</form>

	    </div>
	    <div class="tab-pane" id="tab2">
	    	<form action="#">
	    		<div class="row-fluid">
					<div class="span2">
						<div class="control-group">
							<label class="control-label" for="sl_aealcohol">ดื่มแอลกอฮอลล์</label>
							<select id="sl_aealcohol" class="input-medium">
								<option value="">---</option>
								<option value="1">ดื่ม</option>
								<option value="2">ไม่ดื่ม</option>
								<option value="9">ไม่ทราบ</option>
							</select>
						</div>
					</div>
					<div class="span2">
						<div class="control-group">
							<label class="control-label" for="sl_aenacrotic_drug">ใช้สารเสพติด</label>
							<select id="sl_aenacrotic_drug" class="input-medium">
								<option value="">---</option>
								<option value="1">ใช้</option>
								<option value="2">ไม่ใช้</option>
								<option value="9">ไม่ทราบ</option>
							</select>
						</div>
					</div>
					<div class="span2">
						<div class="control-group">
							<label class="control-label" for="sl_aebelt">คาดเข็มขัดนิรภัย</label>
							<select id="sl_aebelt" class="input-medium">
								<option value="">---</option>
								<option value="1">คาด</option>
								<option value="2">ไม่คาด</option>
								<option value="9">ไม่ทราบ</option>
							</select>
						</div>
					</div>
					<div class="span2">
						<div class="control-group">
							<label class="control-label" for="sl_aehelmet">สวมหมวดนิรภัย</label>
							<select id="sl_aehelmet" class="input-medium">
								<option value="">---</option>
								<option value="1">สวม</option>
								<option value="2">ไม่สวม</option>
								<option value="9">ไม่ทราบ</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<div class="control-group">
							<label class="control-label" for="sl_aeairway">การดูแลการหายใจ</label>
							<select id="sl_aeairway" class="input-xlarge">
								<option value="">---</option>
								<option value="1">มีการดูแลการหายใจก่อนมาถึง</option>
								<option value="2">ไม่มีการดูแลการหายใจก่อนมาถึง</option>
								<option value="3">ไม่จำเป็น</option>
							</select>
						</div>
					</div>
					<div class="span3">
						<div class="control-group">
							<label class="control-label" for="sl_aestopbleed">การห้ามเลือด</label>
							<select id="sl_aestopbleed" class="input-xlarge">
								<option value="">---</option>
								<option value="1">มีการห้ามเลือดก่อนมาถึง</option>
								<option value="2">ไม่มีการห้ามเลือดก่อนมาถึง</option>
								<option value="3">ไม่จำเป็น</option>
							</select>
						</div>
					</div>
					<div class="span3">
						<div class="control-group">
							<label class="control-label" for="sl_aesplint">การใส่ splint/slab</label>
							<select id="sl_aesplint" class="input-xlarge">
								<option value="">---</option>
								<option value="1">มีการใส่ splint/slab ก่อนมาถึง</option>
								<option value="2">ไม่มีการใส่ splint/slab ก่อนมาถึง</option>
								<option value="3">ไม่จำเป็น</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<div class="control-group">
							<label class="control-label" for="sl_aefluid">มีการให้น้ำเกลือ</label>
							<select id="sl_aefluid" class="input-xlarge">
								<option value="">---</option>
								<option value="1">มีการให้ IV fluid ก่อนมาถึง</option>
								<option value="2">ไม่มีการให้ IV fluid ก่อนมาถึง</option>
								<option value="3">ไม่จำเป็น</option>
							</select>
						</div>
					</div>
					<div class="span2">
						<div class="control-group">
							<label class="control-label" for="txt_aecoma_eye">ระดับความรู้สึกทางสายตา</label>
							<input type="text" class="input-medium" data-type="number" id="txt_aecoma_eye">
						</div>
					</div>
					<div class="span2">
						<div class="control-group">
							<label class="control-label" for="txt_aecoma_speak">ระดับความรู้สึกทางการพูด</label>
							<input type="text" class="input-medium" data-type="number" id="txt_aecoma_speak">
						</div>
					</div>
					<div class="span2">
						<div class="control-group">
							<label class="control-label" for="txt_aecoma_movement">ระดับความรู้สึกการเคลื่อนไหว</label>
							<input type="text" class="input-medium" data-type="number" id="txt_aecoma_movement">
						</div>
					</div>
				</div>
	    	</form>
	    </div>
    </div>
</div>
   

<form class="form-actions">
	<a href="javascript:void(0);" class="btn btn-success" id="btn_save">
		<i class="icon-ok-sign icon-white"></i> บันทึกข้อมูล
	</a>
	
	<a href="<?php echo site_url('services'); ?>" class="btn">
		<i class="icon-home"></i> กลับหน้าหลัก
	</a>
	<div class="pull-right">
		<a href="javascript:void(0);" class="btn btn-info">
		<i class="icon-time icon-white"></i> ประวัติการเกิดอุบัติเหตุ
	</a>
	</div>
</form>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.accidents.js');
</script>

