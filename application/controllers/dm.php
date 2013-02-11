<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * DM Controller
     *
     * @package     Controller
     * @author      Utit Sairat <soodteeruk@gmail.com>
     * @since       Version 1.0.0
     * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
     * @license     http://his.mhkdc.com/licenses
     */

class Dm extends CI_Controller
{
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Global parameter
     */
    protected $user_id;
    protected $owner_id;
    protected $provider_id;
    protected $clinic_code;
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

        $this->clinic_code = '01';

        //$this->load->model('Dm_model', 'dm');
        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');

        $this->load->helper(array('person'));
    }

    /**
     * Index method
     */
    public function index()
    {
        $this->person->owner_id = $this->owner_id;
        $this->person->clinic_code = $this->clinic_code;

        $data['villages'] = $this->person->get_villages();
        $this->layout->view('dm/index_view', $data);
    }

    //------------------------------------------------------------------------------------------------------------------
    public function get_list()
    {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $this->ncd->owner_id = $this->owner_id;
        $rs = $this->ncd->get_list($start, $limit);

        if($rs)
        {

            $arr_result = array();

            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->hn = $r['hn'];
                $obj->cid = $r['cid'];
                $obj->id = get_first_object($r['_id']);
                $obj->first_name = $r['first_name'];
                $obj->last_name = $r['last_name'];
                $obj->sex = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate = $r['birthdate'];
                $obj->age = count_age($r['birthdate']);
                $obj->reg_date = isset($r['registers'][0]['reg_date']) ? $r['registers'][0]['reg_date'] : '';

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
    //------------------------------------------------------------------------------------------------------------------
    public function get_list_by_house()
    {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');
        $house_id = $this->input->post('house_id');

        //$start = empty($start) ? 0 : $start;
        //$stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $this->ncd->owner_id = $this->owner_id;
        $rs = $this->ncd->get_list_by_house($house_id);

        if($rs)
        {

            $arr_result = array();

            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->hn = $r['hn'];
                $obj->cid = $r['cid'];
                $obj->id = get_first_object($r['_id']);
                $obj->first_name = $r['first_name'];
                $obj->last_name = $r['last_name'];
                $obj->sex = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate = $r['birthdate'];
                $obj->age = count_age($r['birthdate']);
                $obj->reg_date = isset($r['registers'][0]['reg_date']) ? $r['registers'][0]['reg_date'] : '';

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
        $this->ncd->owner_id = $this->owner_id;
        $total = $this->ncd->get_list_total();
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function get_list_by_village_total()
    {
        $this->ncd->owner_id = $this->owner_id;
        $total = $this->ncd->get_list_by_village_total();
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Search person
    *
    * @internal param	string 	$query	The query for search
    * @internal param	string	$filter	The filter type. 0 = CID, 1 = HN, 2 = First name and last name
    */
    public function search_person()
    {
        $query = $this->input->post('query');
        $filter = $this->input->post('filter');

        $filter = empty($filter) ? '0' : $filter;

        if(empty($query))
        {
            $json = '{"success": false, "msg": "No query found"}';
        }
        else
        {

            if($filter == '0') //by cid
            {
                $rs = $this->person->search_person_by_cid($query);
            }
            else
            {
                $rs = $this->person->search_person_by_hn($query);
            }

            if($rs)
            {

                $arr_result = array();

                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->id = get_first_object($r['_id']);
                    $obj->hn = $r['hn'];
                    $obj->cid = $r['cid'];
                    $obj->first_name = $r['first_name'];
                    $obj->last_name = $r['last_name'];
                    $obj->birthdate = $r['birthdate'];
                    $obj->sex = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                    $obj->age = count_age($r['birthdate']);

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg ": "ไม่พบรายการ"}';
            }

        }

        render_json($json);
    }

    public function do_register()
    {
        $hn = $this->input->post('hn');

        if(empty($hn))
        {
            $json = '{"success": false, "msg": "HN not found."}';
        }
        else
        {

            $this->person->owner_id = $this->owner_id;
            $this->person->user_id = $this->user_id;

            $exists = $this->person->check_clinic_exist($hn, $this->clinic_code);

            if($exists)
            {
                $json = '{"success": false, "msg": "ทะเบียนซ้ำ - ชื่อนี้มีอยู่ในทะเบียนเรียบร้อยแล้ว"}';
            }
            else
            {
                $rs = $this->person->do_register_clinic($hn, $this->clinic_code);

                if($rs)
                {
                    $json = '{"success": true}';
                }
                else
                {
                    $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                }
            }

        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Check DM registration
     *
     * @return void
     * @internal param string $hn
     */

    public function check_registration()
    {
        $hn = $this->input->post('hn');

        if(empty($hn))
        {
            $json = '{"success": false, "msg": "HN not found."}';
        }
        else
        {
            $rs = $this->person->do_register_clinic($hn, $this->clinic_code);

            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูลการลงทะเบียน"}';
            }
        }

        render_json($json);
    }

    public function remove_dm_register() {
        $person_id = $this->input->post('person_id');
        
        if(empty($person_id)) {
            $json = '{ "success": false, "msg": "No person id found." }';
        } else {
            $rs = $this->ncd->remove_ncd_register($person_id);
            if($rs) {
                $json = '{ "success": true }';
            } else {
                $json = '{ "success": false, "msg": "Can\'t remove dm register." }';
            }
        }
        
        render_json($json);
    }
}


//End file