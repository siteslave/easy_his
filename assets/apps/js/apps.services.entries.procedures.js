head.ready(function(){
    var procedures = {};
    procedures.modal = {
        show_new: function(vn){
            $('#spn_procedure_vn').html(vn);
            /*$('#mdl_proced_new > .modal-dialog > .modal-content > .modal-body')
                .load(site_url + '/pages/procedure/' + vn, function(){
                    $.getScript(base_url + 'assets/apps/js/modal/procedures.js');
                });*/
            app.load_page($('#mdl_proced_new'), '/pages/procedure/' + vn, 'assets/apps/js/pages/procedures.js');
            $('#mdl_proced_new').modal({keyboard: false});
        },
        show_update: function(vn, code){
            $('#spn_procedure_vn').html(vn);
          /*  $('#mdl_proced_new > .modal-dialog > .modal-content > .modal-body')
                .load(site_url + '/pages/procedure/' + vn + '/' + code, function(){
                    $.getScript(base_url + 'assets/apps/js/modal/procedures.js');
                });*/
            app.load_page($('#mdl_proced_new'), '/pages/procedure/' + vn + '/' + code, 'assets/apps/js/pages/procedures.js');
            $('#mdl_proced_new').modal({keyboard: false});
        },
        hide_new: function(){
            $('#mdl_proced_new').modal('hide');
        }
    };

    procedures.ajax = {
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

    $('#btn_proced_new').click(function(){
        var vn = $('#vn').val();
        procedures.modal.show_new(vn);
    });

    procedures.get_list = function(){

        var vn = $('#vn').val();

        $('#tbl_proced_list > tbody').empty();

        procedures.ajax.get_proced(vn, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_proced_list > tbody').append(
                    '<tr>' +
                        '<td colspan="9">ไม่พบรายการ</td>' +
                        '</tr>'
                );
            }else{
                if(_.size(data.rows)){
                    var i = 1;
                    _.each(data.rows, function(v){
                        $('#tbl_proced_list > tbody').append(
                            '<tr>' +
                                '<td>'+ i +'</td>' +
                                '<td>'+ v.clinic_name +'</td>' +
                                '<td>'+ v.code +'</td>' +
                                '<td>'+ app.strip(v.proced_name, 80) +'</td>' +
                                '<td>'+ app.add_commars(v.price) +'</td>' +
                                '<td>'+ v.start_time +'</td>' +
                                '<td>'+ v.end_time +'</td>' +
                                '<td>'+ v.provider_name +'</td>' +
                                '<td>' +
                                '<div class="btn-group">' +
                                '<a href="javascript:void(0);" class="btn btn-default" data-name="btn_proced_edit" data-code="'+ v.code +'"' +
                                ' title="แก้ไข">' +
                                '<i class="icon-edit"></i>' +
                                '</a>' +
                                '<a href="javascript:void(0);" class="btn btn-danger" data-name="btn_proced_remove" data-code="'+ v.code +'" title="ลบรายการ">' +
                                '<i class="icon-trash"></i>' +
                                '</a>' +
                                '</div></td>' +
                                '</tr>'
                        );

                        i++;
                    });
                }else{
                    $('#tbl_proced_list > tbody').append(
                        '<tr>' +
                            '<td colspan="9">ไม่พบรายการ</td>' +
                            '</tr>'
                    );
                }
            }
        });
    };

    $('a[href="#tab_procedure"]').click(function(){
        procedures.get_list();
    });

    //remove proced
    $(document).on('click', 'a[data-name="btn_proced_remove"]', function(){
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

    $(document).on('click', 'a[data-name="btn_proced_edit"]', function(){

        var code = $(this).data('code'),
            vn = $('#vn').val();
        procedures.modal.show_update(vn, code);
    });

});