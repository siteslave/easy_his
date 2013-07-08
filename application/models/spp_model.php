<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Special PP model
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */
class Spp_model extends CI_Model {
    public $owner_id;
    public $provider_id;
    public $user_id;

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save Special PP service
     *
     * @param   array   $data
     * @return  array   $rs
     */
    public function save_service($data)
    {
        $rs = $this->mongo_db
            ->insert('visit_special_pp', array(
                '_id'           => $data['id'],
                'vn'            => (string) $data['vn'],
                'hn'            => (string) $data['hn'],
                'date_serv'     => to_string_date($data['date_serv']),
                'hospcode'      => (string) $data['hospcode'],
                'servplace'     => $data['servplace'],
                'ppspecial'     => new mongoId($data['ppspecial']),
                'user_id'       => new MongoId($this->user_id),
                'owner_id'      => new MongoId($this->owner_id),
                'provider_id'   => new MongoId($data['provider_id']),
                'last_update'   => date('Y-m-d H:i:s')
            ));

        return $rs;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Update Special pp
     *
     * @param   array   $data   The data for update
     * @return  boolean
     */
    public function update_service($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->set(array(
                'servplace'     => $data['servplace'],
                'ppspecial'     => new MongoId($data['ppspecial']),
                'provider_id'   => new MongoId($data['provider_id']),
                'user_id'       => new MongoId($this->user_id),
                'last_update'   => date('Y-m-d H:i:s')
            ))->update('visit_special_pp');
        return $rs;
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Check visit duplicate
     *
     * @param   string  $hn
     * @param   string  $vn
     * @return  boolean
     */
    public function check_duplicated($hn, $vn, $ppspecial)
    {
        $this->mongo_db->add_index('visit_special_pp', array('hn' => -1));
        $this->mongo_db->add_index('visit_special_pp', array('vn' => -1));
        $this->mongo_db->add_index('visit_special_pp', array('ppspecial' => -1));

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'vn' => (string) $vn, 'ppspecial' => new MongoId($ppspecial)))
            ->count('visit_special_pp');

        return $rs > 0 ? TRUE : FALSE;
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get service history
     */
    public function get_visit_history($hn, $vn)
    {
        $this->mongo_db->add_index('visit_special_pp', array('vn' => -1));
        $this->mongo_db->add_index('visit_special_pp', array('hn' => -1));

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'vn' => (string) $vn))
            ->get('visit_special_pp');

        return $rs;
    }
    public function get_history($hn)
    {
        $this->mongo_db->add_index('visit_special_pp', array('hn' => -1));

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->get('visit_special_pp');

        return $rs;
    }

    public function remove_visit($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->delete('visit_special_pp');

        return $rs;
    }
}

//End file