head.ready(function(){
    //namespace
    var women = {};

    women.ajax = {
        get_list: function(year, start, stop, cb){

            var url = 'women/get_list',
                params = {
                    year: year,
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_list_total: function(year, cb){

            var url = 'women/get_list_total',
                params = {
                    year: year
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        save: function(data, cb){

            var url = 'women/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        clear: function(data, cb){

            var url = 'women/clear',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_detail: function(year, hn, cb){

            var url = 'women/get_detail',
                params = {
                    year: year,
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search_filter: function(items, start, stop, cb){

            var url = 'women/search_filter',
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

            var url = 'women/search',
                params = {
                    query: query,
                    year: year
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search_filter_total: function(items, cb){

            var url = 'women/search_filter_total',
                params = {
                    year: items.year,
                    village_id: items.village_id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    women.modal = {
        show_screen: function(){
            $('#mdl_screen').modal({
                backdrop: 'static'
            });
        },
        hide_screen: function(){
            $('#mdl_screen').modal('hide');
        }
    };

    women.get_list = function()
    {
        var year = $('#sl_year').val();

        $('#tbl_list > tbody').empty();

        $('#main_paging').fadeIn('slow');

        women.ajax.get_list_total(year, function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('womer_paging'),
                    onSelect: function(page){
                        app.set_cookie('womer_paging', page);

                        women.ajax.get_list(year, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                            }else{
                                women.set_list(data);
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
    women.search_filter = function(items)
    {

        $('#tbl_list > tbody').empty();

        $('#main_paging').fadeIn('slow');
        women.ajax.search_filter_total(items, function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('womer_filter_paging'),
                    onSelect: function(page){
                        app.set_cookie('womer_filter_paging', page);

                        women.ajax.search_filter(items, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                            }else{
                                women.set_list(data);
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

    women.set_list = function(data)
    {

        var year = $('#sl_year').val();

        $('#tbl_list > tbody').empty();

        if(!data)
        {
            $('#tbl_list > tbody').append('<tr><td colspan="9">ไม่พบข้อมูล</td></td></tr>');
        }
        else
        {
            $(data.rows).each(function(i, v)
            {
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.hn +'</td>' +
                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>'+ app.mongo_to_thai_date(v.birthdate) +'</td>' +
                        '<td>'+ v.age +'</td>' +
                        '<td>'+ v.mstatus +'</td>' +
                        '<td>'+ v.numberson +'</td>' +
                        '<td>'+ v.fptype_name +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_screen" class="btn btn-success btn-small" ' +
                        'data-hn="'+ v.hn + '" data-cid="'+ v.cid +'" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-age="'+ v.age +'" data-birthdate="'+ app.mongo_to_thai_date(v.birthdate) +'" data-year="'+ year +'">' +
                        '<i class="fa fa-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_clear" class="btn btn-danger btn-small" ' +
                        'data-hn="'+ v.hn +'" data-year="'+ year +'">' +
                        '<i class="fa fa-trash-o"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };

    $(document).on('click', 'a[data-name="btn_screen"]', function(){
        var fullname = $(this).data('fullname'),
            hn = $(this).data('hn'),
            cid = $(this).data('cid'),
            age = $(this).data('age'),
            birthdate = $(this).data('birthdate'),
            year = $(this).data('year');

        women.clear_form();

        $('#txt_fullname').val(fullname);
        $('#txt_hn').val(hn);
        $('#txt_cid').val(cid);
        $('#txt_birthdate').val(birthdate);
        $('#txt_age').val(age);

        //get detail
        women.ajax.get_detail(year, hn, function(err, data){
            if(!err)
            {
                if(data.rows)
                {
                    //set detail
                    women.set_detail(data);
                }

            }
        });

        women.modal.show_screen();
    });

    women.set_detail = function(data)
    {
        $('#sl_fptype').val(data.rows.fptype);
        $('#sl_nofpcause').val(data.rows.nofpcause);
        $('#txt_totalson').val(data.rows.totalson);
        $('#txt_numberson').val(data.rows.numberson);
        $('#txt_abortion').val(data.rows.abortion);
        $('#txt_stillbirth').val(data.rows.stillbirth);
    };

    women.clear_form = function()
    {
        app.set_first_selected($('#sl_fptype'));
        app.set_first_selected($('#sl_nofpcause'));
        $('#txt_totalson').val('');
        $('#txt_numberson').val('');
        $('#txt_abortion').val('');
        $('#txt_stillbirth').val('');
    };

    //save
    $('#btn_save').on('click', function(){
        var items = {};

        items.hn = $('#txt_hn').val();
//        items.cid = $('#txt_cid').val();
        items.fptype = $('#sl_fptype').select2('val');
        items.nofpcause = $('#sl_nofpcause').select2('val');
        items.totalson = $('#txt_totalson').val();
        items.numberson = $('#txt_numberson').val();
        items.abortion = $('#txt_abortion').val();
        items.stillbirth = $('#txt_stillbirth').val();

        items.year = $('#sl_year').val();

        if(!items.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!items.fptype)
        {
            app.alert('กรุณาระบุวิธีการคุมกำเนิดในปัจจุบัน');
        }
        else
        {
            women.ajax.save(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    women.get_list();

                    women.modal.hide_screen();
                    //clear form
                    women.clear_form();
                }
            });
        }

    });

    //clear
    $(document).on('click', 'a[data-name="btn_clear"]', function(){
        var items   = {};
        items.year  = $(this).data('year');
        items.hn    = $(this).data('hn');

        app.confirm('คุณต้องการลบรายการสำรวจ ใช่หรือไม่?', function(res){
            if(res)
            {
                women.ajax.clear(items, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ยกเลิกรายการเสร็จเรียบร้อย');
                        women.get_list();
                    }
                });
            }
        });
    });

    $('#btn_do_get_list').on('click', function(){
        var items = {};
        items.year = $('#sl_year').val(),
        items.village_id = $('#sl_village').val();

        if(!items.village_id)
        {
            app.alert('กรุณาเลือกหมู่บ้านที่ต้องการ');
        }
        else
        {
            women.search_filter(items);
        }

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

    $('#btn_refresh').on('click', function(){
        women.get_list();
    });

    $('#btn_do_search').on('click', function(){

        var data = $('#txt_query').select2('data');

        var year = $('#sl_year').val();

        $('#main_paging').fadeOut('slow');

        if(data === null)
        {
            app.alert('กรุณาระบุคำค้นหา');
        }
        else
        {
            women.ajax.search(data.hn, year, function(err, data){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    women.set_list(data);
                }
            });
        }
    });

    women.get_list();

});