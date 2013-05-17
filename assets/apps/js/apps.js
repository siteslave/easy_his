/**
 * Main application script
 */
 
var base_url = 'http://his.local/',
    site_url = 'http://his.local/index.php/';
        
var app = {
    showLoginLoading: function(){
        $('#divLoading').css('display', 'inline');
    },
    hideLoginLoading: function(){
        $('#divLoading').css('display', 'none');
    },
    show_loading: function(){
        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: 1,
                color: '#fff'
            },
            message: '<h4>Loading <img src="' + base_url + 'assets/apps/img/ajax-loader-fb.gif" alt="loading."> </h4>'
        });
    },

    hide_loading: function(){
        $.unblockUI();
    },
    show_block: function(obj){
        $(obj).block({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: 1,
                color: '#fff'
            },
            message: '<h4><img src="' + base_url + 'assets/apps/img/ajax-loader-fb.gif" alt="loading."> Loading...</h4>'
        });
    },
    hide_block: function(obj){
        $(obj).unblock();
    },

    showImageLoading: function(){
        $('#imgLoading').css('display', 'inline');
    },

    hideImageLoading: function(){
        $('#imgLoading').css('display', 'none');
    },

    dbpop_to_thai_date: function(d){
        if(!d){
            return '';
        }else{
            var old_date = d.toString();

            var year = old_date.substr(0, 4).toString(),
                month = old_date.substr(4, 2).toString(),
                day = old_date.substr(6, 2).toString();

            var new_date = day + '/' + month + '/' + year;

            return new_date;
        }

    },
    /** mongo date to thai date **/
    mongo_to_thai_date: function(d){
        if(!d){
            return '';
        }else{
            var old_date = d.toString();

            var year = parseInt(old_date.substr(0, 4).toString()) + 543,
                month = old_date.substr(4, 2).toString(),
                day = old_date.substr(6, 2).toString();

            var new_date = day + '/' + month + '/' + year;

            return new_date;
        }

    },
    mongo_to_js_date: function(d){
        if(!d){
            return '';
        }else{
            var old_date = d.toString();

            var year = parseInt(old_date.substr(0, 4).toString()),
                month = old_date.substr(4, 2).toString(),
                day = old_date.substr(6, 2).toString();

            var new_date = day + '/' + month + '/' + year;

            return new_date;
        }

    },
    to_thai_date: function(d){
        if(!d){
            return '-';
        }else{
            var date = d.split('/');

            var dd = date[0],
                mm = date[1],
                yyyy = parseInt(date[2]) + 543;

            return dd + '/' + mm + '/' + yyyy;
        }
    },
    convertDBPOPDateToEngDate: function(d){
        if(!d){
            return '';
        }else{
            var old_date = d.toString();

            var year = parseInt(old_date.substr(0, 4).toString()) - 543,
                month = old_date.substr(4, 2).toString(),
                day = old_date.substr(6, 2).toString();

            var new_date = day + '/' + month + '/' + year;

            return new_date;
        }

    },

    count_age_dbpop: function(d){
        if(!d){
            return 0;
        }else{
            var old_date = d.toString();

            var year_birth = old_date.substr(0, 4);
            var year_current = new Date();
            var year_current2 = year_current.getFullYear() + 543;

            var age = year_current2 - parseInt(year_birth);

            return age;
        }
    },

    count_age: function(d){
        if(!d){
            return 0;
        }else{
            var d = d.split('/');
            var year_birth = d[2];
            var year_current = new Date();
            var year_current2 = year_current.getFullYear();

            var age = year_current2 - parseInt(year_birth);

            return age;
        }
    },

    count_age_mongo: function(d){
        if(!d){
            return 0;
        }else{
            var old_date = d.toString();

            var year_birth = old_date.substr(0, 4);
            var year_current = new Date();
            var year_current2 = year_current.getFullYear();

            var age = year_current2 - parseInt(year_birth);

            return age;
        }
    },

    getFileExtension: function(filename)
    {
        var ext = /^.+\.([^.]+)$/.exec(filename);
        return ext == null ? "" : ext[1];
    },
    getReadableFileSizeString: function(fileSizeInBytes) {

        var i = -1;
        var byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
        do {
            fileSizeInBytes = fileSizeInBytes / 1024;
            i++;
        } while (fileSizeInBytes > 1024);

        return Math.max(fileSizeInBytes, 0.1).toFixed(1) + byteUnits[i];
    },

    go_to_url: function(url){
        location.href = site_url + url;
    },
    /**
     * Ajax
     *
     * @param url
     * @param params
     * @param cb
     */
    ajax: function(url, params, cb){

        params.csrf_token = csrf_token;

        app.show_loading();

        try{
            $.ajax({
                url: site_url + url,
                type: 'POST',
                dataType: 'json',

                data: params,

                success: function(data){
                    if(data.success){

                        if(data){
                            cb(null, data);
                        }else{
                            cb('Record not found.', null);
                        }

                        app.hide_loading();

                    }else{
                        cb(data.msg, null);
                        app.hide_loading();
                    }
                },

                error: function(xhr, status){
                    cb('Error:  [' + xhr.status + '] ' + xhr.statusText, null);
                    app.hide_loading();
                }
            });
        }catch(err){
            cb(err, null);
        }

    },

    confirm: function(msg, cb){
        bootbox.dialog(msg, [
            {
                'label': 'ใช่ (Yes)',
                'class': 'btn-success',
                'icon': 'icon-ok',
                'callback': function(){
                    cb(true);
                }
            },
            {
                'label': 'ไม่ (No)',
                'class': 'btn-danger',
                'icon': 'icon-off',
                'callback': function(){
                    cb(false);
                }
            }
        ]);
    },

    alert: function(msg, title){
        if(!title){
            title = 'Messages';
        }

        $("#freeow").freeow(title, msg, {
            //classes: ["gray", "error"],
            classes: ["gray"],
            prepend: false,
            autoHide: true
        });
    },
    set_first_selected: function(obj){
        $(obj).find('option').first().attr('selected', 'selected');
    },

    trim: function(string){
        return $.trim(string);
    },

    get_current_date: function(){
        var date = new Date();
        var y = date.getFullYear(),
            m = date.getMonth() + 1,
            d = date.getDate();

        return d + '/' + m + '/' + y;
    },

    get_current_time: function(){
        var date = new Date(),
            h = date.getHours(),
            m = date.getMinutes();

        return h + ':' + m;
    },
    add_commars: function(str){
        var my_number = numeral(str).format('0,0.00');

        return my_number;
    },
    add_commars_with_out_decimal: function(str){
        var my_number = numeral(str).format('0,0');

        return my_number;
    },

    clear_null: function(v)
    {
        return v == null ? '-' : v;
    },

    mongo_datetime_to_thai: function(v)
    {
        var d = v.split(' ');
        var date = d[0].split('-');
        var cd = date[2],
            cm = date[1],
            cy = parseInt(date[2]) + 543;

        return cd + '/' + cm + '/' + cy;
    }
};
//Record pre page
app.record_per_page = 25;

