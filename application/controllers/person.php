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

class Person extends CI_Controller
{
    /*
     * Owner id for assign owner.
     */
    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        //models
        $this->load->model('Person_model', 'person');
        $this->load->model('Basic_model', 'basic');

        //helpers
        $this->load->helper('person');
    }

    //index action
    public function index()
    {
        $this->layout->view('person/index_view');
    }

    public function register($house_id=''){
        if(empty($house_id)){
            show_error('No house id found.', 505);
        }else{
            $educations     = $this->basic->get_education();
            $titles         = $this->basic->get_title();
            $inscls         = $this->basic->get_insurance();
            $occupations    = $this->basic->get_occupation();
            $marry_status   = $this->basic->get_marry_status();
            $races          = $this->basic->get_races();
            $nationalities  = $this->basic->get_nationalities();
            $religions      = $this->basic->get_religions();
            $provinces      = $this->basic->get_province();
            $typearea       = $this->basic->get_typearea();
            $labor_types    = $this->basic->get_labor_type();
            $vstatus        = $this->basic->get_vstatus();
            $house_type     = $this->basic->get_house_type();

            $data['educations'] = $educations;
            $data['titles'] = $titles;
            $data['inscls'] = $inscls;
            $data['occupations'] = $occupations;
            $data['races'] = $races;
            $data['nationalities'] = $nationalities;
            $data['religions'] = $religions;
            $data['marry_statuses'] = $marry_status;
            $data['provinces'] = $provinces;
            $data['typearea'] = $typearea;
            $data['labor_types'] = $labor_types;
            $data['vstatus'] = $vstatus;
            $data['house_type'] = $house_type;

            $data['house_id'] = $house_id;
            $this->layout->view('person/register_view', $data);
        }

    }

    public function get_villages(){

        $this->person->owner_id = $this->owner_id;
        $result = $this->person->get_villages();

        $arr_result = array();
        foreach($result as $r){

            $obj                = new stdClass();
            $obj->village_code  = $r['village_code'];
            $obj->village_name  = $r['village_name'];
            $obj->moo           = substr($r['village_code'], 6, 2);
            $obj->id            = get_first_object($r['_id']);

            $arr_result[] = $obj;
        }

        $rows = json_encode($arr_result);

        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }

    public function get_houses(){

        $village_id = $this->input->post('village_id');
        if(empty($village_id)){
            $json = '{"success": false, "msg": "No village id found."}';
        }else{
            $result = $this->person->get_houses($village_id);

            $arr_result = array();

            foreach($result as $r){

                $obj            = new stdClass();
                $obj->house     = $r['house'];
                $obj->id        = get_first_object($r['_id']);
                $obj->house_id  = $r['house_id'];
                $obj->total     = count_person($obj->id);

                $arr_result[] = $obj;
            }

            $rows = json_encode($arr_result);

            $json = '{"success": true, "rows": '. $rows .'}';
        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * @internal param   string  $village_id
     */
    public function get_houses_list(){

        $village_id = $this->input->post('village_id');
        if(empty($village_id)){
            $json = '{"success": false, "msg": "No village id found."}';
        }else{
            $result = $this->person->get_houses($village_id);

            $arr_result = array();

            foreach($result as $r){

                $obj            = new stdClass();
                $obj->house     = $r['house'];
                $obj->id        = get_first_object($r['_id']);
                $obj->house_id  = $r['house_id'];

                $arr_result[] = $obj;
            }

            $rows = json_encode($arr_result);

            $json = '{"success": true, "rows": '. $rows .'}';
        }

        render_json($json);
    }
    /**
     * Save new house
     *
     * @internal    param   mixed   $data
     *
     * @return      json
     */
    public function save_house(){

        $data = $this->input->post('data');

        if(!$data){
            $json = '{"success": false, "msg": "No data for save"}';
        }else{
            //check house duplicate
            $duplicated = $this->person->check_duplicate_house($data['house'], $data['village_id']);


            //if house duplicate return false
            if($duplicated){
                $json = '{"success": false, "msg": "House duplicated"}';
            //if don't duplicate save new house
            }else{
                $data['hid'] = generate_serial('HOUSE', FALSE);
                $this->person->owner_id = $this->owner_id;
                $result = $this->person->save_house($data);

                if($result){
                    $json = '{"success": true}';
                }else{
                    $json = '{"success": false, "msg": "Model error."}';
                }
            }
        }
        //render json
        render_json($json);
    }

    public function search_dbpop(){
        $query = $this->input->post('query');
        //$by = $this->input->post('by');

        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{
            if(is_numeric($query)){
                $result = $this->person->search_dbpop_by_cid($query);
            }else{
                $result = $this->person->search_dbpop_by_name($query);
            }

            if($result){
                $arr_result = array();
                foreach($result as $r){
                    $obj = new stdClass();

                    $obj->fname             = $r['fname'];
                    $obj->lname             = $r['lname'];
                    $obj->birthdate         = $r['birthdate'];
                    $obj->maininscl         = $r['maininscl'];
                    $obj->maininscl_name    = get_main_inscl($r['maininscl']);
                    $obj->cid               = $r['pid'];
                    $obj->subinscl          = $r['subinscl'];
                    $obj->sex               = $r['sex'];
                    $obj->cardid            = $r['cardid'];
                    $obj->hmain_code        = (string) $r['hmain'];
                    $obj->hmain_code        = strlen($obj->hmain_code) < 5 ? '0' . $obj->hmain_code : (string) $r['hmain'];
                    $obj->hsub_code         = (string) $r['hsub'];
                    $obj->hsub_code         = strlen($obj->hsub_code) < 5 ? '0' . $obj->hsub_code : (string) $r['hsub'];
                    $obj->hmain_name        = get_hospital_name($obj->hmain_code);
                    $obj->hsub_name         = get_hospital_name($obj->hsub_code);
                    $obj->startdate         = $r['startdate'];
                    $obj->expdate           = $r['expdate'];

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);

                $json = '{"success": true, "rows": '. $rows .'}';
            }else{
                $json = '{"success"": false, "msg": "No result found"}';
            }
        }

        render_json($json);
    }

    public function save_house_survey(){
        $data = $this->input->post('data');

        if(!$data){
            $json = '{"success": false, "msg": "No data for save"}';
        }else{
            //check house duplicate
            $house_exist = $this->person->check_house_exist($data['house_id']);

            //if house duplicate return false
            if(!$house_exist){
                $json = '{"success": false, "msg": "No house id found"}';
                //if don't duplicate save new house
            }else{
                $this->person->owner_id = $this->owner_id;
                $result = $this->person->save_house_survey($data);

                if($result){
                    $json = '{"success": true}';
                }else{
                    $json = '{"success": false, "msg": "Model error."}';
                }
            }
        }
        //render json
        render_json($json);

    }

    public function get_house_survey(){
        $house_id = $this->input->post('house_id');

        if(empty($house_id)){
            $json = '{"success": false, "msg": "No house id found"}';
        }else{
            //check house exist
            $house_exist = $this->person->check_house_exist($house_id);

            //if house exist
            if(!$house_exist){
                $json = '{"success": false, "msg": "No house id found"}';
            }else{
                $result = $this->person->get_house_survey($house_id);

                $rows = json_encode($result);
                if($result){
                    $json = '{"success": true, "rows": '.$rows.'}';
                }else{
                    $json = '{"success": false, "msg": "Model error."}';
                }
            }
        }
        //render json
        render_json($json);

    }

    public function save(){
        $data = $this->input->post('data');
        if(empty($data)){
            $json = '{"success": false, "msg": "No data found"}';
        }else{
            //check cid
            $person_exist = $this->person->check_person_exist($data['cid']);
            if($person_exist){
                $json = '{"success": false, "msg": "CID duplicate."}';
            }else{
                $data['hn'] = generate_serial('HN');
                $this->person->owner_id = $this->owner_id;

                $result = $this->person->save_person($data);

                if($result){
                    //person id
                    $person_id = $result;

                    //save address
                    //if($data['typearea'] == '3' || $data['typearea'] == '4' || $data['typearea'] == '0'){
                    $this->person->save_person_address($person_id, $data['address']);
                    //}
                    $this->person->save_insurance($person_id, $data['ins']);
                    $json = '{"success": true}';

                }else{
                    $json = '{"success": false, "msg": "Model error"}';
                }
            }
        }

        render_json($json);
    }

    public function do_update(){
        $data = $this->input->post('data');

        $success = FALSE;
        $msg = '';

        if(empty($data)){

            $success = FALSE;
            $msg = "No data found";

        }else{

            if($data['old_cid'] == $data['cid']){

                $result = $this->do_update_person($data);

                if($result){
                    $success = TRUE;
                }else{
                    $success = FALSE;
                    $msg = "Database model error.";
                }

            }else{
                //check cid
                $person_exist = $this->person->check_person_exist($data['cid']);

                if($person_exist){
                    $success = FALSE;
                    $msg = "CID duplicate.";
                }else{
                    $result = $this->do_update_person($data);
                    if($result){
                        $success = TRUE;
                    }else{
                        $success = FALSE;
                        $msg = "Update failed, please check your data/parameters";
                    }
                }
            }
        }

        if($success){
            $json = '{"success": true}';
        }else{
            $json = '{"success": false, "msg": "'.$msg.'"}';
        }

        render_json($json);
    }

    private function do_update_person($data){

        $result = $this->person->update_person($data);

        if($result){
            //save address
            //if($data['typearea'] == '3' || $data['typearea'] == '4' || $data['typearea'] == '0'){
                //remove address
                $this->person->remove_person_address($data['hn']);
                //update new address
                $this->person->save_person_address($data['hn'], $data['address']);
            //}
            //remove old insurance
            $this->person->remove_person_insurance($data['hn']);
            $this->person->save_insurance($data['hn'], $data['ins']);

            return TRUE;

        }else{
            return FALSE;
        }
    }

    /**
     * Get person list
     *
     * @internal    param   string  $house_code     The House code
     * @return      Mixed
     */
    public function get_person_list(){
        $house_code = $this->input->post('house_code');
        if(empty($house_code)){
            $json = '{"success": false, "msg": "No house id defined"}';
        }else{
            //get person list
            $result = $this->person->get_person_list($house_code);
            if($result){
                $arr_result = array();
                foreach($result as $r){
                    $obj                = new stdClass();
                    $obj->first_name    = $r['first_name'];
                    $obj->last_name     = $r['last_name'];
                    $obj->birthdate     = to_js_date($r['birthdate']);
                    $obj->sex           = get_sex( (string) $r['sex']);
                    $obj->hn            = $r['hn'];
                    $obj->cid           = $r['cid'];
                    $obj->id            = get_first_object($r['_id']);
                    $obj->age           = count_age( (string)$r['birthdate']);
                    $obj->fstatus       = get_fstatus_name($r['fstatus']);
                    $obj->title         = $this->basic->get_title_name($r['title']);

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);

                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "Model error, please check your data."}';
            }
        }

        render_json($json);
    }

    public function edit($hn = ''){
        if(empty($hn)){
            show_error("No person id found, please check patient id", 404);
        }else{
            //get person detail
            $result = $this->person->detail($hn);
            if($result){
                $obj                    = new stdClass();
                $obj->hn                = $hn;
                $obj->abogroup          = $result['abogroup'];
                $obj->house_code        = $result['house_code'];
                $obj->birthdate         = to_js_date($result['birthdate']);
                $obj->cid               = $result['cid'];
                $obj->couple_cid        = $result['couple_cid'];
                $obj->discharge_date    = to_js_date($result['discharge_date']);
                $obj->discharge_status  = $result['discharge_status'];
                $obj->education         = get_first_object($result['education']);
                $obj->father_cid        = $result['father_cid'];
                $obj->first_name        = $result['first_name'];
                $obj->fstatus           = $result['fstatus'];
                $obj->hn                = $result['hn'];
                $obj->house_code        = get_first_object($result['house_code']);
                $obj->labor_type        = get_first_object($result['labor_type']);
                $obj->last_name         = $result['last_name'];
                $obj->mother_cid        = $result['mother_cid'];
                $obj->movein_date       = to_js_date($result['movein_date']);
                $obj->mstatus           = get_first_object($result['mstatus']);
                $obj->nation            = get_first_object($result['nation']);
                $obj->occupation        = get_first_object($result['occupation']);
                $obj->owner_id          = get_first_object($result['owner_id']);
                $obj->passport          = $result['passport'];
                $obj->race              = get_first_object($result['race']);
                $obj->religion          = get_first_object($result['religion']);
                $obj->rhgroup           = $result['rhgroup'];
                $obj->sex               = $result['sex'];
                $obj->title             = get_first_object($result['title']);
                $obj->typearea          = $result['typearea'];
                $obj->vstatus           = get_first_object($result['vstatus']);

                //insurance
                if(!empty($result['insurances'])){
                    $obj->ins_code          = isset($result['insurances']['code']) ? $result['insurances']['code'] : NULL;
                    $obj->ins_id            = isset($result['insurances']['id']) ? $result['insurances']['id'] : NULL;
                    $obj->ins_expire_date   = to_js_date(isset($result['insurances']['expire_date']) ? $result['insurances']['expire_date'] : NULL);
                    $obj->ins_start_date    = to_js_date(isset($result['insurances']['start_date']) ? $result['insurances']['start_date'] : NULL);
                    $obj->ins_hmain_code    = isset($result['insurances']['hmain']) ? $result['insurances']['hmain'] : NULL;
                    $obj->ins_hmain_name    = get_hospital_name($obj->ins_hmain_code);
                    $obj->ins_hsub_code     = isset($result['insurances']['hsub']) ? $result['insurances']['hsub'] : NULL;
                    $obj->ins_hsub_name     = get_hospital_name($obj->ins_hsub_code);
                }
                //address
                if(!empty($result['address'])){
                    $obj->address_address_type  = isset($result['address']['address_type']) ? $result['address']['address_type'] : NULL;
                    $obj->address_ampur         = isset($result['address']['ampur']) ? $result['address']['ampur'] : NULL;
                    $obj->address_changwat      = isset($result['address']['changwat']) ? $result['address']['changwat'] : NULL;
                    $obj->address_condo         = isset($result['address']['condo']) ? $result['address']['condo'] : NULL;
                    $obj->address_house_id      = isset($result['address']['house_id']) ? $result['address']['house_id'] : NULL;
                    $obj->address_house_type    = isset($result['address']['house_type']) ? $result['address']['house_type'] : NULL;
                    $obj->address_houseno       = isset($result['address']['houseno']) ? $result['address']['houseno'] : NULL;
                    $obj->address_mobile        = isset($result['address']['mobile']) ? $result['address']['mobile'] : NULL;
                    $obj->address_postcode      = isset($result['address']['postcode']) ? $result['address']['postcode'] : NULL;
                    $obj->address_road          = isset($result['address']['road']) ? $result['address']['road'] : NULL;
                    $obj->address_room_no       = isset($result['address']['room_no']) ? $result['address']['room_no'] : NULL;
                    $obj->address_soi_main      = isset($result['address']['soi_main']) ? $result['address']['soi_main'] : NULL;
                    $obj->address_soi_sub       = isset($result['address']['soi_sub']) ? $result['address']['soi_sub'] : NULL;
                    $obj->address_tambon        = isset($result['address']['tambon']) ? $result['address']['tambon'] : NULL;
                    $obj->address_telephone     = isset($result['address']['telephone']) ? $result['address']['telephone'] : NULL;
                    $obj->address_village       = isset($result['address']['village']) ? $result['address']['village'] : NULL;
                    $obj->address_village_name  = isset($result['address']['village_name']) ? $result['address']['village_name'] : NULL;

                    $ampurs     = !empty($obj->address_ampur) ? $this->basic->get_ampur($obj->address_changwat) : NULL;
                    $tambons    = !empty($obj->address_tambon) ? $this->basic->get_tambon($obj->address_changwat, $obj->address_ampur) : NULL;

                    //$this->twiggy->set('amphurs', $ampurs);
                    //$this->twiggy->set('tambons', $tambons);
                    $data['ampurs'] = $ampurs;
                    $data['tambons'] = $tambons;
                }
                $data['chronic_discharge_types'] = $this->basic->get_chronic_discharge_type();
                $data['educations']     = $this->basic->get_education();
                $data['titles']         = $this->basic->get_title();
                $data['inscls']         = $this->basic->get_insurance();
                $data['occupations']    = $this->basic->get_occupation();
                $data['marry_status']   = $this->basic->get_marry_status();
                $data['races']          = $this->basic->get_races();
                $data['nationalities']  = $this->basic->get_nationalities();
                $data['religions']      = $this->basic->get_religions();
                $data['provinces']      = $this->basic->get_province();
                $data['typearea']       = $this->basic->get_typearea();
                $data['labor_types']    = $this->basic->get_labor_type();
                $data['vstatus']        = $this->basic->get_vstatus();
                $data['house_type']     = $this->basic->get_house_type();
                $data['drug_allergy_diag_types']    = $this->basic->get_drug_allergy_diag_type();
                $data['drug_allergy_alevels']       = $this->basic->get_drug_allergy_alevel();
                $data['drug_allergy_symptoms']      = $this->basic->get_drug_allergy_symptom();
                $data['drug_allergy_informants']    = $this->basic->get_drug_allergy_informant();

                $data['data'] = $obj;
                $this->layout->view('person/edit_view', $data);
                //$this->twiggy->template('person/edit')->display();
            }else{
                show_error('Database error, please check your data/parameters and try again.');
            }
        }
    }

    public function save_drug_allergy(){

        $data = $this->input->post('data');

        if(empty($data)){
            $json = '{"success": false, "msg": "No data for save."}';
        }else{

            //if is update
            if($data['isupdate']){
                //do update
                $result = $this->person->update_drug_allergy($data);

                if($result){
                    $json = '{"success": true, "msg": "updated"}';
                }else{
                    $json = '{"success": false, "msg": "Database error, please check your data."}';
                }

            }else{
                //check drug duplicate
                $duplicated = $this->person->check_drug_allergy_duplicate($data['hn'], $data['drug_id']);
                if($duplicated){
                    $json = '{"success": false, "msg": "Drug duplicated, please check drug"}';
                }else{
                    $result = $this->person->save_drug_allergy($data);
                    if($result){
                        $json = '{"success": true, "msg": "inserted"}';
                    }else{
                        $json = '{"success": false, "msg": "Database error, please check your data."}';
                    }
                }
            }
        }

        render_json($json);
    }

    public function get_drug_allergy_list(){
        $hn = $this->input->post('hn');
        if(empty($hn)){
            $json = '{"success": false, "msg": "No person id found."}';
        }else{
            $result = $this->person->get_drug_allergy_list($hn);

            if($result){
                $arr_result = array();

                //echo json_encode($result);
                if(isset($result[0]['allergies'])){
                    foreach($result[0]['allergies'] as $r){
                        $obj = new stdClass();
                        $obj->drug_id = get_first_object($r['drug_id']);
                        $obj->drug_detail = $this->basic->get_drug_detail($obj->drug_id);
                        $obj->record_date = to_js_date($r['record_date']);
                        $obj->diag_type_id = get_first_object($r['diag_type_id']);
                        $obj->diag_type_name = get_drug_allergy_diag_type_name($obj->diag_type_id);
                        $obj->alevel_id = get_first_object($r['alevel_id']);
                        $obj->alevel_name = get_drug_allergy_level_name($obj->alevel_id);
                        $obj->symptom_id = get_first_object($r['symptom_id']);
                        $obj->symptom_name = get_symptom_name($obj->symptom_id);
                        $obj->informant_id = get_first_object($r['informant_id']);
                        $obj->informant_name = get_informant_name($r['informant_id']);
                        $obj->hospcode = $r['hospcode'];
                        $obj->hospname = get_hospital_name($obj->hospcode);

                        $arr_result[] = $obj;
                    }

                    $rows = json_encode($arr_result);
                    $json = '{"success": true, "rows": '.$rows.'}';
                }else{
                    $json = '{"success": false, "msg": "No result found"}';
                }

            }else{
                $json = '{"success": false, "msg": "No result found."';
            }
        }

        render_json($json);
    }
/*
    public function get_drug_allergy_detail(){

        $drug_id = $this->input->post('drug_id');
        $person_id = $this->input->post('person_id');

        if(empty($drug_id)){
            $json = '{"success": false, "msg": "No id found."}';
        }else{
            $drugallergy = $this->person->get_drug_allergy_detail($person_id, $drug_id);

            //echo var_dump($result);

            $result = get_drug_allergy_in_array($drugallergy, $drug_id);
            $obj = new stdClass();

            $obj->record_date = to_js_date($result['record_date']);
            $obj->drug_id = get_first_object($result['drug_id']);
            $obj->drug_name = get_drug_name($obj->drug_id);
            $obj->diag_type_id = get_first_object($result['diag_type_id']);
            $obj->alevel_id = get_first_object($result['alevel_id']);
            $obj->symptom_id = get_first_object($result['symptom_id']);
            $obj->informant_id = get_first_object($result['informant_id']);
            $obj->informhosp = $result['informhosp'];
            $obj->informhosp_name = get_hospital_name($obj->informhosp);

            $rows = json_encode($obj);

            $json = '{"success": true, "rows": '.$rows.'}';
        }

        render_json($json);
    }
*/
    public function get_drug_allergy_detail(){

        $drug_id = $this->input->post('drug_id');
        $hn = $this->input->post('hn');

        if(empty($drug_id)){
            $json = '{"success": false, "msg": "No id found."}';
        }else{
            $drugallergy = $this->person->get_drug_allergy_detail($hn, $drug_id);

            //echo var_dump($result);

            $result = get_drug_allergy_in_array($drugallergy, $drug_id);
            $obj = new stdClass();

            $record_date = isset($result['record_date']) ? $result['record_date'] : NULL;
            $obj->record_date = to_js_date($record_date);

            $drug_id = isset($result['drug_id']) ? get_first_object($result['drug_id']) : NULL;
            $obj->drug_id = $drug_id;
            $obj->drug_name = get_drug_name($drug_id);

            $diag_type_id = isset($result['diag_type_id']) ? get_first_object($result['diag_type_id']) : NULL;
            $obj->diag_type_id = $diag_type_id;

            $alevel_id = isset($result['alevel_id']) ? get_first_object($result['alevel_id']) : NULL;
            $obj->alevel_id = $alevel_id;

            $symptom_id = isset($result['symptom_id']) ? get_first_object($result['symptom_id']) : NULL;
            $obj->symptom_id = $symptom_id;

            $informant_id = isset($result['informant_id']) ? get_first_object($result['informant_id']) : NULL;
            $obj->informant_id = $informant_id;

            $hospcode = isset($result['hospcode']) ? $result['hospcode'] : NULL;
            $obj->hospcode = $hospcode;
            $obj->hospname = get_hospital_name($hospcode);

            $rows = json_encode($obj);

            $json = '{"success": true, "rows": '.$rows.'}';
        }

        render_json($json);
    }
    public function remove_drug_allergy(){
        $hn = $this->input->post('hn');
        $drug_id = $this->input->post('drug_id');

        if(empty($hn)){
            $json = '{"success": false, "msg": "No person id found."}';
        }else if(empty($drug_id)){
            $json = '{"success": false, "msg": "No drug id found."}';
        }else{
            $result = $this->person->remove_drug_allergy($hn, $drug_id);

            if($result){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\' remove drug allergy."}';
            }
        }

        render_json($json);
    }

    public function remove_chronic(){
        $hn = $this->input->post('hn');
        $chronic_code = $this->input->post('code');

        if(empty($hn)){
            $json = '{"success": false, "msg": "No person id found."}';
        }else if(empty($chronic_code)){
            $json = '{"success": false, "msg": "No chronic code found."}';
        }else{
            $result = $this->person->remove_chronic($hn, $chronic_code);

            if($result){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\' remove chronic."}';
            }
        }

        render_json($json);
    }

    public function save_chronic(){
        $data = $this->input->post('data');

        if(empty($data['isupdate'])){
            //check duplicate
            $duplicate = $this->person->check_chronic_duplicate($data['hn'], $data['chronic']);
            if($duplicate){
                $json = '{"success": false, "msg": "Chronic duplicated, please use new chronic code."}';
            }else{
                //inserted
                $result = $this->person->save_chronic($data);
                if($result){
                    $json = '{"success": true}';
                }else{
                    $json = '{"success": false}';
                }
            }

        }else{
            //update
            $result = $this->person->update_chronic($data);
            if($result){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false}';
            }
        }

        render_json($json);
    }

    public function get_chronic_list(){
        $hn = $this->input->post('hn');
        if(empty($hn)){
            $json = '{"success": false, "msg": "No person id found."}';
        }else{
            $rs = $this->person->get_chronic_list($hn);
            if($rs){
                $arr_result = array();

                //echo json_encode($result);
                if(isset($rs[0]['chronics'])){
                    foreach($rs[0]['chronics'] as $r){
                        $obj = new stdClass();
                        $obj->diag_date = to_js_date($r['diag_date']);
                        $obj->chronic = $r['chronic'];
                        $obj->chronic_name = get_diag_name($obj->chronic);
                        $obj->discharge_date = to_js_date($r['discharge_date']);
                        $obj->discharge_type = get_first_object($r['discharge_type']);
                        $obj->discharge_type_name = get_chronic_discharge_type_name($obj->discharge_type);
                        $obj->hosp_dx_code = $r['hosp_dx'];
                        $obj->hosp_rx_code = $r['hosp_rx'];
                        $obj->hosp_dx_name = get_hospital_name($obj->hosp_dx_code);
                        $obj->hosp_rx_name = get_hospital_name($obj->hosp_rx_code);

                        $arr_result[] = $obj;
                    }

                    $rows = json_encode($arr_result);
                    $json = '{"success": true, "rows": '.$rows.'}';
                }else{
                    $json = '{"success": false, "msg": "No result found"}';
                }

            }else{
                $json = '{"success": false, "msg": "No result found."';
            }
        }

        render_json($json);

    }
    
    public function auto_gen_hn()
    {
    	$person = $this->person->get_all_person();

    	foreach($person as $r)
    	{
    		$hn = generate_serial('HN');
    		$this->person->set_hn(get_first_object($r['_id']), $hn);
    	}
    }

    public function search_person_ajax(){
        $query = $this->input->post('query');

        if(!empty($query))
        {

            if(is_numeric($query))
            {
                //search by code
                $rs = $this->person->search_person_ajax_by_hn($query);
            }
            else
            {
                //search by name
                $fullname = explode(' ', $query);
                $first_name = $fullname[0];
                $last_name = isset($fullname[1]) ? $fullname[1] : ' ';

                $rs = $this->person->search_person_ajax_by_name($first_name, $last_name);
            }

            if($rs)
            {
                $arr_result = array();
                foreach ($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->name = $r['hn'] . '#' . $r['first_name'] . ' ' . $r['last_name'] . '#' . to_js_date($r['birthdate']);

                    $arr_result[] = $obj;
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';

            }
            else
            {
                $json = '{"success": false, "msg": "No data."}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "Query empty."}';
        }

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

    public function save_village_survey()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            $this->person->user_id = $this->user_id;
            $rs = $this->person->save_village_survey($data);

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
            $json = '{"success": false, "msg": "ไม่พบข้อมุลที่ต้องการบันทึก"}';
        }

        render_json($json);
    }
}

//End of file