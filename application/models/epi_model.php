<?php
class Epi_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;
    public $clinic_code;


    public function __construct()
    {
        $this->clinic_code = '05';
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get EPI list
     *
     * @param $start
     * @param $limit
     * @return mixed
     */
    public function get_list($start, $limit)
    {
        $this->mongo_db->add_index('person', array('registers.clinic_code' => -1));
        $this->mongo_db->add_index('person', array('registers.owner_id' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'registers' =>
                    array(
                        '$elemMatch' =>
                        array(
                            'clinic_code' => '05',
                            'owner_id' => new MongoId($this->owner_id)
                        )
                    )
                ))
            ->offset($start)
            ->limit($limit)
            ->get('person');
        return $rs;
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get EPI by house
     *
     * @param $house_id
     * @return mixed
     */
    public function get_list_by_village($houses, $start, $limit)
    {
        $this->mongo_db->add_index('person', array('registers.clinic_code' => -1));
        $this->mongo_db->add_index('person', array('registers.owner_id' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'registers' =>
                    array(
                        '$elemMatch' =>
                        array(
                            'clinic_code' => '05',
                            'owner_id' => new MongoId($this->owner_id)
                        )
                    )
                ))
            ->where_in('house_code', $houses)
            ->offset($start)
            ->limit($limit)
            ->get('person');
        return $rs;
    }

    public function get_list_total()
    {
        $this->mongo_db->add_index('person', array('registers.clinic_code' => -1));
        $this->mongo_db->add_index('person', array('registers.owner_id' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'registers' =>
                    array(
                        '$elemMatch' =>
                        array(
                            'clinic_code' => '05',
                            'owner_id' => new MongoId($this->owner_id)
                        )
                    )
                ))
            ->count('person');

        return $rs;
    }
    public function get_list_by_village_total($houses)
    {
        $this->mongo_db->add_index('person', array('registers.clinic_code' => -1));
        $this->mongo_db->add_index('person', array('registers.owner_id' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'registers' =>
                    array(
                        '$elemMatch' =>
                        array(
                            'clinic_code' => '05',
                            'owner_id' => new MongoId($this->owner_id)
                        )
                    )
                ))
            ->where_in('house_code', $houses)
            ->count('person');

        return $rs;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save epi visit
     */
    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('visit_vaccines', array(
                '_id' => $data['_id'],
                'vn' => $data['vn'],
                'hn' => $data['hn'],
                'lot' => $data['lot'],
                'expire' => to_string_date($data['expire']),
                'date_serv' => to_string_date($data['date_serv']),
                'hospcode' => $data['hospcode'],
                'vaccine_id' => new MongoId($data['vaccine_id']),
                'owner_id' => new MongoId($this->owner_id),
                'provider_id' => new MongoId($data['provider_id']),
                'user_id' => new MongoId($this->user_id),
                'last_update' => date('Ymd H:i:s')
            ));

        return $rs;
    }

    public function update($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->set(array(
                'lot' => $data['lot'],
                'expire' => to_string_date($data['expire']),
                'provider_id' => new MongoId($data['provider_id']),
                'user_id' => new MongoId($this->user_id),
                'hospcode' => $data['hospcode'],
                'last_update' => date('Ymd H:i:s')
            ))
            ->update('visit_vaccines');

        return $rs;
    }

    public function check_visit_duplicated($date_serv, $vaccine_id)
    {
        $this->mongo_db->add_index('visit_vaccines', array('vn' => -1));
        $this->mongo_db->add_index('visit_vaccines', array('vaccine_id' => -1));

        $rs = $this->mongo_db
            ->where(array('date_serv' => to_string_date($date_serv), 'vaccine_id' => new MongoId($vaccine_id)))
            ->count('visit_vaccines');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_history($hn)
    {
        $this->mongo_db->add_index('visit_vaccines', array('hn' => -1));
        $this->mongo_db->add_index('visit_vaccines', array('date_serv' => -1));

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->order_by(array('date_serv' => 'DESC'))
            ->get('visit_vaccines');

        return $rs;
    }

    public function get_list_by_visit($vn)
    {
        $this->mongo_db->add_index('visit_vaccines', array('vn' => -1));

        $rs = $this->mongo_db
            ->where('vn', (string) $vn)
            ->get('visit_vaccines');

        return $rs;
    }

    public function remove($hn)
    {
        $this->mongo_db->add_index('visit_vaccines', array('vn' => -1));

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->pull('registers', array(
                'clinic_code' => '05'
            ))
            ->update('person');


        return $rs;
    }

    public function get_detail($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->limit(1)
            ->get('visit_vaccines');

        return $rs ? $rs[0] : NULL;
    }

    public function remove_visit($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->delete('visit_vaccines');

        return $rs;
    }

    public function check_owner($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id), 'owner_id' => new MongoId($this->owner_id)))
            ->count('visit_vaccines');

        return $rs > 0 ? TRUE : FALSE;

    }
}
