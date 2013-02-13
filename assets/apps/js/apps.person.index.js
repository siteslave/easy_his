/**
 * Main person script
 */
head.ready(document).ready(function(){
    var Person = {};

    Person.alert = {};

    /**
     * Modal window
     */
    Person.modal = {
        /** show new register help **/
        showNewHouse: function(){
            $('#mdlNewHouse').modal({
                    backdrop: 'static'
                }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        /** show house survey **/
        showHouseSurvey: function(){
            $('#mdlHouseSurvey').modal({
                backdrop: 'static'
            }).css({
                    width: 780,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
    };

    Person.alert.show_save_house_alert = function(cls, head, message){
        $('#alert_save_house').removeClass('alert alert-info');
        $('#alert_save_house').addClass(cls);
        $('#alert_save_house strong').html(head);
        $('#alert_save_house span').html(message);
    };


    /** Ajax functions **/
    Person.ajax = {
        /**
         * Get house survey detail
         *
         * @param   house_id    House id
         * @param   cb          Callback function
         * @return  callback
         */
        get_house_survey: function(house_id, cb){
            var url = 'person/get_house_survey',
                params = {
                    house_id: house_id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        /**
         * Get village list
         *
         * @param   cb  Callback function, no parameters for assign.
         * @return  cb  Callback function
         */
        get_villages: function(cb){
            var url = 'person/get_villages',
                params = {};

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        /**
         * Get house list
         *
         * @param   village_id  The village id
         * @param   cb          Callback function.
         * @return  cb          Callback function.
         */
        get_houses: function(village_id, cb){
            var url = 'person/get_houses',
                params = {
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        /**
         * Save house data
         *
         * @param items The object of house information.
         * @param cb    Callback function.
         */
        save_house: function(items, cb){
            var url = 'person/save_house',
                params = {
                    data: items
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        /**
         * Save house survey detail
         *
         * @param items The object of survey detail.
         * @param cb    Callback function.
         */
        save_house_survey: function(items, cb){

            var url = 'person/save_house_survey',
                params = {
                    data: items
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        },
        /**
         * Get person list in the house
         *
         * @param house_code    The house id [_id].
         * @param cb            Callback function.
         */
        get_person_list: function(house_code, cb){

            var url = 'person/get_person_list',
                params = {
                    house_code: house_code
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    Person.set_house = function(village_id){

        Person.ajax.get_houses(village_id, function(err, data){

            $('#tbl_houses_list > tbody').empty();

            var i = 1;
            if(_.size(data.rows)){
                _.each(data.rows, function(v){
                    $('#tbl_houses_list > tbody').append(
                        '<tr>' +
                            '<td>'+ i +'</td>' +
                            '<td>'+ v.house_id +'</td>' +
                            '<td>'+ v.house +'</td>' +
                            '<td>'+ v.total +'</td>' +
                            '<td>' +
                            '<div class="btn-group"> ' +
                            '<a href="#showPersonList" data-name="btn_get_person" class="btn btn-info" data-house="' + v.house + '" data-id="' + v.id + '" title="ดูประชากร"><i class="icon-user icon-white"></i></a>' +
                            '<a href="javascript:void(0);" data-name="btnHouseSurvey" data-id="' + v.id + '" class="btn" title="ข้อมูลสำรวจ" data-id="' + v.id + '">'+
                            '<i class="icon-edit"></i></a>' +
                            '</td>' +
                            '</tr>'
                    );

                    i++;
                });
            }else{
                $('#tbl_houses_list > tbody').append(
                    '<tr><td colspan="4">ไม่พบหลังคาเรือน</td></tr>'
                );
            }

        });
    };

    Person.setSurvey = function(data){
        $('#txt_house_latitude').val(data.latitude);
        $('#txt_house_longitude').val(data.longitude);
        $('#sl_locatype').val(data.locatype);
        $('#txt_vhvid').val(data.vhvid);
        $('#txt_headid').val(data.headid);
        $('#sl_toilet').val(data.toilet);
        $('#sl_water').val(data.water);
        $('#sl_watertype').val(data.watertype);
        $('#sl_garbage').val(data.garbage);
        $('#sl_housing').val(data.housing);
        $('#sl_durability').val(data.durability);
        $('#sl_cleanliness').val(data.cleanliness);
        $('#sl_ventilation').val(data.ventilation);
        $('#sl_light').val(data.light);
        $('#sl_watertm').val(data.watertm);
        $('#sl_mfood').val(data.mfood);
        $('#sl_bcontrol').val(data.bcontrol);
        $('#sl_acontrol').val(data.acontrol);
        $('#sl_chemical').val(data.chemical);
    };

    Person.clear_servey_form = function(){
        $('#txt_house_latitude').val('');
        $('#txt_house_longitude').val('');
        $('#sl_locatype').find('option:first').attr('selected','selected');
        $('#txt_vhvid').val('');
        $('#txt_headid').val('');
        $('#sl_toilet').find('option:first').attr('selected','selected');
        $('#sl_water').find('option:first').attr('selected','selected');
        $('#sl_watertype').find('option:first').attr('selected','selected');
        $('#sl_garbage').find('option:first').attr('selected','selected');
        $('#sl_housing').find('option:first').attr('selected','selected');
        $('#sl_durability').find('option:first').attr('selected','selected');
        $('#sl_cleanliness').find('option:first').attr('selected','selected');
        $('#sl_ventilation').find('option:first').attr('selected','selected');
        $('#sl_light').find('option:first').attr('selected','selected');
        $('#sl_watertm').find('option:first').attr('selected','selected');
        $('#sl_mfood').find('option:first').attr('selected','selected');
        $('#sl_bcontrol').find('option:first').attr('selected','selected');
        $('#sl_acontrol').find('option:first').attr('selected','selected');
        $('#sl_chemical').find('option:first').attr('selected','selected');
    };


    $('#btnShowModalNewHouse').click(function(){
        Person.modal.showNewHouse();
    });

    $('a[data-name="btnHouseSurvey"]').on('click', function(){

        var house_id = $(this).attr('data-id');

        if(!house_id){
            app.alert('กรุณาเลือกหลังคาเรือนที่ต้องการ');
        }else{

            $('#txtHouseId').val(house_id);

            Person.ajax.get_house_survey(house_id, function(err, data){
                //set data
                if(err){
                    app.alert(err);
                }else{
                    //set data
                    if(_.size(data.rows.surveys) > 0){
                        Person.setSurvey(data.rows.surveys);
                    }
                    //console.log(data.surveys);
                    Person.modal.showHouseSurvey();
                }

            });

        }

    });
    $('#btnNewPerson').click(function(){
        var house_id = $('#txtHouseId').val();

        if(!house_id){
            app.alert('กรุณาเลือกหลังคาเรือนที่ต้องการ');
        }else{
            var url = 'person/register/' + house_id;
            app.go_to_url(url);
        }

    });


    $('a[data-name="btnSelectedVillage"]').on('click', function(){
        //clear old address
        $('#txtHouseId').val('');
        $('#txt_show_house_address').html('');
        //clear person list
        $('#tbl_person_in_house > tbody').empty();
        $('#divPersonList').fadeOut('slow');

        var village_id = $(this).attr('data-id'),
            village_name = $(this).attr('data-vname'),
            moo = $(this).attr('data-vmoo');

        $('#vMooName').html('หมู่ ' + moo + ' ' + village_name);

        $('#village_id').val(village_id);

        Person.set_house(village_id);

        $('#btnShowModalNewHouse').fadeIn('slow');
    });

    Person.ajax.get_villages(function(err, data){

        if(err){
            app.alert(err);
        }else{
            $('#tblVillageList > tbody').empty();
            _.each(data.rows, function(v){
                $('#tblVillageList > tbody').append(
                    '<tr>' +
                        '<td>'+ v.village_code +'</td>' +
                        '<td>'+ v.moo +'</td>' +
                        '<td>'+ v.village_name +'</td>' +
                        //'<td><a href="javascript:void(0);" rel="tooltip" title="ดูหลังคาเรือน"><i class="icon-share"></i></a></td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_edit_village" disabled class="btn btn-info" data-id="' + v.id + '" title="แก้ไขหมู่"><i class="icon-edit icon-white"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btnSelectedVillage" class="btn" title="ดูหลังคาเรือน" ' +
                        'data-id="' + v.id + '" data-vmoo="' + v.moo + '" data-vname="' + v.village_name + '">'+
                        '<i class="icon-share-alt"></i></a></div></td>' +
                        '</tr>'
                );
            });
        }
    });


    Person.clear_register_form = function(){
        $('#txtHouse').val('');
        $('#txtHouseId').val('');
        $('#txtHouseCode').val('');
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

        items.house = $('#txtAddress').val();
        items.house_id = $('#txtHouseCode').val();
        items.house_type = $('#slHouseType').val();
        items.room_no = $('#txtRoomNo').val();
        items.soi_sub = $('#txtSoiSub').val();
        items.soi_main = $('#txtSoiMain').val();
        items.condo = $('#txtCondo').val();
        items.village_name = $('#txtVillageName').val();
        items.road = $('#txtRoad').val();
        items.village_id = $('#village_id').val();

        if(!items.house){
            //Person.alert.show_save_house_alert('alert alert-error', 'เกิดข้อผิดพลาด', 'กรุณาระบุบ้านเลขที่');
            app.alert('กรุณาระบุบ้านเลขที่');
        }else{
            Person.ajax.save_house(items, function(err){
                if(err){
                    //Person.alert.show_save_house_alert('alert alert-error', 'เกิดข้อผิดพลาด', err);
                    app.alert(err);
                }else{
                    //Person.alert.show_save_house_alert('alert alert-info', 'สำเร็จ', 'การบันทึกข้อมูลเสร็จเรียบร้อย');

                    app.alert('การบันทึกข้อมูลเสร็จเรียบร้อย');
                    
                    Person.set_house(items.village_id);

                    Person.clear_register_form();
                }
            });
        }
    });

    //clear house id;
    $('#txtHouseId').val('');

    //get person list
    $('a[data-name="btn_get_person"]').on('click', function(){
        var id = $(this).attr('data-id'),
            house = $(this).attr('data-house');
        $('#txtHouseId').val(id);
        $('#txt_show_house_address').html(house);

        //show person
    });

    //save house survey
    $('#btn_save_house_seruvey').click(function(){
        var items = {};
        items.latitude = $('#txt_house_latitude').val();
        items.longitude = $('#txt_house_longitude').val();
        items.locatype = $('#sl_locatype').val();
        items.vhvid = $('#txt_vhvid').val();
        items.headid = $('#txt_headid').val();
        items.toilet = $('#sl_toilet').val();
        items.water = $('#sl_water').val();
        items.watertype = $('#sl_watertype').val();
        items.garbage = $('#sl_garbage').val();
        items.housing = $('#sl_housing').val();
        items.durability = $('#sl_durability').val();
        items.cleanliness = $('#sl_cleanliness').val();
        items.ventilation = $('#sl_ventilation').val();
        items.light = $('#sl_light').val();
        items.watertm = $('#sl_watertm').val();
        items.mfood = $('#sl_mfood').val();
        items.bcontrol = $('#sl_bcontrol').val();
        items.acontrol = $('#sl_acontrol').val();
        items.chemical = $('#sl_chemical').val();

        items.house_id = $('#txtHouseId').val();

        if(!items.house_id){
            app.alert('กรุณาเลือกหลังคาเรือนที่ต้องการสำรวจ');
        }else{
            Person.ajax.save_house_survey(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('Save success');
                    $('#mdlHouseSurvey').modal('hide');
                }
            });
        }
    });

    $('#mdlHouseSurvey').on('hidden', function(){
        Person.clear_servey_form();
    });

    $('a[data-name="btn_get_person"]').on('click', function(){
        var house_code = $(this).attr('data-id');

        $('#divPersonList').fadeIn('slow');

        //get person list
        if(house_code){
            Person.ajax.get_person_list(house_code, function(err, data){
                $('#tbl_person_in_house > tbody').empty();

                if(err){
                    $('#tbl_person_in_house > tbody').append(
                        '<tr>' +
                            '<td colspan="9">ไม่พบรายการ</td>' +
                        '</tr>'
                    );
                }else{
                    _.each(data.rows, function(v){
                        $('#tbl_person_in_house > tbody').append(
                            '<tr>' +
                                '<td>'+ v.hn +'</td>' +
                                '<td>'+ v.cid +'</td>' +
                                '<td>'+ v.title +'</td>' +
                                '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                                '<td>'+ app.to_thai_date(v.birthdate) +'</td>' +
                                '<td>'+ v.age +'</td>' +
                                '<td>'+ v.sex +'</td>' +
                                '<td>'+ v.fstatus +'</td>' +
                                '<td> <div class="btn-group">' +
                                '<a class="btn btn-danger" href="'+ site_url + 'person/delete/' + v.id + '" title="ลบ">' +
                                '<i class="icon-trash icon-white"></i></a>' +
                                '<a class="btn" href="'+ site_url + 'person/edit/' + v.id + '" title="แก้ไข">' +
                                '<i class="icon-edit"></i></a>' +
                                '</div></td>' +
                            '</tr>'
                        );
                    });
                }

            });
        }
    });
});