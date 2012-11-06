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
            $educations = $this->basic->get_education;
            $titles = $this->basic->get_title;
            $inscls = $this->basic->get_inscl;
            $occupations = $this->basic->get_occupation;
            $marry_status = $this->basic->get_marry_status;

            $this->twiggy->set('education', $educations);
            $this->twiggy->set('title', $titles);
            $this->twiggy->set('inscl', $inscls);
            $this->twiggy->set('occupation', $occupations);
            $this->twiggy->set('marry_status', $marry_status);

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
}