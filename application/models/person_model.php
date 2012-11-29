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
            'hid'           => $data['hid'],
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

    public function get_house_survey($house_id){
        $result = $this->mongo_db
                        ->select(array('surveys'))
                        ->where(array('_id' => new MongoId($house_id)))->get('houses');
        return count($result) > 0 ? $result[0] : null;
    }

    public function save_house_survey($data){
        $result = $this->mongo_db
                        ->where('_id', new MongoId($data['house_id']))
                        ->set(
                                array(
                                    'surveys.latitude'      => $data['latitude'],
                                    'surveys.longitude'     => $data['longitude'],
                                    'surveys.locatype'      => $data['locatype'],
                                    'surveys.vhvid'         => $data['vhvid'],
                                    'surveys.headid'        => $data['headid'],
                                    'surveys.toilet'        => $data['toilet'],
                                    'surveys.water'         => $data['water'],
                                    'surveys.watertype'     => $data['watertype'],
                                    'surveys.garbage'       => $data['garbage'],
                                    'surveys.housing'       => $data['housing'],
                                    'surveys.durability'    => $data['durability'],
                                    'surveys.cleanliness'   => $data['cleanliness'],
                                    'surveys.ventilation'   => $data['ventilation'],
                                    'surveys.light'         => $data['light'],
                                    'surveys.watertm'       => $data['watertm'],
                                    'surveys.mfood'         => $data['mfood'],
                                    'surveys.bcontrol'      => $data['bcontrol'],
                                    'surveys.acontrol'      => $data['acontrol'],
                                    'surveys.chemical'      => $data['chemical']
                                )
                        )
                        ->update('houses');
        return $result;
    }
    public function save_person($data){
        $result = $this->mongo_db->insert('person', array(
            'cid'               => $data['cid'],
            'hn'                => $data['hn'],
            'owner_id'          => new MongoId($this->owner_id),
            'house_code'        => $data['house_code'],
            'title'             => new MongoId($data['title']),
            'first_name'        => $data['first_name'],
            'last_name'         => $data['last_name'],
            'sex'               => $data['sex'],
            'birthdate'         => toStringDate($data['birthdate']),
            'mstatus'           => new MongoId($data['mstatus']),
            'occpuation'        => new MongoId($data['occupation']),
            'race'              => new MongoId($data['race']),
            'nation'            => new MongoId($data['nation']),
            'religion'          => new MongoId($data['religion']),
            'education'         => new MongoId($data['education']),
            'fstatus'           => $data['fstatus'],
            'father_cid'        => $data['father_cid'],
            'mother_cid'        => $data['mother_cid'],
            'couple_cid'        => $data['couple_cid'],
            'vstatus'           => $data['vstatus'],
            'movein_date'       => toStringDate($data['movein_date']),
            'discharge_status'  => $data['discharge_status'],
            'discharge_date'    => toStringDate($data['discharge_date']),
            'abogroup'           => $data['abogroup'],
            'rhgroup'           => $data['rhgroup'],
            'labor_type'        => new MongoId($data['labor_type']),
            'passport'          => $data['passport'],
            'typearea'          => $data['typearea']
        ));

        return $result; //return _id
    }

    public function save_person_address($person_id, $data){
        $result = $this->mongo_db->insert('address', array(
            'person_id'     => new MongoId($person_id),
            'address_type'  => $data['address_type'],
            'house_id'      => new MongoId($data['house_id']),
            'house_type'    => new MongoId($data['house_type']),
            'room_no'       => $data['room_no'],
            'condo'         => $data['condo'],
            'houseno'       => $data['houseno'],
            'soi_sub'       => $data['soi_sub'],
            'soi_main'      => $data['soi_main'],
            'road'          => $data['road'],
            'village_name'  => $data['village_name'],
            'village'       => $data['village'],
            'tambon'        => $data['tambon'],
            'ampur'         => $data['ampur'],
            'changwat'      => $data['changwat'],
            'postcode'      => $data['postcode'],
            'telephone'     => $data['telephone'],
            'mobile'        => $data['mobile']
        ));

        return $result;
    }

    public function check_house_exist($house_id){

        $result = $this->mongo_db->where(array('_id' => new MongoId($house_id)))->count('houses');

        return $result > 0 ? TRUE : FALSE;
    }


    public function check_person_exist($cid){

        $result = $this->mongo_db->where(array('cid' => (string) $cid))->count('person');

        return $result > 0 ? TRUE : FALSE;
    }
}