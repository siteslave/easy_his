head.ready(function(){

    var procedures = {};

    procedures.ajax = {
        save_proced_opd: function(data, cb){

            var url = 'services/save_proced_opd',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    procedures.clear_form = function(){
        $('#txt_proced_query').val('');
        $('#txt_proced_isupdate').val('');
        $('#txt_proced_query_code').val('');
        $('#txt_proced_price').val('0');
        $('#txt_proced_end_time').val('');
        $('#txt_proced_start_time').val('');

        app.set_first_selected($('#sl_proced_provider'));
        app.set_first_selected($('#sl_proced_clinic'));

        $('#txt_proced_query').removeProp('disabled');
        $('#txt_proced_query').removeClass('uneditable-input');
        //$('#txt_proced_query').css('background-color', 'white');

    };

    $('#btn_proced_do_save').click(function(){
        var items = {};
        items.code = $('#txt_proced_query_code').val();
        items.price = $('#txt_proced_price').val();
        items.isupdate = $('#txt_proced_isupdate').val();
        items.provider_id = $('#sl_proced_provider').val();
        items.start_time = $('#txt_proced_start_time').val();
        items.end_time = $('#txt_proced_end_time').val();
        items.clinic_id = $('#sl_proced_clinic').val();

        items.vn = $('#txt_proced_vn').val();

        if(!items.code){
            app.alert('กรุณาระบุ หัตถการ');
        }else if(!items.price){
            app.alert('กรุณาระบุ ราคา');
        }else if(!items.provider_id){
            app.alert('กรุณาระบุ ผู้ทำหัตถการ');
        }else if(!items.start_time){
            app.alert('กรุณาระบุ เวลาเริ่มทำหัตถการ');
        }else if(!items.clinic_id){
            app.alert('กรุณาระบุ คลินิกที่ให้บริการ');
        }else if(!items.end_time){
            app.alert('กรุณาระบุ เวลาสิ้นสุดการทำหัตถการ');
        }else{
            //do save
            procedures.ajax.save_proced_opd(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                }
            });
        }
    });

    $('#txt_proced_query').on('keyup', function(){
        $('#txt_proced_query_code').val('');
    });

    $('#txt_proced_query').typeahead({
        ajax: {
            url: site_url + '/basic/search_procedure_ajax',
            timeout: 500,
            displayField: 'name',
            triggerLength: 3,
            preDispatch: function(query){
                return {
                    query: query,
                    csrf_token: csrf_token
                }
            },

            preProcess: function(data){
                if(data.success){
                    return data.rows;
                }else{
                    return false;
                }
            }
        },
        updater: function(data){
            var d = data.split('#');
            var name = d[1],
                code = d[0];

            $('#txt_proced_query_code').val(code);
            $('#txt_proced_query').val(name);

            return name;
        }
    });

    $('#btn_proced_refresh').on('click', function(e){
        procedures.clear_form();
        e.preventDefault();
    });

    app.set_runtime();
});