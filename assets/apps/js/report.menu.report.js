/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 10/4/2556 15:50 น.
 */
$(function() {
    var rpt = {};

    rpt.ajax = {
        get_list: function(start, stop, cb) {
            var url = 'reports/get_sub_list',
                params = {
                    start: start,
                    stop: stop,
                    group: $('#tboId').val()
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'reports/get_sub_list_total',
                params = { group: $('#tboId').val() };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    rpt.set_list = function(data){
        if(_.size(data.rows) > 0){
            _.each(data.rows, function(v){
                $('#tblList > tbody').append(
                    '<tr>'+
                        '<td>'+ v.name +'</td>'+
                        '<td>'+
                        '<div class="btn-group">'+
                            '<a class="btn btn-success" data-url="'+ v.url +'" id="btnView" title="แสดงรายงาน"><i class="icon-list"></i></a>'+
                            '<!-- <a class="btn btn-info" data-url="'+ v.url +'" id="btnPrint" title="พิมพ์รายงาน"><i class="icon-print"></i></a> -->'+
                        '</div>'+
                        '</td>'+
                        '</tr>'
                );
            });
        }else{
            $('#tblList > tbody').append(
                '<tr><td colspan="3">ไม่พบรายการ</td></tr>'
            );
        }
    };
    rpt.get_list = function(){
        $('#main_paging').fadeIn('slow');
        rpt.ajax.get_list_total(function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        rpt.ajax.get_list(this.slice[0], this.slice[1], function(err, data){
                            $('#tblList > tbody').empty();
                            if(err){
                                app.alert(err);
                            }else{
                                rpt.set_list(data);
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

    rpt.date2_show = function() {
        $('#mdlDate2').modal({
            backdrop: 'static'
        }).css({
            //width: 680,
            'margin-left': function() {
                return -($(this).width() / 2);
            }
        });
    }
    rpt.date2_hide = function() {
        $('#mdlDate2').modal('hide');
    }

    $(document).on('click', '#btnView', function() {
        var url = $(this).attr('data-url');
        if(url.substr(8, 7) == 'date_bw') {
            //app.alert('Date2');
            $('#tboUrl').val(url);
            rpt.date2_show();
        } else {
            location.href=site_url + url;
        }
    });

    $('#btnDate2View').click(function() {
        location.href=site_url + $('#tboUrl').val() + '/' + rpt.ConvertDate($('#tboStart').val()) + '/' + rpt.ConvertDate($('#tboStop').val());
    });

    rpt.ConvertDate = function(d) {
        var _tmp = '';
        _tmp = d.substr(d.lastIndexOf('/')+1, 4) + '-' + d.substr(d.indexOf('/')+1, 2) + '-' + d.substr(0, 2);
        return _tmp;
    }

    $(document).on('click', '#btnPrint', function() {
        //var url = $(this).attr('data-url');
        //location.href=site_url + url + '/print';
    });

    rpt.get_list();
});