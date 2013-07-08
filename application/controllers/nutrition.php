<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nutrition controller
 *
 * @package     Controllers
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Nutrition extends CI_Controller
{
    protected $provider_id;
    protected $user_id;
    protected $owner_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->load->model('Nutrition_model', 'nutri');
        $this->nutri->owner_id = $this->owner_id;
        $this->nutri->provider_id = $this->provider_id;
        $this->nutri->owner_id = $this->owner_id;
    }

    public function save()
    {
        $data = $this->input->post('data');

        if(empty($data))
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }
        else
        {
            if(!empty($data['id']))
            {
                $rs = $this->nutri->update($data);
                $id = $data['id'];

            }
            else
            {
                $data['_id'] = new MongoId();
                $rs = $this->nutri->save($data);
                $id = get_first_object($data['_id']);
            }

            if($rs)
            {
                $json = '{"success": true, "id": "'.$id.'"}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
            }
        }

        render_json($json);
    }

    public function get_nutrition()
    {
        $vn = $this->input->post('vn');

        if(empty($vn))
        {
            $json = '{"success": false, "msg": "VN not found."}';
        }
        else
        {
            $rs = $this->nutri->get_visit_detail($vn);
            if($rs)
            {
                $data = isset($rs['nutritions']) ? $rs['nutritions'] : NULL;

                if(count($data) > 0)
                {
                    $rows = $data ? json_encode($data) : NULL;

                    $json = '{"success": true, "rows": '.$rows.'}';
                }
                else
                {
                    $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
                }

            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
            }
        }

        render_json($json);
    }

    /*
     *                     'weight'         => $data['weight'],
                    'height'         => $data['height'],
                    'headcircum'     => $data['headcircum'],
                    'childdevelop'   => $data['childdevelop'],
                    'food'           => $data['food'],
                    'date_serv'      => to_string_date($data['date_serv']),
                    'hospcode'       => $data['hospcode'],
     */
    public function history()
    {
        $hn = $this->input->post('hn');
        if(!empty($hn))
        {
            $rs = $this->nutri->get_history($hn);
            if($rs)
            {
                $arr = array();
                foreach($rs as $r)
                {
                    $obj = new stdClass();

                    $obj->date_serv = from_mongo_to_thai_date($r['date_serv']);
                    $obj->hospcode = $r['hospcode'];
                    $obj->hospname = get_hospital_name($obj->hospcode);
                    $obj->height = $r['height'];
                    $obj->weight = $r['weight'];
                    $obj->headcircum = $r['headcircum'];
                    $obj->childdevelop = $r['childdevelop'] == '1' ? 'ปกติ' : $r['childdevelop'] == '2' ? 'สงสัยช้ากว่าปกติ' : $r['childdevelop'] == '3' ? 'ช้ากว่าปกติ' : '-';
                    $obj->food = $r['food'] == '1' ? 'นมแม่อย่างเดียว' : $r['food'] == '2' ? 'นมแม่และน้ำ' : $r['food'] == '3' ? 'นมแม่และนมผสม' : $r['food'] == '4' ? 'นมผสมอย่างเดียว' : '-';
                    $obj->provider = get_provider_name_by_id(get_first_object($r['provider_id']));
                    $obj->bottle = $r['bottle'] == '1' ? 'ใช้ขวดนม' : 'ไม่ใช้ขวดนม';

                    $arr[] = $obj;
                }

                $rows = json_encode($arr);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false ,"msg": "ไม่พบข้อมูล"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบ HN"}';
        }
        render_json($json);
    }

}