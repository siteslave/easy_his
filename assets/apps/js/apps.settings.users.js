head.ready(function(){

    var provider = {};

    provider.clear_form = function(){
        $('#txt_regster_no').val('');
        $('#txt_council').val('');
        $('#txt_cid').val('');
        $('#txt_old_cid').val('');
        $('#txt_first_name').val('');
        $('#txt_last_name').val('');
        $('#sl_sex').val('');
        $('#txt_birth_date').val('');
        $('#txt_start_date').val('');
        $('#txt_out_date').val('');
        $('#txt_move_from_hospital_code').val('');
        $('#txt_move_to_hospital_code').val('');
        $('#txt_provider_id').val('');
    };

    provider.ajax = {
        save: function(data, cb){
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


    provider.modal = {
        show_new: function(){
            $('#modal_new').modal({
                backdrop: 'static'
            }).css({
                    width: 700,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        show_search_hospital: function(){
            $('#modal_search_hospital').modal({
                backdrop: 'static'
            }).css({
                    width: 680,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
    };

    $('#btn_new_provider').click(function(){
        //clear new provider form
        provider.clear_form();
        //show modal
        provider.modal.show_new();
    });

    $('#btn_do_search_hospital').click(function(){
        var query = $('#text_query_search_hospital').val();
        var op = $('#chk_search_by_name').is(":checked") ? 1 : 0;

        if(!query){
            app.alert('กรุณาระบคำที่ต้องการค้นหา');
        }else{
            //do search

            $('#table_search_hospital_result_list tbody').empty();

            provider.ajax.search_hospital(query, op, function(err, data){
                if(err){
                    $('#table_search_hospital_result_list tbody').append(
                        '<tr>' +
                            '<td colspan="4">' + err + '</td>' +
                            '</tr>'
                    );
                }else{
                    if( _.size(data) ){
                        _.each(data, function(v){
                            $('#table_search_hospital_result_list tbody').append(
                                '<tr>' +
                                    '<td>' + v.code + '</td>' +
                                    '<td>' + v.name + '</td>' +
                                    '<td>' + v.province + '</td>' +
                                    '<td><a href="#" class="btn" data-name="btn_set_hospital" ' +
                                    'data-code="' + v.code + '" data-vname="'+ v.name +'"><i class="icon-share"></i></a></td>' +
                                    '</tr>'
                            );
                        });
                    }else{
                        $('#table_search_hospital_result_list tbody').append(
                            '<tr>' +
                                '<td colspan="4">ไม่พบรายการ</td>' +
                                '</tr>'
                        );
                    }
                }
            });
        }
    });

    $(document).on('click', 'a[data-name="btn_set_hospital"]', function(){
        var act = $('#txt_search_for').val(),
            hospcode = $(this).attr('data-code'),
            hospname = $(this).attr('data-vname');

        if(act == 'f'){
            $('#txt_move_from_hospital_name').val(hospname);
            $('#txt_move_from_hospital_code').val(hospcode);
        }else{
            $('#txt_move_to_hospital_name').val(hospname);
            $('#txt_move_to_hospital_code').val(hospcode);
        }

        $('#modal_search_hospital').modal('hide');

    });

    $('#btn_search_hospital_from').click(function(){
        $('#txt_search_for').val('f');
        $('#modal_new_provider').modal('hide');
        provider.modal.show_search_hospital();
    });
    $('#btn_search_hospital_to').click(function(){
        $('#txt_search_for').val('t');
        $('#modal_new_provider').modal('hide');
        provider.modal.show_search_hospital();
    });


    $('#modal_search_hospital').on('hidden', function(){
        $('#modal_new_provider').modal('show');
    });

    //save provider
    $('#btn_do_save_provider').click(function(){
        var items                   = {};
        items.register_no           = $('#txt_regster_no').val();
        items.council               = $('#txt_council').val();
        items.cid                   = $('#txt_cid').val();
        items.title_id              = $('#sl_title').val();
        items.first_name            = $('#txt_first_name').val();
        items.last_name             = $('#txt_last_name').val();
        items.sex                   = $('#sl_sex').val();
        items.birth_date            = $('#txt_birth_date').val();
        items.provider_type_id      = $('#sl_provider_type').val();
        items.start_date            = $('#txt_start_date').val();
        items.out_date              = $('#txt_out_date').val();
        items.move_from_hospital    = $('#txt_move_from_hospital_code').val();
        items.move_to_hospital      = $('#txt_move_to_hospital_code').val();

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

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var id = $(this).attr('data-id');

        if(!id){
            app.alert('ไม่พบรหัสของผู้ให้บริการ');
        }else{
            provider.set_provider_detail(id);
        }
    });


});