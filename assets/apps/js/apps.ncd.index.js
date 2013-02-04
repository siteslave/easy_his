/**
 * NCD scripts
 *
 * @author      Mr.Satit Riapit <mr.satit@outlook.com>
 * @copyright   Copyright 2013, Mr.Satit Rianpit
 * @since       Version 1.0
 */
head.ready(function(){
    // NCD name space with object.
    var ncd = {};
    ncd.update = {};

    //------------------------------------------------------------------------------------------------------------------
    //ajax object
    ncd.ajax = {
        /**
         * Get person list
         *
         * @param   start
         * @param   stop
         * @param   cb
         */
        get_list: function(start, stop, cb){
            var url = 'ncd/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'ncd/get_list_total',
                params = {};

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

        get_list_by_house: function(house_id, cb){
            var url = 'ncd/get_list_by_house',
                params = {
                    house_id: house_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        search_person: function(query, filter, cb){
            var url = 'ncd/search_person',
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
            var url = 'ncd/do_register',
                params = {
                    hn: hn
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        check_registration: function(hn, cb){
            var url = 'ncd/check_registration',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };
    
    ncd.update.ajax = {
        remove_ncd_register: function(person_id, cb) {
            var url = 'ncd/remove_ncd_register',
                params = {
                    person_id: person_id
                };
            
            app.ajax(url, params, function(err, data) {
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    ncd.modal = {
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
        hide_register: function()
        {
            $('#mdl_register').modal('hide');
        }
    };
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Set person list
     *
     * @param data
     */

    ncd.set_list = function(data){
        if(_.size(data.rows) > 0){
            _.each(data.rows, function(v){
                $('#tbl_ncd_list > tbody').append(
                    '<tr>' +
                        '<td>' + v.hn + '</td>' +
                        '<td>' + app.clear_null(v.cid) + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.reg_date) + '</td>' +
                        '<td>' + v.first_name +' '+ v.last_name + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.birthdate) + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>' + v.sex + '</td>' +
                        '<td>' +
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0);" class="btn btn-danger" data-name="remove" data-id="' + v.id + '"><i class="icon-trash"></i></a>' +
                        '</div>' +
                        '</td>' +
                        '</tr>'
                );
            });
        }else{
            $('#tbl_ncd_list > tbody').append(
                '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
            );
        }
    };
    ncd.get_list = function(){
        $('#main_paging').fadeIn('slow');
        ncd.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        ncd.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_ncd_list > tbody').empty();
                            if(err){
                                app.alert(err);
                            }else{
                                ncd.set_list(data);
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
        ncd.modal.show_register();
    });


    ncd.set_search_person_result = function(data)
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

            ncd.ajax.search_person(query, filter, function(err, data){

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
                   ncd.set_search_person_result(data);
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
        var hn = $(this).attr('data-hn');

        if(confirm('คุณต้องการลงทะเบียนข้อมูลนี้ใช่หรือไม่?'))
        {
            //do register
            ncd.ajax.do_register(hn, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('ลงทะเบียนรายการเสร็จเรียบร้อยแล้ว');
                    ncd.modal.hide_register();
                    ncd.get_list();
                }
            });
        }
    });

    $('#sl_village').on('change', function(){
        var village_id = $(this).val();

        ncd.ajax.get_house_list(village_id, function(err, data){
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

    $('#btn_do_get_list').click(function(){
        var house_id = $('#sl_house').val();

        ncd.ajax.get_list_by_house(house_id, function(err, data){

            $('#tbl_ncd_list > tbody').empty();

           if(err)
           {
               app.alert(err);
               $('#tbl_ncd_list > tbody').append(
                   '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
               );
           }
            else
           {
               if(data)
               {
                   $('#main_paging').fadeOut('slow');
                   ncd.set_list(data);
               }
               else
               {
                   $('#tbl_ncd_list > tbody').append(
                       '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
                   );
               }
           }
        });
    });
    
    $('a[data-name="remove"]').live('click', function() {
        var person_id = $(this).attr('data-id');
        //Confirm remove NCD data
        app.confirm('คุณต้องการจะลบรายการนี้หรือไม่?', function(cb) {
            if(cb) {
                ncd.update.ajax.remove_ncd_register(person_id, function(err) {
                    if(err) {
                        app.alert(err);
                    } else {
                        app.alert('ลบรายการเรียบร้อยแล้ว');
                        
                        ncd.get_list();
                    }
                });
            }
        });
    });
<<<<<<< HEAD

=======
<<<<<<< HEAD
    
=======

>>>>>>> master
>>>>>>> ncd
    ncd.get_list();
});