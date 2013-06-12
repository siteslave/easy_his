    <?php 
    echo form_open(site_url('users/do_login'), array('class' => 'form-signin', 'id' => "frmLogin"));
    ?>
    <!-- <h2 class="form-signin-heading">Please sign in</h2> -->
    <?php if(isset($success)) { ?>
    <div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong> <?=$msg?>
    </div>
    <?php } ?>

    <input type="text" class="input-block-level" placeholder="ชื่อผู้ใช้งาน" value="<?php echo set_value('username'); ?>"
        id="txt_username" name="username" autocomplete="off" autofocus>
    <input type="password" class="input-block-level" placeholder="รหัสผ่าน" value="<?php echo set_value('password'); ?>"
        id="txt_password" name="password" autocomplete="off">
    <button class="btn btn-large btn-primary btn-block" type="submit" id="btn_dologin">เข้าใช้งาน</button>
  </form>

    <div id="divLoading" style="display: none;">
        &nbsp; <img src="<?php echo base_url(); ?>assets/apps/img/ajax-loader.gif" alt="Loading...">  &nbsp;Logging in...
    </div>
