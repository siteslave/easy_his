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
    $('#txt_ap_diag_name').typeahead({
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
            var code = d[0],
                name = d[1];
            //alert(code);
            $('#txt_ap_diag_code').val(code);
            $('#txt_ap_diag_name').val(name);

            return name;
        }
    });

    $('#txt_ap_diag_name').on('keyup', function(){
        $('#txt_ap_diag_code').val('');
    });
    //save
    $('#btn_ap_do_register').click(function(){
        var items = {};

        items.date = $('#txt_ap_date').val();
        items.time = $('#txt_ap_time').val();
        items.clinic = $('#sl_ap_clinic').val();
        items.diag = $('#txt_ap_diag_code').val();
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
                }
            });
        }
    });

    app.set_runtime();
});