/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 4/4/2556 9:12 น.
 */
$(function() {
    var rpt = {};

    rpt.ajax = {
        get_list: function(start, stop, cb) {
            var url = 'reports/get_list',
                params = {
                    start: start,
                    stop: stop,
                    group: $('#tboGroup').val()
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(cb){
            var url = 'reports/get_list_total',
                params = {};

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        show_report: function() {
            $('#mdlReport').modal('show').css({
                width: 700,
                'margin-left': function() {
                    return -($(this).width() / 2);
                }
            });
        },
        hide_report: function() {
            $('#mdlReport').modal('hide');
        },
        clear_form: function() {
            $('#tboId').val('');
            $('#tboName').val('');
            $('#tboUrl').val('');
            $('#cboGroup').val('1');
        }
    };

    $('#btnAddReport').click(function() {
        rpt.ajax.clear_form();
        var id = $(this).attr('data-id');
        $('#cboGroup').val(id);

        rpt.ajax.show_report();
    });

    $('#btnSave').click(function() {
        var url = 'reports/save_report',
            params = {
                id: 0,
                name: $('#tboName').val(),
                url: $('#tboUrl').val(),
                group: $('#cboGroup').val()
            };

        if(params.name == '' || params.url == '') {
            app.alert('กรุณากรอกข้อมูลให้ครบด้วย');
        } else {
            app.ajax(url, { data: params }, function(err, data) {
                if(data != null) {
                    app.alert(data.msg);
                    rpt.ajax.hide_report();
                } else {
                    app.alert(err);
                }
            });
        }
    });

    rpt.set_list = function(data){
        if(_.size(data.rows) > 0){
            _.each(data.rows, function(v){
                $('#tblList > tbody').append(
                    '<tr>'+
                        '<td>'+ v.name +'</td>'+
                        '<td>'+ v.url +'</td>'+
                        '<td>'+
                            '<div class="btn-group">'+
                                '<a class="btn btn-success" data-id="'+ v.id +'" id="btnEdit" title="แก้ไขเมนู"><i class="icon-edit"></i></a>'+
                                '<a class="btn btn-danger" data-id="'+ v.id +'" id="btnRemove" title="ลบเมนู"><i class="icon-trash"></i></a>'+
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
                            $('#tbl_list > tbody').empty();
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