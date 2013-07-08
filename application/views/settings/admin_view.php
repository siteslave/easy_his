    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
        <li class="active">ตั้งค่า</li>
        <li class="active">ข้อมูลผู้ใช้งาน (Users)</li>
    </ul>

    <table class="table table-striped table-hover" id="tbl_users_list">
        <thead>
        <tr>
            <th>ชื่อผู้ใช้งาน</th>
            <th>ชื่อ - สกุล</th>
            <th>เลขบัตรประชาชน</th>
            <th>แพทย์</th>
            <th>วันที่ลงทะเบียน</th>
            <th>เข้าใช้งานล่าสุด</th>
            <th>สถานะ</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
        </tr>
        </tbody>
    </table>

    <div class="row-fluid">

        <br>
        <button type="button" class="btn btn-success" id="btn_new_users" title="เพิ่มผู้ใช้งาน" rel="tooltip">
            <i class="icon-plus-sign"></i>
        </button>
        <button type="button" class="btn btn-default" id="btn_refresh_users" title="รีเฟรช" rel="tooltip">
            <i class="icon-refresh"></i>
        </button>
    </div>

    <div class="modal fade" id="modal_new">
        <div class="modal-dialog" style="width: 960px; left: 35%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="icon-group"></i> เพิ่มผู้ใช้งาน (New user)</h4>
                </div>
                <div class="modal-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">ข้อมูลทั่วไป</a></li>
                            <li><a href="#tab2" data-toggle="tab">สิทธิ์การใช้งาน (Under construction)</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <br>
                                <form action="#">
                                    <input type="hidden" id="txt_id" value="">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label class="control-label" for="txt_cid">เลขบัตรประชาชน</label>
                                            <input type="text" id="txt_cid" data-type="number">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="control-label" for="txt_first_name">ชื่อ</label>
                                            <input type="text" id="txt_first_name">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="control-label" for="txt_last_name">สกุล</label>
                                            <input type="text" id="txt_last_name">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="control-label" for="sl_clinics">คลินิกเริ่มต้น</label>
                                            <select  id="sl_clinics">
                                                <option value="">--</option>
                                                <?php
                                                foreach($clinics as $t){
                                                    echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="control-label" for="sl_providers">แพทย์</label>
                                            <select  id="sl_providers">
                                                <option value="">--</option>
                                                <?php
                                                foreach($providers as $t){
                                                    echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="alert alert-success">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label class="control-label" for="txt_username">ชื่อผู้ใช้งาน</label>
                                                <input type="text" id="txt_username" placeholder="username">
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label" for="txt_password">รหัสผ่าน</label>
                                                <input type="password" id="txt_password" placeholder="********">
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label" for="txt_password">รหัสผ่าน (ยืนยัน)</label>
                                                <input type="password" id="txt_password2" placeholder="********">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label" for="txt_password">สิทธิการใช้งาน</label>
                                                <div class="btn-group" data-toggle="buttons-radio">
                                                    <button type="button" class="btn btn-success active" data-name="btn_active" data-value="Y"><i class="icon-ok"></i> เปิดใช้งาน</button>
                                                    <button type="button" class="btn btn-success" data-name="btn_active" data-value="N"><i class="icon-minus"></i> ระงับสิทธิ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <dl>
                                            <dt>Administrator</dt>
                                            <dd>
                                                <label class="checkbox">
                                                    <input type="checkbox"> รายการยา
                                                </label>
                                            </dd>
                                            <dd>
                                                <label class="checkbox">
                                                    <input type="checkbox"> รายการค่าใช้จ่าย
                                                </label>
                                            </dd>
                                            <dd>
                                                <label class="checkbox">
                                                    <input type="checkbox"> ข้อมูลแผนก
                                                </label>
                                            </dd>
                                            <dd>
                                                <label class="checkbox">
                                                    <input type="checkbox"> ผู้ใช้งาน (Users)
                                                </label>
                                            </dd>
                                            <dd>
                                                <label class="checkbox">
                                                    <input type="checkbox"> ข้อมูลยา
                                                </label>
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="col-lg-6">
                                        <dl>
                                            <dt>ลงทะเบียน</dt>
                                            <dd>
                                                <label class="checkbox">
                                                    <input type="checkbox"> ผู้ป่วยโรคเรื้อรัง
                                                </label>
                                            </dd>
                                            <dd>
                                                <label class="checkbox">
                                                    <input type="checkbox"> เด็กแรกเกิด
                                                </label>
                                            </dd>
                                            <dd>
                                                <label class="checkbox">
                                                    <input type="checkbox"> แม่
                                                </label>
                                            </dd>
                                            <dd>
                                                <label class="checkbox">
                                                    <input type="checkbox"> ผู้พิการ
                                                </label>
                                            </dd>
                                            <dd>
                                                <label class="checkbox">
                                                    <input type="checkbox"> เสียชีวิต
                                                </label>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_save"><i class="icon-save"></i> บันทึกข้อมูล</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_change_password">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="icon-key"></i> เปลี่ยนรหัสผ่าน (Change password)</h4>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-inline">
                        <input type="hidden" id="txt_change_password_id" value="" />
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="txt_change_password_new">รหัสผ่านใหม่</label>
                                <input type="password" id="txt_change_password_new"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="txt_change_password_new2">รหัสผ่านใหม่ (ยืนยัน)</label>
                                <input type="password" id="txt_change_password_new2"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_change_password"><i class="icon-save"></i> เปลี่ยนรหัสผ่าน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        head.js('<?php echo base_url(); ?>assets/apps/js/apps.settings.users.js');
    </script>