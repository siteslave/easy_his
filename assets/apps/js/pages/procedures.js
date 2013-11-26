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
        var data = $('#txt_proced_query').select2('data');

        items.code = data.code;
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
                    parent.procedures.get_list();
                    parent.procedures.modal.hide_new();
                }
            });
        }
    });

    $('#txt_proced_query').select2({
        placeholder: 'รหัส หรือ ชื่อห้ตถการ',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_procedure_ajax",
            dataType: 'json',
            type: 'POST',
            quietMillis: 100,
            data: function (term, page) {
                return {
                    query: term,
                    csrf_token: csrf_token,
                    start: page,
                    stop: 10
                };
            },
            results: function (data, page)
            {
                var more = (page * 10) < data.total; // whether or not there are more results available

                // notice we return the value of more so Select2 knows if more results can be loaded
                return {results: data.rows, more: more};

                //return { results: data.rows, more: (data.rows && data.rows.length == 10 ? true : false) };
            }
            //dropdownCssClass: "bigdrop"
        },

        id: function(data) { return { id: data.code } },

        formatResult: function(data) {
            return '[' + data.code + '] ' + data.name;
        },
        formatSelection: function(data) {
            return '[' + data.code + '] ' + data.name;
        }
//        ajax: {
//            url: site_url + '/basic/search_procedure_ajax',
//            timeout: 500,
//            displayField: 'name',
//            triggerLength: 3,
//            preDispatch: function(query){
//                return {
//                    query: query,
//                    csrf_token: csrf_token
//                }
//            },
//
//            preProcess: function(data){
//                if(data.success){
//                    return data.rows;
//                }else{
//                    return false;
//                }
//            }
//        },
//        updater: function(data){
//            var d = data.split('#');
//            var name = d[1],
//                code = d[0];
//
//            $('#txt_proced_query_code').val(code);
//            $('#txt_proced_query').val(name);
//
//            return name;
//        }
    });

    $('#btn_proced_refresh').on('click', function(e){
        procedures.clear_form();
        e.preventDefault();
    });

    procedures.set_procedure = function() {
        var proced_code = $('#txt_proced_code').val();
        var proced_name = $('#txt_proced_name').val();

        if(proced_code) {
            $('#txt_proced_query').select2('data', {code: proced_code, name: proced_name});
            $('#txt_proced_query').select2('enable', false);
        }
    };

    procedures.set_procedure();

    app.set_runtime();
});