/**
 * Pregnancies scripts
 *
 * @author      Mr.Satit Riapit <mr.satit@outlook.com>
 * @copyright   Copyright 2013, Mr.Satit Rianpit
 * @since       Version 1.0
 */
head.ready(function(){
    // Pregnancies name space with object.
    var preg = {};

    //------------------------------------------------------------------------------------------------------------------
    //ajax object
    preg.ajax = {
        search_person: function(query, filter, cb){
            var url = 'pregnancies/search_person',
                params = {
                    query: query,
                    filter: filter
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(start, stop, cb){
            var url = 'pregnancies/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'pregnancies/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        do_register: function(data, cb){
            var url = 'pregnancies/do_register',
                params = {
                    data: data
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        check_registration: function(hn, cb){
            var url = 'pregnancies/check_registration',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }

    };

    preg.modal = {
        show_register: function()
        {
            $('#mdl_register').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        show_labor: function()
        {
            $('#mdl_labor').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_register: function()
        {
            $('#mdl_register').modal('hide');
        },
        hide_labor: function()
        {
            $('#mdl_labor').modal('hide');
        }
    };
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Set person list
     *
     * @param data
     */

    preg.set_list = function(data){
        $('#tbl_list > tbody').empty();
        if(_.size(data.rows) > 0){
            _.each(data.rows, function(v){
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.anc_code +'</td>' +
                        '<td>' + v.hn + '</td>' +
                        '<td>' + app.clear_null(v.cid) + '</td>' +
                        '<td>' + v.first_name +' '+ v.last_name + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.birthdate) + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.reg_date) + '</td>' +
                        '<td>'+ v.gravida +'</td>' +
                        '<td>'+ v.preg_status +'</td>' +
                        '<td>' +
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0);" class="btn" data-name="labor" data-hn="' + v.hn + '" title="ข้อมูลการคลอด"><i class="icon-check"></i></a>' +
                        '<a href="javascript:void(0);" class="btn" data-name="remove" data-id="' + v.id + '"><i class="icon-trash"></i></a>' +
                        '</div>' +
                        '</td>' +
                        '</tr>'
                );
            });
        }else{
            $('#tbl_list > tbody').append(
                '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
            );
        }
    };
    preg.get_list = function(){
        $('#main_paging').fadeIn('slow');
        $('#tbl_list > tbody').empty();
        preg.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_list > tbody').append(
                    '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
                );
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        preg.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                            }else{
                                preg.set_list(data);
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
        preg.modal.show_register();
    });


    preg.set_search_person_result = function(data)
    {
        _.each(data.rows, function(v)
        {
            $('#tbl_search_person_result > tbody').append(
                '<tr>' +
                    '<td>'+ v.hn +'</td>' +
                    '<td>'+ v.cid +'</td>' +
                    '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                    '<td>'+ app.mongo_to_thai_date(v.birthdate) +'</td>' +
                    '<td>'+ v.age +'</td>' +
                    '<td>'+ v.sex +'</td>' +
                    '<td><a href="javascript:void(0);" data-name="btn_selected_person" class="btn" data-hn="'+ v.hn +'"><i class="icon-ok"></i></a></td>' +
                    '</tr>'
            );
        });
    };

    //search person
    $('#btn_do_search_person').click(function(){
        var query = $('#txt_query_person').val(),
            filter = $('input[data-name="txt_search_person_filter"]').val();

        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา โดยระบุชื่อ-สกุล หรือ HN หรือ เลขบัตรประชาชน');
        }
        else
        {
            //do search
            $('#tbl_search_person_result > tbody').empty();

            preg.ajax.search_person(query, filter, function(err, data){

                if(err)
                {
                    app.alert(err);
                }
                else if(!data)
                {
                    app.alert('ไม่พบรายการ');
                }
                else
                {
                   preg.set_search_person_result(data);
                }
            });
        }
    });

    //set filter
    $('a[data-name="btn_set_search_person_filter"]').click(function(){
        var filter = $(this).attr('data-value');

        $('input[data-name="txt_search_person_filter"]').val(filter);
    });

    $('a[data-name="btn_selected_person"]').live('click', function(){

        var gravida = prompt('กรุณาระบุครรภ์ที่', 1);

        if(gravida || gravida > 0)
        {
            var data = {};
            data.hn = $(this).attr('data-hn');
            data.gravida = gravida;

            if(confirm('คุณต้องการลงทะเบียนข้อมูลนี้ใช่หรือไม่?'))
            {
                //do register
                preg.ajax.do_register(data, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลงทะเบียนรายการเสร็จเรียบร้อยแล้ว');
                        preg.modal.hide_register();
                        preg.get_list();
                    }
                });
            }
        }
    });

    $('#sl_village').on('change', function(){
        var village_id = $(this).val();

        preg.ajax.get_house_list(village_id, function(err, data){
            if(err)
            {
                app.alert(err);
            }
            else
            {
                if(data)
                {
                    $('#sl_house').empty();
                   // $('#sl_house').append('<option value="00000000">ทั้งหมด</option>');

                    _.each(data.rows, function(v){
                        $('#sl_house').append('<option value="'+ v.id +'">' + v.house + '</option>');
                    });

                }
            }
        });
    });

    //labor detail
    $('a[data-name="labor"]').live('click', function(){
        var hn = $(this).attr('data-hn');

        //show labor detail

        preg.modal.show_labor();
    });

    preg.get_list();
});