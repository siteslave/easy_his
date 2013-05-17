head.ready(function(){
    var drugs = {};

    drugs.modal = {
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

    drugs.ajax = {
        save: function(data, cb){

            var url = 'drugs/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(start, stop, cb){
            var url = 'drugs/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'drugs/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        search: function(query, start, stop, cb){
            var url = 'drugs/search',
                params = {
                    query: query,
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        search_total: function(query, cb){
            var url = 'drugs/search_total',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(id, cb){
            var url = 'drugs/detail',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        remove: function(id, cb){
            var url = 'drugs/remove',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    drugs.get_list = function()
    {
        $('#main_paging').fadeIn('slow');

        drugs.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        drugs.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_list > tbody').empty();
                            if(err){
                                app.alert(err);
                            }else{
                                drugs.set_list(data);
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

    drugs.search = function(query)
    {
        $('#main_paging').fadeIn('slow');

        drugs.ajax.search_total(query, function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        drugs.ajax.search(query, this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_list > tbody').empty();
                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append('<tr><td colspan="8">ไม่พบข้อมูล</td></td></tr>');
                            }else{
                                drugs.set_list(data);
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

    drugs.set_list = function(data)
    {

        $('#tbl_list > tbody').empty();

        if(!data.rows)
        {
            $('#tbl_list > tbody').append('<tr><td colspan="8">ไม่พบข้อมูล</td></td></tr>');
        }
        else
        {
            _.each(data.rows, function(v)
            {
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.did +'</td>' +
                        '<td>'+ v.name +'</td>' +
                        '<td>'+ v.strength + ' ' + v.strength_unit +'</td>' +
                        '<td>'+ v.unit_name +'</td>' +
                        '<td>'+ app.add_commars(v.cost) +'</td>' +
                        '<td>'+ app.add_commars(v.price) +'</td>' +
                        '<td>'+ app.add_commars(v.qty) +'</td>' +
                        '<td>' +
                        '<a href="javascript:void(0);" data-name="btn_edit" class="btn" data-id="'+ v.id +'" ' +
                        'data-vname="'+ v.name +'" data-did="'+ v.did +'" data-cost="'+ v.cost +'" data-price="'+ v.price +'" ' +
                        'data-qty="'+ v.qty +'">' +
                        '<i class="icon-edit"></i></a>' +
                        '</td>' +
                        '</tr>'
                );
            });
        }
    };

    $('#btn_register').click(function(){
        drugs.clear_form();
        drugs.modal.show_register();
    });

    drugs.clear_form = function()
    {
        $('#txt_reg_did').val('');
        $('#txt_reg_name').val('');
        $('#txt_reg_unit_cost').val('');
        $('#txt_reg_unit_price').val('');
        $('#txt_reg_qty').val('');

        $('#txt_id').val('');
    };

    $('#btn_save').click(function(){
        var data = {};

        data.price = $('#txt_reg_unit_price').val();
        data.qty = $('#txt_reg_qty').val();

        data.id = $('#txt_id').val();

        if(!data.price)
        {
            app.alert('กรุณาระบุราคาขาย');
        }
        else if(!data.qty)
        {
            app.alert('กรุณาระบุจำนวนคงเหลือ');
        }
        else
        {
            drugs.ajax.save(data, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    drugs.modal.hide_register();
                    drugs.clear_form();
                    drugs.get_list();
                }
            });
        }
    });

    drugs.get_detail = function(id)
    {
        drugs.ajax.get_detail(id, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
               //set data
               drugs.set_detail(data);
           }
        });
    };

    drugs.set_detail = function(v)
    {
        var data = v.rows;

        $('#txt_reg_unit_price').val(data.price);
        $('#txt_reg_qty').val(data.qty);
    };

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var id = $(this).data('id'),
            name = $(this).data('vname'),
            did = $(this).data('did'),
            cost = $(this).data('cost'),
            price = $(this).data('price'),
            qty = $(this).data('qty');

        $('#txt_id').val(id);
        $('#txt_reg_unit_cost').val(cost);
        $('#txt_reg_did').val(did);
        $('#txt_reg_name').val(name);
        $('#txt_reg_unit_price').val(price);
        $('#txt_reg_qty').val(qty);

        drugs.modal.show_register();
    });

    /**
     * Remove
     */
    $(document).on('click', 'a[data-name="btn_remove"]', function(){
        var id = $(this).data('id');

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
           if(res)
           {
               drugs.ajax.remove(id, function(err){
                   if(err)
                   {
                       app.alert(err);
                   }
                   else
                   {
                       app.alert('ลบข้อมูลเสร็จเรียบร้อยแล้ว');
                       drugs.get_list();
                   }
               });
           }
        });

    });

    //search
    $('#btn_search').on('click', function(){
        var query = $('#txt_query').val();
        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา');
        }
        else
        {
            drugs.search(query);
        }
    })

    $('#btn_refresh').on('click', function(){
        drugs.get_list();
    })

    drugs.get_list();
});