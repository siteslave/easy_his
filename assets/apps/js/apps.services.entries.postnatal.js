/**
 * Service Postnatal script
 */
head.ready(function(){
    var postnatal = {};

    postnatal.ajax = {
        check_registration: function(hn, cb){
            var url = 'pregnancies/check_registration',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_history: function(hn, cb){
            var url = 'pregnancies/postnatal_get_history',
                params = {
                    hn: hn
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
            var url = 'pregnancies/postnatal_get_detail',
                params = {
                    data: data
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
        }
    };

    postnatal.modal = {
        show_new: function()
        {
            $('#mdl_postnatal').modal({
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
            $('#mdl_postnatal').modal('hide');
        }
    };


    postnatal.get_detail = function(data)
    {
        postnatal.ajax.get_detail(data, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
               $('#sl_postnatal_gravida').val(data.rows.gravida);
               $('#sl_postnatal_ppresult').val(data.rows.postnatal[0].ppresult);
                $('#sl_postnatal_sugar').val(data.rows.postnatal[0].sugar);
               $('#sl_postnatal_albumin').val(data.rows.postnatal[0].albumin);
               $('#sl_postnatal_amniotic_fluid').val(data.rows.postnatal[0].amniotic_fluid);
               $('#sl_postnatal_perineal').val(data.rows.postnatal[0].perineal);
               $('#sl_postnatal_uterus').val(data.rows.postnatal[0].uterus);
               $('#sl_postnatal_tits').val(data.rows.postnatal[0].tits);
           }
        });
    };

    postnatal.set_gravida_select = function(data)
    {
        $('#sl_postnatal_gravida').empty();
        _.each(data.rows, function(v){
            $('#sl_postnatal_gravida').append(
                '<option value="'+ v.gravida +'">' + v.gravida + '</option>'
            );
        });

    };
    $('a[data-name="btn_postnatal"]').click(function(){
        var data = {};

        data.vn = $('#vn').val(),
        data.hn = $('#hn').val();

        postnatal.ajax.check_registration(data.hn, function(err){
           if(err)
           {
               app.alert('ข้อมูลนี้ยังไม่ได้ถูกลงทะเบียนกรุณาลงทะเบียนก่อนการให้บริการ');
           }
           else
           {
               postnatal.ajax.get_gravida(data.hn, function(err, data){
                  postnatal.set_gravida_select(data);
               });
               //get detail
               postnatal.get_detail(data);
               postnatal.modal.show_new();
           }
        });
    });

    $('#btn_postnatal_save').click(function(){
        var data = {};

        data.hn = $('#hn').val();
        data.gravida = $('#sl_postnatal_gravida').val();
        data.vn = $('#vn').val();
        data.ppresult = $('#sl_postnatal_ppresult').val();
        data.sugar = $('#sl_postnatal_sugar').val();
        data.albumin = $('#sl_postnatal_albumin').val();
        data.amniotic_fluid = $('#sl_postnatal_amniotic_fluid').val();
        data.perineal = $('#sl_postnatal_perineal').val();
        data.uterus = $('#sl_postnatal_uterus').val();
        data.tits = $('#sl_postnatal_tits').val();

        if(!data.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!data.vn)
        {
            app.alert('กรุณาระบุ เลขที่รับบริการ (VN)');
        }
        else if(!data.gravida)
        {
            app.alert('กรุณาระบุครรภ์ที่');
        }
        else if(!data.ppresult)
        {
            app.alert('กรุณาระบุผลการตรวจ');
        }
        else
        {
            postnatal.ajax.save_service(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
               else
               {
                   app.alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                   postnatal.modal.hide_new();
               }
            });
        }
    });

    postnatal.set_history = function(data)
    {
        $('#tbl_postnatal_history > tbody').empty();

        if(data)
        {
            _.each(data.rows, function(v){

                var res = v.ppresult == '1' ? 'ปกติ' : v.anc_result == '2' ? 'ผิดปกติ' : 'ไม่ทราบ';
                $('#tbl_postnatal_history > tbody').append(
                    '<tr>' +
                        '<td>' + app.mongo_to_thai_date(v.date_serv) + '</td>' +
                        '<td>' + app.clear_null(v.owner_name) + '</td>' +
                        '<td>' + app.clear_null(data.gravida) + '</td>' +
                        '<td>' + app.clear_null(res) + '</td>' +
                        '<td>' + app.clear_null(v.provider_name) + '</td>' +
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_postnatal_history > tbody').append(
                '<tr>' +
                    '<td colspan="5">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }



    };

    $('a[href="#tab_postnatal2"]').click(function(){
        var hn = $('#hn').val();

        postnatal.ajax.get_history(hn, function(err, data){
           postnatal.set_history(data);
        });
    });
});
//End file