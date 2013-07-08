<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 8/5/2556 11:19 น.
 */
class Person_by_age_model extends CI_Model {
    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list($start, $limit) {
        $rs = $this->mongo_db
            ->offset($start)
            ->limit($limit)
            ->get('rpt_person_age');

        return $rs;
    }

    public function get_list_total() {
        $rs = $this->mongo_db
            ->count('rpt_person_age');

        return $rs;
    }

    #นับจำนวนประชากรในเขตรับผิดชอบที่มี Typearea = 1, 3 และเพศ และช่วงอายุ
    public function get_person_count_in_area_with_sex_age($sex, $opt, $param1, $param2) {
        switch($opt) {
            case "<" :
                if($param1 != '')
                    $param1 = date('Ymd', strtotime('-'.$param1.' year'));

                $rs = $this->mongo_db
                    //->where_in('house_code', $house_id)
                    ->where(array(
                        'typearea' => array(
                            '$elemMatch' => array(
                                'typearea' => array(
                                    '$in' => array('1', '3')
                                ),
                                'owner_id' => new MongoId($this->owner_id)
                            )
                        )
                    ))
                    ->where('sex', $sex)
                    ->where_gt('birthdate', $param1)
                    ->count('person');
                break;

            case "<=" :
                if($param1 != '')
                    $param1 = date('Ymd', strtotime('-'.((int)$param1 + 1).' year'));

                $rs = $this->mongo_db
                    //->where_in('house_code', $house_id)
                    ->where(array(
                        'typearea' => array(
                            '$elemMatch' => array(
                                'typearea' => array(
                                    '$in' => array('1', '3')
                                ),
                                'owner_id' => new MongoId($this->owner_id)
                            )
                        )
                    ))
                    ->where('sex', $sex)
                    ->where_gt('birthdate', $param1)
                    ->count('person');
                break;

            case "BETWEEN" :
                if($param1 != '')
                    $param1 = date('Ymd', strtotime('-'.$param1.' year'));
                if($param2 != '')
                    $param2 = date('Ymd', strtotime('-'.((int)$param2 + 1).' year'));

                $rs = $this->mongo_db
                    //->where_in('house_code', $house_id)
                    ->where(array(
                        'typearea' => array(
                            '$elemMatch' => array(
                                'typearea' => array(
                                    '$in' => array('1', '3')
                                ),
                                'owner_id' => new MongoId($this->owner_id)
                            )
                        )
                    ))
                    ->where('sex', $sex)
                    ->where_lte('birthdate', $param1)
                    ->where_gt('birthdate', $param2)
                    ->count('person');
                break;

            case ">" :
                if($param1 != '')
                    $param1 = date('Ymd', strtotime('-'.$param1.' year'));

                $rs = $this->mongo_db
                    //->where_in('house_code', $house_id)
                    ->where(array(
                        'typearea' => array(
                            '$elemMatch' => array(
                                'typearea' => array(
                                    '$in' => array('1', '3')
                                ),
                                'owner_id' => new MongoId($this->owner_id)
                            )
                        )
                    ))
                    ->where('sex', $sex)
                    ->where_lt('birthdate', $param1)
                    ->count('person');
                break;

            case ">=" :if($param1 != '')
                $param1 = date('Ymd', strtotime('-'.$param1.' year'));

                $rs = $this->mongo_db
                    //->where_in('house_code', $house_id)
                    ->where(array(
                        'typearea' => array(
                            '$elemMatch' => array(
                                'typearea' => array(
                                    '$in' => array('1', '3')
                                ),
                                'owner_id' => new MongoId($this->owner_id)
                            )
                        )
                    ))
                    ->where('sex', $sex)
                    ->where_lte('birthdate', $param1)
                    ->count('person');
                break;

        }

        return $rs;
    }
}