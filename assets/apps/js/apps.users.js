head.ready(function(){

    //User namespace
    var user = {};

    user.check_login = function(){

        var items = {};
        items.username = $('#txt_username').val();
        items.password = $('#txt_password').val();

        if(!items.username)
        {
          app.alert('กรุณาระบุชื่อผู้ใช้งาน');
          return false;
        }
        else if(!items.password)
        {
          app.alert('กรุณาระบุรหัสผ่าน');
          return false;
        }
        else
        {
          return true;
        }
    };

    $('#txt_password').bind('keypress', function(e) {
      if(e.keyCode==13){
        user.check_login();
      }
    });

    $('#btn_dologin').on('click', function(){
      user.check_login();
    });

    $('[rel="tooltip"]').tooltip();

});