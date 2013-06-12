/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 7/5/2556 14:15 น.
 */
$(function() {
    var rpt = {};

    rpt.ajax = {
        get_list: function(start, stop, cb) {
            var url = 'person_by_age/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'person_by_age/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    rpt.set_list = function(data){
        if(_.size(data.rows) > 0){
            var male = 0, female = 0, sum = 0;
            _.each(data.rows, function(v){
                male += v.male;
                female += v.female;
                sum += (v.male + v.female);
                $('#tblList > tbody').append(
                    '<tr>'+
                        '<td>'+ v.name +'</td>'+
                        '<td>'+ app.add_commars_with_out_decimal(v.male) +'</td>'+
                        '<td>'+ app.add_commars_with_out_decimal(v.female) +'</td>'+
                        '<td>'+ app.add_commars_with_out_decimal((v.male + v.female)) +'</td>'+
                        '</tr>'
                );
            });
            $('#tblList > tbody').append(
                '<tr>'+
                    '<td><b>รวมทั้งหมด</b></td>'+
                    '<td><b>'+ app.add_commars_with_out_decimal(male) +'</b></td>'+
                    '<td><b>'+ app.add_commars_with_out_decimal(female) +'</b></td>'+
                    '<td><b>'+ app.add_commars_with_out_decimal(sum) +'</b></td>'+
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