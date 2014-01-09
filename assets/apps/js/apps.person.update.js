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
        show_allergy: function(hn){
            app.load_page($('#modal_search_drug_allergy'), '/pages/allergies/' + hn, 'assets/apps/js/pages/allergies.js');
            $('#modal_search_drug_allergy').modal({keyboard: false});
        },
        show_update_allergy: function(hn, id){
            app.load_page($('#modal_search_drug_allergy'), '/pages/allergies/' + hn + '/' + id, 'assets/apps/js/pages/allergies.js');
            $('#modal_search_drug_allergy').modal({keyboard: false});
        },
        show_search_chronic: function(){
            $('#modal_search_chronic').modal({
                backdrop: 'static'
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

//        save_drug_allergy: function(data, cb){
//
//            var url = 'person/save_drug_allergy',
//                params = {
//                    data: data
//                };
//
//            app.ajax(url, params, function(err, data){
//                return err ? cb(err) : cb(null);
//            });
//
//        },

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
//    person.clear_register_form = function(){
//        $('#txt_cid').val('');
//        $('#txt_first_name').val('');
//        $('#txt_last_name').val('');
//        $('#txt_birth_date').val('');
//        $('#txtFatherCid').val('');
//        $('#txtMotherCid').val('');
//        $('#txtCoupleCid').val('');
//        $('#txtMoveInDate').val('');
//        $('#txtDischargeDate').val('');
//        $('#txt_passport').val('');
//
//        //address
//        $('#txtOutsideHouseId').val('');
//        $('#txtOutsideRoomNumber').val('');
//        $('#txtOutsideCondo').val('');
//        $('#txtOutsideAddressNumber').val('');
//        $('#txtOutsideSoiSub').val('');
//        $('#txtOutsideSoiMain').val('');
//        $('#txtOutsideRoad').val('');
//        $('#txtOutsideVillageName').val('');
//        $('#txtOutsidePostcode').val('');
//        $('#txtOutsideTelephone').val('');
//        $('#txtOutsideMobile').val('');
//
//        //insurance
//        $('#txt_inscl_code').val('');
//        $('#txtInsStartDate').val('');
//        $('#txtInsExpireDate').val('');
//        $('#txt_ins_hospmain_code').val('');
//        $('#txt_ins_hospsub_code').val('');
//        $('#txt_ins_hospmain_name').val('');
//        $('#txt_ins_hospsub_name').val('');
//    };

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
                                '<td>' + app.to_thai_date(v.record_date) + '</td>' +
                                '<td>' + v.drug_name + '</td>' +
                                '<td>' + v.symptom_name + '</td>' +
                                '<td>' + v.alevel_name + '</td>' +
                                // '<td>' + v.informant_name + '</td>' +
                                '<td>' + v.hospname + '</td>' +
                                '<td>' + v.user_fullname + '</td>' +
                                '<td>' +
                                '<div class="btn-group"> ' +
                                '<button class="btn btn-default" type="button" data-name="btn_allergy_edit" ' +
                                'data-id="' + v.drug_id + '" title="แก้ไขรายการ"><i class="fa fa-edit"></i></button>' +
                                '<button class="btn btn-danger" type="button" data-name="btn_allergy_remove" ' +
                                'data-id="' + v.drug_id + '" title="ลบรายการ"><i class="fa fa-trash-o"></i></button>' +
                                '</div></td>' +
                                '</tr>'
                        );
                    });
                }else{
                    $('#tbl_drug_allergy_list > tbody').append('<tr><td colspan="7">ไม่พบรายการ</td></tr>');
                }
            }
        });
    };

    $(document).on('click', 'button[data-name="btn_allergy_edit"]', function() {
        var id = $(this).data('id');
        var hn = $('#hn').val();

        person.update.modal.show_update_allergy(hn, id);
    });
    //remove drug
    $(document).on('click', 'button[data-name="btn_allergy_remove"]', function(){
        var id = $(this).attr('data-id');
        var hn = $('#hn').val();

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res){
                person.update.ajax.remove_drug_allergy(hn, id, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        person.update.get_drug_allergy_list(hn);
                    }
                });
            }
        });

    });

    $('#btn_allergy_refresh').on('click', function() {
        var hn = $('#hn').val();
        person.update.get_drug_allergy_list(hn);
    });


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
        items.title             = $('#slTitle').select2('val');
        items.first_name        = $('#txt_first_name').val();
        items.last_name         = $('#txt_last_name').val();
        items.sex               = $('#sl_sex').select2('val');
        items.birthdate         = $('#txt_birth_date').val();
        items.mstatus           = $('#slMStatus').select2('val');
        items.occupation        = $('#slOccupation').select2('val');
        items.race              = $('#slRace').select2('val');
        items.nation            = $('#slNation').select2('val');
        items.religion          = $('#slReligion').select2('val');
        items.education         = $('#slEducation').select2('val');
        items.fstatus           = $('#slFstatus').select2('val');
        items.vstatus           = $('#slVstatus').select2('val');
        items.father_cid        = $('#txtFatherCid').val();
        items.mother_cid        = $('#txtMotherCid').val();
        items.couple_cid        = $('#txtCoupleCid').val();
        items.movein_date       = $('#txtMoveInDate').val();
        items.discharge_date    = $('#txtDischargeDate').val();
        items.discharge_status  = $('#slDischarge').select2('val');
        items.abogroup          = $('#slABOGroup').select2('val');
        items.rhgroup           = $('#slRHGroup').select2('val');
        items.labor_type        = $('#slLabor').select2('val');
        items.typearea          = $('#slTypeArea').select2('val');
        items.passport          = $('#txt_passport').val();

        //address
        items.address = {};
        items.address.address_type  = $('#slOutsiedAddressType').select2('val');
        items.address.house_id      = $('#txtOutsideHouseId').val();
        items.address.house_type    = $('#slOutsiedHouseType').select2('val');
        items.address.room_no       = $('#txtOutsideRoomNumber').val();
        items.address.condo         = $('#txtOutsideCondo').val();
        items.address.houseno       = $('#txtOutsideAddressNumber').val();
        items.address.soi_sub       = $('#txtOutsideSoiSub').val();
        items.address.soi_main      = $('#txtOutsideSoiMain').val();
        items.address.road          = $('#txtOutsideRoad').val();
        items.address.village_name  = $('#txtOutsideVillageName').val();
        items.address.village       = $('#slOutsideVillage').select2('val');
        items.address.tambon        = $('#slOutsideTambon').select2('val');
        items.address.ampur         = $('#slOutsideAmpur').select2('val');
        items.address.changwat      = $('#slOutsideProvince').select2('val');
        items.address.postcode      = $('#txtOutsidePostcode').val();
        items.address.telephone     = $('#txtOutsideTelephone').val();
        items.address.mobile        = $('#txtOutsideMobile').val();

        //insurance
        items.ins = {};
        var hospmain            = $('#txt_ins_hospmain_name').select2('data');
        var hospsub             = $('#txt_ins_hospsub_name').select2('data');

        items.ins.id            = $('#sl_inscl_type').select2('val');
        items.ins.code          = $('#txt_inscl_code').val();
        items.ins.start_date    = $('#txtInsStartDate').val();
        items.ins.expire_date   = $('#txtInsExpireDate').val();
        items.ins.hmain         = hospmain === null ? '' : hospmain.code;
        items.ins.hsub          = hospsub === null ? '' : hospsub.code;

        if(!items.hn) {
            app.alert('ไม่พบลรหัสบุคคลที่ต้องการปรับปรุง [HN]');
        } else if(!items.cid || items.cid.length != 13) {
            app.alert('กรุณาระบุเลขบัตรประชาชน/รูปแบบไม่ถูกต้อง');
        } else if(!items.title) {
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
            if( _.contains(['3', '4', '0'], items.typearea) ){
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
        //app.go_to_url('person');
        history.go(-1);
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
        var hn = $('#hn').val();
        person.update.modal.show_allergy(hn);
    });

