<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * Controller
     *
     * Controller information information
     *
     * @package     Controller
     * @author      Satit Rianpit <rianpit@gmail.com>
     * @since       Version 1.0.0
     * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
     * @license     http://his.mhkdc.com/licenses
     */

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->layout->setLayout('login_layout');

        //load model
        $this->load->model('User_model', 'user');

        //$this->csrf_token = $this->security->get_csrf_hash();

        //$this->twiggy->set('site_url', site_url());
        //$this->twiggy->set('base_url', base_url());
        //$this->twiggy->set('csrf_token', $this->csrf_token);

    }

    //index action
    public function index()
    {
        $this->login();
    }
    public function login(){
        //$this->twiggy->layout('login')->template('users/login')->display();
        $this->layout->view('users/login_view');
    }

    /*
     * Check login
     *
     * Check user login, get username and password from login page
     */
    public function do_login(){

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if(empty($username)){
            $json = '{"success": false, "msg": "Username empty."}';
        }else if(empty($password)){
            $json = '{"success": false, "msg": "Password empty."}';
        }else{
            //do login
            $users = $this->user->do_login($username, $password);

            if(count($users) > 0){

                // Create session

                //$users = $this->user->get_user_detail($username);

                $fullname = $users['fullname'];
                $user_id = get_first_object($users['_id']);
                $provider_id = get_first_object($users['provider_id']);

                $owner_id = $users['owner_id'];

                $owners = $this->user->get_owner_detail($owner_id);

                $hmain_code = $owners['main_hospital'];
                $hmain_name = get_hospital_name($hmain_code);
                $hsub_code = $owners['pcucode'];
                $hsub_name = get_hospital_name($hsub_code);

                $data = array(
                    'username' => $username,
                    'fullname' => $fullname,
                    'hmain_code' => $hmain_code,
                    'hsub_code' => $hsub_code,
                    'hmain_name' => $hmain_name,
                    'hsub_name' => $hsub_name,
                    'owner_id' => $owner_id,
                    'user_id' => $user_id,
                    'provider_id' => $provider_id
                );

                //set session data
                $this->session->set_userdata($data);

                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Username or Password incorrect."}';
            }
        }

        render_json($json);
    }

    public function logout(){
        $this->session->sess_destroy();
        $this->login();
    }
    public function access_denied(){
        $json = '{"success": false, "msg": "Access denied, please login."}';

        render_json($json);
    }



}