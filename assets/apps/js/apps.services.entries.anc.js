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
        }
    };

    anc.modal = {
        show_new: function(hn, vn)
        {
            app.load_page($('#mdl_anc'), '/pages/service_anc/' + hn + '/' + vn, 'assets/apps/js/pages/service_anc.js');
            $('#mdl_anc').modal({keyboard: false});
        },

        hide_new: function()
        {
            $('#mdl_anc').modal('hide');
        }
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
               anc.modal.show_new(data.hn, data.vn);

           }
        });
    });


});
//End file