
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title">Sign in to EasyHIS.</h1>
                <div class="account-wall">
                    <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                         alt="">
                    <?php echo form_open(site_url('users/do_login'), array('class' => 'form-signin', 'id' => "frmLogin")); ?>
                        <input type="text" autocomplete="off" id="txt_username" name="username" class="form-control" placeholder="Username" required autofocus>
                        <input type="password" id="txt_password" name="password" class="form-control" placeholder="Password" required>
                        <button class="btn btn-lg btn-primary btn-block" type="submit" id="btn_dologin"> Sign in </button>

                    </form>
                </div>
            </div>
        </div>
    </div>