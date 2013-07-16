<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

    /*
     * Owner id for assign owner.
     */
    var $owner_id;

    public function __construct(){
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        $this->load->model('Basic_model', 'basic');
        $this->load->model('Service_model', 'service');
        $this->load->model('Appoint_model', 'appoint');
        $this->load->model('Referout_model', 'rfo');
        $this->load->model('Person_model', 'person');
        $this->load->model('Epi_model', 'epi');
        $this->load->model('Fp_model', 'fp');
        $this->load->model('Nutrition_model', 'nutri');
        $this->load->model('Pregnancies_model', 'preg');
        $this->load->model('Babies_model', 'babies');
        $this->load->model('Spp_model', 'spp');

        $this->epi->owner_id = $this->owner_id;

        $this->preg->owner_id = $this->owner_id;
        $this->preg->user_id = $this->user_id;
        $this->preg->provider_id = $this->provider_id;

        $this->service->owner_id = $this->owner_id;

        $this->babies->owner_id = $this->owner_id;
        $this->spp->owner_id = $this->owner_id;

        $this->person->owner_id = $this->owner_id;
        $this->person->user_id = $this->user_id;
        $this->person->provider_id = $this->provider_id;

        $this->basic->owner_id = $this->owner_id;
    }
    public function index()
    {
        //$this->twiggy->display();
        $this->layout->view('pages/index_view');
    }

    public function procedure($vn='', $code='')
    {
        if(empty($vn))
        {
            echo 'VN not found.';
        }
        else
        {
            $data['providers'] = $this->basic->get_providers();
            $data['clinics']   = $this->basic->get_clinic();
            $data['vn'] = $vn;
            $data['update'] = empty($code) ? '0' : 1;
            //proced
            if(!empty($code))
            {
                $proced = $this->service->get_service_proced_opd_detail($vn, $code);
                $obj = new stdClass();
                $obj->code = $proced['code'];
                $obj->proced_name = get_procedure_name($obj->code);
                $obj->price = $proced['price'];
                $obj->start_time = isset($proced['start_time']) ? $proced['start_time'] : NULL;
                $obj->end_time = isset($proced['end_time']) ? $proced['end_time'] : NULL;
                $obj->provider_id = isset($proced['provider_id']) ? get_first_object($proced['provider_id']) : NULL;
                $obj->clinic_id = isset($proced['clinic_id']) ? get_first_object($proced['clinic_id']) : NULL;
                $data['proced'] = $obj;
            }

            $this->load->view('pages/procedure_view', $data);
        }
    }

    public function diagnosis()
    {
        $data['diag_types']= $this->basic->get_diag_type();
        $data['clinics']   = $this->basic->get_clinic();
        $this->load->view('pages/diagnosis_view', $data);
    }

    public function drugs($vn='', $id='')
    {
        $data['update'] = empty($id) ? '0' : 1;
        if(!empty($id))
        {
            $drugs = $this->service->get_drug_detail($id);

            $obj = new stdClass();
            $obj->id = $id;
            $obj->drug_id = get_first_object($drugs['drug_id']);
            $obj->drug_name = get_drug_name($drugs['drug_id']);
            $obj->usage_name = get_usage_name($drugs['usage_id']);
            $obj->usage_id = $drugs['usage_id'];
            $obj->qty = $drugs['qty'];
            $obj->price = $drugs['price'];
            $data['drug'] = $obj;
        }

        $this->load->view('pages/drug_view', $data);
    }

    public function charges($hn='', $vn='', $id='')
    {
        if(!empty($id))
        {
            $rs = $this->service->get_charge_opd($id);
            $obj = new stdClass();
            $obj->charge_code = $rs['charge_code'];
            $obj->charge_name = get_charge_name($obj->charge_code);
            $obj->qty = $rs['qty'];
            $obj->price = $rs['price'];

            $data['items'] = $obj;
            $data['id'] = $id;
        }

        $data['vn'] = $vn;
        $data['hn'] = $hn;
        $this->load->view('pages/charge_view', $data);
    }

    public function appoints($hn='', $vn='', $id='')
    {
        $data['hn'] = $hn;
        $data['vn'] = $vn;
        $data['providers'] = $this->basic->get_providers();
        $data['clinics']        = $this->basic->get_clinic();
        $data['aptypes']        = $this->basic->get_appoint_type();

        if(!empty($id))
        {
            $rs = $this->appoint->detail($id);

            $data['id'] = get_first_object($rs['_id']);
            $data['clinic_id'] = get_first_object($rs['apclinic_id']);
            $data['provider_id'] = get_first_object($rs['provider_id']);
            $data['diag_code'] = $rs['apdiag'];
            $data['type'] = get_first_object($rs['aptype_id']);
            $data['diag_name'] = get_diag_name($rs['apdiag']);
            $data['apdate'] = from_mongo_to_thai_date($rs['apdate']);
            $data['aptime'] = $rs['aptime'];
        }

        $this->load->view('pages/appoint_view', $data);
    }

    public function refer_out($hn='', $vn='', $code='')
    {
        $data['hn'] = $hn;
        $data['vn'] = $vn;

        if(!empty($code))
        {
            $data['code'] = $code;
            $rs = $this->rfo->get_detail($code);
            $data['refer_date'] = from_mongo_to_thai_date($rs['refer_date']);
            $data['refer_time'] = $rs['refer_time'];
            $data['cause'] = (string) $rs['cause'];
            $data['reason'] = (string) $rs['reason'];
            $data['clinic_id'] = get_first_object($rs['clinic_id']);
            $data['provider_id'] = get_first_object($rs['provider_id']);
            $data['comment'] = $rs['comment'];
            $data['request'] = $rs['request'];
            $data['result'] = (string) $rs['result'];
            $data['refer_hospital_code'] = $rs['refer_hospital'];
            $data['refer_hospital_name'] = get_hospital_name($rs['refer_hospital']);
        }

        $data['providers'] = $this->basic->get_providers();
        $data['clinics']        = $this->basic->get_clinic();

        $this->load->view('pages/refer_out_view', $data);
    }

    public function allergies($hn='', $drug_id='')
    {
        $data['hn'] = $hn;
        if(!empty($drug_id))
        {
            $data['drug_id'] = $drug_id;
            $rs = $this->person->get_drug_allergy_detail($hn, $drug_id);
            $data['drug_name'] = get_drug_name($drug_id);
            $data['record_date'] = from_mongo_to_thai_date($rs['record_date']);
            $data['diag_type_id'] = get_first_object($rs['diag_type_id']);
            $data['alevel_id'] = get_first_object($rs['alevel_id']);
            $data['symptom_id'] = get_first_object($rs['symptom_id']);
            $data['informant_id'] = get_first_object($rs['informant_id']);
            $data['hospname'] = get_hospital_name($rs['hospcode']);
            $data['hospcode'] = $rs['hospcode'];
        }

        $data['diag_types']    = $this->basic->get_drug_allergy_diag_type();
        $data['alevels']       = $this->basic->get_drug_allergy_alevel();
        $data['symptoms']      = $this->basic->get_drug_allergy_symptom();
        $data['informants']    = $this->basic->get_drug_allergy_informant();

        $this->load->view('pages/allergies_view', $data);
    }

    //Vaccine
    public function vaccines($hn='', $vn='')
    {
        //check owner

        if(empty($hn))
        {
            echo 'HN not found.';
        }
        else
        {
            $data['hn'] = $hn;

            if(!empty($vn))
            {
                $data['vn'] = $vn;
                $visit = $this->service->get_visit_info($vn);
                $data['date_serv'] = from_mongo_to_thai_date($visit['date_serv']);
                $data['hospname'] = get_owner_name(get_first_object($visit['owner_id']));
                $data['hospcode'] = get_owner_pcucode(get_first_object($visit['owner_id']));
            }

            $data['providers'] = $this->basic->get_providers();
            $data['vaccines'] = $this->basic->get_epi_vaccine_list();
            $this->load->view('pages/vaccines_view', $data);
        }

    }
    public function update_vaccines($hn='', $id='')
    {
        //check owner
        $is_owner = $this->epi->check_owner($id);

        if(!$is_owner)
        {
            echo '
            <div class="alert alert-danger">
            คุณไม่มีสิทธิในการลบหรือแก้ไขรายการนี้ เนื่องจากไม่ใช่ข้อมูลของคุณ
            </div>
            ';
        }
        else
        {
            if(empty($hn))
            {
                echo 'HN not found.';
            }
            else
            {
                $data['hn'] = $hn;
                $data['id'] = $id;
                $rs = $this->epi->get_detail($id);
                $data['lot'] = $rs['lot'];
                $data['expire'] = from_mongo_to_thai_date($rs['expire']);
                $data['provider_id'] = get_first_object($rs['provider_id']);
                $data['vaccine_id'] = get_first_object($rs['vaccine_id']);
                $data['date_serv'] = isset($rs['date_serv']) ? from_mongo_to_thai_date($rs['date_serv']) : '';
                $data['hospcode'] = isset($rs['hospcode']) ? $rs['hospcode'] : '';
                $data['hospname'] = get_hospital_name($data['hospcode']);

                $data['providers'] = $this->basic->get_providers();
                $data['vaccines'] = $this->basic->get_epi_vaccine_list();
                $this->load->view('pages/vaccines_view', $data);
            }
        }
    }

    public function fp($hn='', $vn='')
    {
        $data['hn'] = $hn;
        $data['vn'] = $vn;

        if(!empty($vn))
        {
            $data['vn'] = $vn;
            $rs = $this->fp->get_list($vn);

            $arr_result = array();

            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->id = get_first_object($r['_id']);
                $obj->fp_name = get_fp_type_name($r['fp_type']);
                $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                //$obj->owner_name = get_owner_name(get_first_object($r['owner_id']));
                $arr_result[] = $obj;
            }

            $data['visit'] = $arr_result;

            $visit = $this->service->get_visit_info($vn);
            $data['date_serv'] = from_mongo_to_thai_date($visit['date_serv']);
            $data['hospname'] = get_owner_name(get_first_object($visit['owner_id']));
            $data['hospcode'] = get_owner_pcucode(get_first_object($visit['owner_id']));

        }

        $data['fp_types']  = $this->basic->get_fp_type();
        $data['providers'] = $this->basic->get_providers();

        $this->load->view('pages/fp_view', $data);
    }

    public function nutrition($hn='', $vn='')
    {
        $data['hn'] = $hn;

        if(!empty($vn))
        {
            $data['vn'] = $vn;
            $visit = $this->service->get_visit_info($vn);
            $data['date_serv'] = from_mongo_to_thai_date($visit['date_serv']);
            $data['hospname'] = get_owner_name(get_first_object($visit['owner_id']));
            $data['hospcode'] = get_owner_pcucode(get_first_object($visit['owner_id']));
            //get nutrition detail
            $items = $this->nutri->get_visit_detail($data['vn']);

            $data['id'] = get_first_object($items['_id']);
            $data['provider_id'] = get_first_object($items['provider_id']);
            $data['weight'] = $items['weight'];
            $data['height'] = $items['height'];
            $data['headcircum'] = $items['headcircum'];
            $data['childdevelop'] = $items['childdevelop'];
            $data['bottle'] = $items['bottle'];
            $data['food'] = $items['food'];

        }

        $data['providers'] = $this->basic->get_providers();

        $this->load->view('pages/nutrition_view', $data);
    }

    public function service_anc($hn='', $vn='')
    {
        $data['hn'] = $hn;
        $data['vn'] = $vn;
        if(!empty($vn))
        {
            $sv = $this->service->get_visit_info($vn);
            $data['date_serv'] = from_mongo_to_thai_date($sv['date_serv']);
            $data['hospname'] = get_owner_name(get_first_object($sv['owner_id']));
            $data['hospcode'] = get_owner_pcucode(get_first_object($sv['owner_id']));

            $visit = $this->preg->anc_get_detail($hn, $vn);
            $data['provider_id']    = isset($visit['anc'][0]['provider_id']) ? get_first_object($visit['anc'][0]['provider_id']) : '';
            $data['ga']             = isset($visit['anc'][0]['ga']) ? $visit['anc'][0]['ga'] : '';
            $data['anc_no']         = isset($visit['anc'][0]['anc_no']) ? $visit['anc'][0]['anc_no'] : '';
            $data['anc_result']     = isset($visit['anc'][0]['anc_result']) ? $visit['anc'][0]['anc_result'] : '';
            $data['gravida']        = isset($visit['gravida']) ? $visit['gravida'] : '';
            $data['id']             = isset($visit['anc'][0]['_id']) ? get_first_object($visit['anc'][0]['_id']) : '';

            //echo var_dump($visit);

        }

        $data['gravidas']   = $this->preg->get_gravida($hn);
        $data['providers']  = $this->basic->get_providers();

        $this->load->view('pages/service_anc_view', $data);
    }

    public function postnatal($hn='', $vn='')
    {
        $data['hn'] = $hn;
        $data['vn'] = $vn;

        if(!empty($vn))
        {
            $sv = $this->service->get_visit_info($vn);
            $data['date_serv'] = from_mongo_to_thai_date($sv['date_serv']);
            $data['hospname'] = get_owner_name(get_first_object($sv['owner_id']));
            $data['hospcode'] = get_owner_pcucode(get_first_object($sv['owner_id']));

            $detail = $this->preg->postnatal_get_detail($hn, $vn);
            $data['gravida'] = isset($detail['gravida']) ? $detail['gravida'] : '';
            $data['ppresult'] = isset($detail['postnatal'][0]['ppresult']) ? $detail['postnatal'][0]['ppresult'] : '';
            $data['sugar'] = isset($detail['postnatal'][0]['sugar']) ? $detail['postnatal'][0]['sugar'] : '';
            $data['albumin'] = isset($detail['postnatal'][0]['albumin']) ? $detail['postnatal'][0]['albumin'] : '';
            $data['perineal'] = isset($detail['postnatal'][0]['perineal']) ? $detail['postnatal'][0]['perineal'] : '';
            $data['amniotic_fluid'] = isset($detail['postnatal'][0]['amniotic_fluid']) ? $detail['postnatal'][0]['amniotic_fluid'] : '';
            $data['uterus'] = isset($detail['postnatal'][0]['uterus']) ? $detail['postnatal'][0]['uterus'] : '';
            $data['tits'] = isset($detail['postnatal'][0]['tits']) ? $detail['postnatal'][0]['tits'] : '';
            $data['provider_id'] = isset($detail['postnatal'][0]['provider_id']) ? get_first_object($detail['postnatal'][0]['provider_id']) : '';
            $data['id'] = isset($detail['postnatal'][0]['_id']) ? get_first_object($detail['postnatal'][0]['_id']) : '';

        }

        $data['gravidas']   = $this->preg->get_gravida($hn);
        $data['providers']  = $this->basic->get_providers();

        $this->load->view('pages/postnatal_view', $data);
    }

    public function babies_care($hn='', $vn='')
    {
        $data['hn'] = $hn;
        $data['providers']  = $this->basic->get_providers();

        if(!empty($vn))
        {
            $data['vn'] = $vn;

            $sv = $this->service->get_visit_info($vn);

            $data['date_serv'] = from_mongo_to_thai_date($sv['date_serv']);
            $data['hospname'] = get_owner_name(get_first_object($sv['owner_id']));
            $data['hospcode'] = get_owner_pcucode(get_first_object($sv['owner_id']));

            $detail = $this->babies->get_service_detail($hn, $vn);
            $data['result'] = $detail['result'];
            $data['id'] = get_first_object($detail['_id']);
            $data['food'] = $detail['food'];
            $data['provider_id'] = get_first_object($detail['provider_id']);
        }

        $this->load->view('pages/babies_care_view', $data);
    }

    public function special_pp($hn='', $vn='')
    {
        $data['hn'] = $hn;

        if(!empty($vn))
        {
            $data['vn'] = $vn;

            $sv = $this->service->get_visit_info($vn);

            $data['date_serv'] = from_mongo_to_thai_date($sv['date_serv']);
            $data['hospname'] = get_owner_name(get_first_object($sv['owner_id']));
            $data['hospcode'] = get_owner_pcucode(get_first_object($sv['owner_id']));

            $visit = $this->spp->get_visit_history($hn, $vn);
            $arr_visit = array();

            foreach($visit as $r)
            {
                $obj = new stdClass();
                $obj->ppspecial_name = get_pp_special_name($r['ppspecial']);
                $obj->servplace_name = $r['servplace'] == '1' ? 'ในสถานบริการ' : 'นอกสถานบริการ';

                $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                $obj->hospcode = $r['hospcode'];
                $obj->hospname = get_hospital_name($r['hospcode']);
                $obj->date_serv = from_mongo_to_thai_date($r['date_serv']);
                $obj->id = get_first_object($r['_id']);

                $arr_visit[] = $obj;
            }

            $data['visit'] = $arr_visit;
        }

        $data['providers']  = $this->basic->get_providers();

        $this->load->view('pages/special_pp_view', $data);
    }

    public function register_service($hn='', $vn='')
    {
        $doctor_rooms           = $this->basic->get_doctor_room();
        $clinics                = $this->basic->get_clinic();
        $inscls                 = $this->basic->get_inscl();

        $data['doctor_rooms']   = $doctor_rooms;
        $data['clinics']        = $clinics;
        $data['inscls']         = $inscls;


        if(!empty($hn))
        {
            $data['hn'] = $hn;

            $person     = $this->person->get_person_detail_with_hn($hn);

            $cid    = $person['cid'];
            $sex    = $person['sex'] == '1' ? 'ชาย' : 'หญิง';

            $data['patient'] = $person['first_name'] . ' ' . $person['last_name'] . ' เพศ: ' . $sex . ' ที่อยู่: ' . get_address($data['hn']);

        }

        if(!empty($vn))
        {
            $data['vn'] = $vn;

            $sv = $this->service->get_visit_info($vn);
            $data['date_serv'] = from_mongo_to_thai_date($sv['date_serv']);
            $data['time_serv'] = isset($sv['time_serv']) ? $sv['time_serv'] : '';

            $data['clinic'] = isset($sv['clinic']) ? get_first_object($sv['clinic']) : '';
            $data['service_place'] = isset($sv['service_place']) ? $sv['service_place'] : '';
            $data['doctor_room'] = isset($sv['doctor_room']) ? get_first_object($sv['doctor_room']) : '';
            $data['patient_type'] = isset($sv['patient_type']) ? $sv['patient_type'] : '';
            $data['location'] = isset($sv['location']) ? $sv['location'] : '';
            $data['intime'] = isset($sv['intime']) ? $sv['intime'] : '';
            $data['type_in'] = isset($sv['type_in']) ? $sv['type_in'] : '';
            $data['cc'] = isset($sv['screenings']['cc']) ? $sv['screenings']['cc'] : '-';

            $data['ins_id'] = isset($sv['insurances']['id']) ? $sv['insurances']['id'] : '';
            $data['ins_code'] = isset($sv['insurances']['code']) ? $sv['insurances']['code'] : '';
            $data['ins_start_date'] = isset($sv['insurances']['start_date']) ? from_mongo_to_thai_date($sv['insurances']['start_date']) : '';
            $data['ins_expire_date'] = isset($sv['insurances']['expire_date']) ? from_mongo_to_thai_date($sv['insurances']['expire_date']) : '';
            $data['ins_hosp_main_code'] = isset($sv['insurances']['hosp_main']) ? $sv['insurances']['hosp_main'] : '';
            $data['ins_hosp_main_name'] = isset($sv['insurances']['hosp_main']) ? get_hospital_name($sv['insurances']['hosp_main']) : '';
            $data['ins_hosp_sub_code'] = isset($sv['insurances']['hosp_sub']) ? $sv['insurances']['hosp_sub'] : '';
            $data['ins_hosp_sub_name'] = isset($sv['insurances']['hosp_sub']) ? get_hospital_name($sv['insurances']['hosp_sub']) : '';
        }

        $this->load->view('pages/register_service_view', $data);
    }

    public function register_service_appoint($hn='', $appoint_id='')
    {
        $doctor_rooms           = $this->basic->get_doctor_room();
        $clinics                = $this->basic->get_clinic();
        $inscls                 = $this->basic->get_inscl();

        $data['doctor_rooms']   = $doctor_rooms;
        $data['clinics']        = $clinics;
        $data['inscls']         = $inscls;


        if(!empty($hn))
        {
            $data['hn'] = $hn;

            $person     = $this->person->get_person_detail_with_hn($hn);

            $cid    = $person['cid'];
            $sex    = $person['sex'] == '1' ? 'ชาย' : 'หญิง';

            $data['patient'] = $person['first_name'] . ' ' . $person['last_name'] . ' เพศ: ' . $sex . ' ที่อยู่: ' . get_address($data['hn']);

        }

        if(!empty($appoint_id))
        {
            $data['appoint_id'] = $appoint_id;
            $appoint = $this->appoint->detail($appoint_id);
            $data['date_serv'] = from_mongo_to_thai_date($appoint['apdate']);
            $data['time_serv'] = $appoint['aptime'];
            $data['clinic'] = get_first_object($appoint['apclinic_id']);
        }

        $this->load->view('pages/register_service_view', $data);
    }

    public function surveillance($hn='', $vn='', $diag='')
    {
        if(empty($hn) || empty($vn))
        {
            echo 'ไม่พบข้อมูล HN';
        }
        else
        {

            //models
            $this->load->model('Person_model', 'person');
            $this->load->model('Service_model', 'service');
            $this->load->model('Basic_model', 'basic');
            $this->load->model('Surveil_model', 'surveil');

            //helpers
            $this->load->helper('person');

            $this->basic->owner_id = $this->owner_id;
            $this->surveil->owner_id = $this->owner_id;
            $this->surveil->user_id = $this->user_id;
            $this->surveil->provider_id = $this->provider_id;

            $data['provinces'] = $this->basic->get_province();
            $data['groups'] = $this->surveil->get_506_group();
            $data['complications'] = $this->surveil->get_complication();
            $data['syndromes'] = $this->surveil->get_syndromes();

            $data['hn'] = $hn;
            $data['vn'] = $vn;
            $data['diag_code'] = $diag;
            $data['diag_name'] = get_diag_name($diag);

            $person     = $this->person->get_person_detail_with_hn($hn);
            $data['name'] = $person['first_name'] . ' ' . $person['last_name'];
            $data['cid'] = $person['cid'];
            $data['birthdate'] = from_mongo_to_thai_date($person['birthdate']);
            $data['age'] = count_age($person['birthdate']);

            $suv = $this->surveil->get_detail($hn, $vn, $diag);
            $data['syndrome'] = $suv['syndrome'];
            $data['code506'] = $suv['code506'];
            $data['illdate'] = from_mongo_to_thai_date($suv['illdate']);
            $data['illhouse'] = $suv['illhouse'];
            $data['illvillage'] = $suv['illvillage'];
            $data['illtambon'] = $suv['illtambon'];
            $data['illampur'] = $suv['illampur'];
            $data['illchangwat'] = $suv['illchangwat'];
            $data['latitude'] = $suv['latitude'];
            $data['longitude'] = $suv['longitude'];
            $data['ptstatus'] = $suv['ptstatus'];
            $data['date_death'] = from_mongo_to_thai_date($suv['date_death']);
            $data['complication'] = $suv['complication'];
            $data['organism'] = $suv['organism'];
            $data['school_class'] = $suv['school_class'];
            $data['school_name'] = $suv['school_name'];

            $data['ampur'] = $this->basic->get_ampur($data['illchangwat']);
            $data['tambon'] = $this->basic->get_tambon($data['illchangwat'], $data['illampur']);

            $data['ogranisms'] = $this->surveil->get_organism($data['code506']);

            $this->load->view('pages/surveillance_view', $data);

        }
    }
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */