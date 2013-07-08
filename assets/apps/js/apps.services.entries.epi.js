/**
 * Service EPI script
 */
head.ready(function(){
    var epis = {};
    epis.hn = $('#hn').val();
    epis.vn = $('#vn').val();

    epis.ajax = {
        get_list: function(vn, cb){
            var url = 'epis/get_visit_list',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        remove_visit: function(id, cb){
            var url = 'epis/remove_visit',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    epis.modal = {
        show_new: function()
        {
            app.load_page($('#mdl_vaccines'), '/pages/vaccines/' + epis.hn + '/' + epis.vn, 'assets/apps/js/pages/vaccines.js');
            $('#mdl_vaccines').modal({keyboard: false});
        },
        show_update: function(id)
        {
            app.load_page($('#mdl_vaccines'), '/pages/update_vaccines/' + epis.hn + '/' + id, 'assets/apps/js/pages/vaccines.js');
            $('#mdl_vaccines').modal({keyboard: false});
        }
    };

    $('#btn_new_vaccine').on('click', function(){
        epis.modal.show_new();
    });

    epis.set_visit = function(data)
    {
        $('#tbl_vaccine_list > tbody').empty();

        if(data)
        {
            var i = 1;
            _.each(data.rows, function(v){
                $('#tbl_vaccine_list > tbody').append(
                    '<tr>' +
                        '<td>' + i + '</td>' +
                        '<td>' + app.clear_null(v.vaccine_name) + '</td>' +
                        '<td>' + app.clear_null(v.lot) + '</td>' +
                        '<td>' + app.clear_null(v.expire) + '</td>' +
                        '<td>' + app.clear_null(v.provider_name) + '</td>' +
                        '<td>' +
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0);" class="btn btn-default" data-name="btn_epi_edit" data-id="'+ v.id +'"><i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0);" class="btn btn-danger" data-name="btn_epi_remove" data-id="'+ v.id +'"><i class="icon-trash"></i></a>' +
                        '</div>' +
                        '</td>' +
                        '</tr>'
                );

                i++;
            });
        }
        else
        {
            $('#tbl_vaccine_list > tbody').append(
                '<tr>' +
                    '<td colspan="7">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }



    };

    $('#btn_vaccine_refresh').on('click', function(){
        epis.ajax.get_list(epis.vn, function(err, data){
            epis.set_visit(data);
        });
    });

    epis.get_list = function(){
        epis.ajax.get_list(epis.vn, function(err, data){
            if(err)
            {
                app.alert(err);

                $('#tbl_vaccine_list > tbody').empty();
                $('#tbl_vaccine_list > tbody').append(
                    '<tr>' +
                        '<td colspan="7">ไม่พบรายการ</td>' +
                        '</tr>'
                );
            }
            else
            {
                epis.set_visit(data);
            }
        });
    };

    $('a[href="#tab_vaccine"]').click(function(){
        epis.get_list();
    });

    $(document).on('click', 'a[data-name="btn_epi_edit"]', function(){
        epis.modal.show_update($(this).data('id'));
    });

    $(document).on('click', 'a[data-name="btn_epi_remove"]', function(){
        var id = $(this).data('id');
        if(app.confirm('คุณต้องการลบรายการ ใช่หรือไม่?', function(res){
            if(res)
            {
                epis.ajax.remove_visit(id, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        epis.get_list();
                    }
                });
            }
        }));
    });
});
//End file