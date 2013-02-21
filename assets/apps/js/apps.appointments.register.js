head.ready(function(){
    var appoint = {};

    appoint.ajax = {
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


    //search diag
    $('#txt_diag_code').typeahead({
        ajax: {
            url: site_url + 'basic/search_icd_ajax',
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
            $('#txt_diag_code').val(code);
            $('#txt_diag_name').val(name);

            return code;
        }
    });

    //save
    $('#btn_save').click(function(){
        var items = {};

        items.date = $('#txt_date').val();
        items.time = $('#txt_time').val();
        items.clinic = $('#sl_clinic').val();
        items.diag = $('#txt_diag_code').val();
        items.type = $('#sl_aptype').val();

        items.vn = $('#txt_vn').val();
        items.hn = $('#txt_hn').val();

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
        else
        {
            appoint.ajax.do_register(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    app.go_to_url('appoints');
                }
            });
        }
    });
});