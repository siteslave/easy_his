<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * Disabilities Controller
     *
     * @package     Controller
     * @author      Satit Rianpit <rianpit@gmail.com>
     * @since       Version 1.0.0
     * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
     * @license     http://his.mhkdc.com/licenses
     */

class Disabilities extends CI_Controller
{
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Global parameter
     */
    protected $user_id;
    protected $owner_id;
    protected $provider_id;
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Construction function
     */
    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id))
        {
            redirect(site_url('users/access_denied'));
        }

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        $this->load->model('Person_model', 'person');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Disability_model', 'disb');
        $this->load->model('House_model', 'house');

        $this->person->owner_id = $this->owner_id;
        $this->disb->owner_id = $this->owner_id;
        $this->disb->user_id = $this->user_id;
        $this->disb->provider_id = $this->provider_id;

        $this->load->helper(array('person'));
    }

    public function index()
    {
        $data['disabilities_types'] = $this->basic->get_disabilities_list();
        $data['villages'] = $this->person->get_villages();

        $this->layout->view('disabilities/index_view', $data);
    }

    public function save()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }
        else
        {
            //check owner
            $is_owner = $this->person->check_owner($data['hn']);

            if($is_owner)
            {
                //check duplicate
                $is_duplicated = $this->disb->check_duplicated($data['hn'], $data['dtype']);

                $rs = $is_duplicated ? $this->disb->do_update($data) : $this->disb->do_save($data);

                if($rs)
                {
                    $json = '{"success": true}';
                }
                else
                {
                    $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                }
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่ใช่คนในเขตรับผิดชอบ"}';
            }

        }

        render_json($json);
    }


    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get babies list
     *
     * @internal    param   int $start
     * @internal    param   int $stop
     * @return      json
     */
    public function get_list()
    {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $this->disb->owner_id = $this->owner_id;
        $rs = $this->disb->get_list($start, $limit);

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {
                $person = $this->person->get_person_detail_with_hn($r['hn']);
                $obj                = new stdClass();
                $obj->hn            = $r['hn'];
                $obj->cid           = $person['cid'];
                $obj->id            = get_first_object($r['_id']);
                $obj->first_name    = $person['first_name'];
                $obj->last_name     = $person['last_name'];
                $obj->sex           = $person['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate     = $person['birthdate'];
                $obj->age           = count_age($person['birthdate']);
                $obj->reg_date      = from_mongo_to_thai_date($r['reg_date']);
                $obj->disb_type     = $this->basic->get_disability_type_name(get_first_object($r['dtype']));

                $arr_result[]       = $obj;
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
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get total
     *
     * @internal    param  string  $owner_id
     * @return      json
     */
    public function get_list_total()
    {
        $this->disb->owner_id = $this->owner_id;

        $total = $this->disb->get_list_total();

        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function get_detail()
    {
        $id = $this->input->post('id');

        $rs = $this->disb->get_detail($id);

        if($rs)
        {
            $obj = new stdClass();
            $obj->hn = $rs['hn'];
            $obj->did = $rs['did'];
            $obj->dtype = get_first_object($rs['dtype']);
            $obj->dcause = $rs['dcause'];
            $obj->diag_code = $rs['diag_code'];
            $obj->diag_name = get_diag_name($rs['diag_code']);
            $obj->detect_date = to_js_date($rs['detect_date']);
            $obj->disb_date = to_js_date($rs['disb_date']);

            $rows = json_encode($obj);

            $json = '{"success": true, "rows": '.$rows.'}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
        }

        render_json($json);
    }

    public function remove()
    {
        $id = $this->input->post('id');
        $rs = $this->disb->remove($id);

        if($rs)
        {
            $json = '{"success": true}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่สามารถลบข้อมูลได้"}';
        }

        render_json($json);
    }

    public function get_list_by_village()
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