$(function(){
    var person = {};
    person.register = {};

    person.register.modal = {
        show_search_dbpop: function(){
            $('#modal_search_dbpop').modal({backdrop: 'static'}).css(
                {
                    'margin-top': function () {
                        return -($(this).height() / 2);
                    }
                })
                .css('width', 740)
        }
    };

    $('#btn_search_dbpop').click(function(){
        person.register.modal.show_search_dbpop();
    });

    amplify.request.decoders.appEnvelope =
        function(data, status, xhr, success, error) {
            if(data.success){
                success(data.rows);
            }else{
                error(data.msg, xhr);
            }
        };

    amplify.request.define('search_dbpop', 'ajax', {
        url: site_url + 'person/search_dbpop',
        dataType: 'json',
        type: 'POST',

        decoder: "appEnvelope"
    });

    person.register.ajax = {
        search_dbpop: function(cid, cb){
            amplify.request({
                resourceId: 'search_dbpop',
                data: {
                    csrf_token: csrf_token,
                    cid: cid
                },
                success: function(data){
                    cb(null, data);
                },
                error: function(msg, xhr){
                    cb('เกิดข้อผิดพลาด: ' + msg + ' [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        }
    };

    //search dbpop
    $('#button_do_search_dbpop').click(function(){
        var cid = $('#text_query_search_dbpop').val();
        if(!cid){
            alert('กรุณาระบุเลขบัตรประชาชน');
        }else{
            //do search
            $('#table_search_dbpop_result_list tbody').empty();
            person.register.ajax.search_dbpop(cid, function(err, data){
                if(err){
                    $('#table_search_dbpop_result_list tbody').append(
                        '<tr>' +
                            '<td colspan="6">' + err + '</td>' +
                        '</tr>'
                    );
                }else{
                    if( _.size(data) ){
                        _.each(data, function(v){
                            $('#table_search_dbpop_result_list tbody').append(
                                '<tr>' +
                                    '<td>' + v.cid + '</td>' +
                                    '<td>' + v.fname + ' ' + v.lname + '</td>' +
                                    '<td>' + App.convertToThaiDateFormat(v.birthdate) + '</td>' +
                                    '<td>' + App.countAge(v.birthdate) + '</td>' +
                                    '<td>[' + v.subinscl + '] ' + v.maininscl_name + '</td>' +
                                    '<td><a href="#" class="btn" data-name="button_set_data_from_dbopo" ' +
                                    'data-cid="' + v.cid + '" data-fname="'+ v.fname +'" data-lname="'+ v.lname+'" ' +
                                    'data-birth="'+ v.birthdate +'"><i class="icon-share"></i></a></td>' +
                                '</tr>'
                            );
                        });
                    }else{
                        $('#table_search_dbpop_result_list tbody').append(
                            '<tr>' +
                                '<td colspan="6">ไม่พบรายการ</td>' +
                                '</tr>'
                        );
                    }
                }
            });
        }
    });
});