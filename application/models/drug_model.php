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
            ->order_by(array('name' => 1))
            ->offset($start)
            ->limit($limit)
            ->get('ref_drugs');

        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->count('ref_drugs');
        return $rs;
    }

    //get drug price, qty
    public function get_price_qty($id)
    {
        $rs = $this->mongo_db
            ->select(array('owners'))
            ->where(array(
                '_id' => new MongoId($id),
                'owners' => array(
                    '$elemMatch' =>
                    array(
                        'owner_id' => new MongoId($this->owner_id)
                    )
                ),
            ))
            ->limit(1)
            ->get('ref_drugs');

      $obj = new stdClass();

      if( count( $rs) > 0 ) {
        if( $rs[0]['owners'] ) {
          foreach( $rs[0]['owners'] as $r ) {

            if( isset($r['owner_id']) ) {

              $obj_owner_id = get_first_object( $r['owner_id'] );

              if( $obj_owner_id == $this->owner_id ) {
                $obj->price = isset($r['price']) ? $r['price'] : 0;
                $obj->qty = isset($r['qty']) ? $r['qty'] : 0;

                return $obj;
                break;
              }
            } else {
              return $obj;
              break;
            }
          }
        } else {
          return $obj;
        }

      } else {
        return $obj;
      }

        #return count($rs) > 0 ? $rs[0]['owners'] : NULL;
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
            ->count('ref_drugs');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function save($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->push('owners',
                array(
                    'price'  => (float) $data['price'],
                    'qty'  => (float) $data['qty'],
                    'owner_id'  => new MongoId($this->owner_id),
                    'user_id'  => new MongoId($this->user_id),
                    'last_update'  => date('Y-m-d H:i:s')
                )
            )
            ->update('ref_drugs');

        return $rs;
    }
    public function update($data)
    {

        $rs = $this->mongo_db
            ->where(array(
                '_id' => new MongoId($data['id']),
                'owners' => array(
                    '$elemMatch' =>
                    array(
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )
            ))
            ->set(array(
                'owners.$.price'  => (float) $data['price'],
                'owners.$.qty'  => (float) $data['qty'],
                'owners.$.user_id'  => new MongoId($this->user_id),
                'owners.$.last_update'  => date('Y-m-d H:i:s')
            ))
            ->update('ref_drugs');

        return $rs;
    }

    public function detail($id)
    {
        $rs = $this->mongo_db
            ->where(array(
                '_id' => new MongoId($id),
                'owners' =>
                array(
                    '$elemMatch' =>
                    array(
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->limit(1)
            ->get('ref_drugs');

        return count($rs) > 0 ? $rs[0] : NULL;
    }
    public function search($query, $start, $limit)
    {
        $rs = $this->mongo_db
            ->like('name', $query)
            ->offset($start)
            ->limit($limit)
            ->get('ref_drugs');

        return count($rs) > 0 ? $rs : NULL;
    }

    public function search_total($query)
    {
        $rs = $this->mongo_db
            ->like('name', $query)
            ->count('ref_drugs');

        return $rs;
    }

    public function check_order_qty($id, $qty)
    {
        $pqty = $this->get_price_qty($id);
        $stock_qty = isset($pqty->qty) ? $pqty->qty : 0;

        return $qty > $stock_qty ? FALSE : TRUE;
    }
}
