head.ready(function(){
    var disb = {};

    disb.modal = {
        show_register: function(){
            $('#mdl_register').modal({
                backdrop: 'static'
            });
        },
        show_search_person: function(){
            $('#mdl_search_person').modal({
                backdrop: 'static'
            });
        },
        hide_search_person: function(){
            $('#mdl_search_person').modal('hide');
        },
        hide_register: function(){
            $('#mdl_register').modal('hide');
        }
    };

    disb.ajax = {
        save: function(data, cb){

            var url = 'disabilities/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search_person: function(query, filter, cb){
            var url = 'person/search',
                params = {
                    query: query,
                    filter: filter
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list_by_village: function(village_id, cb){
            var url = 'disabilities/get_list_by_village',
                params = {
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(start, stop, cb){
            var url = 'disabilities/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'disabilities/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(id, cb){
            var url = 'disabilities/get_detail',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_house_list: function(village_id, cb){
            var url = 'person/get_houses_list',
                params = {
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        remove: function(id, cb){
            var url = 'disabilities/remove',
                params = {
                    id: id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };
    //set person detail
    $('#txt_hn').on('click', function(e) {
        e.preventDefault();

        var person = $(this).select2('data');

        if(person === null) {
            app.alert('กรุณาระบุข้อมูลบุคคล');
        } else {
            $('#txt_cid').val( person.cid );
            $('#txt_birthdate').val( person.birthdate );
            $('#txt_age').val( person.age );
        }
    });

    $('#txt_icdname').select2({
        placeholder: 'รหัส หรือ ชื่อการวินิจฉัยโรค',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_icd_ajax",
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
        },
        initSelection: function(el, cb) {
            //var eltxt = $(el).val();
            //cb({'term': eltxt });
        }
    });

    //search person
    $('#txt_hn').select2({
        placeholder: 'HN, เลขบัตรประชาชน, ชื่อ-สกุล',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/person/search_person_all_ajax",
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
        },

        id: function(data) { return { id: data.hn } },

        formatResult: function(data) {
            return '[' + data.hn + '] ' + data.fullname;
        },
        formatSelection: function(data) {
            return '[' + data.hn + '] ' + data.fullname;
        },
        initSelection: function(el, cb) {
            //var eltxt = $(el).val();
            //cb({'term': eltxt });
        }
    });

    $('#btn_refresh').on('click', function(){
        disb.get_list();
    });

    disb.get_list = function()
    {
        $('#main_paging').fadeIn('slow');
        disb.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('ds_paging'),
                    onSelect: function(page){
                        app.set_cookie('ds_paging', page);

                        disb.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_list > tbody').empty();
                            if(err){
                                app.alert(err);
                            }else{
                                disb.set_list(data);
                            }

                        });

                    },
                    onFormat: app.paging_format
                });
            }
        });
    };

    disb.set_list = function(data)
    {

        $('#tbl_list > tbody').empty();

        if(!data)
        {
            $('#tbl_list > tbody').append('<tr><td colspan="8">ไม่พบข้อมูล</td></td></tr>');
        }
        else
        {
            _.each(data.rows, function(v)
            {
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.hn +'</td>' +
                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>'+ app.mongo_to_thai_date(v.birthdate) +'</td>' +
                        '<td>'+ v.age +'</td>' +
                        '<td>'+ v.reg_date +'</td>' +
                        '<td>'+ v.disb_type +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_edit" class="btn btn-success btn-small" data-hn="'+ v.hn +'" ' +
                        'data-cid="'+ v.cid +'" data-fullname="'+ v.first_name + ' ' + v.last_name +'" title="แก้ไข"' +
                        'data-age="'+ v.age +'" data-birthdate="'+ app.mongo_to_thai_date(v.birthdate) +'" data-id="'+ v.id +'">' +
                        '<i class="fa fa-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_remove" class="btn btn-danger btn-small"' +
                        ' title="ลบออกจากทะเบียน" data-id="'+ v.id +'">' +
                        '<i class="fa fa-trash-o"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };

    $('#btn_register').click(function(){
        disb.clear_form();
        disb.modal.show_register();
    });

    disb.clear_form = function()
    {
        $('#txt_fullname').val('');
        $('#txt_hn').val('');
        $('#txt_cid').val('');
        $('#txt_age').val('');
        $('#txt_birthdate').val('');
        $('#txt_did').val('');
        $('#sl_disb_types').removeProp('disabled');
        app.set_first_selected($('#sl_disb_types'));
        app.set_first_selected($('#sl_disp_cause'));
        $('#txt_icdcode').val('');
        $('#txt_icdname').val('');
        $('#txt_detect_date').val('');
        $('#txt_disab_date').val('');
        $('#txt_update_id').val('');
        $('#btn_search_person').removeProp('disabled');
    };

    $('#btn_save_disb').click(function(){
        var
            items       = {}
            , person    = $('#txt_hn').select2('data')
            , diag      = $('#txt_icdname').select2('data')
        ;

        //console.log(person);

        items.hn            = person === null ? '' : person.hn;
        items.diag_code     = diag === null ? '' : diag.code;

        //console.log(items.hn);

        items.did           = $('#txt_did').val();
        items.dtype         = $('#sl_disb_types').select2('val');
        items.dcause        = $('#sl_disp_cause').select2('val');

        items.detect_date   = $('#txt_detect_date').val();
        items.disb_date     = $('#txt_disab_date').val();
        //items.fullname      = $('#txt_fullname').val();
        //data.id = $('#txt_update_id').val();

        if(!items.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!items.dtype)
        {
            app.alert('ประเภทความพิการ');
        }
        else if(!items.dcause)
        {
            app.alert('สาเหตุความพิการ');
        }
        else if(!items.diag_code)
        {
            app.alert('กรุณาระบุรหัสโรคหรือการบาดเจ็บที่เป็นสาเหตุของความพิการ');
        }
        else if(!items.detect_date)
        {
            app.alert('กรุณาระบุวันที่ตรวจพบความพิการ');
        }
        else if(!items.disb_date)
        {
            app.alert('กรุณาระบุวันที่เริ่มมีความพิการ');
        }
        else
        {
            disb.ajax.save(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                    disb.modal.hide_register();
                    disb.get_list();
                }
            });
        }
    });

    $('#btn_search_person').click(function(){
        disb.modal.hide_register();
        disb.modal.show_search_person();
    });

    $('#mdl_search_person').on('hidden', function(){
        disb.modal.show_register();
    });

    disb.get_detail = function(id)
    {
        disb.ajax.get_detail(id, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
               //set data
               disb.set_detail(data);
           }
        });
    };

    disb.set_detail = function(data)
    {
        $('#txt_did').val(data.rows.did);
        $('#sl_disb_types').select2('val', data.rows.dtype);
        $('#sl_disp_cause').select2('val', data.rows.dcause);
        //$('#txt_icdcode').val(data.rows.diag_code);
        $('#txt_icdname').select2('data', { code: data.rows.diag_code, name: data.rows.diag_name });
        $('#txt_detect_date').val(data.rows.detect_date);
        $('#txt_disab_date').val(data.rows.disb_date);
    };

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var
            hn          = $(this).data('hn')
            , cid       = $(this).data('cid')
            , fullname  = $(this).data('fullname')
            , age       = $(this).data('age')
            , birthdate = $(this).data('birthdate')
            , id        = $(this).data('id')
        ;

        //$('#btn_search_person').attr('disabled', 'disabled');
        //$('#txt_fullname').val(fullname);
        $('#txt_hn').select2('data', { hn: hn, fullname: fullname });
        $('#txt_hn').select2('enable', false);

        $('#txt_cid').val(cid);
        $('#txt_age').val(age);
        $('#txt_birthdate').val(birthdate);
        //$('#txt_update_id').val(id);

       $('#sl_disb_types').prop('disabled', true).css('background-color', 'white');
        //get disability detail
        disb.get_detail(id);
        disb.modal.show_register();
    });

    $('#btn_do_get_list').click(function(){
        var village_id = $('#sl_village').val();

        if(!village_id)
        {
            disb.get_list();
        }
        else
        {
            $('#main_paging').fadeOut('slow');
            disb.ajax.get_list_by_village(village_id, function(err, data){
                disb.set_list(data);
            });
        }

    });

    /**
     * Remove
     */
    $(document).on('click', 'a[data-name="btn_remove"]', function(){
        var id = $(this).data('id');

        app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
           if(res)
           {
               disb.ajax.remove(id, function(err){
                   if(err)
                   {
                       app.alert(err);
                   }
                   else
                   {
                       app.alert('ลบข้อมูลเสร็จเรียบร้อยแล้ว');
                       disb.get_list();
                   }
               });
           }
        });

    });

    disb.get_list();
});