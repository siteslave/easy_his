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
    protected $provider_id;
    protected $user_id;
    protected $owner_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');
        $this->load->model('Drug_model', 'drug');
        $this->load->model('Appoint_model', 'appoint');
        $this->load->model('Accident_model', 'accident');
        $this->load->model('Income_model', 'income');

        $this->load->helper('person');

        $this->accident->user_id    = $this->user_id;
        $this->accident->provider_id= $this->provider_id;
        $this->accident->owner_id   = $this->owner_id;

        $this->income->owner_id     = $this->owner_id;

        $this->service->owner_id    = $this->owner_id;
        $this->service->user_id     = $this->user_id;
        $this->service->provider_id = $this->provider_id;
        $this->basic->owner_id      = $this->owner_id;
        $this->drug->owner_id       = $this->owner_id;

    }

    public function index()
    {
        $doctor_rooms           = $this->basic->get_doctor_room();
        $clinics                = $this->basic->get_clinic();
        $inscls                 = $this->basic->get_inscl();

        $data['doctor_rooms']   = $doctor_rooms;
        $data['clinics']        = $clinics;
        $data['inscls']         = $inscls;

        $this->layout->view('services/index_view', $data);
    }
    public function entries($vn = '')
    {

        $this->load->model('Diabetes_model', 'dm');

        $this->dm->clinic_code  = '01';
        $this->dm->owner_id     = $this->owner_id;

        if(empty($vn) || !isset($vn))
        {
            show_error('No vn found.', 404);
        }
        else if(!$this->service->check_visit_exist($vn))
        {
            show_error('VN don\'t exist, please check visit number and try again.', 404);
        }
        else if(!$this->service->check_owner($vn ,$this->owner_id))
        {
            show_error('Invalid owner.');
        }
        else
        {
            $hn         = $this->service->get_person_hn($vn);
            $person     = $this->person->get_person_detail_with_hn($hn);

            $cid    = $person['cid'];
            $sex    = $person['sex'];

            $patient_name = $person['first_name'] . ' ' . $person['last_name'];

            $drinkings                  = $this->basic->get_drinking();
            $smokings                   = $this->basic->get_smoking();

            $diag_types                 = $this->basic->get_diag_type();

            $lab_groups                 = $this->basic->get_lab_groups_list();

            $data['is_dm']              = $this->dm->is_registered($hn);

            $data['drinkings']  = $drinkings;
            $data['smokings']   = $smokings;
            $data['diag_types'] = $diag_types;

            $data['dental_charge_items'] = $this->income->get_dental_list();

            $data['hn']         = $hn;
            //$data['person_id']  = $person_id;
            $data['cid']        =$cid;
            $data['vn']         = $vn;
            $data['sex']        = $sex;
            $data['lab_groups'] = $lab_groups;


            $data['disabilities_types'] = $this->basic->get_disabilities_list();
            $data['icf_qualifiers']     = $this->basic->get_icf_qualifiers();
            $data['patient_name']       = $patient_name;
            $data['providers']          = $this->basic->get_providers();

            //accident

            $data['aetypes']    = $this->basic->get_aetype();
            $data['aeplaces']   = $this->basic->get_aeplace();
            $data['aetypeins']  = $this->basic->get_aetypein();
            $data['aetraffics'] = $this->basic->get_aetraffic();
            $data['aevehicles'] = $this->basic->get_aevehicle();

            $this->layout->view('services/entries_view', $data);
        }

    }

    public function search_person()
    {
        $query  = $this->input->post('query');
        $op     = $this->input->post('op');

        if(empty($query))
        {
            $json = '{"success": false, "msg": "No query."}';
        }
        else
        {
            if($op == 'hn')
            {
                $rs = $this->service->search_person_by_hn($query);
            }
            else if($op == 'cid')
            {
                $rs = $this->service->search_person_by_cid($query);
            }
            else
            {
                $rs = $this->service->search_person_by_name($query);
            }

            if($rs)
            {
                $arr_result = array();
                foreach($rs as $r)
                {
                    $obj            = new stdClass();
                    $obj->id        = get_first_object($r['_id']);
                    $obj->fullname  = $r['first_name'] . ' ' . $r['last_name'];
                    $obj->cid       = $r['cid'];
                    $obj->hn        = $r['hn'];
                    $obj->birthdate = to_js_date($r['birthdate']);
                    $obj->sex       = $r['sex'];
                    $obj->address   = get_address($obj->hn);
                    
                    $arr_result[]   = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบรายการ."}';
            }
        }

        render_json($json);
    }

    public function get_person_detail()
    {
        $hn = $this->input->post('hn');
        if(empty($hn)){
            $json = '{"success": false, "msg": "ไม่พบ HN."}';
        }else{
            $rs = $this->service->get_person_detail($hn);
            if($rs){
                $obj            = new stdClass();
                $obj->fullname  = $rs['first_name'] . ' ' . $rs['last_name'];
                $obj->birthdate = to_js_date($rs['birthdate']);
                $obj->sex       = $rs['sex'];
                $obj->cid       = $rs['cid'];
                $obj->hn        = $rs['hn'];
                $obj->address   = get_address($rs['house_code']);
                
                $rows           = json_encode($obj);

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
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก."}';
        }else{

            if(empty($data['vn'])){
                //insert
                $data['vn'] = generate_serial('VN');
                $rs         = $this->service->do_register($data);
            }else{
                //update
                $rs         = $this->service->do_update($data);
            }

            if(!empty($data['appoint_id']))
            {
                $this->appoint->update_status($data);
            }
            //check result
            if($rs){
                $json = '{"success": true, "vn": "'.$data['vn'].'"}';
            }else{
                $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้."}';
            }
        }

        render_json($json);
    }

    public function get_list(){
        $start          = $this->input->post('start');
        $stop           = $this->input->post('stop');
        $date           = $this->input->post('date');
        $doctor_room    = $this->input->post('doctor_room');

        $date           = empty($date) ? date('Ymd') : to_string_date($date);

        $start          = empty($start) ? 0 : $start;
        $stop           = empty($stop) ? 25 : $stop;
        $limit          = (int) $stop - (int) $start;
        
        $rs             = $this->service->get_list($date, $doctor_room, $start, $limit);

        if($rs){
            $arr_result = array();

            foreach($rs as $r){

                $obj = new stdClass();

                $obj->vn        = isset($r['vn']) ? $r['vn'] : '-';
                $obj->person_id = isset($r['person_id']) ? get_first_object($r['person_id']) : null;

                $person_detail  = get_person_detail_with_hn($r['hn']);

                $obj->diag          = $this->service->get_visit_pdx($obj->vn);
                $obj->diag_name     = get_diag_name($obj->diag);
                $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));

                if($person_detail){
                    $obj->hn        = $person_detail['hn'];
                    $obj->cid       = $person_detail['cid'];
                    $obj->fullname  = $person_detail['first_name'] . ' ' . $person_detail['last_name'];
                    $obj->birthdate = to_js_date($person_detail['birthdate']);
                }else{
                    $obj->cid       = '-';
                    $obj->fullname  = '-';
                    $obj->birthdate = '-';
                }

                $obj->clinic_name = get_clinic_name(get_first_object($r['clinic']));

                if(isset($r['insurances'])){
                    $obj->insurance_name    = get_insurance_name($r['insurances']['id']);
                    $obj->insurance_id      = $r['insurances']['id'];
                    $obj->insurance_code    = $r['insurances']['code'];
                }else{
                    $obj->insurance_name    = '-';
                    $obj->insurance_id      = '-';
                    $obj->insurance_code    = '-';
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
            $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
        }

        render_json($json);

    }

    public function get_list_search(){
        $start  = $this->input->post('start');
        $stop   = $this->input->post('stop');
        $hn     = $this->input->post('hn');

        $start  = empty($start) ? 0 : $start;
        $stop   = empty($stop) ? 25 : $stop;
        $limit  = (int) $stop - (int) $start;

        $rs = $this->service->get_list_search($hn, $start, $limit);

        if($rs){
            $arr_result = array();

            foreach($rs as $r){

                $obj = new stdClass();

                $obj->vn        = isset($r['vn']) ? $r['vn'] : '-';
                $obj->person_id = isset($r['person_id']) ? get_first_object($r['person_id']) : null;

                $person_detail  = get_person_detail_with_hn($r['hn']);

                $obj->diag      = $this->service->get_visit_pdx($obj->vn);
                $obj->diag_name = get_diag_name($obj->diag);
                $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));

                if($person_detail){
                    $obj->hn        = $person_detail['hn'];
                    $obj->cid       = $person_detail['cid'];
                    $obj->fullname  = $person_detail['first_name'] . ' ' . $person_detail['last_name'];
                    $obj->birthdate = to_js_date($person_detail['birthdate']);
                }else{
                    $obj->cid       = '-';
                    $obj->fullname  = '-';
                    $obj->birthdate = '-';
                }

                $obj->clinic_name = get_clinic_name(get_first_object($r['clinic']));

                if(isset($r['insurances'])){
                    $obj->insurance_name = get_insurance_name($r['insurances']['id']);
                    $obj->insurance_id      = $r['insurances']['id'];
                    $obj->insurance_code    = $r['insurances']['code'];
                }else{
                    $obj->insurance_name    = '-';
                    $obj->insurance_id      = '-';
                    $obj->insurance_code    = '-';
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
            $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
        }

        render_json($json);

    }

    public function get_list_total()
    {
        $date           = $this->input->post('date');
        $doctor_room    = $this->input->post('doctor_room');

        $date = empty($date) ? date('Ymd') : to_string_date($date);

        $total  = $this->service->get_list_total($date, $doctor_room);
        $json   = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function get_list_search_total()
    {
        $hn     = $this->input->post('hn');
        $total  = $this->service->get_list_search_total($hn);
        $json   = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function save_screening(){

        $data = $this->input->post('data');

        if(empty($data)){
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }else{

            $rs = $this->service->save_screening($data);
            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
            }
        }

        render_json($json);
    }

    public function get_screening(){

        $vn = $this->input->post('vn');
        if(empty($vn)){
            $json = '{"success": false, "msg": "ไม่พบรหัส VN"}';
        }else{
            $rs     = $this->service->get_screening($vn);

            $rows   = json_encode($rs);

            $json   = '{"success": true, "rows": '.$rows.'}';
        }

        render_json($json);
    }

    public function get_screening_allergy_list(){
        $hn = $this->input->post('hn');
        if(empty($hn)){
            $json = '{"success": false, "msg": "ไม่พบ Person ID"}';
        }else{
            $result = $this->person->get_drug_allergy_list($hn);

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
                    $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
                }

            }else{
                $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
            }
        }

        render_json($json);
    }

    public function remove_screening_allergy(){
        $hn = $this->input->post('hn');
        $drug_id = $this->input->post('drug_id');

        if(empty($hn) || empty($drug_id)){
            $json = '{"success": false, "msg": "No person id or drug id, please check your data and try again."}';
        }else{
            $rs = $this->person->remove_drug_allergy($hn, $drug_id);

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
                    $obj->clinic_name = get_clinic_name(get_first_object($r['clinic']));
                    $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));

                    $arr_result[] = $obj;

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
                $json = '{"success": false, "msg": "ไม่สามารถปรับปรุงรายการได้"}';
            }
        }else{
            //check duplicate
            $duplicated = $this->service->check_duplicate_opd_proced($data['vn'], $data['code']);
            if($duplicated){
                $json = '{"success": false, "msg": "รายการนี้มีอยู่แล้วกรุณาตรวจสอบ"}';
            }else{
                $rs = $this->service->save_proced_opd($data);
                if($rs){
                    $json = '{"success": true}';
                }else{
                    $json = '{"success": false, "msg": "ไม่สามารถบันทึกรายการได้"}';
                }
            }
        }

        render_json($json);
    }


    public function get_service_proced_opd(){
        $vn = $this->input->post('vn');

        if(empty($vn)){
            $json = '{"success": false, "msg": "กรุณาระบุเลขที่รับบริการ (VN)"}';
        }else{
            $rs = $this->service->get_service_proced_opd($vn);
            if($rs){
                $arr_result = array();
                foreach($rs as $r){
                    $obj = new stdClass();
                    $obj->code = $r['code'];
                    $obj->proced_name = get_procedure_name($obj->code);
                    $obj->price = $r['price'];
                    $obj->start_time = isset($r['start_time']) ? $r['start_time'] : NULL;
                    $obj->end_time = isset($r['end_time']) ? $r['end_time'] : NULL;
                    $obj->provider_id = isset($r['provider_id']) ? get_first_object($r['provider_id']) : NULL;
                    $obj->clinic_id = isset($r['clinic_id']) ? get_first_object($r['clinic_id']) : NULL;
                    $obj->clinic_name = get_clinic_name($obj->clinic_id);
                    $obj->provider_name = get_provider_name_by_id($obj->provider_id);

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);

                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
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
    public function save_drug_opd()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "No data for save."}';
        }
        else if(empty($data['drug_id']))
        {
            $json = '{"success": false, "msg": "No drug id found."}';
        }
        else if(!$this->service->check_visit_exist($data['vn']))
        {
           $json = '{"success": false, "msg": "No visit found."}';
        }
        else if($this->person->check_drug_allergy_duplicate($data['hn'], $data['drug_id']))
        {
            $json = '{"success": false, "msg": "ผู้ป่วยแพ้ยานี้ ไม่สามารถสั่งได้ กรุณาตรวจสอบ"}';
        }
        else if($data['isupdate'] == '1')
        {

            //check qty
            //$qty_overload = $this->drug->check_order_qty($data['drug_id'], $data['qty']);
            //if(!$qty_overload)
            //{
            //    $json = '{"success": false, "msg": "จำนวนยาในสต๊อกไม่พอจ่าย กรุณาตรวจสอบ"}';
            //}
            //else
            //{
                //do update
                $rs = $this->service->update_drug_opd($data);

                if($rs)
                {
                    $json = '{"success": true}';
                }
                else
                {
                    $json = '{"success": false, "msg": "ไม่สามารถปรับปรุงข้อมูลได้"}';
                }
           // }

        }
        else
        {
            //check drug duplicate
            $duplicated = $this->service->check_drug_duplicate($data['vn'], $data['drug_id']);
            
            if(!$duplicated)
            {
                //check qty
                $qty_overload = $this->drug->check_order_qty($data['drug_id'], $data['qty']);

                if(!$qty_overload)
                {
                    $json = '{"success": false, "msg": "จำนวนยาในสต๊อกไม่พอจ่าย กรุณาตรวจสอบ"}';
                }
                else
                {
                    $data['provider_id'] = $this->provider_id;
                    $rs = $this->service->save_drug_opd($data);

                    if($rs)
                    {
                        $json = '{"success": true}';
                    }
                    else
                    {
                        $json = '{"success": false, "msg": "Can\'t save data"}';
                    }
                }
            }
            else
            {
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
            $rs = $this->service->remove_drug_opd($id);
            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t save data"}';
            }
        }

        render_json($json);
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
                    $obj->price = isset($r['price']) ? $r['price'] : 0;
                    $obj->qty = isset($r['qty']) ? $r['qty'] : 0;

                    //array_push($arr_result, $obj);
                    $arr_result[] = $obj;
                    
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

    public function remove_bill_drug_opd(){
        $vn = $this->input->post('vn');
        if(empty($vn)){
            $json = '{"success": false, "msg": "No vn found"}';
        }else{
            $rs = $this->service->remove_bill_drug_opd($vn);
            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t remove data"}';
            }
        }

        render_json($json);
    }


    ########### Charge module #########

    /*
     * Save charge
     */
    public function save_charge_opd()
    {
        $data = $this->input->post('data');
        $this->service->owner_id = $this->owner_id;
        
        if(empty($data))
        {
            $json = '{"success": false, "msg": "No data for save."}';
        }
        else if(!$this->service->check_visit_exist($data['vn']))
        {
            $json = '{"success": false, "msg": "No visit found."}';
        }
        else if($data['isupdate'] == '1')
        {
            //do update
            $rs = $this->service->update_charge_opd($data);
            
            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "Can\'t update data"}';
            }
        }
        else
        {
            //check drug duplicate
            $duplicated = $this->service->check_charge_duplicate($data['vn'], $data['charge_id']);
            
            if(!$duplicated)
            {
                //do save
                $data['user_id'] = $this->user_id;
                $rs = $this->service->save_charge_opd($data);

                if($rs)
                {
                    $json = '{"success": true}';
                }
                else
                {
                    $json = '{"success": false, "msg": "Can\'t save data"}';
                }
            }
            else
            {
                $json = '{"success": false, "msg": "Charge duplicate, please use another."}';
            }
        }

        render_json($json);
    }
    /*
     * Remove drug
     *
     * @param   array   $data
     */
    public function remove_charge_opd(){
        $id = $this->input->post('id');
        if(empty($id)){
            $json = '{"success": false, "msg": "No data found"}';
        }else{
            $rs = $this->service->remove_charge_opd($id);
            if($rs){
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t save data"}';
            }
        }

        render_json($json);
    }
    /*
     * Get drug list
     */
    public function get_charge_list(){
        $vn = $this->input->post('vn');
        if(!empty($vn)){
            $rs = $this->service->get_charge_list($vn);
            if($rs){
                $arr_result = array();
                foreach($rs as $r){
                    $obj = new stdClass();
                    $obj->id = get_first_object($r['_id']);
                    $obj->charge_id = isset($r['charge_id']) ? get_first_object($r['charge_id']) : '';
                    $obj->name = get_charge_name($obj->charge_id);
                    $obj->price = $r['price'];
                    $obj->qty = $r['qty'];

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';

            }else{
                $json = '{"success": false, "msg": "Can\'t get charge list."}';
            }
        }else{
            $json = '{"success": false, "msg": "No vn found."}';
        }

        render_json($json);
    }

    public function icf_save()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            //check duplicate
            $is_duplicated = $this->service->icf_check_duplicated($data);
            if($is_duplicated)
            {
                $json = '{"success": false, "msg": "รายการซ้ำ"}';
            }
            else
            {
                $this->service->user_id = $this->user_id;
                $this->service->owner_id = $this->owner_id;
                $this->service->provider_id = $this->provider_id;

                $rs = $this->service->icf_save($data);
                if($rs)
                {
                    $json = '{"success": true}';
                }
                else
                {
                    $json = '{"success": false, "msg": "ไม่สามารถบันทึกรายการได้"}';
                }
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }

        render_json($json);
    }

    public function icf_get_list()
    {

        $vn = $this->input->post('vn');
        if(!empty($vn))
        {
            $rs = $this->service->icf_get_list($vn);
            $arr_result = array();
            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->id = get_first_object($r['_id']);
                $obj->icf = get_first_object($r['icf']);
                $obj->icf_name = $this->basic->get_icf_name($obj->icf);
                $obj->qualifier = get_first_object($r['qualifier']);
                $obj->qualifier_name = $this->basic->get_icf_qualifier_name($obj->qualifier);
                $obj->provider_name = $this->basic->get_provider_name_by_id(get_first_object($r['provider_id']));

                $arr_result[] = $obj;
            }

            $rows = json_encode($arr_result);

            $json = '{"success": true, "rows": '.$rows.'}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบ VN"}';
        }

        render_json($json);
    }
    public function icf_get_history()
    {
        $hn = $this->input->post('hn');
        if(!empty($hn))
        {
            $rs = $this->service->icf_get_history($hn);
            $arr_result = array();
            foreach($rs as $r)
            {
                $obj = new stdClass();

                $visit = $this->service->get_visit_info($r['vn']);
                $obj->clinic_name = get_clinic_name(get_first_object($visit['clinic']));
                $obj->date_serv = from_mongo_to_thai_date($visit['date_serv']);
                $obj->time_serv = $visit['time_serv'];

                $obj->id = get_first_object($r['_id']);
                $obj->disabid = $r['disabid'];
                $obj->icf = get_first_object($r['icf']);
                $obj->icf_name = $this->basic->get_icf_name($obj->icf);
                $obj->qualifier = get_first_object($r['qualifier']);
                $obj->qualifier_name = $this->basic->get_icf_qualifier_name($obj->qualifier);
                $obj->provider_name = $this->basic->get_provider_name_by_id(get_first_object($r['provider_id']));
                $obj->owner_name = $this->basic->get_owner_name(get_first_object($r['owner_id']));

                $arr_result[] = $obj;
            }

            $rows = json_encode($arr_result);

            $json = '{"success": true, "rows": '.$rows.'}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบ HN"}';
        }

        render_json($json);
    }

    public function icf_remove()
    {
        if($this->input->is_ajax_request())
        {
            $id = $this->input->post('id');
            $rs = $this->service->icf_remove($id);

            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }

    }

    /******************************************************************************** Dental module *******************************************************************************/
    public function dental_save()
    {
        $is_ajax = $this->input->is_ajax_request();

        if($is_ajax)
        {
            $data = $this->input->post('data');
            if(!empty($data))
            {
                $is_duplicated = $this->service->dental_check_duplicated($data['vn']);

                $rs = $is_duplicated ? $this->service->dental_update($data) : $this->service->dental_save($data);

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
                $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
            }

            render_json($json);
        }
        else
        {
            show_error('Don\'t ajax.', 404);
        }

    }

    public function dental_detail()
    {
        if($this->input->is_ajax_request())
        {
            $vn = $this->input->post('vn');
            $rs = $this->service->dental_detail($vn);

            if($rs)
            {
                $obj = new stdClass();
                $obj->vn                = $rs['vn'];
                $obj->hn                = $rs['hn'];
                $obj->denttype          = $rs['denttype'];
                $obj->pteeth            = $rs['pteeth'];
                $obj->pcaries           = $rs['pcaries'];
                $obj->pfilling          = $rs['pfilling'];
                $obj->pextract          = $rs['pextract'];
                $obj->dteeth            = $rs['dteeth'];
                $obj->dcaries           = $rs['dcaries'];
                $obj->dfilling          = $rs['dfilling'];
                $obj->dextract          = $rs['dextract'];
                $obj->need_fluoride     = $rs['need_fluoride'];
                $obj->need_scaling      = $rs['need_scaling'];
                $obj->need_sealant      = $rs['need_sealant'];
                $obj->need_pfilling     = $rs['need_pfilling'];
                $obj->need_dfilling     = $rs['need_dfilling'];
                $obj->need_pextract     = $rs['need_pextract'];
                $obj->need_dextract     = $rs['need_dextract'];
                $obj->nprosthesis       = $rs['nprosthesis'];
                $obj->permanent_perma   = $rs['permanent_perma'];
                $obj->permanent_prost   = $rs['permanent_prost'];
                $obj->prosthesis_prost  = $rs['prosthesis_prost'];
                $obj->gum               = $rs['gum'];
                $obj->schooltype        = $rs['schooltype'];
                $obj->school_class      = $rs['school_class'];
                $obj->provider_id       = get_first_object($rs['provider_id']);

                $rows = json_encode($obj);

                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูลการรับบริการ"}';
            }

            render_json($json);
        }
        else
        {
            show_error('No ajax.', 404);
        }

    }

    public function dental_remove()
    {
        if($this->input->is_ajax_request())
        {
            $vn = $this->input->post('vn');
            if(!empty($vn))
            {
                $rs = $this->service->dental_remove($vn);
                if($rs)
                {
                    $json = '{"success": true}';
                }
                else
                {
                    $json = '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
                }

            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบรหัสการรับบริการ (VN)"}';
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }

    }

    public function dental_history()
    {
        $is_ajax = $this->input->is_ajax_request();

        if($is_ajax)
        {
            $hn = $this->input->post('hn');
            $rs = $this->service->dental_history($hn);

            if($rs)
            {
                $arr_result = array();
                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $visit = $this->service->get_visit_info($r['vn']);
                    $obj->clinic_name = get_clinic_name(get_first_object($visit['clinic']));
                    $obj->date_serv = from_mongo_to_thai_date($visit['date_serv']);
                    $obj->time_serv = $visit['time_serv'];
                    $obj->servplace_name = $visit['service_place'] == '1' ? 'ในสถานบริการ' : 'นอกสถานบริการ';

                    $obj->gum = get_gum_name($r['gum']);
                    $obj->denttype = get_denttype_name($r['denttype']);

                    $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                    $obj->owner_name = get_owner_name(get_first_object($r['owner_id']));

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบรายการ"}';
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }
    }

    public function search()
    {
        $is_ajax = $this->input->is_ajax_request();

        if($is_ajax)
        {
            $hn = $this->input->post('hn');

            $rs = $this->service->search_by_hn($hn);


        }
        else
        {
            show_error('Not ajax.', 404);
        }
    }

    public function save_accident()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "No data for save"}';
        }
        else
        {
            //check exist
            $exist = $this->accident->check_exist($data['vn']);
            $rs = $exist ? $rs = $this->accident->update($data) : $this->accident->save($data);
            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "Can\'t save data."}';
        }

        render_json($json);
    }

    public function get_accident_data()
    {
        $vn = $this->input->post('vn');

        if(empty($vn))
        {
            $json = '{"success": false, "msg": "No vn found"}';
        }
        else
        {
            $rs = $this->accident->get_data($vn);
            if($rs)
            {
                $obj = new stdClass();
                $obj->ae_date = to_js_date($rs['ae_date']);
                $obj->ae_time = $rs['ae_time'];
                $obj->ae_urgency = $rs['ae_urgency'];
                $obj->ae_type = get_first_object($rs['ae_type']);
                $obj->ae_place = get_first_object($rs['ae_place']);
                $obj->ae_typein = get_first_object($rs['ae_typein']);
                $obj->ae_traffic = get_first_object($rs['ae_traffic']);
                $obj->ae_vehicle = get_first_object($rs['ae_vehicle']);
                $obj->ae_alcohol = $rs['ae_alcohol'];
                $obj->ae_nacrotic_drug = $rs['ae_nacrotic_drug'];
                $obj->ae_belt = $rs['ae_belt'];
                $obj->ae_helmet = $rs['ae_helmet'];
                $obj->ae_airway = $rs['ae_airway'];
                $obj->ae_stopbleed = $rs['ae_stopbleed'];
                $obj->ae_splint = $rs['ae_splint'];
                $obj->ae_fluid = $rs['ae_fluid'];
                $obj->ae_coma_eye = $rs['ae_coma_eye'];
                $obj->ae_coma_speak = $rs['ae_coma_speak'];
                $obj->ae_coma_movement = $rs['ae_coma_movement'];


                $rows = json_encode($obj);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูลการเกิดอุบัติเหตุ."}';
            }
        }

        render_json($json);
    }

    public function remove_accident()
    {
        $vn = $this->input->post('vn');
        if(!empty($vn))
        {
            $rs = $this->accident->remove($vn);
            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
        }
        else
        {
            $json = '{"success": false, "msg": "กรุณาระบุเลขที่รับบริการ [VN]"}';
        }

        render_json($json);
    }

    public function save_charge_dental()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            if(empty($data['id']))
            {
                //check duplicate
                $is_duplicated = $this->service->check_charge_dental_exist($data['vn'], $data['charge_id']);
                if(!$is_duplicated)
                {
                    $data['id'] = new MongoId();
                    $rs = $this->service->save_charge_dental($data);
                    $json = $rs ? '{"success": true, "id": "'.get_first_object($data['id']).'"}' : '{"success": false, "msg": "ไม่สามารถบันทึกรายการได้"}';
                }
                else
                {
                    $json = '{"success": false, "msg": "รายการนี้ซ้ำ"}';
                }
            }
            else
            {
                //update
                $rs = $this->service->update_charge_dental($data);
                $json = $rs ? '{"success": true, "id": "'.$data['id'].'"}' : '{"success": false, "msg": "ไม่สามารถบันทึกรายการได้"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }

        render_json($json);
    }

    public function get_charge_dental_list()
    {
        $vn = $this->input->post('vn');
        if(!empty($vn))
        {
            $rs = $this->service->get_charge_dental_list($vn);
            if($rs)
            {
                $arr_result = array();
                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->id = get_first_object($r['_id']);
                    $obj->charge_id = get_first_object($r['charge_id']);
                    $obj->name = get_charge_name($obj->charge_id);
                    $obj->price = isset($r['price']) ? $r['price'] : 0;
                    $obj->teeth = isset($r['teeth']) ? $r['teeth'] : 0;
                    $obj->side = isset($r['side']) ? $r['side'] : 0;

                    $arr_result[] = $obj;
                }

                $row = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$row.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบรายการ"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "กรุณาระบุ VN"}';
        }

        render_json($json);
    }

    public function get_charge_dental_remove()
    {
        $id = $this->input->post('id');
        if(!empty($id))
        {
            $rs = $this->service->get_charge_dental_remove($id);
            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
        }
        else
        {
            $json = '{"success": false, "msg": "กรุณาระบุ ID ที่ต้องการลบ"}';
        }

        render_json($json);
    }

    //===================== Remove service ====================//
    public function remove_service()
    {
        $hn = $this->input->post('hn');
        $vn = $this->input->post('vn');

        if(!empty($hn) && !empty($vn))
        {
            //check owner
            $is_owner = $this->service->check_owner($vn, $this->owner_id);
            if($is_owner)
            {
                $rs = $this->service->remove_service($hn, $vn);
                $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
            }
            else
            {
                $json = '{"success": false, "msg": "การรับบริการครั้งนี้ไม่ใช่ของหน่วยงานคุณๆ ไม่มีสิทธิ์ลบหรือแก้ไข"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "กรุณาระบุเงื่อนไขในการตรวจสอบ"}';
        }

        render_json($json);
    }

}

/* End of file services.php */
/* Location: ./controllers/services.php */