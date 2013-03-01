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

class Labs extends CI_Controller
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

        $this->load->model('Lab_model', 'lab');
        $this->load->model('Basic_model', 'basic');

    }

    public function get_item_visit()
    {
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax)
        {
            $group_id = $this->input->post('group_id');
            $vn = $this->input->post('vn');

            if(empty($group_id))
            {
                $json = '{"success": false, "msg": "Group ID not found."}';
            }
            else
            {
                $rs = $this->lab->get_items_visit($group_id, $vn);
                if($rs)
                {

                    $arr_result = array();
                    foreach($rs['lab_items'] as $ri)
                    {
                        $obj = new stdClass();
                        $obj->id = get_first_object($ri);
                        $obj->name = $this->basic->get_lab_name($obj->id);

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

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }
    }

    public function save_order()
    {
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax)
        {
            $data = $this->input->post('data');

            if(!empty($data))
            {
                $is_duplicated = $this->lab->check_order_duplicated($data);
                if(!$is_duplicated)
                {
                    $items = $this->lab->get_items($data['group_id']);

                    $arr_labs = array();
                    foreach($items as $r)
                    {
                        $arr_labs[] = $r['_id'];
                    }

                    $rs = $this->lab->save_order($data, $arr_labs);

                    if($rs)
                    {
                        $json = '{"success": true}';
                    }
                    else
                    {
                        $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                    }
                }
                else
                {
                    $json = '{"success": false, "msg": "ข้อมูลซ้ำ"}';
                }
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }
    }

    //get order list
    public function get_order_list()
    {
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax)
        {
            $vn = $this->input->post('vn');
            if(!empty($vn))
            {
                $rs = $this->lab->get_order($vn);

                if($rs)
                {
                    $arr_order = array();
                    foreach($rs as $r)
                    {
                        $obj = new stdClass();
                        $obj->group_id = get_first_object($r['group_id']);
                        $obj->name = $this->basic->get_lab_group_name($obj->group_id);
                        $arr_order[] = $obj;
                    }

                    $rows = json_encode($arr_order);
                    $json = '{"success": true, "rows": '.$rows.'}';
                }
                else
                {
                    $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
                }
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบ VN."}';
            }

            render_json($json);
        }
        else
        {
            show_error('Not ajax.', 404);
        }
    }
}