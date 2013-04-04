/**
 * NCD scripts
 *
 * @author      Mr.Satit Riapit <mr.satit@outlook.com>
 * @copyright   Copyright 2013, Mr.Satit Rianpit
 * @since       Version 1.0
 */
head.ready(function(){
    // NCD name space with object.
    var ncd = {};
    ncd.update = {};

    //------------------------------------------------------------------------------------------------------------------
    //ajax object
    ncd.ajax = {
        /**
         * Get person list
         *
         * @param   start
         * @param   stop
         * @param   cb
         */
        get_list: function(start, stop, cb){
            var url = 'ncd/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'ncd/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        get_house_list: function(village_id, cb){
            var url = 'person/get_houses_list',
                params = {
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        get_list_by_house: function(house_id, cb){
                var url = 'ncd/get_list_by_house',
                    params = {
                        house_id: house_id
                    };

                app.ajax(url, params, function(err, data){
                    err ? cb(err) : cb(null, data);
                });
        },

        search_person: function(query, filter, cb){
            var url = 'ncd/search_person',
                params = {
                    query: query,
                    filter: filter
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        do_register: function(hn, cb){
            var url = 'ncd/do_register',
                params = {
                    hn: hn
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        check_registration: function(hn, cb){
            var url = 'ncd/check_registration',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };
    
    ncd.update.ajax = {
        remove_ncd_register: function(person_id, cb) {
            var url = 'ncd/remove_ncd_register',
                params = {
                    person_id: person_id
                };
            
            app.ajax(url, params, function(err, data) {
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    ncd.modal = {
        show_register: function()
        {
            $('#mdl_register').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_register: function()
        {
            $('#mdl_register').modal('hide');
        }
    };
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Set person list
     *
     * @param data
     */

    ncd.set_list = function(data){
        if(_.size(data.rows) > 0){
            _.each(data.rows, function(v){
                $('#tbl_ncd_list > tbody').append(
                    '<tr>' +
                        '<td>' + v.hn + '</td>' +
                        '<td>' + app.clear_null(v.cid) + '</td>' +
                        '<td>' + v.first_name +' '+ v.last_name + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.birthdate) + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>' + v.sex + '</td>' +
                        '<td>' + v.screen + '</td>' +
                        '<td>' +
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0);" class="btn" data-name="btnFilter" data-id="' + v.id + '"><i class="icon-filter"></i></a>' +
                        '</div>' +
                        '</td>' +
                        '</tr>'
                );
            });
        }else{
            $('#tbl_ncd_list > tbody').append(
                '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
            );
        }
    };
    ncd.get_list = function(){
        $('#main_paging').fadeIn('slow');
        ncd.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        ncd.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_ncd_list > tbody').empty();
                            if(err){
                                app.alert(err);
                            }else{
                                ncd.set_list(data);
                            }

                        });

                    },
                    onFormat: function(type){
                        switch (type) {

                            case 'block':

                                if (!this.active)
                                    return '<li class="disabled"><a href="">' + this.value + '</a></li>';
                                else if (this.value != this.page)
                                    return '<li><a href="#' + this.value + '">' + this.value + '</a></li>';
                                return '<li class="active"><a href="#">' + this.value + '</a></li>';

                            case 'right':
                            case 'left':

                                if (!this.active) {
                                    return "";
                                }
                                return '<li><a href="#' + this.value + '">' + this.value + '</a></li>';

                            case 'next':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&raquo;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&raquo;</a></li>';

                            case 'prev':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&laquo;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&laquo;</a></li>';

                            case 'first':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&lt;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&lt;</a></li>';

                            case 'last':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&gt;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&gt;</a></li>';

                            case 'fill':
                                if (this.active) {
                                    return '<li class="disabled"><a href="#">...</a></li>';
                                }
                        }
                        return ""; // return nothing for missing branches
                    }
                });
            }
        });
    };

    $('#btn_register').click(function(){
        ncd.modal.show_register();
    });

    ncd.clear_form = function() {
        var d = new Date();
        // Header
        $('#dtpHeadDate').val(app.get_current_date());
        $('#dtpHeadTime').val(app.get_current_time());
        $('#tboHeadWeight').val('');
        $('#tboHeadHeight').val('');
        $('#tboHeadWaistline').val('');
        $('#tboHeadBMI').val('');
        $('#chkHeadServiceLocal').prop('checked', true);
        app.set_first_selected($('#cboDoctor'));
        $('#tboPcuCode').val('');
        $('#tboPcuName').val('');

        // Tab 1
        $('#chkTab11DM').prop('checked', false);
        $('#chkTab11HT').prop('checked', false);
        $('#chkTab11Gout').prop('checked', false);
        $('#chkTab11CRF').prop('checked', false);
        $('#chkTab11MI').prop('checked', false);
        $('#chkTab11Stroke').prop('checked', false);
        $('#chkTab11Copd').prop('checked', false);
        $('#chkTab11Unknown').prop('checked', false);

        $('#chkTab12DM').prop('checked', false);
        $('#chkTab12HT').prop('checked', false);
        $('#chkTab12Gout').prop('checked', false);
        $('#chkTab12CRF').prop('checked', false);
        $('#chkTab12MI').prop('checked', false);
        $('#chkTab12Stroke').prop('checked', false);
        $('#chkTab12Copd').prop('checked', false);
        $('#chkTab12Unknown').prop('checked', false);

        app.set_first_selected($('#cboTab21DM'));
        app.set_first_selected($('#cboTab21HT'));
        app.set_first_selected($('#cboTab21Liver'));
        app.set_first_selected($('#cboTab21Paralysis'));
        app.set_first_selected($('#cboTab21Heart'));
        app.set_first_selected($('#cboTab21Lipid'));
        app.set_first_selected($('#cboTab21FootUlcers'));
        app.set_first_selected($('#cboTab21Confined'));
        app.set_first_selected($('#cboTab21DrinkWaterFrequently'));
        app.set_first_selected($('#cboTab21NightUrination'));
        app.set_first_selected($('#cboTab21Batten'));
        app.set_first_selected($('#cboTab21WeightDown'));
        app.set_first_selected($('#cboTab21UlceratedLips'));
        app.set_first_selected($('#cboTab21ItchySkin'));
        app.set_first_selected($('#cboTab21BlearyEyed'));
        app.set_first_selected($('#cboTab21TeaByHand'));
        app.set_first_selected($('#cboTab21HowToBehave'));
        app.set_first_selected($('#cboTab21CreasedNeck'));
        app.set_first_selected($('#cboTab21HistoryFPG'));

        $('#rdoNoSmoke').prop('checked', true);
        $('#tboOfSmoked').val('');
        $('#tboTimeSmoke').val('');
        $('#tboSmokingNumberPerDay').val('');
        $('#tboSmokingNumberPerYear').val('');
        $('#tboOfSmoking').val('');
        $('#tboSmokingYear').val('');
        $('#rdoNoAlcohol').prop('checked', true);
        $('#tboAlcoholPerWeek').val('');
        $('#rdoExercise1').prop('checked', true);
        $('#rdoNoFood').prop('checked', true);

        //Tab 2
        $('#dtpFcgDate').val(app.get_current_date());
        $('#dtpFcgTime').val(app.get_current_time());
        $('#tboFcgResult').val('');
        $('#chkFcg').prop('checked', false);

        $('#dtpFpgDate').val(app.get_current_date());
        $('#dtpFpgTime').val(app.get_current_time());
        $('#tboFpgResult').val('');

        $('#tboPPG1').val('');
        $('#tboPPG2').val('');

        //Tab 3
        $('#tboHtResult1').val('');
        $('#tboHtResult2').val('');

        $('#tboScreen').val('');

        //Hiden field
        //$('#hideScreenId').val('');
        $('#hideFcg').val('');
        $('#hideFpg').val('');
        $('#hideHt').val('');
    }

    //search person
    $('#btn_do_search_person').click(function(){
        var query = $('#txt_query_person').val(),
            filter = $('input[data-name="txt_search_person_filter"]').val();

        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา โดยระบุชื่อ-สกุล หรือ HN หรือ เลขบัตรประชาชน');
        }
        else
        {
            //do search
            $('#tbl_search_person_result > tbody').empty();

            ncd.ajax.search_person(query, filter, function(err, data){

                if(err)
                {
                    app.alert(err);
                }
                else if(!data)
                {
                    app.alert('ไม่พบรายการ');
                }
                else
                {
                   ncd.set_search_person_result(data);
                }
            });
        }
    });

    //set filter
    $('a[data-name="btn_set_search_person_filter"]').click(function(){
        var filter = $(this).attr('data-value');

        $('input[data-name="txt_search_person_filter"]').val(filter);
    });

    $('#sl_village').on('change', function(){
        var village_id = $(this).val();

        ncd.ajax.get_house_list(village_id, function(err, data){
            if(err)
            {
                app.alert(err);
            }
            else
            {
                if(data)
                {
                    $('#sl_house').empty();
                   // $('#sl_house').append('<option value="00000000">ทั้งหมด</option>');

                    _.each(data.rows, function(v){
                        $('#sl_house').append('<option value="'+ v.id +'">' + v.house + '</option>');
                    });

                }
            }
        });
    });

    $('#btn_do_get_list').click(function(){
        var house_id = $('#sl_house').val();

        if(house_id != null) {
            ncd.ajax.get_list_by_house(house_id, function(err, data){

                $('#tbl_ncd_list > tbody').empty();

                if(err)
                {
                    app.alert(err);
                    $('#tbl_ncd_list > tbody').append(
                        '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
                    );
                }
                else
                {
                    if(data)
                    {
                        $('#main_paging').fadeOut('slow');
                        ncd.set_list(data);
                    }
                    else
                    {
                        $('#tbl_ncd_list > tbody').append(
                            '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
                        );
                    }
                }
            });
        } else {
            ncd.get_list();
        }

    });

    $(document).on('click', 'a[data-name="btnFilter"]', function() {
        var person_id = $(this).attr('data-id');
        $('#tboPersonId').val(person_id);
        $('#hideScreenId').val('');

        $('#mdlViewScreen').modal('show').css({
            width: 800,
            'margin-left': function () {
                return -($(this).width() / 2);
            }
        });

        ncd.get_standard_detail();
        ncd.get_ncd_list();
    });

    ncd.get_standard_detail = function() {
        var url = 'ncd/get_standard_detail',
            params = { person_id: $('#tboPersonId').val() };

        app.ajax(url, params, function(err, data) {
            if(data != null && _.size(data.rows) > 0) {
                _.each(data.rows, function(v) {
                    $('#tboFname').val(v.first_name);
                    $('#tboLname').val(v.last_name);
                    $('#tboSex').val(v.sex=="1"?"ชาย":"หญิง");
                    $('#tboAge').val(app.count_age_mongo(v.birthdate));
                });
            }
        });
    }

    ncd.get_ncd_list = function() {
        var url = 'ncd/get_ncd_list',
            params = { person_id: $('#tboPersonId').val() };

        $('#tblScreen > tbody').empty();
        app.ajax(url, params, function(err, data) {
            if(data != null && _.size(data.rows) > 0) {
                _.each(data.rows, function(v) {
                    $('#tblScreen > tbody').append(
                        '<tr>' +
                            '<td>'+ app.to_thai_date(v.date) +'</td>' +
                            '<td>'+ v.time +'</td>' +
                            '<td>'+ v.weight +'</td>' +
                            '<td>'+ v.height +'</td>' +
                            '<td>'+ v.waist_line +'</td>' +
                            '<td>'+ v.bmi +'</td>' +
                            '<td><div class="input-append">'+
                                '<a class="btn" data-name="btnEditNcd" data-id="'+ v.id +'" title="แก้ไขข้อมูล"><i class="icon-edit"></i></a>'+
                                '<a class="btn btn-danger" data-name="btnRemoveNcdList" data-id="'+ v.id +'" title="ลบข้อมูล"><i class="icon-trash"></i></a>'+
                            '</div></td>' +
                        '</tr>'
                    );
                });
            }
        });
    }

    ncd.show_modal_viewscreen = function() {
        $('#mdlViewScreen').modal('hide');
        $('#mdlScreen').modal('show').css({
            width: 800,
            'margin-left': function () {
                return -($(this).width() / 2);
            }
        });
    }

    $(document).on('click', 'a[data-name="btnShowScreenDialog"]', function() {
        $('#mdlViewScreen').modal('hide');

        ncd.clear_form();
        $('#tblFcg > tbody').empty();
        $('#tblFpg > tbody').empty();
        $('#tblHt > tbody').empty();
        $('#hideScreenId').val('');
        $('#mdlScreen').modal('show').css({
            width: 800,
            'margin-left': function () {
                return -($(this).width() / 2);
            }
        });
    });

    $('#btnCancelSaveScreen').click(function(e) {
        e.preventDefault();
        $('#mdlScreen').modal('hide');
        $('#mdlViewScreen').modal('show').css({
            width: 850,
            'margin-left': function () {
                return -($(this).width() / 2);
            }
        });
    });

    $('#btnSaveScreen').click(function(e) {
        e.preventDefault();
        if($('#tboHeadWeight').val() == '' ||
        $('#tboHeadHeight').val() == '' ||
        $('#tboHeadWaistline').val() == '' ||
        $('#cboDoctor').val() == '' ||
        $('#tboPcuName').val() == '') {
            app.alert('กรุณาระบุ ( น้ำหนัก - ส่วนสูง - เส้นรอบเอว - ผู้คัดกรอง - สถานที่คัดกรอง ) ให้ชัดเจนด้วย');
        } else if((!$('#chkTab11DM').is(':checked') &&
        !$('#chkTab11HT').is(':checked') &&
        !$('#chkTab11Gout').is(':checked') &&
        !$('#chkTab11CRF').is(':checked') &&
        !$('#chkTab11MI').is(':checked') &&
        !$('#chkTab11Stroke').is(':checked') &&
        !$('#chkTab11Copd').is(':checked') &&
        !$('#chkTab11Unknown').is(':checked')) ||
        (!$('#chkTab12DM').is(':checked') &&
        !$('#chkTab12HT').is(':checked') &&
        !$('#chkTab12Gout').is(':checked') &&
        !$('#chkTab12CRF').is(':checked') &&
        !$('#chkTab12MI').is(':checked') &&
        !$('#chkTab12Stroke').is(':checked') &&
        !$('#chkTab12Copd').is(':checked') &&
        !$('#chkTab12Unknown').is(':checked'))) {
            app.alert('กรุณาระบุข้อมูลครอบครัวด้วย');
        } else {
            var _smoking = ($('#rdoEverSmoked').is(':checked')?'เคยสูบแต่เลิกแล้ว':($('#rdoSmoking').is(':checked')?'สูบ':'ไม่สูบ'));
            var _alcohol = ($('#rdoBeenDrinkingAlcohol').is(':checked')?'เคยดื่มแต่เลิกแล้ว':($('#rdoAlcohol').is(':checked')?'ดื่ม':'ไม่ดื่ม'));
            var _exercise = ($('#rdoExercise1').is(':checked')?'ออกกำลังกายทุกวัน ครั้งละ 30 นาที':($('#rdoExercise2').is(':checked')?'ออกกำลังกายสัปดาห์ละมากกว่า 3 ครั้ง ครั้งละ 30 นาทีสม่ำเสมอ':($('#rdoExercise3').is(':checked')?'ออกกำลังกายสัปดาห์ละ 3 ครั้ง ครั้งละ 30 นาทีสม่ำเสมอ':($('#rdoExercise4').is(':checked')?'ออกกำลังกายน้อยกว่าสัปดาห์ละ 3 ครั้ง':'ไม่ออกกำลังกายเลย'))));
            var _food = ($('#rdoFoodSweet').is(':checked')?'หวาน':($('#rdoFoodSalt').is(':checked')?'เค็ม':($('#rdoFoodIt').is(':checked')?'มัน':'ไม่ชอบทุกข้อ')));

            var url = 'ncd/do_register',
                params = {
                    id: $('#hideScreenId').val(),
                    personId: $('#tboPersonId').val(),
                    date: $('#dtpHeadDate').val(),
                    time: $('#dtpHeadTime').val(),
                    weight: $('#tboHeadWeight').val(),
                    height: $('#tboHeadHeight').val(),
                    waistLine: $('#tboHeadWaistline').val(),
                    bmi: $('#tboHeadBMI').val(),
                    serviceLocal: $('#chkHeadServiceLocal').is(':checked'),
                    doctor: $('#cboDoctor').val(),
                    pcu: $('#tboPcuCode').val(),

                    historyDm: $('#chkTab11DM').is(':checked'),
                    historyHt: $('#chkTab11HT').is(':checked'),
                    historyGout: $('#chkTab11Gout').is(':checked'),
                    historyCrf: $('#chkTab11CRF').is(':checked'),
                    historyMi: $('#chkTab11MI').is(':checked'),
                    historyStroke: $('#chkTab11Stroke').is(':checked'),
                    historyCopd: $('#chkTab11Copd').is(':checked'),
                    historyUnknown: $('#chkTab11Unknown').is(':checked'),

                    historyDm2: $('#chkTab12DM').is(':checked'),
                    historyHt2: $('#chkTab12HT').is(':checked'),
                    historyGout2: $('#chkTab12Gout').is(':checked'),
                    historyCrf2: $('#chkTab12CRF').is(':checked'),
                    historyMi2: $('#chkTab12MI').is(':checked'),
                    historyStroke2: $('#chkTab12Stroke').is(':checked'),
                    historyCopd2: $('#chkTab12Copd').is(':checked'),
                    historyUnknown2: $('#chkTab12Unknown').is(':checked'),

                    historyIllnessDm: $('#cboTab21DM').val(),
                    historyIllnessHt: $('#cboTab21HT').val(),
                    historyIllnessLiver: $('#cboTab21Liver').val(),
                    historyIllnessParalysis: $('#cboTab21Paralysis').val(),
                    historyIllnessHeart: $('#cboTab21Heart').val(),
                    historyIllnessLipid: $('#cboTab21Lipid').val(),
                    historyIllnessFootUlcers: $('#cboTab21FootUlcers').val(),
                    historyIllnessConfined: $('#cboTab21Confined').val(),
                    historyIllnessDrinkWaterFrequently: $('#cboTab21DrinkWaterFrequently').val(),
                    historyIllnessNightUrination: $('#cboTab21NightUrination').val(),
                    historyIllnessBatten: $('#cboTab21Batten').val(),
                    historyIllnessWeightDown: $('#cboTab21WeightDown').val(),
                    historyIllnessUlceratedLips: $('#cboTab21UlceratedLips').val(),
                    historyIllnessItchySkin: $('#cboTab21ItchySkin').val(),
                    historyIllnessBlearyEyed: $('#cboTab21BlearyEyed').val(),
                    historyIllnessTeaByHand: $('#cboTab21TeaByHand').val(),
                    historyIllnessHowToBehave: $('#cboTab21HowToBehave').val(),
                    historyIllnessCreasedNeck: $('#cboTab21CreasedNeck').val(),
                    historyIllnessHistoryFPG: $('#cboTab21HistoryFPG').val(),

                    smoking: _smoking,
                    ofSmoked: $('#tboOfSmoked').val(),
                    timeSmoke: $('#tboTimeSmoke').val(),
                    smokingNumberPerDay: $('#tboSmokingNumberPerDay').val(),
                    smokingNumberPerYear: $('#tboSmokingNumberPerYear').val(),
                    ofSmoking: $('#tboOfSmoking').val(),
                    smokingYear: $('#tboSmokingYear').val(),

                    alcohol: _alcohol,
                    alcoholPerWeek:$('#tboAlcoholPerWeek').val(),

                    exercise: _exercise,
                    food: _food,

                    //TAB 2
                    fcg: $('#hideFcg').val(),
                    fpg: $('#hideFpg').val(),
                    ppg: $('#tboPPG1').val(),
                    ppgHours: $('#tboPPG2').val(),

                    //TAB 3
                    ht: $('#hideHt').val(),
                    bodyScreen: $('#tboScreen').val()
                };

            if($('#hideScreenId').val() == '') {
                app.ajax(url, { data:params }, function(err, data) {
                    if(err) {
                        app.alert(err);
                    } else {
                        ncd.get_ncd_list();
                        app.alert('บันทึกข้อมูลการคัดกรองแล้ว.');
                    }
                });
            } else {
                app.ajax('ncd/update_ncd_detail', { data:params }, function(err, data) {
                    if(err) {
                        app.alert(err);
                    } else {
                        ncd.get_ncd_list();
                        app.alert('แก้ไขข้อมูลการคัดกรองแล้ว.');
                    }
                });
            }
        }

        $('#mdlScreen').modal('hide');
        $('#mdlViewScreen').modal('show').css({
            width: 800,
            'margin-left': function () {
                return -($(this).width() / 2);
            }
        });

    });

    $(document).on('click', 'a[data-name="btnEditNcd"]', function() {
        //แก้ไขรายละเอียดการคัดกรอง
        var url = 'ncd/get_ncd_detail',
            params = { id: $(this).attr('data-id') };
        $('#hideScreenId').val($(this).attr('data-id'));
        app.ajax(url, params, function(err, data) {
            if(_.size(data.rows) > 0) {
                var v = data.rows[0];
                $('#dtpHeadDate').val(v.date);
                $('#dtpHeadTime').val(v.time);
                $('#tboHeadWeight').val(v.weight);
                $('#tboHeadHeight').val(v.height);
                $('#tboHeadWaistline').val(v.waist_line);
                $('#tboHeadBMI').val(v.bmi);
                $('#chkHeadServiceLocal').prop('checked', v.service_local=='true'?true:false);
                $('#cboDoctor').val(v.doctor);
                $('#tboPcuCode').val(v.service_place);
                $('#tboPcuName').val(v.pcu_name);

                $('#chkTab11DM').prop('checked', v.parental_illness_history_dm=='true'?true:false);
                $('#chkTab11HT').prop('checked', v.parental_illness_history_ht=='true'?true:false);
                $('#chkTab11Gout').prop('checked', v.parental_illness_history_gout=='true'?true:false);
                $('#chkTab11CRF').prop('checked', v.parental_illness_history_crf=='true'?true:false);
                $('#chkTab11MI').prop('checked', v.parental_illness_history_mi=='true'?true:false);
                $('#chkTab11Stroke').prop('checked', v.parental_illness_history_stroke=='true'?true:false);
                $('#chkTab11Copd').prop('checked', v.parental_illness_history_copd=='true'?true:false);
                $('#chkTab11Unknown').prop('checked', v.parental_illness_history_unknown=='true'?true:false);
                $('#chkTab12DM').prop('checked', v.sibling_illness_history_dm=='true'?true:false);
                $('#chkTab12HT').prop('checked', v.sibling_illness_history_ht=='true'?true:false);
                $('#chkTab12Gout').prop('checked', v.sibling_illness_history_gout=='true'?true:false);
                $('#chkTab12CRF').prop('checked', v.sibling_illness_history_crf=='true'?true:false);
                $('#chkTab12MI').prop('checked', v.sibling_illness_history_mi=='true'?true:false);
                $('#chkTab12Stroke').prop('checked', v.sibling_illness_history_stroke=='true'?true:false);
                $('#chkTab12Copd').prop('checked', v.sibling_illness_history_copd=='true'?true:false);
                $('#chkTab12Unknown').prop('checked', v.sibling_illness_history_unknown=='true'?true:false);

                $('#cboTab21DM').val(v.history_illness_dm);
                $('#cboTab21HT').val(v.history_illness_ht);
                $('#cboTab21Liver').val(v.history_illness_liver);
                $('#cboTab21Paralysis').val(v.history_illness_paralysis);
                $('#cboTab21Heart').val(v.history_illness_heart);
                $('#cboTab21Lipid').val(v.history_illness_lipid);
                $('#cboTab21FootUlcers').val(v.history_illness_footUlcers);
                $('#cboTab21Confined').val(v.history_illness_confined);
                $('#cboTab21DrinkWaterFrequently').val(v.history_illness_drink_water_frequently);
                $('#cboTab21NightUrination').val(v.history_illness_night_urination);
                $('#cboTab21Batten').val(v.history_illness_batten);
                $('#cboTab21WeightDown').val(v.history_illness_weight_down);
                $('#cboTab21UlceratedLips').val(v.history_illness_ulcerated_lips);
                $('#cboTab21ItchySkin').val(v.history_illness_itchy_skin);
                $('#cboTab21BlearyEyed').val(v.history_illness_bleary_eyed);
                $('#cboTab21TeaByHand').val(v.history_illness_tea_by_hand);
                $('#cboTab21HowToBehave').val(v.history_illness_how_to_behave);
                $('#cboTab21CreasedNeck').val(v.history_illness_creased_neck);
                $('#cboTab21HistoryFPG').val(v.history_illness_history_fpg);

                if(v.smoking == 'เคยสูบแต่เลิกแล้ว') {
                    $('#rdoEverSmoked').prop('checked', true);
                } else if(v.smoking == 'สูบ') {
                    $('#rdoSmoking').prop('checked', true);
                } else {
                    $('#rdoNoSmoke').prop('checked', true);
                }
                $('#tboOfSmoked').val(v.of_smoked);
                $('#tboTimeSmoke').val(v.time_smoke);
                $('#tboSmokingNumberPerDay').val(v.smoking_number_per_day);
                $('#tboSmokingNumberPerYear').val(v.smoking_number_per_year);
                $('#tboOfSmoking').val(v.of_smoking);
                $('#tboSmokingYear').val(v.time_smoke);

                if(v.alcohol == 'เคยดื่มแต่เลิกแล้ว') {
                    $('#rdoBeenDrinkingAlcohol').prop('checked', true);
                } else if(v.alcohol == 'ดื่ม') {
                    $('#rdoAlcohol').prop('checked', true);
                } else {
                    $('#rdoNoAlcohol').prop('checked', true);
                }
                $('#tboAlcoholPerWeek').val(v.alcohol_per_week);

                if(v.exercise =='ออกกำลังกายทุกวัน ครั้งละ 30 นาที') {
                    $('#rdoExercise1').prop('checked', true);
                } else if(v.exercise == 'ออกกำลังกายสัปดาห์ละมากกว่า 3 ครั้ง ครั้งละ 30 นาทีสม่ำเสมอ') {
                    $('#rdoExercise2').prop('checked', true);
                } else if(v.exercise == 'ออกกำลังกายสัปดาห์ละ 3 ครั้ง ครั้งละ 30 นาทีสม่ำเสมอ') {
                    $('#rdoExercise3').prop('checked', true);
                } else if(v.exercise == 'ออกกำลังกายน้อยกว่าสัปดาห์ละ 3 ครั้ง') {
                    $('#rdoExercise4').prop('checked', true);
                } else {
                    $('#rdoNoExercise').prop('checked', true);
                }

                if(v.food == 'หวาน') {
                    $('#rdoFoodSweet').prop('checked', true);
                } else if(v.food == 'เค็ม') {
                    $('#rdoFoodSalt').prop('checked', true);
                } else if(v.food == 'มัน') {
                    $('#rdoFoodIt').prop('checked', true);
                } else {
                    $('#rdoNoFood').prop('checked', true);
                }

                $('#hideFcg').val(v.fcg);
                $('#hideFpg').val(v.fpg);
                $('#tboPPG1').val(v.ppg);
                $('#tboPPG2').val(v.ppg_hours);

                $('#hideHt').val(v.pressure_measurements);
                $('#tboHtResult2').val(v.body_screen);

                ncd.load_fcg();
                ncd.load_fpg();
                ncd.load_ht();

                ncd.show_modal_viewscreen();
            }
        });
    });

    $(document).on('click', 'a[data-name="btnRemoveNcdList"]', function() {
        //ลบข้อมูลการคัดกรอง
        var id = $(this).attr('data-id');
        if(confirm('ยืนยันการลบข้อมูล')) {
            app.ajax('ncd/remove_ncd', { id: id }, function(err, data) {
                if(data.success) {
                    app.alert('ลบรายการแล้ว');
                } else {
                    app.alert('ไม่สามารถลบรายการได้');
                }
                ncd.get_ncd_list();
            });
        }
    });

    /* BEGIN "Fasting Capillary Blood Glucose (FCG)" */
    $(document).on('click', '#btnShowAddFcg', function() {
        $('#popFcg').show();
        $('#btnShowAddFcg').hide();
    });

    $(document).on('click', '#btnCancelFcg', function() {
        $('#popFcg').hide();
        $('#btnShowAddFcg').show();

        $('#dtpFcgDate').val(app.get_current_date());
        $('#dtpFcgTime').val(app.get_current_time());
        $('#tboFcgResult').val('');
        $('#chkFcg').prop('checked', false);
    });

    $(document).on('click', '#btnAddFcg', function() {
        if($('#tboFcgResult').val() == '') {
            app.alert('กรุณากรอกผลด้วย');
        } else {
            var chkFcg = false;
            if($('#chkFcg').is(':checked')) chkFcg = true;
            if($('#hideFcg').val() == '') {
                $('#hideFcg').val('{ "date":"'+$('#dtpFcgDate').val()+'", "time":"'+$('#dtpFcgTime').val()+'","result":"'+$('#tboFcgResult').val()+'","fast":"'+ chkFcg +'" }');
            } else {
                $('#hideFcg').val($('#hideFcg').val()+',{ "date":"'+$('#dtpFcgDate').val()+'", "time":"'+$('#dtpFcgTime').val()+'","result":"'+$('#tboFcgResult').val()+'","fast":"'+ chkFcg +'" }');
            }
            ncd.load_fcg();

            $('#popFcg').hide();
            $('#btnShowAddFcg').show();
        }
    });
    ncd.load_fcg = function() {
        var json = $.parseJSON("["+ $('#hideFcg').val() +"]");
        var j = '';
        $.each(json, function(index, value) {
            j += '<tr>'+
                    '<td>'+ (index+1) +'</td>'+
                    '<td>'+ value.date +'</td>'+
                    '<td>'+ value.time +'</td>'+
                    '<td>'+ value.result +'</td>'+
                    '<td><input type="checkbox" '+((value.fast=="true")?'checked':'')+' disabled></td>'+
                    '<td><a id="btnRemoveFcg" data-id="'+ index +'" class="btn btn-danger"><i class="icon-trash"></i></td>'+
                '</tr>';
        });
        $('#tblFcg > tbody').empty();
        $('#tblFcg > tbody').append(j);

        $('#dtpFcgDate').val(app.get_current_date());
        $('#dtpFcgTime').val(app.get_current_time());
        $('#tboFcgResult').val('');
        $('#chkFcg').prop('checked', false);
    }
    $(document).on('click', '#btnRemoveFcg', function() {
        if(confirm('ยืนยันการลบข้อมูล')) {
            var id = $(this).attr('data-id');
            ncd.remove_fcg(id);
            ncd.load_fcg();
        }
    });
    ncd.remove_fcg = function(id) {
        var json = $.parseJSON("["+ $('#hideFcg').val() +"]");
        var j = '';
        $.each(json, function(index, value) {
            if(index != id) {
                if(j == '') {
                    j = '{ "date":"'+ value.date +'", "time":"'+value.time+'", "result":"'+value.result+'", "fast":"'+value.fast+'" }';
                } else {
                    j += ',{ "date":"'+ value.date +'", "time":"'+value.time+'", "result":"'+value.result+'", "fast":"'+value.fast+'" }';
                }
            }
        });
        $('#hideFcg').val(j);
    }
    /* END "Fasting Capillary Blood Glucose (FCG)" */

    /* BEGIN "Fasting Plasma Glucose (FPG)" */
    $(document).on('click', '#btnShowAddFpg', function() {
        $('#popFpg').show();
        $('#btnShowAddFpg').hide();
    });

    $(document).on('click', '#btnCancelFpg', function() {
        $('#popFpg').hide();
        $('#btnShowAddFpg').show();

        $('#dtpFpgDate').val(app.get_current_date());
        $('#dtpFpgTime').val(app.get_current_time());
        $('#tboFpgResult').val('');
    });

    $(document).on('click', '#btnAddFpg', function() {
        if($('#tboFpgResult').val() == '') {
            app.alert('กรุณาลงผลด้วย');
        } else {
            if($('#hideFpg').val() == '') {
                $('#hideFpg').val('{ "date":"'+$('#dtpFpgDate').val()+'", "time":"'+$('#dtpFpgTime').val()+'","result":"'+$('#tboFpgResult').val()+'" }');
            } else {
                $('#hideFpg').val($('#hideFpg').val()+',{ "date":"'+$('#dtpFpgDate').val()+'", "time":"'+$('#dtpFpgTime').val()+'","result":"'+$('#tboFpgResult').val()+'" }');
            }
            ncd.load_fpg();

            $('#popFpg').hide();
            $('#btnShowAddFpg').show();
        }
    });
    ncd.load_fpg = function() {
        var json = $.parseJSON("["+ $('#hideFpg').val() +"]");
        var j = '';
        $.each(json, function(index, value) {
            j += '<tr>'+
                '<td>'+ (index+1) +'</td>'+
                '<td>'+ value.date +'</td>'+
                '<td>'+ value.time +'</td>'+
                '<td>'+ value.result +'</td>'+
                '<td><a id="btnRemoveFpg" data-id="'+ index +'" class="btn btn-danger"><i class="icon-trash"></i></td>'+
                '</tr>';
        });
        $('#tblFpg > tbody').empty();
        $('#tblFpg > tbody').append(j);
        $('#dtpFpgDate').val(app.get_current_date());
        $('#dtpFpgTime').val(app.get_current_time());
        $('#tboFpgResult').val('');
    }
    $(document).on('click', '#btnRemoveFpg', function() {
        if(confirm('ยืนยันการลบข้อมูล')) {
            var id = $(this).attr('data-id');
            ncd.remove_fpg(id);
            ncd.load_fpg();
        }
    });
    ncd.remove_fpg = function(id) {
        var json = $.parseJSON("["+ $('#hideFpg').val() +"]");
        var j = '';
        $.each(json, function(index, value) {
            if(index != id) {
                if(j == '') {
                    j = '{ "date":"'+ value.date +'", "time":"'+value.time+'", "result":"'+value.result+'" }';
                } else {
                    j += ',{ "date":"'+ value.date +'", "time":"'+value.time+'", "result":"'+value.result+'" }';
                }
            }
        });
        $('#hideFpg').val(j);
    }
    /* END "Fasting Plasma Glucose (FPG)" */

    /* BEGIN "การวัดความดัน" */
    $(document).on('click', '#btnShowAddHt', function() {
        $('#popHt').show();
        $('#btnShowAddHt').hide();
    });

    $(document).on('click', '#btnCancelHt', function() {
        $('#popHt').hide();
        $('#btnShowAddHt').show();

        $('#tboHtResult1').val('');
        $('#tboHtResult2').val('');
    });

    $(document).on('click', '#btnAddHt', function() {
        if($('#tboHtResult1').val() == '' || $('#tboHtResult2').val() == '') {
            app.alert('กรุณากรอกข้อมูลให้ครบด้วย');
        } else {
            if($('#hideHt').val() == '') {
                $('#hideHt').val('{ "result1":"'+ $('#tboHtResult1').val() +'", "result2":"'+ $('#tboHtResult2').val() +'" }');
            } else {
                $('#hideHt').val($('#hideHt').val()+',{ "result1":"'+ $('#tboHtResult1').val() +'", "result2":"'+ $('#tboHtResult2').val() +'" }');
            }
            ncd.load_ht();

            $('#popHt').hide();
            $('#btnShowAddHt').show();
        }
    });
    ncd.load_ht = function() {
        var json = $.parseJSON("["+ $('#hideHt').val() +"]");
        var j = '';
        $.each(json, function(index, value) {
            j += '<tr>'+
                '<td>'+ (index+1) +'</td>'+
                '<td>'+ value.result1 +'</td>'+
                '<td>'+ value.result2 +'</td>'+
                '<td><a id="btnRemoveHt" data-id="'+ index +'" class="btn btn-danger"><i class="icon-trash"></i></td>'+
                '</tr>';
        });
        $('#tblHt > tbody').empty();
        $('#tblHt > tbody').append(j);
        $('#tboHtResult1').val('');
        $('#tboHtResult2').val('');
    }
    $(document).on('click', '#btnRemoveHt', function(id) {
        if(confirm('ยืนยันการลบข้อมูล')) {
            var id = $(this).attr('data-id');
            ncd.remove_ht(id);
            ncd.load_ht();
        }
    });
    ncd.remove_ht = function(id) {
        var json = $.parseJSON("["+ $('#hideHt').val() +"]");
        var j = '';
        $.each(json, function(index, value) {
            if(index != id) {
                if(j == '') {
                    j = '{ "result1":"'+ value.result1 +'", "result2":"'+value.result2+'" }';
                } else {
                    j += ',{ "result1":"'+ value.result1 +'", "result2":"'+value.result2+'" }';
                }
            }
        });
        $('#hideHt').val(j);
    }
    /* END "การวัดความดัน" */

    /* BEGIN คำนวณ BMI */
    $('#tboHeadWeight').keyup(function() {
        ncd.bmi_calc();
    });

    $('#tboHeadHeight').keyup(function() {
        ncd.bmi_calc();
    });

    ncd.bmi_calc = function() {
        var _weight = $('#tboHeadWeight').val();
        var _height = $('#tboHeadHeight').val();
        if(_weight != '' && _height != '') {
            $('#tboHeadBMI').val((parseFloat(_weight) / ((parseFloat(_height) / 100) * (parseFloat(_height) / 100))).toFixed(2));
        } else {
            $('#tboHeadBMI').val('');
        }
    }
    /* END คำนวณ BMI */

    $('#tboPcuCode').typeahead({
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

            $('#tboPcuCode').val(code);
            $('#tboPcuName').val(name);

            return code;
        }
    });

    //TAB
    $('#mainTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('#subTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    ncd.get_list();
});