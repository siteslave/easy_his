<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Services controller
 *
 * @package     Controllers
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Services extends CI_Controller
{
    var $provider_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->provider_id = $this->session->userdata('provider_id');

        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');

        $this->load->helper('person');

        //$this->csrf_token = $this->security->get_csrf_hash();

        //$this->twiggy->set('site_url', site_url());
        //$this->twiggy->set('base_url', base_url());
        //$this->twiggy->set('csrf_token', $this->csrf_token);

        //$this->twiggy->set('fullname', $this->session->userdata('fullname'));

    }

    public function index()
    {
        $doctor_rooms = $this->basic->get_doctor_room();
        $clinics = $this->basic->get_clinic();
        $inscls = $this->basic->get_insurance();

        //$this->twiggy->set('doctor_rooms', $doctor_rooms);
        //$this->twiggy->set('clinics', $clinics);
        //$this->twiggy->set('inscls', $inscls);
        $data['doctor_rooms'] = $doctor_rooms;
        $data['clinics'] = $clinics;
        $data['inscls'] = $inscls;
        $this->layout->view('services/index_view', $data);
        //$this->twiggy->template('services/index')->display();
    }
    public function entries($vn = '')
    {
        if(empty($vn) || !isset($vn)){
            show_error('No vn found.', 404);
        }else if(!$this->service->check_visit_exist($vn)){
            show_error('VN don\'t exist, please check visit number and try again.', 404);
        }else{
            $person_id = $this->service->get_person_id($vn);
            $person = $this->person->get_person_detail($person_id);

            $hn = $person['hn'];
            $cid = $person['cid'];
            $sex = $person['sex'];

            $patient_name = $person['first_name'] . ' ' . $person['last_name'];

            $drug_allergy_diag_types    = $this->basic->get_drug_allergy_diag_type();
            $drug_allergy_alevels       = $this->basic->get_drug_allergy_alevel();
            $drug_allergy_symptoms      = $this->basic->get_drug_allergy_symptom();
            $drug_allergy_informants    = $this->basic->get_drug_allergy_informant();
            $drinkings                  = $this->basic->get_drinking();
            $smokings                  = $this->basic->get_smoking();

            $diag_types                 = $this->basic->get_diag_type();

            $data['drug_allergy_informants'] = $drug_allergy_informants;
            $data['drug_allergy_symptoms'] = $drug_allergy_symptoms;
            $data['drug_allergy_alevels'] = $drug_allergy_alevels;
            $data['drug_allergy_diag_types'] = $drug_allergy_diag_types;
            $data['drinkings'] = $drinkings;
            $data['smokings'] = $smokings;
            $data['diag_types'] = $diag_types;

            $data['hn'] = $hn;
            $data['person_id'] = $person_id;
            $data['cid'] =$cid;
            $data['vn'] = $vn;
            $data['sex'] = $sex;

            $data['patient_name'] = $patient_name;
            $this->layout->view('services/entries_view', $data);
            //$this->twiggy->template('services/entries')->display();
        }

    }

    public function search_person(){
        $query = $this->input->post('query');
        $op = $this->input->post('op');

        if(empty($query)){
            $json = '{"success": false, "msg": "No query."}';
        }else{
            if($op == 'hn'){
                $rs = $this->service->search_person_by_hn($query);
            }else if($op == 'cid'){
                $rs = $this->service->search_person_by_cid($query);
            }else{
                $rs = $this->service->search_person_by_name($query);
            }

            if($rs){
                $arr_result = array();
                foreach($rs as $r){
                    $obj = new stdClass();
                    $obj->id = get_first_object($r['_id']);
                    $obj->fullname = $r['first_name'] . ' ' . $r['last_name'];
                    $obj->cid = $r['cid'];
                    $obj->hn = $r['hn'];
                    $obj->birthdate = to_js_date($r['birthdate']);
                    $obj->sex = $r['sex'];
                    $obj->address = get_address($obj->hn);

                    array_push($arr_result, $obj);
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "No result."}';
            }
        }

        render_json($json);
    }

    public function get_person_detail(){
        $hn = $this->input->post('hn');
        if(empty($hn)){
            $json = '{"success": false, "msg": "No hn found."}';
        }else{
            $rs = $this->service->get_person_detail($hn);
            if($rs){
                $obj = new stdClass();
                $obj->fullname = $rs['first_name'] . ' ' . $rs['last_name'];
                $obj->birthdate = to_js_date($rs['birthdate']);
                $obj->sex = $rs['sex'];
                $obj->cid = $rs['cid'];
                $obj->hn = $rs['hn'];
                $obj->address = get_address($rs['house_code']);
                $rows = json_encode($obj);

                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "No result."}';
            }
        }

        render_json($json);
    }

    public function do_register(){

        $data = $this->input->post('data');
        if(empty($data)){
            $json = '{"success": false, "msg": "No data for save."}';
        }else{

            $this->service->owner_id = $this->owner_id;
            $this->service->user_id = $this->user_id;

            if(empty($data['vn'])){
                //insert
                $data['vn'] = generate_serial('VN');
                $rs = $this->service->do_register($data);
            }else{
                //update
                $rs = $this->service->do_update($data);
            }
            //check result
            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t save data."}';
            }
        }

        render_json($json);
    }

    public function get_list(){
        $offset = $this->input->post('offset');
        $limit = $this->input->post('limit');

        $offset = empty($offset) ? 0 : $offset;
        $limit = empty($limit) ? 25 : $limit;

        $by = $this->input->post('by');
        /*
         * Query by
         * 1 = by diagnosis
         * 2 = by clinic
         * defaul by date
         */
        if($by == '1'){
            /*
             * 1 = no diagnosis
             * 2 = diagnosised
             */
            $diag_status = $this->input->post('diag_status');
            $rs = $this->service->get_list_by_diag_status($diag_status, $offset, $limit);

        }else if($by == '2'){
            $clinic = $this->input->post('clinic');
            $rs = $this->service->get_list_by_clinic($clinic, $offset, $limit);

        }else{
            $date = $this->input->post('date');

            if(empty($date)){
                $date = to_string_date(date('d/m/Y'));
            }

            $rs = $this->service->get_list_by_date($date, $offset, $limit);
        }

        if($rs){
            $arr_result = array();

            foreach($rs as $r){

                $obj = new stdClass();

                $obj->vn = isset($r['vn']) ? $r['vn'] : '-';
                $obj->person_id = isset($r['person_id']) ? get_first_object($r['person_id']) : null;

                $person_detail = get_person_detail(get_first_object($r['person_id']));

                if($person_detail){
                    $obj->hn = $person_detail['hn'];
                    $obj->cid = $person_detail['cid'];
                    $obj->fullname = $person_detail['first_name'] . ' ' . $person_detail['last_name'];
                    $obj->birthdate = to_js_date($person_detail['birthdate']);
                }else{
                    $obj->cid = '-';
                    $obj->fullname = '-';
                    $obj->birthdate = '-';
                }

                $obj->clinic_name = get_clinic_name(get_first_object($r['clinic']));

                if(isset($r['insurances'])){
                    $obj->insurance_name = get_insurance_name($r['insurances']['id']);
                    $obj->insurance_id = $r['insurances']['id'];
                    $obj->insurance_code = $r['insurances']['code'];
                }else{
                    $obj->insurance_name = '-';
                    $obj->insurance_id = '-';
                    $obj->insurance_code = '-';
                }

                $screenings = $this->service->get_service_screening($r['vn']);
                //echo var_dump($screenings);
                $obj->cc = isset($screenings) ? $screenings['cc'] : '-';

                array_push($arr_result, $obj);
            }

            //echo var_dump($rs);

            $rows = json_encode($arr_result);
            $json = '{"success": true, "rows": '.$rows.'}';
        }else{
            $json = '{"success": false, "msg": "No result."}';
        }

        render_json($json);

    }

    public function save_screening(){

        $data = $this->input->post('data');

        if(empty($data)){
            $json = '{"success": false, "msg": "No data for save, please check you data and try again."}';
        }else{

            $rs = $this->service->save_screening($data);
            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t save screening data, please try again."}';
            }
        }

        render_json($json);
    }

    public function get_screening(){

        $vn = $this->input->post('vn');
        if(empty($vn)){
            $json = '{"success": false, "msg": "No vn found"}';
        }else{
            $rs = $this->service->get_screening($vn);

            $rows = json_encode($rs);

            $json = '{"success": true, "rows": '.$rows.'}';
        }

        render_json($json);
    }

    public function save_screening_allergy(){
        $data = $this->input->post('data');

        if(empty($data)){
            $json = '{"success": false, "msg": "No data for save."}';
        }else{

            $this->person->user_id = $this->user_id;

            //if is update
            if(!empty($data['isupdate'])){
                //do update
                $result = $this->person->update_drug_allergy($data);

                if($result){
                    $json = '{"success": true, "msg": "updated"}';
                }else{
                    $json = '{"success": false, "msg": "Database error, please check your data."}';
                }

            }else{
                //check drug duplicate
                $duplicated = $this->person->check_drug_allergy_duplicate($data['person_id'], $data['drug_id']);
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

    public function get_screening_allergy_list(){
        $person_id = $this->input->post('person_id');
        if(empty($person_id)){
            $json = '{"success": false, "msg": "No person id found."}';
        }else{
            $result = $this->person->get_drug_allergy_list($person_id);

            if($result){
                $arr_result = array();

                //echo json_encode($result);
                if(isset($result[0]['allergies'])){
                    foreach($result[0]['allergies'] as $r){
                        $obj = new stdClass();

                        $drug_id = isset($r['drug_id']) ? $r['drug_id'] : NULL;
                        $obj->drug_id = get_first_object($drug_id);
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
                        $obj->hospname = get_hospital_name($r['hospcode']);
                        $obj->hospcode = $r['hospcode'];
                        $obj->user_fullname = get_user_fullname(get_first_object($r['user_id']));

                        array_push($arr_result, $obj);
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

    public function remove_screening_allergy(){
        $person_id = $this->input->post('person_id');
        $drug_id = $this->input->post('drug_id');

        if(empty($person_id) || empty($drug_id)){
            $json = '{"success": false, "msg": "No person id or drug id, please check your data and try again."}';
        }else{
            $rs = $this->person->remove_drug_allergy($person_id, $drug_id);

            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t remove allergy item, please try again."}';
            }
        }

        render_json($json);
    }

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

    //save diag
    public function save_diag_opd(){
        $data = $this->input->post('data');
        if(empty($data)){
            $json = '{"success": false, "msg": "No data for save, please check your data and try again."}';
        }else{
            $ok = TRUE;
            $msg = NULL;

            if($data['diag_type'] == '1'){
                //check priciple diag exist
                $principle_exist = $this->service->check_principle_opd_exist($data['vn']);
                if($principle_exist){
                    $ok = FALSE;
                    $msg = 'Principle diagnosis is ready exist.';
                }else{
                    $ok = TRUE;
                    $msg = '';
                }
            }else{
                $principle_exist = $this->service->check_principle_opd_exist($data['vn']);
                if(!$principle_exist){
                    $ok = FALSE;
                    $msg = 'No principle diagnosis please set diagnosis type to 1 [Principle dx.]';
                }else{
                    //check diag code exist
                    $diag_exist = $this->service->check_diag_opd_exist($data['vn'], $data['code']);

                    if($diag_exist){
                        $ok = FALSE;
                        $msg = 'This diagnosis is ready exist, please use another diagnosis.';
                    }else{
                        $ok = TRUE;
                        $msg = '';
                    }
                }

            }

            if($ok){
                //save
                $rs = $this->service->save_diag_opd($data);
                if($rs){
                    $json = '{"success": true}';
                }else{
                    $json = '{"success": false, "msg": "Can\'t save diagnosis, please check your data and try again."}';
                }
            }else{
                $json = '{"success": false, "msg": "'.$msg.'"}';
            }
        }

        render_json($json);
    }

    //get service opd diagnosis
    public function get_service_diag_opd(){
        $vn = $this->input->post('vn');
        if(empty($vn)){
            $json = '{"success": false, "msg": "No vn found."}';
        }else{
            $rs = $this->service->get_service_diag_opd($vn);
            if($rs){
                $arr_result = array();

                foreach ($rs as $r) {
                    $obj = new stdClass();
                    $obj->code = $r['code'];
                    $obj->diag_type = $r['diag_type'];
                    $obj->diag_name = get_diag_name($obj->code);
                    $obj->diag_type_name = get_diag_type_name($obj->diag_type);

                    array_push($arr_result, $obj);

                }

                $rows = json_encode($arr_result);

                $json = '{"success": true, "rows": '.$rows.'}';

            }else{
                $json = '{"success": false, "msg": "No diagnosis found."}';
            }
        }

        render_json($json);
    }

    public function remove_diag_opd(){
        $vn = $this->input->post('vn');
        $diag_code = $this->input->post('diag_code');

        if(empty($vn)){
            $json = '{"success": false, "msg": "No vn found."}';
        }else if(empty($diag_code)){
            $json = '{"success": false, "msg": "No diagnosis found."}';
        }else{

            $rs = $this->service->remove_diag_opd($vn, $diag_code);
            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t remove diagnosis, please try again."}';
            }
        }

        render_json($json);
    }

    public function save_proced_opd(){
        $data = $this->input->post('data');
        if(empty($data)){
            $json = '{"success": false, "msg": "No data for save"}';
        }else if($data['isupdate'] == '1'){
            //update
            $rs = $this->service->update_opd_proced($data);
            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t update procedure, please check your data and try again."}';
            }
        }else{
            //check duplicate
            $duplicated = $this->service->check_duplicate_opd_proced($data['vn'], $data['code']);
            if($duplicated){
                $json = '{"success": false, "msg": "Duplicate proced code, please use another code."}';
            }else{
                $rs = $this->service->save_proced_opd($data);
                if($rs){
                    $json = '{"success": true}';
                }else{
                    $json = '{"success": false, "msg": "Can\'t save procedure, please check your data and try again."}';
                }
            }
        }

        render_json($json);
    }

    public function get_service_proced_opd(){
        $vn = $this->input->post('vn');

        if(empty($vn)){
            $json = '{"success": false, "msg": "No vn number found."}';
        }else{
            $rs = $this->service->get_service_proced_opd($vn);
            if($rs){
                $arr_result = array();
                foreach($rs as $r){
                    $obj = new stdClass();
                    $obj->code = $r['code'];
                    $obj->proced_name = get_procedure_name($obj->code);
                    $obj->price = $r['price'];
                    $obj->provider = $r['provider'];
                    $obj->provider_name = get_provider_name($obj->provider);

                    array_push($arr_result, $obj);
                }

                $rows = json_encode($arr_result);

                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "Can\'t save procedure, please check your data and try again."}';
            }
        }

        render_json($json);
    }


    public function remove_proced_opd(){
        $vn = $this->input->post('vn');
        $code = $this->input->post('code');

        if(empty($vn)){
            $json = '{"success": false, "msg": "No vn found."}';
        }else if(empty($code)){
            $json = '{"success": false, "msg": "No procedure code found."}';
        }else{

            $rs = $this->service->remove_proced_opd($vn, $code);
            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t remove procedure, please try again."}';
            }
        }

        render_json($json);
    }

    ########### Drug module #########

    /*
     * Save drug
     */
    public function save_drug_opd(){
        $data = $this->input->post('data');
        if(empty($data)){
            $json = '{"success": false, "msg": "No data for save."}';
        }else if(empty($data['drug_id'])){
            $json = '{"success": false, "msg": "No drug id found."}';
        }else if(!$this->service->check_visit_exist($data['vn'])){
           $json = '{"success": false, "msg": "No visit found."}';
        }else if($data['isupdate']){
            //do update
            $rs = $this->service->update_drug_opd($data);
            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t update data"}';
            }
        }else{

            //check drug duplicate
            $duplicated = $this->service->check_drug_duplicate($data['vn'], $data['drug_id']);
            if($duplicated){
                //do save
                $data['provider_id'] = $this->provider_id;
                $rs = $this->service->save_drug_opd($data);

                if($rs){
                    $json = '{"success": true}';
                }else{
                    $json = '{"success": false, "msg": "Can\'t save data"}';
                }
            }else{
                $json = '{"success": false, "msg": "Drug duplicate, please use another."}';
            }
        }

        render_json($json);
    }
    /*
     * Remove drug
     *
     * @param   array   $data
     */
    public function remove_drug_opd(){
        $id = $this->input->post('id');
        if(empty($id)){
            $json = '{"success": false, "msg": "NO data found"}';
        }else{
            //$rs = $this->service->remove_drug
        }
    }
    /*
     * Get drug list
     */
    public function get_drug_list(){
        $vn = $this->input->post('vn');
        if(!empty($vn)){
            $rs = $this->service->get_drug_list($vn);
            if($rs){
                $arr_result = array();
                foreach($rs as $r){
                    $obj = new stdClass();
                    $obj->id = get_first_object($r['_id']);
                    $obj->drug_id = get_first_object($r['drug_id']);
                    $obj->drug_name = get_drug_name($obj->drug_id);
                    $obj->usage_id = get_first_object($r['usage_id']);
                    $obj->usage_name = get_usage_name($obj->usage_id);
                    $obj->price = $r['price'];
                    $obj->qty = $r['qty'];

                    array_push($arr_result, $obj);

                    $rows = json_encode($arr_result);
                    $json = '{"success": true, "rows": '.$rows.'}';
                }
            }else{
                $json = '{"success": false, "msg": "Can\'t get drug list."}';
            }
        }else{
            $json = '{"success": false, "msg": "No vn found."}';
        }

        render_json($json);
    }
}

/* End of file services.php */
/* Location: ./controllers/services.php */