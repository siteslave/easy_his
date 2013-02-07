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

        //Initialized clinic code
        $this->clinic_code = '04';

        $this->load->model('Pregnancies_model', 'preg');
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
        $this->layout->view('pregnancies/index_view', $data);
    }

    public function check_registration()
    {
        $hn = $this->input->post('hn');
        //$this->preg->owner_id = $this->owner_id;

        $rs = $this->preg->check_register_status($hn);

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

        $this->preg->owner_id = $this->owner_id;

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

    public function do_register()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "Data not found."}';
        }
        else
        {

            $this->preg->owner_id = $this->owner_id;
            $this->preg->user_id = $this->user_id;
            $this->preg->provider_id = $this->provider_id;

            $exists = $this->preg->check_register_status($data['hn']);

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
            $this->preg->owner_id = $this->owner_id;
            $this->preg->user_id = $this->user_id;
            $this->preg->provider_id = $this->provider_id;
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

    public function anc_get_gravida()
    {
        $hn = $this->input->post('hn');

        $gravidas = $this->preg->anc_get_gravida($hn);

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

            $this->preg->owner_id = $this->owner_id;
            $this->preg->user_id = $this->user_id;
            $this->preg->provider_id = $this->provider_id;

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

        if(!empty($hn))
        {
            $rs = $this->preg->anc_get_history($hn);
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
                $json = '{"success": false, "msg": }';
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
                    $obj->gravida = $r['gravida'];
                    $obj->lmp = to_js_date($r['labor']['lmp']);
                    $obj->edc = to_js_date($r['labor']['edc']);
                    $obj->bdate = to_js_date($r['labor']['bdate']);
                    $obj->icd_code = $r['labor']['bresult'];
                    $obj->icd_name = get_diag_name($r['labor']['bresult']);
                    $obj->bplace = $r['labor']['bplace'];
                    $obj->bhosp = $r['labor']['bhosp'];
                    $obj->bhosp_name = get_hospital_name($r['labor']['bhosp']);
                    $obj->btype = $r['labor']['btype'];
                    $obj->bdoctor = $r['labor']['bdoctor'];
                    $obj->sborn = $r['labor']['sborn'];
                    $obj->lborn = $r['labor']['lborn'];
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

}

//End file