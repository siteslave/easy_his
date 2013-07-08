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

class Diabetes extends CI_Controller
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
        //Get default value
        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');
        //Set clinic code
        $this->clinic_code = '01';
        //Load model
        $this->load->model('Diabetes_model', 'dm');
        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');
        //Load person helper
        $this->load->helper(array('person'));
        //Set owner id for all model
        $this->basic->owner_id      = $this->owner_id;
        $this->person->owner_id     = $this->owner_id;
        $this->person->clinic_code  = $this->clinic_code;
        $this->person->user_id  = $this->user_id;

        $this->dm->clinic_code  = $this->clinic_code;
        $this->dm->owner_id         = $this->owner_id;
        $this->dm->user_id          = $this->user_id;
    }

    /**
     * Index method
     */
    public function index()
    {
        $data['villages'] = $this->person->get_villages();
        $data['providers'] = $this->basic->get_providers();
        $data['diabetes_types'] = $this->basic->get_diabetes_type_list();
        
        $this->layout->view('diabetes/index_view', $data);
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
                $obj->reg_serial    = $r['registers'][0]['reg_serial'];
                $obj->reg_date      = isset($r['registers'][0]['reg_date']) ? $r['registers'][0]['reg_date'] : '';
                $obj->diag_type     = $this->basic->get_diabetes_type_name(get_first_object($r['registers'][0]['diag_type']));
                $obj->diag_type_code= $r['registers'][0]['diag_type'];

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
    public function get_list_by_villages()
    {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');
        $village_id = $this->input->post('village_id');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $houses = $this->person->get_houses_in_village($village_id);

        $rs = $this->dm->get_list_by_village($houses, $start, $limit);

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
                $obj->reg_serial    = $r['registers'][0]['reg_serial'];
                $obj->reg_date      = isset($r['registers'][0]['reg_date']) ? $r['registers'][0]['reg_date'] : '-';
                $obj->diag_type     = $this->basic->get_diabetes_type_name(get_first_object($r['registers'][0]['diag_type']));
                $obj->diag_type_code= $r['registers'][0]['diag_type'];
                $obj->discharge_date= from_mongo_to_thai_date($r['registers'][0]['discharge_date']);
                $obj->member_status = $r['registers'][0]['member_status'];

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
        $total = $this->dm->get_list_total();
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function get_list_by_village_total()
    {
        $village_id = $this->input->post('village_id');

        $houses = $this->person->get_houses_in_village($village_id);

        $total = $this->dm->get_list_by_village_total($houses);
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function get_detail()
    {
        $hn = $this->input->post('hn');

        if(empty($hn))
        {
            $json = '{"success": false, "msg": "No query found"}';
        }
        else
        {

            $rs = $this->person->detail($hn);

            if($rs)
            {
                $obj = new stdClass();
                $obj->id            = get_first_object($rs['_id']);
                $obj->hn            = $rs['hn'];
                $obj->cid           = $rs['cid'];
                $obj->first_name    = $rs['first_name'];
                $obj->last_name     = $rs['last_name'];
                $obj->birthdate     = $rs['birthdate'];
                $obj->sex           = $rs['sex'];
                $obj->age           = count_age($rs['birthdate']);

                if(isset($rs['registers'])) {
                    foreach($rs['registers'] as $reg) {
                        if($reg['clinic_code'] == '01') {
                            $reg_serial     = $reg['reg_serial'];
                            $hosp_serial    = $reg['hosp_serial'];
                            $year           = $reg['reg_year'];
                            $reg_date       = from_mongo_to_thai_date($reg['reg_date']);
                            $diag_type      = get_first_object($reg['diag_type']);
                            $doctor         = get_first_object($reg['doctor']);
                            $pre_register   = $reg['pre_regis'];
                            $pregnancy      = $reg['pregnancy'];
                            $hypertension   = $reg['hypertension'];
                            $insulin        = $reg['insulin'];
                            $newcase        = $reg['newcase'];
                            $discharge_date = from_mongo_to_thai_date($reg['discharge_date']);
                            $member_status = $reg['member_status'];
                        }
                    }

                    $obj->reg_serial    = $reg_serial;
                    $obj->hosp_serial   = $hosp_serial;
                    $obj->year          = $year;
                    $obj->reg_date      = $reg_date;
                    $obj->diag_type     = $diag_type;
                    $obj->doctor        = $doctor;
                    $obj->pre_register  = $pre_register;
                    $obj->pregnancy     = $pregnancy;
                    $obj->hypertension  = $hypertension;
                    $obj->insulin       = $insulin;
                    $obj->newcase       = $newcase;
                    $obj->discharge_date= $discharge_date;
                    $obj->member_status = $member_status;

                    $rows = json_encode($obj);
                    $json = '{"success": true, "rows": '.$rows.'}';
                }
                else
                {
                    $json = '{ "success": false, "msg": "ไม่พบรายการ" }';
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
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "HN not found."}';
        }
        else
        {
            if($data['is_update'] == '1')
            {
                $rs = $this->dm->do_update($data);
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
                $is_owner = $this->person->check_owner($data['hn']);

                if($is_owner)
                {
                    $data['reg_serial'] = generate_serial('DM');
                    $rs = $this->dm->do_register($data);
                    $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                }
                else
                {
                    $json = '{"success": false, "msg": "ไม่ใช่บุคคลในเขตรับผิดชอบ (Typearea ไม่ใช่ 1 หรือ 3)"}';
                }
            }
        }

        render_json($json);
    }

    private function _check_registration($hn)
    {
        $rs = $this->person->check_clinic_exist($hn, $this->clinic_code);
        return $rs ? TRUE : FALSE;
    }

    public function remove() {
        $hn = $this->input->post('hn');
        
        if(empty($hn))
        {
            $json = '{ "success": false, "msg": "No HN found." }';
        }
        else
        {
            $rs = $this->dm->remove($hn);
            $json = $rs ? '{ "success": true }' : '{ "success": false, "msg": "Can\'t remove dm register." }';
        }
        
        render_json($json);
    }
    
    public function get_providers_by_active() {
        $rs = $this->dm->get_providers_by_active();
        if($rs) {
            $arr_result = array();
            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->id = get_first_object($r['_id']);
                $obj->name = $r['first_name'].' '.$r['last_name'];

                $arr_result[] = $obj;
            }
            
            return $arr_result;
        }
    }

    public function search_person()
    {
        $hn = $this->input->post('hn');
        if(empty($hn))
        {
            $json = '{"success": false, "msg": "กรุณาระบุ HN"}';
        }
        else
        {
            //check owner
            $is_owner = $this->person->check_owner($hn);
            if(!$is_owner)
            {
                $json = '{"success": false, "msg": "บุคคลนี้ไม่ใช่กลุ่มเป้าหมายของคุณ [Typearea ไม่ใช่ 1 และ 3]"}';
            }
            else
            {
                //check registered
                $duplicated = $this->_check_registration($hn);
                if($duplicated)
                {
                    $json = '{"success": false, "msg": "บุคคลนี้ได้ถูกลงทะเบียนไว้เรียบร้อยแล้ว ไม่สามารถลงทะเบียนใหม่ได้"}';
                }
                else
                {
                    $person = $this->person->get_person_detail_with_hn($hn);

                    $obj                = new stdClass();
                    $obj->hn            = $hn;
                    $obj->cid           = $person['cid'];
                    $obj->first_name    = $person['first_name'];
                    $obj->last_name     = $person['last_name'];
                    $obj->sex           = $person['sex'];
                    $obj->birthdate     = $person['birthdate'];
                    $obj->age           = count_age($person['birthdate']);

                    $rows = json_encode($obj);

                    $json = '{"success": true, "rows": '.$rows.'}';
                }
            }

        }

        render_json($json);
    }

    public function search()
    {
        $hn = $this->input->post('hn');

        if(empty($hn))
        {
            $json = '{"success": false, "msg": "กรุณาระบุ HN"}';
        }
        else
        {
            $rs = $this->dm->search($hn);

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
                    $obj->diag_type     = $this->basic->get_diabetes_type_name(get_first_object($r['registers'][0]['diag_type']));
                    $obj->diag_type_code= $r['registers'][0]['diag_type'];

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "No result."}';
            }
        }

        render_json($json);
    }
}

//End of file