<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * EPI Controller
     *
     * @package     Controller
     * @author      Satit Rianpit <rianpit@gmail.com>
     * @since       Version 1.0.0
     * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
     * @license     http://his.mhkdc.com/licenses
     */

class Epis extends CI_Controller
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

        $this->clinic_code = '05';

        $this->load->model('Epi_model', 'epi');
        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');

        $this->epi->owner_id = $this->owner_id;
        $this->epi->user_id = $this->user_id;
        $this->epi->provider_id = $this->provider_id;
        $this->epi->clinic_code = $this->clinic_code;

        $this->person->owner_id = $this->owner_id;
        $this->person->clinic_code = $this->clinic_code;

        $this->load->helper(array('person'));
    }

    /**
     * Index method
     */
    public function index()
    {

        $data['villages'] = $this->person->get_villages();
        $this->layout->view('epis/index_view', $data);
    }

    //------------------------------------------------------------------------------------------------------------------
    public function get_list()
    {
        $start  = $this->input->post('start');
        $stop   = $this->input->post('stop');

        $start  = empty($start) ? 0 : $start;
        $stop   = empty($stop) ? 25 : $stop;
        $limit  = (int) $stop - (int) $start;

        $rs     = $this->epi->get_list($start, $limit);

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

                $rs_history = $this->epi->get_history($r['hn']);

                $arr_history = array();

                if($rs_history)
                {
                    foreach($rs_history as $rh)
                    {
                        $objh = new stdClass();
                        $objh->date_serv = from_mongo_to_thai_date($rh['date_serv']);
                        $objh->vaccine_name = get_vaccine_name(get_first_object($rh['vaccine_id']));
                        $objh->provider_name = get_provider_name_by_id(get_first_object($rh['provider_id']));
                        $objh->lot = $rh['lot'];
                        $objh->expire = from_mongo_to_thai_date($rh['expire']);
                        $objh->hospname = get_hospital_name($rh['hospcode']);
                        $objh->hospcode = $rh['hospcode'];
                        $objh->id = get_first_object($rh['_id']);

                        $arr_history[] = $objh;
                    }
                }

                $obj->history = $arr_history;

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
    public function get_list_by_village()
    {
        $start      = $this->input->post('start');
        $stop       = $this->input->post('stop');
        $village_id = $this->input->post('village_id');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $houses = $this->person->get_houses_in_village($village_id);
        $limit = (int) $stop - (int) $start;

        $rs = $this->epi->get_list_by_village($houses, $start, $limit);

        if($rs)
        {

            $arr_result = array();

            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->hn        = $r['hn'];
                $obj->cid       = $r['cid'];
                $obj->id        = get_first_object($r['_id']);
                $obj->first_name= $r['first_name'];
                $obj->last_name = $r['last_name'];
                $obj->sex       = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate = $r['birthdate'];
                $obj->age       = count_age($r['birthdate']);
                $obj->reg_date  = isset($r['registers'][0]['reg_date']) ? $r['registers'][0]['reg_date'] : '';

                $rs_history = $this->epi->get_history($r['hn']);

                $arr_history = array();

                if($rs_history)
                {
                    foreach($rs_history as $rh)
                    {
                        $objh = new stdClass();
                        $objh->date_serv = from_mongo_to_thai_date($rh['date_serv']);
                        $objh->vaccine_name = get_vaccine_name(get_first_object($rh['vaccine_id']));
                        $objh->provider_name = get_provider_name_by_id(get_first_object($rh['provider_id']));
                        $objh->lot = $rh['lot'];
                        $objh->expire = from_mongo_to_thai_date($rh['expire']);
                        $objh->hospname = get_hospital_name($rh['hospcode']);
                        $objh->hospcode = $rh['hospcode'];
                        $objh->id = get_first_object($rh['_id']);

                        $arr_history[] = $objh;
                    }
                }

                $obj->history = $arr_history;

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
        $total = $this->epi->get_list_total();
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function get_list_by_village_total()
    {
        $village_id = $this->input->post('village_id');
        $houses = $this->person->get_houses_in_village($village_id);

        $total = $this->epi->get_list_by_village_total($houses);
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function do_register()
    {
        $hn = $this->input->post('hn');

        if(empty($hn))
        {
            $json = '{"success": false, "msg": "HN not found."}';
        }
        else
        {
            $is_owner = $this->person->check_owner($hn, $this->owner_id);
            if($is_owner)
            {
                $exists = $this->person->check_clinic_exist($hn, $this->clinic_code);
                if($exists)
                {
                    $json = '{"success": false, "msg": "ทะเบียนซ้ำ - ชื่อนี้มีอยู่ในทะเบียนเรียบร้อยแล้ว"}';
                }
                else
                {
                    $rs = $this->person->do_register_clinic($hn, $this->clinic_code);
                    $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                }
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่ใช่คนในเขตรับผิดชอบ (Typearea ไม่ใช่ 1 หรือ 3)"}';
            }

        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Service module
     */

    public function service_save()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลสำหรับบันทึก"}';
        }
        else
        {
            $rs = $this->epi->sevice_save($data);
            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
        }

        render_json($json);
    }

    /**
     * Check EPI registration
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
            $rs = $this->person->check_clinic_exist($hn, $this->clinic_code);
            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่พบข้อมูลการลงทะเบียน"}';
        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get epi vaccines list
     */
    public function get_epi_vaccine_list()
    {
        $rs = $this->basic->get_epi_vaccine_list();

        if($rs)
        {
            $rows = json_encode($rs);

            $json = '{"success": true, "rows": '.$rows.'}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save epi service
     */
    public function save()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลสำหรับบันทึก"}';
        }
        else
        {
            if(!empty($data['id']))
            {
                //update
                $rs = $this->epi->update($data);
                $json = $rs ? '{"success": true, "id": "'.$data['id'].'"}' : '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
            }
            else
            {
                if(!empty($data['vn']))
                {
                    //save visit
                    $duplicated = $this->epi->check_visit_duplicated($data['date_serv'], $data['vaccine_id']);

                    if($duplicated)
                    {
                        $json = '{"success": false, "msg": "ข้อมูลซ้ำ [มีการให้วัคซีนนี้แล้วในครั้งนี้]"}';
                    }
                    else
                    {
                        $data['_id'] = new MongoId();
                        $rs = $this->epi->save($data);

                        $json = $rs ? '{"success": true, "id": "'.get_first_object($data['_id']).'"}' : '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                    }
                }
                else
                {
                    //save coverage
                    $data['_id'] = new MongoId();
                    $rs = $this->epi->save($data);
                    $json = $rs ? '{"success": true, "id": "'.get_first_object($data['_id']).'"}' : '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                }
            }

        }

        render_json($json);
    }

    public function get_visit_list()
    {
        $vn = $this->input->post('vn');

        if(!empty($vn))
        {
            $rs = $this->epi->get_list_by_visit($vn);

            if($rs)
            {
                $arr_result = array();

                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->id = get_first_object($r['_id']);
                    $obj->vaccine_name = get_vaccine_name(get_first_object($r['vaccine_id']));
                    $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                    $obj->lot = $r['lot'];
                    $obj->expire = from_mongo_to_thai_date($r['expire']);

                    $arr_result[] = $obj;
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูลการฉีดวัคซีน"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
        }

        render_json($json);
    }
    public function history()
    {
        $hn = $this->input->post('hn');

        if(!empty($hn))
        {
            $rs = $this->epi->get_history($hn);

            if($rs)
            {
                $arr_result = array();

                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->date_serv = from_mongo_to_thai_date($r['date_serv']);
                    $obj->vaccine_name = get_vaccine_name(get_first_object($r['vaccine_id']));
                    $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                    $obj->lot = $r['lot'];
                    $obj->expire = from_mongo_to_thai_date($r['expire']);
                    $obj->hospname = get_hospital_name($r['hospcode']);
                    $obj->hospcode = $r['hospcode'];

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบรายการ"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
        }

        render_json($json);
    }

	public function remove_vaccine()
	{
        $id = $this->input->post('id');
        if(empty($id))
        {
            $json = '{"success": false, "msg": "กรุณาระบุ ID ที่ต้องการลบ"}';
        }
        else
        {
            //check owner
            $is_owner = $this->epi->check_owner($id);

            if(!$is_owner)
            {
                $json = '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
            }
            else
            {
                $rs = $this->epi->remove_visit($id);
                $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
            }
        }

        render_json($json);
	}
}


//End file