<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * Babies Controller
     *
     * @package     Controller
     * @author      Satit Rianpit <rianpit@gmail.com>
     * @since       Version 1.0.0
     * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
     * @license     http://his.mhkdc.com/licenses
     */

class Spp extends CI_Controller
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

        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        $this->load->model('Service_model', 'service');
        $this->load->model('Person_model', 'person');
        $this->load->model('Spp_model', 'spp');

        $this->spp->owner_id = $this->owner_id;
        $this->spp->provider_id = $this->provider_id;
        $this->spp->user_id = $this->user_id;

        $this->load->helper(array('person'));
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save visit data
     */
    public function save_service()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            if(!empty($data['id']))
            {
                $rs = $this->spp->update_service($data);
                $json = $rs ? '{"success": true, "id": "'.$data['id'].'"}' : '{"success": false, "msg": "ไม่สามารถบันทึกได้"}';
            }
            else
            {
                //check duplicated
                $is_duplicated = $this->spp->check_duplicated($data['hn'], $data['vn'], $data['ppspecial']);

                if($is_duplicated)
                {
                    $json = '{"success": false, "msg": "รายการนี้ช้ำ กรุณาตรวจสอบ (กิจกรรมซ้ำ)"}';
                }
                else
                {
                    $data['id'] = new MongoId();

                    $rs = $this->spp->save_service($data);
                    $json = $rs ? '{"success": true, "id": "'.get_first_object($data['id']).'"}' : '{"success": false, "msg": "ไม่สามารถบันทึกได้"}';
                }
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }

        render_json($json);
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get service detail
     *
     * @internal    param   array   $data
     */
    public function get_service_detail()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            $rs = $this->spp->get_service_detail($data['hn'], $data['vn']);
            if($rs)
            {
                $obj = new stdClass();
                $obj->servplace = $rs['servplace'];
                $obj->ppspecial = get_first_object($rs['ppspecial']);

                $rows = json_encode($obj);

                $json = '{"success": true, "rows": '. $rows .'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการค้นหา"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการค้นหา"}';
        }

        render_json($json);
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get service history
     */
    public function get_history()
    {
        $hn = $this->input->post('hn');

        if(!empty($hn))
        {
            $rs = $this->spp->get_history($hn);
            if($rs)
            {
                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->ppspecial_name = get_pp_special_name($r['ppspecial']);
                    $obj->servplace_name = $r['servplace'] == '1' ? 'ในสถานบริการ' : 'นอกสถานบริการ';

                    $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                    $obj->hospcode = $r['hospcode'];
                    $obj->hospname = get_hospital_name($r['hospcode']);
                    $obj->date_serv = from_mongo_to_thai_date($r['date_serv']);
                    $obj->id = get_first_object($r['_id']);

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
            }

        }
        else
        {
            $json = '{"success": false ,"msg": "ไม่พบ HN กรุณาระบุ"}';
        }

        render_json($json);
    }

    public function get_visit_history()
    {
        $hn = $this->input->post('hn');
        $vn = $this->input->post('vn');

        if(!empty($hn))
        {
            $rs = $this->spp->get_visit_history($hn, $vn);
            if($rs)
            {
                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->ppspecial_name = get_pp_special_name($r['ppspecial']);
                    $obj->servplace_name = $r['servplace'] == '1' ? 'ในสถานบริการ' : 'นอกสถานบริการ';

                    $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                    $obj->hospcode = $r['hospcode'];
                    $obj->hospname = get_hospital_name($r['hospcode']);
                    $obj->date_serv = from_mongo_to_thai_date($r['date_serv']);
                    $obj->id = get_first_object($r['_id']);

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
            }

        }
        else
        {
            $json = '{"success": false ,"msg": "ไม่พบ HN กรุณาระบุ"}';
        }

        render_json($json);
    }

    public function remove_visit()
    {
        $id = $this->input->post('id');
        if(!empty($id))
        {
            $rs = $this->spp->remove_visit($id);
            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
        }
        else
        {
            $json = '{"success": false ,"msg": "ไม่พบ ID ที่ต้องการลบ"}';
        }

        render_json($json);
    }
}

//End of file