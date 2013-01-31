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
        get_epi_vaccine_list: function(hn, cb){
            var url = '/epis/get_epi_vaccine_list',
                params = {

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
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
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
               //show epi
                epis.modal.show_new_epi();
           }
        });
    });
});
//End file