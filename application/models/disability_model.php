<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Disability model
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */
class Disability_model extends CI_Model {
    public $owner_id;
    public $provider_id;
    public $user_id;

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save
     *
     * @param   array   $data
     * @return  array   $rs
     */
    public function do_save($data)
    {
        $rs = $this->mongo_db
            ->insert('disabilities', array(
                'hn'            => (string) $data['hn'],
                'did'           => $data['did'],
                'dtype'         => new MongoId($data['dtype']),
                'dcause'        => $data['dcause'],
                'diag_code'     => $data['diag_code'],
                'detect_date'   => to_string_date($data['detect_date']),
                'disb_date'     => to_string_date($data['disb_date']),
                'last_update'   => date('Y-m-d H:i:s'),
                'reg_date'       => date('Ymd'),
                'user_id'       => new MongoId($this->user_id),
                'owner_id'       => new MongoId($this->owner_id)
            ));

        return $rs;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Update
     *
     * @param   array   $data   The data for update
     * @return  boolean
     */
    public function do_update($data)
    {
        $rs = $this->mongo_db
            ->where(array(
                'hn' => $data['hn'],
                'dtype' => new MongoId($data['dtype'])
            ))
            ->set(array(
                'did'           => $data['did'],
                'dcause'        => $data['dcause'],
                'diag_code'     => $data['diag_code'],
                'detect_date'   => to_string_date($data['detect_date']),
                'disb_date'     => to_string_date($data['disb_date']),
                'last_update'   => date('Y-m-d H:i:s'),
                'user_id'    => new MongoId($this->user_id)
                )
            )->update('disabilities');

        return $rs;
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Check duplicate
     *
     * @param   string  $hn
     * @param   string  $dtype
     * @return  boolean
     */
    public function check_duplicated($hn, $dtype)
    {
        $rs = $this->mongo_db
            ->where(array(
                'hn' => (string) $hn,
                'dtype' => new MongoId($dtype)
            ))->count('disabilities');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_detail($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->get('disabilities');

        return count($rs) > 0 ? $rs[0] : NULL;
    }

    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->offset($start)
            ->limit($limit)
            ->get('disabilities');
        return $rs;
    }
    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->count('disabilities');
        return $rs;
    }

    public function get_person_list_village($persons){
        $rs = $this->mongo_db
            ->where_in('hn', $persons)
            ->get('disabilities');

        return $rs;
    }

    /**
     * Remove
     *
     * @param   string  $id
     */
    public function remove($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->delete('disabilities');
        return $rs;
    }

}

//End file