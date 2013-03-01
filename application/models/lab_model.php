<?php
class Lab_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;

    public function get_items($group_id)
    {
        $rs = $this->mongo_db->where(array('group_id' => new MongoId($group_id)))
            ->get('ref_lab_items');

        return $rs;
    }

    public function get_items_visit($group_id, $vn)
    {
        $rs = $this->mongo_db
            ->select(array('lab_items'))
            ->where(array(
                'group_id' => new MongoId($group_id),
                'vn' => (string) $vn
            ))
            ->get('visit_lab_orders');

        return count($rs) > 0 ? $rs[0] : NULL;
    }

    public function save_order($data, $items)
    {
        $rs = $this->mongo_db
            ->insert('visit_lab_orders', array(
                'vn' => (string) $data['vn'],
                'hn' => (string) $data['hn'],
                'order_date' => date('Ymd'),
                'user_id' => new MongoId($this->user_id),
                'owner_id' => new MongoId($this->owner_id),
                'group_id' => new MongoId($data['group_id']),
                'lab_items' => $items)
            );
        return $rs;
    }

    public function check_order_duplicated($data)
    {
        $rs = $this->mongo_db
            ->where(array(
                'vn' => (string) $data['vn'],
                'group_id' => new MongoId($data['group_id'])
            ))
            ->count('visit_lab_orders');

        return $rs > 0 ? TRUE : FALSE;
    }
    public function get_order($vn)
    {
        $rs = $this->mongo_db
            ->select(array('group_id'))
            ->where(array('vn' => (string) $vn))
            ->get('visit_lab_orders');

        return $rs;
    }

}