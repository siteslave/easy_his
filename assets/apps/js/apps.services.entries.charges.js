
head.ready(function(){
    var charge = {};
    charge.vn = $('#vn').val();

    charge.modal = {
        show_new: function(){
            $('#mdl_charge_new').modal({
                backdrop: 'static'
            }).css({
                    width: 640,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_new: function(){
            $('#mdl_charge_new').modal('hide');
        },
        show_search_charge: function(){
            $('#mdl_charge_search').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_search_charge: function(){
            $('#mdl_charge_search').modal('hide');
        },
        show_search_charge_usage: function(){
            $('#mdl_charge_usage_search').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_search_charge_usage: function(){
            $('#mdl_charge_usage_search').modal('hide');
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
            }else{
                charge.set_list(data);
            }

        });
    };
    //set charge list
    charge.set_list = function(data){
        $('#tbl_charge_list > tbody').empty();

        _.each(data.rows, function(v){
            $('#tbl_charge_list > tbody').append(
                '<tr>' +
                    '<td>' + v.charge_name + '</td>' +
                    '<td>' + app.add_commars(v.price) + '</td>' +
                    '<td>' + v.qty + '</td>' +
                    '<td>' + v.usage_name + '</td>' +
                    '<td>' +
                    '<div class="btn-group">' +
                    '<a href="javascript:void(0);" class="btn" title="แก้ไขรายการ" ' +
                    'data-name="btn_charge_edit" data-id="'+ v.id +'" data-charge_id="'+ v.charge_id +'" data-charge_name="'+ v.charge_name+'" ' +
                    'data-price="' + v.price + '" data-usage_id="'+ v.usage_id +'" data-usage_name="'+ v.usage_name +'" ' +
                    'data-qty="'+ v.qty +'"><i class="icon-edit"></i></a>' +
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

    //do search charge
    $('#bnt_charge_do_search').click(function(){
        var query = $('#txt_charge_search_name').val();
        if(!query){
            app.alert('กรุณาระบุคำค้นหา');
        }else{
            charge.ajax.search_charge(query, function(err, data){
                $('#tbl_charge_search_result > tbody').empty();
                if(err){
                    app.alert(err);
                    $('#tbl_charge_search_result > tbody').append(
                        '<tr><td colspan="6">ไม่พบรายการ</td></tr>'
                    );
                }else{
                    _.each(data.rows, function(v){
                        $('#tbl_charge_search_result > tbody').append(
                            '<tr>' +
                                '<td>' + v.stdcode + '</td>' +
                                '<td>' + v.name + '</td>' +
                                '<td>' + app.add_commars(v.price) + '</td>' +
                                '<td>' + v.unit + '</td>' +
                                '<td>' + v.streng + '</td>' +
                                '<td><a href="javascript:void(0);" class="btn btn-mini" title="เลือกรายการ" ' +
                                'data-name="btn_selected_charge" data-id="' + v.id + '" data-vname="' + v.name + '" ' +
                                'data-price="' + v.price + '">' +
                                '<i class="icon-ok"></i>' +
                                '</a></td>' +
                            '</tr>'
                        );
                    });
                }
            });
        }
    });

    $('a[data-name="btn_selected_charge"]').live('click', function(){
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
                                '<i class="icon-ok icon-white"></i>' +
                                '</a></td>' +
                                '</tr>'
                        );
                    });
                }
            });
        }
    });

    $('a[data-name="btn_selected_charge_usage"]').live('click', function(){
        var id = $(this).attr('data-id'),
            name = $(this).attr('data-vname');

        $('#txt_charge_usage_name').val(name);
        $('#txt_charge_usage_id').val(id);

        charge.modal.hide_search_charge_usage();
    });

    charge.clear_form = function(){
        $('#txt_charge_usage_id').val('');
        $('#txt_charge_usage_name').val('');
        $('#txt_charge_id').val('');
        $('#txt_charge_name').val('');
        $('#txt_charge_price').val('0');
        $('#txt_charge_qty').val('0');
        $('#btn_charge_show_search').removeAttr('disabled');
        $('#charge_isupdate').val('0');
    };
    //save charge
    $('#btn_charge_do_save').click(function(){
        var items = {};

        items.usage_id = $('#txt_charge_usage_id').val();
        items.charge_id = $('#txt_charge_id').val();
        items.price = $('#txt_charge_price').val();
        items.qty = $('#txt_charge_qty').val();

        items.vn = charge.vn;

        items.isupdate = $('#charge_isupdate').val();

        if(!items.charge_id){
            app.alert('กรุณาระบุรายการยา')
        }else if(!items.usage_id){
            app.alert('กรุณาระบุข้อมูลการใช้ยา');
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


    $('a[href="#tab_charge"]').click(function(){
        charge.get_list();
    });

    $('a[data-name="btn_charge_edit"]').live('click', function(){
        var id = $(this).attr('data-id'),
            charge_id = $(this).attr('data-charge_id'),
            charge_name = $(this).attr('data-charge_name'),
            price = $(this).attr('data-price'),
            qty = $(this).attr('data-qty'),
            usage_id = $(this).attr('data-usage_id'),
            usage_name = $(this).attr('data-usage_name');

        //set data

        $('#txt_charge_usage_id').val(usage_id);
        $('#txt_charge_usage_name').val(usage_name);
        $('#txt_charge_id').val(charge_id);
        $('#btn_charge_show_search').attr('disabled', 'disabled');
        $('#txt_charge_price').val(price);
        $('#txt_charge_qty').val(qty);

        $('#charge_isupdate').val('1');

        charge.modal.show_new();

    });

    $('#mdl_charge_new').on('hidden', function(){
        //charge.clear_form();
    });

    //remove charge
    $('a[data-name="btn_charge_remove"]').live('click', function(){

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
            var d = data.split('#');
            var name = d[1],
                id = d[0];

            $('#txt_charge_id').val(id);
            $('#txt_charge_name').val(name);

            return name;
        }
    });

});