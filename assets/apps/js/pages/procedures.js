head.ready(function(){

    var procedures = {};

    procedures.ajax = {
        save_proced_opd: function(data, cb){

            var url = 'services/save_proced_opd',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_extra_list: function(start, stop, cb){

            var url = 'basic/get_procedure_extra_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data.rows);
            });
        },

        get_extra_total: function(cb){

            var url = 'basic/get_procedure_extra_total',
                params = {};

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data.total);
            });
        }
    };

    procedures.get_extra = function(){
        $('#procedure_extra_paging').fadeIn('slow');
        procedures.ajax.get_extra_total(function(err, total){
            if(err){
                app.alert(err);
                $('#tbl_procedure_extra > tbody').append(
                    '<tr><td colspan="4">ไม่พบรายการ</td></tr>'
                );
            }else{
                $('#procedure_extra_paging').paging(total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: 10,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        procedures.ajax.get_extra_list(this.slice[0], this.slice[1], function(err, rs){
                            $('#tbl_procedure_extra > tbody').empty();
                            if(err){
                                app.alert(err);
                                $('#tbl_epi_list > tbody').append(
                                    '<tr><td colspan="4">ไม่พบรายการ</td></tr>'
                                );
                            }else{
                                procedures.set_extra(rs);
                            }

                        });

                    },
                    onFormat: app.paging_format
                });
            }
        });
    };


    procedures.set_extra = function(data) {
        if(_.size(data))
        {
            _.each(data, function(v) {
                $('#tbl_procedure_extra > tbody').append(
                    '<tr>' +
                        '<td>'+app.clear_null(v.code)+'</td>' +
                        '<td>'+app.clear_null(v.name)+'</td>' +
                        '<td>'+app.clear_null(v.price)+'</td>' +
                        '<td>' +
                        '<a href="javascript: void(0);" class="btn btn-sm btn-default" data-name="btn_procedure_extra" ' +
                        'data-code="' + v.code + '" data-eng_name="' + v.eng_name + '" data-price="' + v.price + '">' +
                        '<i class="fa fa-plus"></i>' +
                        '</a></td>' +
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_procedure_extra > tbody').append('<tr><td colspan="4">ไม่พบรายการ</td></tr>');
        }
    };

    $(document).on('click', 'a[data-name="btn_procedure_extra"]', function(e) {

        e.preventDefault();

        var code = $(this).data('code'),
            name = $(this).data('eng_name'),
            price = $(this).data('price');

        $('#txt_proced_query').select2('data', { code: code, name: name });
        $('#txt_proced_price').val(price);

        $('a[href="#procedure_new"]').tab('show');
    });



    procedures.clear_form = function(){
        $('#txt_proced_query').val('');
        $('#txt_proced_isupdate').val('');
        $('#txt_proced_query_code').val('');
        $('#txt_proced_price').val('0');
        $('#txt_proced_end_time').val('');
        $('#txt_proced_start_time').val('');

        app.set_first_selected($('#sl_proced_provider'));
        app.set_first_selected($('#sl_proced_clinic'));

        $('#txt_proced_query').removeProp('disabled');
        $('#txt_proced_query').removeClass('uneditable-input');
        //$('#txt_proced_query').css('background-color', 'white');

    };

    $('#btn_proced_do_save').click(function(){
        var items = {};
        var data = $('#txt_proced_query').select2('data');

        items.code = data === null ? '' : data.code;
        items.price = $('#txt_proced_price').val();
        items.isupdate = $('#txt_proced_isupdate').val();
        items.provider_id = $('#sl_proced_provider').val();
        items.start_time = $('#txt_proced_start_time').val();
        items.end_time = $('#txt_proced_end_time').val();
        items.clinic_id = $('#sl_proced_clinic').val();

        items.vn = $('#txt_proced_vn').val();

        if(!items.code){
            app.alert('กรุณาระบุ หัตถการ');
        }else if(!items.price){
            app.alert('กรุณาระบุ ราคา');
        }else if(!items.provider_id){
            app.alert('กรุณาระบุ ผู้ทำหัตถการ');
        }else if(!items.start_time){
            app.alert('กรุณาระบุ เวลาเริ่มทำหัตถการ');
        }else if(!items.clinic_id){
            app.alert('กรุณาระบุ คลินิกที่ให้บริการ');
        }else if(!items.end_time){
            app.alert('กรุณาระบุ เวลาสิ้นสุดการทำหัตถการ');
        }else{
            //do save
            procedures.ajax.save_proced_opd(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    parent.procedures.get_list();
                    parent.procedures.modal.hide_new();
                }
            });
        }
    });

    $('#txt_proced_query').select2({
        placeholder: 'รหัส หรือ ชื่อห้ตถการ',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_procedure_ajax",
            dataType: 'json',
            type: 'POST',
            quietMillis: 100,
            data: function (term, page) {
                return {
                    query: term,
                    csrf_token: csrf_token,
                    start: page,
                    stop: 10
                };
            },
            results: function (data, page)
            {
                var more = (page * 10) < data.total; // whether or not there are more results available

                // notice we return the value of more so Select2 knows if more results can be loaded
                return {results: data.rows, more: more};

                //return { results: data.rows, more: (data.rows && data.rows.length == 10 ? true : false) };
            }
            //dropdownCssClass: "bigdrop"
        },

        id: function(data) { return { id: data.code } },

        formatResult: function(data) {
            return '[' + data.code + '] ' + data.name;
        },
        formatSelection: function(data) {
            return '[' + data.code + '] ' + data.name;
        }
    });

    $('#btn_proced_refresh').on('click', function(e){
        procedures.clear_form();
        e.preventDefault();
    });

    procedures.set_procedure = function() {
        var proced_code = $('#txt_proced_code').val();
        var proced_name = $('#txt_proced_name').val();

        if(proced_code) {
            $('#txt_proced_query').select2('data', {code: proced_code, name: proced_name});
            $('#txt_proced_query').select2('enable', false);
        }
    };



    $('#txt_procedure_extra_query').select2({
        placeholder: 'รหัส หรือ ชื่อห้ตถการ',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_procedure_extra_ajax",
            dataType: 'json',
            type: 'POST',
            quietMillis: 100,
            data: function (term, page) {
                return {
                    query: term,
                    csrf_token: csrf_token,
                    start: page,
                    stop: 10
                };
            },
            results: function (data, page)
            {
                var more = (page * 10) < data.total; // whether or not there are more results available

                // notice we return the value of more so Select2 knows if more results can be loaded
                return {results: data.rows, more: more};

                //return { results: data.rows, more: (data.rows && data.rows.length == 10 ? true : false) };
            }
            //dropdownCssClass: "bigdrop"
        },

        id: function(data) { return { id: data.code } },

        formatResult: function(data) {
            return '[' + data.code + '] ' + data.name;
        },
        formatSelection: function(data) {
            return '[' + data.code + '] ' + data.name;
        }
    });

    $('a[href="#procedure_extra"]').on('click', function(e) {
        e.preventDefault();
        procedures.get_extra();
    });

//    $('#btn_procedure_extra_do_search').on('click', function(e) {
//        e.preventDefault();
//
//        var data = $('#txt_procedure_extra_query').select2('data');
//
//        if(data === null) {
//            app.alert('กรุณาเลือกรายการ');
//        } else {
//            var code = data.code,
//                name = data.eng_name,
//                price = data.price;
//
//            $('#txt_proced_query').select2('data', { code: code, name: name });
//            $('#txt_proced_price').val(price);
//
//            $('a[href="#procedure_new"]').tab('show');
//        }
//    });


    procedures.set_procedure();


    app.set_runtime();
});