/**
 * Service EPI script
 */
head.ready(function(){
    var pregnancies = {};

    pregnancies.ajax = {
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
            var url = 'pregnancies/get_history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(vn, cb){
            var url = 'pregnancies/get_detail',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        do_register: function(data, cb){
            var url = 'pregnancies/save_service',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    pregnancies.modal = {
        show_new: function()
        {
            $('#mdl_anc').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
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


    pregnancies.get_detail = function(vn)
    {
        pregnancies.ajax.get_detail(vn, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
                $('#sl_anc_no').val(data.rows.anc_no);
                $('#txt_anc_ga').val(data.rows.ga);
                $('#sl_anc_result').val(data.rows.anc_result);
           }
        });
    };

    $('a[data-name="btn_anc"]').click(function(){
        var vn = $('#vn').val(),
            hn = $('#hn').val();

        pregnancies.ajax.check_registration(hn, function(err){
           if(err)
           {
               app.alert('ข้อมูลนี้ยังไม่ได้ถูกลงทะเบียนกรุณาลงทะเบียนก่อนการให้บริการ');
           }
           else
           {
               //get detail
               pregnancies.get_detail(vn);
               pregnancies.modal.show_new();
           }
        });
    });

    $('#btn_anc_save').click(function(){
        var data = {};

        data.hn = $('#hn').val(),
        data.vn = $('#vn').val(),
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
            pregnancies.ajax.do_register(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
               else
               {
                   app.alert('เพิ่มรายการเรียบร้อยแล้ว');
                   pregnancies.modal.hide_new();
               }
            });
        }
    });

    pregnancies.set_history = function(data)
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
                    '<td colspan="6">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }



    };

    $('a[href="#tab_anc2"]').click(function(){
        var hn = $('#hn').val();

        pregnancies.ajax.get_history(hn, function(err, data){
           pregnancies.set_history(data);
        });
    });
});
//End file