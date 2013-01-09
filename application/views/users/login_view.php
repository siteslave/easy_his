<form class="form-signin" action="#" method="get" id="frmLogin">
    <h2 class="form-signin-heading">Please sign in</h2>
    <div id="divAlert" class="alert alert-info">
        <h4>คำแนะนำ</h4> <span> ระบุชื่อผู้ใช้งานและรหัสผ่าน</span>
    </div>
    <input type="text" class="input-block-level" placeholder="username@mhkdc.com" id="txtUsername" name="user">
    <input type="password" class="input-block-level" placeholder="password" id="txtPassword" name="pass">
    <button class="btn btn-primary" type="button" id="btnDoLogin">
        <i class="icon-user icon-white"></i>
        ลงชื่อเข้าใช้
    </button>
    <div id="divLoading" style="display: none;">
        &nbsp; <img src="<?php echo base_url(); ?>assets/apps/img/ajax-loader.gif" alt="Loading...">  &nbsp;Logging in...
    </div>
</form>
