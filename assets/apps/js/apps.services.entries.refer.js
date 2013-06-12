head.ready(function(){
    var refer = {};
    refer.modal = {
        show_new: function(hn, vn){
            $('#spn_refer_out_vn').html(vn);
            app.load_page($('#mdl_new_refer_out'), '/pages/refer_out/' + hn + '/' + vn, 'assets/apps/js/pages/refer_out.js');
            $('#mdl_new_refer_out').modal({keyboard: false});
        },
        show_update: function(hn, vn, id){
            $('#spn_refer_out_vn').html(vn);
            app.load_page($('#mdl_new_refer_out'), '/pages/refer_out/' + hn + '/' + vn + '/' + id, 'assets/apps/js/pages/refer_out.js');
            $('#mdl_new_refer_out').modal({keyboard: false});
        },
        hide_new: function(){
            $('#mdl_new_refer_out').modal('hide');
        }
    };

    refer.ajax = {
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

    $('#btn_new_refer_out').click(function(){
        var vn = $('#vn').val(),
            hn = $('#hn').val();
        refer.modal.show_new(hn, vn);
    });

    refer.get_out_list = function(){
        var vn = $('#vn').val();
        $('#tbl_refer_out_list > tbody').empty();

        refer.ajax.get_out_list(vn, function(err, data){
            if(err)
            {
                app.alert(err);
                $('#tbl_refer_out_list > tbody').append(
                    '<tr>' +
                        '<td colspan="7">ไม่พบรายการนัด</td>' +
                        '</tr>'
                );

            }
            else
            {
                refer.set_out_list(data);
            }

        });
    };

    refer.set_out_list = function(data)
    {
        if(data.rows)
        {
            var i = 1;
            _.each(data.rows, function(v){
                $('#tbl_refer_out_list > tbody').append(
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
            $('#tbl_refer_out_list > tbody').append(
                '<tr>' +
                    '<td colspan="7">ไม่พบรายการนัด</td>' +
                    '</tr>'
            );
        }
    };

    $('a[href="#tab_refer_out"]').click(function(){
       refer.get_out_list();
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

    $('#btn_refer_out_refresh').on('click', function(){
        refer.get_out_list();
    });

    $('#mdl_new_appointment').on('hide', function(){
        appoint.get_list();
    });
});