app.set_runtime = function()
{
    $('div[data-name="datepicker"]').datepicker({
        format: 'dd/mm/yyyy',
        language: 'th'
    });

    $('.timepicker').timepicker({
        minuteStep: 1,
        secondStep: 5,
        showInputs: false,
        //template: 'modal',
        //modalBackdrop: true,
        //showSeconds: true,
        showMeridian: false
    });

    $('input[data-type="time"]').mask("99:99");
    $('input[data-type="year"]').mask("9999");
    $('input[data-type="number"]').numeric();
    $('input[disabled]').css('background-color', 'white');
    $('textarea[disabled]').css('background-color', 'white');

    $('[rel="tooltip"]').tooltip();
};

head.ready(function(){
    app.set_runtime();

    app.get_providers = function(cb){
        var url = 'basic/get_providers',
            params = {};

        app.ajax(url, params, function(err, data){
            err ? cb(err) : cb(null, data);
        });
    };
    app.get_clinics = function(cb){
        var url = 'basic/get_clinics',
            params = {};

        app.ajax(url, params, function(err, data){
            err ? cb(err) : cb(null, data);
        });
    };

    app.show_set_provider_clinic = function()
    {
        $('#modal_provider_clinic').modal({
            backdrop: 'static'
        }).css({
                width: 780,
                'margin-left': function() {
                    return -($(this).width() / 2);
                }
            });
    };
    app.hide_set_provider_clinic = function()
    {
        $('#modal_provider_clinic').modal('hide');
    };

    $('#btn_idx_set_provider_clinic').on('click', function(e){
        app.set_clinics();
        app.set_providers();
        app.show_set_provider_clinic();

        e.preventDefault();
    });

    app.set_clinics = function(){
        $('#sl_clinics').empty();
        app.get_clinics(function(err, data){
            if(err)
            {
                app.alert(err);
            }
            else
            {
                $('#sl_clinics').append('<option value="">---</option>');
                _.each(data.rows, function(v){
                    $('#sl_clinics').append('<option value="'+ v.id +'">' + v.name + '</option>');
                });
            }
        });
    };
    app.set_providers = function(){
        $('#sl_providers').empty();
        app.get_providers(function(err, data){
            if(err)
            {
                app.alert(err);
            }
            else
            {
                $('#sl_providers').append('<option value="">---</option>');
                _.each(data.rows, function(v){
                    $('#sl_providers').append('<option value="'+ v.id +'">' + v.name + '</option>');
                });
            }
        });
    };
});
