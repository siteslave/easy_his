head.ready(function(){

    var allergy = {};

    allergy.person_id = $('#person_id').val();

    allergy.vn = $('#vn').val();
    allergy.hn = $('#hn').val();

    allergy.modal = {
        show_allergy: function(){
            $('#spn_allergy_vn').html(allergy.vn);
            app.load_page($('#modal_screening_allergy'), '/pages/allergies/' + allergy.hn, 'assets/apps/js/pages/allergies.js');
            $('#modal_screening_allergy').modal({keyboard: false});
        },
        show_update: function(hn, id){
            $('#spn_allergy_vn').html(allergy.vn);
            app.load_page($('#modal_screening_allergy'), '/pages/allergies/' + hn + '/' + id, 'assets/apps/js/pages/allergies.js');
            $('#modal_screening_allergy').modal({keyboard: false});
        }
    };

    allergy.ajax = {

        get_list: function(hn, cb){

            var url = 'person/get_drug_allergy_list',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove_allergy: function(hn, drug_id, cb){

            var url = 'services/remove_screening_allergy',
                params = {
                    hn: hn,
                    drug_id: drug_id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    allergy.get_list = function(hn){
        $('#tbl_screening_allergy_list > tbody').empty();

        allergy.ajax.get_list(hn, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_screening_allergy_list > tbody').append('<tr><td colspan="7">ไม่พบรายการ</td></tr>');
            }else{
                if(_.size(data.rows)){
                    _.each(data.rows, function(v){
                        $('#tbl_screening_allergy_list > tbody').append(
                            '<tr>' +
                                '<td>' + app.to_thai_date(v.record_date) + '</td>' +
                                '<td>' + v.drug_name + '</td>' +
                                '<td>' + v.symptom_name + '</td>' +
                                '<td>' + v.alevel_name + '</td>' +
                               // '<td>' + v.informant_name + '</td>' +
                                '<td>' + v.hospname + '</td>' +
                                '<td>' + v.user_fullname + '</td>' +
                                '<td>' +
                                '<div class="btn-group"> ' +
                                '<button class="btn btn-default" type="button" data-name="btn_screening_allergy_edit" ' +
                                'data-id="' + v.drug_id + '" title="แก้ไขรายการ"><i class="icon-edit"></i></button>' +
                                '<button class="btn btn-danger" type="button" data-name="btn_screening_allergy_remove" ' +
                                'data-id="' + v.drug_id + '" title="ลบรายการ"><i class="icon-trash"></i></button>' +
                                '</div></td>' +
                                '</tr>'
                        );
                    });
                }else{
                    $('#tbl_screening_allergy_list > tbody').append('<tr><td colspan="7">ไม่พบรายการ</td></tr>');
                }
            }
        });
    };

    $('#btn_screening_add_drgu_allergy').click(function(){
        allergy.modal.show_allergy();
    });


    $('a[href="#tab_screening_allergy"]').click(function(){
        allergy.get_list(allergy.hn);
    });

    $('#btn_screening_refresh_drug_allergy').on('click', function(e){
        allergy.get_list(allergy.hn);
        e.preventDefault();
    });

    //remove drug
    $(document).on('click', 'button[data-name="btn_screening_allergy_remove"]', function(){
        var drug_id = $(this).attr('data-id');

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
            if(res){
                allergy.ajax.remove_allergy(allergy.hn, drug_id, function(err){
                    if(err){
                        app.alert(err);
                    }else{
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        allergy.get_list(allergy.hn);
                    }
                });
            }
        });

    });

    $(document).on('click', 'button[data-name="btn_screening_allergy_edit"]', function(){
        var drug_id = $(this).attr('data-id');

        //get detail
        allergy.modal.show_update(allergy.hn, drug_id);
    });
});