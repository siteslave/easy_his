head.ready(function(){
    var allergies = {};
    allergies.ajax = {
        save_allergy: function(items, cb){

            var url = 'person/save_drug_allergy',
                params = {
                    data: items
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(hn, drug_id, cb){

        var url = 'services/get_drug_allergy_detail',
            params = {
                hn: hn,
                drug_id: drug_id
            };

        app.ajax(url, params, function(err, data){
            return err ? cb(err) : cb(null, data);
        });
    }
    };

    allergies.set_allergy_detail = function(hn, drug_id){
        allergies.ajax.get_detail(hn, drug_id, function(err, data){
            if(err){
                app.alert(err);
            }else{
                //set data
                $('#txt_screening_allergy_date_record').val(data.rows.record_date);
                $('#txt_screening_drug_allergy_code').val(data.rows.drug_id);
                //$('#txt_screening_drug_allergy_name').val(data.rows.drug_name);
                //$('#txt_screening_drug_allergy_name').attr('disabled', 'disabled');
                //$('#txt_screening_drug_allergy_name').css('background-color', 'white');

                $('#txt_screening_allergy_isupdate').val('1');

                //$('#txt_screening_drug_allergy_hosp_code').val(data.rows.hospcode);
                //$('#txt_screening_drug_allergy_hosp_name').val(data.rows.hospname);

                $('#sl_screening_allergy_diag_type').val(data.rows.diag_type_id);
                $('#sl_screening_allergy_alevel').val(data.rows.alevel_id);
                $('#sl_screening_allergy_symptom').val(data.rows.symptom_id);
                $('#sl_screening_allergy_informant').val(data.rows.informant_id);

                //allergies.set_allergies_selected(data.rows.drug_id, data.rows.drug_name);
                allergies.modal.show_allergy();
            }
        });
    };

    allergies.set_allergies_selected = function() {
        var id = $('#txt_allergy_id').val();
        var name = $('#txt_allergy_name').val();

        var hospcode = $('#txt_allergy_hospcode').val();
        var hospname = $('#txt_allergy_hospname').val();

        if(id) {
            $('#txt_allergies_name').select2('data', {id: id, name: name});
            $('#txt_allergies_name').select2('enable', false);
        }

        if(hospcode) {
            $('#txt_allergies_hosp_name').select2('data', {code: hospcode, name: hospname});
            //$('#txt_allergies_hosp_name').select2('enable', false);
        }

    };


    $('#btn_allergies_save').click(function(){
        var items = {};

        var drug    = $('#txt_allergies_name').select2('data');
        var hos     = $('#txt_allergies_hosp_name').select2('data');

        //console.log(data);

        items.record_date   = $('#txt_allergies_date_record').val();
        items.drug_id       = drug.id;
        items.diag_type_id  = $('#sl_allergies_diag_type').val();
        items.alevel_id     = $('#sl_allergies_alevel').val();
        items.symptom_id    = $('#sl_allergies_symptom').val();
        items.informant_id  = $('#sl_allergies_informant').val();
        items.isupdate      = $('#txt_isupdate').val();
        items.hn            = $('#txt_allergy_hn').val();

        items.hospcode = hos.code;

        if(!items.record_date){
            app.alert('กรุณาระบุ วันที่บันทึก');
        }else if(!items.hn){
            app.alert('กรุณาระบุ HN');
        }else if(!items.drug_id){
            app.alert('กรุณาระบุ ยาที่แพ้');
        }else if(!items.diag_type_id){
            app.alert('กรุณาระบุ การวินิจฉัย');
        }else if(!items.alevel_id){
            app.alert('กรุณาระบุ ระดับความรุนแรง');
        }else if(!items.symptom_id){
            app.alert('กรุณาระบุ อาการแพ้');
        }else if(!items.informant_id){
            app.alert('กรุณาระบุ ผู้ให้ข้อมูล');
        }else if(!items.hospcode){
            app.alert('กรุณาระบุ สถานบริการที่ให้ข้อมูลการแพ้ยา หากไม่ทราบให้ใส่รหัสสถานบริการของตัวเอง');
        }else{
            allergies.ajax.save_allergy(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกข้อมูลการแพ้ยา เสร็จเรียบร้อยแล้ว');
                    $('#txt_isupdate').val('1');
                    //parent.allergy.get_list();
                    //parent.allergy.modal.hide_allergy();
                }
            });
        }
    });

    $('#txt_allergies_name').select2({
        placeholder: 'ระบุชื่อยาที่แพ้',
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

    $('#txt_allergies_hosp_name').select2({
        placeholder: 'ชื่อ หรือ รหัสสถานบริการ',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_hospital_ajax",
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


    allergies.set_allergies_selected();

    app.set_runtime();
});