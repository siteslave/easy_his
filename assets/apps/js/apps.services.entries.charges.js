head.ready(function(){
    var charge = {};
    charge.vn = $('#vn').val();
    charge.hn = $('#hn').val();

    charge.modal = {
        show_new: function(){
            $('#spn_charge_vn').html(charge.vn);
            app.load_page($('#mdl_charge_new'), '/pages/charges', 'assets/apps/js/pages/charges.js');
            $('#mdl_charge_new').modal({
                keyboard: false
            });
        },
        show_update: function(id){
            $('#spn_charge_vn').html(charge.vn + ': แก้ไข');
            app.load_page($('#mdl_charge_new'), '/pages/charges/' + charge.hn + '/' + charge.vn + '/' + id, 'assets/apps/js/pages/charges.js');
            $('#mdl_charge_new').modal({
                keyboard: false
            });
        },
        hide_new: function(){
            $('#mdl_charge_new').modal('hide');
        }
    };

    //ajax
    charge.ajax = {
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
        }
    };

    charge.get_list = function(){
        charge.ajax.get_list(charge.vn, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_charge_list > tbody').empty().append(
                    '<tr><td colspan="7">ไม่พบรายการ</td></tr>'
                );
            }else{
                charge.set_list(data);
            }

        });
    };
    //set charge list
    charge.set_list = function(data){
        $('#tbl_charge_list > tbody').empty();

        var i = 1;
        _.each(data.rows, function(v){
            var total = v.price * v.qty;

            $('#tbl_charge_list > tbody').append(
                '<tr>' +
                    '<td>' + i + '</td>' +
                    '<td>' + v.code + '</td>' +
                    '<td>' + v.name + '</td>' +
                    '<td>' + app.add_commars(v.price) + '</td>' +
                    '<td>' + app.add_commars(v.qty) + '</td>' +
                    '<td>' + app.add_commars(total) + '</td>' +
                    '<td>' +
                    '<div class="btn-group">' +
                    '<a href="javascript:void(0);" class="btn btn-default" title="แก้ไขรายการ" ' +
                    'data-name="btn_charge_edit" data-id="'+ v.id +'"><i class="icon-edit"></i></a>' +
                    '<a href="javascript:void(0);" data-name="btn_charge_remove" class="btn btn-danger" ' +
                    'title="ลบรายการ" data-id="'+ v.id +'"><i class="icon-trash"></i></a>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
            );

            i++;
        });
    };

    $('#btn_charge_new').click(function(){
        charge.modal.show_new();
    });

    $('a[href="#tab_income"]').click(function(){
        charge.get_list();
    });

    $(document).on('click', 'a[data-name="btn_charge_edit"]', function(){
        var id = $(this).attr('data-id');
        charge.modal.show_update(id);
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

    $('#btn_charge_refresh').on('click', function(e){
        charge.get_list();
        e.preventDefault();
    });
});