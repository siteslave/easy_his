head.ready(function(){
    var vaccs = {};

    vaccs.hn = $('#txt_vaccs_hn').val();

    vaccs.ajax = {
        get_history: function(hn, cb){
            var url = 'epis/history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        save: function(data, cb){
            var url = 'epis/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#txt_vaccs_hosp_name').on('keyup', function(){
        $('#txt_vaccs_hosp_code').val('');
    });

    $('#txt_vaccs_hosp_name').typeahead({
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

            $('#txt_vaccs_hosp_code').val(code);

            return name;
        }
    });


    $('#btn_vaccs_save').click(function(){
        var items = {};

        items.id = $('#txt_vaccs_id').val();
        items.hn = $('#txt_vaccs_hn').val();
        items.vn = $('#txt_vaccs_vn').val();
        items.vaccine_id = $('#sl_vaccs_vaccine_id').val();
        items.lot = $('#txt_vaccs_lot').val();
        items.expire = $('#txt_vaccs_expire_date').val()
        items.provider_id = $('#sl_vaccs_providers').val()
        items.date_serv = $('#txt_vaccs_date').val()
        items.hospcode = $('#txt_vaccs_hosp_code').val()

        if(!items.vaccine_id)
        {
            app.alert('กรุณาเลือกวัคซีนที่ต้องการ');
        }
        else if(!items.date_serv)
        {
            app.alert('กรุณาระบุวันที่รับบริการ');
        }
        else if(!items.hospcode)
        {
            app.alert('กรุณาระบุสถานพยาบาลที่ให้บริการ');
        }
        else if(!items.provider_id)
        {
            app.alert('กรุณาระบุเจ้าหน้าที่หรือแพทย์ผู้ให้บริการ');
        }
        else if(!items.lot)
        {
            app.alert('กรุณาระบุ Lot number.');
        }
        else if(!items.hn)
        {
            app.alert('กรุณาระบ HN.');
        }
        else
        {
            vaccs.ajax.save(items, function(err, data){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลวัคซีนเสร็จเรียบร้อยแล้ว');
                    $('#txt_vaccs_id').val(data.id);
                    $('#sl_vaccs_vaccine_id').prop('disabled', true).css('background-color', 'white');
                }
            });
        }
    });

    vaccs.get_history = function(){

        $('#tbl_vaccs_history > tbody').empty();

        vaccs.ajax.get_history(vaccs.hn, function(err, data){
            if(err)
            {
                app.alert(err);
                $('#tbl_vaccs_history > tbody').append('<tr><td colspan="6">ไม่พบรายการ</td></tr>');
            }
            else
            {
                vaccs.set_history(data);
            }
        });
    };

    vaccs.set_history = function(data){
        if(_.size(data.rows))
        {
            _.each(data.rows, function(v){
                $('#tbl_vaccs_history > tbody').append(
                    '<tr>' +
                        '<td>'+ v.date_serv +'</td>' +
                        '<td>'+ app.clear_null(v.vaccine_name) +'</td>' +
                        '<td>'+ app.clear_null(v.lot) +'</td>' +
                        '<td>'+ app.clear_null(v.expire) +'</td>' +
                        '<td>['+ v.hospcode +'] ' + v.hospname + '</td>' +
                        '<td>' + v.provider_name + '</td>' +
                        '</tr>');
            });
        }
        else
        {
            $('#tbl_vaccs_history > tbody').append('<tr><td colspan="6">ไม่พบรายการ</td></tr>');
        }
    };

    $('a[href="#tab_epi2"]').on('click', function(){
        vaccs.get_history();
    });

    app.set_runtime();
});