
head.ready(function(){
    var drug = {};
    drug.vn = $('#vn').val();
    drug.hn = $('#hn').val();

    drug.modal = {
        show_new: function(){
            $('#mdl_drug_new').modal({
                backdrop: 'static'
            }).css({
                    width: 640,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_new: function(){
            $('#mdl_drug_new').modal('hide');
        },
        show_search_drug: function(){
            $('#mdl_drug_search').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_search_drug: function(){
            $('#mdl_drug_search').modal('hide');
        },
        show_search_drug_usage: function(){
            $('#mdl_drug_usage_search').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_search_drug_usage: function(){
            $('#mdl_drug_usage_search').modal('hide');
        }
    };

    //ajax
    drug.ajax = {
        save_drug: function(data, cb){

            var url = 'services/save_drug_opd',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search_drug: function(query, cb){

            var url = 'basic/search_drug',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(vn, cb){

            var url = 'services/get_drug_list',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove_drug: function(id, cb){

            var url = 'services/remove_drug_opd',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove_bill: function(cb){

            var url = 'services/remove_bill_drug_opd',
                params = {
                    vn: drug.vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search_usage: function(query, cb){

            var url = 'basic/search_drug_usage',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };


    drug.get_list = function(){
        drug.ajax.get_list(drug.vn, function(err, data){
            if(err){
                $('#tbl_drug_list > tbody').empty();
                $('#tbl_drug_list > tbody').append(
                    '<tr><td colspan="5">ไม่พบรายการ</td></tr>'
                );

                app.alert(err);
            }else{
                drug.set_list(data);
            }

        });
    };
    //set drug list
    drug.set_list = function(data){
        $('#tbl_drug_list > tbody').empty();

        _.each(data.rows, function(v){
            $('#tbl_drug_list > tbody').append(
                '<tr>' +
                    '<td>' + v.drug_name + '</td>' +
                    '<td>' + app.add_commars(v.price) + '</td>' +
                    '<td>' + v.qty + '</td>' +
                    '<td>' + v.usage_name + '</td>' +
                    '<td>' +
                    '<div class="btn-group">' +
                    '<a href="javascript:void(0);" class="btn" title="แก้ไขรายการ" ' +
                    'data-name="btn_drug_edit" data-id="'+ v.id +'" data-drug_id="'+ v.drug_id +'" data-drug_name="'+ v.drug_name+'" ' +
                    'data-price="' + v.price + '" data-usage_id="'+ v.usage_id +'" data-usage_name="'+ v.usage_name +'" ' +
                    'data-qty="'+ v.qty +'"><i class="icon-edit"></i></a>' +
                    '<a href="javascript:void(0);" data-name="btn_drug_remove" class="btn" title="ลบรายการ" data-id="'+ v.id +'"><i class="icon-remove"></i></a>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
            );
        });
    };

    $('#btn_drug_new').click(function(){
        drug.clear_form();
        drug.modal.show_new();
    });

    $('#btn_drug_show_search').click(function(){
        drug.modal.hide_new();
        //$('#mdl_drug_new').modal('hide');
        drug.modal.show_search_drug();
    });

    $('#mdl_drug_search').on('hidden', function(){
        drug.modal.show_new();
    });

    //do search drug
    $('#bnt_drug_do_search').click(function(){
        var query = $('#txt_drug_search_name').val();
        if(!query){
            app.alert('กรุณาระบุคำค้นหา');
        }else{
            drug.ajax.search_drug(query, function(err, data){
                $('#tbl_drug_search_result > tbody').empty();
                if(err){
                    app.alert(err);
                    $('#tbl_drug_search_result > tbody').append(
                        '<tr><td colspan="6">ไม่พบรายการ</td></tr>'
                    );
                }else{
                    _.each(data.rows, function(v){
                        $('#tbl_drug_search_result > tbody').append(
                            '<tr>' +
                                '<td>' + v.stdcode + '</td>' +
                                '<td>' + v.name + '</td>' +
                                '<td>' + app.add_commars(v.price) + '</td>' +
                                '<td>' + v.unit + '</td>' +
                                '<td>' + v.streng + '</td>' +
                                '<td><a href="javascript:void(0);" class="btn btn-mini" title="เลือกรายการ" ' +
                                'data-name="btn_selected_drug" data-id="' + v.id + '" data-vname="' + v.name + '" ' +
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

    $(document).on('click', 'a[data-name="btn_selected_drug"]', function(){
        var id = $(this).attr('data-id'),
            name = $(this).attr('data-vname'),
            price = $(this).attr('data-price');

        $('#txt_drug_id').val(id);
        $('#txt_drug_name').val(name);
        $('#txt_drug_price').val(app.add_commars(price));

        drug.modal.hide_search_drug();
    });

    //show search usage
    $('#btn_drug_usage_show_search').click(function(){
        drug.modal.hide_new();
        drug.modal.show_search_drug_usage();
    });

    $('#mdl_drug_usage_search').on('hidden', function(){
        drug.modal.show_new();
    });
    //search usage
    $('#bnt_drug_usage_do_search').click(function(){
        var query = $('#txt_drug_usage_search_query').val();
        if(!query){
            app.alert('กรุณาระบุคำที่ต้องการค้นหา');
        }else{
            drug.ajax.search_usage(query, function(err, data){
                $('#tbl_drug_usage_search_result > tbody').empty();
                if(err){
                    app.alert(err);
                    $('#tbl_drug_usage_search_result > tbody').append(
                        '<tr><td colspan="6">ไม่พบรายการ</td></tr>'
                    );
                }else{
                    _.each(data.rows, function(v){
                        $('#tbl_drug_usage_search_result > tbody').append(
                            '<tr>' +
                                '<td>' + v.alias_code + '</td>' +
                                '<td>' + v.name1 + '</td>' +
                                '<td>' + v.name2 + '</td>' +
                                '<td>' + v.name3 + '</td>' +
                                '<td><a href="javascript:void(0);" class="btn btn-mini btn-info" title="เลือกรายการ" ' +
                                'data-name="btn_selected_drug_usage" data-id="' + v.id + '" data-vname="' + v.name1 + '">' +
                                '<i class="icon-ok"></i>' +
                                '</a></td>' +
                                '</tr>'
                        );
                    });
                }
            });
        }
    });

    $(document).on('click', 'a[data-name="btn_selected_drug_usage"]', function(){
        var id = $(this).attr('data-id'),
            name = $(this).attr('data-vname');

        $('#txt_drug_usage_name').val(name);
        $('#txt_drug_usage_id').val(id);

        drug.modal.hide_search_drug_usage();
    });

    drug.clear_form = function(){
        $('#txt_drug_usage_id').val('');
        $('#txt_drug_usage_name').val('');
        $('#txt_drug_id').val('');
        $('#txt_drug_name').val('');
        $('#txt_drug_price').val('0');
        $('#txt_drug_qty').val('0');
        $('#btn_drug_show_search').removeAttr('disabled');
        $('#drug_isupdate').val('0');
    };
    //save drug
    $('#btn_drug_do_save').click(function(){
        var items = {};

        items.usage_id = $('#txt_drug_usage_id').val();
        items.drug_id = $('#txt_drug_id').val();
        items.price = $('#txt_drug_price').val();
        items.qty = $('#txt_drug_qty').val();

        items.vn = drug.vn;
        items.hn = drug.hn;

        items.isupdate = $('#drug_isupdate').val();

        if(!items.drug_id){
            app.alert('กรุณาระบุรายการยา')
        }else if(!items.usage_id){
            app.alert('กรุณาระบุข้อมูลการใช้ยา');
        }else if(!items.qty){
            app.alert('กรุณาระบุจำนวน');
        }else if(!items.price){
            app.alert('กรุณาระบุราคา');
        }else{
            //do save
            drug.ajax.save_drug(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    drug.modal.hide_new();
                    drug.get_list();
                    drug.clear_form();
                }
            });
        }
    });


    $('a[href="#tab_drug"]').click(function(){
        drug.get_list();
    });

    $(document).on('click', 'a[data-name="btn_drug_edit"]', function(){
        var id = $(this).data('id'),
            drug_id = $(this).data('drug_id'),
            drug_name = $(this).data('drug_name'),
            price = $(this).data('price'),
            qty = $(this).data('qty'),
            usage_id = $(this).data('usage_id'),
            usage_name = $(this).data('usage_name');

        //set data

        $('#txt_drug_usage_id').val(usage_id);
        $('#txt_drug_name').val(drug_name);
        $('#txt_drug_usage_name').val(usage_name);
        $('#txt_drug_id').val(drug_id);
        $('#btn_drug_show_search').attr('disabled', 'disabled');
        $('#txt_drug_price').val(price);
        $('#txt_drug_qty').val(qty);

        $('#drug_isupdate').val('1');

        drug.modal.show_new();

    });

    $('#mdl_drug_new').on('hidden', function(){
        //drug.clear_form();
    });

    //remove drug
    $(document).on('click', 'a[data-name="btn_drug_remove"]', function(){

        var id = $(this).attr('data-id');
       // alert(id);

        app.confirm('คุณต้องการลบรายการใช่หรือไม่?', function(res){
            if(res){
                drug.ajax.remove_drug(id, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        drug.get_list();
                    }
                });
            }
        });
    });

    $('#btn_drug_remove_bill').click(function(){
        app.confirm('คุณต้องการยกเลิกรายการยาทั้งหมด ใช่หรือไม่?', function(res){
           if(res){
               drug.ajax.remove_bill(function(err){
                   if(err){
                       app.alert(err);
                   }else{
                       drug.get_list();
                       app.alert('ยกเลิกรายการเสร็จเรียบร้อยแล้ว');
                   }
               });
           }
        });
    });
});