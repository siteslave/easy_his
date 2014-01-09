<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Death extends CI_Controller {

    /*
     * Owner id for assign owner.
     */
    var $owner_id;

    public function __construct(){
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->provider_id = $this->session->userdata('provider_id');

        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');
        $this->load->model('Death_model', 'death');

        $this->person->owner_id = $this->owner_id;
        $this->person->user_id = $this->user_id;
        $this->person->provider_id = $this->provider_id;


        $this->death->provider_id = $this->provider_id;
        $this->death->user_id = $this->user_id;
        $this->death->owner_id = $this->owner_id;

        $this->load->helper('person');
    }
    public function index()
    {
        $this->layout->view('death/index_view');
    }

    public function save()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            //check person exist
            $person_exist = $this->person->check_owner($data['hn']);

            if($person_exist)
            {
                if($data['isupdate'] == '1')
                {
                    //update
                    $rs = $this->death->update($data);

                    //update death status
                    if($data['dchstatus'] == '1')
                    {
                        $this->person->change_discharge_status($data['hn'], '1');
                    }

                    if($rs)
                    {
                        $json = '{"success": true, "msg": "Updated"}';
                    }
                    else
                    {
                        $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                    }

                }
                else
                {
                    $exist = $this->death->check_exist($data['hn']);
                    if($exist)
                    {
                        $json = '{"success": false, "msg": "มีข้อมูลบุคคลนี้ในทะเบียนแล้ว กรุณาตรวจสอบ/แก้ไข"}';
                    }
                    else
                    {
                        //register
                        $rs = $this->death->save($data);
                        //update death status
                        if($data['dchstatus'] == '1')
                        {
                            $this->person->change_discharge_status($data['hn'], '1');
                        }

                        if($rs)
                        {
                            $json = '{"success": true, "msg": "Insert"}';
                        }
                        else
                        {
                            $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                        }

                    }
                }
            }
            else
            {
                $json = '{"success": "ไม่ใช่กลุ่มเป้าหมาย (Typearea ไม่ใช่ 1 หรือ 3) : HN = " '. $data['hn'] . '}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
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

        $rs = $this->death->get_list($start, $limit);

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {
                $person = $this->person->get_person_detail_with_hn($r['hn']);
                $obj                = new stdClass();
                $obj->hn            = $r['hn'];
                $obj->cid           = $person['cid'];
                $obj->id            = get_first_object($r['_id']);
                $obj->first_name    = $person['first_name'];
                $obj->last_name     = $person['last_name'];
                $obj->sex           = $person['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate     = $person['birthdate'];
                $obj->age           = count_age($person['birthdate']);
                $obj->ddeath      = from_mongo_to_thai_date($r['ddeath']);
                $obj->icd_code     = $this->basic->get_diag_name($r['cdeath']);

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
        $total = $this->death->get_list_total();

        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }
    //================== Remove death =====================//
    public function remove()
    {
        $hn = $this->input->post('hn');
        $dchstatus = $this->input->post('dchstatus');

        if(!empty($hn))
        {
            $this->death->remove($hn);
            //change person discharge_status to '9'
            if(!empty($dchstatus))
            {
                $this->person->change_discharge_status($hn, '9');
            }

            $json = '{"success": true}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
        }

        render_json($json);

    }

    public function search()
    {
        $query = $this->input->post('query');
        $rs = $this->death->search_by_hn($query);

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {
                $person = $this->person->get_person_detail_with_hn($r['hn']);

                $obj                = new stdClass();
                $obj->hn            = $r['hn'];
                $obj->cid           = $person['cid'];
                $obj->id            = get_first_object($r['_id']);
                $obj->first_name    = $person['first_name'];
                $obj->last_name     = $person['last_name'];
                $obj->sex           = $person['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate     = $person['birthdate'];
                $obj->age           = count_age($person['birthdate']);
                $obj->ddeath        = from_mongo_to_thai_date($r['ddeath']);
                $obj->icd_code      = $this->basic->get_diag_name($r['cdeath']);

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

    public function get_detail()
    {
        $hn = $this->input->post('hn');
        if(!empty($hn))
        {
            $rs = $this->death->get_detail($hn);
            if($rs)
            {
                $obj = new stdClass();
                $obj->cdeath        = $rs['cdeath'];
                $obj->cdeath_name   = $this->basic->get_diag_name($obj->cdeath);
                $obj->odisease      = $rs['odisease'];
                $obj->odisease_name = $this->basic->get_diag_name($obj->cdeath);
                $obj->cdeath_a      = $rs['cdeath_a'];
                $obj->cdeath_a_name = $this->basic->get_diag_name($obj->cdeath_a);
                $obj->cdeath_b      = $rs['cdeath_b'];
                $obj->cdeath_b_name = $this->basic->get_diag_name($obj->cdeath_b);
                $obj->cdeath_c      = $rs['cdeath_c'];
                $obj->cdeath_c_name = $this->basic->get_diag_name($obj->cdeath_c);
                $obj->cdeath_d      = $rs['cdeath_d'];
                $obj->cdeath_d_name = $this->basic->get_diag_name($obj->cdeath_d);
                $obj->pregdeath     = $rs['pregdeath'];
                $obj->ddeath        = from_mongo_to_thai_date($rs['ddeath']);
                $obj->hospdeath     = $rs['hospdeath'];
                $obj->hospdeath_name= $this->basic->get_hospital_name($obj->hospdeath);
                $obj->pdeath        = $rs['pdeath'];

                $rows = json_encode($obj);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg": "ไม่พบรายการ"}';
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการค้นหา"}';
        }

        render_json($json);
    }
}

/* End of file death.php */
/* Location: ./application/controllers/death.php */