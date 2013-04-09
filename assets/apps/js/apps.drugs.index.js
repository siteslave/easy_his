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
                        '<td>'+ app.add_commars(v.unit_cost) +'</td>' +
                        '<td>'+ app.add_commars(v.unit_price) +'</td>' +
                        '<td>'+ app.add_commars(v.qty) +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_edit" class="btn" data-id="'+ v.id +'">' +
                        '<i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_remove" class="btn" data-id="'+ v.id +'">' +
                        '<i class="icon-trash"></i></a>' +
                        '</div></td>' +
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
        $('#txt_reg_strength_value').val('');
        app.set_first_selected($('#sl_reg_strength_unit'));
        app.set_first_selected($('#sl_reg_unit'));
        $('#txt_reg_unit_cost').val('');
        $('#txt_reg_unit_price').val('');
        $('#txt_reg_qty').val('');

        $('#txt_id').val('');
        $('#txt_isupdate').val('0');

    };

    $('#btn_save').click(function(){
        var data = {};

        data.did = $('#txt_reg_did').val();
        data.name = $('#txt_reg_name').val();
        data.strength = $('#txt_reg_strength_value').val();
        data.strength_unit = $('#sl_reg_strength_unit').val();
        data.unit = $('#sl_reg_unit').val();
        data.unit_cost = $('#txt_reg_unit_cost').val();
        data.unit_price = $('#txt_reg_unit_price').val();
        data.qty = $('#txt_reg_qty').val();

        data.id = $('#txt_id').val();
        data.isupdate = $('#txt_isupdate').val();

        if(!data.did)
        {
            app.alert('กรุณาระบุ รหัสมาตรฐาน');
        }
        else if(!data.name)
        {
            app.alert('กรุณาระบุชื่อ');
        }
        else if(!data.strength)
        {
            app.alert('กรุณาระบุค่าความแรง');
        }
        else if(!data.strength_unit)
        {
            app.alert('กรุณาระบุหน่วยความแรง');
        }
        else if(!data.unit)
        {
            app.alert('กรุณาระบุหน่วย');
        }
        else if(!data.unit_cost)
        {
            app.alert('กรุณาระบุราคาทุน');
        }
        else if(!data.unit_price)
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

        $('#txt_reg_did').val(data.did);
        $('#txt_reg_name').val(data.name);
        $('#txt_reg_strength_value').val(data.strength);
        $('#sl_reg_strength_unit').val(data.strength_unit);
        $('#sl_reg_unit').val(data.unit);
        $('#txt_reg_unit_cost').val(data.unit_cost);
        $('#txt_reg_unit_price').val(data.unit_price);
        $('#txt_reg_qty').val(data.qty);

        $('#txt_isupdate').val('1');
        $('#txt_id').val(data.id);
    };

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var id = $(this).data('id');
        drugs.get_detail(id);
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

    drugs.get_list();
});