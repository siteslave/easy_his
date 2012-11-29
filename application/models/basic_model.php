<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model
 *
 * Model information information
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Basic_model extends CI_Model
{

    public function __construct(){
        parent::__construct();
    }
    public function get_inscl()
    {
        $result = $this->mongo_db
                        ->order_by(array('inscl' => 1))
                        ->get('basic_inscl');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['inscl'];
            $obj->name = $r['name'];
            //$obj->c = $r['inscl'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_occupation()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('basic_occupation');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_labor_type()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('basic_labor_types');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_title()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('basic_title');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_marry_status()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('basic_marry_status');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_education()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('basic_education');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_vstatus()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('basic_vstatus');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_house_type()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('basic_house_type');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_typearea()
    {
        $result = $this->mongo_db->order_by(array('code' => 1))->get('basic_typearea');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['code'];
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_races()
    {
        $result = $this->mongo_db
                        ->where(array('actived' => 'Y'))
                        ->order_by(array('name' => 1))->get('basic_races');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_nationalities()
    {
        $result = $this->mongo_db
                        ->where(array('actived' => 'Y'))
                        ->order_by(array('name' => 1))->get('basic_nationalities');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_religions()
    {
        $result = $this->mongo_db
                        ->where(array('actived' => 'Y'))
                        ->order_by(array('name' => 1))->get('basic_religions');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function search_hospital_by_name($query){

        $this->mongo_db->add_index('hospitals', array('hospname' => -1));

        $result = $this->mongo_db
                        ->like('hospname', $query)
                        ->order_by(array('hospcode' => 1))
                        ->limit(25)
                        ->get('hospitals');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['hospcode'];
            $obj->name = $r['hospname'];
            $obj->province = get_changwat($r['changwat']);

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function search_hospital_by_code($query){
        $this->mongo_db->add_index('hospitals', array('hospcode' => -1));

        $result = $this->mongo_db
                        ->order_by(array('hospcode' => 1))
                        ->where(array('hospcode' => $query))
                        ->get('hospitals');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['hospcode'];
            $obj->name = $r['hospname'];
            $obj->province = get_changwat($r['changwat']);

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_province(){
        $this->mongo_db->add_index('provinces', array('code' => -1));

        $result = $this->mongo_db
            ->order_by(array('name' => 1))
            ->get('provinces');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['code'];
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }


    public function get_ampur($chw){
        $this->mongo_db->add_index('catms', array('catm_code' => -1));
        $this->mongo_db->add_index('catms', array('changwat' => -1));
        $this->mongo_db->add_index('catms', array('ampur' => -1));
        $this->mongo_db->add_index('catms', array('tambon' => -1));
        $this->mongo_db->add_index('catms', array('moo' => -1));

        $result = $this->mongo_db
            ->where(array('changwat' => $chw))
            ->where(array('tambon' => '00'))
            ->where(array('moo' => '00'))
            ->where_ne('ampur', '00')
            ->order_by(array('catm_name' => 1))
            ->get('catms');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['ampur'];
            $obj->name = $r['catm_name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_tambon($chw, $amp){
        $this->mongo_db->add_index('catms', array('catm_code' => -1));
        $this->mongo_db->add_index('catms', array('changwat' => -1));
        $this->mongo_db->add_index('catms', array('ampur' => -1));
        $this->mongo_db->add_index('catms', array('tambon' => -1));
        $this->mongo_db->add_index('catms', array('moo' => -1));

        $result = $this->mongo_db
            ->where(array('changwat' => $chw))
            ->where(array('ampur' => $amp))
            ->where_ne('tambon', '00')
            ->where(array('moo' => '00'))
            ->order_by(array('catm_name' => 1))
            ->get('catms');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['tambon'];
            $obj->name = $r['catm_name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

}