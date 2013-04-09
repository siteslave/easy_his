<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Drug model
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.1
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Drug_model extends CI_Model
{
    public $owner_id;
    public $user_id;

    public function __construct(){
        parent::__construct();
    }

    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->order_by(array('name' => 1))
            ->offset($start)
            ->limit($limit)
            ->get('ref_drugs');

        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->count('ref_drugs');
        return $rs;
    }

    public function check_duplicated($data)
    {
        $rs = $this->mongo_db
            ->where(array('name' => $data['name'], 'owner_id' => new MongoId($this->owner_id)))
            ->count('ref_drugs');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('ref_drugs', array(
                'name' => $data['name'],
                'did' => $data['did'],
                'strength' => $data['strength'],
                'strength_unit' => new MongoId($data['strength_unit']),
                'qty' => $data['qty'],
                'unit_price' => $data['unit_price'],
                'unit_cost' => $data['unit_cost'],
                'unit' => new MongoId($data['unit']),
                'owner_id' => new MongoId($this->owner_id),
                'user_id' => new MongoId($this->user_id),
                'last_update' => date('Y-m-d H:i:s')
            ));

        return $rs;
    }
    public function update($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->set(array(
                'name' => $data['name'],
                'did' => $data['did'],
                'strength' => $data['strength'],
                'strength_unit' => new MongoId($data['strength_unit']),
                'qty' => $data['qty'],
                'unit_price' => $data['unit_price'],
                'unit_cost' => $data['unit_cost'],
                'unit' => new MongoId($data['unit']),
                'user_id' => new MongoId($this->user_id),
                'last_update' => date('Y-m-d H:i:s')
            ))
            ->update('ref_drugs');

        return $rs;
    }

    public function detail($id)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id), '_id' => new MongoId($id)))
            ->limit(1)
            ->get('ref_drugs');

        return count($rs) > 0 ? $rs[0] : NULL;
    }
    public function search($query, $start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->like('name', $query)
            ->offset($start)
            ->limit($limit)
            ->get('ref_drugs');

        return count($rs) > 0 ? $rs : NULL;
    }
    public function search_total($query)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->like('name', $query)
            ->count('ref_drugs');

        return $rs;
    }

    public function remove($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->delete('ref_drugs');

        return $rs;
    }
}
