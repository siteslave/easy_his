head.ready(function(){
    //namespace
    var income = {};

    income.ajax = {
        get_list: function(start, stop, cb){

            var url = 'incomes/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_filter_list: function(income, start, stop, cb){

            var url = 'incomes/get_filter_list',
                params = {
                    income: income,
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_list_total: function( cb){

            var url = 'incomes/get_list_total',
                params = {  };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_filter_total: function(inc, cb){

            var url = 'incomes/get_filter_total',
                params = { income: inc };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        save: function(data, cb){

            var url = 'incomes/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        remove: function(id, cb){

            var url = 'incomes/remove',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search: function(query, cb){

            var url = 'incomes/search',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    income.modal = {
        show_register: function(){
            $('#modal_new_item').modal({
                backdrop: 'static'
            });
        },
        hide_register: function(){
            $('#modal_new_item').modal('hide');
        }
    };

    $('#btn_new').on('click', function(){
        income.clear_form();
       income.modal.show_register();
    });

    income.clear_form = function()
    {
        $('#txt_reg_name').val('');
        $('#txt_reg_price').val('');
        $('#txt_reg_cost').val('');
        $('#txt_reg_qty').val('');
        $('#txt_id').val('');
    };

    $('#btn_save').on('click', function(){
       var items = {};

        items.price = $('#txt_reg_price').val();
        items.id = $('#txt_id').val();
        items.qty = $('#txt_reg_qty').val();

       if(!items.price)
        {
            app.alert('กรุณาระบุราคา');
        }
        else if(!items.qty)
        {
            app.alert('กรุณาระบุจำนวนคงเหลือ');
        }
        else
        {
            //save
            income.ajax.save(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    income.modal.hide_register();
                    income.clear_form();
                    income.get_list();
                }
            });
        }
    });


    income.get_list = function()
    {

        $('#tbl_list > tbody').empty();

        $('#main_paging').fadeIn('slow');

        income.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_list > tbody').append('<tr><td colspan="7">ไม่พบข้อมูล</td></td></tr>');
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('income_index_paging'),
                    onSelect: function(page){
                        app.set_cookie('income_index_paging', page);

                        income.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append('<tr><td colspan="7">ไม่พบข้อมูล</td></td></tr>');
                            }else{
                                income.set_list(data);
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

    income.do_filter = function(inc)
    {

        $('#tbl_list > tbody').empty();

        $('#main_paging').fadeIn('slow');

        income.ajax.get_filter_total(inc, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_list > tbody').append('<tr><td colspan="7">ไม่พบข้อมูล</td></td></tr>');
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('income_index_filter_paging'),
                    onSelect: function(page){
                        app.set_cookie('income_index_filter_paging', page);

                        income.ajax.get_filter_list(inc, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append('<tr><td colspan="7">ไม่พบข้อมูล</td></td></tr>');
                            }else{
                                income.set_list(data);
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

    income.set_list = function(data)
    {
        $('#tbl_list > tbody').empty();

        if(!data.rows)
        {
            $('#tbl_list > tbody').append('<tr><td colspan="7">ไม่พบข้อมูล</td></td></tr>');
        }
        else
        {
            _.each(data.rows, function(v)
            {

                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ app.strip(v.name, 60) +'</td>' +
                        '<td>'+ app.strip(v.income_name, 40) +'</td>' +
                        '<td>'+ app.add_commars(v.cost) +'</td>' +
                        '<td>'+ app.add_commars(v.price) +'</td>' +
                        '<td>'+ v.unit +'</td>' +
                        '<td>'+ app.add_commars_with_out_decimal(v.qty) +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_edit" class="btn btn-success btn-small" data-id="'+ v.id +'" title="แก้ไขข้อมูล" ' +
                        'data-vname="'+ v.name +'" data-price="'+ v.price +'" data-qty="'+ v.qty +'" data-cost="'+ v.cost +'" data-price="'+ v.price +'">' +
                        '<i class="icon-edit"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var id = $(this).data('id'),
            name = $(this).data('vname'),
            price = $(this).data('price'),
            cost = $(this).data('cost'),
            qty = $(this).data('qty');

        $('#txt_reg_name').val(name);
        $('#txt_reg_price').val(price);
        $('#txt_reg_cost').val(cost);
        $('#txt_reg_qty').val(qty);
        $('#txt_id').val(id);

        income.modal.show_register();

    });

    $('#btn_refresh').on('click', function(){
        income.get_list();
    });

    $('#btn_filter').on('click', function(){
        var inc = $('#sl_incomes').val();
        if(!inc)
        {
            income.get_list();
        }
        else
        {
            income.do_filter(inc);
        }
    });

    $('#btn_search').on('click', function(){
        var query = $('#txt_query').val();
        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา');
        }
        else
        {
            $('#main_paging').fadeOut('slow');

            income.ajax.search(query, function(err, data){
                if(err)
                {
                    $('#tbl_list > tbody').empty();
                    $('#tbl_list > tbody').append('<tr><td colspan="8">ไม่พบข้อมูล</td></td></tr>');
                }
                else
                {
                    income.set_list(data);
                }
            });
        }
    });

    income.get_list();
});