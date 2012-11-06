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
    //get inscl list
    amplify.request.define('get_inscl', 'ajax', {
        url: site_url + 'basic/get_inscl',
        dataType: 'json',
        type: 'POST',

        decoder: "appEnvelope"
    });

    amplify.request.define('get_occupation', 'ajax', {
        url: site_url + 'basic/get_occupation',
        dataType: 'json',
        type: 'POST',

        decoder: "appEnvelope"
    });

    amplify.request.define('get_title', 'ajax', {
        url: site_url + 'basic/get_title',
        dataType: 'json',
        type: 'POST',

        decoder: "appEnvelope"
    });

    amplify.request.define('get_marry_status', 'ajax', {
        url: site_url + 'basic/get_marry_status',
        dataType: 'json',
        type: 'POST',

        decoder: "appEnvelope"
    });
    amplify.request.define('get_education', 'ajax', {
        url: site_url + 'basic/get_education',
        dataType: 'json',
        type: 'POST',

        decoder: "appEnvelope"
    });

    person.register.ajax = {
        get_marry_status: function(cb){
            amplify.request({
                resourceId: 'get_marry_status',
                data: {
                    csrf_token: csrf_token
                },
                success: function(data){
                    cb(null, data);
                },
                error: function(msg, xhr){
                    cb('เกิดข้อผิดพลาด: ' + msg + ' [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        },
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
        },
        get_inscl: function(cb){
            amplify.request({
                resourceId: 'get_inscl',
                data: {
                    csrf_token: csrf_token
                },
                success: function(data){
                    cb(null, data);
                },
                error: function(msg, xhr){
                    cb('เกิดข้อผิดพลาด: ' + msg + ' [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        },
        get_occupation: function(cb){
            amplify.request({
                resourceId: 'get_occupation',
                data: {
                    csrf_token: csrf_token
                },
                success: function(data){
                    cb(null, data);
                },
                error: function(msg, xhr){
                    cb('เกิดข้อผิดพลาด: ' + msg + ' [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        },
        get_title: function(cb){
            amplify.request({
                resourceId: 'get_title',
                data: {
                    csrf_token: csrf_token
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
    //set data
    person.register.set_data = {
        set_inscl: function(){
            $('#slInstype').empty();

            person.register.ajax.get_inscl(function(err, data){

                if(err){
                    console.log(err);
                }else{
                    if(_.size(data)){
                        $('#slInstype').append(
                            '<option value="">-</option>'
                        );
                        _.each(data, function(v){
                            $('#slInstype').append(
                                '<option value="'+ v.inscl +'">['+ v.inscl +'] ' + v.name + '</option>'
                            );
                        });
                    }else{
                        console.log('no data');
                    }
                }
            });
        },
        set_occupation: function(){
            $('#slOccupation').empty();

            person.register.ajax.get_occupation(function(err, data){

                if(err){
                    console.log(err);
                }else{
                    if(_.size(data)){
                        $('#slOccupation').append(
                            '<option value="">-</option>'
                        );
                        _.each(data, function(v){
                            $('#slOccupation').append(
                                '<option value="'+ v.id +'">'+ v.name + '</option>'
                            );
                        });
                    }else{
                        console.log('no data');
                    }
                }
            });
        },
        set_title: function(){
            $('#slTitle').empty();

            person.register.ajax.get_title(function(err, data){

                if(err){
                    console.log(err);
                }else{
                    if(_.size(data)){
                        $('#slTitle').append(
                            '<option value="">-</option>'
                        );
                        _.each(data, function(v){
                            $('#slTitle').append(
                                '<option value="'+ v.id +'">'+ v.name + '</option>'
                            );
                        });
                    }else{
                        console.log('no data');
                    }
                }
            });
        },
        set_marry_status: function(){
            $('#slMStatus').empty();

            person.register.ajax.get_marry_status(function(err, data){

                if(err){
                    console.log(err);
                }else{
                    if(_.size(data)){
                        $('#slMStatus').append(
                            '<option value="">-</option>'
                        );
                        _.each(data, function(v){
                            $('#slMStatus').append(
                                '<option value="'+ v.id +'">'+ v.name + '</option>'
                            );
                        });
                    }else{
                        console.log('no data');
                    }
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
                                    'data-birth="'+ v.birthdate +'" data-inscl="'+ v.subinscl +'"><i class="icon-share"></i></a></td>' +
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



    //load inscl list
   // App.showImageLoading();
   // person.register.set_data.set_inscl();
   // person.register.set_data.set_occupation();
   // person.register.set_data.set_title();
   // person.register.set_data.set_marry_status();
   // person.register.set_data.set_marry_status();

   // App.hideImageLoading();
});