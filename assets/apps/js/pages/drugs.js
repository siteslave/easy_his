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
        var drug = $('#txt_drug_name').select2('data');
        var usage = $('#txt_drug_usage_name').select2('data');

        items.usage_id = usage === null ? false : usage.id;
        items.drug_id = drug === null ? false : drug.id;
        items.price = $('#txt_drug_price').val();
        items.qty = $('#txt_drug_qty').val();
        items.id = $('#service_drug_visit_id').val();

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
                    parent.drug.modal.hide_new();
                    parent.drug.get_list();
                }
            });
        }
    });

    $('#txt_drug_name').on('click', function(e) {
        e.preventDefault();
        var data = $(this).select2('data');

        $('#txt_drug_price').val(data.price);
    });

    $('#txt_drug_name').select2({
        placeholder: 'รายการยา',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_drug_ajax",
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

    $('#txt_drug_usage_name').select2({
        placeholder: 'รายการยา',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_drug_usage_ajax",
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
            return data.name + ' [' + data.name1 + ']';
        },
        formatSelection: function(data) {
            return data.name1;
        },
        initSelection: function(el, cb) {
            //var eltxt = $(el).val();
            //cb({'term': eltxt });
        }
    });

    drugs.set_drug_usage_selected = function() {
        var drug_id = $('#service_drug_id').val(),
            drug_name = $('#service_drug_name').val(),
            usage_id = $('#service_drug_usage_id').val(),
            usage_name = $('#service_drug_usage_name').val();

        if(drug_id) {
            $('#txt_drug_name').select2('data', {id: drug_id, name: drug_name});
            $('#txt_drug_name').select2('enable', false);

            $('#txt_drug_usage_name').select2('data', {id: usage_id, name1: usage_name});
        }
    };

    drugs.set_drug_usage_selected();

    app.set_runtime();
});