head.ready(function(){

    var entries = {};

    entries.vn = $('#vn').val();

    entries.modal = {
        show_edit: function(hn, vn) {
            app.load_page($('#mdl_new_service'), '/pages/register_service/' + hn + '/' + vn, 'assets/apps/js/pages/register_service.js');
            $('#mdl_new_service').modal({keyboard: false});
        }
    };

    entries.ajax = {
        save_screening: function(data, cb){

            var url = 'services/save_screening',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_screening: function(vn, cb){

            var url = 'services/get_screening',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove_service: function(hn, vn, cb){

            var url = 'services/remove_service',
                params = {
                    vn: vn,
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    //save screening
    $('#btn_save_screening').click(function(){
        var items = {};
        items.vn = $('#vn').val();
        items.cc = $('#txt_screening_cc').val();
        items.pe = $('#txt_screening_pe').val();
        items.height = $('#txt_screening_height').val();
        items.weight = $('#txt_screening_weight').val();
        items.body_tmp = $('#txt_screening_body_tmp').val();
        items.waist = $('#txt_screening_waist').val();
        items.pluse = $('#txt_screening_pluse').val();
        items.breathe = $('#txt_screening_breathe').val();
        items.sbp = $('#txt_screening_sbp').val();
        items.dbp = $('#txt_screening_dbp').val();
        items.ill_history = $('input[name="rd_ill_history"]:checked').val();
        items.operate = $('#chk_operate').is(":checked") ? '1' : '0';
        items.typeout = $('#sl_typeout').val();

        //screen
        items.smoking = $('#sl_screening_smoking').val();
        items.drinking = $('#sl_screening_drinking').val();

        //mind
        items.mind_strain = $('#chk_screening_screen_mind_strain').is(':checked') ? '1' : '0';
        items.mind_work = $('#chk_screening_screen_mind_work').is(':checked') ? '1' : '0';
        items.mind_family = $('#chk_screening_screen_mind_family').is(':checked') ? '1' : '0';
        items.mind_other = $('#chk_screening_screen_mind_other').is(':checked') ? '1' : '0';
        items.mind_other_detail = $('#txt_screening_screen_mind_other_detail').val();

        if(items.mind_other == '1'){
            items.mind_other_detail = $('#txt_screening_screen_mind_other_detail').val();
        }else{
            items.mind_other_detail = '';
            $('#txt_screening_screen_mind_other_detail').val('');
        }
        //risk
        items.risk_ht = $('#chk_screening_screen_risk_ht').is(':checked') ? '1' : '0';
        items.risk_dm = $('#chk_screening_screen_risk_dm').is(':checked') ? '1' : '0';
        items.risk_stoke = $('#chk_screening_screen_risk_stoke').is(':checked') ? '1' : '0';
        items.risk_other = $('#chk_screening_screen_risk_other').is(':checked') ? '1' : '0';

        if(items.risk_other == '1'){
            items.risk_other_detail = $('#txt_screening_screen_risk_other_detail').val();
        }else{
            items.risk_other_detail = '';
            $('#txt_screening_screen_risk_other_detail').val('');
        }


        //lmp
        items.lmp = $('#sl_screening_lamp').val();

        var sex = $('#person_sex').val();

        if(items.lmp == '0'){
            $('#txt_screening_lmp_start').val('');
        }else{
            $('#txt_screening_lmp_finished').val('');
        }

        items.lmp_start = $('#txt_screening_lmp_start').val();
        items.lmp_finished = $('#txt_screening_lmp_finished').val();

        if(items.ill_history == '1'){
            items.ill_history_ill_detail = $('#txt_ill_history_ill_detail').val();
        }

        if(items.operate == '1'){
            items.operate_detail = $('#txt_ill_history_operate_detail').val();
            items.operate_year = $('#txt_operate_year').val();
        }

        items.consult_drug = $('#chk_screening_consult_drug').is(':checked') ? '1' : '0';
        items.consult_activity = $('#chk_screening_consult_activity').is(':checked') ? '1' : '0';
        items.consult_food = $('#chk_screening_consult_food').is(':checked') ? '1' : '0';
        items.consult_appoint = $('#chk_screening_consult_appoint').is(':checked') ? '1' : '0';
        items.consult_exercise = $('#chk_screening_consult_exercise').is(':checked') ? '1' : '0';
        items.consult_complication = $('#chk_screening_consult_complication').is(':checked') ? '1' : '0';
        items.consult_other = $('#chk_screening_consult_other').is(':checked') ? '1' : '0';
        items.consult_other_detail = $('#chk_screening_consult_other_detail').val();

        if(!items.cc){
            app.alert('กรุณาระบุ อาการสำคัญ (Chief complaint)');
        }else if(!items.pe){
            app.alert('กรุณาระบุ การตรวจร่างกาย (Physical examination)');
        }else if(!items.height){
            app.alert('กรุณาระบุ ส่วนสูง');
        }else if(!items.weight){
            app.alert('กรุณาระบุ น้ำหนัก');
        }else if(!items.body_tmp){
            app.alert('กรุณาระบุ อุณหภูมิของร่างกาย');
        }else if(!items.pluse){
            app.alert('กรุณาระบุ ชีพจร');
        }else if(!items.breathe){
            app.alert('กรุณาระบุ การเต้นของหัวใจ');
        }else if(!items.sbp){
            app.alert('กรุณาระบุ ความดัน (SBP)');
        }else if(!items.dbp){
            app.alert('กรุณาระบุ ความดัน (DBP)');
        }else if(items.operate == '1' && !items.operate_detail && !items.operate_year){
            app.alert('กรุณาระบุ รายละเอียดการผ่าตัด');
        }else if(items.operate == '1' && !items.operate_year){
            app.alert('กรุณาระบุ ปีที่ผ่าตัด');
        }else if(items.ill_history == '1' && !items.ill_history_ill_detail){
            app.alert('กรุณาระบุ โรคประจำตัว');
        }else if(items.mind_other == '1' && !items.mind_other_detail){
            app.alert('กรุณาระบุ สุขภาพจิต อื่นๆ');
        }else if(items.risk_other == '1' && !items.risk_other_detail){
            app.alert('กรุณาระบุ ความเสี่ยงอื่นๆ');
        }else if(sex == '1' && (items.lmp == '0' || items.lmp == '1')){
            app.alert('เป็นเพศชาย ไม่สามารถระบุการเป็นประจำเดือนได้ กรุณาตรวจสอบ');
        }else if(items.lmp == '1' && !items.lmp_start){
            app.alert('กรุณาระบุ วันที่มีประจำเดือน');
        }else if(items.lmp == '0' && !items.lmp_finished){
            app.alert('กรุณาระบุ วันที่หมดประจำเดือน');
        }else if(items.consult_other == '1' && !items.consult_other_detail){
            app.alert('กรุณาระบุ การให้คำปรึกษาอื่นๆ');
        }else{
            //do save
            items.operate_detail = items.operate == '1' ? items.operate_detail : '';
            items.operate_year = items.operate == '1' ? items.operate_year : '';

            items.ill_history_ill_detail = items.ill_history == '1' ? items.ill_history_ill_detail : '';

                entries.ajax.save_screening(items, function(err){
                if(err){
                    app.alert(err);
                }else{
                    app.alert('บันทึกข้อมูล Screening เสร็จเรียบร้อยแล้ว');
                }
            });
        }

    });

    //get screening

    entries.ajax.get_screening(entries.vn, function(err, data){
        if(err){
            app.alert('ไม่พบข้อมูล Screening [' + err + ']');
        }else{
            //set data
            $('#txt_screening_cc').val(data.rows.cc);
            $('#txt_screening_pe').val(data.rows.pe);
            $('#txt_screening_height').val(data.rows.height);
            $('#txt_screening_weight').val(data.rows.weight);
            $('#txt_screening_body_tmp').val(data.rows.body_tmp);
            $('#txt_screening_waist').val(data.rows.waist);
            $('#txt_screening_pluse').val(data.rows.pluse);
            $('#txt_screening_breathe').val(data.rows.breathe);
            $('#txt_screening_sbp').val(data.rows.sbp);
            $('#txt_screening_dbp').val(data.rows.dbp);
            $('#sl_typeout').val(data.rows.typeout);
            $('#sl_service_place').val(data.rows.service_place);
            $('#sl_typein').val(data.rows.typein);
            $('#sl_location').val(data.rows.location);
            $('#sl_intime').val(data.rows.intime);

            if(data.rows.ill_history == '1'){
                $('#rd_ill_history2').prop('checked', 'checked');
                $('#rd_ill_history1').removeProp('checked');
                $('#txt_ill_history_ill_detail').val(data.rows.ill_history_ill_detail);
            }else{
                $('#rd_ill_history2').removeProp('checked');
                $('#rd_ill_history1').prop('checked', 'checked');
                $('#txt_ill_history_ill_detail').val('');
            }

            if(data.rows.operate == '1'){
                $('#chk_operate').prop('checked', 'checked');
                $('#txt_ill_history_operate_detail').val(data.rows.operate_detail);
                $('#txt_operate_year').val(data.rows.operate_year);
            }else{
                $('#chk_operate').removeProp('checked');
                $('#txt_ill_history_operate_detail').val('');
                $('#txt_operate_year').val('');
            }

            //screen
            $('#sl_screening_smoking').val(data.rows.smoking);
            $('#sl_screening_drinking').val(data.rows.drinking);

            data.rows.mind_strain == '1' ? $('#chk_screening_screen_mind_strain').prop('checked', 'checked') : $('#chk_screening_screen_mind_strain').removeProp('checked');
            data.rows.mind_work == '1' ? $('#chk_screening_screen_mind_work').prop('checked', 'checked') : $('#chk_screening_screen_mind_work').removeProp('checked');
            data.rows.mind_family == '1' ? $('#chk_screening_screen_mind_family').prop('checked', 'checked') : $('#chk_screening_screen_mind_family').removeProp('checked');

            if(data.rows.mind_other == '1'){
                $('#chk_screening_screen_mind_other').prop('checked', 'checked')
                $('#txt_screening_screen_mind_other_detail').val(data.rows.mind_other_detail);
            }else{
                $('#txt_screening_screen_mind_other_detail').val('');
                $('#chk_screening_screen_mind_other').removeProp('checked');
            }
            //risk

            data.rows.risk_ht == '1' ? $('#chk_screening_screen_risk_ht').prop('checked', 'checked') : $('#chk_screening_screen_risk_ht').removeProp('checked');
            data.rows.risk_dm == '1' ? $('#chk_screening_screen_risk_dm').prop('checked', 'checked') : $('#chk_screening_screen_risk_dm').removeProp('checked');
            data.rows.risk_stoke == '1' ? $('#chk_screening_screen_risk_stoke').prop('checked', 'checked') : $('#chk_screening_screen_risk_stoke').removeProp('checked');

            if(data.rows.risk_other == '1'){
                $('#chk_screening_screen_risk_other').prop('checked', 'checked')
                $('#txt_screening_screen_risk_other_detail').val(data.rows.risk_other_detail);
            }else{
                $('#txt_screening_screen_risk_other_detail').val('');
                $('#chk_screening_screen_risk_other').removeProp('checked');
            }

            $('#sl_screening_lamp').val(data.rows.lmp);

            if(data.rows.lmp == '0'){
                $('#txt_screening_lmp_start').val('');
                $('#txt_screening_lmp_finished').val(data.rows.lmp_finished);
            }else if(data.rows.lmp == '1'){
                $('#txt_screening_lmp_start').val(data.rows.lmp_start);
                $('#txt_screening_lmp_finished').val('');
            }else{
                $('#txt_screening_lmp_start').val('');
                $('#txt_screening_lmp_finished').val();
            }

            data.rows.consult_drug == '1' ? $('#chk_screening_consult_drug').prop('checked', 'checked') : $('#chk_screening_consult_drug').removeProp('checked');
            data.rows.consult_activity == '1' ? $('#chk_screening_consult_activity').prop('checked', 'checked') : $('#chk_screening_consult_activity').removeProp('checked');
            data.rows.consult_food == '1' ? $('#chk_screening_consult_food').prop('checked', 'checked') : $('#chk_screening_consult_food').removeProp('checked');
            data.rows.consult_appoint == '1' ? $('#chk_screening_consult_appoint').prop('checked', 'checked') : $('#chk_screening_consult_appoint').removeProp('checked');
            data.rows.consult_exercise == '1' ? $('#chk_screening_consult_exercise').prop('checked', 'checked') : $('#chk_screening_consult_exercise').removeProp('checked');
            data.rows.consult_complication == '1' ? $('#chk_screening_consult_complication').prop('checked', 'checked') : $('#chk_screening_consult_complication').removeProp('checked');
            if(data.rows.consult_other == '1'){
                $('#chk_screening_consult_other').prop('checked', 'checked');
                $('#chk_screening_consult_other_detail').val(data.rows.consult_other_detail);
            }else{
                $('#chk_screening_consult_other').removeProp('checked');
                $('#chk_screening_consult_other_detail').val('');
            }
        }
    });

    $('#btn_edit_service').on('click', function() {
        var hn = $('#hn').val(),
            vn = $('#vn').val();

        entries.modal.show_edit(hn, vn);
    });

    $('#btn_remove_service').on('click', function() {
        var hn = $('#hn').val(),
            vn = $('#vn').val();

        if(confirm('คุณต้องการลบการรับบริการครั้งนี้ ใช่หรือไม่?'))
        {
            entries.ajax.remove_service(hn, vn, function(err) {
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('ลบข้อมูลการรับบริการเสร็จเรียบร้อยแล้ว');
                    app.go_to_url('services');
                }
            });
        }
    });
});