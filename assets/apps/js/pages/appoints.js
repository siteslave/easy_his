head.ready(function(){
    var appoints = {};
    appoints.ajax = {
        do_register: function(data, cb){
            var url = 'appoints/do_register',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#txt_ap_diag_name').select2({
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


    $('#btn_ap_do_register').click(function(){
        var items = {};
        var diag = $('#txt_ap_diag_name').select2('data');

        items.date = $('#txt_ap_date').val();
        items.time = $('#txt_ap_time').val();
        items.clinic = $('#sl_ap_clinic').val();
        items.diag = diag.code;
        items.type = $('#sl_ap_type').val();
        items.provider = $('#sl_ap_provider').val();
        items.isupdate = $('#txt_ap_isupdate').val();
        items.id = $('#txt_ap_id').val();

        items.vn = $('#txt_ap_vn').val();
        items.hn = $('#txt_ap_hn').val();

        if(!items.date)
        {
            app.alert('กรุณาระบุวันที่นัด');
        }
        else if(!items.time)
        {
            app.alert('กรุณาระบุเวลานัด');
        }
        else if(!items.clinic)
        {
            app.alert('กรุณาระบุคลินิค');
        }
        else if(!items.type)
        {
            app.alert('กรุณาระบุประเภทการนัด');
        }
        else if(!items.vn)
        {
            app.alert('ไม่พบรหัสการรับบริการ (vn)');
        }
        else if(!items.hn)
        {
            app.alert('ไม่พบรหัสประจำตัวผู้ป่วย (hn)');
        }
        else if(!items.provider)
        {
            app.alert('กรุณาระบุแพทย์ผู้นัด');
        }
        else
        {
            appoints.ajax.do_register(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    parent.appoint.get_list();
                    parent.appoint.modal.hide_new();
                }
            });
        }
    });

    appoints.set_diag_selected = function() {
        var code = $('#txt_ap_diag_code').val(),
            name = $('#txt_ap_diag_name2').val();

        if(code) {
            $('#txt_ap_diag_name').select2('data', {code: code, name: name});
        }

    };
    //set diag selected
    appoints.set_diag_selected();
    //set runtime
    app.set_runtime();
});