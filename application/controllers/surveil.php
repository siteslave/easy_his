<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surveil extends CI_Controller {

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
        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Surveil_model', 'surveil');

        //helpers
        $this->load->helper('person');

        $this->surveil->owner_id = $this->owner_id;
        $this->surveil->user_id = $this->user_id;
        $this->surveil->provider_id = $this->provider_id;
    }

    public function index()
    {
        $this->layout->view('surveil/index_view');
    }

    public function get_list()
    {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');
        $visit_date = $this->input->post('visit_date');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;
        $vn = $this->surveil->get_vn(to_string_date($visit_date));
        $this->surveil->code506 = $this->basic->get_506_list();

        $rs = $this->surveil->get_list($vn, $start, $limit);

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {
                $hn = $this->surveil->get_visit_hn($r['vn']);
                $person = $this->person->get_person_detail_with_hn($hn);
                $visit = $this->service->get_visit_info($r['vn']);

                $surveil            = $this->surveil->get_detail($hn, $r['vn'], $r['code']);
                $obj                = new stdClass();
                $obj->date_serv     = from_mongo_to_thai_date($visit['date_serv']);
                $obj->vn            = $r['vn'];
                $obj->hn            = $hn;
                $obj->cid           = $person['cid'];
                $obj->first_name    = $person['first_name'];
                $obj->last_name     = $person['last_name'];
                $obj->sex           = $person['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate     = $person['birthdate'];
                $obj->age           = count_age($person['birthdate']);
                $obj->diag_code     = $r['code'];
                $obj->diag_name     = get_diag_name($r['code']);
                $obj->code506      = $this->surveil->get_code506_name($surveil['code506']);
                $obj->ptstatus      = $this->surveil->get_ptstatus_name($surveil['ptstatus']);

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
        $visit_date = $this->input->post('visit_date');

        $vn = $this->surveil->get_vn(to_string_date($visit_date));
        $this->surveil->code506 = $this->basic->get_506_list();

        $total = $this->surveil->get_list_total($vn);

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
            $exist = $this->surveil->check_exist($data['vn'], $data['diagcode']);
            $data['death_date'] = $data['ptstatus'] == '2' ? to_string_date($data['date_death']) : '';
            $rs = $exist ? $this->surveil->update($data) : $this->surveil->save($data);

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
            $rs = $this->surveil->clear($data);
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
        $vn = $this->input->post('vn');
        $diagcode = $this->input->post('diagcode');
        $hn = $this->input->post('hn');

        if(empty($hn))
        {
            $json = '{"success": false, "msg": "กรุณาระบุ HN"}';
        }
        else if(empty($vn))
        {
            $json = '{"success": false, "msg": "กรุณาระบุ VN"}';
        }
        else if(empty($diagcode))
        {
            $json = '{"success": false, "msg": "กรุณาระบุรหัสการวินิจฉัย"}';
        }
        else
        {
            $rs = $this->surveil->get_detail($hn, $vn, $diagcode);

            $obj = new stdClass();
            $obj->code506 = $rs['code506'];
            $obj->complication = $rs['complication'];
            $obj->date_death = $rs['date_death'];
            $obj->diagcode = $rs['diagcode'];
            $obj->hn = $rs['hn'];
            $obj->illampur = $rs['illampur'];
            $obj->illchangwat = $rs['illchangwat'];
            $obj->illdate = $rs['illdate'];
            $obj->illhouse = $rs['illhouse'];
            $obj->illtambon = $rs['illtambon'];
            $obj->illvillage = $rs['illvillage'];
            $obj->latitude = $rs['latitude'];
            $obj->longitude = $rs['longitude'];
            $obj->organism = $rs['organism'];
            $obj->ptstatus = $rs['ptstatus'];
            $obj->school_class = $rs['school_class'];
            $obj->school_name = $rs['school_name'];
            $obj->syndrome = $rs['syndrome'];
            $obj->vn = $rs['vn'];

            $rows = json_encode($obj);

            $json = '{"success": true, "rows": '.$rows.'}';
        }

        render_json($json);
    }

    public function get_organism()
    {
        $code506 = $this->input->post('code');

        if(empty($code506))
        {
            $json = '{"success": false, "msg": "ไม่พบเงื่อนไช"}';
        }
        else
        {
            $rs = $this->surveil->get_organism($code506);
            $rows = json_encode($rs);

            $json = '{"success": true, "rows": '.$rows.'}';
        }

        render_json($json);
    }


}

/* End of file women.php */
/* Location: ./application/controllers/women.php */