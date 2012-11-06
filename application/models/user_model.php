<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Model
 *
 * Model information information
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class User_model extends CI_Model
{

    var $owner_id;

    /*
     * Check login
     *
     * Check username and password for login
     *
     * @param   string  $username   User name
     * @param   string  $password   User password
     *
     * @return  boolean             True if exist, False if don't exist.
     */
    public function do_login($username, $password)
    {

        $this->mongo_db->add_index('users', array('username' => -1), array('unique' => TRUE));
        $this->mongo_db->add_index('users', array('password' => -1), array('unique' => FALSE));

        $result = $this->mongo_db
                        ->where('username', $username)
                        ->where('password', $password)
                        ->count('users');

        return $result > 0 ? TRUE : FALSE;
    }
    /*
     * Get user login detail
     *
     * @param   string  $username
     *
     * @return  mixed
     */
    public function get_user_detail($username){
        $this->mongo_db->add_index('users', array('username' => -1), array('unique' => TRUE));
        $result = $this->mongo_db->where('username', $username)->get('users');

        return count($result) > 0 ? $result[0] : Null;
    }

    public function get_owner_detail($owner_id){
        //$this->mongo_db->add_index('users', array('username' => -1), array('unique' => TRUE));
        $result = $this->mongo_db->where('_id', $owner_id)->get('owners');

        return count($result) > 0 ? $result[0] : Null;
    }
}