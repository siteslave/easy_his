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
            ->where(array('active' => 'Y'))
            ->order_by(array('name' => 'DESC'))
            ->get('ref_incomes');
        return $rs;
    }

    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->offset($start)
            ->limit($limit)
            ->order_by(array('name' => 'DESC'))
            ->get('ref_charge_items');
        return $rs;
    }
    public function get_filter_list($income, $start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array('income' => new MongoId($income)))
            ->offset($start)
            ->limit($limit)
            ->order_by(array('name' => 'DESC'))
            ->get('ref_charge_items');
        return $rs;
    }
    public function search($query)
    {
        $rs = $this->mongo_db
            ->like('name', $query)
            ->get('ref_charge_items');
        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->count('ref_charge_items');
        return $rs;
    }
    public function get_filter_total($income)
    {
        $rs = $this->mongo_db
            ->where(array('income' => new MongoId($income)))
            ->count('ref_charge_items');
        return $rs;
    }

    public function check_item_duplicated($name)
    {
        $rs = $this->mongo_db
            ->where(array('name' => $name))
            ->count('ref_charge_items');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function save($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->push('owners',
                array(
                    'price'  => (float) $data['price'],
                    //'qty'  => (float) $data['qty'],
                    'owner_id'  => new MongoId($this->owner_id),
                    'user_id'  => new MongoId($this->user_id),
                    'last_update'  => date('Y-m-d H:i:s')
                )
            )
            ->update('ref_charge_items');

        return $rs;
    }
    public function update($data)
    {
        $rs = $this->mongo_db
            ->where(array(
                '_id' => new MongoId($data['id']),
                'owners.owner_id' => new MongoId($this->owner_id)))
            ->set(array(
                'owners.$.price'  => (float) $data['price'],
                //'owners.$.qty'  => (float) $data['qty'],
                'owners.$.user_id'  => new MongoId($this->user_id),
                'owners.$.last_update'  => date('Y-m-d H:i:s')
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

    public function get_price_qty($id)
    {
        $rs = $this->mongo_db
            ->select(array('owners'))
            ->where(array(
                '_id' => $id,
                'owners' => array(
                    '$elemMatch' =>
                    array(
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )
            ))
            ->limit(1)
            ->get('ref_charge_items');

        return count($rs) > 0 ? $rs[0]['owners'] : NULL;
    }


    public function check_duplicated($id)
    {
        $rs = $this->mongo_db
            ->where(array(
                '_id' => new MongoId($id),
                'owners' => array(
                    '$elemMatch' =>
                    array(
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )
            ))
            ->count('ref_charge_items');

        return $rs > 0 ? TRUE : FALSE;
    }

}