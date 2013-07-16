head.ready(function() {

    var cdental = {};

    cdental.ajax = {
        save: function(items, cb){

            var url = 'services/save_charge_dental',
                params = {
                    data: items
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(vn, cb){

            var url = 'services/get_charge_dental_list',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(id, cb){

            var url = 'services/get_charge_dental_remove',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    cdental.modal = {
        show_new: function(){
            $('#mdl_dental_charge_new').modal({
                backdrop: 'static'
            });
        },
        hide_new: function(){
            $('#mdl_dental_charge_new').modal('hide');
        }
    };

    $('#btn_new_charge_dental').on('click', function() {
        cdental.clear_form();
        cdental.modal.show_new();
    });

    cdental.clear_form = function() {
        $('#txt_charge_dental_id').val('');
        app.set_first_selected($('#sl_charge_dental_items'));
        $('#sl_charge_dental_items').removeProp('disabled');
        $('#txt_charge_dental_teeth').val('');
        $('#txt_charge_dental_price').val('');
        $('#txt_charge_dental_side').val('');
    };

    $('#btn_save_charge_dental').on('click', function() {
        var items = {};
        items.vn = $('#vn').val();
        items.hn = $('#hn').val();

        items.id = $('#txt_charge_dental_id').val();
        items.charge_id = $('#sl_charge_dental_items').val();
        items.teeth = $('#txt_charge_dental_teeth').val();
        items.price = $('#txt_charge_dental_price').val();
        items.side = $('#txt_charge_dental_side').val();

        if(!items.vn)
        {
            app.alert('กรุณาระบุ VN');
        }
        else if(!items.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!items.charge_id)
        {
            app.alert('กรุณาระบุค่าใช้จ่ายหรือกิจกรรมที่ทำ');
        }
        else if(!items.price)
        {
            app.alert('กรุณาระบุราคา');
        }
        else if(!items.teeth)
        {
            app.alert('กรุณาระบุซี่ฟัน');
        }
        else
        {
            cdental.ajax.save(items, function(err) {
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    cdental.clear_form();

                    cdental.get_list();

                    cdental.modal.hide_new();
                }
            });
        }

    });

    $('#sl_charge_dental_items').on('change', function() {
        var price = $(this).find('option:selected').attr('data-price');
        $('#txt_charge_dental_price').val(price);
    });

    cdental.get_list = function() {
        var vn = $('#vn').val();

        $('#tbl_charge_item_list > tbody').empty();

        cdental.ajax.get_list(vn ,function(err, data) {
            if(err)
            {
                app.alert(err);
                $('#tbl_charge_item_list > tbody').append('<tr><td colspan="6">ไม่พบรายการ</td></tr>');
            }
            else
            {
                if( _.size(data.rows) > 0 )
                {
                    var i = 1;

                    _.each(data.rows, function(v) {
                        $('#tbl_charge_item_list > tbody').append(
                            '<tr>' +
                                '<td>'+ i +'</td>' +
                                '<td>'+ v.name +'</td>' +
                                '<td>'+ v.teeth +'</td>' +
                                '<td>'+ v.side +'</td>' +
                                '<td>'+ app.add_commars(v.price) +'</td>' +
                                '<td><div class="btn-group">' +
                                '<a href="#" class="btn btn-success" data-name="btn_charge_dental_edit"' +
                                ' data-price="'+ v.price +'" data-teeth="'+ v.teeth +'" ' +
                                ' data-side="'+ v.side +'" data-id="'+ v.id +'" data-charge_id="'+ v.charge_id+'" title="แก้ไขรายการ"><i class="icon-edit"></i></a>' +
                                '<a href="#" class="btn btn-danger" data-name="btn_charge_dental_remove" data-id="'+ v.id +'" title="ลบรายการ">' +
                                '<i class="icon-trash"></i></a>' +
                                '</div></td>' +
                                '</tr>'
                        );

                        i++;
                    });
                }
                else
                {
                    $('#tbl_charge_item_list > tbody').append('<tr><td colspan="6">ไม่พบรายการ</td></tr>');
                }
            }
        });
    };

    $(document).on('click', 'a[data-name="btn_charge_dental_edit"]', function() {
        var id = $(this).data('id'),
            charge_id = $(this).data('charge_id'),
            price = $(this).data('price'),
            teeth = $(this).data('teeth'),
            side = $(this).data('side');

        $('#txt_charge_dental_id').val(id);
        $('#sl_charge_dental_items').val(charge_id).prop('disabled', true).css('background-color', 'white');
        $('#txt_charge_dental_teeth').val(teeth);
        $('#txt_charge_dental_price').val(price);
        $('#txt_charge_dental_side').val(side);

        cdental.modal.show_new();
    });

    $(document).on('click', 'a[data-name="btn_charge_dental_remove"]', function() {
        var id = $(this).data('id');
        if(confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?'))
        {
            cdental.ajax.remove(id, function(err) {
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                    cdental.get_list();
                }
            });
        }
    });

    $('a[href="#tab_dental_charge_item"]').on('click', function(){
        cdental.get_list();
    });

    app.set_runtime();
});