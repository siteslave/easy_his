/**
 * Service Special PP script
 */
head.ready(function(){
    var spp = {};

    spp.ajax = {
        get_history: function(hn, cb){
            var url = 'spp/get_service_history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(data, cb){
            var url = 'spp/get_service_detail',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        save_service: function(data, cb){
            var url = 'spp/save_service',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    spp.modal = {
        show_new: function()
        {
            $('#mdl_special_pp').modal({
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
            $('#mdl_special_pp').modal('hide');
        }
    };


    spp.get_detail = function(data)
    {
        spp.ajax.get_detail(data, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
               $('#sl_spp_servplace').val(data.rows.servplace);
               $('#sl_spp_ppspecial').val(data.rows.ppspecial);
           }
        });
    };

    $('a[data-name="btn_specialpp"]').click(function(){
        var data = {};

        data.vn = $('#vn').val(),
        data.hn = $('#hn').val();

        $('a[href="#tab_special_pp1"]').tab('show');
        spp.get_detail(data);
        spp.modal.show_new();
    });

    spp.set_history = function(data)
    {
        $('#tbl_special_pp_history > tbody').empty();

        if(data)
        {
            _.each(data.rows, function(v){

                $('#tbl_special_pp_history > tbody').append(
                    '<tr>' +
                        '<td>' + app.mongo_to_thai_date(v.date_serv) + '</td>' +
                        '<td>' + app.clear_null(v.owner_name) + '</td>' +
                        '<td>' + app.clear_null(v.ppspecial_name) + '</td>' +
                        '<td>' + app.clear_null(v.servplace_name) + '</td>' +
                        '<td>' + app.clear_null(v.provider_name) + '</td>' +
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_special_pp_history > tbody').append(
                '<tr>' +
                    '<td colspan="5">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }
    };

    $('a[href="#tab_special_pp2"]').click(function(){
        var hn = $('#hn').val()

        spp.ajax.get_history(hn, function(err, data){
           spp.set_history(data);
        });
    });

    $('#btn_special_pp_save').click(function(){
       var data = {};
        data.vn = $('#vn').val();
        data.hn = $('#hn').val();
        data.servplace = $('#sl_spp_servplace').val();
        data.ppspecial = $('#sl_spp_ppspecial').val();

        if(!data.servplace)
        {
            app.alert('กรุณาระบุสถานที่ตรวจ');
        }
        else if(!data.ppspecial)
        {
            app.alert('กรุณาระบุประเภทการให้บริการ');
        }
        else
        {
            //do save
            spp.ajax.save_service(data, function(err){
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