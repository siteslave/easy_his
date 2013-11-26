var drug = {};

head.ready(function(){

    drug.vn = $('#vn').val();
    drug.hn = $('#hn').val();

    drug.modal = {
        show_new: function(){
            $('#spn_drug_vn').html(drug.vn);
            app.load_page($('#mdl_drug_new'), '/pages/drugs', 'assets/apps/js/pages/drugs.js');
            $('#mdl_drug_new').modal({keyboard: false})
        },
        show_update: function(id){
            $('#spn_drug_vn').html(drug.vn + ':แก้ไข');
            app.load_page($('#mdl_drug_new'), '/pages/drugs/' + drug.vn + '/' + id, 'assets/apps/js/pages/drugs.js');
            $('#mdl_drug_new').modal({keyboard: false})
        },
        hide_new: function(){
            $('#mdl_drug_new').modal('hide');
        }
    };

    //ajax
    drug.ajax = {
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
        }
    };


    drug.get_list = function(){
        drug.ajax.get_list(drug.vn, function(err, data){
            if(err){
                $('#tbl_drug_list > tbody').empty();
                $('#tbl_drug_list > tbody').append(
                    '<tr><td colspan="6">ไม่พบรายการ</td></tr>'
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
        var i = 1;
        _.each(data.rows, function(v){
            $('#tbl_drug_list > tbody').append(
                '<tr>' +
                    '<td>' + i + '</td>' +
                    '<td>' + app.strip(v.drug_name, 80) + '</td>' +
                    '<td>' + app.add_commars(v.price) + '</td>' +
                    '<td>' + v.qty + '</td>' +
                    '<td>' + v.usage_name + '</td>' +
                    '<td>' +
                    '<div class="btn-group">' +
                    '<a href="javascript:void(0);" class="btn btn-default" title="แก้ไขรายการ" ' +
                    'data-name="btn_drug_edit" data-id="'+ v.id +'" data-drug_id="'+ v.drug_id +'" data-drug_name="'+ v.drug_name+'" ' +
                    'data-price="' + v.price + '" data-usage_id="'+ v.usage_id +'" data-usage_name="'+ v.usage_name +'" ' +
                    'data-qty="'+ v.qty +'"><i class="fa fa-edit"></i></a>' +
                    '<a href="javascript:void(0);" data-name="btn_drug_remove" class="btn btn-danger" title="ลบรายการ" ' +
                    'data-id="'+ v.id +'"><i class="fa fa-trash-o"></i></a>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
            );
            i++;
        });
    };

    $('#btn_drug_new').click(function(){
        drug.modal.show_new();
    });

    $('a[href="#tab_drug"]').click(function(){
        drug.get_list();
    });

    $(document).on('click', 'a[data-name="btn_drug_edit"]', function(){
        var id = $(this).data('id');
        drug.modal.show_update(id);
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

    $('#btn_drug_refresh').on('click', function(){
        drug.get_list();
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