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

}