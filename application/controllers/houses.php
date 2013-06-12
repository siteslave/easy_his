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

class Houses extends CI_Controller
{
    /*
     * Owner id for assign owner.
     */
    var $owner_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        //models
        $this->load->model('Person_model', 'person');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('House_model', 'house');
        $this->load->model('Disability_model', 'disb');

        //helpers
        $this->load->helper('person');
    }

}