/**
 * Service Community service script
 */
head.ready(function(){
    var comms = {};

    comms.ajax = {
        get_history: function(hn, cb){
            var url = 'comms/get_service_history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(data, cb){
            var url = 'comms/get_service_detail',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        save_service: function(data, cb){
            var url = 'comms/save_service',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    comms.modal = {
        show_new: function()
        {
            $('#mdl_comms').modal({
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
            $('#mdl_comms').modal('hide');
        }
    };


    comms.get_detail = function(data)
    {
        comms.ajax.get_detail(data, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
               $('#sl_comms').val(data.rows.comservice);
           }
        });
    };

    $('a[data-name="btn_community_service"]').click(function(){
        var data = {};

        data.vn = $('#vn').val(),
        data.hn = $('#hn').val();

        $('a[href="#tab_comms1"]').tab('show');
        comms.get_detail(data);
        comms.modal.show_new();
    });

    comms.set_history = function(data)
    {
        $('#tbl_comms_history > tbody').empty();

        if(data)
        {
            _.each(data.rows, function(v){

                $('#tbl_comms_history > tbody').append(
                    '<tr>' +
                        '<td>' + app.mongo_to_thai_date(v.date_serv) + '</td>' +
                        '<td>' + app.clear_null(v.owner_name) + '</td>' +
                        '<td>' + app.clear_null(v.comservice_name) + '</td>' +
                        '<td>' + app.clear_null(v.provider_name) + '</td>' +
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_comms_history > tbody').append(
                '<tr>' +
                    '<td colspan="4">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }
    };

    $('a[href="#tab_comms2"]').click(function(){
        var hn = $('#hn').val()

        comms.ajax.get_history(hn, function(err, data){
           comms.set_history(data);
        });
    });

    $('#btn_comms_save').click(function(){
       var data = {};
        data.vn = $('#vn').val();
        data.hn = $('#hn').val();
        data.comservice = $('#sl_comms').val();

        if(!data.comservice)
        {
            app.alert('กรุณาระบุกิจกรรม');
        }
        else
        {
            //do save
            comms.ajax.save_service(data, function(err){
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