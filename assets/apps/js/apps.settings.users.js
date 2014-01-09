head.ready(function(){

    var users = {};

    users.ajax = {
        save: function(data, cb){
            var url = 'admin/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err){
                if(err){
                    cb(err);
                }else{
                    cb(null);
                }
            });
        },
        get_detail: function(id, cb){
            var url = 'admin/get_detail',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(cb) {
            var url = 'admin/get_list',
                params = {};

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        change_password: function(id, pass, cb) {
            var url = 'admin/change_password',
                params = {
                    id: id,
                    pass: pass
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    users.get_list = function() {
        $('#tbl_users_list > tbody').empty();

        users.ajax.get_list(function(err, data) {
            if(err)
            {
                $('#tbl_users_list > tbody').append('<tr><td colspan="8">ไม่พบรายการ</td></tr>');
            }
            else
            {
                if(_.size(data.rows) > 0)
                {
                    _.each(data.rows, function(v) {
                        var active = v.active == 'Y' ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-minus-circle"></i>';
                        $('#tbl_users_list > tbody').append(
                            '<tr>' +
                                '<td>'+ v.username +'</td>' +
                                '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                                '<td>'+ v.cid +'</td>' +
                                '<td>'+ v.provider_name +'</td>' +
                                '<td>'+ v.register_date +'</td>' +
                                '<td>'+ v.last_login +'</td>' +
                                '<td>'+ active +'</td>' +
                                '<td><div class="btn-group">' +
                                '<a href="javascript:void(0);" data-name="btn_edit" class="btn btn-success btn-small" data-id="'+ v.id +'" title="ดูข้อมูล/แก้ไข">' +
                                '<i class="fa fa-edit"></i></a>' +
                                '<a href="javascript:void(0);" data-name="btn_change_password" class="btn btn-default btn-small" data-id="'+ v.id +'" title="เปลี่ยนรหัสผ่าน">' +
                                '<i class="fa fa-key"></i></a>' +
                                '</div></td>' +
                            '</tr>'
                        );
                    });
                }
                else
                {
                    $('#tbl_users_list > tbody').append('<tr><td colspan="8">ไม่พบรายการ</td></tr>');
                }
            }
        });
    };

    users.modal = {
        show_new: function(){
            $('#modal_new').modal({
                backdrop: 'static'
            });
        },
        hide_new: function() {
            $('#modal_new').modal('hide');
        },
        show_change_password: function(){
            $('#modal_change_password').modal({
                backdrop: 'static'
            });
        },
        hide_change_password: function() {
            $('#modal_change_password').modal('hide');
        }
    };

    users.clear_form = function(){
        app.set_first_selected($('#sl_providers'));
        app.set_first_selected($('#sl_clinics'));
        $('#txt_username').val('').removeProp('disabled');
        $('#txt_password').val('').removeProp('disabled');
        $('#txt_password2').val('').removeProp('disabled');
        $('#txt_cid').val('');
        $('#txt_id').val('');
        $('#txt_first_name').val('');
        $('#txt_last_name').val('');
    };

    $('#btn_new_users').click(function(){
        //clear new users form
        users.clear_form();
        //show modal
        users.modal.show_new();
    });

    $('#btn_save').on('click', function() {
        var items = {};

        items.provider_id = $('#sl_providers').select2('val');
        items.clinic_id = $('#sl_clinics').select2('val');
        items.username = $('#txt_username').val();
        items.password = $('#txt_password').val();
        items.password2 = $('#txt_password2').val();
        items.cid = $('#txt_cid').val();
        items.first_name = $('#txt_first_name').val();
        items.last_name = $('#txt_last_name').val();
        items.id = $('#txt_id').val();
//
//       $('button[data-name="btn_active"]').each(function(){
//           if($(this).hasClass('active'))
//           {
//               items.active = $(this).data('value');
//           }
//        });

        if($('#lbl_active').hasClass('active')) {
            items.active = 'Y';
        } else {
            items.active = 'N';
        }

        if(!items.provider_id)
        {
            app.alert('กรุณาระบุแพทย์');
        }
        else if(!items.clinic_id)
        {
            app.alert('กรุณาระบุแผนก');
        }
        else if(!items.username)
        {
            app.alert('กรุณาระบุชื่อผู้ใช้งาน');
        }
        else if(!items.id && (!items.password || items.password <= 3))
        {
            app.alert('กรุณาระบุรหัสผ่าน และรหัสผ่านต้องมีความยาว 4 ตัวอักษรขึ้นไป');
        }
        else if(!items.cid)
        {
            app.alert('กรุณาระบุเลขบัตรประชาชน');
        }
        else if(!items.first_name)
        {
            app.alert('กรุณาระบุชื่อ');
        }
        else if(!items.last_name)
        {
            app.alert('กรุณาระบุสกุล');
        }
        else if(!items.id || (items.password != items.password2))
        {
            app.alert('รหัสผ่านทั้ง 2 ช่องไม่ตรงกัน');
        }
        else
        {
            app.confirm('คุณต้องการบันทึกข้อมูลใช่หรือไม่?', function(res) {
                if(res)
                {
                    users.ajax.save(items, function(err) {
                        if(err)
                        {
                            app.alert(err);
                        }
                        else
                        {
                            app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                            users.get_list();
                            users.modal.hide_new();
                        }
                    });
                }
            });
        }
    });

    $(document).on('click', 'a[data-name="btn_edit"]', function() {
        var id = $(this).data('id');
        users.ajax.get_detail(id, function(err, data) {
            users.set_detail(data.rows);

            users.modal.show_new();
        });
    });

    users.set_detail = function(v) {
        $('#sl_providers').select2('val', v.provider_id);
        $('#sl_clinics').select2('val', v.clinic_id);
        $('#txt_username').val(v.username).prop('disabled', true).css('background-color', 'white');
        $('#txt_password').prop('disabled', true).css('background-color', 'white');
        $('#txt_password2').prop('disabled', true).css('background-color', 'white');
        $('#txt_cid').val(v.cid);
        $('#txt_first_name').val(v.first_name);
        $('#txt_last_name').val(v.last_name);

        $('#txt_id').val(v.id);

        if(v.active == 'Y') {
            $("#lbl_active").addClass('active');
            $("#lbl_deny").removeClass('active');

            //$("#opt_active").prop('checked', true);
            //$("#opt_deny").prop('checked', false);
        } else {
            $("#lbl_active").removeClass('active');
            $("#lbl_deny").addClass('active');

            //$("#opt_active").prop('checked', false);
            //$("#opt_deny").prop('checked', true);
        }
//
//        $('button[data-name="btn_active"]').each(function(){
//            $(this).data('value') == v.active ? $(this).addClass('active', true) : $(this).removeClass('active')
//        });

    };

    $('#btn_refresh_users').on('click', function(e) {
        users.get_list();
        e.preventDefault();
    });

    //change password
    $(document).on('click', 'a[data-name="btn_change_password"]', function() {
        var id = $(this).data('id');
        $('#txt_change_password_id').val(id);
        $('#txt_change_password_new').val('');
        $('#txt_change_password_new2').val('');

        users.modal.show_change_password();
    });

    $('#btn_change_password').on('click', function() {
        var password = $('#txt_change_password_new').val(),
            password2 = $('#txt_change_password_new2').val(),

            id = $('#txt_change_password_id').val();

        if(!password)
        {
            app.alert('กรุณาระบุรหัสผ่านใหม่');
        }
        else if(!password2)
        {
            app.alert('กรุณาระบุรหัสผ่านใหม่ (ยืนยัน)');
        }
        else if(password != password2)
        {
            app.alert('รห้สผ่านทั้ง 2 ครั้งไม่เหมือนกัน');
        }
        else
        {
            users.ajax.change_password(id, password, function(err) {
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('เปลี่ยนรหัสผ่านเสร็จเรียบร้อยแล้ว');
                    users.modal.hide_change_password();
                }
            });
        }
    });

    users.get_list();

});