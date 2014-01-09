head.ready(function(){

    var svanc = {};

    svanc.ajax = {
        save_service: function(data, cb){
            var url = 'pregnancies/anc_save_service',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_history: function(hn, gravida, cb){
            var url = 'pregnancies/anc_get_history',
                params = {
                    hn: hn,
                    gravida: gravida
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(data, cb){
            var url = 'pregnancies/anc_get_detail',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        remove_visit: function(hn, id, cb){
            var url = 'pregnancies/anc_remove_visit',
                params = {
                    hn: hn,
                    id: id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#btn_anc_save').click(function(){
        var data = {};

        var hospital = $('#txt_anc_hosp_name').select2('data');

        data.hn = $('#txt_svc_anc_hn').val();
        data.id = $('#txt_svc_anc_id').val();
        data.gravida = $('#sl_anc_gravida').val();
        data.vn = $('#txt_svc_anc_vn').val();
        data.anc_no = $('#sl_anc_no').val();
        data.ga = $('#txt_anc_ga').val();
        data.anc_result = $('#sl_anc_result').val();
        data.date_serv = $('#txt_anc_date').val();
        data.hospcode = hospital === null ? '' : hospital.code;
        data.provider_id = $('#sl_anc_providers').val();

        if(!data.gravida)
        {
            app.alert('กรุณาระบุครรภ์ที่');
        }
        else if(!data.anc_no)
        {
            app.alert('กรุณาระบุช่วงอายุครรภ์');
        }
        else if(!data.hn)
        {
            app.alert('กรุณระบุ HN');
        }
        else if(!data.date_serv)
        {
            app.alert('กรุณาระบุวันที่รับบริการ');
        }
        else if(!data.hospcode)
        {
            app.alert('กรุณาระบุสถานพยาบาลที่ให้บริการ');
        }
        else if(!data.ga)
        {
            app.alert('กรุณาระบุอายุครรภ์');
        }
        else if(!data.anc_result)
        {
            app.alert('กรุณาระบุผลการตรวจครรภ์');
        }
        else
        {
            svanc.ajax.save_service(data, function(err, v){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลเรียบร้อยแล้ว')
                    $('#txt_svc_anc_id').val(v.id);
                }
            });
        }
    });

    svanc.set_history = function(data)
    {
        $('#tbl_anc_history > tbody').empty();

        if(data)
        {
            if(_.size(data.rows) > 0)
            {
                _.each(data.rows, function(v){

                    var res = v.anc_result == '1' ? 'ปกติ' : v.anc_result == '2' ? 'ผิดปกติ' : 'ไม่ทราบ';
                    $('#tbl_anc_history > tbody').append(
                        '<tr>' +
                            '<td>' + app.clear_null(v.date_serv) + '</td>' +
                            '<td>' + app.clear_null(v.hospname) + '</td>' +
                            '<td>' + app.clear_null(data.gravida) + '</td>' +
                            '<td>' + app.clear_null(v.anc_no) + '</td>' +
                            '<td>' + app.clear_null(v.ga) + '</td>' +
                            '<td>' + app.clear_null(res) + '</td>' +
                            '<td>' + app.clear_null(v.provider_name) + '</td>' +
                            '<td><a href="#" class="btn btn-danger" data-name="btn_anc_remove2" data-hn="'+ v.hn +'" ' +
                            'data-id="'+ v.id +'" title="ลบรายการ">' +
                            '<i class="fa fa-trash-o"></i></a></td>' +
                            '</tr>'
                    );
                });
            }
            else
            {
                $('#tbl_anc_history > tbody').append(
                    '<tr>' +
                        '<td colspan="8">ไม่พบรายการ</td>' +
                        '</tr>'
                );
            }
        }
        else
        {
            $('#tbl_anc_history > tbody').append(
                '<tr>' +
                    '<td colspan="8">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }
    };

    $(document).on('click', 'a[data-name="btn_anc_remove2"]', function(e){
        var id = $(this).data('id'),
            hn = $(this).data('hn');

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res)
            {
                svanc.ajax.remove_visit(hn, id, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        var gravida = $('#sl_anc_gravida2').val();
                        svanc.get_history(hn, gravida);
                    }
                });
            }
        });

        e.preventDefault();
    });

    $('a[href="#tab_anc2"]').click(function(){
        var hn = $('#txt_svc_anc_hn').val(),
            gravida = $('#sl_anc_gravida2').select2('val');

        svanc.get_history(hn, gravida);
    });

    svanc.get_history = function(hn, gravida){
        svanc.ajax.get_history(hn, gravida, function(err, data){
            svanc.set_history(data);
        });
    };

    $('#sl_anc_gravida2').on('change', function(){
        var hn = $('#txt_svc_anc_hn').val(),
            gravida = $(this).val();

        svanc.get_history(hn, gravida);
    });


    svanc.get_detail = function(data)
    {
        svanc.ajax.get_detail(data, function(err, data){
            if(err)
            {
                app.alert(err);
            }
            else
            {
                //set anc_no
                $('#sl_anc_no').select2('val', data.rows.anc[0].anc_no);
                $('#txt_anc_ga').val(data.rows.anc[0].ga);
                $('#sl_anc_result').select2('val', data.rows.anc[0].anc_result);
                $('#sl_anc_gravida').select2('val', data.rows.gravida);
            }
        });
    };

    $('#txt_anc_hosp_name').select2({
        placeholder: 'ชื่อ หรือ รหัสสถานบริการ',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_hospital_ajax",
            dataType: 'json',
            type: 'POST',
            quietMillis: 100,
            data: function (term) {
                return {
                    query: term,
                    csrf_token: csrf_token
                };
            },
            results: function (data)
            {
                return { results: data.rows, more: (data.rows && data.rows.length == 10 ? true : false) };
            }
            //dropdownCssClass: "bigdrop"
        },

        id: function(data) { return { id: data.code } },

        formatResult: function(data) {
            return '[' + data.code + '] ' + data.name;
        },
        formatSelection: function(data) {
            return '[' + data.code + '] ' + data.name;
        },
        initSelection: function(el, cb) {
            //var eltxt = $(el).val();
            //cb({'term': eltxt });
        }
    });

//    $('#txt_anc_hosp_name').on('keyup', function(){
//        $('#txt_anc_hosp_code').val('');
//    });
//
//    $('#txt_anc_hosp_name').typeahead({
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
//            $('#txt_anc_hosp_code').val(code);
//
//            return name;
//        }
//    });

    svanc.set_hospital_selected = function() {
        var hospcode = $('#txt_svc_anc_hospcode1').val();
        var hospname = $('#txt_svc_anc_hospname1').val();

        if(hospcode) {
            $('#txt_anc_hosp_name').select2('data', {code: hospcode, name: hospname});
            $('#txt_anc_hosp_name').select2('enable', false);
        }
    };

    svanc.set_hospital_selected();
    app.set_runtime();
});