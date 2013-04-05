/**
 * Register new patient
 */
head.ready(function(){
    var person = {};
    person.register = {};

    //Register modal
    person.register.modal = {
        //Search person from dbpop
        show_search_dbpop: function(){
            $('#modal_search_dbpop').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
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
        }
    };
    //click event for search dbpop
    $('#btn_search_dbpop').click(function(){
        person.register.modal.show_search_dbpop();
    });

    //main ajax function for register person
    person.register.ajax = {
        /**
         * Save person
         *
         * @param data  Person detail
         * @param cb    Callback function
         */
        save_person: function(data, cb){

            var url = 'person/save',
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

        search_dbpop: function(query, by, cb){

            var url = 'person/search_dbpop',
                params = {
                    query: query,
                    by: by
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

    //search dbpop
    $('#button_do_search_dbpop').click(function(){
        var query = $('#text_query_search_dbpop').val(),
            by = $('#txt_dbpop_search_by').val();

        if(!query){
            app.alert('กรุณาระบุเลขบัตรประชาชน');
        }else{
            //do search
            $('#table_search_dbpop_result_list tbody').empty();

            person.register.ajax.search_dbpop(query, by, function(err, data){
                if(err){
                    app.alert(err);

                    $('#table_search_dbpop_result_list tbody').append(
                        '<tr>' +
                            '<td colspan="6">ไม่พบรายการ</td>' +
                            '</tr>'
                    );
                }else{
                    if( _.size(data) ){
                        _.each(data.rows, function(v){
                            $('#table_search_dbpop_result_list tbody').append(
                                '<tr>' +
                                    '<td>' + v.cid + '</td>' +
                                    '<td>' + v.fname + ' ' + v.lname + '</td>' +
                                    '<td>' + app.dbpop_to_thai_date(v.birthdate) + '</td>' +
                                    '<td>' + app.count_age_dbpop(v.birthdate) + '</td>' +
                                    '<td>[' + v.subinscl + '] ' + v.maininscl_name + '</td>' +
                                    '<td><a href="#" class="btn" data-name="button_set_data_from_dbopo" ' +
                                    ' data-cid="' + v.cid + '" data-fname="'+ v.fname +'" data-lname="'+ v.lname+'" ' +
                                    ' data-birth="'+ v.birthdate +'" data-maininscl="'+ v.maininscl +'" ' +
                                    ' data-inscl="'+ v.subinscl +'" data-sex="'+ v.sex +'" data-cardid="'+ v.cardid +'"' +
                                    ' data-startdate="'+ v.startdate+'" data-expdate="'+ v.expdate +'"' +
                                    ' data-hmain_code="'+ v.hmain_code +'" data-hmain_name="'+ v.hmain_name +'" ' +
                                    ' data-hsub_code="'+ v.hsub_code +'" data-hsub_name="'+ v.hsub_name +'"><i class="icon-share"></i></a></td>' +
                                    '</tr>'
                            );
                        });
                    }else{
                        $('#table_search_dbpop_result_list tbody').append(
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

            $('#table_search_hospital_result_list tbody').empty();

            person.register.ajax.search_hospital(query, op, function(err, data){
                if(err){
                    $('#table_search_hospital_result_list tbody').append(
                        '<tr>' +
                            '<td colspan="4">' + err + '</td>' +
                            '</tr>'
                    );
                }else{
                    if( _.size(data) ){
                        _.each(data.rows, function(v){
                            $('#table_search_hospital_result_list tbody').append(
                                '<tr>' +
                                    '<td>' + app.clear_null(v.code) + '</td>' +
                                    '<td>' + app.clear_null(v.name) + '</td>' +
                                    '<td>' + app.clear_null(v.province) + '</td>' +
                                    '<td><a href="#" class="btn" data-name="btn_set_hospital" ' +
                                    'data-code="' + v.code + '" data-vname="'+ v.name +'"><i class="icon-share"></i></a></td>' +
                                    '</tr>'
                            );
                        });
                    }else{
                        $('#table_search_hospital_result_list tbody').append(
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
        person.register.modal.show_search_hospital();
    });
    $('#btn_search_hospital_sub').click(function(){
        $('#txt_search_by').val('hsub');
        person.register.modal.show_search_hospital();
    });

    $(document).on('click', 'a[data-name="btn_set_hospital"]', function(){
        var act = $('#txt_search_by').val(),
            hospcode = $(this).attr('data-code'),
            hospname = $(this).attr('data-vname');

        if(act == 'hmain'){
            $('#txt_ins_hospmain_name').val(hospname);
            $('#txt_ins_hospmain_code').val(hospcode);
        }else{
            $('#txt_ins_hospsub_name').val(hospname);
            $('#txt_ins_hospsub_code').val(hospcode);
        }

        $('#modal_search_hospital').modal('hide');

    });
    //get ampur list
    $('#slOutsideProvince').change(function(){
        var chw = $(this).val();

        app.showImageLoading();
        //load ampur list
        person.register.ajax.get_ampur(chw, function(err, data){
            $('#slOutsideAmpur').empty();
            $('#slOutsideTambon').empty();

            $('#slOutsideAmpur').append('<option value="00">--</option>');
            _.each(data.rows, function(v){
                if(!v.name.match(/\*/))
                    $('#slOutsideAmpur').append('<option value="'+ v.code +'">'+ v.name +'</option>');
            });

            app.hideImageLoading();
        });
    });

    $('#slOutsideAmpur').change(function(){
        var chw = $('#slOutsideProvince').val(),
            amp = $(this).val();

        app.showImageLoading();
        //load ampur list
        person.register.ajax.get_tambon(chw, amp, function(err, data){
            $('#slOutsideTambon').empty();
            $('#slOutsideTambon').append('<option value="00">--</option>');
            _.each(data.rows, function(v){
                if(!v.name.match(/\*/))
                    $('#slOutsideTambon').append('<option value="'+ v.code +'">'+ v.name +'</option>');
            });

            app.hideImageLoading();
        });
    });

    //save person
    $('#btn_save_person').click(function(){
        var items = {};

        items.cid               = $('#txt_cid').val();
        //index key
        items.house_code        = $('#house_code').val();
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

        if(!items.cid || items.cid.length != 13){
            app.alert('กรุณาระบุเลขบัตรประชาชน/รูปแบบไม่ถูกต้อง');
        }else if(!items.house_code){
            app.alert('ไม่พบบ้าน หรือ หลังคาเรือนที่ต้องการเพิ่มคน');
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
                    person.register.ajax.save_person(items, function(err){
                        if(err){
                            app.alert(err);
                        }else{
                            if(confirm('บันทึกข้อมูลเสร็จเรียบร้อยแล้วคุณต้องการเพิ่มรายการอีกหรือไม่?')){
                                person.clear_register_form();
                            }else{
                                app.go_to_url('person');
                            }
                        }
                    });
                }
            }else{
                //save without address
                person.register.ajax.save_person(items, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        if(confirm('บันทึกข้อมูลเสร็จเรียบร้อยแล้วคุณต้องการเพิ่มรายการอีกหรือไม่?')){
                            person.clear_register_form();
                        }else{
                            app.go_to_url('person');
                        }
                    }
                });
            }
        }
    });

    //clear register form
    $("#btn_clear_person").click(function(){
        person.clear_register_form();
    });

    $('#btn_dbpop_search_by_cid').click(function(){
        $('#txt_dbpop_search_by').val('cid');
    });

    $('#btn_dbpop_search_by_name').click(function(){
        $('#txt_dbpop_search_by').val('name');
    });
});