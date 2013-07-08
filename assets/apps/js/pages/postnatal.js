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
        items.hospcode = $('#txt_postnatal_hospcode').val();
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
                            '<td><a href="#" class="btn btn-danger" data-name="btn_remove_mother_care" title="ลบรายการ" ' +
                            'data-id="' + v.id + '"><i class="icon-trash"></i></td>' +
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


    $(document).on('click', 'a[data-name="btn_remove_mother_care"]', function(e){
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

    $('#txt_postnatal_hospname').on('keyup', function(){
        $('#txt_postnatal_hospcode').val('');
    });

    $('#txt_postnatal_hospname').typeahead({
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

            $('#txt_postnatal_hospcode').val(code);

            return name;
        }
    });

    app.set_runtime();
});