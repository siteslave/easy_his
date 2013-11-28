//namespace
var surveil = {};

head.ready(function(){

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

        clear: function(data, cb){

            var url = 'surveil/clear',
                params = {
                    data: data
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
    };

    surveil.modal = {
        show_entry: function(hn, vn, diag){
            app.load_page($('#mdl_surveillance_entry'), '/pages/surveillance/' + hn + '/' + vn + '/' + diag, 'assets/apps/js/pages/surveillance.js');
            $('#mdl_surveillance_entry').modal({keyboard: false});
        },
        hide_entry: function(){
            $('#mdl_surveillance_entry').modal('hide');
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
                $('#tbl_list > tbody').append('<tr><td colspan="7">ไม่พบข้อมูล</td></td></tr>');
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('sur_current_page'),
                    onSelect: function(page){
                        app.set_cookie('sur_current_page', page)
                        surveil.ajax.get_list(visit_date, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append('<tr><td colspan="7">ไม่พบข้อมูล</td></td></tr>');
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

        if(_.size(data.rows) == 0)
        {
            $('#tbl_list > tbody').append('<tr><td colspan="7">ไม่พบข้อมูล</td></td></tr>');
        }
        else
        {
            _.each(data.rows, function(v)
            {
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.date_serv +'</td>' +
                        '<td>'+ v.hn +'</td>' +
//                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>[<strong>'+ v.diag_code + '</strong>] ' + app.strip(v.diag_name, 40) +'</td>' +
                        '<td>'+ app.strip(v.code506, 30) +'</td>' +
                        '<td>'+ v.ptstatus +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_entry" class="btn btn-default" data-hn="'+ v.hn +'" data-vn="'+ v.vn +'" ' +
                        'data-diag="'+ v.diag_code +'">' +
                        '<i class="fa fa-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_clear" class="btn btn-danger" data-vn="'+ v.vn +'" ' +
                        'data-hn="'+ v.hn +'" data-diag="'+ v.diag_code +'">' +
                        '<i class="fa fa-trash-o"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };

    $(document).on('click', 'a[data-name="btn_entry"]', function(e){
        var hn = $(this).data('hn'),
            vn = $(this).data('vn'),
            diag = $(this).data('diag');

        surveil.modal.show_entry(hn, vn, diag);
    });

    $('#btn_get_list').on('click', function(){
        surveil.get_list();
    });

    $('#btn_surveil_resresh').on('click', function(){
        surveil.get_list();
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

    surveil.get_list();

});