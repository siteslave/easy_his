/**
 * EPI scripts
 *
 * @author      Mr.Satit Riapit <mr.satit@outlook.com>
 * @copyright   Copyright 2013, Mr.Satit Rianpit
 * @since       Version 1.0
 */
head.ready(function(){
    // EPI name space with object.
    var epi = {};

    //------------------------------------------------------------------------------------------------------------------
    //ajax object
    epi.ajax = {
        /**
         * Get person list
         *
         * @param   start
         * @param   stop
         * @param   cb
         */
        get_list: function(start, stop, cb){
            var url = 'epis/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'epis/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_by_village: function(village_id, start, stop, cb){
            var url = 'epis/get_list_by_village',
                params = {
                    start: start,
                    stop: stop,
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_by_village_total: function(village_id, cb){
            var url = 'epis/get_list_by_village_total',
                params = {
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
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

        do_register: function(hn, cb){
            var url = 'epis/do_register',
                params = {
                    hn: hn
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        check_registration: function(hn, cb){
            var url = 'epis/check_registration',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        remove: function(hn, cb){
            var url = 'epis/remove',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    epi.modal = {
        show_register: function()
        {
            $('#mdl_search_person').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_register: function()
        {
            $('#mdl_search_person').modal('hide');
        }
    };
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Set person list
     *
     * @param data
     */

    epi.set_list = function(data){
        if(_.size(data.rows) > 0){
            _.each(data.rows, function(v){
                $('#tbl_epi_list > tbody').append(
                    '<tr>' +
                        '<td>' + v.hn + '</td>' +
                        '<td>' + app.clear_null(v.cid) + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.reg_date) + '</td>' +
                        '<td>' + v.first_name +' '+ v.last_name + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.birthdate) + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>35%</td>' +
                        '<td>' +
                        '<div class="progress progress-success"><div class="bar" style="width: 55%;" title="35%"></div></div>' +
                        '</td>' +
                        '<td>' +
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0);" class="btn" title="ความครอบคลุม" data-name="edit" data-vname="' + v.name + '" data-id="' + v.id + '"><i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0);" class="btn" data-name="remove" title="จำหน่ายรายการ" data-hn="' + v.hn + '"><i class="icon-trash"></i></a>' +
                        '</div>' +
                        '</td>' +
                        '</tr>'
                );
            });
        }else{
            $('#tbl_epi_list > tbody').append(
                '<tr><td colspan="9">ไม่พบรายการ</td></tr>'
            );
        }
    };
    epi.get_list = function(){
        $('#main_paging').fadeIn('slow');
        epi.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_epi_list > tbody').append(
                    '<tr><td colspan="9">ไม่พบรายการ</td></tr>'
                );
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        epi.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_epi_list > tbody').empty();
                            if(err){
                                app.alert(err);
                                $('#tbl_epi_list > tbody').append(
                                    '<tr><td colspan="9">ไม่พบรายการ</td></tr>'
                                );
                            }else{
                                epi.set_list(data);
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
    epi.get_list_by_village = function(village_id){
        $('#main_paging').fadeIn('slow');
        epi.ajax.get_list_by_village_total(village_id, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_epi_list > tbody').append(
                    '<tr><td colspan="9">ไม่พบรายการ</td></tr>'
                );
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        epi.ajax.get_list_by_village(village_id, this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_epi_list > tbody').empty();
                            if(err){
                                app.alert(err);
                                $('#tbl_epi_list > tbody').append(
                                    '<tr><td colspan="9">ไม่พบรายการ</td></tr>'
                                );
                            }else{
                                epi.set_list(data);
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

    $('#btn_register').click(function(){
        epi.modal.show_register();
    });


    epi.set_search_person_result = function(data)
    {
        if(!data)
        {
            $('#tbl_search_person_result > tbody').append(
                '<tr><td colspan="7">ไม่พบรายการ</td></tr>');
        }
        else
        {
            _.each(data.rows, function(v){
                $('#tbl_search_person_result > tbody').append(
                    '<tr>' +
                        '<td>'+ v.hn +'</td>' +
                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>'+ app.mongo_to_thai_date(v.birthdate) +'</td>' +
                        '<td>'+ v.age +'</td>' +
                        '<td>'+ v.sex +'</td>' +
                        '<td><a href="#" class="btn" data-hn="'+ v.hn + '" data-name="btn_selected_person" data-typearea="'+ v.typearea +'">' +
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

            epi.ajax.search_person(query, filter, function(err, data){

                if(err)
                {
                    app.alert(err);
                    $('#tbl_search_person_result > tbody').append(
                        '<tr><td colspan="7">ไม่พบรายการ</td></tr>');
                }
                else
                {
                   epi.set_search_person_result(data);
                }
            });
        }
    });

    //set filter
    $('a[data-name="btn_search_person_fillter"]').click(function(){
        var filter = $(this).data('value');

        $('#txt_search_person_filter').val(filter);
    });

    $(document).on('click', 'a[data-name="btn_selected_person"]', function(){

        if( ! _.indexOf(['1', '3'], $(this).data('typearea')) ||  !$(this).data('typearea'))
        {
            app.alert('บุคคลนี้ไม่ใช่บุคคลในเขตรับผิดชอบ (Typearea ไม่ใช่ 1 หรือ 3)');
        }
        else
        {
            var hn = $(this).data('hn');

            if(confirm('คุณต้องการลงทะเบียนข้อมูลนี้ใช่หรือไม่?'))
            {
                //do register
                epi.ajax.do_register(hn, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลงทะเบียนรายการเสร็จเรียบร้อยแล้ว');
                        epi.modal.hide_register();
                        epi.get_list();
                    }
                });
            }
        }
    });

    $('#btn_fillter').click(function(e){

        var village_id = $('#sl_village').val();

        if(!village_id)
        {
            epi.get_list();
        }
        else
        {
            epi.get_list_by_village(village_id);
        }

        e.preventDefault();
    });

    $(document).on('click', 'a[data-name="remove"]', function(e){
        var hn = $(this).data('hn');
        var obj = $(this).parent().parent().parent();

        if(confirm('คุณต้องการจำหน่ายออกจากรายการใช่หรือไม่?'))
        {
            epi.ajax.remove(hn, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('จำหน่ายรายการเสร็จเรียบร้อยแล้ว');
                    obj.fadeOut('slow');
                }
            });
        }

        e.preventDefault();

    });

    $('#btn_refresh').on('click', function(e){
        epi.get_list();
        e.preventDefault();
    });

    epi.get_list();
});