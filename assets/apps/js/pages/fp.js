head.ready(function(){
    var fps = {};
    
    fps.ajax = {
        save_fp: function(items, cb)
        {
            var url = 'fps/save',
                params = {
                    data: items
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(vn, cb)
        {
            var url = 'fps/get_list',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list_all: function(hn, cb)
        {
            var url = 'fps/get_history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(id, cb)
        {
            var url = 'fps/remove',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };


    //save fp
    $('#btn_save_fp').click(function(){
        var items = {};

        items.fp_type = $('#sl_fp_type').val();
        items.date_serv = $('#txt_fp_date').val();
        items.hospcode = $('#txt_fp_hosp_code').val();
        items.provider_id = $('#sl_fp_providers').val();
        items.vn = $('#vn').val();
        items.hn = $('#hn').val();

        if(!items.fp_type)
        {
            app.alert('กรุณาระบุประเภทการคุมกำเนิด');
        }
        else if(!items.date_serv)
        {
            app.alert('กรุณาระบุวันที่ให้บริการ');
        }
        else if(!items.hospcode)
        {
            app.alert('กรุณาระบุสถานพยาบาลที่ให้บริการ');
        }
        else if(!items.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else
        {
            fps.ajax.save_fp(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    fps.clear_form();
                    fps.get_list();
                }
            });
        }
    });

    fps.clear_form = function(){
        app.set_first_selected($('#sl_fp_type'));
        app.set_first_selected($('#sl_fp_providers'));
    };
//
//    $('#txt_fp_hosp_name').typeahead({
//        ajax: {
//            url: site_url + '/basic/search_hospital_ajax',
//            timeout: 500,
//            displayField: 'fullname',
//            triggerLength: 3,
//            preDispatch: function(query){
//                return {
//                    query: query,
//                    csrf_token: csrf_token
//                }
//            },
//
//            preProcess: function(data){
//                if(data.success){
//                    return data.rows;
//                }else{
//                    return false;
//                }
//            }
//        },
//        updater: function(data){
//            var d = data.split('#');
//            var name = d[0],
//                code = d[1];
//
//            $('#txt_fp_hosp_code').val(code);
//
//            return name;
//        }
//    });

    fps.get_list = function()
    {
        var vn = $('#txt_fp_vn').val();

        $('#tbl_fp_list > tbody').empty();

        fps.ajax.get_list(vn, function(err, data){
            if(err)
            {
                app.alert(err);
                $('#tbl_fp_list > tbody').append('<tr><td colspan="3">ไม่พบรายการ</td></tr>');
            }
            else
            {
                _.each(data.rows, function(v){
                    $('#tbl_fp_list > tbody').append(
                        '<tr>' +
                            '<td>'+ v.fp_name +'</td>' +
                            '<td>'+ v.provider_name +'</td>' +
                            '<td>' +
                            '<div class="btn-group">' +
                            '<a href="#" class="btn btn-danger" data-name="btn_fp_remove_visit" data-id="'+ v.id +'">' +
                            '<i class="fa fa-trash-o"></i>' +
                            '</a>' +
                            '</div>' +
                            '</td>' +
                            '<tr>'
                    );
                });
            }
        });
    };

    $(document).on('click', 'a[data-name="btn_fp_remove_visit"]', function(){
        var id = $(this).data('id');

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่', function(res){
            if(res)
            {
                fps.ajax.remove(id, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        fps.get_list();
                    }
                });
            }
        });
    });

    fps.get_list_all = function()
    {
        var hn = $('#txt_fp_hn').val();

        fps.ajax.get_list_all(hn, function(err, data){
            $('#tbl_fp_list_all > tbody').empty();

            if(err)
            {
                app.alert(err);
                $('#tbl_fp_list_all > tbody').append('<tr><td colspan="6">ไม่พบรายการ</td></tr>');
            }
            else
            {
                _.each(data.rows, function(v){
                    $('#tbl_fp_list_all > tbody').append(
                        '<tr>' +
                            '<td>'+app.to_thai_date(v.date_serv)+'</td>' +
                            '<td>'+v.time_serv+'</td>' +
                            '<td>'+v.clinic_name+'</td>' +
                            '<td>'+v.owner_name+'</td>' +
                            '<td>'+v.fp_name+'</td>' +
                            '<td>'+v.provider_name+'</td>' +
                            '<tr>'
                    );
                });
            }
        });
    };



    $('a[href="#fp_tab2"]').click(function(){
        fps.get_list_all();
    });

    fps.get_list();

    app.set_runtime();
});