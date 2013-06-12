head.ready(function(){
    var drugs = {};

    drugs.vn = $('#vn').val();
    drugs.hn = $('#hn').val();

    drugs.ajax = {
        save_drug: function(data, cb){

            var url = 'services/save_drug_opd',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    //save drug
    $('#btn_drug_do_save').click(function(){
        var items = {};

        items.usage_id = $('#txt_drug_usage_id').val();
        items.drug_id = $('#txt_drug_id').val();
        items.price = $('#txt_drug_price').val();
        items.qty = $('#txt_drug_qty').val();
        items.id = $('#service_drug_id').val();

        items.vn = drugs.vn;
        items.hn = drugs.hn;

        items.isupdate = $('#drug_isupdate').val();

        if(!items.drug_id){
            app.alert('กรุณาระบุรายการยา')
        }else if(!items.usage_id){
            app.alert('กรุณาระบุข้อมูลการใช้ยา');
        }else if(!items.qty){
            app.alert('กรุณาระบุจำนวน');
        }else if(!items.price){
            app.alert('กรุณาระบุราคา');
        }else{
            //do save
            drugs.ajax.save_drug(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                }
            });
        }
    });

    $('#txt_drug_name').on('keyup', function(){
        $('#txt_drug_id').val('');
    });

    $('#txt_drug_name').typeahead({
        ajax: {
            url: site_url + '/basic/search_drug_ajax',
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
            var name = d[0],
                code = d[1],
                price = d[2];

            $('#txt_drug_id').val(code);
            $('#txt_drug_price').val(price);

            return name;
        }
    });

    $('#txt_drug_usage_name').typeahead({
        ajax: {
            url: site_url + '/basic/search_drug_usage_ajax',
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
            var alias = d[0],
                name = d[1],
                id = d[2];

            $('#txt_drug_usage_id').val(id);

            return alias;
        }
    });

    $('#txt_drug_usage_name').on('keyup', function(){
        $('#txt_drug_usage_id').val('');
    });

    app.set_runtime();
});