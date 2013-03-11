//Lab scripts
head.ready(function(){
    var labs = {};

    labs.hn = $('#hn').val();
    labs.vn = $('#vn').val();

    labs.modal = {
        show_order: function()
        {
            $('#mdl_lab_order').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
    };

    labs.ajax = {
        get_item_visit: function(group_id, vn, cb){
            var url = 'labs/get_item_visit',
                params = {
                    group_id: group_id,
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_order_list: function(vn, cb){
            var url = 'labs/get_order_list',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        save_order: function(data, cb){
            var url = 'labs/save_order',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        save_result: function(data, cb){
            var url = 'labs/save_result',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        remove_item: function(data, cb){
            var url = 'labs/remove_item',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        remove_order: function(data, cb){
            var url = 'labs/remove_order',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#btn_labs').on('click', function(){
        labs.get_order_list(labs.vn);
        labs.modal.show_order();
    });

    $('a[href="#tab_lab2"]').on('click', function(){
        labs.get_order_list(labs.vn);
        $('#tbl_lab_result > tbody').empty();
        $('#tbl_lab_result > tbody').append(
            '<tr><td colspan="5">กรุณาเลือกรายการ</td></tr>'
        );
    });

    labs.get_order_list = function(vn)
    {
        labs.ajax.get_order_list(vn, function(err, data){
            $('#tbl_lab_group_list > tbody').empty();
            if(err)
            {
                app.alert(err);
                $('#tbl_lab_group_list > tbody').append(
                    '<tr><td colspan="3">ไม่พบรายการ</td></tr>'
                );
            }
            else
            {
                var i = 1;
                _.each(data.rows, function(v){
                    $('#tbl_lab_group_list > tbody').append(
                        '<tr>' +
                            '<td>' + i + '</td>' +
                            '<td>' + v.name + '</td>' +
                            '<td><a href="#" data-name="btn_lab_remove_order" class="btn" ' +
                            'data-id="' + v.group_id + '"><i class="icon-trash"></i></a></td>' +
                        '</tr>'
                    );

                    i++;
                });

                //set group combo list
                labs.set_result_combo(data);
            }
        });
    };

    labs.set_result_combo = function(data)
    {
        $('#sl_lab_group_result').empty();
        $('#sl_lab_group_result').append('<option value="">--</option>');
        _.each(data.rows, function(v){
            $('#sl_lab_group_result').append(
                '<option value="' + v.group_id + '">' + v.name + '</option>'
            );
        });
    };

    labs.set_result_item = function(err, data)
    {
        if(err)
        {
            app.alert(err);

            $('#tbl_lab_result > tbody').append(
                '<tr><td colspan="5">ไม่พบรายการ</td></tr>'
            );
        }
        else
        {
            _.each(data.rows, function(v){
                $('#tbl_lab_result > tbody').append(
                    '<tr>' +
                        '<td>' + v.name + '</td>' +
                        '<td><input type="text" class="input-mini" data-type="number" value="' + v.result + '"></td>' +
                        '<td>' + v.unit + '</td>' +
                        '<td>' + v.default_value + '</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="#" class="btn" data-name="btn_lab_result_save" data-id="' + v.id + '">' +
                        '<i class="icon-save"></i></a>' +
                        '<a href="#" class="btn" data-name="btn_lab_result_remove" data-id="' + v.id + '">' +
                        '<i class="icon-trash"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });

            app.set_runtime();
        }
    };
    $('#sl_lab_group_result').on('change', function(){
        var group_id = $(this).val();
        $('#tbl_lab_result > tbody').empty();

        //get item list
        labs.ajax.get_item_visit(group_id, labs.vn, function(err, data){
            labs.set_result_item(err, data);
        });
    });

    $(document).on('click', 'a[data-name="btn_lab_result_save"]', function(){
        var obj = $(this).parent().parent().prev().prev().prev();
        var data = {};

        data.result = null,
        data.lab_id = $(this).attr('data-id'),
        data.vn = labs.vn,
        data.group_id = $('#sl_lab_group_result').val();

        obj.find('input').each(function(){
            data.result = $(this).val();
        });

        if(!data.group_id)
        {
            app.alert('กรุณาเลือกชุด LAB');
        }
        else if(!data.result)
        {
            app.alert('กรุณาระบุผลตรวจ');
        }
        else if(!data.vn)
        {
            app.alert('ไม่พบรหัสรับบริการ');
        }
        else if(!data.lab_id)
        {
            app.alert('ไม่พบรายการ LAB');
        }
        else
        {
            labs.ajax.save_result(data, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                }
            });
        }

    });

    $('#btn_lab_do_order').on('click', function(e){
        var data = {};

        data.group_id = $('#sl_lab_group').val();
        data.hn = labs.hn;
        data.vn = labs.vn;

        if(!data.group_id)
        {
            app.alert('กรุณาเลือกรายการ');
        }
        else
        {
            labs.ajax.save_order(data, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    labs.get_order_list(data.vn);
                    app.alert('เพิ่มข้อมูลแล้ว');
                }
            });
        }

        e.preventDefault();

    });

    $(document).on('click', 'a[data-name="btn_lab_result_remove"]', function(){
        var data = {};

        data.lab_id = $(this).attr('data-id');
        data.group_id = $('#sl_lab_group_result').val();
        data.hn = labs.hn;
        data.vn = labs.vn;

        var obj = $(this).parent().parent().parent();

        if(confirm('คุณต้องการลบรายการใช่หรือไม่?'))
        {
            labs.ajax.remove_item(data, function(err){
                if(err)
                {
                    app.alert('ไม่สามารถลบรายการได้');
                }
                else
                {
                    app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                    obj.fadeOut('slow');
                }
            });
        }
    });

    //remove lab order
    $(document).on('click', 'a[data-name="btn_lab_remove_order"]', function(){
        var data = {};
        data.group_id = $(this).attr('data-id'),
        data.vn = labs.vn;

        var obj = $(this).parent().parent();

        if(confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?'))
        {
            labs.ajax.remove_order(data, function(err){
                if(err)
                {
                    app.alert('ไม่สามารถลบรายการได้');
                }
                else
                {
                    app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                    obj.fadeOut('slow');
                }
            });
        }
    })
});