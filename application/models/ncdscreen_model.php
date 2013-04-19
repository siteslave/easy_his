<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Women Model
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Ncdscreen_model extends CI_Model
{

    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list($start, $limit)
    {
        $this->mongo_db->add_index('person', array('typearea' => -1));
        $this->mongo_db->add_index('person', array('birthdate' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'typearea' =>
            array(
                '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
            )))
            ->where_lte('birthdate', (string) ((int) date('Y') - 15).'1231')
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->offset($start)
            ->limit($limit)
            ->order_by(array('first_name' => 'ASC'))
            ->get('person');
        return $rs;
    }

    public function get_list_total()
    {
        $this->mongo_db->add_index('person', array('typearea' => -1));
        $this->mongo_db->add_index('person', array('birthdate' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'typearea' =>
                array(
                    '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where_lte('birthdate', (string) ((int) date('Y') - 15).'1231')
            ->count('person');
        return $rs;
    }

    public function get_detail($year, $hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'year' => (string) $year))
            ->get('ncdscreen');

        return count($rs) ? $rs[0] : NULL;
    }

    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('ncdscreen', array(
                'fptype' => $data['fptype'],
                'nofpcause' => $data['nofpcause'],
                'totalson' => $data['totalson'],
                'numberson' => $data['numberson'],
                'abortion' => $data['abortion'],
                'stillbirth' => $data['stillbirth'],
                'hn' => $data['hn'],
                'year' => $data['year'],
                'user_id' => new MongoId($this->user_id),
                'owner_id' => new MongoId($this->owner_id),
                'last_update' => date('Y-m-d H:i:s')
            ));

        return $rs;
    }
    public function update($data)
    {
        $rs = $this->mongo_db
            ->set(array(
                'fptype' => $data['fptype'],
                'nofpcause' => $data['nofpcause'],
                'totalson' => $data['totalson'],
                'numberson' => $data['numberson'],
                'abortion' => $data['abortion'],
                'stillbirth' => $data['stillbirth'],
                //'hn' => $data['hn'],
                'user_id' => new MongoId($this->user_id),
                //'owner_id' => new MongoId($this->owner_id),
                'last_update' => date('Y-m-d H:i:s')
            ))
            ->update('ncdscreen');

        return $rs;
    }

    public function check_exist($hn, $year)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'year' => (string) $year))
            ->count('ncdscreen');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function clear($hn, $year)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'year' => (string) $year))
            ->delete('ncdscreen');

        return $rs;
    }

    /**
     * @param   array   $house_id
     * @param   string  $year
     * @return  mixed
     */
    public function search_filter($house_id, $start, $limit)
    {
        $this->mongo_db->add_index('person', array('owner_id' => -1));
        $this->mongo_db->add_index('person', array('birthdate' => -1));
        $this->mongo_db->add_index('person', array('house_code' => -1));
        $this->mongo_db->add_index('person', array('typearea' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'typearea' =>
                array(
                    '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where_lte('birthdate', (string) ((int) date('Y') - 15).'1231')
            ->where_in('house_code', $house_id)
            ->offset($start)
            ->limit($limit)
            ->order_by(array('first_name' => 'ASC'))
            ->get('person');
        return $rs;
    }

    public function search($hn)
    {
        $this->mongo_db->add_index('person', array('birthdate' => -1));
        $this->mongo_db->add_index('person', array('typearea' => -1));
        $this->mongo_db->add_index('person', array('owner_id' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'typearea' =>
                array(
                    '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->where(array('sex' => '2'))
            ->where_lte('birthdate', (string) ((int) date('Y') - 15).'1231')
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where('hn', (string) $hn)
            ->order_by(array('first_name' => 'ASC'))
            ->get('person');
        return $rs;
    }

    public function search_filter_total($house_id)
    {
        $this->mongo_db->add_index('person', array('owner_id' => -1));
        $this->mongo_db->add_index('person', array('typearea' => -1));
        $this->mongo_db->add_index('person', array('birthdate' => -1));
        $this->mongo_db->add_index('person', array('house_code' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'typearea' =>
                array(
                    '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->where_lte('birthdate', (string) ((int) date('Y') - 15).'1231')
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where_in('house_code', $house_id)
            ->count('person');
        return $rs;
    }

    public function get_house_list($village_id)
    {
        $this->mongo_db->add_index('houses', array('village_id' => -1));
        $rs = $this->mongo_db
            ->select(array('_id'))
            ->where(array('village_id' => new MongoId($village_id)))
            ->get('houses');

        return $rs;
    }

}

//End of file