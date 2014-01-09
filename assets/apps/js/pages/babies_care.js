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
        var hospital = $('#txt_babies_care_hospname').select2('data');

        items.vn = $('#txt_babies_care_vn').val();
        items.hn = $('#txt_babies_care_hn').val();
        items.id = $('#txt_babies_care_id').val();
        items.result = $('#sl_babies_care_result').val();
        items.food = $('#sl_babies_care_food').val();
        items.provider_id = $('#sl_babies_care_providers').val();
        items.hospcode = hospital.code;
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
                        '<td>' +
                        '<a href="#" class="btn btn-danger" data-id="'+ v.id +'" ' +
                        ' data-name="btn_babies_care_remove_visit1"><i class="fa fa-trash-o"></i></a>' +
                        '</td>'+
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_babies_care_history > tbody').append(
                '<tr>' +
                    '<td colspan="6">ไม่พบรายการ</td>' +
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

    $(document).on('click', 'a[data-name="btn_babies_care_remove_visit1"]', function(){
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
    $('#txt_babies_care_hospname').select2({
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

    bc.set_hospital_selected = function() {
        var vn = $('#txt_babies_care_vn').val();
        var hospcode = $('#txt_babies_care_hospcode1').val();

        if(vn && hospcode) {
            var hospname = $('#txt_babies_care_hospname1').val();

            $('#txt_babies_care_hospname').select2('data', {code: hospcode, name: hospname});
            $('#txt_babies_care_hospname').select2('enable', false);
        } else if(vn && !hospcode) {
            var code = $('#txt_babies_care_owner_code').val(),
                name = $('#txt_babies_care_owner_name').val();

            $('#txt_babies_care_hospname').select2('data', {code: code, name: name});
            $('#txt_babies_care_hospname').select2('enable', false);
        }

    };

    bc.set_hospital_selected();

    app.set_runtime();
});