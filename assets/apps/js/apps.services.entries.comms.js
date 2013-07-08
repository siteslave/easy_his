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
        },
        remove_service: function(id, cb){
            var url = 'comms/remove_service',
                params = {
                    id: id
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
            });
        },

        hide_new: function()
        {
            $('#mdl_comms').modal('hide');
        }
    };

    comms.get_detail = function()
    {
        var items = {};
        items.hn = $('#hn').val();
        items.vn = $('#vn').val();

        comms.ajax.get_detail(items, function(err, data){

            $('#tbl_comms_visit_list > tbody').empty();

           if(err)
           {
               app.alert(err);
               $('#tbl_comms_visit_list > tbody').append(
                   '<tr><td colspan="4">ไม่พบรายการ</td></tr>'
               );
           }
            else
           {
               if(_.size(data.rows) > 0)
               {
                   var i = 1;
                   _.each(data.rows, function(v){
                       $('#tbl_comms_visit_list > tbody').append(
                           '<tr>' +
                               '<td>'+ i +'</td>' +
                               '<td>'+ v.comservice +'</td>' +
                               '<td>'+ v.provider +'</td>' +
                               '<td><a href="#" class="btn btn-danger" data-id="'+ v.id +'" data-name="btn_remove_comms" title="ลบรายการ">' +
                               '<i class="icon-trash"></i></a></td>' +
                            '</tr>'
                       );

                       i++;
                   });
               }
               else
               {
                   $('#tbl_comms_visit_list > tbody').append(
                       '<tr><td colspan="4">ไม่พบรายการ</td></tr>'
                   );
               }
           }
        });
    };

    $('a[data-name="btn_community_service"]').click(function(){
        $('a[href="#tab_comms1"]').tab('show');
        comms.get_detail();

        app.set_first_selected($('#sl_comms'));
        app.set_first_selected($('#sl_comms_providers'));

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
    $('a[href="#tab_comms1"]').click(function(){
        comms.get_detail();
    });

    $('#btn_comms_save').click(function(){
       var items = {};
        items.vn = $('#vn').val();
        items.hn = $('#hn').val();
        items.comservice = $('#sl_comms').val();
        items.provider_id = $('#sl_comms_providers').val();

        if(!items.comservice)
        {
            app.alert('กรุณาระบุกิจกรรม');
        }
        else if(!items.provider_id)
        {
            app.alert('กรุณาเลือก Provider');
        }
        else
        {
            //do save
            comms.ajax.save_service(items, function(err){
               if(err)
               {
                   app.alert(err);
               }
               else
               {
                   app.alert('การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                   comms.get_detail();
               }
            });
        }
    });

    $(document).on('click', 'a[data-name="btn_remove_comms"]', function(){
        var id = $(this).data('id');

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่', function(res){
            if(res)
            {
                comms.ajax.remove_service(id, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        comms.get_detail();
                    }
                });
            }
        });
    });
});
//End file