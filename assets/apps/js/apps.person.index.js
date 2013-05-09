/**
 * Main person script
 */
head.ready(document).ready(function(){
    var person = {};

    person.alert = {};

    /**
     * Modal window
     */
    person.modal = {
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
        },
        show_search_person: function(){
            $('#mdl_search_person').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_search_person: function(){
            $('#mdl_search_person').modal('hide');
        },
        show_village_survey: function(){
            $('#mdl_village_survey').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
    };

    person.alert.show_save_house_alert = function(cls, head, message){
        $('#alert_save_house').removeClass('alert alert-info');
        $('#alert_save_house').addClass(cls);
        $('#alert_save_house strong').html(head);
        $('#alert_save_house span').html(message);
    };


    /** Ajax functions **/
    person.ajax = {
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
        get_house_list: function(village_id, cb){
            var url = 'person/get_houses_list',
                params = {
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        /**
         * Get person list in the house
         *
         * @param house_code    The house id [_id].
         * @param cb            Callback function.
         */
        get_list: function(house_code, village_id, start, stop, cb){

            var url = 'person/get_list',
                params = {
                    house_code: house_code,
                    village_id: village_id,
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list_total: function(house_code, village_id, cb){

            var url = 'person/get_list_total',
                params = {
                    house_code: house_code,
                    village_id: village_id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        save_village_survey: function(data, cb){

            var url = 'person/save_village_survey',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(hn, cb){

            var url = 'person/remove',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search_person: function(query, filter, cb){

            var url = 'person/search',
                params = {
                    filter: filter,
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search_result: function(hn, cb){

            var url = 'person/search_result',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    person.setSurvey = function(data){
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

    person.clear_servey_form = function(){
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


    $('#btn_add_house').click(function(){
        var village_id = $('#sl_villages').val();
        if(!village_id)
        {
            app.alert('กรุณาเลือกหมู่บ้านที่ต้องการ');
        }
        else
        {
            person.modal.showNewHouse();
        }

    });

    $('#btn_add_person').on('click', function(){
        var house_id = $('#sl_houses').val();

        if(!house_id){
            app.alert('กรุณาเลือกหลังคาเรือนที่ต้องการ');
        }else{
            var url = 'person/register/' + house_id;
            app.go_to_url(url);
        }

    });

    person.clear_register_form = function(){
        $('#txtAddress').val('');
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

    $(document).on('hidden', '#mdlNewHouse', function(){
        person.clear_register_form();
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
            //person.alert.show_save_house_alert('alert alert-error', 'เกิดข้อผิดพลาด', 'กรุณาระบุบ้านเลขที่');
            app.alert('กรุณาระบุบ้านเลขที่');
        }else{
            person.ajax.save_house(items, function(err){
                if(err){
                    //person.alert.show_save_house_alert('alert alert-error', 'เกิดข้อผิดพลาด', err);
                    app.alert(err);
                }else{
                    //person.alert.show_save_house_alert('alert alert-info', 'สำเร็จ', 'การบันทึกข้อมูลเสร็จเรียบร้อย');

                    app.alert('การบันทึกข้อมูลเสร็จเรียบร้อย');
                    
                    person.set_house(items.village_id);

                    person.clear_register_form();
                }
            });
        }
    });

    //clear house id;
    $('#txtHouseId').val('');

    //get person list
    $(document).on('click', 'a[data-name="btn_get_person"]', function(){
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
            person.ajax.save_house_survey(items, function(err){
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
        person.clear_servey_form();
    });

    person.set_person = function(data)
    {
        if(!data.rows)
        {
            $('#tbl_person > tbody').append(
                '<tr>' +
                    '<td colspan="11">ไม่พบรายการ</td>' +
                    '</tr>'
            );
        }
        else
        {
            _.each(data.rows, function(v){
                var discharge_status = '';
                if(v.discharge_status == '1')
                    discharge_status = 'ตาย', status_class = 'error';
                else if(v.discharge_status == '2')
                    discharge_status = 'ย้าย', status_class = 'warning';
                else if(v.discharge_status == '3')
                    discharge_status = 'สาบสูญ', status_class = 'warning';
                else if(v.discharge_status == '9')
                    discharge_status = 'ไม่จำหน่าย', status_class = '';
                else
                    discharge_status = 'ไม่ระบุ', status_class = 'warning';


                $('#tbl_person > tbody').append(
                    '<tr class="'+ status_class +'">' +
                        '<td>'+ v.hn +'</td>' +
                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.title +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>'+ app.to_thai_date(v.birthdate) +'</td>' +
                        '<td>'+ v.age +'</td>' +
                        '<td>'+ v.sex +'</td>' +
                        '<td>'+ v.fstatus +'</td>' +
                        '<td>'+ discharge_status +'</td>' +
                        '<td>'+ app.clear_null(v.typearea) +'</td>' +
                        '<td> <div class="btn-group">' +
/*                        '<a class="btn" href="javascript:void(0);" data-name="btn_remove_person" data-hn="'+ v.hn +'" title="ลบ">' +
                        '<i class="icon-trash"></i></a>' +*/
                        '<a class="btn" href="'+ site_url + 'person/edit/' + v.hn + '" title="แก้ไข">' +
                        '<i class="icon-edit"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }

    };

    $(document).on('click', 'a[data-name="btn_remove_person"]', function(e){

        var hn = $(this).data('hn');

        if(confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?'))
        {
            person.ajax.remove(hn, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                }
            });
        }

        e.preventDefault();
    })

    $('#btn_get_list').on('click', function(){
        var house_code = $('#sl_houses').val(),
            village_id = $('#sl_villages').val();

        if(!village_id)
        {
            app.alert('กรุณาเลือกหมู่บ้าน และ หลังคาเรือน');
        }
        else
        {
            person.get_list(house_code, village_id);

        }


    });

    person.get_list = function(house_code, village_id)
    {

        $('#tbl_person > tbody').empty();

        $('#main_paging').fadeIn('slow');

        person.ajax.get_list_total(house_code, village_id, function(err, data){
            if(err){
                app.alert(err);
                $('#tbl_person > tbody').append(
                    '<tr>' +
                        '<td colspan="11">ไม่พบรายการ</td>' +
                        '</tr>'
                );
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        person.ajax.get_list(house_code, village_id, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                                $('#tbl_person > tbody').append(
                                    '<tr>' +
                                        '<td colspan="11">ไม่พบรายการ</td>' +
                                        '</tr>'
                                );
                            }else{
                                person.set_person(data);
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


    $('#btn_save_village_survey').on('click', function(){
        var data = {};

        data.village_id = $('#txt_village_id').val();

        data.ntraditional = $('#txt_ntraditional').val();
        data.nmonk = $('#txt_nmonk').val();
        data.nreligionleader = $('#txt_nreligionleader').val();
        data.nbroadcast = $('#txt_nbroadcast').val();
        data.nradio = $('#txt_nradio').val();
        data.npchc = $('#txt_npchc').val();
        data.nclinic = $('#txt_nclinic').val();
        data.ndrugstore = $('#txt_ndrugstore').val();
        data.nchildcenter = $('#txt_nchildcenter').val();
        data.npschool = $('#txt_npschool').val();
        data.nsschool = $('#txt_nsschool').val();
        data.ntemple = $('#txt_ntemple').val();
        data.nreligiousplace = $('#txt_nreligiousplace').val();
        data.nmarket = $('#txt_nmarket').val();
        data.nshop = $('#txt_nshop').val();
        data.nfoodshop = $('#txt_nfoodshop').val();
        data.nstall = $('#txt_nstall').val();
        data.nraintank = $('#txt_nraintank').val();
        data.nchickenfarm = $('#txt_nchickenfarm').val();
        data.npigfarm = $('#txt_npigfarm').val();
        data.wastewater = $('#sl_wastewater').val();
        data.garbage = $('#sl_garbage').val();
        data.nfactory = $('#txt_nfactory').val();
        data.latitude = $('#txt_latitude').val();
        data.longitude = $('#txt_longitude').val();
        data.outdate = $('#txt_outdate').val();
        data.numactually = $('#txt_numactually').val();
        data.risktype = $('#txt_risktype').val();
        data.numstateless = $('#txt_numstateless').val();
        data.nexerciseclub = $('#txt_nexerciseclub').val();
        data.nolderlyclub = $('#txt_nolderlyclub').val();
        data.ndisableclub = $('#txt_ndisableclub').val();
        data.nnumberoneclub = $('#txt_nnumberoneclub').val();

        person.ajax.save_village_survey(data, function(err){
            if(err)
            {
                app.alert(err);
            }
            else
            {
                app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
            }
        });
    });

    $(document).on('change', '#sl_villages', function(){
        var village_id = $(this).val();

        person.ajax.get_house_list(village_id, function(err, data){
            $('#sl_houses').empty();
            if(err)
            {
                app.alert(err);
            }
            else
            {
                if(data)
                {
                    $('#sl_houses').append('<option value="">ทั้งหมด</option>');
                    _.each(data.rows, function(v){
                        $('#sl_houses').append('<option value="'+ v.id +'">' + v.house + '</option>');
                    });
                }
            }
        });
    });

    $('#btn_village_survey').on('click', function(){
        var id = $('#sl_villages').val();
        if(!id)
        {
            app.alert('กรุณาระบุหมู่บ้านที่ต้องการสำหรวจ');
        }
        else
        {
            $('#txt_village_id').val(id);

            person.modal.show_village_survey();
        }

    });

    $('#btn_house_survey').on('click', function(){
        var house_id = $('#sl_houses').val();

        if(!house_id){
            app.alert('กรุณาเลือกหลังคาเรือนที่ต้องการ');
        }else{

            $('#txtHouseId').val(house_id);

            person.ajax.get_house_survey(house_id, function(err, data){
                //set data
                if(err){
                    app.alert(err);
                }else{
                    //set data
                    if(_.size(data.rows.surveys) > 0){
                        person.setSurvey(data.rows.surveys);
                    }
                    //console.log(data.surveys);
                    person.modal.showHouseSurvey();
                }

            });

        }
    });

    $('#btn_search_person').on('click', function(){
        person.modal.show_search_person();
    });

    //do search person
    $('a[data-name="btn_search_person_fillter"]').on('click', function(){
        var filter = $(this).data('value');
        $('#txt_search_person_filter').val(filter);

    });

    person.set_search_person_result = function(data)
    {
        if(!data)
        {
            $('#tbl_search_person_result > tbody').append(
                '<tr><td colspan="7">ไม่พบรายการ</td></tr>');
        }
        else
        {
            _.each(data.rows, function(v){

                $('#tbl_search_person_result > tbody').append(
                    '<tr>' +
                    '<td>'+ v.hn +'</td>' +
                    '<td>'+ v.cid +'</td>' +
                    '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                    '<td>'+ app.mongo_to_thai_date(v.birthdate) +'</td>' +
                    '<td>'+ v.age +'</td>' +
                    '<td>'+ v.sex +'</td>' +
                    '<td><a href="#" class="btn" data-hn="'+ v.hn + '" data-name="btn_selected_person" data-typearea="'+ v.typearea +'">' +
                        '<i class="icon-ok"></i></a></td>' +
                    '</tr>');
            });
        }
    };

   $(document).on('click', 'a[data-name="btn_selected_person"]', function(e){
       if( ! _.indexOf(['1', '3'], $(this).data('typearea')))
       {
           app.alert('บุคคลนี้ไม่ใช่บุคคลในเขตรับผิดชอบ');
       }
       else
       {
           var hn = $(this).data('hn');

           $('#tbl_person > tbody').empty();

           $('#main_paging').fadeOut('slow');

           person.ajax.search_result(hn, function(err, data){
               if(err)
               {
                   app.alert('ไม่พบรายการ');
                   $('#tbl_person > tbody').append(
                       '<tr>' +
                           '<td colspan="11">ไม่พบรายการ</td>' +
                           '</tr>'
                   );
               }
               else
               {
                   person.set_person(data);
                   person.modal.hide_search_person();
               }


           });
       }
        e.preventDefault();
    });

    $('#btn_do_search_person').on('click', function(){
        var query = $('#txt_search_query').val(),
            filter = $('#txt_search_person_filter').val();

        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา');
        }
        else
        {
            $('#tbl_search_person_result > tbody').empty();

            person.ajax.search_person(query,filter, function(err, data){
                if(err)
                {
                    app.alert(err);
                    $('#tbl_search_person_result > tbody').append(
                        '<tr><td colspan="7">ไม่พบรายการ</td></tr>');
                }
                else
                {
                    person.set_search_person_result(data);
                }
            });
        }
    });
});