head.ready(function(){
    var procedures = {};

    procedures.modal = {
        show_new: function(){
            $('#mdl_proced_new').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_new: function(){
            $('#mdl_proced_new').modal('hide');
        }
    };

    //ajax
    procedures.ajax = {
        save_proced_opd: function(data, cb){

            var url = 'services/save_proced_opd',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_proced: function(vn, cb){

            var url = 'services/get_service_proced_opd',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove_proced: function(vn, code, cb){

            var url = 'services/remove_proced_opd',
                params = {
                    vn: vn,
                    code: code
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    procedures.clear_form = function(){
        $('#txt_proced_query').val('');
        $('#txt_proced_isupdate').val('');
        $('#txt_proced_query_code').val('');
        $('#txt_proced_price').val('0');
        $('#txt_proced_provider_code').val('');
        $('#txt_proced_provider_name').val('');

        $('#txt_proced_query').removeAttr('disabled');
        $('#txt_proced_query').removeClass('uneditable-input');
        //$('#txt_proced_query').css('background-color', 'white');

    };

    procedures.get_list = function(){

        var vn = $('#vn').val();

        $('#tbl_proced_list > tbody').empty();

        procedures.ajax.get_proced(vn, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_proced_list > tbody').append(
                    '<tr>' +
                        '<td colspan="5">ไม่พบรายการ</td>' +
                        '</tr>'
                );
            }else{
                if(_.size(data.rows)){
                    _.each(data.rows, function(v){
                        $('#tbl_proced_list > tbody').append(
                            '<tr>' +
                                '<td>'+ v.code +'</td>' +
                                '<td>'+ v.proced_name +'</td>' +
                                '<td>'+ app.add_commars(v.price) +'</td>' +
                                '<td>'+ v.provider_name +'</td>' +
                                '<td>' +
                                '<div class="btn-group">' +
                                '<a href="javascript:void(0);" class="btn" data-name="btn_proced_edit" data-code="'+ v.code +'"' +
                                'data-proced_name="'+ v.proced_name +'" data-provider="' + v.provider + '"' +
                                'data-provider_name=" ' + v.provider_name + '" data-price="' + v.price + '" title="แก้ไข">' +
                                '<i class="icon-edit"></i>' +
                                '</a>' +
                                '<a href="javascript:void(0);" class="btn" data-name="btn_proced_remove" data-code="'+ v.code +'" title="ลบรายการ">' +
                                '<i class="icon-remove"></i>' +
                                '</a>' +
                                '</div></td>' +
                                '</tr>'
                        );
                    });
                }else{
                    $('#tbl_proced_list > tbody').append(
                        '<tr>' +
                            '<td colspan="5">ไม่พบรายการ</td>' +
                            '</tr>'
                    );
                }
            }
        });
    };

    procedures.set_proced_data = function(data){
        $('#txt_proced_query').val(data.proced_name);
        $('#txt_proced_query').attr('disabled', 'disabled');
        $('#txt_proced_query').addClass('uneditable-input');
        $('#txt_proced_query').css('background-color', 'white');

        $('#txt_proced_isupdate').val('1');
        $('#txt_proced_query_code').val(data.code);
        $('#txt_proced_price').val(data.price);
        $('#txt_proced_provider_code').val(data.provider);
        $('#txt_proced_provider_name').val(data.provider_name);

        procedures.modal.show_new();
    };

    $('#btn_proced_new').click(function(){
        procedures.clear_form();
        procedures.modal.show_new();
    });

    $('#mdl_proced_new').on('hidden', function(){
        procedures.clear_form();
    });

    //save proced
    $('#btn_proced_do_save').click(function(){
        var items = {};
        items.code = $('#txt_proced_query_code').val();
        items.price = $('#txt_proced_price').val();
        items.isupdate = $('#txt_proced_isupdate').val();
        items.provider = $('#txt_proced_provider_code').val();

        items.vn = $('#vn').val();

        if(!items.code){
            app.alert('กรุณาระบุ หัตถการ');
        }else if(!items.price){
            app.alert('กรุณาระบุ ราคา');
        }else if(!items.provider){
            app.alert('กรุณาระบุ ผู้ทำหัตถการ');
        }else{
            //do save
            procedures.ajax.save_proced_opd(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    procedures.get_list();
                    procedures.modal.hide_new();
                }
            });
        }
    });

    $('#txt_proced_query').typeahead({
        ajax: {
            url: site_url + 'basic/search_procedure_ajax',
            timeout: 500,
            displayField: 'name',
            triggerLength: 3,
            preDispatch: function(query){
                return {
                    query: query,
                    csrf_token: csrf_token
                }
            },

            preProcess: function(data){
                if(data.success){
                    return data.rows;
                }else{
                    return false;
                }
            }
        },
        updater: function(data){
            var d = data.split('#');
            var name = d[1],
                code = d[0];

            $('#txt_proced_query_code').val(code);
            $('#txt_proced_query').val(name);

            return name;
        }
    });

    $('#txt_proced_provider_name').typeahead({
        ajax: {
            url: site_url + 'basic/search_provider_ajax',
            timeout: 500,
            displayField: 'name',
            triggerLength: 3,
            preDispatch: function(query){
                return {
                    query: query,
                    csrf_token: csrf_token
                }
            },

            preProcess: function(data){
                if(data.success){
                    return data.rows;
                }else{
                    return false;
                }
            }
        },
        updater: function(data){
            var d = data.split('#');
            var name = d[1],
                code = d[0];

            $('#txt_proced_provider_code').val(code);
            $('#txt_proced_provider_name').val(name);

            return name;
        }
    });

    $('a[href="#tab_procedure"]').click(function(){
        procedures.get_list();
    });

    //remove proced
    $('a[data-name="btn_proced_remove"]').on('click', function(){
        var obj = $(this).parent().parent().parent(),
            code = $(this).attr('data-code'),
            vn = $('#vn').val();

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res){
                procedures.ajax.remove_proced(vn, code, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        obj.fadeOut('slow');
                    }
                });
            }
        });
    });

    $('a[data-name="btn_proced_edit"]').on('click', function(){
        /*
         '<a href="javascript:void(0);" class="btn" data-name="btn_proced_edit" data-code="'+ v.code +'"' +
         'data-proced_name="'+ v.proced_name +'" data-provider="' + v.provider + '"' +
         'data-provider_name=" ' + v.provider_name + '" data-price="' + v.price + '" title="แก้ไข">' +
         */

        var items = {};
        items.code = $(this).attr('data-code');
        items.proced_name = $(this).attr('data-proced_name');
        items.provider = $(this).attr('data-provider');
        items.provider_name = $(this).attr('data-provider_name');
        items.price = $(this).attr('data-price');

        procedures.set_proced_data(items);
    });

});