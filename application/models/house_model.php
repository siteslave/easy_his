<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * House model
     *
     * @package     Model
     * @author      Satit Rianpit <rianpit@gmail.com>
     * @since       Version 1.0.0
     * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
     * @license     http://his.mhkdc.com/licenses
     */

class House_model extends CI_Model {
    //-----------------------------------------------------------------------------------------------------------------
    /*
     * Global parameters
     */
    public $owner_id;
    public $user_id;
    public $provider_id;

    /**
     * Get house list
     * @param   $village_id
     * @return  array
     */
    public function get_house_list($village_id)
    {
        $rs = $this->mongo_db
            ->select(array('_id'))
            ->where(array('village_id' => new MongoId($village_id)))
            ->get('houses');

        if($rs)
        {
            $arr_result = array();
            foreach($rs as $r)
            {
                $arr_result[] = get_first_object($r['_id']);
            }

            return $arr_result;
        }
        else
        {
            return array();
        }
    }

    public function get_person_list($house_id)
    {
        $rs = $this->mongo_db
            ->select(array('hn'))
            ->where(array('house_code' => new MongoId($house_id)))
            ->get('person');
        return $rs;
    }


    public function get_houses_in_village($village_id)
    {
        $rs = $this->house->get_house_list($village_id);

        return $rs;
    }

    public function get_person_in_house($houses)
    {
        $arr_person = array();

        for($i=0; $i < count($houses); $i++) {

            $persons = $this->house->get_person_list($houses[$i]);

            foreach($persons as $p)
            {
                $arr_person[] = $p['hn'];
            }
        }

        return $arr_person;
    }

}