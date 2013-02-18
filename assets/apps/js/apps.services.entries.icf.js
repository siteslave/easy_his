//ICF Script
head.ready(function(){
    var icf = {};

    icf.modal = {
        show_register: function(){
            $('#mdl_icf').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
    };

    icf.ajax = {
        get_icf: function(disb_id, cb){

            var url = 'basic/get_icf',
                params = {
                    disb_id: disb_id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        save: function(data, cb){

            var url = 'services/icf_save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(vn, cb){

            var url = 'services/icf_get_list',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    $('a[data-name="btn_icf"]').on('click', function(){
        icf.get_list();
        icf.modal.show_register();
    });

    $('#sl_icf_disb_type').on('change', function(){
        var disb_id = $(this).val();

        icf.ajax.get_icf(disb_id, function(err, data){
            $('#sl_icf').empty();
            $('#sl_icf').append('<option value="">--</option>');
            if(!err)
            {
                _.each(data.rows, function(v){
                    $('#sl_icf').append('<option value="' + v.id + '">' + v.name + '</option>');
                });

            }
        });
    });

    //save
    $('#btn_icf_save').click(function(){
        var data = {};
        data.icf = $('#sl_icf').val();
        data.qualifier = $('#sl_icf_qualifier').val();

        data.vn = $('#vn').val();
        data.hn = $('#hn').val();

        if(!data.icf)
        {
            app.alert('กรุณาระบุภาวะสุขภาพ');
        }
        else if(!data.qualifier)
        {
            app.alert('กรุณาระบุระดับการประเมินภาวะสุขภาพ');
        }
        else
        {
            icf.ajax.save(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
                else
               {
                   app.alert('บันทึกข้อมูลเสร็จเรียบร้อย');
                   //get list
                   icf.get_list();
               }
            });
        }
    });

    icf.get_list = function()
    {
        var vn = $('#vn').val();

        icf.ajax.get_list(vn, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
               $('#tbl_icf_list > tbody').empty();
               _.each(data.rows, function(v){
                  $('#tbl_icf_list > tbody').append(
                      '<tr>' +
                          '<td>' + v.icf_name + '</td>' +
                          '<td>' + v.qualifier_name + '</td>' +
                          '<td>' + v.provider_name + '</td>' +
                      '</tr>'
                  );
               });
           }
        });
    };
});