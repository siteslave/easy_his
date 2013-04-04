<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * DM Controller
     *
     * @package     Controller
     * @author      Mr.Utit Sairat <soodteeruk@gmail.com>
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

        $this->load->model('Dm_model', 'dm');
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
        $this->dm->owner_id = $this->owner_id;

        $data['villages'] = $this->person->get_villages();
        $data['providers'] = $this->get_providers_by_active();
        
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

        $this->dm->owner_id = $this->owner_id;
        $rs = $this->dm->get_list($start, $limit);

        if($rs)
        {

            $arr_result = array();

            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->hn            = $r['hn'];
                $obj->cid           = $r['cid'];
                $obj->id            = get_first_object($r['_id']);
                $obj->first_name    = $r['first_name'];
                $obj->last_name     = $r['last_name'];
                $obj->sex           = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate     = $r['birthdate'];
                $obj->age           = count_age($r['birthdate']);
                $obj->reg_date      = isset($r['registers'][0]['reg_date']) ? $r['registers'][0]['reg_date'] : '';

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

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $this->dm->owner_id = $this->owner_id;
        $rs = $this->dm->get_list_by_house($house_id);

        if($rs)
        {

            $arr_result = array();

            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->hn            = $r['hn'];
                $obj->cid           = $r['cid'];
                $obj->id            = get_first_object($r['_id']);
                $obj->first_name    = $r['first_name'];
                $obj->last_name     = $r['last_name'];
                $obj->sex           = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate     = $r['birthdate'];
                $obj->age           = count_age($r['birthdate']);
                $obj->reg_date      = isset($r['registers'][0]['reg_date']) ? $r['registers'][0]['reg_date'] : '';

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
        $this->dm->owner_id = $this->owner_id;
        $total = $this->dm->get_list_total();
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function get_list_by_village_total()
    {
        $this->dm->owner_id = $this->owner_id;
        $total = $this->dm->get_list_by_village_total();
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
        $query = (string)$this->input->post('query');
        $filter = (string)$this->input->post('filter');

        $filter = empty($filter) ? '0' : $filter;

        if(empty($query))
        {
            $json = '{"success": false, "msg": "No query found"}';
        }
        else
        {
            $this->person->owner_id = $this->owner_id;
            if($filter == '0') //by cid
            {
                $rs = $this->person->search_person_by_cid_with_owner($query);
            }
            else
            {
                $rs = $this->person->search_person_by_hn_with_owner($query);
            }

            if($rs)
            {
                $arr_result = array();
                $type_area_check = false;
                $chk_dm_regis = "0";
                $reg_serial = "";
                $hosp_serial = "";
                $year = "";
                $reg_date = date('Ymd');
                $diag_type = "";
                $doctor = "";
                $pre_register = false;
                $pregnancy = false;
                $hypertension = false;
                $insulin = false;
                $newcase = false;

                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->id            = get_first_object($r['_id']);
                    $obj->hn            = $r['hn'];
                    $obj->cid           = $r['cid'];
                    $obj->first_name    = $r['first_name'];
                    $obj->last_name     = $r['last_name'];
                    $obj->birthdate     = $r['birthdate'];
                    $obj->sex           = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                    $obj->age           = count_age($r['birthdate']);
                    //$type_area_check = $r['typearea'][0]['typearea'];
                    foreach($r['typearea'] as $typearea) {
                        if(($typearea['typearea']== "1" || $typearea['typearea'] == "3") && $typearea['owner_id'] == $this->owner_id)
                            $type_area_check = true;
                    }
                    
                    if(isset($r['registers'])) {
                        foreach($r['registers'] as $reg) {
                            if($reg['clinic_code'] == '01') {
                                $chk_dm_regis   = "1";
                                $reg_serial     = $reg['reg_serial'];
                                $hosp_serial    = $reg['hosp_serial'];
                                $year           = $reg['reg_year'];
                                $reg_date       = $reg['reg_date'];
                                $diag_type      = $reg['diag_type'];
                                $doctor         = get_first_object($reg['doctor']);
                                $pre_register   = $reg['pre_regis'];
                                $pregnancy      = $reg['pregnancy'];
                                $hypertension   = $reg['hypertension'];
                                $insulin        = $reg['insulin'];
                                $newcase        = $reg['newcase'];
                            }
                        }
                    }
                    $obj->chk_regis     = $chk_dm_regis;
                    $obj->reg_serial    = $reg_serial;
                    $obj->hosp_serial   = $hosp_serial;
                    $obj->year          = $year;
                    $obj->reg_date      = to_js_date($reg_date);
                    $obj->diag_type     = $diag_type;
                    $obj->doctor        = $doctor;
                    $obj->pre_register  = $pre_register;
                    $obj->pregnancy     = $pregnancy;
                    $obj->hypertension  = $hypertension;
                    $obj->insulin       = $insulin;
                    $obj->newcase       = $newcase;

                    $arr_result[] = $obj;
                }
                
                if($type_area_check) {
                    $rows = json_encode($arr_result);
                    $json = '{"success": true, "rows": '.$rows.'}';
                } else {
                    $json = '{ "success": false, "msg": "ไม่ใช่บุคคลในเขตรับผิดชอบ" }';
                }
            }
            else
            {
                $json = '{ "success": false, "msg": "ไม่พบรายการ" }';
            }

        }

        render_json($json);
    }

    public function do_register()
    {
        $data['hn']             = $this->input->post('hn');
        $data['hid_regis']      = $this->input->post('hid_regis');
        $data['year_regis']     = $this->input->post('year_regis');
        $data['date_regis']     = $this->input->post('date_regis');
        $data['diag_type']      = $this->input->post('diag_type');
        $data['doctor']         = $this->input->post('doctor');
        $data['pre_register']   = $this->input->post('pre_register');
        $data['pregnancy']      = $this->input->post('pregnancy');
        $data['hypertension']   = $this->input->post('hypertension');
        $data['insulin']        = $this->input->post('insulin');
        $data['newcase']        = $this->input->post('newcase');
        $data['hosp_serial']    = $this->input->post('hosp_serial');

        if(empty($data['hn']))
        {
            $json = '{"success": false, "msg": "HN not found."}';
        }
        else
        {

            $this->dm->owner_id = $this->owner_id;
            $this->dm->user_id = $this->user_id;
            $data['reg_serial'] = generate_serial('DM');

            $rs = $this->dm->do_regis_dm_clinic($data);

            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
            }
        }

        render_json($json);
    }

    public function do_update()
    {
        $data['hn']             = $this->input->post('hn');
        $data['hid_regis']      = $this->input->post('hid_regis');
        $data['year_regis']     = $this->input->post('year_regis');
        $data['date_regis']     = $this->input->post('date_regis');
        $data['diag_type']      = $this->input->post('diag_type');
        $data['doctor']         = $this->input->post('doctor');
        $data['pre_register']   = $this->input->post('pre_register');
        $data['pregnancy']      = $this->input->post('pregnancy');
        $data['hypertension']   = $this->input->post('hypertension');
        $data['insulin']        = $this->input->post('insulin');
        $data['newcase']        = $this->input->post('newcase');
        $data['hosp_serial']    = $this->input->post('hosp_serial');

        if(empty($data['hn']))
        {
            $json = '{"success": false, "msg": "HN not found."}';
        }
        else
        {

            $this->dm->owner_id = $this->owner_id;
            $this->dm->user_id = $this->user_id;
            //$reg_serial = //generate_serial('DM');

            $rs = $this->dm->do_update_dm_clinic($data);

            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถแก้ไขข้อมูลได้"}';
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
            $rs = $this->dm->remove_dm_register($person_id);
            if($rs) {
                $json = '{ "success": true }';
            } else {
                $json = '{ "success": false, "msg": "Can\'t remove dm register." }';
            }
        }
        
        render_json($json);
    }
    
    public function get_providers_by_active() {
        $rs = $this->dm->get_providers_by_active();
        if($rs) {
            $arr_result = array();
            foreach($rs as $r) {
                $obj = new stdClass();
                $obj->id = get_first_object($r['_id']);
                $obj->name = $r['first_name'].' '.$r['last_name'];
                
                array_push($arr_result, $obj);
            }
            
            return $arr_result;
        }
    }
}

//End of file