<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Women Model
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Income_model extends CI_Model
{

    public $owner_id;
    public $user_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_incomes_list()
    {
        $rs = $this->mongo_db
            ->where(array('active' => 'Y', 'owner_id' => new MongoId($this->owner_id)))
            ->order_by(array('name' => 'DESC'))
            ->get('ref_incomes');
        return $rs;
    }

    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->offset($start)
            ->limit($limit)
            ->order_by(array('name' => 'DESC'))
            ->get('ref_charge_items');
        return $rs;
    }
    public function get_filter_list($income, $start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id), 'income' => new MongoId($income)))
            ->offset($start)
            ->limit($limit)
            ->order_by(array('name' => 'DESC'))
            ->get('ref_charge_items');
        return $rs;
    }
    public function search_item($query)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->like('name', $query)
            ->get('ref_charge_items');
        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->count('ref_charge_items');
        return $rs;
    }
    public function get_filter_total($income)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id), 'income' => new MongoId($income)))
            ->count('ref_charge_items');
        return $rs;
    }

    public function check_item_duplicated($name)
    {
        $rs = $this->mongo_db
            ->where(array('name' => $name, 'owner_id' => new MongoId($this->owner_id)))
            ->count('ref_charge_items');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function save_item($data)
    {
        $rs = $this->mongo_db
            ->insert('ref_charge_items', array(
                'code' => (string) $data['code'],
                'name' => $data['name'],
                'price' => (float) $data['price'],
                'cost' => (float) $data['cost'],
                'unit' => $data['unit'],
                'income' => new MongoId($data['income']),
                'owner_id' => new MongoId($this->owner_id),
                'active' => $data['active']
            ));

        return $rs;
    }
    public function update_item($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->set(array(
                'name' => $data['name'],
                'price' => (float) $data['price'],
                'cost' => (float) $data['cost'],
                'unit' => $data['unit'],
                'income' => new MongoId($data['income']),
                'owner_id' => new MongoId($this->owner_id),
                'active' => $data['active']
            ))
            ->update('ref_charge_items');

        return $rs;
    }

    public function get_income_name($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->limit(1)
            ->get('ref_incomes');

        return count($rs) ? $rs[0]['name'] : '-';
    }

    public function remove_item($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->delete('ref_charge_items');

        return $rs;
    }

    public function get_all()
    {
        $rs = $this->mongo_db->get('ref_charge_items');
        return $rs;
    }

    public function set_code($id, $code)
    {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->set(array('code' => (string) $code))
            ->update('ref_charge_items');
        return $rs;
    }

}