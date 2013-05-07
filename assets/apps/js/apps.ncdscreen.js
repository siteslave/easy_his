head.ready(function(){
    //namespace
    var ncdscreen = {};


    ncdscreen.ajax = {
        get_list: function(year, start, stop, cb){

            var url = 'ncdscreen/get_list',
                params = {
                    year: year,
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_list_total: function(year, cb){

            var url = 'ncdscreen/get_list_total',
                params = {
                    year: year
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        save: function(data, cb){

            var url = 'ncdscreen/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        clear: function(data, cb){

            var url = 'ncdscreen/clear',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_detail: function(year, hn, cb){

            var url = 'ncdscreen/get_detail',
                params = {
                    year: year,
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search_filter: function(items, start, stop, cb){

            var url = 'ncdscreen/search_filter',
                params = {
                    year: items.year,
                    village_id: items.village_id,
                    start: start,
                    stop: stop
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        search: function(query, year, cb){

            var url = 'ncdscreen/search',
                params = {
                    query: query,
                    year: year
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        search_filter_total: function(items, cb){

            var url = 'ncdscreen/search_filter_total',
                params = {
                    year: items.year,
                    village_id: items.village_id
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },

        get_result: function(year, cb){

            var url = 'ncdscreen/get_result',
                params = {
                    year: year
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    ncdscreen.modal = {
        show_screen: function(){
            $('#mdl_screen').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }, show_result: function(){
            $('#mdl_result').modal({
                backdrop: 'static'
            }).css({
                    width: 680,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        },
        hide_screen: function(){
            $('#mdl_screen').modal('hide');
        }
    };

    ncdscreen.get_list = function()
    {
        var year = $('#sl_year').val();

        $('#tbl_list > tbody').empty();

        $('#main_paging').fadeIn('slow');

        ncdscreen.ajax.get_list_total(year, function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        ncdscreen.ajax.get_list(year, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                            }else{
                                ncdscreen.set_list(data);
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
    ncdscreen.search_filter = function(items)
    {

        $('#tbl_list > tbody').empty();

        $('#main_paging').fadeIn('slow');
        ncdscreen.ajax.search_filter_total(items, function(err, data){
            if(err){
                app.alert(err);
            }else{
                $('#main_paging > ul').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: 1,
                    onSelect: function(page){
                        ncdscreen.ajax.search_filter(items, this.slice[0], this.slice[1], function(err, data){
                            if(err){
                                app.alert(err);
                            }else{
                                ncdscreen.set_list(data);
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

    ncdscreen.set_list = function(data)
    {

        var year = $('#sl_year').val();

        $('#tbl_list > tbody').empty();

        if(!data)
        {
            $('#tbl_list > tbody').append('<tr><td colspan="9">ไม่พบข้อมูล</td></td></tr>');
        }
        else
        {
            _.each(data.rows, function(v)
            {
                var screen_place = v.screen_place == '1' ? 'ในสถานบริการ' : v.screen_place == '2' ? 'นอกสถานบริการ' : '-';
                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>'+ v.hn +'</td>' +
                        '<td>'+ v.cid +'</td>' +
                        '<td>'+ v.first_name + ' ' + v.last_name +'</td>' +
                        '<td>'+ app.mongo_to_thai_date(v.birthdate) +'</td>' +
                        '<td>'+ v.age +'</td>' +
                        '<td>'+ app.clear_null(v.screen_date) +'</td>' +
                        '<td>'+ screen_place +'</td>' +
                        '<td>'+ app.clear_null(v.weight) +'</td>' +
                        '<td>'+ app.clear_null(v.height) +'</td>' +
                        '<td>'+ app.clear_null(v.fbs) +'</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" data-name="btn_screen" class="btn" data-hn="'+ v.hn +'" ' +
                        'data-cid="'+ v.cid +'" data-fullname="'+ v.first_name + ' ' + v.last_name +'" ' +
                        'data-age="'+ v.age +'" data-birthdate="'+ app.mongo_to_thai_date(v.birthdate) +'" data-year="'+ year +'">' +
                        '<i class="icon-edit"></i></a>' +
                        '<a href="javascript:void(0);" data-name="btn_clear" class="btn" data-hn="'+ v.hn +'" data-year="'+ year +'" title="ยกเลิกข้อมูลการคัดกรอง">' +
                        '<i class="icon-trash"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
            });
        }
    };


    var dm_history = '0',
        ht_history = '0',
        lv_history = '0',
        ds_history = '0',
        hb_history = '0',
        lb_history = '0',
        lg_history = '0',
        bb_history = '0',
        wt_history = '0',
        ur_history = '0',
        et_history = '0',
        we_history = '0',
        mo_history = '0',
        sk_history = '0',
        ey_history = '0',
        fg_history = '0',
        status_history = '0';

    $(document).on('click', 'a[data-name="btn_screen"]', function(){
        var fullname = $(this).data('fullname'),
            hn = $(this).data('hn'),
            cid = $(this).data('cid'),
            age = $(this).data('age'),
            birthdate = $(this).data('birthdate'),
            year = $(this).data('year');

        ncdscreen.clear_form();

        $('#txt_fullname').val(fullname);
        $('#txt_hn').val(hn);
        $('#txt_cid').val(cid);
        $('#txt_birthdate').val(birthdate);
        $('#txt_age').val(age);

        //get detail
        ncdscreen.ajax.get_detail(year, hn, function(err, data){
            if(!err)
            {
                if(data.rows)
                {
                    //set detail
                    ncdscreen.set_detail(data.rows);
                }

            }
        });

        ncdscreen.modal.show_screen();
    });

    ncdscreen.set_detail = function(v)
    {
        $('#txt_screen_date').val(app.mongo_to_js_date(v.screen_date));
        $('#txt_screen_time').val(v.screen_time);
        $('#txt_weight').val(v.weight);
        $('#txt_height').val(v.height);
        $('#txt_waistline').val(v.waistline);
        $('#txt_bmi').val(v.bmi);
        v.fm_dm == '1' ? $('#chk_fm_dm').prop('checked', true) :  $('#chk_fm_dm').prop('checked', false);
        v.fm_ht == '1' ? $('#chk_fm_ht').prop('checked', true) : $('#chk_fm_ht').prop('checked', false);
        v.fm_gout == '1' ? $('#chk_fm_gout').prop('checked', 'checked') : $('#chk_fm_gout').prop('checked', false);
        v.fm_crf == '1' ? $('#chk_fm_crf').prop('checked', true) : $('#chk_fm_crf').removeProp('checked');
        v.fm_mi == '1' ? $('#chk_fm_mi').prop('checked', true) : $('#chk_fm_mi').removeProp('checked');
        v.fm_copd == '1' ? $('#chk_fm_copd').prop('checked', true) : $('#chk_fm_copd').removeProp('checked');
        v.fm_stroke == '1' ? $('#chk_fm_stroke').prop('checked', true) : $('#chk_fm_stroke').prop('checked', false);
        v.fm_not_know == '1' ? $('#chk_fm_not_know').prop('checked', true) : $('#chk_fm_not_know').prop('checked', false);
        v.fm_no == '1' ? $('#chk_fm_no').prop('checked', true) : $('#chk_fm_no').prop('checked', false);
        v.fm_other == '1' ? $('#chk_fm_other').prop('checked', true) : $('#chk_fm_other').prop('checked', false);

        $('#txt_fm_other_detail').val(v.fm_other_detail);

        v.sb_dm == '1' ? $('#chk_sb_dm').prop('checked', true) : $('#chk_sb_dm').prop('checked', false);
        v.sb_ht == '1' ? $('#chk_sb_ht').prop('checked', true) : $('#chk_sb_ht').prop('checked', false);
        v.sb_gout == '1' ? $('#chk_sb_gout').prop('checked', true) : $('#chk_sb_gout').prop('checked', false);
        v.sb_crf == '1' ? $('#chk_sb_crf').prop('checked', true) : $('#chk_sb_crf').prop('checked', false);
        v.sb_mi == '1' ? $('#chk_sb_mi').prop('checked', true) : $('#chk_sb_mi').prop('checked', false);
        v.sb_copd == '1' ? $('#chk_sb_copd').prop('checked', true) : $('#chk_sb_copd').prop('checked', false);
        v.sb_stroke == '1' ? $('#chk_sb_stroke').prop('checked', true) : $('#chk_sb_stroke').prop('checked', false);
        v.sb_not_know == '1' ? $('#chk_sb_not_know').prop('checked', true) : $('#chk_sb_not_know').prop('checked', false);
        v.sb_no == '1' ? $('#chk_sb_no').prop('checked', true) : $('#chk_sb_no').prop('checked', false);
        v.sb_other == '1' ? $('#chk_sb_other').prop('checked', true) : $('#chk_sb_other').prop('checked', false);

        $('#txt_sb_other_detail').val(v.sb_other_detail);

        $('input[name="rd_smoke"]').each(function(){
            $(this).val() == v.smoke ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        $('#txt_smoke_qty').val(v.smoke_qty);
        $('#txt_smoke_type').val(v.smoke_type);
        $('#txt_smoke_year').val(v.smoke_year);
        $('#txt_smoked_qty').val(v.smoked_qty);
        $('#txt_smoked_type').val(v.smoked_type);
        $('#txt_smoked_year').val(v.smoked_year);

        $('input[name="rd_drink"]').each(function(){
            $(this).val() == v.drink ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        $('#txt_drink_qty').val(v.drink_qty);

        $('input[name="rd_sport"]').each(function(){
            $(this).val() == v.sport ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        v.food_taste_sweet == '1' ? $('#food_taste_sweet').prop('checked', true) : $('#food_taste_sweet').prop('checked', false);
        v.food_taste_salt == '1' ? $('#food_taste_salt').prop('checked', true) : $('#food_taste_salt').prop('checked', false);
        v.food_taste_creamy == '1' ? $('#food_taste_creamy').prop('checked', true) : $('#food_taste_creamy').prop('checked', false);
        v.food_taste_no == '1' ? $('#food_taste_no').prop('checked', true) : $('#food_taste_no').prop('checked', false);

        $('input[name="rd_screen_tb"]').each(function(){
            $(this).val() == v.screen_tb ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        $('#txt_sbp1').val(v.sbp1);
        $('#txt_dbp1').val(v.dbp1);
        $('#txt_sbp2').val(v.sbp2);
        $('#txt_dbp2').val(v.dbp2);
        $('#txt_sbp3').val(v.sbp3);
        $('#txt_dbp3').val(v.dbp3);
        $('#txt_fbs').val(v.fbs);
        $('#txt_blood_sugar').val(v.blood_sugar);

        $('input[name="rd_risk_meta"]').each(function(){
            $(this).val() == v.risk_meta ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        v.risk_meta_dm == '1' ? $('#chk_risk_meta_dm').prop('checked', true) :  $('#chk_risk_meta_dm').prop('checked', false);
        v.risk_meta_ht == '1' ? $('#chk_risk_meta_ht').prop('checked', true) : $('#chk_risk_meta_ht').prop('checked', false);
        v.risk_meta_stroke == '1' ? $('#chk_risk_meta_stroke').prop('checked', true) : $('#chk_risk_meta_stroke').prop('checked', false);
        v.risk_meta_obesity == '1' ? $('#chk_risk_meta_obesity').prop('checked', true) : $('#chk_risk_meta_obesity').prop('checked', false);

        $('input[name="rd_risk_ncd"]').each(function(){
            $(this).val() == v.risk_ncd ? $(this).prop('checked', true) : $(this).prop('checked', false)
        });

        v.risk_ncd_dm == '1' ? $('#chk_risk_ncd_dm').prop('checked', true) : $('#chk_risk_ncd_dm').prop('checked', false);
        v.risk_ncd_ht == '1' ? $('#chk_risk_ncd_ht').prop('checked', true) : $('#chk_risk_ncd_ht').prop('checked', false);
        v.risk_ncd_stroke == '1' ? $('#chk_risk_ncd_stroke').prop('checked', true) : $('#chk_risk_ncd_stroke').prop('checked', false);
        v.risk_ncd_obesity == '1' ? $('#chk_risk_ncd_obesity').prop('checked', true) : $('#chk_risk_ncd_obesity').prop('checked', false);

        $('input[name="rd_risk_disb"]').each(function(){
            $(this).val() == v.risk_disb ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        $('button[data-name="btn_dm_history"]').each(function(){
            $(this).data('value') == v.dm_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_ht_history"]').each(function(){
            $(this).data('value') == v.ht_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_lv_history"]').each(function(){
            $(this).data('value') == v.lv_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_ds_history"]').each(function(){
            $(this).data('value') == v.ds_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_hb_history"]').each(function(){
            $(this).data('value') == v.hb_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_lb_history"]').each(function(){
            $(this).data('value') == v.lb_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_lg_history"]').each(function(){
            $(this).data('value') == v.lg_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_bb_history"]').each(function(){
            $(this).data('value') == v.bb_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_wt_history"]').each(function(){
            $(this).data('value') == v.wt_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_ur_history"]').each(function(){
            $(this).data('value') == v.ur_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_et_history"]').each(function(){
            $(this).data('value') == v.et_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_we_history"]').each(function(){
            $(this).data('value') == v.we_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_mo_history"]').each(function(){
            $(this).data('value') == v.mo_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_sk_history"]').each(function(){
            $(this).data('value') == v.sk_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_ey_history"]').each(function(){
            $(this).data('value') == v.ey_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_fg_history"]').each(function(){
            $(this).data('value') == v.fg_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
        $('button[data-name="btn_status_history"]').each(function(){
            $(this).data('value') == v.status_history ? $(this).addClass('active') : $(this).removeClass('active');
        });
    };

    ncdscreen.clear_form = function()
    {
        $('#txt_hn').val('');
        $('#txt_screen_date').val('');
        $('#txt_screen_time').val('');
        $('#txt_weight').val('');
        $('#txt_height').val('');
        $('#txt_waistline').val('');
        $('#txt_bmi').val('');
        $('#chk_fm_dm').prop('checked', false);
        $('#chk_fm_ht').prop('checked', false);
        $('#chk_fm_gout').prop('checked', false);
        $('#chk_fm_crf').prop('checked', false);
        $('#chk_fm_mi').prop('checked', false);
        $('#chk_fm_copd').prop('checked', false);
        $('#chk_fm_stroke').prop('checked', false);
        $('#chk_fm_not_know').prop('checked', false);
        $('#chk_fm_no').prop('checked', false);
        $('#chk_fm_other').prop('checked', false);
        $('#txt_fm_other_detail').val('');
        $('#chk_sb_dm').prop('checked', false);
        $('#chk_sb_ht').prop('checked', false);
        $('#chk_sb_gout').prop('checked', false);
        $('#chk_sb_crf').prop('checked', false);
        $('#chk_sb_mi').prop('checked', false);
        $('#chk_sb_copd').prop('checked', false);
        $('#chk_sb_stroke').prop('checked', false);
        $('#chk_sb_not_know').prop('checked', false);
        $('#chk_sb_no').prop('checked', false);
        $('#chk_sb_other').prop('checked', false);
        $('#txt_sb_other_detail').val('');
        $('input[name="rd_smoke"]').each(function(){
            $(this).val() == '0' ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });
        $('#txt_smoke_qty').val('');
        $('#txt_smoke_type').val('');
        $('#txt_smoke_year').val('');
        $('#txt_smoked_qty').val('');
        $('#txt_smoked_type').val('');
        $('#txt_smoked_year').val('');

        $('input[name="rd_drink"]').each(function(){
            $(this).val() == '0' ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        $('#txt_drink_qty').val('');

        $('input[name="rd_sport"]').each(function(){
            $(this).val() == '0' ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        $('#food_taste_sweet').removeAttr('checked');
        $('#food_taste_salt').removeAttr('checked');
        $('#food_taste_creamy').removeAttr('checked');
        $('#food_taste_no').removeAttr('checked');

        $('input[name="rd_screen_tb"]').each(function(){
            $(this).val() == '0' ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        $('#txt_sbp1').val('');
        $('#txt_dbp1').val('');
        $('#txt_sbp2').val('');
        $('#txt_dbp2').val('');
        $('#txt_sbp3').val('');
        $('#txt_dbp3').val('');
        $('#txt_fbs').val('');
        $('#txt_blood_sugar').val('');

        $('input[name="rd_risk_meta"]').each(function(){
            $(this).val() == '0' ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        $('#chk_risk_meta_dm').prop('checked', false);
        $('#chk_risk_meta_ht').prop('checked', false);
        $('#chk_risk_meta_stroke').prop('checked', false);
        $('#chk_risk_meta_obesity').prop('checked', false);

        $('input[name="rd_risk_ncd"]').each(function(){
            $(this).val() == '0' ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        $('#chk_risk_ncd_dm').prop('checked', false);
        $('#chk_risk_ncd_ht').prop('checked', false);
        $('#chk_risk_ncd_stroke').prop('checked', false);
        $('#chk_risk_ncd_obesity').prop('checked', false);

        $('input[name="rd_risk_disb"]').each(function(){
            $(this).val() == '0' ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });

        $('button[data-name="btn_dm_history"]').removeClass('active');
        $('button[data-name="btn_ht_history"]').removeClass('active');
        $('button[data-name="btn_lv_history"]').removeClass('active');
        $('button[data-name="btn_ds_history"]').removeClass('active');
        $('button[data-name="btn_hb_history"]').removeClass('active');
        $('button[data-name="btn_lb_history"]').removeClass('active');
        $('button[data-name="btn_lg_history"]').removeClass('active');
        $('button[data-name="btn_bb_history"]').removeClass('active');
        $('button[data-name="btn_wt_history"]').removeClass('active');
        $('button[data-name="btn_ur_history"]').removeClass('active');
        $('button[data-name="btn_et_history"]').removeClass('active');
        $('button[data-name="btn_we_history"]').removeClass('active');
        $('button[data-name="btn_mo_history"]').removeClass('active');
        $('button[data-name="btn_sk_history"]').removeClass('active');
        $('button[data-name="btn_ey_history"]').removeClass('active');
        $('button[data-name="btn_fg_history"]').removeClass('active');
        $('button[data-name="btn_status_history"]').removeClass('active');
    };


    $('button[data-name="btn_dm_history"]').on('click', function(){
        dm_history = $(this).data('value');
    });
    $('button[data-name="btn_ht_history"]').on('click', function(){
        ht_history = $(this).data('value');
    });

    $('button[data-name="btn_lv_history"]').on('click', function(){
        lv_history = $(this).data('value');
    });

    $('button[data-name="btn_ds_history"]').on('click', function(){
        ds_history = $(this).data('value');
    });
    $('button[data-name="btn_hb_history"]').on('click', function(){
        hb_history = $(this).data('value');
    });

    $('button[data-name="btn_lb_history"]').on('click', function(){
        lb_history = $(this).data('value');
    });

    $('button[data-name="btn_lg_history"]').on('click', function(){
        lg_history = $(this).data('value');
    });
    $('button[data-name="btn_bb_history"]').on('click', function(){
        bb_history = $(this).data('value');
    });
    $('button[data-name="btn_wt_history"]').on('click', function(){
        wt_history = $(this).data('value');
    });
    $('button[data-name="btn_ur_history"]').on('click', function(){
        ur_history = $(this).data('value');
    });

    $('button[data-name="btn_et_history"]').on('click', function(){
        et_history = $(this).data('value');
    });

    $('button[data-name="btn_we_history"]').on('click', function(){
        we_history = $(this).data('value');
    });

    $('button[data-name="btn_mo_history"]').on('click', function(){
        mo_history = $(this).data('value');
    });

    $('button[data-name="btn_sk_history"]').on('click', function(){
        sk_history = $(this).data('value');
    });

    $('button[data-name="btn_ey_history"]').on('click', function(){
        ey_history = $(this).data('value');
    });

    $('button[data-name="btn_fg_history"]').on('click', function(){
        fg_history = $(this).data('value');
    });
    $('button[data-name="btn_status_history"]').on('click', function(){
        status_history = $(this).data('value');
    });

    //save
    $('#btn_save').on('click', function(){
        var items = {};

        items.dm_history = dm_history;
        items.ht_history = ht_history;
        items.ds_history = ds_history;
        items.hb_history = hb_history;
        items.lb_history = lb_history;
        items.lg_history = lg_history;
        items.lv_history = lv_history;
        items.bb_history = bb_history;
        items.wt_history = wt_history;
        items.ur_history = ur_history;
        items.et_history = et_history;
        items.we_history = we_history;
        items.mo_history = mo_history;
        items.sk_history = sk_history;
        items.ey_history = ey_history;
        items.fg_history = fg_history;
        items.status_history = status_history;


        items.screen_place = $('#sl_place').val();
        items.hn = $('#txt_hn').val();
        items.screen_date = $('#txt_screen_date').val();
        items.screen_time = $('#txt_screen_time').val();
        items.weight = $('#txt_weight').val();
        items.height = $('#txt_height').val();
        items.waistline = $('#txt_waistline').val();
        items.bmi = $('#txt_bmi').val();
        items.fm_dm = $('#chk_fm_dm').is(':checked') ? '1' : '0';
        items.fm_ht = $('#chk_fm_ht').is(':checked') ? '1' : '0';
        items.fm_gout = $('#chk_fm_gout').is(':checked') ? '1' : '0';
        items.fm_crf = $('#chk_fm_crf').is(':checked') ? '1' : '0';
        items.fm_mi = $('#chk_fm_mi').is(':checked') ? '1' : '0';
        items.fm_copd = $('#chk_fm_copd').is(':checked') ? '1' : '0';
        items.fm_stroke = $('#chk_fm_stroke').is(':checked') ? '1' : '0';
        items.fm_not_know = $('#chk_fm_not_know').is(':checked') ? '1' : '0';
        items.fm_no = $('#chk_fm_no').is(':checked') ? '1' : '0';
        items.fm_other = $('#chk_fm_other').is(':checked') ? '1' : '0';
        items.fm_other_detail = $('#txt_fm_other_detail').val();
        items.sb_dm = $('#chk_sb_dm').is(':checked') ? '1' : '0';
        items.sb_ht = $('#chk_sb_ht').is(':checked') ? '1' : '0';
        items.sb_gout = $('#chk_sb_gout').is(':checked') ? '1' : '0';
        items.sb_crf = $('#chk_sb_crf').is(':checked') ? '1' : '0';
        items.sb_mi = $('#chk_sb_mi').is(':checked') ? '1' : '0';
        items.sb_copd = $('#chk_sb_copd').is(':checked') ? '1' : '0';
        items.sb_stroke = $('#chk_sb_stroke').is(':checked') ? '1' : '0';
        items.sb_not_know = $('#chk_sb_not_know').is(':checked') ? '1' : '0';
        items.sb_no = $('#chk_sb_no').is(':checked') ? '1' : '0';
        items.sb_other = $('#chk_sb_other').is(':checked') ? '1' : '0';
        items.sb_other_detail = $('#txt_sb_other_detail').val();
        items.smoke = $('input[name="rd_smoke"]').val();
        items.smoke_qty = $('#txt_smoke_qty').val();
        items.smoke_type = $('#txt_smoke_type').val();
        items.smoke_year = $('#txt_smoke_year').val();
        items.smoked_qty = $('#txt_smoked_qty').val();
        items.smoked_type = $('#txt_smoked_type').val();
        items.smoked_year = $('#txt_smoked_year').val();

        items.drink = $('input[name="rd_drink"]').val() ? $('input[name="rd_drink"]').val() : '0';
        items.drink_qty = $('#txt_drink_qty').val() ? $('#txt_drink_qty').val() : '0';

        items.sport = $('input[name="rd_sport"]').val() ? $('input[name="rd_sport"]').val() : '0';

        items.food_taste_sweet = $('#food_taste_sweet').is(':checked') ? '1' : '0';
        items.food_taste_salt = $('#food_taste_salt').is(':checked') ? '1' : '0';
        items.food_taste_creamy = $('#food_taste_creamy').is(':checked') ? '1' : '0';
        items.food_taste_no = $('#food_taste_no').is(':checked') ? '1' : '0';

        items.screen_tb = $('input[name="rd_screen_tb"]').val() ? $('input[name="rd_screen_tb"]').val() : '0';

        items.sbp1 = $('#txt_sbp1').val() ? $('#txt_sbp1').val() : '0';
        items.dbp1 = $('#txt_dbp1').val() ? $('#txt_dbp1').val() : '0';
        items.sbp2 = $('#txt_sbp2').val() ? $('#txt_sbp2').val() : '0';
        items.dbp2 = $('#txt_dbp2').val() ? $('#txt_dbp2').val() : '0';
        items.sbp3 = $('#txt_sbp3').val() ? $('#txt_sbp3').val() : '0';
        items.dbp3 = $('#txt_dbp3').val() ? $('#txt_dbp3').val() : '0';
        items.fbs = $('#txt_fbs').val() ? $('#txt_fbs').val() : '0';
        items.blood_sugar = $('#txt_blood_sugar').val() ? $('#txt_blood_sugar').val() : '0';

        items.risk_meta = $('input[name="rd_risk_meta"]').val() ? $('input[name="rd_risk_meta"]').val() : '0';

        items.risk_meta_dm = $('#chk_risk_meta_dm').is(':checked') ? '1' : '0';
        items.risk_meta_ht = $('#chk_risk_meta_ht').is(':checked') ? '1' : '0';
        items.risk_meta_stroke = $('#chk_risk_meta_stroke').is(':checked') ? '1' : '0';
        items.risk_meta_obesity = $('#chk_risk_meta_obesity').is(':checked') ? '1' : '0';

        items.risk_ncd = $('input[name="rd_risk_ncd"]').val() ? $('input[name="rd_risk_ncd"]').val() : '0';
        items.risk_ncd_dm = $('#chk_risk__ncd_dm').is(':checked') ? '1' : '0';
        items.risk_ncd_ht = $('#chk_risk_ncd_ht').is(':checked') ? '1' : '0';
        items.risk_ncd_stroke = $('#chk_risk_ncd_stroke').is(':checked') ? '1' : '0';
        items.risk_ncd_obesity = $('#chk_risk_ncd_obesity').is(':checked') ? '1' : '0';

        items.risk_disb = $('input[name="rd_risk_disb"]').val() ? $('input[name="rd_risk_disb"]').val() : '0';

        items.year = $('#sl_year').val();

        if(!items.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!items.year)
        {
            app.alert('กรุณาระบุปีที่ต้องการบันทึก');
        }
        else if(!items.screen_date)
        {
            app.alert('กรุณาระบุวันที่คัดกรอง');
        }
        else if(!items.screen_time)
        {
            app.alert('กรุณาระบุเวลาที่คัดกรอง');
        }
        else if(!items.weight)
        {
            app.alert('กรุณาระบุน้ำหนัก');
        }
        else if(!items.height)
        {
            app.alert('กรุณาระบุส่วนสูง');
        }
        else if(!items.waistline)
        {
            app.alert('กรุณาระบุเส้นรอบเอว');
        }
        else
        {
            ncdscreen.ajax.save(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    ncdscreen.get_list();

                    ncdscreen.modal.hide_screen();
                    //clear form
                    ncdscreen.clear_form();
                }
            });
        }

    });

    //clear
    $(document).on('click', 'a[data-name="btn_clear"]', function(){
        var items = {};
        items.year = $(this).data('year');
        items.hn = $(this).data('hn');

        app.confirm('คุณต้องการลบรายการสำรวจ ใช่หรือไม่?', function(res){
            if(res)
            {
                ncdscreen.ajax.clear(items, function(err){
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ยกเลิกรายการเสร็จเรียบร้อย');
                        ncdscreen.get_list();
                    }
                });
            }
        });
    });

    $('#btn_do_get_list').on('click', function(){
        var items = {};
        items.year = $('#sl_year').val(),
        items.village_id = $('#sl_village').val();

        if(!items.village_id)
        {
            app.alert('กรุณาเลือกหมู่บ้านที่ต้องการ');
        }
        else
        {
            ncdscreen.search_filter(items);
        }

    });

    //search person
    $('#txt_query').typeahead({
        ajax: {
            url: site_url + 'person/search_person_ajax',
            timeout: 500,
            displayField: 'name',
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
            var code = d[0],
                name = d[1];

            return code;
        }
    });

    $('#btn_refresh').on('click', function(){
        ncdscreen.get_list();
    });

    $('#btn_do_search').on('click', function(){
        var query = $('#txt_query').val();
        var year = $('#sl_year').val();

        $('#main_paging').fadeOut('slow');

        if(!query)
        {
            app.alert('กรุณาระบุคำค้นหา');
        }
        else
        {
            ncdscreen.ajax.search(query, year, function(err, data){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    ncdscreen.set_list(data);
                }
            });
        }
    });

    $('#btn_result').on('click', function(){
        ncdscreen.modal.show_result();
    });

    $('#btn_get_result').on('click', function(){
        var year = $('#sl_result_year').val();
        ncdscreen.ajax.get_result(year, function(err, data){
            $('#txt_total').html(app.add_commars_with_out_decimal(data.total));
            $('#txt_result').html(app.add_commars_with_out_decimal(data.result));

            var percent = (parseInt(data.result) * 100) / parseInt(data.total);

            $('#txt_percent').html(percent.toFixed(2));

            ncdscreen.set_result_chart(parseInt(data.total), parseInt(data.result));
        });
    });

    ncdscreen.set_result_chart = function(total, result){

        var mean = total / 3;
        var medium = mean * 2.5;

        var m = (mean * 100) / total;
        var d = (medium * 100) / total;
        var r = parseFloat(((result * 100) / total).toFixed(2));

        $('#div_result_chart').highcharts({
                credits : {
                    enabled : false
                },
                chart: {
                    type: 'gauge',
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },

                title: {
                    text: 'ผลการปฏิบัติงาน'
                },

                pane: {
                    startAngle: -150,
                    endAngle: 150,
                    background: [{
                        backgroundColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                            stops: [
                                [0, '#FFF'],
                                [1, '#333']
                            ]
                        },
                        borderWidth: 0,
                        outerRadius: '109%'
                    }, {
                        backgroundColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                            stops: [
                                [0, '#333'],
                                [1, '#FFF']
                            ]
                        },
                        borderWidth: 1,
                        outerRadius: '107%'
                    }, {
                        // default background
                    }, {
                        backgroundColor: '#DDD',
                        borderWidth: 0,
                        outerRadius: '105%',
                        innerRadius: '103%'
                    }]
                },

                // the value axis
                yAxis: {
                    min: 0,
                    max: 100,

                    minorTickInterval: 'auto',
                    minorTickWidth: 1,
                    minorTickLength: 10,
                    minorTickPosition: 'inside',
                    minorTickColor: '#666',

                    tickPixelInterval: 30,
                    tickWidth: 2,
                    tickPosition: 'inside',
                    tickLength: 10,
                    tickColor: '#666',
                    labels: {
                        step: 2,
                        rotation: 'auto'
                    },
                    title: {
                        text: '%'
                    },
                    plotBands: [{
                        from: 0,
                        to: 50,
                        color: '#DF5353' // red

                    }, {
                        from: 50,
                        to: 90,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: 90,
                        to: 100,
                        color: '#55BF3B' // green
                    }]
                },

                series: [{
                    name: '%',
                    data: [r],
                    tooltip: {
                        valueSuffix: ' %'
                    }
                }]


        });
    };

    ncdscreen.get_list();

});