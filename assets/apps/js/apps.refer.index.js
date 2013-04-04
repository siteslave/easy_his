/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 11/3/2556 14:12 น.
 */
$(function() {
    var refer = {};

    refer.ajax = {
        get_list_by_date: function(start, stop, date_start, date_stop, cb) {
            var url = 'refer/get_list_by_date',
                params = {
                    start: start,
                    stop: stop,
                    date_start: date_start,
                    date_stop: date_stop
                };
            app.ajax(url, params, function(err, data) {
                err?cb(err):cb(null, data);
            });
        },
        get_list_total_by_date: function(date_start, date_stop, cb) {
            var url = 'refer/get_list_total_by_date',
                params = {
                    date_start: date_start,
                    date_stop: date_stop
                };
            app.ajax(url, params, function(err, data) {
                err?cb(err):cb(null, data);
            });
        },
        show_register_form: function() {
            $('#mdlRegister').modal('show').css({
                width: 800,
                'margin-left': function () {
                    return -($(this).width() / 2);
                }
            });
        },
        hide_register_form: function() {
            $('#mdlRegister').modal('hide');
        },
        show_list_form: function() {
            $('#mdlServiceList').modal('show').css({
                width: 800,
                'margin-left': function () {
                    return -($(this).width() / 2);
                }
            });
        },
        hide_list_form: function() {
            $('#mdlServiceList').modal('hide');
        },
        search_person: function(query, filter, cb){
            var url = 'refer/search_person',
                params = {
                    query: query,
                    filter: filter
                };
            //Do load ajax.
            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    refer.set_search_person_result = function(data)
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
                    '<td><a href="javascript:void(0);" data-name="btn_selected_person" class="btn" data-id="'+ v.id +'" data-hn="'+ v.hn +'"><i class="icon-ok"></i></a></td>' +
                    '</tr>'
            );
        });
    };

    $('a[data-name="btn_set_search_person_filter2"]').click(function(){
        var filter = $(this).attr('data-value');

        $('input[data-name="txt_search_person_filter2"]').val(filter);
    });

    $('#btn_do_search_person').click(function() {
        var query = $('#txt_query_person').val(),
            filter = $('input[data-name="txt_search_person_filter2"]').val();

        if(!query) {
            app.alert('กรุณาระบุคำค้นหา โดยระบุชื่อ-สกุล หรือ HN หรือ เลขบัตรประชาชน');
        } else {
            $('#tbl_search_person_result > tbody').empty();
            refer.ajax.search_person(query, filter, function(err, data) {
                if(err) {
                    app.alert(err);
                } else if(!data) {
                    app.alert('ไม่พบรายการ');
                } else {
                    refer.set_search_person_result(data);
                }
            });
        }
    });

    $('#btnShowRegisterForm').click(function() {
        refer.ajax.show_register_form();
    });

    $(document).on('click', 'a[data-name="btn_selected_person"]', function(e) {
        e.preventDefault();
        $('#tblServiceList > tbody').empty();

        var url = 'refer/get_visit',
            params = {
                id: $(this).attr('data-id'),
                hn: $(this).attr('data-hn')
            };

        app.ajax(url, params, function(err, data) {
            if(data != null) {
                if(_.size(data.rows) > 0) {
                    _.each(data.rows, function(v) {
                        $('#tblServiceList > tbody').append(
                            '<tr>' +
                                '<td>'+ v.vn +'</td>' +
                                '<td>'+ app.mongo_to_thai_date(v.date) +' '+ v.time +'</td>' +
                                '<td>'+ v.cc +'</td>' +
                                '<td>' +
                                    '<a id="btnRegisterRefer" class="btn" data-hn="'+ v.hn +'" data-vn="'+ v.vn +'"><i class="icon-check"></i></a>' +
                                '</td>' +
                            '</tr>'
                        );
                    });

                    refer.ajax.hide_register_form();
                    refer.ajax.show_list_form();
                } else {
                    app.alert('ไม่พบข้อมูลบริการ');
                }
            } else {
                app.alert(err);
            }
        });
    });

    $('#btnCancelServiceList').click(function() {
        refer.ajax.hide_list_form();
        refer.ajax.show_register_form();
    });

    $(document).on('click', '#btnRegisterRefer', function() {
        location.href = site_url + 'refer/register/' + $(this).attr('data-hn') + '/' + $(this).attr('data-vn');
    });

    $('#mainTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
});