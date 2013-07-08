<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Appointment model
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Nutrition_model extends CI_Model {
    //-----------------------------------------------------------------------------------------------------------------
    /*
     * Global parameters
     */
    public $owner_id;
    public $user_id;
    public $provider_id;
    //-----------------------------------------------------------------------------------------------------------------

    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('visit_nutrition',
                array(
                    '_id'            => $data['_id'],
                    'vn'             => $data['vn'],
                    'hn'             => $data['hn'],
                    'weight'         => $data['weight'],
                    'height'         => $data['height'],
                    'headcircum'     => $data['headcircum'],
                    'childdevelop'   => $data['childdevelop'],
                    'food'           => $data['food'],
                    'date_serv'      => to_string_date($data['date_serv']),
                    'hospcode'       => $data['hospcode'],
                    'bottle'         => $data['bottle'],
                    'provider_id'    => new MongoId($data['provider_id']),
                    'user_id'        => new MongoId($this->user_id),
                    'owner_id'       => new MongoId($this->owner_id),
                    'last_update'    => date('Y-m-d H:i:s')
                )
            );
        return $rs;
    }
    public function update($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->set(
                array(
                    'weight'         => $data['weight'],
                    'height'         => $data['height'],
                    'headcircum'     => $data['headcircum'],
                    'childdevelop'   => $data['childdevelop'],
                    'food'           => $data['food'],
                    'date_serv'      => to_string_date($data['date_serv']),
                    'hospcode'       => $data['hospcode'],
                    'bottle'         => $data['bottle'],
                    'provider_id'    => new MongoId($data['provider_id']),
                    'user_id'        => new MongoId($this->user_id),
                    'last_update'    => date('Y-m-d H:i:s')
                )
            )->update('visit_nutrition');
        return $rs;
    }

    public function get_visit_detail($vn)
    {
        $this->mongo_db->add_index('nutrition', array('vn' => -1));
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn))
            ->limit(1)
            ->get('visit_nutrition');

        return $rs ? $rs[0] : NULL;
    }

    public function get_history($hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->get('visit_nutrition');

        return $rs;
    }

}

