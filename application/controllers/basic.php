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

    public function search_hospital_ajax(){
        $query = $this->input->post('query');

        if(!empty($query)){

            if(is_numeric($query)){
                //search by code
                $result = $this->basic->search_hospital_ajax_by_code($query);
            }else{
                //search by name
                $result = $this->basic->search_hospital_ajax_by_name($query);
            }
            $rows=  json_encode($result);

            $json = '{"success": true, "rows": '.$rows.'}';
        }else{
            $json = '{"success": false, "msg": "Query empty."}';
        }

        render_json($json);

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

    public function search_drug(){
        $query = $this->input->post('query');
        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{
            $result = $this->basic->search_drug($query);
            if($result){
                $arr_result = array();
                foreach ($result as $r) {
                    $obj = new stdClass();
                    $obj->id = get_first_object($r['_id']);
                    $obj->name = $r['name'];
                    $obj->unit = $r['unit'];
                    $obj->cost = $r['cost'];
                    $obj->price = $r['price'];
                    $obj->stdcode = $r['stdcode'];
                    $obj->streng = get_streng_name($r['streng_code']);

                    array_push($arr_result, $obj);
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }
    public function search_icd(){
        $query = $this->input->post('query');
        $op = $this->input->post('op');

        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{
            if($op == '1'){
                $result = $this->basic->search_icd10_by_code($query);
            }else{
                $result = $this->basic->search_icd10_by_name($query);
            }

            if($result){
                $arr_result = array();
                foreach ($result as $r) {
                    $obj = new stdClass();
                    $obj->code = $r['code'];
                    $obj->desc_r = $r['desc_r'];
                    $obj->valid = $r['valid'];
                    $obj->chronic = $r['chronic'];

                    array_push($arr_result, $obj);
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }
    public function search_icd_chronic_ajax(){
        $query = $this->input->post('query');
        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{

            $op = has_number($query);

            if($op){
                $result = $this->basic->search_icd_chronic_by_code($query);
            }else{
                $result = $this->basic->search_icd_chronic_by_name($query);
            }

            if($result){
                $arr_result = array();
                foreach ($result as $r) {
                    $obj = new stdClass();
                    $obj->name = $r['code'] . '#' . $r['desc_r'];

                    array_push($arr_result, $obj);
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }



    public function search_drug_usage(){
        $query = $this->input->post('query');
        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{

            $op = has_number($query);

            if($op){
                $rs = $this->basic->search_drug_usage_by_alias($query);
            }else{
                $rs = $this->basic->search_drug_usage_by_name($query);
            }

            if($rs){
                $rows = json_encode($rs);
                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }

    public function search_icd_ajax(){
        $query = $this->input->post('query');
        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{

            $op = has_number($query);

            if($op){
                $result = $this->basic->search_icd_by_code($query);
            }else{
                $result = $this->basic->search_icd_by_name($query);
            }

            if($result){
                $arr_result = array();
                foreach ($result as $r) {
                    $obj = new stdClass();
                    $obj->name = $r['code'] . '#' . $r['desc_r'];

                    array_push($arr_result, $obj);
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }

    public function search_charge_item_ajax(){
        $query = $this->input->post('query');
        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{

            $result = $this->basic->search_charge_item_ajax($query);

            if($result){
                $arr_result = array();
                foreach ($result as $r) {
                    $obj = new stdClass();
                    $obj->name = $r['code'] . '|' . $r['name'] . '|' . $r['price'] . '|' . $r['unit'];

                    array_push($arr_result, $obj);
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }

    public function search_procedure_ajax(){
        $query = $this->input->post('query');
        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{

            $op = has_number($query);

            if($op){
                $result = $this->basic->search_procedure_by_code($query);
            }else{
                $result = $this->basic->search_procedure_by_name($query);
            }

            if($result){
                $arr_result = array();
                foreach ($result as $r) {
                    $obj = new stdClass();
                    $obj->name = $r['code'] . '#' . $r['desc_r'];

                    array_push($arr_result, $obj);
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }
    public function search_provider_ajax(){
        $query = $this->input->post('query');
        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{

            $op = has_number($query);

            if($op){
                $result = $this->basic->search_provider_by_code($query);
            }else{
                $result = $this->basic->search_provider_by_name($query);
            }

            if($result){
                $arr_result = array();
                foreach ($result as $r) {
                    $obj = new stdClass();
                    $obj->name = $r['provider'] . '#' . $r['first_name'] . ' ' . $r['last_name'];

                    array_push($arr_result, $obj);
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }else{
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }

    public function search_drug_ajax(){
        $query = $this->input->post('query');
        if(empty($query)){
            $json = '{"success": false, "msg": "No result."}';
        }else{
            $rs = $this->basic->search_drug_ajax($query);
            $rows = json_encode($rs);

            $json = '{"success": true, "rows": '.$rows.'}';
        }

        render_json($json);
    }

    public function get_pp_special_list()
    {
        $rs = $this->basic->get_pp_special_list();

        $rows = json_encode($rs);
        $json = '{"success": true, "rows": '. $rows .'}';

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

    public function test(){
        $subject = "GreenWithEnvy15";
        preg_match_all('/[0-9]/', $subject, $matches);
        $count = count($matches[0]);
        echo $count; //echos number of integers in $subject

    }
}