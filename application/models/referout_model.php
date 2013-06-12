<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Referout Model
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Referout_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;

    public function save_service($data)
    {
        $rs = $this->mongo_db
            ->set(array(
                'code' => $data['code'],
                'refer_date' => to_string_date($data['refer_date']),
                'refer_time' => (string) $data['refer_time'],
                'vn' => (string) $data['vn'],
                'hn' => (string) $data['hn'],
                'refer_hospital' => (string) $data['refer_hospital'],
                'cause' => (string) $data['cause'],
                'reason' => (string) $data['reason'],
                'clinic_id' => new MongoId($data['clinic_id']),
                'provider_id' => new MongoId($data['provider_id']),
                'request' => $data['request'],
                'comment' => $data['comment'],
                'result' => $data['result'],
                'user_id' => new MongoId($this->user_id),
                'last_update' => date('Y-m-d H:i:s')
            ))
            ->insert('refer_out');

        return $rs;
    }

    public function update_service($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->set(array(
                'refer_date' => to_string_date($data['refer_date']),
                'refer_time' => (string) $data['refer_time'],
                'refer_hospital' => (string) $data['refer_hospital'],
                'cause' => (string) $data['cause'],
                'reason' => (string) $data['reason'],
                'clinic_id' => new MongoId($data['clinic_id']),
                'provider_id' => new MongoId($data['provider_id']),
                'request' => $data['request'],
                'comment' => $data['comment'],
                'result' => $data['result'],
                'user_id' => new MongoId($this->user_id),
                'last_update' => date('Y-m-d H:i:s')
            ))
            ->update('refer_out');

        return $rs;
    }

}