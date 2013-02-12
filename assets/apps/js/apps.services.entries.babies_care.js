/**
 * Service EPI script
 */
head.ready(function(){
    var babies = {};

    babies.ajax = {
        check_registration: function(hn, cb){
            var url = 'babies/check_registration',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_history: function(hn, cb){
            var url = 'babies/get_service_history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(data, cb){
            var url = 'babies/get_service_detail',
                params = {
                    data: data
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
        }
    };

    babies.modal = {
        show_new: function()
        {
            $('#mdl_babies_care').modal({
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
            $('#mdl_babies_care').modal('hide');
        }
    };


    babies.get_detail = function(data)
    {
        babies.ajax.get_detail(data, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {

           }
        });
    };

    $('a[data-name="btn_baby_care"]').click(function(){
        var data = {};

        data.vn = $('#vn').val(),
        data.hn = $('#hn').val();

        babies.ajax.check_registration(data.hn, function(err){
           if(err)
           {
               app.alert('ข้อมูลนี้ยังไม่ได้ถูกลงทะเบียนกรุณาลงทะเบียนก่อนการให้บริการ');
           }
           else
           {
               //babies.get_detail(data);
               babies.modal.show_new();
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


    babies.set_history = function(data)
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

    $('#btn_babies_care_save').click(function(){
       var data = {};
        data.vn = $('#vn').val();
        data.hn = $('#hn').val();
        data.result = $('#sl_babies_care_result').val();
        data.food = $('#sl_babies_care_food').val();

        if(!data.result)
        {
            app.alert('กรุณาระบุผลการตรวจ');
        }
        else if(!data.food)
        {
            app.alert('กรุณาระบุอาหารที่รับประทาน');
        }
        else
        {
            //do save

        }
    });
});
//End file