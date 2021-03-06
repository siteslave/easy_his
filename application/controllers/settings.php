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

class Settings extends CI_Controller
{
    public $owner_id;
    public $user_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        //models
        $this->load->model('Setting_model', 'setting');
        $this->load->model('Basic_model', 'basic');

        $this->setting->owner_id = $this->owner_id;
        $this->basic->owner_id = $this->owner_id;
    }

    public function providers()
    {
        $data['titles'] = $this->basic->get_title();
        $data['provider_types'] = $this->basic->get_provider_type();

        $this->layout->view('settings/provider_view', $data);
    }

    public function do_save_providers(){

        $data = $this->input->post('data');

        if(empty($data)){
            $json = '{"success": false, "msg": "No data for save."}';
        }else{
            //check duplicate
            $duplicated = $this->setting->check_duplicate_provider($data['cid']);

            if($duplicated){
                $json = '{"success": false, "msg": "Duplicate CID"}';
            }else{
                $data['provider'] = generate_serial('PROVIDER');
                $result = $this->setting->do_save_provider($data);
                if($result){
                    $json = '{"success": true}';
                }else{
                    $json = '{"success": false, "msg": "Save provider failed."}';
                }
            }
        }

        render_json($json);
    }

    public function do_update_providers(){

        $data = $this->input->post('data');

        if(empty($data)){
            $json = '{"success": false, "msg": "No data for save."}';
        }else{

            if($data['cid'] == $data['old_cid']){
                $result = $this->setting->do_update_provider($data);
                if($result){
                    $json = '{"success": true, "msg": "old_cid"}';
                }else{
                    $json = '{"success": false, "msg": "Save provider failed."}';
                }
            }else{
                //check duplicate
                $duplicated = $this->setting->check_duplicate_provider($data['cid']);

                if($duplicated){
                    $json = '{"success": false, "msg": "Duplicate CID"}';
                }else{
                    $result = $this->setting->do_update_provider($data);
                    if($result){
                        $json = '{"success": true}';
                    }else{
                        $json = '{"success": false, "msg": "Save provider failed."}';
                    }
                }
            }
        }

        render_json($json);

    }

    public function get_provider_list(){
        $result = $this->setting->get_provider_list();
        if($result){
            $arr_result = array();
            foreach($result as $r){
                $obj = new stdClass();
                $obj->id = get_first_object($r['_id']);
                $obj->provider = $r['provider'];
                $obj->register_no = $r['register_no'];
                $obj->council = $r['council'];
                $obj->cid = $r['cid'];
                $obj->title = get_title_name($r['title_id']);
                $obj->first_name = $r['first_name'];
                $obj->last_name = $r['last_name'];
                $obj->sex = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birth_date = from_mongo_to_thai_date($r['birth_date']);
                $obj->provider_type = get_provider_type_name($r['provider_type_id']);
                $obj->start_date = from_mongo_to_thai_date($r['start_date']);
                $obj->out_date = from_mongo_to_thai_date($r['out_date']);
                $obj->move_from_hospital_code = $r['move_from_hospital'];
                $obj->move_from_hospital_name = get_hospital_name($obj->move_from_hospital_code);
                $obj->move_to_hospital_code = $r['move_to_hospital'];
                $obj->move_to_hospital_name = get_hospital_name($obj->move_to_hospital_code);

                array_push($arr_result, $obj);
            }

            $rows = json_encode($arr_result);
            $json = '{"success": true, "rows": '.$rows.'}';
        }else{
            $json = '{"success": false, "msg": "ไม่พบรายการ"}';
        }

        render_json($json);
    }

    public function get_provider_detail(){
        $id = $this->input->post('id');
        if(empty($id)){
            $json = '{"success": false, "msg": "No id found."}';
        }else{
            $r = $this->setting->get_provider_detail($id);
            if($r){
                $obj = new stdClass();
                $obj->id = get_first_object($r['_id']);
                $obj->provider = $r['provider'];
                $obj->register_no = $r['register_no'];
                $obj->council = $r['council'];
                $obj->cid = $r['cid'];
                $obj->title_id = get_first_object($r['title_id']);
                $obj->first_name = $r['first_name'];
                $obj->last_name = $r['last_name'];
                $obj->sex = $r['sex'];
                $obj->birth_date = from_mongo_to_thai_date($r['birth_date']);
                $obj->provider_type_id = get_first_object($r['provider_type_id']);
                //$obj->provider_type = get_provider_type_name($r['provider_type_id']);
                $obj->start_date = from_mongo_to_thai_date($r['start_date']);
                $obj->out_date = from_mongo_to_thai_date($r['out_date']);
                $obj->move_from_hospital_code = $r['move_from_hospital'];
                $obj->move_from_hospital_name = get_hospital_name($obj->move_from_hospital_code);
                $obj->move_to_hospital_code = $r['move_to_hospital'];
                $obj->move_to_hospital_name = get_hospital_name($obj->move_to_hospital_code);

                $rows = json_encode($obj);

                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "Database error, please check your data."}';
            }
        }

       render_json($json);
    }

    public function clinics()
    {
        $this->layout->view('settings/clinic_view');
    }
    public function get_clinic_list()
    {
        $rs = $this->setting->get_clinic_list();
        $arr_result = array();
        foreach($rs as $r)
        {
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];
            $obj->export_code = $r['export_code'];

            $arr_result[] = $obj;
        }

        $rows = json_encode($arr_result);

        $json = '{"success": true, "rows": '.$rows.'}';
        render_json($json);
    }

    public function do_save_clinics()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "กรุณาระบุข้อมูลที่ต้องการบันทึก"}';
        }
        else
        {
            if($data['is_update'] == '1')
            {
                $rs = $this->setting->update_clinics($data);
                $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถปรับปรุงรายการได้"}';
            }
            else
            {
                //check exist
                $exist = $this->setting->check_clinic_duplicated($data['name']);
                if($exist)
                {
                    $json = '{"success": false, "msg": "รายการซ้ำ"}';
                }
                else
                {
                    $rs = $this->setting->save_clinics($data);
                    $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถเพิ่มรายการได้"}';
                }

            }
        }

        render_json($json);
    }
}
/* End of file settings.php */
/* Location: ./controllers/settings.php */