<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 1/4/2556 10:42 น.
 */
class Reports extends CI_Controller {
    protected $provider_id;
    protected $user_id;
    protected $owner_id;

    public function __construct() {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->provider_id = $this->session->userdata('provider_id');
        $this->load->helper('person');
        $this->load->model('Reports_model', 'report');
    }

    public function index() {
        $data['id'] = '1';

        $this->layout->layout('report_layout');
        $this->layout->view('reports/index_view', $data);
    }

    public function menu($id) {
        $id = empty($id)?'1':$id;
        $id = !isset($id)?'1':$id;
        $data['id'] = $id;

        $this->layout->layout('report_layout');
        $this->layout->view('reports/index_view', $data);
    }
}