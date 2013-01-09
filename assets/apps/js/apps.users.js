head.ready(function(){

    //User namespace
    var user = {};


    user.alert = {
        setAlert: function(c, head, message){
            $('#divAlert').removeClass('alert alert-info');
            $('#divAlert').addClass(c);
            $('#divAlert h4').html(head);
            $('#divAlert span').html(message);
        }
    };
    //Namespace for dataset
    user.ds = {};

    user.check_login = function(){

        $("#btnDoLogin").attr("disabled", "disabled");

        var items = {};
        items.username = $('#txtUsername').val();
        items.password = $('#txtPassword').val();

        if(!items.username){
            //alert('กรุณาระบุชื่อผู้ใช้งาน');
            user.alert.setAlert('alert', 'เกิดข้อผิดพลาด', 'กรุณาระบุชื่อผู้ใช้งาน');
            $("#btnDoLogin").removeAttr("disabled");
        }else if(!items.password){
            //alert('กรุณาระบุรหัสผ่าน');
            user.alert.setAlert('alert', 'เกิดข้อผิดพลาด', 'กรุณาระบุรหัสผ่าน');
            $("#btnDoLogin").removeAttr("disabled");
        }else{

            app.showLoginLoading();
            //Check user login
            user.ajax.do_login(items, function(err){

                if(err){
                    user.alert.setAlert('alert', 'เกิดข้อผิดพลาด', err);
                    $("#btnDoLogin").removeAttr("disabled");
                }else{
                    user.alert.setAlert('alert alert-success', 'ยินดีต้อนรับ', 'ยินดีต้อนรับเข้าสู่ระบบ');
                    location.href = site_url;
                }

                app.hideLoginLoading();
            });
        }

        app.hideLoginLoading();
    }

    //Namespace for ajax
    user.ajax = {
        //Do login
        do_login: function(items, cb){
            var url = 'users/do_login',
                params = {
                    username: items.username,
                    password: items.password
                };
            app.ajax(url, params, function(err){
                if(err){
                    cb(err);
                }else{
                    cb(null);
                }
            });
        }
    };

    $('#txtPassword').bind('keypress', function(e) {
        if(e.keyCode==13){
            user.check_login();
        }
    });

    //Do login
    $('#btnDoLogin').click(function(){
        user.check_login();
    });
});