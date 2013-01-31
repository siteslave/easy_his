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
    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array(
                'registers.clinic_code' => '05',
                //'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->offset($start)
            ->limit($limit)
            ->get('person');
        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array(
                        'registers.clinic_code' => $this->clinic_code,
                        //'registers.owner_id' => new MongoId($this->owner_id)
            ))
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
                'user_id' => new MongoId($this->user_id)
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

}