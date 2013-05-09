<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 17/4/2556 10:24 น.
 */
class Report_basic_model extends CI_Model {
    #นับจำนวนหลังคาเรือน แยกรายหมู่บ้าน
    public function get_houses_count($id) {
        $rs = $this->mongo_db
            ->where('village_id', new MongoId($id))
            ->count('houses');

        return $rs;
    }

    #ดึก _id ของบ้านนั้นๆ แยกรายหมู่บ้าน
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

    #นับจำนวนประชากรในเขตรับผิดชอบที่มี Typearea = 1, 3
    public function get_person_count_per_house_id_in_area($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
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
            ->count('person');

        return $rs;
    }

    #นับจำนวนประชากรในเขตรับผิดชอบที่มี Typearea = 1, 3 และเป็นเพศ ชาย
    public function get_person_count_in_area_with_male($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
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
            ->where('sex', '1')
            ->count('person');

        return $rs;
    }

    #นับจำนวนประชากรในเขตรับผิดชอบที่มี Typearea = 1, 3 และเป็นเพศ หญิง
    public function get_person_count_in_area_with_female($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
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
            ->where('sex', '2')
            ->count('person');

        return $rs;
    }

    #นับจำนวนประชากรนอกเขตรับผิดชอบที่มี Typearea = 0, 2, 4
    public function get_person_count_per_house_id_out_area($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
            ->where(array(
                'typearea' => array(
                    '$elemMatch' => array(
                        'typearea' => array(
                            '$in' => array('0', '2', '4')
                        ),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )
            ))
            ->count('person');

        return $rs;
    }

    #นับจำนวนประชากรที่มี Typearea = 0
    public function get_person_count_with_typearea_0($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
            ->where(array('typearea' => array('$elemMatch' => array('typearea' => '0', 'owner_id' => new MongoId($this->owner_id)))))
            ->count('person');

        return $rs;
    }

    #นับจำนวนประชากรที่มี Typearea = 1
    public function get_person_count_with_typearea_1($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
            ->where(array('typearea' => array('$elemMatch' => array('typearea' => '1', 'owner_id' => new MongoId($this->owner_id)))))
            ->count('person');

        return $rs;
    }

    #นับจำนวนประชากรที่มี Typearea = 2
    public function get_person_count_with_typearea_2($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
            ->where(array('typearea' => array('$elemMatch' => array('typearea' => '2', 'owner_id' => new MongoId($this->owner_id)))))
            ->count('person');

        return $rs;
    }

    #นับจำนวนประชากรที่มี Typearea = 3
    public function get_person_count_with_typearea_3($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
            ->where(array('typearea' => array('$elemMatch' => array('typearea' => '3', 'owner_id' => new MongoId($this->owner_id)))))
            ->count('person');

        return $rs;
    }

    #นับจำนวนประชากรที่มี Typearea = 4
    public function get_person_count_with_typearea_4($id) {
        $rs = $this->mongo_db
            ->where_in('house_code', $id)
            ->where(array('typearea' => array('$elemMatch' => array('typearea' => '4', 'owner_id' => new MongoId($this->owner_id)))))
            ->count('person');

        return $rs;
    }
}