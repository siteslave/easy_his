<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Community Service model
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */
class Comms_model extends CI_Model {
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
            ->insert('visit_communities', array(
                'vn'            => (string) $data['vn'],
                'hn'            => (string) $data['hn'],
                'comservice'     => new mongoId($data['comservice']),
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
            ->where(array('hn' => (string) $data['hn'], 'vn' => (string) $data['vn']))
            ->set(array(
                'comservice'     => new mongoId($data['comservice']),
                'user_id'       => new MongoId($this->user_id),
                'provider_id'   => new MongoId($data['provider_id']),
                'last_update'   => date('Y-m-d H:i:s')
            ))->update('visit_communities');
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
    public function check_duplicated($hn, $vn, $comms)
    {
        $this->mongo_db->add_index('visit_communities', array('hn' => -1));
        $this->mongo_db->add_index('visit_communities', array('vn' => -1));
        $this->mongo_db->add_index('visit_communities', array('comservice' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'hn' => (string) $hn,
                'vn' => (string) $vn,
                'comservice' => new MongoId($comms)
            ))
            ->count('visit_communities');

        return $rs > 0 ? TRUE : FALSE;
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get service detail
     */
    public function get_service_detail($hn, $vn)
    {
        $this->mongo_db->add_index('visit_communities', array('hn' => -1));
        $this->mongo_db->add_index('visit_communities', array('vn' => -1));

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'vn' => (string) $vn))
            ->get('visit_communities');
        return count($rs) > 0 ? $rs : NULL;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get service history
     */
    public function get_service_history($hn)
    {
        $this->mongo_db->add_index('visit_communities', array('hn' => -1));
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->get('visit_communities');

        return $rs;
    }

    public function remove_service($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->delete('visit_communities');

        return $rs;
    }
}

//End file