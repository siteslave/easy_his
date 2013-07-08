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
        allergy.ajax.get_detail(hn, drug_id, function(err, data){
            if(err){
                app.alert(err);
            }else{
                //set data
                $('#txt_screening_allergy_date_record').val(data.rows.record_date);
                $('#txt_screening_drug_allergy_code').val(data.rows.drug_id);
                $('#txt_screening_drug_allergy_name').val(data.rows.drug_name);
                $('#txt_screening_drug_allergy_name').attr('disabled', 'disabled');
                $('#txt_screening_drug_allergy_name').css('background-color', 'white');

                $('#txt_screening_allergy_isupdate').val('1');

                $('#txt_screening_drug_allergy_hosp_code').val(data.rows.hospcode);
                $('#txt_screening_drug_allergy_hosp_name').val(data.rows.hospname);

                $('#sl_screening_allergy_diag_type').val(data.rows.diag_type_id);
                $('#sl_screening_allergy_alevel').val(data.rows.alevel_id);
                $('#sl_screening_allergy_symptom').val(data.rows.symptom_id);
                $('#sl_screening_allergy_informant').val(data.rows.informant_id);

                allergies.modal.show_allergy();
            }
        });
    };


    $('#btn_allergies_save').click(function(){
        var items = {};

        items.record_date = $('#txt_allergies_date_record').val();
        items.drug_id = $('#txt_allergies_code').val();
        items.diag_type_id = $('#sl_allergies_diag_type').val();
        items.alevel_id = $('#sl_allergies_alevel').val();
        items.symptom_id = $('#sl_allergies_symptom').val();
        items.informant_id = $('#sl_allergies_informant').val();
        items.isupdate = $('#txt_isupdate').val();
        items.hn = $('#txt_allergy_hn').val();

        items.hospcode = $('#txt_allergies_hosp_code').val();

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
                }
            });
        }
    });

    $('#txt_allergies_hosp_name').typeahead({
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

            $('#txt_allergies_hosp_code').val(code);

            return name;
        }
    });

    $('#txt_allergies_hosp_name').on('keyup', function(){
        $('#txt_allergies_hosp_code').val('');
    });

    $('#txt_allergies_name').on('keyup', function(){
        $('#txt_allergies_code').val('');
    });

    //typeahead for drug allergy
    $('#txt_allergies_name').typeahead({
        ajax: {
            url: site_url + '/basic/search_drug_ajax',
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
            var name = d[0],
                code = d[1];

            $('#txt_allergies_code').val(code);

            return name;
        }
    });

    app.set_runtime();
});