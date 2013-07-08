/**
 * Service baby care script
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
        }
    };

    babies.modal = {
        show_new: function(hn, vn)
        {
            app.load_page($('#mdl_babies_care'), '/pages/babies_care/' + hn + '/' + vn, 'assets/apps/js/pages/babies_care.js');
            $('#mdl_babies_care').modal({keyboard: false});
        }
    };

    $('a[data-name="btn_baby_care"]').click(function(){
        vn = $('#vn').val(),
        hn = $('#hn').val();

        babies.ajax.check_registration(hn, function(err){
           if(err)
           {
               app.alert('ข้อมูลนี้ยังไม่ได้ถูกลงทะเบียนกรุณาลงทะเบียนก่อนการให้บริการ');
           }
           else
           {
               babies.modal.show_new(hn, vn);
           }
        });
    });
});
//End file