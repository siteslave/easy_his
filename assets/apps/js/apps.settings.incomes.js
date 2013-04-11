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

            var url = 'incomes/save_item',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        remove: function(id, cb){

            var url = 'incomes/remove_item',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search: function(query, cb){

            var url = 'incomes/search_item',
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
            }).css({
                    width: 760,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
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
        $('#is_update').val('0');
        $('#txt_reg_name').val('');
        app.set_first_selected($('#sl_reg_income'));
        $('#txt_reg_price').val('');
        $('#txt_reg_cost').val('');
        $('#txt_reg_unit').val('');
        $('#txt_id').val('');
        $('#chk_active').attr('checked', 'checked');
    };

    $('#btn_save').on('click', function(){
       var items = {};

        items.is_update = $('#is_update').val();
        items.name = $('#txt_reg_name').val();
        items.income = $('#sl_reg_income').val();
        items.price = $('#txt_reg_price').val();
        items.cost = $('#txt_reg_cost').val();
        items.unit = $('#txt_reg_unit').val();
        items.id = $('#txt_id').val();
        items.active = $('#chk_active').is(':checked') ? 'Y' : 'N';

        if(!items.name)
        {
            app.alert('กรุณาระบุรายการ');
        }
        else if(!items.income)
        {
            app.alert('กรุณาระบุกลุ่มค่าใช้จ่าย');
        }
        else if(!items.price)
        {
            app.alert('กรุณาระบุราคา');
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
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        income.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append('<tr><td colspan="5">ไม่พบข้อมูล</td></td></tr>');
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
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        income.ajax.get_filter_list(inc, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append('<tr><td colspan="5">ไม่พบข้อมูล</td></td></tr>');
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
                var status = v.active == 'Y' ? '<i class="icon-ok"></i>' : '<i class="icon-minus"></i>';

                var name = v.name.length > 60 ? v.name.substr(0, 60) + '...' : v.name;
                var income_name = v.income_name.length > 60 ? v.income_name.substr(0, 40) + '...' : v.income_name;

                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.code +'</td>' +
                        '<td>'+ name +'</td>' +
                        '<td>'+ income_name +'</td>' +
                        '<td>'+ app.add_commars(v.cost) +'</td>' +
                        '<td>'+ app.add_commars(v.price) +'</td>' +
                        '<td>'+ v.unit +'</td>' +
                        '<td>'+ status +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_edit" class="btn" data-id="'+ v.id +'" ' +
                        'data-vname="'+ v.name +'" data-income="'+ v.income + '" data-price="'+ v.price +'" ' +
                        'data-cost="'+ v.cost +'" data-active="'+ v.active +'" data-unit="'+ v.unit +'">' +
                        '<i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_remove" class="btn" data-id="'+ v.id +'">' +
                        '<i class="icon-trash"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var id = $(this).data('id'),
            name = $(this).data('vname'),
            inc = $(this).data('income'),
            price = $(this).data('price'),
            cost = $(this).data('cost'),
            unit = $(this).data('unit'),
            active = $(this).data('active');

        $('#is_update').val('1');
        $('#txt_reg_name').val(name);
        $('#sl_reg_income').val(inc);
        $('#txt_reg_price').val(price);
        $('#txt_reg_cost').val(cost);
        $('#txt_reg_unit').val(unit);
        $('#txt_id').val(id);

        if(active == 'Y')
        {
            $('#chk_active').attr('checked', 'checked');
        }
        else
        {
            $('#chk_active').removeAttr('checked');
        }

        income.modal.show_register();

    });

    $(document).on('click', 'a[data-name="btn_remove"]', function(){
        var id = $(this).data('id');
        var obj = $(this).parent().parent().parent();

        if(confirm('คุณต้องการจะลบรายการนี้ใช่หรือไม่'))
        {
            income.ajax.remove(id, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                    obj.fadeOut('slow');
                }
            });

        }
    });


    $('#btn_refresh').on('click', function(){
        income.get_list();
    });

    $('#btn_filter').on('click', function(){
        var inc = $('#sl_incomes').val();
        if(!inc)
        {
            app.alert('กรุณาระบุกลุ่มค่าใช้จ่าย');
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
                    $('#tbl_list > tbody').append('<tr><td colspan="7">ไม่พบข้อมูล</td></td></tr>');
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