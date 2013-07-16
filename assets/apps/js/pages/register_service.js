head.ready(function() {

    var regsv = {};

    regsv.ajax = {

        do_register: function(data, cb){

            var url = 'services/do_register',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search_person_all: function(query, cb){
            var url = 'person/search2',
                params = {
                    query: query
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    $('#btn_show_search_person').click(function(){
        var query = $('#txt_service_profile_hn').val();
        if(!query || query.length <= 2)
        {
            app.alert('กรุณาระบุคำที่ต้องการค้นหา');
        }
        else
        {
            //do search
            regsv.ajax.search_person_all(query, function(err, data){
                if(data)
                {
                    var detail = data.rows[0].first_name + ' ' + data.rows[0].last_name +
                        ' อายุ: ' + data.rows[0].age + ' ปี ที่อยู่: ' + data.rows[0].address
                    $('#txt_service_profile').val(detail);
                    $('#txt_service_hn').val(data.rows[0].hn);
                }
                else
                {
                    $('#txt_service_profile').val('');
                    app.alert('ไม่พบข้อมูลที่ค้นหา');
                    $('#txt_service_hn').val('');
                }
            });
        }
    });


    //save service
    $('#btn_save_service_register').click(function(){
        var items = {};
        items.vn = $('#txt_service_vn').val();
        items.hn = $('#txt_service_hn').val();
        items.appoint_id = $('#txt_service_appoint_id').val();
        items.date_serv = $('#txt_reg_service_date').val();
        items.time_serv = $('#txt_reg_service_time').val();
        items.clinic = $('#sl_reg_service_clinic').val();
        items.doctor_room = $('#sl_reg_service_doctor_room').val();
        items.patient_type = $('#sl_reg_service_pttype').val();
        items.location = $('#sl_reg_service_location').val();
        items.type_in = $('#sl_reg_service_typein').val();
        items.service_place = $('#sl_reg_service_service_place').val();
        items.insc_id = $('#sl_reg_service_insc').val();
        items.insc_code = $('#txt_reg_service_insc_code').val();
        items.insc_start_date = $('#txt_reg_service_insc_start_date').val();
        items.insc_expire_date = $('#txt_reg_service_insc_expire_date').val();
        items.insc_hosp_main = $('#txt_reg_service_insc_hosp_main_code').val();
        items.insc_hosp_sub = $('#txt_reg_service_insc_hosp_sub_code').val();
        items.cc = $('#txt_reg_service_cc').val();


        if(!items.hn)
        {
            app.alert('กรุณาระบุผู้รับบริการ');
        }
        else if(!items.date_serv){
            app.alert('กรุณาระบุวันที่รับบริการ');
        }else if(!items.time_serv){
            app.alert('กรุณาระบุเวลารับบริการ');
        }else if(!items.clinic){
            app.alert('กรุณาระบุ คลินิก');
        }else if(!items.patient_type){
            app.alert('กรุณาระบุ ประเภทผู้ป่วย');
        }else if(!items.doctor_room){
            app.alert('กรุณา เลือกห้องตรวจ');
        }else if(!items.location){
            app.alert('กรุณาระบุ ที่ตั้ง');
        }else if(!items.type_in){
            app.alert('กรุณาระบุ ประเภทการมา');
        }else if(!items.service_place){
            app.alert('กรุณาระบุ สถานที่รับบริการ');
        }else if(!items.insc_id){
            app.alert('กรุณาระบ สิทธิการรักษาพยาบาล');
        }else if(!items.cc){
            app.alert('กรุณาระบุ อาการแรกรับ (CC)');
        }else{
            //do save
            regsv.ajax.do_register(items, function(err, v){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกข้อมูลส่งตรวจเสร็จเรียบร้อยแล้ว.');
                    $('#txt_service_vn').val(v.vn);
                }
            });
        }

    });

    $('#txt_reg_service_insc_hosp_main_name').typeahead({
        ajax: {
            url: site_url + '/basic/search_hospital_ajax',
            timeout: 500,
            displayField: 'fullname',
            triggerLength: 3,
            preDispatch: function(query){
                return {
                    query: query,
                    csrf_token: csrf_token
                }
            },

            preProcess: function(data){
                if(data.success){
                    return data.rows;
                }else{
                    return false;
                }
            }
        },
        updater: function(data){
            var d = data.split('#');
            var name = d[0],
                code = d[1];

            $('#txt_reg_service_insc_hosp_main_code').val(code);
            $('#txt_reg_service_insc_hosp_main_name').val(name);

            return name;
        }
    });

    $('#txt_service_profile_hn').bind('keyup', function(e) {
        $('#txt_hn').val('');
    });
    $('#txt_reg_service_insc_hosp_sub_name').bind('keyup', function(e) {
        $('#txt_reg_service_insc_hosp_sub_code').val('');
    });
    $('#txt_reg_service_insc_hosp_main_name').bind('keyup', function(e) {
        $('#txt_reg_service_insc_hosp_main_code').val('');
    });
    $('#txt_service_profile_hn').bind('keyup', function(e) {
        $('#txt_service_profile').val('');
        $('#txt_service_hn').val('');
    });

    $('#txt_reg_service_insc_hosp_sub_name').typeahead({
        ajax: {
            url: site_url + '/basic/search_hospital_ajax',
            timeout: 500,
            displayField: 'fullname',
            triggerLength: 3,
            preDispatch: function(query){
                return {
                    query: query,
                    csrf_token: csrf_token
                }
            },

            preProcess: function(data){
                if(data.success){
                    return data.rows;
                }else{
                    return false;
                }
            }
        },
        updater: function(data){
            var d = data.split('#');
            var name = d[0],
                code = d[1];

            $('#txt_reg_service_insc_hosp_sub_code').val(code);
            $('#txt_reg_service_insc_hosp_sub_name').val(name);

            return name;
        }
    });


    app.set_runtime();
});