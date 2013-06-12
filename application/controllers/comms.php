<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * Community service Controller
     *
     * @package     Controller
     * @author      Satit Rianpit <rianpit@gmail.com>
     * @since       Version 1.0.0
     * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
     * @license     http://his.mhkdc.com/licenses
     */

class Comms extends CI_Controller
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

        $this->load->model('Service_model', 'service');
        $this->load->model('Person_model', 'person');
        $this->load->model('Comms_model', 'comms');

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
            //check duplicated
            $is_duplicated = $this->comms->check_duplicated($data['hn'], $data['vn']);

            $this->comms->owner_id = $this->owner_id;
            $this->comms->provider_id = $this->provider_id;
            $this->comms->user_id = $this->user_id;

            if(!$is_duplicated)
            {
                $rs = $this->comms->save_service($data);
            }
            else
            {
                $rs = $this->comms->update_service($data);
            }

            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถบันทึกได้"}';
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
            $rs = $this->comms->get_service_detail($data['hn'], $data['vn']);
            if($rs)
            {
                $obj = new stdClass();
                $obj->comservice = get_first_object($rs['comservice']);

                $rows = json_encode($obj);
                $json = '{"success": true, "rows": '. $rows .'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
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
    public function get_service_history()
    {
        $hn = $this->input->post('hn');

        if(!empty($hn))
        {
            $rs = $this->comms->get_service_history($hn);
            if($rs)
            {
                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $visit = $this->service->get_visit_info($r['vn']);
                    $obj->clinic_name = get_clinic_name(get_first_object($visit['clinic']));
                    $obj->date_serv = $visit['date_serv'];
                    $obj->time_serv = $visit['time_serv'];

                    $obj->comservice_name = get_community_service_name($r['comservice']);

                    $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                    $obj->owner_name = get_owner_name(get_first_object($r['owner_id']));

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
}

//End of file