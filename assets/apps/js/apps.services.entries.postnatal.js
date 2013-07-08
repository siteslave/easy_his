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
        }
    };

    postnatal.modal = {
        show_new: function(hn, vn)
        {
            app.load_page($('#mdl_postnatal'), '/pages/postnatal/' + hn + '/' + vn , 'assets/apps/js/pages/postnatal.js');
            $('#mdl_postnatal').modal({keyboard: false});
        },

        hide_new: function()
        {
            $('#mdl_postnatal').modal('hide');
        }
    };

    $('a[data-name="btn_postnatal"]').click(function(){
        var vn = $('#vn').val(),
            hn = $('#hn').val();

        postnatal.ajax.check_registration(hn, function(err){
           if(err)
           {
               app.alert('ข้อมูลนี้ยังไม่ได้ถูกลงทะเบียนกรุณาลงทะเบียนก่อนการให้บริการ');
           }
           else
           {
               postnatal.modal.show_new(hn, vn);
           }
        });
    });

});
//End file