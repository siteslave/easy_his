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
            ->where('_id', new MongoId($data['person_id']))
            ->push('disabilities',
                    array(
                        'did'          => to_string_date($data['did']),
                        'dtype'         => new MongoId($data['dtype']),
                        'dcause'        => $data['dcause'],
                        'diag_code'     => $data['diag_code'],
                        'detect_date'   => to_string_date($data['detect_date']),
                        'ddate'         => to_string_date($data['informant_id']),
                        'last_update'   => date('Y-m-d H:i:s'),
                        'user_id'       => new MongoId($this->user_id)
                    )
            )->update('person');

        return $rs;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Update
     *
     * @param   array   $data   The data for update
     * @return  boolean
     */
    public function update_service($data)
    {
        $rs = $this->mongo_db
            ->where(array(
                '_id' => new MongoId($data['person_id']),
                'disabilities.did' => $data['did'],
                'disabilities.dtype' => $data['dtype'],
            ))
            ->set(array(
                'disabilities.$.dcause'        => new MongoId($data['dcause']),
                'disabilities.$.diag_code'     => new MongoId($data['diag_code']),
                'disabilities.$.detect_date'   => to_string_date($data['detect_date']),
                'disabilities.$.ddate'         => to_string_date($data['ddate']),
                'disabilities.$.last_update'   => date('Y-m-d H:i:s'),
                'disabilities.$.user_id'       => new MongoId($this->user_id)
                )
            )->update('person');

        return $rs;
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Check duplicate
     *
     * @param   string  $person_id
     * @param   string  $did
     * @param   string  $dtype
     * @return  boolean
     */
    public function check_duplicated($person_id, $did, $dtype)
    {
        $rs = $this->mongo_db
            ->where(array(
                'person_id' => new MongoId($person_id),
                'did' => (string) $did,
                'dtype' => new MongoId($dtype)
            ))->count('visit_special_pp');

        return $rs > 0 ? TRUE : FALSE;
    }

}

//End file