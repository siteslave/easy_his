<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Women extends CI_Controller {

    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id     = $this->session->userdata('owner_id');
        $this->user_id      = $this->session->userdata('user_id');
        $this->provider_id  = $this->session->userdata('provider_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        //models
        $this->load->model('Person_model', 'person');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Women_model', 'women');

        //helpers
        $this->load->helper('person');
    }

    public function index()
    {
        $this->layout->view('women/index_view');
    }
}

/* End of file women.php */
/* Location: ./application/controllers/women.php */