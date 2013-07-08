<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Refer controller
 *
 * @package     Controller
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mkh.go.th/licenses
 */

class Refers extends CI_Controller
{

    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        $this->load->model('Referout_model', 'rfo');

        $this->rfo->user_id = $this->user_id;
        $this->rfo->provider_id = $this->provider_id;
        $this->rfo->owner_id = $this->owner_id;
    }

    public function save_rfo()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            //check if update
            if(!empty($data['code']))
            {
                //update
                $rs = $this->rfo->update($data);
                if ($rs) {
                    $json = '{"success": true, "code": "'.$data['code'].'"}';
                } else {
                    $json = '{"success": false, "msg": "ไม่สามารถปรับปรุงรายการได้"}';
                }

            }
            else
            {
                //insert
                $data['code'] = generate_serial('RFO', TRUE);
                $rs = $this->rfo->save($data);
                if ($rs) {
                    $json = '{"success": true, "code": "'.$data['code'].'"}';
                } else {
                    $json = '{"success": false, "msg": "ไม่สามารถเพิ่มรายการได้"}';
                }
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }

        render_json($json);
    }

    public function get_rfo_list()
    {
        $vn = $this->input->post('vn');
        if(!empty($vn))
        {
            $rs = $this->rfo->get_list($vn);
            $arr_result = array();
            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->refer_date = from_mongo_to_thai_date($r['refer_date']);
                $obj->code = $r['code'];
                $obj->refer_hospital_name = get_hospital_name($r['refer_hospital']);
                $obj->refer_hospital_code = $r['refer_hospital'];
                $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
                $obj->clinic_name = get_clinic_name(get_first_object($r['clinic_id']));
                $obj->hn = $r['hn'];
                $obj->vn = $r['vn'];

                $arr_result[] = $obj;
            }

            $rows = json_encode($arr_result);
            $json = '{"success": true, "rows": '.$rows.'}';
        }
        else
        {
            $json = '{"success": false, "ไม่พบ VN"}';
        }

        render_json($json);
    }

    public function remove_rfo()
    {
        $code = $this->input->post('code');
        if(!empty($code))
        {
            //remove
            $rs = $this->rfo->remove($code);
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
            $json = '{"success": false, "msg": "ไม่พบเลขที่ส่งต่อที่ต้องการลบ"}';
        }

        render_json($json);
    }

    public function save_rfo_answer()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            $rs = $this->rfo->save_answer($data);
            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถบันทึกรายการได้"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "กรุณาระบุข้อมูลที่ต้องการบันทึก"}';
        }

        render_json($json);
    }

    public function get_rfo_answer()
    {
        $code = $this->input->post('code');
        if(!empty($code))
        {
            $rs = $this->rfo->get_answer($code);
            $obj = new stdClass();
            $obj->answer_date = from_mongo_to_thai_date($rs['answer']['answer_date']);
            $obj->answer_detail = $rs['answer']['answer_detail'];
            $obj->answer_diag_code = $rs['answer']['answer_diag'];
            $obj->answer_diag_name = get_diag_name($obj->answer_diag_code);
            $rows = json_encode($obj);

            $json = '{"success": true, "rows": '.$rows.'}';
        }
        else
        {
            $json = '{"success": false, "msg": "กรุณาระบุเลขที่ส่งต่อ"}';
        }

        render_json($json);
    }
}