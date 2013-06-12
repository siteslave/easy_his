<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin controller
 *
 * @package     Controller
 * @author      Mr.Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mkh.go.th/licenses
 */

class Admin extends CI_Controller {

    public $owner_id;
    public $user_id;
    public $provider_id;
    public $salt;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id))
        {
            redirect(site_url('users/access_denied'));
        }

        //check access menu
        /*
         * Under constructor
         */

        $this->load->model('Admin_model', 'admin');

        //Get default value
        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');

        $this->admin->salt = get_salt();
        $this->admin->user_id = $this->user_id;
        $this->admin->owner_id = $this->owner_id;
    }

    public function index()
    {
        $data['users'] = $this->admin->get_list();
        $data['providers'] = $this->admin->get_provider_list();
        $this->layout->view('settings/admin_view', $data);
    }

}