head.ready(function(){

    var spps = {};

    spps.ajax = {
        get_history: function(hn, cb){
            var url = 'spp/get_history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_visit_history: function(hn, vn, cb){
            var url = 'spp/get_visit_history',
                params = {
                    hn: hn,
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        save_service: function(data, cb){
            var url = 'spp/save_service',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        remove_visit: function(id, cb){
            var url = 'spp/remove_visit',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    spps.get_history = function() {
        var hn = $('#txt_ssp_hn').val();
        spps.ajax.get_history(hn, function(err, data) {
            if(err)
            {
                app.alert(err);
            }
            else
            {
                spps.set_history(data);
            }
        });
    };

    spps.get_visit_history = function() {
        var hn = $('#txt_ssp_hn').val();
        var vn = $('#txt_ssp_vn').val();
        spps.ajax.get_visit_history(hn, vn, function(err, data) {
            if(err)
            {
                app.alert(err);
            }
            else
            {
                spps.set_visit_history(data);
            }
        });
    };

    spps.set_history = function(items)
    {
        $('#tbl_special_pp_history > tbody').empty();

        if(items)
        {
            _.each(items.rows, function(v){

                $('#tbl_special_pp_history > tbody').append(
                    '<tr>' +
                        '<td>' + app.clear_null(v.date_serv) + '</td>' +
                        '<td>['+ v.hospcode +'] ' + v.hospname + '</td>' +
                        '<td>' + app.clear_null(v.ppspecial_name) + '</td>' +
                        '<td>' + app.clear_null(v.servplace_name) + '</td>' +
                        '<td>' + app.clear_null(v.provider_name) + '</td>' +
                        /*'<td><a href="#" class="btn btn-danger" data-name="btn_remove_spp_visit" ' +
                        'title="ลบรายการ" data-id="'+ v.id +'"><i class="icon-trash"></i></a></td>' +*/
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_special_pp_history > tbody').append(
                '<tr>' +
                    '<td colspan="5">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }
    };
    spps.set_visit_history = function(items)
    {
        $('#tbl_visit_ssp > tbody').empty();

        if(items)
        {
            var i = 1;
            _.each(items.rows, function(v){

                $('#tbl_visit_ssp > tbody').append(
                    '<tr>' +
                        '<td>' + i + '</td>' +
                        '<td>['+ v.hospcode +'] ' + v.hospname + '</td>' +
                        '<td>' + app.clear_null(v.ppspecial_name) + '</td>' +
                        '<td>' + app.clear_null(v.servplace_name) + '</td>' +
                        '<td>' + app.clear_null(v.provider_name) + '</td>' +
                        '<td><a href="#" class="btn btn-danger" data-name="btn_remove_visit_spp" ' +
                        'title="ลบรายการ" data-id="'+ v.id +'"><i class="icon-trash"></i></a></td>' +
                        '</tr>'
                );

                i++;
            });
        }
        else
        {
            $('#tbl_visit_ssp > tbody').append(
                '<tr>' +
                    '<td colspan="5">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }
    };

    $(document).on('click', 'a[data-name="btn_remove_visit_spp"]', function(){
        var id = $(this).data('id');
        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res)
            {
                spps.ajax.remove_visit(id, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        spps.get_visit_history();
                    }
                });
            }
        });
    });

    $('a[href="#tab_special_pp2"]').click(function(){
        spps.get_history();
    });

    $('#btn_special_pp_save').click(function(){
        var items = {};
        items.vn = $('#txt_ssp_vn').val();
        items.hn = $('#txt_ssp_hn').val();
        items.servplace = $('#sl_spp_servplace').val();
        items.ppspecial = $('#sl_spp_ppspecial').val();
        items.hospcode = $('#txt_spp_hospcode').val();
        items.date_serv = $('#txt_spp_date').val();
        items.provider_id = $('#sl_spp_providers').val();
        items.id = $('#txt_ssp_id').val();

        if(!items.servplace)
        {
            app.alert('กรุณาระบุสถานที่ตรวจ');
        }
        else if(!items.ppspecial)
        {
            app.alert('กรุณาระบุประเภทการให้บริการ');
        }
        else if(!items.date_serv)
        {
            app.alert('กรุณาระบุวันที่ให้บริการ');
        }
        else if(!items.hospcode)
        {
            app.alert('กรุณาระบุสถานพยาบาลที่ให้บริการ');
        }
        else
        {
            //do save
            spps.ajax.save_service(items, function(err, v){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    $('#txt_ssp_id').val(v.id);
                    spps.get_visit_history();

                    spps.clear_form();
                }
            });
        }
    });

    spps.clear_form = function() {
        app.set_first_selected($('#sl_spp_servplace'));
        app.set_first_selected($('#sl_spp_ppspecial'));
        app.set_first_selected($('#sl_spp_providers'));
    };

    $('#txt_spp_hospname').on('keyup', function(){
        $('#txt_spp_hospcode').val('');
    });

    $('#txt_spp_hospname').typeahead({
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

            $('#txt_spp_hospcode').val(code);

            return name;
        }
    });

    spps.get_visit_history();

    app.set_runtime();
});