/*
 * Main appointment library.
 * 
 * @author		Mr.Satit Rianpit <mr.satit@outlook.com>
 * @copyright	Copyright 2013. Allright reserved.
 * @license		http://his.mhkdc.com
 */

head.ready(function(){
    //------------------------------------------------------------------------------------------------------------------
    //Appointment object.
    var appoint = {};
    //------------------------------------------------------------------------------------------------------------------
    // Modal object
    appoint.modal = {
        show_search_visit: function(){
            $('#mdl_select_visit').modal({
                backdrop: 'static'
            }).css({
                width: 780,
                'margin-left': function() {
                    return -($(this).width() / 2);
                }
                });
        },
        show_register_service: function(){
            $('#mdl_register_service').modal({
                backdrop: 'static'
            }).css({
                width: 960,
                'margin-left': function() {
                    return -($(this).width() / 2);
                }
                });
        },
        show_update: function(){
            $('#mdl_update').modal({
                backdrop: 'static'
            }).css({
                width: 960,
                'margin-left': function() {
                    return -($(this).width() / 2);
                }
            });
        },
        hide_new: function(){
            $('#mdl_select_visit').modal('hide');
        }
    };
    //------------------------------------------------------------------------------------------------------------------
    // Ajax object.
    appoint.ajax = {
        get_list: function(data, start, stop, cb){
            var url = 'appoints/get_list',
            params = {
                data: data,
                start: start,
                stop: stop
            };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_total_clinic: function(data, cb){
            var url = 'appoints/get_total_clinic',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_total_without_clinic: function(data, cb){
            var url = 'appoints/get_total_without_clinic',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        search_visit: function(query, filter, cb){
            var url = 'appoints/search_visit',
            params = {
                query: query,
                filter: filter
            };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(id, cb){
            var url = 'appoints/remove',
            params = {
                id: id
            };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        update: function(data, cb){
            var url = 'appoints/update',
            params = {
                data: data
            };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        detail: function(id, cb){
            var url = 'appoints/detail',
            params = {
                id: id
            };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        save_service: function(data, cb){
            var url = 'appoints/save_service',
            params = {
                data: data
            };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };
    //------------------------------------------------------------------------------------------------------------------
    //Set appointment list.
    appoint.set_list = function(data){
        $('#tbl_appoint_list > tbody').empty();
        if(_.size(data.rows) <= 0)
        {
            $('#tbl_appoint_list > tbody').append('<tr><td colspan="9">ไม่พบข้อมูล</td></tr>');
        }
        else
        {
            _.each(data.rows, function(v){
                var vstatus = v.vstatus == '1' ? '<span class="label label-success" title="มาตามนัด">มาตามนัด</span>' :
                    '<span class="label label-warning" title="ไม่มาตามนัด">ไม่มาตามนัด</span>';

                $('#tbl_appoint_list > tbody').append(
                    '<tr>' +
                        '<td>' + vstatus + '</td>' +
                        '<td>' + v.apdate_thai + '</td>' +
                        '<td>' + v.aptime + '</td>' +
                        '<td>' + v.hn + '</td>' +
                        '<td>' + v.person_name + '</td>' +
                        '<td>' + v.aptype_name + '</td>' +
                        '<td>' + v.clinic_name + '</td>' +
                        '<td>' + v.provider_name + '</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_edit" data-id="' + v.id + '" class="btn">' +
                        '<i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_remove" data-id="' + v.id + '" class="btn"> '+
                        '<i class="icon-trash"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_set_visit" data-id="' + v.id + '" data-hn="'+ v.hn +'" ' +
                        'data-fullname="'+ v.person_name +'" data-clinic="' + v.clinic_id + '" data-apdate="'+ v.apdate_js +'" ' +
                        'data-status="' + v.vstatus + '" class="btn"> '+
                        '<i class="icon-share"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };
    /**
     * Get appointment list
     *
     * @return void
     */
    appoint.get_list = function()
    {
        var data = {};
        data.date     = $('#txt_date').val();
        data.clinic   = $('#sl_clinic').val();
        data.status   = $('#txt_status').val();

        if(data.clinic)
        {
            //search by clinic
            appoint.get_list_clinic(data);
        }
        else
        {
            //search without clinic
            appoint.get_list_without_clinic(data);
        }
    };
    //------------------------------------------------------------------------------------------------------------------
    //Do filter.
    $('button[data-name="btn_do_filter"]').click(function(){
        var id = $(this).attr('data-id');
        $('#txt_status').val(id);
        appoint.get_list();
    });
    //------------------------------------------------------------------------------------------------------------------
    $('#btn_show_visit').click(function(){
        appoint.modal.show_search_visit();
    });
    //------------------------------------------------------------------------------------------------------------------
    //Set search visit filter.
    $('a[data-name="btn_set_search_visit_filter"]').click(function(){
        var v = $(this).attr('data-value');

        $('#txt_search_visit_by').val(v);
    });

    //------------------------------------------------------------------------------------------------------------------
    //Search visit
    $('#btn_do_search_visit').click(function(){
        var query = $('#txt_query_visit').val(),
            filter = $('#txt_search_visit_by').val();

        if(!query){
            app.alert('กรุณาระบุคำที่ต้องการค้นหา');
        }else{
            appoint.ajax.search_visit(query, filter, function(err, data){
                $('#tbl_search_visit_result > tbody').empty();
                if(err){
                    app.alert(err);
                }else{
                    _.each(data.rows, function(v){

                        $('#tbl_search_visit_result > tbody').append(
                                '<tr>' +
                                '<td>'+ v.vn +'</td>' +
                                '<td>'+ v.date_serv +'</td>' +
                                '<td>'+ v.time_serv +'</td>' +
                                '<td>'+ v.clinic_name +'</td>' +
                                '<td><a href="javascript:void(0);" class="btn" data-name="btn_selected_visit" ' +
                                'data-vn="'+ v.vn +'" data-hn="'+ v.hn +'"><i class="icon-ok"></i></a></td>' +
                                '</tr>'
                        );
                    });
                }
            });
        }
    });

    $(document).on('click', 'a[data-name="btn_selected_visit"]', function(){
        var hn = $(this).attr('data-hn'),
            vn = $(this).attr('data-vn');

        app.go_to_url('appoints/register/' + vn + '/' + hn);
    });

    //------------------------------------------------------------------------------------------------------------------
    /*
     * Remove appointment
     */
    $(document).on('click', 'a[data-name="btn_remove"]', function(){
        var id = $(this).attr('data-id'),
            obj = $(this).parent().parent().parent();

        app.confirm('คุณต้องการลบรายการใช่หรือไม่?', function(res){
            if(res){
                appoint.ajax.remove(id, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        obj.fadeOut('slow');
                    }
                });
            }
        });
    });

    /**
     * Get appointment list by clinic
     * @param   mixed   items
     */
    appoint.get_list_clinic = function(items){

        $('#tbl_appoint_list > tbody').empty();

        appoint.ajax.get_total_clinic(items, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_appoint_list > tbody').append('<tr><td colspan="9">ไม่พบข้อมูล</td></tr>');
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        appoint.ajax.get_list(items, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                            }else{
                                appoint.set_list(data);
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

    appoint.get_list_without_clinic = function(items){

        $('#tbl_appoint_list > tbody').empty();

        appoint.ajax.get_total_without_clinic(items, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_appoint_list > tbody').append('<tr><td colspan="9">ไม่พบข้อมูล</td></tr>');
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        appoint.ajax.get_list(items, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                                $('#tbl_appoint_list > tbody').append('<tr><td colspan="9">ไม่พบข้อมูล</td></tr>');
                            }else{
                                appoint.set_list(data);
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

    //edit
    appoint.set_detail = function(data)
    {
        $('#txt_update_date').val(data.rows.date);
        $('#txt_update_time').val(data.rows.time);
        $('#sl_update_clinic').val(data.rows.clinic);
        $('#sl_update_aptype').val(data.rows.type);
        $('#txt_update_diag_code').val(data.rows.diag);
        $('#txt_update_diag_name').val(data.rows.diag_name);
    };

    appoint.clear_form = function()
    {
        $('#txt_update_date').val('');
        $('#txt_update_time').val('');
        $('#sl_update_clinic').val('');
        $('#sl_update_aptype').val('');
        $('#txt_update_diag_code').val('');
        $('#txt_update_diag_name').val('');
    };

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var id = $(this).attr('data-id');

        $('#txt_update_id').val(id);

        //get detail
        appoint.ajax.detail(id, function(err, data){
            if(err)
            {
                app.alert(err);
            }
            else
            {
                appoint.clear_form();
                //set data
                appoint.set_detail(data);
                //show modal
                appoint.modal.show_update();
            }
        });
    });
    //save update
    $('#btn_do_update').on('click', function(){
        var data = {};
        data.id = $('#txt_update_id').val();
        data.date = $('#txt_update_date').val();
        data.time = $('#txt_update_time').val();
        data.clinic = $('#sl_update_clinic').val();
        data.type = $('#sl_update_aptype').val();
        data.diag = $('#txt_update_diag_code').val();

        if(!data.id)
        {
            app.alert('กรุณาระบุข้อมูลที่ต้องการแก้ไข (ID not found.)');
        }
        else if(!data.date)
        {
            app.alert('กรุณาระบุวันที่นัด');
        }
        else if(!data.time)
        {
            app.alert('กรุณาระบุเวลาที่นัด');
        }
        else if(!data.clinic)
        {
            app.alert('กรุณารุบุคลินิคที่นัด');
        }
        else if(!data.type)
        {
            app.alert('กรุณาระบุประเภทการนัด');
        }
        else
        {
            //do save
            appoint.ajax.update(data, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('ปรับปรุงข้อมูลเสร็จเรียบร้อยแล้ว');

                    appoint.get_list();
                }
            });
        }
    });

    //search diag
    $('#txt_update_diag_code').typeahead({
        ajax: {
            url: site_url + 'basic/search_icd_ajax',
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
            var code = d[0],
                name = d[1];
            //alert(code);
            $('#txt_update_diag_code').val(code);
            $('#txt_update_diag_name').val(name);

            return code;
        }
    });

    //set visit
    $(document).on('click', 'a[data-name="btn_set_visit"]', function(){
        var id = $(this).attr('data-id');
        //set detail

    });

    //show set service
    $(document).on('click', 'a[data-name="btn_set_visit"]', function(){
        var id = $(this).attr('data-id'),
            fullname = $(this).attr('data-fullname'),
            hn = $(this).attr('data-hn'),
            clinic = $(this).attr('data-clinic'),
            date_serv = $(this).attr('data-apdate'),
            status = $(this).attr('data-status');

        if(status == '1')
        {
            app.alert('รายการนี้ได้ถูกลงทะเบียนรับบริการเรียบร้อยแล้ว ไม่สามารถลงทะเบียนได้อีก');
        }
        else
        {
            appoint.clear_register_service_form();

            $('#txt_serv_date').val(date_serv);
            $('#txt_serv_appoint_id').val(id);
            $('#txt_serv_hn').val(hn);
            $('#txt_serv_fullname').val(fullname);
            $('#sl_serv_clinic').val(clinic);

            appoint.modal.show_register_service();
        }
    });


    $('#txt_serv_insc_hosp_main_name').typeahead({
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

            $('#txt_serv_insc_hosp_main_code').val(code);
            $('#txt_serv_insc_hosp_main_name').val(name);

            return name;
        }
    });

    $('#txt_serv_insc_hosp_sub_name').bind('keyup', function(e) {
        //alert(e.keyCode);
        if(e.keyCode==8){
            $('#txt_serv_insc_hosp_sub_code').val('');
        }
    });
    $('#txt_serv_insc_hosp_main_name').bind('keyup', function(e) {
        //alert(e.keyCode);
        if(e.keyCode==8){
            $('#txt_serv_insc_hosp_main_code').val('');
        }
    });

    $('#txt_serv_insc_hosp_sub_name').typeahead({
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

            $('#txt_serv_insc_hosp_sub_code').val(code);
            $('#txt_serv_insc_hosp_sub_name').val(name);

            return name;
        }
    });

    appoint.clear_register_service_form = function()
    {
        $('#txt_serv_hn').val('');
        $('#txt_serv_fullname').val('');
        $('#txt_serv_appoint_id').val('');

        $('#txt_serv_date').val('');
        $('#txt_serv_time').val('');

        app.set_first_selected($('#sl_serv_clinic'));
        app.set_first_selected($('#sl_serv_doctor_room'));
        app.set_first_selected($('#sl_serv_pttype'));
        app.set_first_selected($('#sl_serv_location'));
        app.set_first_selected($('#sl_serv_typein'));
        app.set_first_selected($('#sl_serv_service_place'));
        app.set_first_selected($('#sl_serv_insc'));
        $('#txt_serv_insc_code').val('');
        $('#txt_serv_insc_start_date').val('');
        $('#txt_serv_insc_expire_date').val('');
        $('#txt_serv_insc_hosp_main_code').val('');
        $('#txt_serv_insc_hosp_main_name').val('');
        $('#txt_serv_insc_hosp_sub_code').val('');
        $('#txt_serv_insc_hosp_sub_name').val('');
        $('#txt_serv_cc').val('');
    };

    //save service

    $('#btn_do_save_service_register').on('click', function(){
        var data = {};

        data.hn                 = $('#txt_serv_hn').val();
        data.appoint_id         = $('#txt_serv_appoint_id').val();

        data.date_serv          = $('#txt_serv_date').val();
        data.time_serv          = $('#txt_serv_time').val();
        data.clinic          = $('#sl_serv_clinic').val();
        data.doctor_room        = $('#sl_serv_doctor_room').val();
        data.patient_type             = $('#sl_serv_pttype').val();
        data.location           = $('#sl_serv_location').val();
        data.type_in             = $('#sl_serv_typein').val();
        data.service_place      = $('#sl_serv_service_place').val();
        data.insc_id               = $('#sl_serv_insc').val();
        data.insc_code          = $('#txt_serv_insc_code').val();
        data.insc_start_date    = $('#txt_serv_insc_start_date').val();
        data.insc_expire_date   = $('#txt_serv_insc_expire_date').val();
        data.insc_hosp_main     = $('#txt_serv_insc_hosp_main_code').val();
        data.insc_hosp_sub      = $('#txt_serv_insc_hosp_sub_code').val();
        data.cc                 = $('#txt_serv_cc').val();

        if(!data.hn)
        {
            app.alert('กรุณาระบุ HN ผู้รับบริการ');
        }
        else if(!data.appoint_id)
        {
            app.alert('ไม่พบข้อมูลการนัด');
        }
        else if(!data.date_serv)
        {
            app.alert('กรุณาระบุวันที่รับบริการ');
        }
        else if(!data.time_serv)
        {
            app.alert('กรุณาระบุเวลารับบริการ');
        }
        else if(!data.clinic)
        {
            app.alert('กรุณาระบุแผนกที่รับบริการ');
        }
        else if(!data.doctor_room)
        {
            app.alert('กรุณาระบุห้องตรวจ');
        }
        else if(!data.patient_type)
        {
            app.alert('กรุณาระบุประเภทผู้ป่วย');
        }
        else if(!data.location)
        {
            app.alert('กรุณาระบุที่ตั้ง');
        }
        else if(!data.type_in)
        {
            app.alert('กรุณาระบุประเภทการมา');
        }
        else if(!data.service_place)
        {
            app.alert('กรุณาระบุสถานที่รับบริการ');
        }
        else if(!data.cc)
        {
            app.alert('กรุณาระบุอาการแรกรับ (CC)');
        }
        else if(!data.insc_id)
        {
            app.alert('กรุณาระบุสิทธิการรักษา');
        }
        else
        {
            //do save
            appoint.ajax.save_service(data, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                }
            });
        }

    });
});

//End file