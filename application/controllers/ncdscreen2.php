<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * ncd Controller
     *
     * @package     Controller
     * @author      Mr.Utit Sairat <soodteeruk@gmail.com>
     * @since       Version 1.0.0
     * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
     * @license     http://his.mhkdc.com/licenses
     */

class Ncdscreen extends CI_Controller
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

        $this->clinic_code = '06';

        $this->load->model('Ncdscreen_model', 'ncd');
        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');
        $this->load->model('Diabetes_model', 'dm');

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

        $this->layout->view('ncd/index_view', $data);
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
                $obj->hn            = $r['hn'];
                $obj->cid           = $r['cid'];
                $obj->id            = get_first_object($r['_id']);
                $obj->first_name    = $r['first_name'];
                $obj->last_name     = $r['last_name'];
                $obj->sex           = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->screen        = $this->ncd->get_last_screen(get_first_object($r['_id']));
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

        $this->ncd->owner_id = $this->owner_id;
        $rs = $this->ncd->get_list_by_house($house_id, $start, $limit);

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
            else if($filter == '2')
            {
                //get hn by first name and last name
                $name = explode(' ', $query); // [0] = first name, [1] = last name

                $first_name = count($name) == 2 ? $name[0] : '';
                $last_name = count($name) == 2 ? $name[1] : '';

                $rs = $this->person->search_person_by_first_last_name($first_name, $last_name);

            }
            else
            {
                $rs = $this->person->search_person_by_hn($query);
            }

            if($rs)
            {

                $arr_result = array();
                $owner_id_check = '';

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
                    $owner_id_check     = $r['owner_id'];

                    $arr_result[] = $obj;
                }

                if($owner_id_check == $this->owner_id) {
                    $rows = json_encode($arr_result);
                    $json = '{"success": true, "rows": '.$rows.'}';
                } else {
                    $json = '{ "success": false, "msg": "ไม่ใช่บุคคลในเขตรับผิดชอบ" }';
                }
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบรายการ"}';
            }

        }

        render_json($json);
    }

    public function do_register()
    {
        $data = $this->input->post('data');
        $this->ncd->owner_id = $this->owner_id;
        $this->ncd->user_id = $this->user_id;

        $rs = $this->ncd->register($data);

        if($rs) {
            $json = '{ "success": true }';
        } else {
            $json = '{ "success": false, "msg": "ไม่สามารถเพิ่มข้อมูลได้." }';
        }

        render_json($json);
    }

    public function update_ncd_detail() {
        $data = $this->input->post('data');
        $this->ncd->owner_id = $this->owner_id;
        $this->ncd->user_id = $this->user_id;

        $rs = $this->ncd->update_ncd_detail($data);

        if($rs) {
            $json = '{ "success": true }';
        } else {
            $json = '{ "success": false, "msg": "ไม่สามารถแก้ไขข้อมูลได้." }';
        }

        render_json($json);
    }

    /**
     * Check NCD registration
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
    
    public function remove_ncd_register() {
        $person_id = $this->input->post('person_id');
        
        if(empty($person_id)) {
            $json = '{ "success": false, "msg": "No person id found." }';
        } else {
            $rs = $this->ncd->remove_ncd_register($person_id);
            if($rs) {
                $json = '{ "success": true }';
            } else {
                $json = '{ "success": false, "msg": "Can\'t remove ncd register." }';
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

                $arr_result[] = $obj;
            }

            return $arr_result;
        }
    }

    public function get_ncd_list() {
        $id = $this->input->post('person_id');
        $rs = $this->ncd->get_ncd_list($id);
        if($rs) {
            $arr_result = array();
            foreach($rs as $r) {
                $obj = new stdClass();
                $obj->id            = get_first_object($r['_id']);
                $obj->date          = $r['date'];
                $obj->time          = $r['time'];
                $obj->weight        = $r['weight'];
                $obj->height        = $r['height'];
                $obj->waist_line    = $r['waist_line'];
                $obj->bmi           = $r['bmi'];

                $arr_result[] = $obj;
            }
            $rows = json_encode($arr_result);
            $json = '{ "success": true, "rows": '.$rows.' }';
        } else {
            $json = '{ "success": false, "msg": "ไม่มีข้อมูล" }';
        }

        render_json($json);
    }

    public function get_standard_detail() {
        $id = $this->input->post('person_id');
        $rs = $this->ncd->get_standard_detail($id);

        if($rs) {
            $rows = json_encode($rs);
            $json = '{ "success": true, "rows": '.$rows.' }';
        } else {
            $json = '{ "success": false, "msg": "ไม่มีข้อมูล" }';
        }

        render_json($json);
    }

    public function remove_ncd() {
        $id = $this->input->post('id');

        $rs = $this->ncd->remove_ncd($id);
        if($rs) {
            $json = '{ "success": true }';
        } else {
            $json = '{ "success": false }';
        }
        render_json($json);
    }

    public function get_ncd_detail() {
        $id = $this->input->post('id');
        $rs = $this->ncd->get_ncd_detail($id);
        if($rs) {
            $arr_result = array();
            foreach($rs as $r) {
                $obj = new stdClass();
                $obj->date          = $r['date'];
                $obj->time          = $r['time'];
                $obj->weight        = $r['weight'];
                $obj->height        = $r['height'];
                $obj->waist_line    = $r['waist_line'];
                $obj->bmi           = $r['bmi'];
                $obj->service_local = $r['service_local'];
                $obj->doctor        = get_first_object($r['doctor']);
                $obj->service_place = $r['service_place'];

                $obj->pcu_name      = get_hospital_name($r['service_place']);

                $obj->parental_illness_history_dm       = $r['parental_illness_history_dm'];
                $obj->parental_illness_history_ht       = $r['parental_illness_history_ht'];
                $obj->parental_illness_history_gout     = $r['parental_illness_history_gout'];
                $obj->parental_illness_history_crf      = $r['parental_illness_history_crf'];
                $obj->parental_illness_history_mi       = $r['parental_illness_history_mi'];
                $obj->parental_illness_history_stroke   = $r['parental_illness_history_stroke'];
                $obj->parental_illness_history_copd     = $r['parental_illness_history_copd'];
                $obj->parental_illness_history_unknown  = $r['parental_illness_history_unknown'];
                $obj->sibling_illness_history_dm        = $r['sibling_illness_history_dm'];
                $obj->sibling_illness_history_ht        = $r['sibling_illness_history_ht'];
                $obj->sibling_illness_history_gout      = $r['sibling_illness_history_gout'];
                $obj->sibling_illness_history_crf       = $r['sibling_illness_history_crf'];
                $obj->sibling_illness_history_mi        = $r['sibling_illness_history_mi'];
                $obj->sibling_illness_history_stroke    = $r['sibling_illness_history_stroke'];
                $obj->sibling_illness_history_copd      = $r['sibling_illness_history_copd'];
                $obj->sibling_illness_history_unknown   = $r['sibling_illness_history_unknown'];
                $obj->history_illness_dm                = $r['history_illness_dm'];
                $obj->history_illness_ht                = $r['history_illness_ht'];
                $obj->history_illness_liver             = $r['history_illness_liver'];
                $obj->history_illness_paralysis         = $r['history_illness_paralysis'];
                $obj->history_illness_heart             = $r['history_illness_heart'];
                $obj->history_illness_lipid             = $r['history_illness_lipid'];
                $obj->history_illness_footUlcers        = $r['history_illness_footUlcers'];
                $obj->history_illness_confined          = $r['history_illness_confined'];
                $obj->history_illness_drink_water_frequently = $r['history_illness_drink_water_frequently'];
                $obj->history_illness_night_urination   = $r['history_illness_night_urination'];
                $obj->history_illness_batten            = $r['history_illness_batten'];
                $obj->history_illness_weight_down       = $r['history_illness_weight_down'];
                $obj->history_illness_ulcerated_lips    = $r['history_illness_ulcerated_lips'];
                $obj->history_illness_itchy_skin        = $r['history_illness_itchy_skin'];
                $obj->history_illness_bleary_eyed       = $r['history_illness_bleary_eyed'];
                $obj->history_illness_tea_by_hand       = $r['history_illness_tea_by_hand'];
                $obj->history_illness_how_to_behave     = $r['history_illness_how_to_behave'];
                $obj->history_illness_creased_neck      = $r['history_illness_creased_neck'];
                $obj->history_illness_history_fpg       = $r['history_illness_history_fpg'];
                $obj->smoking                           = $r['smoking'];
                $obj->of_smoked                         = $r['of_smoked'];
                $obj->time_smoke                        = $r['time_smoke'];
                $obj->smoking_number_per_day            = $r['smoking_number_per_day'];
                $obj->smoking_number_per_year           = $r['smoking_number_per_year'];
                $obj->of_smoking                        = $r['of_smoking'];
                $obj->smoking_year                      = $r['smoking_year'];
                $obj->alcohol                           = $r['alcohol'];
                $obj->alcohol_per_week                  = $r['alcohol_per_week'];
                $obj->exercise                          = $r['exercise'];
                $obj->food                              = $r['food'];
                $obj->fcg                               = $r['fcg'];
                $obj->fpg                               = $r['fpg'];
                $obj->ppg                               = $r['ppg'];
                $obj->ppg_hours                         = $r['ppg_hours'];
                $obj->pressure_measurements             = $r['pressure_measurements'];
                $obj->body_screen                       = $r['body_screen'];

                $arr_result[] = $obj;
            }
            $rows = json_encode($arr_result);
            $json = '{ "success": true, "rows":'.$rows.' }';
        } else {
            $json = '{ "success": false }';
        }

        render_json($json);
    }
}
//End of file