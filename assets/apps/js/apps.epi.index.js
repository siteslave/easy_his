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
        },
        get_history: function(hn, cb){
            var url = 'epis/history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        remove_vaccine: function(id, cb){
            var url = 'epis/remove_vaccine',
                params = {
                    id: id
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
            });
        },
        hide_register: function()
        {
            $('#mdl_search_person').modal('hide');
        },
        show_new: function(hn)
        {
            app.load_page($('#mdl_vaccines'), '/pages/vaccines/' + hn, 'assets/apps/js/pages/vaccines.js');
            $('#mdl_vaccines').modal({keyboard: false});
        },
        show_update: function(hn, id)
        {
            app.load_page($('#mdl_vaccines'), '/pages/update_vaccines/' + hn + '/' + id, 'assets/apps/js/pages/vaccines.js');
            $('#mdl_vaccines').modal({keyboard: false});
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

                var html = '<button type="button" class="btn btn-success" data-name="btn_add_cover" ' +
                    'data-hn="'+ v.hn +'"><i class="fa fa-plus-circle"></i> วัคซีนจากที่อื่น</button>';

                if(_.size(v.history) > 0)
                {
                    html +=
                        '<table style="width: 690px;" class="table table-striped">' +
                        '<thead>' +
                        '<tr>' +
                        '<th>วันที่</th>' +
                        '<th>ชื่อวัคซีน</th>' +
                        '<th>สถานพยาบาล</th>' +
                        '<th></th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';


                    _.each(v.history, function(h){
                        html += '<tr>' +
                            '<td>'+ h.date_serv +'</td>' +
                            '<td>'+ app.clear_null(h.vaccine_name) +'</td>' +
                            '<td>['+ h.hospcode +'] ' + h.hospname + '</td>' +
                            '<td><div class="btn-group">' +
                            '<a href="#" data-hn="'+ v.hn +'" data-id="'+ h.id +'" data-name="btn_edit_vaccine" rel="tooltip" title="แก้ไขวัคซีน"' +
                            'class="btn btn-success btn-small"><i class="fa fa-edit"></i></a>' +
                            '<a href="#" class="btn btn-danger" data-id="'+ h.id +'" data-name="btn_remove_vaccine" rel="tooltip" title="ลบรายการวัคซีน">' +
                            '<i class="fa fa-trash-o"></i></a>' +
                            '</div></td>' +
                            '</tr>'
                    });

                    html += '</tbody></table>';
                }
                else
                {
                    html += '<table style="width: 650px;" class="table table-striped">' +
                        '<thead>' +
                        '<tr>' +
                        '<th>วันที่</th>' +
                        '<th>ชื่อวัคซีน</th>' +
                        '<th>สถานพยาบาล</th>' +
                        '<th></th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                        '<tr>' +
                        '<td colspan="4">ไม่พบรายการ</td>' +
                        '</tr></tbody>' +
                        '</table>';
                }

                $('#tbl_epi_list > tbody').append(
                    '<tr>' +
                        '<td>' + v.hn + '</td>' +
                        '<td>' + app.clear_null(v.cid) + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.reg_date) + '</td>' +
                        '<td>' + v.first_name +' '+ v.last_name + '</td>' +
                        '<td>' + app.mongo_to_thai_date(v.birthdate) + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>*</td>' +
//                        '<td>' +
//                        '<div class="progress"><div class="progress-bar progress-bar-success" style="width: 55%;" title="55%"></div></div>' +
//                        '</td>' +
                        '<td>' +
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0);" class="btn btn-success btn-small" data-name="cover_history" ' +
                        'data-title="ประวัติการรับวัคซีน" rel="tooltip" data-content="' + app.html_safe(html) + '" title="ดูประวัติการรับวัคซีน"><i class="fa fa-share-square"></i></a>' +
                        '<a href="javascript:void(0);" rel="tooltip" class="btn btn-danger btn-small" data-name="remove" title="จำหน่ายรายการ" ' +
                        'data-hn="' + v.hn + '"><i class="fa fa-trash-o"></i></a>' +
                        '</div>' +
                        '</td>' +
                        '</tr>'
                );

                $('a[data-name="cover_history"]').popover({
                    html: true,placement: 'left'
                });

                app.set_runtime();
            });
        }else{
            $('#tbl_epi_list > tbody').append(
                '<tr><td colspan="7">ไม่พบรายการ</td></tr>'
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
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('epi_curent_page'),
                    onSelect: function(page){
                        app.set_cookie('epi_current_page', page);
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
                    onFormat: app.paging_format
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
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('epi_village_current_page'),
                    onSelect: function(page){
                        app.set_cookie('epi_village_current_page', page);
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
                    onFormat: app.paging_format
                });
            }
        });
    };

    $('#btn_register').click(function(){
        epi.modal.show_register();
    });

    //search person
    $('#txt_search_query').select2({
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

    $('#btn_do_register_epi').on('click', function(){

         var person = $('#txt_search_query').select2('data');
        if(person === null) {
          alert('กรุณาระบุข้อมูลที่ต้องการ');
        } else {
          if(person.typearea == '1' || person.typearea == '3')
          {
            var hn = person.hn;

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
          else
          {
            app.alert('บุคคลนี้ไม่ใช่บุคคลในเขตรับผิดชอบ (Typearea ไม่ใช่ 1 หรือ 3) Typearea ปัจจุบันคือ ' + person.typearea);
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

    epi.get_history = function(hn, cb){
        var html;
        epi.ajax.get_history(hn, function(err, data){
            if(err)
            {
                html = '<table style="width: 650px;">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>วันที่</th>' +
                    '<th>ชื่อวัคซีน</th>' +
                    '<th>สถานพยาบาล</th>' +
                    '<th></th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                    '<tr>' +
                    '<td colspan="4">ไม่พบรายการ</td>' +
                    '</tr></tbody>' +
                '</table>';
            }
            else
            {
                html = '<table style="width: 650px;">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>วันที่</th>' +
                    '<th>ชื่อวัคซีน</th>' +
                    '<th>สถานพยาบาล</th>' +
                    '<th></th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';


                _.each(data.rows, function(v){
                    html += '<tr>' +
                        '<td>'+ v.date_serv +'</td>' +
                        '<td>'+ app.clear_null(v.vaccine_name) +'</td>' +
                        '<td>['+ v.hospcode +'] ' + v.hospname + '</td>' +
                        '<td><a href="#" class="btn btn-success btn-small"><i class="fa fa-edit"></i></a></td>' +
                    '</tr>'
                });



                html += '</tbody></table>';
            }

            cb(html);
        });
    };

    $(document).on('click', 'button[data-name="btn_add_cover"]', function(){
        var hn = $(this).data('hn');
        epi.modal.show_new(hn);
    });

    $(document).on('click', 'a[data-name="btn_edit_vaccine"]', function(){
        var hn = $(this).data('hn'),
            id = $(this).data('id');
        epi.modal.show_update(hn, id);
    });
    $(document).on('click', 'a[data-name="btn_remove_vaccine"]', function(){
        var id = $(this).data('id'),
            obj = $(this).parent().parent().parent();

        app.confirm('คุณต้องการลบรายการวัคซีนนี้ ใช่หรือไม่?', function(res){
            if(res)
            {
                epi.ajax.remove_vaccine(id, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลบรายการวัคซีนนี้เสร็จเรียบร้อยแล้ว');
                        obj.fadeOut('slow');
                    }
                });
            }
        });
    });

    epi.get_list();
});