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
    public function save_service($data)
    {
        $rs = $this->mongo_db
            ->insert('visit_epi', array(
                'vn' => $data['vn'],
                'hn' => $data['hn'],
                'vaccine_id' => new MongoId($data['vaccine_id']),
                'owner_id' => new MongoId($this->owner_id),
                'provider_id' => new MongoId($this->provider_id),
                'user_id' => new MongoId($this->user_id),
                'last_update' => date('Ymd H:i:s')
            ));

        return $rs;
    }

    public function check_visit_duplicated($vn, $vaccine_id)
    {
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn, 'vaccine_id' => new MongoId($vaccine_id)))
            ->count('visit_epi');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_history($hn)
    {
        $rs = $this->mongo_db
            ->where('hn', (string) $hn)
            ->get('visit_epi');

        return $rs;
    }

    public function get_list_by_visit($vn)
    {
        $rs = $this->mongo_db
            ->where('vn', (string) $vn)
            ->get('visit_epi');

        return $rs;
    }

    public function remove($hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->pull('registers', array(
                'clinic_code' => '05'
            ))
            ->update('person');


        return $rs;
    }
}