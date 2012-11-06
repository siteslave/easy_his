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

class Person_model extends CI_Model
{

    var $owner_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_villages(){

        $this->mongo_db->add_index('villages', array('owner_id' => -1));

        $result = $this->mongo_db
                        ->where(array('owner_id' => $this->owner_id))
                        ->order_by(array('village_code' => 1))
                        ->get('villages');
        return $result;
    }

    public function get_houses($village_id){

        $this->mongo_db->add_index('houses', array('village_id' => -1));

        $result = $this->mongo_db
                        ->where(array('village_id' => new MongoId($village_id)))
                        ->order_by(array('_id' => 1))
                        ->get('houses');
        return $result;
    }

    public function save_house($data){

        $result = $this->mongo_db->insert('houses', array(
            'owner_id'      => new MongoId($this->owner_id),
            'house'         => $data['house'],
            'house_id'      => $data['house_id'],
            'house_type'    => $data['house_type'],
            'room_no'       => $data['room_no'],
            'condo'         => $data['condo'],
            'soi_sub'       => $data['soi_sub'],
            'soi_main'      => $data['soi_main'],
            'road'          => $data['road'],
            'village_name'  => $data['village_name'],
            'village_id'    => new MongoId($data['village_id'])
        ));

        return $result;
    }

    public function check_duplicate_house($house, $village_id){

        $this->mongo_db->add_index('houses', array('house' => -1));
        $this->mongo_db->add_index('houses', array('owner_id' => -1));
        $this->mongo_db->add_index('houses', array('village_id' => -1));

        $result = $this->mongo_db->where(array('house' => $house))
                                //->where(array('owner_id' => new MongoId($this->owner_id)))
                                ->where(array('village_id' => new MongoId($village_id)))
                                ->count('houses');

        return $result > 0 ? TRUE : FALSE;
    }

    public function search_dbpop($cid){
        $this->mongo_db->add_index('dbpop', array('pid' => -1));
        $result = $this->mongo_db->where(array('pid' => (float) $cid))->get('dbpop');
        return $result;
    }

}