head.ready(function(){
    var bc = {};

    bc.ajax = {
        get_history: function(hn, cb){
            var url = 'babies/get_service_history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        save_service: function(data, cb){
            var url = 'babies/save_service',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        remove_service: function(hn, id, cb){
            var url = 'babies/remove_service',
                params = {
                    hn: hn,
                    id: id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#btn_babies_care_save').click(function(){
        var items = {};
        items.vn = $('#txt_babies_care_vn').val();
        items.hn = $('#txt_babies_care_hn').val();
        items.id = $('#txt_babies_care_id').val();
        items.result = $('#sl_babies_care_result').val();
        items.food = $('#sl_babies_care_food').val();
        items.provider_id = $('#sl_babies_care_providers').val();
        items.hospcode = $('#txt_babies_care_hospcode').val();
        items.date_serv = $('#txt_babies_care_date').val();

        if(!items.result)
        {
            app.alert('กรุณาระบุผลการตรวจ');
        }
        else if(!items.hn)
        {
            app.alert('กรุณระบุ HN');
        }
        else if(!items.hospcode)
        {
            app.alert('กรุณาระบุ สถานพยาบาลที่ให้บริการ');
        }
        else if(!items.date_serv)
        {
            app.alert('กรุณาระบุ วันที่ให้บริการ');
        }
        else if(!items.food)
        {
            app.alert('กรุณาระบุอาหารที่รับประทาน');
        }
        else
        {
            //do save
            bc.ajax.save_service(items, function(err, v){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    $('#txt_babies_care_id').val(v.id);
                }
            });
        }
    });

    bc.set_history = function(data)
    {
        $('#tbl_babies_care_history > tbody').empty();

        if(data)
        {
            _.each(data.rows, function(v){

                $('#tbl_babies_care_history > tbody').append(
                    '<tr>' +
                        '<td>' + app.clear_null(v.date_serv) + '</td>' +
                        '<td>['+ v.hospcode +'] ' + v.hospname + '</td>' +
                        '<td>' + app.clear_null(v.result) + '</td>' +
                        '<td>' + app.clear_null(v.food) + '</td>' +
                        '<td>' + app.clear_null(v.provider_name) + '</td>' +
                        '<td><a href="#" class="btn btn-danger" data-id="'+ v.id +'" ' +
                        'data-name="btn_babies_care_remove_visit"><i class="icon-trash"></i></a></td>'+
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_babies_care_history > tbody').append(
                '<tr>' +
                    '<td colspan="5">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }
    };

    bc.get_history = function(){
        var hn = $('#txt_babies_care_hn').val();

        bc.ajax.get_history(hn, function(err, data){
            bc.set_history(data);
        });
    };

    $(document).on('click', 'a[data-name="btn_babies_care_remove_visit"]', function(){
        var id = $(this).data('id');
        var hn = $('#txt_babies_care_hn').val();

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res)
            {
                bc.ajax.remove_service(hn, id, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        bc.get_history();
                    }
                });
            }
        });
    });

    $('a[href="#tab_babies_care2"]').click(function(){
        bc.get_history();
    });

    $('#txt_babies_care_hospname').on('keyup', function(){
        $('#txt_babies_care_hospcode').val('');
    });

    $('#txt_babies_care_hospname').typeahead({
        ajax: {
            url: site_url + '/basic/search_hospital_ajax',
            timeout: 500,
            displayField: 'fullname',
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
            var name = d[0],
                code = d[1];

            $('#txt_babies_care_hospcode').val(code);

            return name;
        }
    });

    app.set_runtime();
});