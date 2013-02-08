<?php
class Babies_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;


    public function __construct()
    {
        //constructor
    }

    public function do_register($hn)
    {
        $rs = $this->mongo_db
            ->insert('babies',
            array(
                'hn' => $hn,
                'reg_date' => date('Ymd'),
                'discharge_status' => 'N',
                'discharge_date' => NULL,
                'owner_id' => new MongoId($this->owner_id),
                'provider_id' => new MongoId($this->provider_id),
                'user_id' => new MongoId($this->user_id)
            ));

        return $rs;
    }

    public function check_register_status($hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->count('babies');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id), 'discharge_status' => 'N'))
            ->offset($start)
            ->limit($limit)
            ->get('babies');
        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->count('babies');

        return $rs;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get labor detail
     *
     * @param   string  $hn
     * @return  mixed
     */
    public function get_labor_detail($hn)
    {
        $rs = $this->mongo_db
            ->select(array(
                            'hn', 'reg_date', 'discharge_status', 'discharge_date',
                            'anc_code', 'bweight', 'asphyxia', 'vitk', 'tsh', 'tshresult'
                          ))
            ->where(array('hn' => (string) $hn))
            ->get('babies');

        return count($rs) > 0 ? $rs[0] : NULL;
    }


}