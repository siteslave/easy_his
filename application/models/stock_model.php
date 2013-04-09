<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model
 *
 * Model information information
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.1
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Stock_model extends CI_Model
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
}