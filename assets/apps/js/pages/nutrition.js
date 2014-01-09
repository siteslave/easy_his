head.ready(function(){

    var nutris = {};
    nutris.hn = $('#txt_nutri_hn').val();
    nutris.vn = $('#txt_nutri_vn').val();

    nutris.ajax = {
        save: function(items, cb){

            var url = 'nutrition/save',
                params = {
                    data: items
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_history: function(hn, cb){

            var url = 'nutrition/history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#txt_nutri_hospname').select2({
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

    $('#btn_nutri_save').click(function(){
        var data = {};
        var hos = $('#txt_nutri_hospname').select2('data');

        data.height = $('#txt_nutri_height').val();
        data.weight = $('#txt_nutri_weight').val();
        data.headcircum = $('#txt_nutri_headcircum').val();
        data.childdevelop = $('#sl_nutri_childdevelop').val();
        data.food = $('#sl_nutri_food').val();
        data.bottle = $('#sl_nutri_bottle').val();
        data.provider_id = $('#sl_nutri_providers').val();
        data.hospcode = hos === null ? '' : hos.code;
        data.date_serv = $('#txt_fp_date').val();

        data.id = $('#txt_nutri_id').val();

        data.vn = nutris.vn;
        data.hn = nutris.hn;

        if(!data.height)
        {
            app.alert('กรุณาระบุส่วนสูง');
        }
        else if(!data.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!data.date_serv)
        {
            app.alert('กรุณาระบุวันที่รับบริการ');
        }
        else if(!data.weight)
        {
            app.alert('กรุณาระบุน้ำหนัก');
        }
        else if(!data.headcircum)
        {
            app.alert('กรุณาระบุเส้นรอบศีรษะ');
        }
        else if(!data.childdevelop)
        {
            app.alert('กรุณาระบุดรับดับพัฒนาการ');
        }
        else if(!data.food)
        {
            app.alert('กรุณาระบุอาหารที่รับประทาน');
        }
        else if(!data.bottle)
        {
            app.alert('กรุณาระบุการใช้ขวดนม');
        }
        else if(!data.hospcode)
        {
            app.alert('กรุณาระบุสถานพยาบาลที่ให้บริการ');
        }
        else
        {
            nutris.ajax.save(data, function(err, v){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    $('#txt_nutri_id').val(v.id);
                }
            });
        }

    });

    $('a[href="#tab_nutri2"]').on('click', function(){
        nutris.get_history();
    });

    nutris.get_history = function() {
        var hn = nutris.hn;

        $('#tbl_nutri_history > tbody').empty();

        nutris.ajax.get_history(hn, function(err, data){
            if(err)
            {
                app.alert(err);
                $('#tbl_nutri_history > tbody').append('<tr><td colspan="7">ไม่พบรายการ</td></tr>');
            }
            else
            {
                nutris.set_history(data);
            }
        });
    };

    nutris.set_history = function(data) {
        if(_.size(data.rows))
        {
            _.each(data.rows, function(v) {
                $('#tbl_nutri_history > tbody').append(
                    '<tr>' +
                        '<td>'+app.clear_null(v.date_serv)+'</td>' +
                        '<td>['+app.clear_null(v.hospcode)+'] '+app.clear_null(v.hospname)+'</td>' +
                        '<td>'+app.clear_null(v.weight)+'</td>' +
                        '<td>'+app.clear_null(v.height)+'</td>' +
                        '<td>'+app.clear_null(v.food)+'</td>' +
                        '<td>'+app.clear_null(v.childdevelop)+'</td>' +
                        '<td>'+app.clear_null(v.provider)+'</td>' +
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_nutri_history > tbody').append('<tr><td colspan="7">ไม่พบรายการ</td></tr>');
        }
    };

    nutris.set_hospital_selected = function() {
        var vn = $('#txt_nutri_vn').val();
        var hospcode = $('#txt_nutri_hospcode1').val();

        if(vn && hospcode) {
            var hospname = $('#txt_nutri_hospname1').val();
            $('#txt_nutri_hospname').select2('data', {code: hospcode, name: hospname});
            $('#txt_nutri_hospname').select2('enable', false);
        } else if(vn && !hospcode) {
            var code = $('#txt_nutri_owner_code').val(),
                name = $('#txt_nutri_owner_name').val();

            $('#txt_nutri_hospname').select2('data', {code: code, name: name});
            $('#txt_nutri_hospname').select2('enable', false);
        }
    };

    nutris.set_hospital_selected();

    app.set_runtime();

});