head.ready(function(){

    var allergy = {};

    allergy.person_id = $('#person_id').val();

    allergy.vn = $('#vn').val();
    allergy.hn = $('#hn').val();

    allergy.modal = {
        show_allergy: function(){
            $('#modal_screening_allergy').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_new_allergy: function(){
            $('#modal_screening_allergy').modal('hide');
        }
    };

    allergy.ajax = {
        save_allergy: function(data, cb){

            var url = 'services/save_screening_allergy',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(hn, cb){

            var url = 'services/get_screening_allergy_list',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove_allergy: function(hn, drug_id, cb){

            var url = 'services/remove_screening_allergy',
                params = {
                    hn: hn,
                    drug_id: drug_id
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

    allergy.set_allergy_detail = function(hn, drug_id){
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

                allergy.modal.show_allergy();
            }
        });
    };

    allergy.clear_form = function(){
        $('#txt_screening_allergy_date_record').val('');
        $('#txt_screening_drug_allergy_code').val('');
        $('#txt_screening_drug_allergy_name').val('');
        $('#txt_screening_allergy_isupdate').val('');

        $('#txt_screening_drug_allergy_hosp_code').val('');
        $('#txt_screening_drug_allergy_hosp_name').val('');

        app.set_first_selected($('#sl_screening_allergy_diag_type'));
        app.set_first_selected($('#sl_screening_allergy_alevel'));
        app.set_first_selected($('#sl_screening_allergy_symptom'));
        app.set_first_selected($('#sl_screening_allergy_informant'));

        $('#txt_screening_drug_allergy_name').removeAttr('disabled');
        $('#txt_screening_drug_allergy_name').css('background-color', 'white');

    };

    allergy.get_list = function(hn){
        $('#tbl_screening_allergy_list > tbody').empty();

        allergy.ajax.get_list(hn, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_screening_allergy_list > tbody').append('<tr><td colspan="7">ไม่พบรายการ</td></tr>');
            }else{
                if(_.size(data.rows)){
                    _.each(data.rows, function(v){
                        $('#tbl_screening_allergy_list > tbody').append(
                            '<tr>' +
                                '<td>' + app.to_thai_date(v.record_date) + '</td>' +
                                '<td>' + v.drug_detail.name + '</td>' +
                                '<td>' + v.symptom_name + '</td>' +
                                '<td>' + v.alevel_name + '</td>' +
                               // '<td>' + v.informant_name + '</td>' +
                                '<td>' + v.hospname + '</td>' +
                                '<td>' + v.user_fullname + '</td>' +
                                '<td>' +
                                '<div class="btn-group"> ' +
                                '<button class="btn" type="button" data-name="btn_screening_allergy_remove" ' +
                                'data-id="' + v.drug_id + '"><i class="icon-trash"></i></button>' +
                                '<button class="btn" type="button" data-name="btn_screening_allergy_edit" ' +
                                'data-id="' + v.drug_id + '"><i class="icon-edit"></i></button>' +
                                '</div></td>' +
                                '</tr>'
                        );
                    });
                }else{
                    $('#tbl_screening_allergy_list > tbody').append('<tr><td colspan="7">ไม่พบรายการ</td></tr>');
                }
            }
        });
    };

    $('#modal_screening_allergy').on('hidden', function(){
        allergy.clear_form();
    });

    $('#btn_screening_add_drgu_allergy').click(function(){
        $('#txt_screening_allergy_isupdate').val('');
        allergy.modal.show_allergy();
    });

    $('#btn_screening_save_allergy').click(function(){
        var items = {};

        items.record_date = $('#txt_screening_allergy_date_record').val();
        items.drug_id = $('#txt_screening_drug_allergy_code').val();
        items.drug_name = $('#txt_screening_drug_allergy_name').val();

        items.diag_type_id = $('#sl_screening_allergy_diag_type').val();
        items.alevel_id = $('#sl_screening_allergy_alevel').val();
        items.symptom_id = $('#sl_screening_allergy_symptom').val();
        items.informant_id = $('#sl_screening_allergy_informant').val();
        items.isupdate = $('#txt_screening_allergy_isupdate').val();

        items.hospcode = $('#txt_screening_drug_allergy_hosp_code').val();
        items.hospname = $('#txt_screening_drug_allergy_hosp_name').val();

        if(!items.record_date){
            app.alert('กรุณาระบุ วันที่บันทึก');
        }else if(!items.drug_id || !items.drug_name){
            app.alert('กรุณาระบุ ยาที่แพ้');
        }else if(!items.diag_type_id){
            app.alert('กรุณาระบุ การวินิจฉัย');
        }else if(!items.alevel_id){
            app.alert('กรุณาระบุ ระดับความรุนแรง');
        }else if(!items.symptom_id){
            app.alert('กรุณาระบุ อาการแพ้');
        }else if(!items.informant_id){
            app.alert('กรุณาระบุ ผู้ให้ข้อมูล');
        }else if(!items.hospcode || !items.hospname){
            app.alert('กรุณาระบุ สถานบริการที่ให้ข้อมูลการแพ้ยา หากไม่ทราบให้ใส่รหัสสถานบริการของตัวเอง');
        }else{
            //save data
            items.hn = allergy.hn;

            allergy.ajax.save_allergy(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกข้อมูลการแพ้ยา เสร็จเรียบร้อยแล้ว');
                    //get allergy list
                    allergy.get_list(allergy.hn);

                    allergy.modal.hide_new_allergy();
                }
            });
        }
    });

    $('#txt_screening_drug_allergy_hosp_name').typeahead({
        ajax: {
            url: site_url + 'basic/search_hospital_ajax',
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

            $('#txt_screening_drug_allergy_hosp_code').val(code);
            $('#txt_screening_drug_allergy_hosp_name').val(name);

            return name;
        }
    });

    //typeahead for drug allergy
    $('#txt_screening_drug_allergy_name').typeahead({
        ajax: {
            url: site_url + 'basic/search_drug_ajax',
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

            $('#txt_screening_drug_allergy_code').val(code);
            $('#txt_screening_drug_allergy_name').val(name);

            return name;
        }
    });

    $('a[href="#tab_screening_allergy"]').click(function(){
        allergy.get_list(allergy.hn);
    });

    //remove drug
    $(document).on('click', 'button[data-name="btn_screening_allergy_remove"]', function(){
        var drug_id = $(this).attr('data-id');
        var obj = $(this).parent().parent().parent();

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res){
                allergy.ajax.remove_allergy(allergy.hn, drug_id, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        $(obj).fadeOut('slow');
                    }
                });
            }
        });

    });

    $(document).on('click', 'button[data-name="btn_screening_allergy_edit"]', function(){
        var drug_id = $(this).attr('data-id');

        //get detail
        allergy.set_allergy_detail(allergy.hn, drug_id);
    });
});