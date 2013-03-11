/**
 * Update person
 */
head.ready(function(){
    var person = {};
    person.update = {};

    person.hn = $('#hn').val();

    person.update.clear_drug_allergy_form = function(){
        $('#txt_drug_isupdate').val('');
        $('#txt_drug_name').removeAttr('disabled');
        $('#txt_drug_code').val('');
        $('#txt_drug_code_old').val('');
        app.set_first_selected($('#sl_type_diag'));
        $('#txt_date_record').val('');
        app.set_first_selected($('#sl_drug_allergy_alevel'));
        app.set_first_selected($('#sl_drug_allergy_symptom'));
        app.set_first_selected($('#sl_drug_allergy_informant'));
        $('#txt_drug_allergy_hosp_code').val('');
        $('#txt_drug_allergy_hosp_name').val('');
        $('#txt_drug_name').val('');
        $('#txt_drug_code').val('');
    };
    //Register modal
    person.update.modal = {
        //Search person from dbpop
        show_search_dbpop: function(){
            $('#modal_search_dbpop').modal({
                backdrop: 'static'
            }).css({
                    width: 740,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        //search hospital
        show_search_hospital: function(){
            $('#modal_search_hospital').modal({
                backdrop: 'static'
            }).css({
                    width: 680,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        //search drug allergy
        show_search_drug_allergy: function(){
            $('#modal_search_drug_allergy').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        show_search_chronic: function(){
            $('#modal_search_chronic').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
    };
    //click event for search dbpop
    $('#btn_search_dbpop').click(function(){
        person.update.modal.show_search_dbpop();
    });

    //main ajax function for register person
    person.update.ajax = {
        /**
         * Update person
         *
         * @param data      Person detail
         * @param cb        Callback function
         */
        update_person: function(data, cb){

            var url = 'person/do_update',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        /**
         * Get ampur list
         *
         * @param chw   Changwat code
         * @param cb    Callback functoion
         */
        get_ampur: function(chw, cb){

            var url = 'basic/get_ampur',
                params = {
                    chw: chw
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        },
        /**
         * Get tambon list
         *
         * @param chw   Changwat code
         * @param amp   Ampur code
         * @param cb    Callback function
         */
        get_tambon: function(chw, amp, cb){

            var url = 'basic/get_tambon',
                params = {
                    chw: chw,
                    amp: amp
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        },
        /**
         * Search person from dbpop database
         *
         * @param cid   Person's cid
         * @param cb    Callback function
         */
        search_dbpop: function(query, cb){

            var url = 'person/search_dbpop',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        },
        /**
         * Search hospital
         *
         * @param query Word or Hospital code
         * @param op    Condition for search. 1 search by name, 2 search by code. Default is search by name
         * @param cb    Callback function
         */
        search_hospital: function(query, op, cb){
            var url = 'basic/search_hospital',
                params = {
                    query: query,
                    op: op
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search_drug: function(query, cb){

            var url = 'basic/search_drug',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        },

        save_drug_allergy: function(data, cb){

            var url = 'person/save_drug_allergy',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null);
            });

        },

        get_drug_allergy_list: function(hn, cb){

            var url = 'person/get_drug_allergy_list',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        },

        get_drug_allergy_detail: function(hn, drug_id, cb){
            var url = 'person/get_drug_allergy_detail',
                params = {
                    drug_id: drug_id,
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        remove_drug_allergy: function(hn, drug_id, cb){
            var url = 'person/remove_drug_allergy',
                params = {
                    drug_id: drug_id,
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search_icd10: function(query, op, cb){
            var url = 'basic/search_icd10',
                params = {
                    query: query,
                    op: op
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        save_chronic: function(data, cb){
            var url = 'person/save_chronic',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err){
                return err ? cb(err) : cb(null);
            });
        },
        remove_chronic: function(hn, code, cb){
            var url = 'person/remove_chronic',
                params = {
                    hn: hn,
                    code: code
                };

            app.ajax(url, params, function(err){
                return err ? cb(err) : cb(null);
            });
        },

        get_chronic_list: function(hn, cb){
            var url = 'person/get_chronic_list',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };
    //Clear register form
    person.clear_register_form = function(){
        $('#txt_cid').val('');
        $('#txt_first_name').val('');
        $('#txt_last_name').val('');
        $('#txt_birth_date').val('');
        $('#txtFatherCid').val('');
        $('#txtMotherCid').val('');
        $('#txtCoupleCid').val('');
        $('#txtMoveInDate').val('');
        $('#txtDischargeDate').val('');
        $('#txt_passport').val('');

        //address
        $('#txtOutsideHouseId').val('');
        $('#txtOutsideRoomNumber').val('');
        $('#txtOutsideCondo').val('');
        $('#txtOutsideAddressNumber').val('');
        $('#txtOutsideSoiSub').val('');
        $('#txtOutsideSoiMain').val('');
        $('#txtOutsideRoad').val('');
        $('#txtOutsideVillageName').val('');
        $('#txtOutsidePostcode').val('');
        $('#txtOutsideTelephone').val('');
        $('#txtOutsideMobile').val('');

        //insurance
        $('#txt_inscl_code').val('');
        $('#txtInsStartDate').val('');
        $('#txtInsExpireDate').val('');
        $('#txt_ins_hospmain_code').val('');
        $('#txt_ins_hospsub_code').val('');
        $('#txt_ins_hospmain_name').val('');
        $('#txt_ins_hospsub_name').val('');
    };

    person.update.get_ampur_list = function(chw){

        //load ampur list
        person.update.ajax.get_ampur(chw, function(err, data){
            $('#slOutsideAmpur').empty();
            $('#slOutsideTambon').empty();

            $('#slOutsideAmpur').append('<option value="00">--</option>');
            _.each(data, function(v){
                if(!v.name.match(/\*/))
                    $('#slOutsideAmpur').append('<option value="'+ v.code +'">'+ v.name +'</option>');
            });

        });
    };

    person.update.get_drug_allergy_list = function(hn){

        person.update.ajax.get_drug_allergy_list(hn, function(err, data){

            $('#tbl_drug_allergy_list > tbody').empty();

            if(err){
                app.alert(err, 'เกิดข้อผิดพลาดในการดึงข้อมูลแพ้ยา');
            }else{
                if(_.size(data.rows)){
                    _.each(data.rows, function(v){
                        $('#tbl_drug_allergy_list > tbody').append(
                            '<tr>' +
                                '<td>' + v.record_date + '</td>' +
                                '<td>' + v.drug_detail['stdcode'] + '</td>' +
                                '<td>' + v.drug_detail['name'] + '</td>' +
                                '<td>' + v.diag_type_name + '</td>' +
                                '<td>' + v.alevel_name + '</td>' +
                                '<td>' + v.symptom_name + '</td>' +
                                '<td><div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn" data-name="btn_edit_drug_allergy" data-id="' + v.drug_id + '"> ' +
                                '<i class="icon-edit"></i></a>' +
                                '<a href="javascript:void(0)" class="btn btn-danger" data-name="btn_remove_drug_allergy" data-id="' + v.drug_id + '"> ' +
                                '<i class="icon-trash"></i></a>' +
                                '</div></td>' +
                            '</tr>'
                        );
                    });
                }else{
                    $('#tbl_drug_allergy_list > tbody').append(
                        '<tr> <td colspan="6">ไม่พบรายการ</td></tr>'
                    );
                }
            }
        });
    };

    person.update.set_drug_allergy_detail = function(hn, drug_id){

        person.update.ajax.get_drug_allergy_detail(hn, drug_id, function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#txt_drug_isupdate').val('1');
                $('#txt_date_record').val(data.rows.record_date);
                $('#txt_drug_name').val(data.rows.drug_name);
                $('#txt_drug_code').val(data.rows.drug_id);
                $('#sl_type_diag').val(data.rows.diag_type_id);
                $('#sl_drug_allergy_alevel').val(data.rows.alevel_id);
                $('#sl_drug_allergy_symptom').val(data.rows.symptom_id);
                $('#sl_drug_allergy_informant').val(data.rows.informant_id);
                $('#txt_drug_allergy_hosp_name').val(data.rows.hospname);
                $('#txt_drug_allergy_hosp_code').val(data.rows.hospcode);

                $('a[href="#tab_save_drug_allergy"]').tab('show');

                person.update.modal.show_search_drug_allergy();
            }
        });

    };

    person.update.search_icd10 = function(query, op){
        var div = $('#div_search_chronic_result');
        app.show_block(div);
        person.update.ajax.search_icd10(query, op, function(err, data){

            $('#tbl_search_chronic_result_list > tbody').empty();

            if(err){
                app.alert(err);
                app.hide_block(div);
            }else{
                if(_.size(data.rows)){
                    _.each(data.rows, function(v){
                        var valid = v.valid == 'T' ? '<i class="icon-ok"></i>' :
                            '<i class="icon-remove"></i>';

                        $('#tbl_search_chronic_result_list > tbody').append(
                            '<tr>' +
                                '<td>' + v.code + '</td>' +
                                '<td>' + v.desc_r + '</td>' +
                                '<td>' + valid + '</td>' +
                                '<td><a href="javascript:void(0)" data-code="'+ v.code +'" data-name="btn_select_chronic_diag" data-vname="'+ v.desc_r +'" '+
                                'data-valid="'+ v.valid +'" data-chronic="' + v.chronic + '" class="btn btn-info">' +
                                '<i class="icon-share"></i></a></td>' +
                            '</tr>'
                        );
                    });
                }else{
                    $('#tbl_search_chronic_result_list > tbody').append(
                        '<tr>' +
                            '<td colspan="4">ไม่พบรายการ</td>' +
                        '</tr>'
                    );
                }

                app.hide_block(div);
            }
        });
    }
    //search dbpop
    $('#button_do_search_dbpop').click(function(){
        var query = $('#text_query_search_dbpop').val();
        if(!query){
            app.alert('กรุณระบุคำค้นหา เลขบัตรประชาชน หรือ ชื่อ-สกุล');
        }else{
            //do search
            $('#table_search_dbpop_result_list > tbody').empty();

            person.update.ajax.search_dbpop(query, function(err, data){
                if(err){
                    $('#table_search_dbpop_result_list > tbody').append(
                        '<tr>' +
                            '<td colspan="6">ไม่พบรายการ</td>' +
                            '</tr>'
                    );
                }else{
                    if( _.size(data.rows) ){
                        _.each(data.rows, function(v){
                            $('#table_search_dbpop_result_list > tbody').append(
                                '<tr>' +
                                    '<td>' + v.cid + '</td>' +
                                    '<td>' + v.fname + ' ' + v.lname + '</td>' +
                                    '<td>' + app.dbpop_to_thai_date(v.birthdate) + '</td>' +
                                    '<td>' + app.count_age_dbpop(v.birthdate) + '</td>' +
                                    '<td>[' + v.subinscl + '] ' + v.maininscl_name + '</td>' +
                                    '<td><a href="#" class="btn" data-name="button_set_data_from_dbopo" ' +
                                    'data-cid="' + v.cid + '" data-fname="'+ v.fname +'" data-lname="'+ v.lname+'" ' +
                                    'data-birth="'+ v.birthdate +'" data-maininscl="'+ v.maininscl +'" ' +
                                    ' data-inscl="'+ v.subinscl +'" data-sex="'+ v.sex +'" data-cardid="'+ v.cardid +'"' +
                                    ' data-startdate="'+ v.startdate+'" data-expdate="'+ v.expdate +'"' +
                                    ' data-hmain_code="'+ v.hmain_code +'" data-hmain_name="'+ v.hmain_name +'" ' +
                                    ' data-hsub_code="'+ v.hsub_code +'" data-hsub_name="'+ v.hsub_name +'"><i class="icon-share"></i></a></td>' +
                                    '</tr>'
                            );
                        });
                    }else{
                        $('#table_search_dbpop_result_list > tbody').append(
                            '<tr>' +
                                '<td colspan="6">ไม่พบรายการ</td>' +
                                '</tr>'
                        );
                    }
                }
            });
        }
    });

    $(document).on('click', 'a[data-name="button_set_data_from_dbopo"]', function(){
        var cid         = $(this).attr('data-cid'),
            fname       = $(this).attr('data-fname'),
            lname       = $(this).attr('data-lname'),
            birthdate   = app.convertDBPOPDateToEngDate($(this).attr('data-birth')),
            inscl       = $(this).attr('data-inscl'),
            maininscl   = $(this).attr('data-maininscl'),
            cardid      = $(this).attr('data-cardid'),
            sex         = $(this).attr('data-sex'),
            hmain_code  = $(this).attr('data-hmain_code'),
            hmain_name  = $(this).attr('data-hmain_name'),
            hsub_code   = $(this).attr('data-hsub_code'),
            hsub_name   = $(this).attr('data-hsub_name'),
            startdate   = app.convertDBPOPDateToEngDate($(this).attr('data-startdate')),
            expdate     = app.convertDBPOPDateToEngDate($(this).attr('data-expdate'));

        if(maininscl == 'SSS'){
            $('#sl_inscl_type').val('S1');
        }else if(maininscl == "OFC"){
            $('#sl_inscl_type').val("O1");
        }else{
            $('#sl_inscl_type').val(inscl);
        }

        //set person data
        $('#txt_cid').val(cid);
        $('#txt_first_name').val(fname);
        $('#txt_last_name').val(lname);
        $('#txt_birth_date').val(birthdate);
        $('#sl_sex').val(sex);
        $('#txt_inscl_code').val(cardid);
        $('#txtInsStartDate').val(startdate);
        $('#txtInsExpireDate').val(expdate);

        $('#txt_ins_hospmain_code').val(hmain_code);
        $('#txt_ins_hospmain_name').val(hmain_name);

        $('#txt_ins_hospsub_code').val(hsub_code);
        $('#txt_ins_hospsub_name').val(hsub_name);

        $('#modal_search_dbpop').modal('hide');
    });
    //search hospital
    $('#btn_do_search_hospital').click(function(){
        var query = $('#text_query_search_hospital').val();
        var op = $('#chk_search_by_name').is(":checked") ? 1 : 0;

        if(!query){
            app.alert('กรุณาระบคำที่ต้องการค้นหา');
        }else{
            //do search

            $('#table_search_hospital_result_list > tbody').empty();

            person.update.ajax.search_hospital(query, op, function(err, data){
                if(err){
                    $('#table_search_hospital_result_list > tbody').append(
                        '<tr>' +
                            '<td colspan="4">' + err + '</td>' +
                            '</tr>'
                    );
                }else{
                    if( _.size(data.rows) ){
                        _.each(data.rows, function(v){
                            $('#table_search_hospital_result_list > tbody').append(
                                '<tr>' +
                                    '<td>' + v.code + '</td>' +
                                    '<td>' + v.name + '</td>' +
                                    '<td>' + v.province + '</td>' +
                                    '<td><a href="#" class="btn" data-name="btn_set_hospital" ' +
                                    'data-code="' + v.code + '" data-vname="'+ v.name +'"><i class="icon-share"></i></a></td>' +
                                    '</tr>'
                            );
                        });
                    }else{
                        $('#table_search_hospital_result_list > tbody').append(
                            '<tr>' +
                                '<td colspan="4">ไม่พบรายการ</td>' +
                                '</tr>'
                        );
                    }
                }
            });
        }
    });

    $('#btn_search_hospital_main').click(function(){
        $('#txt_search_by').val('hmain');
        person.update.modal.show_search_hospital();
    });
    $('#btn_search_hospital_sub').click(function(){
        $('#txt_search_by').val('hsub');
        person.update.modal.show_search_hospital();
    });
    $('#txt_search_drug_allergy_hosp').click(function(){
        $('#txt_search_by').val('drug');
        $('#modal_search_drug_allergy').modal('hide');
        person.update.modal.show_search_hospital();

    });

    //search hospital dx chronic
    $('#btn_search_chronic_dx_hosp').click(function(){
        $('#txt_search_by').val('chronic_dx');
        $('#modal_search_chronic').modal('hide');
        person.update.modal.show_search_hospital();
    });

    $('#btn_search_chronic_rx_hosp').click(function(){
        $('#txt_search_by').val('chronic_rx');
        $('#modal_search_chronic').modal('hide');
        person.update.modal.show_search_hospital();
    });

    $(document).on('click', 'a[data-name="btn_set_hospital"]', function(){
        var act = $('#txt_search_by').val(),
            hospcode = $(this).attr('data-code'),
            hospname = $(this).attr('data-vname');

        if(act == 'hmain'){
            $('#txt_ins_hospmain_name').val(hospname);
            $('#txt_ins_hospmain_code').val(hospcode);
        }else if(act == 'hsub'){
            $('#txt_ins_hospsub_name').val(hospname);
            $('#txt_ins_hospsub_code').val(hospcode);
        }else if(act == 'drug'){
            $('#txt_drug_allergy_hosp_code').val(hospcode);
            $('#txt_drug_allergy_hosp_name').val(hospname);
            $('#modal_search_drug_allergy').modal('show');
        }else if(act == 'chronic_dx'){
            $('#txt_chronic_hosp_dx_code').val(hospcode);
            $('#txt_chronic_hosp_dx_name').val(hospname);
            $('#modal_search_chronic').modal('show');
        }else if(act == 'chronic_rx'){
            $('#txt_chronic_hosp_rx_code').val(hospcode);
            $('#txt_chronic_hosp_rx_name').val(hospname);
            $('#modal_search_chronic').modal('show');

        }else{
            //
        }
        $('#modal_search_hospital').modal('hide');
    });
/*
    $('#modal_search_hospital').on('hidden', function(){
        var act = $('#txt_search_by').val();

        if(act == 'drug'){
            $('#modal_search_drug_allergy').modal('show');
        }else if(act == 'chronic_dx' || act == 'chronic_rx'){
            $('#modal_search_chronic').modal('show');
        }
    });
    */
    //get ampur list
    $('#slOutsideProvince').change(function(){
        var chw = $(this).val();

        //load ampur list
        person.update.ajax.get_ampur(chw, function(err, data){
            $('#slOutsideAmpur').empty();
            $('#slOutsideTambon').empty();

            $('#slOutsideAmpur').append('<option value="00">--</option>');
            _.each(data.rows, function(v){
                if(!v.name.match(/\*/))
                    $('#slOutsideAmpur').append('<option value="'+ v.code +'">'+ v.name +'</option>');
            });

        });
    });

    $('#slOutsideAmpur').change(function(){
        var chw = $('#slOutsideProvince').val(),
            amp = $(this).val();

        //load ampur list
        person.update.ajax.get_tambon(chw, amp, function(err, data){
            $('#slOutsideTambon').empty();
            $('#slOutsideTambon').append('<option value="00">--</option>');
            _.each(data.rows, function(v){
                if(!v.name.match(/\*/))
                    $('#slOutsideTambon').append('<option value="'+ v.code +'">'+ v.name +'</option>');
            });

        });
    });

    //save person
    $('#btn_save_person').click(function(){
        var items = {};

        items.hn                = person.hn;
        items.cid               = $('#txt_cid').val();
        items.old_cid           = $('#txt_old_cid').val();
        items.title             = $('#slTitle').val();
        items.first_name        = $('#txt_first_name').val();
        items.last_name         = $('#txt_last_name').val();
        items.sex               = $('#sl_sex').val();
        items.birthdate         = $('#txt_birth_date').val();
        items.mstatus           = $('#slMStatus').val();
        items.occupation        = $('#slOccupation').val();
        items.race              = $('#slRace').val();
        items.nation            = $('#slNation').val();
        items.religion          = $('#slReligion').val();
        items.education         = $('#slEducation').val();
        items.fstatus           = $('#slFstatus').val();
        items.vstatus           = $('#slVstatus').val();
        items.father_cid        = $('#txtFatherCid').val();
        items.mother_cid        = $('#txtMotherCid').val();
        items.couple_cid        = $('#txtCoupleCid').val();
        items.movein_date       = $('#txtMoveInDate').val();
        items.discharge_date    = $('#txtDischargeDate').val();
        items.discharge_status  = $('#slDischarge').val();
        items.abogroup          = $('#slABOGroup').val();
        items.rhgroup           = $('#slRHGroup').val();
        items.labor_type        = $('#slLabor').val();
        items.typearea          = $('#slTypeArea').val();
        items.passport          = $('#txt_passport').val();

        //address
        items.address = {};
        items.address.address_type  = $('#slOutsiedAddressType').val();
        items.address.house_id      = $('#txtOutsideHouseId').val();
        items.address.house_type    = $('#slOutsiedHouseType').val();
        items.address.room_no       = $('#txtOutsideRoomNumber').val();
        items.address.condo         = $('#txtOutsideCondo').val();
        items.address.houseno       = $('#txtOutsideAddressNumber').val();
        items.address.soi_sub       = $('#txtOutsideSoiSub').val();
        items.address.soi_main      = $('#txtOutsideSoiMain').val();
        items.address.road          = $('#txtOutsideRoad').val();
        items.address.village_name  = $('#txtOutsideVillageName').val();
        items.address.village       = $('#slOutsideVillage').val();
        items.address.tambon        = $('#slOutsideTambon').val();
        items.address.ampur         = $('#slOutsideAmpur').val();
        items.address.changwat      = $('#slOutsideProvince').val();
        items.address.postcode      = $('#txtOutsidePostcode').val();
        items.address.telephone     = $('#txtOutsideTelephone').val();
        items.address.mobile        = $('#txtOutsideMobile').val();

        //insurance
        items.ins = {};
        items.ins.id            = $('#sl_inscl_type').val();
        items.ins.code          = $('#txt_inscl_code').val();
        items.ins.start_date    = $('#txtInsStartDate').val();
        items.ins.expire_date   = $('#txtInsExpireDate').val();
        items.ins.hmain         = $('#txt_ins_hospmain_code').val();
        items.ins.hsub          = $('#txt_ins_hospsub_code').val();

        if(!items.hn){
            app.alert('ไม่พบลรหัสบุคคลที่ต้องการปรับปรุง [HN]');
        }else if(!items.cid || items.cid.length != 13){
            app.alert('กรุณาระบุเลขบัตรประชาชน/รูปแบบไม่ถูกต้อง');
        }else if(!items.title){
            app.alert('กรุณาเลือกคำนำหน้าชื่อ');
        }else if(!items.first_name){
            app.alert('กรุณาระบุชื่อ');
        }else if(!items.last_name){
            app.alert('กรุณาระบุสกุล');
        }else if(!items.sex){
            app.alert('กรุณาเลือกเพศ');
        }else if(!items.birthdate){
            app.alert('กรุณาระบุวันเดือนปี เกิด');
        }else if(!items.mstatus){
            app.alert('กรุณาระบุสถานะการสมรส');
        }else if(!items.occupation){
            app.alert('กรุณาระบุอาชีพ');
        }else if(!items.race){
            app.alert('กรุณาระบุเชื้อชาติ');
        }else if(!items.nation){
            app.alert('กรุณาระบุสัญชาติ');
        }else if(!items.religion){
            app.alert('กรุณาระบุศาสนา');
        }else if(!items.education){
            app.alert('กรุณาระบุการศึกษา')
        }else if(!items.fstatus){
            app.alert('กรุณาระบุสถานะในครอบครัว');
        }else if(!items.vstatus){
            app.alert('กรุณาระบุสถานะในชุมชน');
        }else if(!items.labor_type){
            app.alert('กรุณาระบุความเป็นต่างด้าว');
        }else if(!items.typearea){
            app.alert('กรุณาระบุประเภทบุคคล');
        }else if(!items.ins.id){
            app.alert('กรุณาระบุสิทธิการรักษา');
        }else{
            if(items.typearea == '3' || items.typearea == '4' || items.typearea == '0'){
                //check address
                if(!items.address.changwat){
                    app.alert('กรุณาระบุจังหวัด นอกเขต');
                }else if(!items.address.ampur){
                    app.alert('กรุณาระบุอำเภอ นอกเขต');
                }else if(!items.address.tambon){
                    app.alert('กรุณาระบุตำบล นอกเขต');
                }else{
                    //save with address
                    person.update.ajax.update_person(items, function(err){
                        if(err){
                            app.alert(err);
                        }else{
                            if(confirm('บันทึกข้อมูลเสร็จเรียบร้อยแล้วคุณต้องการกลับหน้าหลักหรือไม่?')){
                                person.clear_register_form();
                                app.go_to_url('person');
                            }
                        }
                    });
                }
            }else{
                //save without address
                person.update.ajax.update_person(items, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        if(confirm('บันทึกข้อมูลเสร็จเรียบร้อยแล้วคุณต้องการกลับหน้าหลักหรือไม่?')){
                            person.clear_register_form();
                            app.go_to_url('person');
                        }
                    }
                });
            }
        }
    });

    //clear register form
    $("#btn_back_to_home").click(function(){
        app.go_to_url('person');
    });

    $('#btn_tab_drug_allergy').click(function(){
        $('#frm_update_person').fadeOut('slow');
    });

    $('#btn_tab_chronic').click(function(){
        $('#frm_update_person').fadeOut('slow');
    });

    $('#btn_tab_person_info').click(function(){
        $('#frm_update_person').fadeIn('slow');
    });
    $('#btn_tab_person_right').click(function(){
        $('#frm_update_person').fadeIn('slow');
    });
    $('#btn_tab_person_address').click(function(){
        $('#frm_update_person').fadeIn('slow');
    });

    $('#btn_new_drug_allergy').click(function(){
        $('#txt_drug_isupdate').val('');
        person.update.clear_drug_allergy_form();

        person.update.modal.show_search_drug_allergy();
    });
/*
    //search drug
    $('#button_do_search_drug').click(function(){
        var query = $('#text_query_search_drug').val();

        if(!query || query.trim().length < 2 ){
            app.alert('กรุณาระบุคำที่ต้องการค้นหา / 2 ตัวอักษรขึ้นไป');
        }else{
            //do search
            var div = $('#div_search_drug_allergy_result');

            app.show_block(div);

            person.update.ajax.search_drug(query, function(err, data){

                $('#tbl_search_drug_result_list > tbody').empty();

                if(err){
                    app.alert(err);
                    app.hide_block(div);
                }else{
                    if(_.size(data.rows)){
                        _.each(data.rows, function(v){
                            $('#tbl_search_drug_result_list > tbody').append(
                                '<tr>' +
                                   // '<td>' + v.stdcode + '</td>' +
                                    '<td>' + v.name + '</td>' +
                                    '<td>' + v.unit + '</td>' +
                                    '<td>' + v.streng + '</td>' +
                                    '<td>' + v.price + '</td>' +
                                    '<td><a href="javascript:void(0);" data-name="btn_set_drug_allergy_info" class="btn btn-info" ' +
                                    'data-id="' + v.id + '" data-vname="' + v.name + '"><i class="icon-share"></i></a></td>' +
                                    '</tr>'
                            );
                        });
                    }else{
                        $('#tbl_search_drug_result_list > tbody').append(
                            '<tr><td colspan="5">ไม่พบรายการ</td></tr>'
                        );
                    }

                    app.hide_block(div);

                }
            });
        }
    });
*/
    $('a[href="#tab_drug_search"]').click(function(){
        //person.update.clear_drug_allergy_form();
    });
/*
    //set drug allergy info
    $('a[data-name="btn_set_drug_allergy_info"]').on('click', function(){

        var isupdate = $('#txt_drug_isupdate').val();

        if(isupdate){
            app.alert('ไม่สามารถแก้ไขรายการยาได้ กรุณาลบรายการแล้วทำการเพิ่มใหม่');
        }else{
            var id = $(this).attr('data-id'),
                name = $(this).attr('data-vname');

            $('#txt_drug_name').val(name);
            $('#txt_drug_code').val(id);
        }

        $('a[href="#tab_save_drug_allergy"]').tab('show');

    });
    */
    //save drug allergy
    $('#btn_save_drug_allergy').click(function(){
        var items = {};

        items.isupdate = $('#txt_drug_isupdate').val();
        items.drug_id = $('#txt_drug_code').val();
        items.drug_id_old = $('#txt_drug_code_old').val();
        items.diag_type_id = $('#sl_type_diag').val();
        items.record_date = $('#txt_date_record').val();
        items.alevel_id = $('#sl_drug_allergy_alevel').val();
        items.symptom_id = $('#sl_drug_allergy_symptom').val();
        items.informant_id = $('#sl_drug_allergy_informant').val();
        items.hospcode = $('#txt_drug_allergy_hosp_code').val();

        items.hn = person.hn;

        if(!items.hn){
            app.alert('ไม่พบรหัสบุคคล กรุณาตรวจสอบ');
        }else if(!items.record_date){
            app.alert('กรุณาระบุวันที่บันทึก');
        }else if(!items.diag_type_id){
            app.alert('กรุณาระบุประเภทการวินิจฉัย')
        }else if(!items.alevel_id){
            app.alert('กรุณาระบุระดับความรุนแรง');
        }else if(!items.drug_id){
            app.alert('กรุณาเลือกรายการยา ที่ต้องการบันทึก');
        }else if(!items.hospcode){
            app.alert('กรุณาระบุหน่วยบริการที่บันทึก');
        }else{
            //do save
            person.update.ajax.save_drug_allergy(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    $('#modal_search_drug_allergy').modal('hide');
                    person.update.clear_drug_allergy_form();
                    person.update.get_drug_allergy_list(person.hn);
                }
            });
        }
    });

    //edit drug allergy

    $(document).on('click', 'a[data-name="btn_edit_drug_allergy"]', function(){
        //set detail
        var drug_id = $(this).attr('data-id');
        person.update.set_drug_allergy_detail(person.hn, drug_id);
    });

    //remove drug allergy
    $(document).on('click', 'a[data-name="btn_remove_drug_allergy"]', function(){

        var drug_id = $(this).attr('data-id');

        //if(app.confirm('ยืนยันการลยข้อมูล');
        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(cb){
            if(cb){
                 person.update.ajax.remove_drug_allergy(person.hn, drug_id, function(err){
                     if(err){
                        app.alert(err);
                     }else{
                         app.alert('ลบรายการเรียบร้อยแล้ว');

                         person.update.clear_drug_allergy_form();
                         person.update.get_drug_allergy_list(person.hn);
                     }
                 });
            }
        });
    });

    $('#btn_tab_drug_allergy').click(function(){
        person.update.get_drug_allergy_list(person.hn);
    });

    $('#txt_drug_allergy_hosp_name').typeahead({
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

            $('#txt_drug_allergy_hosp_code').val(code);
            $('#txt_drug_allergy_hosp_name').val(name);

            return name;
        }
    });

    //typeahead for drug allergy
    $('#txt_drug_name').typeahead({
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

            $('#txt_drug_code').val(code);
            $('#txt_drug_name').val(name);

            return name;
        }
    });

    $('#txt_chronic_hosp_dx_name').typeahead({
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

            $('#txt_chronic_hosp_dx_code').val(code);
            $('#txt_chronic_hosp_dx_name').val(name);

            return name;
        }
    });

    $('#txt_chronic_hosp_rx_name').typeahead({
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

            $('#txt_chronic_hosp_rx_code').val(code);
            $('#txt_chronic_hosp_rx_name').val(name);

            return name;
        }
    });


    $('#txt_chronic_name').typeahead({
        ajax: {
            url: site_url + 'basic/search_icd_chronic_ajax',
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

            $('#txt_chronic_code').val(code);
            $('#txt_chronic_name').val(name);

            return name;
        }
    });

    //new chronic
    $('#btn_new_chronic').click(function(){
        person.update.clear_chronic_form();
        $('a[href="#tab_chronic_search"]').tab('show');
        person.update.modal.show_search_chronic();
    });

    //search chronic
    $('#button_do_search_chronic').click(function(){
        var query = $('#text_query_search_chronic').val(),
            op = $('#chk_chronic_search_by_code').is(":checked") ? 1 : 0;

        if(query){
            if($.trim(query).length > 2){
                //do search
                person.update.search_icd10(query, op);
            }else{
                app.alert('กรุณาระบุคำค้น มากว่า 2 ตัวอักษรขึ้นไป');
            }
        }else{
            app.alert('กรุณาระบุคำที่ต้องการค้นหา');
        }
    });
    /*
     '<td><a href="javascript:void(0)" data-code="'+ v.code +'" data-name="btn_select_chronic_diag" data-vname="'+ v.desc_r +'" '+
     'data-valid="'+ v.valid +'" class="btn btn-info">' +
     */
    $(document).on('click', 'a[data-name="btn_select_chronic_diag"]', function(){
        var valid = $(this).attr('data-valid'),
            chronic = $(this).attr('data-chronic'),
            isupdate = $('#txt_chronic_isupdate').val();

        if(isupdate){
            app.alert('ไม่สามารถแก้ไขรหัสได้ กรุณาลบรายการนี้แล้วเพิ่มใหม่');
        }else{
            if(valid == 'T'){ //valid
                if(chronic == 'Y'){
                    //set diag detail
                    var diag_code = $(this).attr('data-code'),
                        diag_name = $(this).attr('data-vname');

                    $('#txt_chronic_code').val(diag_code);
                    $('#txt_chronic_name').val(diag_name);

                    //set selected tab
                    $('a[href="#tab_save_chronic"]').tab('show');
                }else{
                    app.alert('รหัสนี้ไม่ใช่รหัสโรคเรื้อรัง กรุณาใช้รหัสใหม่');
                }
            }else{
                app.alert('รายการนี้ไม่สามารถใช้งานได้ กรุณาตรวจสอบรหัสการวินิจฉัยโรค');
            }
        }

    });

    person.update.clear_chronic_form = function(){
        $('#txt_chronic_isupdate').val('');
        $('#txt_chronic_hosp_dx_code').val('');
        $('#txt_chronic_hosp_rx_code').val('');
        $('#txt_chronic_date_diag').val('');
        $('#txt_chronic_code').val('');
        $('#txt_chronic_date_disch').val('');
        $('#txt_chronic_hosp_rx_name').val('');
        $('#txt_chronic_hosp_dx_name').val('');
        $('#txt_chronic_name').val('');
        $('#txt_chronic_name').removeAttr('disabled');
        $('#txt_chronic_name').attr('background-color', 'white');

        app.set_first_selected($('#sl_chronic_dischage_type'));
    };

    person.update.get_chronic_list = function(hn){
        $('#tbl_chronic_list > tbody').empty();
        person.update.ajax.get_chronic_list(hn, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_chronic_list > tbody').append(
                        '<tr><td colspan="5">ไม่พบรายการ</td></tr>'
                    );
            }else{
                if(_.size(data.rows)){
                    _.each(data.rows, function(v){
                        $('#tbl_chronic_list > tbody').append(
                            '<tr>' +
                                // '<td>' + v.stdcode + '</td>' +
                                '<td>' + v.chronic + '</td>' +
                                '<td>' + v.chronic_name + '</td>' +
                                '<td>' + v.diag_date + '</td>' +
                                '<td>' + v.discharge_type_name + '</td>' +
                                '<td>' + v.discharge_date + '</td>' +
                                '<td><div class="btn-group">' +
                                '<a href="javascript:void(0);" data-name="btn_chronic_edit" class="btn" ' +
                                'data-code="' + v.chronic + '" data-desc_r="' + v.chronic_name + '" data-diag_date="' + v.diag_date + '" ' +
                                'data-discharge="' + v.discharge_type + '" data-discharge_date="' + v.discharge_date + '" ' +
                                'data-hosp_dx_code="' + v.hosp_dx_code + '" data-hosp_rx_code="' + v.hosp_rx_code + '" '+
                                'data-hosp_dx_name="' + v.hosp_dx_name + '" data-hosp_rx_name="' + v.hosp_rx_name + '"> '+
                                '<i class="icon-edit"></i></a>' +
                                '<a href="javascript:void(0);" class="btn" data-name="btn_chronic_remove" data-id="'+ v.chronic +'">' +
                                '<i class="icon-trash"></i>' +
                                '</a>' +
                                '</div></td>' +
                                '</tr>'
                        );
                    });
                }else{
                    $('#tbl_chronic_list > tbody').append(
                        '<tr><td colspan="5">ไม่พบรายการ</td></tr>'
                    );
                }
            }
        });
    }

    //remove chronic
    $(document).on('click', 'a[data-name="btn_chronic_remove"]', function(){
        var diag_code = $(this).attr('data-id');

        var obj = $(this).parent().parent().parent();

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่', function(res){
            if(res){
                //do remove
                person.update.ajax.remove_chronic(person.hn, diag_code, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        obj.fadeOut('slos');
                    }
                });
            }
        });
    });

    $('#btn_save_chronic').click(function(){
        var items = {};
        items.hn = person.hn;
        items.isupdate = $('#txt_chronic_isupdate').val();
        items.hosp_dx = $('#txt_chronic_hosp_dx_code').val();
        items.hosp_rx = $('#txt_chronic_hosp_rx_code').val();
        items.diag_date = $('#txt_chronic_date_diag').val();
        items.chronic = $('#txt_chronic_code').val();
        items.discharge_date = $('#txt_chronic_date_disch').val();
        items.discharge_type = $('#sl_chronic_dischage_type').val();

        if(!items.diag_date){
            app.alert('กรุณาระบุวันเดือนปี ที่ตรวจพบครั้งแรก');
        }else if(!items.chronic){
            app.alert('กรุณาระบุรหัสโรคเรื้อรัง');
        }else if(!items.hosp_dx){
            app.alert('กรุณาระบุสถานพยาบาลที่วินิจฉัยครั้งแรก');
        }else if(!items.discharge_type){
            app.alert('กรุณาระบุสถานะการจำหน่าย');
        }else{
            //do save
            person.update.ajax.save_chronic(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    //clear form
                    person.update.clear_chronic_form();
                    //hide form
                    $('#modal_search_chronic').modal('hide');
                    //load chronic list
                    person.update.get_chronic_list(items.hn);
                }
            });
        }
    });

    $('#btn_tab_chronic').click(function(){
        person.update.get_chronic_list(person.hn);
    });

    $(document).on('click', 'a[data-name="btn_chronic_edit"]', function(){
        var chronic = $(this).attr('data-code'),
            chronic_name = $(this).attr('data-desc_r'),
            diag_date = $(this).attr('data-diag_date'),
            discharge = $(this).attr('data-discharge'),
            discharge_date = $(this).attr('data-discharge_date'),
            hosp_dx_code = $(this).attr('data-hosp_dx_code'),
            hosp_rx_code = $(this).attr('data-hosp_rx_code'),
            hosp_dx_name = $(this).attr('data-hosp_dx_name'),
            hosp_rx_name = $(this).attr('data-hosp_rx_name');

        $('#txt_chronic_isupdate').val('1');
        $('#txt_chronic_hosp_dx_code').val(hosp_dx_code);
        $('#txt_chronic_hosp_rx_code').val(hosp_rx_code);
        $('#txt_chronic_date_diag').val(diag_date);
        $('#txt_chronic_code').val(chronic);
        $('#txt_chronic_date_disch').val(discharge_date);
        $('#txt_chronic_hosp_rx_name').val(hosp_rx_name);
        $('#txt_chronic_hosp_dx_name').val(hosp_dx_name);
        $('#txt_chronic_name').val(chronic_name).attr('disabled', 'disabled').css('background-color', 'white');

        $('#sl_chronic_dischage_type').val(discharge);

        person.update.modal.show_search_chronic();
        $('a[href="#tab_save_chronic"]').tab('show');
    });
});