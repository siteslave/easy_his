/**
 * Pregnancies scripts
 *
 * @author      Mr.Satit Riapit <mr.satit@outlook.com>
 * @copyright   Copyright 2013, Mr.Satit Rianpit
 * @since       Version 1.0
 */
head.ready(function(){
    // Pregnancies name space with object.
    var preg = {};

    //------------------------------------------------------------------------------------------------------------------
    //ajax object
    preg.ajax = {
        search_person: function(query, filter, cb){
            var url = 'person/search',
                params = {
                    query: query,
                    filter: filter
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(start, stop, cb){
            var url = 'pregnancies/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_by_village: function(village_id, cb){
            var url = 'pregnancies/get_list_by_village',
                params = {
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'pregnancies/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        do_register: function(data, cb){
            var url = 'pregnancies/do_register',
                params = {
                    data: data
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        check_registration: function(hn, cb){
            var url = 'pregnancies/check_registration',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        anc: {
            get_info: function(anc_code, cb){
                var url = 'pregnancies/get_anc_info',
                    params = {
                        anc_code: anc_code
                    };

                app.ajax(url, params, function(err, data){
                    err ? cb(err) : cb(null, data);
                });
            },
            get_history: function(hn, gravida, cb){
                var url = 'pregnancies/anc_get_history',
                    params = {
                        hn: hn,
                        gravida: gravida
                    };

                app.ajax(url, params, function(err, data){
                    err ? cb(err) : cb(null, data);
                });
            },
            save_info: function(data, cb){
                var url = 'pregnancies/save_anc_info',
                    params = {
                        data: data
                    };

                app.ajax(url, params, function(err, data){
                    err ? cb(err) : cb(null, data);
                });
            }
        },

        labor: {
            save: function(data, cb){
                var url = 'pregnancies/labor_save',
                    params = {
                        data: data
                    };

                app.ajax(url, params, function(err, data){
                    err ? cb(err) : cb(null, data);
                });
            },
            get_detail: function(anc_code, cb)
            {
                var url = 'pregnancies/labor_get_detail',
                    params = {
                        anc_code: anc_code
                    };

                app.ajax(url, params, function(err, data){
                    err ? cb(err) : cb(null, data);
                });
            }
        }



    };

    preg.modal = {
        show_register: function()
        {
            $('#mdl_search_person').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        show_labor: function()
        {
            $('#mdl_labor').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        show_anc_info: function()
        {
            $('#mdl_anc_info').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_register: function()
        {
            $('#mdl_search_person').modal('hide');
        },
        hide_labor: function()
        {
            $('#mdl_labor').modal('hide');
        },
        hide_anc_info: function()
        {
            $('#mdl_anc_info').modal('hide');
        }
    };
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Set person list
     *
     * @param data
     */

    preg.set_list = function(data){
        $('#tbl_list > tbody').empty();
        if(_.size(data.rows) > 0){
            _.each(data.rows, function(v){
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.anc_code +'</td>' +
                        '<td>' + v.hn + '</td>' +
                        '<td>' + app.clear_null(v.cid) + '</td>' +
                        '<td>' + v.first_name +' '+ v.last_name + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.birthdate) + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.reg_date) + '</td>' +
                        '<td>'+ v.gravida +'</td>' +
                        '<td>'+ v.preg_status +'</td>' +
                        '<td>' +
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0);" class="btn" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-birthdate="'+app.mongo_to_thai_date(v.birthdate)+'" data-age="'+ v.age+'" data-hn="'+ v.hn+'" ' +
                        'data-anc_code="'+ v.anc_code+'" data-gravida="'+ v.gravida +'" data-name="labor" data-hn="' + v.hn + '" ' +
                        'data-cid="' + v.cid +'" title="ข้อมูลการคลอด"><i class="icon-check"></i></a>' +
                        '<a href="javascript:void(0);" class="btn" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-birthdate="'+app.mongo_to_thai_date(v.birthdate)+'" data-age="'+ v.age+'" data-hn="'+ v.hn+'" ' +
                        'data-anc_code="'+ v.anc_code+'" data-gravida="'+ v.gravida +'" data-name="anc_info" data-hn="' + v.hn + '" ' +
                        'data-cid="' + v.cid +'" title="ข้อมูลการฝากครรภ์"><i class="icon-book"></i></a>' +
                        '</div>' +
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
    preg.get_list = function(){
        $('#main_paging').fadeIn('slow');
        $('#tbl_list > tbody').empty();
        preg.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_list > tbody').append(
                    '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
                );
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        preg.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append(
                                    '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
                                );
                            }else{
                                preg.set_list(data);
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

    preg.get_list_by_village = function(village_id){
        $('#main_paging').fadeOut('slow');
        $('#tbl_list > tbody').empty();
        preg.ajax.get_list_by_village(village_id, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_list > tbody').append(
                    '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
                );
            }else{
                preg.set_list(data);
            }
        });
    };

    $('#btn_register').click(function(){
        preg.modal.show_register();
    });

    $('#btn_do_get_list').on('click', function(e){
        var village_id = $('#sl_village').val();
        if(!village_id)
        {
            preg.get_list();
        }
        else
        {
            preg.get_list_by_village(village_id);
        }
    });

    preg.set_search_person_result = function(data)
    {
        if(!data)
        {
            $('#tbl_search_person_result > tbody').append(
                '<tr><td colspan="7">ไม่พบรายการ</td></tr>');
        }
        else
        {
            _.each(data.rows, function(v){
                $('#tbl_search_person_result > tbody').append(
                    '<tr>' +
                        '<td>'+ v.hn +'</td>' +
                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>'+ app.mongo_to_thai_date(v.birthdate) +'</td>' +
                        '<td>'+ v.age +'</td>' +
                        '<td>'+ v.sex +'</td>' +
                        '<td><a href="#" class="btn" data-hn="'+ v.hn + '" data-sex="'+ v.sex +'" ' +
                        'data-name="btn_selected_person" data-typearea="'+ v.typearea +'">' +
                        '<i class="icon-ok"></i></a></td>' +
                        '</tr>');
            });
        }
    };

    //search person
    $('#btn_do_search_person').click(function(){
        var query = $('#txt_search_query').val(),
            filter = $('#txt_search_person_filter').val();

        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา โดยระบุชื่อ-สกุล หรือ HN หรือ เลขบัตรประชาชน');
        }
        else
        {
            //do search
            $('#tbl_search_person_result > tbody').empty();

            preg.ajax.search_person(query, filter, function(err, data){

                if(err)
                {
                    app.alert(err);
                    $('#tbl_search_person_result > tbody').append(
                        '<tr><td colspan="7">ไม่พบรายการ</td></tr>');
                }
                else
                {
                    preg.set_search_person_result(data);
                }
            });
        }
    });

    //set filter
    $('a[data-name="btn_search_person_fillter"]').click(function(){
        var filter = $(this).attr('data-value');

        $('#txt_search_person_filter').val(filter);
    });

    $(document).on('click', 'a[data-name="btn_selected_person"]', function(){

        if( ! _.indexOf(['1', '3'], $(this).data('typearea')) || !$(this).data('typearea'))
        {
            app.alert('บุคคลนี้ไม่ใช่บุคคลในเขตรับผิดชอบ');
        }
        else if($(this).data('sex') == 'ชาย')
        {
            app.alert('บุคคลนี้เป็นเพศชาย ไม่สามารถลงทะเบียนได้');
        }
        else
        {
            var gravida = prompt('กรุณาระบุครรภ์ที่', 1);

            if(gravida || gravida > 0)
            {
                var data = {};
                data.hn = $(this).data('hn');
                data.gravida = gravida;

                if(confirm('คุณต้องการลงทะเบียนข้อมูลนี้ใช่หรือไม่?'))
                {
                    //do register
                    preg.ajax.do_register(data, function(err){
                        if(err)
                        {
                            app.alert(err);
                        }
                        else
                        {
                            app.alert('ลงทะเบียนรายการเสร็จเรียบร้อยแล้ว');
                            preg.modal.hide_register();
                            preg.get_list();
                        }
                    });
                }
            }
        }
    });
    preg.labor = {
        get_detail: function(anc_code)
        {
            preg.ajax.labor.get_detail(anc_code, function(err, data){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    preg.labor.set_detail(data);
                }
            });
        },

        set_detail: function(data)
        {
            //$('#txt_labor_lmp').val(data.rows[0].lmp);
            //$('#txt_labor_edc').val(data.rows[0].edc);
            $('#txt_labor_bdate').val(data.rows[0].bdate);
            $('#txt_labor_btime').val(data.rows[0].btime);
            $('#txt_labor_bresult_icdcode').val(data.rows[0].icd_code);
            $('#txt_labor_bresult_icdname').val(data.rows[0].icd_name);
            $('#sl_labor_bplace').val(data.rows[0].bplace);
            $('#txt_labor_hospcode').val(data.rows[0].bhosp);
            $('#txt_labor_hospname').val(data.rows[0].bhosp_name);
            $('#sl_labor_btype').val(data.rows[0].btype);
            $('#sl_labor_bdoctor').val(data.rows[0].bdoctor);
            $('#txt_labor_lborn').val(data.rows[0].lborn);
            $('#txt_labor_sborn').val(data.rows[0].sborn);
            //$('#sl_labor_preg_status').val(data.rows[0].preg_status);
        }
    };
    //labor detail
    $(document).on('click', 'a[data-name="labor"]', function(){
        var hn = $(this).attr('data-hn'),
            anc_code = $(this).attr('data-anc_code'),
            fullname = $(this).attr('data-fullname'),
            birthdate = $(this).attr('data-birthdate'),
            age = $(this).attr('data-age'),
            gravida = $(this).attr('data-gravida'),
            cid = $(this).attr('data-cid');

        $('#txt_labor_hn').val(hn);
        $('#txt_labor_cid').val(cid);
        $('#txt_labor_fullname').val(fullname);
        $('#txt_labor_birthdate').val(birthdate);
        $('#txt_labor_age').val(age);
        $('#txt_labor_gravida').val(gravida);

        //get labor detail
        preg.labor.get_detail(anc_code);

        preg.modal.show_labor();
    });

    //------------------------------------------------------------------------------------------------------------------
    //save labor
    $('#btn_labor_do_save').click(function(){
        var data = {};

        data.hn = $('#txt_labor_hn').val();
        data.gravida = $('#txt_labor_gravida').val();
        //data.lmp = $('#txt_labor_lmp').val();
        //data.edc = $('#txt_labor_edc').val();
        data.bdate = $('#txt_labor_bdate').val();
        data.btime = $('#txt_labor_btime').val();
        data.bresult = $('#txt_labor_bresult_icdcode').val();
        data.bplace = $('#sl_labor_bplace').val();
        data.bhosp = $('#txt_labor_hospcode').val();
        data.btype = $('#sl_labor_btype').val();
        data.bdoctor = $('#sl_labor_bdoctor').val();
        data.lborn = $('#txt_labor_lborn').val();
        data.sborn = $('#txt_labor_sborn').val();
        //data.preg_status = $('#sl_labor_preg_status').val();

        if(!data.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!data.gravida)
        {
            app.alert('กรุณาระบุ ครรภ์ที่');
        }
        else if(!data.bdate)
        {
            app.alert('กรุณาระบุวันที่คลอด');
        }
        else if(!data.btime)
        {
            app.alert('กรุณาระบุเวลาที่คลอด');
        }
        else if(!data.bresult)
        {
            app.alert('กรุณาระบุการวินิจฉัยการคลอด');
        }
        else if(!data.bplace)
        {
            app.alert('กรุณาระบุสถานที่คลอด');
        }
        else if(!data.bhosp)
        {
            app.alert('กรุณาระบุสถานพยาบาลที่คลอด');
        }
        else if(!data.btype)
        {
            app.alert('กรุณาระบุประเภทการคลอด');
        }
        else if(!data.bdoctor)
        {
            app.alert('กรุณาระบุประเภทของผู้ทำคลอด');
        }
        else
        {
            //do save
            preg.ajax.labor.save(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
                else
               {
                   app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                   preg.modal.hide_labor();
                   preg.get_list();
               }
            });
        }
    });

    //search diagnosis
    $('#txt_labor_bresult_icdcode').typeahead({
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

            $('#txt_labor_bresult_icdcode').val(code);
            $('#txt_labor_bresult_icdname').val(name);

            return code;
        }
    });

    //search hospital
    $('#txt_labor_hospcode').typeahead({
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
            var code = d[1],
                name = d[0];

            $('#txt_labor_hospcode').val(code);
            $('#txt_labor_hospname').val(name);

            return code;
        }
    });

    //------------------------------------------------------------------------------------------------------------------
    //Anc info
    preg.anc_info = {
        get_detail: function(anc_code)
        {
            preg.ajax.anc.get_info(anc_code, function(err, data){
                if(err)
                {
                    app.alert('ไม่พบข้อมูลการฝากครรภ์');
                }
                else
                {
                    preg.anc_info.set_detail(data);
                }
            });
        },

        set_detail: function(data)
        {
            $('#txt_anc_info_lmp').val(data.rows.lmp);
            $('#txt_anc_info_edc').val(data.rows.edc);
            $('#sl_anc_info_preg_status').val(data.rows.preg_status);
            $('#sl_anc_info_vdrl').val(data.rows.vdrl);
            $('#sl_anc_info_hb').val(data.rows.hb);
            $('#sl_anc_info_hiv').val(data.rows.hiv);
            $('#txt_anc_info_hct_date').val(data.rows.hct_date);
            $('#sl_anc_info_hct').val(data.rows.hct);
            $('#sl_anc_info_thalassemia').val(data.rows.thalassemia);
            //$('#chk_anc_info_do_export').attr('checked') ? '1' : '0';
            data.rows.do_export == '1' ? $('#chk_anc_info_do_export').attr('checked', 'checked') : $('#chk_anc_info_do_export').removeAttr('checked');
            $('#txt_anc_info_export_date').val(data.rows.do_export_date);
        },

        get_history_list: function(hn, gravida)
        {
            preg.ajax.anc.get_history(hn, gravida, function(err, data){
               if(err)
               {
                   app.alert(err);
               }
                else
               {
                   preg.anc_info.set_history_list(data);
               }
            });
        },
        set_history_list: function(data)
        {
            $('#tbl_anc_history > tbody').empty();

            if(data)
            {
                _.each(data.rows, function(v){

                    var res = v.anc_result == '1' ? 'ปกติ' : v.anc_result == '2' ? 'ผิดปกติ' : 'ไม่ทราบ';
                    $('#tbl_anc_history > tbody').append(
                        '<tr>' +
                            '<td>' + app.mongo_to_thai_date(v.date_serv) + '</td>' +
                            '<td>' + app.clear_null(v.owner_name) + '</td>' +
                            //'<td>' + app.clear_null(data.gravida) + '</td>' +
                            '<td>' + app.clear_null(v.anc_no) + '</td>' +
                            '<td>' + app.clear_null(v.ga) + '</td>' +
                            '<td>' + app.clear_null(res) + '</td>' +
                            '<td>' + app.clear_null(v.provider_name) + '</td>' +
                            '</tr>'
                    );
                });
            }
            else
            {
                $('#tbl_anc_history > tbody').append(
                    '<tr>' +
                        '<td colspan="6">ไม่พบรายการ</td>' +
                        '</tr>'
                );
            }
        }
    };

    $(document).on('click', 'a[data-name="anc_info"]', function(){
        var hn = $(this).attr('data-hn'),
            anc_code = $(this).attr('data-anc_code'),
            fullname = $(this).attr('data-fullname'),
            birthdate = $(this).attr('data-birthdate'),
            age = $(this).attr('data-age'),
            gravida = $(this).attr('data-gravida'),
            cid = $(this).attr('data-cid');

        $('#txt_anc_info_hn').val(hn);
        $('#txt_anc_info_cid').val(cid);
        $('#txt_anc_info_fullname').val(fullname);
        $('#txt_anc_info_birthdate').val(birthdate);
        $('#txt_anc_info_age').val(age);
        $('#txt_anc_info_gravida').val(gravida);

        //get anc info
        preg.anc_info.get_detail(anc_code);

        preg.modal.show_anc_info();
    });

    $('#btn_anc_info_save').click(function(){
        var data = {};
        data.hn = $('#txt_anc_info_hn').val();
        data.gravida = $('#txt_anc_info_gravida').val();
        data.lmp = $('#txt_anc_info_lmp').val();
        data.edc = $('#txt_anc_info_edc').val();
        data.preg_status = $('#sl_anc_info_preg_status').val();
        data.vdrl = $('#sl_anc_info_vdrl').val();
        data.hb = $('#sl_anc_info_hb').val();
        data.hiv = $('#sl_anc_info_hiv').val();
        data.hct_date = $('#txt_anc_info_hct_date').val();
        data.hct = $('#sl_anc_info_hct').val();
        data.thalassemia = $('#sl_anc_info_thalassemia').val();
        data.do_export = $('#chk_anc_info_do_export').attr('checked') ? '1' : '0';
        data.do_export_date = $('#txt_anc_info_export_date').val();

        if(!data.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!data.gravida)
        {
            app.alert('กรุณาระบุครรภ์ที่');
        }
        else if(!data.hct_date)
        {
            app.alert('กรุณาระบุวันที่ตรวจ HCT');
        }
        else
        {
            preg.ajax.anc.save_info(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
                else
               {
                   app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                   preg.modal.hide_anc_info();
                   preg.get_list();
               }
            });
        }
    });


    $('a[href="#tab_anc_info2"]').click(function(){
        var hn = $('#txt_anc_info_hn').val(),
            gravida = $('#txt_anc_info_gravida').val();

        preg.anc_info.get_history_list(hn, gravida);
    });

    $('#btn_refresh').on('click', function(){
        preg.get_list();
    })

    preg.get_list();
});