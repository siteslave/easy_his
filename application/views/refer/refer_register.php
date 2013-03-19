<!--
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 13/3/2556 10:17 น.
-->
<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('refer'); ?>">ทะเบียน Refer</a> <span class="divider">/</span></li>
    <li class="active">ลงทะเบียน Refer</li>
    <div class="pull-right">
        <button class="btn btn-primary btn-mini"><i class="icon-plus-sign icon-white"></i> บันทึกข้อมูล Refer</button>
    </div>
</ul>

<div class="tabbable tabs-left">
    <!-- Begin Tab Menu -->
    <ul class="nav nav-tabs" id="mainTab">
        <li class="active"><a href="#tab1" data-toggle="tab">ข้อมูลการส่งต่อ</a></li>
        <li><a href="#tab2" data-toggle="tab">การรักษาเบื้องต้น</a></li>
        <li><a href="#tab3" data-toggle="tab">การวินิจฉัย/หัตถการ</a></li>
        <li><a href="#tab4" data-toggle="tab">ผลตรวจทางห้องปฏิบัติการ</a></li>
        <li><a href="#tab5" data-toggle="tab">รายการ X-Ray</a></li>
        <li><a href="#tab6" data-toggle="tab">รายการยา/ค่าใช้จ่าย</a></li>
        <li><a href="#tab7" data-toggle="tab">สรุปค่าใช้จ่าย</a></li>
        <li><a href="#tab8" data-toggle="tab">รูป</a></li>
        <li><a href="#tab9" data-toggle="tab">การประสานงาน</a></li>
        <li><a href="#tab10" data-toggle="tab">Scan Documents</a></li>
        <li><a href="#tab11" data-toggle="tab">การตอบกลับ</a></li>
    </ul>
    <!-- End Tab Menu -->
    <!-- Begin Tab Content -->
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div class="alert alert-success"><h4>การประสานงาน</h4></div>
            <div class="row-fluid">
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label">ส่งไปที่</label>
                        <div class="controls">
                            <input type="text" id="tboPcuId" class="input-mini" placeholder="รหัส">
                            <input type="text" id="tboPcuName" placeholder="ชื่อสถานบริการ" class="input-medium" disabled>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label">เลขที่ส่งต่อ</label>
                        <div class="controls">
                            <input type="text" class="input-mini" id="tboReferNumber" placeholder="เลขที่ส่งต่อ" disabled>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label">จุดส่งต่อ</label>
                        <div class="controls">
                            <select class="input-small" id="cboReferPoint">
                                <option value="">---</option>
                                <option value="ER">ER</option>
                                <option value="OPD">OPD</option>
                                <option value="IPD">IPD</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label">ห้องตรวจ</label>
                        <div class="controls">
                            <select class="input-small" id="cboReferRoom">
                                <option value="">---</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label">แผนก</label>
                        <div class="controls">
                            <select class="input-small" id="cboReferRoom">
                                <option value="">---</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label">แพทย์</label>
                        <div class="controls">
                            <select class="input-medium" id="cboReferRoom">
                                <option value="">---</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <label class="control-label">ประเภทการส่งต่อ</label>
                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="rdoTypeRefer" value="ในจังหวัด" checked> ในจังหวัด
                        </label>
                        <label class="radio">
                            <input type="radio" name="rdoTypeRefer" value="นอกจังหวัด"> นอกจังหวัด
                        </label>
                    </div>
                </div>
                <div class="span2">
                    <label class="control-label">ประเภทการส่งต่อในเขต</label>
                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="rdoTypeAreaRefer" value="ในเขต" checked> ในเขต
                        </label>
                        <label class="radio">
                            <input type="radio" name="rdoTypeAreaRefer" value="นอกเขต"> นอกเขต
                        </label>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label">สถานะการตอบรับ</label>
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox"> ปลายทางอนุญาตให้ส่งตัวได้
                            </label>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label">ประเภทความเจ็บป่วย</label>
                        <div class="controls">
                            <select class="input-small" id="cboType">
                                <option value="">----</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label">ส่งต่อจาก</label>
                        <div class="controls">
                            <input type="text" id="tboPcuId" class="input-mini" placeholder="รหัส">
                            <input type="text" id="tboPcuName" placeholder="ชื่อสถานบริการ" class="input-medium" disabled>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label">สิทธิการรักษา</label>
                        <div class="controls">
                            <input type="text" class="input-medium">
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label">เลขที่สิทธิ</label>
                        <div class="controls">
                            <input type="text" class="input-medium">
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info"><h4>ประเภท / สถานะ</h4></div>
            <div class="form-inline">
                <label class="controls">ประเภทการส่งตัว</label>
                <select class="input-small">
                    <option value="">----</option>
                </select>
                <label class="controls">ความฉุกเฉน</label>
                <select class="input-medium">
                    <option value="">----</option>
                </select>
                <label class="controls">สาเหตุ</label>
                <select class="input-large">
                    <option value="">----</option>
                </select>
                <label class="controls">ประเภทการส่งตัว</label>
                <select class="input-small">
                    <option value="">----</option>
                </select>
            </div>
            <br>

            <div class="alert"><h4>Vital sign / CC / PE / Nurse</h4></div>
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs" id="subTab">
                    <li class="active"><a href="#stab1" data-toggle="tab">Vital sign</a></li>
                    <li><a href="#stab2" data-toggle="tab">CC / PE</a></li>
                    <li><a href="#stab3" data-toggle="tab">Nurse</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="stab1">
                        <div class="row-fluid">
                            <div class="span3">
                                <label class="control-label">BP</label>
                                <div class="form-inline">
                                    <input type="text" class="input-mini"> /
                                    <input type="text" class="input-mini">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label">HR</label>
                                <div class="controls">
                                    <input type="text" class="input-mini">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label">PR</label>
                                <div class="controls">
                                    <input type="text" class="input-mini">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label">RR</label>
                                <div class="controls">
                                    <input type="text" class="input-mini">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label">BW</label>
                                <div class="controls">
                                    <input type="text" class="input-mini">
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span2">
                                <label class="control-label">Height</label>
                                <div class="controls">
                                    <input type="text" class="input-mini">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label">Temp</label>
                                <div class="controls">
                                    <input type="text" class="input-mini">
                                </div>
                            </div>
                            <div class="span4">
                                <label class="control-label">การวินิจฉัยขั้นต้น</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge">
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span2">
                                <label class="control-label">Coma score</label>
                            </div>
                            <div class="span2">
                                <label class="control-label">E</label>
                                <div class="controls">
                                    <select class="input-mini">
                                        <option value="">----</option>
                                    </select>
                                    <select class="input-mini">
                                        <option value="">----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label">V</label>
                                <div class="controls">
                                    <select class="input-mini">
                                        <option value="">----</option>
                                    </select>
                                    <select class="input-mini">
                                        <option value="">----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label">M</label>
                                <div class="controls">
                                    <select class="input-mini">
                                        <option value="">----</option>
                                    </select>
                                    <select class="input-mini">
                                        <option value="">----</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span2">
                                <label class="control-label">Pupil sizes</label>
                            </div>
                            <div class="span2">
                                <label class="control-label">E</label>
                                <div class="controls">
                                    <input type="text" class="input-mini">
                                    <select class="input-mini">
                                        <option value="">----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label">V</label>
                                <div class="controls">
                                    <input type="text" class="input-mini">
                                    <select class="input-mini">
                                        <option value="">----</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span2">
                                <label class="checkbox">
                                    <input type="checkbox"> Consciousness
                                </label>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <input type="text" class="input-medium">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="checkbox">
                                    <input type="checkbox"> เสียชีวิตขณะนำส่ง
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="stab2">
                        <div class="row-fluid">
                            <div class="span4">
                                <label class="control-label">CC</label>
                                <div class="controls">
                                    <textarea style="width: 180pt;" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="span4">
                                <label class="control-label">PE</label>
                                <div class="controls">
                                    <textarea style="width: 180pt;" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="form-inline">
                                <label class="checkbox">
                                    <input type="checkbox"> GA
                                </label>
                                <input type="text" class="input-small">
                                &nbsp;
                                <label class="checkbox">
                                    <input type="checkbox"> HEENT
                                </label>
                                <input type="text" class="input-small">
                                &nbsp;
                                <label class="checkbox">
                                    <input type="checkbox"> HEART
                                </label>
                                <input type="text" class="input-small">
                                &nbsp;
                                <label class="checkbox">
                                    <input type="checkbox"> LUNG
                                </label>
                                <input type="text" class="input-small">
                                &nbsp;
                                <label class="checkbox">
                                    <input type="checkbox"> Neuro
                                </label>
                                <input type="text" class="input-small">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="stab3">
                        <div class="row-fluid">
                            <div class="form-inline">
                                <label class="checkbox">
                                    <input type="checkbox"> มีพยาบาลไปด้วย
                                </label>
                                &nbsp;&nbsp;
                                <label class="checkbox">
                                    <input type="checkbox"> ส่งตัวด้วยรถ Ambulance
                                </label>
                                &nbsp;&nbsp;
                                เวลารถออก
                                <div class="input-append" data-type="datetimepicker">
                                    <input type="text" class="input-medium">
                                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                </div>
                            </div>
                        </div><br>
                        <div class="row-fluid">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ลำดับที่</th>
                                        <th>ชื่อ - นามสกุล</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>ทดสอบ</td>
                                        <td><a data-name="btnRemove" data-id="" class="btn btn-danger btn-mini"><i class="icon-trash icon-white"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row-fluid">
                                <button class="btn btn-primary" title="เพิ่มพยาบาล"><i class="icon-plus-sign icon-white"></i></button>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="alert alert-error"><h4>การ Consult</h4></div>
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label">บันทึกการส่งต่อ</label>
                        <div class="controls">
                            <textarea style="width: 350pt;" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label">Response</label>
                        <div class="controls">
                            <textarea style="width: 350pt;" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="alert alert-info"><h4>การรักษาเบื้องต้น ก่อนการส่งต่อ</h4></div>
            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label"><strong>Airway & Breathing care</strong></label>
                    <div class="form-inline">
                        <label class="checkbox">
                            <input type="checkbox"> จัด Position
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> ใส่ Airway
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> Suction
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> ET. Tube
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> O2
                        </label>
                        <input type="text" class="input-mini"> &nbsp;&nbsp;
                        <label class="control-label">LPM</label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> Mask
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> Canular
                        </label>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label"><strong>Stop bleed</strong></label>
                    <div class="form-inline">
                        <label class="checkbox">
                            <input type="checkbox"> Suture
                        </label>
                        <input type="text" class="input-mini"> เข็ม&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> Pressure dressing
                        </label>
                        &nbsp;&nbsp;อื่นๆ <input type="text" class="input-large">
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label"><strong>IV Fluid</strong></label>
                    <div class="form-inline">
                        <label class="checkbox">
                            <input type="checkbox"> 0.9 NSS
                        </label>
                        <input type="text" class="input-mini"> cc/hr.&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> RLS
                        </label>
                        <input type="text" class="input-mini"> cc/hr.&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> Acetar
                        </label>
                        <input type="text" class="input-mini"> cc/hr.&nbsp;&nbsp;
                        อื่นๆ <input type="text" class="input-large">
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label"><strong>Immoblized</strong></label>
                    <div class="form-inline">
                        <label class="checkbox">
                            <input type="checkbox"> Splint
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> Sling
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> Long spinal board
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox"> Collars
                        </label>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label"><strong>CPR</strong></label>
                    <div class="form-inline">
                        <label class="checkbox">
                            <input type="checkbox"> ทำ CPR
                        </label>
                    </div>
                </div>
            </div>

            <div class="alert alert-success"><h4>อาการเปลี่ยนแปลงระหว่างนำส่ง</h4></div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>วันที่ / เวลา</th>
                        <th>สัญญาณชีพ</th>
                        <th>อาการ</th>
                        <th>การพยาบาล</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>18/03/2013 08:30:12</td>
                        <td>1234</td>
                        <td>***</td>
                        <td>***</td>
                        <td><a class="btn btn-danger btn-mini" title="ลบรายการ"><i class="icon-trash icon-white"></i></a></td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-primary" title="เพิ่มอาการ"><i class="icon-plus-sign icon-white"></i></button>
        </div>
        <div class="tab-pane" id="tab3">
            <div class="alert alert-info"><h4>การวินิจฉัย</h4></div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสโรค</th>
                    <th>ประเภท</th>
                    <th>ชื่อโรค</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>A1234</td>
                    <td>ทดสอบ</td>
                    <td>ทดสอบ</td>
                </tr>
                </tbody>
            </table>
            <div class="alert alert-success"><h4>หัตถการ</h4></div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสหัตถการ</th>
                    <th>ชื่อหัตถการ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>1234567</td>
                    <td>ทดสอบ</td>
                </tr>
                </tbody>
            </table>
            <!--
            <div class="alert"><h4>การประเมินการดูแล</h4></div>
            <div class="row-fluid">
                <div class="form-inline">
                    <label class="control-label">วันที่ประเมิน</label>
                    <div class="input-append" data-type="datetimepicker">
                        <input type="text" class="input-medium">
                        <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="form-inline">
                    <label class="control-label">A&B Care</label>

                </div>
            </div>
            -->
        </div>
        <div class="tab-pane active" id="tab4">
            <div class="alert alert-success"><h4>ผลตรวจทางห้องปฏิบัติการ</h4></div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>กลุ่ม</th>
                    <th>ชื่อรายการ</th>
                    <th>ผลตรวจ</th>
                    <th>หน่วย</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Paracetamol</td>
                    <td>20</td>
                    <td>2 เม็ด 3 เวลา หลังอาหาร</td>
                    <td>1</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane active" id="tab5">
            <div class="alert alert-success"><h4>รายการสั่ง X-Ray</h4></div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>วันที่สั่ง</th>
                    <th>วันที่รายงาน</th>
                    <th>ชื่อรายการ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>19/03/2556 16:15:00</td>
                    <td>19/03/2556 16:15:00</td>
                    <td>2 เม็ด 3 เวลา หลังอาหาร</td>
                </tr>
                </tbody>
            </table>

            <div class="alert alert-danger"><h4>การอ่านผล</h4></div>
            <textarea rows="10" style="width: 600px;" placeholder="..."></textarea>
        </div>
        <div class="tab-pane" id="tab6">
            <div class="alert alert-info"><h4>รายการยา / ค่าใช้จ่าย</h4></div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อรายการ</th>
                    <th>จำนวน</th>
                    <th>วิธีใช้</th>
                    <th>ราคาต่อหน่วย</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Paracetamol</td>
                    <td>20</td>
                    <td>2 เม็ด 3 เวลา หลังอาหาร</td>
                    <td>1</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="tab7">
            <div class="alert alert-info"><h4>สรุปค่าใช้จ่าย</h4></div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อรายการ</th>
                    <th>มูลค่า</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>ยาและเวชภัณฑ์</td>
                    <td>20</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="tab8">
            <div class="alert alert-success"><h4>รูป</h4></div>
        </div>
        <div class="tab-pane active" id="tab9">
            <div class="alert alert-danger"><h4>การประสานงาน</h4></div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รพ.ปลายทาง</th>
                    <th>เริ่มต้นเวลา</th>
                    <th>สิ้นสุดเวลา</th>
                    <th>ระยะเวลา (ชั่วโมง)</th>
                    <th>ระยะเวลา (นาที)</th>
                    <th>ผลการประสาน</th>
                    <th>การให้คำปรึกษา</th>
                    <th>ผู้ประสานงานปลายทาง</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>รพ.มหาสารคาม</td>
                    <td>20</td>
                    <td>20</td>
                    <td>20</td>
                    <td>20</td>
                    <td>20</td>
                    <td>20</td>
                    <td>20</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="tab10">
            <div class="alert alert-success"><h4>เอกสาร Scan</h4></div>
        </div>
        <div class="tab-pane" id="tab11">
            <div class="alert alert-info"><h4>ข้อมูลการส่งต่อ</h4></div>
            <div class="row-fluid">
                <div class="span3">
                    <label class="control-label">ส่งต่อมาจาก</label>
                    <div class="control-group">
                        <select class="input-medium">
                            <option value="">-- ส่งต่อมาจาก --</option>
                        </select>
                    </div>
                </div>
                <div class="span3">
                    <label class="control-label">วันที่ส่ง</label>
                    <div class="control-group">
                        <div class="input-append" data-type="datetimepicker">
                            <input type="text" class="input-medium" value="<?php echo date('d/m/Y H:i:s'); ?>" disabled>
                            <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label">ความเร่งด่วน</label>
                        <div class="controls">
                            <select class="input-medium">
                                <option value="">-- ความเร่งด่วน --</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label">สาเหตุ</label>
                        <div class="controls">
                            <select class="input-medium">
                                <option value="">-- สาเหตุ --</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert"><h4>สรุปข้อมูลการรักษา</h4></div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab11_1" data-toggle="tab">Vital sign</a></li>
                <li><a href="#tab11_2" data-toggle="tab">การวินิจฉัย</a></li>
                <li><a href="#tab11_3" data-toggle="tab">การทำหัตถการ</a></li>
                <li><a href="#tab11_4" data-toggle="tab">การตรวจทางห้องปฏิบัติการ</a></li>
                <li><a href="#tab11_5" data-toggle="tab">รายการยา / ค่าใช้จ่าย</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab11_1">
                    <div class="alert alert-success" style="font-size: 14pt;">Vital sign</div>
                    <div class="row-fluid">
                        <div class="span5">
                            <div class="row-fluid">
                                <div class="control-group">
                                    <div class="form-inline">
                                        <label class="control-label">CC</label>
                                        <textarea rows="2" style="width: 300px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="control-group">
                                    <div class="form-inline">
                                        <label class="control-label">PE</label>
                                        <textarea rows="2" style="width: 300px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span7">
                            <div class="row-fluid">
                                <div class="span5">
                                    <div class="control-group form-inline">
                                        <label class="control-label">BP</label>
                                        <input type="text" class="input-mini"> / <input type="text" class="input-mini">
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group form-inline">
                                        <label class="control-label">HR</label>
                                        <input type="text" class="input-mini">
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group form-inline">
                                        <label class="control-label">RR</label>
                                        <input type="text" class="input-mini">
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span4">
                                    <div class="control-group form-inline">
                                        <label class="control-label">BW</label>
                                        <input type="text" class="input-mini">
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="control-group form-inline">
                                        <label class="control-label">Height</label>
                                        <input type="text" class="input-mini">
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="control-group form-inline">
                                        <label class="control-label">Temp</label>
                                        <input type="text" class="input-mini">
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group form-inline">
                                        <label class="control-label">การวินิจฉัยขั้นต้น</label>
                                        <input type="text" class="input-xlarge">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger" style="font-size: 14pt;">การตอบกลับ</div>
                    <div class="row-fluid">
                        <div class="control-group">
                            <label class="control-label">ให้ดำเนินการต่อดังนี้</label>
                            <div class="controls">
                                <textarea rows="3" style="width: 600px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab11_2">
                    <div class="alert alert-info">
                        <h4>การวินิจฉัย<button class="btn btn-primary pull-right btn-mini" title="เพิ่มการวินิจฉัย"><i class="icon-plus-sign icon-white"></i></button></h4>
                    </div>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัสโรค</th>
                            <th>ประเภท</th>
                            <th>ชื่อโรค</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>F0123</td>
                            <td>123</td>
                            <td>ทดสอบ</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info" title="แก้ไขรายการ"><i class="icon-edit icon-white"></i></a>
                                    <a class="btn btn-danger" title="ลบรายการ"><i class="icon-trash icon-white"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab11_3">
                    <div class="alert alert-danger">
                        <h4>การทำหัตถการ<button class="btn btn-primary pull-right btn-mini" title="เพิ่มการทำหัตถการ"><i class="icon-plus-sign icon-white"></i></button></h4>
                    </div>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัสหัตถการ</th>
                            <th>ชื่อหัตถการ</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>F0123</td>
                            <td>123</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info" title="แก้ไขรายการ"><i class="icon-edit icon-white"></i></a>
                                    <a class="btn btn-danger" title="ลบรายการ"><i class="icon-trash icon-white"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab11_4">
                    <div class="alert">
                        <h4>ผลตรวจทางห้องปฏิบัติการ<button class="btn btn-primary pull-right btn-mini" title="เพิ่มผลตรวจทางห้องปฏิบัติการ"><i class="icon-plus-sign icon-white"></i></button></h4>
                    </div>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>กลุ่ม</th>
                            <th>ชื่อรายการ</th>
                            <th>ผลตรวจ</th>
                            <th>หน่วย</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>F0123</td>
                            <td>123</td>
                            <td>123</td>
                            <td>123</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info" title="แก้ไขรายการ"><i class="icon-edit icon-white"></i></a>
                                    <a class="btn btn-danger" title="ลบรายการ"><i class="icon-trash icon-white"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab11_5">
                    <div class="alert alert-success">
                        <h4>รายการยา / ค่าใช้จ่าย<button class="btn btn-primary pull-right btn-mini" title="เพิ่มรายการยา / ค่าใช้จ่าย"><i class="icon-plus-sign icon-white"></i></button></h4>
                    </div>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อรายการ</th>
                            <th>จำนวน</th>
                            <th>วิธีใช้</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>F0123</td>
                            <td>123</td>
                            <td>123</td>
                            <td>123</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info" title="แก้ไขรายการ"><i class="icon-edit icon-white"></i></a>
                                    <a class="btn btn-danger" title="ลบรายการ"><i class="icon-trash icon-white"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div><br>

            <div class="alert alert-success"><h4>การจำหน่าย</h4></div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="controls form-inline">
                        <label class="control-label">ประเภทการจำหน่าย</label>
                        <select class="input-medium">
                            <option value="">-- ประเภทการจำหน่าย --</option>
                        </select>
                        <label class="control-label">ส่งต่อไปที่</label>
                        <input type="text" class="input-mini" placeholder="...">
                        <input type="text" class="input-medium" placeholder="..." disabled>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
    <!-- End Tab Content -->
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/apps.refer.register.index.js');
</script>