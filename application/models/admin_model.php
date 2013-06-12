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
    public $salt;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->order_by(array('fullname' => 'ASC'))
            ->get('users');

        $arr_result = array();

        foreach($rs as $r)
        {
            $obj = new stdClass();
            $obj->cid           = $r['cid'];
            $obj->id            = get_first_object($r['_id']);
            $obj->fullname      = $r['fullname'];
            $obj->username      = $r['username'];
            //$obj->owner_name    = get_owner_name(get_first_object($r['owner_id']));
            $obj->provider_name = get_provider_name_by_id(get_first_object($r['provider_id']));
            $obj->last_login    = $r['last_login'];
            $obj->register_date = $r['register_date'];
            $obj->active        = $r['active'];

            $arr_result[] = $obj;
        }

        return $arr_result;
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
                'fullname' => $data['fullname'],
                'username' => $data['username'],
                'password' => md5($this->salt.$data['password']),
                'active' => $data['active'],
                'provider_id' => new MongoId($data['provider_id']),
                'owner_id' => new MongoId($this->owner_id),
                'last_update' => date('Y-m-d H:i:s')
            ));
        return $rs;
    }
    public function update($data)
    {
        $rs = $this->mongo_db
            ->where(array('username' => $data['username']))
            ->set(array(
                'fullname' => $data['fullname'],
                'actived' => $data['active'],
                'provider_id' => new MongoId($data['provider_id']),
                'last_update' => date('Y-m-d H:i:s')
            ))
            ->update('users');
        return $rs;
    }

    public function change_password($username, $new_pass)
    {
        $password = sha1(md5($new_pass));

        $rs = $this->mongo_db
            ->where(array('username' => $username))
            ->set(array('password' => md5($this->salt.$password)))
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
}