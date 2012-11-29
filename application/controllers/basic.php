<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Basic Controller
 *
 * Basic Controller information
 *
 * @package     Controller
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Basic extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/access_denied'));
        }

        $this->load->model('Basic_model', 'basic');
    }

    public function index()
    {
        show_404();
    }

    public function search_hospital(){
        $op = $this->input->post('op');
        $query = $this->input->post('query');

        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{
            if($op == 1){
                //search by name
                $result = $this->basic->search_hospital_by_name($query);
            }else{
                //search by code
                $result = $this->basic->search_hospital_by_code($query);
            }

            $rows = json_encode($result);

            $json = '{"success": true, "rows": '.$rows.'}';
        }

        render_json($json);
    }

    public function get_ampur(){

        $chw = $this->input->post('chw');
        $result = $this->basic->get_ampur($chw);
        $rows = json_encode($result);

        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }
    public function get_tambon(){

        $chw = $this->input->post('chw');
        $amp = $this->input->post('amp');
        $result = $this->basic->get_tambon($chw, $amp);
        $rows = json_encode($result);

        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }
/*
    public function get_inscl(){

        $result = $this->basic->get_inscl();
        $rows = json_encode($result);

        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }
    public function get_occupation(){

        $result = $this->basic->get_occupation();

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }
        $rows = json_encode($arr_result);

        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }
    public function get_title(){

        $result = $this->basic->get_title();

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }
        $rows = json_encode($arr_result);

        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }
    public function get_marry_status(){

        $result = $this->basic->get_marry_status();

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }
        $rows = json_encode($arr_result);

        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }

    public function get_education(){

        $result = $this->basic->get_education();

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        $rows = json_encode($arr_result);

        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }
*/
}