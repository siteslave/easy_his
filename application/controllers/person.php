<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller
 *
 * Controller information information
 *
 * @package     Controller
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Person extends CI_Controller
{
    /*
     * Owner id for assign owner.
     */
    var $owner_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        //load model
        $this->load->model('Person_model', 'person');
        $this->load->model('Basic_model', 'basic');

        $this->csrf_token = $this->security->get_csrf_hash();

        $this->twiggy->set('site_url', site_url());
        $this->twiggy->set('base_url', base_url());
        $this->twiggy->set('csrf_token', $this->csrf_token);

        $this->twiggy->set('fullname', $this->session->userdata('fullname'));

    }

    //index action
    public function index()
    {
        $this->twiggy->template('person/index')->display();
    }

    public function register($house_id=''){
        if(empty($house_id)){
            show_error('No house id found.', 505);
        }else{
            $educations = $this->basic->get_education();
            $titles = $this->basic->get_title();
            $inscls = $this->basic->get_inscl();
            $occupations = $this->basic->get_occupation();
            $marry_status = $this->basic->get_marry_status();
            $races = $this->basic->get_races();
            $nationalities = $this->basic->get_nationalities();
            $religions = $this->basic->get_religions();
            $provinces = $this->basic->get_province();
            $typearea = $this->basic->get_typearea();
            $labor_types = $this->basic->get_labor_type();
            $vstatus = $this->basic->get_vstatus();
            $house_type = $this->basic->get_house_type();

            $this->twiggy->set('educations', $educations);
            $this->twiggy->set('titles', $titles);
            $this->twiggy->set('inscls', $inscls);
            $this->twiggy->set('occupations', $occupations);
            $this->twiggy->set('races', $races);
            $this->twiggy->set('nationalities', $nationalities);
            $this->twiggy->set('religions', $religions);
            $this->twiggy->set('marry_statuses', $marry_status);
            $this->twiggy->set('provinces', $provinces);
            $this->twiggy->set('typearea', $typearea);
            $this->twiggy->set('labor_types', $labor_types);
            $this->twiggy->set('vstatus', $vstatus);
            $this->twiggy->set('house_type', $house_type);

            $this->twiggy->set('house_id', $house_id);
            $this->twiggy->template('person/register')->display();
        }

    }

    public function get_villages(){

        $this->person->owner_id = $this->owner_id;
        $result = $this->person->get_villages();

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->village_code = $r['village_code'];
            $obj->village_name = $r['village_name'];
            $obj->moo = substr($r['village_code'], 6, 2);
            $obj->id = get_first_object($r['_id']);
            array_push($arr_result, $obj);
        }

        $rows = json_encode($arr_result);

        $json = '{"success": true, "rows": '.$rows.'}';

        render_json($json);
    }

    public function get_houses(){

        $village_id = $this->input->post('village_id');
        if(empty($village_id)){
            $json = '{"success": false, "msg": "No village id found."}';
        }else{
            $result = $this->person->get_houses($village_id);

            $arr_result = array();
            foreach($result as $r){
                $obj = new stdClass();

                $obj->house = $r['house'];
                $obj->id = get_first_object($r['_id']);
                $obj->house_id = $r['house_id'];

                array_push($arr_result, $obj);
            }

            $rows = json_encode($arr_result);

            $json = '{"success": true, "rows": '. $rows .'}';
        }

        render_json($json);
    }

    /**
     * Save new house
     *
     * @internal    param   mixed   $data
     *
     * @return      json
     */
    public function save_house(){

        $data = $this->input->post('data');

        if(!$data){
            $json = '{"success": false, "msg": "No data for save"}';
        }else{
            //check house duplicate
            $duplicated = $this->person->check_duplicate_house($data['house'], $data['village_id']);


            //if house duplicate return false
            if($duplicated){
                $json = '{"success": false, "msg": "House duplicated"}';
            //if don't duplicate save new house
            }else{
                $data['hid'] = generate_serial('HOUSE', FALSE);
                $this->person->owner_id = $this->owner_id;
                $result = $this->person->save_house($data);

                if($result){
                    $json = '{"success": true}';
                }else{
                    $json = '{"success": false, "msg": "Model error."}';
                }
            }
        }
        //render json
        render_json($json);
    }

    public function search_dbpop(){
        $cid = $this->input->post('cid');
        if(empty($cid)){
            $json = '{"success": false, "msg": "No cid found."}';
        }else{
            $result = $this->person->search_dbpop($cid);

            if($result){
                $arr_result = array();
                foreach($result as $r){
                    $obj = new stdClass();

                    $obj->fname = $r['fname'];
                    $obj->lname = $r['lname'];
                    $obj->birthdate = $r['birthdate'];
                    $obj->maininscl = $r['maininscl'];
                    $obj->maininscl_name = get_main_inscl($r['maininscl']);
                    $obj->cid = $r['pid'];
                    $obj->subinscl = $r['subinscl'];
                    $obj->sex = $r['sex'];
                    $obj->cardid = $r['cardid'];
                    $obj->hmain_code = (string) $r['hmain'];
                    $obj->hmain_code = strlen($obj->hmain_code) < 5 ? '0' . $obj->hmain_code : (string) $r['hmain'];
                    $obj->hsub_code = (string) $r['hsub'];
                    $obj->hsub_code = strlen($obj->hsub_code) < 5 ? '0' . $obj->hsub_code : (string) $r['hsub'];
                    $obj->hmain_name = get_hospital_name($obj->hmain_code);
                    $obj->hsub_name = get_hospital_name($obj->hsub_code);
                    $obj->startdate = $r['startdate'];
                    $obj->expdate = $r['expdate'];

                    array_push($arr_result, $obj);
                }

                $rows = json_encode($arr_result);

                $json = '{"success": true, "rows": '. $rows .'}';
            }else{
                $json = '{"success"": false, "msg": "No result found"}';
            }
        }

        render_json($json);
    }

    public function save_house_survey(){
        $data = $this->input->post('data');

        if(!$data){
            $json = '{"success": false, "msg": "No data for save"}';
        }else{
            //check house duplicate
            $house_exist = $this->person->check_house_exist($data['house_id']);

            //if house duplicate return false
            if(!$house_exist){
                $json = '{"success": false, "msg": "No house id found"}';
                //if don't duplicate save new house
            }else{
                $this->person->owner_id = $this->owner_id;
                $result = $this->person->save_house_survey($data);

                if($result){
                    $json = '{"success": true}';
                }else{
                    $json = '{"success": false, "msg": "Model error."}';
                }
            }
        }
        //render json
        render_json($json);

    }

    public function get_house_survey(){
        $house_id = $this->input->post('house_id');

        if(empty($house_id)){
            $json = '{"success": false, "msg": "No house id found"}';
        }else{
            //check house exist
            $house_exist = $this->person->check_house_exist($house_id);

            //if house exist
            if(!$house_exist){
                $json = '{"success": false, "msg": "No house id found"}';
            }else{
                $result = $this->person->get_house_survey($house_id);

                $rows = json_encode($result);
                if($result){
                    $json = '{"success": true, "rows": '.$rows.'}';
                }else{
                    $json = '{"success": false, "msg": "Model error."}';
                }
            }
        }
        //render json
        render_json($json);

    }

    public function save(){
        $data = $this->input->post('data');
        if(empty($data)){
            $json = '{"success": false, "msg": "No data found"}';
        }else{
            //check cid
            $person_exist = $this->person->check_person_exist($data['cid']);
            if($person_exist){
                $json = '{"success": false, "msg": "CID duplicate."}';
            }else{
                $data['hn'] = generate_serial('HN');
                $this->person->owner_id = $this->owner_id;

                $result = $this->person->save_person($data);

                if($result){
                    //save address
                    if($data['typearea'] == '3' || $data['typearea'] == '4' || $data['typearea'] == '0'){
                        $person_id = $result;
                        $res = $this->person->save_person_address($person_id, $data['address']);
                        if($res){
                            $json = '{"success": true}';
                        }else{
                            $json = '{"success": false, "save address failed."}';
                        }
                    }
                }else{
                    $json = '{"success": false, "msg": "Model error"}';
                }
            }
        }

        render_json($json);
    }
}