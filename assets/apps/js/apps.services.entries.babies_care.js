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
               $('#sl_babies_care_result').val(data.rows[0].bcareresult);
               $('#sl_babies_care_food').val(data.rows[0].food);
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
               $('a[href="#tab_babies_care1"]').tab('show');
               babies.get_detail(data);
               babies.modal.show_new();
           }
        });
    });

    babies.set_history = function(data)
    {
        $('#tbl_babies_care_history > tbody').empty();

        if(data)
        {
            _.each(data.rows, function(v){

                $('#tbl_babies_care_history > tbody').append(
                    '<tr>' +
                        '<td>' + app.mongo_to_thai_date(v.date_serv) + '</td>' +
                        '<td>' + app.clear_null(v.owner_name) + '</td>' +
                        '<td>' + app.clear_null(v.bcareresult) + '</td>' +
                        '<td>' + app.clear_null(v.food) + '</td>' +
                        '<td>' + app.clear_null(v.provider_name) + '</td>' +
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_babies_care_history > tbody').append(
                '<tr>' +
                    '<td colspan="5">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }
    };

    $('a[href="#tab_babies_care2"]').click(function(){
        var hn = $('#hn').val()

        babies.ajax.get_history(hn, function(err, data){
           babies.set_history(data);
        });
    });

    $('#btn_babies_care_save').click(function(){
       var data = {};
        data.vn = $('#vn').val();
        data.hn = $('#hn').val();
        data.bcareresult = $('#sl_babies_care_result').val();
        data.food = $('#sl_babies_care_food').val();

        if(!data.bcareresult)
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
            babies.ajax.save_service(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
               else
               {
                    app.alert('การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
               }
            });
        }
    });
});
//End file