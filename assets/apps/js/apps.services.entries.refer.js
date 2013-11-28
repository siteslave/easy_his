var refer = {};

head.ready(function(){

    refer.modal = {
        show_new: function(hn, vn){
            $('#spn_refer_out_vn').html(vn);
            app.load_page($('#mdl_new_refer_out'), '/pages/refer_out/' + hn + '/' + vn, 'assets/apps/js/pages/refer_out.js');
            $('#mdl_new_refer_out').modal({keyboard: false});
        },
        show_update: function(hn, vn, code){
            $('#spn_refer_out_vn').html(vn);
            app.load_page($('#mdl_new_refer_out'), '/pages/refer_out/' + hn + '/' + vn + '/' + code, 'assets/apps/js/pages/refer_out.js');
            $('#mdl_new_refer_out').modal({keyboard: false});
        },
        hide_new: function(){
            $('#mdl_new_refer_out').modal('hide');
        }
    };

    refer.ajax = {
        get_rfo_list: function(vn, cb){
            var url = 'refers/get_rfo_list',
                params = {
                    vn: vn
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(code, cb){
            var url = 'refers/remove_rfo',
                params = {
                    code: code
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

    refer.get_rfo_list = function(){
        var vn = $('#vn').val();
        refer.ajax.get_rfo_list(vn, function(err, data){
            if(err)
            {
                app.alert(err);
                $('#tbl_refer_out_list > tbody').empty();
                $('#tbl_refer_out_list > tbody').append(
                    '<tr>' +
                        '<td colspan="7">ไม่พบข้อมูลส่งต่อ</td>' +
                        '</tr>'
                );

            }
            else
            {
                refer.set_rfo_list(data);
            }

        });
    };

    refer.set_rfo_list = function(data)
    {
        $('#tbl_refer_out_list > tbody').empty();
        if(_.size(data.rows))
        {
            var i = 1;
            _.each(data.rows, function(v){
                $('#tbl_refer_out_list > tbody').append(
                    '<tr>' +
                        '<td>'+ i +'</td>' +
                        '<td>'+ v.refer_date +'</td>' +
                        '<td>'+ v.code +'</td>' +
                        '<td>['+ v.refer_hospital_code +'] ' + v.refer_hospital_name +' </td>' +
                        '<td>'+ v.clinic_name +'</td>' +
                        '<td>'+ v.provider_name +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0)" data-name="btn_rfo_edit" data-hn="'+ v.hn +'" data-vn="'+ v.vn +'" ' +
                        'class="btn btn-default" title="แก้ไข" data-code="'+ v.code +'"><i class="fa fa-edit"></i></a>' +
                        '<a href="javascript:void(0)" data-name="btn_rfo_remove" data-code="'+ v.code +'" ' +
                        'class="btn btn-danger" title="ลบรายการ"><i class="fa fa-trash-o"></i></a>' +
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
                    '<td colspan="7">ไม่พบข้อมูลส่งต่อ</td>' +
                    '</tr>'
            );
        }
    };

    $('a[href="#tab_refer"]').click(function(){
       refer.get_rfo_list();
    });

    $(document).on('click', 'a[data-name="btn_rfo_remove"]', function(){
        var code = $(this).data('code');

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res){
                refer.ajax.remove(code, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        refer.get_rfo_list();
                    }
                });
            }
        });
    });

    $(document).on('click', 'a[data-name="btn_rfo_edit"]', function(){

        var hn = $(this).data('hn'),
            vn = $(this).data('vn'),
            code = $(this).data('code');
        refer.modal.show_update(hn, vn, code);
    });

    $('#btn_rfo_refresh').on('click', function(){
        refer.get_rfo_list();
    });

    $('#mdl_new_appointment').on('hide', function(){
        refer.get_rfo_list();
    });
});