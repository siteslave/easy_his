
head.ready(function(){
    var charge = {};
    charge.vn = $('#vn').val();

    charge.modal = {
        show_new: function(){
            $('#mdl_charge_new').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_new: function(){
            $('#mdl_charge_new').modal('hide');
        }
    };

    //ajax
    charge.ajax = {
        save_charge: function(data, cb){

            var url = 'services/save_charge_opd',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search_charge: function(query, cb){

            var url = 'basic/search_charge',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(vn, cb){

            var url = 'services/get_charge_list',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove_charge: function(id, cb){

            var url = 'services/remove_charge_opd',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search_usage: function(query, cb){

            var url = 'basic/search_charge_usage',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };


    charge.get_list = function(){
        charge.ajax.get_list(charge.vn, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_charge_list > tbody').empty();
                $('#tbl_charge_list > tbody').append(
                    '<tr><td colspan="6">ไม่พบรายการ</td></tr>'
                );
            }else{
                charge.set_list(data);
            }

        });
    };
    //set charge list
    charge.set_list = function(data){
        $('#tbl_charge_list > tbody').empty();

        _.each(data.rows, function(v){
            var total = v.price * v.qty;

            $('#tbl_charge_list > tbody').append(
                '<tr>' +
                    '<td>' + v.code + '</td>' +
                    '<td>' + v.name + '</td>' +
                    '<td>' + app.add_commars(v.price) + '</td>' +
                    '<td>' + app.add_commars(v.qty) + '</td>' +
                    '<td>' + app.add_commars(total) + '</td>' +
                    '<td>' +
                    '<div class="btn-group">' +
                    '<a href="javascript:void(0);" class="btn" title="แก้ไขรายการ" ' +
                    'data-name="btn_charge_edit" data-id="'+ v.id +'" data-charge_code="'+ v.code +'" data-charge_name="'+ v.name+'" ' +
                    'data-price="' + v.price + '" data-qty="'+ v.qty +'"><i class="icon-edit"></i></a>' +
                    '<a href="javascript:void(0);" data-name="btn_charge_remove" class="btn" title="ลบรายการ" data-id="'+ v.id +'"><i class="icon-remove"></i></a>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
            );
        });
    };

    $('#btn_charge_new').click(function(){
        charge.clear_form();
        charge.modal.show_new();
    });

    $('#btn_charge_show_search').click(function(){
        charge.modal.hide_new();
        //$('#mdl_charge_new').modal('hide');
        charge.modal.show_search_charge();
    });

    $('#mdl_charge_search').on('hidden', function(){
        charge.modal.show_new();
    });

    $(document).on('click', 'a[data-name="btn_selected_charge"]', function(){
        var id = $(this).attr('data-id'),
            name = $(this).attr('data-vname'),
            price = $(this).attr('data-price');

        $('#txt_charge_id').val(id);
        $('#txt_charge_name').val(name);
        $('#txt_charge_price').val(app.add_commars(price));

        charge.modal.hide_search_charge();
    });

    //show search usage
    $('#btn_charge_usage_show_search').click(function(){
        charge.modal.hide_new();
        charge.modal.show_search_charge_usage();
    });

    $('#mdl_charge_usage_search').on('hidden', function(){
        charge.modal.show_new();
    });
    //search usage
    $('#bnt_charge_usage_do_search').click(function(){
        var query = $('#txt_charge_usage_search_query').val();
        if(!query){
            app.alert('กรุณาระบุคำที่ต้องการค้นหา');
        }else{
            charge.ajax.search_usage(query, function(err, data){
                $('#tbl_charge_usage_search_result > tbody').empty();
                if(err){
                    app.alert(err);
                    $('#tbl_charge_usage_search_result > tbody').append(
                        '<tr><td colspan="6">ไม่พบรายการ</td></tr>'
                    );
                }else{
                    _.each(data.rows, function(v){
                        $('#tbl_charge_usage_search_result > tbody').append(
                            '<tr>' +
                                '<td>' + v.alias_code + '</td>' +
                                '<td>' + v.name1 + '</td>' +
                                '<td>' + v.name2 + '</td>' +
                                '<td>' + v.name3 + '</td>' +
                                '<td><a href="javascript:void(0);" class="btn btn-mini btn-info" title="เลือกรายการ" ' +
                                'data-name="btn_selected_charge_usage" data-id="' + v.id + '" data-vname="' + v.name1 + '">' +
                                '<i class="icon-ok"></i>' +
                                '</a></td>' +
                                '</tr>'
                        );
                    });
                }
            });
        }
    });

    $(document).on('click', 'a[data-name="btn_selected_charge_usage"]', function(){
        var id = $(this).attr('data-id'),
            name = $(this).attr('data-vname');

        $('#txt_charge_usage_name').val(name);
        $('#txt_charge_usage_id').val(id);

        charge.modal.hide_search_charge_usage();
    });

    charge.clear_form = function(){
        $('#txt_charge_name').val('');
        $('#txt_charge_price').val('0');
        $('#txt_charge_qty').val('0');
        $('#charge_isupdate').val('0');
        $('#txt_charge_code').val('');
        $('#service_charge_id').val('');
    };
    //save charge
    $('#btn_charge_do_save').click(function(){
        var items = {};

        items.charge_code = $('#txt_charge_code').val();
        items.charge_name = $('#txt_charge_name').val();
        items.price = $('#txt_charge_price').val();
        items.qty = $('#txt_charge_qty').val();

        items.vn = charge.vn;

        items.isupdate = $('#charge_isupdate').val();

        if(!items.charge_code || !items.charge_name){
            app.alert('กรุณาระบุรายการยา')
        }else if(!items.qty){
            app.alert('กรุณาระบุจำนวน');
        }else if(!items.price){
            app.alert('กรุณาระบุราคา');
        }else{
            //do save
            charge.ajax.save_charge(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    charge.modal.hide_new();
                    charge.get_list();
                    charge.clear_form();
                }
            });
        }
    });


    $('a[href="#tab_income"]').click(function(){
        charge.get_list();
    });

    $(document).on('click', 'a[data-name="btn_charge_edit"]', function(){
        var id = $(this).attr('data-id'),
            charge_code = $(this).attr('data-charge_code'),
            charge_name = $(this).attr('data-charge_name'),
            price = $(this).attr('data-price'),
            qty = $(this).attr('data-qty');

        //set data

        $('#service_charge_id').val(id);
        $('#txt_charge_name').val(charge_name);
        $('#txt_charge_code').val(charge_code);
        $('#txt_charge_price').val(price);
        $('#txt_charge_qty').val(qty);

        $('#charge_isupdate').val('1');

        charge.modal.show_new();

    });

    $('#mdl_charge_new').on('hidden', function(){
        charge.clear_form();
    });

    //remove charge
    $(document).on('click', 'a[data-name="btn_charge_remove"]', function(){

        var id = $(this).attr('data-id');
       // alert(id);

        app.confirm('คุณต้องการลบรายการใช่หรือไม่?', function(res){
            if(res){
                charge.ajax.remove_charge(id, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        charge.get_list();
                    }
                });
            }
        });
    });

    $('#txt_charge_name').typeahead({
        ajax: {
            url: site_url + 'basic/search_charge_item_ajax',
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
            var d = data.split('|');
            var name = d[1],
                code = d[0],
                price = d[2];

            $('#txt_charge_code').val(code);
            $('#txt_charge_name').val(name);
            $('#txt_charge_price').val(price);

            return name;
        }
    });

});