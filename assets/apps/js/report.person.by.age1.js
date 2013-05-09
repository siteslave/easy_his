/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 17/4/2556 15:51 น.
 */
$(function() {
    var rpt = {};

    rpt.ajax = {
        get_list: function(start, stop, cb) {
            var url = 'person_by_age1/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'person_by_age1/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    rpt.set_list = function(data){
        if(_.size(data.rows) > 0){
            var a0001m = 0, a0001f = 0,
                a0104m = 0, a0104f = 0,
                a0509m = 0, a0509f = 0,
                a1014m = 0, a1014f = 0,
                a1519m = 0, a1519f = 0,
                a2024m = 0, a2024f = 0,
                a2529m = 0, a2529f = 0,
                a3034m = 0, a3034f = 0,
                a3539m = 0, a3539f = 0;
            _.each(data.rows, function(v){
                a0001m += v.age0001m;   a0001f += v.age0001f;
                a0104m += v.age0104m;   a0104f += v.age0104f;
                a0509m += v.age0509m;   a0509f += v.age0509f;
                a1014m += v.age1014m;   a1014f += v.age1014f;
                a1519m += v.age1519m;   a1519f += v.age1519f;
                a2024m += v.age2024m;   a2024f += v.age2024f;
                a2529m += v.age2529m;   a2529f += v.age2529f;
                a3034m += v.age3034m;   a3034f += v.age3034f;
                a3539m += v.age3539m;   a3539f += v.age3539f;

                $('#tblList > tbody').append(
                    '<tr>'+
                        '<td>'+ v.code.substr(6) +'</td>'+
                        '<td>'+ v.name +'</td>'+
                        '<td>'+ v.age0001m +'</td><td>'+ v.age0001f +'</td>'+
                        '<td>'+ v.age0104m +'</td><td>'+ v.age0104f +'</td>'+
                        '<td>'+ v.age0509m +'</td><td>'+ v.age0509f +'</td>'+
                        '<td>'+ v.age1014m +'</td><td>'+ v.age1014f +'</td>'+
                        '<td>'+ v.age1519m +'</td><td>'+ v.age1519f +'</td>'+
                        '<td>'+ v.age2024m +'</td><td>'+ v.age2024f +'</td>'+
                        '<td>'+ v.age2529m +'</td><td>'+ v.age2529f +'</td>'+
                        '<td>'+ v.age3034m +'</td><td>'+ v.age3034f +'</td>'+
                        '<td>'+ v.age3539m +'</td><td>'+ v.age3539f +'</td>'+
                    '</tr>'
                );
            });
            $('#tblList > tbody').append(
                '<tr>'+
                    '<td colspan="2"><b>รวมทั้งหมด</b></td>'+
                    '<td><b>'+ a0001m +'</b></td><td><b>'+ a0001f +'</b></td>'+
                    '<td><b>'+ a0104m +'</b></td><td><b>'+ a0104f +'</b></td>'+
                    '<td><b>'+ a0509m +'</b></td><td><b>'+ a0509f +'</b></td>'+
                    '<td><b>'+ a1014m +'</b></td><td><b>'+ a1014f +'</b></td>'+
                    '<td><b>'+ a1519m +'</b></td><td><b>'+ a1519f +'</b></td>'+
                    '<td><b>'+ a2024m +'</b></td><td><b>'+ a2024f +'</b></td>'+
                    '<td><b>'+ a2529m +'</b></td><td><b>'+ a2529f +'</b></td>'+
                    '<td><b>'+ a3034m +'</b></td><td><b>'+ a3034f +'</b></td>'+
                    '<td><b>'+ a3539m +'</b></td><td><b>'+ a3539f +'</b></td>'+
                '</tr>'
            );
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

    rpt.get_list();
});