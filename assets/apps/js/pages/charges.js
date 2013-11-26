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
        var charge = $('#txt_charge_name').select2('data');

        items.charge_id = charge.id;
        items.charge_name = charge.name;
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
                    parent.charge.modal.hide_new();
                    parent.charge.get_list();
                }
            });
        }
    });

    $('#txt_charge_name').on('click', function(e) {
        e.preventDefault();

        var data = $('#txt_charge_name').select2('data');

        $('#txt_charge_price').val(data.price);
    });

    $('#txt_charge_name').select2({
        placeholder: 'รายการยา',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_charge_item_ajax",
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

        //id: function(data) { return { id: data.code } },

        formatResult: function(data) {
            return data.name;
        },
        formatSelection: function(data) {
            return data.name;
        },
        initSelection: function(el, cb) {
            //var eltxt = $(el).val();
            //cb({'term': eltxt });
        }
    });

    charges.set_item_selected = function() {
        var id = $('#charge_item_id').val(),
            name = $('#charge_item_name').val();
        if(id) {
            $('#txt_charge_name').select2('data', {id: id, name: name, price: null, vprice: null});
            $('#txt_charge_name').select2('enable', false);
        }

    };
    //set select2 selected.
    charges.set_item_selected();
    //set runtime
    app.set_runtime();
});