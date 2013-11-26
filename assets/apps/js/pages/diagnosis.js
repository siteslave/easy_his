head.ready(function(){
    var diags = {};

    diags.ajax = {
        save_diag_opd: function(data, cb){

            var url = 'services/save_diag_opd',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#btn_diag_do_save').click(function(){
        var items = {};

        var icd = $('#txt_diag_query').select2('data');

        items.code = icd.code;
        items.diag_type = $('#sl_diag_type').val();
        items.clinic = $('#sl_diag_clinic').val();

        items.vn = $('#vn').val();

        if(!items.code){
            app.alert('กรุณาระบุ รหัสการวินิจฉัยโรค');
        }else if(!items.diag_type){
            app.alert('กรุณาระบุ ประเภทการวินิจฉัยโรค');
        }else if(!items.clinic){
            app.alert('กรุณาระบุ คลินิกที่ให้บริการ');
        }else{
            //do save
            diags.ajax.save_diag_opd(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    parent.diags.get_diag();
                    parent.diags.modal.hide_new();
                }
            });
        }
    });

    $('#txt_diag_query').select2({
        placeholder: 'รหัส หรือ ชื่อการวินิจฉัยโรค',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_icd_ajax",
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
        },
        initSelection: function(el, cb) {
            //var eltxt = $(el).val();
            //cb({'term': eltxt });
        }
    });

//
//    $('#txt_diag_query').typeahead({
//        ajax: {
//            url: site_url + '/basic/search_icd_ajax',
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
//            $('#txt_diag_query_code').val(code);
//            $('#txt_diag_query').val(name);
//
//            return name;
//        }
//    });

    $('#sl_diag_type').select2();
    $('#sl_diag_clinic').select2();

    app.set_runtime();
});