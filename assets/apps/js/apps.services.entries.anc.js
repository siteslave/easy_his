/**
 * Service EPI script
 */
head.ready(function(){
    var anc = {};

    anc.ajax = {
        check_registration: function(hn, cb){
            var url = 'pregnancies/check_registration',
                params = {
                    hn: hn
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
        get_gravida: function(hn, cb){
            var url = 'pregnancies/get_gravida',
                params = {
                    hn: hn
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
        save_service: function(data, cb){
            var url = 'pregnancies/anc_save_service',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    anc.modal = {
        show_new: function()
        {
            $('#mdl_anc').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },

        hide_new: function()
        {
            $('#mdl_anc').modal('hide');
        }
    };


    anc.get_detail = function(data)
    {
        anc.ajax.get_detail(data, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
               //set anc_no
                $('#sl_anc_no').val(data.rows.anc[0].anc_no);
                $('#txt_anc_ga').val(data.rows.anc[0].ga);
                $('#sl_anc_result').val(data.rows.anc[0].anc_result);
               $('#sl_anc_gravida').val(data.rows.gravida);
           }
        });
    };

    anc.set_gravida_select = function(data)
    {
        $('#sl_anc_gravida').empty();
        $('#sl_anc_gravida').append('<option value="">- ระบุ -</option>');
        _.each(data.rows, function(v){
            $('#sl_anc_gravida').append(
                '<option value="'+ v.gravida +'">' + v.gravida + '</option>'
            );
        });

        $('#sl_anc_gravida2').empty();
        $('#sl_anc_gravida2').append('<option value="">- ระบุ -</option>');
        _.each(data.rows, function(v){
            $('#sl_anc_gravida2').append(
                '<option value="'+ v.gravida +'">' + v.gravida + '</option>'
            );
        });

    };
    $('a[data-name="btn_anc"]').click(function(){
        var data = {};

        data.vn = $('#vn').val(),
        data.hn = $('#hn').val();

        anc.ajax.check_registration(data.hn, function(err){
           if(err)
           {
               app.alert('ข้อมูลนี้ยังไม่ได้ถูกลงทะเบียนกรุณาลงทะเบียนก่อนการให้บริการ');
           }
           else
           {
               anc.ajax.get_gravida(data.hn, function(err, data){
                  anc.set_gravida_select(data);
               });
               //get detail
               anc.get_detail(data);
               anc.modal.show_new();
           }
        });
    });

    $('#btn_anc_save').click(function(){
        var data = {};

        data.hn = $('#hn').val();
        data.gravida = $('#sl_anc_gravida').val();
        data.vn = $('#vn').val();
        data.anc_no = $('#sl_anc_no').val();
        data.ga = $('#txt_anc_ga').val();
        data.anc_result = $('#sl_anc_result').val();

        if(!data.anc_no)
        {
            app.alert('กรุณาระบุครรภ์ที่');
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
            anc.ajax.save_service(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
               else
               {
                   app.alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                   anc.modal.hide_new();
               }
            });
        }
    });

    anc.set_history = function(data)
    {
        $('#tbl_anc_history > tbody').empty();

        if(data)
        {
            _.each(data.rows, function(v){

                var res = v.anc_result == '1' ? 'ปกติ' : v.anc_result == '2' ? 'ผิดปกติ' : 'ไม่ทราบ';
                $('#tbl_anc_history > tbody').append(
                    '<tr>' +
                        '<td>' + app.mongo_to_thai_date(v.date_serv) + '</td>' +
                        '<td>' + app.clear_null(v.owner_name) + '</td>' +
                        '<td>' + app.clear_null(data.gravida) + '</td>' +
                        '<td>' + app.clear_null(v.anc_no) + '</td>' +
                        '<td>' + app.clear_null(v.ga) + '</td>' +
                        '<td>' + app.clear_null(res) + '</td>' +
                        '<td>' + app.clear_null(v.provider_name) + '</td>' +
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_anc_history > tbody').append(
                '<tr>' +
                    '<td colspan="7">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }



    };

    $('a[href="#tab_anc2"]').click(function(){
        var hn = $('#hn').val(),
            gravida = $('#sl_anc_gravida2').val();

        anc.ajax.get_history(hn, gravida, function(err, data){
           anc.set_history(data);
        });
    });

    $('#sl_anc_gravida2').on('change', function(){
        var hn = $('#hn').val(),
            gravida = $(this).val();

        anc.ajax.get_history(hn, gravida, function(err, data){
            anc.set_history(data);
        });
    });
});
//End file