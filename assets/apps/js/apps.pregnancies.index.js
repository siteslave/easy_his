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
        search: function(hn, cb){
            var url = 'pregnancies/search',
                params = {
                    hn: hn
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
            });
        },
        show_labor: function()
        {
            $('#mdl_labor').modal({
                backdrop: 'static'
            });
        },
        show_anc_info: function()
        {
            $('#mdl_anc_info').modal({
                backdrop: 'static'
            });
        },
        show_service_anc: function(hn)
        {
            app.load_page($('#mdl_anc'), '/pages/service_anc/' + hn , 'assets/apps/js/pages/service_anc.js');
            $('#mdl_anc').modal({keyboard: false});
        },
        show_mother_care: function(hn, vn)
        {
            app.load_page($('#mdl_postnatal'), '/pages/postnatal/' + hn + '/' + vn , 'assets/apps/js/pages/postnatal.js');
            $('#mdl_postnatal').modal({keyboard: false});
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
                        '<div class="btn-group dropup">' +
                        '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">' +
                        '<i class="fa fa-th-list"></i> <span class="caret"></span>' +
                        '</button>' +
                        '<ul class="dropdown-menu pull-right">' +
                        '<li>' +
                        '<a href="javascript:void(0);" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-birthdate="'+app.mongo_to_thai_date(v.birthdate)+'" data-age="'+ v.age+'" data-hn="'+ v.hn+'" ' +
                        'data-anc_code="'+ v.anc_code+'" data-gravida="'+ v.gravida +'" data-name="labor" data-hn="' + v.hn + '" ' +
                        'data-cid="' + v.cid +'"><i class="fa fa-check-circle"></i> ข้อมูลการคลอด</a>' +
                        '</li>' +
                        '<li>' +
                        '<a href="javascript:void(0);" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-birthdate="'+app.mongo_to_thai_date(v.birthdate)+'" data-age="'+ v.age+'" data-hn="'+ v.hn+'" ' +
                        'data-anc_code="'+ v.anc_code+'" data-gravida="'+ v.gravida +'" data-name="anc_info" data-hn="' + v.hn + '" ' +
                        'data-cid="' + v.cid +'"><i class="fa fa-th-list"></i> ข้อมูลการฝากครรภ์</a>' +
                        '</li>' +
                        '<li>' +
                        '<a href="javascript:void(0);" data-name="btn_service_anc" data-hn="'+ v.hn +'"><i class="fa fa-calendar"></i> ฝากครรภ์ (จากที่อื่น)</a>' +
                        '</li>' +
                        '<li>' +
                        '<a href="javascript:void(0);" data-name="btn_mother_care" data-hn="'+ v.hn +'"><i class="fa fa-user-md"></i> เยี่ยมหลังคลอด</a>' +
                        '</li>' +
                        '</ul>' +
                        '</div>' +
                        '</td>' +
                        '</tr>'
                );

                $('[rel="tooltip"]').tooltip();
            });
        }else{
            $('#tbl_list > tbody').append(
                '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
            );
        }
    };

    $(document).on('click', 'a[data-name="btn_mother_care"]', function(e){
        var hn = $(this).data('hn');

        preg.modal.show_mother_care(hn, '');

        e.preventDefault();
    });

    $(document).on('click', 'a[data-name="btn_service_anc"]', function(e){
        var hn = $(this).data('hn');

        preg.modal.show_service_anc(hn);

        e.preventDefault();
    });

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
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('preg_paging'),
                    onSelect: function(page){
                        app.set_cookie('preg_paging', page);

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
                        '<td><a href="#" class="btn btn-success" data-hn="'+ v.hn + '" data-sex="'+ v.sex +'" ' +
                        'data-name="btn_selected_person" data-typearea="'+ v.typearea +'">' +
                        '<i class="fa fa-comments-o"></i></a></td>' +
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


    $('#btn_do_register').on('click', function(){

        var person = $('#txt_search_query').select2('data');

        if(person.sex == "1")
        {
            app.alert('บุคคลนี้เป็นเพศชาย ไม่สามารถลงทะเบียนได้');
        }
        else if(person.typearea == "1" || person.typearea == "3")
        {
            var gravida = prompt('กรุณาระบุครรภ์ที่', 1);

            if(gravida || gravida > 0)
            {
                var data = {};
                data.hn = person.hn;
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
        else
        {
            app.alert('บุคคลนี้ไม่ใช่บุคคลในเขตรับผิดชอบ');
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
            $('#sl_labor_bdoctor').select2('val', data.rows[0].bdoctor);
            $('#txt_labor_lborn').val(data.rows[0].lborn);
            $('#txt_labor_sborn').val(data.rows[0].sborn);
            $('#sl_labor_bplace').select2('val', data.rows[0].bplace);
            $('#sl_labor_btype').select2('val', data.rows[0].btype);

            $('#txt_labor_bresult_icdname').select2('data', {code: data.rows[0].icd_code, name: data.rows[0].icd_name});

            $('#txt_labor_hospname').select2('data', {code: data.rows[0].bhosp, name: data.rows[0].bhosp_name});
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
        var hospital = $('#txt_labor_hospname').select2('data');
        var diag = $('#txt_labor_bresult_icdname').select2('data');

        data.hn = $('#txt_labor_hn').val();
        data.gravida = $('#txt_labor_gravida').val();
        //data.lmp = $('#txt_labor_lmp').val();
        //data.edc = $('#txt_labor_edc').val();
        data.bdate = $('#txt_labor_bdate').val();
        data.btime = $('#txt_labor_btime').val();
        data.bresult = diag.code;
        data.bplace = $('#sl_labor_bplace').val();
        data.bhosp = hospital.code;
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
        else if(!hospital.code)
        {
            app.alert('กรุณาระบุรหัสสถานพบาลที่ทำคลอด');
        }
        else if(!diag.code)
        {
            app.alert('กรุณาระบุรหัสการวินิจฉัยโรค');
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

    $('#txt_labor_bresult_icdname').select2({
        placeholder: 'รหัส หรือ ชื่อการวินิจฉัยโรค',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_icd_ajax",
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

    $('#txt_labor_hospname').select2({
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
                            '<td>' + app.clear_null(v.date_serv) + '</td>' +
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

    /**
     * Do search pregnancies
     */

    $('#btn_do_search_preg').on('click', function(e){
        var hn = $('#txt_query_preg').val();
        if(!hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else
        {
            $('#main_paging').fadeOut('slow');
            $('#tbl_list > tbody').empty();
            preg.ajax.search(hn, function(err, data){
                if(err)
                {
                    app.alert(err);
                    $('#tbl_list > tbody').append(
                        '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
                    );
                }
                else
                {
                    preg.set_list(data);
                }
            });
        }
    });


    //search person
    $('#txt_search_query').select2({
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

    preg.get_list();
});