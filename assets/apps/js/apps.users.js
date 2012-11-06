$(function(){

    //User namespace
    var User = {};


    User.alert = {
        setAlert: function(c, head, message){
            $('#divAlert').removeClass('alert alert-info');
            $('#divAlert').addClass(c);
            $('#divAlert h4').html(head);
            $('#divAlert span').html(message);
        }
    };
    //Namespace for dataset
    User.ds = {};

    //Namespace for ajax
    User.ajax = {
        //Do login
        do_login: function(items, callback){

            $.ajax({
                url: site_url + 'users/do_login',
                type: 'POST',
                dataType: 'json',

                data: {
                    username: items.username,
                    password: items.password,
                    csrf_token: csrf_token
                },
                //if success
                success: function(data){
                    if(data.success){
                        callback(null);
                    }else{
                        callback(data.msg);
                    }
                },
                //if error
                error: function(xhr, status){
                    callback(xhr);
                }
            });
        }
    };

    //Do login
    $('#btnDoLogin').click(function(){
        var items = {};
        items.username = $('#txtUsername').val();
        items.password = $('#txtPassword').val();

        if(!items.username){
            //alert('กรุณาระบุชื่อผู้ใช้งาน');
            User.alert.setAlert('alert', 'เกิดข้อผิดพลาด', 'กรุณาระบุชื่อผู้ใช้งาน');
        }else if(!items.password){
            //alert('กรุณาระบุรหัสผ่าน');
            User.alert.setAlert('alert', 'เกิดข้อผิดพลาด', 'กรุณาระบุรหัสผ่าน');
        }else{

            App.showLoginLoading();
            //Check user login
            User.ajax.do_login(items, function(err){

                if(err){
                    User.alert.setAlert('alert', 'เกิดข้อผิดพลาด', err);
                }else{
                    User.alert.setAlert('alert alert-success', 'ยินดีต้อนรับ', 'ยินดีต้อนรับเข้าสู่ระบบ');
                    location.href = site_url;
                }

                App.hideLoginLoading();
            });
        }

        App.hideLoginLoading();
    });
});