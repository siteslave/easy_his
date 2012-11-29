$(function(){
    var person = {};
    person.register = {};

    person.register.modal = {
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

    $('#btn_search_dbpop').click(function(){
        person.register.modal.show_search_dbpop();
    });

    person.register.ajax = {
        save_person: function(data, cb){
            $.ajax({
                url: site_url + '/person/save',
                type: 'POST',
                dataType: 'json',

                data: {
                    csrf_token: csrf_token,
                    data: data
                },

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    cb('เกิดข้อผิดพลาด: [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        },
        get_ampur: function(chw, cb){
            $.ajax({
                url: site_url + '/basic/get_ampur',
                type: 'POST',
                dataType: 'json',

                data: {
                    csrf_token: csrf_token,
                    chw: chw
                },

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    cb('เกิดข้อผิดพลาด: [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        },
        get_tambon: function(chw, amp, cb){
            $.ajax({
                url: site_url + '/basic/get_tambon',
                type: 'POST',
                dataType: 'json',

                data: {
                    csrf_token: csrf_token,
                    chw: chw,
                    amp: amp
                },

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    cb('เกิดข้อผิดพลาด: [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        },
        search_dbpop: function(cid, cb){
            $.ajax({
                url: site_url + '/person/search_dbpop',
                type: 'POST',
                dataType: 'json',

                data: {
                    csrf_token: csrf_token,
                    cid: cid
                },

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    cb('เกิดข้อผิดพลาด: [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        },
        search_hospital: function(query, op, cb){
            $.ajax({
                url: site_url + '/basic/search_hospital',
                type: 'POST',
                dataType: 'json',

                data: {
                    csrf_token: csrf_token,
                    query: query,
                    op: op
                },

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    cb('เกิดข้อผิดพลาด: [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        }
    };

    //search dbpop
    $('#button_do_search_dbpop').click(function(){
        var cid = $('#text_query_search_dbpop').val();
        if(!cid){
            alert('กรุณาระบุเลขบัตรประชาชน');
        }else{
            //do search
            $('#table_search_dbpop_result_list tbody').empty();

            person.register.ajax.search_dbpop(cid, function(err, data){
                if(err){
                    $('#table_search_dbpop_result_list tbody').append(
                        '<tr>' +
                            '<td colspan="6">ไม่พบรายการ</td>' +
                            '</tr>'
                    );
                }else{
                    if( _.size(data) ){
                        _.each(data, function(v){
                            $('#table_search_dbpop_result_list tbody').append(
                                '<tr>' +
                                    '<td>' + v.cid + '</td>' +
                                    '<td>' + v.fname + ' ' + v.lname + '</td>' +
                                    '<td>' + App.convertToThaiDateFormat(v.birthdate) + '</td>' +
                                    '<td>' + App.countAge(v.birthdate) + '</td>' +
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

    $('a[data-name="button_set_data_from_dbopo"]').live('click', function(){
        var cid = $(this).attr('data-cid'),
            fname = $(this).attr('data-fname'),
            lname = $(this).attr('data-lname'),
            birthdate = App.convertDBPOPDateToEngDate($(this).attr('data-birth')),
            inscl = $(this).attr('data-inscl'),
            maininscl = $(this).attr('data-maininscl'),
            cardid = $(this).attr('data-cardid'),
            sex = $(this).attr('data-sex'),
            hmain_code = $(this).attr('data-hmain_code'),
            hmain_name = $(this).attr('data-hmain_name'),
            hsub_code = $(this).attr('data-hsub_code'),
            hsub_name = $(this).attr('data-hsub_name'),
            startdate = App.convertDBPOPDateToEngDate($(this).attr('data-startdate')),
            expdate = App.convertDBPOPDateToEngDate($(this).attr('data-expdate'));

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
            alert('กรุณาระบคำที่ต้องการค้นหา');
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
                        _.each(data, function(v){
                            $('#table_search_hospital_result_list tbody').append(
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

    $('a[data-name="btn_set_hospital"]').live('click', function(){
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

        App.showImageLoading();
        //load ampur list
        person.register.ajax.get_ampur(chw, function(err, data){
            $('#slOutsideAmpur').empty();
            $('#slOutsideTambon').empty();

            $('#slOutsideAmpur').append('<option value="00">--</option>');
            _.each(data, function(v){
                if(!v.name.match(/\*/))
                    $('#slOutsideAmpur').append('<option value="'+ v.code +'">'+ v.name +'</option>');
            });

            App.hideImageLoading();
        });
    });

    $('#slOutsideAmpur').change(function(){
        var chw = $('#slOutsideProvince').val(),
            amp = $(this).val();

        App.showImageLoading();
        //load ampur list
        person.register.ajax.get_tambon(chw, amp, function(err, data){
            $('#slOutsideTambon').empty();
            $('#slOutsideTambon').append('<option value="00">--</option>');
            _.each(data, function(v){
                if(!v.name.match(/\*/))
                    $('#slOutsideTambon').append('<option value="'+ v.code +'">'+ v.name +'</option>');
            });

            App.hideImageLoading();
        });
    });

    //save person
    $('#btn_save_person').click(function(){
        var items = {};

        items.cid = $('#txt_cid').val();
        //index key
        items.house_code = $('#house_code').val();
        items.title = $('#slTitle').val();
        items.first_name = $('#txt_first_name').val();
        items.last_name = $('#txt_last_name').val();
        items.sex = $('#sl_sex').val();
        items.birthdate = $('#txt_birth_date').val();
        items.mstatus = $('#slMStatus').val();
        items.occupation = $('#slOccupation').val();
        items.race = $('#slRace').val();
        items.nation = $('#slNation').val();
        items.religion = $('#slReligion').val();
        items.education = $('#slEducation').val();
        items.fstatus = $('#slFstatus').val();
        items.vstatus = $('#slVstatus').val();
        items.father_cid = $('#txtFatherCid').val();
        items.mother_cid = $('#txtMotherCid').val();
        items.couple_cid = $('#txtCoupleCid').val();
        items.movein_date = $('#txtMoveInDate').val();
        items.discharge_date = $('#txtDischargeDate').val();
        items.discharge_status = $('#slDischarge').val();
        items.abogroup = $('#slABOGroup').val();
        items.rhgroup = $('#slRHGroup').val();
        items.labor_type = $('#slLabor').val();
        items.typearea = $('#slTypeArea').val();
        items.passport = $('#txt_passport').val();

        //address
        items.address = {};
        items.address.address_type = $('#slOutsiedAddressType').val();
        items.address.house_id = $('#txtOutsideHouseId').val();
        items.address.house_type = $('#slOutsiedHouseType').val();
        items.address.room_no = $('#txtOutsideRoomNumber').val();
        items.address.condo = $('#txtOutsideCondo').val();
        items.address.houseno = $('#txtOutsideAddressNumber').val();
        items.address.soi_sub = $('#txtOutsideSoiSub').val();
        items.address.soi_main = $('#txtOutsideSoiMain').val();
        items.address.road = $('#txtOutsideRoad').val();
        items.address.village_name = $('#txtOutsideVillageName').val();
        items.address.village = $('#slOutsideVillage').val();
        items.address.tambon = $('#slOutsideTambon').val();
        items.address.ampur = $('#slOutsideAmpur').val();
        items.address.changwat = $('#slOutsideProvince').val();
        items.address.postcode = $('#txtOutsidePostcode').val();
        items.address.telephone = $('#txtOutsideTelephone').val();
        items.address.mobile = $('#txtOutsideMobile').val();

        if(!items.cid || items.cid.length != 13){
            alert('กรุณาระบุเลขบัตรประชาชน/รูปแบบไม่ถูกต้อง');
        }else if(!items.house_code){
            alert('ไม่พบบ้าน หรือ หลังคาเรือนที่ต้องการเพิ่มคน');
        }else if(!items.title){
            alert('กรุณาเลือกคำนำหน้าชื่อ');
        }else if(!items.first_name){
            alert('กรุณาระบุชื่อ');
        }else if(!items.last_name){
            alert('กรุณาระบุสกุล');
        }else if(!items.sex){
            alert('กรุณาเลือกเพศ');
        }else if(!items.birthdate){
            alert('กรุณาระบุวันเดือนปี เกิด');
        }else if(!items.mstatus){
            alert('กรุณาระบุสถานะการสมรส');
        }else if(!items.occupation){
            alert('กรุณาระบุอาชีพ');
        }else if(!items.race){
            alert('กรุณาระบุเชื้อชาติ');
        }else if(!items.nation){
            alert('กรุณาระบุสัญชาติ');
        }else if(!items.religion){
            alert('กรุณาระบุศาสนา');
        }else if(!items.education){
            alert('กรุณาระบุการศึกษา')
        }else if(!items.fstatus){
            alert('กรุณาระบุสถานะในครอบครัว');
        }else if(!items.vstatus){
            alert('กรุณาระบุสถานะในชุมชน');
        }else if(!items.labor_type){
            alert('กรุณาระบุความเป็นต่างด้าว');
        }else if(!items.typearea){
            alert('กรุณาระบุประเภทบุคคล');
        }else{
            if(items.typearea == '3' || items.typearea == '4' || items.typearea == '0'){
                //check address
                if(!items.address.changwat){
                    alert('กรุณาระบุจังหวัด นอกเขต');
                }else if(!items.address.ampur){
                    alert('กรุณาระบุอำเภอ นอกเขต');
                }else if(!items.address.tambon){
                    alert('กรุณาระบุตำบล นอกเขต');
                }else{
                    //save with address
                    person.register.ajax.save_person(items, function(err){
                        if(err){
                            alert(err);
                        }else{
                            alert('Save successfull');
                        }
                    });
                }
            }else{
                //save without address
                person.register.ajax.save_person(items, function(err){
                    if(err){
                        alert(err);
                    }else{
                        alert('Save successfull');
                    }
                });
            }
        }
    });
});