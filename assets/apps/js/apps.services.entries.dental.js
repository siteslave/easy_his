//Service dental
head.ready(function(){
    var dental = {};

    dental.modal = {
        show_register: function(){
            $('#mdl_dental').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
    };

    dental.ajax = {
        save: function(data, cb){

            var url = 'services/dental_save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_detail: function(vn, cb){

            var url = 'services/dental_detail',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        remove: function(vn, cb){

            var url = 'services/dental_remove',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        history: function(hn, cb){

            var url = 'services/dental_history',
                params = {
                    hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    dental.get_detail = function()
    {
        var vn = $('#vn').val();

        dental.ajax.get_detail(vn, function(err, data){
            if(!err)
            {
                dental.set_detail(data);
            }
        });
    };
    dental.get_history = function()
    {
        var hn = $('#hn').val();

        dental.ajax.history(hn, function(err, data){

            $('#tbl_dental_history > tbody').empty();

            if(!err)
            {
                dental.set_history(data);
            }
            else
            {
                $('#tbl_dental_history > tbody').append('<tr><td colspan="6">ไม่พบรายการ</td></tr>');
            }
        });
    };

    dental.set_history = function(data)
    {
        if(data)
        {
            _.each(data.rows, function(v){
                $('#tbl_dental_history > tbody').append(
                    '<tr>' +
                        '<td>'+ v.date_serv +'</td>' +
                        '<td>'+ v.owner_name +'</td>' +
                        '<td>'+ v.denttype +'</td>' +
                        '<td>'+ v.servplace_name +'</td>' +
                        '<td>'+ v.gum +'</td>' +
                        '<td>'+ v.provider_name +'</td>' +
                        '</tr>'
                );
            });
        }
        else
        {
            $('#tbl_dental_history > tbody').append('<tr><td colspan="6">ไม่พบรายการ</td></tr>');
        }
    };

    $('a[data-name="btn_dental"]').on('click', function(){
        dental.clear_form();
        //get detail
        dental.get_detail();
        $('a[href="#tab_dental1"]').tab('show');
        dental.modal.show_register();
    })

    dental.set_detail = function(data)
    {
        $('#sl_dental_denttype').val(data.rows.denttype);
        $('#txt_dental_pteeth').val(data.rows.pteeth);
        $('#txt_dental_pcaries').val(data.rows.pcaries);
        $('#txt_dental_pfilling').val(data.rows.pfilling);
        $('#txt_dental_pextract').val(data.rows.pextract);
        $('#txt_dental_dteeth').val(data.rows.dteeth);
        $('#txt_dental_dcaries').val(data.rows.dcaries);
        $('#txt_dental_dfilling').val(data.rows.dfilling);
        $('#txt_dental_dextract').val(data.rows.dextract);
        $('#sl_dental_need_fluoride').val(data.rows.need_fluoride);
        $('#sl_dental_need_scaling').val(data.rows.need_scaling);
        $('#txt_dental_need_sealant').val(data.rows.need_sealant);
        $('#txt_dental_need_pfilling').val(data.rows.need_pfilling);
        $('#txt_dental_need_dfilling').val(data.rows.dfilling);
        $('#txt_dental_need_pextract').val(data.rows.need_pextract);
        $('#txt_dental_need_dextract').val(data.rows.need_dextract);
        $('#txt_dental_nprosthesis').val(data.rows.nprosthesis);
        $('#txt_dental_permanent_perma').val(data.rows.permanent_perma);
        $('#txt_dental_permanent_prost').val(data.rows.permanent_prost);
        $('#txt_dental_prosthesis_prost').val(data.rows.prosthesis_prost);
        $('#sl_dental_gum').val(data.rows.gum);
        $('#sl_dental_schooltype').val(data.rows.schooltype);
        $('#txt_dental_school_class').val(data.rows.school_class);
    };

    dental.clear_form = function()
    {
        app.set_first_selected($('#sl_dental_denttype'));
        $('#txt_dental_pteeth').val('');
        $('#txt_dental_pcaries').val('');
        $('#txt_dental_pfilling').val('');
        $('#txt_dental_pextract').val('');
        $('#txt_dental_dteeth').val('');
        $('#txt_dental_dcaries').val('');
        $('#txt_dental_dfilling').val('');
        $('#txt_dental_dextract').val('');
        app.set_first_selected($('#sl_dental_need_fluoride'));
        app.set_first_selected($('#sl_dental_need_scaling'));
        $('#txt_dental_need_sealant').val('');
        $('#txt_dental_need_pfilling').val('');
        $('#txt_dental_need_dfilling').val('');
        $('#txt_dental_need_pextract').val('');
        $('#txt_dental_need_dextract').val('');
        $('#txt_dental_nprosthesis').val('');
        $('#txt_dental_permanent_perma').val('');
        $('#txt_dental_permanent_prost').val('');
        $('#txt_dental_prosthesis_prost').val('');
        app.set_first_selected($('#sl_dental_gum'));
        app.set_first_selected($('#sl_dental_schooltype'));
        $('#txt_dental_school_class').val('');
    }

    $('#btn_dental_save').on('click', function(){
        var data = {};
        data.vn                 = $('#vn').val();
        data.hn                 = $('#hn').val();
        data.denttype           = $('#sl_dental_denttype').val();
        data.pteeth             = $('#txt_dental_pteeth').val();
        data.pcaries            = $('#txt_dental_pcaries').val();
        data.pfilling           = $('#txt_dental_pfilling').val();
        data.pextract           = $('#txt_dental_pextract').val();
        data.dteeth             = $('#txt_dental_dteeth').val();
        data.dcaries            = $('#txt_dental_dcaries').val();
        data.dfilling           = $('#txt_dental_dfilling').val();
        data.dextract           = $('#txt_dental_dextract').val();
        data.need_fluoride      = $('#sl_dental_need_fluoride').val();
        data.need_scaling       = $('#sl_dental_need_scaling').val();
        data.need_sealant       = $('#txt_dental_need_sealant').val();
        data.need_pfilling      = $('#txt_dental_need_pfilling').val();
        data.need_dfilling      = $('#txt_dental_need_dfilling').val();
        data.need_pextract      = $('#txt_dental_need_pextract').val();
        data.need_dextract      = $('#txt_dental_need_dextract').val();
        data.nprosthesis        = $('#txt_dental_nprosthesis').val();
        data.permanent_perma    = $('#txt_dental_permanent_perma').val();
        data.permanent_prost    = $('#txt_dental_permanent_prost').val();
        data.prosthesis_prost   = $('#txt_dental_prosthesis_prost').val();
        data.gum                = $('#sl_dental_gum').val();
        data.schooltype         = $('#sl_dental_schooltype').val();
        data.school_class       = $('#txt_dental_school_class').val();

        if(!data.denttype)
        {
            app.alert('กรุณาระบุประเภทผู้รับบริการ');
        }
        else if(!data.pteeth)
        {
            app.alert('กรุณาระบุจำนวนฟันแท้ที่มีอยู่');
        }
        else if(!data.pcaries)
        {
            app.alert('กรุณาระบุ จำนวนฟันแท้ผุที่ไม่ได้อุด');
        }
        else if(!data.pfilling)
        {
            app.alert('กรุณาระบุ จำนวนฟันแท้ที่ได้รับการอุด');
        }
        else if(!data.pextract)
        {
            app.alert('กรุณาระบุ จำนวนฟันแท้ที่ถอนหรืออุด');
        }
        else if(!data.dteeth)
        {
            app.alert('กรุณาระบุ จำนวนฟันน้ำนมที่มีอยู่');
        }
        else if(!data.dcaries)
        {
            app.alert('กรุณาระบุ จำนวนฟันน้ำนมผุที่ไม่ได้อุด');
        }
        else if(!data.dfilling)
        {
            app.alert('กรุณาระบุ จำนวนฟันน้ำนมที่ได้รับการอุด');
        }
        else if(!data.dextract)
        {
            app.alert('กรุณาระบุ จำนวนฟันน้ำนมที่ถอนหรือหลุด');
        }
        else if(!data.need_fluoride)
        {
            app.alert('กรุณาระบุ ความจำเป็นในการเคลือบฟลูออไรด์');
        }
        else if(!data.need_scaling)
        {
            app.alert('กรุณาระบุ จำเป็นต้องขูดหินน้ำลาย');
        }
        else if(!data.need_sealant)
        {
            app.alert('กรุณาระบุ จำนวนฟันที่ต้องเคลือบหลุมร่องฟัน');
        }
        else if(!data.need_pfilling)
        {
            app.alert('กรุณาระบุ จำนวนฟันแท้ที่ต้องอุด');
        }
        else if(!data.need_dfilling)
        {
            app.alert('กรุณาระบุ จำนวนฟันน้ำนมที่ต้องอุด');
        }
        else if(!data.need_pextract)
        {
            app.alert('กรุณาระบุ จำนวนฟันแท้ที่ต้องถอน/รักษาคลองรากฟัน');
        }
        else if(!data.need_dextract)
        {
            app.alert('กรุณาระบุ จำนวนฟันน้ำนมที่ต้องถอน/รักษาคลองรากฟัน');
        }
        else if(!data.nprosthesis)
        {
            app.alert('กรุณาระบุ จำเป็นต้องใส่ฟันเทียม');
        }
        else if(!data.permanent_perma)
        {
            app.alert('กรุณาระบุ จำนวนคู่สบฟันแท้กับฟันแท้');
        }
        else if(!data.permanent_prost)
        {
            app.alert('กรุณาระบุ จำนวนคู่สบฟันแท้กับฟันเทียม');
        }
        else if(!data.gum)
        {
            app.alert('กรุณาระบุ สภาวะปริทันต์');
        }
        else if(!data.schooltype)
        {
            app.alert('กรุณาระบุ สถานาศึกษา');
        }
        else if(!data.school_class)
        {
            app.alert('กรุณาระบุ ระดับการศึกษา');
        }
        else
        {
            dental.ajax.save(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
                else
               {
                   app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
               }
            });
        }
    });

    $('#btn_dental_remove').on('click', function(){
        var vn = $('#vn').val();
        if(confirm('คุณต้องการลบข้อมูลการให้บริการนี้ใช่หรือไม่?'))
        {
            dental.ajax.remove(vn, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('ลบข้อมูลการให้บริการเสร็จเรียบร้อยแล้ว');
                    dental.clear_form();
                }
            });
        }
    });

    $('a[href="#tab_dental2"]').on('click', function(){
        dental.get_history();
    })
});