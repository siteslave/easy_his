<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 17/4/2556 14:44 น.
 */
class Person_by_sex extends CI_Controller {
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
                $obj->id = get_first_object($r['_id']);
                $obj->code = $r['village_code'];
                $obj->name = $r['village_name'];

                $house_id = $this->rb->get_house_id_per_village($obj->id);
                $person_male = $this->rb->get_person_count_in_area_with_male($house_id);
                $obj->male = $person_male;

                $person_female = $this->rb->get_person_count_in_area_with_female($house_id);
                $obj->female = $person_female;

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