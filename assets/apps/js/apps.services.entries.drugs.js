
head.ready(function(){
    var drug = {};

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
        }
    };

    //ajax
    drug.ajax = {
        search_drug: function(query, cb){

            var url = 'basic/search_drug',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_diag: function(vn, cb){

            var url = 'services/get_service_diag_opd',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove_diag: function(vn, diag_code, cb){

            var url = 'services/remove_diag_opd',
                params = {
                    vn: vn,
                    diag_code: diag_code
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#btn_drug_new').click(function(){
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

    $('a[data-name="btn_selected_drug"]').live('click', function(){
        var id = $(this).attr('data-id'),
            name = $(this).attr('data-vname'),
            price = $(this).attr('data-price');

        $('#txt_drug_id').val(id);
        $('#txt_drug_name').val(name);
        $('#txt_drug_price').val(app.add_commars(price));

        drug.modal.hide_search_drug();
    });
});