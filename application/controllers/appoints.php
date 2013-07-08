<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Appoint Controller
 *
 * Appoint Controller information
 *
 * @package     Controller
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Appoints extends CI_Controller
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

        $this->load->model('Appoint_model', 'appoint');
        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');

        $this->basic->owner_id  = $this->owner_id;
        $this->person->owner_id  = $this->owner_id;

        $this->service->owner_id  = $this->owner_id;
        $this->service->user_id = $this->user_id;

        $this->appoint->owner_id    = $this->owner_id;
        $this->appoint->provider_id = $this->provider_id;
        $this->appoint->user_id     = $this->user_id;

    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Index function
     * 
     * Index page for appointment module
     * @param	string	$vn	The visit number, if null will display appointment list else if vn isset 
     * 						display new register.
     */
    public function index($vn = '', $hn = '')
    {
        if(empty($vn) || !isset($vn))
        {
            $data['clinics']        = $this->basic->get_clinic();
            $data['aptypes']        = $this->basic->get_appoint_type();
            $data['doctor_rooms']   = $this->basic->get_doctor_room();
            $data['inscls']         = $this->basic->get_inscl();

            $this->layout->view('appoints/index_view', $data);
        }
        else
        {
            $this->register($vn, $hn);
        }
    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Register function
     * 
     * Register new appoint
     * @param	string	$vn The visit number
     * 
     */
    public function register($vn = '', $hn = '')
    {
        $this->service->owner_id = $this->owner_id;

        if(empty($vn) OR !isset($vn) OR empty($hn) OR !isset($hn))
        {
            show_error('No vn found.', 404);
        }
        else if(!$this->service->check_visit_exist($vn))
        {
            show_error('VN don\'t exist, please check visit number and try again.', 404);
        }
        else if(!$this->person->check_person_exist_by_hn($hn))
        {
            show_error('Person don\'t exist, please check person and try again.', 404);
        }
        else
        {
            $data['person'] = get_patient_info($hn);
            $data['vn']         = $vn;
            $data['hn']         = $hn;
            $data['address']    = get_address($hn);
            $data['aptypes']    = $this->basic->get_appoint_type();
            $data['clinics']    = $this->basic->get_clinic();

            $this->layout->view('appoints/register_view', $data);

        }
    }
    //------------------------------------------------------------------------------------------------------------------
    public function do_register()
    {
        $is_ajax = $this->input->is_ajax_request();

        if($is_ajax)
        {
            $data = $this->input->post('data');

            if(empty($data))
            {
                $json = '{"success": false, "msg": "No data for save."}';
            }
            else
            {
                //check owner
                $is_owner = $this->service->check_owner($data['vn'], $this->owner_id);
                if($is_owner)
                {
                    if($data['isupdate'])
                    {
                        $rs = $this->appoint->update($data);
                        if($rs)
                        {
                            $json = '{"success": true}';
                        }
                        else
                        {
                            $json = '{"success": false, "msg": "ไม่สามารถปรับปุงข้อมูลการนัดได้"}';
                        }
                    }
                    else
                    {
                        $duplicated = $this->appoint->check_duplicate(to_string_date($data['date']), $data['type']);

                        if($duplicated)
                        {
                            $json = '{"success": false, "msg": "ข้อมูลซ้ำ กรุณาเลือกแผลกและประเภทการนัดใหม่"}';
                        }
                        else
                        {
                            $rs = $this->appoint->do_register($data);

                            if($rs)
                            {
                                $json = '{"success": true}';
                            }
                            else
                            {
                                $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลการนัดได้"}';
                            }
                        }
                    }

                }
                else
                {
                    $json = '{"success": false, "msg": "ไม่ใช่ข้อมูลการให้บริการของหน่วยงานคุณ กรุณาตรวจสอบ"}';
                }
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }
    }
    //-----------------------------------------------------------------------------------------------------------------
    public function get_list()
    {

        $is_ajax = $this->input->is_ajax_request();

        if($is_ajax)
        {
            $data   = $this->input->post('data');
            $start  = $this->input->post('start');
            $stop   = $this->input->post('stop');

            $start  = empty($start) ? 0 : $start;
            $stop   = empty($stop) ? 25 : $stop;

            $limit  = (int) $stop - (int) $start;

            if(!empty($data['clinic']))
            {
                $rs = $this->appoint->get_list_with_clinic($data, $start, $limit);
            }
            else
            {
                $rs = $this->appoint->get_list_without_clinic($data, $start, $limit);
            }

            if($rs)
            {
                $arr_result = array();

                foreach($rs as $r)
                {
                    $obj = new stdClass();

                    $obj->clinic_name   = get_clinic_name(get_first_object($r['apclinic_id']));
                    $obj->clinic_id     = get_first_object($r['apclinic_id']);
                    $obj->provider_name = get_provider_name_by_id($r['provider_id']);
                    $obj->apdate   = from_mongo_to_thai_date($r['apdate']);
                    $obj->aptime        = $r['aptime'];
                    $obj->aptype_name   = get_appoint_type_name($r['aptype_id']);

                    $person = $this->service->get_person_detail($r['hn']);

                    $obj->id            = get_first_object($r['_id']);
                    $obj->person_name   = $person['first_name'] . ' ' . $person['last_name'];
                    $obj->hn            = $r['hn'];
                    $obj->vn            = $r['vn'];
                    $obj->vstatus       = $r['visit_status'];

                    array_push($arr_result, $obj);
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "No record found."}';
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }

    }

    public function get_total_clinic()
    {
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax)
        {
            $data = $this->input->post('data');
            $total = $this->appoint->get_total_with_clinic($data);

            $json = '{"success": true, "total": '.$total.'}';

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }

    }

    public function get_total_without_clinic()
    {
        $is_ajax = $this->input->is_ajax_request();

        if($is_ajax)
        {
            $data = $this->input->post('data');
            $total = $this->appoint->get_total_without_clinic($data);

            $json = '{"success": true, "total": '.$total.'}';

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }
    }
    public function get_list_total_clinic()
    {
        $total = $this->appoint->get_list_total();

        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Search visit
    *
    * @param	string 	$query	The query for search
    * @param	string	$filter	The filter type. 0 = CID, 1 = HN, 2 = First name and last name
    */
    public function search_visit()
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

            $hn = NULL;

            if($filter == '0')
            {
                //get hn by cid
                $hn = $this->person->get_hn_from_cid($query);
            }
            else if($filter == '2')
            {
                //get hn by first name and last name
                $name = explode(' ', $query); // [0] = first name, [1] = last name

                $first_name = count($name) == 2 ? $name[0] : '';
                $last_name = count($name) == 2 ? $name[1] : '';

                $hn = $this->person->get_hn_from_first_last_name($first_name, $last_name);

            }
            else
            {
                $hn = $query;
            }

            $rs = $this->appoint->do_search_visit($hn);

            if($rs)
            {

                $arr_result = array();
                foreach($rs as $r)
                {
                    $obj = new stdClass();

                    $person = $this->service->get_person_detail($r['hn']);
                    $obj->person_name = $person['first_name'] . ' ' . $person['last_name'];

                    $obj->hn = $r['hn'];
                    $obj->vn = $r['vn'];
                    $obj->date_serv = from_mongo_to_thai_date($r['date_serv']);
                    $obj->time_serv = $r['time_serv'];
                    $obj->clinic_name = get_clinic_name(get_first_object($r['clinic']));

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

    //------------------------------------------------------------------------------------------------------------------
    /*
     * Remove appointment
     *
     * @param	MongoId	$id The appointment id.
     */
    public function remove()
    {
        $is_ajax = $this->input->is_ajax_request();

        if($is_ajax)
        {
            $id = $this->input->post('id');

            if(empty($id))
            {
                $json = '{"success": false, "msg": "ไม่พบรหัสการนัดที่ต้องการลบ"}';
            }
            else
            {
                $is_visit = $this->appoint->check_visit_exist($id);

                if($is_visit)
                {
                    $json = '{"success": false, "msg": "รายการนี้ถูกลงทะเบียนส่งตรวจแล้วไม่สามารถลบได้"}';
                }
                else
                {
                    //do remove
                    $rs = $this->appoint->do_remove($id);

                    if($rs)
                    {
                        $json = '{"success": true}';
                    }
                    else
                    {
                        $json = '{"success": false, "msg": "ไม่สามารถลบรายการได้ กรุณาตรวจสอบ"}';
                    }
                }
            }

            render_json($json);
        }
        else
        {
            show_eror('Not ajax.', 404);
        }
    }

    public function detail()
    {
        $is_ajax = $this->input->is_ajax_request();

        if($is_ajax)
        {
            $id = $this->input->post('id');

            if(!empty($id))
            {
                $rs = $this->appoint->detail($id);

                if($rs)
                {
                    $obj = new stdClass();
                    $obj->date = to_js_date($rs['apdate']);
                    $obj->time = $rs['aptime'];
                    $obj->type = get_first_object($rs['aptype_id']);
                    $obj->clinic = get_first_object($rs['apclinic_id']);
                    $obj->diag = $rs['apdiag'];
                    $obj->diag_name = get_diag_name($rs['apdiag']);

                    $rows = json_encode($obj);

                    $json = '{"success": true, "rows": '.$rows.'}';
                }
                else
                {
                    $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
                }
            }
            else
            {
                $json = '{"success": false, "msg": "ID not found."}';
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }
    }

    public function update()
    {
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax)
        {
            $data = $this->input->post('data');
            $rs = $this->appoint->update($data);

            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถปรับปรุงได้"}';
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }
    }

    public function save_service()
    {
        $is_ajax = $this->input->is_ajax_request();

        if($is_ajax)
        {
            $data = $this->input->post('data');

            $data['vn'] = generate_serial('VN');

            $rs = $this->service->do_register($data);
            if($rs){
                //update appoint status
                $this->appoint->update_status($data);
                $json = '{"success": true}';
            }else{
                $json = '{"success": false, "msg": "Can\'t save data."}';
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }
    }

    public function get_appoint()
    {

        $is_ajax = $this->input->is_ajax_request();

        if($is_ajax)
        {
            $vn   = $this->input->post('vn');
            $start  = $this->input->post('start');
            $stop   = $this->input->post('stop');

            $start  = empty($start) ? 0 : $start;
            $stop   = empty($stop) ? 25 : $stop;

            $limit  = (int) $stop - (int) $start;

            $rs = $this->appoint->get_appoint($vn, $start, $limit);

            if($rs)
            {
                $arr_result = array();

                foreach($rs as $r)
                {
                    $obj = new stdClass();

                    $obj->clinic_name   = get_clinic_name(get_first_object($r['apclinic_id']));
                    $obj->clinic_id     = get_first_object($r['apclinic_id']);
                    $obj->aptype_id     = get_first_object($r['aptype_id']);
                    $obj->provider_name = get_provider_name_by_id($r['provider_id']);
                    $obj->apdate   = from_mongo_to_thai_date($r['apdate']);
                    $obj->aptime        = $r['aptime'];
                    $obj->aptype_name   = get_appoint_type_name($r['aptype_id']);
                    $obj->diag          = $r['apdiag'] . ' : ' . get_diag_name($r['apdiag']);
                    $obj->id            = get_first_object($r['_id']);
                    $obj->vn            = $r['vn'];
                    $obj->hn            = $r['hn'];

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "No record found."}';
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }

    }
}

//End file