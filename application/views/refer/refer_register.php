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
                        <label class="control-label" for="tboTab1PcuId">ส่งไปที่</label>
                        <div class="controls">
                            <input type="text" id="tboTab1PcuId" class="input-mini" placeholder="รหัส">
                            <input type="text" id="tboTab1PcuName" placeholder="ชื่อสถานบริการ" class="input-medium" disabled>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="tboTab1ReferNumber">เลขที่ส่งต่อ</label>
                        <div class="controls">
                            <input type="text" class="input-small" id="tboTab1ReferNumber" placeholder="เลขที่ส่งต่อ" disabled>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="cboTab1ReferPoint">จุดส่งต่อ</label>
                        <div class="controls">
                            <select class="input-medium" id="cboTab1ReferPoint">
                                <option value="">---</option>
                                <option value="ER">ER</option>
                                <option value="OPD">OPD</option>
                                <option value="IPD">IPD</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="cboTab1ReferRoom">ห้องตรวจ</label>
                        <div class="controls">
                            <select class="input-medium" id="cboTab1ReferRoom">
                                <option value="">---</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">
                    <label class="control-label">ประเภทการส่งต่อ</label>
                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="rdoTab1TypeRefer" value="ในจังหวัด"> ในจังหวัด
                        </label>
                        <label class="radio">
                            <input type="radio" name="rdoTab1TypeRefer" value="นอกจังหวัด"> นอกจังหวัด
                        </label>
                    </div>
                </div>
                <div class="span2">
                    <label class="control-label">ประเภทการส่งต่อในเขต</label>
                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="rdoTab1TypeAreaRefer" value="ในเขต"> ในเขต
                        </label>
                        <label class="radio">
                            <input type="radio" name="rdoTab1TypeAreaRefer" value="นอกเขต"> นอกเขต
                        </label>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label">สถานะการตอบรับ</label>
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" id="chkTab1AcceptStatus"> ปลายทางอนุญาตให้ส่งตัวได้
                            </label>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="cboTab1Department">แผนก</label>
                        <div class="controls">
                            <select class="input-medium" id="cboTab1Department">
                                <option value="">---</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="cboTab1Doctor">แพทย์</label>
                        <div class="controls">
                            <select class="input-medium" id="cboTab1Doctor">
                                <option value="">---</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label" for="tboTab1FromPcuId">ส่งต่อจาก</label>
                        <div class="controls">
                            <input type="text" id="tboTab1FromPcuId" class="input-mini" placeholder="รหัส" disabled>
                            <input type="text" id="tboTab1FromPcuName" placeholder="ชื่อสถานบริการ" class="input-medium" disabled>
                        </div>
                    </div>
                </div>
                <div class="span2">
                    <div class="control-group">
                        <label class="control-label" for="cboTab1TypeOfIllness">ประเภทความเจ็บป่วย</label>
                        <div class="controls">
                            <select class="input-small" id="cboTab1TypeOfIllness">
                                <option value="">----</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="tboTab1Claim">สิทธิการรักษา</label>
                        <div class="controls">
                            <input type="text" class="input-medium" id="tboTab1Claim">
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="tboTab1ClaimNumber">เลขที่สิทธิ</label>
                        <div class="controls">
                            <input type="text" class="input-medium" id="tboTab1ClaimNumber">
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info"><h4>ประเภท / สถานะ</h4></div>
            <div class="form-inline">
                <label class="controls" for="cboTab1TransportedType">ประเภทการส่งตัว</label>
                <select class="input-small" id="cboTab1TransportedType">
                    <option value="">----</option>
                </select>
                <label class="controls" for="cboTab1Emergency">ความฉุกเฉิน</label>
                <select class="input-medium" id="cboTab1Emergency">
                    <option value="">----</option>
                </select>
                <label class="controls" for="cboTab1Cause">สาเหตุ</label>
                <select class="input-large" id="cboTab1Cause">
                    <option value="">----</option>
                </select>
                <label class="controls" for="cboTab1Type">ประเภท</label>
                <select class="input-small" id="cboTab1Type">
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
                                <label class="control-label" for="tboTab1Bp1">BP</label>
                                <div class="form-inline">
                                    <input type="text" class="input-mini" id="tboTab1Bp1"> /
                                    <input type="text" class="input-mini" id="tboTab1Bp2">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label" for="tboTab1Hr">HR</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" id="tboTab1Hr">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label" for="tboTab1Pr">PR</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" id="tboTab1Pr">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label" for="tboTab1Rr">RR</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" id="tboTab1Rr">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label" for="tboTab1Bw">BW</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" id="tboTab1Bw">
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span2">
                                <label class="control-label" for="tboTab1Height">Height</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" id="tboTab1Height">
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label" for="tboTab1Temp">Temp</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" id="tboTab1Temp">
                                </div>
                            </div>
                            <div class="span4">
                                <label class="control-label" for="tboTab1FirstDiag">การวินิจฉัยขั้นต้น</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" id="tboTab1FirstDiag">
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span2">
                                <label class="control-label">Coma score</label>
                            </div>
                            <div class="span2">
                                <label class="control-label" for="cboTab1E1">E</label>
                                <div class="controls">
                                    <select class="input-mini" id="cboTab1E1">
                                        <option value="">----</option>
                                    </select>
                                    <select class="input-mini" id="cboTab1E2">
                                        <option value="">----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label" for="cboTab1V1">V</label>
                                <div class="controls">
                                    <select class="input-mini" id="cboTab1V1">
                                        <option value="">----</option>
                                    </select>
                                    <select class="input-mini" id="cboTab1V2">
                                        <option value="">----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label" for="cboTab1M1">M</label>
                                <div class="controls">
                                    <select class="input-mini" id="cboTab1M1">
                                        <option value="">----</option>
                                    </select>
                                    <select class="input-mini" id="cboTab1M2">
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
                                <label class="control-label" for="tboTab1L">L</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" id="tboTab1L">
                                    <select class="input-mini" id="cboTab1L">
                                        <option value="">----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <label class="control-label" for="tboTab1R">R</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" id="tboTab1R">
                                    <select class="input-mini" id="cboTab1R">
                                        <option value="">----</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span2">
                                <label class="checkbox">
                                    <input type="checkbox" id="chkTab1Consciousness"> Consciousness
                                </label>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <input type="text" class="input-medium" id="tboTab1Consciousness">
                                </div>
                            </div>
                            <div class="span3">
                                <label class="checkbox">
                                    <input type="checkbox" id="chkTab1Death"> เสียชีวิตขณะนำส่ง
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="stab2">
                        <div class="row-fluid">
                            <div class="span4">
                                <label class="control-label" for="tboTab1Cc">CC</label>
                                <div class="controls">
                                    <textarea style="width: 180pt;" rows="3" id="tboTab1Cc"></textarea>
                                </div>
                            </div>
                            <div class="span4">
                                <label class="control-label" for="tboTab1Pe">PE</label>
                                <div class="controls">
                                    <textarea style="width: 180pt;" rows="3" id="tboTab1Pe"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="control-group form-inline">
                                <label class="checkbox">
                                    <input type="checkbox" id="chkTab1Ga"> GA
                                </label>
                                <input type="text" class="input-small" id="tboTab1Ga">
                                &nbsp;
                                <label class="checkbox">
                                    <input type="checkbox" id="chkTab1Heent"> HEENT
                                </label>
                                <input type="text" class="input-small" id="cboTab1Heent">
                                &nbsp;
                                <label class="checkbox">
                                    <input type="checkbox" id="chkTab1Heart"> HEART
                                </label>
                                <input type="text" class="input-small" id="tboTab1Heart">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="control-group form-inline">
                                <label class="checkbox">
                                    <input type="checkbox" id="chkTab1Lung"> LUNG
                                </label>
                                <input type="text" class="input-small" id="tboTab1Lung">
                                &nbsp;
                                <label class="checkbox">
                                    <input type="checkbox" id="chkTab1Neuro"> Neuro
                                </label>
                                <input type="text" class="input-small" id="tboTab1Neuro">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="stab3">
                        <div class="row-fluid">
                            <div class="form-inline">
                                <label class="checkbox">
                                    <input type="checkbox" id="chkTab1Nurse"> มีพยาบาลไปด้วย
                                </label>
                                &nbsp;&nbsp;
                                <label class="checkbox">
                                    <input type="checkbox" id="chkTab1Ambulance"> ส่งตัวด้วยรถ Ambulance
                                </label>
                                &nbsp;&nbsp;
                                เวลารถออก
                                <div class="input-append" data-type="datetimepicker">
                                    <input type="text" class="input-medium" id="dtpTab1TimeRefer">
                                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                </div>
                            </div>
                        </div><br>
                        <div class="row-fluid">
                            <table class="table table-striped table-hover table-bordered" id="tblTab1Nurse">
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
                                        <td><a data-name="btnTab1RemoveNurse" data-id="" class="btn btn-danger btn-mini"><i class="icon-trash icon-white"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row-fluid">
                                <button id="btnTab1AddNurse" class="btn btn-primary" title="เพิ่มพยาบาล"><i class="icon-plus-sign icon-white"></i></button>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="alert alert-error"><h4>การ Consult</h4></div>
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label" for="tboTab1SaveReferResult">บันทึกการส่งต่อ</label>
                        <div class="controls">
                            <textarea style="width: 400px;" rows="3" id="tboTab1SaveReferResult"></textarea>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label" for="tboTab1Response">Response</label>
                        <div class="controls">
                            <textarea style="width: 400px;" rows="3" id="tboTab1Response"></textarea>
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
                            <input type="checkbox" id="chkTab2Position"> จัด Position
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Airway"> ใส่ Airway
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Suction"> Suction
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2EtTube"> ET. Tube
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2O2"> O2
                        </label>
                        <input type="text" class="input-mini" id="tboTab2O2"> &nbsp;&nbsp;
                        <label class="control-label">LPM</label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Mask"> Mask
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Canular"> Canular
                        </label>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label"><strong>Stop bleed</strong></label>
                    <div class="form-inline">
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Suture"> Suture
                        </label>
                        <input type="text" class="input-mini" id="tboTab2Suture"> เข็ม&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2PressureDressing"> Pressure dressing
                        </label>
                        &nbsp;&nbsp;อื่นๆ <input type="text" class="input-large" id="cboTab2OtherStopBleed">
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label"><strong>IV Fluid</strong></label>
                    <div class="form-inline">
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Nss"> 0.9 NSS
                        </label>
                        <input type="text" class="input-mini" id="tboTab2Nss"> cc/hr.&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Rls"> RLS
                        </label>
                        <input type="text" class="input-mini" id="tboTab2Rls"> cc/hr.&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Acetar"> Acetar
                        </label>
                        <input type="text" class="input-mini" id="tboTab2Acetar"> cc/hr.&nbsp;&nbsp;
                        อื่นๆ <input type="text" class="input-large" id="tboTab2OtherIvFluid">
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label"><strong>Immoblized</strong></label>
                    <div class="form-inline">
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Splint"> Splint
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Sling"> Sling
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2LongSpinalBoard"> Long spinal board
                        </label>&nbsp;&nbsp;
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Collars"> Collars
                        </label>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label"><strong>CPR</strong></label>
                    <div class="form-inline">
                        <label class="checkbox">
                            <input type="checkbox" id="chkTab2Cpr"> ทำ CPR
                        </label>
                    </div>
                </div>
            </div>

            <div class="alert alert-success"><h4>อาการเปลี่ยนแปลงระหว่างนำส่ง</h4></div>
            <table class="table table-striped table-hover table-bordered" id="tblTab2Changes">
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
                        <td><a id="btnTab2RemoveChanges" class="btn btn-danger btn-mini" title="ลบรายการ"><i class="icon-trash icon-white"></i></a></td>
                    </tr>
                </tbody>
            </table>
            <button id="btnTab2AddChanges" class="btn btn-primary" title="เพิ่มอาการ"><i class="icon-plus-sign icon-white"></i></button><br><br>
        </div>

        <div class="tab-pane" id="tab3">
            <div class="alert alert-info"><h4>การวินิจฉัย</h4></div>
            <table class="table table-striped table-hover table-bordered" id="tblTab3Diag">
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
            <table class="table table-striped table-hover table-bordered" id="tblTab3Proced">
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

        <div class="tab-pane" id="tab4">
            <div class="alert alert-success"><h4>ผลตรวจทางห้องปฏิบัติการ</h4></div>
            <table class="table table-striped table-hover table-bordered" id="tblTab4Laboratory">
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

        <div class="tab-pane" id="tab5">
            <div class="alert alert-success"><h4>รายการสั่ง X-Ray</h4></div>
            <table class="table table-striped table-hover table-bordered" id="tblTab5Xray">
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
            <textarea rows="10" style="width: 600px;" placeholder="..." id="tboTab5Xray"></textarea>
        </div>

        <div class="tab-pane" id="tab6">
            <div class="alert alert-info"><h4>รายการยา / ค่าใช้จ่าย</h4></div>
            <table class="table table-striped table-hover table-bordered" id="tboTab6Drug">
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
            <table class="table table-striped table-hover table-bordered" id="tblTab7Payment">
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

        <div class="tab-pane" id="tab9">
            <div class="alert alert-danger"><h4>การประสานงาน</h4></div>
            <table class="table table-striped table-hover table-bordered" id="tblTab9Liaison">
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
                    <label class="control-label" for="cboTab11FromPcu">ส่งต่อมาจาก</label>
                    <div class="control-group">
                        <select class="input-medium" id="cboTab11FromPcu">
                            <option value="">-- ส่งต่อมาจาก --</option>
                        </select>
                    </div>
                </div>
                <div class="span3">
                    <label class="control-label" for="dtpTab11DateRefer">วันที่ส่ง</label>
                    <div class="control-group">
                        <div class="input-append" data-type="datetimepicker">
                            <input id="dtpTab11DateRefer" type="text" class="input-medium" value="<?php echo date('d/m/Y H:i:s'); ?>" disabled>
                            <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="cboTab11Haste">ความเร่งด่วน</label>
                        <div class="controls">
                            <select class="input-medium" id="cboTab11Haste">
                                <option value="">-- ความเร่งด่วน --</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="control-group">
                        <label class="control-label" for="cboTab11Cause">สาเหตุ</label>
                        <div class="controls">
                            <select class="input-medium" id="cboTab11Cause">
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
                                        <label class="control-label" for="tboTab11Cc">CC</label>
                                        <textarea rows="2" style="width: 300px;" id="tboTab11Cc"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="control-group">
                                    <div class="form-inline">
                                        <label class="control-label" for="tboTab11Pe">PE</label>
                                        <textarea rows="2" style="width: 300px;" id="tboTab11Pe"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span7">
                            <div class="row-fluid">
                                <div class="span5">
                                    <div class="control-group form-inline">
                                        <label class="control-label" for="tboTab11Bp1">BP</label>
                                        <input type="text" class="input-mini" id="tboTab11Bp1"> / <input type="text" class="input-mini" id="tboTab11Bp2">
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group form-inline">
                                        <label class="control-label" for="tboTab11Hr">HR</label>
                                        <input type="text" class="input-mini" id="tboTab11Hr">
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group form-inline">
                                        <label class="control-label" for="tboTab11Rr">RR</label>
                                        <input type="text" class="input-mini" id="tboTab11Rr">
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span4">
                                    <div class="control-group form-inline">
                                        <label class="control-label" for="tboTab11Bw">BW</label>
                                        <input type="text" class="input-mini" id="tboTab11Bw">
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="control-group form-inline">
                                        <label class="control-label" for="tboTab11Height">Height</label>
                                        <input type="text" class="input-mini" id="tboTab11Height">
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="control-group form-inline">
                                        <label class="control-label" for="tboTab11Temp">Temp</label>
                                        <input type="text" class="input-mini" id="tboTab11Temp">
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group form-inline">
                                        <label class="control-label" for="tbpTab11Diag">การวินิจฉัยขั้นต้น</label>
                                        <input type="text" class="input-xlarge" id="tbpTab11Diag">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger" style="font-size: 14pt;">การตอบกลับ</div>
                    <div class="row-fluid">
                        <div class="control-group">
                            <label class="control-label" for="tboTab11Step">ให้ดำเนินการต่อดังนี้</label>
                            <div class="controls">
                                <textarea rows="3" style="width: 600px;" id="tboTab11Step"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab11_2">
                    <div class="alert alert-info">
                        <h4>การวินิจฉัย<button id="btnTab11AddDiag" class="btn btn-primary pull-right btn-mini" title="เพิ่มการวินิจฉัย"><i class="icon-plus-sign icon-white"></i></button></h4>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="tblTab11Diag">
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
                                    <a id="btnTab11EditDiag" class="btn btn-info" title="แก้ไขรายการ"><i class="icon-edit icon-white"></i></a>
                                    <a id="btnTab11RemoveDiag" class="btn btn-danger" title="ลบรายการ"><i class="icon-trash icon-white"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab11_3">
                    <div class="alert alert-danger">
                        <h4>การทำหัตถการ<button id="btnTab11AddProced" class="btn btn-primary pull-right btn-mini" title="เพิ่มการทำหัตถการ"><i class="icon-plus-sign icon-white"></i></button></h4>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="tblTab11Proced">
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
                                    <a id="btnTab11EditProced" class="btn btn-info" title="แก้ไขรายการ"><i class="icon-edit icon-white"></i></a>
                                    <a id="btnTab11RemoveProced" class="btn btn-danger" title="ลบรายการ"><i class="icon-trash icon-white"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab11_4">
                    <div class="alert">
                        <h4>ผลตรวจทางห้องปฏิบัติการ<button id="btnTab11AddLab" class="btn btn-primary pull-right btn-mini" title="เพิ่มผลตรวจทางห้องปฏิบัติการ"><i class="icon-plus-sign icon-white"></i></button></h4>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="tblTab11Lab">
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
                                    <a id="btnTab11EditLab" class="btn btn-info" title="แก้ไขรายการ"><i class="icon-edit icon-white"></i></a>
                                    <a id="btnTab11RemoveLab" class="btn btn-danger" title="ลบรายการ"><i class="icon-trash icon-white"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab11_5">
                    <div class="alert alert-success">
                        <h4>รายการยา / ค่าใช้จ่าย<button id="btnTab11AddDrug" class="btn btn-primary pull-right btn-mini" title="เพิ่มรายการยา / ค่าใช้จ่าย"><i class="icon-plus-sign icon-white"></i></button></h4>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="tblTab11Drug">
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
                                    <a id="btnTab11EditDrug" class="btn btn-info" title="แก้ไขรายการ"><i class="icon-edit icon-white"></i></a>
                                    <a id="btnTab11RemoveDrug" class="btn btn-danger" title="ลบรายการ"><i class="icon-trash icon-white"></i></a>
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
                        <label class="control-label" for="cboTab11DistributionType">ประเภทการจำหน่าย</label>
                        <select class="input-medium" id="cboTab11DistributionType">
                            <option value="">-- ประเภทการจำหน่าย --</option>
                        </select>
                        <label class="control-label" for="tboTab11ReferToPcuId">ส่งต่อไปที่</label>
                        <input type="text" class="input-mini" placeholder="..." id="tboTab11ReferToPcuId">
                        <input type="text" class="input-medium" placeholder="..." disabled id="tboTab11ReferToPcuName">
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