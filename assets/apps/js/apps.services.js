head.ready(function(){
    var service = {};

    service.modal = {
        register: function(hn, vn){
            if(hn)
            {
                if(vn)
                {
                    //edit visit
                    app.load_page($('#mdl_new_service'), '/pages/register_service/' + hn + '/' + vn, 'assets/apps/js/pages/register_service.js');
                    $('#mdl_new_service').modal({keyboard: false});
                }
                else
                {
                    //register new visit with patient information
                    app.load_page($('#mdl_new_service'), '/pages/register_service/' + hn , 'assets/apps/js/pages/register_service.js');
                    $('#mdl_new_service').modal({keyboard: false});
                }

            }
            else
            {
                //register new visit without patient information
                app.load_page($('#mdl_new_service'), '/pages/register_service', 'assets/apps/js/pages/register_service.js');
                $('#mdl_new_service').modal({keyboard: false});
            }
        },
        hide_register: function(){
            $('#mdl_new_service').modal('hide');
        },
        search_person: function(){
            $('#modal_search_person').modal({
                keyboard: false
            });
        },
        hide_search_person: function(){
            $('#modal_search_person').modal('hide');
        }
    };

    service.ajax = {
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
                        '<td><a href="javascript:void(0)" data-name="btn_selected_visit" class="btn btn-default" ' +
                        'data-id="'+ v.person_id +'" data-vn="' + v.vn + '"> <i class="fa fa-arrow-circle-o-right"></i></a></td>' +
                        '</tr>'
                );
            });
        }else{
            $('#tbl_service_list > tbody').append('<tr><td colspan="9">ไม่พบรายการ</td></tr>');
        }
    };

    $('#btn_refresh_visit').on('click', function() {
        service.get_list();
    });

    service.get_list = function(){

        var date = $('#txt_service_date').val(),
            doctor_room = $('#sl_service_doctor_room').val();

        $('#tbl_service_list > tbody').empty();

        service.ajax.get_list_total(date, doctor_room, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_service_list > tbody').append('<tr><td colspan="9">ไม่พบรายการ</td></tr>');
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('serv_current_page'),
                    onSelect: function(page){
                        app.set_cookie('serv_current_page', page)
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
                $('#main_paging').paging(data.total, {
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
/*
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
    };*/

    $('#btn_new_visit').click(function(){
        //service.clear_register_form();
        service.modal.register();
    });

    //search person
    $('#btn_show_search_person').click(function(){
        var query = $('#txt_service_profile_hn').val();
        if(!query || query.length <= 2)
        {
            app.alert('กรุณาระบุคำที่ต้องการค้นหา');
        }
        else
        {
            //do search
            service.ajax.search_person_all(query, function(err, data){
                if(data)
                {
                    var detail = data.rows[0].first_name + ' ' + data.rows[0].last_name +
                        ' อายุ: ' + data.rows[0].age + ' ปี ที่อยู่: ' + data.rows[0].address
                    $('#txt_service_profile').val(detail);
                    $('#txt_hn').val(data.rows[0].hn);
                }
                else
                {
                    $('#txt_service_profile').val('');
                    app.alert('ไม่พบข้อมูลที่ค้นหา');
                    $('#txt_hn').val('');
                }
            });
        }
    });

    $(document).on('click', 'a[data-name="btn_selected_visit"]', function(){
        var vn = $(this).data('vn');

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

//    $('#txt_query_visit').typeahead({
//        ajax: {
//            url: site_url + '/person/search_person_ajax',
//            timeout: 500,
//            displayField: 'name',
//            triggerLength: 3,
//            preDispatch: function(query){
//                return {
//                    query: query,
//                    csrf_token: csrf_token
//                }
//            },
//
//            preProcess: function(data){
//                if(data.success){
//                    return data.rows;
//                }else{
//                    return false;
//                }
//            }
//        },
//        updater: function(data){
//
//            var d = data.split('#');
//
//            var hn = d[0],
//                name = d[1];
//
//           // $('#txt_reg_service_insc_hosp_sub_code').val(code);
//           // $('#txt_reg_service_insc_hosp_sub_name').val(name);
//
//            return hn;
//        }
//    });

    service.get_list();
});