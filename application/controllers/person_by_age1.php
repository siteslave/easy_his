<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 17/4/2556 15:59 น.
 */
class Person_by_age1 extends CI_Controller {
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
        $this->load->model('Person_per_village_model', 'ppv');
        $this->load->model('Report_basic_model', 'rb');
    }


    public function get_list() {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $this->ppv->owner_id = $this->owner_id;
        $this->rb->owner_id = $this->owner_id;
        $rs = $this->ppv->get_list($start, $limit);
        if($rs)
        {
            $arr_result = array();

            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->id        = get_first_object($r['_id']);
                $obj->code      = $r['village_code'];
                $obj->name      = $r['village_name'];

                $obj->age0001m   = 0;
                $obj->age0001f   = 0;
                $obj->age0104m   = 0;
                $obj->age0104f   = 0;
                $obj->age0509m   = 0;
                $obj->age0509f   = 0;
                $obj->age1014m   = 0;
                $obj->age1014f   = 0;
                $obj->age1519m   = 0;
                $obj->age1519f   = 0;
                $obj->age2024m   = 0;
                $obj->age2024f   = 0;
                $obj->age2529m   = 0;
                $obj->age2529f   = 0;
                $obj->age3034m   = 0;
                $obj->age3034f   = 0;
                $obj->age3539m   = 0;
                $obj->age3539f   = 0;

                $arr_result[] = $obj;
            }

            $rows = json_encode($arr_result);
            $json = '{"success": true, "rows": '.$rows.'}';
        }
        else
        {
            $json = '{"success": false, "msg": "No result."}';
        }

        render_json($json);
    }

    public function get_list_total()
    {
        $this->ppv->owner_id = $this->owner_id;
        $total = $this->ppv->get_list_total();
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }
}