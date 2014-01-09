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

    public $owner_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/access_denied'));
        }

        $this->load->model('Basic_model', 'basic');
        $this->load->model('Drug_model', 'drug');
        $this->load->model('Income_model', 'income');

        $this->basic->owner_id = $this->owner_id;
        $this->drug->owner_id = $this->owner_id;
        $this->income->owner_id = $this->owner_id;
    }

    public function index()
    {
        show_404();
    }

    public function search_hospital_ajax(){
        $query = $this->input->post('query');

        $start  = $this->input->post('start');
        $stop   = $this->input->post('stop');

        $start  = empty($start) ? 1 : $start;
        $stop   = empty($stop) ? 10 : $stop;

        $start = ($start - 1) * $stop;

        $limit  = $stop;

        if(!empty($query))
        {

            $rs = $this->basic->search_hospital_ajax($query, $start, $limit);
            $total = $this->basic->search_hospital_ajax_total($query);

            $rows=  json_encode($rs);

            $json = '{"success": true, "rows": '.$rows.', "total": ' . $total . '}';
        }
        else
        {
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
                    $obj->id    = get_first_object($r['_id']);
                    $obj->name  = $r['name'];
                    $obj->unit  = $r['unit'];

                    $pq = $this->drug->get_price_qty($r['_id']);

                    $obj->cost      = $r['cost'];
                    $obj->price     = $pq->price;
                    $obj->qty       = $pq->qty;
                    $obj->stdcode   = $r['did'];
                    $obj->streng    = $r['strength'] .' '.get_strength_name($r['strength_unit']);

                    $arr_result[] = $obj;
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
        $query  = $this->input->post('query');
        $op     = $this->input->post('op');

        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{
            if($op == '1') {
                $result = $this->basic->search_icd10_by_code($query);
            } else {
                $result = $this->basic->search_icd10_by_name($query);
            }

            if($result) {
                $arr_result = array();
                foreach ($result as $r) {
                    $obj = new stdClass();
                    $obj->code      = $r['code'];
                    $obj->desc_r    = $r['desc_r'];
                    $obj->valid     = $r['valid'];
                    $obj->chronic   = $r['chronic'];

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            } else {
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

            if($op) {
                $rs = $this->basic->search_drug_usage_by_alias($query);
            } else {
                $rs = $this->basic->search_drug_usage_by_name($query);
            }

            if($rs) {
                $rows = json_encode($rs);
                $json = '{"success": true, "rows": '.$rows.'}';
            } else {
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }

    public function search_drug_usage_ajax(){
        $query = $this->input->post('query');

        $start  = $this->input->post('start');
        $stop   = $this->input->post('stop');

        $start  = empty($start) ? 1 : $start;
        $stop   = empty($stop) ? 10 : $stop;

        $start  = ($start - 1) * $stop;

        $limit  = $stop;

        if(empty($query)) {
            $json = '{"success": false, "msg": "No query found."}';
        } else {

            $rs = $this->basic->search_drug_usage_by_alias_ajax($query, $start, $limit);
            $total = $this->basic->search_drug_usage_by_alias_ajax_total($query);

            if($rs) {
                $rows = json_encode($rs);
                $json = '{"success": true, "rows": '.$rows.', "total": '.$total.'}';
            } else {
                $json = '{"success": false, "msg": "ไม่พบรายการ"}';
            }
        }

        render_json($json);
    }

    public function search_icd_ajax() {
        $query = $this->input->post('query');

        $start  = $this->input->post('start');
        $stop   = $this->input->post('stop');

        $start  = empty($start) ? 1 : $start;
        $stop   = empty($stop) ? 10 : $stop;

        $start  = ($start - 1) * $stop;

        $limit  = $stop;


        if(empty($query)) {
            $json = '{"success": false, "msg": "No query found."}';
        } else {

            $op = has_number($query);

            if($op){
                $result = $this->basic->search_icd_by_code($query, $start, $limit);
                $total = $this->basic->search_icd_by_code_total($query);
            }else{
                $result = $this->basic->search_icd_by_name($query, $start, $limit);
                $total = $this->basic->search_icd_by_name_total($query);
            }

            if($result){
                $arr_result = array();
                foreach ($result as $r) {
                    $obj = new stdClass();
                    $obj->code = $r['code'];
                    $obj->name = $r['desc_r'];
                    array_push($arr_result, $obj);
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.', "total": '.$total.'}';
            }else{
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }

    public function search_charge_item_ajax(){
        $query = $this->input->post('query');
        $start  = $this->input->post('start');
        $stop   = $this->input->post('stop');

        $start  = empty($start) ? 1 : $start;
        $stop   = empty($stop) ? 10 : $stop;

        $start = ($start - 1) * $stop;

        $limit  = $stop;

        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{

            $result = $this->basic->search_charge_item_ajax($query, $start, $limit);
            $total = $this->basic->search_charge_item_ajax_total($query);

            if($result){
                $arr_result = array();
                foreach ($result as $r) {
                    $pq = $this->income->get_price_qty($r['_id']);
                    $obj = new stdClass();
                    $obj->vprice    = isset($pq->price) ? $pq->price : 0;
                    $obj->name      = $r['name'];
                    $obj->id        = get_first_object($r['_id']);
                    #$obj->name = $r['name'] . '|' . $vprice . '|' . $r['unit'] . '|' . get_first_object($r['_id']);

                    $arr_result[]   = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.', "total": '.$total.'}';
            } else {
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }

    public function search_procedure_extra_ajax(){
        $query  = $this->input->post('query');

        $start  = $this->input->post('start');
        $stop   = $this->input->post('stop');

        $start  = empty($start) ? 1 : $start;
        $stop   = empty($stop) ? 10 : $stop;

        $start  = ($start - 1) * $stop;

        $limit  = $stop;

        if(empty($query)) {
            $json = '{"success": false, "msg": "No query found."}';
        } else {

            $result = $this->basic->search_procedure_extra($query, $start, $limit);
            $total = $this->basic->search_procedure_extra_count($query);

            if($result) {
                $arr_result = array();
                foreach ($result as $r) {
                    $obj = new stdClass();
                    $obj->code = $r['procedure'];
                    $obj->name = $r['th_name'];
                    $obj->price = $r['price'];
                    //$obj->eng_name = $r['eng_name'];

                    array_push($arr_result, $obj);
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.', "total": '.$total.'}';
            } else {
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }

    public function get_procedure_extra_total() {
        $rs = $this->basic->get_procedure_extra_total();

        $json = '{"success": true, "total": ' . $rs . '}';

        render_json($json);
    }

    public function get_procedure_extra_list(){

        $start  = $this->input->post('start');
        $stop   = $this->input->post('stop');

        $start  = empty($start) ? 0 : $start;
        $stop   = empty($stop) ? 25 : $stop;

        $limit  = (int) $stop - (int) $start;

        $rs     = $this->basic->get_procedure_extra_list($start, $limit);

        if($rs) {
            $arr_result = array();
            foreach ($rs as $r) {
                $obj = new stdClass();
                $obj->code      = $r['procedure'];
                $obj->name      = $r['th_name'];
                $obj->price     = $r['price'];
                $obj->eng_name  = $r['eng_name'];

                $arr_result[] = $obj;
            }

            $rows = json_encode($arr_result);
            $json = '{"success": true, "rows": '.$rows.'}';

        } else {
            $json = '{"success": false, "msg": "No data."}';
        }

        render_json($json);
    }

    public function search_procedure_ajax(){
        $query  = $this->input->post('query');

        $start  = $this->input->post('start');
        $stop   = $this->input->post('stop');

        $start  = empty($start) ? 1 : $start;
        $stop   = empty($stop) ? 10 : $stop;

        $start  = ($start - 1) * $stop;

        $limit  = $stop;

        if(empty($query)){
            $json = '{"success": false, "msg": "No query found."}';
        }else{

            $op = has_number($query);

            if($op){
                $result = $this->basic->search_procedure_by_code($query, $start, $limit);
                $total = $this->basic->search_procedure_by_code_count($query);
            }else{
                $result = $this->basic->search_procedure_by_name($query, $start, $limit);
                $total = $this->basic->search_procedure_by_name_count($query);
            }

            if($result){
                $arr_result = array();
                foreach ($result as $r) {
                    $obj            = new stdClass();
                    $obj->code      = $r['code'];
                    $obj->name      = $r['desc_r'];

                    $arr_result[]   = $obj;
                }
                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.', "total": '.$total.'}';
            }else{
                $json = '{"success": false, "msg": "No data."}';
            }
        }

        render_json($json);
    }

//    public function search_provider_ajax(){
//        $query = $this->input->post('query');
//        if(empty($query)){
//            $json = '{"success": false, "msg": "No query found."}';
//        }else{
//
//            $op = has_number($query);
//
//            if($op){
//                $result = $this->basic->search_provider_by_code($query);
//            }else{
//                $result = $this->basic->search_provider_by_name($query);
//            }
//
//            if($result){
//                $arr_result = array();
//                foreach ($result as $r) {
//                    $obj            = new stdClass();
//                    $obj->name      = $r['provider'] . '#' . $r['first_name'] . ' ' . $r['last_name'];
//
//                    $arr_result[]   = $obj;
//                }
//                $rows = json_encode($arr_result);
//                $json = '{"success": true, "rows": '.$rows.'}';
//            }else{
//                $json = '{"success": false, "msg": "No data."}';
//            }
//        }
//
//        render_json($json);
//    }

    public function search_drug_ajax(){

        $query = $this->input->post('query');

        $start  = $this->input->post('start');
        $stop   = $this->input->post('stop');

        $start  = empty($start) ? 1 : $start;
        $stop   = empty($stop) ? 10 : $stop;

        $start = ($start - 1) * $stop;

        $limit  = $stop;

        if(empty($query)){
            $json = '{"success": false, "msg": "No result."}';
        }else{

            $rs     = $this->basic->search_drug_ajax($query, $start, $limit);
            $total  = $this->basic->search_drug_ajax_total($query);
            $rows   = json_encode($rs);

            $json   = '{"success": true, "rows": '.$rows.', "total": '.$total.'}';
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

    public function get_icf()
    {
        $disb_id    = $this->input->post('disb_id');
        $rs         = $this->basic->get_icf_list($disb_id);

        $arr_result = array();
        foreach($rs as $r)
        {
            $obj                = new stdClass();
            $obj->id            = get_first_object($r['_id']);
            $obj->export_code   = $r['export_code'];
            $obj->name          = $r['name'];
            $arr_result[]       = $obj;
        }

        $rows = json_encode($arr_result);
        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }

    public function get_strength_list()
    {
        $rs = $this->basic->get_strength_list($this->owner_id);

        $rows = json_encode($rs);
        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }

    public function get_providers()
    {
        $rs     = $this->basic->get_providers();
        $rows   = json_encode($rs);
        $json   = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }

    public function get_clinics()
    {
        $rs     = $this->basic->get_clinic();
        $rows   = json_encode($rs);
        $json   = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }

}