//    //save drug allergy
//    $('#btn_save_drug_allergy').click(function(){
//        var items = {};
//
//        items.isupdate = $('#txt_drug_isupdate').val();
//        items.drug_id = $('#txt_drug_code').val();
//        items.drug_id_old = $('#txt_drug_code_old').val();
//        items.diag_type_id = $('#sl_type_diag').val();
//        items.record_date = $('#txt_date_record').val();
//        items.alevel_id = $('#sl_drug_allergy_alevel').val();
//        items.symptom_id = $('#sl_drug_allergy_symptom').val();
//        items.informant_id = $('#sl_drug_allergy_informant').val();
//        items.hospcode = $('#txt_drug_allergy_hosp_code').val();
//
//        items.hn = person.hn;
//
//        if(!items.hn){
//            app.alert('ไม่พบรหัสบุคคล กรุณาตรวจสอบ');
//        }else if(!items.record_date){
//            app.alert('กรุณาระบุวันที่บันทึก');
//        }else if(!items.diag_type_id){
//            app.alert('กรุณาระบุประเภทการวินิจฉัย')
//        }else if(!items.alevel_id){
//            app.alert('กรุณาระบุระดับความรุนแรง');
//        }else if(!items.drug_id){
//            app.alert('กรุณาเลือกรายการยา ที่ต้องการบันทึก');
//        }else if(!items.hospcode){
//            app.alert('กรุณาระบุหน่วยบริการที่บันทึก');
//        }else{
//            //do save
//            person.update.ajax.save_drug_allergy(items, function(err){
//                if(err){
//                    app.alert(err);
//                }else{
//                    $('#modal_search_drug_allergy').modal('hide');
//                    person.update.clear_drug_allergy_form();
//                    person.update.get_drug_allergy_list(person.hn);
//                }
//            });
//        }
//    });

    $('#btn_tab_drug_allergy').click(function(){
        person.update.get_drug_allergy_list(person.hn);
    });


    person.update.set_hospital_selected = function() {
        var
            hosp_main_name = $('#txt_ins_hospmain_name1').val()
            , hosp_main_code = $('#txt_ins_hospmain_code1').val()
            , hosp_sub_name = $('#txt_ins_hospsub_name1').val()
            , hosp_sub_code = $('#txt_ins_hospsub_code1').val()
            ;

        $('#txt_ins_hospmain_name').select2('data', { code: hosp_main_code, name: hosp_main_name });
        $('#txt_ins_hospsub_name').select2('data', { code: hosp_sub_code, name: hosp_sub_name });
    };


    $('#txt_ins_hospmain_name').select2({
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

    $('#txt_ins_hospsub_name').select2({
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

    //new chronic
    $('#btn_new_chronic').click(function(){
        person.update.clear_chronic_form();
        $('a[href="#tab_chronic_search"]').tab('show');
        person.update.modal.show_search_chronic();
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
                                '<a href="javascript:void(0);" data-name="btn_chronic_edit" class="btn btn-default" ' +
                                'data-code="' + v.chronic + '" data-desc_r="' + v.chronic_name + '" data-diag_date="' + v.diag_date + '" ' +
                                'data-discharge="' + v.discharge_type + '" data-discharge_date="' + v.discharge_date + '" ' +
                                'data-hosp_dx_code="' + v.hosp_dx_code + '" data-hosp_rx_code="' + v.hosp_rx_code + '" '+
                                'data-hosp_dx_name="' + v.hosp_dx_name + '" data-hosp_rx_name="' + v.hosp_rx_name + '"> '+
                                '<i class="fa fa-edit"></i></a>' +
                                '<a href="javascript:void(0);" class="btn btn-danger" data-name="btn_chronic_remove" data-id="'+ v.chronic +'">' +
                                '<i class="fa fa-trash-o"></i>' +
                                '</a>' +
                                '</div></td>' +
                                '</tr>'
                        );
                    });
                }else{
                    $('#tbl_chronic_list > tbody').append(
                        '<tr><td colspan="6">ไม่พบรายการ</td></tr>'
                    );
                }
            }
        });
    }

    //remove chronic
    $(document).on('click', 'a[data-name="btn_chronic_remove"]', function(){
        var diag_code = $(this).attr('data-id');

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่', function(res){
            if(res){
                //do remove
                person.update.ajax.remove_chronic(person.hn, diag_code, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');

                        var hn = $('#hn').val();
                        person.update.get_chronic_list(hn);
                    }
                });
            }
        });
    });

    $('#btn_save_chronic').click(function(){
        var
            items = {}
            , hosp_dx = $('#txt_chronic_hosp_dx_name').select2('data')
            , hosp_rx = $('#txt_chronic_hosp_rx_name').select2('data')
            , chronic = $('#txt_chronic_name').select2('data')
        ;


        items.hn = person.hn;
        items.isupdate = $('#txt_chronic_isupdate').val();
        items.hosp_dx = hosp_dx === null ? '' : hosp_dx.code;
        items.hosp_rx = hosp_rx === null ? '' : hosp_rx.code;
        items.chronic = chronic === null ? '' : chronic.code;

        items.diag_date = $('#txt_chronic_date_diag').val();
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

    $('#btn_refresh_chronic').on('click', function(e) {
        e.preventDefault();

        person.update.get_chronic_list(person.hn);
    });

    $(document).on('click', 'a[data-name="btn_chronic_edit"]', function(){
        var
            chronic             = $(this).data('code')
            , chronic_name      = $(this).data('desc_r')
            , diag_date         = $(this).data('diag_date')
            , discharge         = $(this).data('discharge')
            , discharge_date    = $(this).data('discharge_date')
            , hosp_dx_code      = $(this).data('hosp_dx_code')
            , hosp_rx_code      = $(this).data('hosp_rx_code')
            , hosp_dx_name      = $(this).data('hosp_dx_name')
            , hosp_rx_name      = $(this).data('hosp_rx_name')
        ;

        $('#txt_chronic_isupdate').val('1');
        $('#txt_chronic_hosp_dx_name').select2('data', { code: hosp_dx_code, name: hosp_dx_name });
        $('#txt_chronic_hosp_rx_name').select2('data', { code: hosp_rx_code, name: hosp_rx_name });
        $('#txt_chronic_date_diag').val(diag_date);
        $('#txt_chronic_name').select2('data', { code: chronic, name: chronic_name });
        $('#txt_chronic_name').select2('enable', false);

        $('#txt_chronic_date_disch').val(discharge_date);
        $('#sl_chronic_dischage_type').select2('val', discharge);

        person.update.modal.show_search_chronic();
        $('a[href="#tab_save_chronic"]').tab('show');
    });

    $('#txt_chronic_name').select2({
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

    $('#txt_chronic_hosp_dx_name').select2({
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

    $('#txt_chronic_hosp_rx_name').select2({
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

    person.update.set_hospital_selected();
});