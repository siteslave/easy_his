head.ready(function(){
    var diags = {};

    diags.modal = {
        show_new: function(){
            $('#mdl_diag_new').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_new: function(){
            $('#mdl_diag_new').modal('hide');
        }
    };

    //ajax
    diags.ajax = {
        save_diag_opd: function(data, cb){

            var url = 'services/save_diag_opd',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_diag: function(vn, cb){

            var url = 'services/get_service_diag_opd',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove_diag: function(vn, diag_code, cb){

            var url = 'services/remove_diag_opd',
                params = {
                    vn: vn,
                    diag_code: diag_code
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    diags.clear_form = function(){
        app.set_first_selected($('#sl_diag_type'));
        app.set_first_selected($('#sl_diag_clinic'));
        $('#txt_diag_query').val('');
        $('#txt_diag_isupdate').val('');
        $('#txt_diag_query_code').val('');
    };

    diags.get_diag = function(){

        var vn = $('#vn').val();

        $('#tbl_diag_list > tbody').empty();

        diags.ajax.get_diag(vn, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_diag_list > tbody').append(
                    '<tr>' +
                        '<td colspan="6">ไม่พบรายการ</td>' +
                        '</tr>'
                );
            }else{
                if(_.size(data.rows)){
                    _.each(data.rows, function(v){
                        if(v.diag_type == '1'){
                            $('#tbl_diag_list > tbody').append(
                                '<tr>' +
                                    '<td><strong>'+ v.code +'</strong></td>' +
                                    '<td><strong>'+ v.diag_name +'</strong></td>' +
                                    '<td><strong>'+ '[' + v.diag_type + '] ' +v.diag_type_name +'</strong></td>' +
                                    '<td><strong>'+ v.provider_name +'</strong></td>' +
                                    '<td><strong>'+ v.clinic_name +'</strong></td>' +
                                    '<td><a href="javascript:void(0);" class="btn" data-name="btn_diag_remove" data-code="'+ v.code +'" title="ลบรายการ">' +
                                    '<i class="icon-remove"></i>' +
                                    '</a></td>' +
                                    '</tr>'
                            );
                        }else{
                            $('#tbl_diag_list > tbody').append(
                                '<tr>' +
                                    '<td>'+ v.code +'</td>' +
                                    '<td>'+ v.diag_name +'</td>' +
                                    '<td>'+ '[' + v.diag_type + '] ' +v.diag_type_name +'</td>' +
                                    '<td>'+ v.provider_name +'</td>' +
                                    '<td>'+ v.clinic_name +'</td>' +
                                    '<td><a href="javascript:void(0);" class="btn" data-name="btn_diag_remove" data-code="'+ v.code +'" title="ลบรายการ">' +
                                    '<i class="icon-remove"></i>' +
                                    '</a></td>' +
                                    '</tr>'
                            );
                        }


                    });
                }else{
                    $('#tbl_diag_list > tbody').append(
                        '<tr>' +
                            '<td colspan="6">ไม่พบรายการ</td>' +
                            '</tr>'
                    );
                }
            }
        });
    }

    $('#btn_diag_new').click(function(){
        diags.clear_form();
        diags.modal.show_new();
    });

    $('#mdl_diag_new').on('hidden', function(){
        diags.clear_form();
    });

    //save diag
    $('#btn_diag_do_save').click(function(){
        var items = {};
        items.code = $('#txt_diag_query_code').val();
        items.diag_type = $('#sl_diag_type').val();
        items.clinic = $('#sl_diag_clinic').val();

        items.vn = $('#vn').val();

        if(!items.code){
            app.alert('กรุณาระบุ รหัสการวินิจฉัยโรค');
        }else if(!items.diag_type){
            app.alert('กรุณาระบุ ประเภทการวินิจฉัยโรค');
        }else if(!items.clinic){
            app.alert('กรุณาระบุ คลินิกที่ให้บริการ');
        }else{
            //do save
            diags.ajax.save_diag_opd(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    diags.get_diag();
                    diags.modal.hide_new();
                }
            });
        }
    });

    $('#txt_diag_query').typeahead({
        ajax: {
            url: site_url + 'basic/search_icd_ajax',
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

            $('#txt_diag_query_code').val(code);
            $('#txt_diag_query').val(name);

            return name;
        }
    });

    $('a[href="#tab_diagnosis"]').click(function(){
        diags.get_diag();
    });

    //remove diag
    $(document).on('click', 'a[data-name="btn_diag_remove"]', function(){
        var obj = $(this).parent().parent(),
            code = $(this).attr('data-code'),
            vn = $('#vn').val();

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res){
                diags.ajax.remove_diag(vn, code, function(err){
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

});