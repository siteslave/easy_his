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

class Death_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;

    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('death', array(
                'hn'            => $data['hn'],
                'hospdeath'     => $data['hospdeath'],
                'ddeath'        => to_string_date($data['ddeath']),
                'cdeath'        => $data['cdeath'],
                'cdeath_a'      => $data['cdeath_a'],
                'cdeath_b'      => $data['cdeath_b'],
                'cdeath_c'      => $data['cdeath_c'],
                'cdeath_d'      => $data['cdeath_d'],
                'odisease'      => $data['odisease'],
                'pregdeath'     => $data['pregdeath'],
                'pdeath'        => $data['pdeath'],
                'provider_id'   => $this->provider_id,
                'user_id'       => $this->user_id,
                'owner_id'      => new MongoId($this->owner_id)
            ));

        return $rs;
    }
    public function update($data)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $data['hn']))
            ->set(array(
                'hospdeath'     => $data['hospdeath'],
                'ddeath'        => to_string_date($data['ddeath']),
                'cdeath'        => $data['cdeath'],
                'cdeath_a'      => $data['cdeath_a'],
                'cdeath_b'      => $data['cdeath_b'],
                'cdeath_c'      => $data['cdeath_c'],
                'cdeath_d'      => $data['cdeath_d'],
                'odisease'      => $data['odisease'],
                'pregdeath'     => $data['pregdeath'],
                'pdeath'        => $data['pdeath'],
                'provider_id'   => $this->provider_id,
                'user_id'       => $this->user_id,
                'owner_id'      => new MongoId($this->owner_id)
            ))
            ->update('death');

        return $rs;
    }

    public function check_exist($hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => $hn))
            ->count('death');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->offset($start)
            ->limit($limit)
            ->get('death');
        return $rs;
    }
    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->count('death');
        return $rs;
    }

    public function get_detail($hn)
    {
        $rs = $this->mongo_db->where(array('hn' => (string) $hn))
            ->get('death');

        return count($rs) > 0 ? $rs[0] : NULL;
    }

}