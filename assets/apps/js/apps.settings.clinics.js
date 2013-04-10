head.ready(function(){

    var clinic = {};

    clinic.clear_form = function(){
        $('#txt_id').val('');
        $('#is_update').val('0');
        $('#txt_name').val('');
        $('#txt_export_code').val('');
    };

    clinic.ajax = {
        save: function(data, cb){
            var url = 'settings/do_save_clinics',
                params = {
                    data: data
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(cb){
            var url = 'settings/get_clinic_list',
                params = {};

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    clinic.get_list = function(){

        clinic.ajax.get_list(function(err, data){

            $('#tbl_list tbody').empty();

            if(err){
                app.alert(err);
            }else{
                if( _.size(data.rows) ) {

                    var i = 1; //set order list number

                    _.each(data.rows, function(v){
                        $('#tbl_list tbody').append(
                            '<tr>' +
                                '<td>' + i + '</td> ' +
                                '<td>' + v.export_code + '</td> ' +
                                '<td>' + v.name + '</td> ' +
                                '<td><div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn" data-name="btn_edit" ' +
                                'data-export_code="'+ v.export_code +'" data-vname="'+ v.name +'" data-id="' + v.id + '"> ' +
                                '<i class="icon-edit"></i></a>' +
                                '<a href="javascript:void(0)" disabled="disabled" class="btn" data-name="btn_remove" data-id="' + v.id + '"> ' +
                                '<i class="icon-trash"></i></a>' +
                                '</div></td> ' +
                                '</tr>'
                        );

                        i++;
                    });
                }
            }
        });

    };

    clinic.set_detail = function(items){

        $('#txt_id').val(items.id);
        $('#txt_name').val(items.name);
        $('#txt_export_code').val(items.export_code);

        $('#is_update').val('1');

        clinic.modal.show_new();
    };

    clinic.modal = {
        show_new: function(){
            $('#modal_new').modal({
                backdrop: 'static'
            }).css({
                width: 700,
                'margin-left': function() {
                    return -($(this).width() / 2);
                }
            });
        }
    };

    $('#btn_new').click(function(){
        //clear new clinic form
        clinic.clear_form();
        //show modal
        clinic.modal.show_new();
    });

    $('#btn_do_save').click(function(){
        var items          = {};
        items.id           = $('#txt_id').val();
        items.name         = $('#txt_name').val();
        items.export_code  = $('#txt_export_code').val();
        items.is_update    = $('#is_update').val();

        if(!items.name){
            app.alert('กรุณาระบุชื่อแผนก');
        }else if(!items.export_code){
            app.alert('กรุณาระบุรหัสส่งออก');
        }else{

            clinic.ajax.save(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    //clear form
                    clinic.clear_form();
                    //hide modal
                    $('#modal_new').modal('hide');
                    clinic.get_list();
                }
            });

        }
    });

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var items = {};

        items.id = $(this).data('id'),
        items.name = $(this).data('vname'),
        items.export_code = $(this).data('export_code');

        if(!items.id){
            app.alert('ไม่พบรหัสแผนก');
        }else{
            clinic.set_detail(items);
        }
    });

    clinic.get_list();


});