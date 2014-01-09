head.ready(function() {

    var surveils = {};

    surveils.ajax = {
        save: function(data, cb){

            var url = 'surveil/save',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_ampur: function(chw, cb){

            var url = 'basic/get_ampur',
                params = {
                    chw: chw
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        },
        get_tambon: function(chw, amp, cb){

            var url = 'basic/get_tambon',
                params = {
                    chw: chw,
                    amp: amp
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        },
        get_organism: function(code, cb){

            var url = 'surveil/get_organism',
                params = {
                    code: code
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });

        }
    };
    //save
    $('#btn_surveil_save').on('click', function(){
        var items = {};

        items.hn = $('#txt_surveil_hn').val();
        items.vn = $('#txt_surveil_vn').val();

        items.syndrome = $('#sl_surveil_syndrome').select2('val');
        items.diagcode = $('#txt_surveil_diag_code').val();
        items.code506 = $('#sl_surveil_506').select2('val');
        items.illdate = $('#txt_surveil_illdate').val();
        items.illhouse = $('#txt_surveil_address').val();
        items.illvillage = $('#txt_surveil_moo').val();
        items.illtambon = $('#sl_surveil_tambon').select2('val');
        items.illampur = $('#sl_surveil_ampur').select2('val');
        items.illchangwat = $('#sl_surveil_province').select2('val');
        items.latitude = $('#txt_surveil_latitude').val();
        items.longitude = $('#txt_surveil_longitude').val();
        items.ptstatus = $('#sl_surveil_ptstatus').select2('val');
        items.date_death = $('#txt_surveil_date_death').val();
        items.complication = $('#sl_surveil_complication').select2('val');
        items.organism = $('#sl_surveil_organism').select2('val');

        items.school_class = $('#txt_surveil_school_class').val();
        items.school_name = $('#txt_surveil_school_name').val();

        if(!items.hn)
        {
            app.alert('กรุณาระบุ HN');
        }
        else if(!items.diagcode)
        {
            app.alert('กรุณาระบุรหัสการวินิจฉัย');
        }
        else if(!items.code506)
        {
            app.alert('กรุณาระบุรหัส 506');
        }
        else
        {
            surveils.ajax.save(items, function(err){
                if(err)
                {
                    app.alert(err);
                }
                else
                {
                    app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                    parent.surveil.modal.hide_entry();
                    parent.surveil.get_list();
                }
            });
        }

    });



    $('#sl_surveil_province').on('change', function(){
        var chw = $(this).val();
        surveils.set_ampur(chw, null);

    });

    surveils.set_ampur = function(chw, ampur)
    {
        surveils.ajax.get_ampur(chw, function(err, data){
            $('#sl_surveil_ampur').empty();
            $('#sl_surveil_tambon').empty();

            $('#sl_surveil_ampur').append('<option value="00">--</option>');
            _.each(data.rows, function(v){
                if(v.code == ampur)
                {
                    if(!v.name.match(/\*/))
                        $('#sl_surveil_ampur').append('<option value="'+ v.code +'" selected="selected">'+ v.name +'</option>');
                }
                else
                {
                    if(!v.name.match(/\*/))
                        $('#sl_surveil_ampur').append('<option value="'+ v.code +'">'+ v.name +'</option>');
                }
            });
        });
    };

    $('#sl_surveil_ampur').on('change', function(){
        var chw = $('#sl_surveil_province').val(),
            amp = $(this).val();

        surveils.set_tambon(chw, amp, null);

    });

    surveils.set_tambon = function(chw, amp, tambon)
    {
        //load ampur list
        surveils.ajax.get_tambon(chw, amp, function(err, data){
            $('#sl_surveil_tambon').empty();
            $('#sl_surveil_tambon').append('<option value="00">--</option>');
            _.each(data.rows, function(v)
            {
                if(v.code == tambon)
                {
                    if(!v.name.match(/\*/))
                        $('#sl_surveil_tambon').append('<option value="'+ v.code +'" selected="selected">'+ v.name +'</option>');
                }
                else
                {
                    if(!v.name.match(/\*/))
                        $('#sl_surveil_tambon').append('<option value="'+ v.code +'">'+ v.name +'</option>');
                }
            });
        });
    };

    $('#sl_surveil_506').on('change', function(){
        var code = $(this).val();
        surveils.ajax.get_organism(code, function(err, data){
            $('#sl_surveil_organism').empty();
            $('#sl_surveil_organism').append('<option value="">--</option>');
            _.each(data.rows, function(v){
                if(!v.name.match(/\*/))
                    $('#sl_surveil_organism').append('<option value="'+ v.code +'">['+ v.code +'] '+ v.name +'</option>');
            });
        });
    });


    app.set_runtime();
});