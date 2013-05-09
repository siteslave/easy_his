head.ready(function(){
    var disb = {};

    disb.modal = {
        show_register: function(){
            $('#mdl_register').modal({
                backdrop: 'static'
            }).css({
                width: 960,
                'margin-left': function() {
                    return -($(this).width() / 2);
                }
            });
        },
        show_search_person: function(){
            $('#mdl_search_person').modal({
                backdrop: 'static'
            }).css({
                width: 960,
                'margin-left': function() {
                    return -($(this).width() / 2);
                }
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
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        disb.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_list > tbody').empty();
                            if(err){
                                app.alert(err);
                            }else{
                                disb.set_list(data);
                            }

                        });

                    },
                    onFormat: function(type){
                        switch (type) {

                            case 'block':

                                if (!this.active)
                                    return '<li class="disabled"><a href="">' + this.value + '</a></li>';
                                else if (this.value != this.page)
                                    return '<li><a href="#' + this.value + '">' + this.value + '</a></li>';
                                return '<li class="active"><a href="#">' + this.value + '</a></li>';

                            case 'right':
                            case 'left':

                                if (!this.active) {
                                    return "";
                                }
                                return '<li><a href="#' + this.value + '">' + this.value + '</a></li>';

                            case 'next':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&raquo;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&raquo;</a></li>';

                            case 'prev':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&laquo;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&laquo;</a></li>';

                            case 'first':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&lt;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&lt;</a></li>';

                            case 'last':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&gt;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&gt;</a></li>';

                            case 'fill':
                                if (this.active) {
                                    return '<li class="disabled"><a href="#">...</a></li>';
                                }
                        }
                        return ""; // return nothing for missing branches
                    }
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
                        '<a href="javascript:void(0);" data-name="btn_edit" class="btn" data-hn="'+ v.hn +'" ' +
                        'data-cid="'+ v.cid +'" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-age="'+ v.age +'" data-birthdate="'+ app.mongo_to_thai_date(v.birthdate) +'" data-id="'+ v.id +'">' +
                        '<i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_remove" class="btn" data-id="'+ v.id +'">' +
                        '<i class="icon-trash"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };
    //search diagnosis
    $('#txt_icdcode').typeahead({
        ajax: {
            url: site_url + 'basic/search_icd_ajax',
            timeout: 500,
            displayField: 'name',
            triggerLength: 3,
            preDispatch: function(query){
                return {
                    query: query,
                    csrf_token: csrf_token
                }
            },

            preProcess: function(data){
                if(data.success){
                    return data.rows;
                }else{
                    return false;
                }
            }
        },
        updater: function(data){
            var d = data.split('#');
            var code = d[0],
                name = d[1];

            $('#txt_icdcode').val(code);
            $('#txt_icdname').val(name);

            return code;
        }
    });

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
        $('#sl_disb_types').removeAttr('disabled');
        app.set_first_selected($('#sl_disb_types'));
        app.set_first_selected($('#sl_disp_cause'));
        $('#txt_icdcode').val('');
        $('#txt_icdname').val('');
        $('#txt_detect_date').val('');
        $('#txt_disab_date').val('');
        $('#txt_update_id').val('');
        $('#btn_search_person').removeAttr('disabled');
    };

    $('#btn_save_disb').click(function(){
        var data = {};

        data.hn = $('#txt_hn').val();
        data.did = $('#txt_did').val();
        data.dtype = $('#sl_disb_types').val();
        data.dcause = $('#sl_disp_cause').val();
        data.diag_code = $('#txt_icdcode').val();
        data.detect_date = $('#txt_detect_date').val();
        data.disb_date = $('#txt_disab_date').val();
        //data.id = $('#txt_update_id').val();

        if(!data.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!data.dtype)
        {
            app.alert('ประเภทความพิการ');
        }
        else if(!data.dcause)
        {
            app.alert('สาเหตุความพิการ');
        }
        else if(!data.diag_code)
        {
            app.alert('กรุณาระบุรหัสโรคหรือการบาดเจ็บที่เป็นสาเหตุของความพิการ');
        }
        else if(!data.detect_date)
        {
            app.alert('กรุณาระบุวันที่ตรวจพบความพิการ');
        }
        else if(!data.disb_date)
        {
            app.alert('กรุณาระบุวันที่เริ่มมีความพิการ');
        }
        else
        {
            disb.ajax.save(data, function(err){
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

    disb.set_search_person_result = function(data)
    {
        if(!data)
        {
            $('#tbl_search_person_result > tbody').append(
                '<tr><td colspan="7">ไม่พบรายการ</td></tr>');
        }
        else
        {
            _.each(data.rows, function(v){
                var t = typeof v.typearea == 'undefined' || 'null' ? '0' : '1';
                $('#tbl_search_person_result > tbody').append(
                    '<tr>' +
                        '<td>'+ v.hn +'</td>' +
                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>'+ app.mongo_to_thai_date(v.birthdate) +'</td>' +
                        '<td>'+ v.age +'</td>' +
                        '<td>'+ v.sex +'</td>' +
                        '<td><a href="#" class="btn" data-hn="'+ v.hn + '" data-cid="'+ v.cid +'" ' +
                        'data-fullname="'+ v.first_name + ' ' + v.last_name +'" data-name="btn_selected_person" ' +
                        'data-sex="'+ v.sex +'" data-age="'+ v.age +'" data-birthdate="'+ app.mongo_to_thai_date(v.birthdate) +'" data-owner="'+ t +'">' +
                        '<i class="icon-ok"></i></a></td>' +
                        '</tr>');
            });
        }
    };

    //search person
    $('#btn_do_search_person').click(function(){
        var query = $('#txt_search_query').val(),
            filter = $('#txt_search_person_filter').val();

        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา โดยระบุชื่อ-สกุล หรือ HN หรือ เลขบัตรประชาชน');
        }
        else
        {
            //do search
            $('#tbl_search_person_result > tbody').empty();

            disb.ajax.search_person(query, filter, function(err, data){

                if(err)
                {
                    app.alert(err);
                    $('#tbl_search_person_result > tbody').append(
                        '<tr><td colspan="7">ไม่พบรายการ</td></tr>');
                }
                else
                {
                    disb.set_search_person_result(data);
                }
            });
        }
    });

    $('a[data-name="btn_search_person_fillter"]').click(function(){
        var filter = $(this).data('value');

        $('#txt_search_person_filter').val(filter);
    });

    $(document).on('click', 'a[data-name="btn_selected_person"]', function(){

        if($(this).data('owner') == '0')
        {
            app.alert('บุคคลนี้ไม่ใช่บุคคลในเขตรับผิดชอบ');
        }
        else
        {
            var hn = $(this).data('hn'),
                cid = $(this).data('cid'),
                fullname = $(this).data('fullname'),
                age = $(this).data('age'),
                birthdate = $(this).data('birthdate');

            $('#txt_fullname').val(fullname);
            $('#txt_hn').val(hn);
            $('#txt_cid').val(cid);
            $('#txt_age').val(age);
            $('#txt_birthdate').val(birthdate);

            disb.modal.hide_search_person();
        }
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
        $('#sl_disb_types').val(data.rows.dtype);
        $('#sl_disp_cause').val(data.rows.dcause);
        $('#txt_icdcode').val(data.rows.diag_code);
        $('#txt_icdname').val(data.rows.diag_name);
        $('#txt_detect_date').val(data.rows.detect_date);
        $('#txt_disab_date').val(data.rows.disb_date);
    };

    $(document).on('click', 'a[data-name="btn_edit"]', function(){
        var hn = $(this).attr('data-hn'),
            cid = $(this).attr('data-cid'),
            fullname = $(this).attr('data-fullname'),
            age = $(this).attr('data-age'),
            birthdate = $(this).attr('data-birthdate'),
            id = $(this).attr('data-id');

        $('#btn_search_person').attr('disabled', 'disabled');
        $('#txt_fullname').val(fullname);
        $('#txt_hn').val(hn);
        $('#txt_cid').val(cid);
        $('#txt_age').val(age);
        $('#txt_birthdate').val(birthdate);
        //$('#txt_update_id').val(id);

       $('#sl_disb_types').attr('disabled', 'disabled').css('background-color', 'white');
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
        var id = $(this).attr('data-id');

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