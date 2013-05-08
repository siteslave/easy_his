head.ready(function(){
    var death = {};

    death.modal = {
        show_register: function(){
            $('#mdl_register').modal({
                backdrop: 'static'
            }).css({
                width: 960,
                'margin-left': function() {
                    return -($(this).width() / 2);
                }
            });
        },
        hide_register: function(){
            $('#mdl_register').modal('hide');
        }
    };

    death.ajax = {
        save: function(data, cb){

            var url = 'death/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(id, cb){

            var url = 'death/remove',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(start, stop, cb){
            var url = 'death/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'death/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(hn, cb){
            var url = 'death/get_detail',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        search: function(query, cb){
            var url = 'death/search',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }

    };

    death.get_list = function()
    {
        $('#tbl_list > tbody').empty();

        $('#main_paging').fadeIn('slow');
        death.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        death.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                            }else{
                                death.set_list(data);
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

    death.set_list = function(data)
    {

        $('#tbl_list > tbody').empty();

        if(!data)
        {
            $('#tbl_list > tbody').append('<tr><td colspan="8">ไม่พบข้อมูล</td></td></tr>');
        }
        else
        {
            var i = 1;
            _.each(data.rows, function(v)
            {
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.hn +'</td>' +
                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>'+ app.mongo_to_thai_date(v.birthdate) +'</td>' +
                        '<td>'+ v.age +'</td>' +
                        '<td>'+ v.ddeath +'</td>' +
                        '<td>'+ v.icd_code +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_edit" class="btn" data-hn="'+ v.hn +'" ' +
                        'data-cid="'+ v.cid +'" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-age="'+ v.age +'" data-birthdate="'+ app.mongo_to_thai_date(v.birthdate) +'" data-id="'+ v.id +'">' +
                        '<i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_remove" class="btn" data-id="'+ v.id +'">' +
                        '<i class="icon-trash"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };
    //search diagnosis
    $('#txt_reg_cdeath_name').typeahead({
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

            $('#txt_reg_cdeath_code').val(code);

            return name;
        }
    });
    $('#txt_reg_odisease_name').typeahead({
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

            $('#txt_reg_odisease_code').val(code);

            return name;
        }
    });
    $('#txt_hosp_deathA_name').typeahead({
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

            $('#txt_hosp_deathA_code').val(code);

            return name;
        }
    });
    $('#txt_hosp_deathB_name').typeahead({
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

            $('#txt_hosp_deathB_code').val(code);

            return name;
        }
    });
    $('#txt_hosp_deathC_name').typeahead({
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

            $('#txt_hosp_deathC_code').val(code);

            return name;
        }
    });
    $('#txt_hosp_deathD_name').typeahead({
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

            $('#txt_hosp_deathD_code').val(code);

            return name;
        }
    });
    $('#txt_reg_hn').typeahead({
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
            var code = d[0],
                name = d[1],
                birth = d[2];

            $('#txt_reg_fullname').val(name);
            $('#txt_reg_birthdate').val(app.to_thai_date(birth));
            $('#txt_reg_age').val(app.count_age(birth));

            return code;
        }
    });
    $('#txt_reg_hosp_death_name').typeahead({
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

            $('#txt_reg_hosp_death_code').val(code);
            //$('#txt_reg_service_insc_hosp_main_name').val(name);

            return name;
        }
    });

    $('#btn_register').click(function(){
        death.clear_form();
        death.modal.show_register();
    });

    death.clear_form = function()
    {
        $('#txt_reg_hn').val('');
        $('#txt_reg_fullname').val('');
        $('#txt_reg_birthdate').val('');
        $('#txt_reg_age').val('');
        $('#txt_reg_hosp_death_code').val('');
        $('#txt_reg_hosp_death_name').val('');
        $('#txt_reg_death_date').val('');
        $('#txt_hosp_deathA_code').val('');
        $('#txt_hosp_deathA_name').val('');
        $('#txt_hosp_deathB_code').val('');
        $('#txt_hosp_deathB_name').val('');
        $('#txt_hosp_deathC_code').val('');
        $('#txt_hosp_deathC_name').val('');
        $('#txt_hosp_deathD_code').val('');
        $('#txt_hosp_deathD_name').val('');
        $('#txt_reg_cdeath_code').val('');
        $('#txt_reg_cdeath_name').val('');
        app.set_first_selected($('#sl_reg_pregdeath'));
        app.set_first_selected($('#sl_pdeath'));
        $('#txt_reg_odisease_code').val('');
        $('#txt_reg_odisease_name').val('');
        $('#txt_isupdate').val('0');
        $('#txt_reg_hn').removeAttr('disabled', 'disabled');
    };

    $('#btn_save_death').click(function(){
        var data = {};

        data.hn = $('#txt_reg_hn').val();
        data.hospdeath = $('#txt_reg_hosp_death_code').val();
        data.ddeath = $('#txt_reg_death_date').val();
        data.cdeath_a = $('#txt_hosp_deathA_code').val();
        data.cdeath_b = $('#txt_hosp_deathB_code').val();
        data.cdeath_c = $('#txt_hosp_deathC_code').val();
        data.cdeath_d = $('#txt_hosp_deathD_code').val();
        data.cdeath = $('#txt_reg_cdeath_code').val();
        data.pregdeath = $('#sl_reg_pregdeath').val();
        data.pdeath = $('#sl_pdeath').val();
        data.odisease = $('#txt_reg_odisease_code').val();

        data.isupdate = $('#txt_isupdate').val();


        if(!data.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!data.cdeath)
        {
            app.alert('กรุณาระบุสาเหตุการเสียชีวิต');
        }
        else if(!data.ddeath)
        {
            app.alert('กรุณาระบุวันที่เสียชีวิต');
        }
        else if(!data.pdeath)
        {
            app.alert('กรุณาระบุสถานที่เสียชีวิต');
        }
        else if(!data.pregdeath)
        {
            app.alert('กรุณาระบุภาวะการตั้งครรภ์');
        }
        else
        {
            death.ajax.save(data, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    death.modal.hide_register();
                    death.get_list();
                }
            });
        }
    });


    death.get_detail = function(hn)
    {
        death.ajax.get_detail(hn, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
               //set data
               death.set_detail(data.rows);
           }
        });
    };

    death.set_detail = function(data)
    {
        $('#txt_reg_hosp_death_code').val(data.hospdeath);
        $('#txt_reg_hosp_death_name').val(data.hospdeath_name);
        $('#txt_reg_death_date').val(data.ddeath);
        $('#txt_hosp_deathA_code').val(data.cdeath_a);
        $('#txt_hosp_deathA_name').val(data.cdeath_a_name);
        $('#txt_hosp_deathB_code').val(data.cdeath_b);
        $('#txt_hosp_deathB_name').val(data.cdeath_b_name);
        $('#txt_hosp_deathC_code').val(data.cdeath_c);
        $('#txt_hosp_deathC_name').val(data.cdeath_c_name);
        $('#txt_hosp_deathD_code').val(data.cdeath_d);
        $('#txt_hosp_deathD_name').val(data.cdeath_d_name);
        $('#txt_reg_cdeath_code').val(data.cdeath);
        $('#txt_reg_cdeath_name').val(data.cdeath_name);
        $('#sl_reg_pregdeath').val(data.pregdeath);
        $('#sl_pdeath').val(data.pdeath);
        $('#txt_reg_odisease_code').val(data.odisease);
        $('#txt_reg_odisease_name').val(data.odisease_name);

        $('#txt_isupdate').val('1');

    };

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var hn = $(this).attr('data-hn'),
            fullname = $(this).attr('data-fullname'),
            age = $(this).attr('data-age'),
            birthdate = $(this).attr('data-birthdate');

        $('#txt_reg_hn').attr('disabled', 'disabled').css('background-color', 'white');;
        $('#txt_reg_fullname').val(fullname);
        $('#txt_reg_hn').val(hn);
        $('#txt_reg_age').val(age);
        $('#txt_reg_birthdate').val(birthdate);
        //get disability detail
        death.get_detail(hn);
        death.modal.show_register();
    });

    /**
     * Remove
     */
    $(document).on('click', 'a[data-name="btn_remove"]', function(){
        var id = $(this).attr('data-id');

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
           if(res)
           {
               death.ajax.remove(id, function(err){
                   if(err)
                   {
                       app.alert(err);
                   }
                   else
                   {
                       app.alert('ลบข้อมูลเสร็จเรียบร้อยแล้ว');
                       death.get_list();
                   }
               });
           }
        });

    });

    $('#mdl_register').on('hidden', function(){
        death.clear_form();
    });

    //search
    $('#btn_search').on('click', function(){
        var query = $('#txt_query').val();

        $('#main_paging').fadeOut('slow');

        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา โดยระบุชื่อ-สกุล หรือ เลขบัตรประชาชน หรือ HN');
        }
        else
        {
            $('#tbl_list > tbody').empty();

            death.ajax.search(query, function(err, data){
                if(err)
                {
                    app.alert(err);
                    $('#tbl_list > tbody').append('<tr><td colspan="9">ไม่พบข้อมูล</td></td></tr>');
                }
                else
                {
                    death.set_list(data);
                }
            });
        }

    });

    //search diagnosis
    $('#txt_query').typeahead({
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
            var code = d[0];

            return code;
        }
    });
    death.get_list();
});