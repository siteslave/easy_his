<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Accidents Controller
 *
 * Appoint Controller information
 *
 * @package     Controller
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Chronicfu extends CI_Controller
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
        $this->load->model('Chronicfu_model', 'cfu');

        $this->service->owner_id = $this->owner_id;
        $this->cfu->owner_id = $this->owner_id;
        $this->cfu->user_id = $this->user_id;
    }

    public function save()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            $is_owner = $this->service->check_owner($data['vn'], $this->owner_id);
            if($is_owner)
            {
                $exist = $this->cfu->check_exist($data['hn'], $data['vn']);
                $rs = $exist ? $this->cfu->update($data) : $this->cfu->save($data);

                $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
            }
            else
            {
                $json = '{"success": false, "msg": "คุณไม่มีสิทธิ์แก้ไขข้อมูลนี้ เนื่องจากไม่ใช่ข้อมูลการให้บริการของหน่วยงานคุณ"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }

        render_json($json);
    }

    public function detail()
    {
        $hn = $this->input->post('hn');
        $vn = $this->input->post('vn');

        if($hn && $vn)
        {
            $rs = $this->cfu->get_detail($hn, $vn);
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
        else
        {
            $json = '{"success": false, "msg": "ไม่พบ HN หรือ VN ที่ต้องการ"}';
        }

        render_json($json);
    }

    public function remove()
    {
        $hn = $this->input->post('hn');
        $vn = $this->input->post('vn');

        if($hn && $vn)
        {
            $rs = $this->cfu->remove($hn, $vn);
            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถลบข้อมูลได้"}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบ HN หรือ VN ที่ต้องการ"}';
        }

        render_json($json);
    }

}