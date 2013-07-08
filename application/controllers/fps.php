<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Fps controller
 *
 * @package     Controllers
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Fps extends CI_Controller
{
    protected $user_id;
    protected $owner_id;
    protected $provider_id;

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
        $this->load->model('Fp_model', 'fp');
        $this->load->model('Basic_model', 'basic');

        $this->service->owner_id = $this->owner_id;
        $this->basic->owner_id = $this->owner_id;
        $this->fp->owner_id = $this->owner_id;
        $this->fp->user_id = $this->user_id;
        $this->fp->provider_id = $this->provider_id;
    }

    public function save()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "No data for save."}';
        }
        else
        {
            $visit_exist = $this->service->check_visit_exist($data['vn']);

            if(!$visit_exist)
            {
                $json = '{"success": false, "msg": "Visit not found."}';
            }
            else
            {
                $duplicated = $this->fp->check_visit_duplicate($data['date_serv'], $data['fp_type']);

                if($duplicated)
                {
                    $json = '{"success": false, "msg": "(ซ้ำ) รายการนี้มีอยู่แล้ว กรุณาตรวจสอบ"}';
                }
                else
                {
                    //check sex
                    $fp_sex = $this->basic->get_fp_type_sex($data['fp_type']);
                    $person_sex = $this->basic->get_person_sex($data['hn']);

                    if($fp_sex == $person_sex || $fp_sex == '9')
                    {
                        //$data['_id'] = new MongoId();
                        $rs = $this->fp->save_fp($data);

                        if($rs)
                        {
                            $json = '{"success": true}';
                        }
                        else
                        {
                            $json = '{"success": false, "msg": "ไม่สามารถบันทึกการให้บริการวางแผนครอบครัวได้"}';
                        }
                    }
                    else
                    {
                        $json = '{"success": false, "msg": "เพศ ไม่เหมาะสมกับประเภทการคุมกำเนิด กรุณาตรวจสอบ"}';
                    }
                }
            }
        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get FP list
     *
     *
     */
    public function get_list()
    {
        $vn = $this->input->post('vn');

        if(empty($vn))
        {
            $json = '{"success": false, "msg": "Vn not found."}';
        }
        else
        {
            $rs = $this->fp->get_list($vn);

            if($rs)
            {
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

                $rows = json_encode($arr_result);

                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "Record not found."}';
            }
        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get FP list
     *
     *
     */
    public function get_history()
    {
        $hn = $this->input->post('hn');

        if(empty($hn))
        {
            $json = '{"success": false, "msg": "HN not found."}';
        }
        else
        {
            $rs = $this->fp->get_history($hn);

            if($rs)
            {
                $arr_result = array();

                foreach($rs as $r)
                {
                    $obj = new stdClass();

                    $obj->vn = $r['vn'];

                    $visit = $this->service->get_visit_info($obj->vn);
                    $obj->clinic_name = get_clinic_name(get_first_object($visit['clinic']));
                    $obj->date_serv = to_js_date($visit['date_serv']);
                    $obj->time_serv = $visit['time_serv'];

                    $obj->id = get_first_object($r['_id']);
                    $obj->fp_name = get_fp_type_name($r['fp_type']);
                    $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                    $obj->owner_name = get_owner_name(get_first_object($r['owner_id']));

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);

                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "Record not found."}';
            }
        }

        render_json($json);
    }

    public function remove()
    {
        $id = $this->input->post('id');
        if(!empty($id))
        {
            $rs = $this->fp->remove($id);
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
            $json = '{"success": false, "msg": "ไม่พบ ID ที่ต้องการลบ"}';
        }

        render_json($json);
    }
}