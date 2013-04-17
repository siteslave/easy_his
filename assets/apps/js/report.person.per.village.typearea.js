/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 17/4/2556 10:09 น.
 */
$(function() {
    var rpt = {};

    rpt.ajax = {
        get_list: function(start, stop, cb) {
            var url = 'person_per_village_typearea/get_list',
                params = {
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'person_per_village_typearea/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    rpt.set_list = function(data){
        if(_.size(data.rows) > 0){
            var type0 = 0, type1 = 0, type2 = 0, type3 = 0, type4 = 0, type13 = 0, type_all = 0;
            _.each(data.rows, function(v){
                type0 += v.type0;
                type1 += v.type1;
                type2 += v.type2;
                type3 += v.type3;
                type4 += v.type4;
                $('#tblList > tbody').append(
                    '<tr>'+
                        '<td>'+ v.code.substr(6) +'</td>'+
                        '<td>'+ v.name +'</td>'+
                        '<td>'+ app.add_commars_with_out_decimal(v.type0) +'</td>'+
                        '<td>'+ app.add_commars_with_out_decimal(v.type1) +'</td>'+
                        '<td>'+ app.add_commars_with_out_decimal(v.type2) +'</td>'+
                        '<td>'+ app.add_commars_with_out_decimal(v.type3) +'</td>'+
                        '<td>'+ app.add_commars_with_out_decimal(v.type4) +'</td>'+
                        '<td>'+ app.add_commars_with_out_decimal(v.type1+v.type3) +'</td>'+
                        '<td>'+ app.add_commars_with_out_decimal(v.type0+v.type1+v.type2+v.type3+v.type4) +'</td>'+
                    '</tr>'
                );
            });
            type13 = (type1 + type3);
            type_all = type0 + type2 + type4 + type13;
            $('#tblList > tbody').append(
                '<tr>'+
                    '<td colspan="2"><b>รวมทั้งหมด</b></td>'+
                    '<td><b>'+ app.add_commars_with_out_decimal(type0) +'</b></td>'+
                    '<td><b>'+ app.add_commars_with_out_decimal(type1) +'</b></td>'+
                    '<td><b>'+ app.add_commars_with_out_decimal(type2) +'</b></td>'+
                    '<td><b>'+ app.add_commars_with_out_decimal(type3) +'</b></td>'+
                    '<td><b>'+ app.add_commars_with_out_decimal(type4) +'</b></td>'+
                    '<td><b>'+ app.add_commars_with_out_decimal(type13) +'</b></td>'+
                    '<td><b>'+ app.add_commars_with_out_decimal(type_all) +'</b></td>'+
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