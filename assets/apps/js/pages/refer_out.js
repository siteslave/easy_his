head.ready(function(){
    var referouts = {};

    $('#txt_rfo_hosp_name').typeahead({
        ajax: {
            url: site_url + '/basic/search_hospital_ajax',
            timeout: 500,
            displayField: 'fullname',
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
                code = d[1];

            $('#txt_rfo_hosp_code').val(code);
            $('#txt_rfo_hosp_name').val(name);

            return name;
        }
    });

    $('#txt_rfo_hosp_name').on('keyup', function(){
        $('#txt_rfo_hosp_code').val('');
    });

    $('#btn_rfo_save').on('click', function(){
        var items = {};
        items.id = $('#txt_rfo_id').val();
        items.code = $('#txt_rfo_no').val();
        items.vn = $('#txt_rfo_vn').val();
        items.hn = $('#txt_rfo_hn').val();
        items.refer_date = $('#txt_rfo_date').val();
        items.refer_time = $('#txt_rfo_time').val();
        items.refer_hospital = $('#txt_rfo_hosp_code').val();
        items.cause = $('#sl_rfo_cause').val();
        items.reason = $('#sl_rfo_reason').val();
        items.clinic_id = $('#sl_rfo_clinic').val();
        items.request = $('#txt_rfo_request').val();
        items.comment = $('#txt_rfo_comment').val();
        items.result = $('#sl_rfo_result').val();
        items.provider_id = $('#sl_rfo_provider').val();

        console.log(items);
    });

    app.set_runtime();
});