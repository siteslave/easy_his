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
        save_cover: function(data, cb){
            var url = 'babies/save_cover',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_ppcare_history: function(hn, cb){
            var url = 'babies/get_ppcare_history',
                params = {
                    hn: hn
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
            }).css({
                    width: 780,
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
        show_ppcare: function()
        {
            $('#mdl_ppcare').modal({
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
            $('#mdl_register').modal('hide');
        },
        hide_labor: function()
        {
            $('#mdl_labor').modal('hide');
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
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0);" class="btn" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-birthdate="'+app.mongo_to_thai_date(v.birthdate)+'" data-age="'+ v.age +'" data-hn="'+ v.hn+'" ' +
                        'data-anc_code="'+ v.anc_code+'" data-name="labor" data-hn="' + v.hn + '" ' +
                        'data-cid="' + v.cid +'" data-gravida="'+ v.gravida +'" data-mother_hn="'+ mother_hn +'" ' +
                        'title="ข้อมูลการคลอด"><i class="icon-check"></i></a>' +
                        '<a href="javascript:void(0);" class="btn" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-birthdate="'+app.mongo_to_thai_date(v.birthdate)+'" data-age="'+ v.age +'" data-hn="'+ v.hn+'" ' +
                        'data-anc_code="'+ v.anc_code+'" data-name="ppcare" data-hn="' + v.hn + '" ' +
                        'data-cid="' + v.cid +'" data-gravida="'+ v.gravida +'" data-mother_hn="'+ mother_hn +'" ' +
                        'title="ข้อมูลหลังคลอด"><i class="icon-time"></i></a>' +
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
    /**
     * Get list by village
     */
    babies.get_list_by_village = function()
    {

        $('#tbl_list > tbody').empty();

        $('#main_paging').fadeOut('slow');
        var village_id = $('#sl_village').val();
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
                $('#main_paging > ul').paging(data.total, {
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
        babies.modal.show_register();
    });


    $('#mdl_labor').on('hidden', function(){
        babies.get_list();
    });

    babies.set_search_person_result = function(data)
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

            babies.ajax.search_person(query, filter, function(err, data){

                if(err)
                {
                    app.alert(err);
                    $('#tbl_search_person_result > tbody').append(
                        '<tr><td colspan="7">ไม่พบรายการ</td></tr>');
                }
                else
                {
                    babies.set_search_person_result(data);
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

        var hn = $(this).data('hn');

        if( ! _.indexOf(['1', '3'], $(this).data('typearea')) || !$(this).data('typearea'))
        {
            app.alert('บุคคลนี้ไม่ใช่บุคคลในเขตรับผิดชอบ');
        }
        else
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
            $('#sl_labor_bplace').val(data.rows.bplace);
            $('#txt_labor_hospcode').val(data.rows.bhosp);
            $('#txt_labor_hospname').val(data.rows.bhosp_name);
            $('#sl_labor_btype').val(data.rows.btype);
            $('#sl_labor_bdoctor').val(data.rows.bdoctor);
            $('#txt_labor_gravida').val(data.rows.gravida);
            $('#sl_labor_gravida').val(data.rows.gravida);
            $('#txt_labor_btime').val(data.rows.btime);
        },
        set_mother_detail: function(data)
        {
            $('#txt_labor_mother_hn').val(data.hn);
            $('#txt_labor_mother_hn').val(data.first_name + ' ' + data.last_name);
        },
        clear_form: function()
        {
            $('#txt_labor_bdate').val('');
            $('#txt_labor_bresult_icdcode').val('');
            $('#txt_labor_bresult_icdname').val('');
            app.set_first_selected($('#sl_labor_bplace'));
            $('#txt_labor_hospcode').val('');
            $('#txt_labor_hospname').val('');
            app.set_first_selected($('#sl_labor_btype'));
            app.set_first_selected($('#sl_labor_bdoctor'));
            $('#txt_labor_gravida').val('');
            $('#txt_labor_btime').val('');
            $('#txt_labor_mother_hn').val('');
            $('#txt_labor_mother_name').val('');
            app.set_first_selected($('#sl_labor_birthno'));
            $('#txt_labor_bweight').val('');
            app.set_first_selected($('#sl_labor_asphyxia'));
            app.set_first_selected($('#sl_labor_vitk'));
            app.set_first_selected($('#sl_labor_tsh'));
            $('#txt_labor_tshresult').val('');
        }
    };
    //labor detail
    $(document).on('click', 'a[data-name="labor"]', function(e){
        var hn = $(this).data('hn'),
            fullname = $(this).data('fullname'),
            birthdate = $(this).data('birthdate'),
            age = $(this).data('age'),
            cid = $(this).data('cid'),
            gravida = $(this).data('gravida'),
            mother_hn = $(this).data('mother_hn');

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
                $('#txt_labor_mother_hn').val(data.rows.hn);
                $('#txt_labor_mother_name').val(data.rows.first_name + ' ' + data.rows.last_name);
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
        $('#sl_labor_birthno').val(data.rows.birthno);
        $('#txt_labor_bweight').val(data.rows.bweight);
        $('#sl_labor_asphyxia').val(data.rows.asphyxia);
        $('#sl_labor_vitk').val(data.rows.vitk);
        $('#sl_labor_tsh').val(data.rows.tsh);
        $('#txt_labor_tshresult').val(data.rows.tshresult);
    };

    $('#txt_labor_mother_name').typeahead({
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

            $('#txt_labor_mother_hn').val(hn);
            $('#txt_labor_mother_name').val(name);

            babies.get_gravida(hn);

            return name;
        }
    });

    $('#sl_labor_gravida').on('change', function(){
        var data = {};
        data.hn_baby = $('#txt_labor_hn').val();
        data.hn_mother = $('#txt_labor_mother_hn').val();
        data.gravida = $(this).val();

        babies.labor.get_detail(data.hn_mother, data.gravida);

    });

    //save mother data
    $('#btn_labor_do_mother_save').click(function(){
        var data = {};

        data.baby_hn = $('#txt_labor_hn').val();
        data.mother_hn = $('#txt_labor_mother_hn').val();
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
        data.birthno = $('#sl_labor_birthno').val();
        data.bweight = $('#txt_labor_bweight').val();
        data.asphyxia = $('#sl_labor_asphyxia').val();
        data.vitk = $('#sl_labor_vitk').val();
        data.tsh = $('#sl_labor_tsh').val();
        data.tshresult = $('#txt_labor_tshresult').val();
        data.mother_hn = $('#txt_labor_mother_hn').val();
        data.gravida = $('#sl_labor_gravida').val();

        data.hn = $('#txt_labor_hn').val();

        if(!data.hn)
        {
            app.alert('กรุณาระบุ HN ของเด็ก');
        }else if(!data.mother_hn)
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
               }
            });
        }
    });

    $('a[href="#tab_labor_2"]').click(function(){
        var hn = $('#txt_labor_hn').val();

        babies.get_babies_detail(hn);
    });


    $(document).on('click', 'a[data-name="ppcare"]', function(e){

        babies.clear_cover_form();

        var hn = $(this).data('hn'),
            fullname = $(this).data('fullname'),
            birthdate = $(this).data('birthdate'),
            age = $(this).data('age'),
            cid = $(this).data('cid'),
            gravida = $(this).data('gravida'),
            mother_hn = $(this).data('mother_hn'),
            gravida = $(this).data('gravida');

        $('#txt_ppcare_hn').val(hn);
        $('#txt_ppcare_cid').val(cid);
        $('#txt_ppcare_fullname').val(fullname);
        $('#txt_ppcare_birthdate').val(birthdate);
        $('#txt_ppcare_age').val(age);
        $('#txt_ppcare_gravida').val(gravida);

        babies.modal.show_ppcare();
        e.preventDefault();
    });

    babies.clear_cover_form = function()
    {
        $('#txt_ppcare_bcare').val('');
        $('#txt_ppcare_hospcode').val('');
        $('#txt_ppcare_hospname').val('');
        app.set_first_selected($('#sl_ppcare_bcareresult'));
        app.set_first_selected($('#sl_ppcare_food'));
        app.set_first_selected($('#sl_ppcare_providers'));
    };
    //save cover
    $('#btn_ppcare_save').on('click', function(e){
        var items = {};
        items.hn = $('#txt_ppcare_hn').val();
        items.gravida = $('#txt_ppcare_gravida').val();
        items.bcare = $('#txt_ppcare_bcare').val();
        items.bcplace = $('#txt_ppcare_hospcode').val();
        items.bcareresult = $('#sl_ppcare_bcareresult').val();
        items.food = $('#sl_ppcare_food').val();
        items.provider_id = $('#sl_ppcare_providers').val();

        if(!items.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!items.bcare)
        {
            app.alert('กรุณาระบุวันที่ให้บริการ');
        }
        else if(!items.bcplace)
        {
            app.alert('กรุณาระบุสถานที่ให้บริการ');
        }
        else if(!items.provider_id)
        {
            app.alert('กรุณาระบุชื่อผู้ให้บริการ');
        }
        else
        {
            babies.ajax.save_cover(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    babies.clear_cover_form();
                }
            });
        }
        e.preventDefault();
    });

    $('#txt_ppcare_hospname').typeahead({
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

            $('#txt_ppcare_hospcode').val(code);
            $('#txt_ppcare_hospname').val(name);

            return name;
        }
    });

    $('a[href="#tab_ppcare2"]').on('click', function(e){

        var hn = $('#txt_ppcare_hn').val();
        babies.ajax.get_ppcare_history(hn, function(err, data){
            if(err)
            {
                app.alert(err);
                $('#tbl_ppcare_history > tbody').append('<tr><td colspan="6">ไม่พบรายการ</td></tr>');
            }
            else
            {
                $('#tbl_ppcare_history > tbody').empty();
                if(_.size(data.rows))
                {
                    _.each(data.rows, function(v){
                        $('#tbl_ppcare_history tbody').append(
                            '<tr>' +
                                '<td>'+ v.bcare +'</td>' +
                                '<td>'+ v.bcplace +'</td>' +
                                '<td>'+ v.bcareresult +'</td>' +
                                '<td>'+ v.food +'</td>' +
                                '<td>'+ v.provider_name +'</td>' +
                                '<td></td>' +
                                '</tr>'
                        );
                    });
                }
                else
                {
                    $('#tbl_ppcare_history > tbody').append('<tr><td colspan="6">ไม่พบรายการ</td></tr>');
                }
            }
        });
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
        var hn = $('#txt_query_babies').val();
        if(!hn)
        {
            app.alert('กรุณาระบุ HN เพื่อค้นหา');
        }
        else
        {
            $('#main_paging').fadeOut('slow');
            $('#tbl_list > tbody').empty();
            babies.ajax.search(hn, function(err, data){
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

    //Load list on page loaded.
    babies.get_list();
});