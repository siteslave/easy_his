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

class Women_model extends CI_Model
{

    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list($year, $start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->where(array('sex' => '2'))
            ->where_lte('birthdate', (string) ((int) $year - 15).'1231')
            ->where_gte('birthdate', (string) ((int) $year - 49).'0101')
            ->offset($start)
            ->limit($limit)
            ->get('person');
        return $rs;
    }

    public function get_list_total($year)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->where(array('sex' => '2'))
            ->where_lte('birthdate', (string) ((int) $year - 15).'1231')
            ->where_gte('birthdate', (string) ((int) $year - 49).'0101')
            ->count('person');
        return $rs;
    }

    public function get_fp_detail($year, $hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'year' => (string) $year))
            ->get('women');

        return count($rs) ? $rs[0] : NULL;
    }

    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('women', array(
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
            ->update('women');

        return $rs;
    }

    public function check_exist($hn, $year)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'year' => (string) $year))
            ->count('women');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function clear($hn, $year)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'year' => (string) $year))
            ->delete('women');

        return $rs;
    }

}

//End of file