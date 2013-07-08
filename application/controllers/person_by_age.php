<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 7/5/2556 14:21 น.
 */
class Person_by_age extends CI_Controller {
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
        $this->load->helper('report');
        $this->load->model('Person_by_age_model', 'pba');
        $this->load->model('Report_basic_model', 'rb');
    }

    public function get_list() {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $this->rb->owner_id = $this->owner_id;
        $this->pba->owner_id = $this->owner_id;
        $rs = $this->pba->get_list($start, $limit);
        if($rs)
        {
            $arr_result = array();

            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->id        = get_first_object($r['_id']);
                $obj->name      = $r['name'];

                $_m = $this->pba->get_person_count_in_area_with_sex_age('1', $r['param'], $r['val1'], $r['val2']);
                $_f = $this->pba->get_person_count_in_area_with_sex_age('2', $r['param'], $r['val1'], $r['val2']);
                $obj->male      = $_m;
                $obj->female    = $_f;

                $arr_result[] = $obj;
            }

            $rows = json_encode($arr_result);
            $json = '{ "success": true, "rows": '.$rows.' }';
        }
        else
        {
            $json = '{"success": false, "msg": "No result."}';
        }

        render_json($json);
    }

    public function get_list_total() {
        $total = $this->pba->get_list_total();
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function test_age($age) {
        $time = strtotime('-'.$age.' year');

        echo date('Y-m-d', $time);
    }
}