<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

    /*
     * Owner id for assign owner.
     */
    var $owner_id;

    public function __construct(){
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->twiggy->set('site_url', site_url());
        $this->twiggy->set('base_url', base_url());

        $this->twiggy->set('fullname', $this->session->userdata('fullname'));
    }
    public function index()
    {
        $this->twiggy->display();
        //$this->load->view('welcome_message');
    }

}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */