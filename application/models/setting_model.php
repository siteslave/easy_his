<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Settings model
 *
 * Model information information
 *
 * @package     Models
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Maha Sarakham Hospital Information center.
 * @license     http://his.mhkdc.com/licenses
 */

class Setting_model extends CI_Model
{
    public $owner_id;

    public function do_update_provider($data)
    {
        $result = $this->mongo_db
                        ->where('_id', new MongoId($data['id']))
                        ->set(array(
                            'register_no'        => $data['register_no'],
                            'council'            => $data['council'],
                            'cid'                => $data['cid'],
                            'title_id'           => new MongoId($data['title_id']),
                            'first_name'         => $data['first_name'],
                            'last_name'          => $data['last_name'],
                            'sex'                => $data['sex'],
                            'birth_date'         => to_string_date($data['birth_date']),
                            'provider_type_id'   => new MongoId($data['provider_type_id']),
                            'start_date'         => to_string_date($data['start_date']),
                            'out_date'           => to_string_date($data['out_date']),
                            'move_from_hospital' => $data['move_from_hospital'],
                            'move_to_hospital'   => $data['move_to_hospital']
                        ))->update('providers');
        return $result;
    }

    public function do_save_provider($data)
    {
        $result = $this->mongo_db
                        ->insert('providers', array(
                            'owner_id'           => new MongoId($this->owner_id),
                            'provider'           => $data['provider'],
                            'register_no'        => $data['register_no'],
                            'council'            => $data['council'],
                            'cid'                => $data['cid'],
                            'title_id'           => new MongoId($data['title_id']),
                            'first_name'         => $data['first_name'],
                            'last_name'          => $data['last_name'],
                            'sex'                => $data['sex'],
                            'birth_date'         => to_string_date($data['birth_date']),
                            'provider_type_id'   => new MongoId($data['provider_type_id']),
                            'start_date'         => to_string_date($data['start_date']),
                            'out_date'           => to_string_date($data['out_date']),
                            'move_from_hospital' => $data['move_from_hospital'],
                            'move_to_hospital'   => $data['move_to_hospital']
                        ));
        return $result;
    }

    public function check_duplicate_provider($cid){
        $result = $this->mongo_db
            ->where('cid', $cid)
            ->where('owner_id', new MongoId($this->owner_id))->get('providers');

        return count($result) > 0 ? TRUE : FALSE;
    }

    public function get_provider_list(){
        $result = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            //->order_by(array('first_name' => 1))
            ->get('providers');

        return $result;
    }

    public function get_provider_detail($id){
        $result = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->get('providers');

        return count($result) > 0 ? $result[0] : FALSE;
    }

    public function get_clinic_list()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->get('ref_clinics');

        return $rs;
    }

    public function save_clinics($data)
    {
        $rs = $this->mongo_db
            ->insert('ref_clinics', array(
                'name' => $data['name'],
                'export_code' => $data['export_code'],
                'owner_id' => new MongoId($this->owner_id)
            ));

        return $rs;
    }
    public function update_clinics($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->set(array(
                'name' => $data['name'],
                'export_code' => $data['export_code'],
                'owner_id' => new MongoId($this->owner_id)
            ))->update('ref_clinics');

        return $rs;
    }

    public function check_clinic_duplicated($name)
    {
        $rs = $this->mongo_db->where(array('name' => $name))->count('ref_clinics');

        return $rs > 0 ? TRUE : FALSE;
    }

}

/* End of file setting_model.php */
/* Location: ./models/setting_model.php */