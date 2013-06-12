    <ul class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
        <li class="active">ตั้งค่า <span class="divider">/</span></li>
        <li class="active">ข้อมูลผู้ใช้งาน (Users)</li>
    </ul>

    <div class="row-fluid">
        <table class="table table-striped table-hover" id="tbl_provider_list">
            <thead>
            <tr>
                <th>ชื่อผู้ใช้งาน</th>
                <th>ชื่อ - สกุล</th>
                <th>เลขบัตรประชาชน</th>
                <th>แพทย์</th>
                <th>วันที่ลงทะเบียน</th>
                <th>เข้าใช้งานล่าสุด</th>
                <th>สถานะ</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($users as $r)
            {
                $active = $r->active == 'Y' ? 'ปกติ' : 'ระงับการใช้';
                echo '<tr>';
                echo '<td>'. $r->username .'</td>';
                echo '<td>'. $r->fullname .'</td>';
                echo '<td>'. $r->cid .'</td>';
                echo '<td>'. $r->provider_name .'</td>';
                echo '<td>'. $r->register_date .'</td>';
                echo '<td>'. $r->last_login .'</td>';
                echo '<td>'. $active .'</td>';
                echo '<td><div class="btn-group">';
                echo '<a href="#" class="btn"><i class="icon-edit"></i></a>';
                echo '<a href="#" class="btn"><i class="icon-key"></i></a>';
                echo '</div></td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
        <br>
        <button type="button" class="btn btn-success" id="btn_new_provider">
            <i class="icon-plus-sign"></i> เพิ่มรายการ
        </button>
    </div>

    <!-- modal new house -->
    <div class="modal hide fade" id="modal_new">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="icon-group"></i> เพิ่มผู้ใช้งาน (New user)</h4>
        </div>
        <div class="modal-body">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">ข้อมูลทั่วไป</a></li>
                    <li><a href="#tab2" data-toggle="tab">สิทธิ์การใช้งาน</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <form action="#">
                            <input type="hidden" id="is_update">
                            <div class="row-fluid">
                                <div class="span3">
                                    <div class="control-group error">
                                        <label class="control-label" for="txt_regster_no">ชื่อผู้ใช้งาน</label>
                                        <div class="controls">
                                            <input type="text" id="txt_regster_no" class="input-medium">
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group error">
                                        <label class="control-label" for="txt_council">รหัสผ่าน</label>
                                        <div class="controls">
                                            <input type="password" id="txt_council" class="input-medium">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row-fluid">
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="txt_cid">เลขบัตรประชาชน</label>
                                        <div class="controls">
                                            <input type="text" id="txt_cid" class="input-medium" data-type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="txt_first_name">ชื่อ</label>
                                        <div class="controls">
                                            <input type="text" id="txt_first_name" class="input-medium">
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="txt_last_name">สกุล</label>
                                        <div class="controls">
                                            <input type="text" id="txt_last_name" class="input-medium">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span5">
                                    <div class="control-group">
                                        <label class="control-label" for="sl_provider_type">แพทย์</label>
                                        <div class="controls">
                                            <select  id="sl_provider_type" class="input-xlarge">
                                                <option value="">--</option>
                                                <?php
                                                foreach($providers as $t){
                                                    echo '<option value="'.$t->id.'">' . $t->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="txt_start_date">เริ่มปฏิบัติงาน</label>
                                        <div class="controls">
                                            <div class="input-append date" data-name="datepicker">
                                                <input class="input-small" id="txt_start_date" type="text" disabled>
                                                <span class="add-on"><i class="icon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <div class="row-fluid">
                            <div class="span6">
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
                            <div class="span6">
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
            <button type="button" class="btn btn-success" id="btn_do_save_provider"><i class="icon-save"></i> บันทึกข้อมูล</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-off"></i> ปิดหน้าต่าง</button>
        </div>
    </div>

    <script type="text/javascript">
        head.js('<?php echo base_url(); ?>assets/apps/js/apps.settings.users.js');
    </script>