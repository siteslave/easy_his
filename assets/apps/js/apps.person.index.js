$(document).ready(function(){
    var Person = {};

    Person.alert = {};

    Person.modal = {
        showNewHouse: function(){
            $('#mdlNewHouse').modal({backdrop: 'static'}).css('width', 768);
        },
        showHouseSurvey: function(){
            $('#mdlHouseSurvey').modal({backdrop: 'static'}).css('width', 768);
        },
        showPerson: function(){
            $('#mdlPersonDetail').modal({backdrop: 'static'}).css('width', 768);
        }
    };

    Person.alert.show_save_house_alert = function(cls, head, message){
        $('#alert_save_house').removeClass('alert alert-info');
        $('#alert_save_house').addClass(cls);
        $('#alert_save_house strong').html(head);
        $('#alert_save_house span').html(message);
    };

    $('#btnShowModalNewHouse').click(function(){
        Person.modal.showNewHouse();
    });

    $('#btnShowModalHomeSurvey').click(function(){
        Person.modal.showHouseSurvey();
    });
    $('#btnNewPerson').click(function(){
        var house_id = $('#txt_house_address').val();

        if(!house_id){
            alert('กรุณาเลือกหลังคาเรือนที่ต้องการ');
        }else{
            location.href = site_url + 'person/register/' + house_id;
        }

    });


    //Decoder
    amplify.request.decoders.appEnvelope =
        function(data, status, xhr, success, error) {
            if(data.success){
                success(data.rows);
            }else{
                error(data.msg, xhr);
            }
        };

    amplify.request.decoders.app_save_house =
        function(data, status, xhr, success, error) {
            if(data.success){
                success(null);
            }else{
                error(data.msg, xhr);
            }
        };

    //define ajax request
    amplify.request.define('get_villages', 'ajax', {
        url: site_url + 'person/get_villages',
        dataType: 'json',
        type: 'POST',

        decoder: "appEnvelope"
    });

    //get house
    amplify.request.define('get_houses', 'ajax', {
        url: site_url + 'person/get_houses',
        dataType: 'json',
        type: 'POST',

        decoder: "appEnvelope"
    });

    amplify.request.define('save_house', 'ajax', {
        url: site_url + 'person/save_house',
        dataType: 'json',
        type: 'POST',

        decoder: "app_save_house"
    });


    Person.ajax = {
        get_villages: function(cb){
            amplify.request({
                resourceId: 'get_villages',
                data: {csrf_token: csrf_token},
                success: function(data){
                    cb(null, data);
                },
                error: function(msg, xhr){
                    cb('เกิดข้อผิดพลาด: ' + msg + ' [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        },
        get_houses: function(village_id, cb){
            amplify.request({
                resourceId: 'get_houses',
                data: {
                    csrf_token: csrf_token,
                    village_id: village_id
                },
                success: function(data){
                    cb(null, data);
                },
                error: function(msg, xhr){
                    cb('เกิดข้อผิดพลาด: ' + msg + ' [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        },
        save_house: function(items, cb){
            amplify.request({
                resourceId: 'save_house',
                data: {
                    csrf_token: csrf_token,
                    data: items
                },
                success: function(){
                    cb(null);
                },
                error: function(msg, xhr){
                    cb('เกิดข้อผิดพลาด: ' + msg + ' [' + xhr.status + ': ' + xhr.statusText + ']');
                }
            });
        }
    };

    Person.set_house = function(village_id){

        App.showImageLoading();

        Person.ajax.get_houses(village_id, function(err, data){

            $('#tbl_houses_list tbody').empty();

            var i = 1;
            if(_.size(data)){
                _.each(data, function(v){
                    $('#tbl_houses_list tbody').append(
                        '<tr>' +
                            '<td>'+ i +'</td>' +
                            '<td>'+ v.house_id +'</td>' +
                            '<td>'+ v.house +'</td>' +
                            '<td>-</td>' +
                            '<td>' +
                            '<div class="btn-group"> ' +
                            '<a href="#divPersonList" data-name="btn_get_person" class="btn" data-house="' + v.house + '" data-id="' + v.id + '" title="ดูประชากร"><i class="icon-user"></i></a>' +
                            '<a href="#" data-name="btn_house_survey" data-id="' + v.id + '" class="btn" title="ข้อมูลสำรวจ" data-id="' + v.id + '">'+
                            '<i class="icon-edit"></i></a>' +
                            '</td>' +
                            '</tr>'
                    );

                    i++;
                });
            }else{
                $('#tbl_houses_list tbody').append(
                    '<tr><td colspan="4">ไม่พบหลังคาเรือน</td></tr>'
                );
            }


            App.hideImageLoading();
        });
    };

    $('a[data-name="btnSelectedVillage"]').live('click', function(){
        var village_id = $(this).attr('data-id'),
            village_name = $(this).attr('data-vname'),
            moo = $(this).attr('data-vmoo');

        $('#vMooName').html('หมู่ ' + moo + ' ' + village_name);

        $('#village_id').val(village_id);

        Person.set_house(village_id);

        $('#btnShowModalNewHouse').fadeIn('slow');
    });

    App.showImageLoading();
    Person.ajax.get_villages(function(err, data){

        if(err){
            alert(err);
        }else{
            $('#tblVillageList tbody').empty();
            _.each(data, function(v){
                $('#tblVillageList tbody').append(
                    '<tr>' +
                        '<td>'+ v.village_code +'</td>' +
                        '<td>'+ v.moo +'</td>' +
                        '<td>'+ v.village_name +'</td>' +
                        //'<td><a href="javascript:void(0);" rel="tooltip" title="ดูหลังคาเรือน"><i class="icon-share"></i></a></td>' +
                        '<td><div class="btn-group">' +
                        '<a href="#" data-name="btn_edit_village" class="btn" data-id="' + v.id + '" title="แก้ไขหมู่"><i class="icon-edit"></i></a>' +
                        '<a href="#" data-name="btnSelectedVillage" class="btn" title="ดูหลังคาเรือน" ' +
                        'data-id="' + v.id + '" data-vmoo="' + v.moo + '" data-vname="' + v.village_name + '">'+
                        '<i class="icon-home"></i></a></div></td>' +
                        '</tr>'
                );
            });
        }

        App.hideImageLoading();
    });


    Person.clear_register_form = function(){
        $('#txtHouse').val('');
        $('#txtHouseId').val('');
        $('#txtRoomNo').val('');
        $('#txtSoiSub').val('');
        $('#txtSoiMain').val('');
        $('#txtCondo').val('');
        $('#txtVillageName').val('');
        $('#txtRoad').val('');
    };

    $('#mdlNewHouse').on('hidden', function(){
        Person.clear_register_form();
    });

    //save houses
    $('#btn_do_save_house').click(function(){
        var items = {};

        items.house = $('#txtHouse').val();
        items.house_id = $('#txtHouseId').val();
        items.house_type = $('#slHouseType').val();
        items.room_no = $('#txtRoomNo').val();
        items.soi_sub = $('#txtSoiSub').val();
        items.soi_main = $('#txtSoiMain').val();
        items.condo = $('#txtCondo').val();
        items.village_name = $('#txtVillageName').val();
        items.road = $('#txtRoad').val();
        items.village_id = $('#village_id').val();

        if(!items.house){
            Person.alert.show_save_house_alert('alert alert-error', 'เกิดข้อผิดพลาด', 'กรุณาระบุบ้านเลขที่');
        }else{
            Person.ajax.save_house(items, function(err){
                if(err){
                    Person.alert.show_save_house_alert('alert alert-error', 'เกิดข้อผิดพลาด', err);
                }else{
                    Person.alert.show_save_house_alert('alert alert-info', 'สำเร็จ', 'การบันทึกข้อมูลเสร็จเรียบร้อย');
                    Person.set_house(items.village_id);

                    Person.clear_register_form();
                }
            });
        }
    });

    //clear house id;
    $('#txt_house_address').val('');

    //get person list
    $('a[data-name="btn_get_person"]').live('click', function(){
        var id = $(this).attr('data-id'),
            house = $(this).attr('data-house');
        $('#txt_house_address').val(id);
        $('#txt_show_house_address').html(house);

        //show person
    });
});