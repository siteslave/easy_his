head.ready(function(){
    var charges = {};
    charges.vn = $('#charge_vn').val();
    charges.hn = $('#chareg_hn').val();

    charges.ajax = {
        save_charge: function(data, cb){

            var url = 'services/save_charge_opd',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    //save charge
    $('#btn_charge_do_save').click(function(){
        var items = {};

        items.charge_id = $('#txt_charge_id').val();
        items.charge_name = $('#txt_charge_name').val();
        items.price = $('#txt_charge_price').val();
        items.qty = $('#txt_charge_qty').val();

        items.vn = charges.vn;
        items.isupdate = $('#charge_isupdate').val();

        if(!items.charge_id || !items.charge_name){
            app.alert('กรุณาระบุรายการยา')
        }else if(!items.qty){
            app.alert('กรุณาระบุจำนวน');
        }else if(!items.price){
            app.alert('กรุณาระบุราคา');
        }else{
            //do save
            charges.ajax.save_charge(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                }
            });
        }
    });

    $('#txt_charge_name').typeahead({
        ajax: {
            url: site_url + '/basic/search_charge_item_ajax',
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
            var d = data.split('|');
            var name = d[0],
                price = d[1],
                id = d[3];

            $('#txt_charge_id').val(id);
            $('#txt_charge_name').val(name);
            $('#txt_charge_price').val(price);

            return name;
        }
    });

    $('#txt_charge_name').on('keyup', function(){
        $('#txt_charge_id').val('');
        $('#txt_charge_price').val('0');
        $('#txt_charge_qty').val('1');
    });

    app.set_runtime();
});