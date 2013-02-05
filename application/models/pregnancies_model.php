<?php
class Pregnancies_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;
    public $clinic_code;


    public function __construct()
    {
        $this->clinic_code = '04';
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
                'registers.clinic_code' => $this->clinic_code,
                'registers.owner_id' => new MongoId($this->owner_id)
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
    public function get_list_by_house($house_id)
    {
        $rs = $this->mongo_db
            ->where(array(
                'registers.clinic_code' => '05',
                'registers.owner_id' => new MongoId($this->owner_id),
                'house_code' => new MongoId($house_id)
            ))
            //->offset($start)
            //->limit($limit)
            ->get('person');
        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array(
                        'registers.clinic_code' => $this->clinic_code,
                        'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->count('person');

        return $rs;
    }
    public function get_list_by_house_total()
    {
        $rs = $this->mongo_db
            ->where(array(
                        'registers.clinic_code' => $this->clinic_code,
                        'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->count('person');

        return $rs;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save anc visit
     */
    public function save_service($data)
    {
        $rs = $this->mongo_db
            ->insert('visit_anc', array(
                'vn' => $data['vn'],
                'hn' => $data['hn'],
                'anc_no' => $data['anc_no'],
                'ga' => $data['ga'],
                'anc_result' => $data['anc_result'],
                'owner_id' => new MongoId($this->owner_id),
                'provider_id' => new MongoId($this->provider_id),
                'user_id' => new MongoId($this->user_id)
            ));

        return $rs;
    }

    public function update_service($data)
    {
        $rs = $this->mongo_db
            ->where('vn', (string) $data['vn'])
            ->set(array(
                'anc_no' => $data['anc_no'],
                'ga' => $data['ga'],
                'anc_result' => $data['anc_result'],
                'owner_id' => new MongoId($this->owner_id),
                'provider_id' => new MongoId($this->provider_id),
                'user_id' => new MongoId($this->user_id)
            ))
            ->update('visit_anc');

        return $rs;
    }


    public function check_visit_duplicated($vn)
    {
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn))
            ->count('visit_anc');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_history($hn)
    {
        $rs = $this->mongo_db
            ->where('hn', (string) $hn)
            ->get('visit_anc');

        return $rs;
    }
    public function get_detail($vn)
    {
        $rs = $this->mongo_db
            ->where('vn', (string) $vn)
            ->limit(1)
            ->get('visit_anc');

        return count($rs) > 0 ? $rs[0] : NULL;
    }

    public function get_list_by_visit($vn)
    {
        $rs = $this->mongo_db
            ->where('vn', (string) $vn)
            ->get('visit_epi');

        return $rs;
    }

}