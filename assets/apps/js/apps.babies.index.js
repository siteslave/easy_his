/**
 * Babies scripts
 *
 * @author      Mr.Satit Riapit <mr.satit@outlook.com>
 * @copyright   Copyright 2013, Mr.Satit Rianpit
 * @since       Version 1.0
 */
head.ready(function(){
    // Babies name space with object.
    var babies = {};

    //------------------------------------------------------------------------------------------------------------------
    //ajax object
    babies.ajax = {
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
            var url = 'babies/search',
                params = {
                    hn: hn
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(start, stop, cb){
            var url = 'babies/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'babies/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        do_register: function(hn, cb){
            var url = 'babies/do_register',
                params = {
                    hn: hn
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        save_babies_detail: function(data, cb){
            var url = 'babies/save_babies_detail',
                params = {
                    data: data
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        check_registration: function(hn, cb){
            var url = 'babies/check_registration',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        get_labor_detail: function(hn, gravida, cb){
            var url = 'babies/get_labor_detail',
                params = {
                    hn: hn,
                    gravida: gravida
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_babies_detail: function(hn, cb){
            var url = 'babies/get_babies_detail',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_mother_detail: function(hn, cb){
            var url = 'babies/get_mother_detail',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_gravida: function(hn, cb){
            var url = 'pregnancies/get_gravida',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        save_mother_detail: function(data, cb){
            var url = 'babies/save_mother',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        get_list_by_village: function(village_id, cb){
            var url = 'babies/get_list_by_village',
                params = {
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    babies.set_gravida_select = function(data)
    {
        $('#sl_labor_gravida').empty();
        $('#sl_labor_gravida').append('<option value="">- ระบุ -</option>');
        _.each(data.rows, function(v){
            $('#sl_labor_gravida').append(
                '<option value="'+ v.gravida +'">' + v.gravida + '</option>'
            );
        });

    };
    /**
     * Modal object
     *
     */
    babies.modal = {
        show_register: function()
        {
            $('#mdl_register').modal({
                backdrop: 'static'
            });
        },
        hide_register: function()
        {
            $('#mdl_register').modal('hide');
        },
        show_labor: function()
        {
            $('#mdl_labor').modal({
                backdrop: 'static'
            });
        },
        hide_labor: function()
        {
            $('#mdl_labor').modal('hide');
        },
        show_ppcare: function(hn, vn)
        {
            app.load_page($('#mdl_babies_care'), '/pages/babies_care/' + hn + '/' + vn, 'assets/apps/js/pages/babies_care.js');
            $('#mdl_babies_care').modal({keyboard: false});
        },
        show_nutrition: function(hn){
            app.load_page($('#mdl_nutri'), '/pages/nutrition/' + hn, 'assets/apps/js/pages/nutrition.js');
            $('#mdl_nutri').modal({keyboard: false});
        }
    };

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Set list
     *
     * @param data
     */
    babies.set_list = function(data){
        $('#tbl_list > tbody').empty();
        if(_.size(data.rows) > 0){
            _.each(data.rows, function(v){
                var mother_fullname = v.mother_detail ? v.mother_detail.first_name + ' ' + v.mother_detail.last_name : '',
                    mother_hn = v.mother_detail ? v.mother_detail.hn : '';

                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>' + v.hn + '</td>' +
                        '<td>' + app.clear_null(v.cid) + '</td>' +
                        '<td>' + v.first_name +' '+ v.last_name + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.birthdate) + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.reg_date) + '</td>' +
                        '<td>' + app.clear_null(v.gravida) +'</td>' +
                        '<td>' + app.clear_null(mother_hn) +'</td>' +
                        '<td>' + app.clear_null(mother_fullname) +'</td>' +
                        '<td>' +
                        '<div class="btn-group dropup">' +
                        '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">' +
                        '<i class="fa fa-th-list"></i> <span class="caret"></span>' +
                        '</button>' +
                        '<ul class="dropdown-menu pull-right">' +
                        '<li>' +
                        '<a href="javascript:void(0);" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-birthdate="'+app.mongo_to_thai_date(v.birthdate)+'" data-age="'+ v.age +'" data-hn="'+ v.hn+'" ' +
                        'data-anc_code="'+ v.anc_code+'" data-name="labor" data-hn="' + v.hn + '" ' +
                        'data-cid="' + v.cid +'" data-gravida="'+ v.gravida +'" data-mother_hn="'+ mother_hn +'" ' +
                        'title="ข้อมูลการคลอด"><i class="fa fa-check-circle"></i> ข้อมูลการคลอด</a>' +
                        '</li>' +
                        '<li>' +
                        '<a href="javascript:void(0);" data-hn="'+ v.hn+'" ' +
                        'data-name="ppcare" data-hn="' + v.hn + '" ' +
                        'title="ข้อมูลหลังคลอด"><i class="fa fa-times-circle"></i> ดูแลหลังคลอด</a>' +
                        '</li>' +'<li>' +
                        '<a href="javascript:void(0);" data-name="btn_babies_nutrition" data-hn="' + v.hn + '" ' +
                        'title="โภชนาการและพัฒนาการ"><i class="fa fa-bar-chart-o"></i> พัฒนาการ</a>' +
                        '</li>' +
                        '</ul>' +
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

    $(document).on('click', 'a[data-name="btn_babies_nutrition"]', function(){
        var hn = $(this).data('hn');

        babies.modal.show_nutrition(hn);
    });

    /**
     * Get list by village
     */
    babies.get_list_by_village = function()
    {

        $('#tbl_list > tbody').empty();

        $('#main_paging').fadeOut('slow');
        var village_id = $('#sl_village').select2('val');

        if(!village_id)
        {
            babies.get_list();
        }
        else
        {
            babies.ajax.get_list_by_village(village_id, function(err, data){
                if(err)
                {
                    app.alert('ไม่พบรายการ');
                    $('#tbl_list > tbody').append(
                        '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
                    );
                }
                else
                {
                    babies.set_list(data);
                }
            });
        }
    };

    /**
     * Do get list filter by village id
     */
    $('#btn_do_get_list').on('click', function(e){
        babies.get_list_by_village();
        e.preventDefault();
    });

    /**
     * Set list
     */
    babies.get_list = function(){
        $('#main_paging').fadeIn('slow');
        $('#tbl_list > tbody').empty();
        babies.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_list > tbody').append(
                    '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
                );
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        babies.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                            }else{
                                babies.set_list(data);
                            }
                        });

                    },
                    onFormat: app.paging_format
                });
            }
        });
    };

    $('#btn_register').click(function(){
        babies.modal.show_register();
    });


    $('#mdl_labor').on('hidden', function(){
        babies.get_list();
    });

    $('#btn_do_register_babies').on('click', function(){

        var person = $('#txt_search_query').select2('data');

        var hn = person.hn;

        if(_.contains(['1', '3'], person.typearea))
        {
            if(confirm('คุณต้องการลงทะเบียนข้อมูลนี้ใช่หรือไม่?'))
            {
                //do register
                babies.ajax.do_register(hn, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลงทะเบียนรายการเสร็จเรียบร้อยแล้ว');
                        babies.modal.hide_register();
                        babies.get_list();
                    }
                });
            }
        }
        else
        {
            app.alert('บุคคลนี้ไม่ใช่บุคคลในเขตรับผิดชอบ [T=' + person.typearea + ']');
        }
    });

    babies.labor = {
        get_detail: function(hn, gravida)
        {
            babies.ajax.get_labor_detail(hn, gravida, function(err, data){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    babies.labor.set_detail(data);
                }
            });
        },

        set_detail: function(data)
        {
            $('#txt_labor_bdate').val(data.rows.bdate);
            $('#txt_labor_bresult_icdcode').val(data.rows.bresult_code);
            $('#txt_labor_bresult_icdname').val(data.rows.bresult_name);
            $('#sl_labor_bplace').select2('val', data.rows.bplace);
            $('#txt_labor_hospcode').val(data.rows.bhosp);
            $('#txt_labor_hospname').val(data.rows.bhosp_name);
            $('#sl_labor_btype').select2('val', data.rows.btype);
            $('#sl_labor_bdoctor').select2('val', data.rows.bdoctor);
            $('#txt_labor_gravida').val(data.rows.gravida);
            $('#sl_labor_gravida').select2('val', data.rows.gravida);
            $('#txt_labor_btime').val(data.rows.btime);
        },

        clear_form: function()
        {
            $('#txt_labor_bdate').val('');
            $('#txt_labor_bresult_icdcode').val('');
            $('#txt_labor_bresult_icdname').val('');
            $('#sl_labor_bplace').select2('val', '');
            $('#txt_labor_hospcode').val('');
            $('#txt_labor_hospname').val('');
            $('#sl_labor_btype').select2('val', '');
            $('#sl_labor_bdoctor').select2('val', '');
            $('#txt_labor_gravida').val('');
            $('#txt_labor_btime').val('');
            $('#txt_labor_mother_hn').val('');
            $('#txt_labor_mother_name').val('');
            $('#sl_labor_birthno').select2('val', '');
            $('#txt_labor_bweight').val('');
            $('#sl_labor_asphyxia').select2('val', '');
            $('#sl_labor_vitk').select2('val', '');
            $('#sl_labor_tsh').select2('val', '');
            $('#txt_labor_tshresult').val('');
        }
    };
    //labor detail
    $(document).on('click', 'a[data-name="labor"]', function(e){
        var hn          = $(this).data('hn'),
            fullname    = $(this).data('fullname'),
            birthdate   = $(this).data('birthdate'),
            age         = $(this).data('age'),
            cid         = $(this).data('cid'),
            gravida     = $(this).data('gravida'),
            mother_hn   = $(this).data('mother_hn');

        $('#txt_labor_hn').val(hn);
        $('#txt_labor_cid').val(cid);
        $('#txt_labor_fullname').val(fullname);
        $('#txt_labor_birthdate').val(birthdate);
        $('#txt_labor_age').val(age);

        babies.labor.clear_form();

        //get detail
        babies.get_gravida(mother_hn);
        babies.get_mother_detail(mother_hn);
        babies.labor.get_detail(mother_hn, gravida);

        $('a[href="#tab_labor_1"]').tab('show');

        babies.modal.show_labor();

        e.preventDefault();
    });

    babies.get_mother_detail = function(hn)
    {
        babies.ajax.get_mother_detail(hn, function(err, data){
            if(!err)
            {
                var fullname = data.rows.first_name + ' ' + data.rows.last_name;
                $('#txt_labor_mother_name').select2('data', { hn: data.rows.hn, fullname: fullname });
            }
        });
    };

    babies.get_gravida = function(hn)
    {
        babies.ajax.get_gravida(hn, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
               if(data)
               {
                   babies.set_gravida_select(data);
               }
           }
        });
    };

    babies.get_babies_detail = function(hn)
    {
        babies.ajax.get_babies_detail(hn, function(err, data){
           if(err)
           {
               app.alert(err);
           }
           else
           {
                babies.set_babies_detail(data);
           }
        });
    };

    babies.set_babies_detail = function(data)
    {
        $('#sl_labor_birthno').select2('val', data.rows.birthno);
        $('#txt_labor_bweight').val(data.rows.bweight);
        $('#sl_labor_asphyxia').select2('val', data.rows.asphyxia);
        $('#sl_labor_vitk').select2('val', data.rows.vitk);
        $('#sl_labor_tsh').select2('val', data.rows.tsh);
        $('#txt_labor_tshresult').val(data.rows.tshresult);
    };

    $('#txt_labor_mother_name').select2({
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

    $('#txt_query_babies').select2({
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

    $('#txt_labor_mother_name').on('click', function() {
        var person = $(this).select2('data');
        babies.get_gravida(person.hn);
    });


    $('#sl_labor_gravida').on('change', function(){
        var data = {};
        var mother = $('#txt_labor_mother_name').select2('data');

        data.hn_baby = $('#txt_labor_hn').val();
        data.hn_mother = mother.hn;
        data.gravida = $(this).val();

        babies.labor.get_detail(data.hn_mother, data.gravida);

    });

    //save mother data
    $('#btn_labor_do_mother_save').click(function(){
        var data = {};
        var mother = $('#txt_labor_mother_name').select2('data');

        data.baby_hn = $('#txt_labor_hn').val();
        data.mother_hn = mother === null ? '' : mother.hn;
        data.gravida = $('#sl_labor_gravida').val();

        if(!data.baby_hn)
        {
            app.alert('กรุณาระบุ HN ของเด็ก');
        }
        else if(!data.mother_hn)
        {
            app.alert('กรุณาระบุ HN มารดา');
        }
        else if(!data.gravida)
        {
            app.alert('กรุณาระบุครรภ์ที่คลอด');
        }
        else
        {
            babies.ajax.save_mother_detail(data ,function(err){
               if(err)
               {
                   app.alert(err);
               }
               else
               {
                    app.alert('บันทึกข้อมูลมารดาเสร็จเรียบร้อยแล้ว');
               }
            });
        }
    });

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save babies detail
     */
    $('#btn_labor_save_babies').click(function(){
        var data = {};
        var mother = $('#txt_labor_mother_name').select2('data');

        data.birthno = $('#sl_labor_birthno').val();
        data.bweight = $('#txt_labor_bweight').val();
        data.asphyxia = $('#sl_labor_asphyxia').val();
        data.vitk = $('#sl_labor_vitk').val();
        data.tsh = $('#sl_labor_tsh').val();
        data.tshresult = $('#txt_labor_tshresult').val();
        data.mother_hn = mother === null ? '' : mother.hn;
        data.gravida = $('#sl_labor_gravida').val();

        data.hn = $('#txt_labor_hn').val();

        if(!data.hn)
        {
            app.alert('กรุณาระบุ HN ของเด็ก');
        }
        else if(!data.mother_hn)
        {
            app.alert('กรุณาระบุข้อมูลมารดา');
        }
        else if(!data.gravida)
        {
            app.alert('กรุณาระบุข้อมูลครรภ์ที่');
        }
        else if(!data.birthno)
        {
            app.alert('กรุณาระบุลำที่ของการคลอด');
        }
        else if(!data.bweight)
        {
            app.alert('กรุณาระบุน้ำหนักคลอด (หน่วยเป็นกรัม)');
        }
        else if(!data.asphyxia)
        {
            app.alert('กรุณาระบุภาวะขาดออกซิเจน');
        }
        else if(!data.vitk)
        {
            app.alert('กรุณาระบุการให้วิตามิน K');
        }
        else if(!data.tsh)
        {
            app.alert('กรุณาระบุการตรวจ TSH');
        }
        else if(!data.tshresult)
        {
            app.alert('กรุณาระบุผลการตรวจ TSH');
        }
        else
        {
            babies.ajax.save_babies_detail(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
               else
               {
                   app.alert('การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                   //babies.modal.hide_labor();
               }
            });
        }
    });

    $('a[href="#tab_labor_2"]').click(function(){
        var hn = $('#txt_labor_hn').val();

        babies.get_babies_detail(hn);
    });


    $(document).on('click', 'a[data-name="ppcare"]', function(e){
        var hn = $(this).data('hn');
        babies.modal.show_ppcare(hn, '');
        e.preventDefault();
    });

    $('#btn_refresh').on('click', function(e){
        babies.get_list();
        e.preventDefault();
    })

    /**
     * Search babies
     */
    $('#btn_do_search_babies').on('click', function(e){
        var query = $('#txt_query_babies').select2('data');
        if(!query.hn)
        {
            app.alert('กรุณาระบุ HN เพื่อค้นหา');
        }
        else
        {
            $('#main_paging').fadeOut('slow');
            $('#tbl_list > tbody').empty();
            babies.ajax.search(query.hn, function(err, data){
                if(err)
                {
                    app.alert(err);
                    $('#tbl_list > tbody').append(
                        '<tr><td colspan="10">ไม่พบรายการ</td></tr>'
                    );
                }
                else
                {
                    babies.set_list(data);
                }
            });
        }

        e.preventDefault();
    });

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

    //Load list on page loaded.
    babies.get_list();
});