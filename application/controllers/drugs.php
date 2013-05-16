<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Drugs Controller
 *
 * @package     Controller
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.1
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Drugs extends CI_Controller
{
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Global parameter
     */
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

        $this->load->model('Drug_model', 'drug');
        $this->load->model('Basic_model', 'basic');

        $this->drug->owner_id = $this->owner_id;
        $this->drug->user_id = $this->user_id;
    }


    public function index()
    {
        $data['strengths'] = $this->basic->get_strength_list($this->owner_id);
        $data['units'] = $this->basic->get_units_list($this->owner_id);
        $this->layout->view('drugs/index_view', $data);
    }

    public function get_list_total()
    {
        $this->drug->owner_id = $this->owner_id;

        $total = $this->drug->get_list_total();

        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function get_list()
    {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $rs = $this->drug->get_list($start, $limit);

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {
                $price_qty = $this->drug->get_price_qty($r['_id']);
                $obj                = new stdClass();
                $obj->id            = get_first_object($r['_id']);
                $obj->name          = $r['name'];
                $obj->did           = $r['did'];
                $obj->strength_unit = get_strength_name(get_first_object($r['strength_unit']), $this->owner_id);
                $obj->strength      = $r['strength'];
                $obj->unit_name     = get_unit_name(get_first_object($r['unit']), $this->owner_id);
                $obj->cost          = $r['cost'];

                $obj->price         = isset($price_qty[0]['price']) ? $price_qty[0]['price'] : 0;
                $obj->qty           = isset($price_qty[0]['qty']) ? $price_qty[0]['qty'] : 0;

                $arr_result[]       = $obj;
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

    public function search_total()
    {
        $query = $this->input->post('query');

        $this->drug->owner_id = $this->owner_id;
        $total = $this->drug->search_total($query);

        $json = '{"success": true, "total": '.$total.'}';
        render_json($json);
    }

    public function search()
    {
        $query = $this->input->post('query');
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $rs = $this->drug->search($query, $start, $limit);

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {

                $price_qty = $this->drug->get_price_qty($r['_id']);
                $obj                = new stdClass();
                $obj->id            = get_first_object($r['_id']);
                $obj->name          = $r['name'];
                $obj->did           = $r['did'];
                $obj->strength_unit = get_strength_name(get_first_object($r['strength_unit']), $this->owner_id);
                $obj->strength      = $r['strength'];
                $obj->unit_name     = get_unit_name(get_first_object($r['unit']), $this->owner_id);
                $obj->cost          = $r['cost'];

                $obj->price         = isset($price_qty[0]['price']) ? $price_qty[0]['price'] : 0;
                $obj->qty           = isset($price_qty[0]['qty']) ? $price_qty[0]['qty'] : 0;

                $arr_result[]       = $obj;
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

    public function save()
    {
        $data = $this->input->post('data');
        if(empty($data))
        {
            $json = '{"success": false, "msg": "กรุณาระบุข้อมูลที่ต้องการบันทึก"}';
        }
        else
        {
            $exist = $this->drug->check_duplicated($data['id']);

            $rs = $exist ? $this->drug->update($data) : $this->drug->save($data);
            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถบันทึกได้"}';
            }

        }

        render_json($json);
    }

    public function detail()
    {
        $id = $this->input->post('id');
        if(empty($id))
        {
            $json = '{"success": false, "msg": "ไม่พบรหัส ID"}';
        }
        else
        {
            $rs = $this->drug->get_price_qty(new MongoId($id));

            $obj = new stdClass();
            $obj->price = $rs['price'];
            $obj->qty = $rs['qty'];

            $rows = json_encode($obj);
            $json = '{"success": true, "rows": '.$rows.'}';
        }

        render_json($json);
    }

    public function remove()
    {
        $id = $this->input->post('id');
        if(empty($id))
        {
            $json = '{"success": false, "msg": "ไม่พบรายการที่ต้องการลบ [ID not found]"}';
        }
        else
        {
            $rs = $this->drug->remove($id);

            if($rs)
            {
                $json = '{"success": true, "msg": "ลบรายการเสร็จเรียบร้อย"}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
            }
        }

        render_json($json);
    }

}

//End of file