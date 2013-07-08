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

    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('refer_out', array(
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
            ));

        return $rs;
    }

    public function update($data)
    {
        $this->mongo_db->add_index('refer_out', array('code' => -1));
        $rs = $this->mongo_db
            ->where(array('code' => (string) $data['code']))
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


    public function get_list($vn)
    {
        $this->mongo_db->add_index('refer_out', array('vn' => -1));
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn))
            ->get('refer_out');

        return $rs;
    }

    public function get_detail($code)
    {
        $this->mongo_db->add_index('refer_out', array('code' => -1));
        $rs = $this->mongo_db
            ->where(array('code' => $code))
            ->limit(1)
            ->get('refer_out');

        return $rs ? $rs[0] : NULL;
    }

    public function remove($code)
    {
        $this->mongo_db->add_index('refer_out', array('code' => -1));
        $rs = $this->mongo_db
            ->where(array('code' => (string) $code))
            ->delete('refer_out');
        return $rs;
    }


    public function save_answer($data)
    {
        $this->mongo_db->add_index('refer_out', array('code' => -1));
        $rs = $this->mongo_db
            ->where(array('code' => (string) $data['rfo_code']))
            ->set(array(
                'answer.answer_date' => to_string_date($data['answer_date']),
                'answer.answer_detail' => $data['answer_detail'],
                'answer.answer_diag' => $data['answer_diag'],
                'last_update' => date('Y-m-d H:i:s'),
                'user_id' => new MongoId($this->user_id)
            ))
            ->update('refer_out');

        return $rs;
    }

    public function get_answer($code)
    {
        $this->mongo_db->add_index('refer_out', array('code' => -1));
        $rs = $this->mongo_db
            ->where(array('code' => (string) $code))
            ->limit(1)
            ->get('refer_out');
        return $rs ? $rs[0] : NULL;
    }

}