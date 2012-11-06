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
                        ->select(array('inscl', 'name'))
                        ->order_by(array('inscl' => 1))
                        ->get('inscl');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

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
        return $result;
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

}