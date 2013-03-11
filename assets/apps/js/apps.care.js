$(document).ready(function(){
    var Care = {
        get_provinces: function(cb){
            $.ajax({
                url: _base_url + 'basic/get_province',
                type: 'POST',
                dataType: 'json',

                data: { csrf_token: _csrf_token },

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    cb(xhr);
                }
            });
        },

        get_ampur: function(chw, cb){
            $.ajax({
                url: _base_url + 'basic/get_ampur',
                type: 'POST',
                dataType: 'json',

                data: {
                    csrf_token: _csrf_token,
                    chw: chw
                },

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    var err = {
                        code: xhr.status,
                        name: xhr.statusText
                    };
                    cb(err);
                }
            });
        },

        get_tambon: function(chw, amp, cb){
            $.ajax({
                url: _base_url + 'basic/get_tambon',
                type: 'POST',
                dataType: 'json',

                data: {
                    csrf_token: _csrf_token,
                    chw: chw,
                    amp: amp
                },

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    var err = {
                        code: xhr.status,
                        name: xhr.statusText
                    };
                    cb(err);
                }
            });
        },

        get_moo: function(chw, amp, tmb, cb){
            $.ajax({
                url: _base_url + 'basic/get_moo',
                type: 'POST',
                dataType: 'json',

                data: {
                    csrf_token: _csrf_token,
                    chw: chw,
                    amp: amp,
                    tmb: tmb
                },

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    var err = {
                        code: xhr.status,
                        name: xhr.statusText
                    };
                    cb(err);
                }
            });
        },

        get_person: function(chat, cb){

            App.showLoading();

            try{
                $.ajax({
                    url: _base_url + 'basic/get_person',
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        csrf_token: _csrf_token,
                        chat: chat
                    },

                    success: function(data){
                        if(data.success){
                            cb(null, data.rows);
                        }else{
                            cb(data.msg);
                        }
                    },

                    error: function(xhr, status){
                        var err = {
                            code: xhr.status,
                            name: xhr.statusText
                        };
                        cb(err);
                    }
                });
            }catch(ex){
                cb(ex);
            }
        },

        get_main_inscl: function(cb){

            App.showLoading();

            try{
                $.ajax({
                    url: _base_url + 'basic/get_main_inscl',
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        csrf_token: _csrf_token,
                        chat: chat
                    },

                    success: function(data){
                        if(data.success){
                            cb(null, data.rows);
                        }else{
                            cb(data.msg);
                        }
                    },

                    error: function(xhr, status){
                        var err = {
                            code: xhr.status,
                            name: xhr.statusText
                        };
                        cb(err);
                    }
                });
            }catch(ex){
                cb(ex);
            }
        },

        get_right: function(pid, cb){

            App.showLoading();

            try{
                $.ajax({
                    url: _base_url + 'basic/get_right',
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        csrf_token: _csrf_token,
                        pid: pid
                    },

                    success: function(data){
                        if(data.success){
                            cb(null, data.rows);
                        }else{
                            cb(data.msg);
                        }
                    },

                    error: function(xhr, status){
                        var err = {
                            code: xhr.status,
                            name: xhr.statusText
                        };
                        cb(err);
                    }
                });
            }catch(ex){
                cb(ex);
            }
        },

        search_pid: function(query, cb){
            $.ajax({
                url: _base_url + 'basic/search_pid',
                type: 'POST',
                dataType: 'json',

                data: {
                    csrf_token: _csrf_token,
                    pid: query
                },

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    var err = {
                        code: xhr.status,
                        name: xhr.statusText
                    };
                    cb(err);
                }
            });
        },

        showModalPersonRight: function(){
            $('#mdlShowPatientRight').modal({backdrop: 'static'}).css('width', 650);
        },

        clearSearchFormResult: function(){
            $('#txtSearchPersonName').html();
            $('#txtSearchPersonAddress').html();
            $('#txtSearchPersonBirthday').html();
            $('#txtSearchPersonRightNo').html();
            $('#txtSearchPersonMainRightName').html();
            $('#txtSearchPersonSubRightName').html();
            $('#txtSearchPersonRightStart').html();
            $('#txtSearchPersonRightExpire').html();
            $('#txtSearchPersonRightHmain').html();
            $('#txtSearchPersonRightHsub').html();
        },
        clearPersonRightResult: function(){
            $('#txtPersonRightNo').html();
            $('#txtPersonMainRightName').html();
            $('#txtPersonRightName').html();
            $('#txtPersonRightStart').html();
            $('#txtPersonRightExpire').html();
            $('#txtPersonRightHmain').html();
            $('#txtPersonRightHsub').html();
        }

    };



    //get provinces
    Care.get_provinces(function(err, data){

        $('#slProvinces').empty();
        if(err){
            //error
            console.log('Get province error: ' + err);
        }else{
            $('#slProvinces').append('<option value="00">เลือกจังหวัด</option>');

            _.each(data, function(v){
                $('#slProvinces').append('<option value="' + v.changwat + '">'+ v.catm_name +'</option>')
            });
        }
    });

    $('#slProvinces').on('change', function(){

        $('#slAmpur').empty();
        $('#slTambon').empty();
        $('#slMooban').empty();

        $('#divPersonResult').fadeOut('slow');

        var chw = $(this).val();
        Care.get_ampur(chw, function(err, data){
            if(err){
                console.log(err);
            }else{

                $('#slAmpur').append('<option value="00">เลือกอำเภอ</option>')
                _.each(data, function(v){
                    if(!v.catm_name.match(/\*/))
                        $('#slAmpur').append('<option value="' + v.ampur + '">'+ v.catm_name +'</option>')
                });
            }
        });
    });

    $(document).on('change', '#slAmpur', function(){
        var chw = $('#slProvinces').val();
        var amp = $('#slAmpur').val();

        $('#slTambon').empty();
        $('#slMooban').empty();
        $('#divPersonResult').fadeOut('slow');

        Care.get_tambon(chw, amp, function(err, data){
            if(err){
                console.log(err);
            }else{

                $('#slTambon').append('<option value="00">เลือกตำบล</option>')
                _.each(data, function(v){
                    if(!v.catm_name.match(/\*/))
                        $('#slTambon').append('<option value="' + v.tambon + '">'+ v.catm_name +'</option>')
                });
            }
        });
    });

    $(document).on('change', '#slTambon', function(){
        var chw = $('#slProvinces').val();
        var amp = $('#slAmpur').val();
        $('#divPersonResult').fadeOut('slow');

        var tmb = $(this).val();

        $('#slMooban').empty();

        Care.get_moo(chw, amp, tmb, function(err, data){
            if(err){
                console.log(err);
            }else{

                $('#slMooban').append('<option value="00">เลือกหมู่บ้าน</option>')
                //var data_new = data.sort(function(a, b) {return a[1] - b[1]});

                _.each(data, function(v){
                    if(v.moo != '00')
                    $('#slMooban').append('<option value="' + v.moo + '">หมู่ ' + v.moo + ' ' + v.catm_name +'</option>')
                });
            }
        });
    });

    $(document).on('change', '#slMooban',function(){
        var chw = $('#slProvinces').val(),
            amp = $('#slAmpur').val(),
            tmb = $('#slTambon').val(),
            moo = $('#slMooban').val();

        var chat = chw + amp + tmb + moo;

        Care.get_person(chat, function(err, data){

            $('#tblPersonResult tbody').empty();

            if(err){
                console.log(err);
                $('#divPersonResult').fadeOut('slow');
            }else{
               //console.log(data);
               var i = 1;
                _.each(data, function(v){
                    var inscl = v.maininscl == null ? '<span class="label label-important">สิทธิว่าง</span>' : v.maininscl;
                    var btn = null;

                    if(v.maininscl == null){
                        btn = '<button class="btn btn-danger" disabled><i class="icon-info-sign"></i></button>';
                    }else{
                        btn = '<button data-name="btnGetRightInfo" ' +
                            'data-pid="' + v.pid + '" type="button" class="btn btn-info">' +
                            '<i class="icon-info-sign"></i> ' +
                        '</button>'
                    }

                    $('#tblPersonResult tbody').append(
                        '<tr> ' +
                            '<td>' + i + '</td> ' +
                            '<td>' + v.pid + '</td> ' +
                            '<td>' + v.fname + ' ' + v.lname + '</td> ' +
                            '<td>' + v.sex + '</td> ' +
                            '<td>' + App.convertToThaiDateFormat(v.birthdate) + '</td> ' +
                            '<td>' + v.age + '</td> ' +
                            '<td>' + inscl + '</td> ' +
                            '<td>' + btn +
                            '</td> ' +
                        '</tr>'
                    );
                    i++;
                });

                $('#divPersonResult').fadeIn('slow');
            }

            App.hideLoading();
        });
    });

    $(document).on('click', 'button[data-name="btnGetRightInfo"]', function(){

        var pid = $(this).attr('data-pid');

        Care.get_right(pid, function(err, data){

            Care.clearPersonRightResult();

            if(err){
                alert(err);
            }else{
                //set data
                $('#txtPersonRightNo').html(data.cardid);
                $('#txtPersonMainRightName').html(data.maininscl + ' ' + data.maininscl_name);
                $('#txtPersonRightName').html(data.subinscl + ' ' + data.subinscl_name);
                $('#txtPersonRightStart').html(App.convertToThaiDateFormat(data.startdate));
                $('#txtPersonRightExpire').html(App.convertToThaiDateFormat(data.expdate));
                $('#txtPersonRightHmain').html(data.hmain_code + ' ' + data.hmain_name);
                $('#txtPersonRightHsub').html(data.hsub_code + ' ' + data.hsub_name);
                Care.showModalPersonRight();
            }

            App.hideLoading();
        });
    });


    $('#btnDoSearchRight').click(function(){
        var query = $('#txtSearchRightQuery').val();

        if(!query){
            alert('กรุณาระบุเลขบัตรประชาชนที่ต้องการตรวจสอบ');
        }else{
            //do search
            App.showLoading();
            Care.search_pid(query, function(err, data){
                if(err){
                    App.hideLoading();
                    alert('ไม่พบข้อมูล');
                    $('#divSearchPatientRightResult').fadeOut('slow');

                }else{
                    Care.clearSearchFormResult();
                    if(_.size(data) > 0){
                        $('#divSearchPatientRightResult').fadeIn('slow');
                        $('#txtSearchPersonName').html(data.fname + ' ' + data.lname);
                        $('#txtSearchPersonAddress').html('หมู่ ' + data.moo + ' ' + data.moo_name  + ' ต.' + data.tambon_name + ' อ.' + data.ampur_name + ' จ.' + data.changwat_name);
                        $('#txtSearchPersonBirthday').html(App.convertToThaiDateFormat(data.birthdate) + ' อายุ ' + data.age + ' ปี');
                        $('#txtSearchPersonRightNo').html(data.cardid);
                        $('#txtSearchPersonMainRightName').html(data.maininscl + ' ' + data.maininscl_name);
                        $('#txtSearchPersonSubRightName').html(data.subinscl + ' ' + data.subinscl_name);
                        $('#txtSearchPersonRightStart').html(App.convertToThaiDateFormat(data.startdate));
                        $('#txtSearchPersonRightExpire').html(App.convertToThaiDateFormat(data.expdate));
                        $('#txtSearchPersonRightHmain').html(data.hmain_code + ' ' + data.hmain_name);
                        $('#txtSearchPersonRightHsub').html(data.hsub_code + ' ' + data.hsub_name);

                        App.hideLoading();
                    }else{
                        $('#divSearchPatientRightResult').fadeOut('slow');
                        App.hideLoading();
                    }
                }
            });
        }
    });

});
