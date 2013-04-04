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

    public function get_disb_person_in_village()
    {
        $village_id = $this->input->post('village_id');

        $houses = $this->_get_house_list($village_id);
        $persons = $this->_get_person_list($houses);

        $person_disb = $this->disb->get_person_list_village($persons);

        if($person_disb)
        {
            $arr_result = array();
            foreach($person_disb as $r)
            {
                $person = $this->person->get_person_detail_with_hn($r['hn']);
                $obj = new stdClass();
                $obj->hn = $r['hn'];
                $obj->cid = $person['cid'];
                $obj->id = get_first_object($r['_id']);
                $obj->first_name = $person['first_name'];
                $obj->last_name = $person['last_name'];
                $obj->sex = $person['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate = $person['birthdate'];
                $obj->age = count_age($person['birthdate']);
                $obj->reg_date = from_mongo_to_thai_date($r['reg_date']);
                $obj->disb_type = $this->basic->get_disability_type_name(get_first_object($r['dtype']));

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

    private function _get_house_list($village_id)
    {
        $rs = $this->house->get_house_list($village_id);

        return $rs;
    }

    private function _get_person_list($houses)
    {
        $arr_person = array();

        for($i=0; $i < count($houses); $i++) {

            $persons = $this->house->get_person_list($houses[$i]);

            foreach($persons as $p)
            {
                $arr_person[] = $p['hn'];
            }
            //$arr_person[] = $persons;
        }

        return $arr_person;
    }
}