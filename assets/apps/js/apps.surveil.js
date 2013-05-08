head.ready(function(){
    //namespace
    var surveil = {};

    surveil.ajax = {
        get_list: function(visit_date, start, stop, cb){

            var url = 'surveil/get_list',
                params = {
                    visit_date: visit_date,
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_list_total: function(visit_date, cb){

            var url = 'surveil/get_list_total',
                params = {
                    visit_date: visit_date
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        save: function(data, cb){

            var url = 'surveil/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        clear: function(data, cb){

            var url = 'surveil/clear',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_detail: function(hn, vn, diagcode, cb){

            var url = 'surveil/get_detail',
                params = {
                    hn: hn,
                    vn: vn,
                    diagcode: diagcode
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search_filter: function(items, start, stop, cb){

            var url = 'surveil/search_filter',
                params = {
                    year: items.year,
                    village_id: items.village_id,
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search: function(query, year, cb){

            var url = 'surveil/search',
                params = {
                    query: query,
                    year: year
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search_filter_total: function(items, cb){

            var url = 'surveil/search_filter_total',
                params = {
                    year: items.year,
                    village_id: items.village_id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
        ,get_ampur: function(chw, cb){

            var url = 'basic/get_ampur',
                params = {
                    chw: chw
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        },
        /**
         * Get tambon list
         *
         * @param chw   Changwat code
         * @param amp   Ampur code
         * @param cb    Callback function
         */
        get_tambon: function(chw, amp, cb){

            var url = 'basic/get_tambon',
                params = {
                    chw: chw,
                    amp: amp
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        },
        get_organism: function(code, cb){

            var url = 'surveil/get_organism',
                params = {
                    code: code
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        }
    };

    surveil.modal = {
        show_entry: function(){
            $('#mdl_entry').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_entry: function(){
            $('#mdl_entry').modal('hide');
        }
    };

    surveil.get_list = function()
    {
        var visit_date = $('#txt_query_date').val();

        $('#tbl_list > tbody').empty();

        $('#main_paging').fadeIn('slow');

        surveil.ajax.get_list_total(visit_date, function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        surveil.ajax.get_list(visit_date, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                            }else{
                                surveil.set_list(data);
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


    surveil.set_list = function(data)
    {

        $('#tbl_list > tbody').empty();

        if(!data)
        {
            $('#tbl_list > tbody').append('<tr><td colspan="8">ไม่พบข้อมูล</td></td></tr>');
        }
        else
        {
            _.each(data.rows, function(v)
            {
                var diag_name = v.diag_name.length > 30 ? v.diag_name.substr(0, 30) + '...' : v.diag_name;
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.date_serv +'</td>' +
                        '<td>'+ v.hn +'</td>' +
                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>[<strong>'+ v.diag_code + '</strong>] ' + diag_name +'...</td>' +
                        '<td>'+ v.code506 +'</td>' +
                        '<td>'+ v.ptstatus +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_entry" class="btn" data-hn="'+ v.hn +'" ' +
                        'data-cid="'+ v.cid +'" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-age="'+ v.age +'" data-birthdate="'+ app.mongo_to_thai_date(v.birthdate) +'" ' +
                        'data-diag_code="'+ v.diag_code +'" data-vn="'+ v.vn +'" data-diag_name="'+ v.diag_name +'">' +
                        '<i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_clear" class="btn" data-vn="'+ v.vn +'" ' +
                        'data-hn="'+ v.hn +'" data-diag="'+ v.diag_code +'">' +
                        '<i class="icon-trash"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };

    $(document).on('click', 'a[data-name="btn_entry"]', function(e){
        var hn = $(this).data('hn'),
            cid = $(this).data('cid'),
            vn = $(this).data('vn'),
            fullname = $(this).data('fullname'),
            age = $(this).data('age'),
            birthdate = $(this).data('birthdate'),
            diag_code = $(this).data('diag_code'),
            diag_name = $(this).data('diag_name');

        $('#txt_hn').val(hn);
        $('#txt_cid').val(cid);
        $('#txt_fullname').val(fullname);
        $('#txt_birthdate').val(birthdate);
        $('#txt_age').val(age);
        $('#txt_vn').val(vn);
        $('#txt_diag_code').val(diag_code);
        $('#txt_diag_name').val(diag_name);

        surveil.ajax.get_detail(hn, vn, diag_code, function(err, data){
            if(err)
            {
                app.alert(err);
            }
            else
            {
                surveil.set_detail(data.rows);
                surveil.modal.show_entry();
            }
        });


    });


    surveil.clear_form = function()
    {
        $('#txt_hn').val('');
        $('#txt_cid').val('');
        $('#txt_fullname').val('');
        $('#txt_birthdate').val('');
        $('#txt_age').val('');
        $('#txt_vn').val('');
        $('#txt_diag_code').val('');
        $('#txt_diag_name').val('');

        app.set_first_selected($('#sl_506'));
        $('#txt_illdate').val('');
        $('#txt_address').val('');
        $('#txt_moo').val('');
        app.set_first_selected($('#sl_tambon'));
        app.set_first_selected($('#sl_ampur'));
        app.set_first_selected($('#sl_province'));
        $('#txt_latitude').val();
        $('#txt_longitude').val();
        app.set_first_selected($('#sl_ptstatus'));
        $('#txt_date_death').val();
        app.set_first_selected($('#sl_complication'));
        app.set_first_selected($('#sl_organism'));
        app.set_first_selected($('#sl_syndrome'));

        $('#txt_school_class').val('');
        $('#txt_school_name').val('');
    };

    surveil.set_detail = function(data)
    {

        surveil.set_ampur(data.illchangwat, data.illampur);
        surveil.set_tambon(data.illchangwat, data.illampur, data.illtambon);

        $('#sl_506').val(data.code506)
        $('#txt_illdate').val(app.mongo_to_js_date(data.illdate));
        $('#txt_address').val(data.illhouse);
        $('#txt_moo').val(data.illvillage);
        //$('#sl_tambon').val(data.illtambon);
        //$('#sl_ampur').val(data.illampur);
        $('#sl_province').val(data.illchangwat);
        $('#txt_latitude').val(data.latitude);
        $('#txt_longitude').val(data.longitude);
        $('#sl_ptstatus').val(data.ptstatus);
        $('#txt_date_death').val(app.mongo_to_js_date(data.date_death));
        $('#sl_complication').val(data.complication);
        $('#sl_organism').val(data.organism);
        $('#sl_syndrome').val(data.syndrome);

        $('#txt_school_class').val(data.school_class);
        $('#txt_school_name').val(data.school_name);
    };

    $('#btn_get_list').on('click', function(){
        surveil.get_list();
    });
    //save
    $('#btn_save').on('click', function(){
        var items = {};

        items.hn = $('#txt_hn').val();
        items.vn = $('#txt_vn').val();

        items.syndrome = $('#sl_syndrome').val();
        items.diagcode = $('#txt_diag_code').val();
        items.code506 = $('#sl_506').val();
        items.illdate = $('#txt_illdate').val();
        items.illhouse = $('#txt_address').val();
        items.illvillage = $('#txt_moo').val();
        items.illtambon = $('#sl_tambon').val();
        items.illampur = $('#sl_ampur').val();
        items.illchangwat = $('#sl_province').val();
        items.latitude = $('#txt_latitude').val();
        items.longitude = $('#txt_longitude').val();
        items.ptstatus = $('#sl_ptstatus').val();
        items.date_death = $('#txt_date_death').val();
        items.complication = $('#sl_complication').val();
        items.organism = $('#sl_organism').val();

        items.school_class = $('#txt_school_class').val();
        items.school_name = $('#txt_school_name').val();

        if(!items.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!items.diagcode)
        {
            app.alert('กรุณาระบุรหัสการวินิจฉัย');
        }
        else if(!items.code506)
        {
            app.alert('กรุณาระบุรหัส 506');
        }
        else
        {
            surveil.ajax.save(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    surveil.get_list();

                    surveil.modal.hide_entry();
                    //clear form
                    surveil.clear_form();
                    surveil.get_list();
                }
            });
        }

    });

    //clear
    $(document).on('click', 'a[data-name="btn_clear"]', function(){
        var items = {};
        items.diag = $(this).data('diag');
        items.hn = $(this).data('hn');
        items.vn = $(this).data('vn');

        app.confirm('คุณต้องการลบรายการ ใช่หรือไม่?', function(res){
            if(res)
            {
                surveil.ajax.clear(items, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        surveil.get_list();
                    }
                });
            }
        });
    });

    $('#sl_province').on('change', function(){
        var chw = $(this).val();
        surveil.set_ampur(chw, null);

    });

    surveil.set_ampur = function(chw, ampur)
    {
        surveil.ajax.get_ampur(chw, function(err, data){
            $('#sl_ampur').empty();
            $('#sl_tambon').empty();

            $('#sl_ampur').append('<option value="00">--</option>');
            _.each(data.rows, function(v){
                if(v.code == ampur)
                {
                    if(!v.name.match(/\*/))
                        $('#sl_ampur').append('<option value="'+ v.code +'" selected="selected">'+ v.name +'</option>');
                }
                else
                {
                    if(!v.name.match(/\*/))
                        $('#sl_ampur').append('<option value="'+ v.code +'">'+ v.name +'</option>');
                }
            });
        });
    };

    $('#sl_ampur').on('change', function(){
        var chw = $('#sl_province').val(),
            amp = $(this).val();

        surveil.set_tambon(chw, amp, null);

    });

    surveil.set_tambon = function(chw, amp, tambon)
    {
        //load ampur list
        surveil.ajax.get_tambon(chw, amp, function(err, data){
            $('#sl_tambon').empty();
            $('#sl_tambon').append('<option value="00">--</option>');
            _.each(data.rows, function(v)
            {
                if(v.code == tambon)
                {
                    if(!v.name.match(/\*/))
                        $('#sl_tambon').append('<option value="'+ v.code +'" selected="selected">'+ v.name +'</option>');
                }
                else
                {
                    if(!v.name.match(/\*/))
                        $('#sl_tambon').append('<option value="'+ v.code +'">'+ v.name +'</option>');
                }
            });
        });
    };

    $('#sl_506').on('change', function(){
        var code = $(this).val();
        surveil.ajax.get_organism(code, function(err, data){
            $('#sl_organism').empty();
            $('#sl_organism').append('<option value="0000">--</option>');
            _.each(data.rows, function(v){
                if(!v.name.match(/\*/))
                    $('#sl_organism').append('<option value="'+ v.code +'">'+ v.name +'</option>');
            });
        });
    });

    surveil.get_list();

});