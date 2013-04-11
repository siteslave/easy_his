<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 11/4/2556 11:28 น.
 */
class Person_per_village_model extends CI_Model {
    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list($start, $limit) {
        $rs = $this->mongo_db
            ->where('owner_id', new MongoId($this->owner_id))
            ->offset($start)
            ->limit($limit)
            ->get('villages');

        return $rs;
    }

    public function get_list_total() {
        $rs = $this->mongo_db
            ->where('owner_id', new MongoId($this->owner_id))
            ->count('villages');

        return $rs;
    }

    public function get_houses_count($id) {
        $rs = $this->mongo_db
            ->where('village_id', new MongoId($id))
            ->count('houses');

        return $rs;
    }

    public function get_house_id_per_village($id) {
        $rs = $this->mongo_db
            ->where('village_id', new MongoId($id))
            ->get('houses');

        $arr_result = array();
        foreach($rs as $r) {
            $arr_result[] = $r['_id'];
        }
        return $arr_result;
    }

    public function get_person_count_per_house_id_in_area($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
            ->where_in('typearea.typearea', array('1', '3'))
            ->where('typearea.owner_id', new MongoId($this->owner_id))
            ->count('person');

        return $rs;
    }

    public function get_person_count_per_house_id_out_area($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
            ->where_in('typearea.typearea', array('2', '4'))
            ->where('typearea.owner_id', new MongoId($this->owner_id))
            ->count('person');

        return $rs;
    }
}