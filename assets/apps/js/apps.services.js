head.ready(function(){
    var service = {};

    service.modal = {
        register: function(){
            $('#mdl_register_new_service').modal({
                backdrop: 'static'
            }).css({
                    width: 980,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_register: function(){
            $('#mdl_register_new_service').modal('hide');
        },
        search_person: function(){
            $('#modal_search_person').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_search_person: function(){
            $('#modal_search_person').modal('hide');
        }
    };

    service.ajax = {
        get_person_detail: function(hn, cb){

            var url = 'services/get_person_detail',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search_person: function(query, op, cb){

            var url = 'services/search_person',
                params = {
                    query: query,
                    op: op
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        do_register: function(data, cb){

            var url = 'services/do_register',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_list: function(date, doctor_room, start, stop, cb){
            var url = 'services/get_list',
                params = {
                    start: start,
                    stop: stop,
                    date: date,
                    doctor_room: doctor_room
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list_search: function(hn, start, stop, cb){
            var url = 'services/get_list_search',
                params = {
                    start: start,
                    stop: stop,
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(date, doctor_room, cb){
            var url = 'services/get_list_total',
                params = {
                    date: date,
                    doctor_room: doctor_room
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list_search_total: function(hn, cb){
            var url = 'services/get_list_search_total',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search_visit: function(query, cb){
            var url = 'services/search',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    service.set_list = function(data)
    {
        if(_.size(data.rows)){
            _.each(data.rows, function(v){
                $('#tbl_service_list > tbody').append(
                    '<tr>' +
                        // '<td>' + v.vn + '</td>' +
                        '<td>' + v.hn + '</td>' +
                        //'<td>' + v.cid + '</td>' +
                        '<td>' + v.fullname + '</td>' +
                        '<td>' + app.count_age(v.birthdate) + '</td>' +
                        '<td>' + v.insurance_name + '</td>' +
                        '<td>' + v.cc + '</td>' +
                        '<td>' + v.clinic_name + '</td>' +
                        '<td>[<strong>' + v.diag + '</strong>] ' + v.diag_name.substr(0, 20) + '...</td>' +
                        '<td>' + v.provider_name + '</td>' +
                        '<td><a href="javascript:void(0)" data-name="btn_selected_visit" class="btn btn-info" ' +
                        'data-id="'+ v.person_id +'" data-vn="' + v.vn + '"> <i class="icon-edit"></i></a></td>' +
                        '</tr>'
                );
            });
        }else{
            $('#tbl_service_list > tbody').append('<tr><td colspan="9">ไม่พบรายการ</td></tr>');
        }
    };

    service.get_list = function(){

        var date = $('#txt_service_date').val(),
            doctor_room = $('#sl_service_doctor_room').val();

        $('#tbl_service_list > tbody').empty();

        service.ajax.get_list_total(date, doctor_room, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_service_list > tbody').append('<tr><td colspan="9">ไม่พบรายการ</td></tr>');
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        service.ajax.get_list(date, doctor_room, this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_service_list > tbody').empty();
                            if(err){
                                app.alert(err);
                                $('#tbl_service_list > tbody').append('<tr><td colspan="9">ไม่พบรายการ</td></tr>');
                            }else{
                                service.set_list(data);
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
        /*
        service.ajax.get_list(function(err, data){
            $('#tbl_service_list > tbody').empty();
            if(err){
                app.alert(err);
                $('#tbl_service_list > tbody').append('<tr><td colspan="8">ไม่พบรายการ</td></tr>');
            }else{
                service.set_list(data);
            }
        });
        */
    };

    service.get_list_search = function(){

        var hn = $('#txt_query_visit').val();

        $('#tbl_service_list > tbody').empty();

        service.ajax.get_list_search_total(hn, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_service_list > tbody').append('<tr><td colspan="9">ไม่พบรายการ</td></tr>');
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        service.ajax.get_list_search(hn, this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_service_list > tbody').empty();
                            if(err){
                                app.alert(err);
                                $('#tbl_service_list > tbody').append('<tr><td colspan="9">ไม่พบรายการ</td></tr>');
                            }else{
                                service.set_list(data);
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
        /*
        service.ajax.get_list(function(err, data){
            $('#tbl_service_list > tbody').empty();
            if(err){
                app.alert(err);
                $('#tbl_service_list > tbody').append('<tr><td colspan="8">ไม่พบรายการ</td></tr>');
            }else{
                service.set_list(data);
            }
        });
        */
    };

    service.clear_register_form = function()
    {
        $('#txt_service_profile_hn').val('');
        $('#txt_service_profile_cid').val('');
        $('#txt_service_profile_fullname').val('');
        $('#txt_service_profile_birthdate').val('');
        $('#txt_service_profile_address').val('');
        $('#txt_service_profile_age').val('');

        $('#txt_person_id').val('');
        $('#txt_service_vn').val('');
        $('#txt_service_hn').val('');
        $('#txt_reg_service_date').val('');
        $('#txt_reg_service_time').val('');

        app.set_first_selected($('#sl_reg_service_clinic'));
        app.set_first_selected($('#sl_reg_service_doctor_room'));
        app.set_first_selected($('#sl_reg_service_pttype'));
        app.set_first_selected($('#sl_reg_service_location'));
        app.set_first_selected($('#sl_reg_service_typein'));
        app.set_first_selected(('#sl_reg_service_service_place'));
        app.set_first_selected($('#sl_reg_service_insc'));
        $('#txt_reg_service_insc_code').val('');
        $('#txt_reg_service_insc_start_date').val('');
        $('#txt_reg_service_insc_expire_date').val('');
        $('#txt_reg_service_insc_hosp_main_code').val('');
        $('#txt_reg_service_insc_hosp_main_name').val('');
        $('#txt_reg_service_insc_hosp_sub_code').val('');
        $('#txt_reg_service_insc_hosp_sub_name').val('');
        $('#txt_reg_service_cc').val('');
    };

    $('#btn_new_visit').click(function(){
        service.clear_register_form();
        service.modal.register();
    });

    $('#txt_reg_service_insc_hosp_main_name').typeahead({
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

            $('#txt_reg_service_insc_hosp_main_code').val(code);
            $('#txt_reg_service_insc_hosp_main_name').val(name);

            return name;
        }
    });

    $('#txt_reg_service_insc_hosp_sub_name').bind('keyup', function(e) {
        //alert(e.keyCode);
        if(e.keyCode==8){
            $('#txt_reg_service_insc_hosp_sub_code').val('');
        }
    });
    $('#txt_reg_service_insc_hosp_main_name').bind('keyup', function(e) {
        //alert(e.keyCode);
        if(e.keyCode==8){
            $('#txt_reg_service_insc_hosp_main_code').val('');
        }
    });

    $('#txt_reg_service_insc_hosp_sub_name').typeahead({
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

            $('#txt_reg_service_insc_hosp_sub_code').val(code);
            $('#txt_reg_service_insc_hosp_sub_name').val(name);

            return name;
        }
    });

    $('#btn_reg_search_person').click(function(){
        var hn = $('#txt_service_hn').val(),
            fullname = $('#txt_service_search').val();

        if(!hn){
            app.alert('กรุณาระบุ ชื่อผู้ป่วย');
        }else if(!fullname){
            app.alert('กรุณาระบุคำที่ต้องการค้นหา');
        }else{
            service.ajax.get_person_detail(hn, function(err, data){
                if(err){
                    app.alert(err);
                }else{
                    $('#txt_service_profile_hn').val(data.hn);
                    $('#txt_service_profile_cid').val(data.cid);
                    $('#txt_service_profile_fullname').val(data.fullname);
                    $('#txt_service_profile_birthdate').val(app.to_thai_date(data.birthdate));
                    $('#txt_service_profile_address').val(data.address);
                }
            });
        }
    });

    //search person
    $('#btn_show_search_person').click(function(){
        service.modal.search_person();
        service.modal.hide_register();
    });

    $('#modal_search_person').on('hidden', function(){
        service.modal.register();
    });

    //search person by condition
    $('#btn_reg_search_person_by_name').click(function(){
        $('#txt_reg_person_search_by').val('name');
    });
    $('#btn_reg_search_person_by_cid').click(function(){
        $('#txt_reg_person_search_by').val('cid');
    });
    $('#btn_reg_search_person_by_hn').click(function(){
        $('#txt_reg_person_search_by').val('hn');
    });

    //do search person
    $('#btn_do_search_person').click(function(){
        var query = $('#txt_reg_search_person').val();
        if(!query || query.length < 2){
            app.alert('กรุณาระบุคำที่ต้องการค้นหา');
        }else{
            var op = $('#txt_reg_person_search_by').val();

            $('#table_search_person_result_list > tbody').empty();

            var obj = $('#div_search_person_result');
            app.show_block(obj);

            service.ajax.search_person(query, op, function(err, data){
                if(err){

                    app.alert(err);

                    $('#table_search_person_result_list > tbody').append(
                        '<tr><td colspan="6">ไม่พบรายการ</td></tr>'
                    );
                    app.hide_block(obj);

                }else{
                    if(_.size(data.rows)){
                        _.each(data.rows, function(v){
                            $('#table_search_person_result_list > tbody').append(
                                '<tr>' +
                                    '<td>'+ v.hn +'</td>' +
                                    '<td>'+ v.cid +'</td>' +
                                    '<td>'+ v.fullname +'</td>' +
                                    '<td>'+ app.to_thai_date(v.birthdate) +'</td>' +
                                    '<td>'+ app.count_age(v.birthdate) +'</td>' +
                                    '<td>'+ v.address +'</td>' +
                                    '<td><a href="javascript:void(0);" class="btn" data-name="btn_selected_person" ' +
                                    'data-id="'+ v.id +'" data-fullname="'+ v.fullname +'" data-hn="'+ v.hn +'" data-cid="'+ v.cid +'" ' +
                                    'data-birthdate="'+ v.birthdate +'" data-address="'+ v.address +'"> ' +
                                    '<i class="icon-ok"></i></a></td>' +
                                    '</tr>'
                            );
                        });
                    }else{
                        $('#table_search_person_result_list > tbody').append(
                            '<tr><td colspan="6">ไม่พบรายการ</td></tr>'
                        );
                    }

                    app.hide_block(obj);
                }
            });
        }
    });

    $(document).on('click', 'a[data-name="btn_selected_person"]', function(){
        var hn = $(this).attr('data-hn'),
            cid = $(this).attr('data-cid'),
            fullname = $(this).attr('data-fullname'),
            birthdate = $(this).attr('data-birthdate'),
            address = $(this).attr('data-address'),
            id = $(this).attr('data-id');

        $('#txt_person_id').val(id);
        $('#txt_service_profile_hn').val(hn);
        $('#txt_service_profile_cid').val(cid);
        $('#txt_service_profile_fullname').val(fullname);
        $('#txt_service_profile_birthdate').val(app.to_thai_date(birthdate));
        $('#txt_service_profile_address').val(address);
        $('#txt_service_profile_age').val(app.count_age(birthdate));

        service.modal.hide_search_person();
        service.modal.register();
    });
    //save service
    $('#btn_do_save_service_register').click(function(){
        var items = {};
        items.person_id = $('#txt_person_id').val();
        items.vn = $('#txt_service_vn').val();
        items.hn = $('#txt_service_profile_hn').val();
        items.date_serv = $('#txt_reg_service_date').val();
        items.time_serv = $('#txt_reg_service_time').val();
        items.clinic = $('#sl_reg_service_clinic').val();
        items.doctor_room = $('#sl_reg_service_doctor_room').val();
        items.patient_type = $('#sl_reg_service_pttype').val();
        items.location = $('#sl_reg_service_location').val();
        items.type_in = $('#sl_reg_service_typein').val();
        items.service_place = $('#sl_reg_service_service_place').val();
        items.insc_id = $('#sl_reg_service_insc').val();
        items.insc_code = $('#txt_reg_service_insc_code').val();
        items.insc_start_date = $('#txt_reg_service_insc_start_date').val();
        items.insc_expire_date = $('#txt_reg_service_insc_expire_date').val();
        items.insc_hosp_main = $('#txt_reg_service_insc_hosp_main_code').val();
        items.insc_hosp_sub = $('#txt_reg_service_insc_hosp_sub_code').val();
        items.cc = $('#txt_reg_service_cc').val();


        if(!items.date_serv){
            app.alert('กรุณาระบุวันที่รับบริการ');
        }else if(!items.time_serv){
            app.alert('กรุณาระบุเวลารับบริการ');
        }else if(!items.clinic){
            app.alert('กรุณาระบุ คลินิก');
        }else if(!items.patient_type){
            app.alert('กรุณาระบุ ประเภทผู้ป่วย');
        }else if(!items.doctor_room){
            app.alert('กรุณา เลือกห้องตรวจ');
        }else if(!items.location){
            app.alert('กรุณาระบุ ที่ตั้ง');
        }else if(!items.type_in){
            app.alert('กรุณาระบุ ประเภทการมา');
        }else if(!items.service_place){
            app.alert('กรุณาระบุ สถานที่รับบริการ');
        }else if(!items.insc_id){
            app.alert('กรุณาระบ สิทธิการรักษาพยาบาล');
        }else if(!items.person_id){
            app.alert('กรุณาระบุ ข้อมูลผู้ป่วย');
        }else if(!items.cc){
            app.alert('กรุณาระบุ อาการแรกรับ (CC)');
        }else{
            //do save
            service.ajax.do_register(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('Save success.');
                    service.modal.hide_register();
                    service.get_list();
                }
            });
        }

    });

    $(document).on('click', 'a[data-name="btn_selected_visit"]', function(){
        var vn = $(this).attr('data-vn'),
            person_id = $(this).attr('data-id');

        if(!vn){
            app.alert('กรุณาเลือกผู้ป่วยที่ต้องการ');
        }else{
            app.go_to_url('services/entries/' + vn);
        }
    });

    $('#btn_do_filter').on('click', function(){
        service.get_list();
    });

    //search visit
    $('#btn_do_search_visit').on('click', function(){
        var query = $('#txt_query_visit').val();

        if(!query)
        {
            service.get_list();
        }
        else
        {
            service.get_list_search();
        }
    });



    $('#txt_query_visit').typeahead({
        ajax: {
            url: site_url + 'person/search_person_ajax',
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

            var hn = d[0],
                name = d[1];

           // $('#txt_reg_service_insc_hosp_sub_code').val(code);
           // $('#txt_reg_service_insc_hosp_sub_name').val(name);

            return hn;
        }
    });

    service.get_list();
});