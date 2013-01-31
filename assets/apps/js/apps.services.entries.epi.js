/**
 * Service EPI script
 */
head.ready(function(){
    var epis = {};

    epis.ajax = {
        check_registration: function(hn, cb){
            var url = '/epis/check_registration',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_epi_vaccine_list: function(cb){
            var url = '/epis/get_epi_vaccine_list',
                params = { };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        do_register: function(data, cb){
            var url = '/epis/save_service',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    epis.modal = {
        show_new_epi: function()
        {
            $('#mdl_epi').modal({
                backdrop: 'static'
            }).css({
                    width: 680,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },

        hide_new_epi: function()
        {
            $('#mdl_epi').modal('hide');
        }
    };

    epis.set_vaccine_list = function()
    {
        epis.ajax.get_epi_vaccine_list(function(err, data)
        {
            $('#sl_epi_vaccines').empty();
            $('#sl_epi_vaccines').append('<option value="">---</option>');
            _.each(data.rows, function(v){
                //get epi vaccines list
                $('#sl_epi_vaccines').append('<option value="'+ v.id +'">[ '+ v.eng_name +' ] ' + v.th_name + '</option>');
            });
        });
    };

    $('a[data-name="btn_epi"]').click(function(){
        var hn = $('#hn').val();

        epis.ajax.check_registration(hn, function(err){
           if(err)
           {
               app.alert('ข้อมูลนี้ยังไม่ได้ถูกลงทะเบียนกรุณาลงทะเบียนก่อนการให้บริการ');
           }
           else
           {
               epis.set_vaccine_list();
               //show epi
                epis.modal.show_new_epi();
           }
        });
    });

    $('#btn_do_add').click(function(){
        var data = {};

        data.hn = $('#hn').val(),
        data.vn = $('#vn').val(),
        data.vaccine_id = $('#sl_epi_vaccines').val();

        if(!data.vaccine_id)
        {
            app.alert('กรุณาเลือกวัคซีนที่ต้องการ');
        }
        else
        {
            epis.ajax.do_register(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
               else
               {
                   app.alert('เพิ่มรายการเรียบร้อยแล้ว');
                   epis.modal.hide_new_epi();
               }
            });
        }
    });
});
//End file