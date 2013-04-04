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
        }
    };

    $('#btn_labs').on('click', function(){
        labs.get_order_list(labs.vn);
        labs.modal.show_order();
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
                            '<td><a href="#" class="btn" data-id="' + v.id + '"><i class="icon-ok-sign"></i></a></td>' +
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

    $('#sl_lab_group_result').on('change', function(){
        var group_id = $(this).val();
        $('#tbl_lab_result > tbody').empty();

        //get item list
        labs.ajax.get_item_visit(group_id, labs.vn, function(err, data){
            if(err)
            {
                app.alert(err);

                $('#tbl_lab_result > tbody').append(
                    '<tr><td colspan="4">ไม่พบรายการ</td></tr>'
                );
            }
            else
            {
                _.each(data.rows, function(v){
                    $('#tbl_lab_result > tbody').append(
                        '<tr>' +
                            '<td>' + v.name + '</td>' +
                            '<td><input type="text" class="input-mini" data-type="number"></td>' +
                            '<td></td>' +
                            '<td><div class="btn-group">' +
                            '<a href="#" class="btn" data-name="btn_lab_result_save" data-id="' + v.id + '"><i class="icon-refresh"></i></a>' +
                            '<a href="#" class="btn" data-name="btn_lab_result_remove" data-id="' + v.id + '"><i class="icon-trash"></i></a>' +
                            '</div></td>' +
                            '</tr>'
                    );
                });

                app.set_runtime();
            }
        });
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

});