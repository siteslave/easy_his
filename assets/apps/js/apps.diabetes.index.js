/**
 * DM scripts
 *
 * @author      Mr.Utit Sairat <soodteeruk@gmail.com>
 * @modified    Mr.Satit Rianpit <rianpit@gmail.com>
 * @copyright   Copyright 2013, Mr.Utit Sairat
 * @since       Version 1.0
 */
head.ready(function(){
    // DM name space with object.
    var dm = {};
    dm.update = {};

    //------------------------------------------------------------------------------------------------------------------
    //ajax object
    dm.ajax = {
        get_list: function(start, stop, cb){
            var url = 'diabetes/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'diabetes/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        get_list_by_village: function(village_id, start, stop, cb){
            var url = 'diabetes/get_list_by_villages',
                params = {
                    village_id: village_id,
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        get_list_by_village_total: function(village_id, cb){
            var url = 'diabetes/get_list_by_village_total',
                params = {
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        get_detail: function(hn, cb){
            var url = 'diabetes/get_detail',
                params = {
                    hn: hn
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        do_register: function(items, cb){
            var url = 'diabetes/do_register',
                params = {
                    data: items
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search_person: function(hn, cb){
            var url = 'diabetes/search_person',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        remove: function(hn, cb){
            var url = 'diabetes/remove',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        search: function(hn, cb){
            var url = 'diabetes/search',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    dm.modal = {
        show_register: function()
        {
            $('#mdlNewRegister').modal({
                backdrop: 'static'
            });
        },
        hide_register: function()
        {
            $('#tboSearch').val('');
            dm.clear_register_form();
            $('#mdlNewRegister').modal('hide');
        }
    };

    dm.set_list = function(data){
        if(_.size(data.rows) > 0){
            _.each(data.rows, function(v){
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>' + v.reg_serial + '</td>' +
                        '<td>' + v.hn + '</td>' +
                        '<td>' + app.clear_null(v.cid) + '</td>' +
                        '<td>' + v.first_name +' '+ v.last_name + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.birthdate) + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>' + v.sex + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.reg_date) + '</td>' +
                        '<td>' + v.diag_type + '</td>' +
                        '<td>' +
                        '<div class="btn-group dropup">' +
                        '<button type="button" class="btn btn-success dropdown-toggle btn-small" data-toggle="dropdown">' +
                        '<i class="fa fa-th-list"></i> <span class="caret"></span>' +
                        '</button>' +
                        '<ul class="dropdown-menu pull-right">' +
                        '<li>' +
                        '<a href="javascript:void(0);" data-name="edit" title="แก้ไข" data-hn="' + v.hn + '">' +
                        '<i class="fa fa-edit"></i> แก้ไขข้อมูล</a>' +
                        '</li>' +
                        '<li>' +
                        '<a href="javascript:void(0);" data-name="remove" title="ลบรายการ" data-hn="' + v.hn + '">' +
                        '<i class="fa fa-trash-o"></i> ลบรายการ</a>' +
                        '</li>' +
                        '<li>' +
                        '<a href="javascript:void(0);" data-name="visit_ncdscreen_history" title="ประวัติคัดกรอง" ' +
                        'data-hn="' + v.hn + '"><i class="fa fa-th-list"></i> ประวัติการคัดกรองความเสี่ยง</a>' +
                        '</li>' +
                        '<li>' +
                        '<a href="javascript:void(0);" data-name="visit_ncdscreen_history" ' +
                        'title="ประวัติคัดกรองภาวะแทรกซ้อน" ' +
                        'data-hn="' + v.hn + '"><i class="fa fa-eye-slash"></i> ประวัติการคัดกรองภาวะแทรกซ้อน</a>' +
                        '</li>' +
                        '</ul></div>' +
                        '</td>' +
                        '</tr>'
                );
            });
        }else{
            $('#tbl_list > tbody').append(
                '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
            );
        }
    };

    dm.get_list = function(){
        $('#main_paging').fadeIn('slow');
        dm.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('dm_paging'),
                    onSelect: function(page){
                        app.set_cookie('dm_paging', page);

                        dm.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_list > tbody').empty();
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append(
                                    '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
                                );
                            }else{
                                dm.set_list(data);
                            }

                        });

                    },
                    onFormat: app.paging_format
                });
            }
        });
    };

    $('#btn_register').click(function(){
        dm.clear_register_form();
        $('div[data-name="blog_search"]').show();
        $('#lblRegis').html('ลงทะเบียน');
        $('#lblRegis').attr('title', 'add');
        dm.modal.show_register();
    });

    dm.set_detail = function(v)
    {
        $('#txt_isupdate').val('1');
        $('#tboHN').val(v.hn);
        $('#tboCid').val(v.cid);
        $('#tboFname').val(v.first_name);
        $('#tboLname').val(v.last_name);
        $('#tboAge').val(v.age);
        $('#slSex').select2('val', v.sex);
        $('#tboRegCenterNumber').val(v.reg_serial);
        $('#tboRegHosNumber').val(v.hosp_serial);
        $('#tboYear').val(v.year);
        $('#dtpRegisDate').val(v.reg_date);
        $('#cboDiseaseType').select2('val', v.diag_type);
        $('#cboDoctor').select2('val', v.doctor);
        $('#ch_pre_register').prop('checked', true);
       //v.pre_register == "Y" ? $('#ch_pre_register').attr('checked', true) : $('#ch_pre_register').attr('checked', false);
        v.pregnancy == "1" ? $('#ch_pregnancy').prop('checked', true) : $('#ch_pregnancy').removeProp('checked');
        v.hypertension == "1" ? $('#ch_hypertension').prop('checked', true) : $('#ch_hypertension').removeProp('checked');
        v.insulin == "1" ? $('#ch_insulin').prop('checked', true) : $('#ch_insulin').removeProp('checked');
        v.newcase == "1" ? $('#ch_newcase').prop('checked', true) : $('#ch_newcase').removeProp('checked');
        $('#sl_member_status').select2('val', v.member_status);
        $('#txt_discharge_date').val(v.discharge_date);

        var fullname = v.first_name + ' '  + v.last_name;
        $('#txt_search_person').select2('data', {hn: v.hn, fullname: fullname});
        $('#txt_search_person').select2('enable', false);

        $('#tboRegHosNumber').focus();

    };

    dm.set_person_detail = function(v)
    {
        $('#tboHN').val(v.hn);
        $('#tboCid').val(v.cid);
        $('#tboFname').val(v.first_name);
        $('#tboLname').val(v.last_name);
        $('#tboAge').val(v.age);
        $('#slSex').val(v.sex);
    };
    //search person
    $('#btn_search_person').click(function(){
        var data = $('#txt_search_person').select2('data');

        var query = data.hn;

        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา โดยระบุ HN หรือ เลขบัตรประชาชน');
        }
        else
        {
            //do search
            //dm.clear_register_form();

            dm.ajax.search_person(query, function(err, data){

                if(err)
                {
                    app.alert(err);
                }
                else
                {
                   dm.set_person_detail(data.rows);
                }
            });
        }
    });


    $('#btn_filter_by_village').click(function(){
        var village_id = $('#sl_village').val();
        if(!village_id)
        {
            dm.get_list();
        }
        else
        {
            dm.get_list_by_village(village_id);
        }

    });

    dm.get_list_by_village = function(village_id)
    {
        $('#main_paging').fadeIn('slow');
        dm.ajax.get_list_by_village_total(village_id, function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('dm_filter_paging'),
                    onSelect: function(page){
                        app.set_cookie('dm_filter_paging', page);

                        dm.ajax.get_list_by_village(village_id, this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_list > tbody').empty();
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append(
                                    '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
                                );
                            }else{
                                dm.set_list(data);
                            }

                        });

                    },
                    onFormat: app.paging_format
                });
            }
        });
    };

    
    dm.clear_register_form = function() {
        $('#txt_isupdate').val('0');
        $('#tboHN').val('');
        $('#tboCid').val('');
        $('#tboFname').val('');
        $('#tboLname').val('');
        $('#tboAge').val('');
        $('#slSex').val('ชาย');
        $('#tboRegCenterNumber').val('');
        $('#tboRegHosNumber').val('');
        $('#tboYear').val('');
        $('#dtpRegisDate').val();
        $('#cboDiseaseType').val('');
        $('#cboDoctor').val('');
        $('#ch_pre_register').removeProp('checked');
        $('#ch_pregnancy').removeProp('checked');
        $('#ch_hypertension').removeProp('checked');
        $('#ch_insulin').removeProp('checked');
        $('#ch_newcase').removeProp('checked');
        $('#txt_search_person').select2('val', '');
        $('#txt_search_person').select2('enable', true);
        $('#btn_search_person').removeProp('disabled');
        $('#txt_discharge_date').val('');
        app.set_first_selected($('#sl_member_status'));
    };

    $(document).on('click', 'a[data-name="remove"]', function() {
        var hn = $(this).data('hn');
        //Confirm remove DM data
        var obj = $(this).parent().parent().parent();
        app.confirm('คุณต้องการจะลบรายการนี้หรือไม่ [hn = '+ hn +']?', function(cb) {
            if(cb) {
                dm.ajax.remove(hn, function(err) {
                    if(err) {
                        app.alert(err);
                    } else {
                        app.alert('ลบรายการเรียบร้อยแล้ว');
                        obj.fadeOut('slow');
                        //dm.get_list();
                    }
                });
            }
        });
    });

    $('#btn_dm_do_register').click(function() {
        var items = {};
        var babies = $('#txt_search_person').select2('data');

        items.hn            = babies.hn;
        items.hid_regis     = $('#tboRegHosNumber').val();
        items.year_regis    = $('#tboYear').val();
        items.reg_date      = $('#dtpRegisDate').val();
        items.diag_type     = $('#cboDiseaseType').val();
        items.doctor        = $('#cboDoctor').val();
        items.pre_register  = $('#ch_pre_register').is(":checked") ? '1' : '0';
        items.pregnancy     = $('#ch_pregnancy').is(":checked") ? '1' : '0';
        items.hypertension  = $('#ch_hypertension').is(":checked") ? '1' : '0';
        items.insulin       = $('#ch_insulin').is(":checked") ? '1' : '0';
        items.newcase       = $('#ch_newcase').is(":checked") ? '1' : '0';
        items.hosp_serial   = $('#tboRegHosNumber').val();
        items.is_update     = $('#txt_isupdate').val();
        items.discharge_date = $('#txt_discharge_date').val();
        items.member_status = $('#sl_member_status').val();

        if(!items.hn) {
            app.alert('กรุณาเลือกบุคคลที่ต้องการลงทะเบียนด้วย !');
        }
        else if(!items.year_regis)
        {
            app.alert("กรุณาระบุปีที่เริ่มเป็นด้วย !");
            $('#tboYear').focus();
        }
        else if(!items.reg_date)
        {
            app.alert("กรุณาระบุวันที่ขึ้นทะเบียน");
            $('#dtpRegisDate').focus();
        }
        else if(!items.diag_type)
        {
            app.alert('กรุณาระบุประเภทโรคด้วย !');
            $('#cboDiseaseType').focus();
        }
        else if(!items.doctor)
        {
            app.alert('กรุณาระบุแพทย์ผู้ดูแลด้วย !');
            $('#cboDoctor').focus();
        }
        else
        {
            if(confirm('คุณต้องการจะลงทะเบียนผู้ป่วยรายนี้หรือไม่ ?')) {
                dm.ajax.do_register(items, function(err) {
                    if(err) {
                        app.alert(err);
                    } else {
                        app.alert('ลงทะเบียนเรียบร้อยแล้ว');
                        dm.modal.hide_register();
                        dm.get_list();
                    }
                });
            }
        }
    });
    
    $(document).on('click', 'a[data-name="edit"]', function() {

        //do search
        dm.clear_register_form();

        $('#txt_search_person').prop('disabled', true).css('background-color', 'white');
        $('#btn_search_person').prop('disabled', true);
        $('#txt_isupdate').val('1');

        dm.modal.show_register();

        var hn = $(this).data('hn');

        if(!hn)
        {
            app.alert('กรุณาระบุคำค้นหา โดยระบุ HN หรือ เลขบัตรประชาชน');
        }
        else
        {
            dm.ajax.get_detail(hn, function(err, data){

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
                   dm.set_detail(data.rows);
                }
            });
        }

    });

    $('#btn_refresh').on('click', function(){
        dm.get_list();
    });

    $('#txt_query').select2({
        placeholder: 'HN, เลขบัตรประชาชน, ชื่อ-สกุล',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/person/search_person_all_ajax",
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

        id: function(data) { return { id: data.hn } },

        formatResult: function(data) {
            return '[' + data.hn + '] ' + data.fullname;
        },
        formatSelection: function(data) {
            return '[' + data.hn + '] ' + data.fullname;
        },
        initSelection: function(el, cb) {
            //var eltxt = $(el).val();
            //cb({'term': eltxt });
        }
    });

    $('#txt_search_person').select2({
        placeholder: 'HN, เลขบัตรประชาชน, ชื่อ-สกุล',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/person/search_person_all_ajax",
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

        id: function(data) { return { id: data.hn } },

        formatResult: function(data) {
            return '[' + data.hn + '] ' + data.fullname;
        },
        formatSelection: function(data) {
            return '[' + data.hn + '] ' + data.fullname;
        },
        initSelection: function(el, cb) {
            //var eltxt = $(el).val();
            //cb({'term': eltxt });
        }
    });

    $('#btn_search').on('click', function(){
        var data = $('#txt_query').select2('data');

        hn = data.hn;

        if(!hn)
        {
            app.alert('กรุณาระบุ HN เพื่อค้นหา');
        }
        else
        {
            $('#tbl_list > tbody').empty();
            $('#main_paging').fadeIn('slow');

            dm.ajax.search(hn, function(err, data){
                if(err)
                {
                    app.alert('ไม่พบรายการ');
                    $('#tbl_list > tbody').append(
                        '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
                    );
                }
                else
                {
                    dm.set_list(data);
                }
            });
        }
    });

    dm.get_list();
});