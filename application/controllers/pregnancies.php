<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pregnancies Controller
 *
 * @package     Controller
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Pregnancies extends CI_Controller
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

        $this->load->model('Pregnancies_model', 'preg');
        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');
        $this->load->model('House_model', 'house');

        $this->person->owner_id = $this->owner_id;

        $this->preg->owner_id = $this->owner_id;
        $this->preg->user_id = $this->user_id;
        $this->preg->provider_id = $this->provider_id;

        $this->load->helper(array('person'));
    }

    /**
     * Index method
     */
    public function index()
    {
        $data['villages'] = $this->person->get_villages();
        $this->layout->view('pregnancies/index_view', $data);
    }

    public function check_registration()
    {
        $hn = $this->input->post('hn');

        $rs = $this->preg->check_register_status_without_gravida($hn);

        if($rs)
        {
            $json = '{"success": true}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลการลงทะเบียน"}';
        }

        render_json($json);
    }
    //------------------------------------------------------------------------------------------------------------------
    public function get_list()
    {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $rs = $this->preg->get_list($start, $limit);

        if($rs)
        {
            $arr_result = array();

            foreach($rs as $r)
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
                $obj->reg_date = $r['reg_date'];
                $obj->anc_code = $r['anc_code'];
                $obj->gravida = $r['gravida'];
                $obj->preg_status = $r['preg_status'] == '0' ? 'ยังไม่คลอด' : 'คลอดแล้ว';
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
        $this->preg->owner_id = $this->owner_id;
        $total = $this->preg->get_list_total();
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function do_register()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "Data not found."}';
        }
        else
        {

            $is_owner = $this->person->check_owner($data['hn']);
            if($is_owner)
            {
                $exists = $this->preg->check_register_status($data['hn'], $data['gravida']);

                if($exists)
                {
                    $json = '{"success": false, "msg": "ทะเบียนซ้ำ - ชื่อนี้มีอยู่ในทะเบียนเรียบร้อยแล้ว"}';
                }
                else
                {
                    $data['anc_code'] = generate_serial('ANC');
                    $rs = $this->preg->do_register($data);

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
            else
            {
                $json = '{"success": false, "msg": "บุคคลนี้ไม่ใช่คนในเขตรับผิดชอบ (Typearea ไม่ใช่ 1 หรือ 3)"}';
            }
        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Service module
     */

    public function anc_service_save()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลสำหรับบันทึก"}';
        }
        else
        {
            $rs = $this->preg->sevice_save($data);

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

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get Pregnancies list
     */
    public function anc_get_detail()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false,"msg": "ไม่พบข้อมูลเพื่อค้นหา"}';
        }
        else
        {
            $rs = $this->preg->anc_get_detail($data['hn'], $data['vn']);

            if($rs)
            {
                $rows = json_encode($rs);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
            }
        }

        render_json($json);
    }

    public function get_gravida()
    {
        $hn = $this->input->post('hn');

        $gravidas = $this->preg->get_gravida($hn);

        $json = '{"success": true, "rows": '.json_encode($gravidas).'}';

        render_json($json);
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save Pregnancies service
     */
    public function anc_save_service()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลสำหรับบันทึก"}';
        }
        else
        {
            //check duplicated
            $duplicated = $this->preg->anc_check_visit_duplicated($data['hn'], $data['vn'], $data['gravida']);

            if($duplicated)
            {
                //$json = '{"success": false, "msg": "ข้อมูลซ้ำ"}';
                //do update
                $rs = $this->preg->anc_update_service($data);
            }
            else
            {
                $rs = $this->preg->anc_save_service($data);
            }

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
    public function anc_get_history()
    {
        $hn = $this->input->post('hn');
        $gravida = $this->input->post('gravida');

        if(!empty($hn))
        {
            $rs = $this->preg->anc_get_history($hn, $gravida);
            $gravida = $rs[0]['gravida'];

            if($rs)
            {
                $arr_result = array();

                if(isset($rs[0]['anc']))
                {
                    foreach($rs[0]['anc'] as $r)
                    {
                        $obj = new stdClass();
                        $visit = $this->service->get_visit_info($r['vn']);
                        $obj->clinic_name = get_clinic_name(get_first_object($visit['clinic']));
                        $obj->date_serv = $visit['date_serv'];
                        $obj->time_serv = $visit['time_serv'];
                        $obj->anc_no = $r['anc_no'];
                        $obj->ga = $r['ga'];
                        $obj->anc_result = $r['anc_result'];
                        $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                        $obj->owner_name = get_owner_name(get_first_object($r['owner_id']));

                        $arr_result[] = $obj;
                    }

                    $rows = json_encode($arr_result);
                    $json = '{"success": true, "rows": '.$rows.', "gravida": "'.$gravida.'"}';
                }
                else
                {
                    $json = '{"success": false, "msg": "No result found"}';
                }

            }
            else
            {
                $json = '{"success": false, "msg": "เกิดข้อผิดพลาดในการค้นหาข้อมูล"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    // Labor module
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Save labor data
     */
    public function labor_save()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false ,"msg": "No data for save."}';
        }
        else
        {
            //save labor data
            $rs = $this->preg->labor_save($data);

            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถบันทึกรายการได้"}';
            }
        }

        render_json($json);
    }

    /**
     * Get labor detail
     */

    public function labor_get_detail()
    {
        $anc_code = $this->input->post('anc_code');

        if(empty($anc_code))
        {
            $json = '{"success": false, "msg": "ANC Code not found."}';
        }
        else
        {
            $rs = $this->preg->labor_get_detail($anc_code);

            if($rs)
            {
                $arr_result = array();
                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->gravida = isset($r['labor']) ? $r['gravida'] : NULL;
                    $obj->lmp = isset($r['prenatal']) ? to_js_date($r['prenatal']['lmp']) : NULL;
                    $obj->edc = isset($r['prenatal']) ? to_js_date($r['prenatal']['edc']) : NULL;
                    $obj->bdate = isset($r['labor']) ? to_js_date($r['labor']['bdate']) : NULL;
                    $obj->btime = isset($r['labor']) ? $r['labor']['btime'] : NULL;
                    $obj->icd_code = isset($r['labor']) ? $r['labor']['bresult'] : NULL;
                    $obj->icd_name = isset($r['labor']) ? get_diag_name($r['labor']['bresult']) : NULL;
                    $obj->bplace = isset($r['labor']) ? $r['labor']['bplace'] : NULL;
                    $obj->bhosp = isset($r['labor']) ? $r['labor']['bhosp'] : NULL;
                    $obj->bhosp_name = isset($r['labor']) ? get_hospital_name($r['labor']['bhosp']) : NULL;
                    $obj->btype = isset($r['labor']) ? $r['labor']['btype'] : NULL;
                    $obj->bdoctor = isset($r['labor']) ? $r['labor']['bdoctor'] : NULL;
                    $obj->sborn = isset($r['labor']) ? $r['labor']['sborn'] : NULL;
                    $obj->lborn = isset($r['labor']) ? $r['labor']['lborn'] : NULL;
                    $obj->preg_status = $r['preg_status'];

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

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save Postnatal service
     */
    public function postnatal_save_service()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลสำหรับบันทึก"}';
        }
        else
        {
            //check duplicated
            $duplicated = $this->preg->postnatal_check_visit_duplicated($data['hn'], $data['vn'], $data['gravida']);

            if($duplicated)
            {
                //$json = '{"success": false, "msg": "ข้อมูลซ้ำ"}';
                //do update
                $rs = $this->preg->postnatal_update_service($data);
            }
            else
            {
                $rs = $this->preg->postnatal_save_service($data);
            }

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
    public function postnatal_get_history()
    {
        $hn = $this->input->post('hn');

        if(!empty($hn))
        {
            $rs = $this->preg->postnatal_get_history($hn);
            $gravida = $rs[0]['gravida'];

            if($rs)
            {
                $arr_result = array();

                if(isset($rs[0]['postnatal']))
                {
                    foreach($rs[0]['postnatal'] as $r)
                    {
                        $obj = new stdClass();
                        $visit = $this->service->get_visit_info($r['vn']);
                        $obj->clinic_name = get_clinic_name(get_first_object($visit['clinic']));
                        $obj->date_serv = $visit['date_serv'];
                        $obj->time_serv = $visit['time_serv'];

                        $obj->ppresult = $r['ppresult'];
                        $obj->sugar = $r['sugar'];
                        $obj->albumin = $r['albumin'];
                        $obj->perineal = $r['perineal'];
                        $obj->amniotic_fluid = $r['amniotic_fluid'];
                        $obj->uterus = $r['uterus'];
                        $obj->tits = $r['tits'];

                        $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                        $obj->owner_name = get_owner_name(get_first_object($r['owner_id']));

                        $arr_result[] = $obj;
                    }

                    $rows = json_encode($arr_result);
                    $json = '{"success": true, "rows": '.$rows.', "gravida": "'.$gravida.'"}';
                }
                else
                {
                    $json = '{"success": false, "msg": "No result found"}';
                }

            }
            else
            {
                $json = '{"success": false, "msg": "เกิดข้อผิดพลาดในการค้นหาข้อมูล"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
        }

        render_json($json);
    }

    public function postnatal_get_detail()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false,"msg": "ไม่พบข้อมูลเพื่อค้นหา"}';
        }
        else
        {
            $rs = $this->preg->postnatal_get_detail($data['hn'], $data['vn']);

            if($rs)
            {
                $rows = json_encode($rs);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
            }
        }

        render_json($json);
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Anc info module
     */

    public function save_anc_info()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "No data for save."}';
        }
        else
        {
            $rs = $this->preg->save_anc_info($data);

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

    public function get_anc_info()
    {
        $anc_code = $this->input->post('anc_code');

        if(empty($anc_code))
        {
            $json = '{"success": false, "msg": "ANC Code not found."}';
        }
        else
        {
            $rs = $this->preg->get_anc_info($anc_code);

            if($rs)
            {
                $obj = new stdClass();
                $obj->lmp = to_js_date($rs['prenatal']['lmp']);
                $obj->edc = to_js_date($rs['prenatal']['edc']);
                $obj->preg_status = $rs['preg_status'];
                $obj->vdrl = $rs['prenatal']['vdrl'];
                $obj->hb = $rs['prenatal']['hb'];
                $obj->hiv = $rs['prenatal']['hiv'];
                $obj->hct_date = to_js_date($rs['prenatal']['hct_date']);
                $obj->hct = $rs['prenatal']['hct'];
                $obj->thalassemia = $rs['prenatal']['thalassemia'];
                $obj->do_export = $rs['prenatal']['do_export'];
                $obj->do_export_date = to_js_date($rs['prenatal']['do_export_date']);


                $rows = json_encode($obj);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "No result."}';
            }
        }

        render_json($json);
    }

    public function get_list_by_village()
    {
        $village_id = $this->input->post('village_id');

        $houses = $this->house->get_houses_in_village($village_id);
        $persons = $this->house->get_person_in_house($houses);

        $person_disb = $this->preg->get_person_list_village($persons);

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
                $obj->reg_date = $r['reg_date'];
                $obj->anc_code = $r['anc_code'];
                $obj->gravida = $r['gravida'];
                $obj->preg_status = $r['preg_status'] == '0' ? 'ยังไม่คลอด' : 'คลอดแล้ว';
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

    /**
     * Search pregnancy
     */
    public function search()
    {
        $hn = $this->input->post('hn');
        if(empty($hn))
        {
            $json = '{"success": false, "msg": "กรุณาระบุ HN"}';
        }
        else
        {
            $rs = $this->preg->search($hn);
            if($rs)
            {
                $arr_result = array();
                foreach($rs as $r)
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
                    $obj->reg_date = $r['reg_date'];
                    $obj->anc_code = $r['anc_code'];
                    $obj->gravida = $r['gravida'];
                    $obj->preg_status = $r['preg_status'] == '0' ? 'ยังไม่คลอด' : 'คลอดแล้ว';
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