head.ready(function(){
    var rfos = {};

    rfos.ajax = {
        save: function(items, cb){
            var url = 'refers/save_rfo',
                params = {
                    data: items
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(code, cb){
            var url = 'refers/remove_rfo',
                params = {
                    code: code
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        save_answer: function(items, cb){
            var url = 'refers/save_rfo_answer',
                params = {
                    data: items
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_answer: function(code, cb){
            var url = 'refers/get_rfo_answer',
                params = {
                    code: code
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

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
    $('#txt_rfo_answer_diag_name').typeahead({
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

            $('#txt_rfo_answer_diag_code').val(code);

            return name;
        }
    });

    $('#txt_rfo_answer_diag_name').on('keyup', function () {
        $('#txt_rfo_answer_diag_code').val('');
    });

    $('#txt_rfo_hosp_name').on('keyup', function(){
        $('#txt_rfo_hosp_code').val('');
    });

    $('#btn_rfo_save').on('click', function(){
        var items = {};
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

        if(!items.vn)
        {
            app.alert('กรุณาระบุเลขที่รับบริการ [VN]');
        }
        else if(!items.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!items.refer_date)
        {
            app.alert('กรุณาระบุวันที่ส่งต่อ');
        }
        else if(!items.refer_time)
        {
            app.alert('กรุณาระบุเวลาส่งต่อ');
        }
        else if(!items.refer_hospital)
        {
            app.alert('กรุณาระบุสถานพยาบาลที่รับส่งต่อ');
        }
        else if(!items.cause)
        {
            app.alert('กรุณาระบุสาเหตุการส่งต่อ');
        }
        else if(!items.reason)
        {
            app.alert('กรุณาระบุเหตุผลการส่งต่อ');
        }
        else if(!items.clinic_id)
        {
            app.alert('กรุณาระบุคลินิกที่ส่งตัว');
        }
        else if(!items.provider_id)
        {
            app.alert('กรุณาระบุแพทย์ผู้ส่งตัว');
        }
        else
        {
            if(confirm('คุณต้องการบันทึกข้อมูลส่งต่อ ใช่หรือไม่?'))
            {
                rfos.ajax.save (items, function (err, data) {
                    if (err) {
                        app.alert (err);
                    } else {
                        app.alert ('บันทึกข้อมูลส่งต่อเสร็จเรียบร้อยแล้ว');
                        $('#txt_rfo_no').val(data.code);
                    }
                });
            }
        }

    });

    $('#btn_answer_save').on('click', function(){
        var items = {
            answer_date: $('#txt_rfo_answer_date').val(),
            answer_detail: $('#txt_rfo_answer_detail').val(),
            answer_diag: $('#txt_rfo_answer_diag_code').val(),
            rfo_code: $('#txt_rfo_no').val()
        };

        if(!items.rfo_code)
        {
            app.alert('กรุณาระบุเลขที่ส่งต่อ');
        }
        else if(!items.answer_date)
        {
            app.alert('กรุณาระบุวันที่ตอบรับ');
        }
        else if(!items.answer_detail)
        {
            app.alert('กรุณาระบุรายละเอียดการตอบรับ');
        }
        else if(!items.answer_diag)
        {
            app.alert('กรุณาระบุการวินิจฉัยโรค');
        }
        else
        {
            rfos.ajax.save_answer(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกรายการตอบรับเสร็จเรียบร้อยแล้ว');
                }
            });
        }

    });

    $('a[href="#tab_rfo_followup"]').on('click', function(){
        var code = $('#txt_rfo_no').val();
        rfos.ajax.get_answer(code, function(err, data){
            if(err)
            {
                app.alert('ไม่พบรายการตอบรับ');
            }
            else
            {
                $('#txt_rfo_answer_date').val(data.rows.answer_date);
                $('#txt_rfo_answer_detail').val(data.rows.answer_detail);
                $('#txt_rfo_answer_diag_code').val(data.rows.answer_diag_code);
                $('#txt_rfo_answer_diag_name').val(data.rows.answer_diag_name);
            }
        });
    });

    app.set_runtime();
});