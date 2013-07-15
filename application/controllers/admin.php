<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin controller
 *
 * @package     Controller
 * @author      Mr.Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mkh.go.th/licenses
 */

class Admin extends CI_Controller {

    public $owner_id;
    public $user_id;
    public $provider_id;
    public $salt;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id))
        {
            redirect(site_url('users/access_denied'));
        }

        //check access menu
        /*
         * Under constructor
         */

        $this->load->model('Admin_model', 'admin');
        $this->load->model('Basic_model', 'basic');

        //Get default value
        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');

        $this->admin->user_id = $this->user_id;
        $this->admin->owner_id = $this->owner_id;
        $this->basic->owner_id = $this->owner_id;
    }

    public function index()
    {
        $data['clinics']   = $this->basic->get_clinic();
        $data['providers'] = $this->admin->get_provider_list();
        $this->layout->view('settings/admin_view', $data);
    }

    public function get_list()
    {
        $rs = $this->admin->get_list();
        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->id = get_first_object($r['_id']);
                $obj->first_name = isset($r['first_name']) ? $r['first_name'] : '';
                $obj->last_name = isset($r['last_name']) ? $r['last_name'] : '';
                $obj->cid = $r['cid'];
                $obj->last_login = isset($r['last_login']) ? $r['last_login'] : '-';
                $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                $obj->register_date = $r['register_date'];
                $obj->username = $r['username'];
                $obj->active = $r['active'];

                $arr_result[] = $obj;
            }

            $rows = json_encode($arr_result);
            $json = '{"success": true, "rows": '.$rows.'}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบรายการ"}';
        }

        render_json($json);
    }

    public function save()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            if(empty($data['id']))
            {
                $is_exist = $this->admin->check_exist($data['username']);
                if($is_exist)
                {
                    $json = '{"success": false, "msg": "ชื่อผู้ใช้งานซ้ำ กรุณาเปลี่ยนชื่อใหม่"}';
                }
                else
                {
                    $data['password'] = generate_password($data['password']);
                    $rs = $this->admin->save($data);

                    $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                }
            }
            else
            {
                $rs = $this->admin->update($data);
                $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }

        render_json($json);
    }

    public function get_detail()
    {
        $id = $this->input->post('id');
        if(!empty($id))
        {
            $rs = $this->admin->get_detail($id);
            if($rs)
            {
                $obj = new stdClass();
                $obj->username = $rs['username'];
                $obj->first_name = $rs['first_name'];
                $obj->last_name = $rs['last_name'];
                $obj->provider_id = isset($rs['provider_id']) ? get_first_object($rs['provider_id']) : '';
                $obj->clinic_id = isset($rs['clinic_id']) ? get_first_object($rs['clinic_id']) : '';
                $obj->active = $rs['active'];
                $obj->cid = $rs['cid'];
                $obj->id = get_first_object($rs['_id']);

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
            $json = '{"success": false, "msg": "กรุณาระบุ ID ที่ต้องการแก้ไข"}';
        }

        render_json($json);
    }

    public function change_password()
    {
        $id = $this->input->post('id');
        $pass = $this->input->post('pass');
        if(!empty($id) || !empty($pass))
        {
            $password = generate_password($pass);
            $rs = $this->admin->change_password($id, $password);

            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถเปลี่ยนรหัสผ่านได้"}';
        }
        else
        {
            $json = '{"success": false, "msg": "กรุณาระบุข้อมูล เช่น รหัสผ่าน หรือ id ของผู้ใช้งาน"}';
        }

        render_json($json);
    }

    public function get_password()
    {
        echo generate_password('123456');
    }
}