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

class Serial_model extends CI_Model
{
    public $serial_type;

    public function get_serial()
    {
        $result = $this->mongo_db
                        ->where('serial_type', $this->serial_type)
                        ->get('sys_serials');
        return count($result) > 0 ? (int) $result[0]['serial_number'] : 0;
    }

    public function update_serial(){
        $result = $this->mongo_db
                        ->where('serial_type', $this->serial_type)
                        ->inc(array('serial_number' => 1))->update('sys_serials');
        return $result;
    }

    function get_year(){
        $result = $this->mongo_db
                        ->where('serial_type', $this->serial_type)
                        ->get('sys_serials');

        $default_thai_yy = (int) date('Y') + 543;
        $default_thai_yy = substr($default_thai_yy, -2);
        $sr_yy = isset($result[0]) ? $result[0]['yy'] : $default_thai_yy;

        return $sr_yy;
    }
    public function update_year($new_year){
        $result = $this->mongo_db
            ->where('serial_type', $this->serial_type)
            ->set('yy', $new_year)->update('sys_serials');
        return $result;
    }
    public function reset_serial(){
        $result = $this->mongo_db
            ->where('serial_type', $this->serial_type)
            ->set('serial_number', 1)->update('sys_serials');
        return $result;
    }
}