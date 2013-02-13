/**
 * DM scripts
 *
 * @author      Mr.Utit Sairat <soodteeruk@gmail.com>
 * @copyright   Copyright 2013, Mr.Utit Sairat
 * @since       Version 1.0
 */
head.ready(function(){
    // DM name space with object.
    var dm = {};
    dm.update = {};

    //------------------------------------------------------------------------------------------------------------------
    //ajax object
    dm.ajax = {
        /**
         * Get person list
         *
         * @param   start
         * @param   stop
         * @param   cb
         */
        get_list: function(start, stop, cb){
            var url = 'dm/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'dm/get_list_total',
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
            var url = 'dm/get_list_by_house',
                params = {
                    house_id: house_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },

        search_person: function(query, filter, cb){
            var url = 'dm/search_person',
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
            var url = 'dm/do_register',
                params = {
                    hn: hn
                }

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        check_registration: function(hn, cb){
            var url = 'dm/check_registration',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };
    
    dm.update.ajax = {
        remove_ncd_register: function(person_id, cb) {
            var url = 'dm/remove_dm_register',
                params = {
                    person_id: person_id
                };
            
            app.ajax(url, params, function(err, data) {
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    dm.modal = {
        show_register: function()
        {
            $('#mdlNewRegister').modal({
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
            $('#mdlNewRegister').modal('hide');
        }
    };
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Set person list
     *
     * @param data
     */

    dm.set_list = function(data){
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
    dm.get_list = function(){
        $('#main_paging').fadeIn('slow');
        dm.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        dm.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            $('#tbl_ncd_list > tbody').empty();
                            if(err){
                                app.alert(err);
                            }else{
                                dm.set_list(data);
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
        dm.modal.show_register();
    });

    dm.set_search_person_result = function(data)
    {
        _.each(data.rows, function(v)
        {
            $('#tboHN').val(v.hn);
            $('#tboCid').val(v.cid);
            $('#tboFname').val(v.first_name);
            $('#tboLname').val(v.last_name);
            $('#tboAge').val(v.age);
            $('#slSex').val(v.sex);
            
            $('#tboRegCenterNumber').focus();
        });
    };

    //search person
    $('#btnSearch').click(function(){
        var query = $('#tboSearch').val(),
            filter = $('input[data-name="txt_search_person_filter"]').val();

        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา โดยระบุ HN หรือ เลขบัตรประชาชน');
        }
        else
        {
            //do search
            dm.clear_register_form();

            dm.ajax.search_person(query, filter, function(err, data){

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
                   dm.set_search_person_result(data);
                }
            });
        }
    });
    
    //set filter
    $('a[data-name="btn_set_search_person_filter"]').click(function(){
        var filter = $(this).attr('data-value');

        $('input[data-name="txt_search_person_filter"]').val(filter);
    });

    $('#sl_village').on('change', function(){
        var village_id = $(this).val();

        dm.ajax.get_house_list(village_id, function(err, data){
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

        dm.ajax.get_list_by_house(house_id, function(err, data){

            $('#tbl_ncd_list > tbody').empty();

           if(err)
           {
               app.alert(err);
               $('#tbl_list > tbody').append(
                   '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
               );
           }
            else
           {
               if(data)
               {
                   $('#main_paging').fadeOut('slow');
                   dm.set_list(data);
               }
               else
               {
                   $('#tbl_list > tbody').append(
                       '<tr><td colspan="8">ไม่พบรายการ</td></tr>'
                   );
               }
           }
        });
    });
    
    dm.clear_register_form = function() {
        var d = new Date();
        $('#tboHN').val('');
        $('#tboCid').val('');
        $('#tboFname').val('');
        $('#tboLname').val('');
        $('#tboAge').val('');
        $('#slSex').val('ชาย');
        $('#tboRegCenterNumber').val('');
        $('#tboRegHosNumber').val('');
        $('#tboYear').val('');
        $('#dtpRegisDate').val((d.getDate()<10?'0'+d.getDate():d.getDate()) + '/' + (d.getMonth()<10?'0'+d.getMonth():d.getMonth()) + '/' + d.getFullYear());
        $('#cboDiseaseType').val('');
        $('#cboDoctor').val('');
        
    };
    
    $('#mdlNewRegister').on('hidden', function() {
        dm.clear_register_form();
    });
    
    $('a[data-name="remove"]').live('click', function() {
        var person_id = $(this).attr('data-id');
        //Confirm remove DM data
        app.confirm('คุณต้องการจะลบรายการนี้หรือไม่?', function(cb) {
            if(cb) {
                dm.update.ajax.remove_ncd_register(person_id, function(err) {
                    if(err) {
                        app.alert(err);
                    } else {
                        app.alert('ลบรายการเรียบร้อยแล้ว');
                        
                        dm.get_list();
                    }
                });
            }
        });
    });
    
    $('#btn_do_register').click(function() {
        app.alert('Test');
    });

    dm.get_list();
});