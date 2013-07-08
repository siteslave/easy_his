/**
 * DM scripts
 *
 * @author      Mr.Satit Rianpit(rianpit@gmail.com)
 * @copyright   Copyright 2013, Mr.Satit Rianpit
 * @since       Version 1.0
 */
head.ready(function() {
    // DM name space with object.
    var ht = {};
    ht.update = {};

    //------------------------------------------------------------------------------------------------------------------
    //ajax object
    ht.ajax = {
        /**
         * Get person list
         *
         * @param   start
         * @param   stop
         * @param   cb
         */
        get_list: function(start, stop, cb){
            var url = 'hypertension/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'hypertension/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        get_list_by_village: function(village_id, start, stop, cb){
            var url = 'hypertension/get_list_by_villages',
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
            var url = 'hypertension/get_list_by_village_total',
                params = {
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        get_detail: function(hn, cb){
            var url = 'hypertension/get_detail',
                params = {
                    hn: hn
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        do_register: function(items, cb){
            var url = 'hypertension/do_register',
                params = {
                    data: items
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search_person: function(hn, cb){
            var url = 'hypertension/search_person',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        remove: function(hn, cb){
            var url = 'hypertension/remove',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        search: function(hn, cb){
            var url = 'hypertension/search',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    ht.modal = {
        show_register: function()
        {
            $('#mdlNewRegister').modal({
                backdrop: 'static'
            });
        },
        hide_register: function()
        {
            $('#tboSearch').val('');
            ht.clear_register_form();
            $('#mdlNewRegister').modal('hide');
        }
    };
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Set person list
     *
     * @param data
     */

    ht.set_list = function(data){
        if(_.size(data.rows) > 0){
            _.each(data.rows, function(v){
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>' + v.hn + '</td>' +
                        '<td>' + app.clear_null(v.cid) + '</td>' +
                        '<td>' + v.first_name +' '+ v.last_name + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.birthdate) + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>' + v.sex + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.reg_date) + '</td>' +
                        '<td>' + v.diag_type + '</td>' +
                        '<td>' +
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0);" class="btn btn-success btn-small" data-name="edit" title="แก้ไข" ' +
                        'data-hn="' + v.hn + '"><i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0);" class="btn btn-danger btn-small" data-name="remove" title="ลบรายการ" ' +
                        'data-hn="' + v.hn + '"><i class="icon-trash"></i></a>' +
                        '</div>' +
                        '</td>' +
                        '</tr>'
                );
            });
        }else{
            $('#tbl_list > tbody').append(
                '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
            );
        }
    };
    ht.get_list = function(){
        $('#main_paging').fadeIn('slow');
        ht.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('ht_current_page'),
                    onSelect: function(page){
                        app.set_cookie('ht_current_page', page);
                        ht.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_list > tbody').empty();
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append(
                                    '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
                                );
                            }else{
                                ht.set_list(data);
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
        ht.clear_register_form();
        $('div[data-name="blog_search"]').show();
        ht.modal.show_register();
    });

    ht.set_detail = function(v)
    {
        $('#txt_isupdate').val('1');
        $('#tboHN').val(v.hn);
        $('#tboCid').val(v.cid);
        $('#tboFname').val(v.first_name);
        $('#tboLname').val(v.last_name);
        $('#tboAge').val(v.age);
        $('#slSex').val(v.sex);
        $('#tboRegCenterNumber').val(v.reg_serial);
        $('#tboRegHosNumber').val(v.hosp_serial);
        $('#tboYear').val(v.year);
        $('#dtpRegisDate').val(v.reg_date);
        $('#cboDiseaseType').val(v.diag_type);
        $('#cboDoctor').val(v.doctor);
        $('#ch_pre_register').prop('checked', true);

       //v.pre_register == "Y" ? $('#ch_pre_register').attr('checked', true) : $('#ch_pre_register').attr('checked', false);
        v.pregnancy == "1" ? $('#ch_pregnancy').prop('checked', true) : $('#ch_pregnancy').removeProp('checked');
        v.hypertension == "1" ? $('#ch_hypertension').prop('checked', true) : $('#ch_hypertension').removeProp('checked');
        v.insulin == "1" ? $('#ch_insulin').prop('checked', true) : $('#ch_insulin').removeProp('checked');
        v.newcase == "1" ? $('#ch_newcase').prop('checked', true) : $('#ch_newcase').removeProp('checked');
        $('#sl_member_status').val(v.member_status);
        $('#txt_discharge_date').val(v.discharge_date);

        $('#tboRegHosNumber').focus();

    };

    ht.set_person_detail = function(v)
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
        var query = $('#txt_search_person').val();

        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา โดยระบุ HN หรือ เลขบัตรประชาชน');
        }
        else
        {
            //do search
            ht.clear_register_form();

            ht.ajax.search_person(query, function(err, data){

                if(err)
                {
                    app.alert(err);
                }
                else
                {
                   ht.set_person_detail(data.rows);
                }
            });
        }
    });
    
    //set filter
    $('a[data-name="btn_set_search_person_filter"]').click(function(){
        var filter = $(this).data('value');

        $('input[data-name="txt_search_person_filter"]').val(filter);
    });

    $('#btn_filter_by_village').click(function(){
        var village_id = $('#sl_village').val();

        if (!village_id) {
            ht.get_list();
        }
        else {
            ht.get_list_by_village(village_id);
        }
    });

    ht.get_list_by_village = function(village_id)
    {
        $('#main_paging').fadeIn('slow');
        ht.ajax.get_list_by_village_total(village_id, function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('ht_village_current_page'),
                    onSelect: function(page){
                        app.set_cookie('ht_village_current_page', page);
                        ht.ajax.get_list_by_village(village_id, this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_list > tbody').empty();
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append(
                                    '<tr><td colspan="9">ไม่พบรายการ</td></tr>'
                                );
                            }else{
                                ht.set_list(data);
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

    
    ht.clear_register_form = function() {
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
        $('#txt_search_person').val('');
        $('#txt_search_person').removeProp('disabled');
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
                ht.ajax.remove(hn, function(err) {
                    if(err) {
                        app.alert(err);
                    } else {
                        app.alert('ลบรายการเรียบร้อยแล้ว');
                        obj.fadeOut('slow');
                        //ht.get_list();
                    }
                });
            }
        });
    });

    $('#btn_do_register').click(function() {
        var items = {};
        items.hn            = $('#tboHN').val();
        items.hid_regis     = $('#tboRegHosNumber').val();
        items.year_regis    = $('#tboYear').val();
        items.reg_date    = $('#dtpRegisDate').val();
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
                ht.ajax.do_register(items, function(err) {
                    if(err) {
                        app.alert(err);
                    } else {
                        app.alert('ลงทะเบียนเรียบร้อยแล้ว');
                        ht.modal.hide_register();
                        ht.get_list();
                    }
                });
            }
        }
    });
    
    $(document).on('click', 'a[data-name="edit"]', function() {

        //do search
        ht.clear_register_form();

        $('#txt_search_person').prop('disabled', true).css('background-color', 'white');
        $('#btn_search_person').prop('disabled', true);
        $('#txt_isupdate').val('1');

        ht.modal.show_register();

        var hn = $(this).data('hn');

        if(!hn)
        {
            app.alert('กรุณาระบุคำค้นหา โดยระบุ HN หรือ เลขบัตรประชาชน');
        }
        else
        {
            ht.ajax.get_detail(hn, function(err, data){

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
                   ht.set_detail(data.rows);
                }
            });
        }

    });

    $('#btn_refresh').on('click', function(){
        ht.get_list();
    });

    $('#txt_search_person').typeahead({
        ajax: {
            url: site_url + '/person/search_person_ajax',
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

            return code;
        }
    });

    $('#txt_query').typeahead({
        ajax: {
            url: site_url + '/person/search_person_ajax',
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

            return code;
        }
    });

    $('#btn_search').on('click', function(){
        var hn = $('#txt_query').val();
        if(!hn)
        {
            app.alert('กรุณาระบุ HN เพื่อค้นหา');
        }
        else
        {
            $('#tbl_list > tbody').empty();
            $('#main_paging').fadeIn('slow');

            ht.ajax.search(hn, function(err, data){
                if(err)
                {
                    app.alert('ไม่พบรายการ');
                    $('#tbl_list > tbody').append(
                        '<tr><td colspan="9">ไม่พบรายการ</td></tr>'
                    );
                }
                else
                {
                    ht.set_list(data);
                }
            });
        }
    });

    ht.get_list();
});