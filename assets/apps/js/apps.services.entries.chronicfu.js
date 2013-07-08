head.ready(function() {

    var chronicfu = {};

    chronicfu.ajax = {
        save: function(items, cb){
            var url = 'chronicfu/save',
                params = {
                    data: items
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        detail: function(hn, vn, cb){
            var url = 'chronicfu/detail',
                params = {
                    hn: hn,
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        },
        remove: function(hn, vn, cb){
            var url = 'chronicfu/remove',
                params = {
                    hn: hn,
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                err ? cb(err) : cb(null, data);
            });
        }
    };

    chronicfu.get_detail = function(hn, vn) {
        chronicfu.ajax.detail(hn, vn, function(err, data) {
            if(err)
            {
                app.alert(err);
            }
            else
            {
                chronicfu.set_detail(data.rows);
            }
        });
    };

    chronicfu.set_detail = function(v) {
        $('#sl_cfu_eye_result_left').val(v.eye_result_left);
        $('#sl_cfu_eye_result_right').val(v.eye_result_right);
        $('#txt_cfu_eye_va_left').val(v.eye_va_left);
        $('#txt_cfu_eye_va_right').val(v.eye_va_right);
        $('#txt_cfu_eye_iop_left').val(v.eye_iop_left);
        $('#txt_cfu_eye_iop_right').val(v.eye_iop_right);
        $('#txt_cfu_eye_oth_dz_left').val(v.eye_oth_dz_left);
        $('#txt_cfu_eye_oth_dz_right').val(v.eye_oth_dz_right);
        $('#sl_cfu_eye_macular').val(v.eye_macular);
        $('#sl_cfu_eye_laser').val(v.eye_laser);
        $('#sl_cfu_eye_cataract').val(v.eye_cataract);
        $('#sl_cfu_eye_surgery').val(v.eye_surgery);
        $('#sl_cfu_eye_blindness').val(v.eye_blindness);
        $('#txt_cfu_eye_treatment').val(v.eye_treatment);
        $('#txt_cfu_eye_remark').val(v.eye_remark);
        // Foot
        $('#sl_cfu_foot_result_left').val(v.foot_result_left);
        $('#sl_cfu_foot_result_right').val(v.foot_result_right);
        $('#sl_cfu_foot_ulcer').val(v.foot_ulcer);
        $('#sl_cfu_foot_his_ulcer').val(v.foot_his_ulcer);
        $('#sl_cfu_foot_his_amp').val(v.foot_his_amp);
        $('#sl_cfu_foot_his_sens').val(v.foot_his_sens);
        $('#sl_cfu_foot_nail').val(v.foot_nail);
        $('#sl_cfu_foot_wart').val(v.foot_wart);
        $('#sl_cfu_foot_footshape').val(v.foot_footshape);
        $('#sl_cfu_foot_hair').val(v.foot_hair);
        $('#sl_cfu_foot_temp').val(v.foot_temp);
        $('#sl_cfu_foot_tenia').val(v.foot_tenia);
        $('#sl_cfu_foot_sensory').val(v.foot_sensory);
        $('#sl_cfu_foot_dieskin').val(v.foot_dieskin);
        $('#sl_cfu_foot_skincolor').val(v.foot_skincolor);
        $('#sl_cfu_foot_posttib_left').val(v.foot_posttib_left);
        $('#sl_cfu_foot_posttib_right').val(v.foot_posttib_right);
        $('#sl_cfu_foot_dorsped_left').val(v.foot_dorsped_left);
        $('#sl_cfu_foot_dorsped_right').val(v.foot_dorsped_right);
        $('#txt_cfu_foot_shoe').val(v.foot_shoe);
        $('#txt_cfu_foot_remark').val(v.foot_remark);
    };

    chronicfu.modal = {
        show_new: function()
        {
            $('#mdl_ncd_follow').modal({
                backdrop: 'static'
            });
        },
        hide_new: function()
        {
            $('#mdl_ncd_follow').modal('hide');
        }
    };

    $('a[data-name="btn_chronic_fu"]').on('click', function() {
        var hn = $('#hn').val();
        var vn = $('#vn').val();

        chronicfu.clear_form();
        chronicfu.get_detail(hn, vn);
        //show modal
        chronicfu.modal.show_new();
    });

    chronicfu.clear_form = function() {
        app.set_first_selected($('#sl_cfu_eye_result_left'));
        app.set_first_selected($('#sl_cfu_eye_result_right'));
        $('#txt_cfu_eye_va_left').val('');
        $('#txt_cfu_eye_va_right').val('');
        $('#txt_cfu_eye_iop_left').val('');
        $('#txt_cfu_eye_iop_right').val('');
        $('#txt_cfu_eye_oth_dz_left').val('');
        $('#txt_cfu_eye_oth_dz_right').val('');
        app.set_first_selected($('#sl_cfu_eye_macular'));
        app.set_first_selected($('#sl_cfu_eye_laser'));
        app.set_first_selected($('#sl_cfu_eye_cataract'));
        app.set_first_selected($('#sl_cfu_eye_surgery'));
        app.set_first_selected($('#sl_cfu_eye_blindness'));
        $('#txt_cfu_eye_treatment').val('');
        $('#txt_cfu_eye_remark').val('');
        // Foot
        app.set_first_selected($('#sl_cfu_foot_result_left'));
        app.set_first_selected($('#sl_cfu_foot_result_right'));
        app.set_first_selected($('#sl_cfu_foot_ulcer'));
        app.set_first_selected($('#sl_cfu_foot_his_ulcer'));
        app.set_first_selected($('#sl_cfu_foot_his_amp'));
        app.set_first_selected($('#sl_cfu_foot_his_sens'));
        app.set_first_selected($('#sl_cfu_foot_nail'));
        app.set_first_selected($('#sl_cfu_foot_wart'));
        app.set_first_selected($('#sl_cfu_foot_footshape'));
        app.set_first_selected($('#sl_cfu_foot_hair'));
        app.set_first_selected($('#sl_cfu_foot_temp'));
        app.set_first_selected($('#sl_cfu_foot_tenia'));
        app.set_first_selected($('#sl_cfu_foot_sensory'));
        app.set_first_selected($('#sl_cfu_foot_dieskin'));
        app.set_first_selected($('#sl_cfu_foot_skincolor'));
        app.set_first_selected($('#sl_cfu_foot_posttib_left'));
        app.set_first_selected($('#sl_cfu_foot_posttib_right'));
        app.set_first_selected($('#sl_cfu_foot_dorsped_left'));
        app.set_first_selected($('#sl_cfu_foot_dorsped_right'));
        $('#txt_cfu_foot_shoe').val('');
        $('#txt_cfu_foot_remark').val('');
    };

    $('#btn_cfu_save').on('click', function() {
       var items = {};

        items.vn = $('#vn').val();
        items.hn = $('#hn').val();

        items.eye_result_left = $('#sl_cfu_eye_result_left').val();
        items.eye_result_right = $('#sl_cfu_eye_result_right').val();
        items.eye_va_left = $('#txt_cfu_eye_va_left').val();
        items.eye_va_right = $('#txt_cfu_eye_va_right').val();
        items.eye_iop_left = $('#txt_cfu_eye_iop_left').val();
        items.eye_iop_right = $('#txt_cfu_eye_iop_right').val();
        items.eye_oth_dz_left = $('#txt_cfu_eye_oth_dz_left').val();
        items.eye_oth_dz_right = $('#txt_cfu_eye_oth_dz_right').val();
        items.eye_macular = $('#sl_cfu_eye_macular').val();
        items.eye_laser = $('#sl_cfu_eye_laser').val();
        items.eye_cataract = $('#sl_cfu_eye_cataract').val();
        items.eye_surgery = $('#sl_cfu_eye_surgery').val();
        items.eye_blindness = $('#sl_cfu_eye_blindness').val();
        items.eye_treatment = $('#txt_cfu_eye_treatment').val();
        items.eye_remark = $('#txt_cfu_eye_remark').val();
        // Foot
        items.foot_result_left = $('#sl_cfu_foot_result_left').val();
        items.foot_result_right = $('#sl_cfu_foot_result_right').val();
        items.foot_ulcer = $('#sl_cfu_foot_ulcer').val();
        items.foot_his_ulcer = $('#sl_cfu_foot_his_ulcer').val();
        items.foot_his_amp = $('#sl_cfu_foot_his_amp').val();
        items.foot_his_sens = $('#sl_cfu_foot_his_sens').val();
        items.foot_nail = $('#sl_cfu_foot_nail').val();
        items.foot_wart = $('#sl_cfu_foot_wart').val();
        items.foot_footshape = $('#sl_cfu_foot_footshape').val();
        items.foot_hair = $('#sl_cfu_foot_hair').val();
        items.foot_temp = $('#sl_cfu_foot_temp').val();
        items.foot_tenia = $('#sl_cfu_foot_tenia').val();
        items.foot_sensory = $('#sl_cfu_foot_sensory').val();
        items.foot_dieskin = $('#sl_cfu_foot_dieskin').val();
        items.foot_skincolor = $('#sl_cfu_foot_skincolor').val();
        items.foot_posttib_left = $('#sl_cfu_foot_posttib_left').val();
        items.foot_posttib_right = $('#sl_cfu_foot_posttib_right').val();
        items.foot_dorsped_left = $('#sl_cfu_foot_dorsped_left').val();
        items.foot_dorsped_right = $('#sl_cfu_foot_dorsped_right').val();
        items.foot_shoe = $('#txt_cfu_foot_shoe').val();
        items.foot_remark = $('#txt_cfu_foot_remark').val();

        app.confirm('คุณต้องการบันทึกข้อมูลใช่หรือไม่?', function(res) {
            if(res)
            {
                chronicfu.ajax.save(items, function(err) {
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
                        chronicfu.clear_form();
                        chronicfu.modal.hide_new();
                    }
                });
            }
        });
    });


    $('#btn_cfu_remove').on('click', function() {
        var hn = $('#hn').val();
        var vn = $('#vn').val();

        app.confirm('คุณต้องการลบข้อมูลนี้ใช่หรือไม่?', function(res) {
            if(res)
            {
                chronicfu.ajax.remove(hn, vn, function(err) {
                    if(err)
                    {
                        app.alert('ไม่สามารถลบรายการได้');
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        chronicfu.clear_form();
                        chronicfu.modal.hide_new();
                    }
                });
            }
        });
    });
});