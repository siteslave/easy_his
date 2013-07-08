<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin model
 *
 * @package     Model
 * @author      Mr.Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mkh.go.th/licenses
 */

class Admin_model extends CI_Model {

    public $owner_id;
    public $user_id;

    public function get_list()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->order_by(array('fullname' => 'ASC'))
            ->get('users');

        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->count('users');

        return $rs;
    }

    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('users', array(
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'password' => $data['password'],
                'active' => $data['active'],
                'cid' => $data['cid'],
                'register_date' => date('Y-m-d'),
                'provider_id' => new MongoId($data['provider_id']),
                'clinic_id' => new MongoId($data['clinic_id']),
                'owner_id' => new MongoId($this->owner_id),
                'last_update' => date('Y-m-d H:i:s')
            ));
        return $rs;
    }
    public function update($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->set(array(
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'active' => $data['active'],
                'cid' => $data['cid'],
                'provider_id' => new MongoId($data['provider_id']),
                'clinic_id' => new MongoId($data['clinic_id']),
                'last_update' => date('Y-m-d H:i:s')
            ))
            ->update('users');
        return $rs;
    }

    public function change_password($id, $password)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->set(array('password' => $password))
            ->update('users');

        return $rs;
    }

    public function get_provider_list()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->get('providers');
        $arr_result = array();
        foreach($rs as $r)
        {
            $obj = new stdClass();
            $obj->name = $r['first_name'] . ' ' . $r['last_name'];
            $obj->id = get_first_object($r['_id']);

            $arr_result[] = $obj;
        }

        return $arr_result;
    }

    public function check_exist($username)
    {
        $rs = $this->mongo_db
            ->where(array('username' => $username, 'owner_id' => new MongoId($this->owner_id)))
            ->count('users');
        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_detail($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->get('users');
        return $rs ? $rs[0] : NULL;
    }
}