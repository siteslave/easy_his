<?php
/**
 * Created by Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 11/3/2556 11:01 น.
 */
class Refer_model extends CI_Model {
    public function get_visit($id) {
        $rs = $this->mongo_db
            ->order_by(array('date_serv' => 'desc', 'time_serv' => 'desc'))
            ->where(array('person_id' => new MongoId($id)))
            ->get('visit');

        return $rs;
    }

    public function get_pcucode_by_owner($owner) {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($owner)))
            ->get('owners');

        return $rs[0];
    }
}