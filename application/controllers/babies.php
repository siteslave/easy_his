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

class Babies extends CI_Controller
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

        $this->load->model('Babies_model', 'babies');
        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');
        $this->load->model('Pregnancies_model', 'preg');

        $this->load->helper(array('person'));
    }

    public function index()
    {
        $this->person->owner_id = $this->owner_id;

        $data['villages'] = $this->person->get_villages();
        $this->layout->view('babies/index_view', $data);
    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Search person
    *
    * @internal param	string 	$query	The query for search
    * @internal param	string	$filter	The filter type. 0 = CID, 1 = HN, 2 = First name and last name
    */
    public function search_person()
    {
        $query = $this->input->post('query');
        $filter = $this->input->post('filter');

        $filter = empty($filter) ? '0' : $filter;

        if(empty($query))
        {
            $json = '{"success": false, "msg": "No query found"}';
        }
        else
        {

            if($filter == '0') //by cid
            {
                $rs = $this->person->search_person_by_cid($query);
            }
            else if($filter == '2')
            {
                //get hn by first name and last name
                $name = explode(' ', $query); // [0] = first name, [1] = last name

                $first_name = count($name) == 2 ? $name[0] : '';
                $last_name = count($name) == 2 ? $name[1] : '';

                $rs = $this->person->search_person_by_first_last_name($first_name, $last_name);

            }
            else
            {
                $rs = $this->person->search_person_by_hn($query);
            }

            if($rs)
            {

                $arr_result = array();

                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->id = get_first_object($r['_id']);
                    $obj->hn = $r['hn'];
                    $obj->cid = $r['cid'];
                    $obj->first_name = $r['first_name'];
                    $obj->last_name = $r['last_name'];
                    $obj->birthdate = $r['birthdate'];
                    $obj->sex = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                    $obj->age = count_age($r['birthdate']);

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg ": "ไม่พบรายการ"}';
            }

        }

        render_json($json);
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Register new baby
     *
     * @internal    param   string  $hn
     * @return      json
     */
    public function do_register()
    {
        $hn = $this->input->post('hn');

        if(empty($hn))
        {
            $json = '{"success": false, "msg": "HN not found."}';
        }
        else
        {

            //check owner
            $is_owner = $this->person->check_owner($hn, $this->owner_id);
            
            if($is_owner)
            {
                $this->babies->owner_id = $this->owner_id;
                $this->babies->user_id = $this->user_id;
                $this->babies->provider_id = $this->provider_id;

                $exists = $this->babies->check_register_status($hn);

                if($exists)
                {
                    $json = '{"success": false, "msg": "ทะเบียนซ้ำ - ชื่อนี้มีอยู่ในทะเบียนเรียบร้อยแล้ว"}';
                }
                else
                {
                    $rs = $this->babies->do_register($hn);

                    if($rs)
                    {
                        $json = '{"success": true}';
                    }
                    else
                    {
                        $json = '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
                    }
                }
            }
            else
            {
                $json = '{"success": false, "msg": "เนื่องจากไม่ใช่ประชากรในการดูแลของหน่วยงาน จึงไม่สามารถลงทะเบียนได้"}';
            }
        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get babies list
     *
     * @internal    param   int $start
     * @internal    param   int $stop
     * @return      json
     */
    public function get_list()
    {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $this->babies->owner_id = $this->owner_id;
        $rs = $this->babies->get_list($start, $limit);

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {
                $person = $this->person->get_person_detail_with_hn($r['hn']);
                $obj = new stdClass();
                $obj->hn = $r['hn'];
                $obj->cid = $person['cid'];
                $obj->id = get_first_object($r['_id']);
                $obj->first_name = $person['first_name'];
                $obj->last_name = $person['last_name'];
                $obj->sex = $person['sex'] == '1' ? 'ชาย' : 'หญิง';
                $obj->birthdate = $person['birthdate'];
                $obj->age = count_age($person['birthdate']);
                $obj->reg_date = $r['reg_date'];

                $arr_result[] = $obj;
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
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get babies total
     *
     * @internal    param  string  $owner_id
     * @return      json
     */
    public function get_list_total()
    {
        $this->babies->owner_id = $this->owner_id;
        $total = $this->babies->get_list_total();

        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get labor detail
     *
     * @internal    param   string  $hn HN of mother.
     * @internal    param   string  $gravida
     * @return      mixed
     */
    public function get_labor_detail()
    {
        $hn = $this->input->post('hn');
        $gravida = $this->input->post('gravida');

        //hn = hn of mother
        if(!empty($hn) AND !empty($gravida))
        {
            $rs_labors = $this->preg->labor_get_detail_by_gravida($hn, $gravida);

            $obj_labors = new stdClass();
            $obj_labors->gravida = $rs_labors['gravida'];
            $obj_labors->bdate = to_js_date($rs_labors['labor']['bdate']);
            $obj_labors->bdoctor = $rs_labors['labor']['bdoctor'];
            $obj_labors->bhosp = $rs_labors['labor']['bhosp'];
            $obj_labors->bhosp_name = get_hospital_name($obj_labors->bhosp);
            $obj_labors->bplace = $rs_labors['labor']['bplace'];
            $obj_labors->bresult_code = $rs_labors['labor']['bresult'];
            $obj_labors->bresult_name = get_diag_name($rs_labors['labor']['bresult']);
            $obj_labors->btime = $rs_labors['labor']['btime'];
            $obj_labors->btype = $rs_labors['labor']['btype'];
            $obj_labors->edc = to_js_date($rs_labors['labor']['edc']);

            $labors = json_encode($obj_labors);

            $json = '{"success": true, "rows": ' . $labors . '}';
        }
        else
        {
            $json = '{"success": false, "msg": "กรุณาระบุ HN"}';
        }

        render_json($json);
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get babies detail
     *
     * @internal    param   string  $hn
     * @return      mixed
     */
    public function get_babies_detail()
    {
        $hn = $this->input->post('hn');

        if(!empty($hn))
        {
            $rs_babies = $this->babies->get_labor_detail($hn);

            $obj_babies = new stdClass();
            $obj_babies->mother_hn = isset($rs_babies['mother_hn']) ? $rs_babies['mother_hn'] : '';
            $obj_babies->birth_no = isset($rs_babies['birth_no']) ? $rs_babies['birth_no'] : '';
            $obj_babies->bweight = isset($rs_babies['bweight']) ? $rs_babies['bweight'] : '';
            $obj_babies->asphyxia = isset($rs_babies['asphyxia']) ? $rs_babies['asphyxia'] : '';
            $obj_babies->vitk = isset($rs_babies['vitk']) ? $rs_babies['vitk'] : '';
            $obj_babies->tshresult = isset($rs_babies['tshresult']) ? $rs_babies['tshresult'] : '';

            $babies = json_encode($obj_babies);

            $json = '{"success": true, "rows": ' . $babies . '}';
        }
        else
        {
            $json = '{"success": false, "msg": "กรุณาระบุ HN"}';
        }

        render_json($json);
    }
}

//End file