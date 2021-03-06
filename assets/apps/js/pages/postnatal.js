head.ready(function(){

    var postnatals = {};

    postnatals.ajax = {
        get_history: function(hn, cb){
            var url = 'pregnancies/postnatal_get_history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
         save_service: function(data, cb){
            var url = 'pregnancies/postnatal_save_service',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
         remove_service: function(hn, id, cb){
            var url = 'pregnancies/postnatal_remove_service',
                params = {
                    hn: hn,
                    id: id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#btn_postnatal_save').click(function(){
        var items = {};

        var hospital = $('#txt_postnatal_hospname').select2('data');

        items.hn = $('#txt_postnatal_hn').val();
        items.gravida = $('#sl_postnatal_gravida').val();
        items.vn = $('#txt_postnatal_vn').val();
        items.ppresult = $('#sl_postnatal_ppresult').val();
        items.sugar = $('#sl_postnatal_sugar').val();
        items.albumin = $('#sl_postnatal_albumin').val();
        items.amniotic_fluid = $('#sl_postnatal_amniotic_fluid').val();
        items.perineal = $('#sl_postnatal_perineal').val();
        items.uterus = $('#sl_postnatal_uterus').val();
        items.tits = $('#sl_postnatal_tits').val();

        items.date_serv = $('#txt_postnatal_date').val();
        items.hospcode = hospital == null ? '' : hospital.code;
        items.provider_id = $('#sl_postnatal_providers').val();

        items.id = $('#txt_postnatal_id').val();

        if(!items.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!items.date_serv)
        {
            app.alert('กรุณาระบุ วันที่รับบริการ');
        }
        else if(!items.hospcode)
        {
            app.alert('กรุณาระบุ สถานพยาบาลที่ให้บริการ');
        }
        else if(!items.gravida)
        {
            app.alert('กรุณาระบุครรภ์ที่');
        }
        else if(!items.ppresult)
        {
            app.alert('กรุณาระบุผลการตรวจ');
        }
        else
        {
            postnatals.ajax.save_service(items, function(err, v){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                    $('#txt_postnatal_id').val(v.id);
                }
            });
        }
    });

    postnatals.set_history = function(data)
    {
        $('#tbl_postnatal_history > tbody').empty();

        if(data)
        {
            if(_.size(data.rows) > 0)
            {
                _.each(data.rows, function(v){

                    var res = v.ppresult == '1' ? 'ปกติ' : v.anc_result == '2' ? 'ผิดปกติ' : 'ไม่ทราบ';
                    $('#tbl_postnatal_history > tbody').append(
                        '<tr>' +
                            '<td>' + app.clear_null(v.date_serv) + '</td>' +
                            '<td>' + app.clear_null(v.hospname) + '</td>' +
                            '<td>' + app.clear_null(data.gravida) + '</td>' +
                            '<td>' + app.clear_null(res) + '</td>' +
                            '<td>' + app.clear_null(v.provider_name) + '</td>' +
                            '<td><a href="#" class="btn btn-danger" data-name="btn_remove_mother_care1" title="ลบรายการ" ' +
                            'data-id="' + v.id + '"><i class="fa fa-trash-o"></i></td>' +
                            '</tr>'
                    );
                });
            }
            else
            {
                $('#tbl_postnatal_history > tbody').append(
                    '<tr>' +
                        '<td colspan="6">ไม่พบรายการ</td>' +
                        '</tr>'
                );
            }
        }
        else
        {
            $('#tbl_postnatal_history > tbody').append(
                '<tr>' +
                    '<td colspan="6">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }
    };


    $(document).on('click', 'a[data-name="btn_remove_mother_care1"]', function(e){
        var id = $(this).data('id'),
            hn = $('#txt_postnatal_hn').val();

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res)
            {
                postnatals.ajax.remove_service(hn, id, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        postnatals.get_history();
                    }
                });
            }
        });
    });

    $('a[href="#tab_postnatal2"]').click(function(){
        postnatals.get_history();
    });

    postnatals.get_history = function() {
        var hn = $('#txt_postnatal_hn').val();

        postnatals.ajax.get_history(hn, function(err, data){
            postnatals.set_history(data);
        });
    };

    $('#txt_postnatal_hospname').select2({
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

//    $('#txt_postnatal_hospname').typeahead({
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
//            $('#txt_postnatal_hospcode').val(code);
//
//            return name;
//        }
//    });

    postnatals.set_hospital_selected = function() {

        var vn = $('#txt_postnatal_vn').val();
        var hospcode = $('#txt_postnatal_hospcode1').val(),
            hospname = $('#txt_postnatal_hospname1').val();

        if(vn && hospcode) {
            var hospcode = $('#txt_postnatal_hospcode1').val(),
                hospname = $('#txt_postnatal_hospname1').val();

            $('#txt_postnatal_hospname').select2('data', {code: hospcode, name: hospname});
            $('#txt_postnatal_hospname').select2('enable', false);
        } else if(vn && !hospcode) {

            var code = $('#txt_postnatal_owner_code').val(),
                name = $('#txt_postnatal_owner_name').val();

            $('#txt_postnatal_hospname').select2('data', {code: code, name: name});
            $('#txt_postnatal_hospname').select2('enable', false);
        }
    };

    postnatals.set_hospital_selected();

    app.set_runtime();
});