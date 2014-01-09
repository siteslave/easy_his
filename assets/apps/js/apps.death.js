head.ready(function(){
    var death = {};

    death.modal = {
        show_register: function(){
            $('#mdl_register').modal({
                backdrop: 'static'
            });
        },
        hide_register: function(){
            $('#mdl_register').modal('hide');
        }
    };

    death.ajax = {
        save: function(data, cb){

            var url = 'death/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(hn, dchstatus, cb){

            var url = 'death/remove',
                params = {
                    hn: hn,
                    dchstatus: dchstatus
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(start, stop, cb){
            var url = 'death/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'death/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(hn, cb){
            var url = 'death/get_detail',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        search: function(query, cb){
            var url = 'death/search',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }

    };

    death.get_list = function()
    {
        $('#main_paging').fadeIn('slow');
        death.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_list > tbody').append('<tr><td colspan="8">ไม่พบข้อมูล</td></td></tr>');
            }else{
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('death_paging'),
                    onSelect: function(page){
                        app.set_cookie('death_paging', page);

                        death.ajax.get_list(this.slice[0], this.slice[1], function(err, data){

                            $('#tbl_list > tbody').empty();

                            if(err){
                                app.alert(err);
                                $('#tbl_list > tbody').append('<tr><td colspan="8">ไม่พบข้อมูล</td></td></tr>');
                            }else{
                                death.set_list(data);
                            }

                        });

                    },
                    onFormat: app.paging_format
                });
            }
        });
    };

    death.set_list = function(data)
    {

        $('#tbl_list > tbody').empty();

        if(_.size(data.rows) == 0)
        {
            $('#tbl_list > tbody').append('<tr><td colspan="8">ไม่พบข้อมูล</td></td></tr>');
        }
        else
        {
            var i = 1;
            _.each(data.rows, function(v)
            {
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.hn +'</td>' +
                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>'+ app.mongo_to_thai_date(v.birthdate) +'</td>' +
                        '<td>'+ v.age +'</td>' +
                        '<td>'+ v.ddeath +'</td>' +
                        '<td>'+ v.icd_code +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_edit" class="btn btn-success btn-small" ' +
                        'data-hn="'+ v.hn +'" ' +
                        'data-cid="'+ v.cid +'" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-age="'+ v.age +'" data-birthdate="'+ app.mongo_to_thai_date(v.birthdate) +'" ' +
                        'data-id="'+ v.id +'" title="แก้ไข">' +
                        '<i class="fa fa-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_remove" class="btn btn-danger btn-small" ' +
                        'data-hn="'+ v.hn +'" title="ลบรายการ">' +
                        '<i class="fa fa-trash-o"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };

    $('#txt_icd_cdeath').select2({
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

    $('#txt_icd_odisease').select2({
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

    $('#txt_icd_deathA').select2({
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

    $('#txt_icd_deathB').select2({
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

    $('#txt_icd_deathC').select2({
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


    $('#txt_icd_deathD').select2({
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


    $('#txt_reg_hosp_death').select2({
        placeholder: 'ชื่อ หรือ รหัสสถานบริการ',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: site_url + "/basic/search_hospital_ajax",
            dataType: 'json',
            type: 'POST',
            quietMillis: 100,
            data: function (term) {
                return {
                    query: term,
                    csrf_token: csrf_token
                };
            },
            results: function (data)
            {
                return { results: data.rows, more: (data.rows && data.rows.length == 10 ? true : false) };
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


    $('#txt_query').select2({
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

    $('#txt_reg_hn').on('click', function(e) {
        var data = $(this).select2('data');

        $('#txt_reg_cid').val(data.cid);
        $('#txt_reg_birthdate').val(data.birthdate);
        $('#txt_reg_age').val(data.age);
    });

    $('#txt_reg_hn').select2({
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

    $('#btn_register').click(function(){
        death.clear_form();
        death.modal.show_register();
    });

    death.clear_form = function()
    {
        $('#txt_reg_hn').select2('val', '');
        $('#txt_reg_cid').val('');
        $('#txt_reg_birthdate').val('');
        $('#txt_reg_age').val('');
        //$('#txt_reg_hosp_death_code').val('');
        $('#txt_reg_hosp_death').select2('val', '');
        $('#txt_reg_death_date').val('');
        //$('#txt_hosp_deathA_code').val('');
        $('#txt_icd_deathA').select2('val', '');
        //$('#txt_hosp_deathB_code').val('');
        $('#txt_icd_deathB').select2('val', '');
        //$('#txt_hosp_deathC_code').val('');
        $('#txt_icd_deathC').select2('val', '');
        //$('#txt_hosp_deathD_code').val('');
        $('#txt_icd_deathD').select2('val', '');
        //$('#txt_reg_cdeath_code').val('');
        $('#txt_icd_cdeath').select2('val', '');
        $('#sl_reg_pregdeath').select2('val', '');
        $('#sl_pdeath').select2('val', '');
        $('#txt_icd_odisease').select2('val', '');
        $('#txt_isupdate').val('0');

        $('#txt_reg_hn').select2('enable', true)
    };

    $('#btn_save_death').click(function(){
        var
            data        = {}

            , person      = $('#txt_reg_hn').select2('data')
            , hospital    = $('#txt_reg_hosp_death').select2('data')
            , cdeath      = $('#txt_icd_cdeath').select2('data')
            , death_a     = $('#txt_icd_deathA').select2('data')
            , death_b     = $('#txt_icd_deathB').select2('data')
            , death_c     = $('#txt_icd_deathC').select2('data')
            , death_d     = $('#txt_icd_deathD').select2('data')
            , odeath      = $('#txt_icd_odisease').select2('data')
        ;

        data.hn         = person === null ? false : person.hn;

        data.hospdeath  = hospital === null ? '' : hospital.code;
        data.cdeath_a   = death_a === null ? '' : death_a.code;
        data.cdeath_b   = death_b === null ? '' : death_b.code;
        data.cdeath_c   = death_c === null ? '' : death_c.code;
        data.cdeath_d   = death_d === null ? '' : death_d.code;
        data.cdeath     = cdeath === null ? '' : cdeath.code;
        data.odisease   = odeath === null ? '' : odeath.code;

        data.ddeath     = $('#txt_reg_death_date').val();
        data.pregdeath  = $('#sl_reg_pregdeath').select2('val');
        data.pdeath     = $('#sl_pdeath').select2('val');
        data.isupdate   = $('#txt_isupdate').val();


        if(!data.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!data.cdeath)
        {
            app.alert('กรุณาระบุสาเหตุการเสียชีวิต');
        }
        else if(!data.ddeath)
        {
            app.alert('กรุณาระบุวันที่เสียชีวิต');
        }
        else if(!data.pdeath)
        {
            app.alert('กรุณาระบุสถานที่เสียชีวิต');
        }
        else if(!data.pregdeath)
        {
            app.alert('กรุณาระบุภาวะการตั้งครรภ์');
        }
        else
        {

            if(confirm('คุณต้องการเปลี่ยนสถานะการจำหน่ายเป็น ตาย [1] หรือไม่?'))
            {
                data.dchstatus = '1';
            }
            else
            {
                data.dchstatus = '0';
            }

            if(confirm('ต้องการบันทึกข้อมูลการตายใช่หรือไม่?'))
            {
                death.ajax.save(data, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                        death.modal.hide_register();
                        death.get_list();
                    }
                });
            }

        }
    });


    death.get_detail = function(hn)
    {
        death.ajax.get_detail(hn, function(err, data){
           if(err)
           {
               app.alert(err);
           }
            else
           {
               //set data
               death.set_detail(data.rows);
           }
        });
    };

    death.set_detail = function(data)
    {
        $('#txt_reg_hosp_death').select2('data', { code: data.hospdeath, name: data.hospdeath_name });
        $('#txt_reg_death_date').val(data.ddeath);
        $('#txt_icd_deathA').select2('data', { code: data.cdeath_a, name: data.cdeath_a_name });
        $('#txt_icd_deathB').select2('data', { code: data.cdeath_b, name: data.cdeath_b_name });
        $('#txt_icd_deathC').select2('data', { code: data.cdeath_c, name: data.cdeath_c_name });
        $('#txt_icd_deathD').select2('data', { code: data.cdeath_d, name: data.cdeath_d_name });
        $('#txt_icd_cdeath').select2('data', { code: data.cdeath, name: data.cdeath_name });
        $('#sl_reg_pregdeath').select2('val', data.pregdeath);
        $('#sl_pdeath').select2('val', data.pdeath);
        $('#txt_icd_odisease').select2('data', { code: data.odisease, name: data.odisease_name });

        $('#txt_isupdate').val('1');

    };

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var
            hn = $(this).data('hn')

            , fullname = $(this).data('fullname')
            , cid = $(this).data('cid')
            , age = $(this).data('age')
            , birthdate = $(this).data('birthdate')
        ;

        death.clear_form();

        $('#txt_reg_cid').val(cid);
        $('#txt_reg_hn').select2('data', { hn: hn, fullname: fullname });
        $('#txt_reg_hn').select2('enable', false);

        $('#txt_reg_age').val(age);
        $('#txt_reg_birthdate').val(birthdate);

        //get disability detail
        death.get_detail(hn);
        death.modal.show_register();
    });

    /**
     * Remove
     */
    $(document).on('click', 'a[data-name="btn_remove"]', function(){
        var hn = $(this).data('hn');
        var dchstatus = null;

        if(confirm('คุณต้องการเปลี่ยนสถานะการจำหน่ายเป็น ไม่จำหน่าย [9] หรือไม่?'))
        {
            dchstatus = '9';
        }
        //app.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?', function(res){
       if(confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?'))
       {
           death.ajax.remove(hn, dchstatus, function(err){
               if(err)
               {
                   app.alert(err);
               }
               else
               {
                   app.alert('ลบข้อมูลเสร็จเรียบร้อยแล้ว');
                   death.get_list();
               }
           });
       }
        //});

    });

    $('#mdl_register').on('hidden', function(){
        death.clear_form();
    });

    //search
    $('#btn_search').on('click', function(){
        var data = $('#txt_query').select2('data');

        if(data === null)
        {
            app.alert('กรุณาระบุคำค้นหา');
        }
        else
        {
            $('#main_paging').fadeOut('slow');

            if(!data.hn)
            {
                app.alert('กรุณาระบุคำค้นหา โดยระบุชื่อ-สกุล หรือ เลขบัตรประชาชน หรือ HN');
            }
            else
            {
                $('#tbl_list > tbody').empty();

                death.ajax.search(data.hn, function(err, data){
                    if(err)
                    {
                        app.alert(err);
                        $('#tbl_list > tbody').append('<tr><td colspan="9">ไม่พบข้อมูล</td></td></tr>');
                    }
                    else
                    {
                        death.set_list(data);
                    }
                });
            }
        }

    });

    //refresh list
    $('#btn_refresh').on('click', function(e) {
        e.preventDefault();
        death.get_list();
    });

    //load list at first time
    death.get_list();
});