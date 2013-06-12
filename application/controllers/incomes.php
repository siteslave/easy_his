<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incomes extends CI_Controller {

    public $owner_id;
    public $user_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id     = $this->session->userdata('owner_id');
        $this->user_id      = $this->session->userdata('user_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->load->model('Income_model', 'income');

        $this->income->owner_id = $this->owner_id;
        $this->income->user_id = $this->user_id;
    }

    public function index()
    {
        $data['incomes'] = $this->income->get_incomes_list();
        $this->layout->view('incomes/index_view', $data);
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
            $exist = $this->income->check_duplicated($data['id']);

            $rs = $exist ? $this->income->update($data) : $this->income->save($data);
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

    public function get_list()
    {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $rs = $this->income->get_list($start, $limit);

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {
                $obj                = new stdClass();
                $obj->id            = get_first_object($r['_id']);
                $obj->income        = get_first_object($r['income']);
                $obj->income_name   = $this->income->get_income_name($obj->income);
                $obj->name          = isset($r['name']) ? $r['name'] : '-';

                $price_qty          = $this->income->get_price_qty($r['_id']);
                $obj->price         = isset($price_qty[0]['price']) ? $price_qty[0]['price'] : 0;
                //$obj->qty           = isset($price_qty[0]['qty']) ? $price_qty[0]['qty'] : 0;

                $obj->cost          = isset($r['cost']) ? $r['cost'] : '-';
                $obj->unit          = isset($r['unit']) ? $r['unit'] : '-';
                $obj->active        = isset($r['active']) ? $r['active'] : '-';
                $obj->code          = isset($r['code']) ? $r['code'] : '-';

                $arr_result[]   = $obj;
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
    public function get_filter_list()
    {
        $income = $this->input->post('income');
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $rs = $this->income->get_filter_list($income, $start, $limit);

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {

                $obj                = new stdClass();
                $obj->id            = get_first_object($r['_id']);
                $obj->income        = get_first_object($r['income']);
                $obj->income_name   = $this->income->get_income_name($obj->income);
                $obj->name          = isset($r['name']) ? $r['name'] : '-';

                $price_qty          = $this->income->get_price_qty($r['_id']);
                $obj->price         = isset($price_qty[0]['price']) ? $price_qty[0]['price'] : 0;
                //$obj->qty           = isset($price_qty[0]['qty']) ? $price_qty[0]['qty'] : 0;

                $obj->cost          = isset($r['cost']) ? $r['cost'] : '-';
                $obj->unit          = isset($r['unit']) ? $r['unit'] : '-';
                $obj->active        = isset($r['active']) ? $r['active'] : '-';
                $obj->code          = isset($r['code']) ? $r['code'] : '-';

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

    public function search()
    {
        $query = $this->input->post('query');

        if(empty($query))
        {
            $json = '{"success": false, "msg": "กรุณาระบุคำค้นหา"}';
        }
        else
        {
            $rs = $this->income->search($query);

            if($rs)
            {
                $arr_result = array();
                foreach($rs as $r)
                {

                    $obj                = new stdClass();
                    $obj->id            = get_first_object($r['_id']);
                    $obj->income        = get_first_object($r['income']);
                    $obj->income_name   = $this->income->get_income_name($obj->income);
                    $obj->name          = isset($r['name']) ? $r['name'] : '-';

                    $price_qty          = $this->income->get_price_qty($r['_id']);
                    $obj->price         = isset($price_qty[0]['price']) ? $price_qty[0]['price'] : 0;
                    //$obj->qty           = isset($price_qty[0]['qty']) ? $price_qty[0]['qty'] : 0;

                    $obj->cost          = isset($r['cost']) ? $r['cost'] : '-';
                    $obj->unit          = isset($r['unit']) ? $r['unit'] : '-';
                    $obj->active        = isset($r['active']) ? $r['active'] : '-';
                    $obj->code          = isset($r['code']) ? $r['code'] : '-';

                    $arr_result[]       = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "No result."}';
            }
        }

        render_json($json);
    }

    public function get_list_total()
    {
        $total = $this->income->get_list_total();

        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function get_filter_total()
    {
        $income = $this->input->post('income');
        $total = $this->income->get_filter_total($income);

        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function remove_item()
    {
        $id = $this->input->post('id');
        if(empty($id))
        {
            $json = '{"success": false, "msg": "กรุณาระบุ ID"}';
        }
        else
        {
            $rs = $this->income->remove_item($id);
            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
        }

        render_json($json);
    }

/*
    public function auto_gen()
    {
        $r = $this->income->get_all();

        foreach($r as $r)
        {
            $code = generate_serial('ITEM', FALSE);
            $this->income->set_code(get_first_object($r['_id']), $code);
        }
    }*/
}