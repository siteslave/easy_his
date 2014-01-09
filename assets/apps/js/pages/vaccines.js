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

    $('#txt_vaccs_hosp_name').select2({
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

    $('#btn_vaccs_save').click(function(){
        var items = {};

        var hosp = $('#txt_vaccs_hosp_name').select2('data');

        items.id = $('#txt_vaccs_id').val();
        items.hn = $('#txt_vaccs_hn').val();
        items.vn = $('#txt_vaccs_vn').val();
        items.vaccine_id = $('#sl_vaccs_vaccine_id').val();
        items.lot = $('#txt_vaccs_lot').val();
        items.expire = $('#txt_vaccs_expire_date').val()
        items.provider_id = $('#sl_vaccs_providers').val()
        items.date_serv = $('#txt_vaccs_date').val()
        items.hospcode = hosp === null ? '' : hosp.code;

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
            vaccs.ajax.save(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลวัคซีนเสร็จเรียบร้อยแล้ว');
                    //parent.epis.get_list();
                    //parent.epis.modal.hide_new();
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

    vaccs.set_hospital_selected = function() {
        var hospcode = $('#txt_vaccs_hospcode').val(),
            hospname = $('#txt_vaccs_hospname').val();

        if(hospcode) {
            $('#txt_vaccs_hosp_name').select2('data', {code: hospcode, name: hospname});
        } else {
            $('#txt_vaccs_hosp_name').select2('val', '');
        }

    };

    vaccs.set_hospital_selected();

    app.set_runtime();
});