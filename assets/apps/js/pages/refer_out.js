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

    $('#txt_rfo_hosp_name').select2({
        placeholder: 'ชื่อ หรือ รหัสสถานบริการ',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_hospital_ajax",
            dataType: 'json',
            type: 'POST',
            quietMillis: 100,
            data: function (term) {
                return {
                    query: term,
                    csrf_token: csrf_token
                };
            },
            results: function (data)
            {
                return { results: data.rows, more: (data.rows && data.rows.length == 10 ? true : false) };
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

    $('#txt_rfo_answer_diag_name').select2({
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