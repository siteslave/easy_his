head.ready(function(){

    var provider = {};

    provider.clear_form = function(){
        $('#txt_regster_no').val('');
        $('#sl_council').select2('val', '');
        $('#txt_cid').val('');
        $('#txt_old_cid').val('');
        $('#txt_first_name').val('');
        $('#txt_last_name').val('');
        $('#sl_sex').select2('val', '');
        $('#txt_birth_date').val('');
        $('#txt_start_date').val('');
        $('#txt_out_date').val('');
        $('#txt_move_from_hospital_name').select2('val', '');
        $('#txt_move_to_hospital_name').select2('val', '');
        $('#txt_provider_id').val('');
    };

    provider.ajax = {
        save_provider: function(data, cb){
            var url = 'settings/do_save_providers',
                params = {
                    data: data
                }

            app.ajax(url, params, function(err){
                if(err){
                    cb(err);
                }else{
                    cb(null);
                }
            });
        },

        update_provider: function(data, cb){
            var url = 'settings/do_update_providers',
                params = {
                    data: data
                }

            app.ajax(url, params, function(err){
                if(err){
                    cb(err);
                }else{
                    cb(null);
                }
            });
        },

        /**
         * Search hospital
         *
         * @param query Word or Hospital code
         * @param op    Condition for search. 1 search by name, 2 search by code. Default is search by name
         * @param cb    Callback function
         */
        search_hospital: function(query, op, cb){
            var url = 'basic/search_hospital',
                params = {
                    query: query,
                    op: op
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_provider_list: function(cb){
            var url = 'settings/get_provider_list',
                params = {};

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_provider_detail: function(id, cb){
            var url = 'settings/get_provider_detail',
                params = {
                    id: id
                }
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data.rows);
            });
        }
    };

    provider.get_provider_list = function(){

        provider.ajax.get_provider_list(function(err, data){

            $('#tbl_provider_list tbody').empty();
            if(err){
                app.alert(err);
                $('#tbl_provider_list tbody').append('<tr><td colspan="9">ไม่พบรายการ</td></tr>');
            }else{
                if( _.size(data.rows) ) {

                    var i = 1; //set order list number

                    _.each(data.rows, function(v){
                        $('#tbl_provider_list tbody').append(
                            '<tr>' +
                                '<td>' + i + '</td> ' +
                                '<td>' + v.provider + '</td> ' +
                                '<td>' + v.cid + '</td> ' +
                                '<td>' + v.first_name + ' ' + v.last_name + '</td> ' +
                                '<td>' + v.register_no + '</td> ' +
                                '<td>' + v.provider_type + '</td> ' +
                                '<td>' + v.start_date + '</td> ' +
                                '<td>' + v.out_date + '</td> ' +
                                '<td><a href="javascript:void(0)" class="btn btn-success btn-small" data-name="btn_edit_provider" ' +
                                'title="แก้ไขรายการ" data-id="' + v.id + '"> ' +
                                '<i class="fa fa-edit"></i></a></td> ' +
                                '</tr>'
                        );

                        i++;
                    });
                }
                else
                {
                    $('#tbl_provider_list tbody').append('<tr><td colspan="9">ไม่พบรายการ</td></tr>');
                }
            }
        });

    };

    provider.set_provider_detail = function(id){

        provider.ajax.get_provider_detail(id, function(err, data){

            if(err){
                app.alert(err, 'เกิดข้อผิดพลาดในการแสดงข้อมูลผู้ให้บริการ');
            }else{
                $('#txt_regster_no').val(data['register_no']);
                $('#txt_provider_id').val(id);

                $('#sl_council').select2('val', data['council']);
                $('#txt_cid').val(data['cid']);
                $('#txt_old_cid').val(data['cid']);
                $('#sl_title').select2('val', data['title_id']);
                $('#sl_provider_type').select2('val', data['provider_type_id']);
                $('#txt_first_name').val(data['first_name']);
                $('#txt_last_name').val(data['last_name']);
                $('#sl_sex').select2('val', data['sex']);
                $('#txt_birth_date').val(data['birth_date']);
                $('#txt_start_date').val(data['start_date']);
                $('#txt_out_date').val(data['out_date']);
                $('#txt_move_from_hospital_name').select2('data', { code: data['move_from_hospital_code'], name: data['move_from_hospital_name']});
                $('#txt_move_to_hospital_name').select2('data', { code: data['move_to_hospital_code'], name: data['move_to_hospital_name'] });

                $('#is_update').val('1');

                provider.modal.show_new();
            }

        });

    }

    provider.modal = {
        show_new: function(){
            $('#modal_new_provider').modal({
                backdrop: 'static'
            });
        }
    };

    $('#btn_new_provider').click(function(){
        //clear new provider form
        provider.clear_form();
        //show modal
        provider.modal.show_new();
    });

    //save provider
    $('#btn_do_save_provider').click(function(){
        var items                   = {};

        var hospital_to           = $('#txt_move_to_hospital_name').select2('data');
        var hospital_from           = $('#txt_move_from_hospital_name').select2('data');

        items.register_no           = $('#txt_regster_no').val();
        items.council               = $('#sl_council').select2('val');
        items.cid                   = $('#txt_cid').val();
        items.title_id              = $('#sl_title').select2('val');
        items.first_name            = $('#txt_first_name').val();
        items.last_name             = $('#txt_last_name').val();
        items.sex                   = $('#sl_sex').select2('val');
        items.birth_date            = $('#txt_birth_date').val();
        items.provider_type_id      = $('#sl_provider_type').select2('val');
        items.start_date            = $('#txt_start_date').val();
        items.out_date              = $('#txt_out_date').val();
        items.move_from_hospital    = hospital_from === null ? '' : hospital_from.code;
        items.move_to_hospital      = hospital_to === null ? '' : hospital_to.code;

        if(!items.register_no){
            app.alert('กรุณาระบุทะเบียนวิชาชีพ');
        }else if(!items.council){
            app.alert('กรุณาระบุรหัสสภาวิชาชีพ');
        }else if(!items.cid){
            app.alert('กรุณาระบุเลขบัตรประชาชน');
        }else if(!items.first_name){
            app.alert('กรุณาระบุชื่อ');
        }else if(!items.sex){
            app.alert('กรุณาระบุเพศ');
        }else if(!items.last_name){
            app.alert('กรุณาระบุสกุล');
        }else if(!items.birth_date){
            app.alert('กรุณาระบุวันเกิด');
        }else if(!items.provider_type_id){
            app.alert('กรุณาระบุประเภทบุคลากร');
        }else if(!items.start_date){
            app.alert('กรุณาระบุวันที่เริ่มปฏิบัติงาน');
        }else{
            //do save

            var is_update = $('#is_update').val();

            if(is_update == '1'){
                items.id        = $('#txt_provider_id').val();
                items.old_cid   = $('#txt_old_cid').val();

                provider.ajax.update_provider(items, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        //clear form
                        provider.clear_form();
                        //hide modal
                        $('#modal_new_provider').modal('hide');
                        provider.get_provider_list();
                    }
                });
            }else{
                provider.ajax.save_provider(items, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        //clear form
                        provider.clear_form();
                        //hide modal
                        $('#modal_new_provider').modal('hide');
                        provider.get_provider_list();
                    }
                });
            }

        }
    });

    $(document).on('click', 'a[data-name="btn_edit_provider"]', function(){
        var id = $(this).attr('data-id');

        if(!id){
            app.alert('ไม่พบรหัสของผู้ให้บริการ');
        }else{
            provider.set_provider_detail(id);
        }
    });

    $('#txt_move_from_hospital_name').select2({
        placeholder: 'ชื่อ หรือ รหัสสถานบริการ',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_hospital_ajax",
            dataType: 'json',
            type: 'POST',
            quietMillis: 100,
            data: function (term) {
                return {
                    query: term,
                    csrf_token: csrf_token
                };
            },
            results: function (data)
            {
                return { results: data.rows, more: (data.rows && data.rows.length == 10 ? true : false) };
            }
            //dropdownCssClass: "bigdrop"
        },

        id: function(data) { return { id: data.code } },

        formatResult: function(data) {
            return '[' + data.code + '] ' + data.name;
        },
        formatSelection: function(data) {
            return '[' + data.code + '] ' + data.name;
        },
        initSelection: function(el, cb) {
            //var eltxt = $(el).val();
            //cb({'term': eltxt });
        }
    });
    $('#txt_move_to_hospital_name').select2({
        placeholder: 'ชื่อ หรือ รหัสสถานบริการ',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_hospital_ajax",
            dataType: 'json',
            type: 'POST',
            quietMillis: 100,
            data: function (term) {
                return {
                    query: term,
                    csrf_token: csrf_token
                };
            },
            results: function (data)
            {
                return { results: data.rows, more: (data.rows && data.rows.length == 10 ? true : false) };
            }
            //dropdownCssClass: "bigdrop"
        },

        id: function(data) { return { id: data.code } },

        formatResult: function(data) {
            return '[' + data.code + '] ' + data.name;
        },
        formatSelection: function(data) {
            return '[' + data.code + '] ' + data.name;
        },
        initSelection: function(el, cb) {
            //var eltxt = $(el).val();
            //cb({'term': eltxt });
        }
    });


    provider.get_provider_list();


});