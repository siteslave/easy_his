head.ready(function(){
    var diags = {};

    diags.modal = {
        show_new: function(){
            app.load_page($('#mdl_diag_new'), '/pages/diagnosis', 'assets/apps/js/pages/diagnosis.js');
            $('#mdl_diag_new').modal({keyboard: false});
        },
        hide_new: function(){
            $('#mdl_diag_new').modal('hide');
        }
    };

    //ajax
    diags.ajax = {
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

    diags.get_diag = function(){

        var vn = $('#vn').val();

        $('#tbl_diag_list > tbody').empty();

        diags.ajax.get_diag(vn, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_diag_list > tbody').append(
                    '<tr>' +
                        '<td colspan="7">ไม่พบรายการ</td>' +
                        '</tr>'
                );
            }else{
                if(_.size(data.rows)){
                    var i = 1;
                    _.each(data.rows, function(v){
                        if(v.diag_type == '1'){
                            $('#tbl_diag_list > tbody').append(
                                '<tr>' +
                                    '<td><strong>'+ i +'</strong></td>' +
                                    '<td><strong>'+ v.code +'</strong></td>' +
                                    '<td><strong>'+ app.strip(v.diag_name, 80) +'</strong></td>' +
                                    '<td><strong>'+ '[' + v.diag_type + '] ' +v.diag_type_name +'</strong></td>' +
                                    '<td><strong>'+ v.provider_name +'</strong></td>' +
                                    '<td><strong>'+ v.clinic_name +'</strong></td>' +
                                    '<td><a href="javascript:void(0);" class="btn btn-danger" data-name="btn_diag_remove" data-code="'+ v.code +'" title="ลบรายการ">' +
                                    '<i class="icon-trash"></i>' +
                                    '</a></td>' +
                                    '</tr>'
                            );
                        }else{
                            $('#tbl_diag_list > tbody').append(
                                '<tr>' +
                                    '<td>'+ i +'</td>' +
                                    '<td>'+ v.code +'</td>' +
                                    '<td>'+ app.strip(v.diag_name, 80) +'</td>' +
                                    '<td>'+ '[' + v.diag_type + '] ' +v.diag_type_name +'</td>' +
                                    '<td>'+ v.provider_name +'</td>' +
                                    '<td>'+ v.clinic_name +'</td>' +
                                    '<td><a href="javascript:void(0);" class="btn btn-danger" data-name="btn_diag_remove" data-code="'+ v.code +'" title="ลบรายการ">' +
                                    '<i class="icon-trash"></i>' +
                                    '</a></td>' +
                                    '</tr>'
                            );
                        }

                        i++;
                    });
                }else{
                    $('#tbl_diag_list > tbody').append(
                        '<tr>' +
                            '<td colspan="7">ไม่พบรายการ</td>' +
                            '</tr>'
                    );
                }
            }
        });
    }

    $('#btn_diag_new').click(function(){
        diags.modal.show_new();
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