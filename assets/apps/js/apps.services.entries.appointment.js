head.ready(function(){
    var appoint = {};
    appoint.modal = {
        show_new: function(hn, vn){
            $('#spn_appoint_vn').html(vn);
            app.load_page($('#mdl_new_appointment'), '/pages/appoints/' + hn + '/' + vn, 'assets/apps/js/pages/appoints.js');
            $('#mdl_new_appointment').modal({keyboard: false});
        },
        show_update: function(hn, vn, id){
            $('#spn_appoint_vn').html(vn);
            app.load_page($('#mdl_new_appointment'), '/pages/appoints/' + hn + '/' + vn + '/' + id, 'assets/apps/js/pages/appoints.js');
            $('#mdl_new_appointment').modal({keyboard: false});
        },
        hide_new: function(){
            $('#mdl_new_appointment').modal('hide');
        }
    };

    appoint.ajax = {
        get_list: function(vn, cb){
            var url = 'appoints/get_appoint',
                params = {
                    vn: vn
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(id, cb){
            var url = 'appoints/remove',
                params = {
                    id: id
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#btn_appoint_new').click(function(){
        var vn = $('#vn').val(),
            hn = $('#hn').val();
        appoint.modal.show_new(hn, vn);
    });

    appoint.get_list = function(){
        var vn = $('#vn').val();
        $('#tbl_appoint_list > tbody').empty();

        appoint.ajax.get_list(vn, function(err, data){
            if(err)
            {
                app.alert(err);
                $('#tbl_appoint_list > tbody').append(
                    '<tr>' +
                        '<td colspan="7">ไม่พบรายการนัด</td>' +
                        '</tr>'
                );

            }
            else
            {
                appoint.set_list(data);
            }

        });
    };

    appoint.set_list = function(data)
    {
        if(data.rows)
        {
            var i = 1;
            _.each(data.rows, function(v){
                $('#tbl_appoint_list > tbody').append(
                    '<tr>' +
                        '<td>'+ i +'</td>' +
                        '<td>'+ v.apdate_thai +'</td>' +
                        '<td>'+ v.aptype_name +'</td>' +
                        '<td>'+ app.strip(v.diag, 50) +'</td>' +
                        '<td>'+ v.clinic_name +'</td>' +
                        '<td>'+ v.provider_name +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0)" data-name="btn_appoint_edit" class="btn btn-default" title="แก้ไข" data-vn="'+ v.vn +'" ' +
                        'data-hn="'+ v.hn+'" data-id="'+ v.id +'"><i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0)" data-name="btn_appoint_remove" data-id="'+ v.id +'" class="btn btn-danger" title="ลบรายการ"><i class="icon-trash"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
                i++;
            });
        }
        else
        {
            $('#tbl_appoint_list > tbody').append(
                '<tr>' +
                    '<td colspan="7">ไม่พบรายการนัด</td>' +
                    '</tr>'
            );
        }
    };

    $('a[href="#tab_appoint"]').click(function(){
       appoint.get_list();
    });

    //remove proced
    $(document).on('click', 'a[data-name="btn_appoint_remove"]', function(){
        var id = $(this).data('id');

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res){
                appoint.ajax.remove(id, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        appoint.get_list();
                    }
                });
            }
        });
    });

    $(document).on('click', 'a[data-name="btn_appoint_edit"]', function(){

        var hn = $(this).data('hn'),
            vn = $(this).data('vn'),
            id = $(this).data('id');
        appoint.modal.show_update(hn, vn, id);
    });

    $('#btn_appoint_refresh').on('click', function(){
        appoint.get_list();
    });

    $('#mdl_new_appointment').on('hide', function(){
        appoint.get_list();
    });
});