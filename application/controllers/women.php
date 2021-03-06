<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Women extends CI_Controller {

    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id     = $this->session->userdata('owner_id');
        $this->user_id      = $this->session->userdata('user_id');
        $this->provider_id  = $this->session->userdata('provider_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        //models
        $this->load->model('Person_model', 'person');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Women_model', 'women');

        $this->women->owner_id = $this->owner_id;
        $this->women->user_id = $this->user_id;
        $this->women->provider_id = $this->provider_id;

        $this->person->owner_id = $this->owner_id;
        //helpers
        $this->load->helper('person');
    }

    public function index()
    {
        $data['villages'] = $this->person->get_villages();
        $data['fptypes'] = $this->basic->get_fp_type();

        $this->layout->view('women/index_view', $data);
    }

    public function get_list()
    {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');
        $year = $this->input->post('year');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;
        $rs = $this->women->get_list($start, $limit);

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {
                $person = $this->person->get_person_detail_with_hn($r['hn']);
                $fp = $this->women->get_fp_detail($year, $r['hn']);

                $obj                = new stdClass();
                $obj->hn            = $r['hn'];
                $obj->cid           = $person['cid'];
                $obj->id            = get_first_object($r['_id']);
                $obj->first_name    = $person['first_name'];
                $obj->last_name     = $person['last_name'];
                $obj->sex           = $person['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate     = $person['birthdate'];
                $obj->age           = count_age($person['birthdate']);
                $obj->fptype        = $fp['fptype'];
                $obj->year          = $fp['year'];
                $obj->fptype_name   = get_fp_type_name($obj->fptype);
                $obj->mstatus       = get_mstatus_name(get_first_object($person['mstatus']));
                $obj->numberson     = (int) $fp['numberson'];

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

    public function get_list_total()
    {
        $total = $this->women->get_list_total();

        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
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
            //check exist
            $exist = $this->women->check_exist($data['hn'], $data['year']);
            $rs = $exist ? $this->women->update($data) : $this->women->save($data);

            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถบันทึกรายการได้"}';
            }
        }

        render_json($json);
    }

    public function clear()
    {
        $data = $this->input->post('data');
        if(empty($data))
        {
            $json = '{"success": false}';
        }
        else
        {
            $rs = $this->women->clear($data['hn'], $data['year']);
            if($rs)
            {
                $json = '{"success": true}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
            }
        }

        render_json($json);
    }

    public function get_detail()
    {
        $year = $this->input->post('year');
        $hn = $this->input->post('hn');

        if(empty($year) || empty($hn))
        {
            $json = '{"success": false, "msg": "ไม่พบเงื่อนไช"}';
        }
        else
        {
            $rs = $this->women->get_fp_detail($year, $hn);
            $rows = json_encode($rs);

            $json = '{"success": true, "rows": '.$rows.'}';
        }

        render_json($json);
    }

    public function search_filter()
    {
        $village_id = $this->input->post('village_id');
        $year = $this->input->post('year');

        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        if(empty($village_id))
        {
            $json = '{"success": false, "msg": "ไม่พบเงื่อนไข - หมู่บ้าน"}';
        }
        else if(empty($year))
        {
            $json = '{"success": false, "msg": "ไม่พบเงื่อนไข - ปีงบประมาณ"}';
        }
        else
        {
            $houses = $this->person->get_houses_in_village($village_id);
            $rs = $this->women->search_filter($houses, $start, $limit);

            $arr_result = array();
            foreach($rs as $r)
            {
                $person = $this->person->get_person_detail_with_hn($r['hn']);
                $fp = $this->women->get_fp_detail($year, $r['hn']);

                $obj                = new stdClass();
                $obj->hn            = $r['hn'];
                $obj->cid           = $person['cid'];
                $obj->id            = get_first_object($r['_id']);
                $obj->first_name    = $person['first_name'];
                $obj->last_name     = $person['last_name'];
                $obj->sex           = $person['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate     = $person['birthdate'];
                $obj->age           = count_age($person['birthdate']);
                $obj->fptype        = $fp['fptype'];
                $obj->year          = $fp['year'];
                $obj->fptype_name   = get_fp_type_name($obj->fptype);
                $obj->mstatus       = get_mstatus_name(get_first_object($person['mstatus']));

                $obj->numberson     = (int) $fp['numberson'];

                $arr_result[]       = $obj;
            }

            $rows = json_encode($arr_result);
            $json = '{"success": true, "rows": '.$rows.'}';

        }

        render_json($json);
    }
    public function search_filter_total()
    {
        $village_id = $this->input->post('village_id');

        //get house list
        $houses = $this->person->get_houses_in_village($village_id);
        $total = $this->women->search_filter_total($houses);

        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }


    public function search()
    {
        $query = $this->input->post('query');
        $year = $this->input->post('year');

        if(empty($query))
        {
            $json = '{"success": false, "msg": "No query found.}';
        }
        else
        {
            $rs = $this->women->search($query);

            if($rs)
            {
                $arr_result = array();
                foreach($rs as $r)
                {
                    $person = $this->person->get_person_detail_with_hn($r['hn']);
                    $fp = $this->women->get_fp_detail($year, $r['hn']);

                    $obj                = new stdClass();
                    $obj->hn            = $r['hn'];
                    $obj->cid           = $person['cid'];
                    $obj->id            = get_first_object($r['_id']);
                    $obj->first_name    = $person['first_name'];
                    $obj->last_name     = $person['last_name'];
                    $obj->sex           = $person['sex'] == '1' ? 'ชาย' : 'หญิง';
                    $obj->birthdate     = $person['birthdate'];
                    $obj->age           = count_age($person['birthdate']);
                    $obj->fptype        = $fp['fptype'];
                    $obj->year          = $fp['year'];
                    $obj->fptype_name   = get_fp_type_name($obj->fptype);
                    $obj->mstatus       = get_mstatus_name(get_first_object($person['mstatus']));
                    $obj->numberson     = (int) $fp['numberson'];

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

}

/* End of file women.php */
/* Location: ./application/controllers/women.php */