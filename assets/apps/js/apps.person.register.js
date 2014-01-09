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

    //get ampur list
    $('#slOutsideProvince').change(function(){
        var chw = $(this).val();

        //load ampur list
        person.register.ajax.get_ampur(chw, function(err, data){
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
        person.register.ajax.get_tambon(chw, amp, function(err, data){
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

        items.cid               = $('#txt_cid').val();
        //index key
        items.house_code        = $('#house_code').val();
        items.title             = $('#slTitle').select2('val');
        items.first_name        = $('#txt_first_name').val();
        items.last_name         = $('#txt_last_name').val();
        items.sex               = $('#sl_sex').select2('val');
        items.birthdate         = $('#txt_birth_date').val();
        items.mstatus           = $('#slMStatus').select2('val');
        items.occupation        = $('#slOccupation').val();
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
            if(_.contains(['3', '4', '0'], items.typearea)){
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
                            app.go_to_url('person');
                        }
                    });
                }
            }else{
                //save without address
                person.register.ajax.save_person(items, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.go_to_url('person');
                    }
                });
            }
        }
    });

//    //clear register form
//    $("#btn_clear_person").click(function(){
//        person.clear_register_form();
//    });

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

});