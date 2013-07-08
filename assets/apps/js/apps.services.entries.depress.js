head.ready(function(){
    var depress = {};
    depress.modal = {
        show_new: function(){
            $('#mdl_depress').modal({keyboard: false});
        },
        hide_new: function(){
            $('#mdl_depress').modal('hide');
        }
    };

    depress.ajax = {
        detail: function(hn, vn, cb){
            var url = 'depress/detail',
                params = {
                    hn: hn,
                    vn: vn
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(hn, vn, cb){
            var url = 'depress/remove',
                params = {
                    hn: hn,
                    vn: vn
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        save: function(items, cb){
            var url = 'depress/save',
                params = {
                    data: items
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    $('a[data-name="btn_depress"]').click(function(){
        var hn = $('#hn').val(),
            vn = $('#vn').val();

        depress.clear_form();
        depress.get_detail(hn, vn);
        depress.modal.show_new();
    });

    depress.get_detail = function(hn, vn) {
        depress.ajax.detail(hn, vn, function(err, data) {
            if(err)
            {
                app.alert('ไม่พบข้อการให้บริการเดิม');
            }
            else
            {
                depress.set_detail(data.rows);
            }
        });
    };

    depress.set_detail = function(v) {
        $('#sl_depress_2q1').val(v.q21);
        $('#sl_depress_2q2').val(v.q22);
        $('#sl_depress_9q1').val(v.q91);
        $('#sl_depress_9q2').val(v.q92);
        $('#sl_depress_9q3').val(v.q93);
        $('#sl_depress_9q4').val(v.q94);
        $('#sl_depress_9q5').val(v.q95);
        $('#sl_depress_9q6').val(v.q96);
        $('#sl_depress_9q7').val(v.q97);
        $('#sl_depress_9q8').val(v.q98);
        $('#sl_depress_9q9').val(v.q99);
    };

    depress.clear_form = function()
    {
        app.set_first_selected($('#sl_depress_2q1'));
        app.set_first_selected($('#sl_depress_2q2'));
        app.set_first_selected($('#sl_depress_9q1'));
        app.set_first_selected($('#sl_depress_9q2'));
        app.set_first_selected($('#sl_depress_9q3'));
        app.set_first_selected($('#sl_depress_9q4'));
        app.set_first_selected($('#sl_depress_9q5'));
        app.set_first_selected($('#sl_depress_9q6'));
        app.set_first_selected($('#sl_depress_9q7'));
        app.set_first_selected($('#sl_depress_9q8'));
        app.set_first_selected($('#sl_depress_9q9'));
    }

    $('#btn_save_depress').on('click', function() {
        var items = {};
        items.hn = $('#hn').val();
        items.vn = $('#vn').val();
        items.q21 = $('#sl_depress_2q1').val();
        items.q22 = $('#sl_depress_2q2').val();
        items.q91 = $('#sl_depress_9q1').val();
        items.q92 = $('#sl_depress_9q2').val();
        items.q93 = $('#sl_depress_9q3').val();
        items.q94 = $('#sl_depress_9q4').val();
        items.q95 = $('#sl_depress_9q5').val();
        items.q96 = $('#sl_depress_9q6').val();
        items.q97 = $('#sl_depress_9q7').val();
        items.q98 = $('#sl_depress_9q8').val();
        items.q99 = $('#sl_depress_9q9').val();

        app.confirm('คุณต้องการบันทึกข้อมูลคัดกรองซึมเศร้านี้ใช่หรือไม่? \n เมื่อบันทึกแล้วกรุณาระบุรหัส Z133 ในหน้าการวินิจฉัยด้วย', function(res) {
            if(res)
            {
                depress.ajax.save(items, function(err) {
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    }
                })
            }
        });
    });

    $('#btn_remove_depress').on('click', function() {
        var hn = $('#hn').val(),
            vn = $('#vn').val();

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res) {
            if(res)
            {
                depress.ajax.remove(hn, vn, function(err) {
                    if(err)
                    {
                        app.alert('ไม่สามารถลบรายการได้');
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        depress.clear_form();
                    }
                });
            }
        });
    });
});