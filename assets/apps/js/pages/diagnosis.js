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
        items.code = $('#txt_diag_query_code').val();
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
                }
            });
        }
    });

    $('#txt_diag_query').on('keyup', function(){
        $('#txt_diag_query_code').val('');
    });

    $('#txt_diag_query').typeahead({
        ajax: {
            url: site_url + '/basic/search_icd_ajax',
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

            $('#txt_diag_query_code').val(code);
            $('#txt_diag_query').val(name);

            return name;
        }
    });

    app.set_runtime();
});